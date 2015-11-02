<?php require_once(ROOT_PATH.'feedback/modules/form/feedback.php'); ?>
<div class="f_form">
  <form name="frmFeedback" method="post" action="" class="htmlForm">
    <div class="header">
      <input name="selectFile" type="image" src="<?php echo $company_logo; ?>" class="img">
      <span class="title"><?php echo $page_title;?></span> 
    </div>
    <div class="subHeader"> 
      <span class="ratings_title">How would you rate this site?</span> 
      <!-- include rating stars -->
      <?php require_once(ROOT_PATH.'feedback/modules/rating/rating.html.php'); ?>
      <div class="clearBoth"></div>
    </div>
    <div class="header_shadow"></div>
    <div class="f_body">
      <!-- left categories -->
      <div class="navigation_wrap"> 
        <span class="topic_title">1. Select feedback topic:</span> <?php echo '<ul>'.$category.'</ul>'; ?> 
      </div>
      <!-- right subcategories -->
      <div id="control_box" class="subcat_wrap" style="display:none"> 
        <span class="topic_title"><?php echo $subcat_title; ?></span>
        <?php if($show_email_form == 1){require_once(ROOT_PATH.'feedback/modules/form/email.html.php');}else{echo '<ul>'.$subcategory.'</ul>';} ?>
      </div>
      <div class="clearBoth"></div>
    </div>
  </form>
</div>
