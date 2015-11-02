<?php
// declare variables
$msg = '';

// ------------------------------------------------------------
// UPDATE USER PASSWORD
// ------------------------------------------------------------
if(isset($_POST['btnUpdatePwQa']))
{
	$validate_error = 0;

	// check for empty fields
	if(empty($_POST['PasswordQ']))
	{
		$validate_error = 1;
		$msg = $pw_q_empty_msg;
	}
	
	if(empty($_POST['PasswordA']))
	{
		$validate_error = 1;
		$msg .= $pw_a_empty_msg;
	}
	
	if(empty($_POST['qa_PasswordQ']))
	{
		$validate_error = 1;
		$msg .= $pw_q_empty_msg;
	}
	
	if(empty($_POST['qa_PasswordA']))
	{
		$validate_error = 1;
		$msg .= $pw_a_empty_msg;
	}
	
	if(isset($_POST['email_qa']))
	{
		$email_qa = 1;
	}
	else
	{
		$email_qa = 0;
	}
	
	if(isset($_POST['include_qa']))
	{
		$include_qa = 1;
	}
	else
	{
		$include_qa = 0;
	}
	
	if(!empty($_POST['PasswordQ']) && !empty($_POST['PasswordA']))
	{
		// get sent field values
		$sent_new_password_q = mysqli_real_escape_string($conn, trim($_POST['PasswordQ']));
		$sent_new_password_a = mysqli_real_escape_string($conn, trim($_POST['PasswordA']));
		$sent_current_password_q = mysqli_real_escape_string($conn, trim($_POST['qa_PasswordQ']));
		$sent_current_password_a = mysqli_real_escape_string($conn, trim($_POST['qa_PasswordA']));
		
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
			
			// if everything is validated  OK
			if($validate_error == 0)
			{
				// update password q and a
				$update_password_qa = mysqli_query($conn, "UPDATE users SET PasswordQuestion = '$sent_new_password_q', PasswordAnswer = '$sent_new_password_a' WHERE UserName = '$user_name'") 
				or die($dataaccess_error);
				
				if(mysqli_affected_rows($conn) > 0)
				{
					if($email_qa == 1)
					{
						require_once('email_new_qa.php');
					}
					else
					{
						$msg = $pw_qa_success1;
					}
				}
				else
				{
					$msg = $pw_qa_failed;
				}
			}
		}
	}
}
?>