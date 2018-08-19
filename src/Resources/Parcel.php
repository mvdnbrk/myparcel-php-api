<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Resources\Recipient;
use Mvdnbrk\MyParcel\Resources\BaseResource;
use Mvdnbrk\MyParcel\Resources\ShipmentOptions;

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
     * @var \Mvdnbrk\MyParcel\Resources\ShipmentOptions
     */
    public $options;

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
        $this->carrier = self::CARRIER_POSTNL;
        $this->options = new ShipmentOptions;

        parent::__construct($attributes);
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
     * Set the parcel to a mailbox pacakge.
     *
     * @return $this
     */
    public function mailboxpackage()
    {
        $this->options->package_type = 2;
        $this->options->signature = false;

        return $this;
    }

    /**
     * Require a signature from the recipient.
     * Sets signature option to tue.
     *
     * @return $this
     */
    public function signature()
    {
        $this->options->signature = true;

        return $this;
    }

    /**
     * Set the shipment options for this parcel.
     *
     * @param array  $value
     */
    public function setOptionsAttribute($value)
    {
        $this->options->fill($value);
    }

    /**
     * Set the recipient for this parcel.
     *
     * @param array  $value
     */
    public function setRecipientAttribute($value)
    {
        if (is_null($this->recipient)) {
            $this->recipient = new Recipient;
        }

        $this->recipient->fill($value);
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

    /**
      * Convert the parcel resource to an array.
      *
      * @return array
      */
    public function toArray()
    {
        return [
            'carrier' => $this->carrier,
            'reference_identifier' => $this->reference_identifier,
            'recipient' => $this->recipient->toArray(),
            'options' => $this->options->toArray(),
        ];
    }
}
