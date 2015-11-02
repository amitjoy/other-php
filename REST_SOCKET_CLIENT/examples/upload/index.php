<?php

include '../../main.php';

try {
	
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_POST);
	$Client->addParam('file', "@" . dirname(__FILE__) . "/test.txt");
	$result = $Client->request('[the url to the action file here]action.php');
	
	print_r($result);
	
} catch(Exception $e) {
	echo 'Problem catched.';
}