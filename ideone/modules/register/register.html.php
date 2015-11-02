<?php require_once(ROOT_PATH.'modules/register/captcha_toggle.php'); ?>
<div class="frmRegister" id="frmRegister">
  <div class="inner">
    <form method="post" action="" name="frm_Register" >
      <h2>New account</h2>
      <ul>
        <?php echo $txbEmptyUn ?>
        <?php echo $txbEmptyPw ?>
        <?php echo $txbEmptyConfirmPw ?>
        <?php echo $passwordMismatch ?>
        <?php echo $passwordTooShort ?>
        <?php echo $passwordNumber ?>
        <?php echo $passwordChar ?>
        <?php echo $userExist ?>
        <?php echo $userInPw ?>
        <?php echo $emailNotValid ?>
        <?php echo $txbEmptyEmail ?>
        <?php echo $txbEmptyQuestion ?>
        <?php echo $txbEmptyAnswer ?>
        <?php echo $txbInvalidCaptcha ?>
        <?php echo $txbUserNameCheck ?>
      </ul>
      <label for="txbUn">USER NAME: *</label>
      <input id="txbUn" name="txbUn" type="text" maxlength="20" value="<?php echo $username ?>" class="txbUn" />
      <input id="btnCheck" name="btnCheckUn" type="submit" value="check" />
      <label for="txbPw">PASSWORD: *</label> 
      <label id="subtext">(min. <?php echo MIN_PASSWORD_LENGTH ?> chrs. <?php echo REQUIRE_NUMBER ?> digit, <?php echo REQUIRE_SPECIAL_CHAR ?> unique chr.)</label>
      <input id="txbPw" name="txbPw" type="password" maxlength="50" class="password" />
      <label for="txbConfirmPw">CONFIRM PASSWORD: *</label>
      <input id="txbConfirmPw" name="txbConfirmPw" type="password" maxlength="50" class="txbConfirmPw" />
      <label for="txbEmail">E-MAIL: *</label>
      <input id="txbEmail" name="txbEmail" type="text" maxlength="50" value="<?php echo $email ?>" class="txbEmail" />
      <label for="txbQuestion">SECURITY QUESTION: *</label>
      <input id="txbQuestion" name="txbQuestion" type="text" maxlength="50" value="<?php echo $question ?>" class="txbQuestion" />
      <label for="txbAnswer">SECURITY ANSWER: *</label>
      <input id="txbAnswer" name="txbAnswer" type="text" maxlength="50" value="<?php echo $answer ?>" class="txbAnswer" />
      <?php
    	if(REGISTER_CAPTCHA_ON == 1)
    	{
    		require_once(ROOT_PATH.'lib/recaptchalib.php');
    		$publickey = RECAPTCHA_PUBLIC_KEY;
    		echo recaptcha_get_html($publickey);
    	}
      ?>
      <input id="btnSubmit" name="btnSubmit" type="submit" value="Register" />
      <a id="show_nav" href="#" class="current">Click for more...</a> 
      <p id="nav"> 
      <a href="<?php SITE_URL ?>login.php">Login</a> 
      <a href="#" class="current">Not registered yet?</a>  
      <a href="<?php SITE_URL ?>recover.php">Lost Password?</a> <br/> 
      <a href="<?php SITE_URL ?>recover-un.php">Lost User Name?</a>  
      <a href="<?php SITE_URL ?>lost-activation.php">Lost Activation?</a> 
      </p>
    </form>
  </div>
</div>
<div class="bottomShadow"></div>