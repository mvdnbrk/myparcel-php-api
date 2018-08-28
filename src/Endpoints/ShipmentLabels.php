<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Resources\Label;
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
            'shipment_labels/'.$value.$this->buildQueryString(
                (new Label)->toArray()
            ),
            null,
            ['Accept' => 'application/pdf']
        );

        return $response;
    }
}
