<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Illuminate\Support\Collection;
use Mvdnbrk\MyParcel\Resources\Webhook as WebhookResource;

class Webhooks extends BaseEndpoint
{
    public function list(): Collection
    {
        $response = $this->performApiCall(
            'GET',
            'webhook_subscriptions'
        );

        return collect($response->data->webhook_subscriptions);
    }

    public function get($value): WebhookResource
    {
        if ($value instanceof WebhookResource) {
            $value = $value->id;
        }

        $response = $this->performApiCall(
            'GET',
            'webhook_subscriptions/' . $value
        );

        return new WebhookResource(
            collect(
                collect($response->data->webhook_subscriptions)->first()
            )->all()
        );
    }

    public function add(WebhookResource $webhook)
    {
        $response = $this->performApiCall(
            'POST',
            'webhook_subscriptions',
            json_encode([
                'data' => [
                    'webhook_subscriptions' => [
                        $webhook->toArray(),
                    ],
                ],
            ]),
            ['Content-Type' => 'application/json; charset=utf-8']
        );
        $webhook->id = $response->data->ids[0]->id;

        return $webhook;
    }

    public function delete($value)
    {
        if ($value instanceof WebhookResource) {
            $value = $value->id;
        }
        $this->performApiCall(
            'DELETE',
            'webhook_subscriptions/'.$value
        );

        return true;
    }
}
