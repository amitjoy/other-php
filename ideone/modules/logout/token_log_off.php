<?php
//------------------------------------------------------------
// THIS FILE IS USED TO DELETE AUTO LOGIN COOKIES
//------------------------------------------------------------
setcookie('user', null, time() - 3600);
setcookie('pass', null, time() - 3600);
header('Location:'.SITE_URL.'login.php?TokenLogOff=0');
?>