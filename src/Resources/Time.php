<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Exceptions\InvalidTimeException;

class Time
{
    const SEPARATOR = ':';

    /**
     * @var string
     */
    protected $time;

    public function __construct($value)
    {
        $value = str_replace('.', self::SEPARATOR, $value);
        $value = strlen($value) === 5 ? $value . ':00' : $value;

        if (! preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]?$/', $value, $matches)) {
            throw new InvalidTimeException;
        }

        $this->time = $value;
    }

    public function get($separator = self::SEPARATOR)
    {
        return str_replace(self::SEPARATOR, $separator, $this->time);
    }
}
