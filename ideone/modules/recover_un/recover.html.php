<?php require_once('recaptcha.php'); ?>
<div class="frmRecover" id="frmRecoverUn">
  <div class="inner">
    <form method="post" action="" name="frmRecover" >
      <h2>Lost user name</h2>
      <ul>
        <?php echo $txbEmptyEmail ?>
        <?php echo $txbEmptyAnswer ?>
        <?php echo $txbInvalidCaptcha ?>
        <?php echo $accountNotFound ?>
        <?php echo $incorrectAnswer ?>
        <?php echo $thankyou ?>
      </ul>
      <label for="txbEmail">E-MAIL: *</label>
      <input id="txbEmail" name="txbEmail" type="text" maxlength="20" value="<?php echo $txbEmail ?>" class="txbEmail"/>
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
      <a href="<?php SITE_URL ?>recover.php">Lost Password?</a> <br/> 
      <a href="#" class="current">Lost User Name?</a>  
      <a href="<?php SITE_URL ?>lost-activation.php">Lost Activation?</a> 
      </p>
    </form>
  </div>
</div>
<div class="bottomShadow"></div>