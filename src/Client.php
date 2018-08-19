<?php

namespace Mvdnbrk\MyParcel;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client as HttpClient;
use Mvdnbrk\MyParcel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Mvdnbrk\MyParcel\Endpoints\Shipments;
use Mvdnbrk\MyParcel\Endpoints\DeliveryOptions;
use Mvdnbrk\MyParcel\Exceptions\MyParcelException;

class Client
{
    /**
     * Endpoint of the remote API.
     */
    const API_ENDPOINT = 'https://api.myparcel.nl';

    /**
     * HTTP Status code for no cotent.
     */
    const HTTP_STATUS_NO_CONTENT = 204;

    /**
     * @var string
     */
    protected $apiEndpoint = self::API_ENDPOINT;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var \Mvdnbrk\MyParcel\Endpoints\DeliveryOptions
     */
    public $deliveryOptions;

    /**
     * @var \Mvdnbrk\MyParcel\Endpoints\Shipments
     */
    public $shipments;

    /**
     * @var \GuzzleHttp\Client;
     */
    protected $httpClient;

    /**
     * Create a new Client Instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient();

        $this->initializeEndpoints();
    }

    /**
     * Initialize the API endpoints used by this client.
     *
     * @return void
     */
    public function initializeEndpoints()
    {
        $this->shipments = new Shipments($this);
        $this->deliveryOptions = new DeliveryOptions($this);
    }

    /**
     * Performs a HTTP call to the API endpoint
     *
     * @param  string  $httpMethod          The method to make the API call. GET/POST etc,
     * @param  string  $apiMethod           The API method to call at the endpoint.
     * @param  string|null  $httpBody       The body to be send with te request.
     * @param  array  $requestHeaders       Request headers to be send with the request.
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null, $requestHeaders = [])
    {
        if (empty($this->apiKey)) {
            throw new MyParcelException("You have not set an API key. Please use setApiKey() to set the API key.");
        }

        $url = $this->apiEndpoint . '/' . $apiMethod;

        $headers = new Collection([
            'User-Agent' => 'CustomApiCall/2',
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.base64_encode($this->apiKey),
        ]);

        if ($httpBody !== null) {
            $headers->put('Content-Type', 'application/json');
        }

        $request = new Request($httpMethod, $url, $headers->merge($requestHeaders)->all(), $httpBody);

        try {
            $response = $this->httpClient->send($request, ['http_errors' => false]);
        } catch (GuzzleException $e) {
            throw new MyParcelException($e->getMessage(), $e->getCode());
        }

        if (! $response) {
            throw new MyParcelException('No API response received.');
        }

        return $response;
    }

    /**
     * Sets the API key.
     *
     * @param string  $value
     * @return void
     */
    public function setApiKey($value)
    {
        $this->apiKey = trim($value);
    }
}
