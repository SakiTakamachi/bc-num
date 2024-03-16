<?php

namespace BcNum\Exception;

use ErrorException;

class InvalidNumberErrorException extends ErrorException
{
    public function __construct(string $num)
    {
        $message = 'Invalid number: ' . $num;
        parent::__construct($message);
    }
}
