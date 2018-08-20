<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Resources\BaseResource;

class Shipment extends Parcel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $barcode;

    /**
     * @var string
     */
    public $created;
}
