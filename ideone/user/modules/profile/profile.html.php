<?php 
// --------------------------------------------------------------
// IF PROFILES ARE ENABLED IN CONFIG FILE
// --------------------------------------------------------------
if(ENABLE_USER_PROFILES == 1){ 
?>
<?php require_once(ROOT_PATH.'user/modules/accordion/banner.html.php'); ?>
<meta charset="utf-8">
<div id="accordionWrap" class="accordionWrap">
  <div id="accordion">
    <h3><span class="ac_profileIcon"></span><a href="#">Profile Details</a></h3>
    <div>
    <?php 
    // get required includes
    require_once(ROOT_PATH.'user/modules/accordion/error_messages.php');
    require_once(ROOT_PATH.'user/modules/accordion/profiles.html.php'); 
    ?>
    </div>
  </div>
</div>
<?php 
}
else
{
	// if profiles are not enabled in web.config
	require_once(ROOT_PATH.'user/modules/accordion/error_messages.php');
	echo $profiles_not_enabled;
} 
?>