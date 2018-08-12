<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Support\Str;
use Mvdnbrk\MyParcel\Support\Collection;
use Mvdnbrk\MyParcel\Contracts\Jsonable;
use Mvdnbrk\MyParcel\Contracts\Arrayable;

abstract class BaseResource implements Arrayable, Jsonable
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
        (new Collection($attributes))->each(function ($value, $key) {
            $this->setAttribute($key, $value);
        });

        return $this;
    }

    /**
     * Convert the recource into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
      * Convert the resource instance to an array.
      *
      * @return array
      */
    public function toArray()
    {
        return $this->attributesToArray();
    }

    /**
     * Convert the resource instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws \Mvdnbrk\MyParcel\\Exceptions\JsonEncodingException
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forResource($this, json_last_error_msg());
        }

        return $json;
    }
}
