# Lazada - Open Platform

Library package to integrate Lazada Open Platform

### Prerequisites

- PHP >= 7.2
- Composer

### Installing

Make sure you have the correct PHP version and Composer installed. Then you can add the package from the command line:

```
composer require laz-vn/logistics-api
```

Or you can add directly to the `composer.json` file and then run the command `composer update`:

```
require {
    "laz-vn/logistics-api":"*"
}
```

Please remember to run `composer dump-autoload -o` to make sure the autolaod works properly.

## Documention

https://open.lazada.com/ - official documentation for Lazada Open Platform

## Environment Variables - .env

```
LAZADA_API_KEY=your_api_key #your api key from lazada open platform
LAZADA_API_SECRET=your_api_secret #your api secret from lazada open platform
LAZADA_API_URL=your_api_url #staging:https://api.lazada.vn/rest -  production:https://api.lazada.vn/rest
```

## Usage

```php
use LazApi\LogisticsService;

$api_key = getenv('LAZADA_API_KEY');
$api_secret = getenv('LAZADA_API_SECRET');
$api_url = getenv('LAZADA_API_URL');

$logistics = new LogisticsService($api_key, $api_secret, $api_url);
```

### [1.Mapping Seller Account to Lazada Open Platform Account](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fcustomers%2Fexternal_relationships_bundle)

```php
$parameters = [
    "platformName" => "your_platform_name(lazada provided)",
    "sellerId" => "your_seller_id(partner input)",
    "otp" => "your_otp(partner get from seller account https://logistics.lazada.vn)",
];

$response = $logistics->mappingSellerAccount($parameters);
```

### [2.Create Warehouse](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fcustomers%2Fwarehouses)

```php
$parameters = [
    "warehouseCode"=> "your_warehouse_code(partner input)",
    "platformName"=> "your_platform_name(lazada provided)",
    // get full parameters from https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fcustomers%2Fwarehouses
];

$response = $logistics->createWarehouse($parameters);
```

### [3. Get Delivery Options](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fservice%2Fdelivery_options)

```php
$parameters = [
    "externalOrderId"= "your_order_id(partner input)",
    // get full parameters from https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fservice%2Fdelivery_options
];
$response = $logistics->getDeliveryOptions($parameters);
```

### [4.Get Estimate Shipping Fee](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Festimate_shipping_fee)

API get estimate shipping fee is used to get the estimated shipping fee for a package

```php
$parameters = [
    "externalSellerId" => "your_seller_id(partner input)",
    ...
    // get full parameters from https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Festimate_shipping_fee
];
$response = $logistics->estimateShippingFee($parameters);
```

### [5.Package Creation](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages)

```php
$parameters = [
     "dangerousGood" => "false",
    "shipper" => [
        'externalSellerId' => 'your_seller_id(partner input)',
        'externalWarehouseCode' => 'your_warehouse_code(partner input)',
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
        'phone' => '1111111111',
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
    "externalOrderId" => "your_order_id(partner input)",
    "platformOrderCreationTime" => "timestamp of order creation(partner input)",
    "packageType" => "Sales_order|Return_order",
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
    ],
    "options" => [
        "directReturnToMerchant" => "false"
    ],
    // get full parameters from https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages
];

$response = $logistics->createPackage($parameters);
```

### [5.1 Package Consign](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Fconsign)

API Package Consign is used to consign a package

```php
    $parameters = [
        "dangerousGood"= "false",
        // get full parameters from https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Fconsign
    ]
    $response = $logistics->consignPackage($parameters);
```

### [5.2 Package Ready To Ship](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Frts)

API Package Ready To Ship is used to notify lazada that the package consigned is ready to ship

```php
    $parameters = [
        "trackingNumber"= "tracking_number pack",
    ]
    $response = $logistics->rtsPackage($parameters);
```

### [6.Print Airway Bill](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Fawb)

```php
$parameters = [
    "packageCode" => "your_package_code(partner input)",
    "type"=>"pdf",
];

$response = $logistics->printAwb($parameters);
```

### [6.1 Print Airway Bill v2](https://open.lazada.com/apps/doc/api?path=/logistics/epis/v2/packages/awb)

print awb v2 support multiple package code and tracking number

```php
$parameters = [
    "packageCodes" => "your_package_code(partner input)",
    "trackingNumbers" => "your_tracking_number(partner input)",
    "type"=>"pdf",
];
$response = $logistics->printAwbV2($parameters);
```

### [7.Package Cancel](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fpackages%2Fcancel)

```php
$parameters = [
    "packageCode" => "your_package_code(partner input)",
    "reason"=>"your_reason(partner input)",
];

$response = $logistics->cancelPackage($parameters);
```

### [8.Get Shipping Fee](https://open.lazada.com/apps/doc/api?path=%2Flogistics%2Fepis%2Fget_shipping_fee)

get shipping fee is used to get shipping fee an estimate and the actual for the package

```php
$parameters = [
    "externalSellerId" => "your_seller_id(partner input)",
    "platformName"= "your_platform_name(lazada provided)",
    "trackingNumber"= "your_tracking_number(partner input)",
];
$response = $logistics->getShippingFee($parameters);
```

## Error List

- otp expired: please check your otp and get new one from seller account

```json
{
  "type": "ISV",
  "code": "IllegalAccessToken",
  "message": "The specified access token is invalid or expired",
  "request_id": "2101567a17104988838493654"
}
```

- invalid signature: please check your api key and api secret

```json
{
  "type": "ISV",
  "code": "IncompleteSignature",
  "message": "The request signature does not conform to platform standards",
  "request_id": "210131d117090244906601493"
}
```

- ip not allowed: please provide your ip to lazada open platform to whitelist

```html
<a
  id="a-link"
  \r\n
  href="https://bixi.alicdn.com/punish/punish:resource:template:lazadaSpace:exefqahalk_33139279.html?qrcode=JLsKMoCLzMuA8mmIk6N75g|ZfWc8Q|MWrYXQ_0&uuid=24bb0a32808bcccb80f2698893a37be6&action=deny&origin=https%3A%2F%2Fapi-pre.lazada.vn%3A443%2Frest%2Flogistics%2Fepis%2Fpackages"
></a
>\r\n
<script>
  \r\n
  var host = location.host;\r\n
  var parts = host.split('.');\r\n
  if (parts.length > 2){\r\n
    host = parts.pop();\r\n
    host = "." + parts.pop() + "." + host;\r\n
  }\r\n
  var exp = new Date();\r\n
  var maxAge = -100;\r\n
  exp.setTime(exp.getTime() + maxAge);\r\n
  var cookie = "x5secdata=;maxAge=" + maxAge + ";expires=" + exp.toUTCString() + ";path=/;domain=" + host + ";";\r\n
  document.cookie = cookie;\r\n
  document.cookie = cookie + 'Secure;SameSite=None';\r\n
  document.getElementById("a-link").click();\r\n
  window._config_ = {\r\n
     "action": "deny",\r\n
     "url": "https://bixi.alicdn.com/punish/punish:resource:template:lazadaSpace:exefqahalk_33139279.html?qrcode=JLsKMoCLzMuA8mmIk6N75g|ZfWc8Q|MWrYXQ_0&uuid=24bb0a32808bcccb80f2698893a37be6&action=deny&origin=https%3A%2F%2Fapi-pre.lazada.vn%3A443%2Frest%2Flogistics%2Fepis%2Fpackages"\r\n
  };\r\n
</script>
```

## Languages

- PHP

## Versioning

```

Version 1.0.0

```

## License

(c) Lazada Vietnam

## Support

=======

```

```

```

```

```

```

```

```
