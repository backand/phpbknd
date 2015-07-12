<?php
	
include('./vendor/nategood/httpful/bootstrap.php');

define('API_URL', 'https://api.backand.com:8080');
define('TOKEN_URL', API_URL . '/token');
define('REST_URL', 'https://api.backand.com:8078');
define('TABLE_URL', API_URL . '/1/table/config/');
define('COLUMNS_URL', API_URL . '/1/table/config/');

$email = 'kornatzky@me.com';
$password = 'secret';
$app_name = 'testsql';

// get token
$vars = array(  
	'username' => $email,
	'password' => $password,
	'appname' => $app_name,
	'grant_type' => 'password'
);	
$response = \Httpful\Request::post(TOKEN_URL)
    ->body(http_build_query($vars))
	->addHeader('Content-Type','application/x-www-form-urlencoded')
	->addHeader('charset', 'utf-8')
	->addHeader('Accept', 'application/json')
	->send();	

// retrieve the access token and token type
$access_token = $response->body->access_token;
$token_type = $response->body->token_type;

// get first page of rows in items table
$response = \Httpful\Request::get(REST_URL . '/1/objects/items?pageSize=20&pageNumber=1')
	->addHeader('Accept', 'application/json')
	->addHeader('Content-Type','application/json')
	->addHeader('Authorization', $token_type . ' ' . $access_token)
	->addHeader('AppName', $app_name)
	->send();	
	
// iterate and print the results
echo 'result' . PHP_EOL;
echo 'total_rows:' . $response->body->totalRows . PHP_EOL;
foreach ($response->body->data as $item) {
	echo $item->Id . ' ' . $item->name . ' ' . $item->description . PHP_EOL;
}

// create new row in items table
$vars = array(  
	'name' => 'Laptop',
	'description' => 'Mac Book Pro'
);
$response = \Httpful\Request::post(REST_URL . '/1/objects/items')
    ->body(json_encode($vars))
	->addHeader('Accept', 'application/json')
	->addHeader('Content-Type','application/json')
	->addHeader('Authorization', $token_type . ' ' . $access_token)
	->addHeader('AppName', $app_name)
	->send();

echo 'id of new row:' . $response->body->__metadata->id . PHP_EOL;

?>