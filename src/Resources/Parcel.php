<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Resources\Recipient;
use Mvdnbrk\MyParcel\Resources\BaseResource;

class Parcel extends BaseResource
{
    /**
     * The carrier ID for PostNL.
     */
    const CARRIER_POSTNL = 1;

    /**
     * @var int
     */
    protected $carrier;

    /**
     * Arbitrary reference indentifier to identify this shipment.
     *
     * @var string
     */
    public $reference_identifier;

    /**
     * @var \Mvdnbrk\MyParcel\Resources\Recipient
     */
    public $recipient;

    /**
     * Create a new shipment instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->carrier = self::CARRIER_POSTNL;

        $this->recipient = new Recipient;
    }

    /**
     * Get a reference for this parcel. Alias for reference_identifier.
     *
     * @return string
     */
    public function getReferenceAttribute()
    {
        return $this->reference_identifier;
    }

    /**
     * Sets a reference for this parcel. Alias for reference_identifier.
     *
     * @param  string  $value
     * @return void
     */
    public function setReferenceAttribute($value)
    {
        $this->reference_identifier = $value;
    }
}
