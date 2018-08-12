<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Support\Str;
use Mvdnbrk\MyParcel\Support\Collection;

abstract class BaseResource
{
    use Concerns\HasAttributes;

    /**
     * Create a new resource instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the resource with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        (new Collection($attributes))->each(function($value, $key) {
            $this->setAttribute($key, $value);
        });

        return $this;
    }
}
