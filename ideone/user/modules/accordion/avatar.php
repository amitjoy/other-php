<?php
// declare variables
$msg = '';
$f_avatar_image = '';
// ------------------------------------------------------------
// UPLOAD AVATAR
// ------------------------------------------------------------
if(isset($_POST['btnUploadAvatar']) && !empty($_FILES['fileUpload']['name']))
{
	// create variables
	$avatar_directory = AVATAR_FILE_DIRECTORY;
	$file_name = $_FILES['fileUpload']['name'];
	$file_type = $_FILES['fileUpload']['type'];
	$file_size = $_FILES['fileUpload']['size'];
	$file_size_limit = AVATAR_FILE_SIZE;
	$calc_kilobites = 1024;
	$file_size_kb = round($file_size / $calc_kilobites, 2);
	$temp_file_name = $_FILES['fileUpload']['tmp_name'];
	$upload_error = $_FILES['fileUpload']['error'];
	
	// create unique file name
	$unique_file_name = $user_name.'-'.$file_name;
	$avatar_img_url = AVATAR_IMAGE_URL.$user_name.'-'.$file_name;
	
	// if upload error display error message
	if($upload_error > 0)
	{
		echo 'ERROR:' . $upload_error;
	}
	
	// if no upload error - check for file types
	if($upload_error == 0 && 
	$file_type == 'image/gif' || 
	$file_type == 'image/jpeg' || 
	$file_type == 'image/png' )
	{
		// if file size is within limits
		if($file_size <= $file_size_limit)
		{
			// move uploaded file to assigned directory
			if(move_uploaded_file($temp_file_name, $avatar_directory . $unique_file_name))
			{
				// get user id
				$get_user_id = mysqli_query($conn, "SELECT UserId FROM users WHERE UserName = '$user_name' Limit 1") 
				or die($dataaccess_error);
				
				// if user id exist
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
						$update_profile = mysqli_query($conn, "UPDATE profiles SET AvatarImage = '$avatar_img_url' WHERE UserName = '$user_name'") 
						or die($dataaccess_error);
						
						if(mysqli_affected_rows($conn) > 0)
						{
							echo 'Upload Success! <br/>';
							echo 'File Name: '.$file_name.'<br/>';
							echo 'File Type: '.$file_type.'<br/>';
							echo 'File Size: '.$file_size_kb.' Kb <br/>';
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
						$insert_profile = mysqli_query($conn, "INSERT INTO profiles(UserId,UserName,AvatarImage) VALUES($user_id,'$user_name','$avatar_img_url')") 
						or die($dataaccess_error);
						
						if(mysqli_affected_rows($conn) > 0)
						{
							echo 'Upload Success! <br/>';
							echo 'File Name: '.$file_name.'<br/>';
							echo 'File Type: '.$file_type.'<br/>';
							echo 'File Size: '.$file_size_kb.' Kb <br/>';
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
			else
			{
				$msg = $avatar_upload_failed;
			}
		}
		else
		{
			$msg = $avatar_file_too_large;
		}
	}
	else
	{
		$msg = $avatar_wrong_file_type;
	}
	
}
elseif(isset($_POST['btnUploadAvatar']) && empty($_FILES['fileUpload']['name']))
{
	$msg = $avatar_empty;
}

// ------------------------------------------------------------
// DISPLAY AVATAR ON PAGE LOAD
// ------------------------------------------------------------
if($user_name)
{
	// get user id
	$get_avatar_image = mysqli_query($conn, "SELECT AvatarImage FROM profiles WHERE UserName = '$user_name' Limit 1") 
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_avatar_image) == 1)
	{
		$row = mysqli_fetch_array($get_avatar_image);
		if($row['AvatarImage'] != 'NULL' && $row['AvatarImage'] != '')
		{
			$f_avatar_image = $row['AvatarImage'];
		}
		else
		{
			$f_avatar_image = AVATAR_IMAGE_URL.DEFAULT_AVATAR_IMAGE;
		}
	}
	else
	{
		$f_avatar_image = AVATAR_IMAGE_URL.DEFAULT_AVATAR_IMAGE;
	}
}
?>