<?
include "functions.php";
$ex	=	explode('-',decrypt($_GET['id']));
$id_invoice	=$ex[0];

$res=mysql_query("select * from invoices where id='".$id_invoice."'")or die(mysql_error());
	$info=mysql_fetch_array($res);
	
							
	$rex=mysql_query("SELECT SUM(amount) as total FROM payments WHERE invoice='".$info['id']."'")or die(mysql_error());
		$r=mysql_fetch_array($rex);
			if($r['total']<$info['total'] && $r['total']>0){
				$p="<b style='color:#ff5757;'>Partially Paid ".$r['total']." ".$info['currency']."";
			}elseif($r['total']==0){
				$p="<b style='color:#ff0000;'>Unpaid</b>";
			}elseif($r['total']>$info['total']){
				$p="<b style='color:#388c00;'>Paid</b>";
				$pd=1;
			}elseif($r['total']==$info['total']){
				$p="<b style='color:#388c00;'>Paid</b>";
				$pd=1;
			}	
?>
<html> 
<head> 
	<title><?=$cfg['lang_invoice']?> No. #<?=$id_invoice?></title> 
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />  
<style>
	body{
		font-size:11px;
		font-family:Arial;
		color:#000;
	}
	h2{
		font-size:20px;
		margin:3px;
		color:#000;
	}
	h3{
		padding:0px;
		margin:0px;
	}
	h4{
		background:#f5f5f5;
		padding:2px;
		color:#5b5b5b;
		font-size:13px;
		margin-bottom:3px;
	}
</style>
</head> 
<body bgcolor="#FFFFFF"> 
<table width='700' align='center' style='border:1px solid #dcdcdc; font-size:13px;'>	
	<tr>
		<td width='40%'><?if($cfg['display_logo']){?><img src='../<?=$cfg['logo']?>' height='70'/><?}?></td>
		<td align='right'><h2>Invoice No. <?=$id_invoice?></h2><h3><?=$cfg['lang_date']?>: <?=date('d/m/Y',$info['date'])?></h3><b>Status: <?=$p?></b><br></td>
	</tr>	
	<tr>
		<td style='border:1px solid #ccc;padding:10px; font-size:12px;' width='50%'>
			<strong><?=$cfg['lang_client']?></strong><br /><br />
					<?=$info['client_name']?><br /> 
					<?=$info['client_address']?><br /> 
					<?=$info['client_location']?><br /> 
		</td>
		<td style='border:1px solid #ccc;padding:10px; font-size:12px;'>
			<strong><?=$cfg['lang_payto']?></strong><br /><br />
			   	<b><?=$cfg['name']?></b><br />
					<?=$cfg['lang_bank']?>: <?=$cfg['bank_name']?><br />
					<?=$cfg['lang_bank_account']?>: <?=$cfg['bank_account']?>
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<h4>Products</h4>
			<table width='100%' border='1' bordercolor='#dbdbdb' style='border:1px solid #dbdbdb; border-collapse:collapse; font-size:12px;'>
				<tr style='font-weight:bold; text-align:center;'>
					<td width='20'>#</td>
					<td width='250'><?=$cfg['lang_description']?></td>
					<td width='130'><?=$cfg['lang_netprice']?></td>
					<td width='130'><?=$cfg['lang_taxes']?></td>
					<td><?=$cfg['lang_amount']?></td>
				</tr>	
				<?
		$res=mysql_query("select * from products where invoice='".$info['id']."' order by id asc")or die(mysql_error());
		$i=1;
		while($rand=mysql_fetch_array($res)){
			unset($tx);
				$tx		=array();
				$taxprod=0;
				$tx=explode(',',$rand['taxes']);
					foreach($tx as $tax){
						$pos1 = strpos($tax,'%' );
							$tm=str_replace('%','',$tax);
							if ($pos1 !== false) {
								$taxprod+=($tm*$rand['price']*$rand['qty'])/100;
							}else{
								$taxprod+=$tm;
							}
					}
				?>
				<tr>
					<td width='20' style='padding:2px;'><?=$i?></td>
					<td width='250' style='padding:2px;'><?=$rand['title']?></td>
					<td width='130' style='padding:2px;'><?=$rand['price']*$rand['qty']?> <?=$info['currency']?></td>
					<td width='130' style='padding:2px;'><?=$taxprod?> <?=$info['currency']?></td>
					<td style='padding:2px; font-weight:bold; text-align:right;'><?=$taxprod+$rand['price']*$rand['qty']?> <?=$info['currency']?></td>
				</tr>				
			<?$i++;
				$totals+=$rand['qty']*$rand['price'];
				$taxes+=$taxprod;
			}?>	
			<tr style='background:#f9f9f9; color:#585858;'>
				<td colspan='4' style='text-align:right; font-weight:bold;'><?=$cfg['lang_subtotal']?></td>
				<td style='text-align:right;font-weight:bold; font-size:14px;'><?=$totals?> <?=$info['currency']?></td>
			</tr>			
			<tr style='background:#f9f9f9; color:#585858;'>
				<td colspan='4' style='text-align:right; font-weight:bold;'><?=$cfg['lang_taxes']?></td>
				<td style='text-align:right;font-weight:bold; font-size:14px;'><?=$taxes?> <?=$info['currency']?></td>
			</tr>			
			<tr style='background:#f9f9f9; font-size:16px;'>
				<td colspan='4' style='text-align:right; font-weight:bold;'><?=$cfg['lang_total']?></td>
				<td style='text-align:right;font-weight:bold;'><?=$taxes+$totals?> <?=$info['currency']?></td>
			</tr>
			</table>
				<h4>Payments</h4>
			<table width='100%' border='1' bordercolor='#dbdbdb' style='border:1px solid #dbdbdb; border-collapse:collapse; font-size:12px;'>
				<tr style='font-weight:bold; text-align:center;'>
					<td width='20'>#</td>
					<td width='150'>From</td>
					<td width='100'>Date</td>
					<td width='130'>Payment Method</td>
					<td>Amount</td>
				</tr>	
				<?
		$res=mysql_query("select * from payments where invoice='".$info['id']."' order by id asc")or die(mysql_error());
		$i=1;
		while($rand=mysql_fetch_array($res)){
				?>
				<tr>
					<td width='20' style='padding:2px;'><?=$i?></td>
					<td width='250' style='padding:2px;'><?=$rand['from']?></td>
					<td width='130' style='padding:2px;'><?=date('d.m.Y',$rand['date'])?></td>
					<td width='130' style='padding:2px;'><?=$rand['pmethod']?></td>
					<td style='padding:2px; font-weight:bold; text-align:right;'><?=$rand['amount']?> <?=$info['currency']?></td>
				</tr>				
			<?$i++;
				$paid+=$rand['amount'];
				}?>	
			<tr style='background:#f9f9f9; font-size:16px;'>
				<td colspan='4' style='text-align:right; font-weight:bold;'><?=$cfg['lang_total']?></td>
				<td style='text-align:right;font-weight:bold;'><?=$paid?> <?=$info['currency']?></td>
			</tr>			
			</table>
			<?if($pd!=1){?>
				<h4>Rest to pay <span style='float:right;'><?=($totals+$taxes)-$paid?> <?=$info['currency']?></span></h4>	
				<?if($cfg['enable_payments']){?>
	<form method="post" name="paypal_form" action="https://www.paypal.com/cgi-bin/webscr">
		<input type="hidden" name="business" value="<?=$cfg['paypal_email']?>" />
		<input type="hidden" name="cmd" value="_xclick" />
		<!-- the next three need to be created -->
		<input type="hidden" name="image_url" value="http://<?=$_SERVER['HTTP_HOST']?><?=str_replace('inc/invoicehtml.php','',$_SERVER['SCRIPT_NAME'])?>style/images/logo.png" />
		<input type="hidden" name="return" value="http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['PHP_SELF']?>?id=<?=$_GET['id']?>" />
		<input type="hidden" name="cancel_return" value="http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['PHP_SELF']?>?id=<?=$_GET['id']?>" />
		<input type="hidden" name="notify_url" value="http://<?=$_SERVER['HTTP_HOST']?><?=str_replace('invoicehtml.php','',$_SERVER['SCRIPT_NAME'])?>paypal_ipn.php" />
		<input type="hidden" name="rm" value="2" />
		<input type="hidden" name="currency_code" value="<?=$cfg['paypal_currency']?>" />
		<input type="hidden" name="lc" value="US" />
		<input type="hidden" name="bn" value="toolkit-php" />
		<input type="hidden" name="cbt" value="Continue" />


		<!-- Product Information -->
		<input type="hidden" name="item_name" value="Invoice #<?=$id_invoice?> at <?=$cfg['name']?>" />
		<input type="hidden" name="amount" value="<?=($totals+$taxes)-$paid?>" />
		<input type="hidden" name="quantity" value="1" />
		<input type="hidden" name="item_number" value="<?=$id_invoice?>" />
		<input type="hidden" name="on0" value="Client" />
		<input type="hidden" name="os0" value="<?=$info['client_name']?>" />

		<!-- Customer Information -->
		<input type="hidden" name="custom" value="1" />
	<input type="submit" name="Submit" class="formbtn" value="&nbsp;Pay via Paypal&nbsp;" style='float:right;' />
	</form>			
				<div style='clear:both'></div>
				<?}?>
			<?}?>
		</td>
	</tr>
	<tr>
		<td colspan='2'><?=nl2br($cfg['footer'])?></td>
	</tr>
</table>

 
 
<p align="center"><a href="javascript:print()">Print</a> | <a href="invoicepdf.php?id=<?=$_GET['id']?>">Download PDF</a> | <a href="javascript:window.close()">Close</a></p> 
</body> 
</html>