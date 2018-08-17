<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\Shipment;

class ShipmentTest extends TestCase
{
    /** @test */
    public function creating_a_shipment_resource()
    {
        $shipment = new Shipment([
            'id' => 123456,
        ]);

        $this->assertEquals(123456, $shipment->id);
    }
}
