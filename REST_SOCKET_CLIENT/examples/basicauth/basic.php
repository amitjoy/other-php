<?php

include '../../main.php';

try {
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_GET);
	$Client->useFopen(); // Also works with Fopen
	$Client->addHeader(REST_CLIENT::HEADER_AUTHORIZATION, 'Basic ' . base64_encode('admin:tester'));
	$result = $Client->request('http://localhost/REST/Examples/basicauth/secured/index.html');
	echo $result;
} catch(Exception $e) {
	echo 'Your username/password combination seems to be wrong!';
}