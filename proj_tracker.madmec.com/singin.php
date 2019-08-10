<?php
define("MODULE_1", "config.php");
define("MODULE_2", "database.php");
require_once(MODULE_1);
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
    "user_name" => isset($_POST["user_name"]) ? $_POST["user_name"] : false,
    "password" => isset($_POST["password"]) ? $_POST["password"] : false,
    "browser" => isset($_POST["browser"]) ? $_POST["browser"] : false
);
//        print_r($parameters);
unset($_POST);
function main($parameters) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $flag = ValidateAdmin();
            if ($flag) {
                echo "login";
            } else if (!$flag) {
                switch ($parameters["action"]) {
                    case "signIn":
                        $userdata = userLogin($parameters);
                        echo $userdata["STATUS"];
                        break;
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    exit(0);
}
function userLogin($parameters) {
    $userdata = array(
        "USER_EMAIL" => NULL,
        "USER_PASS" => NULL,
        "USER_ID" => NULL,
        "USER_NAME" => NULL,
        "STATUS" => 'error'
    );
    $query = 'SELECT a.*
                FROM `user_profile` a
                WHERE a.`user_name`=\'' . mysql_real_escape_string($parameters["user_name"]) . '\'
                AND a.`password`=\'' . mysql_real_escape_string($parameters["password"]) . '\';';
    $res = executeQuery($query);
    if (get_resource_type($res) == 'mysql result') {
        if (mysql_num_rows($res) > 0) {
            $row = mysql_fetch_assoc($res);
            // echo '<br />'.print_r($row);
            if ($row["user_name"] == $parameters["user_name"] &&
                    $row["password"] == $parameters["password"]
            ) {
                $userdata = array(
                    "USER_EMAIL" => $row["email"],
                    "USER_PASS" => $row["password"],
                    "USER_ID" => $row["id"],
                    "USER_NAME" => $row["user_name"],
                    "STATUS" => 'success'
                );
                executeQuery('UPDATE `user_profile` SET `login` = 1 WHERE `id` = "' . $row["id"] . '";');
            } else if ($row["user_name"] == $parameters["user_name"] &&
                    $row["password"] != $parameters["password"]) {
                $userdata = array(
                    "USER_EMAIL" => NULL,
                    "USER_PASS" => $parameters["password"],
                    "USER_ID" => NULL,
                    "USER_NAME" => $parameters["user_name"],
                    "STATUS" => 'password'
                );
            }
            updateUserlog($parameters, $row["id"]);
        }
    }
    $_SESSION["USER_LOGIN_DATA"] = $userdata;
    return $userdata;
}
function updateUserlog($parameters, $id) {
    $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
    $query = 'INSERT INTO `user_logs` (`id`,
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
					`isp`,
					`browser`,
					`user_pk`,
					`in_time`)  VALUES(
				NULL,
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["query"]) . '\',
				\'' . mysql_real_escape_string($_SERVER["SERVER_ADDR"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["city"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["zip"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["regionName"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["region"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["country"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["countryCode"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["lat"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["lon"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["timezone"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["org"] . '♥♥♥' . $_SESSION["IP_INFO"]["as"] . '♥♥♥' . $_SESSION["IP_INFO"]["isp"]) . '\',
				\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["isp"]) . '\',
				\'' . mysql_real_escape_string($parameters["browser"]) . '\',
				\'' . mysql_real_escape_string($id) . '\',
				default);';
    executeQuery($query);
}
if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') {
    global $parameters;
    main($parameters);
}
?>