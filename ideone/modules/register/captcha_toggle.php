<?php 
if(REGISTER_CAPTCHA_ON == 1)
{
	require_once(ROOT_PATH.'modules/register/recaptcha.php'); 
}
else
{
	require_once(ROOT_PATH.'modules/register/no_captcha.php');
}
?>