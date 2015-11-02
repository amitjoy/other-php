<?php

include '../../main.php';

try {
	
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_PUT);
	// $Client->useFopen(); // You can also use fopen for this
	$Client->setData(file_get_contents('source.txt'));
	$result = $Client->request('http://192.168.1.101:8080/Source/Projects/PHP/REST_CLIENT/src/Script/Examples/put/action.php');
	
} catch(Exception $e) {
	echo 'Problem catched.';
}