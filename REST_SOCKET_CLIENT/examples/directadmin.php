<?php

include '../main.php';

try {
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_GET); // This is not required because the default method is GET
	//$Client->useFopen(); // Also works with Fopen
	$Client->addHeader(REST_CLIENT::HEADER_CUSTOMREQUEST, 'GET /CMD_API_SHOW_USERS? HTTP/1.0');
	$Client->addHeader(REST_CLIENT::HEADER_AUTHORIZATION, 'Basic ' . base64_encode('[username]:[password]'));
	$result = $Client->request('[direct admin url]:2222', REST_CLIENT::CONTENT_QUERYSTRING);
	
	print_r($result);
	
} catch(Exception $e) {
	echo 'Can\'t connect to DirectAdmin!';
}