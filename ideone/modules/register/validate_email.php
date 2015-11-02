<?php
// ------------------------------------------------------------
// VALIDATE E-MAIL
// ------------------------------------------------------------
if(!filter_var($txbEmail, FILTER_VALIDATE_EMAIL))
{
	$emailNotValid = $email_error;
	$emailValidate_error = 1;
}

// ------------------------------------------------------------
// WARNING! THE BELOW CODE REQUIRES PHP 5.3 OR LATER on windows
// ------------------------------------------------------------
if(filter_var($txbEmail, FILTER_VALIDATE_EMAIL))
{
	if(domain_exists($txbEmail))
	{
		$emailValidate_error = 0;
	}
	else
	{
		$emailNotValid = $emailMx_error;
		$emailValidate_error = 1;
	}
}
// check if mx records exist
function domain_exists($emailtocheck,$record = 'MX')
{
	list($user,$domain) = preg_split('/@/',$emailtocheck);
	//return checkdnsrr($domain,$record);
	return 1;
}
?>