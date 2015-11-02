<?php


 
 require 'config.php';
 
 /**
 * Check if user is currently logged in, or if the just
 * submitted log in request was valid.
 *
 * @return mixed: true if logged in or error message (string)
 */
 function LogInMessage() {
 	global $config;
 	
 	if(isset($_POST['username']) && isset($_POST['password'])) {
 		if(isset($config['auth'][$_POST['username']]) && $_POST['password'] == $config['auth'][$_POST['username']]) {
 			// correct; set cookies.
 			
 			// random salt
 			$salt = substr(md5(rand()), 0, 6);
 			
 			// plaintext username
 			setcookie('user', $_POST['username'], time() + $config['session_expire']);
 			// password hash
 			setcookie('pass', sha1(sha1($_POST['password']) . ':' . $_POST['username'] . ':' . $salt . $config['salt']), time() + $config['session_expire']);
 			setcookie('salt', $salt, time() + $config['session_expire']);
 			
 			// redirect
 			header('Location: ?');
 			
 			exit;
 		} else {
 			return 'Invalid username/password.';
 		}
 	} elseif(isset($_COOKIE['user']) && isset($_COOKIE['pass']) && isset($_COOKIE['salt'])) {
 		if(!isset($config['auth'][$_COOKIE['user']]))
 			return false; // username doesn't exist.
 		
 		// get actual password
 		$password = $config['auth'][$_COOKIE['user']];
 		
 		// validate password hash
 		if($_COOKIE['pass'] == sha1(sha1($password) . ':' . $_COOKIE['user'] . ':' . $_COOKIE['salt'] . $config['salt'])) {
 			// valid
 			return true;
 		}
 	}
 	
 	 	
 	return false;
 }
 
 /**
 * Destroy current session.
 *
 * @return null
 */
 function Logout() {
 	setcookie('user', false, time() - 360);
	// password hash
	setcookie('pass', false, time() - 360);
	setcookie('salt', false, time() - 360);
	
	header('Location: ?');
 }
 
