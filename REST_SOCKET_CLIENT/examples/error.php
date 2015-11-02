<?php

include '../main.php';

try {
	$Client = new REST_CLIENT();
	$Client->useFopen();
	$Client->setMethod(REST_CLIENT::METHOD_GET);
	$result = $Client->request('http://404.php.net');
} catch(Exception $e) {
	
	// Get more information about the problem
	//print_r($Client->getErrors());

	// Get response headers
	//print_r($Client->getHeaders());
	
	// Show the user that the service is offline
	echo 'Service seems to be offline!';
}