<?php
// ------------------------------------------------------------
// PAYPAL POSTED VALUES EXPLANATION
// https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_IPNandPDTVariables
// ------------------------------------------------------------
/*
subscr_eot - Subscription end of term. A transaction type (txn_type) value.
- For subscriptions with NO RECURRING payments, end of term messages are sent WHEN the SUBSCRIPTION PERIOD ENDS. 
- For subscriptions with RECURRING payments AND a LIMITED number of BILLING CYCLES, end of term messages are sent AT the END of the LAST BILLING CYCLE. 
- For subscriptions that are CANCELLED, end of term messages are sent WHEN the SUBSCRIPTION PERIOD or the CURRENT BILLING CYCLE ENDS. 
- For subscriptions that PayPal CANCELS due to FAILURES in attempts TO COLLECT recurring payments, end of term messages are SENT IMMEDIATELY.

payment_status - The status of the payment: 
- Canceled_Reversal: A reversal has been canceled. For example, you won a dispute with the customer, and the funds for the transaction that was reversed have been returned to you. 
- Completed: The payment has been completed, and the funds have been added successfully to your account balance.
- Created: A German ELV payment is made using Express Checkout.
- Denied: You denied the payment. This happens only if the payment was previously pending because of possible reasons described for the pending_reason variable or the Fraud_Management_Filters_x variable.
- Expired: This authorization has expired and cannot be captured.
- Failed: The payment has failed. This happens only if the payment was made from your customer's bank account.
- Pending: The payment is pending. See pending_reason for more information.
- Refunded: You refunded the payment.
- Reversed: A payment was reversed due to a chargeback or other type of reversal. The funds have been removed from your account balance and returned to the buyer. The reason for the reversal is specified in the ReasonCode element.
- Processed: A payment has been accepted. 
- Voided: This authorization has been voided.

item_name - Item name as passed by you, the merchant. Or, if not passed by you, as entered by your customer. If this is a shopping cart transaction, PayPal will append the number of the item (e.g., item_name1, item_name2, and so forth). Length: 127 characters

item_number - Pass-through variable for you to track purchases. It will get passed back to you at the completion of the payment. If omitted, no variable will be passed back to you. If this is a shopping cart transaction, PayPal will append the number of the item (e.g., item_number1, item_number2, and so forth) Length: 127 characters

mc_gross - Full amount of the customer's payment, before transaction fee is subtracted. Equivalent to payment_gross for USD payments. If this amount is negative, it signifies a refund or reversal, and either of those payment statuses can be for the full or partial amount of the original transaction.

mc_fee - Transaction fee associated with the payment. mc_gross minus mc_fee equals the amount deposited into the receiver_email account. Equivalent to payment_fee for USD payments. If this amount is negative, it signifies a refund or reversal, and either of those payment statuses can be for the full or partial amount of the original transaction fee.

mc_currency - 
- For payment IPN notifications, this is the currency of the payment. 
- For non-payment subscription IPN notifications (i.e., txn_type= signup, cancel, failed, eot, or modify), this is the currency of the subscription. 
- For payment subscription IPN notifications, it is the currency of the payment (i.e., txn_type = subscr_payment)

txn_id - The merchant's original transaction identification number for the payment from the buyer, against which the case was registered. Transaction ID is unique for every transaction.

txn_type - The kind of transaction for which the IPN message was sent. txn_type is sent with every transaction.
- subscr_cancel - Subscription canceled
- subscr_eot - Subscription expired
- subscr_failed - Subscription signup failed
- subscr_modify - Subscription modified
- subscr_payment - Subscription payment received
- subscr_signup - Subscription started

receiver_email - Primary email address of the payment recipient (that is, the merchant). If the payment is sent to a non-primary email address on your PayPal account, the receiver_email is still your primary email. Note: The value of this variable is normalized to lowercase characters. Length: 127 characters

payer_email - Customer's primary email address. Use this email to provide any credits. Length: 127 characters

mc_amount1 - Amount of payment for trial period 1 for USD payments; otherwise blank (optional).

mc_amount2 - Amount of payment for trial period 2 for USD payments; otherwise blank (optional).

custom - Custom value as passed by you, the merchant. These are pass-through variables that are never presented to your customer Length: 255 characters
*/

// --------------------------------------------------------
// log errors to paypal_ipn_errors.log file
// --------------------------------------------------------
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/paypal_ipn_errors.log');

// --------------------------------------------------------
// add required includes
// --------------------------------------------------------
require_once('../web.config.php');

// --------------------------------------------------------
// check if premium membership is enabled
// --------------------------------------------------------
if(ENABLE_PREMIUM_MEMBERSHIP == 1)
{
    require_once('../connect/mysql.php');
    require_once('../lib/paypal_ipn_listener.class.php');

    // --------------------------------------------------------
    // instantiate the PayPalIpnListener class
    // --------------------------------------------------------
    $listener = new PayPalIpnListener();

    // --------------------------------------------------------
    // should we post to paypal sandbox or live gateway?
    // --------------------------------------------------------
    $get_paypal_config = mysqli_query($conn, "SELECT IsSandbox FROM paypal_config Limit 1")
    or die();

    if(mysqli_num_rows($get_paypal_config) == 1)
    {
        $row = mysqli_fetch_array($get_paypal_config);
        $is_sandbox_on = $row['IsSandbox'];
        
        if($is_sandbox_on == 1)
        {
            $listener->use_sandbox = true;
        }
        elseif($is_sandbox_on == 0)
        {
            $listener->use_sandbox = false;
        }
    }

    /*
    DEVELOPER NOTES: 
    By default the IpnListener object is going  going to post the data back to PayPal
    using cURL over a secure SSL connection. This is the recommended way to post
    the data back, however, some people may have connections problems using this
    method. 
    */

    // To post over standard HTTP connection, uncomment the line below:
    // $listener->use_ssl = false;

    // To post using the fsockopen() function rather than cURL, uncomment the line below:
    // $listener->use_curl = false;

    /*
    DEVELOPER NOTES: 
    The processIpn() method will encode the POST variables sent by PayPal and then
    POST them back to the PayPal server. An exception will be thrown if there is 
    a fatal error (cannot connect, your server is not configured properly, etc.).
    Use a try/catch block to catch these fatal errors and log to the ipn_errors.log
    file we setup at the top of this file. The processIpn() method will send the 
    raw data on 'php://input' to PayPal. You can optionally pass the data to 
    processIpn() yourself:
    */

    $verified = $listener->processIpn($my_post_data);
    try
    {
        $listener->requirePostMethod();
        $verified = $listener->processIpn();
    } 
    catch(Exception $e)
    {
        error_log($e->getMessage());
        exit(0);
    }

    // --------------------------------------------------------
    // The processIpn() method returns true if the IPN was 
    // "VERIFIED" and false if it was "INVALID".
    // --------------------------------------------------------
    if($verified)
    {
        // --------------------------------------------------------
        // assign paypal recieved variables to local variables
        // --------------------------------------------------------
        $subscr_id = $_POST['subscr_id'];
        $item_name = urldecode($_POST['item_name']);
        $item_number = urldecode($_POST['item_number']);
        if(isset($_POST['payment_status'])){$payment_status = $_POST['payment_status'];}else{$payment_status = 'none';}
        if(isset($_POST['pending_reason'])){$pending_reason = $_POST['pending_reason'];}else{$pending_reason = 'none';}
        if(isset($_POST['period1'])){$period_1 = $_POST['period1'];}
        if(isset($_POST['mc_amount1'])){$trial_period_1 = $_POST['mc_amount1'];}else{$trial_period_1 = '0.00';}
        if(isset($_POST['period2'])){$period_2 = $_POST['period2'];}
        if(isset($_POST['mc_amount2'])){$trial_period_2 = $_POST['mc_amount2'];}else{$trial_period_2 = '0.00';}
        if(isset($_POST['period3'])){$period_3 = $_POST['period3'];}
        if(isset($_POST['mc_amount3'])){$membership_fee = $_POST['mc_amount3'];}else{$membership_fee = '0.00';}
        if(isset($_POST['mc_gross'])){$mc_gross = $_POST['mc_gross'];}else{$mc_gross = '0.00';}
        $payment_currency = $_POST['mc_currency'];
        if(isset($_POST['txn_id'])){$txn_id = $_POST['txn_id'];}else{$txn_id = 'none';}
        $txn_type = $_POST['txn_type'];
        if(isset($_POST['mc_fee'])){$mc_fee = $_POST['mc_fee'];}else{$mc_fee = '0.00';}
        $receiver_email = urldecode($_POST['receiver_email']);
        $payer_email = urldecode($_POST['payer_email']);
        $custom = urldecode($_POST['custom']);
        if(isset($custom)){list($user_name, $rates_id) = explode('|', $custom);}

        // -------------------------------------------------------- 
        // IF NEW SIGNUP
        // --------------------------------------------------------
        if($txn_type == 'subscr_signup')
        {               
            /* 
            DEVELOPER NOTES:
            This is a subscription signup which could be for Perio1,2 or 3!
            If it is for trial-1 with 0.00 amount, then we must handle it here, activate premium membership -
            and calculate expiration date because this is all we will get for a free trial-1 period since -
            there isn't an actual transaction taking place. NO payment_status = Complete will arrive.
            If it is NOT for a free trial-1 period with 0.00, then we can just record it as a regular signup.
            */
            
            // -------------------------------------------------------- 
            // 0. get merchant email and currency type from db 
            // --------------------------------------------------------
            $get_merchant_id = mysqli_query($conn, "SELECT MerchantAccountID, PaypalCurrency  FROM paypal_config LIMIT 1")
            or die();
            
            // if merchant email is present in the database, compare with what was received from PayPal
            if(mysqli_num_rows($get_merchant_id) == 1)
            {
                $row = mysqli_fetch_array($get_merchant_id);
                $merchant_id = $row['MerchantAccountID'];
                $currency_type = $row['PaypalCurrency'];
                
                // if the payment reciver is not you!
                if($receiver_email != $merchant_id)
                {
                    // insert signup info with FLAG for BadTransaction
                    require_once(ROOT_PATH.'user/modules/ipn/db_bad_transaction.php');

                    // send email to admin for manual investigation
                    $postdata = file_get_contents('php://input');
                    require_once(ROOT_PATH.'user/modules/ipn/e_invalid_merchant.php');
                    exit();
                }
                
                // if the currency type does not match!
                if($payment_currency != $currency_type)
                {
                    // insert signup info with FLAG for BadTransaction
                    require_once(ROOT_PATH.'user/modules/ipn/db_bad_transaction.php');

                    // send email to admin for manual investigation
                    $postdata = file_get_contents('php://input');
                    require_once(ROOT_PATH.'user/modules/ipn/e_invalid_currency.php');
                    exit();
                }
            }
            
            // get rate details from db based on the rate id received from PayPal
            $get_rate_details = mysqli_query($conn, "SELECT  IsTrial1, Trial1Rate, Trial1Length, Trial1Type, PremiumLevel FROM membership_rates WHERE RatesId = $rates_id LIMIT 1")
            or die();
            
            // if rate id received from paypal is found in database
            if(mysqli_num_rows($get_rate_details) == 1 )
            {
                $row = mysqli_fetch_array($get_rate_details);
                $is_trial_1 = $row['IsTrial1'];
                $trial_1_rate = $row['Trial1Rate'];
                $trial_1_length = $row['Trial1Length'];
                $trial_1_type = $row['Trial1Type'];
                $premium_level = $row['PremiumLevel'];
                
                // -------------------------------------------------------- 
                // 1. if trial-1 is ON and the amount is 0.00 this is a 
                // transaction for a free trial-1 period and we must handle 
                // it here as a payment_status=Completed
                // --------------------------------------------------------
                if($is_trial_1 == 1 && $trial_1_rate == 0.00)
                {
                    // translate interval types for calculating expiration date
                    if($trial_1_type == 'D')$trial_1_type = "DAY";
                    if($trial_1_type == 'W')$trial_1_type = "WEEK";
                    if($trial_1_type == 'M')$trial_1_type = "MONTH";
                    if($trial_1_type == 'Y')$trial_1_type = "YEAR";
                    
                    // insert new signup info into paypal_payments table
                    $insert_signup_info = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),ADDDATE(NOW(), INTERVAL $trial_1_length $trial_1_type),'$item_name','$item_number','$receiver_email','$payer_email','Completed',0)") 
                    or die();
                    
                    // enable premium, calculate expiration date, add allowed premium level
                    $update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 1, PremiumType = '$item_name', PremiumStartDate = NOW(), PremiumEndDate = ADDDATE(NOW(), INTERVAL $trial_1_length $trial_1_type), PremiumAmount = '$mc_gross', IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = $premium_level WHERE UserName = '$user_name'") 
                    or die();
                }
                
                // -------------------------------------------------------- 
                // 2. if this is NOT a trial-1 or a trial-1 with greater
                // than 0.00 amount, we record it as a regular signup.
                // For this, PayPal WILL send a payment_status=Completed and
                // that will be handled in that section of this IPN.
                // --------------------------------------------------------
                if($is_trial_1 == 0 || $is_trial_1 == 1 && $trial_1_rate > 0.00)
                {
                    // insert new signup info into paypal_payments table
                    $insert_signup_info = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),'0000-00-00 00:00:00','$item_name','$item_number','$receiver_email','$payer_email','Signup',0)") 
                    or die();
                }
            }
            else
            {
                // rate id sent by paypal was not found in the database - no such item exist
                // insert signup info with FLAG for BadTransaction
                require_once(ROOT_PATH.'user/modules/ipn/db_bad_transaction.php');
            }
        }
                    
        // -------------------------------------------------------- 
        // IF CANCELLED
        // --------------------------------------------------------
        if($txn_type == 'subscr_cancel')
        {
            /*
            DEVELOPER NOTES:
            Here we simply insert the transaction sent by PayPal for the subscription cancellation - 
            and set the IsCancelled column for the user account to 1 to reflect the changes.
            Actual cancellation takes place at the expiration date which is checked for at the time -
            of accessing premium content pages.
            */
            
            // insert cancellation info into paypal_payments table to create a record of it
            $insert_cancel_info = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),'0000-00-00 00:00:00','$item_name','$item_number','$receiver_email','$payer_email','Cancelled',0)") 
            or die();

            // update users table - set iscancelled column to 1 and record cancellation date
            $update_user_account = mysqli_query($conn, "UPDATE users SET IsCancelled = 1, CancelledDate = NOW() WHERE UserName = '$user_name'") 
            or die();
        }
        
        // -------------------------------------------------------- 
        // IF END OF TERM
        // --------------------------------------------------------
        if($txn_type == 'subscr_eot')
        {
            /*
            DEVELOPER NOTES:
            Here we simply insert the transaction sent by PayPal for the subscription end of term - 
            and set the IsEndOfTerm column for the user account to 1 to reflect the changes.
            Actual termination of subscription takes place at the expiration date which is checked -
            for at the time of accessing premium content.
            */
            
            // insert eot info into paypal_payments table
            $insert_eot_info = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),'0000-00-00 00:00:00','$item_name','$item_number','$receiver_email','$payer_email','End Of Term',0)") 
            or die();
            
            // update users table
            $update_user_account = mysqli_query($conn, "UPDATE users SET IsEndOfTerm = 1, EndOfTermDate = NOW() WHERE UserName = '$user_name'") 
            or die();
        }
        
        // -------------------------------------------------------- 
        // IF FAILED
        // --------------------------------------------------------
        if($txn_type == 'subscr_failed')
        {
            /*
            DEVELOPER NOTES:
            Here we simply record the transaction sent by PayPal. This does nothing other than 
            recording the event. If the transaction eventually succeeds, it will be handled by
            one of the other txn_types of this IPN.
            */
            
            // insert failed attempt into paypal_payments table
            $insert_failed_info = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),'0000-00-00 00:00:00','$item_name','$item_number','$receiver_email','$payer_email','Failed',1)") 
            or die();
            
            // do nothing in the user table. 
            // PayPal will send cancellation after three failed attempts.
        }
        
        // -------------------------------------------------------- 
        // IF PAYMENT - PENDING
        // --------------------------------------------------------
        if($txn_type == 'subscr_payment' && $payment_status == 'Pending')
        {
            /*
            DEVELOPER NOTES:
            Here we simply record the transaction sent by PayPal. If PayPal eventually sends
            a payment_status = Complete, this record will be updated along with the user account
            in another txn_type. In the mean time we set the Pending to true in the user account.
            */
            
            // insert new pending info into paypal_payments table
            $insert_pending_info = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,pending_reason,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),'0000-00-00 00:00:00','$item_name','$item_number','$receiver_email','$payer_email','$payment_status','$pending_reason',0)") 
            or die();
            
            // update users table
            $update_user_account = mysqli_query($conn, "UPDATE users SET IsPending = 1, PendingDate = NOW() WHERE UserName = '$user_name'") 
            or die();
        }
        
        // -------------------------------------------------------- 
        // IF PAYMENT - COMPLETED
        // --------------------------------------------------------
        if($txn_type == 'subscr_payment' && $payment_status == 'Completed')
        {
            /*
            DEVELOPER NOTES:
            Check for transaction id, merchant email, currency type, amounts. Check if transaction id 
            already exist with a payment_status=Pending and if it does, and the current transaction 
            is payment_status=Completed we update the existing record to reflect those changes. If this 
            is a new transaction, we create a new record, calculate expiration date and update the user 
            account.
            
            Eventhough the information sent from PayPal does not distinguish between periods, our application
            does this for us. When subscription rates are created, it is made sure that only trial-1 can be
            free 0.00 amount, and none of the period prices can match. This way we can figure out which period 
            the transaction is for, just by checking the received mc_gross amount against the period amounts
            assigned to each subscription rate in the db. Each subscription period can have three different
            prices and time periods so it is essential that we know which one we are dealing with so we can
            accuratelly calculate the expiration date without which the whole application would fall apart.
            */
            
            // if we received a txn_id from PayPal for this transaction - only comes with payment_status=Completed
            if(isset($txn_id) && $txn_id != 'none')
            {
                // get merchant id and currency type from paypal_config table
                $get_merchant_id = mysqli_query($conn, "SELECT MerchantAccountID, PaypalCurrency FROM paypal_config LIMIT 1")
                or die();
                
                // if the details are present in db
                if(mysqli_num_rows($get_merchant_id) == 1 )
                {
                    $row = mysqli_fetch_array($get_merchant_id);
                    $merchant_id = $row['MerchantAccountID'];
                    $currency_type = $row['PaypalCurrency'];

                    // if payment receiver is not you!
                    if($receiver_email != $merchant_id)
                    {
                        // insert info with FLAG for BadTransaction
                        require_once(ROOT_PATH.'user/modules/ipn/db_bad_transaction.php');

                        // send email to admin for manual investigation
                        $postdata = file_get_contents('php://input');
                        require_once(ROOT_PATH.'user/modules/ipn/e_invalid_merchant.php');
                        exit();
                    }
                    
                    // if the currency type does not match!
                    if($payment_currency != $currency_type)
                    {
                        // insert signup info with FLAG for BadTransaction
                        require_once(ROOT_PATH.'user/modules/ipn/db_bad_transaction.php');

                        // send email to admin for manual investigation
                        $postdata = file_get_contents('php://input');
                        require_once(ROOT_PATH.'user/modules/ipn/e_invalid_currency.php');
                        exit();
                    }
                }
                
                // assign received txn_id to variable
                $transaction_id = mysqli_real_escape_string($conn, $txn_id);
                
                // get transaction details based on the above received txn_id
                $check_txn_id = mysqli_query($conn, "SELECT subscr_id, txn_id, txn_type, UserName, RatesId, mc_gross, payment_currency, receiver_email, payment_status FROM paypal_payments WHERE txn_id = '$transaction_id' LIMIT 1")
                or die();
                
                // -------------------------------------------------------- 
                // if txn_id already exists in db
                // This block only runs if the received txn_id matches a 
                // txn_id present in the database
                // -------------------------------------------------------- 
                if(mysqli_num_rows($check_txn_id) == 1 )
                {
                    $row = mysqli_fetch_array($check_txn_id);
                    $t_subscr_id = $row['subscr_id'];
                    $t_txn_type = $row['txn_type'];
                    $t_UserName = $row['UserName'];
                    $t_RatesId = $row['RatesId'];
                    $t_mc_gross = $row['mc_gross'];
                    $t_payment_currency = $row['payment_currency'];
                    $t_receiver_email = $row['receiver_email'];
                    $t_payment_status = $row['payment_status'];
                    
                    // if existing status is pending and recived status is completed
                    if($t_payment_status == 'Pending' && $payment_status == 'Completed')
                    {
                        // check that everything else matches
                        if($t_subscr_id == $subscr_id && $t_txn_type == $txn_type && $t_UserName == $user_name && $t_RatesId == $rates_id && $t_mc_gross == $mc_gross && $t_payment_currency == $payment_currency)
                        {
                            // get rate details based on sent rate id so we can check prices and calculate expiration date
                            $get_rate_details = mysqli_query($conn, "SELECT  Trial1Rate, Trial1Length, Trial1Type, Trial2Rate, Trial2Length, Trial2Type, MembershipFee, IntervalLength, IntervalType, PremiumLevel FROM membership_rates WHERE RatesId = $rates_id LIMIT 1")
                            or die();
                            
                            // if rate details exist in db
                            if(mysqli_num_rows($get_rate_details) == 1 )
                            {
                                $row = mysqli_fetch_array($get_rate_details);
                                $t_trial_1_rate = $row['Trial1Rate'];
                                $t_trial_1_length = $row['Trial1Length'];
                                $t_trial_1_type = $row['Trial1Type'];
                                $t_trial_2_rate = $row['Trial2Rate'];
                                $t_trial_2_length = $row['Trial2Length'];
                                $t_trial_2_type = $row['Trial2Type'];
                                $t_membership_fee = $row['MembershipFee'];
                                $t_interval_length = $row['IntervalLength'];
                                $t_interval_type = $row['IntervalType'];
                                $t_premium_level = $row['PremiumLevel'];
                                
                                // -------------------------------------------------------- 
                                // 1. if this is Trial-1 Period
                                // -------------------------------------------------------- 
                                if($mc_gross == $t_trial_1_rate)
                                {
                                    // translate interval types
                                    if($t_trial_1_type == 'D')$t_trial_1_type = "DAY";
                                    if($t_trial_1_type == 'W')$t_trial_1_type = "WEEK";
                                    if($t_trial_1_type == 'M')$t_trial_1_type = "MONTH";
                                    if($t_trial_1_type == 'Y')$t_trial_1_type = "YEAR";
                                    
                                    // update existing transaction
                                    $update_transaction = mysqli_query($conn, "UPDATE paypal_payments SET payment_status = '$payment_status',TransactionDate = NOW(),ExpireDate = ADDDATE(NOW(), INTERVAL $t_trial_1_length $t_trial_1_type) WHERE txn_id = '$transaction_id'") 
                                    or die();
                                    
                                    // enable premium, calculate expiration date, add allowed premium level
                                    $update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 1, PremiumType = '$item_name', PremiumStartDate = NOW(), PremiumEndDate = ADDDATE(NOW(), INTERVAL $t_trial_1_length $t_trial_1_type), PremiumAmount = '$mc_gross', IsPending = 0, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = $t_premium_level WHERE UserName = '$user_name'") 
                                    or die();
                                }
                                
                                // -------------------------------------------------------- 
                                // 2. if this is Trial-2 Period
                                // -------------------------------------------------------- 
                                if($mc_gross == $t_trial_2_rate)
                                {
                                    // translate interval types
                                    if($t_trial_2_type == 'D')$t_trial_2_type = "DAY";
                                    if($t_trial_2_type == 'W')$t_trial_2_type = "WEEK";
                                    if($t_trial_2_type == 'M')$t_trial_2_type = "MONTH";
                                    if($t_trial_2_type == 'Y')$t_trial_2_type = "YEAR";
                                    
                                    // update existing transaction
                                    $update_transaction = mysqli_query($conn, "UPDATE paypal_payments SET payment_status = '$payment_status',TransactionDate = NOW(),ExpireDate = ADDDATE(NOW(), INTERVAL $t_trial_2_length $t_trial_2_type) WHERE txn_id = '$transaction_id'") 
                                    or die();
                                    
                                    // enable premium, calculate expiration date, add allowed premium level
                                    $update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 1, PremiumType = '$item_name', PremiumStartDate = NOW(), PremiumEndDate = ADDDATE(NOW(), INTERVAL $t_trial_2_length $t_trial_2_type), PremiumAmount = '$mc_gross', IsPending = 0, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = $t_premium_level WHERE UserName = '$user_name'") 
                                    or die();
                                }
                                
                                // -------------------------------------------------------- 
                                // 3. if this is Regular Subscription Period
                                // -------------------------------------------------------- 
                                if($mc_gross == $t_membership_fee)
                                {
                                    // translate interval types
                                    if($t_interval_type == 'D')$t_interval_type = "DAY";
                                    if($t_interval_type == 'W')$t_interval_type = "WEEK";
                                    if($t_interval_type == 'M')$t_interval_type = "MONTH";
                                    if($t_interval_type == 'Y')$t_interval_type = "YEAR";
                                    
                                    // update existing transaction
                                    $update_transaction = mysqli_query($conn, "UPDATE paypal_payments SET payment_status = '$payment_status',TransactionDate = NOW(),ExpireDate = ADDDATE(NOW(), INTERVAL $t_interval_length $t_interval_type) WHERE txn_id = '$transaction_id'") 
                                    or die();

                                    // enable premium, calculate expiration date, add allowed premium level
                                    $update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 1, PremiumType = '$item_name', PremiumStartDate = NOW(), PremiumEndDate = ADDDATE(NOW(), INTERVAL $t_interval_length $t_interval_type), PremiumAmount = '$mc_gross', IsPending = 0, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = $t_premium_level WHERE UserName = '$user_name'") 
                                    or die();
                                }
                                
                                // -------------------------------------------------------- 
                                // 4. if gross amount received from paypal does not match
                                //    any of the above - we have a problem!
                                // -------------------------------------------------------- 
                                if($mc_gross != $t_trial_1_rate && $mc_gross != $t_trial_2_rate && $mc_gross != $t_membership_fee)
                                {
                                    // insert payment info with FLAG for BadTransaction
                                    require_once(ROOT_PATH.'user/modules/ipn/db_bad_transaction.php');

                                    // send email to admin for investigation
                                    $postdata = file_get_contents('php://input');
                                    require_once(ROOT_PATH.'user/modules/ipn/e_invalid_amount.php');
                                    exit();
                                }
                            }
                        }
                    }
                    
                    // txn_id was found and updated
                    // we can exit here safely
                    exit();
                }
                // -------------------------------------------------------- 
                // if txn_id does NOT exist in db
                // This block only runs if the received txn_id does NOT 
                // exist in the database - this is a NEW transaction!
                // -------------------------------------------------------- 
                else
                {
                    // get rate details based on sent rate id
                    $get_rate_details = mysqli_query($conn, "SELECT  Trial1Rate, Trial1Length, Trial1Type, Trial2Rate, Trial2Length, Trial2Type, MembershipFee, IntervalLength, IntervalType, PremiumLevel FROM membership_rates WHERE RatesId = $rates_id LIMIT 1")
                    or die();
                    
                    // if rate details exist
                    if(mysqli_num_rows($get_rate_details) == 1 )
                    {
                        $row = mysqli_fetch_array($get_rate_details);
                        $t_trial_1_rate = $row['Trial1Rate'];
                        $t_trial_1_length = $row['Trial1Length'];
                        $t_trial_1_type = $row['Trial1Type'];
                        $t_trial_2_rate = $row['Trial2Rate'];
                        $t_trial_2_length = $row['Trial2Length'];
                        $t_trial_2_type = $row['Trial2Type'];
                        $t_membership_fee = $row['MembershipFee'];
                        $t_interval_length = $row['IntervalLength'];
                        $t_interval_type = $row['IntervalType'];
                        $t_premium_level = $row['PremiumLevel'];
                        
                        // -------------------------------------------------------- 
                        // 1. if this is Trial-1 Period
                        // -------------------------------------------------------- 
                        if($mc_gross == $t_trial_1_rate)
                        {
                            // translate interval types
                            if($t_trial_1_type == 'D')$t_trial_1_type = "DAY";
                            if($t_trial_1_type == 'W')$t_trial_1_type = "WEEK";
                            if($t_trial_1_type == 'M')$t_trial_1_type = "MONTH";
                            if($t_trial_1_type == 'Y')$t_trial_1_type = "YEAR";
                            
                            // insert new info into paypal_payments table
                            $insert_payment_info = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),ADDDATE(NOW(), INTERVAL $t_trial_1_length $t_trial_1_type),'$item_name','$item_number','$receiver_email','$payer_email','$payment_status',0)") 
                            or die();
                            
                            // enable premium, calculate expiration date, add allowed premium level
                            $update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 1, PremiumType = '$item_name', PremiumStartDate = NOW(), PremiumEndDate = ADDDATE(NOW(), INTERVAL $t_trial_1_length $t_trial_1_type), PremiumAmount = '$mc_gross', IsPending = 0, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = $t_premium_level WHERE UserName = '$user_name'") 
                            or die();
                        }
                        
                        // -------------------------------------------------------- 
                        // 2. if this is Trial-2 Period
                        // --------------------------------------------------------
                        if($mc_gross == $t_trial_2_rate)
                        {
                            // translate interval types
                            if($t_trial_2_type == 'D')$t_trial_2_type = "DAY";
                            if($t_trial_2_type == 'W')$t_trial_2_type = "WEEK";
                            if($t_trial_2_type == 'M')$t_trial_2_type = "MONTH";
                            if($t_trial_2_type == 'Y')$t_trial_2_type = "YEAR";
                            
                            // insert new info into paypal_payments table
                            $insert_payment_info = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),ADDDATE(NOW(), INTERVAL $t_trial_2_length $t_trial_2_type),'$item_name','$item_number','$receiver_email','$payer_email','$payment_status',0)") 
                            or die();
                            
                            // enable premium, calculate expiration date, add allowed premium level
                            $update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 1, PremiumType = '$item_name', PremiumStartDate = NOW(), PremiumEndDate = ADDDATE(NOW(), INTERVAL $t_trial_2_length $t_trial_2_type), PremiumAmount = '$mc_gross', IsPending = 0, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = $t_premium_level WHERE UserName = '$user_name'") 
                            or die();
                        }
                        
                        // -------------------------------------------------------- 
                        // 3. if this is Regular Subscription Period
                        // -------------------------------------------------------- 
                        if($mc_gross == $t_membership_fee)
                        {
                            // translate interval types
                            if($t_interval_type == 'D')$t_interval_type = "DAY";
                            if($t_interval_type == 'W')$t_interval_type = "WEEK";
                            if($t_interval_type == 'M')$t_interval_type = "MONTH";
                            if($t_interval_type == 'Y')$t_interval_type = "YEAR";
                            
                            // insert new info into paypal_payments table
                            $insert_payment_info = mysqli_query($conn, "INSERT INTO paypal_payments(subscr_id,txn_id,txn_type,UserName,RatesId,custom,mc_gross,mc_fee,Trial1Amount,Trial2Amount,MembershipFee,payment_currency,TransactionDate,ExpireDate,item_name,item_number,receiver_email,payer_email,payment_status,BadTransaction) VALUES('$subscr_id','$txn_id','$txn_type','$user_name',$rates_id,'$custom','$mc_gross','$mc_fee','$trial_period_1','$trial_period_2','$membership_fee','$payment_currency',NOW(),ADDDATE(NOW(), INTERVAL $t_interval_length $t_interval_type),'$item_name','$item_number','$receiver_email','$payer_email','$payment_status',0)") 
                            or die();
                            
                            // enable premium, calculate expiration date, add allowed premium level
                            $update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 1, PremiumType = '$item_name', PremiumStartDate = NOW(), PremiumEndDate = ADDDATE(NOW(), INTERVAL $t_interval_length $t_interval_type), PremiumAmount = '$mc_gross', IsPending = 0, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = $t_premium_level WHERE UserName = '$user_name'") 
                            or die();
                        }
                        
                        // -------------------------------------------------------- 
                        // 4. if gross amount received from paypal does not match
                        //    any of the above - we have a problem!
                        // -------------------------------------------------------- 
                        if($mc_gross != $t_trial_1_rate && $mc_gross != $t_trial_2_rate && $mc_gross != $t_membership_fee)
                        {
                            // insert payment info with FLAG for BadTransaction
                            require_once(ROOT_PATH.'user/modules/ipn/db_bad_transaction.php');

                            // send email to admin for investigation
                            $postdata = file_get_contents('php://input');
                            require_once(ROOT_PATH.'user/modules/ipn/e_invalid_amount.php');
                            exit();
                        }
                    }
                }
            }
            // all completed transactions should come with a txn_id!!?
            else
            {
                // insert info with FLAG for BadTransaction
                require_once(ROOT_PATH.'user/modules/ipn/db_bad_transaction.php');
                exit();
            }
        }

        // --------------------------------------------------------
        // send a full transaction report to specified recipient
        // --------------------------------------------------------
        // mail(NO_REPLY, 'Verified IPN', $listener->getTextReport());
    }
    else
    {
        // -------------------------------------------------------- 
        // FOR TESTING: notify admin via email
        // --------------------------------------------------------
        $postdata = file_get_contents('php://input');
        require_once(ROOT_PATH.'user/modules/ipn/e_invalid_transaction.php');
        exit();

        // --------------------------------------------------------
        // send a full transaction report to specified recipient
        // --------------------------------------------------------
        // mail(NO_REPLY, 'Invalid IPN', $listener->getTextReport());
    }
}
?>