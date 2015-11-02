<?php
// ------------------------------------------------------------
// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
// ------------------------------------------------------------
$from_address = NO_REPLY;

// ------------------------------------------------------------
// CREATE HTML E-MAIL
// ------------------------------------------------------------
$to = $accountemail;
$subject = 'Account User Name Recovery';
$message = '
<html>
<head>
  	<title>Account User Name Recovery</title>
</head>
<body>
  	<p>Hello '.$accountname.',</p>
	<p>Your account user name has been successfully recovered.</p>
	<p>User Name: '.$accountname.'</p>
	<p>Cheers, Site Admininstrator</p>
</body>
</html>
';

// ------------------------------------------------------------
// SET HEADERS FOR HTML MAIL
// ------------------------------------------------------------
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Account User Name Recovery <'.$from_address.'>' . "\r\n";
// ------------------------------------------------------------
// SEND E-MAIL
// ------------------------------------------------------------
mail($to, $subject, $message, $headers);
?>