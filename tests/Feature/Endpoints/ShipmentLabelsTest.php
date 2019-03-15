<?php

namespace Mvdnbrk\MyParcel\Tests\Unit\Endpoints;

use Mvdnbrk\MyParcel\Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\Parcel;

/** @group integration */
class ShipmentLabelsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $parcel = new Parcel([
            'recipient' => $this->validRecipient(),
        ]);

        $this->shipment = $this->client->shipments->concept($parcel);
    }

    private function validRecipient($overrides = [])
    {
        return array_merge([
            'first_name' => 'John',
            'last_name' => 'Doe',
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

    /** @test */
    public function getting_a_label_with_an_invalid_shipment_id_should_throw_an_error()
    {
        $this->expectException(\Mvdnbrk\MyParcel\Exceptions\MyParcelException::class);
        $this->expectExceptionMessage('Error executing API call (3001) : Permission Denied. (printShipmentLabel,writeResourceOwnedByOthers)');

        $this->client->labels->get('9999999999');
    }
}
