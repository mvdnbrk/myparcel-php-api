<?php

namespace Mvdnbrk\MyParcel\Resources;

class Trace extends BaseResource
{
    /** @var string */
    public $code;

    /** @var mixed */
    public $status;

    /** @var string */
    public $description;

    /** @var string */
    public $time;

    public function getDatetimeAttribute(): string
    {
        return $this->time;
    }
}
