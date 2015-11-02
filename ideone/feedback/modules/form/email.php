<?php
//------------------------------------------------------------
// SEND EMAIL
//------------------------------------------------------------
if(isset($_POST['btnSubmit']))
{
	require_once(ROOT_PATH.'feedback/modules/form/error_messages.php');
	
	// captcha error variable
	$captcha_error = 0;
	
	//------------------------------------------------------------
	// 1. CHECK IF CAPTCHA IS TURNED ON
	//------------------------------------------------------------
	$is_captcha_on = FEEDBACK_CAPTCHA_ON;
	if($is_captcha_on == 1)
	{
		require_once(ROOT_PATH.'lib/recaptchalib.php');
		$privatekey = RECAPTCHA_PRIVATE_KEY;
		$resp = recaptcha_check_answer
		(
			$privatekey,
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]
		);
		
		// if captcha is not valid
		if (!$resp->is_valid) 
		{
			$captcha_error = 1;
			echo $captcha_incorrect;
		}
		// if captcha is valid
		else
		{
			$captcha_error = 0;
		}
	}
	
	//------------------------------------------------------------
	// 2. IF CAPTCHA ERROR IS ZERO (0)
	//------------------------------------------------------------
	if($captcha_error == 0)
	{
		//------------------------------------------------------------
		// 1. FOR CATEGORY OTHER
		//------------------------------------------------------------
		if(isset($_GET['cid']) && !empty($_GET['cid']) && isset($_GET['cat']) && !empty($_GET['cat']))
		{
			// validate form fields
			if(isset($_POST['issue']) && !empty($_POST['issue']))
			{
				// create variables
				$cid = mysqli_real_escape_string($conn, $_GET['cid']);
				$cat = mysqli_real_escape_string($conn, $_GET['cat']);
				$issue_text = strip_tags($_POST['issue']);
				$email_address = mysqli_real_escape_string($conn, $_POST['email']);
				
				// calculate max allowed chars.
				$textLength = strlen($issue_text);
				$word_count = count(explode(" ", $issue_text));
				$allowedLength = MAX_FEEDBACK_LENGTH;
				$minLength = MIN_FEEDBACK_LENGTH;
				$minWords = MIN_FEEDBACK_WORDS;
				$lengthDiff = ($textLength-$allowedLength);
				
				if(strlen($issue_text) > $allowedLength)
				{
					echo '<div class="error_msg">'.$lengthDiff.' characters Too Long!</div>';
				}
				elseif(strlen($issue_text) < $minLength)
				{
					echo '<div class="error_msg">Too Short! min.'.$minLength.' chars. required</div>';
				}
				elseif($word_count < $minWords)
				{
					echo $text_too_short;
				}
				elseif(strlen($issue_text) < $allowedLength)
				{
					// send email here
					$from_address = NO_REPLY;
					$to = GENERAL_CONTACT;
					$subject = 'Website Feedback';
					$message = '
					<html>
					<head>
						<title>Website Feedback</title>
					</head>
					<body>
						<p>Hello Admin,</p>
						<p>You have received a website feedback.</p>
						<p>Category Id: '.$cid.' <br/>Category Name: '.$cat.'</p>
						<p>'.$issue_text.'</p>
						<p>E-mail Address: '.$email_address.'</p>
						<p>Visitor IP Address: '.$_SERVER['REMOTE_ADDR'].'</p>
					</body>
					</html>
					';
					
					// ------------------------------------------------------------------
					// SET HEADERS FOR HTML MAIL
					// ------------------------------------------------------------------
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Website Feedback <'.$from_address.'>' . "\r\n";
					
					// ------------------------------------------------------------------
					// SEND E-MAIL
					// ------------------------------------------------------------------
					$send_email = mail($to, $subject, $message, $headers);
					if($send_email)
					{
						echo $email_sent_success;
					}
					else
					{
						echo $email_send_error;
					}
				}
			}
			else
			{
				echo $empty_form_error;
			}
		}
		
		//------------------------------------------------------------
		// 2. IF SUBCATEGORY
		//------------------------------------------------------------
		if(isset($_GET['scid']) && !empty($_GET['scid']) && isset($_GET['scat']) && !empty($_GET['scat']))
		{
			// validate form fields
			if(isset($_POST['issue']) && !empty($_POST['issue']))
			{
				// create variables
				$cat = mysqli_real_escape_string($conn, $_GET['cat']);
				$scat = mysqli_real_escape_string($conn, $_GET['scat']);
				$issue_text = strip_tags($_POST['issue']);
				$email_address = mysqli_real_escape_string($conn, $_POST['email']);
				
				// calculate max allowed chars.
				$textLength = strlen($issue_text);
				$word_count = count(explode(" ", $issue_text));
				$allowedLength = MAX_FEEDBACK_LENGTH;
				$minLength = MIN_FEEDBACK_LENGTH;
				$minWords = MIN_FEEDBACK_WORDS;
				$lengthDiff = ($textLength-$allowedLength);
				
				if(strlen($issue_text) > $allowedLength)
				{
					echo '<div class="error_msg">'.$lengthDiff.' characters Too Long!</div>';
				}
				elseif(strlen($issue_text) < $minLength)
				{
					echo '<div class="error_msg">Too Short! min.'.$minLength.' chars. required</div>';
				}
				elseif($word_count < $minWords)
				{
					echo $text_too_short;
				}
				elseif(strlen($issue_text) < $allowedLength)
				{
					// send email here
					$from_address = NO_REPLY;
					$to = GENERAL_CONTACT;
					$subject = 'Website Feedback';
					$message = '
					<html>
					<head>
						<title>Website Feedback</title>
					</head>
					<body>
						<p>Hello Admin,</p>
						<p>You have received a website feedback.</p>
						<p>Category: '.$cat.' <br/>Subcategory: '.$scat.'</p>
						<p>'.$issue_text.'</p>
						<p>E-mail Address: '.$email_address.'</p>
						<p>Visitor IP Address: '.$_SERVER['REMOTE_ADDR'].'</p>
					</body>
					</html>
					';
					
					// ------------------------------------------------------------------
					// SET HEADERS FOR HTML MAIL
					// ------------------------------------------------------------------
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Website Feedback <'.$from_address.'>' . "\r\n";
					
					// ------------------------------------------------------------------
					// SEND E-MAIL
					// ------------------------------------------------------------------
					$send_email = mail($to, $subject, $message, $headers);
					if($send_email)
					{
						echo $email_sent_success;
					}
					else
					{
						echo $email_send_error;
					}
				}
			}
			else
			{
				echo $empty_form_error;
			}
		}
	}
}
?>