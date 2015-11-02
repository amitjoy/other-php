<?php require_once(ROOT_PATH.'user/modules/accordion/avatar.php'); ?>
<div class="profileWrap">
  <form name="frmAvatar" method="post" action="" enctype="multipart/form-data" class="htmlForm">
    <div class="infoBanner2">
      <p>REQUIREMENTS:  File Size: <?php echo AVATAR_FILE_SIZE / 1024 ?> kb max. File Type: gif, jpg, png</p>
    </div>
    <!-- error msgs -->
    <ul>
    <?php echo $msg; ?>
    </ul>
    <p><input name="selectFile" type="image" src="<?php echo $f_avatar_image; ?>" class="img"></p>
    <p><label for="fileUpload">Avatar Image:</label><input name="fileUpload" type="file" id="fileUpload" maxlength="255" ></p>
    <input name="btnUploadAvatar" type="submit" value="Upload" class="gvbtn btn" onclick="return confirm('Are You READY to UPLOAD?');"/>
  </form>
</div>