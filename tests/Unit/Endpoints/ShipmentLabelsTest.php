<?php

namespace Tests\Unit\Endpoints;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Client;
use Mvdnbrk\MyParcel\Resources\Parcel;
use Mvdnbrk\MyParcel\Resources\Shipment;

/**
 * @group integration
 */
class ShipmentLabelsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->client = new Client;
        $this->client->setApiKey(getenv('API_KEY'));

        $parcel = new Parcel([
            'recipient' => $this->validRecipient(),
        ]);

        $this->shipment = $this->client->shipments->concept($parcel);
    }

    private function validRecipient($overrides = [])
    {
        return array_merge([
            'person' => 'John Doe',
            'street' => 'Poststraat',
            'number' => '1',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'cc' => 'NL',
        ], $overrides);
    }

    /** @test */
    public function get_a_label_in_A6_size_by_shipment_id()
    {
        $pdf = $this->client->labels->get($this->shipment->id);

        $this->assertInternalType('string', $pdf);
    }

    /** @test */
    public function get_a_label_in_A6_size_by_shipment_object()
    {
        $pdf = $this->client->labels->get($this->shipment);

        $this->assertInternalType('string', $pdf);
    }
}
