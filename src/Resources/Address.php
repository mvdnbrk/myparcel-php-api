<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Support\Str;

class Address extends BaseResource
{
    /**
     * @var string
     */
    public $street;

    /**
     * Additional information for the street that should
     * not be included in the street field.
     *
     * @var string
     */
    public $street_additional_info;

    /**
     * @var string
     */
    public $number;

    /**
     * @var string
     */
    public $number_suffix;

    /**
     * @var string
     */
    public $postal_code;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $region;

    /**
     * ISO3166-1 country code.
     * https://en.wikipedia.org/wiki/ISO_3166-1
     *
     * @var string
     */
    public $cc;

    /**
     * Set country code.
     *
     * @param  string  $value
     * @return void
     */
    public function setCcAttribute($value)
    {
        $this->cc = Str::upper($value);
    }

    /**
     * Sets the country code. Alias for cc.
     *
     * @param  string  $value
     * @return void
     */
    public function setCountryCodeAttribute($value)
    {
        $this->setCcAttribute($value);
    }

    /**
     * Set the postal code.
     *
     * @param  string  $value
     * @return void
     */
    public function setPostalCodeAttribute($value)
    {
        $this->postal_code = Str::upper($value);
    }

    /**
     * Sets the zipcode. Alias for postal_code.
     *
     * @param  string  $value
     * @return void
     */
    public function setZipcodeAttribute($value)
    {
        $this->setPostalCodeAttribute($value);
    }

    /**
      * Convert the resource instance to an array.
      * Removes all attributes with null values.
      *
      * @return array
      */
    public function toArray()
    {
        return collect(parent::toArray())
            ->transform(function ($value, $key) {
                if ($key == 'number') {
                    return (string) $value;
                }

                return $value;
            })
            ->all();
    }
}
