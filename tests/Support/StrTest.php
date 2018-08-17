<?php

namespace Tests\Support;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Support\Str;

class StrTest extends TestCase
{
    /** @test */
    public function lower()
    {
        $this->assertEquals('mvdnbrk myparcel', Str::lower('MVDNBRK MYPARCEL'));
        $this->assertEquals('mvdnbrk myparcel', Str::lower('MvdnBrk MyParcel'));
    }

    /** @test */
    public function starts_with()
    {
        $this->assertTrue(Str::startsWith('mvdnbrk', 'mvdn'));
        $this->assertTrue(Str::startsWith('mvdnbrk', 'mvdnbrk'));
        $this->assertFalse(Str::startsWith('mvdnbrk', 'parcel'));
        $this->assertFalse(Str::startsWith('mvdnbrk', ''));
        $this->assertFalse(Str::startsWith('m', ' m'));
    }

    /** @test */
    public function studly()
    {
        $this->assertEquals('MvdnbrkMyParcelPhp', Str::studly('mvdnbrk_my_parcel_php'));
        $this->assertEquals('MvdnbrkMyparcelPhp', Str::studly('mvdnbrk_myparcel_php'));
        $this->assertEquals('MvdnbrkMyParcelPhp', Str::studly('mvdnbrk-myParcel-php'));
        $this->assertEquals('MvdnbrkMyparcelPhp', Str::studly('mvdnbrk  -_-  myparcel   -_-   php   '));
    }

    /** @test */
    public function upper()
    {
        $this->assertEquals('FOO BAR', Str::upper('foo bar'));
        $this->assertEquals('FOO BAR', Str::upper('foO bAr'));
    }
}
