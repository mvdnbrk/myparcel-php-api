<?php

namespace Mvdnbrk\MyParcel\Tests\Feature\Endpoints;

use Illuminate\Support\Collection;
use Mvdnbrk\MyParcel\Exceptions\MyParcelException;
use Mvdnbrk\MyParcel\Resources\Webhook;
use Mvdnbrk\MyParcel\Tests\TestCase;
use Mvdnbrk\MyParcel\Types\HookType;

class WebhooksTest extends TestCase
{
    private function cleanUp(Webhook $webhook): bool
    {
        return $this->client->webhooks->delete($webhook);
    }

    /** @test */
    public function get_current_webhook_subscriptions_collection()
    {
        $subscriptions = $this->client->webhooks->list();
        $this->assertInstanceOf(Collection::class, $subscriptions);
    }

    /** @test */
    public function add_new_subscription()
    {
        $webhook = new Webhook([
            'hook' => HookType::SHIPMENT_STATUS_CHANGED,
            'url' => 'https://localhost.nl/shipment_status_changed',
        ]);
        $subscription = $this->client->webhooks->add($webhook);
        $this->assertInstanceOf(Webhook::class, $subscription);
        $this->assertNotNull($subscription->id);
        $this->assertEquals('https://localhost.nl/shipment_status_changed', $subscription->url);
        $this->assertTrue($this->cleanUp($subscription));
    }

    /** @test */
    public function get_subscription_by_id()
    {
        $webhook = new Webhook([
            'hook' => HookType::SHIPMENT_STATUS_CHANGED,
            'url' => 'https://localhost.nl/shipment_status_changed',
        ]);
        $createdSubscription = $this->client->webhooks->add($webhook);

        // get subscription by id
        $subscription = $this->client->webhooks->get($createdSubscription->id);
        $this->assertInstanceOf(Webhook::class, $subscription);
        $this->assertNotNull($subscription->id);
        $this->assertEquals('https://localhost.nl/shipment_status_changed', $subscription->url);
        $this->assertTrue($this->cleanUp($subscription));
    }

    /** @test */
    public function get_subscription_by_resource()
    {
        $webhook = new Webhook([
            'hook' => HookType::SHIPMENT_STATUS_CHANGED,
            'url' => 'https://localhost.nl/shipment_status_changed',
        ]);
        $createdSubscription = $this->client->webhooks->add($webhook);

        // get subscription by id
        $subscription = $this->client->webhooks->get($createdSubscription);
        $this->assertInstanceOf(Webhook::class, $subscription);
        $this->assertNotNull($subscription->id);
        $this->assertEquals('https://localhost.nl/shipment_status_changed', $subscription->url);
        $this->assertTrue($this->cleanUp($subscription));
    }

    /** @test */
    public function delete_subscription_by_id()
    {
        $webhook = new Webhook([
            'hook' => HookType::SHIPMENT_STATUS_CHANGED,
            'url' => 'https://localhost.nl/shipment_status_changed',
        ]);
        $createdSubscription = $this->client->webhooks->add($webhook);

        // delete subscription by id
        $this->assertTrue($this->client->webhooks->delete($createdSubscription->id));
    }

    /** @test */
    public function delete_subscription_by_resource()
    {
        $webhook = new Webhook([
            'hook' => HookType::SHIPMENT_STATUS_CHANGED,
            'url' => 'https://localhost.nl/shipment_status_changed',
        ]);
        $createdSubscription = $this->client->webhooks->add($webhook);

        // delete subscription by id
        $this->assertTrue($this->client->webhooks->delete($createdSubscription));
    }

    /** @test */
    public function add_subscription_invalid_data()
    {
        $this->expectException(MyParcelException::class);
        $this->expectExceptionMessage('Error executing API call');
        $webhook = new Webhook([
            'hook' => HookType::SHIPMENT_STATUS_CHANGED,
        ]);
        $this->client->webhooks->add($webhook);
    }
}
