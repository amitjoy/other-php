<?
include "inc/functions.php";

if(!$_SESSION['logged']){
	header("Location: login/");
}
	$meniu='payments';
	
	$res		=	mysql_query("select * from payments");
	$count		=	mysql_num_rows($res);
	$pagination	=	smart_pagination(1,$count,10,'da')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
	<title>Payments | Pro Invoice Maker</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.boxshadow.js"></script>
	<script language="javascript" type="text/javascript" src="js/script.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.tipsy.js"></script>
	<link rel="stylesheet" media="screen" href="style/style.css" /> 
	<link rel="stylesheet" media="screen" href="style/tipsy.css" /> 
 </head>
 <body>
	<div id='container'>
	<?include "inc/header.php"?>
		<div class='title'>Payments</div>
		<div id='content'>
		<script type='text/javascript'>
			setfiltru=function(id,page){
			$('#page').val(page);
				$.ajax({
				   type: "POST",
				   url: "inc/addpayment.php",
				   data: "page="+$('#page').val(),
				   success: function(msg){
						$('#ajaxresponse').html(msg);
				   }
				 });
			}
		</script>
		<input type='hidden' id='page' value='1'/>
		<div id='ajaxresponse'>
			<table width='100%' cellspacing='0' cellpadding='0'>
				<tr style='background:#5c8c00; color:#fff;'>
					<td class='tdhead' width='20'>ID</td>
					<td class='tdhead' width='320'>From</td>
					<td class='tdhead'>Amount</td>
					<td class='tdhead' width='100'>Invoice No.</td>
					<td class='tdhead' width='180'>Payment Method</td>
					<td class='tdhead' width='100'>Date</td>
					<td class='tdhead' width='60'>Actions</td>
				</tr>
				<?
					$i=1;
				$res=mysql_query("select * from payments order by id desc limit 0,10")or die(mysql_error());
						while($row=mysql_fetch_array($res)){
							$r=mysql_query("select * from invoices where id='".$row['invoice']."'")or die(mysql_error());
								$c=mysql_fetch_array($r);
							$rex=mysql_query("SELECT SUM(amount) as total FROM payments WHERE invoice='".$row['invoice']."'")or die(mysql_error());
								$r=mysql_fetch_array($rex);								
						
						?>
					<tr onmouseover="$(this).css('background','#efffd0')" onmouseout="$(this).css('background','#fff')">
						<td class='tdhead2'><?=$i?></td>
						<td class='tdhead2'><?=$row['from']?></td>
						<td class='tdhead2'><?=$row['amount']?> <?=$c['currency']?></td>
						<td class='tdhead2' onmouseover="$(this).tipsy({gravity: 's',html: true,fallback: '<b>Invoice #<?=$row['invoice']?><br><table><tr><td>Total........</td><td><?=$c['total']?> <?=$c['currency']?></td></tr><tr><td>Paid......... </td><td><?=$r['total']?> <?=$c['currency']?></td></tr></table>'});"><a href='edit.php?id=<?=$row['invoice']?>' title="">#<?=$row['invoice']?></a></td>
						<td class='tdhead2'><?=$row['pmethod']?></td>
						<td class='tdhead2'><?=date('d.m.Y',$row['date'])?></td>
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><a href='#' onclick="return delpay(<?=$row['id']?>)"><img src='style/images/delete.png'/></a></td>
					</tr>						
						<?$i++;}
						if(mysql_num_rows($res)==0){
							echo "<tr><td class='tdhead2' style='border-right:1px solid #e6e6e6; text-align:center;' colspan='7'>No Payments added yet.</td></tr>";
						}
						?>
			</table>
			<div class='pagination' id='pagination'><?=$pagination?></div>
		</div>

	</div>
	<?include "inc/footer.php"?>
 </body>
 </html>