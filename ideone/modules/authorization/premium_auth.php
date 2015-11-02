<?php
//------------------------------------------------------------
// IF THIRD PASS = 1 - CHECK FOR PREMIUM ACCESS LEVELS
//------------------------------------------------------------

// DB: get membership info
$get_premium_info = mysqli_query($conn, "SELECT NOW() as CurrentTime, IsPremium, PremiumType, PremiumStartDate, PremiumEndDate, IsCancelled, CancelledDate, IsEndOfTerm, PremiumLevel FROM users WHERE UserName = '$premium_user_name' Limit 1") 
or die($dataaccess_error);

if(mysqli_num_rows($get_premium_info) == 1 )
{
	$row = mysqli_fetch_array($get_premium_info);
	$current_time = $row['CurrentTime'];
	$is_premium = $row['IsPremium'];
	$premium_type = $row['PremiumType'];
	$premium_start_date = $row['PremiumStartDate'];
	$premium_end_date = $row['PremiumEndDate'];
	$is_cancelled = $row['IsCancelled'];
	$cancelled_date = $row['CancelledDate'];
	$is_end_of_term = $row['IsEndOfTerm'];
	$user_premium_level = $row['PremiumLevel'];

	// if premium has expired - did not receive next payment
	if($is_premium == 1 && strtotime($premium_end_date) < strtotime($current_time) || $is_premium == 0 && $premium_end_date != '0000-00-00 00:00:00' && strtotime($premium_end_date) < strtotime($current_time))
	{		
		// set premium to 0
		$update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 0, PremiumLevel = 0 WHERE UserName = '$premium_user_name'") 
		or die($dataaccess_error);
	}
	
	// if membership has been cancelled and expired
	if($is_cancelled == 1 && strtotime($premium_end_date) < strtotime($current_time))
	{
		// reset membership in users table
		$update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 0, PremiumType = 'Free Membership', PremiumStartDate = '0000-00-00 00:00:00', PremiumEndDate = '0000-00-00 00:00:00', PremiumAmount = 0.00, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = 0 WHERE UserName = '$premium_user_name'") 
		or die($dataaccess_error);
	}

	// if eot has been sent by paypal and membership has expired
	if($is_end_of_term == 1 && strtotime($premium_end_date) < strtotime($current_time))
	{
		// reset membership in users table
		$update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 0, PremiumType = 'Free Membership', PremiumStartDate = '0000-00-00 00:00:00', PremiumEndDate = '0000-00-00 00:00:00', PremiumAmount = 0.00, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = 0 WHERE UserName = '$premium_user_name'") 
		or die($dataaccess_error);
	}
}
?>