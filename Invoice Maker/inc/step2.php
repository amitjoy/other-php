<?
	$res=mysql_query("select * from invoices order by id desc")or die(mysql_error());
		$r=mysql_fetch_array($res);
		$id=$r['id']+1;
?>
<table width='100%' cellspacing='0' cellpadding='0'>
	<tr>
		<td><b>Invoice #<?=$id?></b></td>
	</tr>
</table>
<script type='text/javascript'>
	refresh_prods()
</script>
<div id='ajaxreturn'>
<div id='products_box'><center>Loading...</center></div>
<div id='total_price'>
	<table cellspacing='0' cellpadding='0'>
		<tr>
			<td>Subtotal:</td>
			<td><b style='font-size:13px;'></b></td>
		</tr>
		<tr>
			<td>Taxes:</td>
			<td><b style='font-size:13px;'></b></td>
		</tr>
		<tr>
			<td>TOTAL:</td>
			<td><b style='font-size:15px;'></b></td>
		</tr>
	</table>
</div>
</div>

<div style='clear:both;'></div>
<table width='100%'>
	<tr>
		<td width='420'>
			<form action='' onsubmit='return addproduct()' method='post'>
				<table>
					<tr>
						<td>Product Title</td>
						<td><input type='text' class='req settings' id='prod_title'/></td>
					</tr>				
					<tr>
						<td>Description</td>
						<td><textarea class='req settings' id='prod_description'/></textarea></td>
					</tr>
					<tr>
						<td>Price</td>
						<td><input type='text' class='req settings' style='width:100px;' id='prod_price'/></td>
					</tr>		
					<tr>
						<td>Quantity</td>
						<td><input type='text' class='req settings' style='width:100px;' id='prod_qty' value='1'/></td>
					</tr>		
					<tr>
						<td align='center' colspan='2'><input type='submit' name='step1' value='Add product' class='button'></td>
					</tr>
				</table>	
			</form>
		</td>
		<td valign='top'><b>Taxes</b><br/>
			<?
				$res=mysql_query("select * from taxes where hidden='0' order by name")or die(mysql_error());
					while($row=mysql_fetch_array($res)){?>
					<input type='checkbox' name='tax[]' value='<?=$row['value']?>' <?if($row['default']==1)echo "checked"?> class='sometax'/><?=$row['name']?><br/>
					<?}?>
		</td>
		<td align='right' valign='bottom'>
			<form action='' method='POST'><input type='submit' name='step2' value='Finish &raquo;' class='button'></form>
		</td>
	</tr>
</table>