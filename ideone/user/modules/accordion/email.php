<?php
// declare variables
$msg = '';

// ------------------------------------------------------------
// UPDATE USER PASSWORD
// ------------------------------------------------------------
if(isset($_POST['btnUpdateEmail']))
{
	$validate_error = 0;

	// check for empty fields
	if(empty($_POST['EmailAddress']))
	{
		$validate_error = 1;
		$msg .= $email_address_empty_msg;
	}
	
	if(empty($_POST['em_PasswordQ']))
	{
		$validate_error = 1;
		$msg .= $pw_q_empty_msg;
	}
	
	if(empty($_POST['em_PasswordA']))
	{
		$validate_error = 1;
		$msg .= $pw_a_empty_msg;
	}
	
	if(isset($_POST['email_email']))
	{
		$email_email = 1;
	}
	else
	{
		$email_email = 0;
	}
	
	if(isset($_POST['include_email']))
	{
		$include_email = 1;
	}
	else
	{
		$include_email = 0;
	}
	
	if(!empty($_POST['EmailAddress']) && !empty($_POST['em_PasswordQ']) && !empty($_POST['em_PasswordA']))
	{
		// get sent field values
		$sent_new_email = mysqli_real_escape_string($conn, trim($_POST['EmailAddress']));
		$sent_current_password_q = mysqli_real_escape_string($conn, trim($_POST['em_PasswordQ']));
		$sent_current_password_a = mysqli_real_escape_string($conn, trim($_POST['em_PasswordA']));
		
		// get current hashed password
		$get_current_q_a = mysqli_query($conn, "SELECT PasswordQuestion, PasswordAnswer FROM users WHERE UserName = '$user_name' Limit 1") 
		or die($dataaccess_error);
		
		if(mysqli_num_rows($get_current_q_a) == 1 )
		{
			$row = mysqli_fetch_array($get_current_q_a);
			$current_password_q = $row['PasswordQuestion'];
			$current_password_a = $row['PasswordAnswer'];
			
			// validate security question
			if($current_password_q != $sent_current_password_q)
			{
				$validate_error = 1;
				$msg .= $pw_q_no_match_msg;
			}
			
			// validate security answer
			if($current_password_a != $sent_current_password_a)
			{
				$validate_error = 1;
				$msg .= $pw_a_no_match_msg;
			}
			
			if(!filter_var($sent_new_email, FILTER_VALIDATE_EMAIL))
			{
				$msg .= $email_invalid_error;
				$validate_error = 1;
			}
			
			// if everything is validated  OK
			if($validate_error == 0)
			{
				// update password q and a
				$update_email = mysqli_query($conn, "UPDATE users SET Email = '$sent_new_email' WHERE UserName = '$user_name'") 
				or die($dataaccess_error);
				
				if(mysqli_affected_rows($conn) > 0)
				{
					if($email_email == 1)
					{
						require_once('email_new_email.php');
					}
					else
					{
						$msg = $email_update_success1;
					}
				}
				else
				{
					$msg = $email_update_failed;
				}
			}
		}
	}
}
?>