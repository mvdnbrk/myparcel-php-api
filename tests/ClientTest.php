<?php

namespace Tests;

use Mvdnbrk\MyParcel\Client;
use Mvdnbrk\MyParcel\Endpoints\Shipments;
use Mvdnbrk\MyParcel\Endpoints\DeliveryOptions;
use Mvdnbrk\MyParcel\Exceptions\MyParcelException;

class ClientTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->client = new Client;
    }

    /** @test */
    public function a_client_has_a_delivery_options_endpoint()
    {
        $this->assertInstanceOf(DeliveryOptions::class, $this->client->deliveryOptions);
    }

    /** @test */
    public function a_client_has_a_shipments_endpoint()
    {
        $this->assertInstanceOf(Shipments::class, $this->client->shipments);
    }

    /** @test */
    public function performing_an_http_call_without_setting_an_api_key_throws_an_exception()
    {
        $this->expectException(MyParcelException::class);
        $this->client->performHttpCall('GET', 'some-resource');
    }
}
