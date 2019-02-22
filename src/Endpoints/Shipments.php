<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Resources\Parcel;
use Mvdnbrk\MyParcel\Types\ShipmentStatus;
use Mvdnbrk\MyParcel\Exceptions\MyParcelException;
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
        $shipment = $this->concept($parcel);

        return $shipment;
    }

    /**
     * Create a new concept shipment for a parcel.
     *
     * @param  \Mvdnbrk\MyParcel\Resources\Parcel  $parcel
     * @return \Mvdnbrk\MyParcel\Resources\Shipment
     */
    public function concept(Parcel $parcel)
    {
        $response = $this->performApiCall(
            'POST',
            'shipments',
            $this->getHttpBody($parcel),
            ['Content-Type' => 'application/vnd.shipment+json; charset=utf-8']
        );

        return new ShipmentResource(array_merge([
            'id' => $response->data->ids[0]->id,
            'status' => ShipmentStatus::CONCEPT,
        ], $parcel->attributesToArray()));
    }

    /**
     * Delete a shipment.
     *
     * @param  int|\Mvdnbrk\MyParcel\Resources\Shipment
     * @return bool
     */
    public function delete($value)
    {
        if ($value instanceof ShipmentResource) {
            if ($value->status !== ShipmentStatus::CONCEPT) {
                return false;
            }

            $value = $value->id;
        }

        $response = $this->performApiCall(
            'DELETE',
            'shipments/'.$value
        );

        return true;
    }

    /**
     * Get a shipment by id.
     *
     * @param  int $id
     * @return \Mvdnbrk\MyParcel\Resources\Shipment
     */
    public function get($id)
    {
        return $this->getShipmentsResource(
            'shipments/'.$id,
            'Shipment with an id of "'.$id.'" not found.'
        );
    }

    /**
     * Get a shipment by your own reference.
     *
     * @param  string $value
     * @return \Mvdnbrk\MyParcel\Resources\Shipment
     */
    public function getByReference($value)
    {
        return $this->getShipmentsResource(
            'shipments'.$this->buildQueryString(['reference_identifier' => $value]),
            'Shipment with reference "'.$value.'" not found.'
        );
    }

    /**
     * Get a shipment resource by performing an API call.
     *
     * @param  string  $apiMethod  The API method to be called to retrieve the shipment.
     * @param  string  $message  The message to be thrown with the exception on failure.
     * @return \Mvdnbrk\MyParcel\Resources\Shipment
     */
    protected function getShipmentsResource($apiMethod, $message = '')
    {
        $response = $this->performApiCall(
            'GET',
            $apiMethod
        );

        $shipment = collect($response->data->shipments)->first();

        if ($shipment === null) {
            throw new MyParcelException($message);
        }

        return new ShipmentResource(
            collect($shipment)->all()
        );
    }

    /**
     * Get the http body for the API request.
     *
     * @param  \Mvdnbrk\MyParcel\Resources\Parcel  $parcel
     * @return string
     */
    protected function getHttpBody(Parcel $parcel)
    {
        return json_encode([
            'data' => [
                'shipments' => [
                    $parcel->toArray()
                ]
            ],
        ]);
    }
}
