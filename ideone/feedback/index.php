<?php 
//------------------------------------------------------------
// NOTE: This is the modal dialogue page for the site feedback.
// When the feedback button is clicked, this page pops up
// in the jquery modal dialogue.
//------------------------------------------------------------
//------------------------------------------------------------
// REQUIRED WHEN CONFIG SETTINGS ARE USED
//------------------------------------------------------------
require_once('../web.config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Feedback Form</title>

<!-- stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php echo FEEDBACK_STYLE; ?>"/>

<!-- shared js -->
<?php require_once(ROOT_PATH.'feedback/themes/shared.js.php'); ?>
</head>
<body>

<!-- feedback form -->
<?php require_once(ROOT_PATH.'feedback/modules/form/feedback.html.php'); ?>

</body>
</html>