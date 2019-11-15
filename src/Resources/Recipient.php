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
     * Convert the Recipient resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect(parent::toArray())
            ->when(! empty($this->getFullNameAttribute()), function ($collection) {
                return $collection->put('person', $this->getFullNameAttribute());
            })
            ->forget('first_name')
            ->forget('last_name')
            ->all();
    }
}
