<?php
// define undefined variables
$txbEmptyUn = '';
$txbEmptyAnswer = '';
$txbInvalidCaptcha = '';
$accountNotFound = '';
$incorrectAnswer = '';
$thankyou = '';
$txbUsername = '';
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
    require_once(ROOT_PATH.'modules/recover_pw/error_messages.php');

    // ------------------------------------------------------------
    // SET VARIABLES FOR SUBMITTED FORM VALUES and sanitize
    // ------------------------------------------------------------
    $txbUn = strip_tags(strtolower($_POST['txbUn']));

    // ------------------------------------------------------------
    // IF CAPTCHA IS NOT VALID
    // ------------------------------------------------------------
    if (!$resp->is_valid) 
	{
        // captcha invalid
        $txbInvalidCaptcha = $captcha_error;
        $txbUsername = $txbUn;
		echo $displayBanner_error;
    }
    // ------------------------------------------------------------
    // IF CAPTCHA IS VALID
    // ------------------------------------------------------------
    else {
        if(!empty($txbUn)) 
		{
			//------------------------------------------------------------
            // include db connection
            //------------------------------------------------------------
            require_once(ROOT_PATH.'connect/mysql.php');

            // ------------------------------------------------------------
            // SET VARIABLES FOR DB CHECK
            // ------------------------------------------------------------
            $username = mysqli_real_escape_string($conn, $txbUn);

            // DB QUERY: lookup security answer in db
            // ------------------------------------------------------------
            $checkusername = mysqli_query($conn, "SELECT UserName, PasswordQuestion, PasswordAnswer, Email FROM users WHERE UserName = '$username' LIMIT 1")
            or die($dataaccess_error);
            // ------------------------------------------------------------
            
			// ------------------------------------------------------------
            // IF AUTHENTICATED OK
            // ------------------------------------------------------------
            if (mysqli_num_rows($checkusername) == 1) 
			{
                // get values from db
				$row = mysqli_fetch_array($checkusername);
				$accountname = $row['UserName'];
                $securityquestion = $row['PasswordQuestion'];
                $securityanswer = $row['PasswordAnswer'];
				$accountemail = $row['Email'];

				// echo back form values
                $txbUsername = $txbUn;
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
			
			if(mysqli_num_rows($checkusername) == 1 && empty($txbAnswer))
			{
				echo $provideAnswer_msg;
				$txbEmptyAnswer = $EmptyAnswer_msg;
				$showfields = 1;
			}
			
			// ------------------------------------------------------------
            // IF ANSWER BOX NOT EMPTY BUT ANSWERS DON'T MATCH
            // ------------------------------------------------------------
			if(mysqli_num_rows($checkusername) == 1 && !empty($txbAnswer) && $securityanswer != $txbAnswer)
			{
				echo $provideAnswer_msg;
				$incorrectAnswer = $securityanswer_error;
				$showfields = 1;
			}
			
			// ------------------------------------------------------------
            // IF ALL IS IN ORDER! - SEND NEW PASSWORD TO USER
            // ------------------------------------------------------------
			if(mysqli_num_rows($checkusername) == 1 && $securityanswer == $txbAnswer)
			{
				// create and send new password
				require_once(ROOT_PATH.'modules/recover_pw/send_new_password.php');
				
				$showfields = 0;
				$txbUsername = "";
				echo $confirmCompletion_msg;
				$thankyou = $confirmCompletion2_msg;
			}
        }
		else
		{
			echo $displayBanner_error;
			$txbEmptyUn = $EmptyUn_msg;
		}
    }
}
?>