<?php
ini_set("max_execution_time",18000);
require_once "../../main.php";

define("BING_API","B91795CF2EB537EC1694547C3B1A4CCE00790E52");
	
$Client = new REST_CLIENT();
$Client->setMethod(REST_CLIENT::METHOD_GET);
$Client->setTimeout = 18000;
$no = range(5717,5938);
$files = array();
foreach($no as $v)
{
array_push($files,"C:\\xampp\\htdocs\\REST_SOCKET_CLIENT\\examples\\gtranslate\\file\\"."AMIT"."_".$v.".log");
}
//explore($files);
foreach($files as $file)
{	
	$data = file_get_contents($file);
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

//explore($result);
$reply = $result->SearchResponse->Translation->Results[0]->TranslatedTerm;
$reply .= "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||\n\n";
$fp = fopen("final_translated.txt","a+");
$fp1 = fopen("log.txt","a+");
fwrite($fp, $reply);
$file_parse = explode("\\",$file);
fwrite($fp1, end($file_parse));
}

?>