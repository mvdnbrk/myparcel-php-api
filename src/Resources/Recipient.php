<?php

namespace Mvdnbrk\MyParcel\Resources;

class Recipient extends Address
{
    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * Get the full name of the recipient.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
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
            ->when($this->full_name, function ($collection) {
                return $collection->put('person', $this->full_name);
            })
            ->forget('first_name')
            ->forget('last_name')
            ->all();
    }
}
