<?php

namespace Mvdnbrk\MyParcel\Tests\Support;

use Mvdnbrk\MyParcel\Support\Str;
use Mvdnbrk\MyParcel\Tests\TestCase;

class StrTest extends TestCase
{
    /** @test */
    public function lower()
    {
        $this->assertEquals('mvdnbrk string', Str::lower('MVDNBRK STRING'));
        $this->assertEquals('mvdnbrk teststring', Str::lower('MvdnBrk TestString'));
    }

    /** @test */
    public function starts_with()
    {
        $this->assertTrue(Str::startsWith('mvdnbrk', 'mvdn'));
        $this->assertTrue(Str::startsWith('mvdnbrk', 'mvdnbrk'));
        $this->assertFalse(Str::startsWith('mvdnbrk', 'string'));
        $this->assertFalse(Str::startsWith('mvdnbrk', ''));
        $this->assertFalse(Str::startsWith('m', ' m'));
    }

    /** @test */
    public function studly()
    {
        $this->assertEquals('MvdnbrkTestStringPhp', Str::studly('mvdnbrk_test_string_php'));
        $this->assertEquals('MvdnbrkStringPhp', Str::studly('mvdnbrk_string_php'));
        $this->assertEquals('MvdnbrkTestStringPhp', Str::studly('mvdnbrk-testString-php'));
        $this->assertEquals('MvdnbrkStringPhp', Str::studly('mvdnbrk  -_-  string   -_-   php   '));
    }

    /** @test */
    public function upper()
    {
        $this->assertEquals('FOO BAR', Str::upper('foo bar'));
        $this->assertEquals('FOO BAR', Str::upper('foO bAr'));
    }
}
