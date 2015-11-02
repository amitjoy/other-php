<?
include "../inc/functions.php";
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
			header("Location: newinvoice.php?step=2");
		}		
		
		if(isset($_POST['step2'])){
			mysql_query("insert into invoices(client_name,client_email,client_phone,client_address,client_location,payment_method,vat,total,currency,date) values('".$_SESSION['order']['client_name']."','".$_SESSION['order']['client_email']."','".$_SESSION['order']['client_phone']."','".$_SESSION['order']['client_address']."','".$_SESSION['order']['client_location']."','".$_SESSION['order']['payment_method']."','".$cfg['vat']."','".$_SESSION['total_order']."','".$cfg['currency']."','".time()."')")or die(mysql_error()."1");
				$id=mysql_insert_id();
				
			foreach($_SESSION['products'] as $tag=>$val){
				mysql_query("insert into products(title,description,qty,price,taxes,invoice) values('".$val['title']."','".$val['description']."','".$val['qty']."','".$val['price']."','".$val['taxes']."','".$id."')")or die(mysql_error()."2");
			}
			
			unset($_SESSION['products'],$_SESSION['order']);
			$_SESSION['invoice']=$id;
			header("Location: newinvoice.php?step=3");
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
					var user = new Array();
					<?
						$res=mysql_query("SELECT * FROM `invoices` group by client_location,client_name")or die(mysql_error());
						$cnt=mysql_num_rows($res);
						$i=1;
							while($row=mysql_fetch_array($res)){
							$row['client_address']=preg_replace("/\r/", '',preg_replace("/\n/", '\n', $row['client_address']));
					?>
					user[<?=$row['id']?>] = new Array();
					user[<?=$row['id']?>]['name']="<?=$row['client_name']?>";
					user[<?=$row['id']?>]['email']="<?=$row['client_email']?>";
					user[<?=$row['id']?>]['phone']="<?=$row['client_phone']?>";
					user[<?=$row['id']?>]['address']="<?=$row['client_address']?>";
					user[<?=$row['id']?>]['location']="<?=$row['client_location']?>";
					<?$i++;}?>					
					
					var prod = new Array();
					<?
						$res=mysql_query("SELECT * FROM `products` group by title,price")or die(mysql_error());
						$cnt=mysql_num_rows($res);
						$i=1;
							while($row=mysql_fetch_array($res)){
							$row['description']=preg_replace("/\r/", '',preg_replace("/\n/", '\n', $row['description']));
					?>
					prod[<?=$row['id']?>] = new Array();
					prod[<?=$row['id']?>]['title']="<?=str_replace('"','',$row['title'])?>";
					prod[<?=$row['id']?>]['description']="<?=str_replace('"','',$row['description'])?>";
					prod[<?=$row['id']?>]['price']="<?=str_replace('"','',$row['price'])?>";
					<?$i++;}?>

					
					
			selectclient=function(val){
				var selected=$('#selected_client').val();
					$('#name').val(user[selected]['name']);
					$('#email').val(user[selected]['email']);
					$('#phone').val(user[selected]['phone']);
					$('#address').val(user[selected]['address']);
					$('#location').val(user[selected]['location']);
			}			
			
			selectprod=function(val){
				var selected=$('#selected_prod').val();
					$('#prod_title').val(prod[selected]['title']);
					$('#prod_description').val(prod[selected]['description']);
					$('#prod_price').val(prod[selected]['price']);
			}

            $("body").css("display", "none");
            $("body").fadeIn(1000);
    });
	
</script>
</head>
<body>
	<div class='title' style='text-align:left;'>New Invoice<div style='float:right;background:#004876' onclick="moveto('index.php')">BACK</div></div>
			<?
			if($step==1){include "inc/step1.php";}
			if($step==2){include "inc/step2.php";}
			if($step==3){include "inc/step3.php";}
			?>
</body>
</html>