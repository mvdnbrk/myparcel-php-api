<?php

namespace Mvdnbrk\MyParcel\Tests\Unit\Endpoints;

use Mvdnbrk\MyParcel\Tests\TestCase;
use Mvdnbrk\MyParcel\Endpoints\BaseEndpoint;
use Mvdnbrk\MyParcel\Exceptions\MyParcelException;

class BaseEndpointTest extends TestCase
{
    /** @test */
    public function passing_an_empty_array_to_build_query_string_should_return_an_empty_string()
    {
        $endpoint = new BaseEndpointStub($this->client);

        $this->assertEquals('', $endpoint->buildQueryString([]));
    }

    /** @test */
    public function performing_a_request_to_a_non_existent_endpoint_should_throw_an_error()
    {
        $this->expectException(MyParcelException::class);
        $this->expectExceptionMessage('Error executing API call (3105)');

        $endpoint = new BaseEndpointStub($this->client);

        $response = $endpoint->performApiCall('GET', 'non-existent');
    }
}

class BaseEndpointStub extends BaseEndpoint
{
    public function buildQueryString(array $filters)
    {
        return parent::buildQueryString($filters);
    }

    public function performApiCall($httpMethod, $apiMethod, $httpBody = null, $requestHeaders = [])
    {
        return parent::performApiCall($httpMethod, $apiMethod, $httpBody = null, $requestHeaders = []);
    }
}
