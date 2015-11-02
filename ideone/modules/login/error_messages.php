<?php
// ------------------------------------------------------------
// MESSAGES, ERROR MESSAGES AND ERROR CODES
// ------------------------------------------------------------	
// form error variables
$emptyField_error = 0;

// general banner error message
$displayBanner_error = "<div class='msgBox1'>Oops! There were problems processing your form. Please review and correct the problems shown below.</div>";

// form error messages
$captcha_error = "<li>CAPTCHA is INCORRECT!</li>";
$dataaccess_error = "<div class='msgBox1'>ERROR: Oops! Database access FAILED!</div>";
$updateactivity_error = "<div class='msgBox1'>ERROR: Oops! Database update FAILED!</div>";
$authentication_error = "<div class='msgBox1'>ERROR: Authentication FAILED! The requested account may not EXIST, NOT APPROVED or is LOCKED OUT.</div>";
$accountnotfound_error = "<li>Account NOT FOUND!</li>";
$maxloginattempt_error = "<div class='msgBox4'>Oops! You have EXCEEDED the MAXIMUM number of LOGIN ATTEMPTS! You may try again in: ".LOCKOUT_DURATION." MINUTES.</div>";
$auth_role_error = "<div class='msgBox5'>You DO NOT have the Security Clearance to VIEW the requested PAGE.</div>";
$auth_token_error = "<div class='msgBox5'>Oops! Someone else LOGGED IN with YOUR account info in ANOTHER LOCATION. Account sharing is NOT ALLOWED.</div>";
$premium_access_error = "<div class='msgBox5'>You DO NOT have the PREMIUM ACCESS LEVEL to VIEW the requested PAGE.</div>";

// empty field error messages
$EmptyUn_msg = "<li>Please enter your USER NAME!</li>";
$EmptyPw_msg = "<li>Please enter your PASSWORD!</li>";
?>