<?php

namespace Mvdnbrk\MyParcel\Resources;

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

    /**
     * @var int
     */
    public $status;
}
