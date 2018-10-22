Produkty
--------

priklad pouzitia:

```php
const API_ID  = '5275fe3ca57307bf8cecfb7b08a447c0';
const SECRET = 'ErYFgUCXWJeINyc89066ed90kcwr28ceta8s1t4a';

$api = new Kika\ApiClient\RestApi(API_ID, SECRET);
$api->setEndpoint('https://api-dev.fhb.sk/v3');

$products = new Kika\ApiClient\Products($api);
$uniqueId = uniqid();

$data = array(
    'id' => $uniqueId,
    'name' => 'Šampón',
    'ean' => '8580000001234',
    'photo_url' => 'http://example.com/image.png',
    'notify_url' => 'http://example.com/api/product/123/notify',
);

/**
 * Create new product
 */
try {
    $result = $products->create($data);
} catch (Kika\ApiClient\BadRequestException $e) {
    print_r($e->getViolations());
    exit;
}

print_r($result);

/**
 * Update product
 */
try {
    $result = $products->update($uniqueId, [
        'name' => 'Šampón XY',
        'ean' => '8580000001234',
        'photo_url' => 'http://example.com/new-image.png',
        'notify_url' => 'http://example.com/api/product/123/notify',
    ]);
} catch (Kika\ApiClient\BadRequestException $e) {
    print_r($e->getViolations());
    exit;
}

print_r($result);

/**
 * Read product
 */
$result = $products->read($uniqueId);

print_r($result);

/**
 * Read all products
 */
$result = $products->readAll();

print_r($result);
```

Objednavky
----------

priklad pouzitia:

```php
const API_ID  = '5275fe3ca57307bf8cecfb7b08a447c0';
const SECRET = 'ErYFgUCXWJeINyc89066ed90kcwr28ceta8s1t4a';

$api = new Kika\ApiClient\RestApi(API_ID, SECRET);
$api->setEndpoint('https://api-dev.fhb.sk/v3');

$orders = new Kika\ApiClient\Orders($api);
$uniqueId = uniqid();

$data = [
    'id' => $uniqueId,
    'variable_symbol' => '12345',
    'value' => 25,
    'recipient' => [
        'address' => [
            'name' => 'Martin Novák',
            'street' => 'Hronská 35',
            'city' => 'Zvolen',
            'zip' => '96001',
            'country' => 'sk'
        ],
        'contact' => [
            'phone' => '+421901000000',
            'email' => 'example@example.com'
        ]
    ],
    'items' => [
        [
            'id' => '12345',
            'quantity' => 1
        ]
    ]
];

/**
 * Create order
 */
try {
    $result = $orders->create($data);
}
catch (Kika\ApiClient\BadRequestException $e) {
    print_r($e->getViolations());
    exit;
}

print_r($result);

/**
 * Update order
 */

try {
    $data['recipient']['address']['name'] = 'Martina Nováková';
    $result = $orders->update($uniqueId, $data);
}
catch (Kika\ApiClient\BadRequestException $e) {
    print_r($e->getViolations());
    exit;
}

print_r($result);

/**
 * Read order
 */

try {
    $result = $orders->read($uniqueId);
}
catch (Kika\ApiClient\BadRequestException $e) {
    print_r($e->getViolations());
    exit;
}

print_r($result);

/**
 * Delete Order
 */

try {
    $result = $orders->delete($uniqueId);
}
catch (Kika\ApiClient\BadRequestException $e) {
    print_r($e->getViolations());
    exit;
}

print_r($result);
```
