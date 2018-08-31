<?php

namespace Tests;

use Mvdnbrk\MyParcel\Client;

class MyParcelServiceProviderTest extends TestCase
{
    /** @test */
    public function it_has_a_valid_default_configuration()
    {
        $this->assertInstanceOf(Client::class, resolve('myparcel'));
    }
}
