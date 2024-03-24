<?php

namespace LazApi;

use \Exception;

class LazopClient
{
    public $baseUrl;

    public $appkey;

    public $secretKey;

    public $signMethod = 'sha256';

    public function __construct($appkey, $secretKey, $baseUrl)
    {
        $this->appkey = $appkey;
        $this->secretKey = $secretKey;
        $this->baseUrl = $baseUrl;
    }
    /**
     * generate sign
     * @param $endpoint
     * @param $params
     * @return string
     */
    public function generateSign($endpoint, $mergerParams)
    {
        ksort($mergerParams);
        $mergerParams = array_map(function ($value) {
            return is_array($value) ? json_encode($value) : $value;
        }, $mergerParams);
        $stringToBeSigned = array_reduce(array_keys($mergerParams), function ($carry, $key) use ($mergerParams) {
            return $carry . $key . $mergerParams[$key];
        }, $endpoint);
        return strtoupper(hash_hmac($this->signMethod, $stringToBeSigned, $this->secretKey));
    }

    /**
     * generate url
     * @param $params
     * @return string
     * @return string
     */
    public function generateUrl($endpoint, $query)
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/') . '?' . $query;
    }

    /**
     * send request
     * @param $url
     * @param $params
     * @return mixed
     */
    public function sendRequest($endpoint, $params, $method = 'POST')
    {
        // format params
        $params = array_map(function ($value) {
            return is_array($value) ? json_encode($value) : $value;
        }, $params);
        // system params
        $systemParams = [
            'app_key' => $this->appkey,
            'sign_method' => $this->signMethod,
            'timestamp' => round(microtime(true) * 1000),
        ];
        // generate sign
        $systemParams['sign'] = $this->generateSign($endpoint, array_merge($params, $systemParams));
        // query
        $query = http_build_query($systemParams);
        if ($method === 'GET' && !empty($params)) {
            $query = http_build_query(array_merge($params, $systemParams));
        }
        //generate url
        $url = $this->generateUrl($endpoint, $query);
        // send request
        return $this->curl($url, $params, $method);
    }


    /**
     * curl 
     * @param $url
     * @param $params
     * @param string $method
     * @param array $header
     * @return mixed
     */
    public function curl($url, $params, $method = 'POST', $headers = [])
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => json_encode($params),
                CURLOPT_HTTPHEADER => array_merge(
                    array('Content-Type: application/json'),
                    $headers
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($response === false) {
                throw new Exception(curl_error($curl), curl_errno($curl));
            }

            curl_close($curl);
            if ($httpcode >= 200 && $httpcode < 300) {
                if (empty($response)) {
                    return [];
                }
                if (json_decode($response, true) === null) {
                    return $response;
                }
                return json_decode($response, true);
            } else {
                // Handle non-2xx responses if needed
                return json_decode($response, true);
            }
        } catch (Exception $e) {
            // Handle errors like connection errors, timeouts, etc.
            return $e;
        }
    }
}
