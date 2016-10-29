<?php

namespace HeyHoo\MyParcel;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that send method returns true
     */
    public function testSendIsTrue()
    {
        $myparcel = new Client();
        $this->assertTrue($myparcel->send());
    }
}
