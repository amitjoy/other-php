<?php
// ------------------------------------------------------------
// CHECK PASSWORD AND CONFIRM PASSWORD MATCH
// ------------------------------------------------------------
if($txbConfirmPw != $txbPw)
{
	$passwordMismatch = $password_error;
	$emptyField_error = 1;
	$passwordMatch_error = 1;
}
?>