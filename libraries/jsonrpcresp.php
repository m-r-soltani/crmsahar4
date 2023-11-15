<?php
class jsonrpcresp
{
    var $val = 0;
    var $errno = 0;
    var $errstr = '';

    /**
     * @param mixed $val either an jsonrpcval obj, a php value or the json serialization of an jsonrpcval (a string)
     * @param integer $fcode set it to anything but 0 to create an error response
     * @param string $fstr the error string, in case of an error response
     */
    function __construct($val, $fcode = 0, $fstr = '')
    {
        if($fcode != 0)
        {
            // error response
            $this->errno = $fcode;
            $this->errstr = $fstr;
        }
        else
        {
            // successful response
            $this->val = $val;
        }
    }

    /**
     * Returns the error code of the response.
     * @return integer the error code of this response (0 for not-error responses)
     * @access public
     */
    function faultCode()
    {
        return $this->errno;
    }

    /**
     * Returns the error code of the response.
     * @return string the error string of this response ('' for not-error responses)
     * @access public
     */
    function faultString()
    {
        return $this->errstr;
    }

    /**
     * Returns the value received by the server.
     * @return mixed the jsonrpcval object returned by the server. Might be an json string or php value if the response has been created by specially configured jsonrpc_client objects
     * @access public
     */
    function value()
    {
        return $this->val;
    }
}