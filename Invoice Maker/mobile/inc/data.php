<?
include "../../inc/functions.php";
if(!$_SESSION['logged']){die();}
?>
var user = new Array();
	<?
		$res=mysql_query("SELECT * FROM `invoices` group by client_location,client_name")or die(mysql_error());
		$cnt=mysql_num_rows($res);
		$i=1;
			while($row=mysql_fetch_array($res)){
			$row['client_address']=preg_replace("/\r/", '',preg_replace("/\n/", '\n', $row['client_address']));
	?>
 user['<?=$row['id']?>'] = new Array();
	user['<?=$row['id']?>']['name']="<?=$row['client_name']?>";
	user['<?=$row['id']?>']['email']="<?=$row['client_email']?>";
	user['<?=$row['id']?>']['phone']="<?=$row['client_phone']?>";
	user['<?=$row['id']?>']['address']="<?=$row['client_address']?>";
	user['<?=$row['id']?>']['location']="<?=$row['client_location']?>";
	<?$i++;}?>


var products = [
	<?
		$res=mysql_query("SELECT * FROM `products` group by title,price")or die(mysql_error());
		$cnt=mysql_num_rows($res);
		$i=1;
			while($row=mysql_fetch_array($res)){
			$row['description']=preg_replace("/\r/", '',preg_replace("/\n/", '\n', $row['description']));
	?>
	{ title: "<?=$row['title']?>", description: "<?=$row['description']?>", price: "<?=$row['price']?>" }<?if($i!=$cnt)echo ",\n"?>
	<?$i++;}?>
];

var pmethods = [
<?
$pm=array();
	$res=mysql_query("select distinct payment_method from invoices order by payment_method")or die(mysql_error());
		while($row=mysql_fetch_array($res)){
			$pm[]='"'.$row['payment_method'].'"';
		}
		echo implode(',',$pm)
?>
];