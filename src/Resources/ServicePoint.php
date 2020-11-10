<?php

namespace Mvdnbrk\MyParcel\Resources;

class ServicePoint extends Address
{
    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var int */
    public $distance;

    /** @var array */
    public $opening_hours;

    /** @var string */
    public $phone;

    /** @var float */
    public $latitude;

    /** @var float */
    public $longitude;

    public function distanceForHumans(): string
    {
        if (! $this->distance) {
            return '';
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
     * @param  string|float  $value
     */
    public function setLatitudeAttribute($value): void
    {
        $this->latitude = (float) $value;
    }

    /**
     * @param  string|float  $value
     */
    public function setLongitudeAttribute($value): void
    {
        $this->longitude = (float) $value;
    }

    public function setLocationAttribute(string $value): void
    {
        $this->name = $value;
    }

    public function setLocationCodeAttribute(string $value): void
    {
        $this->id = $value;
    }

    /**
     * @param  object|array
     */
    public function setOpeningHoursAttribute($value): void
    {
        $this->opening_hours = collect($value)->all();
    }

    public function setPhoneNumberAttribute(string $value): void
    {
        $this->phone = $value;
    }

    public function getPhoneNumberAttribute(): string
    {
        return $this->phone;
    }

    public function toArray(): array
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
