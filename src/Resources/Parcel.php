<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Types\PackageType;
use Mvdnbrk\MyParcel\Types\DeliveryType;

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
     * @var \Mvdnbrk\MyParcel\Resources\PickupLocation
     */
    protected $pickup;

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
        $this->recipient = new Recipient;

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
     * Sets a label description for the parcel.
     * Sets label_description option to the specified value.
     *
     * @param  string  $value
     * @return $this
     */
    public function labelDescription($value)
    {
        $this->options->label_description = trim($value);

        return $this;
    }

    /**
     * Set the parcel to a mailbox pacakge.
     *
     * @return $this
     */
    public function mailboxpackage()
    {
        $this->options->setDefaultOptions();

        $this->options->package_type = 2;

        return $this;
    }

    /**
     * Deliver the parcel to the recipient only.
     * Sets only_recipent option to true.
     *
     * @return $this
     */
    public function onlyRecipient()
    {
        $this->options->only_recipient = true;

        return $this;
    }

    /**
     * Return the parcel to sender when the recipient is not at home.
     * Sets return option to true.
     *
     * @return $this
     */
    public function returnToSender()
    {
        $this->options->return = true;

        return $this;
    }

    /**
     * Require a signature from the recipient.
     * Sets signature option to true.
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
     * @param  array  $value
     * @return void
     */
    public function setOptionsAttribute($value)
    {
        $this->options->fill($value);
    }

    /**
     * Set the pick up location for this parcel.
     *
     * @param  array|null  $value
     * @return void
     */
    public function setPickupAttribute($value)
    {
        if (is_null($value)) {
            $this->pickup = null;

            return;
        }

        if (is_null($this->pickup)) {
            $this->pickup = new PickupLocation($value);
        }

        $this->options->setDefaultOptions();
        $this->options->package_type = PackageType::PACKAGE;
        $this->options->delivery_type = DeliveryType::PICKUP;
        $this->signature();
    }

    /**
     * Set the recipient for this parcel.
     *
     * @param  array  $value
     * @return void
     */
    public function setRecipientAttribute($value)
    {
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
        return collect(parent::toArray())
            ->merge([
                'recipient' => $this->recipient->toArray(),
                'options' => $this->options->toArray(),
            ])
            ->when(! is_null($this->reference_identifier), function ($collection) {
                return $collection->put('reference_identifier', (string) $this->reference_identifier);
            })
            ->when(! is_null($this->pickup), function ($collection) {
                return $collection->put('pickup', $this->pickup->toArray());
            })
            ->all();
    }
}
