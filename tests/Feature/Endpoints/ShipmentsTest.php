<?php

namespace Mvdnbrk\MyParcel\Tests\Feature\Endpoints;

use Mvdnbrk\MyParcel\Resources\Parcel;
use Mvdnbrk\MyParcel\Resources\ServicePoint;
use Mvdnbrk\MyParcel\Resources\Shipment;
use Mvdnbrk\MyParcel\Resources\ShipmentOptions;
use Mvdnbrk\MyParcel\Tests\TestCase;
use Mvdnbrk\MyParcel\Types\PackageType;
use Mvdnbrk\MyParcel\Types\ShipmentStatus;

/** @group integration */
class ShipmentsTest extends TestCase
{
    private function cleanUp(Shipment $shipment): bool
    {
        return $this->client->shipments->delete($shipment);
    }

    private function validRecipient(array $overrides = []): array
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
    public function create_a_new_shipment_concept_for_a_parcel()
    {
        $array = [
            'reference_identifier' => 'test-123',
            'recipient' => [
                'company' => 'Test Company B.V.',
                'first_name' => 'John',
                'last_name' => 'Doe',
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
                'package_type' => PackageType::PACKAGE,
                'return' => false,
                'signature' => true,
            ],
        ];

        $parcel = new Parcel($array);

        $shipment = $this->client->shipments->create($parcel);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertInstanceOf(ShipmentOptions::class, $shipment->options);
        $this->assertNotNull($shipment->id);
        $this->assertEquals(ShipmentStatus::CONCEPT, $shipment->status);
        $this->assertEquals('John', $shipment->recipient->first_name);
        $this->assertEquals('Doe', $shipment->recipient->last_name);

        $this->assertTrue($this->cleanUp($shipment));
    }

    /** @test */
    public function create_a_shipment_with_invalid_data()
    {
        $this->expectException(\Mvdnbrk\MyParcel\Exceptions\MyParcelException::class);
        $this->expectExceptionMessage('Error executing API call (0) : data.shipments[0].recipient Array value found, but an object is required');

        $parcel = new Parcel(['invalid-data']);

        $this->client->shipments->concept($parcel);
    }

    /** @test */
    public function create_a_new_shipment_concept_for_a_parcel_morning_delivery()
    {
        $array = [
            'reference_identifier' => 'test-123',
            'recipient' => [
                'company' => 'Test Company B.V.',
                'first_name' => 'John',
                'last_name' => 'Doe',
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
                'package_type' => PackageType::PACKAGE,
                'return' => false,
                'signature' => true,
            ],
        ];

        $parcel = new Parcel($array);
        $parcel->morningDelivery(new \DateTime('tomorrow'));
        $shipment = $this->client->shipments->create($parcel);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertInstanceOf(ShipmentOptions::class, $shipment->options);
        $this->assertNotNull($shipment->id);
        $this->assertEquals(ShipmentStatus::CONCEPT, $shipment->status);
        $this->assertEquals('John', $shipment->recipient->first_name);
        $this->assertEquals('Doe', $shipment->recipient->last_name);

        $this->assertTrue($this->cleanUp($shipment));
    }

    /** @test */
    public function create_a_new_shipment_concept_for_a_parcel_evening_delivery()
    {
        $array = [
            'reference_identifier' => 'test-123',
            'recipient' => [
                'company' => 'Test Company B.V.',
                'first_name' => 'John',
                'last_name' => 'Doe',
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
                'package_type' => PackageType::PACKAGE,
                'return' => false,
                'signature' => true,
            ],
        ];

        $parcel = new Parcel($array);
        $parcel->eveningDelivery(new \DateTime('tomorrow'));
        $shipment = $this->client->shipments->create($parcel);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertInstanceOf(ShipmentOptions::class, $shipment->options);
        $this->assertNotNull($shipment->id);
        $this->assertEquals(ShipmentStatus::CONCEPT, $shipment->status);
        $this->assertEquals('John', $shipment->recipient->first_name);
        $this->assertEquals('Doe', $shipment->recipient->last_name);

        $this->assertTrue($this->cleanUp($shipment));
    }

    /** @test */
    public function create_a_new_shipment_concept_for_a_parcel_express_delivery()
    {
        $array = [
            'reference_identifier' => 'test-123',
            'recipient' => [
                'company' => 'Test Company B.V.',
                'first_name' => 'John',
                'last_name' => 'Doe',
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
                'package_type' => PackageType::PACKAGE,
                'return' => false,
                'signature' => true,
            ],
        ];

        $parcel = new Parcel($array);
        $parcel->expressDelivery(new \DateTime('tomorrow'));
        $shipment = $this->client->shipments->create($parcel);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertInstanceOf(ShipmentOptions::class, $shipment->options);
        $this->assertNotNull($shipment->id);
        $this->assertEquals(ShipmentStatus::CONCEPT, $shipment->status);
        $this->assertEquals('John', $shipment->recipient->first_name);
        $this->assertEquals('Doe', $shipment->recipient->last_name);

        $this->assertTrue($this->cleanUp($shipment));
    }

    /** @test */
    public function create_shipment_with_a_pick_up_location()
    {
        $array = [
            'recipient' => $this->validRecipient(),
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

        $shipment = $this->client->shipments->concept($parcel);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertInstanceOf(ShipmentOptions::class, $shipment->options);
        $this->assertInstanceOf(ServicePoint::class, $shipment->pickup);
        $this->assertNotNull($shipment->id);

        $this->assertTrue($this->cleanUp($shipment));
    }

    /** @test */
    public function delete_a_shipment_by_id()
    {
        $parcel = new Parcel([
            'recipient' => $this->validRecipient(),
        ]);

        $shipment = $this->client->shipments->concept($parcel);

        $this->assertTrue($this->client->shipments->delete($shipment->id));
    }

    /** @test */
    public function delete_a_shipment_by_passing_shipment_resource()
    {
        $parcel = new Parcel([
            'recipient' => $this->validRecipient(),
        ]);

        $shipment = $this->client->shipments->concept($parcel);

        $this->assertTrue($this->client->shipments->delete($shipment));
    }

    /** @test */
    public function only_a_concept_can_be_deleted()
    {
        $parcel = new Parcel([
            'recipient' => $this->validRecipient(),
        ]);

        $shipment = $this->client->shipments->concept($parcel);
        $shipment->status = ShipmentStatus::REGISTERED;

        $this->assertFalse($this->client->shipments->delete($shipment));

        $shipment->status = ShipmentStatus::CONCEPT;

        $this->assertTrue($this->client->shipments->delete($shipment));
    }

    /** @test */
    public function get_a_shipment_by_its_id()
    {
        $array = [
            'recipient' => $this->validRecipient(),
        ];

        $parcel = new Parcel($array);
        $concept = $this->client->shipments->concept($parcel);

        $shipment = $this->client->shipments->get($concept->id);

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertNotNull($shipment->id);
        $this->assertNotNull($shipment->created);
        $this->assertNotNull($shipment->status);

        $this->assertTrue($this->cleanUp($shipment));
    }

    /** @test */
    public function getting_a_shipment_with_an_invalid_id_should_throw_an_error()
    {
        $this->expectException(\Mvdnbrk\MyParcel\Exceptions\MyParcelException::class);
        $this->expectExceptionMessage('Shipment with an id of "9999999999" not found.');

        $this->client->shipments->get('9999999999');
    }

    /** @test */
    public function get_a_shipment_by_its_reference()
    {
        $array = [
            'reference_identifier' => 'test-123',
            'recipient' => $this->validRecipient(),
        ];

        $parcel = new Parcel($array);
        $this->client->shipments->concept($parcel);

        $shipment = $this->client->shipments->getByReference('test-123');

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertEquals('test-123', $shipment->reference_identifier);
        $this->assertNotNull($shipment->id);
        $this->assertNotNull($shipment->created);
        $this->assertNotNull($shipment->status);

        $this->assertTrue($this->cleanUp($shipment));
    }

    /** @test */
    public function getting_a_shipment_with_an_invalid_reference_should_throw_an_error()
    {
        $this->expectException(\Mvdnbrk\MyParcel\Exceptions\MyParcelException::class);
        $this->expectExceptionMessage('Shipment with reference "invalid-reference-throws-error" not found.');

        $this->client->shipments->getByReference('invalid-reference-throws-error');
    }
}
