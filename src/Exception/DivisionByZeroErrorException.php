<?php

namespace BcNum\Exception;

use ErrorException;

class DivisionByZeroErrorException extends ErrorException
{
    public function __construct()
    {
        parent::__construct('Division by zero');
    }
}
