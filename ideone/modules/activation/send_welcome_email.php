<?php
// ------------------------------------------------------------
// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
// ------------------------------------------------------------
$from_address = NO_REPLY;
// if admin notification is enabled
$notify_admin = ACTIVATION_NOTIFICATION;

// DB QUERY: GET USER EMAIL
// ------------------------------------------------------------
$getuseremail = mysqli_query($conn, "SELECT UserName, Email FROM users WHERE ActivationKey = '$activationKey' LIMIT 1") 
or die($activation_error);
// ------------------------------------------------------------

$row = mysqli_fetch_array($getuseremail);
$recipientname = $row['UserName'];
$recipientemail = $row['Email'];

// ------------------------------------------------------------
// CREATE HTML E-MAIL
// ------------------------------------------------------------
$to = $recipientemail;
$subject = 'Welcome Aboard!';
$message = '
<html>
<head>
  	<title>Welcome Aboard!</title>
</head>
<body>
  	<p>Hello '.$recipientname.',</p>
	<p>Welcome aboard! Your new account has been confirmed and is now active. Please keep your user name, password and security answer in a safe place.</p>
	<p>Have a wonderful day!</p>
</body>
</html>
';

// ------------------------------------------------------------
// SET HEADERS FOR HTML MAIL
// ------------------------------------------------------------
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Account Confirmation <'.$from_address.'>' . "\r\n";
if($notify_admin == 1)
{
	// if admin notification is enabled, send carbon copy
	$headers .= 'Bcc: '.$from_address.'' . "\r\n";
}

// ------------------------------------------------------------
// SEND E-MAIL
// ------------------------------------------------------------
mail($to, $subject, $message, $headers);
?>