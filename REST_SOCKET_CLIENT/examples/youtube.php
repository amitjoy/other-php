<?php
require_once "../main.php";

try {
	$Client = new REST_CLIENT();
	$Client->setMethod(REST_CLIENT::METHOD_GET); // This is not required because the default method is GET
	$Client->setParams(array('vq' => 'codecanyon', 'orderby' => 'viewCount'));
	$result = $Client->request('http://gdata.youtube.com/feeds/api/videos', REST_CLIENT::CONTENT_XML);
	// Show results
	echo '<ul>';
	foreach($result->entry as $item) {
		echo '<li><a href="' . $item->link[0]['href'] . '">' . trim($item->title) . '</a></li>';
	}
	echo '</ul>';
} catch(Exception $e) {
	echo 'YouTube seems to be offline!';
}