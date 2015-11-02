<?php

require_once "../../main.php";

define("GOOGLE_API","AIzaSyDEqBO9D1tLqSdX3QOtqy6-ZfotMZ5e-6A");

$client = new REST_CLIENT();
$client->setMethod(REST_CLIENT::METHOD_POST);
$client->addParam("longUrl", "http://www.amitinside.com/");
$client->addParam("key", GOOGLE_API);

$result = $client->request("https://www.googleapis.com/urlshortener/v1/url", REST_CLIENT::CONTENT_JSON);
explode($result);