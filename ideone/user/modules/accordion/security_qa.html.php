<?php require_once(ROOT_PATH.'user/modules/accordion/security_qa.php'); ?>
<div class="profileWrap">
  <form name="frmPasswordQA" method="post" action="" class="htmlForm">
    <div class="infoBanner2">
      <p>INFO: If you ever loose or forget your password, you will need these to retrieve it. You will also need it to reset your password, e-mail and Q and A.</p>
    </div>
    <!-- error msgs -->
	<ul>
    <?php echo $msg; ?>
    </ul>
    <p title="Enter the new security question that you would like to replace the current one."><label for="PasswordQ">New Question:</label><input name="PasswordQ" type="text" id="PasswordQ" maxlength="100" ></p>
    <p title="Enter the new security answer that you would like to replace the current one."><label for="PasswordA">New Answer:</label><input name="PasswordA" type="text" id="PasswordA" maxlength="100" ></p>
    <div class="infoBanner2">
      <p>INFO: To change your Security Q and A, you must provide your current Security Question and Answer.</p>
    </div>
    <p title="Enter your current security question."><label for="qa_PasswordQ">Current Question?</label><input name="qa_PasswordQ" type="text" id="qa_PasswordQ" maxlength="100" ></p>
    <p title="Enter your current security answer."><label for="qa_PasswordA">Current Answer?</label><input name="qa_PasswordA" type="text" id="qa_PasswordA" maxlength="100" ></p>
	<p title="Check this checkbox if you would like to receive a confirmation e-mail. The new Q and A NOT included!"><input type="checkbox" name="email_qa" id="email_qa" class="checkbox" /><label for="email_qa">E-mail Confirmation?</label></p>
    <p title="Check this checkbox if you would like to include your new Q and A with the confirmation e-mail. If you select this option, please make sure you delete the e-mail after printing it and keeping it in a safe place."><input type="checkbox" name="include_qa" id="include_qa" class="checkbox" /><label for="include_qa">Include New Q and A?</label></p>
    <div class="clearLeft"></div>    
    <input name="btnUpdatePwQa" type="submit" value="Save Changes" class="gvbtn btn" onclick="return confirm('SAVE New Password QUESTION and ANSWER?');"/>
  </form>
</div>