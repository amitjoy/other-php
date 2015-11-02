<?php 
// define undefined variables
$txbEmptyUn = '';
$txbUserNameCheck = '';
$txbEmptyPw = '';
$txbEmptyConfirmPw = '';
$passwordMismatch = '';
$passwordTooShort = '';
$passwordNumber = '';
$passwordChar = '';
$userExist = '';
$userInPw = '';
$emailNotValid = '';
$txbEmptyEmail = '';
$txbEmptyQuestion = '';
$txbEmptyAnswer = '';
$txbInvalidCaptcha = '';
$username = '';
$email = '';
$question = '';
$answer = '';
// ------------------------------------------------------------
// USER NAME CHECK SUBMIT
// ------------------------------------------------------------	
require_once(ROOT_PATH.'modules/register/username_check.php');

// ------------------------------------------------------------
// REGISTER FORM SUBMIT
// ------------------------------------------------------------
if(isset($_POST['btnSubmit']))
{
	// ------------------------------------------------------------
	// MESSAGES, ERROR MESSAGES AND ERROR CODES
	// ------------------------------------------------------------	
	require_once(ROOT_PATH.'modules/register/error_messages.php');
		
	// ------------------------------------------------------------
	// SET VARIABLES FOR SUBMITTED FORM VALUES and sanitize
	// ------------------------------------------------------------
	$txbUn = strip_tags(strtolower($_POST['txbUn']));
	$txbPw = strip_tags($_POST['txbPw']);
	$txbConfirmPw = strip_tags($_POST['txbConfirmPw']);
	$txbEmail = strtolower($_POST['txbEmail']);
	$txbQuestion = strip_tags($_POST['txbQuestion']);
	$txbAnswer = strip_tags($_POST['txbAnswer']);

	// ------------------------------------------------------------
	// CHECK PASSWORD AND CONFIRM PASSWORD MATCH
	// ------------------------------------------------------------
	require_once(ROOT_PATH.'modules/register/password_match.php');
	
	// ------------------------------------------------------------
	// CHECK PASSWORD MINIMUM REQUIREMENTS
	// ------------------------------------------------------------
	require_once(ROOT_PATH.'modules/register/password_requirements.php');
	
	// ------------------------------------------------------------
	// VALIDATE E-MAIL
	// ------------------------------------------------------------
	require_once(ROOT_PATH.'modules/register/validate_email.php');
	
	// ------------------------------------------------------------
	// CHECK IF TEXTBOXES ARE FILLED AND EVERYTHING VALIDATED
	// ------------------------------------------------------------
	if
	(
		!empty($txbUn) && 
		!empty($txbPw) && 
		!empty($txbConfirmPw) && 
		!empty($txbEmail) && 
		!empty($txbQuestion)&& 
		!empty($txbAnswer) && 
		$passwordMatch_error == 0 && 
		$emailValidate_error == 0 && 
		$pwMinRequirements_error == 0
	)
	{
		//------------------------------------------------------------
		// include db connection and hasher
		//------------------------------------------------------------
		require_once(ROOT_PATH.'connect/mysql.php');
		require_once(ROOT_PATH.'lib/hasher.fn.php');

		// ------------------------------------------------------------
		// SET VARIABLES FOR DB CHECK
		// ------------------------------------------------------------
		$username4db = mysqli_real_escape_string($conn, $txbUn);
		$email4db = mysqli_real_escape_string($conn, $txbEmail);
		
		// DB QUERY: check for DUPLICATE username and/or email - both must be unique
		// ------------------------------------------------------------
		$checkuser = mysqli_query($conn, "SELECT UserName, Email FROM users WHERE UserName = '$username4db' OR EMAIL = '$email4db'") 
		or die($checkUser_error);
		// ------------------------------------------------------------
		
		// if user name or email does NOT exist yet validation is ok
		if(mysqli_num_rows($checkuser) == 0 && $passwordMatch_error == 0 && $emailValidate_error == 0 && $pwMinRequirements_error == 0)
		{
			// create hashed password and activation key
			$hashedPw = hashThis($txbPw);
			$ActivationKey = hashThis($txbUn);
			
			// check for account approval type
			$adminApproval = BY_ADMIN_APPROVAL_ONLY;
			$instantApproval = INSTANT_ACCOUNT_APPROVAL;
			
			if($adminApproval == 1 && $instantApproval == 0)
			{
				$is_approved = 0;
			}
			
			if($adminApproval == 1 && $instantApproval == 1)
			{
				$is_approved = 0;
			}
			
			if($adminApproval == 0 && $instantApproval == 0)
			{
				$is_approved = 0;
			}
			
			if($adminApproval == 0 && $instantApproval == 1)
			{
				$is_approved = 1;
			}
			
			// DB QUERY: CREATE new user 
			// ------------------------------------------------------------
			$createuser = mysqli_query($conn, "INSERT INTO users(UserName, Password, PasswordQuestion, PasswordAnswer, Email, IsApproved, CreateDate, LastActivityDate, ActivationKey) VALUES('$txbUn', '$hashedPw', '$txbQuestion', '$txbAnswer', '$txbEmail', $is_approved, NOW(), NOW(), '$ActivationKey')") 
			or die($createUser_error);
			// ------------------------------------------------------------
			
			if($createuser)
			{
				// get the last insert id
				$lastInsertId = mysqli_insert_id($conn);
				$defaultRole = DEFAULT_ROLE;
				$defaultRoleId = DEFAULT_ROLE_ID;
				
				// DB QUERY: ADD NEW USER to DEFAULT ROLE
				// ------------------------------------------------------------
				$addusertorole = mysqli_query($conn, "INSERT INTO users_in_roles(UserId, RoleId, RoleName) VALUES ($lastInsertId, $defaultRoleId, '$defaultRole')") 
				or die($addUserToRole_error);
				// ------------------------------------------------------------
				
				// ------------------------------------------------------------
				// IF ADMIN MUST APPROVE ALL ACCOUNTS
				// ------------------------------------------------------------
				if($adminApproval == 1)
				{
					echo $activation_pending_msg;
				}
				elseif($adminApproval == 0)
				{
					// ------------------------------------------------------------
					// IF INSTANT APPROVAL IS NOT ON - SEND CONFIRMATION E-MAIL
					// ------------------------------------------------------------
					if($addusertorole && $instantApproval == 0)
					{
						require_once(ROOT_PATH.'modules/register/send_confirmation.php');
						echo $confirmEmail_msg;
					}
					// ------------------------------------------------------------
					// OTHERWISE ONLY DISPLAY SUCCESS MESSAGE
					// ------------------------------------------------------------
					elseif($addusertorole && $instantApproval == 1)
					{
						echo $confirmactivation_msg;
					}
				}
			}
			else
			{
				echo $displayBanner_error;
			}
		}
		// ------------------------------------------------------------
		// IF USER NAME OR E-MAIL ALREADY EXIST
		// ------------------------------------------------------------
		elseif(mysqli_num_rows($checkuser) > 0)
		{
			$userExist = $userName_error;
			echo $displayBanner_error;
		}
	}
	// ------------------------------------------------------------
	// CHECK FOR EMPTY FIELDS
	// ------------------------------------------------------------
	require_once(ROOT_PATH.'modules/register/empty_fields_check.php');
}
?>