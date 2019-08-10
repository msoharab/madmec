<?php

define("MODULE_0", "config.php");
require_once (MODULE_0);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
    "user_name" => (isset($_POST["user_name"]) && validateUserName($_POST["user_name"])) ? $_POST["user_name"] : false,
    "password" => (isset($_POST["password"]) && validatePassword($_POST["password"])) ? $_POST["password"] : false,
    "browser" => isset($_POST["browser"]) ? $_POST["browser"] : false
);
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
        "USER_PHOTO" => NULL,
        "USER_TYPE" => NULL,
        "BUSS_ID" => NULL,
        "DB_HOST" => NULL,
        "DB_USERNAME" => NULL,
        "DB_NAME" => NULL,
        "DB_PASSWORD" => NULL,
        "STATUS" => 'error'
    );
    $_SESSION["distributor"] = array(
        "id" => NULL,
        "name" => 'Distributor',
        "oname" => 'Madmec',
        "email" => NULL,
        "dir" => NULL,
        "addrs" => NULL,
        "photo" => USER_ANON_IMAGE
    );
    $query = 'SELECT a.*,
                    CASE WHEN  a.`user_type_id`=10
                                THEN 10
                                ELSE
                                DATEDIFF(v.expiry_date,CURRENT_DATE)  END AS expiry_date  ,
					   CASE WHEN p.`ver2` IS NULL
							THEN "' . USER_ANON_IMAGE . '"
							ELSE CONCAT("' . URL . ASSET_DIR . '",p.`ver2`)
					   END AS photo,
					   ut.`user_type` AS user_type,
					   distributor.*,
                                           p.id as photoidd
				FROM `user_profile` AS a
				LEFT JOIN `photo` AS p ON p.`id` = a.`photo_id`
                                LEFT JOIN `validity` v
                                ON v.`user_pk`=a.`id`
				LEFT JOIN `user_type` AS ut ON ut.`id` = a.`user_type_id`
				LEFT JOIN (
					SELECT  a.`id` AS busns_id,
							a.`user_name` AS busns_name,
							a.`owner_name` AS busns_owner,
							a.`email` AS busns_email,
							a.`directory` AS busns_directory,
							CONCAT(
								CASE WHEN (a.`addressline` IS NULL OR a.`addressline` = "" )
									THEN "Not provided"
									ELSE a.`addressline`
								END,"☻♥☻",
								CASE WHEN (a.`town` IS NULL OR a.`town` = "" )
									THEN "Not provided"
									ELSE a.`town`
								END,"☻♥☻",
								CASE WHEN (a.`city` IS NULL OR a.`city` = "" )
									THEN "Not provided"
									ELSE a.`city`
								END,"☻♥☻",
								CASE WHEN (a.`district` IS NULL OR a.`district` = "" )
									THEN "Not provided"
									ELSE a.`district`
								END,"☻♥☻",
								CASE WHEN (a.`province` IS NULL OR a.`province` = "" )
									THEN "Not provided"
									ELSE a.`province`
								END,"☻♥☻",
								CASE WHEN (a.`province_code` IS NULL OR a.`province_code` = "" )
									THEN NULL
									ELSE a.`province_code`
								END,"☻♥☻",
								CASE WHEN (a.`country` IS NULL OR a.`country` = "" )
									THEN "Not provided"
									ELSE a.`country`
								END,"☻♥☻",
								CASE WHEN (a.`country_code` IS NULL OR a.`country_code` = "" )
									THEN NULL
									ELSE a.`country_code`
								END,"☻♥☻",
								CASE WHEN (a.`zipcode` IS NULL OR a.`zipcode` = "" )
									THEN "Not provided"
									ELSE a.`zipcode`
								END,"☻♥☻",
								CASE WHEN (a.`website` IS NULL OR a.`website` = "" )
									THEN "Not provided"
									ELSE a.`website`
								END,"☻♥☻",
								CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
									THEN "---"
									ELSE a.`postal_code`
								END,"☻♥☻",
								CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
									THEN "Not provided"
									ELSE a.`telephone`
								END,"☻♥☻"
							) AS busns_addrs,
							CASE WHEN p.`ver2` IS NULL
								THEN "' . USER_ANON_IMAGE . '"
								ELSE CONCAT("' . URL . ASSET_DIR . '",p.`ver2`)
							END AS busns_logo
					FROM `user_profile` AS a
					LEFT JOIN `photo` AS p ON p.`id` = a.`photo_id`
					WHERE  a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
															`statu_name` = "Hide" OR
															`statu_name` = "Delete" OR
															`statu_name` = "Fired" OR
															`statu_name` = "Inactive" OR
															`statu_name` = "Flag"))
				) AS distributor ON distributor.`busns_id` = a.`business_id`
				WHERE a.`user_name`="' . mysql_real_escape_string($parameters["user_name"]) . '"
				AND a.`password`="' . mysql_real_escape_string($parameters["password"]) . '"
				AND ut.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name`="Show" AND status=1)
				AND a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
															`statu_name` = "Hide" OR
															`statu_name` = "Delete" OR
															`statu_name` = "Fired" OR
															`statu_name` = "Inactive" OR
															`statu_name` = "Flag"));';
    $res = executeQuery($query);
    if (get_resource_type($res) == 'mysql result') {
        if (mysql_num_rows($res) > 0) {
            $row = mysql_fetch_assoc($res);
            if (isset($row["user_name"]) && isset($row["password"])) {
                if ($row["user_name"] == $parameters["user_name"] && $row["password"] == $parameters["password"]
                ) {

                    if ($row['expiry_date'] < 0) {
                        $userdata = array(
                            "USER_EMAIL" => NULL,
                            "USER_PASS" => NULL,
                            "USER_ID" => NULL,
                            "USER_NAME" => NULL,
                            "USER_PHOTO" => NULL,
                            "USER_TYPE" => NULL,
                            "BUSS_ID" => NULL,
                            "DB_HOST" => NULL,
                            "DB_USERNAME" => NULL,
                            "DB_NAME" => NULL,
                            "DB_PASSWORD" => NULL,
                            "STATUS" => 'expired'
                        );
                    } else {
                        $userdata = array(
                            "USER_EMAIL" => $row["email"],
                            "USER_PASS" => $row["password"],
                            "USER_ID" => $row["id"],
                            "USER_NAME" => $row["user_name"],
                            "USER_PHOTO" => $row["photo"],
                            "USER_TYPE" => $row["user_type"],
                            "BUSS_ID" => $row["business_id"],
                            "DB_HOST" => $row["db_host"],
                            "DB_USERNAME" => $row["db_username"],
                            "DB_NAME" => $row["db_name"],
                            "DB_PASSWORD" => $row["db_password"],
                            "PHOTO_IDD" => $row["photoidd"],
                            "DIR_PATH" => $row["directory"],
                            "STATUS" => 'success'
                        );
                    }
                    if (isset($row["business_id"]) && $row["business_id"] != NULL) {
                        $_SESSION["distributor"] = array(
                            "id" => $row["busns_id"],
                            "name" => $row["busns_name"],
                            "oname" => $row["busns_owner"],
                            "email" => $row["busns_email"],
                            "dir" => $row["busns_directory"],
                            "addrs" => $row["busns_addrs"],
                            "photo" => $row["busns_logo"]
                        );
                    }
                    updateUserlog($parameters, $row["id"]);
                } else if ($row["user_name"] == $parameters["user_name"] && $row["password"] != $parameters["password"]) {
                    $userdata = array(
                        "USER_EMAIL" => NULL,
                        "USER_PASS" => $parameters["password"],
                        "USER_ID" => NULL,
                        "USER_NAME" => $parameters["user_name"],
                        "USER_PHOTO" => NULL,
                        "USER_TYPE" => NULL,
                        "BUSS_ID" => NULL,
                        "DB_HOST" => $row["db_host"],
                        "DB_USERNAME" => $row["db_username"],
                        "DB_NAME" => $row["db_name"],
                        "DB_PASSWORD" => $row["db_password"],
                        "STATUS" => 'password'
                    );
                }
            }
        }
    }
    $_SESSION["USER_LOGIN_DATA"] = $userdata;
    return $userdata;
}

function updateUserlog($parameters, $id) {
    if(isset($_SESSION["IP_INFO"]["status"]) && $_SESSION["IP_INFO"]["status"] != 'fail') {
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
}

if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') {
    global $parameters;
    main($parameters);
}
?>