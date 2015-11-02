<?php
//------------------------------------------------------------
// INCLUDE FILES
//------------------------------------------------------------
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'modules/register/error_messages.php');

//------------------------------------------------------------
// GET ACTIVATION KEY FROM QUERY STRING
//------------------------------------------------------------
if(!empty($_GET['aid']))
{
	$activationKey = mysqli_real_escape_string($conn, $_GET['aid']);
}
else
{
	// if activation key not present, redirect user
	header('Location:'.SITE_URL.'login.php');
	die('Oops! ...:)');
}

// DB QUERY: VERIFY ACTIVATION KEY IN DATABASE
// ------------------------------------------------------------
$verify = mysqli_query($conn, "SELECT ActivationKey, IsApproved FROM users WHERE ActivationKey = '$activationKey' LIMIT 1") 
or die($activation_error);
// ------------------------------------------------------------

$row = mysqli_fetch_array($verify);
$isapproved = $row['IsApproved'];

//------------------------------------------------------------
// IF ACTIVATION KEY IS FOUND AND USER IS NOT YET APPROVED
//------------------------------------------------------------
if(mysqli_num_rows($verify) == 1 && $isapproved == 0)
{	
	// activate user account
	$activate = mysqli_query($conn, "UPDATE users SET IsApproved = 1 WHERE ActivationKey = '$activationKey'") 
	or die($activation_error);
	
	// display success massage
	echo $confirmactivation_msg;
	
	//send welcome email message
	require_once(ROOT_PATH.'modules/activation/send_welcome_email.php');
}
//------------------------------------------------------------
// IF USER IS ALREADY APPROVED
//------------------------------------------------------------
elseif(mysqli_num_rows($verify) == 1 && $isapproved == 1)
{
	echo $alreadyactive_error;
}
//------------------------------------------------------------
// IF ACTIVATION KEY IS NOT FOUND
//------------------------------------------------------------
elseif(mysqli_num_rows($verify) == 0)
{
	echo $activation_error;
}
?>