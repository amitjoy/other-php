<?php
// get user name
if(isset($_COOKIE['user']) && !empty($_COOKIE['user']))
{
	$user_name = mysqli_real_escape_string($conn, $_COOKIE['user']);
	$user_cookie_on = 1;
}
elseif(isset($_SESSION['UserName']) && !empty($_SESSION['UserName']))
{
	$user_name = mysqli_real_escape_string($conn, $_SESSION['UserName']);
	$user_cookie_on = 0;
}
?>