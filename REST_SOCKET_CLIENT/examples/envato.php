<?php

require_once "../main.php";

try {
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_GET); // This is not required because the default method is GET
	$result = $Client->request('http://marketplace.envato.com/api/v2/popular:codecanyon.json', REST_CLIENT::CONTENT_JSON);
	explore($result);
	// Show results
	/*foreach($result->popular->authors_last_month as $user) {
		echo '<a href="' . $user->url . '"><img src="' . $user->image . '" alt="' . $user->item . '" /></a>';
	}*/
} catch(Exception $e) {
	echo 'Envato seems to be offline!';
}