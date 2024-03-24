<?php

namespace LazApi;

use PHPUnit\Framework\TestCase;
use LazApi\LazopClient;
use Dotenv\Dotenv;

class ClientTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        $dotenv =  Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->client = new LazopClient($_ENV['APP_KEY'], $_ENV['SECRET_KEY'], $_ENV['BASE_URL']);
    }

    public function testSendRequest()
    {
        $endpoint = '/logistics/epis/packages';
        $params = [
            "dangerousGood" => "false",
            "shipper" => [
                'externalSellerId' => 'Q123',
                'externalWarehouseCode' => 'WH02'
            ],
            "dimWeight" => [
                'length' => '10',
                'width' => '10',
                'weight' => '100',
                'height' => '5'
            ],
            "origin" => [
                'address' => [
                    'details' => 'Test quận 2',
                    'id' => 'R7346817'
                ],
                'phone' => '0366452565',
                'name' => 'Kho mặc định',
                'email' => 'teat@gmail.com'
            ],
            "destination" => [
                'address' => [
                    'details' => 'Phường Mai dịch',
                    'id' => 'R80199163',
                    'type' => 'home'
                ],
                'phone' => '0366452565',
                'name' => 'huy huy',
                'email' => 'teat@gmail.com'
            ],
            "payment" => [
                'totalAmount' => '234535',
                'currency' => 'VND',
                'paymentType' => 'COD'
            ],
            "externalOrderId" => "TEST80333111111213VNT",
            "platformOrderCreationTime" => "1680161485000",
            "packageType" => "Sales_order",
            "deliveryOption" => "standard",
            "items" => [
                [
                    'unitPrice' => '200000',
                    'quantity' => '1',
                    'name' => 'Áo thun nam thời trang',
                    'id' => '10887094399',
                    'sku' => 'SP701',
                    'paidPrice' => '200000'
                ],
                [
                    'unitPrice' => '34535',
                    'quantity' => '1',
                    'name' => 'áo TOP Nam đẹp',
                    'id' => 'AA66',
                    'sku' => '1',
                    'paidPrice' => '34535'
                ]
            ],
            "options" => ["directReturnToMerchant" => "false"],
        ];
        $method = 'POST';
        $actualResponse = $this->client->sendRequest($endpoint, $params, $method);
        $this->assertIsArray($actualResponse);
        $this->assertArrayHasKey('data', $actualResponse);
        $this->assertTrue($actualResponse['success']);
    }
}
