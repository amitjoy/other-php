<?php
require_once "../../main.php";
$client = new REST_CLIENT();
$client->setMethod(REST_CLIENT::METHOD_GET);
$headers = array("CURLOPT_USERAGENT"=>"Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5",
			"CURLOPT_HTTPHEADER"=>Array("Content-Type: application/x-www-form-urlencoded","Accept: */*"),
			"CURLOPT_POST"=>TRUE,"CURLOPT_FOLLOWLOCATION"=>TRUE,
			"CURLOPT_RETURNTRANSFER"=>TRUE,
			"CURLOPT_AUTOREFERER"=>true,
			"CURLOPT_SSL_VERIFYPEER"=>false,
			"CURLOPT_MAXREDIRS"=>0
			);
foreach($headers as $k=>$v)
{
	$client->addHeader($k, $v);
}
$url = "http://wwwa.way2sms.com/jsp/logout.jsp";
$result = $client->request($url,REST_CLIENT::CONTENT_PLAIN);
print_r($result);