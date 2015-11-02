<!-- css for feedback button -->
<link rel="stylesheet" type="text/css" href="<?php echo FEEDBACK_STYLE; ?>"/>
<!-- jquery library for feedback modal dialogue -->
<?php require_once(ROOT_PATH.'js/jquery/jquery.php'); ?>
<!-- jquery modal js feedback modal dialogue -->
<script type="text/javascript" src="<?php echo SITE_URL.'js/jquery/modal.js' ?>"></script>
<!-- feedback modal settings -->
<script type="text/javascript">
var md_animation = true;
$(document).ready(function(){
	$("a.modal").click(function(){
	var x = this.title || $(this).text() || this.href;
	md_show(x,this.href,450,665);
	return false;
	});
});
</script>