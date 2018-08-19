<?php

namespace Mvdnbrk\MyParcel\Resources;

class PickupLocation extends Address
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
     * @var string
     */
    public $location_code;

    /**
     * @var array
     */
    public $opening_hours;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * Get the distance to a pick up location in a human readable format.
     *
     * @return string
     */
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

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect($this->attributesToArray())
            ->merge(['distance' => $this->distanceForHumans()])
            ->all();
    }
}
