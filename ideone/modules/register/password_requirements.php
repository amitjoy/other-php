<?php
// ------------------------------------------------------------
// CHECK PASSWORD MINIMUM REQUIREMENTS
// ------------------------------------------------------------

// get the length of the password
$passwordinput = $txbPw;
$length = strlen($txbPw);

// check minimum password length
$minpasswordlength = MIN_PASSWORD_LENGTH;
if($length <= $minpasswordlength)
{
	$pwMinRequirements_error = 1;
	$passwordTooShort = $passwordLength_error;
}

// check for numbers
$requirenumber = REQUIRE_NUMBER;
if($requirenumber == 1)
{
	preg_match_all('/[0-9]/', $passwordinput, $numbers);
	$minonenumber = count($numbers[0]);
	if($minonenumber < 1)
	{
		$pwMinRequirements_error = 1;
		$passwordNumber = $passwordNumber_error;
	}
}

// check for special chars
$requirespecialchar = REQUIRE_SPECIAL_CHAR;
if($requirespecialchar == 1)
{
	preg_match_all('/[|!@#$%&*\/=?,;.:\-_+~^\\\]/', $passwordinput, $specialchars);
	$minoneuniquechar = count($specialchars[0]);
	if($minoneuniquechar < 1)
	{
		$pwMinRequirements_error = 1;
		$passwordChar = $passwordSpecialChar_error;
	}
}

// check for user name in password
$check_user_in_pass = ALLOW_USERNAME_IN_PASS;
if($check_user_in_pass == 0 && !empty($txbUn) && !empty($txbPw))
{
	$pos = strstr($txbPw,$txbUn);
	if($pos != false) 
	{
		echo $displayBanner_error;
		$userInPw = $username_in_password_error;
		$passwordMatch_error = 1;
	}
}
?>