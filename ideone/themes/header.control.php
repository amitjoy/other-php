<?php 
// get includes
require_once(ROOT_PATH.'themes/ie-detect.php');
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'user/modules/accordion/get_user_name.php');
?>
<div class="header"> 
  <a href="index.php" title="Online Compiler Portal"><div class="logo"></div></a>
  <form id='frmLogout' name='frmLogout' method='post' action='' class='frmLogout'>
    <?php require_once(ROOT_PATH.'themes/logout.php'); ?>
    <?php if(!isset($user_name)){ ?>
      <span class="link"><a href="login.php" title="Click here to login..." class="btnLogin">Login</a></span> 
    <?php } ?>
    <span class="link"><a href="index.php" title="Home page ...">Home</a></span>
    <span class="link"><a href="user/index.php" title="Manage your account..."><?php if(!empty($_SESSION['UserName'])){echo 'Welcome! '.$_SESSION['UserName'];}elseif(!empty($_COOKIE['user'])){echo 'Welcome Back! '.$_COOKIE['user'];}else{echo 'My Account';} ?></a></span> 
  </form>
</div>
<div class="subHeader">Online Coding Panel and Management for Users</div>
<div class="header_shadow"></div>
<?php if(SCHEDULED_MAINTENANCE == 1){header('Location:'.UNDER_CONSTRUCTION_PAGE);} ?>