<?php
// declare variables
$msg = '';
$newsletter = 0;
$newsletter_0 = 0;
$newsletter_1 = 0;
$promotion = 0;
$promotion_0 = 0;
$promotion_1 = 0;

// ------------------------------------------------------------
// UPDATE NEWSLETTER AND PROMOTIONAL OFFERS
// ------------------------------------------------------------
if(isset($_POST['btnUpdateNewsletter']))
{
	// check for newsletter
	if(isset($_POST['newsletter']) && is_numeric($_POST['newsletter']) && $_POST['newsletter'] >= 0 || $_POST['newsletter'] <=1)
	{
		$newsletter = mysqli_real_escape_string($conn, $_POST['newsletter']);
	}
	else
	{
		die($invalid_value);
	}
	
	// check for promotional offers
	if(isset($_POST['promotion']) && is_numeric($_POST['promotion']) && $_POST['promotion'] >= 0 || $_POST['promotion'] <=1)
	{
		$promotion = mysqli_real_escape_string($conn, $_POST['promotion']);
	}
	else
	{
		die($invalid_value);
	}
	
	// check if user profile already exist
	$check_user_profile = mysqli_query($conn, "SELECT UserName FROM profiles WHERE UserName = '$user_name' Limit 1") 
	or die($dataaccess_error);
	
	// if user profile exist - update
	if(mysqli_num_rows($check_user_profile) == 1 )
	{
		// ------------------------------------------------------------
		// DB: update newsletter and promotional offer
		$update_profiles = mysqli_query($conn, "UPDATE profiles SET Newsletter = $newsletter, Promotion = $promotion WHERE UserName = '$user_name'") 
		or die($dataaccess_error);
		// ------------------------------------------------------------
		
		if(mysqli_affected_rows($conn) > 0)
		{
			$msg = $newsletter_update_success;
		}
		else
		{
			$msg = $newsletter_update_failed;
		}
	}
	else
	{
		$msg = $profile_not_found;
	}
}

// ------------------------------------------------------------
// DISPLAY CHECKBOX SELECTIONS ON PAGE LOAD
// ------------------------------------------------------------
if($user_name)
{
	// ------------------------------------------------------------
	// DB: get current subscription
	$get_subscription = mysqli_query($conn, "SELECT Newsletter, Promotion FROM profiles WHERE UserName = '$user_name' Limit 1") 
	or die($dataaccess_error);
	// ------------------------------------------------------------
	
	if(mysqli_num_rows($get_subscription) == 1 )
	{
		$row = mysqli_fetch_array($get_subscription);
		$newsletter_value = $row['Newsletter'];
		$promotion_value = $row['Promotion'];
		
		// check newsletter checkbox?
		if($newsletter_value == 1)
		{
			$newsletter_1 = 'checked="checked"';
		}
		elseif($newsletter_value == 0)
		{
			$newsletter_0 = 'checked="checked"';
		}
		
		// check promotion checkbox?
		if($promotion_value == 1)
		{
			$promotion_1 = 'checked="checked"';
		}
		elseif($promotion_value == 0)
		{
			$promotion_0 = 'checked="checked"';
		}
	}
	else
	{
		$newsletter_0 = 'checked="checked"';
		$promotion_0 = 'checked="checked"';
	}
}
?>