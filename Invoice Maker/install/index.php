<?
session_start();
if(isset($_POST['submit'])){
	if($_POST['admin_user']=='' || $_POST['admin_pass']==''){
		$eroare='Admin User/Pass Empty!';
	}
	if(!@mysql_connect($_POST['mysql_host'],$_POST['mysql_user'],$_POST['mysql_pass'])){
		$eroare='MySQL Connection Failure';
	}	
	
	if(!@mysql_select_db($_POST['mysql_db'])){
		$eroare='MySQL Database Not Found!';
	}
	if(!$eroare){
	$filename 		= 'sql.sql';
		$templine = '';
		$lines 	  = @file($filename);
		if(is_array($lines)){
			foreach ($lines as $line_num => $line) {
				if (substr($line, 0, 2) != '--' && $line != '') {
					$templine .= $line;
					if (substr(trim($line), -1, 1) == ';') {
						mysql_query($templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysql_error() . '<br /><br />');
						$templine = '';
					}
				}
			}
		}
		
		$myFile = "../inc/db.php";
			$fh = @fopen($myFile, 'w+') or $success=1;
			$stringData = '<?
			$host      = "'.$_POST['mysql_host'].'";
			$username  = "'.$_POST['mysql_user'].'";
			$password  = "'.$_POST['mysql_pass'].'";
			$db        = "'.$_POST['mysql_db'].'";
			mysql_connect($host, $username, $password) or die("<font color=\"darkred\"><b>Cannot connect to database!</b></font>");
			mysql_select_db($db);
			?>';
			@fwrite($fh, $stringData);
			@fclose($fh);	
			mysql_query("insert into config(name,value) values('admin_user','".$_POST['admin_user']."')")or die(mysql_error());
			mysql_query("insert into config(name,value) values('admin_pass','".$_POST['admin_pass']."')")or die(mysql_error());
			
			if($success!=1)
		$suc="Successfully Installed!";	
			else
				$suc='<b>Success!</b> The db.php file in inc/ could not be created though. Please rename the db_config.php to db.php and configure it manually!';

	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Pro Invoice Maker Installation</title>
	<link rel="stylesheet" type="text/css" href="css/login.css" media="screen"/>
</head>
<body>

		<div id="container2">
			<div id="container">
				<div class='header'>Installation</div>
				<div class="content">
					<?if($eroare){?><div class='error'><?=$eroare?></div><?}?>
					<?if($suc){?><div class='suc'><?=$suc?></div><?}?>
						<form action='' method='POST'>			
							<table width='100%' cellspacing='0' cellpadding='0'>
								<tr>
									<td>
										<label for='username'>Admin Username</label>
										<input type='text' class='login' name='admin_user' id='username' value='<?=$_POST['admin_user']?>'/>								
										<label for='parola'>Admin Password</label>
										<input type='text' class='login' name='admin_pass' id='parola' value='<?=$_POST['admin_pass']?>'/>										
										
										<label for='host'>MySQL Host</label>
										<input type='text' class='login' name='mysql_host' id='host' value='<?=$_POST['mysql_host']?>''/>
											
										<label for='user'>MySQL User</label>
										<input type='text' class='login' name='mysql_user' id='user' value='<?=$_POST['mysql_user']?>'/>
											
										<label for='pass'>MySQL Password</label>
										<input type='text' class='login' name='mysql_pass' id='pass' value='<?=$_POST['mysql_pass']?>'/>
											
										<label for='db'>MySQL DB</label>
										<input type='text' class='login' name='mysql_db' id='db' value='<?=$_POST['mysql_db']?>'/>
										
										<input type='submit' name='submit' class='autentificare' value='Install'/>
									</td>
								</tr>
							</table>
						</form>					
				</div>			
			</div>
		</div>
</body>
</html>