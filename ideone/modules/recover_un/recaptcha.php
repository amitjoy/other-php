<?php
// define undefined variables
$txbEmptyEmail = '';
$txbEmptyAnswer = '';
$txbInvalidCaptcha = '';
$accountNotFound = '';
$incorrectAnswer = '';
$thankyou = '';
$txbEmail = '';
$txbQuestion = '';
$showfields = 0;
$txbAnswer = '';
      
if (isset($_POST['btnSubmit'])) 
{
    // recaptcha validation starts here...
    require_once(ROOT_PATH.'lib/recaptchalib.php');
    $privatekey = RECAPTCHA_PRIVATE_KEY;
    $resp = recaptcha_check_answer
    (
        $privatekey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]
    );

    // ------------------------------------------------------------
    // MESSAGES, ERROR MESSAGES AND ERROR CODES
    // ------------------------------------------------------------
    require_once(ROOT_PATH.'modules/recover_un/error_messages.php');

    // ------------------------------------------------------------
    // SET VARIABLES FOR SUBMITTED FORM VALUES and sanitize
    // ------------------------------------------------------------
    $txbEmail = strip_tags(strtolower($_POST['txbEmail']));

    // ------------------------------------------------------------
    // IF CAPTCHA IS NOT VALID
    // ------------------------------------------------------------
    if (!$resp->is_valid) 
	{
        // captcha invalid
        $txbInvalidCaptcha = $captcha_error;
        $txbEmail = $txbEmail;
		echo $displayBanner_error;
    }
    // ------------------------------------------------------------
    // IF CAPTCHA IS VALID
    // ------------------------------------------------------------
    else {
        if(!empty($txbEmail)) 
		{
			//------------------------------------------------------------
            // include db connection
            //------------------------------------------------------------
            require_once(ROOT_PATH.'connect/mysql.php');

            // ------------------------------------------------------------
            // SET VARIABLES FOR DB CHECK
            // ------------------------------------------------------------
            $user_email = mysqli_real_escape_string($conn, $txbEmail);

            // DB QUERY: lookup security answer in db
            // ------------------------------------------------------------
            $checkemail = mysqli_query($conn, "SELECT UserName, PasswordQuestion, PasswordAnswer, Email FROM users WHERE Email = '$user_email' LIMIT 1")
            or die($dataaccess_error);
            // ------------------------------------------------------------
            
			// ------------------------------------------------------------
            // IF AUTHENTICATED OK
            // ------------------------------------------------------------
            if (mysqli_num_rows($checkemail) == 1) 
			{
                // get values from db
				$row = mysqli_fetch_array($checkemail);
				$accountname = $row['UserName'];
                $securityquestion = $row['PasswordQuestion'];
                $securityanswer = $row['PasswordAnswer'];
				$accountemail = $row['Email'];

				// echo back form values
                $txbEmail = $txbEmail;
                $txbQuestion = $securityquestion;
				
				// display question and answer fields
				$showfields = 1;
            }
			// ------------------------------------------------------------
            // SHOW AUTHENTICATION ERROR
            // ------------------------------------------------------------
			else 
			{
                echo $authentication_error;
                $accountNotFound = $accountnotfound_error;
				$showfields = 0;
            }
			
			// ------------------------------------------------------------
            // IF ANSWER BOX IS LEFT EMPTY
            // ------------------------------------------------------------
			if(!empty($_POST['txbAnswer']))
			{
				// set variable for answer value
				$txbAnswer = strip_tags($_POST['txbAnswer']);
			}
			
			if(mysqli_num_rows($checkemail) == 1 && empty($txbAnswer))
			{
				echo $provideAnswer_msg;
				$txbEmptyAnswer = $EmptyAnswer_msg;
				$showfields = 1;
			}
			
			// ------------------------------------------------------------
            // IF ANSWER BOX NOT EMPTY BUT ANSWERS DON'T MATCH
            // ------------------------------------------------------------
			if(mysqli_num_rows($checkemail) == 1 && !empty($txbAnswer) && $securityanswer != $txbAnswer)
			{
				echo $provideAnswer_msg;
				$incorrectAnswer = $securityanswer_error;
				$showfields = 1;
			}
			
			// ------------------------------------------------------------
            // IF ALL IS IN ORDER! - SEND USER NAME TO USER
            // ------------------------------------------------------------
			if(mysqli_num_rows($checkemail) == 1 && $securityanswer == $txbAnswer)
			{
				// send user name
				require_once(ROOT_PATH.'modules/recover_un/send_user_name.php');
				
				$showfields = 0;
				$txbEmail = "";
				echo $confirmCompletion_msg;
				$thankyou = $confirmCompletion2_msg;
			}
        }
		else
		{
			echo $displayBanner_error;
			$txbEmptyEmail = $EmptyEmail_msg;
		}
    }
}
?>