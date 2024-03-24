<?php

namespace LazApi;

use PHPUnit\Framework\TestCase;
use LazApi\LazopClient;

class PackageCreatetionTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->client = new LazopClient($_ENV['APP_KEY'], $_ENV['SECRET_KEY'], $_ENV['BASE_URL']);
    }
}
