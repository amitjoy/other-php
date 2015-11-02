<?php 
//------------------------------------------------------------
// instantiate sessions
//------------------------------------------------------------
if(!isset($_SESSION)){
  session_start();
}

//------------------------------------------------------------
// if cookies exist, user is logged in with remember me.
//------------------------------------------------------------
if(isset($_COOKIE['user'], $_COOKIE['pass']))
{
	$autoLoginDays = (AUTO_LOGIN_DURATION / 86400);
	echo "<div class='msgBox3'><form id='frmAutoLogout' name='frmAutoLogout' method='post' action='' class='htmlForm'><input type='submit' name='btnAutoLogout' id='btnAutoLogout' value='Turn Off' class='btnRight' />WELCOME! You are AUTO LOGGED IN. Your AUTO LOGIN will be Active for ".$autoLoginDays." DAYS.</form> </div>";
	
	if(isset($_POST['btnAutoLogout']))
	{
		require_once(ROOT_PATH.'delete_auto_login.php');
	}
	exit();
}

//------------------------------------------------------------
// if session exists, user is already logged in.
//------------------------------------------------------------
if(!empty($_SESSION['UserName']) && $_SESSION['LoggedIn'] == 1)
{
	$username = $_SESSION['UserName'];
	echo "<div class='msgBox2'><form id='frmLogout' name='frmLogout' method='post' action='' class='htmlForm'><input type='submit' name='btnLogout' id='btnLogout' value='Log Out' class='btnRight' />WELCOME $username! You are LOGGED IN. </form></div>";

	if(isset($_POST['btnLogout']))
	{
		require_once(ROOT_PATH.'modules/logout/logout.php');
	}
}
else
{
	require_once(ROOT_PATH.'modules/recover_un/recover.html.php');
}
?>