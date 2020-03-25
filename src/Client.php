<?php

namespace Mvdnbrk\MyParcel;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Mvdnbrk\MyParcel\Endpoints\ServicePoints;
use Mvdnbrk\MyParcel\Endpoints\ShipmentLabels;
use Mvdnbrk\MyParcel\Endpoints\Shipments;
use Mvdnbrk\MyParcel\Endpoints\TrackTrace;
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
     * @var \Mvdnbrk\MyParcel\Endpoints\ServicePoints
     */
    public $servicePoints;

    /**
     * @var \Mvdnbrk\MyParcel\Endpoints\ShipmentLabels
     */
    public $labels;

    /**
     * @var \Mvdnbrk\MyParcel\Endpoints\Shipments
     */
    public $shipments;

    /**
     * @var \Mvdnbrk\MyParcel\Endpoints\TrackTrace
     */
    public $tracktrace;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * Create a new Client instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient([
            RequestOptions::VERIFY => CaBundle::getBundledCaBundlePath(),
        ]);

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
        $this->labels = new ShipmentLabels($this);
        $this->tracktrace = new TrackTrace($this);
        $this->servicePoints = new ServicePoints($this);
    }

    /**
     * Performs a HTTP call to the API endpoint.
     *
     * @param  string  $httpMethod
     * @param  string  $apiMethod
     * @param  string|null  $httpBody
     * @param  array  $requestHeaders
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \Mvdnbrk\MyParcel\Exceptions\MyParcelException
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null, $requestHeaders = [])
    {
        if (empty($this->apiKey)) {
            throw new MyParcelException('You have not set an API key. Please use setApiKey() to set the API key.');
        }

        $headers = collect([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.base64_encode($this->apiKey),
        ]);

        if ($httpBody !== null) {
            $headers->put('Content-Type', 'application/json');
        }

        $request = new Request(
            $httpMethod,
            $this->apiEndpoint.'/'.$apiMethod,
            $headers->merge($requestHeaders)->all(),
            $httpBody
        );

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
     * Set the API key.
     *
     * @param  string  $value
     * @return \Mvdnbrk\MyParcel\Client
     */
    public function setApiKey($value)
    {
        $this->apiKey = trim($value);

        return $this;
    }
}
