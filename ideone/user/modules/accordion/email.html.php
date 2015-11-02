<?php require_once(ROOT_PATH.'user/modules/accordion/email.php'); ?>
<div class="profileWrap">
  <form name="frmEmail" method="post" action="" class="htmlForm">
    <div class="infoBanner2">
      <p>INFO: Here you can change your account email.</p>
    </div>
    <!-- error msgs -->
	<ul>
    <?php echo $msg; ?>
    </ul>
    <p title="Enter the new e-mail address that you would like to replace your current one."><label for="EmailAddress">New Email Address:</label><input name="EmailAddress" type="text" id="EmailAddress" maxlength="100" ></p>
    <div class="infoBanner2">
      <p>INFO: To change your Account E-mail, you must provide your current Security Question and Answer.</p>
    </div>
    <p title="Enter your current security question."><label for="em_PasswordQ">Security Question?</label><input name="em_PasswordQ" type="text" id="em_PasswordQ" maxlength="100" ></p>
    <p title="Enter your current security answer."><label for="em_PasswordA">Security Answer?</label><input name="em_PasswordA" type="text" id="em_PasswordA" maxlength="100" ></p>
    <p title="Check this checkbox if you would like to receive a confirmation e-mail. New e-mail is NOT included!"><input type="checkbox" name="email_email" id="email_email" class="checkbox" /><label for="email_email">E-mail Confirmation?</label></p>
    <p title="Check this checkbox if you would like to include the new e-mail address with your confirmation e-mail. If you select this option, please make sure you delete the e-mail after printing it and keeping it in a safe place."><input type="checkbox" name="include_email" id="include_email" class="checkbox" /><label for="include_email">Include New Email?</label></p>
    <div class="clearLeft"></div>     
    <input name="btnUpdateEmail" type="submit" value="Save Changes" class="gvbtn btn" onclick="return confirm('SAVE New Email Address?');"/>
  </form>
</div>