<?
include "../inc/functions.php";
	$meniu='settings';
if(!$_SESSION['logged']){
	header("Location: login/");
}	
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
	<div class='title' style='text-align:left;'>Payments<div style='float:right;background:#004876' onclick="moveto('index.php')">BACK</div></div>
	<div id='ajaxresponse'>
			<table width='100%' cellspacing='0' cellpadding='0' style='background:#fff;'>
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
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><a href='#' onclick="return delpay(<?=$row['id']?>)"><img src='style/images/delete.png' style='width:28px;'/></a></td>
					</tr>						
						<?$i++;}
						if(mysql_num_rows($res)==0){
							echo "<tr><td class='tdhead2' style='border-right:1px solid #e6e6e6; text-align:center;' colspan='7'>No Payments added yet.</td></tr>";
						}
						?>
			</table>
	</div>	
 </body>
 </html>