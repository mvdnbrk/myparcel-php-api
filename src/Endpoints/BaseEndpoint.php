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

    /**
     * Create a endpont instance.
     *
     * @param \Mvdnbrk\MyParcel\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->apiClient = $client;

        $this->boot();
    }

    /**
     * Boots the endpoint instance.
     *
     * @return mixed
     */
    protected function boot()
    {
    }

    /**
     * Build a query string.
     *
     * @param  array  $filters
     * @return string
     */
    protected function buildQueryString(array $filters)
    {
        if (empty($filters)) {
            return '';
        }

        return '?' . http_build_query($filters);
    }

    /**
     * Performs a HTTP call to the API endpoint
     *
     * @param  string  $httpMethod          The method to make the API call. GET/POST etc,
     * @param  string  $apiMethod           The API method to call at the endpoint.
     * @param  string|null  $httpBody       The body to be send with te request.
     * @param  array  $requestHeaders       Request headers to be send with the request.
     * @return string|object|null           The body of the response.
     * @throws \Mvdnbrk\MyParcel\Exceptions\MyParcelException
     */
    protected function performApiCall($httpMethod, $apiMethod, $httpBody = null, $requestHeaders = [])
    {
        $response = $this->apiClient->performHttpCall($httpMethod, $apiMethod, $httpBody, $requestHeaders);

        if (collect($response->getHeader('Content-Type'))->first() == 'application/pdf') {
            return $response->getBody()->getContents();
        }

        $body = $response->getBody()->getContents();

        if (empty($body)) {
            if ($response->getStatusCode() === Client::HTTP_STATUS_NO_CONTENT) {
                return null;
            }

            throw new MyParcelException('No response body found.');
        }

        $object = @json_decode($body);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new MyParcelException("Unable to decode MyParcel response: '{$body}'.");
        }

        if ($response->getStatusCode() >= 400) {
            $error = collect(collect($object->errors)->first());

            $messageBag = collect('Error executing API call');

            if ($error->has('code')) {
                $messageBag->push('('.$error->get('code').')');
            }

            if ($error->has('message')) {
                $messageBag->push(': '.$error->get('message'));
            }

            if ($error->has('human')) {
                $messageBag->push(': '.collect($error->get('human'))->first());
            }

            throw new MyParcelException($messageBag->implode(' '), $response->getStatusCode());
        }

        return $object;
    }
}
