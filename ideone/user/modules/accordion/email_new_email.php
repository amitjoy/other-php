<?php
// ------------------------------------------------------------
// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
// ------------------------------------------------------------
$from_address = NO_REPLY;

// ------------------------------------------------------------
// CREATE HTML E-MAIL
// ------------------------------------------------------------
if($include_email == 1)
{
	$email_value = $sent_new_email;
}
else
{
	$email_value = '******';
}

$to = $sent_new_email;
$subject = 'Account Email Confirmation';
$message = '
<html>
<head>
	<title>Account Email Confirmation</title>
</head>
<body>
	<p>Hello '.$user_name.',</p>
	<p>Your account email has been successfully changed. If you have elected to include the new e-mail address in this confirmation e-mail, please make sure that you delete this e-mail after printing it and keeping it in a safe place.</p>
	<p>New Email: '.$email_value.'</p>
</body> 
</html>
';

// ------------------------------------------------------------
// SET HEADERS FOR HTML MAIL
// ------------------------------------------------------------
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$headers .= 'To: <'.$txbEmail.'>' . "\r\n";
$headers .= 'From: Account Email Confirmation <'.$from_address.'>' . "\r\n";
//$headers .= 'Cc: anothermail@foo.org' . "\r\n";
//$headers .= 'Bcc: '.$from_address.'' . "\r\n";

// ------------------------------------------------------------
// SEND E-MAIL
// ------------------------------------------------------------
if(mail($to, $subject, $message, $headers))
{
	$msg = $email_update_success2;
}
else
{
	$msg = 	$send_email_error;
}

?>