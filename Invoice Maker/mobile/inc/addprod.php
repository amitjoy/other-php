<?
include "../../inc/functions.php";
if(!$_SESSION['logged']){die();}
$_POST['taxes']=str_replace('undefined,','',$_POST['taxes']);
if(empty($_SESSION['products']))$_SESSION['products']=array();
	if($_POST['action']=='add'){
		$_SESSION['products'][]=$_POST;
	}
	if($_POST['action']=='delete'){
		unset($_SESSION['products'][$_POST['id']]);
	}	
	
	if($_POST['action']=='update'){
		if($_POST['rule']==0)$_SESSION['products'][$_POST['id']]['qty']-=1;
		if($_POST['rule']==1)$_SESSION['products'][$_POST['id']]['qty']+=1;
	}
?>
<div id='prods' style='background:#fff;'>
<div id='products_box'>
	<table width='100%'>
		<tr style='background:#e2e2e2; color:#000;'>
			<td width='30'>&nbsp;</td>
			<td width='500'>Title</td>
			<td width='120'>Qty</td>
			<td>Net</td>
			<td>Taxes</td>
			<td>Total</td>
			<td>&nbsp;</td>
		</tr>
		<?$i=1;
			foreach($_SESSION['products'] as $tag=>$val){
			unset($tx);
				$tx		=array();
				$taxprod=0;
				$tx=explode(',',$val['taxes']);
					foreach($tx as $tax){
						$pos1 = stripos($tax,'%' );
							$tm=str_replace('%','',$tax);
							if ($pos1 !== false) {
								$taxprod+=($tm*$val['price']*$val['qty'])/100;
							}else{
								$taxprod+=$tm;
							}
					}
			?>
		<tr>
			<td width='30'><?=$i?></td>
			<td width='500'><b><?=$val['title']?></b><br><i style='font-size:11px'><?=$val['description']?></i></td>
			<td width='120'>
				<table cellspacing='0' cellpadding='0'>
					<tr>
						<td><input type='text' class='settings' style='width:60px;' value='<?=$val['qty']?>'/></td>
						<td><table cellspacing='0' cellpadding='0'><tr><td><img src='style/images/quantity_up.gif' style='cursor:pointer;height:13px;'  onclick="update_prod('<?=$tag?>','1')"/></td></tr><tr><td><img src='style/images/quantity_down.gif' style='cursor:pointer;height:13px;' onclick="update_prod('<?=$tag?>','0')"/></td></tr></table></td>
					</tr>
				</table>	
			</td>
			<td><?=$val['qty']*$val['price']?> <?=$cfg['currency']?></td>
			<td><?=$taxprod?></td>
			<td><b><?=($val['qty']*$val['price'])+$taxprod?> <?=$cfg['currency']?></b></td>
			<td width='15'><img src='style/images/delete.png' alt='Delete?' title='Delete?' onclick="deleteprod('<?=$tag?>')" style='cursor:pointer;'/></td>
		</tr>			
		<?$i++;
			$totalmare+=($val['qty']*$val['price'])+$taxprod;
			$subtotal+=$val['qty']*$val['price'];
			$taxes+=$taxprod;
		}?>
	</table>
</div>
<div id='total_price' style='border-top:1px solid #000; font-size:10px;'>
	<table cellspacing='0' cellpadding='0' width='100%'>
		<tr>
			<td>Subtotal:</td>
			<td ><b style='font-size:10px;'><?=$subtotal?> <?=$cfg['currency']?></b></td>
			<td>Taxes:</td>
			<td><b style='font-size:10px;'><?=$taxes?> <?=$cfg['currency']?></b></td>
			<td>TOTAL:</td>
			<td><b style='font-size:13px;'><?=$totalmare?> <?=$cfg['currency']?> <?$_SESSION['total_order']=$totalmare?></b></td>
		</tr>
	</table>
</div>
<div style='clear:both;'></div>
</div>