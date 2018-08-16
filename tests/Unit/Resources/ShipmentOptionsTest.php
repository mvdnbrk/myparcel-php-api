<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\ShipmentOptions;

class ShipmentOptionsTest extends TestCase
{
    /** @test */
    public function creating_a_shipments_options_resource()
    {
        $options = new ShipmentOptions([
            'label_description' => 'Test description',
        ]);

        $this->assertEquals('Test description', $options->label_description);
    }

    /** @test */
    public function description_may_be_used_as_an_alias_to_label_description()
    {
        $recipient = new ShipmentOptions([
            'description' => 'Test description',
        ]);

        $this->assertEquals('Test description', $recipient->label_description);
        $this->assertEquals('Test description', $recipient->description);
    }
}
