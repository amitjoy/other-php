<?php 
//------------------------------------------------------------
// RESTRICT ACCESS TO PAGE
//------------------------------------------------------------
require_once('../web.config.php'); require_once(ROOT_PATH.'global.php');
$auth_roles = array('owner','superadmin','administrator','member','user');// << add roles here
require_once(ROOT_PATH.'modules/authorization/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>My Account Details</title>

<!-- stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php echo USER_STYLE; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo USER_MENU_STYLE; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo ACCORDION_STYLE; ?>"/>
<script language="Javascript" type="text/javascript" src="../edit_area/edit_area_full.js"></script>
	<link rel="stylesheet" href="../lib_main/amit_button.css">
	<script language="Javascript" type="text/javascript">
		// initialisation
		editAreaLoader.init({
			id: "code"	// id of the textarea to transform		
			,start_highlight: true	// if start with highlight
			,allow_resize: "both"
			,allow_toggle: true
			,word_wrap: true
			,language: "en"
			,syntax: "php"	
		});
	</script>

<!-- favicons -->
<link rel="shortcut icon" href="../images/favicon.gif"/>
<link rel="shortcut icon" href="../images/favicon.ico"/>

<!-- shared js -->
<?php require_once(ROOT_PATH.'user/themes/shared.js.php'); ?>
</head>
<body>

<!-- jquery wrap -->
<div id="Header">
	<!-- header -->
	<?php require_once(ROOT_PATH.'user/themes/header.control.php'); ?>
</div>

<!-- jquery wrap -->
<div id="Menu">
	<!-- menu -->
	<?php require_once(ROOT_PATH.'user/modules/menu/menu.html.php'); ?>
</div>

<!-- newsletter page - single -->
<?php require_once(ROOT_PATH.'user/modules/compiler/compiler.html.php'); ?>

<!-- footer -->
<?php require_once(ROOT_PATH.'user/themes/footer.control.php'); ?>

</body>
</html>