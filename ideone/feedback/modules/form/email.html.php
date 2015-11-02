<?php require_once(ROOT_PATH.'feedback/modules/form/email.php'); ?>

<div class="email_form">
  <div class="captcha"> Please enter your text below. E-mail address is NOT required but helpful if you want us to get back with you. </div>
  <label for="issue">Issue:* <span class="small_text">(max <?php echo MAX_FEEDBACK_LENGTH; ?> char.)</span></label>
  <textarea name="issue" id="issue"></textarea>
  <label for="email">Email: (optional) </label>
  <input name="email" type="text" id="email" maxlength="100">
  <?php
  if(FEEDBACK_CAPTCHA_ON == 1)
  {
	  require_once(ROOT_PATH.'lib/recaptchalib.php');
	  $publickey = RECAPTCHA_PUBLIC_KEY;
	  echo recaptcha_get_html($publickey);
  }
  ?>
  <input name="btnSubmit" type="submit" value="Send" class="btn" onclick="return confirm('Are You READY to SUBMIT?');" />
  <input name="btnCancel" type="reset" value="Reset" class="btn" />
</div>
