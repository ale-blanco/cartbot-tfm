<?php

namespace UlaboxApi\Http;

class NotValidHttpMethodException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The http method name passed is not valid');
    }
}
