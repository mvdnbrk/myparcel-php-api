<?php

namespace Tests;

use Mvdnbrk\MyParcel\Client;
use Mvdnbrk\MyParcel\Endpoints\Shipments;
use Mvdnbrk\MyParcel\Endpoints\TrackTrace;
use Mvdnbrk\MyParcel\Endpoints\ShipmentLabels;
use Mvdnbrk\MyParcel\Endpoints\DeliveryOptions;
use Mvdnbrk\MyParcel\Exceptions\MyParcelException;

class ClientTest extends TestCase
{
    /** @test */
    public function a_client_has_a_delivery_options_endpoint()
    {
        $this->assertInstanceOf(DeliveryOptions::class, $this->client->deliveryOptions);
    }

    /** @test */
    public function a_client_has_a_shipment_labels_endpoint()
    {
        $this->assertInstanceOf(ShipmentLabels::class, $this->client->labels);
    }

    /** @test */
    public function a_client_has_a_shipments_endpoint()
    {
        $this->assertInstanceOf(Shipments::class, $this->client->shipments);
    }

    /** @test */
    public function a_client_has_a_track_trace_endpoint()
    {
        $this->assertInstanceOf(TrackTrace::class, $this->client->tracktrace);
    }

    /** @test */
    public function performing_an_http_call_without_setting_an_api_key_throws_an_exception()
    {
        $this->expectException(MyParcelException::class);
        $this->client->setApiKey(null);
        $this->client->performHttpCall('GET', 'some-resource');
    }
}
