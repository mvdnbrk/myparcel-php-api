<?php

namespace Mvdnbrk\MyParcel\Exceptions;

use Exception;

class MyParcelException extends Exception
{
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}
