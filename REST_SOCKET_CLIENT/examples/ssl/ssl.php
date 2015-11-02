<?php

include '../../main.php';

try {
	
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_GET);
	$Client->useCertificate(str_replace('\\', '/', getcwd()) . '/cacert.pem');
	$result = $Client->request('https://mobilevikings.com/api/1.0/doc/');
	echo $result;
	
} catch(Exception $e) {
	print_r($Client->getErrors());
	echo 'Problems with service.';
}