<?
include "inc/functions.php";

if(!$_SESSION['logged']){
	header("Location: login/");
}
	$meniu='taxes';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
	<title>Taxes | Pro Invoice Maker</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.boxshadow.js"></script>
	<script language="javascript" type="text/javascript" src="js/script.js"></script>
	<link rel="stylesheet" media="screen" href="style/style.css" /> 
 </head>
 <body>
	<div id='container'>
	<?include "inc/header.php"?>
		<div class='title'>Taxes</div>
		<div id='content'>
		<div id='ajaxresponse'>
			<table width='100%' cellspacing='0' cellpadding='0'>
				<tr style='background:#5c8c00; color:#fff;'>
					<td class='tdhead' width='20'>ID</td>
					<td class='tdhead' width='580'>Tax Name</td>
					<td class='tdhead'>Amount</td>
					<td class='tdhead' width='60'>Default</td>
					<td class='tdhead' width='60'>Actions</td>
				</tr>
				<?
					$i=1;
				$res=mysql_query("select * from taxes where hidden='0' order by id desc limit 0,10")or die(mysql_error());
						while($row=mysql_fetch_array($res)){
						$pos1 = stripos($row['value'],'%' );
							if ($pos1 !== false) {
								$tax="<b>".$row['value']."</b> of product price";
							}else{
								$tax="<b>".$row['value']."</b> ".$cfg['currency'];
							}

						?>
					<tr onmouseover="$(this).css('background','#efffd0')" onmouseout="$(this).css('background','#fff')">
						<td class='tdhead2'><?=$i?></td>
						<td class='tdhead2'><?=$row['name']?></td>
						<td class='tdhead2'><?=$tax?></td>
						<td class='tdhead2'><?if($row['default']==1)echo "Yes";else echo "No"?></td>
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><a href='#' onclick="return edittax(<?=$row['id']?>)"><img src='style/images/icon_edit.png' height='18'/></a><a href='#' onclick="return deltax(<?=$row['id']?>)"><img src='style/images/delete.png'/></a></td>
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
									<td><input type='text' class='req settings' style='width:100px;' id='tax_value'/><font style='font-size:11px;'>Ex. 20% of product value or 20 for static tax</font></td>
								</tr>								
								<tr>
									<td>Default?</td>
									<td><input type='checkbox' value='1' id='default'/><font style='font-size:11px;'>Will automatically be checked when adding a product</font></td>
								</tr>			
								<tr>
									<td colspan='2'><input type='submit' name='step1' value='Add Tax' class='button'></td>
								</tr>
							</table>
						</form>	
			<br>
		</div>
	</div>
	<?include "inc/footer.php"?>
 </body>
 </html>