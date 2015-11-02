<?php
// ------------------------------------------------------------
// CRETATE AUTH TOKEN TO ENABLE, DISABLE ACCOUNT SHARING
// ------------------------------------------------------------
if(ACCOUNT_SHARING == 0)
{
	// create token for db
	$auth_token = hashThis(time());

	// create session token
	$_SESSION['auth_token'] = $auth_token;

	// create cookie version for auto login
	$expire_auth_token = time() + AUTO_LOGIN_DURATION;
	setcookie('cookie_auth_token', $auth_token, $expire_auth_token);
}