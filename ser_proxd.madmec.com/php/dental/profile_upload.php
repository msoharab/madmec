<?php
    require_once("config.php");
    require_once(CONFIG_ROOT.MODULE_1);
    require_once(CONFIG_ROOT.MODULE_2);
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        $file_name =  base64_encode(date('Y-m-d-H-i-s-u')).$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], DOC_ROOT.PROFILE_IMAGE.$file_name);//DOC_ROOT.PROFILE_IMAGE
        $_SESSION['profile_img_details']['img_url'] = URL.PROFILE_IMAGE.$file_name;
        $_SESSION['profile_img_details']['thumb_url'] = URL.PROFILE_IMAGE.$file_name;//saving thumb for temperory use will upgrade it later
    }
?>
