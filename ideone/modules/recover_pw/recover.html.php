<?php require_once('recaptcha.php'); ?>
<div class="frmRecover" id="frmRecover">
  <div class="inner">
    <form method="post" action="" name="frmRecover" >
      <h2>Password reset</h2>
      <ul>
        <?php echo $txbEmptyUn ?>
        <?php echo $txbEmptyAnswer ?>
        <?php echo $txbInvalidCaptcha ?>
        <?php echo $accountNotFound ?>
        <?php echo $incorrectAnswer ?>
        <?php echo $thankyou ?>
      </ul>
      <label for="txbUn">USER NAME: *</label>
      <input id="txbUn" name="txbUn" type="text" maxlength="20" value="<?php echo $txbUsername ?>" class="txbUn" />
      <?php if($showfields == 1): ?>
      <label for="txbQuestion">SECURITY QUESTION:</label>
      <input id="txbQuestion" name="txbQuestion" type="text" maxlength="50" readonly="readonly" value="<?php echo $txbQuestion ?>" class="txbQuestion" />
      <label for="txbAnswer">SECURITY ANSWER? *</label>
      <input id="txbAnswer" name="txbAnswer" type="text" maxlength="50" class="txbAnswer" />
      <?php endif; ?>
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
      <a href="#" class="current">Lost Password?</a> <br/> 
      <a href="<?php SITE_URL ?>recover-un.php">Lost User Name?</a>  
      <a href="<?php SITE_URL ?>lost-activation.php">Lost Activation?</a> 
      </p>
    </form>
  </div>
</div>
<div class="bottomShadow"></div>