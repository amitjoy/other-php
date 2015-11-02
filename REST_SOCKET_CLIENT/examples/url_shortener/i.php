<?
//This is the URL you want to shorten
$longUrl = 'https://www.packtpub.com/php-jquery-cookbook-to-create-interactive-web-applications/book';
$apiKey = 'AIzaSyDEqBO9D1tLqSdX3QOtqy6-ZfotMZ5e-6A';
//Get API key from : http://code.google.com/apis/console/
 
$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
$jsonData = json_encode($postData);
 
$curlObj = curl_init();
 
curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curlObj, CURLOPT_HEADER, 0);
curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
curl_setopt($curlObj, CURLOPT_POST, 1);
curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
 
$response = curl_exec($curlObj);
 
//change the response json string to object
$json = json_decode($response);
print_r($json); 
curl_close($curlObj);
 
echo 'Shortened URL is: '.$json->id;