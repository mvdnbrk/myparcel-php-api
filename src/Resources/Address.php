<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Support\Str;

class Address extends BaseResource
{
    /** @var string */
    public $street;

    /** @var string */
    public $street_additional_info;

    /** @var string|int */
    public $number;

    /** @var string */
    public $number_suffix;

    /** @var string */
    public $postal_code;

    /** @var string */
    public $city;

    /** @var string */
    public $region;

    /** @var string */
    public $cc;

    public function setCcAttribute(string $value): void
    {
        $this->cc = Str::upper($value);
    }

    public function setCountryCodeAttribute(string $value): void
    {
        $this->setCcAttribute($value);
    }

    public function setPostalCodeAttribute(string $value): void
    {
        $this->postal_code = Str::upper($value);
    }

    public function setZipcodeAttribute(string $value): void
    {
        $this->setPostalCodeAttribute($value);
    }

    public function toArray(): array
    {
        return collect(parent::toArray())
            ->transform(function ($value, $key) {
                if ($key === 'number') {
                    return (string) $value;
                }

                return $value;
            })
            ->all();
    }
}
