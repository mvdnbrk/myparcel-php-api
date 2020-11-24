<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Exceptions\MyParcelException;
use Mvdnbrk\MyParcel\Resources\Parcel;
use Mvdnbrk\MyParcel\Resources\ParcelCollection;
use Mvdnbrk\MyParcel\Resources\Shipment as ShipmentResource;
use Mvdnbrk\MyParcel\Resources\ShipmentCollection;
use Mvdnbrk\MyParcel\Types\ShipmentStatus;

class Shipments extends BaseEndpoint
{
    public function create(Parcel $parcel): ShipmentResource
    {
        return $this->concept($parcel);
    }

    public function createbatch(ParcelCollection $collection)
    {
        return $this->conceptbatch($collection);
    }

    public function concept(Parcel $parcel): ShipmentResource
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

    public function conceptbatch(ParcelCollection $parcelCollection): ShipmentCollection
    {
        $response = $this->performApiCall(
            'POST',
            'shipments',
            $this->getHttpBody($parcelCollection),
            ['Content-Type' => 'application/vnd.shipment+json; charset=utf-8']
        );

        $shipmentCollection = new ShipmentCollection();

        foreach ($response->data->ids as $item) {
            $parcel = $parcelCollection->get($item->reference_identifier);
            $shipmentCollection->add(new ShipmentResource(array_merge([
                'id' => $item->id,
                'status' => ShipmentStatus::CONCEPT,
            ], $parcel->attributesToArray())));
        }

        return $shipmentCollection;
    }

    public function delete($value): bool
    {
        if ($value instanceof ShipmentResource) {
            if ($value->status !== ShipmentStatus::CONCEPT) {
                return false;
            }

            $value = $value->id;
        }

        $this->performApiCall(
            'DELETE',
            'shipments/'.$value
        );

        return true;
    }

    public function get(int $id): ShipmentResource
    {
        return $this->getShipmentsResource(
            'shipments/'.$id,
            'Shipment with an id of "'.$id.'" not found.'
        );
    }

    public function getByReference(string $value): ShipmentResource
    {
        return $this->getShipmentsResource(
            'shipments'.$this->buildQueryString(['reference_identifier' => $value]),
            'Shipment with reference "'.$value.'" not found.'
        );
    }

    protected function getShipmentsResource(string $apiMethod, string $message = ''): ShipmentResource
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

    protected function getHttpBody($parcel): string
    {
        if ($parcel instanceof ParcelCollection) {
            return json_encode([
                'data' => [
                    'shipments' => $parcel->toArray()
                ],
            ]);
        }

        return json_encode([
            'data' => [
                'shipments' => [
                    $parcel->toArray()
                ]
            ],
        ]);
    }
}
