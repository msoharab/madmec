<?php
require_once('var_config.php');
//include_once('mysql2i.class.php');
date_default_timezone_set('Asia/Kolkata');
$temp = explode("/", rtrim($_SERVER['DOCUMENT_ROOT'], "/"));
$doc_path = $_SERVER['DOCUMENT_ROOT'] . "/";
$libroot = str_replace($temp[count($temp) - 1], "library", $_SERVER['DOCUMENT_ROOT']) . "/";
define("DOC_ROOT", $doc_path);
define("LIB_ROOT", $libroot);
define("DIRS", "appDirectories/");
define("INC", "inc/");
define("ADMIN", "admin/");
define("EMPLY", "employee/");
define("INC_ADM", INC . ADMIN);
define("INC_EMP", INC . EMPLY);
define("CLASSES", "classes/");
define("DOWNLOADS", "downloads/");
define("UPLOADS", "uploads/");
define("ASSET_DIR", "assets/");
define("ASSET_JSF", "assets/js/");
define("ASSET_DST", "assets/dist/");
define("ASSET_IMG", "assets/images/");
define("ASSET_BSF", "bootstrap/");
define("ASSET_PLG", "plugins/");
define("ASSET_JQF", "jQuery/");
define("ADM_JS", "admin/");
define("EMP_JS", "employee/");
define("FONT_1", "font-awesome-4.1.0/");
define("FONT_2", "font-awesome-4.2.0/");
define("FONT_3", "font-awesome-4.4.0/");
define("FONT_4", "fonts-ionicons-2.0.1/");
define("ASSET_THM", "AdminLTHEME/");
define("ADM_DASH", DOC_ROOT . INC_ADM . "dashboard.html");
define("ADM_EMPS", DOC_ROOT . INC_ADM . "employees.html");
define("ADM_PROJ", DOC_ROOT . INC_ADM . "projects.html");
define("ADM_IMPT", DOC_ROOT . INC_ADM . "import.html");
define("ADM_REPT", DOC_ROOT . INC_ADM . "reports.html");
define("ADM_PROF", DOC_ROOT . INC_ADM . "profile.html");
define("DOA_ADM_DASH", DOC_ROOT . CLASSES . ADMIN . "dashboard.php");
define("DOA_ADM_EMPS", DOC_ROOT . CLASSES . ADMIN . "employees.php");
define("DOA_ADM_PROJ", DOC_ROOT . CLASSES . ADMIN . "projects.php");
define("DOA_ADM_IMPT", DOC_ROOT . CLASSES . ADMIN . "import.php");
define("DOA_ADM_REPT", DOC_ROOT . CLASSES . ADMIN . "reports.php");
define("DOA_ADM_PROF", DOC_ROOT . CLASSES . ADMIN . "profile.php");
define("EMP_DASH", DOC_ROOT . INC_EMP . "dashboard.html");
define("EMP_ACTIVITY", DOC_ROOT . INC_EMP . "empactivity.html");
define("EMP_ENGE", DOC_ROOT . INC_EMP . "engage.html");
define("EMP_IMPT", DOC_ROOT . INC_EMP . "import.html");
define("EMP_PROF", DOC_ROOT . INC_EMP . "profile.html");

define("DOA_EMP_DASH", DOC_ROOT . CLASSES . EMPLY . "dashboard.php");
define("DOA_EMP_ACTIVITY", DOC_ROOT . CLASSES . EMPLY . "activity.php");
define("DOA_EMP_ENGE", DOC_ROOT . CLASSES . EMPLY . "engage.php");
define("DOA_EMP_IMPT", DOC_ROOT . CLASSES . EMPLY . "import.php");
define("DOA_EMP_PROF", DOC_ROOT . CLASSES . EMPLY . "profile.php");

define("START_DATE", "2015-09-18");

define("LOGO", URL . ASSET_IMG . "logo.jpg");

define('EXCEL_ACTIVITY', "ACTIVITY");
define('EXCEL_ACTIVITY_DESC', "DESCRIPTION");
define('EXCEL_ACTIVITY_FROM', "FROM");
define('EXCEL_ACTIVITY_TO', "TO");

define("USER_ANON_IMAGE", URL . ASSET_IMG . "anonymous.png");
function validateUserName($uname) {
    if (preg_match('%^[A-Z_a-z\."\- 0-9]{3,100}%', stripslashes(trim($uname)))) {
        return $uname;
    } else {
        return NULL;
    }
}
function validatePassword($pass) {
    if (strlen($pass) > 3) {
        return $pass;
    } else {
        return NULL;
    }
}
function validateEmail($email) {
    if (preg_match('%^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})%', stripslashes(trim($email)))) {
        return $email;
    } else {
        return NULL;
    }
}
function ValidateAdmin() {
    $flag = false;
    if (!isset($_SESSION["USER_LOGIN_DATA"])) {
        return $flag;
    } else if (isset($_SESSION["USER_LOGIN_DATA"]["STATUS"]) && $_SESSION["USER_LOGIN_DATA"]["STATUS"] == 'success') {
        $query = 'SELECT up.`id` as userid,
		up.`user_name`,
		up.`password`,
		up.`email_id`,
                up.`user_type_id`,
		ut.`type`,
                ut.`filename`
                FROM `user_profile` AS up
                LEFT JOIN `user_type` AS ut ON up.`user_type_id`= ut.`id`
		WHERE
		up.`email_id`=\'' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_EMAIL"]) . '\'
		AND
		up.`password`=\'' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_PASS"]) . '\';';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $row = mysql_fetch_assoc($res);
            $_SESSION["USER_LOGIN_DATA"] = array(
                "USER_EMAIL" => $row["email_id"],
                "USER_PASS" => $row["password"],
                "USER_ID" => $row["userid"],
                "USER_NAME" => $row["user_name"],
                "USER_TYPE" => $row["user_type_id"],
                "MENU_FILE" => $row["filename"],
                "STATUS" => 'success'
            );
            $flag = true;
        }
    }
    return $flag;
}
function generateRandomString($length = 6) {
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
//    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    if (strlen($randomString) > 5)
        return $randomString;
    else
        generateRandomString();
}
function getStatusId($statname = false) {
    $statname = ucfirst($statname);
    $res = executeQuery('SELECT `id` FROM `status` WHERE `statu_name` =\'' . $statname . '\';');
    $row = mysql_fetch_assoc($res);
    return $row["id"];
}
function getGenderId($statname = false) {
    $statname = ucfirst($statname);
    $res = executeQuery('SELECT `id` FROM `gender` WHERE `gender_name` =\'' . $statname . '\';');
    $row = mysql_fetch_assoc($res);
    return $row["id"];
}
function getUserTypeId($usertype = false) {
    $statname = ucfirst($usertype);
    $res = executeQuery('SELECT `id` FROM `user_type` WHERE `type` ="' . $usertype . '";');
    $row = mysql_fetch_assoc($res);
    return $row["id"];
}
function createdirectories($directory) {
    createDirectory(DOC_ROOT . DIRS);
    $flag = false;
    $i = 0;
    $temp = '';
    $curr_dir = getCurrUserDir();
    $sruct_array = array(
        DOC_ROOT . DIRS . "$curr_dir/$directory/temp/",
        DOC_ROOT . DIRS . "$curr_dir/$directory/profile/",
        DOC_ROOT . DIRS . "$curr_dir/$directory/profile/temp");
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
        file_put_contents($sruct_array[$i] . "/index.php", "<?php header('Location:" . URL . "'); ?>");
    }
    if ($flag) {
        $curr_dir = $curr_dir . "/" . $directory;
        return $curr_dir;
    } else
        return NULL;
}
function getCurrUserDir() {
    $i = 1;
    $dir = DOC_ROOT . DIRS;
    $curr = 'res_';
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                $curr = "res_" . $i;
                if (is_dir($dir . $file)) {
                    if ($file != "." && $file != ".." && $file == $curr && file_exists($dir . $file . $curr) && is_dir($dir . $file . $curr)) {
                        $num = Number_directories($dir . $file . $curr);
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
    createDirectory($dir . $file . $curr);
    return $curr;
}
function Number_directories($dir) {
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
function delete_temp_files($source) {
    if (is_dir($source)) {
        $files = scandir($source);
        foreach ($files as $file) {
            if (in_array($file, array(".", "..", "temp", "index.php")))
                continue;
            unlink($source . $file);
        }
    } else
        createDirectory($source);
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
function getLastWeekDates() {
    $previous_week = strtotime("-1 week +1 day");
    $start_week = strtotime("last sunday midnight", $previous_week);
    $end_week = strtotime("next saturday", $start_week);
    $start_week = date("Y-m-d h:i:s", $start_week);
    $end_week = date("Y-m-d h:i:s", $end_week);
    return array(
        "start" => $start_week,
        "end" => $end_week
    );
}
?>
