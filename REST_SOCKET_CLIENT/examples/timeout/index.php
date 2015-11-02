<?php

include '../../main.php';

try {
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_GET);
	$Client->setTimeout(1);
	$result = $Client->request('[url to sleep script here]sleep.php');
} catch(Exception $e) {
	echo 'Request timeout';
}
