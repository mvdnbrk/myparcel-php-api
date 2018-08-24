<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use Mvdnbrk\MyParcel\Resources\Recipient;

class RecipientTest extends TestCase
{
    private function validParams($overrides = [])
    {
        return array_merge([
            'company' => 'Test Company B.V.',
            'person' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '0101111111',
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
    public function creating_a_valid_recipient_resource()
    {
        $recipient = new Recipient([
            'company' => 'Test Company B.V.',
            'person' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '0101111111',
            'street' => 'Poststraat',
            'number' => '1',
            'number_suffix' => 'A',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'region' => 'Noord-Holland',
            'cc' => 'NL',
        ]);

        $this->assertEquals('Test Company B.V.', $recipient->company);
        $this->assertEquals('John Doe', $recipient->person);
        $this->assertEquals('john@example.com', $recipient->email);
        $this->assertEquals('0101111111', $recipient->phone);
        $this->assertEquals('1', $recipient->number);
        $this->assertEquals('A', $recipient->number_suffix);
        $this->assertEquals('1234AA', $recipient->postal_code);
        $this->assertEquals('Amsterdam', $recipient->city);
        $this->assertEquals('Noord-Holland', $recipient->region);
        $this->assertEquals('NL', $recipient->cc);
    }

    /** @test */
    public function country_code_may_be_used_as_an_alias_to_cc()
    {
        $recipient = new Recipient([
            'country_code' => 'NL'
        ]);

        $this->assertEquals('NL', $recipient->cc);
    }

    /** @test */
    public function zipcode_may_be_used_as_an_alias_to_postal_code()
    {
        $recipient = new Recipient([
            'zipcode' => '9999ZZ'
        ]);

        $this->assertEquals('9999ZZ', $recipient->postal_code);
    }

    /** @test */
    public function lower_case_country_code_is_converted_to_uppercase()
    {
        $recipient = new Recipient($this->validParams([
            'cc' => 'nl'
        ]));

        $this->assertEquals('NL', $recipient->cc);
    }

    /** @test */
    public function lower_case_postal_code_is_converted_to_uppercase()
    {
        $recipient = new Recipient($this->validParams([
            'postal_code' => '1234aa'
        ]));

        $this->assertEquals('1234AA', $recipient->postal_code);
    }

    /** @test */
    public function number_should_be_casted_to_a_string()
    {
        $recipient = new Recipient($this->validParams([
            'number' => 999
        ]));

        $array = $recipient->toArray();

        $this->assertInternalType('string', $array['number']);
        $this->assertEquals('999', $array['number']);
    }
}
