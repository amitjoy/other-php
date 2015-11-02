<?
include "../inc/functions.php";
	$meniu='settings';
if(!$_SESSION['logged']){
	header("Location: login/");
}
		if(isset($_GET['delete'])){
			mysql_query("delete from invoices where id='".$_GET['delete']."'")or die(mysql_error());
			mysql_query("delete from products where invoice='".$_GET['delete']."'")or die(mysql_error());
			mysql_query("delete from payments where invoice='".$_GET['delete']."'")or die(mysql_error());
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
	<div class='title' style='text-align:left;'>All Invoices<div style='float:right;background:#004876' onclick="moveto('index.php')">BACK</div></div>
			<table width='100%' cellspacing='0' cellpadding='0' style='background:#fff;'>
				<tr style='background:#014288; color:#fff;'>
					<td class='tdhead' width='20'>ID</td>
					<td class='tdhead' width='200'>Client Name</td>
					<td class='tdhead' width='170'>Paid?</td>
					<td class='tdhead' width='130'>Total</td>
					<td class='tdhead' width='100'>#</td>
				</tr>
				<?
					$i=1;
				$res=mysql_query("select * from invoices order by id desc")or die(mysql_error());
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
						<td class='tdhead2'><?=$p?></td>
						<td class='tdhead2' align='right'><b><?=$row['total']?> <?=$row['currency']?></b></td>
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><a href='?delete=<?=$row['id']?>' onclick="return confirm('Are you sure you want to delete this invoice?\nAll data will be lost.')"><img src='style/images/delete.png' width='30'/></a></td>
					</tr>	
						<?$i++;}
						if(mysql_num_rows($res)==0){
							echo "<tr><td class='tdhead2' style='border-right:1px solid #e6e6e6; text-align:center;' colspan='8'>No Invoices Found</td></tr>";
						}
						?>
			</table>
 </body>
 </html>