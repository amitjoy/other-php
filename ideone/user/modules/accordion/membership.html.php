<?php require_once(ROOT_PATH.'user/modules/accordion/membership.php'); ?>
<div class="profileWrap">
  <div class="history">
    <a id="btnHistoryShow" href="payment-history.php" class="btn2">Payment History</a>
    <a id="btnHistory" href="#" class="btn2">hide</a>
  </div>
  <form name="frmMembership" method="post" action="" class="htmlForm">
    <div id="historyPanel" class="membership">
      <h4>Current Membership Status:</h4>
      <p>
        <label>Membership Type:</label>
        <label><?php echo $premium_type; ?></label>
      </p>
      <div class="clearLeft"></div>
      <p>
        <label>Last Payment Date:</label>
        <label><?php echo $premium_start_date; ?></label>
      </p>
      <div class="clearLeft"></div>
      <p>
        <label>Last Amount Paid:</label>
        <label><?php echo $premium_amount; ?></label>
      </p>
      <div class="clearLeft"></div>
      <p>
        <label>Expires On:</label>
        <label><?php echo $premium_end_date; ?></label>
      </p>
      <div class="clearLeft"></div>
      <p>
        <label>Current Server Time:</label>
        <label><?php echo $current_time; ?></label>
      </p>
      <div class="clearLeft"></div>
    </div>
    <!-- display expired banner? -->
    <?php if($display_expired_banner == 1){ ?>
    <div class="msgBox4"><?php echo $expired_banner_msg; ?></div>
    <br/>
    <?php } ?>
    <!-- display membership options? -->
    <?php if($display_signup == 1){ ?>
    <div class="membership2">
      <h4>Premium Membership Options:</h4>
      <!-- error msgs -->
      <ul>
        <?php echo $msg; ?>
      </ul>
      <p>
        <label for="ddl_coupon">Have a Coupon Code?</label>
        <input name="txb_coupon" type="text" id="ddl_coupon" class="waterMark" <?php echo $read_only; ?> value="<?php echo $txb_coupon;?>" maxlength="20">
      </p>
      <p>
        <label for="ddl_membership_types">Membership Option(s):</label>
        <select name="ddl_membership_types" title="Select a Membership Type" onchange="this.form.submit();">
          <option value="<?php echo $default_type_value; ?>"><?php echo $default_type; ?></option>
          <?php require_once(ROOT_PATH.'user/modules/accordion/membership_types.php'); ?>
        </select>
      </p>
      <p>
        <label for="ddl_membership_rates">Membership Rate(s):</label>
        <select name="ddl_membership_rates" title="Select a Membership Rate" onchange="this.form.submit();">
          <option value="<?php echo $selected_rate_value; ?>"><?php echo $selected_rate; ?></option>
          <?php require_once(ROOT_PATH.'user/modules/accordion/membership_rates.php'); ?>
        </select>
      </p>
    </div>
    <?php } ?>
  </form>
  <!-- display selected membership -->
  <?php if($display_paypal == 1){ ?>
  <div class="membership4"> <?php echo $rate_description; ?> </div>
  <div class="membership3">
    <h4>You have selected the following:</h4>
    <?php if($add_free_trial_1 == 1){ ?>
    <p>
      <label>Trial Period:</label>
      <label><?php echo $free_trial; ?></label>
    </p>
    <div class="clearLeft"></div>
    <?php } ?>
    <p>
      <label>Membership Type:</label>
      <label><?php echo $pp_membership_type; ?></label>
    </p>
    <div class="clearLeft"></div>
    <p>
      <label>Subscription Rate:</label>
      <label><?php echo $pp_premium_amount; ?></label>
    </p>
    <div class="clearLeft"></div>
    <p>
      <label>Coupon Discount:</label>
      <label><?php echo $discount_amount; ?></label>
    </p>
    <div class="clearLeft"></div>
    <?php if(isset($total_amount)){ ?>
    <p>
      <label>Total:</label>
      <label><?php echo $total_amount; ?></label>
    </p>
    <?php } ?>
    <div class="clearLeft"></div>
    <div class="pp_image"></div>
    <div class="pp_btn">
      <form action="<?php echo $form_action; ?>" method="post">
        <input type="hidden" name="cmd" value="_xclick-subscriptions">
        <input type="hidden" name="business" value="<?php echo $merchant_account_id; ?>">
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="item_name" value="<?php echo $pp_membership_type; ?>">
        <input type="hidden" name="item_number" value="<?php echo $pp_premium_amount; ?>">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="rm" value="1">
        <input type="hidden" name="return" value="<?php echo $success_url; ?>">
        <input type="hidden" name="cancel_return" value="<?php echo $cancel_url; ?>">
        <?php if($add_free_trial_1 == 1){ ?>
        <input type="hidden" name="a1" value="<?php echo $trial_1_rate; ?>">
        <input type="hidden" name="p1" value="<?php echo $trial_1_lenth; ?>">
        <input type="hidden" name="t1" value="<?php echo $trial_1_type; ?>">
        <?php } ?>
        <?php if($add_free_trial_2 == 1){ ?>
        <input type="hidden" name="a2" value="<?php echo $trial_2_rate; ?>">
        <input type="hidden" name="p2" value="<?php echo $trial_2_lenth; ?>">
        <input type="hidden" name="t2" value="<?php echo $trial_2_type; ?>">
        <?php } ?>
        <input type="hidden" name="src" value="<?php echo $is_auto_renew; ?>">
        <input type="hidden" name="a3" value="<?php echo $membership_fee; ?>">
        <input type="hidden" name="p3" value="<?php echo $interval_length; ?>">
        <input type="hidden" name="t3" value="<?php echo $interval_type; ?>">
        <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">
        <?php if($add_auto_renew_times == 1){ ?>
        <input type="hidden" name="srt" value="<?php echo $auto_renew_times; ?>">
        <?php } ?>
        <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.png:NonHosted">
        <input type="hidden" name="notify_url" value="<?php echo $notify_url ?>">
        <input type="hidden" name="custom" value="<?php echo $custom_field ?>">
        <input type="image" src="<?php echo SITE_URL; ?>user/themes/default/images/profile/btn_subscribeCC_LG.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
      </form>
    </div>
  </div>
  <?php } ?>
</div>
