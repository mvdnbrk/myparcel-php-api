<?php

namespace Mvdnbrk\MyParcel\Tests\Feature\Endpoints;

use Illuminate\Support\Collection;
use Mvdnbrk\MyParcel\Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\ServicePoint;
use Mvdnbrk\MyParcel\Endpoints\ServicePoints;
use Mvdnbrk\MyParcel\Exceptions\InvalidPostalCodeException;
use Mvdnbrk\MyParcel\Exceptions\InvalidHousenumberException;

class ServicePointsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->servicePoints = new ServicePoints($this->client);
    }

    /** @test */
    public function setting_a_valid_postal_code()
    {
        $this->servicePoints->setPostalCode('1234AA');
        $this->assertEquals('1234AA', $this->servicePoints->postal_code);

        $this->servicePoints->setPostalCode('1234 AA');
        $this->assertEquals('1234AA', $this->servicePoints->postal_code);

        $this->servicePoints->setPostalCode(' 1234 AA ');
        $this->assertEquals('1234AA', $this->servicePoints->postal_code);

        $this->servicePoints->setPostalCode('1234aa');
        $this->assertEquals('1234AA', $this->servicePoints->postal_code);
    }

    /** @test */
    public function setting_a_dutch_postal_code_sets_the_country_to_nl()
    {
        $this->servicePoints->setPostalCode('1234AA');
        $this->assertEquals('NL', $this->servicePoints->getCountry());
    }

    /** @test */
    public function setting_a_belgian_postal_code_sets_the_country_to_be()
    {
        $this->servicePoints->setPostalCode('2000');
        $this->assertEquals('BE', $this->servicePoints->getCountry());
    }

    /** @test */
    public function setting_in_invalid_postal_code_throws_an_exception()
    {
        $this->expectException(InvalidPostalCodeException::class);
        $this->servicePoints->setPostalCode('invalid-zipcode');
    }

    /** @test */
    public function setting_a_valid_housenumber()
    {
        $this->servicePoints->setHousenumber('1');
        $this->assertEquals('1', $this->servicePoints->housenumber);
    }

    /** @test */
    public function setting_a_valid_housenumber_removes_a_suffix()
    {
        $this->servicePoints->setHousenumber('1A');
        $this->assertEquals('1', $this->servicePoints->housenumber);

        $this->servicePoints->setHousenumber('1 A');
        $this->assertEquals('1', $this->servicePoints->housenumber);
    }

    /** @test */
    public function setting_an_invalid_housenumber_throws_exception()
    {
        $this->expectException(InvalidHousenumberException::class);
        $this->servicePoints->setHousenumber('not-a-number');
    }

    /**
     * @test
     * @group integration
     */

    /** @test */
    public function it_can_retrieve_delivery_options()
    {
        $locations = $this->servicePoints->setPostalcode('1012NP')->setHousenumber('2')->get()->take(2);

        $this->assertInstanceOf(\Tightenco\Collect\Support\Collection::class, $locations);
        $this->assertEquals(2, $locations->count());
        $this->assertInstanceOf(ServicePoint::class, $locations->first());
        $this->assertInstanceOf(ServicePoint::class, $locations->last());
        $this->assertIsArray($locations->first()->opening_hours);
    }
}
