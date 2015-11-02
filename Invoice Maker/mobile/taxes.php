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
	<div class='title' style='text-align:left;'>Taxes<div style='float:right;background:#004876' onclick="moveto('index.php')">BACK</div></div>
		<div id='ajaxresponse'>
			<table width='100%' cellspacing='0' cellpadding='0'>
				<tr style='background:#014288; color:#fff;'>
					<td class='tdhead' width='20'>ID</td>
					<td class='tdhead' width='80'>Tax Name</td>
					<td class='tdhead'>Amount</td>
					<td class='tdhead' width='60'>Default</td>
					<td class='tdhead' width='70'>Actions</td>
				</tr>
				<?
					$i=1;
				$res=mysql_query("select * from taxes where hidden='0' order by id desc limit 0,10")or die(mysql_error());
						while($row=mysql_fetch_array($res)){
						$pos1 = strpos($row['value'],'%' );
							if ($pos1 !== false) {
								$tax="<b>".$row['value']."</b>";
							}else{
								$tax="<b>".$row['value']."</b> ".$cfg['currency'];
							}

						?>
					<tr onmouseover="$(this).css('background','#efffd0')" onmouseout="$(this).css('background','#fff')">
						<td class='tdhead2'><?=$i?></td>
						<td class='tdhead2'><?=$row['name']?></td>
						<td class='tdhead2'><?=$tax?></td>
						<td class='tdhead2'><?if($row['default']==1)echo "Yes";else echo "No"?></td>
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><a href='#' onclick="return edittax(<?=$row['id']?>)"><img src='style/images/icon_edit.png' height='30'/></a><a href='#' onclick="return deltax(<?=$row['id']?>)"><img src='style/images/delete.png' style='height:30px;'/></a></td>
					</tr>						
						<?$i++;}
						if(mysql_num_rows($res)==0){
							echo "<tr><td class='tdhead2' style='border-right:1px solid #e6e6e6; text-align:center;' colspan='5'>No Taxes Defined Yet</td></tr>";
						}
						?>
			</table>
		</div>
						<form action='' onsubmit='return addtax()' method='post'>		
							<table>
								<tr>
									<td>Tax Name</td>
									<td><input type='text' class='req settings' id='tax_name'/></td>
								</tr>				
								<tr>
									<td>Value</td>
									<td><input type='text' class='req settings' style='width:100px;' id='tax_value'/><font style='font-size:11px;'>Ex. 20% or 20</font></td>
								</tr>								
								<tr>
									<td>Default?</td>
									<td><input type='checkbox' value='1' id='default'/><font style='font-size:11px;'></font></td>
								</tr>			
								<tr>
									<td colspan='2'><input type='submit' name='step1' value='Add Tax' class='button'></td>
								</tr>
							</table>
						</form>	
			<br>
 </body>
 </html>