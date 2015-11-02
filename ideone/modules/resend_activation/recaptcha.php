<?php
// define undefined variables
$txbEmptyUn = '';
$txbInvalidCaptcha = '';
$accountNotFound = '';
$thankyou = '';
$txbUsername = '';
      
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
    require_once(ROOT_PATH.'modules/resend_activation/error_messages.php');

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
            $checkusername = mysqli_query($conn, "SELECT UserName, Email, ActivationKey FROM users WHERE UserName = '$username' LIMIT 1")
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
				$accountemail = $row['Email'];
                $activationkey = $row['ActivationKey'];

				// send activation email
				require_once(ROOT_PATH.'modules/resend_activation/resend_activation.php');
				
				// show confirmation
				echo $confirmCompletion_msg;
				$thankyou = $confirmCompletion2_msg;
            }
			// ------------------------------------------------------------
            // SHOW AUTHENTICATION ERROR
            // ------------------------------------------------------------
			else 
			{
                echo $authentication_error;
                $accountNotFound = $accountnotfound_error;
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