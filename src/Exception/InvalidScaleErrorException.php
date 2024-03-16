<?php

namespace BcNum\Exception;

use ErrorException;

class InvalidScaleErrorException extends ErrorException
{
    public function __construct(int $scale)
    {
        $message = 'Invalid scale: ' . $scale . '. Scale must be between 0 and 2147483647';
        parent::__construct($message);
    }
}
