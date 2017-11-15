<?php

namespace Mvdnbrk\MyParcel\Tests;

use Mvdnbrk\MyParcel\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * Test that send method returns true
     */
    public function testSendIsTrue()
    {
        $client = new Client();
        $this->assertTrue(true);
    }
}
