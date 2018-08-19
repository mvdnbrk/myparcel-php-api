<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Resources\Parcel;
use Mvdnbrk\MyParcel\Resources\Shipment as ShipmentResource;

class Shipments extends BaseEndpoint
{
    /**
     * Create a new shipment for a parcel.
     *
     * @param  \Mvdnbrk\MyParcel\Resources\Parcel  $parcel
     * @return \Mvdnbrk\MyParcel\Resources\Shipment
     */
    public function create(Parcel $parcel)
    {
        $httpBody = json_encode([
            'data' => [
                'shipments' => [
                    json_decode($parcel->toJson())
                ]
            ],
        ]);

        $response = $this->performApiCall(
            'POST',
            'shipments',
            $httpBody,
            ['Content-Type' => 'application/vnd.shipment+json; charset=utf-8']
        );

        return new ShipmentResource(array_merge([
            'id' => $response->data->ids[0]->id,
        ], $parcel->toArray()));
    }
}
