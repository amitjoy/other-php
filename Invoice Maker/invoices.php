<?
include "inc/functions.php";
	$meniu='invoices';
	
	if(isset($_POST['addpay'])){
		if($_POST['value']!=''){
			mysql_query("insert into payments(`from`,`amount`,`invoice`,`pmethod`,`date`) values('".$_POST['from']."','".$_POST['value']."','".$_POST['id']."','".$_POST['pmethod']."','".time()."')")or die(mysql_error());
		}
	}
	
		if(isset($_GET['delete'])){
			mysql_query("delete from invoices where id='".$_GET['delete']."'")or die(mysql_error());
			mysql_query("delete from products where invoice='".$_GET['delete']."'")or die(mysql_error());
			mysql_query("delete from payments where invoice='".$_GET['delete']."'")or die(mysql_error());
		}
	
	$res		=	mysql_query("select * from invoices");
	$count		=	mysql_num_rows($res);
	$pagination	=	smart_pagination(1,$count,10,'da')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
	<title>Invoice List | Pro Invoice Maker</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.boxshadow.js"></script>
	<script language="javascript" type="text/javascript" src="js/script.js"></script>
	<link rel="stylesheet" media="screen" href="style/style.css" /> 
 </head>
 <body>
	<div id='container'>
	<?include "inc/header.php"?>
		<div class='title'>View All Invoices</div>
		<div id='content'>
		<h2>Filters</h2>
		<table width='100%'>
			<tr>
				<td>Client Name</td>
				<td><input type='text' class='settings filter' id='clientname' name='client_name' onkeyup='setfilter()' style='width:200px;'></td>				
				<td>Product Name</td>
				<td><input type='text' class='settings filter' id='productname' name='product_name' onkeyup='setfilter()' style='width:200px;'></td>				
				<td>Display</td>
				<td>
					<select name='limit' class='settings filter' onchange='setfilter()' style='width:50px;'>
						<option value='10'>10</option>
						<option value='20'>20</option>
						<option value='50'>50</option>
						<option value='100'>100</option>
					</select>	
				</td>
			</tr>
		</table>
		<br>
		<input type='hidden' class='filter' id='page' name='page' value='1'>
		<div id='ajaxreturn'>
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
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><img src='style/images/paid.jpg' height='18' onclick="$('#hid<?=$row['id']?>').slideToggle('slow');" style='cursor:pointer;'/><a href='edit.php?id=<?=$row['id']?>'><img src='style/images/icon_edit.png' height='18'/></a><a href='inc/invoicepdf.php?id=<?=encrypt($row['id']."-".md5($row['id']))?>' target='_blank'><img src='style/images/icon_pdf.jpg' height='20'/></a><a href='inc/invoicehtml.php?id=<?=encrypt($row['id']."-".md5($row['id']))?>' target='_blank'><img src='style/images/icon_html.jpg' height='20'/></a><a href='?delete=<?=$row['id']?>' onclick="return confirm('Are you sure you want to delete this invoice?\nAll data will be lost.')"><img src='style/images/delete.png'/></a></td>
					</tr>	
					<tr id='hid<?=$row['id']?>' colspan='8' class='tdhead2' style='display:none;border-right:1px solid #e6e6e6;'>
						<td colspan='8'><form action='' method='post'><b>Add payment</b> From: <input type='text' class='settings' name='from' value='<?=$row['client_name']?>' style='width:160px;'/> Payment Method: <input type='text' class='settings' name='pmethod' value='<?=$row['payment_method']?>' style='width:160px;'/>  Amount: <input type='text' class='settings' value='<?=$row['total']-$r['total']?>' name='value' style='width:70px;'/> <?=$row['currency']?> <input type='submit' value='Add Payment' class='button' name='addpay' style='font-size:13px; height:30px;'><input type='hidden' name='id' value='<?=$row['id']?>'/></form></td>
					</tr>
						<?$i++;}
						if(mysql_num_rows($res)==0){
							echo "<tr><td class='tdhead2' style='border-right:1px solid #e6e6e6; text-align:center;' colspan='8'>No Invoices Found</td></tr>";
						}
						?>
			</table>
			<div class='pagination'><?=$pagination?></div>
		</div>	
			<br>
		</div>
	</div>
	<?include "inc/footer.php"?>
 </body>
 </html>