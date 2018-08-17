<?php

namespace Mvdnbrk\MyParcel;

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
     * @var resource
     */
    protected $ch;

    /**
     * @var int
     */
    protected $last_http_response_status_code;

    /**
     * @var \Mvdnbrk\MyParcel\Endpoints\DeliveryOptions
     */
    public $deliveryOptions;

    /**
     * @var \Mvdnbrk\MyParcel\Endpoints\Shipments
     */
    public $shipments;

    /**
     * Create a new Client Instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->shipments = new Shipments($this);
        $this->deliveryOptions = new DeliveryOptions($this);
    }

    /**
     * Desctructs the Cliemt instance.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->closeTcpConnection();
    }

    /**
     * C;pses the tcp connection.
     *
     * @return void
     */
    private function closeTcpConnection()
    {
        if (is_resource($this->ch)) {
            curl_close($this->ch);
            $this->ch = null;
        }
    }

    /**
     * Gets the last http response code.
     *
     * @return int
     */
    public function getLastHttpResponseStatusCode()
    {
        return $this->last_http_response_status_code;
    }

    /**
     * Performs a HTTP call to the API endpoint
     *
     * @param  string  $httpMethod          The method to make the API call. GET/POST etc,
     * @param  string  $apiMethod           The API method to call at the endpoint.
     * @param  string|null  $httpBody       The body to be send with te request.
     * @param  array  $requestHeaders       Request headers to be send with the request.
     * @return object                       The body of the repsone.
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null, $requestHeaders = [])
    {
        if (empty($this->apiKey)) {
            throw new MyParcelException("You have not set an API key. Please use setApiKey() to set the API key.");
        }

        if (empty($this->ch)) {
            $this->ch = curl_init();
        } else {
            curl_reset($this->ch);
        }

        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $httpMethod);
        curl_setopt($this->ch, CURLOPT_URL, $this->apiEndpoint . "/" . $apiMethod);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_ENCODING, "");

        $request_headers = array_merge([
            'User-Agent: CustomApiCall/2',
            'Accept: application/json',
            'Authorization: Basic '.base64_encode($this->apiKey),
        ], $requestHeaders);

        if ($httpBody !== null) {
            $request_headers[] = "Content-Type: application/json";
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $httpBody);
        }

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, true);

        $body = curl_exec($this->ch);

        $this->last_http_response_status_code = (int) curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        if (curl_errno($this->ch)) {
            throw new MyParcelException('Unable to communicate with MyParcel:'.curl_error($this->ch));
        }

        return $body;
    }

    /**
     * Sets the API key.
     *
     * @param string  $value
     * @return void
     */
    public function setApiKey($value)
    {
        $this->apiKey = $value;
    }
}
