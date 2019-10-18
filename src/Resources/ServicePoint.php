<?php

namespace Mvdnbrk\MyParcel\Resources;

class ServicePoint extends Address
{
    /**
     * @var string
     */
    public $id;

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
            return;
        }

        if ($this->distance >= 10000) {
            return round($this->distance / 1000, 0).' km';
        }

        if ($this->distance >= 1000) {
            return round($this->distance / 1000, 1).' km';
        }

        return "{$this->distance} meter";
    }

    /**
     * Sets the latitude for this location.
     *
     * @param  string|float  $value
     * @return void
     */
    public function setLatitudeAttribute($value)
    {
        $this->latitude = (float) $value;
    }

    /**
     * Sets the longitude for this location.
     *
     * @param  string|float  $value
     * @return void
     */
    public function setLongitudeAttribute($value)
    {
        $this->longitude = (float) $value;
    }

    /**
     * Sets a location. Alias for name.
     *
     * @param  string  $value
     * @return void
     */
    public function setLocationAttribute($value)
    {
        $this->name = $value;
    }

    /**
     * Sets a location code. Alias for id.
     *
     * @param  string  $value
     * @return void
     */
    public function setLocationCodeAttribute($value)
    {
        $this->id = $value;
    }

    /**
     * Sets the opening hours.
     *
     * @param  object|array
     * @return void
     */
    public function setOpeningHoursAttribute($value)
    {
        $this->opening_hours = collect($value)->all();
    }

    /**
     * Sets a phone number for this location. Alias for phone.
     *
     * @param  string  $value
     * @return void
     */
    public function setPhoneNumberAttribute($value)
    {
        $this->phone = $value;
    }

    /**
     * Get the phone number for this location. Alias for phone.
     *
     * @return string
     */
    public function getPhoneNumberAttribute()
    {
        return $this->phone;
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
                'distance' => $this->distanceForHumans(),
            ])
            ->reject(function ($value) {
                return empty($value);
            })
            ->all();
    }
}
