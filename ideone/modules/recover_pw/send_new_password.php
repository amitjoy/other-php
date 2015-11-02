<?php
// ------------------------------------------------------------
// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
// ------------------------------------------------------------
$from_address = NO_REPLY;

// ------------------------------------------------------------
// GENERATE NEW PASSWORD
// ------------------------------------------------------------
require_once(ROOT_PATH.'modules/recover_pw/salt_generator.php');
require_once(ROOT_PATH.'lib/hasher.fn.php');
$salt = gen_chars(8);
$newpassword = $accountname . $salt;
$newhashedpw = hashThis($newpassword);

// DB QUERY: update database with new password
// ------------------------------------------------------------
$updatepassword = mysqli_query($conn,"UPDATE users SET Password = '$newhashedpw' WHERE UserName = '$username'") 
or die($updatepassword_error);
// ------------------------------------------------------------

// ------------------------------------------------------------
// CREATE HTML E-MAIL
// ------------------------------------------------------------
$to = $accountemail;
$subject = 'Account Password Reset';
$message = '
<html>
<head>
  	<title>Account Password Reset</title>
</head>
<body>
  	<p>Hello '.$accountname.',</p>
	<p>Your account password has been successfully reset, and a new temporary password has been generated for you.</p>
	<p>After logging into your account, it is recommended that you change this password.</p>
	<p>New Password: '.$newpassword.'</p>
	<p>Cheers, Site Administrator</p>
</body>
</html>
';

// ------------------------------------------------------------
// SET HEADERS FOR HTML MAIL
// ------------------------------------------------------------
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$headers .= 'To: <'.$txbEmail.'>' . "\r\n";
$headers .= 'From: Account Password Reset <'.$from_address.'>' . "\r\n";
//$headers .= 'Cc: anothermail@foo.org' . "\r\n";
//$headers .= 'Bcc: '.$from_address.'' . "\r\n";

// ------------------------------------------------------------
// SEND E-MAIL
// ------------------------------------------------------------
mail($to, $subject, $message, $headers);
?>