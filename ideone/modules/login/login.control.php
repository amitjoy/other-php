<?php
//------------------------------------------------------------
// INSTANTIATE SESSIONS
//------------------------------------------------------------ 
if(!isset($_SESSION)){
  session_start();
}

// show login form?
$showForm = 1; // 1 = show

//------------------------------------------------------------
// IF USER FAILED TOKEN MATCH - ACCOUNT SHARING NOT ALLOWED
//------------------------------------------------------------
if(isset($_GET['TokenLogOff']) && $_GET['TokenLogOff'] == '1')
{
	require_once(ROOT_PATH.'modules/logout/token_log_off.php');
}

if(isset($_GET['TokenLogOff']) && $_GET['TokenLogOff'] == '0')
{
	require_once(ROOT_PATH.'modules/login/error_messages.php');
	echo $auth_token_error;
}

//------------------------------------------------------------
// IF USER FAILS ACCESS LEVEL (ROLE) CHECK
//------------------------------------------------------------
if(isset($_GET['clearance']) && $_GET['clearance'] == 'failed')
{
	require_once(ROOT_PATH.'modules/login/error_messages.php');
	echo $auth_role_error;
}

//------------------------------------------------------------
// IF USER FAILS PREMIUM ACCESS LEVEL CHECK
//------------------------------------------------------------
if(isset($_GET['premium']) && $_GET['premium'] == 'failed')
{
	require_once(ROOT_PATH.'modules/login/error_messages.php');
	echo $premium_access_error;
}

//------------------------------------------------------------
// IF COOKIES EXIST, USER IS LOGGED IN WITH REMEMBER ME.
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
// IF LOGIN SESSION EXIST, USER IS LOGGED IN
//------------------------------------------------------------
if(!empty($_SESSION['UserName']) && !empty($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1)
{
	$username = $_SESSION['UserName'];
	echo "<div class='msgBox2'><form id='frmLogout' name='frmLogout' method='post' action='' class='htmlForm'><input type='submit' name='btnLogout' id='btnLogout' value='Log Out' class='btnRight' />WELCOME $username! You are LOGGED IN. </form></div>";

	if(isset($_POST['btnLogout']))
	{
		require_once(ROOT_PATH.'modules/logout/logout.php');
	}
}

//------------------------------------------------------------
// IF LOCKOUT SESSION EXISTS
//------------------------------------------------------------
if(!empty($_SESSION['count']))
{
	require_once(ROOT_PATH.'connect/mysql.php');
	require_once(ROOT_PATH.'modules/login/error_messages.php');
	
	$count = $_SESSION['count'];
	$offender = mysqli_real_escape_string($conn, $_SESSION['offender']);
	$maxLoginAttempt = MAX_LOGIN_ATTEMPT;
	
	// if count is greater than max allowed
	if($count >= $maxLoginAttempt)
	{
		// check if user exists in database
		$checkOffender = mysqli_query($conn, "SELECT UserName, IsLockedOut, LastLockoutDate, LastUnlockDate, NOW() AS ServerTime FROM users WHERE UserName = '$offender' LIMIT 1")
		or die($dataaccess_error);
		
		// if username exist
		if(mysqli_num_rows($checkOffender) == 1)
		{
			// show banner and hide form
			echo $maxloginattempt_error;
			$showForm = 0;
			
			$row = mysqli_fetch_array($checkOffender);
			$isLockedOut = $row['IsLockedOut'];
			$lastlockoutdate = $row['LastLockoutDate'];
			$lastUnlockDate = $row['LastUnlockDate'];
			$serverTime = $row['ServerTime'];
			
			// unlock user if lockout has expired
			if($isLockedOut == 1 && strtotime($lastUnlockDate) < strtotime($serverTime))
			{
				$unlockOffender = mysqli_query($conn,"UPDATE users SET IsLockedOut = 0 WHERE UserName = '$offender'") 
				or die($updateactivity_error);
				
				unset($_SESSION['count']);
				unset($_SESSION['offender']);
				
				$showForm == 1;
			}
			
			// otherwise lockout the user
			if($isLockedOut == 0)
			{
				$lockoutDuration = (LOCKOUT_DURATION);
				$updateOffender = mysqli_query($conn,"UPDATE users SET IsLockedOut = 1, LastLockoutDate = NOW(), LastUnlockDate = ADDDATE(NOW(), INTERVAL $lockoutDuration MINUTE)  WHERE UserName = '$offender'") 
				or die($updateactivity_error);
			}
		}
		
		// username does not exist - lockout with session
		if(mysqli_num_rows($checkOffender) == 0)
		{
			$lockoutDuration = (LOCKOUT_DURATION * 60);

			if(isset($_SESSION['started']))
			{
				echo $maxloginattempt_error;
				$showForm = 0;

			  	if(time() > ($_SESSION['started'] + $lockoutDuration))
			  	{
					session_unset();
					session_destroy();
					$showForm = 1;
				}
			}
			else
			{
				$_SESSION['started'] = time();
			}
		}
	}
}

//------------------------------------------------------------
// OTHERWISE IF NO COOKIE, NO SESSION AND NO LOCKOUT - SHOW LOGIN FORM
//------------------------------------------------------------
if(!isset($_COOKIE['user'], $_COOKIE['pass']) && empty($_SESSION['UserName']) && $showForm == 1)
{
	require_once(ROOT_PATH.'modules/login/login.html.php');
}
?>