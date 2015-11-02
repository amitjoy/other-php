<?
include "../inc/functions.php";
if(!$_SESSION['logged']){
	header("Location: login/");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pro Invoice Maker | Mobile</title>
<link rel="stylesheet" href="style/style.css" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="js/script.js"></script>
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
	
	<div class='menu' onclick="moveto('newinvoice.php')">New Invoice</div>
	<div class='menu' onclick="moveto('allinvoices.php')">All Invoices</div>
	<div class='menu' onclick="moveto('payments.php')">Payments</div>
	<div class='menu' onclick="moveto('taxes.php')">Taxes</div>
	<div class='menu' onclick="moveto('settings.php')">Settings</div>
	<div class='menu' onclick="moveto('disconnect.php')">Disconnect</div>
</body>
</html>