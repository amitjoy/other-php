<?php

include '../main.php';

try {
	
	// Create api client instance
	$Client = new REST_CLIENT();
	
	// Get token to authenticate our requests
	$Client->setMethod(REST_CLIENT::METHOD_GET); // This is not required because the default method is GET
	$Client->addHeader(REST_CLIENT::HEADER_AUTHORIZATION, 'Basic ' . base64_encode('[email]:[password]'));
	$result = $Client->request('https://www.pivotaltracker.com/services/v3/tokens/active', REST_CLIENT::CONTENT_XML);
	$token = trim($result->guid);

	
	// Get activity log
	$Client->reset();
	$Client->addHeader('X-TrackerToken', $token);
	$result = $Client->request('http://www.pivotaltracker.com/services/v3/projects/232211/activities?limit=20', REST_CLIENT::CONTENT_XML);

	// Show activity log
	echo '<ul>';
	foreach($result->activity as $activity) {
		echo '<li>' . $activity->description . '</li>';
	}
	echo '</ul>';
	
	// Create a new project
	// We don't need to set the token again because it is still set from the get activity log above
	$Client->setMethod(REST_CLIENT::METHOD_POST);
	$Client->addHeader(REST_CLIENT::HEADER_CONTENT_TYPE, 'application/xml');
	$Client->setData('<project><name>Test project by Api Client</name><iteration_length type="integer">2</iteration_length></project>');
	$result = $Client->request('http://www.pivotaltracker.com/services/v3/projects', REST_CLIENT::CONTENT_XML);
	
	if(isset($result->id)){
		echo 'New project is created an has ID: ' . $result->id;
	}
	
} catch(Exception $e) {
	echo 'Problem while executing!';
}