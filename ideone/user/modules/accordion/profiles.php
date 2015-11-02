<?php
// declare variables
$msg = '';

// ------------------------------------------------------------
// UPDATE USER PROFILE
// ------------------------------------------------------------
if(isset($_POST['btnUpdatePf']))
{
	// check for field values
	if(!empty($_POST['FirstName']))
	{
		$first_name = mysqli_real_escape_string($conn, trim(htmlentities($_POST['FirstName'])));
	}
	else
	{
		$first_name = '';
	}
	
	if(!empty($_POST['LastName']))
	{
		$last_name = mysqli_real_escape_string($conn, trim(htmlentities($_POST['LastName'])));
	}
	else
	{
		$last_name = '';
	}
	
	if(!empty($_POST['CompanyName']))
	{
		$company_name = mysqli_real_escape_string($conn, trim(htmlentities($_POST['CompanyName'])));
	}
	else
	{
		$company_name = '';
	}
	
	if(!empty($_POST['Website']))
	{
		$website = mysqli_real_escape_string($conn, trim(htmlentities($_POST['Website'])));
	}
	else
	{
		$website = '';
	}
	
	if(!empty($_POST['ProfileTitle']))
	{
		$profile_title = mysqli_real_escape_string($conn, trim(htmlentities($_POST['ProfileTitle'])));
	}
	else
	{
		$profile_title = '';
	}
	
	if(!empty($_POST['ProfileText']))
	{
		$profile_text = mysqli_real_escape_string($conn, trim(htmlentities($_POST['ProfileText'])));
	}
	else
	{
		$profile_text = '';
	}
	
	if(!empty($_POST['Phone']))
	{
		$phone = mysqli_real_escape_string($conn, trim(htmlentities($_POST['Phone'])));
	}
	else
	{
		$phone = '';
	}
	
	if(!empty($_POST['Address']))
	{
		$address = mysqli_real_escape_string($conn, trim(htmlentities($_POST['Address'])));
	}
	else
	{
		$address = '';
	}
	
	if(!empty($_POST['Street']))
	{
		$street = mysqli_real_escape_string($conn, trim(htmlentities($_POST['Street'])));
	}
	else
	{
		$street = '';
	}
	
	if(!empty($_POST['City']))
	{
		$city = mysqli_real_escape_string($conn, trim(htmlentities($_POST['City'])));
	}
	else
	{
		$city = '';
	}
	
	if(!empty($_POST['State']))
	{
		$state = mysqli_real_escape_string($conn, trim(htmlentities($_POST['State'])));
	}
	else
	{
		$state = '';
	}
	
	if(!empty($_POST['Zip']))
	{
		$zip_code = mysqli_real_escape_string($conn, trim(htmlentities($_POST['Zip'])));
	}
	else
	{
		$zip_code = '';
	}
	
	if(!empty($_POST['Country']))
	{
		$country = mysqli_real_escape_string($conn, trim(htmlentities($_POST['Country'])));
	}
	else
	{
		$country = '';
	}

	// get user id
	$get_user_id = mysqli_query($conn, "SELECT UserId FROM users WHERE UserName = '$user_name' Limit 1") 
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_user_id) == 1 )
	{
		$row = mysqli_fetch_array($get_user_id);
		$user_id = $row['UserId'];
		
		// check if user profile already exist
		$check_user_profile = mysqli_query($conn, "SELECT UserId FROM profiles WHERE UserName = '$user_name' Limit 1") 
		or die($dataaccess_error);
		
		// if user profile exist - update
		if(mysqli_num_rows($check_user_profile) == 1 )
		{
			// update profiles
			$update_profile = mysqli_query($conn, "UPDATE profiles SET UserName = '$user_name', FirstName = '$first_name', LastName = '$last_name', CompanyName = '$company_name', WebSiteUrl = '$website', ProfileTitle = '$profile_title', ProfileText = '$profile_text', Phone = '$phone', Address = '$address', Street = '$street', City = '$city', State = '$state', Zip = '$zip_code', Country = '$country' WHERE UserName = '$user_name'") 
			or die($dataaccess_error);
			
			if(mysqli_affected_rows($conn) > 0)
			{
				$msg = $profile_update_success;
			}
			else
			{
				$msg = $profile_update_failed;
			}
		}
		else
		{
			// create profile
			$insert_profile = mysqli_query($conn, "INSERT INTO profiles(UserId,UserName,FirstName,LastName,CompanyName,WebsiteUrl,ProfileTitle,ProfileText,Phone,Address,Street,City,State,Zip,Country) VALUES($user_id,'$user_name','$first_name','$last_name','$company_name','$website','$profile_title','$profile_text','$phone','$address','$street','$city','$state','$zip_code','$country')") 
			or die($dataaccess_error);
			
			if(mysqli_affected_rows($conn) > 0)
			{
				$msg = $profile_update_success;
			}
			else
			{
				$msg = $profile_create_failed;
			}
		}
	}
	else
	{
		// user id not found
		$msg = $profile_update_failed2;
	}
}

// ------------------------------------------------------------
// DISPLAY USER PROFILE ON PAGE LOAD
// ------------------------------------------------------------
if($user_name)
{	
	// get user id
	$get_profile_details = mysqli_query($conn, "SELECT * FROM profiles WHERE UserName = '$user_name' Limit 1") 
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_profile_details) == 1 )
	{
		$row = mysqli_fetch_array($get_profile_details);
		$f_first_name = $row['FirstName'];
		$f_last_name = $row['LastName'];
		$f_company_name = $row['CompanyName'];
		if($row['WebsiteUrl'] == '')
		{
			$f_website = 'http://'.$row['WebsiteUrl'];
		}
		else
		{
			$f_website = $row['WebsiteUrl'];
		}
		$f_profile_title = $row['ProfileTitle'];
		$f_profile_text = $row['ProfileText'];
		$f_phone = $row['Phone'];
		$f_address = $row['Address'];
		$f_street = $row['Street'];
		$f_city = $row['City'];
		$f_state = $row['State'];
		$f_zip_code = $row['Zip'];
		$f_country = $row['Country'];
	}
	else
	{
		$f_first_name = '';
		$f_last_name = '';
		$f_company_name = '';
		$f_website = 'http://';
		$f_profile_title = '';
		$f_profile_text = '';
		$f_phone = '';
		$f_address = '';
		$f_street = '';
		$f_city = '';
		$f_state = '';
		$f_zip_code = '';
		$f_country = '';
	}
}
?>