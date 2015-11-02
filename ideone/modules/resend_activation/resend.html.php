<?php require_once(ROOT_PATH.'modules/resend_activation/recaptcha.php'); ?>
<div class="frmResend" id="frmResend">
  <div class="inner">
    <form method="post" action="" name="frmResend" >
      <h2>Resend activation</h2>
      <ul>
        <?php echo $txbEmptyUn ?>
  	  <?php echo $txbInvalidCaptcha ?>
        <?php echo $accountNotFound ?>
        <?php echo $thankyou ?>
      </ul>
      <label for="txbUn">ENTER USER NAME: *</label>
      <input id="txbUn" name="txbUn" type="text" maxlength="20" value="<?php echo $txbUsername ?>" class="txbUn" />
      <?php
  		require_once(ROOT_PATH.'lib/recaptchalib.php');
  		$publickey = RECAPTCHA_PUBLIC_KEY;
  		echo recaptcha_get_html($publickey);
      ?>
      <br/>
      <input id="btnSubmit" name="btnSubmit" type="submit" value="Submit" />
      <a id="show_nav" href="#" class="current">Click for more...</a> 
      <p id="nav"> 
      <a href="<?php SITE_URL ?>login.php">Login</a> 
      <a href="<?php SITE_URL ?>register.php">Not registered yet?</a>  
      <a href="<?php SITE_URL ?>recover.php">Lost Password?</a> <br/> 
      <a href="<?php SITE_URL ?>recover-un.php">Lost User Name?</a>  
      <a href="#" class="current">Lost Activation?</a> 
      </p>
    </form>
  </div>
</div>
<div class="bottomShadow"></div>