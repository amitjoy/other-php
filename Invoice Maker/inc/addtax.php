<?
include "functions.php";
if(!$_SESSION['logged']){die();}
	if($_POST['action']=='add'){
		$res=mysql_query("insert into taxes(`name`,`value`,`default`) values('".$_POST['name']."','".$_POST['value']."','".$_POST['default']."')")or die(mysql_error());
	}
	if($_POST['action']=='delete'){
		mysql_query("update taxes set hidden='1' where id='".$_POST['id']."'")or die(mysql_error());
	}
	
	if($_POST['action']=='update'){
		mysql_query("update taxes set `name`='".$_POST['name']."',`value`='".$_POST['value']."',`default`='".$_POST['default']."' where id='".$_POST['id']."'")or die(mysql_error());
	}

?>
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
				if($_POST['edit']==$row['id']){?>
					<tr onmouseover="$(this).css('background','#efffd0')" onmouseout="$(this).css('background','#fff')">
						<td class='tdhead2'><?=$i?></td>
						<td class='tdhead2'><input type='text' class='settings req2' name='name' id='name2' value='<?=$row['name']?>' style='margin-left:0px;'/></td>
						<td class='tdhead2'><input type='text' class='settings req2' name='value' id='value2' value='<?=$row['value']?>' style='width:80px; margin-left:0px;'/></td>
						<td class='tdhead2'><input type='checkbox' name='default' id='default2' value='1' <?if($row['default']==1)echo "checked"?>/></td>						
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><a href='#' onclick="return edit2tax(<?=$row['id']?>)"><img src='style/images/tick.png' height='18'/></a><a href='#' onclick="return edittax('0')"><img src='style/images/cancel.png' height='18'/></a></td>
					</tr>
				<?}else{
						?>
					<tr onmouseover="$(this).css('background','#efffd0')" onmouseout="$(this).css('background','#fff')">
						<td class='tdhead2'><?=$i?></td>
						<td class='tdhead2'><?=$row['name']?></td>
						<td class='tdhead2'><?=$tax?></td>
						<td class='tdhead2'><?if($row['default']==1)echo "Yes";else echo "No"?></td>						
						<td class='tdhead2' align='right' style='border-right:1px solid #e6e6e6;'><a href='#' onclick="return edittax(<?=$row['id']?>)"><img src='style/images/icon_edit.png' height='18'/></a><a href='#' onclick="return deltax(<?=$row['id']?>)"><img src='style/images/delete.png'/></a></td>
					</tr>						
						<?}$i++;}
						if(mysql_num_rows($res)==0){
							echo "<tr><td class='tdhead2' style='border-right:1px solid #e6e6e6; text-align:center;' colspan='7'>No Taxes Defined Yet</td></tr>";
						}
						?>
			</table>