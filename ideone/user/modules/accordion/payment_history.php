<?php
// get required includes
require_once(ROOT_PATH.'user/modules/accordion/error_messages.php');

// declare variables
$payment_history = '';

// ------------------------------------------------------------
// 3. DISPLAY PAYMENT HISTORY
// ------------------------------------------------------------

// DB: get payment history
$get_payment_history = mysqli_query($conn, "SELECT mc_gross, Trial1Amount, Trial2Amount, payment_currency, TransactionDate, ExpireDate, item_name, item_number, payment_status FROM paypal_payments WHERE UserName = '$user_name' ORDER BY TransactionDate DESC") 
or die($dataaccess_error);

if(mysqli_num_rows($get_payment_history) > 0 )
{
	while($row = mysqli_fetch_array($get_payment_history))
	{
		$payment_history .= 
		'<tr>'.
		'<td>'.$row['item_name'].
		'<td>'.$row['item_number'].
		'<td>'.$row['payment_currency'].
		'<td>'.$row['Trial1Amount'].
		'<td>'.$row['Trial2Amount'].
		'<td>'.$row['mc_gross'].
		'<td>'.$row['TransactionDate'].
		'<td>'.$row['ExpireDate'].
		'<td>'.$row['payment_status'].
		'</tr>';
	}
}
else
{
	$payment_history .= 
	'<tr>'.
	'<td>'.'none found...'.
	'<td>'.''.
	'<td>'.''.
	'<td>'.''.
	'<td>'.''.
	'<td>'.''.
	'<td>'.''.
	'<td>'.''.
	'<td>'.''.
	'</tr>';
}
?>