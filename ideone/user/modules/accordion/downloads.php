<?php
// declare variables
$msg = '';
$available_downloads = '';

// ------------------------------------------------------------
// 1. DISPLAY AVAILABLE DOWNLOADS
// ------------------------------------------------------------
if($user_name)
{	
	// get current user's premium level
	$get_user_premium_level = mysqli_query($conn, "SELECT PremiumLevel FROM users WHERE UserName = '$user_name' Limit 1") 
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_user_premium_level) == 1 )
	{
		$row = mysqli_fetch_array($get_user_premium_level);
		$user_premium_level = $row['PremiumLevel'];
		
		// check if downloads are available for user
		$check_for_downloads = mysqli_query($conn, "SELECT DownloadName, FileName FROM downloads WHERE FIND_IN_SET('$user_premium_level', PremiumLevel) AND IsEnabled = 1") 
		or die($dataaccess_error);
		
		if(mysqli_num_rows($check_for_downloads) > 0 )
		{
			$i=1;
			while($row = mysqli_fetch_array($check_for_downloads))
			{
				// row number
				$rowNumber = $i++;

				// database values
				$download_name = $row['DownloadName'];
				$file_name = $row['FileName'];
				
				// echo out download buttons
				$available_downloads .= '
				<li>'.$rowNumber.'. '.$download_name.'</li>
				<li>
				  <form name="frmDownload" method="post" action="../download.php" class="htmlForm">
				    <div class="download_ico">
					</div><input name="fileName" type="hidden" value="'.$file_name.'">
				    <input name="btnDownload" type="submit" value="Download" class="btn">
				  </form>
				</li>
				<div class="clearLeft"></div>'
				;
			}
		}
		else
		{
			$available_downloads .= '
			<li>No files are available for download at this time ...</li>
			<div class="clearLeft"></div>'
			;
		}
	}
}
?>