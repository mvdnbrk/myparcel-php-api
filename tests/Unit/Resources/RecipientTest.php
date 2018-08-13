<?php

namespace Mvdnbrk\MyParcel\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Mvdnbrk\MyParcel\Resources\Recipient;
use Mvdnbrk\MyParcel\Exceptions\JsonEncodingException;

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
    public function encoding_malformed_json_throws_an_exception()
    {
        $this->expectException(JsonEncodingException::class);
        $this->expectExceptionMessage('Error encoding resource [Mvdnbrk\MyParcel\Resources\Recipient] to JSON: Malformed UTF-8 characters, possibly incorrectly encoded');

        $obj = new \stdClass;
        $obj->foo = "b\xF8r";

        $recipient = new Recipient($this->validParams([
            'person' => $obj
        ]));

        $recipient->toJson();
    }
}
