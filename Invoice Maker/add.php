<?
include "inc/functions.php";

if(!$_SESSION['logged']){
	header("Location: login/");
}
	$meniu='add';
	$step=1;
		if(isset($_GET['step'])){
			$step=$_GET['step'];
		}
		
		if(isset($_POST['step1'])){
			$_SESSION['order']['client_name']=$_POST['client_name'];
			$_SESSION['order']['client_email']=$_POST['client_email'];
			$_SESSION['order']['client_phone']=$_POST['client_phone'];
			$_SESSION['order']['client_address']=$_POST['client_address'];
			$_SESSION['order']['client_location']=$_POST['client_location'];
			$_SESSION['order']['payment_method']=$_POST['payment_method'];
			header("Location: add.php?step=2");
		}		
		
		if(isset($_POST['step2'])){
			mysql_query("insert into invoices(client_name,client_email,client_phone,client_address,client_location,payment_method,vat,total,currency,date) values('".$_SESSION['order']['client_name']."','".$_SESSION['order']['client_email']."','".$_SESSION['order']['client_phone']."','".$_SESSION['order']['client_address']."','".$_SESSION['order']['client_location']."','".$_SESSION['order']['payment_method']."','".$cfg['vat']."','".$_SESSION['total_order']."','".$cfg['currency']."','".time()."')")or die(mysql_error()."1");
				$id=mysql_insert_id();
				
			foreach($_SESSION['products'] as $tag=>$val){
				mysql_query("insert into products(title,description,qty,price,taxes,invoice) values('".$val['title']."','".$val['description']."','".$val['qty']."','".$val['price']."','".$val['taxes']."','".$id."')")or die(mysql_error()."2");
			}
			
			unset($_SESSION['products'],$_SESSION['order']);
			$_SESSION['invoice']=$id;
			header("Location: add.php?step=3");
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
			<?
			if($step==1){include "inc/step1.php";}
			if($step==2){include "inc/step2.php";}
			if($step==3){include "inc/step3.php";}
			?>
		</div>
	</div>
	<?include "inc/footer.php"?>
 </body>
 </html>