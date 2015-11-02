<?
include "inc/functions.php";

if(!$_SESSION['logged']){
	header("Location: login/");
}
	$meniu='add';
		if(isset($_POST['step2'])){		
		mysql_query("delete from products where invoice='".$_GET['id']."'")or die(mysql_error());
			foreach($_SESSION['products'] as $tag=>$val){
				mysql_query("insert into products(title,description,qty,price,taxes,invoice) values('".$val['title']."','".$val['description']."','".$val['qty']."','".$val['price']."','".$val['taxes']."','".$_GET['id']."')")or die(mysql_error());
			}	
			mysql_query("update invoices set total='".$_SESSION['total_order']."' where id='".$_GET['id']."'")or die(mysql_error());	
			unset($_SESSION['products'],$_SESSION['order']);	
			$_SESSION['invoice']=$_GET['id'];	
			header("Location: add.php?step=3");
		}
		
		unset($_SESSION['products']);
		
		$res=mysql_query("select * from products where invoice='".$_GET['id']."'")or die(mysql_error());
			while($row=mysql_fetch_array($res)){
				$_SESSION['products'][]=$row;
			}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
	<title>New Invoice | Pro Invoice Maker</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="js/script.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.ajaxQueue.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.boxshadow.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.autocomplete.js"></script>
	<script language="javascript" type="text/javascript" src="inc/data.php"></script>
	<link rel="stylesheet" media="screen" href="style/style.css" /> 
	<link rel="stylesheet" media="screen" href="style/jquery.autocomplete.css" />
	
<script type="text/javascript">
$().ready(function() {
	$("#suggest13").autocomplete(emails, {
		minChars: 0,
		width: 306,
		max:20,
		matchContains: "word",
		autoFill: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + row.name + "\" , " + row.location + "";
		},
		formatMatch: function(row, i, max) {
			return row.name;
			
		},
		formatResult: function(row) {
			return row.to;
		}
	});	

	$('#suggest13').result(function(event, data, formatted) {
		$('#email').val(data.email);
		$('#phone').val(data.phone);
		$('#address').val(data.address);
		$('#location').val(data.location);
	});	
	
	$("#prod_title").autocomplete(products, {
		minChars: 0,
		width: 306,
		max:20,		
		matchContains: "word",
		autoFill: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + row.title + "\" , " + row.price + " <?=$cfg['currency']?>";
		},
		formatMatch: function(row, i, max) {
			return row.title;
			
		},
		formatResult: function(row) {
			return row.to;
		}
	});	

	$('#prod_title').result(function(event, data, formatted) {
		$('#prod_description').val(data.description);
		$('#prod_price').val(data.price);
	});
	
		
	$("#pmethod").autocomplete(pmethods, {
		minChars: 0,
		width: 306,
		matchContains: "word",
		autoFill: false
	});

});
</script>		
 </head>
 <body>
	<div id='container'>
	<?include "inc/header.php"?>
		<div class='title'>New Invoice</div>
		<div id='step'>
			<table align='center'>
				<tr>
					<td class='step <?if($step==1){?>current<?}elseif($step>1){?>done<?}?>'>Setup Client</td>
					<td class='step <?if($step==2){?>current<?}elseif($step>2){?>done<?}?>'>Add Products</td>
					<td class='step <?if($step==3){?>current<?}elseif($step>3){?>done<?}?>'>Save/Export</td>
				</tr>
			</table>
		</div>
		<div id='content'>
			<table width='100%' cellspacing='0' cellpadding='0'>
				<tr>
					<td><b>Invoice #<?=$_GET['id']?></b></td>
					<td align='right'>VAT: <b><?=$cfg['vat']?>%</b></td>
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
						<td>VAT:</td>
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
									<td><input type='text' class='req settings' style='width:100px;' id='prod_qty'/></td>
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
						<form action='' method='POST'><input type='submit' name='step2' value='Update &raquo;' class='button'></form>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?include "inc/footer.php"?>
 </body>
 </html>