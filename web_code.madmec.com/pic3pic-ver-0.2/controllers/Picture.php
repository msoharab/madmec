<?php
class Picture extends BaseController {

    private $para;
    private $PictureMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->PictureMod = new Picture_Model();
        $this->PictureMod->setPostData($this->postPara);
    }
    public function Index() {
        
    }
    public function UploadPic() {
        header('Content-type: image/jpeg');
        if (isset($_FILES['file'])) {
            var_dump($_FILES);
            $errors = array();
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_ext = explode('.', $_FILES['file']['name']);
            $file_ext = $file_ext[sizeof($file_ext) -1];
            $file_ext = strtolower($file_ext);
            $expensions = array("jpeg", "jpg", "png");

            if (in_array($file_ext, $expensions) === false) {
                $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
            }

            if ($file_size > 2097152) {
                $errors[] = 'File size must be excately 2 MB';
            }

            if (empty($errors) == true) {
                $file_path1 = $this->config["DOC_ROOT"] .
                        $_SESSION["USERDATA"]["logindata"]["directory"] . '/posts/'.
                        $_SESSION["USERDATA"]["logindata"]['id'] . '_original_pic' . time() . '.' . $file_ext;
                $file_path = $_SESSION["USERDATA"]["logindata"]["directory"] . '/posts/'.
                        $_SESSION["USERDATA"]["logindata"]['id'] . '_original_pic' . time() . '.' . $file_ext;
                move_uploaded_file($file_tmp, $file_path1);
                $_SESSION['Individual_POST_PATH']['respnse'] = array(
                    "error" => NULL,
                    "status" => "success",
                    "original_pic" => $file_path,
                    "version_1" => $this->resizeImage($file_path1, 0.7, '1st_version'),
                    "version_2" => $this->resizeImage($file_path1, 0.5, '2nd_version'),
                    "version_3" => $this->resizeImage($file_path1, 0.4, '3nd_version'),
                    "version_4" => $this->resizeImage($file_path1, 0.3, '4nd_version'),
                    "version_5" => $this->resizeImage($file_path1, 0.1, '5nd_version')
                );
            } else {
                $_SESSION['Individual_POST_PATH']['respnse'] = array(
                    "error" => (array) $errors,
                    "status" => "error",
                    "original_pic" => NULL,
                    "version_1" => NULL,
                    "version_2" => NULL,
                    "version_3" => NULL,
                    "version_4" => NULL,
                    "version_5" => NULL
                );
            }
        }
    }
    public function resizeImage($filename, $percent, $version) {
        // Content type
        header('Content-Type: image/jpeg');

        // Get new sizes
        list($width, $height) = getimagesize($filename);
        $newwidth = $width * $percent;
        $newheight = $height * $percent;

        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($filename);

        // Resize
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        $file_path1 = $this->config["DOC_ROOT"] .
                $_SESSION["USERDATA"]["logindata"]["directory"] . '/posts/'.
                $_SESSION["USERDATA"]["logindata"]['id'] . '_' . $version . time() . '.' . 'jpg';
        $file_path = $_SESSION["USERDATA"]["logindata"]["directory"] . '/posts/'.
                $_SESSION["USERDATA"]["logindata"]['id'] . '_' . $version . time() . '.' . 'jpg';
        imagejpeg($thumb, $file_path1);
        return $file_path;
    }
}