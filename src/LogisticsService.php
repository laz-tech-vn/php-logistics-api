<?php

namespace LazApi;

use LazApi\LazopClient;

class LogisticsService
{
    protected $client;

    public function __construct($appkey, $secretKey, $baseUrl)
    {
        $this->client = new LazopClient($appkey, $secretKey, $baseUrl);
    }
    /**
     * create package
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages
     */
    public function createPackage($params)
    {
        $endpoint = '/logistics/epis/packages';
        return $this->client->sendRequest($endpoint, $params, 'POST');
    }

    /**
     * Mapping seller account to open platform account
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fcustomers%2Fexternal_relationships_bundle
     */
    public function mappingSellerAccount($params)
    {
        $endpoint = '/logistics/epis/customers/external_relationships_bundle';
        return $this->client->sendRequest($endpoint, $params, 'POST');
    }

    /**
     * Create warehouse
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fcustomers%2Fwarehouses
     */
    public function createWarehouse($params)
    {
        $endpoint = '/logistics/epis/customers/warehouses';
        return $this->client->sendRequest($endpoint, $params, 'POST');
    }

    /**
     * Print AWB
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Fawb
     */
    public function printAwb($params)
    {
        $endpoint = '/logistics/epis/packages/awb';
        return $this->client->sendRequest($endpoint, $params, 'GET');
    }

    /**
     * cancel package
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Fcancel
     */
    public function cancelPackage($params)
    {
        $endpoint = '/logistics/epis/packages/cancel';
        return $this->client->sendRequest($endpoint, $params, 'POST');
    }

    /**
     * Get Delivery options
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fservice%2Fdelivery_options
     */
    public function getDeliveryOptions($params)
    {
        $endpoint = '/logistics/epis/service/delivery_options';
        return $this->client->sendRequest($endpoint, $params, 'GET');
    }

    /**
     * Estimate shipping fee
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Festimate_shipping_fee
     */
    public function estimateShippingFee($params)
    {
        $endpoint = '/logistics/epis/estimate_shipping_fee';
        return $this->client->sendRequest($endpoint, $params, 'GET');
    }

    /**
     * PackageConsignment
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Fconsign
     */
    public function consignPackage($params)
    {
        $endpoint = '/logistics/epis/packages/consign';
        return $this->client->sendRequest($endpoint, $params, 'POST');
    }

    /**
     * PackageInfoUpdate
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Fupdate
     */
    public function updatePackage($params)
    {
        $endpoint = '/logistics/epis/packages/update';
        return $this->client->sendRequest($endpoint, $params, 'POST');
    }
    /**
     * Package Ready To Shipped
     * @param $params
     * @return mixed
     * @document https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Frts
     */
    public function rtsPackage($params)
    {
        $endpoint = '/logistics/epis/packages/rts';
        return $this->client->sendRequest($endpoint, $params, 'POST');
    }
}
