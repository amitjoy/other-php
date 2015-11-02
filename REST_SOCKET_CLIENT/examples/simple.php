<?php

require_once "../main.php";

$Client = new REST_CLIENT();
$Client->setMethod(REST_CLIENT::METHOD_GET);
$Client->addParam('q', 'microsoft');
$result = $Client->request('http://ajax.googleapis.com/ajax/services/search/web?v=1.0', REST_CLIENT::CONTENT_JSON);

explore($result);
