<?php
class Picture extends BaseController {
    private $para, $logindata, $UserId;
    private $PictureMod, $absolutepath, $relativepath;
    private $extensions, $errors;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->extensions = array("jpeg", "jpg", "jpe", "gif", "wbmp", "xbm", "png");
        $this->errors = array();
        $this->PictureMod = new Picture_Model();
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
    }
    public function UploadPic($target = false) {
        //header('Content-type: image/jpeg');
        $file_name = array();
        $file_size = array();
        $file_tmp = array();
        $file_type = array();
        $file_ext = array();
        $chdir = '';
        $path1 = '';
        $file = '';
        $_SESSION['IMG_RESPONSE'] = array();
        if (isset($this->postFile) && count($this->postFile) > 0) {
            if (isset($this->postFile['photo']['name'])) {
                $file_name[] = $this->postFile['photo']['name'];
                $file_size[] = $this->postFile['photo']['size'];
                $file_tmp[] = $this->postFile['photo']['tmp_name'];
                $file_type[] = $this->postFile['photo']['type'];
                $temp = explode('.', $this->postFile['photo']['name']);
                $temp = $temp[count($temp) - 1];
                $file_ext[] = strtolower($temp);
                if($target === "user"){
                    $chdir = $this->PictureMod->getDirectory($this->jsonData["id"], "team_members","id");
                }
                else{
                    $chdir = $this->PictureMod->getDirectory($this->jsonData["id"], "product","id");
                }
            }
            for ($i = 0; $i < count($file_name) && (int) $this->jsonData["id"] > 0; $i++) {
                if (in_array($file_ext[$i], $this->extensions) === false) {
                    $this->errors[$i][] = "Extension not allowed, please choose a JPEG or PNG file.";
                }
                if ($file_size[$i] > $this->config["MAX_IMG_SIZE"]) {
                    $this->errors[$i][] = 'File size must be less than 5 MB';
                }
                if (empty($this->errors[$i]) == true && (int) $this->jsonData["id"] > 0) {
                    $path1 = $this->config["DOC_ROOT"] . $chdir . '/profile';
                    $this->relativepath = $chdir . '/profile';
                    $file = $this->jsonData["id"] . '_original_pic' . time() . '.' . $file_ext[$i];
                    $this->absolutepath = $path1 . '/' . $file;
                    if (move_uploaded_file($file_tmp[$i], $this->absolutepath)) {
                        array_push($_SESSION["IMG_RESPONSE"], array(
                            "error" => NULL,
                            "status" => "success",
                            "pic" => $this->relativepath . '/' . $file,
                            "ver1" => '',
                            "ver2" => '',
                            "ver3" => '',
                            "ver4" => '',
                            "ver5" => ''
                        ));
                        $this->Process($path1, $file);
                    }
                } else {
                    array_push($_SESSION["IMG_RESPONSE"], array(
                        "error" => (array) $this->errors[$i],
                        "status" => "error",
                        "pic" => NULL,
                        "ver1" => '',
                        "ver2" => '',
                        "ver3" => '',
                        "ver4" => '',
                        "ver5" => ''
                    ));
                }
            }
        }
    }
    public function Process($path, $file) {
        $imageproperties = getimagesize($path . "/" . $file);
        $srcW = $imageproperties[0];
        $srcH = $imageproperties[1];
        $imgtype = $imageproperties[2];
        if ($srcW <= 650)
            $this->createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.65, 0.55, 0.45, 0.35, 0.25);
        else if ($srcW >= 651 && $srcW <= 1250)
            $this->createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.55, 0.45, 0.35, 0.25, 0.15);
        else if ($srcW >= 1251 && $srcW <= 1800)
            $this->createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.45, 0.35, 0.25, 0.15, 0.075);
        else if ($srcW >= 1801 && $srcW <= 2200)
            $this->createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.35, 0.25, 0.15, 0.075, 0.0375);
        else
            $this->createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.35, 0.25, 0.15, 0.075, 0.0375);
    }
    public function createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, $ratio1, $ratio2, $ratio3, $ratio4, $ratio5) {
        $versions[0] = floor($srcW * $ratio1) . "_" . floor($srcH * $ratio1);
        $versions[1] = floor($srcW * $ratio2) . "_" . floor($srcH * $ratio2);
        $versions[2] = floor($srcW * $ratio3) . "_" . floor($srcH * $ratio3);
        $versions[3] = floor($srcW * $ratio4) . "_" . floor($srcH * $ratio4);
        $versions[4] = floor($srcW * $ratio5) . "_" . floor($srcH * $ratio5);
        for ($i = 0, $j = 1; $i < sizeof($versions); $i++, $j++) {
            $temp = explode("_", $versions[$i]);
            $desW = $temp[0];
            $desH = $temp[1];
            $image_p = imagecreatetruecolor($desW, $desH);
            $image = $this->createImage($imgtype, $path, $file);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $desW, $desH, $srcW, $srcH);
            $temp = explode(".", $file);
            $extension = strtolower($temp[1]);
            $name = $temp[0] . "_ver" . $j . "_." . $extension;
            $this->outputImageToBrowser($image_p, $path, $name, $extension);
            $ver = 'ver' . $j;
            $_SESSION['IMG_RESPONSE'][count($_SESSION['IMG_RESPONSE']) - 1][$ver] = $this->relativepath . '/' . $name;
        }
        imagedestroy($image_p);
    }
    public function createImage($imageprop, $path, $file) {
        switch ($imageprop) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($path . "/" . $file);
            case IMAGETYPE_JPEG2000:
                return imagecreatefromjpeg($path . "/" . $file);
            case IMAGETYPE_GIF:
                return imagecreatefromgif($path . "/" . $file);
            case IMAGETYPE_PNG:
                $imgPng = imagecreatefrompng($path . "/" . $file);
                $imgPng = $this->imagetranstowhite($imgPng);
                return $imgPng;
            case IMAGETYPE_WBMP:
                return imagecreatefromwbmp($path . "/" . $file);
            case IMAGETYPE_XBM:
                return imagecreatefromxbm($path . "/" . $file);
            default:
                return false;
        }
    }
    public function imagetranstowhite($trans) {
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
    public function outputImageToBrowser($image_p, $path, $name, $extension) {
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
}
?>