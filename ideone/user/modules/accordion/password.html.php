<?php require_once(ROOT_PATH.'user/modules/accordion/password.php'); ?>
<div class="profileWrap">
  <form name="frmPassword" method="post" action="" class="htmlForm">
    <div class="infoBanner2">
      <p>REQUIREMENTS: <?php echo 'min. length: '.MIN_PASSWORD_LENGTH.' numeric: '.REQUIRE_NUMBER.' special char: '.REQUIRE_SPECIAL_CHAR ?></p>
    </div>
    <!-- error msgs -->
    <ul>
    <?php echo $msg; ?>
    </ul>
    <p title="Enter your current password."><label for="currentPassword">Current Password:</label><input name="currentPassword" type="password" id="currentPassword" maxlength="20" ></p>
    <p title="Enter the new password you would like to replace your current password with."><label for="newPassword0">New Password:</label><input name="newPassword0" type="password" id="newPassword0" maxlength="20" ></p>
    <p title="Retype the new password."><label for="newPassword1">Retype New Password:</label><input name="newPassword1" type="password" id="newPassword1" maxlength="20" ></p>
    <div class="infoBanner2">
      <p>INFO: To change your Account Password, you must provide your current Security Question and Answer.</p>
    </div>
    <p title="Enter your current security question."><label for="pw_PasswordQ">Security Question?</label><input name="pw_PasswordQ" type="text" id="pw_PasswordQ" maxlength="100" ></p>
    <p title="Enter your current security answer."><label for="pw_PasswordA">Security Answer?</label><input name="pw_PasswordA" type="text" id="pw_PasswordA" maxlength="100" ></p>
    <p title="Check this checkbox if you would like to receive a confirmation email. New password NOT included!"><input type="checkbox" name="email_credentials" id="email_credentials" class="checkbox" /><label for="email_credentials">E-mail Confirmation?</label></p>
    <p title="Check this checkbox if you would like to include the new password with the confirmation e-mail. If you select this option, please make sure you delete the e-mail after printing and keeping it in a safe place."><input type="checkbox" name="include_pw" id="include_pw" class="checkbox" /><label for="include_pw">Include New Password?</label></p>
    <div class="clearLeft"></div>
    <input name="btnUpdatePw" type="submit" value="Save Changes" class="gvbtn btn" onclick="return confirm('SAVE New PASSWORD?');"/>
  </form>
</div>