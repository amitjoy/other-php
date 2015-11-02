<?php 
// see if failure session count is set
if(isset($count))
{
	$count = $count;
}
else
{
	$count = 0;
}

$captcha_on_x = CAPTCHA_ON_X;
// if captcha is set to ON
if(LOGIN_CAPTCHA_ON == 1 || LOGIN_CAPTCHA_ON == 0 && $count >= $captcha_on_x)
{
	require_once(ROOT_PATH.'modules/login/recaptcha.php'); 
}
else
{
	require_once(ROOT_PATH.'modules/login/no_captcha.php');
}
?>