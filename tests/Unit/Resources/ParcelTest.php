<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\Parcel;

class ParcelTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function create_a_new_parcel()
    {
        $parcel = new Parcel([
            'reference_identifier' => 'test-123',
        ]);

        $this->assertEquals('test-123', $parcel->reference_identifier);
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
}
