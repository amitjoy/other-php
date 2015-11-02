<?
session_start();
include "../../inc/db.php";
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pro Invoice Maker | Mobile</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="../js/script.js"></script>
<link rel="apple-touch-icon" href="apple-touch-icon.png"/>
<meta name="viewport" content="width=270; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<script type="text/javascript">
    $(document).ready(function() {
            $("body").css("display", "none");
            $("body").fadeIn(1000);
    });
	
</script>
</head>
<body>
	<div class='title'>Pro Invoice Maker</div>
					<?if($eroare){?><div class='errormsg'><?=$eroare?></div><?}?>
						<form action='' method='POST'>			
							<table align='center' cellspacing='0' cellpadding='0'>
								<tr>
									<td>
										<label for='username' class='loginlbl'>Username</label>
										<input type='text' class='login' name='username' id='username'/>								
										
										<label for='parola' class='loginlbl'>Password</label>
										<input type='password' class='login' name='parola' id='parola'/>
										<input type='submit' name='submit' class='autentificare' value='Login'/>
									</td>
								</tr>
							</table>
						</form>					
					<div class='warning'>
					Your <b>IP</b>: <b style='color:red;'><?=$_SERVER['REMOTE_ADDR']?></b>
					</div>	
	
</body>
</html>