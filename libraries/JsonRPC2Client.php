<?php

class JsonRPC2Client
{
    private $debug;
    private $url;
    private $id;
    private $notification = false;
    public function __construct($url=__ASIATECHOSSURL__, $debug = false)
    {
        $this->url                   = $url;
        // empty($proxy) ? $this->proxy = '' : $this->proxy = $proxy;
        // empty($debug) ? $this->debug = false : $this->debug = true;
        $this->id                    = 1;
        // $this->id                    = "";
    }

    public function setRPCNotification($notification)
    {
        empty($notification) ? $this->notification = false : $this->notification = true;
    }

    public function __call($method, $params)
    {
		$header=array();
        // check
        if (!is_scalar($method)) {
            throw new Exception('Method name has no scalar value');
        }
        // check
        if (is_array($params)) {
            // no keys
            /*mychanges
            //$params = array_values($params);
            */
        } else {
            throw new Exception('Params must be given as array');
        }

        // sets notification or request task
        if ($this->notification) {
            $currentId = null;
        } else {
            $currentId = $this->id;
        }
        $request = array(
            'method' => $method,
            'params' => $params,
            'id'     => $currentId
        );
            // return $request;
        $request   = json_encode($request);
        // return $request; 
        $ch        = curl_init();
        $header[0] = "Content-Type: application/json";
        // $header[1] = "Content-Length: 1000";
        // $header[2] = "Host:".$_SERVER['SERVER_NAME'];
        // $header[2] = "Host:http:://www.saharertebat.com";
        curl_setopt($ch, CURLOPT_URL, $this->url);
        // curl_setopt($ch,CURLOPT_POST, $request);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); //Timeout Duration
        $result = curl_exec($ch);
		// return $result;
        $result = trim($result);
        // return $result;
		curl_close($ch);
        if ($result) {
            $response = json_decode($result, true);
        } else {
            throw new Exception('Unable to connect to ' . $this->url);
            return;
		}
		
        if ($response['error']) {
            // $finalresult            = array();
            // $finalresult['errcode'] = 808;
            // $finalresult['errmsg']  = $response['error'];
            // return $finalresult;
            return $response;
        }
        if ($response) {
            return $response;
        } else {
            throw new Exception('Content is not JSON Format');
        }
    }
}
