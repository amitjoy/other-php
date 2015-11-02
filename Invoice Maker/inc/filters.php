<?
include "functions.php";
if(!$_SESSION['logged']){die();}

$limit=$_POST['limit'];

	if($_POST['page']){
		$page=$_POST['page'];
	}else{
		$page=1;
	}
	$pages=$page-1;	
	
	if(isset($_POST['client_name'])){
		$qu=str_replace(' ','%',$_POST['client_name']);
		$q.="AND client_name like '%".$qu."%'";
	}	
	if(isset($_POST['product_name'])){
		$qu=str_replace(' ','%',$_POST['product_name']);
		$q.="AND id in (select invoice from products where title like '%".$qu."%')";
	}
	
	$res=mysql_query("select * from invoices");
	$count=mysql_num_rows($res);
	
	$pagination=smart_pagination($_POST['page'],$count,$limit,'da')	

?>
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
				$res=mysql_query("select * from invoices where 1=1 ".$q." order by id desc LIMIT " . ($pages*$limit) . "," . $limit)or die(mysql_error());
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
							echo "<tr><td class='tdhead2' style='border-right:1px solid #e6e6e6; text-align:center;' colspan='7'>No Matches Found</td></tr>";
						}
						?>
			</table>
			<div class='pagination'><?=$pagination?></div>			