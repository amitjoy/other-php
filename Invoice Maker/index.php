<?
include "inc/functions.php";

if(!$_SESSION['logged']){
	header("Location: login/");
}
	$meniu='home';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
	<title>Pro Invoice Maker</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="js/script.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.ajaxQueue.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.autocomplete.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.boxshadow.js"></script>
	<script language="javascript" type="text/javascript" src="inc/data.php"></script>
	<link rel="stylesheet" media="screen" href="style/style.css" /> 
	<link rel="stylesheet" media="screen" href="style/jquery.autocomplete.css" /> 
	
<script type="text/javascript">
$().ready(function() {
	$("#suggest13").autocomplete(emails, {
		minChars: 0,
		width: 306,
		max:20,		
		matchContains: "word",
		autoFill: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + row.name + "\" , " + row.location + "";
		},
		formatMatch: function(row, i, max) {
			return row.name;
			
		},
		formatResult: function(row) {
			return row.to;
		}
	});	

	$('#suggest13').result(function(event, data, formatted) {
		$('#email').val(data.email);
		$('#phone').val(data.phone);
		$('#address').val(data.address);
		$('#location').val(data.location);
	});
	
		
	$("#pmethod").autocomplete(pmethods, {
		minChars: 0,
		width: 306,
		matchContains: "word",
		autoFill: false
	});

});
</script>	
 </head>
 <body>
	<div id='container'>
	<?include "inc/header.php"?>
		<div class='title'>Home</div>
		<div id='content'>
			<h2>Last 10 Invoices</h2>
<table width='100%' cellspacing='0' cellpadding='0'>
				<tr style='background:#5c8c00; color:#fff;'>
					<td class='tdhead' width='20'>ID</td>
					<td class='tdhead' width='200'>Client Name</td>
					<td class='tdhead'>Date</td>
					<td class='tdhead' width='170'>Paid?</td>
					<td class='tdhead' width='30'>Prod.</td>
					<td class='tdhead' width='130'>Total</td>
					<td class='tdhead' width='150'>Payment Method</td>
					<td class='tdhead' width='100'>Actions</td>
				</tr>
				<?
					$i=1;
				$res=mysql_query("select * from invoices order by id desc limit 0,10")or die(mysql_error());
						while($row=mysql_fetch_array($res)){
							$res2=mysql_query("select * from products where invoice='".$row['id']."'")or die(mysql_error());
								$nr=mysql_num_rows($res2);
							
						$rex=mysql_query("SELECT SUM(amount) as total FROM payments WHERE invoice='".$row['id']."'")or die(mysql_error());
							$r=mysql_fetch_array($rex);
								if($r['total']<$row['total'] && $r['total']>0){
									$p="<b style='color:#ff5757;'>".$r['total']." ".$row['currency']."";
								}elseif($r['total']==0){
									$p="<b style='color:#ff0000;'>Unpaid</b>";
								}elseif($r['total']>$row['total']){
									$p="<b style='color:#0e71d6'>Too Much! (".$r['total']." ".$row['currency'].")</b>";
								}elseif($r['total']==$row['total']){
									$p="<b style='color:#388c00;'>Paid</b>";
								}
						?>
					<tr onmouseover="$(this).css('background','#efffd0')" onmouseout="$(this).css('background','#fff')">
						<td class='tdhead2'><?=$i?></td>
						<td class='tdhead2'><?=$row['client_name']?></td>
						<td class='tdhead2'><?=date('d.m.Y',$row['date'])?></td>
						<td class='tdhead2'><?=$p?></td>
						<td class='tdhead2'><?=$nr?></td>
						<td class='tdhead2' align='right'><b><?=$row['total']?> <?=$row['currency']?></b></td>
						<td class='tdhead2'><?=$row['payment_method']?></td>
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><img src='style/images/paid.jpg' height='18' onclick="$('#hid<?=$row['id']?>').slideToggle('slow');" style='cursor:pointer;'/><a href='edit.php?id=<?=$row['id']?>'><img src='style/images/icon_edit.png' height='18'/></a><a href='inc/invoicepdf.php?id=<?=encrypt($row['id']."-".md5($row['id']))?>' target='_blank'><img src='style/images/icon_pdf.jpg' height='20'/></a><a href='inc/invoicehtml.php?id=<?=encrypt($row['id']."-".md5($row['id']))?>' target='_blank'><img src='style/images/icon_html.jpg' height='20'/></a><a href='invoices.php?delete=<?=$row['id']?>' onclick="return confirm('Are you sure you want to delete this invoice?\nAll data will be lost.')"><img src='style/images/delete.png'/></a></td>
					</tr>	
					<tr id='hid<?=$row['id']?>' colspan='8' class='tdhead2' style='display:none;border-right:1px solid #e6e6e6;'>
						<td colspan='8'><form action='invoices.php' method='post'><b>Add payment</b> From: <input type='text' class='settings' name='from' value='<?=$row['client_name']?>' style='width:160px;'/> Payment Method: <input type='text' class='settings' name='pmethod' value='<?=$row['payment_method']?>' style='width:160px;'/>  Amount: <input type='text' class='settings' value='<?=$row['total']-$r['total']?>' name='value' style='width:70px;'/> <?=$row['currency']?> <input type='submit' value='Add Payment' class='button' name='addpay' style='font-size:13px; height:30px;'><input type='hidden' name='id' value='<?=$row['id']?>'/></form></td>
					</tr>
						<?$i++;}
						if(mysql_num_rows($res)==0){
							echo "<tr><td class='tdhead2' style='border-right:1px solid #e6e6e6; text-align:center;' colspan='8'>No Invoices Found</td></tr>";
						}
						?>
			</table>
<br>			
			<h2>Quick Create Invoice</h2>
			<?include "inc/step1.php";?>
		</div>
	</div>
	<?include "inc/footer.php"?>
 </body>
 </html>