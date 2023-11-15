<?php

//use JsonRPC\Exception\InvalidJsonFormatException;

class RPCJsonFormatValidator
{
    /**
     * Validate
     *
     * @param  mixed $payload
     *
     * @throws InvalidJsonFormatException
     */
    public static function validate($payload)
    {
        if (! is_array($payload)) {
//            throw new InvalidJsonFormatException('Malformed payload');
            $error = 'Malformed payload';
            throw new Exception($error);
        }
    }
}