<?php

namespace Mvdnbrk\MyParcel\Object;

use Mvdnbrk\MyParcel\Contracts\Arrayable;

class PickupLocation extends Location implements Arrayable
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $distance;

    /**
     * @var array
     */
    public $openingHours;

    /**
     * @var string
     */
    public $phone;

    public function distanceForHumans()
    {
        if ($this->distance >= 10000) {
            return round($this->distance / 1000, 0) . ' km';
        }

        if ($this->distance >= 1000) {
            return round($this->distance / 1000, 1) . ' km';
        }

        return "{$this->distance} meter";
    }

    public function toArray()
    {
        return array_merge(
            get_object_vars($this),
            ['distance' => $this->distanceForHumans()]
        );
    }
}
