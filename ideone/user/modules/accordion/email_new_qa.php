<?php
// ------------------------------------------------------------
// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
// ------------------------------------------------------------
$from_address = NO_REPLY;

// ------------------------------------------------------------
// CREATE HTML E-MAIL
// ------------------------------------------------------------
$get_user_details = mysqli_query($conn, "SELECT Email, PasswordQuestion, PasswordAnswer FROM users WHERE UserName =  '$user_name' LIMIT 1") 
or die($dataaccess_error);

if(mysqli_num_rows($get_user_details) == 1)
{
	$row = mysqli_fetch_array($get_user_details);
	$email = $row['Email'];
	$pw_question = $row['PasswordQuestion'];
	$pw_answer = $row['PasswordAnswer'];
	
	if($include_qa == 1)
	{
		$q_value = $pw_question;
		$a_value = $pw_answer;
	}
	else
	{
		$q_value = '******';
		$a_value = '******';
	}
	
	$to = $email;
	$subject = 'Security Q and A Update Confirmation';
	$message = '
	<html>
	<head>
		<title>Security Q and A Update Confirmation</title>
	</head>
	<body>
		<p>Hello '.$user_name.',</p>
		<p>Your account security Question and Answer has been successfully updated. If you have elected to receive your new Q and A, please make sure you delete the e-mail after printing and keeping it in a safe place.</p>
		<p>New Security Q: '.$q_value.'</p>
		<p>New Security A: '.$a_value.'</p>
	</body> 
	</html>
	';
	
	// ------------------------------------------------------------
	// SET HEADERS FOR HTML MAIL
	// ------------------------------------------------------------
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers .= 'To: <'.$txbEmail.'>' . "\r\n";
	$headers .= 'From: Security Q and A Update Confirmation <'.$from_address.'>' . "\r\n";
	//$headers .= 'Cc: anothermail@foo.org' . "\r\n";
	//$headers .= 'Bcc: '.$from_address.'' . "\r\n";
	
	// ------------------------------------------------------------
	// SEND E-MAIL
	// ------------------------------------------------------------
	mail($to, $subject, $message, $headers);
	
	$msg = $pw_qa_success2;
}
else
{
	$msg = $send_email_error;
}
?>