<?php
// ------------------------------------------------------------
// CHECK FOR EMPTY FIELDS
// ------------------------------------------------------------
if(trim($txbUn == ""))
{
	$txbEmptyUn = $EmptyUn_msg;
	$emptyField_error = 1;
}
if(trim($txbPw == ""))
{
	$txbEmptyPw = $EmptyPw_msg;
	$emptyField_error = 1;
}
if(trim($txbConfirmPw == ""))
{
	$txbEmptyConfirmPw = $EmptyConfirmPw_msg;
	$emptyField_error = 1;
}
if(trim($txbEmail == ""))
{
	$txbEmptyEmail = $EmptyEmail_msg;
	$emptyField_error = 1;
}
if(trim($txbQuestion == ""))
{
	$txbEmptyQuestion = $EmptyQuestion_msg;
	$emptyField_error = 1;
}
if(trim($txbAnswer == ""))
{
	$txbEmptyAnswer = $EmptyAnswer_msg;
	$emptyField_error = 1;
}

// ------------------------------------------------------------
// DISPLAY ERROR BANNER ON TOP AND ECHO BACK ENTERED VALUES
// ------------------------------------------------------------
if($emptyField_error == 1)
{
	echo $displayBanner_error;
	
	$username = $txbUn;
	$email = $txbEmail;
	$question = $txbQuestion;
	$answer = $txbAnswer;
}
?>