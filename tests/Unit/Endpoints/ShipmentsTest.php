<?php

namespace Tests\Unit\Endpoints;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Client;
use Mvdnbrk\MyParcel\Resources\Parcel;
use Mvdnbrk\MyParcel\Resources\Shipment;
use Mvdnbrk\MyParcel\Resources\PickupLocation;
use Mvdnbrk\MyParcel\Resources\ShipmentOptions;

/** @group integration */
class ShipmentsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->client = new Client;
        $this->client->setApiKey(getenv('API_KEY'));
    }

    /** @test */
    public function create_a_new_shipment()
    {
        $array = [
            'reference_identifier' => 'test-123',
            'recipient' => [
                'company' => 'Test Company B.V.',
                'person' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '0101111111',
                'street' => 'Poststraat',
                'number' => '1',
                'number_suffix' => 'A',
                'postal_code' => '1234AA',
                'city' => 'Amsterdam',
                'region' => 'Noord-Holland',
                'cc' => 'NL',
            ],
            'options' => [
                'label_description' => 'Test label description',
                'large_format' => false,
                'only_recipient' => false,
                'package_type' => 1,
                'return' => false,
                'signature' => true,
            ],
        ];

        $parcel = new Parcel($array);

        $shipment = $this->client->shipments->create($parcel);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertInstanceOf(ShipmentOptions::class, $shipment->options);
        $this->assertNotNull($shipment->id);
    }

    /** @test */
    public function create_shipment_with_a_pick_up_location()
    {
        $array = [
            'recipient' => [
                'person' => 'John Doe',
                'street' => 'Poststraat',
                'number' => '1',
                'postal_code' => '1234AA',
                'city' => 'Amsterdam',
                'cc' => 'NL',
            ],
            'pickup' => [
                'name' => 'Test pick up',
                'street' => 'Pickup street',
                'number' => '1',
                'postal_code' => '9999ZZ',
                'city' => 'Maastricht',
                'cc' => 'NL',
            ],
        ];

        $parcel = new Parcel($array);

        $shipment = $this->client->shipments->create($parcel);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertInstanceOf(ShipmentOptions::class, $shipment->options);
        $this->assertInstanceOf(PickupLocation::class, $shipment->pickup);
        $this->assertNotNull($shipment->id);
    }
}
