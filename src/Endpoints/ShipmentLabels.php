<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Resources\Label;
use Mvdnbrk\MyParcel\Resources\Shipment;

class ShipmentLabels extends BaseEndpoint
{
    /**
     * Get a shipment label by shipment object or id.
     *
     * @param \Mvdnbrk\MyParcel\Resources\Shipment|int $value
     * @param \Mvdnbrk\MyParcel\Resources\Label|null   $label
     * @return string
     */
    public function get($value, Label $label = null)
    {
        if ($value instanceof Shipment) {
            $value = $value->id;
        }

        if ( ! $label instanceof Label) {
            $label = new Label;
        }

        $response = $this->performApiCall(
            'GET',
            'shipment_labels/' . $value . $this->buildQueryString(
                $label->toArray()
            ),
            null,
            ['Accept' => 'application/pdf']
        );

        return $response;
    }
}
