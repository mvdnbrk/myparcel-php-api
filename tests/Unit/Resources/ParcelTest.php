<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\Parcel;
use Mvdnbrk\MyParcel\Resources\PickupLocation;

class ParcelTest extends TestCase
{
    /** @test */
    public function create_a_new_parcel()
    {
        $parcel = new Parcel([
            'reference_identifier' => 'test-123',
            'recipient' => [
                'company' => 'Test Company B.V.',
                'person' => 'John Doe',
            ],
            'options' => [
                'description' => 'Test label description',
                'signature' => 1,
            ],
        ]);

        $this->assertEquals('test-123', $parcel->reference_identifier);
        $this->assertEquals('Test Company B.V.', $parcel->recipient->company);
        $this->assertEquals('John Doe', $parcel->recipient->person);
        $this->assertEquals('Test label description', $parcel->options->label_description);
        $this->assertSame(1, $parcel->options->signature);
    }

    /** @test */
    public function it_can_set_a_label_description()
    {
        $parcel = new Parcel();

        $this->assertNull($parcel->options->label_description);

        $parcel->labelDescription('Test label description');
        $this->assertEquals('Test label description', $parcel->options->label_description);

        $parcel->labelDescription('   Test   ');
        $this->assertEquals('Test', $parcel->options->label_description);
    }

    /** @test */
    public function it_can_require_a_signature_from_the_recipient_of_the_parcel()
    {
        $parcel = new Parcel();

        $this->assertFalse($parcel->options->signature);

        $parcel->signature();

        $this->assertInstanceOf(Parcel::class, $parcel);
        $this->assertTrue($parcel->options->signature);
    }

    /** @test */
    public function it_can_set_a_parcel_as_a_mailbox_package()
    {
        $parcel = new Parcel([
            'options' => [
                'signature' => true,
                'large_format' => true,
                'only_recipent' => true,
            ]
        ]);

        $this->assertTrue($parcel->options->signature);

        $parcel->mailboxpackage();

        $this->assertInstanceOf(Parcel::class, $parcel);
        $this->assertSame(2, $parcel->options->package_type);
        $this->assertFalse($parcel->options->signature);
        $this->assertFalse($parcel->options->large_format);
        $this->assertFalse($parcel->options->only_recipient);
    }

    /** @test */
    public function it_can_set_a_parcel_to_be_only_delivered_to_the_recipient()
    {
        $parcel = new Parcel();

        $this->assertFalse($parcel->options->only_recipient);

        $parcel->onlyRecipient();

        $this->assertInstanceOf(Parcel::class, $parcel);
        $this->assertTrue($parcel->options->only_recipient);
    }

    /** @test */
    public function it_can_set_a_parcel_to_be_returned_to_sender_when_recipient_is_not_at_home()
    {
        $parcel = new Parcel();

        $this->assertFalse($parcel->options->return);

        $parcel->returnToSender();

        $this->assertInstanceOf(Parcel::class, $parcel);
        $this->assertTrue($parcel->options->return);
    }

    /** @test */
    public function it_can_set_a_pickup_location_where_the_recipient_can_pick_up_the_parcel_with_an_array()
    {
        $parcel = new Parcel();

        $this->assertNull($parcel->pickup);
        $this->assertArrayNotHasKey('pickup', $parcel->toArray());

        $parcel->fill([
            'pickup' => [
                'name' => 'MyParcel',
                'street' => 'Siriusdreef',
                'number' => '66',
                'postal_code' => '2132WT',
                'city' => 'Hoofddorp',
                'cc' => 'NL',
            ],
        ]);

        $this->assertInstanceOf(Parcel::class, $parcel);
        $this->assertInstanceOf(PickupLocation::class, $parcel->pickup);
        $this->assertArrayHasKey('pickup', $parcel->toArray());

        $this->assertEquals('MyParcel', $parcel->pickup->location_name);
        $this->assertEquals('Siriusdreef', $parcel->pickup->street);
        $this->assertEquals('66', $parcel->pickup->number);
        $this->assertEquals('2132WT', $parcel->pickup->postal_code);
        $this->assertEquals('Hoofddorp', $parcel->pickup->city);
        $this->assertEquals('NL', $parcel->pickup->cc);
        $this->assertEquals(1, $parcel->options->package_type);
        $this->assertEquals(4, $parcel->options->delivery_type);
        $this->assertFalse($parcel->options->only_recipient);
        $this->assertTrue($parcel->options->signature);
    }

    /** @test */
    public function reference_may_be_used_as_an_alias_to_reference_identifier()
    {
        $parcel = new Parcel([
            'reference' => 'test-123',
        ]);

        $this->assertEquals('test-123', $parcel->reference_identifier);
        $this->assertEquals('test-123', $parcel->reference);
    }

    /** @test */
    public function to_array_test()
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
                'delivery_type' => 2,
                'label_description' => 'Test label description',
                'large_format' => 0,
                'only_recipient' => 0,
                'package_type' => 1,
                'return' => 0,
                'signature' => 1,
            ],
        ];

        $parcel = new Parcel($array);

        $this->assertSame($array, $parcel->toArray());
    }

    /** @test */
    public function reference_identifier_is_optional()
    {
        $parcel = new Parcel([
            'reference_identifier' => null,
        ]);

        $this->assertArrayNotHasKey('reference_identifier', $parcel->toArray());
    }

    /** @test */
    public function recipient_is_required()
    {
        $parcel = new Parcel();

        $array = $parcel->toArray();

        $this->assertArrayHasKey('recipient', $array);
        $this->assertInternalType('array', $array['recipient']);
    }

    /** @test */
    public function options_are_required()
    {
        $parcel = new Parcel();

        $array = $parcel->toArray();

        $this->assertArrayHasKey('options', $array);
        $this->assertInternalType('array', $array['options']);
    }
}
