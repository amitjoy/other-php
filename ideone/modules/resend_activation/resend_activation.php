<?php
// ------------------------------------------------------------
// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
// ------------------------------------------------------------
$from_address = NO_REPLY;
$activation_base_URL = ACCOUNT_ACTIVATION_URL;

// ------------------------------------------------------------
// ASSEMBLE ACTIVATION URL
// ------------------------------------------------------------
$activation_code = $activationkey;
$parameter = "?aid=";
$verificationURL = $activation_base_URL.$parameter.$activation_code;

// ------------------------------------------------------------
// CREATE HTML E-MAIL
// ------------------------------------------------------------
$to = $accountemail;
$subject = 'RESEND: Account Confirmation';
$message = '
<html>
<head>
  	<title>RESEND: Account Confirmation</title>
</head>
<body>
  	<p>Hello '.$accountname.',</p>
	<p>To complete your registration process, please click on the link below to confirm and activate your account.</p>
	<p><a href="'.$verificationURL.'">'.$verificationURL.'</a></p>
</body>
</html>
';

// ------------------------------------------------------------
// SET HEADERS FOR HTML MAIL
// ------------------------------------------------------------
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$headers .= 'To: <'.$txbEmail.'>' . "\r\n";
$headers .= 'From: Account Confirmation <'.$from_address.'>' . "\r\n";
//$headers .= 'Cc: anothermail@foo.org' . "\r\n";
//$headers .= 'Bcc: '.$from_address.'' . "\r\n";

// ------------------------------------------------------------
// SEND E-MAIL
// ------------------------------------------------------------
mail($to, $subject, $message, $headers);
?>