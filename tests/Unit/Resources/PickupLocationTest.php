<?php

namespace Mvdnbrk\MyParcel\Tests\Unit\Resources;

use Mvdnbrk\MyParcel\Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\PickupLocation;

class PickupLocationTest extends TestCase
{
    /** @test */
    public function creating_a_valid_pickup_location_resource()
    {
        $pickup = new PickupLocation([
            'location' => 'Test Company B.V.',
            'street' => 'Poststraat',
            'number' => '1',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'phone_number' => '0101111111',
            'distance' => '9999',
            'latitude' => '12.3456',
            'longitude' => '98.76543',
            'location_code' => '112233',
            'opening_hours' => [
                'monday' => ['08:00-18:30'],
                'tuesday' => ['08:00-18:30'],
                'wednesday' => ['08:00-18:30'],
                'thursday' => ['08:00-18:30'],
                'friday' => ['08:00-18:30'],
                'saturday' => ['08:00-17:00'],
                'sunday' => []
            ],
        ]);

        $this->assertEquals('Test Company B.V.', $pickup->location_name);
        $this->assertEquals('Poststraat', $pickup->street);
        $this->assertEquals('1', $pickup->number);
        $this->assertEquals('1234AA', $pickup->postal_code);
        $this->assertEquals('Amsterdam', $pickup->city);
        $this->assertEquals('0101111111', $pickup->phone_number);
        $this->assertEquals('9999', $pickup->distance);
        $this->assertEquals('12.3456', $pickup->latitude);
        $this->assertEquals('98.76543', $pickup->longitude);
        $this->assertEquals('112233', $pickup->location_code);
        $this->assertInternalType('array', $pickup->opening_hours);
    }

    /** @test */
    public function can_get_distance_for_humans()
    {
        $pickup = new PickupLocation;

        $pickup->distance = 999;
        $this->assertEquals('999 meter', $pickup->distanceForHumans());

        $pickup->distance = 1000;
        $this->assertEquals('1 km', $pickup->distanceForHumans());

        $pickup->distance = 1500;
        $this->assertEquals('1.5 km', $pickup->distanceForHumans());

        $pickup->distance = 2211;
        $this->assertEquals('2.2 km', $pickup->distanceForHumans());

        $pickup->distance = 2255;
        $this->assertEquals('2.3 km', $pickup->distanceForHumans());

        $pickup->distance = 11500;
        $this->assertEquals('12 km', $pickup->distanceForHumans());
    }

    /** @test */
    public function distance_for_humans_returns_null_if_distance_is_null()
    {
        $pickup = new PickupLocation;

        $pickup->distance = null;

        $this->assertNull($pickup->distanceForHumans());
    }

    /** @test */
    public function location_may_be_used_as_an_alias_to_set_location_name()
    {
        $pickup = new PickupLocation([
            'location' => 'Test Location',
        ]);

        $this->assertEquals('Test Location', $pickup->location_name);
    }

    /** @test */
    public function name_may_be_used_as_an_alias_to_location_name()
    {
        $pickup = new PickupLocation([
            'name' => 'Test Location',
        ]);

        $this->assertEquals('Test Location', $pickup->location_name);
        $this->assertEquals('Test Location', $pickup->name);
    }

    /** @test */
    public function phone_number_may_be_used_as_an_alias_to_phone()
    {
        $pickup = new PickupLocation([
            'phone_number' => '0101111111',
        ]);

        $this->assertEquals('0101111111', $pickup->phone);
        $this->assertEquals('0101111111', $pickup->phone_number);
    }

    /** @test */
    public function latitude_and_longitude_are_converted_to_float()
    {
        $pickup = new PickupLocation([
            'latitude' => '1.11',
            'longitude' => '2.22',
        ]);

        $this->assertSame(1.11, $pickup->latitude);
        $this->assertSame(2.22, $pickup->longitude);
    }

    /** @test */
    public function to_array()
    {
        $pickup = new PickupLocation([
            'name' => 'Test name',
            'phone' => '0101111111',
            'location_code' => 'testcode1234',
            'opening_hours' => [
                'monday' => '9:00-17:00',
            ],
            'latitude' => 1.11,
            'longitude' => 2.22,
            'distance' => 100,
        ]);

        $array = $pickup->toArray();

        $this->assertInternalType('array', $array);
        $this->assertEquals('Test name', $array['location_name']);
        $this->assertEquals('0101111111', $array['phone']);
        $this->assertEquals('testcode1234', $array['location_code']);
        $this->assertEquals(['monday' => '9:00-17:00'], $array['opening_hours']);
        $this->assertEquals(1.11, $array['latitude']);
        $this->assertEquals(2.22, $array['longitude']);
        $this->assertEquals('100 meter', $array['distance']);
    }

    /** @test */
    public function to_array_removes_empty_attributes()
    {
        $pickup = new PickupLocation([
            'name' => 'Test name',
            'phone' => null,
            'location_code' => null,
            'opening_hours' => [],
            'latitude' => null,
            'longitude' => null,
            'distance' => null,
        ]);

        $array = $pickup->toArray();

        $this->assertInternalType('array', $array);
        $this->assertEquals('Test name', $array['location_name']);
        $this->assertArrayNotHasKey('phone', $array);
        $this->assertArrayNotHasKey('location_code', $array);
        $this->assertArrayNotHasKey('latitude', $array);
        $this->assertArrayNotHasKey('longitude', $array);
        $this->assertArrayNotHasKey('distance', $array);
        $this->assertArrayNotHasKey('opening_hours', $array);
    }

    /** @test */
    public function number_should_be_casted_to_a_string()
    {
        $pickup = new PickupLocation([
            'number' => 999
        ]);

        $array = $pickup->toArray();

        $this->assertInternalType('string', $array['number']);
        $this->assertEquals('999', $array['number']);
    }
}
