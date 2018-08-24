<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\PickupLocation;

class PickupLocationTest extends TestCase
{
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
    public function name_may_be_used_as_an_alias_to_location_name()
    {
        $pickup = new PickupLocation([
            'name' => 'Test Location',
        ]);

        $this->assertEquals('Test Location', $pickup->location_name);
        $this->assertEquals('Test Location', $pickup->name);
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
