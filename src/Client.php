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
use Mvdnbrk\MyParcel\Endpoints\Webhooks;
use Mvdnbrk\MyParcel\Exceptions\MyParcelException;
use Psr\Http\Message\ResponseInterface;

class Client
{
    const API_ENDPOINT = 'https://api.myparcel.nl';

    const HTTP_STATUS_NO_CONTENT = 204;

    /** @var string */
    protected $apiEndpoint = self::API_ENDPOINT;

    /** @var string */
    protected $apiKey;

    /** @var \Mvdnbrk\MyParcel\Endpoints\ServicePoints */
    public $servicePoints;

    /** @var \Mvdnbrk\MyParcel\Endpoints\ShipmentLabels */
    public $labels;

    /** @var \Mvdnbrk\MyParcel\Endpoints\Shipments */
    public $shipments;

    /** @var \Mvdnbrk\MyParcel\Endpoints\TrackTrace */
    public $tracktrace;

    /** @var \Mvdnbrk\MyParcel\Endpoints\Webhooks */
    public $webhooks;

    /** @var \GuzzleHttp\Client */
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new HttpClient([
            RequestOptions::VERIFY => CaBundle::getBundledCaBundlePath(),
        ]);

        $this->initializeEndpoints();
    }

    public function initializeEndpoints(): void
    {
        $this->shipments = new Shipments($this);
        $this->labels = new ShipmentLabels($this);
        $this->tracktrace = new TrackTrace($this);
        $this->servicePoints = new ServicePoints($this);
        $this->webhooks = new Webhooks($this);
    }

    /**
     * @throws \Mvdnbrk\MyParcel\Exceptions\MyParcelException
     */
    public function performHttpCall(string $httpMethod, string $apiMethod, ?string $httpBody = null, array $requestHeaders = []): ResponseInterface
    {
        if (empty($this->apiKey)) {
            throw new MyParcelException('You have not set an API key. Please use setApiKey() to set the API key.');
        }

        $headers = collect([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.base64_encode($this->apiKey),
        ])
            ->when($httpBody !== null, function ($collection) {
                return $collection->put('Content-Type', 'application/json');
            })
            ->merge($requestHeaders)
            ->all();

        $request = new Request(
            $httpMethod,
            $this->apiEndpoint.'/'.$apiMethod,
            $headers,
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

    public function setApiKey(?string $value): self
    {
        $this->apiKey = trim($value);

        return $this;
    }
}
