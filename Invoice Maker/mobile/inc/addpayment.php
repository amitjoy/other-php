<?
include "../../inc/functions.php";
if(!$_SESSION['logged']){die();}
$limit=10;

	if($_POST['page']){
		$page=$_POST['page'];
	}else{
		$page=1;
	}
	$pages=$page-1;	
	if($_POST['action']=='delete'){
		mysql_query("delete from payments where id='".$_POST['id']."'")or die(mysql_error());
	}
	
	$res=mysql_query("select * from payments");
	$count=mysql_num_rows($res);
	
	$pagination=smart_pagination($_POST['page'],$count,$limit,'da')	
	
?>
	<table width='100%' cellspacing='0' cellpadding='0'>
				<tr style='background:#014288; color:#fff;'>
					<td class='tdhead' width='20'>ID</td>
					<td class='tdhead'>Amount</td>
					<td class='tdhead' width='60'>Invoice No.</td>
					<td class='tdhead' width='100'>Payment Method</td>
					<td class='tdhead'></td>
				</tr>
				<?
					$i=1;
				$res=mysql_query("select * from payments order by id desc")or die(mysql_error());
						while($row=mysql_fetch_array($res)){
							$r=mysql_query("select * from invoices where id='".$row['invoice']."'")or die(mysql_error());
								$c=mysql_fetch_array($r);
							$rex=mysql_query("SELECT SUM(amount) as total FROM payments WHERE invoice='".$row['invoice']."'")or die(mysql_error());
								$r=mysql_fetch_array($rex);								
						
						?>
					<tr onmouseover="$(this).css('background','#efffd0')" onmouseout="$(this).css('background','#fff')">
						<td class='tdhead2'><?=$i?></td>
						<td class='tdhead2'><?=$row['amount']?> <?=$c['currency']?></td>
						<td class='tdhead2'><b>#<?=$row['invoice']?></b></td>
						<td class='tdhead2'><?=$row['pmethod']?></td>
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><a href='#' onclick="return delpay(<?=$row['id']?>)"><img src='style/images/delete.png' style='width:30px;'/></a></td>
					</tr>						
						<?$i++;}
						if(mysql_num_rows($res)==0){
							echo "<tr><td class='tdhead2' style='border-right:1px solid #e6e6e6; text-align:center;' colspan='6'>No Taxes Defined Yet</td></tr>";
						}
						?>
			</table>