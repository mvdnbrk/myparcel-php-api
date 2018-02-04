<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Client;
use Mvdnbrk\MyParcel\Object\Time;
use Mvdnbrk\MyParcel\Support\Collection;
use Mvdnbrk\MyParcel\Object\PickupLocation;
use Mvdnbrk\MyParcel\Exceptions\InvalidZipcodeException;
use Mvdnbrk\MyParcel\Exceptions\InvalidHousenumberException;

class DeliveryOptions extends BaseResource
{
    /**
     * The carrier from wich to get delivery oprions.
     */
    const CARRIER = 'postnl';

    /**
     * @var \Mvdnbrk\MyParcel\Support\Collection
     */
    public $pickup;

    /**
     * @var string
     */
    public $zipcode;

    /**
     * @var string
     */
    public $housenumber;

    /**
     * @var  array
     */
    public $validZipcodes = [
        'BE' => '/^[1-9]{1}\d{3}$/',
        'NL' => '/^[1-9]{1}\d{3}[A-Z]{2}$/',
    ];

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $carrier = self::CARRIER;

    /**
     * @var \Mvdnbrk\MyParcel\Client
     */
    protected $client;

    /**
     * @var \Mvdnbrk\MyParcel\Object\Time
     */
    protected $cutoffTime;

    protected function boot()
    {
        $this->cutoffTime = new Time('15:30');
        $this->pickup = new Collection;
    }

    public function get($zipcode, $housenumber, array $filters = [])
    {
        $this->setZipcode($zipcode);
        $this->setHousenumber($housenumber);

        $result = $this->performApiCall(
            'GET',
            'delivery_options' . $this->buildQueryString($this->getFilters($filters))
        );

        $this->pickup = new Collection();

        foreach ($result->data->pickup as $location) {
            $newLocation = new PickupLocation;
            $newLocation->name = $location->location;
            $newLocation->street = $location->street;
            $newLocation->zipcode = $location->postal_code;
            $newLocation->housenumber = $location->number;
            $newLocation->city = $location->city;
            $newLocation->country = $location->cc;
            $newLocation->phone = $location->phone_number;
            $newLocation->distance = $location->distance;
            $newLocation->latitude = (float) $location->latitude;
            $newLocation->longitude = (float) $location->longitude;
            $newLocation->openingHours = (array) $location->opening_hours;
            $newLocation->locationCode = $location->location_code;

            $this->pickup->push($newLocation);
        }

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    protected function getFilters($filters)
    {
        return array_merge($filters, [
            'cc' => $this->getCountry(),
            'carrier' => $this->carrier,
            'number' => $this->housenumber,
            'postal_code' => $this->zipcode,
            'cutoff_time' => $this->cutoffTime->get(),
        ]);
    }

    protected function setCountry()
    {
        $zipcodes = new Collection($this->validZipcodes);

        $zipcodes->each(function ($value, $key) {
            if (preg_match($value, $this->zipcode)) {
                $this->country = $key;
            }
        });
    }

    public function setCutoffTime($value)
    {
        $this->cutoffTime = new Time($value);

        return $this;
    }

    public function setHousenumber($value)
    {
        $this->housenumber = filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        if (! is_numeric($this->housenumber)) {
            throw new InvalidHousenumberException;
        }

        return $this;
    }

    public function setZipcode($value)
    {
        $this->zipcode = preg_replace('/\s+/', '', strtoupper($value));
        $this->setCountry();

        if ($this->country === null) {
            throw new InvalidZipcodeException;
        }

        return $this;
    }
}
