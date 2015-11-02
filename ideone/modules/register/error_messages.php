<?php
// ------------------------------------------------------------
// MESSAGES, ERROR MESSAGES AND ERROR CODES
// ------------------------------------------------------------	
// form error variables
$emptyField_error = 0;
$passwordMatch_error = 0;
$emailValidate_error = 0;
$pwMinRequirements_error = 0;

// general banner error message
$displayBanner_error = "<div class='msgBox1'>Oops! There were problems processing your form. Please review and correct the problems shown below.</div>";
$registration_not_enabled = "<div class='msgBox1'>Oops! Registration is currently NOT AVAILABLE...</div>";

// form error messages
$captcha_error = "<li>CAPTCHA is INCORRECT!</li>";
$password_error = "<li>PASSWORD and CONFIRM PASSWORD must match!</li>";
$passwordLength_error = "<li>PASSWORD is TOO SHORT!</li>";
$passwordNumber_error = "<li>PASSWORD MUST CONTAIN a NUMBER!</li>";
$passwordSpecialChar_error = "<li>PASSWORD MUST CONTAIN a SPECIAL CHARACTER!</li>";
$userName_error = "<li>USER NAME OR E-MAIL already EXIST!</li>";
$username_in_password_error = "<li>USER NAME Cannot be present in PASSWORD!</li>";
$checkUser_error = "<div class='msgBox1'>ERROR: Oops! CHECK user FAILED!</div>";
$createUser_error = "<div class='msgBox1'>ERROR: Oops! CREATE user FAILED!</div>";
$addUserToRole_error = "<div class='msgBox1'>ERROR: Oops! ADDING user to default ROLE FAILED!</div>";
$email_error = "<li>INCORRECT E-MAIL address!</li>";
$emailMx_error = "<li>Oops! NOT a VALID E-MAIL address!</li>";
$activation_error = "<div class='msgBox1'>ERROR: Oops! VERIFICATION process FAILED!</div>";
$alreadyactive_error = "<div class='msgBox3'>ERROR: Oops! Your ACCOUNT is ALREADY ACTIVE!</div>";

// empty field error messages
$EmptyUn_msg = "<li>Please enter your USER NAME!</li>";
$EmptyCheckUn_msg = "<li>Please enter the desired USER NAME to CHECK for!</li>";
$EmptyPw_msg = "<li>Please enter your PASSWORD!</li>";
$EmptyConfirmPw_msg = "<li>Please confirm your PASSWORD!</li>";
$EmptyEmail_msg = "<li>Please enter your E-MAIL!</li>";
$EmptyQuestion_msg = "<li>Please enter your SECURITY QUESTION!</li>";
$EmptyAnswer_msg = "<li>Please enter your SECURITY ANSWER!</li>";

// confirmation messages
$confirmEmail_msg = "<div class='msgBox2'>THANK YOU! A CONFIRMATION E-MAIL has been sent to you. Please click on the link within the email to ACTIVATE your account <a class='floatRight' href='./login.php'>Login</a> </div>";
$confirmactivation_msg = "<div class='msgBox2'>THANK YOU! Your ACCOUNT has been CONFIRMED and is now ACTIVE! Please proceed to the LOGIN page to LOGIN. <a class='floatRight' href='./login.php'>Login</a> </div>";
$activation_pending_msg = "<div class='msgBox3'>THANK YOU! Your ACCOUNT is now waiting for APPROVAL by the Administrator. You will receive a CONFIRMATION E-MAIL shortly ...</div>";
$userNameAvailable_msg = "<li>User Name is AVAILABLE!</li>";
$userNameNotAvailable_msg = "<li>User Name is ALREADY TAKEN!</li>";
?>