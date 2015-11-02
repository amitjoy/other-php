<?php 
// --------------------------------------------------------------
// IF PROFILES ARE ENABLED IN CONFIG FILE
// --------------------------------------------------------------
if(ENABLE_USER_PROFILES == 1){ ?>
<?php require_once(ROOT_PATH.'user/modules/accordion/banner.html.php'); ?>
  <?php 
  // --------------------------------------------------------------
  // IF PREMIUM MEMBERSHIP IS ENABLED IN CONFIG FILE
  // --------------------------------------------------------------
  if(ENABLE_PREMIUM_MEMBERSHIP == 1){ ?>
  <div id="accordionWrap" class="accordionWrap">
    <div id="accordion">
      <h3><span class="ac_premiumIcon"></span><a href="#">Payment History</a></h3>
      <div>
      <?php require_once(ROOT_PATH.'user/modules/accordion/payment_history.html.php'); ?>
      </div>
    </div>
  </div>
  <?php 
  }
  else
  {
    // if premium membership is not enabled in web.config
    require_once(ROOT_PATH.'user/modules/accordion/error_messages.php');
    echo $premium_not_enabled;
  }
  ?>
<?php 
}
else
{
  // if profiles are not enabled in web.config
  require_once(ROOT_PATH.'user/modules/accordion/error_messages.php');
  echo $profiles_not_enabled;
} 
?>