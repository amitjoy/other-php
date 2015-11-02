<?php 
// ------------------------------------------------------------
// DEFINE VARIABLES
// ------------------------------------------------------------
$txbEmptyUn = '';
$txbEmptyPw = '';
$txbInvalidCaptcha = '';
$accountNotFound = '';
$username = '';
$emptyfielderror = 0;

// ------------------------------------------------------------
// WHEN THE FORM IS SUBMITTED
// ------------------------------------------------------------
if(isset($_POST['btnSubmit']))
{
	// ------------------------------------------------------------
	// CRETATE AUTH TOKENS TO ENABLE, DISABLE ACCOUNT SHARING
	// ------------------------------------------------------------	
	require_once(ROOT_PATH.'lib/hasher.fn.php');
	require_once(ROOT_PATH.'modules/authorization/auth_token.php');
	
	// ------------------------------------------------------------
	// MESSAGES, ERROR MESSAGES AND ERROR CODES
	// ------------------------------------------------------------	
	require_once(ROOT_PATH.'modules/login/error_messages.php');
	
	// ------------------------------------------------------------
	// SET VARIABLES FOR SUBMITTED FORM VALUES and sanitize
	// ------------------------------------------------------------
	$txbUn = strip_tags(strtolower($_POST['txbUn']));
	$txbPw = strip_tags($_POST['txbPw']);

	if(!empty($txbUn) && !empty($txbPw))
	{
		//------------------------------------------------------------
		// include db connection
		//------------------------------------------------------------
		require_once(ROOT_PATH.'connect/mysql.php');

		// ------------------------------------------------------------
		// SET VARIABLES FOR DB
		// ------------------------------------------------------------
		$username = mysqli_real_escape_string($conn, strtolower($txbUn));
		$password = hashThis(mysqli_real_escape_string($conn, $txbPw));
		
		// DB QUERY: check login credentials in db
		// ------------------------------------------------------------
		$checklogin = mysqli_query($conn, "SELECT UserName, Password, DestinationUrl FROM users WHERE UserName = '$username' AND Password = '$password' AND IsApproved = 1 AND IsLockedOut = 0 LIMIT 1")
		or die($dataaccess_error);
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// IF LOGIN FAILED - NO ROWS RETURNED
		// ------------------------------------------------------------
		if(mysqli_num_rows($checklogin) == 0)
		{
			// DB QUERY: check if user is locked out
			// ------------------------------------------------------------
			$checkuserlockout = mysqli_query($conn, "SELECT UserName, Password, DestinationUrl, IsLockedOut, LastUnlockDate, NOW() AS ServerTime FROM users WHERE UserName = '$username' AND Password = '$password' AND IsApproved = 1 AND IsLockedOut = 1 LIMIT 1")
			or die($dataaccess_error);
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// IF USER IS LOCKED OUT
			// ------------------------------------------------------------
			if(mysqli_num_rows($checkuserlockout) == 1)
			{
				$row = mysqli_fetch_array($checkuserlockout);
				$lastUnlockDate = $row['LastUnlockDate'];
				$serverTime = $row['ServerTime'];
				
				// if lockout already expired
				if(strtotime($lastUnlockDate) < strtotime($serverTime))
				{
					// ------------------------------------------------------------
					// LOG USER IN AND UNLOCK ACCOUNT
					// ------------------------------------------------------------
					
					// set variables
					$auth_pass = $row['Password'];
					$user_redirect = $row['DestinationUrl'];
					
					// create login sessions
					$_SESSION['UserName'] = $username;
					$_SESSION['Password'] = hashThis($auth_pass);
					$_SESSION['LoggedIn'] = 1;
	
					$cbxRememberMe = $_POST['cbxRememberMe'];
					
					// if remember me is checked
					if(isset($cbxRememberMe) && $cbxRememberMe == '1')
					{
						// create cookies for autologin
						$expire = time() + AUTO_LOGIN_DURATION;
						$cookie_un = $row['UserName'];
						$cookie_pass = hashThis($row['Password']);
						
						setcookie('user', $cookie_un, $expire);
						setcookie('pass', $cookie_pass, $expire);
					}
					
					// get user's IP address
					$lastloginip = $_SERVER['REMOTE_ADDR'];
					
					// DB QUERY: update database activity - and UNLOCK USER
					// ------------------------------------------------------------
					$updateactivity = mysqli_query($conn,"UPDATE users SET LastLoginDate = NOW(), LastActivityDate = NOW(), LastLoginIP = '$lastloginip', IsLockedOut = 0, IsLoggedIn = 1, SessionId = '$auth_token' WHERE UserName = '$username'") 
					or die($updateactivity_error);
					// ------------------------------------------------------------
					
					// redirect to destination
					if(USE_DEFAULT_LOGIN_DESTINATION == 1 && $user_redirect == 'default')
					{
						header('Location:'.DEFAULT_LOGIN_DESTINATION_URL);
					}
					elseif(USE_DEFAULT_LOGIN_DESTINATION == 1 && $user_redirect != 'default')
					{
						header('Location:'.$user_redirect);
					}
					elseif(USE_DEFAULT_LOGIN_DESTINATION == 0 && $user_redirect != 'default')
					{
						header('Location:'.$user_redirect);
					}
					elseif(USE_DEFAULT_LOGIN_DESTINATION == 0 && $user_redirect == 'default' && isset($_GET['ReturnURL']))
					{
						$destination_url = $_GET['ReturnURL'];
						header('Location:'.$destination_url);
					}
					elseif(USE_DEFAULT_LOGIN_DESTINATION == 0 && $user_redirect == 'default' && !isset($_GET['ReturnURL']))
					{
						header('Location:'.DEFAULT_LOGIN_DESTINATION_URL);
					}
				}
			}
			
			// show error messages
			echo $authentication_error;
			$accountNotFound = $accountnotfound_error;
			
			// ------------------------------------------------------------
			// COUNT FAILED LOGIN ATTEMPTS
			// ------------------------------------------------------------
			if (!isset($_SESSION['count'])) 
			{
			  $_SESSION['count'] = 2;
			  $_SESSION['offender'] = $username;
			} 
			else 
			{
			  $_SESSION['count']++;
			}
		}
		
		// ------------------------------------------------------------
		// IF AUTHENTICATION IS OK! LOG USER IN
		// ------------------------------------------------------------
		if(mysqli_num_rows($checklogin) == 1)
		{
			// set variables
			$row = mysqli_fetch_array($checklogin);
			$auth_pass = $row['Password'];
			$user_redirect = $row['DestinationUrl'];
			
			// create login sessions
			$_SESSION['UserName'] = $username;
			$_SESSION['Password'] = hashThis($auth_pass);
			$_SESSION['LoggedIn'] = 1;

			$cbxRememberMe = $_POST['cbxRememberMe'];
			
			// if remember me is checked
			if(isset($cbxRememberMe) && $cbxRememberMe == '1')
			{						
				// create cookies for autologin
				$expire = time() + AUTO_LOGIN_DURATION;
				$cookie_un = $row['UserName'];
				$cookie_pass = hashThis($row['Password']);
				
				setcookie('user', $cookie_un, $expire);
				setcookie('pass', $cookie_pass, $expire);
			}
			
			// get user's IP address
			$lastloginip = $_SERVER['REMOTE_ADDR'];
			
			// DB QUERY: update database activity
			// ------------------------------------------------------------
			$updateactivity = mysqli_query($conn,"UPDATE users SET LastLoginDate = NOW(), LastActivityDate = NOW(), LastLoginIP = '$lastloginip', IsLoggedIn = 1, SessionId = '$auth_token' WHERE UserName = '$username'") 
			or die($updateactivity_error);
			// ------------------------------------------------------------
			
			// redirect to destination
			if(USE_DEFAULT_LOGIN_DESTINATION == 1 && $user_redirect == 'default')
			{
				header('Location:'.DEFAULT_LOGIN_DESTINATION_URL);
			}
			elseif(USE_DEFAULT_LOGIN_DESTINATION == 1 && $user_redirect != 'default')
			{
				header('Location:'.$user_redirect);
			}
			elseif(USE_DEFAULT_LOGIN_DESTINATION == 0 && $user_redirect != 'default')
			{
				header('Location:'.$user_redirect);
			}
			elseif(USE_DEFAULT_LOGIN_DESTINATION == 0 && $user_redirect == 'default' && isset($_GET['ReturnURL']))
			{
				$destination_url = $_GET['ReturnURL'];
				header('Location:'.$destination_url);
			}
			elseif(USE_DEFAULT_LOGIN_DESTINATION == 0 && $user_redirect == 'default' && !isset($_GET['ReturnURL']))
			{
				header('Location:'.DEFAULT_LOGIN_DESTINATION_URL);
			}
		}
	}
	
	// ------------------------------------------------------------
	// CHECK FOR EMPTY FIELDS
	// ------------------------------------------------------------
	require_once(ROOT_PATH.'modules/login/empty_fields_check.php');
}
?>