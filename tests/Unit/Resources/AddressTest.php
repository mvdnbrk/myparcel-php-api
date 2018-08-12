<?php

namespace Mvdnbrk\MyParcel\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mvdnbrk\MyParcel\Resources\Address;

class AddressTest extends TestCase
{
    private function validParams($overrides = [])
    {
        return array_merge([
            'street' => 'Poststraat',
            'number' => '1',
            'number_suffix' => 'A',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'region' => 'Noord-Holland',
            'cc' => 'NL',
        ], $overrides);
    }

    /** @test */
    public function creating_a_valid_address_resource()
    {
        $address = new Address([
            'street' => 'Poststraat',
            'number' => '1',
            'number_suffix' => 'A',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'region' => 'Noord-Holland',
            'cc' => 'NL',
        ]);

        $this->assertEquals('Poststraat', $address->street);
        $this->assertEquals('1', $address->number);
        $this->assertEquals('A', $address->number_suffix);
        $this->assertEquals('1234AA', $address->postal_code);
        $this->assertEquals('Amsterdam', $address->city);
        $this->assertEquals('Noord-Holland', $address->region);
        $this->assertEquals('NL', $address->cc);
    }

    /** @test */
    public function country_code_may_be_used_as_an_alias_to_cc()
    {
        $address = new Address([
            'country_code' => 'NL'
        ]);

        $this->assertEquals('NL', $address->cc);
    }

    /** @test */
    public function zipcode_may_be_used_as_an_alias_to_postal_code()
    {
        $address = new Address([
            'zipcode' => '9999ZZ'
        ]);

        $this->assertEquals('9999ZZ', $address->postal_code);
    }

    /** @test */
    public function lower_case_country_code_is_converted_to_uppercase()
    {
        $address = new Address($this->validParams([
            'cc' => 'nl'
        ]));

        $this->assertEquals('NL', $address->cc);
    }

    /** @test */
    public function lower_case_postal_code_is_converted_to_uppercase()
    {
        $address = new Address($this->validParams([
            'postal_code' => '1234aa'
        ]));

        $this->assertEquals('1234AA', $address->postal_code);
    }
}
