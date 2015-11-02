<?php require_once(ROOT_PATH.'user/modules/accordion/newsletter.php'); ?>
<div class="profileWrap">
  <form name="frmNewsletter" method="post" action="" class="htmlForm">
    <div class="infoBanner2">
      <p>Question: Would you like to subscribe to our newsletter and promotional offers?</p>
    </div>
    <!-- error msgs -->
	<ul>
    <?php echo $msg; ?>
    </ul>
    <p>
      <label>Newsletter:</label>
      <label class="radioLabel">Yes<input type="radio" class="radioButton" name="newsletter" value="1" id="newsletter_0" <?php echo $newsletter_1; ?> /></label>
      <label class="radioLabel">No<input type="radio" class="radioButton" name="newsletter" value="0" id="newsletter_1" <?php echo $newsletter_0; ?> /></label>
    </p>
    <br/>
    <p>
      <label>Promotional Offers:</label>
      <label class="radioLabel">Yes<input type="radio" class="radioButton" name="promotion" value="1" id="promotion_0" <?php echo $promotion_1; ?> /></label>
      <label class="radioLabel">No<input type="radio" class="radioButton" name="promotion" value="0" id="promotion_1" <?php echo $promotion_0; ?> /></label>
    </p>
    <div class="clearLeft"></div>
    <input name="btnUpdateNewsletter" type="submit" value="Save Changes" class="gvbtn btn" onclick="return confirm('SAVE Changes?');"/>
  </form>
</div>