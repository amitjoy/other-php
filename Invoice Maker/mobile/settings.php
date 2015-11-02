<?
include "../inc/functions.php";
if(!$_SESSION['logged']){
	header("Location: login/");
}
	$meniu='settings';
		if(isset($_POST['submit'])){
		if($_POST['admin_pass']=='')$_POST['admin_pass']=$cfg['admin_pass'];
			foreach($_POST as $tag=>$val){
				$res=mysql_query("select * from config where name='".$tag."'")or die(mysql_error());
					if(mysql_num_rows($res)){
						mysql_query("update config set value='".$val."' where name='".$tag."'")or die(mysql_error());
					}else{
						mysql_query("insert into config(name,value) values('".$tag."','".$val."')")or die(mysql_error());
					}
			}
		}else{
			$_POST=$cfg;
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pro Invoice Maker | Mobile</title>
<link rel="stylesheet" href="style/style.css" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script language="javascript" type="text/javascript" src="inc/data.php"></script>
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
	<div class='title' style='text-align:left;'>Configuration<div style='float:right;background:#004876' onclick="moveto('index.php')">BACK</div></div>
	   <form action='' method='post'>
			<table align='center'>
				<tr>
					<td class='prop'>Company Name</td>
					<td><input type='text' class='settings' name='name'  value='<?=$_POST['name']?>'></td>
				</tr>				
				<tr>
					<td class='prop' valign='top'>Address</td>
					<td><textarea class='settings' name='address'><?=$_POST['address']?></textarea></td>
				</tr>					
				<tr>
					<td class='prop' valign='top'>Footer notes</td>
					<td><textarea class='settings' name='footer'><?=$_POST['footer']?></textarea></td>
				</tr>				
				<tr>
					<td class='prop'>Email</td>
					<td><input type='text' class='settings' name='email' value='<?=$_POST['email']?>'></td>
				</tr>			
				<tr>
					<td class='prop'>Bank Name</td>
					<td><input type='text' class='settings' name='bank_name' value='<?=$_POST['bank_name']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Website</td>
					<td><input type='text' class='settings' name='website' value='<?=$_POST['website']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Bank Account</td>
					<td><input type='text' class='settings' name='bank_account' value='<?=$_POST['bank_account']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Watermark</td>
						<td><input type='text' class='settings' name='watermark' value='<?=$_POST['watermark']?>'></td>				
				</tr>								
				<tr>
					<td class='prop'>Currency</td>
					<td><input type='text' class='settings' name='currency' value='<?=$_POST['currency']?>'></td>
				</tr>
				<tr>
					<td class='prop'>Invoice size</td>
					<td><select name='size' class='settings'>
						<option value='A3' <?if($_POST['size']=='A3')echo "selected";?>>A3</option>
						<option value='A4' <?if($_POST['size']=='A4')echo "selected";?>>A4</option>
						<option value='A5' <?if($_POST['size']=='A5')echo "selected";?>>A5</option>
						<option value='letter' <?if($_POST['size']=='letter')echo "selected";?>>Letter</option>
						<option value='legal' <?if($_POST['size']=='legal')echo "selected";?>>Legal</option>
					</select></td>
				</tr>
				<tr>
					<td class='prop'>Admin User</td>
					<td><input type='text' class='settings' name='admin_user' value='<?=$_POST['admin_user']?>'></td>
					<td class='fieldinfo'></td>
				</tr>				
				<tr>
					<td class='prop'>Admin Pass</td>
					<td><input type='text' class='settings' name='admin_pass' value=''></td>
					<td class='fieldinfo'></td>
				</tr>				
			</table>	

		<h2>Online Payments</h2>
			<table align='center'>
				<tr>
					<td class='prop'>Enable Payments</td>
					<td><select name='enable_payments' class='settings'>
						<option value='1' <?if($_POST['enable_payments']=='1')echo "selected";?>>Enable</option>
						<option value='0' <?if($_POST['enable_payments']=='0')echo "selected";?>>Disable</option>
					</select></td>
				</tr>				
				<tr>
					<td class='prop'>Paypal Email</td>
					<td><input type='text' class='settings' name='paypal_email'  value='<?=$_POST['paypal_email']?>'></td>
				</tr>					
				<tr>
					<td class='prop'>Paypal Currency</td>
					<td><input type='text' class='settings' name='paypal_currency'  value='<?=$_POST['paypal_currency']?>'></td>
				</tr>								
			</table>
			
		<h2>Language</h2>

			<table align='center'>
				<tr>
					<td class='prop'>Page</td>
					<td><input type='text' class='settings' name='lang_page'  value='<?=$_POST['lang_page']?>'></td>
				</tr>					
				<tr>
					<td class='prop'>Date</td>
					<td><input type='text' class='settings' name='lang_date'  value='<?=$_POST['lang_date']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Bank</td>
					<td><input type='text' class='settings' name='lang_bank'  value='<?=$_POST['lang_bank']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Bank Account</td>
					<td><input type='text' class='settings' name='lang_bank_account'  value='<?=$_POST['lang_bank_account']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Payment Method</td>
					<td><input type='text' class='settings' name='lang_pmethod'  value='<?=$_POST['lang_pmethod']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Due  Date</td>
					<td><input type='text' class='settings' name='lang_duedate'  value='<?=$_POST['lang_duedate']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Status</td>
					<td><input type='text' class='settings' name='lang_status'  value='<?=$_POST['lang_status']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Paid</td>
					<td><input type='text' class='settings' name='lang_paid'  value='<?=$_POST['lang_paid']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Unaid</td>
					<td><input type='text' class='settings' name='lang_unpaid'  value='<?=$_POST['lang_unpaid']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Partial</td>
					<td><input type='text' class='settings' name='lang_partial'  value='<?=$_POST['lang_partial']?>'></td>
				</tr>								
				<tr>
					<td class='prop'>Description</td>
					<td><input type='text' class='settings' name='lang_description'  value='<?=$_POST['lang_description']?>'></td>
				</tr>			
				<tr>
					<td class='prop'>Quantity</td>
					<td><input type='text' class='settings' name='lang_qty'  value='<?=$_POST['lang_qty']?>'></td>
				</tr>					
				<tr>
					<td class='prop'>Taxes</td>
					<td><input type='text' class='settings' name='lang_taxes'  value='<?=$_POST['lang_taxes']?>'></td>
				</tr>					
				<tr>
					<td class='prop'>NET Price</td>
					<td><input type='text' class='settings' name='lang_netprice'  value='<?=$_POST['lang_netprice']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Amount</td>
					<td><input type='text' class='settings' name='lang_amount'  value='<?=$_POST['lang_amount']?>'></td>
				</tr>					
				<tr>
					<td class='prop'>Invoice</td>
					<td><input type='text' class='settings' name='lang_invoice'  value='<?=$_POST['lang_invoice']?>'></td>
				</tr>					
				<tr>
					<td class='prop'>Client</td>
					<td><input type='text' class='settings' name='lang_client'  value='<?=$_POST['lang_client']?>'></td>
				</tr>					
				<tr>
					<td class='prop'>Pay To</td>
					<td><input type='text' class='settings' name='lang_payto'  value='<?=$_POST['lang_payto']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Subtotal</td>
					<td><input type='text' class='settings' name='lang_subtotal'  value='<?=$_POST['lang_subtotal']?>'></td>
				</tr>				
				<tr>
					<td class='prop'>Total</td>
					<td><input type='text' class='settings' name='lang_total'  value='<?=$_POST['lang_total']?>'></td>
				</tr>						
				<tr>
					<td colspan='3' align='center'><input type='submit' name='submit' value='Update' class='button'></td>
				</tr>
			</table>	
		</form>	
 </body>
 </html>