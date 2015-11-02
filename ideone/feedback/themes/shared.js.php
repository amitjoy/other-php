<!-- JQUERY LIBRARY -->
<?php require_once(ROOT_PATH.'js/jquery/jquery.php'); ?>
<!-- RATING JS -->
<script type="text/javascript" src="<?php echo SITE_URL.'js/jquery/rating.js' ?>"></script>
<!-- RECAPTCHA THEME -->
<script type="text/javascript" src="<?php echo SITE_URL.'js/recaptcha/theme.js' ?>"></script>
<!-- COOKIE PLUGIN -->
<script type="text/javascript" src="<?php echo SITE_URL.'js/jquery/jquery.cookie.js' ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
 	// MODAL - RIGHT COLUMN ANIMATION
	$('#control_box').slideUp(0).delay(100).fadeIn('slow');

	// HIGHLIGHT SELECTED CATEGORY
	var feedback_cat = $.cookie('feedback_cat_id');
	if (feedback_cat != '') {
		$('#' + feedback_cat).addClass('selected');
	}
});
</script>