<?php

namespace Mvdnbrk\MyParcel\Resources;

use Illuminate\Support\Collection;
use Mvdnbrk\MyParcel\Types\DeliveryType;
use Mvdnbrk\MyParcel\Types\PackageType;

class ShipmentCollection extends BaseResource
{
    /** @var string */
    public $collection;

    public function __construct(array $attributes = [])
    {
        $this->collection = new Collection();
        parent::__construct($attributes);
    }

    public function add(Shipment $shipment)
    {
        $this->collection->add($shipment);

        return $this;
    }

    public function get(string $reference_identifier): Parcel
    {
        return $this
            ->collection
            ->where('reference_identifier', $reference_identifier)
            ->first();
    }

    public function toArray(): array
    {
        return $this->collection
            ->map(function ($shipment) {
                return $shipment->toArray();
            })
            ->all();
    }
}
