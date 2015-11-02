<?php 
//------------------------------------------------------------
// TURN OFF AUTO LOGIN
//------------------------------------------------------------
if(isset($_POST['btnAutoLogout']))
{
	require_once(ROOT_PATH.'delete_auto_login.php');
}
//------------------------------------------------------------
// LOGOUT
//------------------------------------------------------------
if(isset($_POST['btnLogout']))
{
	require_once(ROOT_PATH.'modules/logout/logout.php');
}
//------------------------------------------------------------
// if cookies exist, user is logged in with remember me.
//------------------------------------------------------------
if(isset($_COOKIE['user'], $_COOKIE['pass']))
{
	echo "<input type='submit' name='btnAutoLogout' id='btnAutoLogout' value='Turn Off' class='btnLogout' title='Turn Off Auto Login' />";
}

//------------------------------------------------------------
// if login session exist, user is logged in
//------------------------------------------------------------
if(!isset($_COOKIE['user'], $_COOKIE['pass']) && !empty($_SESSION['UserName']) && !empty($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1)
{
	echo "<input type='submit' name='btnLogout' id='btnLogout' value='Log Out' class='btnLogout' title='Log Out' />";
}
?>