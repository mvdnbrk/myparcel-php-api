<?php

namespace Mvdnbrk\MyParcel\Resources;

use Illuminate\Support\Collection;
use Mvdnbrk\MyParcel\Types\DeliveryType;
use Mvdnbrk\MyParcel\Types\PackageType;

class ParcelCollection extends BaseResource
{
    /** @var string */
    public $collection;

    public function __construct(array $attributes = [])
    {
        $this->collection = new Collection();
        parent::__construct($attributes);
    }

    public function add(Parcel $parcel)
    {
        $this->collection->add($parcel);

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
            ->map(function ($parcel) {
                return $parcel->toArray();
            })
            ->all();
    }
}
