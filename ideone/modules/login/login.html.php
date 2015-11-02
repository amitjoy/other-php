<?php require_once(ROOT_PATH.'modules/login/captcha_toggle.php'); ?>
<div class="frmLogin" id="frmLogin">
  <div class="inner">
    <form method="post" action="" name="frmLogin" >
      <h2>Login</h2>
      <ul>
        <?php echo $txbEmptyUn ?>
        <?php echo $txbEmptyPw ?>
        <?php echo $txbInvalidCaptcha ?>
        <?php echo $accountNotFound ?>
      </ul>
      <label for="txbUn">USER NAME: *</label>
      <input id="txbUn" name="txbUn" type="text" maxlength="20" value="<?php echo $username ?>" class="txbUn" />
      <label for="txbPw">PASSWORD: *</label>
      <input id="txbPw" name="txbPw" type="password" maxlength="50" class="txbPw"/>
      <?php
    	if(LOGIN_CAPTCHA_ON == 1 || LOGIN_CAPTCHA_ON == 0 && $count >= $captcha_on_x)
    	{
    		require_once(ROOT_PATH.'lib/recaptchalib.php');
    		$publickey = RECAPTCHA_PUBLIC_KEY;
    		echo recaptcha_get_html($publickey);
    	}
      ?>
      <input name="cbxRememberMe" type="checkbox" value="1" id="cbxRememberMe"/>
      <label for="cbxRememberMe" id="label" title="Auto-Login will remember you and automatically log you in next time.">Turn On Auto-Login</label>
      <br/>
      <input id="btnSubmit" name="btnSubmit" type="submit" value="Log In" />
      <!-- nav links to other modules -->
      <a id="show_nav" href="#">Click for more...</a> 
      <p id="nav"> 
      <a href="#" class="current">Login</a> 
      <a href="<?php SITE_URL ?>register.php">Not registered yet?</a>  
      <a href="<?php SITE_URL ?>recover.php">Lost Password?</a> <br/> 
      <a href="<?php SITE_URL ?>recover-un.php">Lost User Name?</a>  
      <a href="<?php SITE_URL ?>lost-activation.php">Lost Activation?</a> 
      </p>
    </form>
  </div>
</div>
<div class="bottomShadow"></div>