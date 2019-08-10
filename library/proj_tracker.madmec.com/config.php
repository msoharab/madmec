<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
/* Database constraints */
define("DBHOST", "localhost");
define("DBUSER", "root");

require_once('var_config.php');
//include_once('mysql2i.class.php');

$temp = explode("/", rtrim($_SERVER['DOCUMENT_ROOT'], "/"));
$doc_path = $_SERVER['DOCUMENT_ROOT'] . "/";
$libroot = str_replace($temp[count($temp) - 1], "library", $_SERVER['DOCUMENT_ROOT']) . "/";
define("DOC_ROOT", $doc_path);
define("LIB_ROOT", $libroot);

define("IMG_CONST", 400);
define("MODULE_ZEND_1", "Zend/Mail.php");
define("MODULE_ZEND_2", "Zend/Mail/Transport/Smtp.php");
define("INC", "inc/");
define("ADMIN", "admin/");
define("USER", "user/");
define("TRAINER", "trainer/");
define("DOWNLOADS", "downloads/");
//define("PHP","php/");
define("UPLOADS", "uploads/");
define("ASSET_DIR", "assets/");
define("FONT", "font-awesome-4.2.0/css/");
define("ASSET_JS", "assets/js/");
define("DATATABLES", "dataTables/");
define("MAIN_JS", "main/js/");
define("TREATMENT_IMAGE", "main/res/treatment_image/");
define("PROFILE_IMAGE", "main/res/profile/");
define("ASSET_JS_USER", "a.user/");
define("ASSET_JS_TRAINER", "a.trainer/");
define("ASSET_JS_MANAGE", "a.manage/");
define("ASSET_JS_REPORT", "a.reports/");
define("ASSET_JS_STATS", "a.stats/");
define("ASSET_JS_ACCOUNTS", "a.accounts/");
define("ASSET_CSS", "assets/css/");
define("ASSET_IMG", "assets/img/");
define("PROFILE_IMG", URL . ASSET_IMG . "find_user.png");
define("IMG_LOADER", "assets/img/loading-bar.gif");
define("ASSET_VOU", "main/res/vouchers/");
define("ASSET_REC", "main/res/receipts/");
define("REG_FEE", "500");
define("PDF", "fpdf/fpdf.php");
define("START_DATE", "2015-11-10");
define("CELL_CODE", "+91");

$bootstrapProperties = array(
    "pageheader_color" => "text-primary",
    "panel_color" => ""
);
function generateRandomString($length = 6) {
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
    //$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $characters = '0123456789madmec';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    if (strlen($randomString) > 5)
        return $randomString;
    else
        generateRandomString();
}
function Alert($email, $name, $subject, $recp = false) {
    $flag = false;
    $mail = '';
    set_include_path(get_include_path() . PATH_SEPARATOR . LIB_ROOT);
    require_once(LIB_ROOT . MODULE_ZEND_1);
    require_once(LIB_ROOT . MODULE_ZEND_2);
    $config = array('auth' => 'login',
        'port' => MAILPORT,
        'username' => MAILUSER,
        'password' => MAILPASS);
    $message = 'Hi ' . $name . ',' .
            '<br />Below is a Recipet. <br /><br />
							<div id="mydiv" style="box-shadow:0px 0px 2px 2px #999;color:#4169E1 !important">
								' . $recp . '
							</div>
									
					<br /><br />Regards, <br /> Sree Ramaseva Mandali';
    $transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
    if ($transport) {
        $mail = new Zend_Mail();
        if ($mail) {
            $mail->setBodyHtml($message);
            $mail->setFrom(MAILUSER, ALTEMAIL);
            $mail->addTo($email, $name);
            $mail->setSubject($subject);
            $flag = true;
        }
    }
    if ($flag) {
        try {
            $mail->send($transport);
            unset($mail);
            unset($transport);
            $flag = true;
        } catch (exceptoin $e) {
            echo 'Invalid email id :- ' . $email . '<br />';
            $flag = false;
        }
    }
    return $flag;
}
function linear_search($key, $listtypes) {
    for ($i = 0; $i < sizeof($listtypes); $i++)
        if ($key == $listtypes[$i])
            return true;
    return false;
}
function createDirectory($path1) {
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
    file_put_contents($path1 . "/index.php", "<?php header('Location:" . URL . "'); ?>");
}
function ValidateAdmin() {
    $flag = false;
    if (!isset($_SESSION["USER_LOGIN_DATA"])) {
        return $flag;
    } else {
        $flag = true;
        return $flag;
    }
}
function CheckAdminValidation($u, $p) {
    $flag = false;
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $query = "SELECT * FROM `admin`
						WHERE `user_name` = '" . mysql_real_escape_string($u) . "'
						AND `password` = '" . mysql_real_escape_string($p) . "'; ";
            $res = executeQuery($query);
            if (mysql_num_rows($res)) {
                $flag = 'success';
            } else {
                $flag = false;
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    return $flag;
}
function updateTraffic() {
    setIPInfo();
    if (isset($_SESSION["IP_INFO"]["status"]) && $_SESSION["IP_INFO"]["status"] != 'fail') {
        $query = 'INSERT INTO `traffic` (`id`,
			`ip`,
			`host`,
			`city`,
			`zipcode`,
			`province`,
			`province_code`,
			`country`,
			`country_code`,
			`latitude`,
			`longitude`,
			`timezone`,
			`organization`,
			`isp`)  VALUES (
		NULL,
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["query"]) . '\',
		\'' . mysql_real_escape_string($_SERVER['SERVER_ADDR']) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["city"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["zip"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["regionName"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["region"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["country"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["countryCode"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["lat"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["lon"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["timezone"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["org"] . '???' . $_SESSION["IP_INFO"]["as"] . '???' . $_SESSION["IP_INFO"]["isp"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["isp"]) . '\');';
        executeQuery($query);
    }
}
function getClientIP() {
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
function setIPInfo() {
    $ip_data = false;
    $ip_data = ip_api(getClientIP());
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
function ip_api($ip) {
    if (empty($ip))
        return false;
    else
        return @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
}
?>
