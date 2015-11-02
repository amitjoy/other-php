<?php

require_once "../main.php";

try {
	
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_POST);
	$Client->useFopen();
	$Client->setData(xmlrpc_encode_request("wp.getPages", array(1, '[username]', '[password]')));
	$result = $Client->request('http://neogenlabs.com/wordpress/xmlrpc.php', REST_CLIENT::CONTENT_XMLRPC);
	explore($result);
	echo '<ul>';
	foreach($result as $page) {
		echo '<li>' . $page['title'] . '</li>';
	}
	echo '</ul>';
	
} catch(Exception $e) {
	echo 'Problems with freshbooks.';
}