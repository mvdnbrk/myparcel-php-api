<?php

namespace Mvdnbrk\MyParcel\Tests\Unit\Resources;

use Mvdnbrk\MyParcel\Resources\Trace;
use Mvdnbrk\MyParcel\Tests\TestCase;

class TraceTest extends TestCase
{
    /** @test */
    public function creating_a_track_trace_resource()
    {
        $tracktrace = new Trace([
            'code' => 'AA1',
            'description' => 'Test description',
            'time' => '2018-08-28 23:00:00',
			'link_consumer_portal' => 'https://postnl.nl/tracktrace/?B=3SMYPA126329191&P=2182KD&D=NL&T=C&L=NL',
			'link_tracktrace' => 'https://postnl.nl/tracktrace/?B=3SMYPA126329191&P=2182KD&D=NL&T=C&L=NL',
        ]);

        $this->assertEquals('AA1', $tracktrace->code);
        $this->assertEquals('Test description', $tracktrace->description);
        $this->assertEquals('2018-08-28 23:00:00', $tracktrace->time);
		$this->assertEquals('https://postnl.nl/tracktrace/?B=3SMYPA126329191&P=2182KD&D=NL&T=C&L=NL', $tracktrace->link_consumer_portal);
		$this->assertEquals('https://postnl.nl/tracktrace/?B=3SMYPA126329191&P=2182KD&D=NL&T=C&L=NL', $tracktrace->link_tracktrace);
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
