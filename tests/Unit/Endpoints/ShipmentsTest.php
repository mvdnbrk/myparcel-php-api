<?php

namespace Tests\Unit\Endpoints;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Client;
use Mvdnbrk\MyParcel\Resources\Parcel;
use Mvdnbrk\MyParcel\Resources\Shipment;

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
            'carrier' => 1,
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
                'signature' => 1,
            ],
        ];

        $parcel = new Parcel($array);

        $shipment = $this->client->shipments->create($parcel);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertNotNull($shipment->id);
    }
}
