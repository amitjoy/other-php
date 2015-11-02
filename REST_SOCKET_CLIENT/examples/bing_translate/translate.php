<?php

require_once "../../main.php";

define("BING_API","B91795CF2EB537EC1694547C3B1A4CCE00790E52");
	
$Client = new REST_CLIENT();
$Client->setMethod(REST_CLIENT::METHOD_GET);

//$data = (file_get_contents("C:\\xampp\\htdocs\\REST_SOCKET_CLIENT\\examples\\gtranslate\\am.log"));
$data = "espana";
//$Client->addHeader("CURLOPT_PROXY", "172.16.1.11:3128");

$params = array(
		"Sources"=>"Translation",
		"Translation.SourceLanguage"=>"Es",
		"Translation.TargetLanguage"=>"en",
		"Query"=>($data)
		);
foreach($params as $key=>$value)
{
	$Client->addParam($key, $value);
	}
		
$result = $Client->request('http://api.bing.net/json.aspx?AppId='.BING_API, REST_CLIENT::CONTENT_JSON);
$reply = $result->SearchResponse->Translation->Results[0]->TranslatedTerm;
echo ($reply);