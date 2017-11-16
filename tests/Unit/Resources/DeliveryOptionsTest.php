<?php

namespace Mvdnbrk\MyParcel\Tests\Unit\Resources;

use Mvdnbrk\MyParcel\Client;
use PHPUnit\Framework\TestCase;
use Mvdnbrk\MyParcel\Support\Collection;
use Mvdnbrk\MyParcel\Object\PickupLocation;
use Mvdnbrk\MyParcel\Resources\DeliveryOptions;
use Mvdnbrk\MyParcel\Exceptions\InvalidZipcodeException;
use Mvdnbrk\MyParcel\Exceptions\InvalidHousenumberException;

class DeliveryOptionsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $client = new Client;
        $client->setApiKey('test-api-key');

        $this->deliveryOptions = new DeliveryOptions($client);
    }

    /** @test */
    public function setting_a_valid_zipcode()
    {
        $this->deliveryOptions->setZipcode('1234AA');
        $this->assertEquals('1234AA', $this->deliveryOptions->zipcode);

        $this->deliveryOptions->setZipcode('1234 AA');
        $this->assertEquals('1234AA', $this->deliveryOptions->zipcode);

        $this->deliveryOptions->setZipcode(' 1234 AA ');
        $this->assertEquals('1234AA', $this->deliveryOptions->zipcode);

        $this->deliveryOptions->setZipcode('1234aa');
        $this->assertEquals('1234AA', $this->deliveryOptions->zipcode);
    }

   /** @test */
    public function setting_a_dutch_zipcode_sets_the_country_to_nl()
    {
        $this->deliveryOptions->setZipcode('1234AA');
        $this->assertEquals('NL', $this->deliveryOptions->getCountry());
    }

   /** @test */
    public function setting_a_belgian_zipcode_sets_the_country_to_be()
    {
        $this->deliveryOptions->setZipcode('2000');
        $this->assertEquals('BE', $this->deliveryOptions->getCountry());
    }

   /** @test */
    public function setting_in_invalid_zipcode_throws_exception()
    {
        $this->expectException(InvalidZipcodeException::class);
        $this->deliveryOptions->setZipcode('invalid-zipcode');
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

    /** @test */
    public function getting_delivery_options()
    {
        $this->assertTrue(true);
        $pickup = $this->deliveryOptions->get('1012NP', '2')->pickup->take(3);
        $this->assertInstanceOf(Collection::class, $pickup);
        $this->assertEquals(3, $pickup->count());
        $this->assertInstanceOf(PickupLocation::class, $pickup->first());
    }
}
