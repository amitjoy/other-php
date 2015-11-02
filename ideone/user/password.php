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

<!-- password page - single -->
<?php require_once(ROOT_PATH.'user/modules/password/password.html.php'); ?>

<!-- footer -->
<?php require_once(ROOT_PATH.'user/themes/footer.control.php'); ?>

</body>
</html>