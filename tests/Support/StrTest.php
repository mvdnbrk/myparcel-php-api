<?php

namespace Mvdnbrk\MyParcel\Tests\Support;

use Mvdnbrk\MyParcel\Support\Str;
use Mvdnbrk\MyParcel\Tests\TestCase;

class StrTest extends TestCase
{
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
