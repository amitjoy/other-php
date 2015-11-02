<?php
include "functions.php";

$url = 'https://www.paypal.com/cgi-bin/webscr';
$postdata = '';
foreach($_POST as $i => $v) {
	$postdata .= $i.'='.urlencode($v).'&';
}
$postdata .= 'cmd=_notify-validate';

$web = parse_url($url);
if ($web['scheme'] == 'https') { 
	$web['port'] = 443;  
	$ssl = 'ssl://'; 
} else { 
	$web['port'] = 80;
	$ssl = ''; 
}
$fp = @fsockopen($ssl.$web['host'], $web['port'], $errnum, $errstr, 30);

if (!$fp) { 
	echo $errnum.': '.$errstr;
} else {
	fputs($fp, "POST ".$web['path']." HTTP/1.1\r\n");
	fputs($fp, "Host: ".$web['host']."\r\n");
	fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
	fputs($fp, "Content-length: ".strlen($postdata)."\r\n");
	fputs($fp, "Connection: close\r\n\r\n");
	fputs($fp, $postdata . "\r\n\r\n");

	while(!feof($fp)) { 
		$info[] = @fgets($fp, 1024); 
	}
	fclose($fp);
	$info = implode(',', $info);
	if (eregi('VERIFIED', $info)) { 
		$emailtext="
		<table width='400' align='center'>
			<tr>
				<td><b>Invoice</b></td>
				<td>".$_POST['item_number']."</td>
			</tr>	
			<tr>
				<td><b>From</b></td>
				<td>".$_POST['option_selection1']."</td>
			</tr>		
			<tr>
				<td><b>Amount</b></td>
				<td>".$_POST['mc_gross']." ".$_POST['mc_currency']."</td>
			</tr>	
			<tr>
				<td><b>Date</b></td>
				<td>".date('d.m.Y')."</td>
			</tr>
		</table>
		";
		mysql_query("Insert into payments(`from`,date,amount,invoice,pmethod) values('".$_POST['option_selection1']."','".time()."','".$_POST['mc_gross']."','".$_POST['item_number']."','Paypal')")or die(mysql_error());

		mailer($cfg['email'],"Payment for Invoice #".$_POST['item_number']." from ".$_POST['option_selection1'],$emailtext);

	} else {
$emailtext		="Transaction details:\n\n";

foreach ($_POST as $key => $value){
$emailtext .= $key . " = " .$value ."<br><br>";
}	
			mailer('adipetcu@yahoo.com',"Hello! There was an error @ a payment :(",$emailtext);
	}
}
?>