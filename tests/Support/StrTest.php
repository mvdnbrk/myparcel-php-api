<?php

namespace Tests\Support;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Support\Str;

class StrTest extends TestCase
{
    /** @test */
    public function testStudly()
    {
        $this->assertEquals('MvdnbrkMyParcelPhp', Str::studly('mvdnbrk_my_parcel_php'));
        $this->assertEquals('MvdnbrkMyparcelPhp', Str::studly('mvdnbrk_myparcel_php'));
        $this->assertEquals('MvdnbrkMyParcelPhp', Str::studly('mvdnbrk-myParcel-php'));
        $this->assertEquals('MvdnbrkMyparcelPhp', Str::studly('mvdnbrk  -_-  myparcel   -_-   php   '));
    }

    /** @test */
    public function testUpper()
    {
        $this->assertEquals('FOO BAR', Str::upper('foo bar'));
        $this->assertEquals('FOO BAR', Str::upper('foO bAr'));
    }
}
