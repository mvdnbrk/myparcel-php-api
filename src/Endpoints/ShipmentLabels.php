<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Types\PaperSize;
use Mvdnbrk\MyParcel\Resources\Shipment;

class ShipmentLabels extends BaseEndpoint
{
    /**
     * Get a shipment label by shipment id.
     *
     * @param  int|\Mvdnbrk\MyParcel\Resources\Shipment $value
     * @return string
     */
    public function get($value)
    {
        if ($value instanceof Shipment) {
            $value = $value->id;
        }

        $response = $this->performApiCall(
            'GET',
            'shipment_labels/'.$value.$this->buildQueryString(['format' => PaperSize::A6]),
            null,
            ['Accept' => 'application/pdf']
        );

        return $response;
    }
}
