<?php

namespace Mvdnbrk\MyParcel\Tests\Unit\Object;

use PHPUnit\Framework\TestCase;
use Mvdnbrk\MyParcel\Object\PickupLocation;

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
}
