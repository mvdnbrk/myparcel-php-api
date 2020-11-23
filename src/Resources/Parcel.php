<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Types\DeliveryType;
use Mvdnbrk\MyParcel\Types\PackageType;

class Parcel extends BaseResource
{
    /**
     * The carrier ID for PostNL.
     */
    const CARRIER_POSTNL = 1;

    /** @var int */
    protected $carrier;

    /** @var string */
    public $reference_identifier;

    /** @var \Mvdnbrk\MyParcel\Resources\ShipmentOptions */
    public $options;

    /** @var \Mvdnbrk\MyParcel\Resources\ServicePoint */
    protected $pickup;

    /** @var \Mvdnbrk\MyParcel\Resources\Recipient */
    public $recipient;

    public function __construct(array $attributes = [])
    {
        $this->carrier = self::CARRIER_POSTNL;
        $this->options = new ShipmentOptions;
        $this->recipient = new Recipient;

        parent::__construct($attributes);
    }

    public function getReferenceAttribute(): string
    {
        return $this->reference_identifier;
    }

    public function labelDescription(string $value): self
    {
        $this->options->label_description = trim($value);

        return $this;
    }

    public function mailboxpackage(): self
    {
        $this->options->setDefaultOptions();

        $this->options->package_type = PackageType::MAILBOX_PACKAGE;

        return $this;
    }

    public function onlyRecipient(): self
    {
        $this->options->only_recipient = true;

        return $this;
    }

    public function returnToSender(): self
    {
        $this->options->return = true;

        return $this;
    }

    public function signature(): self
    {
        $this->options->signature = true;

        return $this;
    }

    public function ageCheck(): self
    {
        $this->options->age_check = true;

        return $this;
    }

    public function insurance(int $cents, string $currency = 'EUR'): self
    {
        $this->options->insurance = new Money([
            'amount' => $cents,
            'currency' => $currency
        ]);
        if ($this->recipient->cc === 'NL') {
            $this->onlyRecipient();
            $this->signature();
        }
        return $this;
    }

    /**
     * @param  array|object  $value
     */
    public function setOptionsAttribute($value): void
    {
        $this->options->fill($value);
    }

    /**
     * @param  array|null  $value
     */
    public function setPickupAttribute($value): void
    {
        if (is_null($value)) {
            $this->pickup = null;

            return;
        }

        if (is_null($this->pickup)) {
            $this->pickup = new ServicePoint($value);
        }

        $this->options->setDefaultOptions();
        $this->options->package_type = PackageType::PACKAGE;
        $this->options->delivery_type = DeliveryType::PICKUP;
        $this->signature();
    }

    /**
     * @param  \Mvdnbrk\MyParcel\Resources\Recipient|array  $value
     */
    public function setRecipientAttribute($value): void
    {
        if ($value instanceof Recipient) {
            $this->recipient = $value;

            return;
        }

        $this->recipient->fill($value);
    }

    public function setReferenceAttribute(string $value): void
    {
        $this->reference_identifier = $value;
    }

    public function toArray(): array
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
                $pickup = collect($this->pickup->toArray())
                    ->put('location_name', $this->pickup->name)
                    ->forget('name');

                return $collection->put('pickup', $pickup);
            })
            ->all();
    }
}
