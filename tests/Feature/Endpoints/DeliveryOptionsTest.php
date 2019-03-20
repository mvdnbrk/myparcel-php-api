<?php

namespace Mvdnbrk\MyParcel\Tests\Feature\Endpoints;

use Illuminate\Support\Collection;
use Mvdnbrk\MyParcel\Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\PickupLocation;
use Mvdnbrk\MyParcel\Endpoints\DeliveryOptions;
use Mvdnbrk\MyParcel\Exceptions\InvalidPostalCodeException;
use Mvdnbrk\MyParcel\Exceptions\InvalidHousenumberException;

class DeliveryOptionsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->deliveryOptions = new DeliveryOptions($this->client);
    }

    /** @test */
    public function setting_a_valid_postal_code()
    {
        $this->deliveryOptions->setPostalCode('1234AA');
        $this->assertEquals('1234AA', $this->deliveryOptions->postal_code);

        $this->deliveryOptions->setPostalCode('1234 AA');
        $this->assertEquals('1234AA', $this->deliveryOptions->postal_code);

        $this->deliveryOptions->setPostalCode(' 1234 AA ');
        $this->assertEquals('1234AA', $this->deliveryOptions->postal_code);

        $this->deliveryOptions->setPostalCode('1234aa');
        $this->assertEquals('1234AA', $this->deliveryOptions->postal_code);
    }

    /** @test */
    public function setting_a_dutch_postal_code_sets_the_country_to_nl()
    {
        $this->deliveryOptions->setPostalCode('1234AA');
        $this->assertEquals('NL', $this->deliveryOptions->getCountry());
    }

    /** @test */
    public function setting_a_belgian_postal_code_sets_the_country_to_be()
    {
        $this->deliveryOptions->setPostalCode('2000');
        $this->assertEquals('BE', $this->deliveryOptions->getCountry());
    }

    /** @test */
    public function setting_in_invalid_postal_code_throws_an_exception()
    {
        $this->expectException(InvalidPostalCodeException::class);
        $this->deliveryOptions->setPostalCode('invalid-zipcode');
    }

    /** @test */
    public function setting_a_valid_housenumber()
    {
        $this->deliveryOptions->setHousenumber('1');
        $this->assertEquals('1', $this->deliveryOptions->housenumber);
    }

    /** @test */
    public function setting_a_valid_housenumber_removes_a_suffix()
    {
        $this->deliveryOptions->setHousenumber('1A');
        $this->assertEquals('1', $this->deliveryOptions->housenumber);

        $this->deliveryOptions->setHousenumber('1 A');
        $this->assertEquals('1', $this->deliveryOptions->housenumber);
    }

    /** @test */
    public function setting_an_invalid_housenumber_throws_exception()
    {
        $this->expectException(InvalidHousenumberException::class);
        $this->deliveryOptions->setHousenumber('not-a-number');
    }

    /**
     * @test
     * @group integration
     */
    public function it_can_retrieve_delivery_options()
    {
        $locations = $this->deliveryOptions->get('1012NP', '2')->take(2);

        $this->assertInstanceOf(\Tightenco\Collect\Support\Collection::class, $locations);
        $this->assertEquals(2, $locations->count());
        $this->assertInstanceOf(PickupLocation::class, $locations->first());
        $this->assertInstanceOf(PickupLocation::class, $locations->last());
    }
}
