<?php 

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

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, TOKEN_URL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($vars));   
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, 
	array(
		'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
		'Accept: application/json'
	)
);
$server_output = curl_exec ($ch);
curl_close ($ch);
$server_output_json = json_decode($server_output);

// retrieve the access token and token type
$access_token = $server_output_json->access_token;
$token_type = $server_output_json->token_type;


// get first page of rows in items table
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, REST_URL . '/1/objects/items?pageSize=20&pageNumber=1');
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, 
	array(
		'Accept: application/json', 
		'Content-Type: application/json',
		'Authorization: ' . $token_type . ' ' . $access_token,
		'AppName: ' . $app_name
	)
);
$server_output = curl_exec ($ch);
curl_close ($ch);
$server_output_json = json_decode($server_output);

// iterate and print the results
echo 'result' . PHP_EOL;
echo 'total_rows:' . $server_output_json->totalRows . PHP_EOL;
foreach ($server_output_json->data as $item) {
	echo $item->Id . ' ' . $item->name . ' ' . $item->description . PHP_EOL;
}

// create new row in items table
$vars = array(  
	'name' => 'Laptop',
	'description' => 'Mac Book Pro'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, REST_URL . '/1/objects/items');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($vars));   
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, 
	array(
		'Content-Type: application/json',
		'Accept: application/json',
		'Authorization: ' . $token_type . ' ' . $access_token,
		'AppName: ' . $app_name
	)
);
$server_output = curl_exec ($ch);
curl_close ($ch);
$server_output_json = json_decode($server_output);

echo 'id of new row:' . $server_output_json->__metadata->id . PHP_EOL;

?>