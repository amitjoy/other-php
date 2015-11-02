<?php 
// get required includes
require_once(ROOT_PATH.'user/modules/accordion/error_messages.php');

// declare variables
$msg = '';

// ------------------------------------------------------------
// UPDATE USER PASSWORD
// ------------------------------------------------------------
if(isset($_POST['btnUpdatePw']))
{
	$validate_error = 0;

	// check for empty fields
	if(empty($_POST['currentPassword']))
	{
		$validate_error = 1;
		$msg = $pw_current_empty_msg;
	}
	
	if(empty($_POST['newPassword0']))
	{
		$validate_error = 1;
		$msg .= $pw_new0_empty_msg;
	}
	
	if(empty($_POST['newPassword1']))
	{
		$validate_error = 1;
		$msg .= $pw_new1_empty_msg;
	}
	
	if(empty($_POST['pw_PasswordQ']))
	{
		$validate_error = 1;
		$msg .= $pw_q_empty_msg;
	}
	
	if(empty($_POST['pw_PasswordA']))
	{
		$validate_error = 1;
		$msg .= $pw_a_empty_msg;
	}

	if(isset($_POST['email_credentials']))
	{
		$email_credentials = 1;
	}
	else
	{
		$email_credentials = 0;
	}
	
	if(isset($_POST['include_pw']))
	{
		$include_pw = 1;
	}
	else
	{
		$include_pw = 0;
	}

	if(!empty($_POST['currentPassword']) && !empty($_POST['newPassword0']) && !empty($_POST['newPassword1']) && !empty($_POST['pw_PasswordQ']) && !empty($_POST['pw_PasswordA']))
	{
		// get required includes
		require_once(ROOT_PATH.'lib/hasher.fn.php');

		// get sent field values
		$sent_current_password = hashThis(mysqli_real_escape_string($conn, $_POST['currentPassword']));
		$sent_new_password0 = mysqli_real_escape_string($conn, $_POST['newPassword0']);
		$sent_new_password1 = mysqli_real_escape_string($conn, $_POST['newPassword1']);
		$sent_pw_PasswordQ = mysqli_real_escape_string($conn, $_POST['pw_PasswordQ']);
		$sent_pw_PasswordA = mysqli_real_escape_string($conn, $_POST['pw_PasswordA']);
		
		// get current hashed password
		$get_current_password = mysqli_query($conn, "SELECT Password, PasswordQuestion, PasswordAnswer FROM users WHERE UserName = '$user_name' Limit 1") 
		or die($dataaccess_error);
		
		if(mysqli_num_rows($get_current_password) == 1 )
		{
			$row = mysqli_fetch_array($get_current_password);
			$current_password = $row['Password'];
			$current_password_q = $row['PasswordQuestion'];
			$current_password_a = $row['PasswordAnswer'];
			
			// validate security question
			if($sent_pw_PasswordQ != $current_password_q)
			{
				$validate_error = 1;
				$msg .= $pw_q_no_match_msg;
			}
			
			// validate security answer
			if($sent_pw_PasswordA != $current_password_a)
			{
				$validate_error = 1;
				$msg .= $pw_a_no_match_msg;
			}
			
			// if sent current password match with current password
			if($sent_current_password == $current_password)
			{
				// check for new passwords match field 1 and 2
				if($sent_new_password0 == $sent_new_password1)
				{
					// check for length
					$length = strlen($sent_new_password0);
					$min_password_length = MIN_PASSWORD_LENGTH;
					if($length >= $min_password_length)
					{
						// check for number
						$require_number = REQUIRE_NUMBER;
						if($require_number == 1)
						{
							preg_match_all('/[0-9]/', $sent_new_password0, $numbers);
							$min_one_number = count($numbers[0]);
							if($min_one_number < 1)
							{
								$validate_error = 1;
								$msg .= $pw_numeric_msg;
							}
						}
						
						// check for special char
						$require_special_char = REQUIRE_SPECIAL_CHAR;
						if($require_special_char == 1)
						{
							preg_match_all('/[|!@#$%&*\/=?,;.:\-_+~^\\\]/', $sent_new_password0, $special_chars);
							$min_one_unique_char = count($special_chars[0]);
							if($min_one_unique_char < 1)
							{
								$validate_error = 1;
								$msg .= $pw_special_msg;
							}
						}
						
						// if everything is validated  OK
						if($validate_error == 0)
						{
							$hashed_pw = hashThis($sent_new_password0);
							
							$reset_password = mysqli_query($conn, "UPDATE users SET Password = '$hashed_pw' WHERE UserName = '$user_name'") 
							or die($dataaccess_error);
							
							if(mysqli_affected_rows($conn) > 0)
							{
								if($email_credentials == 1)
								{
									require_once('email_new_pw.php');
								}
								else
								{
									$msg = $pw_reset_success1;
								}
							}
							else
							{
								$msg = $pw_reset_failed;
							}
						}
					}
					else
					{
						// if password is too short
						$validate_error = 1;
						$msg .= $pw_length_msg;
					}
				}
				else
				{
					// if new passwords do not match
					$validate_error = 1;
					$msg .= $pw_match_msg;
				}
			}
			else
			{
				// if sent current password do not match current password
				$validate_error = 1;
				$msg .= $pw_not_found_msg;
			}
		}
		else
		{
			// if password not found for current user name
			$validate_error = 1;
			$msg .= $pw_not_found_msg;
		}
	}
}
?>