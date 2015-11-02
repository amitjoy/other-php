<?php
// ------------------------------------------------------------
// PAYPAL BUTTON VALUES EXPLANATION
// ------------------------------------------------------------
/*
- name="cmd" value="_xclick-subscriptions" - The button that the person clicked was a Subscribe button.
- name="business" - Your PayPal ID or an email address associated with your PayPal account. Email addresses must be confirmed. 
- name="lc" value="US" - The language of the login or sign-up page that subscribers see when they click the Subscribe button. If unspecified, the language is determined by a PayPal cookie in the subscriber's browser. If there is no PayPal cookie, the default language is U.S. English.
- name="item_name" - Description of item. If omitted, payers enter their own name at the time of payment.
- name="item_number" - Pass-through variable for you to track product or service purchased or the contribution made. The value you specify passed back to you upon payment completion.
- name="no_note" - Do not prompt payers to include a note with their payments. For Subscribe buttons, always include no_note and set it to 1.
- name="no_shipping" - Do not prompt payers for shipping address. Allowable values:0 – prompt for an address, but do not require one 1 – do not prompt for an address 2 – prompt for an address, and require one The default is 0.
- name="rm" - Return method. The FORM METHOD used to send data to the URL specified by the return variable after payment completion. Allowable values:0 – all shopping cart transactions use the GET method 1 – the payer's browser is redirected to the return URL by the GET method, and no transaction variables are sent 2 – the payer's browser is redirected to the return URL by the POST method, and all transaction variables are also posted
- name="return" - The URL to which the payer's browser is redirected after completing the payment; for example, a URL on your site that displays a "Thank you for your payment" page. Default – The browser is redirected to a PayPal web page.
- name="cancel_return" - A URL to which the payer's browser is redirected if payment is cancelled; for example, a URL on your website that displays a "Payment Canceled" page. Default – The browser is redirected to a PayPal web page.
- name="src" - Recurring payments. Subscription payments recur unless subscribers cancel their subscriptions before the end of the current billing cycle or you limit the number of times that payments recur with the value that you specify for srt. Allowable values: 0 – subscription payments do not recur 1 – subscription payments recur
- name="srt" - Recurring times. Number of times that subscription payments recur. Specify an integer above 1. Valid only if you specify src="1".
- name="a1" - Trial period 1 price. For a free trial period, specify 0.
- name="p1" - Trial period 1 duration. Required if you specify a1. Specify an integer value in the allowable range for the units of duration that you specify with t1. 
- name="t1" - Trial period 1 units of duration. Required if you specify a1. Allowable values: D – for days; allowable range for p1 is 1 to 90 W – for weeks; allowable range for p1 is 1 to 52 M – for months; allowable range for p1 is 1 to 24 Y – for years; allowable range for p1 is 1 to 5
- name="a2" - Trial period 2 price. Can be specified only if you also specify a1. 
- name="p2" - Trial period 2 duration. Required if you specify a2. Specify an integer value in the allowable range for the units of duration that you specify with t2.
- name="t2" - Trial period 2 units of duration. Allowable values: D – for days; allowable range for p2 is 1 to 90 W – for weeks; allowable range for p2 is 1 to 52 M – for months; allowable range for p2 is 1 to 24 Y – for years; allowable range for p2 is 1 to 5
- name="a3" - Regular subscription price.
- name="p3" - Subscription duration. Specify an integer value in the allowable range for the units of duration that you specify with t3.
- name="t3" - Regular subscription units of duration. Allowable values: D – for days; allowable range for p3 is 1 to 90 W – for weeks; allowable range for p3 is 1 to 52 M – for months; allowable range for p3 is 1 to 24 Y – for years; allowable range for p3 is 1 to 5
- name="currency_code" - The currency of prices for trial periods and the subscription. The default is USD. For allowable values, see Currency Codes.
- name="bn" - An identifier of the source that built the code for the button that the payer clicked, sometimes known as the build notation.
- name="notify_url" - The URL to which PayPal posts information about the transaction, in the form of Instant Payment Notification messages.
- name="custom" - User-defined field which will be passed through the system and returned in your merchant payment notification email. This field will not be shown to your subscribers.
*/

// get required includes
require_once(ROOT_PATH.'user/modules/accordion/error_messages.php');

// declare variables
$msg = '';
$display_paypal = 0;
$display_signup = 0;
$display_expired_banner = 0;
$expired_banner_msg = '';
$pp_membership_type = 'none';
$pp_premium_amount = 0;
$add_free_trial_1 = 0;
$add_free_trial_2 = 0;
$add_auto_renew_times = 0;
$discount_amount = 'none';

// check if coupon code was sent
if(isset($_POST['txb_coupon']) && !empty($_POST['txb_coupon']))
{
	$txb_coupon = mysqli_real_escape_string($conn,trim($_POST['txb_coupon']));
	$read_only = '';
}
else
{
	$txb_coupon = '';
	$read_only = '';
}

// check for type selection session
if(isset($_SESSION['selected_type']) && !empty($_SESSION['selected_type']))
{
	$selected_type = $_SESSION['selected_type'];
}

// ------------------------------------------------------------
// 1. DISPLAY CURRENT MEMBERSHIP INFO ON PAGE LOAD
// ------------------------------------------------------------
if($user_name)
{ 
	// DB: get membership info
	$get_membership_info = mysqli_query($conn, "SELECT NOW() as CurrentTime, IsPremium, PremiumType, PremiumStartDate, PremiumEndDate, PremiumAmount, IsPending, IsCancelled, CancelledDate, IsEndOfTerm FROM users WHERE UserName = '$user_name' Limit 1") 
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_membership_info) == 1 )
	{
		$row = mysqli_fetch_array($get_membership_info);
		$current_time = $row['CurrentTime'];
		$is_premium = $row['IsPremium'];
		$premium_type = $row['PremiumType'];
		$premium_start_date = $row['PremiumStartDate'];
		$premium_end_date = $row['PremiumEndDate'];
		$premium_amount = 'USD $' . $row['PremiumAmount'];
		$is_pending = $row['IsPending'];
		$is_cancelled = $row['IsCancelled'];
		$cancelled_date = $row['CancelledDate'];
		$is_end_of_term = $row['IsEndOfTerm'];
		
		// ------------------------------------------------------------
		// WHEN TO TURN OFF PREMIUM ACCESS?
		// ------------------------------------------------------------

		// if premium has expired - did not receive next payment
		if($is_premium == 1 && strtotime($premium_end_date) < strtotime($current_time) || $is_premium == 0 && $premium_end_date != '0000-00-00 00:00:00' && strtotime($premium_end_date) < strtotime($current_time))
		{
			$premium_type = 'Free Membership';
			$display_expired_banner = 1;
			$expired_banner_msg = 'Your current membership type is set to "Free Membership". Premium content will not be available until the next payment is received.';
			
			// set premium to 0
			$update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 0, PremiumLevel = 0 WHERE UserName = '$user_name'") 
			or die($dataaccess_error);
		}

		// ------------------------------------------------------------
		// WHEN TO SHOW / NOT SHOW MEMBERSHIP SIGNUP FORM?
		// ------------------------------------------------------------
		
		// if membership has been cancelled and expired
		if($is_cancelled == 1 && strtotime($premium_end_date) < strtotime($current_time))
		{
			$display_signup = 1;
			$display_expired_banner = 1;
			$expired_banner_msg = 'Your previous membership has been cancelled. Your current membership type is "Free Membership". To become a Premium Member, please use the form provided below.';
			$premium_type = 'Free Membership';

			// reset membership in users table
			$update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 0, PremiumType = 'Free Membership', PremiumStartDate = '0000-00-00 00:00:00', PremiumEndDate = '0000-00-00 00:00:00', PremiumAmount = 0.00, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = 0  WHERE UserName = '$user_name'") 
			or die($dataaccess_error);
		}

		// if eot has been sent by paypal and membership has expired
		if($is_end_of_term == 1 && strtotime($premium_end_date) < strtotime($current_time))
		{
			$display_signup = 1;
			$display_expired_banner = 1;
			$expired_banner_msg = 'Your previous subscription has ended. Your current membership type is "Free Membership". To become a Premium Member, please use the form provided below.';
			$premium_type = 'Free Membership';

			// reset membership in users table
			$update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 0, PremiumType = 'Free Membership', PremiumStartDate = '0000-00-00 00:00:00', PremiumEndDate = '0000-00-00 00:00:00', PremiumAmount = 0.00, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = 0  WHERE UserName = '$user_name'") 
			or die($dataaccess_error);
		}

		// if user is not a premium member
		if($is_premium == 0 && $premium_end_date == '0000-00-00 00:00:00')
		{
			$display_signup = 1;
			$premium_type = 'Free Membership';
			$display_expired_banner = 1;
			$expired_banner_msg = 'Your current membership status does not allow you to view premium content. To become a Premium Member, please use the form provided below. <strong>PLEASE NOTE!</strong> If you have just subscribed and still see the form below, then PayPal is still in the process of sending the verification.';
		}
		
		// if membership status is pending
		if($is_pending == 1)
		{
			$display_signup = 0;
			$premium_type = 'Payment Pending';
			$display_expired_banner = 1;
			$expired_banner_msg = 'Your current membership status is <strong>Pending</strong> and waiting for Confirmation from PayPal. After receipt of confirmation your premium membership will be active.';
		}
	}
}

// ------------------------------------------------------------
// 2. DISPLAY DEFAULT MEMBERSHIP TYPE IN DROPDOWNLIST ON PAGE LOAD
// ------------------------------------------------------------
if(isset($_POST['ddl_membership_types']))
{
	// ------------------------------------------------------------
	// selected membership type ddl values
	// ------------------------------------------------------------
	$sent_membership_type = mysqli_real_escape_string($conn, $_POST['ddl_membership_types']);
	list($types_id, $types_label) = explode('|', $sent_membership_type);
	
	$default_type_value = $types_id .'|'. $types_label;
	$default_type = $types_label;

	// create session
	$_SESSION['selected_type'] = $types_id;
}
else
{
	// ------------------------------------------------------------
	// default membership type ddl values
	// ------------------------------------------------------------
	$default_type_value = '0|Step 1. Select Membership --';
	$default_type = 'Step 1. Select Membership --';
}

// ------------------------------------------------------------
// 3. DISPLAY DEFAULT MEMBERSHIP RATE IN DROPDOWNLIST
// ------------------------------------------------------------
if(isset($_POST['ddl_membership_rates']))
{
	// ------------------------------------------------------------
	// selected membership rate ddl values
	// ------------------------------------------------------------
	$sent_membership_rate = mysqli_real_escape_string($conn, $_POST['ddl_membership_rates']);
	list($rates_id, $rates_label) = explode('|', $sent_membership_rate);
	
	// check if session exist
	if(isset($selected_type) && $selected_type == $types_id && $rates_label != 'Step 2. Select Membership Rate --')
	{
		// display in membership rates ddl
		$selected_rate_value = $rates_id .'|'. $rates_label;
		$selected_rate = $rates_label;
		
		// set read only on coupon code
		$read_only = 'readonly="readonly"';
		
		//***************** << START PAYPAL BUTTON >> *****************
		// ------------------------------------------------------------
		// CONFIGURE PAYPAL BUTTON - add relevant data
		// ------------------------------------------------------------
		// display PayPal order form
		$display_paypal = 1;
		
		// show user selected membership type and rate
		$pp_membership_type = $types_label;
		$pp_premium_amount = $rates_label;
		
		// ------------------------------------------------------------
		// DB: get paypal configurations
		$get_paypal_config = mysqli_query($conn, "SELECT PaypalGateway, PaypalSandbox, IsSandbox, MerchantAccountId, SuccessURL, CancelURL, PaypalCurrency, IpnURL FROM paypal_config Limit 1") 
		or die($dataaccess_error);
		// ------------------------------------------------------------
		
		if(mysqli_num_rows($get_paypal_config) == 1 )
		{
			$row = mysqli_fetch_array($get_paypal_config);
			$paypal_gateway = $row['PaypalGateway'];
			$paypal_sandbox = $row['PaypalSandbox'];
			$is_sandbox_on = $row['IsSandbox'];
			
			// button form action
			if($is_sandbox_on == 1)
			{
				$form_action = $paypal_sandbox;
			}
			elseif($is_sandbox_on == 0)
			{
				$form_action = $paypal_gateway;
			}
			
			// paypal merchant account ID
			$merchant_account_id = $row['MerchantAccountId'];
			
			// success url
			$success_url = $row['SuccessURL'];

			// cancel url
			$cancel_url = $row['CancelURL'];

			// currency code
			$currency_code = $row['PaypalCurrency'];

			// notify url (ipn)
			$notify_url = $row['IpnURL'];
		}

		// ------------------------------------------------------------
		// DB: check membership rates
		$get_membership_rates = mysqli_query($conn, "SELECT Description, IntervalLength, IntervalType, IsAutoRenew, AutoRenewTimes, MembershipFee, IsTrial1, Trial1Rate, Trial1Length, Trial1Type, IsTrial2, Trial2Rate, Trial2Length, Trial2Type, PremiumLevel FROM membership_rates WHERE RatesId = $rates_id Limit 1") 
		or die($dataaccess_error);
		// ------------------------------------------------------------

		if(mysqli_num_rows($get_membership_rates) == 1 )
		{
			$row = mysqli_fetch_array($get_membership_rates);
			
			// rate description
			$rate_description = $row['Description'];
			
			// selected membership fee
			$interval_length = $row['IntervalLength'];
			$interval_type = $row['IntervalType'];
			$is_auto_renew = $row['IsAutoRenew'];
			$auto_renew_times = $row['AutoRenewTimes'];
			$m_membership_fee = $row['MembershipFee'];
			
			// premium level set for this rate
			$premium_level = $row['PremiumLevel'];

			// trial settings
			$is_trial_1 = $row['IsTrial1'];
			$trial_1_rate = $row['Trial1Rate'];
			$trial_1_lenth = $row['Trial1Length'];
			$trial_1_type = $row['Trial1Type'];

			$is_trial_2 = $row['IsTrial2'];
			$trial_2_rate = $row['Trial2Rate'];
			$trial_2_lenth = $row['Trial2Length'];
			$trial_2_type = $row['Trial2Type'];

			// translate trial 1 type
			if($trial_1_type == 'D')$trial_1_period = "Day";
			if($trial_1_type == 'W')$trial_1_period = "Week";
			if($trial_1_type == 'M')$trial_1_period = "Month";
			if($trial_1_type == 'Y')$trial_1_period = "Year";

			// translate trial 2 type
			if($trial_2_type == 'D')$trial_2_period = "Day";
			if($trial_2_type == 'W')$trial_2_period = "Week";
			if($trial_2_type == 'M')$trial_2_period = "Month";
			if($trial_2_type == 'Y')$trial_2_period = "Year";

			// if free trial 1 is ON - add to button
			if($is_trial_1 == 1 && $is_trial_2 == 0)
			{
				// add to button
				$add_free_trial_1 = 1;

				// show on form
				$free_trial = $trial_1_lenth.' '.$trial_1_period.' - USD '.$trial_1_rate;
			}

			// if free trial 1 and 2 is ON - add to button
			if($is_trial_1 == 1 && $is_trial_2 == 1)
			{
				$add_free_trial_1 = 1;
				$add_free_trial_2 = 1;

				// show on form
				$free_trial = $trial_1_lenth.' '.$trial_1_period.' - USD '.$trial_1_rate;
				$free_trial .= '<br/> '.$trial_2_lenth.' '.$trial_2_period.' - USD '.$trial_2_rate;
			}

			// if auto renew times is set
			if($is_auto_renew == 1 && $auto_renew_times != 0)
			{
				$add_auto_renew_times = 1;
			}
			
			// ****************** << START COUPON >> *********************
			if(!empty($txb_coupon))
			{
				// ------------------------------------------------------------
				// DB: get coupon details
				$get_coupon_details = mysqli_query($conn, "SELECT NOW() as CurrentDate, Discount, DateStart, DateEnd, IsEnabled, PremiumLevel FROM membership_coupons WHERE CouponCode = '$txb_coupon' Limit 1") 
				or die($dataaccess_error);
				// ------------------------------------------------------------
				
				// if coupon code exist
				if(mysqli_num_rows($get_coupon_details) == 1 )
				{
					$validate_error = 0;
					
					// coupon details
					$row = mysqli_fetch_array($get_coupon_details);
					$c_current_date = strtotime($row['CurrentDate']);
					$c_discount_percentage = $row['Discount'];
					$c_date_start = strtotime($row['DateStart']);
					$c_date_end = strtotime($row['DateEnd']);
					$c_is_enabled = $row['IsEnabled'];
					$c_premium_level = $row['PremiumLevel'];
					
					// if coupon is enabled
					if($c_is_enabled == 1)
					{
						// if current date is within valid date range
						if($c_current_date >= $c_date_start && $c_current_date <= $c_date_end)
						{
							// if premium level match current selection
							if($c_premium_level == $premium_level)
							{
								// if no errors present, calculate discount membership fee
								if($validate_error == 0)
								{
									$savings_amount = ($c_discount_percentage * $m_membership_fee) / 100;
									$final_amount = ($m_membership_fee - $savings_amount);
									$membership_fee = round($final_amount,2);
									$discount_amount = 'USD -' . $savings_amount . ' ('.$c_discount_percentage .'%)';
									$total_amount = 'USD ' . round($final_amount,2);
								}
								else
								{
									// set membership without discount
									$membership_fee = $m_membership_fee;
								}
							}
							else
							{
								// coupon is not valid for this premium level
								$validate_error = 1;
								$msg .= $coupon_premium_incorrect_msg . '<br/>';
								
								// set membership without discount
								$membership_fee = $m_membership_fee;
							}
						}
						else
						{
							// invalid coupon date
							$validate_error = 1;
							$msg .= $coupon_date_incorrect_msg . '<br/>';
							
							// set membership without discount
							$membership_fee = $m_membership_fee;
						}
					}
					else
					{
						// coupon is not enabled
						$validate_error = 1;
						$msg .= $coupon_not_exist_msg . '<br/>';
						
						// set membership without discount
						$membership_fee = $m_membership_fee;
					}
				}
				else
				{
					// coupon does not exist
					$msg .= $coupon_not_exist_msg . '<br/>';
					
					// set membership without discount
					$membership_fee = $m_membership_fee;
				}
			}
			else
			{
				// set membership fee without discount
				$membership_fee = $m_membership_fee;
			}
			// ****************** << END COUPON  >> *********************
		}
		else
		{
			exit();
		}

		// custom field sent to paypal to identify current user
		$custom_field = $user_name.'|'.$rates_id;
		
		//****************** << END PAYPAL BUTTON >> ******************
	}
	else
	{
		$selected_rate_value = '0|Step 2. Select Membership Rate --';
		$selected_rate = 'Step 2. Select Membership Rate --';
	}
}
else
{
	// ------------------------------------------------------------
	// default membership rate ddl values
	// ------------------------------------------------------------
	$selected_rate_value = '0|Step 2. Select Membership Rate --';
	$selected_rate = 'Step 2. Select Membership Rate --';
}
?>