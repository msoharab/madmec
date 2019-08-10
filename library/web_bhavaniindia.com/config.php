<?php
require_once('var_config.php');
date_default_timezone_set('Asia/Kolkata');
$temp = explode("/", rtrim($_SERVER['DOCUMENT_ROOT'], "/"));
$doc_path = $_SERVER['DOCUMENT_ROOT'] . "/";
$libroot = str_replace($temp[count($temp) - 1], "library", $_SERVER['DOCUMENT_ROOT']) . "/";

define("DOC_ROOT", $doc_path);
define("DOC_ADMIN_ROOT", $doc_path.'admin/');
define("LIB_ROOT", $libroot);
set_include_path(get_include_path() . PATH_SEPARATOR . LIB_ROOT);
define("IMG_CONST", 400);
define("MAILPORT", 587);
define("MAILHOST", "smtp.gmail.com");
define("MAILUSER", "bhavanienterprise.info@gmail.com");
define("MAILPASS", "splasher777@");
define("MODULE_ZEND_1", "Zend/Mail.php");
define("MODULE_ZEND_2", "Zend/Mail/Transport/Smtp.php");
define("ADMIN", "admin/");
define("INC", "inc/");
define("MOD", "html/");
define("ASSET_DIR", "assets/");
define("ASSET_JSF", "assets/js/");
define("ASSET_CSS", "assets/css/");
define("ASSET_IMG", "assets/images/");
define("ASSET_PLG", "assets/js/plugins/");

/*Default Images*/
define("DEFAULT_LOGO",IMAGEURL."views/".ASSET_IMG."Final.png");
define("DEFAULT_PRD_IMG",IMAGEURL."views/".ASSET_IMG."i6.png");
define("DEFAULT_IMG",IMAGEURL."views/".ASSET_IMG."ic10.jpg");

function validateName($uname) {
    if (preg_match('%^[A-Z_a-z\."\- 0-9]{3,100}%', stripslashes(trim($uname)))) {
        return $uname;
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
}function ValidateAdmin() {
    $flag = false;
    if (!isset($_SESSION["USER_LOGIN_DATA"])) {
        return $flag;
    } else if (isset($_SESSION["USER_LOGIN_DATA"]["STATUS"]) && $_SESSION["USER_LOGIN_DATA"]["STATUS"] == 'success') {

        $query = 'SELECT *
		FROM `users`
		WHERE
		`name`=\'' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) . '\'
		AND
		`password`=\'' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_PASS"]) . '\';';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $row = mysql_fetch_assoc($res);
            $_SESSION["USER_LOGIN_DATA"] = array(
                "USER_NAME" => $row["name"],
                "USER_PASS" => $row["password"],
                "USER_ID" => $row["id"],
                "USER_TYPE" => $row["user_type_id"],
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
