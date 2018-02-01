Produkty
--------

priklad pouzitia:

```php

use Kika\Api\RestApi;
use Kika\Api\Products;
use Kika\Api\RestApiException;


const API_ID  = '5275fe3ca57307bf8cecfb7b08a447c0';
const SECRET = 'ErYFgUCXWJeINyc89066ed90kcwr28ceta8s1t4a';

$api = new RestApi(API_ID, SECRET);
//$api->setEndpoint('https://system-dev.fhb.sk/api/v2'); // if you want to connect to DEV, uncomment this line
$products = new Products($api);


$uniqueId = '123456';

$data = array(
	'id' => $uniqueId,
	'name' => 'Šampón',
	'ean' => '8580000001234',
	'photoUrl' => 'http://example.com/image.png',
	'notifyLink' => '"http://example.com/api/product/123/notify',
);


try {

	//create
	$result = $products->create($data);
	echo '<pre>';
	print_r($result);
	echo '</pre>';

	//update
	$data['name'] = 'Šampón updated';
	$result = $products->update($uniqueId, $data);
	echo '<pre>';
	print_r($result);
	echo '</pre>';

	//read
	$result = $products->read($uniqueId);
	echo '<pre>';
	print_r($result);
	echo '</pre>';

	//readAll
	$result = $products->readAll();
	echo '<pre>';
	print_r($result);
	echo '</pre>';


} catch (RestApiException $e) {
	die($e->getMessage());
}

```

Objednavky
----------

priklad pouzitia:

```php

use Kika\Api\RestApi;
use Kika\Api\Orders;
use Kika\Api\RestApiException;


const API_ID  = '5275fe3ca57307bf8cecfb7b08a447c0';
const SECRET = 'ErYFgUCXWJeINyc89066ed90kcwr28ceta8s1t4a';


$api = new RestApi(API_ID, SECRET);
//$api->setEndpoint('https://system-dev.fhb.sk/api/v2'); // if you want to connect to DEV, uncomment this line
$orders = new Orders($api);


$uniqueId = '123456';

$data = array(
	'id' => $uniqueId,
	'name' => 'Martin Novák',
	'street' => 'Hronská 35',
	'city' => 'Zvolen',
	'psc' => '96001',
	'country' => 'sk',
	'email' => 'email@example.com',
	'phone' => '00421900123456',
	'variableSymbol' => '588988552',
	'cod' => '54.98',
	'note' => 'poznamka',
	'_embedded' => array(
		'items' =>  array(
			array(
				'id' => '123456',
				'qty' => 3,
			),
			array(
				'id' => '1234567',
				'qty' => 4,
			),
		),

		'notifyLinks' => array(
			array(
				'confirmed' => 'http://example.com/api/order/123/confirm',
				'sent' => 'http://example.com/api/order/123/sent',
				'delivered' => 'http://example.com/api/order/123/delivered',
				'returned' => 'http://example.com/api/order/123/returned',
			),
		)
	),
);


try {

	//create
	$result = $orders->create($data);
	echo '<pre>';
	print_r($result);
	echo '</pre>';

	//update
	$data['name'] = 'Martin Novák updated';
	$result = $orders->update($uniqueId, $data);
	echo '<pre>';
	print_r($result);
	echo '</pre>';

	//read
	$result = $orders->read($uniqueId);
	echo '<pre>';
	print_r($result);
	echo '</pre>';

	//delete
	$result = $orders->delete($uniqueId);
	echo '<pre>';
	print_r($result);
	echo '</pre>';


} catch (RestApiException $e) {
	die($e->getMessage());
}


```
