<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Mvdnbrk\MyParcel\Resources\TrackTrace;

class TrackTraceTest extends TestCase
{
    /** @test */
    public function creating_a_track_trace_resource()
    {
        $tracktrace = new TrackTrace([
            'shipment_id' => '123456',
            'status' => [
                'current' => 7,
                'final' => true,
            ],
            'code' => 'AA1',
            'description' => 'Test description',
            'time' => '2018-08-28 23:00:00',
            'history' => [],
        ]);

        $this->assertEquals('123456', $tracktrace->shipment_id);
        $this->assertTrue($tracktrace->final);
        $this->assertEquals('AA1', $tracktrace->code);
        $this->assertEquals('Test description', $tracktrace->description);
        $this->assertEquals('2018-08-28 23:00:00', $tracktrace->time);
        $this->assertSame([], $tracktrace->history);
    }

    /** @test */
    public function getting_items_on_a_track_trace_collection_returns_a_collection_class()
    {
        $tracktrace = new TrackTrace([
            'history' => [],
        ]);

        $this->assertInstanceOf(Collection::class, $tracktrace->items);
    }

    /** @test */
    public function getting_items_on_a_track_trace_collection_includes_the_last_trace()
    {
        $tracktrace = new TrackTrace([
            'code' => 'AA4',
            'description' => 'Test 4',
            'time' => '2018-09-04 15:00:00',
            'history' => [
                ['code' => 'AA3', 'description' => 'Test 3', 'time' => '2018-09-03 14:00:00'],
                ['code' => 'AA2', 'description' => 'Test 2', 'time' => '2018-09-02 13:00:00'],
                ['code' => 'AA1', 'description' => 'Test 1', 'time' => '2018-09-01 12:00:00'],
            ],
        ]);

        $this->assertCount(3, $tracktrace->history);
        $this->assertCount(4, $tracktrace->items);
        $this->assertEquals('AA4', $tracktrace->items->first()->code);
        $this->assertEquals('Test 4', $tracktrace->items->first()->description);
        $this->assertEquals('2018-09-04 15:00:00', $tracktrace->items->first()->time);
        $this->assertEquals('AA1', $tracktrace->items->last()->code);
        $this->assertEquals('Test 1', $tracktrace->items->last()->description);
        $this->assertEquals('2018-09-01 12:00:00', $tracktrace->items->last()->time);
    }
}
