<?
if(!$_SESSION['logged']){die();}
	$res=mysql_query("select * from invoices where id='".$_SESSION['invoice']."'")or die(mysql_error());
		$info=mysql_fetch_array($res);
	if(isset($_POST['sendinvoice'])){
		$to=$_POST['to'];
		if($to==''){
			echo "<div class='errormsg'>Please enter a valid Email</div>";
		}else{
			$subject=$_POST['subject'];
			$message=$_POST['message'];
			$_GET['id']=$_SESSION['invoice'];
			include "../inc/invoice_save.php";
			
			$invoiceloc=str_replace(array('inc','mobile/'),'',dirname(__FILE__))."inc/invoices/".$_SESSION['invoice'].".pdf";
			if(mailer($to,$subject,$message,$invoiceloc)){
				echo "<div class='successmsg'>Email has been Sent</div>";
			}else{
				echo "<div class='errormsg'>Oops! Something went wrong!</div>";
			}
		}	
}
		
?>
<table align='center' style=''>
	<tr>
		<td class='alldone' onclick="window.open('../inc/invoicepdf.php?id=<?=$_SESSION['invoice']?>')"><img src='style/images/save_pdf.png' style='width:120px;'/><br>Download PDF</td>
		<td class='alldone' onclick="window.open('../inc/invoicehtml.php?id=<?=$_SESSION['invoice']?>')"><img src='style/images/save_html.png' style='width:120px;'/><br>View HTML</td>
	</tr>
	<tr>
	<td class='alldone' colspan='2' onclick="$('#emailtoclient').slideDown(); 	$('html, body').animate({scrollTop: 300}, 1000);"><img src='style/images/send_email.png' style='width:120px;'/><br>Send as Attachment via Email</td>
	</tr>
</table>
<form action='' method='post'>
<table width='310' style='background:#fff; display:none;' align='center' id='emailtoclient'>
	<tr>
		<td>Subject:</td>
		<td><input type='text' class='settings' style='width:235px;' name='subject' value='Invoice #<?=$_SESSION['invoice']?> from <?=$cfg['name']?>'></td>
	</tr>	
	<tr>
		<td>To:</td>
		<td><input type='text' class='settings' style='width:235px;' name='to' value='<?=$info['client_email']?>'></td>
	</tr>	
	<tr>
		<td colspan='2'><textarea class='settings' name='message' style='widtH:300px; height:200px;'>Dear <?=$info['client_name']?>,
We have attached an invoice in the amount of <?=$info['total']?><?=$info['currency']?>.
			
You may pay, view and print the invoice online by visiting the following link: 
			
Best Regards,
<?=$cfg['name']?>
		</textarea></td>
	</tr>
	<tr>
		<td colspan='2' align='center'><input type='submit' name='sendinvoice' class='button' value='Email invoice to Client'/></td>
	</tr>
</table>
</form>