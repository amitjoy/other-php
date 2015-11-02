<?php
//------------------------------------------------------------
// instantiate sessions
//------------------------------------------------------------
if(!isset($_SESSION)){
  session_start();
}

if(!empty($_SESSION['UserName']) && !empty($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1)
{
	//------------------------------------------------------------
	// include db connection
	//------------------------------------------------------------
	require_once(ROOT_PATH.'connect/mysql.php');
	
	// update database
	$username = $_SESSION['UserName'];
	$updateactivity = mysqli_query($conn,"UPDATE users SET IsLoggedIn = 0 WHERE UserName = '$username'") 
	or die($updateactivity_error);
	
	// delete sessions
	session_destroy();		
	header('Location:'.SITE_URL.'login.php');
}
?>