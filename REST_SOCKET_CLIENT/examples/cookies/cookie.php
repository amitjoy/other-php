<?php

include '../../main.php';

try {
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_GET);
	//$Client->useFopen(); // Also works with Fopen
	//$Client->addHeader(REST_CLIENT::HEADER_COOKIE, 'Variable1=Value1; Variable2=Value2;');	// String method
	$Client->addHeader(REST_CLIENT::HEADER_COOKIE, array('Variable1' => 'Value1', 'Variable2' => 'Value2')); // Array method
	$result = $Client->request('http://localhost/REST_SOCKET_CLIENT/examples/cookies/endpoint.php');
	echo $result;
} catch(Exception $e) {
	echo 'Service seems to be offline!';
}