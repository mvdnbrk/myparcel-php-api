<?php

namespace Mvdnbrk\MyParcel\Tests;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Exception\InvalidPathException;
use Mvdnbrk\MyParcel\Client;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var \Mvdnbrk\MyParcel\Client */
    protected $client;

    protected function setUp(): void
    {
        try {
            (Dotenv::createUnsafeImmutable(__DIR__.'/..'))->load();
        } catch (InvalidPathException $e) {
            //
        } catch (InvalidFileException $e) {
            exit('The environment file is invalid: '.$e->getMessage());
        }

        $this->client = (new Client)->setApiKey(getenv('API_KEY'));

        parent::setUp();
    }
}
