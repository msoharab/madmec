<?php

define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
//$doc_path = $_SERVER['DOCUMENT_ROOT'] . "/";
//define("DOC_ROOT", $doc_path);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
);

function main($parameters) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
        switch ($parameters['action']) {

            case "messages" :
                echo json_encode(messages());
                break;
        }
    }
}

function messages() {
    $name = isset($_POST['name']) ? $_POST['name'] : false;
    $email = isset($_POST['email']) ? $_POST['email'] : false;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : false;
    $subject = isset($_POST['subject']) ? $_POST['subject'] : false;
    $message = isset($_POST['message']) ? $_POST['message'] : false;
    $flag = true;
    $q = "INSERT INTO contact(name,email,phone,subject,message)VALUES('" . ($name) . "','" . ($email) . "','" . ($phone) . "','" . ($subject) . "','" . ($message) . "')";
    return executeQuery($q);
}

function uploadFileToServer($fileparam) {
    $errors = array();
    $verImages = array(
        "error" => NULL,
        "status" => "error",
    );
    $file = '';
    $path1 = '';
    $relativepath = '';
    $absolutepath = '';

    $target = $fileparam["target"];
    $directory = $fileparam["directory"];
    $pic_id = (integer) $fileparam["picid"];
    $file_name = $fileparam['file_name'];
    $file_size = $fileparam['file_size'];
    $file_tmp = $fileparam['file_tmp'];
    $file_type = $fileparam['file_type'];

    $file_ext = explode('.', $fileparam['file_name']);
    $file_ext = $file_ext[count($file_ext) - 1];
    $file_ext = strtolower($file_ext);

    $extensions = array("jpeg", "jpg", "jpe", "gif", "wbmp", "xbm", "png");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 20971520) {
        $errors[] = 'File size must be less than or equal to 2 MB';
    }

    if (empty($errors) == true) {
        $path1 = DOC_ROOT . $directory . '/' . $target;
        $relativepath = $directory . '/' . $target;
        $file = 'ori_pic' . time() . '.' . $file_ext;
        $absolutepath = $path1 . '/' . $file;

        if (move_uploaded_file($file_tmp, $absolutepath)) {
            $temp = ProcessImg($path1, $file);
            if (is_array($temp) && count($temp) > 0) {
                foreach ($temp as &$value) {
                    $value = $relativepath . '/' . $value;
                }
                $temp["original_pic"] = $relativepath . '/' . $file;
                if (updatePortalPhotoDetails($temp, $pic_id)) {
                    $verImages["status"] = "success";
                }
            }
        }
    }
    $verImages["error"] = (array) $errors;
    return $verImages;
}

function updatePortalPhotoDetails($photo = false, $picid = 0) {
    $res3 = false;
    if (is_array($photo) && $picid > 0) {
        if (count($photo) > 0) {
            $query3 = 'UPDATE photo SET original_pic = "' . ($photo['original_pic']) . '",
                        ver1 = "' . ($photo[0]) . '",
                        ver2 = "' . ($photo[1]) . '",
                        ver3 = "' . ($photo[2]) . '",
                        ver4 = "' . ($photo[3]) . '",
                        ver5 = "' . ($photo[4]) . '",
                    WHERE id = "' . ($picid) . '"';
            executeQuery($query3);
        }
    }
    return $res3;
}

function ProcessImg($path, $file) {
    $imageproperties = getimagesize($path . "/" . $file);
    $srcW = $imageproperties[0];
    $srcH = $imageproperties[1];
    $imgtype = $imageproperties[2];
    if ($srcW <= 650)
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.65, 0.55, 0.45, 0.35, 0.25);
    else if ($srcW >= 651 && $srcW <= 1250)
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.55, 0.45, 0.35, 0.25, 0.15);
    else if ($srcW >= 1251 && $srcW <= 1800)
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.45, 0.35, 0.25, 0.15, 0.075);
    else if ($srcW >= 1801 && $srcW <= 2200)
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.35, 0.25, 0.15, 0.075, 0.0375);
    else
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.35, 0.25, 0.15, 0.075, 0.0375);
}

function createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, $ratio1, $ratio2, $ratio3, $ratio4, $ratio5) {
    $versions[0] = floor($srcW * $ratio1) . "_" . floor($srcH * $ratio1);
    $versions[1] = floor($srcW * $ratio2) . "_" . floor($srcH * $ratio2);
    $versions[2] = floor($srcW * $ratio3) . "_" . floor($srcH * $ratio3);
    $versions[3] = floor($srcW * $ratio4) . "_" . floor($srcH * $ratio4);
    $versions[4] = floor($srcW * $ratio5) . "_" . floor($srcH * $ratio5);
    $verimages = array();
    for ($i = 0, $j = 1; $i < sizeof($versions); $i++, $j++) {
        $temp = explode("_", $versions[$i]);
        $desW = $temp[0];
        $desH = $temp[1];
        $image_p = imagecreatetruecolor($desW, $desH);
        $image = createImage($imgtype, $path, $file);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $desW, $desH, $srcW, $srcH);
        $temp = explode(".", $file);
        $extension = strtolower($temp[1]);
        $name = $temp[0] . "_ver" . $j . "_." . $extension;
        outputImageToBrowser($image_p, $path, $name, $extension);
        array_push($verimages, $name);
    }
    imagedestroy($image_p);
    return $verimages;
}

function createImage($imageprop, $path, $file) {
    switch ($imageprop) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($path . "/" . $file);
        case IMAGETYPE_JPEG2000:
            return imagecreatefromjpeg($path . "/" . $file);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($path . "/" . $file);
        case IMAGETYPE_PNG:
            $imgPng = imagecreatefrompng($path . "/" . $file);
            $imgPng = imagetranstowhite($imgPng);
            return $imgPng;
        case IMAGETYPE_WBMP:
            return imagecreatefromwbmp($path . "/" . $file);
        case IMAGETYPE_XBM:
            return imagecreatefromxbm($path . "/" . $file);
        default:
            return false;
    }
}

function outputImageToBrowser($image_p, $path, $name, $extension) {
    if ($extension == "jpg" || $extension == "JPG")
        imagejpeg($image_p, $path . "/" . $name);
    if ($extension == "jpe" || $extension == "JPE")
        imagejpeg($image_p, $path . "/" . $name);
    if ($extension == "jpeg" || $extension == "JPEG")
        imagejpeg($image_p, $path . "/" . $name);
    if ($extension == "png" || $extension == "PNG")
        imagepng($image_p, $path . "/" . $name);
    if ($extension == "gif" || $extension == "GIF")
        imagegif($image_p, $path . "/" . $name);
    if ($extension == "wbmp" || $extension == "WBMP")
        imagewbmp($image_p, $path . "/" . $name);
    if ($extension == "xbm" || $extension == "XBM")
        imagexbm($image_p, $path . "/" . $name);
}

function imagetranstowhite($trans) {
// Create a new true color image with the same size
    $w = imagesx($trans);
    $h = imagesy($trans);
    $white = imagecreatetruecolor($w, $h);
// Fill the new image with white background
    $bg = imagecolorallocate($white, 255, 255, 255);
    imagefill($white, 0, 0, $bg);
// Copy original transparent image onto the new image
    imagecopy($white, $trans, 0, 0, 0, 0, $w, $h);
    return $white;
}

if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') {
    main($parameters);
    unset($_POST);
    exit(0);
}
?>