<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Client;
use Mvdnbrk\MyParcel\Exceptions\MyParcelException;

abstract class BaseEndpoint
{
    /**
     * @var \Mvdnbrk\MyParcel\Client
     */
    protected $apiClient;

    public function __construct(Client $client)
    {
        $this->apiClient = $client;

        $this->boot();
    }

    protected function boot()
    {
    }

    protected function buildQueryString(array $filters)
    {
        if (empty($filters)) {
            return '';
        }

        return '?' . http_build_query($filters);
    }

    protected function performApiCall($httpMethod, $apiMethod, $httpBody = null)
    {
        $body = $this->apiClient->performHttpCall($httpMethod, $apiMethod, $httpBody);

        if ($this->apiClient->getLastHttpResponseStatusCode() == Client::HTTP_STATUS_NO_CONTENT) {
            return null;
        }

        if (empty($body)) {
            throw new MyParcelException("Unable to decode empty response: '{$body}'.");
        }

        $object = @json_decode($body);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new MyParcelException("Unable to decode response: '{$body}'.");
        }

        if (! empty($object->errors)) {
            $error = $object->errors[0];
            throw new MyParcelException("Error executing API call ({$error->code}): {$error->message}");
        }

        return $object;
    }
}
