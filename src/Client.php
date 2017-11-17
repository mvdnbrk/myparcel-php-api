<?php

namespace Mvdnbrk\MyParcel;

use Mvdnbrk\MyParcel\Resources\DeliveryOptions;
use Mvdnbrk\MyParcel\Exceptions\MyParcelException;

class Client
{
    /**
     * Endpoint of the remote API.
     */
    const API_ENDPOINT = 'https://api.myparcel.nl';

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
     * @var \Mvdnbrk\Resources\DeliveryOptions
     */
    public $deliveryOptions;

    /**
     * Create a new MyParcel_API_Client Instance
     */
    public function __construct()
    {
        $this->deliveryOptions = new DeliveryOptions($this);
    }

    public function __destruct()
    {
        $this->closeTcpConnection();
    }

    private function closeTcpConnection()
    {
        if (is_resource($this->ch)) {
            curl_close($this->ch);
            $this->ch = null;
        }
    }

    public function getLastHttpResponseStatusCode()
    {
        return $this->last_http_response_status_code;
    }

    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null)
    {
        if (empty($this->apiKey)) {
            throw new MyParcelException("You have not set an API key. Please use setApiKey() to set the API key.");
        }

        if (empty($this->ch) || ! function_exists('curl_reset')) {
            $this->ch = curl_init();
        } else {
            curl_reset($this->ch);
        }

        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $httpMethod);
        curl_setopt($this->ch, CURLOPT_URL, $this->apiEndpoint . "/" . $apiMethod);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_ENCODING, "");

        $request_headers = [
            "Accept: application/json",
            "Authorization: Bearer {$this->apiKey}",
        ];

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
            $this->closeTcpConnection();
            throw new MyParcelException('Unable to communicate with MyParcel');
        }

        if (! function_exists("curl_reset")) {
            $this->closeTcpConnection();
        }

        return $body;
    }

    public function setApiKey($value)
    {
        $this->apiKey = $value;
    }
}
