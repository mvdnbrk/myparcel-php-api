<?php

namespace Mvdnbrk\MyParcel\Exceptions;

use Exception;

class MyParcelException extends Exception
{
    /**
     * @param  string  $message
     * @param  int  $code
     */
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}
