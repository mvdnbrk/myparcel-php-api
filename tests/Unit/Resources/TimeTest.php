<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\Time;
use Mvdnbrk\MyParcel\Exceptions\InvalidTimeException;

class TimeTest extends TestCase
{
    /** @test */
    public function constructing_a_valid_time()
    {
        $time = new Time('12:00:00');
        $this->assertEquals('12:00:00', $time->get());

        $time = new Time('12:00');
        $this->assertEquals('12:00:00', $time->get());
    }

    /** @test */
    public function constructing_an_invalid_time()
    {
        $this->expectException(InvalidTimeException::class);
        $time = new Time('not-valid');

        $this->expectException(InvalidTimeException::class);
        $time = new Time('99:00:00');
    }

    /** @test */
    public function can_get_a_time()
    {
        $time = new Time('12:34');
        $this->assertEquals('12:34:00', $time->get());
    }
}
