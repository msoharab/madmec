<?php
date_default_timezone_set('Asia/Kolkata');
//error_reporting(0);
require_once 'dashboard-ids.php';
require_once 'index-ids.php';
require_once 'profile-ids.php';
require_once 'stock-ids.php';
require_once 'sales-ids.php';


class configure {

    private $temp,
            $doc_path,
            $libroot,
            $index_ids,
            $dashboard_ids,
            $user_ids,
            $stock_ids,
            $sales_ids,
            $profile_ids;
    public $config,
            $idHolders;

    public function __construct() {
        $this->doc_path = $_SERVER["DOCUMENT_ROOT"] . "\\app\\";
        $this->libroot = $_SERVER["DOCUMENT_ROOT"] . "\\library\\";
        $this->config = array(
			"CompanyName" => "MadMec",
			"AppDescription" => "MadMec AutoBill Application For Retailers",
			"AppVersion" => "31.8.0.0",
			"InternalName" => "AutoBill Application",
			"LegalCopyright" => "(c) MadMec 2012-2016",
			"OriginalFilename" => "AutoBill.exe",
			"ProductName" => "AutoBill",
			"ProductVersion" => "31.8.0.0",
            "URL" => "http://".$_SERVER["HTTP_HOST"]."/app/",
            "EGPCSURL" => "http://".$_SERVER["HTTP_HOST"]."/app/index.php?url=",
            "DBHOST" => "127.0.0.1",
            "DBUSER" => "root",
            "DBPASS" => "",
            "DBNAME_ZERO" => "habeebshop",
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
            "ASSSET_REG" => "assets/js/habeeb/",
            "ASSSET_BST" => "assets/bootstrap/",
            /* Mail constraints */
            "GMAIL_HOST" => "smtp.gmail.com",
            "GMAIL_PORT" => "587",
            "GMAIL_USER" => "habeebshop.developer@gmail.com",
            "GMAIL_PASS" => "complex222@",
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
            "PLG_30" => "jszip/",
            "PLG_31" => "pdfmake/",
            "FONT_0" => "font-awesome-4.5.0/",
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
            "CTRL_0" => "CRM/",
            "CTRL_1" => "Index/",
            "CTRL_2" => "Error/",
            "CTRL_3" => "Login/",
            "CTRL_4" => "Logout/",
            "CTRL_5" => "Profile/",
            "CTRL_6" => "Register/",
            "CTRL_8" => "Reports/",
            "CTRL_14" => "Terms/",
            "CTRL_15" => "User/",
            "CTRL_16" => "Facebook/",
            "CTRL_17" => "GooglePlus/",
            "CTRL_18" => "ForgotPassword/",
            "CTRL_19" => "Dashboard/",
            "CTRL_20" => "Stock/",
            "CTRL_21" => "Sales/",
            "START_DATE" => "2016-09-10",
        );

        $this->config["MAX_IMG_SIZE"] = 5242880;

        $this->config["DEFAULT_LMENU"] = "commonLeftNavMenu.php";
        $this->config["DEFAULT_HEADER"] = "commonHeader.php";
        /* No Media */
        $this->config["DEFAULT_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "no-upload.jpg";
        /* Logo */
        $this->config["DEFAULT_LOGO"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "logo.jpg";
        /* User */
        $this->config["DEFAULT_USER_IMG"] = $this->config["URL"] .
                $this->config["VIEWS"] .
                $this->config["ASSSET_IMG"] . "anonymous.png";

        $this->dashboard_ids = new dashboard_ids($this->config);
        $this->index_ids = new index_ids($this->config);
        $this->profile_ids = new profile_ids($this->config);
        $this->stock_ids = new stock_ids($this->config);
        $this->sales_ids = new sales_ids($this->config);
        $this->idHolders = array(
            "shop" => array(
                "dashbord" => $this->dashboard_ids->getIds(),
                "index" => $this->index_ids->getIds(),
                "profile" => $this->profile_ids->getIds(),
                "stock" => $this->stock_ids->getIds(),
                "sales" => $this->sales_ids->getIds(),
            ),
        );
    }

    public function createdirectories($directory) {
        $this->createDirectory($this->config["DOC_ROOT"] . $this->config["DIRS"]);
        $flag = false;
        $curr_dir = $this->getCurrUserDir();
        $sruct_array = array(
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/temp/",
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/profile/",
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory//profile/temp/");
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
            $title = isset($para['title']) ? trim($para['title']) : 'Tamboola';
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
                $mail->setFrom($MailConfig["host"], "Tamboola");
                $mail->addTo($mailParameters["to"], $mailParameters["name"]);
                $mail->setSubject($mailParameters["subject"]);
                try {
                    $mail->send($transport);
                    unset($mail);
                    unset($transport);
                    $ret['status'] = 'success';
                } catch (exception $e) {
//                    $logger = Zend_Registry::get('Logger');
//                    $logger->err($e->getMessage());
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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        // $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        if (strlen($randomString) > 5)
            return $randomString;
        else
            $this->generateRandomString();
    }

    public function getClientIP() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else if (isset($_SERVER['REMOTE_HOST']))
            $ipaddress = $_SERVER['REMOTE_HOST'];
        else
            $ipaddress = NULL;
        return $ipaddress;
    }

    public function setIPInfo() {
        $ip_data = false;
        $ip_data = $this->ip_api($this->getClientIP());
        //{"query":"192.168.0.10","status":"fail","message":"private range"}
        if ($ip_data["status"] == 'fail') {
            $ip_data = array(
                "countryCode" => 'IN',
                "zip" => '560078',
                "country" => 'India',
                "region" => '19',
                "org" => 'BSNL',
                "as" => 'AS9829 National Internet Backbone',
                "regionName" => 'Karnataka',
                "city" => 'Bangalore',
                "lat" => '12.983300209045',
                "lon" => '77.583297729492',
                "timezone" => 'Asia/Calcutta',
                "status" => 'success',
                "query" => '117.208.185.160',
                "isp" => 'BSNL'
            );
        }
        $_SESSION["IP_INFO"] = $ip_data;
    }

    public function ip_api($ip) {
        if (empty($ip))
            return false;
        else
            return @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
    }

}

?>
