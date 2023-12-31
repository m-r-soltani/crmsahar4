<?php
class jsonrpc_client {

    // private $debug;
    private $path = '/';
    // private $server="80.253.151.5";
    private $port = 80;
    private $errno;
    private $errstr;
    private $id;
    private $method = 'http';
    // private $username = 'system';
    // private $password = 'si@h@sti974';


    public function __construct($url, $debug = false) {
        $parts = parse_url($url);
        $server = $parts['host'];
        $path = isset($parts['path']) ? $parts['path'] : '';

        if(isset($parts['query']))
        {
            $path .= '?'.$parts['query'];
        }

        if(isset($parts['fragment']))
        {
            $path .= '#'.$parts['fragment'];
        }

        if(isset($parts['port']))
        {
            $port = $parts['port'];
        }
        else{
            $port = "80";
        }

        if(isset($parts['scheme']))
        {
            $method = $parts['scheme'];
        }

        if(isset($parts['user']))
        {
            $this->username = $parts['user'];
        }

        if(isset($parts['pass']))
        {
            $this->password = $parts['pass'];
        }

        if($path == '' || $path[0] != '/')
        {
            $this->path = '/'.$path;
        }
        else
        {
            $this->path = $path;
        }

        $this->server = $server;

        if($port != '')
        {
            $this->port = $port;
        }

        if(isset($method) && $method != '')
        {
            $this->method = $method;
        }

        $this->debug = (bool) $debug;

        // message id
        $this->id = 1;
    }

    /**
     * Sets the notification state of the object. In this state, notifications are performed, instead of requests.
     *
     * @param boolean $notification
     */
    public function setRPCNotification($notification) {
        empty($notification) ?
            $this->notification = false
            :
            $this->notification = true;
    }

    /**
     * Performs a jsonRCP request and gets the results as an array
     *
     * @param string $method
     * @param array $params
     * @return array
     */
    public function send($method, $params, $timeout=8000) {

        // sets notification or request task
        if (isset($this->notification) && $this->notification) {
            $currentId = NULL;
        } else {
            $currentId = $this->id;
        }

        // prepares the request
        $request = array(
            'method' => $method,
            'params' => $params,
            'id' => $currentId
        );

        $request = json_encode($request);

        $uri = '/';
        $op= 'POST ' . $uri. " HTTP/1.0\r\n" .
            'Host: '. $this->server . ':' . $this->port . "\r\n" .
            "Content-Type: application/json\r\n".
            'Content-Length: ' . strlen($request) . "\r\n\r\n" .
            $request;


        if($timeout > 0) {
            $fp = @fsockopen($this->server, $this->port, $this->errno, $this->errstr, $timeout);
        } else {
            $fp = @fsockopen($this->server, $this->port, $this->errno, $this->errstr);
        }
        if($fp) {
            if($timeout > 0 && function_exists('stream_set_timeout')) {
                stream_set_timeout($fp, $timeout);
            }
        } else {
            $this->errstr = 'Connect error: '. $this->errstr . ' (' . $this->errno . ')';
            $r = new jsonrpcresp(0, 1, $this->errstr); // TODO: replace 1 with better errorno
            return $r;
        }

        if(!fputs($fp, $op, strlen($op))) {
            fclose($fp);
            $this->errstr = 'Write error';
            $r = new jsonrpcresp(0, 1, $this->errstr); // TODO: replace 1 with better errorno
            return $r;
        } else {
            // reset errno and errstr on succesful socket connection
            $this->errstr = '';
        }

        $response = '';
        do {
            $response .= fread($fp, 32768);
        } while(!feof($fp));

        fclose($fp);

        list($error, $result) = $this->parseResponse($response);
        $r = new jsonrpcresp($result, (int)$error, (string)$error);
        return $r;
    }

    public function parseResponse($response) {
        $response = $this->stripHeaders($response);
        $response = json_decode($response, true);

        return array($response['error'], $response['result']);
    }

    public function stripHeaders($response) {
        list($header, $content) = explode("\r\n\r\n", $response, 2);
        return $content;
    }
}


?>