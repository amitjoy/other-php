<?php
// insert payment info with FLAG for BadTransaction
$insert_bad_transaction = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,pending_reason,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),'0000-00-00 00:00:00','$item_name','$item_number','$receiver_email','$payer_email','Failed','$pending_reason',1)") 
or die($db_conn_err);
?>