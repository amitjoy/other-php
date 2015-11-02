<?php
// ------------------------------------------------------------
// USER NAME CHECK SUBMIT
// ------------------------------------------------------------	
if(isset($_POST['btnCheckUn']))
{
	if(!empty($_POST['txbUn']))
	{
		// set variable for user name submitted value
		$txbUn = strip_tags(strtolower($_POST['txbUn']));
		
		// include required files
		require_once(ROOT_PATH.'connect/mysql.php');
		require_once(ROOT_PATH.'modules/register/error_messages.php');
		
		// check user name in db
		$usernamelookup = mysqli_real_escape_string($conn, $txbUn);
		$checkusername = mysqli_query($conn, "SELECT * FROM users WHERE UserName = '$usernamelookup'") 
		or die($checkUser_error);
		
		if(mysqli_num_rows($checkusername) > 0)
		{
			// not available
			echo $displayBanner_error;
			$txbUserNameCheck = $userNameNotAvailable_msg;
			$username = $txbUn;
		}
		else
		{
			// available
			$txbUserNameCheck = $userNameAvailable_msg;
			$username = $txbUn;
		}
	}
	else
	{
		require_once(ROOT_PATH.'modules/register/error_messages.php');
		$txbEmptyUn = $EmptyCheckUn_msg;
		echo $displayBanner_error;
	}
}
?>