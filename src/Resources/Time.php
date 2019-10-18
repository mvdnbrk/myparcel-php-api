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

    /**
     * Construct a new Time instance.
     *
     * @param string  $value
     * @throws \Mvdnbrk\MyParcel\Exceptions\InvalidTimeException
     */
    public function __construct($value)
    {
        $value = str_replace('.', self::SEPARATOR, $value);
        $value = strlen($value) === 5 ? $value.':00' : $value;

        if (! preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]?$/', $value, $matches)) {
            throw new InvalidTimeException;
        }

        $this->time = $value;
    }

    /**
     * Get the time.
     *
     * @param  string $separator
     * @return string
     */
    public function get($separator = self::SEPARATOR)
    {
        return str_replace(self::SEPARATOR, $separator, $this->time);
    }
}
