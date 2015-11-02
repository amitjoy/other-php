<?php
// ------------------------------------------------------------
// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
// ------------------------------------------------------------
$from_address = NO_REPLY;
if($include_pw == 1)
{
	$pw_value = $sent_new_password0;
}
else
{
	$pw_value = '******';
}

// ------------------------------------------------------------
// CREATE HTML E-MAIL
// ------------------------------------------------------------
$get_user_email = mysqli_query($conn, "SELECT Email FROM users WHERE UserName =  '$user_name' LIMIT 1") 
or die($dataaccess_error);

if(mysqli_num_rows($get_user_email) == 1)
{
	$row = mysqli_fetch_array($get_user_email);
	$email = $row['Email'];
	
	$to = $email;
	$subject = 'Password Reset Confirmation';
	$message = '
	<html>
	<head>
		<title>Password Reset Confirmation</title>
	</head>
	<body>
		<p>Hello '.$user_name.',</p>
		<p>Your account password has been successfully reset. If you elected to receive your new password along with the confirmation, please make sure you delete this e-mail after printing and keeping it in a safe place.</p>
		<p>New Password: '.$pw_value.'</p>
	</body> 
	</html>
	';
	
	// ------------------------------------------------------------
	// SET HEADERS FOR HTML MAIL
	// ------------------------------------------------------------
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers .= 'To: <'.$txbEmail.'>' . "\r\n";
	$headers .= 'From: Password Reset Confirmation <'.$from_address.'>' . "\r\n";
	//$headers .= 'Cc: anothermail@foo.org' . "\r\n";
	//$headers .= 'Bcc: '.$from_address.'' . "\r\n";
	
	// ------------------------------------------------------------
	// SEND E-MAIL
	// ------------------------------------------------------------
	mail($to, $subject, $message, $headers);
	
	$msg = $pw_reset_success2;
}
else
{
	$msg = $send_email_error;
}
?>