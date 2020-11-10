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

	/** @var string */
	public $link_consumer_portal;

	/** @var string */
	public $link_tracktrace;

    public function getDatetimeAttribute(): string
    {
        return $this->time;
    }
}
