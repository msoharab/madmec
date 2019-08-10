<?php
date_default_timezone_set('Asia/Kolkata');
require_once 'channel-ids.php';
require_once 'index-ids.php';
require_once 'profile-ids.php';
require_once 'wall-ids.php';
class configure {

    private $temp, $doc_path, $libroot, $channel_ids, $index_ids, $profile_ids, $wall_ids;
    public $config, $idHolders;

    public function __construct() {
        $this->temp = explode("/", rtrim($_SERVER["DOCUMENT_ROOT"], "/"));
        $this->doc_path = $_SERVER["DOCUMENT_ROOT"] . "/";
        $this->libroot = str_replace($this->temp[count($this->temp) - 1], "library", $_SERVER["DOCUMENT_ROOT"]) . "/";

        $this->config = array(
            //"URL" => "http://local.pic3pic.com/",
            "URL" => "http://www.pic3pic.com/",
            //"URL" => "http://code.madmec.com/",
            "DBHOST" => "localhost",
            "DBUSER" => "root",
            //"DBPASS" => "9743967575",
            "DBPASS" => "madmec@418133",
            "DBNAME_ZERO" => "pic3pic_india",
            "DOC_ROOT" => $this->doc_path,
            "LIB_ROOT" => $this->libroot,
            "DIRS" => "appDirectories/",
            "LIBS" => "libs/",
            "CONTROLLERS" => "controllers/",
            "MODELS" => "models/",
            "VIEWS" => "views/",
            "ASSSET" => "assets/",
            "ASSSET_JSF" => "assets/js/",
            "ASSSET_IMG" => "assets/img/",
            "ASSSET_PLG" => "assets/plugins/",
            /* Mail constraints */
            "GMAIL_HOST" => "smtp.gmail.com",
            "GMAIL_PORT" => "587",
            "GMAIL_USER" => "pic3pic.developer@gmail.com",
            "GMAIL_PASS" => "splasher777@",
            /* Zend mail library */
            "MODULE_ZEND_1" => "Zend/Mail.php",
            "MODULE_ZEND_2" => "Zend/Mail/Transport/Smtp.php",
            /* OAuth api library */
            "OAuth_API_ROOT" => "oauth-api/",
            "OAuth_API_MOD" => "oauth_client.php",
            /* Facebook OAuth api library */
            "FB_OAuth_API_ROOT" => "Facebook/",
            "FB_OAuth_API_MOD" => "autoload.php",
            /* Google OAuth api library */
            "GP_OAuth_API_ROOT" => "Google/",
            "GP_OAuth_API_MOD" => "autoload.php",
            /* HTTP Client api library */
            "HTTP_API_ROOT" => "httpclient/",
            "HTTP_API_MOD" => "http.php",
            /* Plugins */
            "PLG_01" => "bootstrap-slider/",
            "PLG_02" => "bootstrap-wysihtml5/",
            "PLG_03" => "chartjs/",
            "PLG_04" => "ckeditor/",
            "PLG_05" => "colorpicker/",
            "PLG_06" => "datatables/",
            "PLG_07" => "datepicker/",
            "PLG_08" => "daterangepicker/",
            "PLG_09" => "fancybox/",
            "PLG_10" => "fastclick/",
            "PLG_11" => "flot/",
            "PLG_12" => "fullcalendar/",
            "PLG_13" => "iCheck/",
            "PLG_14" => "input-mask/",
            "PLG_15" => "ionslider/",
            "PLG_16" => "jQuery/",
            "PLG_17" => "jQuery-File-Upload-9.10.4/",
            "PLG_18" => "jQueryUI/",
            "PLG_19" => "jvectormap/",
            "PLG_20" => "knob/",
            "PLG_21" => "morris/",
            "PLG_22" => "pace/",
            "PLG_23" => "picedit/",
            "PLG_24" => "select2/",
            "PLG_25" => "slimScroll/",
            "PLG_26" => "sparkline/",
            "PLG_27" => "timepicker/",
            "PLG_28" => "facebook/",
            "PLG_29" => "googleplus/",
            "ASSSET_PIC" => "assets/js/pic3pic/",
            "ASSSET_BST" => "assets/bootstrap/",
            "FONT_0" => "font-awesome-4.4.0/",
            "FONT_1" => "fonts-ionicons-2.0.1/",
            "INC" => "inc/",
            "MODULE_0" => "config.php",
            "MODULE_1" => "database.php",
            "MODULE_2" => "model.php",
            "MODULE_3" => "view.php",
            "MODULE_4" => "controller.php",
            "MODULE_5" => "bootstrap.php",
            "MODULE_6" => "sessions.php",
            "DEFAULT_CNTRL" => "Index.php",
            "CTRL_0" => "About/",
            "CTRL_1" => "Channel/",
            "CTRL_2" => "Error/",
            "CTRL_3" => "Login/",
            "CTRL_4" => "Logout/",
            "CTRL_5" => "Profile/",
            "CTRL_6" => "Register/",
            "CTRL_7" => "Wall/",
            "CTRL_8" => "Popular/",
            "CTRL_9" => "NewPost/",
            "CTRL_10" => "Geography/",
            "CTRL_11" => "Languages/",
            "CTRL_12" => "LoadJS/",
            "CTRL_13" => "LoadJSON/",
            "CTRL_14" => "Post/",
            "CTRL_15" => "Report/",
            "CTRL_16" => "Sections/",
            "CTRL_17" => "Visitor/",
            "CTRL_18" => "Picture/",
            "CTRL_19" => "Header/",
            "CTRL_20" => "Guidelines/",
            "CTRL_21" => "Privacy/",
            "CTRL_22" => "Rules/",
            "CTRL_23" => "Terms/",
            "CTRL_24" => "Unique/",
            "CTRL_25" => "Help/",
            "CTRL_26" => "Facebook/",
            "CTRL_27" => "GooglePlus/",
            "CTRL_28" => "Index/",
            "START_DATE" => "2015-10-01",
        );
        $this->config["CHN_CNT_LMT"] = 3;
        $this->config["CHN_CNT_SIZ"] = 300;
        $this->config["CHN_ADD_LMT"] = 1;
        $this->config["POST_DELY_TIME"] = 900;

        $this->config["DEFAULT_LOGO"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "logo.png";

        /* Wall */
        $this->config["DEFAULT_POST_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "wall/default-thumbnail.jpg";
        $this->config["DEFAULT_COMENT_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "wall/default-thumbnail.jpg";
        $this->config["DEFAULT_REPLY_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "wall/default-thumbnail.jpg";
        /* Channel */
        $this->config["DEFAULT_CHANEL_BACK_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "channels/channel_cover.jpg";
        $this->config["DEFAULT_CHANEL_ICON_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "channels/channel_logo.jpg";
        $this->config["DEFAULT_CHANEL_ADV_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "channels/add.png";
        /* User */
        $this->config["DEFAULT_USER_BACK_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "profile/banner_0.jpg";
        $this->config["DEFAULT_USER_ICON_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "profile/profle.jpg";

        $this->channel_ids = new channel_ids($this->config);
        $this->index_ids = new index_ids($this->config);
        $this->profile_ids = new profile_ids($this->config);
        $this->wall_ids = new wall_ids($this->config);

        $this->idHolders = array(
            "pic3pic" => array(
                "profile" => $this->profile_ids->getIds(),
                "channel" => $this->channel_ids->getIds(),
                "wall" => $this->wall_ids->getIds(),
                "index" => $this->index_ids->getIds(),
            ),
        );
    }
    public function createdirectories($directory) {
        $this->createDirectory($this->config["DOC_ROOT"] . $this->config["DIRS"]);
        $flag = false;
        $curr_dir = $this->getCurrUserDir();
        $sruct_array = array(
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/comments/",
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/replys/",
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/channel/",
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/posts/",
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/profile/");
        for ($i = 0; $i < sizeof($sruct_array); $i++) {
            if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') {
                if (!file_exists($sruct_array[$i])) {
                    if (!mkdir($sruct_array[$i], 0, true) && !is_dir($sruct_array[$i])) {
                        $flag = false;
                        break;
                    } else {
                        $flag = true;
                    }
                }
            }
            if (PHP_OS == 'Linux') {
                if (!file_exists($sruct_array[$i])) {
                    if (!mkdir($sruct_array[$i], 0777, true) && !is_dir($sruct_array[$i])) {
                        $flag = false;
                        break;
                    } else {
                        $flag = true;
                    }
                }
            }
            file_put_contents($sruct_array[$i] . "index.php", "<?php header('Location:" . $this->config["URL"] . "'); ?>");
        }
        if ($flag) {
            $curr_dir = $curr_dir . "/" . $directory;
            return $this->config["DIRS"] . $curr_dir;
        } else
            return NULL;
    }
    public function getCurrUserDir() {
        $i = 2;
        $dir = $this->config["DOC_ROOT"] . $this->config["DIRS"];
        $curr = 'res_';
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    $curr = "res_" . $i;
                    if (is_dir($dir . $file)) {
                        if ($file != "." && $file != ".." && $file == $curr && file_exists($dir . $file . $curr) && is_dir($dir . $file . $curr)) {
                            $num = $this->Number_directories($dir . $file . $curr);
                            if ($num > 9999) {
                                $i++;
                                continue;
                            }
                        }
                    }
                }
            }
            closedir($dh);
        }
        $this->createDirectory($dir . $file . $curr);
        return $curr;
        return $curr;
    }
    public function Number_directories($dir) {
        $i = 0;
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while ($file = readdir($dh)) {
                    if (is_dir($dir . "/" . $file) && $file != "." && $file != "..") {
                        $i++;
                    }
                }
            }
            closedir($dh);
        }
        return $i;
    }
    public function createDirectory($path1) {
        if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') {
            if (!file_exists($path1)) {
                mkdir($path1, 0, true);
            }
        }
        if (PHP_OS == 'Linux') {
            if (!file_exists($path1)) {
                mkdir($path1, 0777, true);
            }
        }
        file_put_contents($path1 . "index.php", "<?php header('Location:" . $this->config["URL"] . "'); ?>");
    }
    public function getIdHolders() {
        $data = array(
            "status" => "error",
            "JSON" => array()
        );
        if (is_array($this->idHolders)) {
            $data["status"] = "success";
            $data["JSON"] = (array) $this->idHolders;
        }
        $this->baseview->setjsonData($data);
        echo $this->baseview->renderJson();
    }
    public function multiExplode($delimiters, $string) {
        if (is_string($string) && strlen($string) > 0) {
            $ary = explode($delimiters[0], $string);
            array_shift($delimiters);
            if ($delimiters != NULL) {
                foreach ($ary as $key => $val) {
                    $ary[$key] = $this->multiexplode($delimiters, $val);
                }
            }
            return $ary;
        }
    }
    public function validateEmail($email) {
        if (preg_match('%^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})%', stripslashes(trim($email)))) {
            return trim($email);
        } else {
            return NULL;
        }
    }
    public function sendMail($para) {
        $to = '';
        $subject = '';
        $message = '';
        $title = '';
        $ret = array(
            "status" => 'error',
            "msg" => 'Please check your mail box for password....',
        );
        if (is_array($para)) {
            $to = isset($para['to']) ? trim($this->validateEmail($para['to'])) : '';
            $subject = isset($para['subject']) ? trim($para['subject']) : '';
            $message = isset($para['message']) ? trim($para['message']) : '';
            $title = isset($para['title']) ? trim($para['title']) : 'Pic3Pic';
        }
        if (!empty($to) && !empty($subject) && !empty($message)) {
            $mail = '';
            $transport = '';
            set_include_path(get_include_path() . PATH_SEPARATOR . $this->config["LIB_ROOT"]);
            require_once($this->config["LIB_ROOT"] . $this->config["MODULE_ZEND_1"]);
            require_once($this->config["LIB_ROOT"] . $this->config["MODULE_ZEND_2"]);
            $MailConfig = array(
                "host" => $this->config["GMAIL_HOST"],
                "port" => $this->config["GMAIL_PORT"],
                "ssl" => "tls",
                "auth" => "login",
                "username" => $this->config["GMAIL_USER"],
                "password" => $this->config["GMAIL_PASS"]
            );
            $mailParameters = array(
                "target_host" => explode("@", $to)[1],
                "message" => $message,
                "title" => $title,
                "name" => explode("@", $to)[0],
                "subject" => $subject,
                "to" => $to,
            );
            if ($has_dns_mx_record = checkdnsrr($mailParameters["target_host"], "MX")) {
                $transport = new Zend_Mail_Transport_Smtp($MailConfig["host"], $MailConfig);
                $mail = new Zend_Mail();
                $mail->setBodyHtml($mailParameters["message"]);
//                $mail->setFrom($MailConfig["host"], $mailParameters["title"]);
                $mail->setFrom($MailConfig["host"], "Pic3Pic");
                $mail->addTo($mailParameters["to"], $mailParameters["name"]);
                $mail->setSubject($mailParameters["subject"]);
                try {
                    $mail->send($transport);
                    unset($mail);
                    unset($transport);
                    $ret['status'] = 'success';
                } catch (exceptoin $e) {
                    $logger = Zend_Registry::get('Logger');
                    $logger->err($e->getMessage());
                    $ret['msg'] = "Error sending Email : " . $e->getMessage() . "\n\n\n";
                }
            }
        }
        return $ret;
    }
    public function folderSize($dir) {
        $count_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
        foreach ($dir_array as $key => $filename) {
            if ($filename != ".." && $filename != ".") {
                if (is_dir($dir . "/" . $filename)) {
                    $new_foldersize = foldersize($dir . "/" . $filename);
                    $count_size = $count_size + $new_foldersize;
                } else if (is_file($dir . "/" . $filename)) {
                    $count_size = $count_size + filesize($dir . "/" . $filename);
                    $count++;
                }
            }
        }
        return $this->roundsize($count_size);
    }
    public function roundsize($size) {
        $i = 0;
        $iec = array("Bytes", "Kilo bytes", "Mega bytes", "Giga bytes", "Terra bytes");
        //$iec = array("Bytes", "Kily bytes", "Mega bytes", "Giga bytes", "Terra bytes");
        //$val = 0 . " " . $iec[$i];
        $val = array(
            "size" => 0,
            "unit" => $iec[$i],
        );
        if ($size > 0) {
            while (($size / 1024) > 1) {
                $size = $size / 1024;
                $i++;
            }
            //$val = round($size, 1) . " " . $iec[$i];
            $val = array(
                "size" => round($size, 1),
                "unit" => $iec[$i],
            );
        }
        return $val;
    }
    public function generateRandomString($length = 6) {
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        if (strlen($randomString) > 5)
            return $randomString;
        else
            $this->generateRandomString();
    }
}