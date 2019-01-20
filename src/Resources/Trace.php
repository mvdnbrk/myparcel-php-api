<?php

namespace Mvdnbrk\MyParcel\Resources;

class Trace extends BaseResource
{
    /**
     * @var string
     */
    public $code;

    /**
     * @var mixed
     */
    public $status;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $time;

    /**
     * Get a date/time for trace. Alias for time.
     *
     * @return string
     */
    public function getDatetimeAttribute()
    {
        return $this->time;
    }
}
