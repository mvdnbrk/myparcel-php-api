<?php

namespace Mvdnbrk\MyParcel\Object;

use Mvdnbrk\MyParcel\Contracts\Arrayable;

class Location
{
    /**
     * @var string
     */
    public $street;

    /**
     * @var string
     */
    public $zipcode;

    /**
     * @var string
     */
    public $housenumber;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $country;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;
}
