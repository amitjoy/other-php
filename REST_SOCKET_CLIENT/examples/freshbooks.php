<?php
require_once "../main.php";

try {
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_POST);
	$Client->addHeader(REST_CLIENT::HEADER_AUTHORIZATION, '[your api key]');
	$Client->setData('<?xml version="1.0" encoding="utf-8"?>  
<request method="invoice.list">  
</request>');
	$result = $Client->request('https://[username].freshbooks.com/api/2.1/xml-in', REST_CLIENT::CONTENT_XML);
	
	echo '<ul>';
	foreach($result->invoices->invoice as $invoice) {
		echo '<li>' . $invoice->invoice_id . ': ' . $invoice->organization . ' (' . $invoice->status . ')</li>';
	}
	echo '</ul>';
	
} catch(Exception $e) {
	echo 'Problems with freshbooks.';
}