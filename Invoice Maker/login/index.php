<?
session_start();
include "../inc/db.php";
if(isset($_POST['submit'])){
$username = $_POST['username'];
$parola   = $_POST['parola'];
if($username==NULL|$parola==NULL)
$eroare = "Wrong Username/Password!";
else{

$res	= mysql_query("Select * from config where name='admin_pass'")or die('Eroare Mysql:'.mysql_error());
$row    = mysql_fetch_array($res);

$res	= mysql_query("Select * from config where name='admin_user'")or die('Eroare Mysql:'.mysql_error());
$row2    = mysql_fetch_array($res);

if($parola!=$row['value'] || $username!=$row2['value'])
	$eroare = "Wrong Username/Password!";

	if(empty($eroare)){
		$_SESSION['logged']=1;
		header("Location: ../index.php"); 
	}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Pro Invoice Maker Login</title>
	<link rel="stylesheet" type="text/css" href="css/login.css" media="screen"/>
</head>
<body>

		<div id="container2">
			<div id="container">
				<div class='header'>Pro Invoice Maker Login</div>
				<div class="content">
					<?if($eroare){?><div class='error'><?=$eroare?></div><?}?>
						<form action='' method='POST'>			
							<table width='100%' cellspacing='0' cellpadding='0'>
								<tr>
									<td><img src='css/login.png'/></td>
									<td>
										<label for='username'>Username</label>
										<input type='text' class='login' name='username' id='username' value='admin'/>								
										
										<label for='parola'>Password</label>
										<input type='password' class='login' name='parola' id='parola' value='admin'/>
										<input type='submit' name='submit' class='autentificare' value='Login'/>
									</td>
								</tr>
							</table>
						</form>					
					<div class='warning'>
					Your <b>IP</b>: <b style='color:red;'><?=$_SERVER['REMOTE_ADDR']?></b>
					</div>
				</div>			
			</div>
		</div>
</body>
</html>