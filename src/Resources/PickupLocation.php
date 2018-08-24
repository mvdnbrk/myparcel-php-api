<?php

namespace Mvdnbrk\MyParcel\Resources;

class PickupLocation extends Address
{
    /**
     * @var string
     */
    public $location_name;

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
        if (! $this->distance) {
            return null;
        }

        if ($this->distance >= 10000) {
            return round($this->distance / 1000, 0) . ' km';
        }

        if ($this->distance >= 1000) {
            return round($this->distance / 1000, 1) . ' km';
        }

        return "{$this->distance} meter";
    }

    /**
     * Get the name for this location. Alias for location_name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->location_name;
    }

    /**
     * Sets a name for this location. Alias for location_name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->location_name = $value;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect(parent::toArray())
            ->merge([
                'distance' => $this->distanceForHumans()
            ])
            ->reject(function ($value) {
                return empty($value);
            })
            ->all();
    }
}
