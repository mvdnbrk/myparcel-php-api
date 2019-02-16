<?php

namespace Mvdnbrk\MyParcel\Tests;

use Mvdnbrk\MyParcel\Client;

class MyParcelServiceProviderTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_client_instance()
    {
        $this->assertInstanceOf(Client::class, resolve('myparcel'));
    }
}
