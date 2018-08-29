<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\Trace;

class TraceTest extends TestCase
{
    /** @test */
    public function creating_a_track_trace_resource()
    {
        $tracktrace = new Trace([
            'code' => 'AA1',
            'description' => 'Test description',
            'time' => '2018-08-28 23:00:00',
        ]);

        $this->assertEquals('AA1', $tracktrace->code);
        $this->assertEquals('Test description', $tracktrace->description);
        $this->assertEquals('2018-08-28 23:00:00', $tracktrace->time);
    }

    /** @test */
    public function datetime_may_be_used_as_an_alias_to_time()
    {
        $tracktrace = new Trace([
            'time' => '2018-08-28 23:00:00',
        ]);

        $this->assertEquals('2018-08-28 23:00:00', $tracktrace->time);
        $this->assertEquals('2018-08-28 23:00:00', $tracktrace->datetime);
    }
}
