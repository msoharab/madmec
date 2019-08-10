<?php
require_once('var_config.php');
date_default_timezone_set('Asia/Kolkata');
$temp = explode("/", rtrim($_SERVER['DOCUMENT_ROOT'], "/"));
$doc_path = $_SERVER['DOCUMENT_ROOT'] . "/";
$libroot = str_replace($temp[count($temp) - 1], "library", $_SERVER['DOCUMENT_ROOT']) . "/";
define("DOC_ROOT", $doc_path);
define("LIB_ROOT", $libroot);
/* BIGROCK HOST */
define("BIGROCK", "208.91.199.224");
/* BIGROCK PORT */
define("BIGROCK_PORT", 587);
/* GMAIL HOST */
define("GMAIL", "smtp.gmail.com");
/* GMAIL PORT */
define("GMAIL_PORT", 587);
/* MADMEC HOST */
define("MADMEC", "182.18.131.149");
/* MADMEC PORT */
define("MADMEC_PORT", 465);
define("IMG_CONST", 400);
define("MAILUSER", "gift11@madmec.com");
define("MAILPASS", "splasher777@");
define("MODULE_ZEND_1", "Zend/Mail.php");
define("MODULE_ZEND_2", "Zend/Mail/Transport/Smtp.php");
define("DIRS", "appDirectories/");
define("INC", "inc/");
define("INC_MOD", INC . "modules/");
define("INC_SUPMOD", INC . "superadminmodule/");
define("INC_CUST", INC . "/customer/");
define("CLASSES",  "classes/");
define("CUSTOMER",  "customer/");
/* defining modules for each html file */
define("MOD_CLIENT", DOC_ROOT . INC_MOD . "client.html");
define("MOD_CLUBSELECT", DOC_ROOT . INC_MOD . "club_select.html");
define("MOD_DASHBOARD", DOC_ROOT . INC_MOD . "club_dashboard.html");
define("MOD_APROFILE", DOC_ROOT . INC_MOD . "admin_profile.html");
//enquiry
define("MOD_ENQADD", DOC_ROOT . INC_MOD . "enquiry_add.html");
define("MOD_ENQFLW", DOC_ROOT . INC_MOD . "enquiry_follow.html");
define("MOD_ENQLIST", DOC_ROOT . INC_MOD . "enquiry_listall.html");
//customer
define("MOD_CUSTADD", DOC_ROOT . INC_MOD . "customer_add.html");
define("MOD_CUSTLIST", DOC_ROOT . INC_MOD . "customer_list.html");
define("MOD_CUSTIMPT", DOC_ROOT . INC_MOD . "customer_import.html");
define("MOD_GRPADD", DOC_ROOT . INC_MOD . "group_add.html");
define("MOD_GRPLIST", DOC_ROOT . INC_MOD . "group_list.html");
//trainer
define("MOD_TRAADD", DOC_ROOT . INC_MOD . "trainers_add.html");
define("MOD_TRALIST", DOC_ROOT . INC_MOD . "trainers_list.html");
define("MOD_TRAPAY", DOC_ROOT . INC_MOD . "trainer_pay.html");
define("MOD_TRAIMPT", DOC_ROOT . INC_MOD . "trainers_import.html");
//manage
define("MOD_MNGFACILITY", DOC_ROOT . INC_MOD . "manage_add_facility.html");
define("MOD_MNGADDOFR", DOC_ROOT . INC_MOD . "manage_add_offer.html");
define("MOD_MNGLISTOFR", DOC_ROOT . INC_MOD . "manage_list_offer.html");
define("MOD_MNGADDPACK", DOC_ROOT . INC_MOD . "manage_add_package.html");
define("MOD_MNGLISTPACK", DOC_ROOT . INC_MOD . "manage_list_package.html");
//attendance
define("MOD_MNGATTEN", DOC_ROOT . INC_MOD . "attendance.html");
//account
define("MOD_ACCPACKFEE", DOC_ROOT . INC_MOD . "acc_package_fee.html");
define("MOD_ACCFCTFEE", DOC_ROOT . INC_MOD . "acc_facility_fee.html");
define("MOD_ACCDUEBAL", DOC_ROOT . INC_MOD . "acc_due_balance.html");
define("MOD_ACCSTFPAY", DOC_ROOT . INC_MOD . "acc_staff_payment.html");
define("MOD_ACCEXP", DOC_ROOT . INC_MOD . "acc_expenses.html");
//stats
define("MOD_STSACC", DOC_ROOT . INC_MOD . "stats_accounts.html");
define("MOD_STSREG", DOC_ROOT . INC_MOD . "stats_registrations.html");
define("MOD_STSTRA", DOC_ROOT . INC_MOD . "stats_trainers.html");
define("MOD_STSCUST", DOC_ROOT . INC_MOD . "stats_customers.html");
//reprort
define("MOD_REPCLUB", DOC_ROOT . INC_MOD . "report_club.html");
define("MOD_REPPACK", DOC_ROOT . INC_MOD . "report_package.html");
define("MOD_REPREG", DOC_ROOT . INC_MOD . "report_registrations.html");
define("MOD_REPPAY", DOC_ROOT . INC_MOD . "report_payments.html");
define("MOD_REPEXP", DOC_ROOT . INC_MOD . "report_expenses.html");
define("MOD_REPBAL", DOC_ROOT . INC_MOD . "report_balancesheet.html");
define("MOD_REPCUST", DOC_ROOT . INC_MOD . "report_customers.html");
define("MOD_REPEMP", DOC_ROOT . INC_MOD . "report_employee.html");
define("MOD_REPREC", DOC_ROOT . INC_MOD . "report_receipts.html");
//CRM
define("MOD_CRMMOB", DOC_ROOT . INC_MOD . "crm_mobileapp.html");
define("MOD_CRMFEED", DOC_ROOT . INC_MOD . "crm_feedbacks.html");
//Add Gym

define("MOD_ADDGYM", DOC_ROOT . INC_MOD . "add_gym.html");
//userrequest
define("MOD_USERREQUEST", DOC_ROOT . INC_MOD . "userrequest.html");
define("MOD_CUSTREQUEST", DOC_ROOT . INC_MOD . "custrequest.html");
define("MOD_OWNERUSER", DOC_ROOT . INC_MOD . "owneruser.html");
//SuperAdmin Modules
define("SU_MOD_ENQADD", DOC_ROOT . INC_SUPMOD . "enquiry_add.html");
define("SU_MOD_ENQFLW", DOC_ROOT . INC_SUPMOD . "enquiry_follow.html");
define("SU_MOD_ENQLIST", DOC_ROOT . INC_SUPMOD . "enquiry_listall.html");
define("SU_MOD_SENT_CREDENTIALS", DOC_ROOT . INC_SUPMOD . "sentcredentials.html");
define("SU_MODULE_ADMINCOLLECTION", DOC_ROOT . INC_SUPMOD . "admincollection.html");
define("SU_MODULE_NOTIFY", DOC_ROOT . INC_SUPMOD . "notify.html");
define("SU_MODULE_FOLLOWUP", DOC_ROOT . INC_SUPMOD . "orderfollowups.html");
define("SU_MODULE_DUEFOLLOWUP", DOC_ROOT . INC_SUPMOD . "duefallowups.html");
define("SU_MODULE_DUE", DOC_ROOT . INC_SUPMOD . "dueadmin.html");
define("SU_MOD_SMS", DOC_ROOT . INC_SUPMOD . "sms.html");
define("CUST_SEARCHGYM", DOC_ROOT . INC_CUST . "searchgym.html");
//-----
define("DOWNLOADS", "downloads/");
define("UPLOADS", "uploads/");
define("ASSET_DIR", "assets/");
define("ASSET_JSF", "assets/js/");
define("ASSET_CSS", "assets/css/");
define("ASSET_IMG", "assets/images/");
define("ASSET_JQF", "jQuery/");
define("ASSET_TAM", "tamboola/");
define("ASSET_BSF", "bootstrap/");
define("ICON_THEME", "set1/");
// define("ICON_THEME","set2/");
define("DGYM_ID", "#printrs");
define("LOGO_1", URL . ASSET_IMG . ASSET_TAM . "logo-1.png");
define("REG_FEE", 500);
define("START_DATE", "2014-02-03");
define("ST_PER", 0.1236);
define("CELL_CODE", "+91");
define("CURRENCY_SYM_1X", "<i class='fa fa-inr'></i>");
define("CURRENCY_SYM_2X", "<i class='fa fa-inr fa-2x'></i>");
define("CURRENCY_SYM_3X", "<i class='fa fa-inr fa-3x'></i>");
define("CURRENCY_SYM_4X", "<i class='fa fa-inr fa-4x'></i>");
define("CURRENCY_SYM_5X", "<i class='fa fa-inr fa-5x'></i>");
define("GYM_LOGO", URL . ASSET_IMG . "short-logo.jpg");
/* XLS FILE CONSTANT */
define('EXCEL_NAME', "NAME");
define('EXCEL_GENDER', "GENDER");
define('EXCEL_DOB', "DOB");
define('EXCEL_MOBILE', "MOBILE");
define('EXCEL_EMAIL', "EMAIL");
define('EXCEL_OCCUPATION', "OCCUPATION");
define('EXCEL_ACCESS_ID', "ACS ID");
$bootstrapProperties = array(
    "pageheader_color" => "text-primary",
    "panel_color" => ""
);
//Customer constraints
define("USER_ANON_IMAGE", URL . ASSET_IMG . "anonymous.png");
// define("USER_ANON_IMAGE", URL . ASSET_IMG . ICON_THEME . "customer.png");
//gym constraints
define("GYM_ANON_IMAGE", URL . ASSET_IMG . ICON_THEME . "gymlogo.png");
//Admin constraints
define("ADMIN_ANON_IMAGE", URL . ASSET_IMG . ICON_THEME . "administrator.png");
//Trainer constraints
define("TRAIN_ANON_IMAGE", URL . ASSET_IMG . ICON_THEME . "trainer.png");

define("GYMNAME",isset($_SESSION["SETGYM"]["GYM_NAME"])	?	$_SESSION["SETGYM"]["GYM_NAME"] : "SELECT GYM");
//80,755,775,1237
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
        $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"] = array(
            "GYM_ID" => NULL,
            "GYM_IND" => NULL,
            "GYM_NAME" => NULL,
            "GYM_HOST" => NULL,
            "GYM_USERNAME" => NULL,
            "GYM_DB_NAME" => NULL,
            "GYM_DB_PASSWORD" => NULL
        );
        $query = 'SELECT *
		FROM `user_profile`
		WHERE
		`email_id`=\'' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_EMAIL"]) . '\'
		AND
		`password`=\'' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_PASS"]) . '\';';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $row = mysql_fetch_assoc($res);
            $query1 = 'select t.`type`
				from `user_type` as t
				join `userprofile_type` as utp
				on t.`id`=utp.`usertype_id`
				join `user_profile` as up
				on utp.`user_pk`=\'' . $row["id"] . '\'
				WHERE
				t.`status`=(SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND status=1)
				group by t.`type`;';
            $res1 = executeQuery($query1);
            if (get_resource_type($res1) == 'mysql result') {
                if (mysql_num_rows($res1) > 0) {
                    $row1 = mysql_fetch_assoc($res1);
                    $_SESSION["USER_LOGIN_DATA"] = array(
                        "USER_EMAIL" => $row["email_id"],
                        "USER_PASS" => $row["password"],
                        "USER_ID" => $row["id"],
                        "USER_NAME" => $row["user_name"],
                        "USER_TYPE" => $row1["type"],
                        "GYM_DETAILS" => array(),
                        "STATUS" => 'success'
                    );
                    if ($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "Admin" || $_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "Owner") {
                        $query = 'SELECT g.*
					FROM `gym_profile` AS g
					JOIN `userprofile_gymprofile` AS ug ON g.`id`=ug.`gym_id`
					JOIN user_profile AS u ON ug.`user_pk`=\'' . $row["id"] . '\'
					WHERE ug.`status`=(SELECT `id` FROM `status` WHERE `statu_name`=\'Active\' AND status=1)
                                        AND g.status=4
					GROUP BY g.`gym_name`;';
                        $res = executeQuery($query);
                        if (get_resource_type($res) == 'mysql result') {
                            if (mysql_num_rows($res) > 0) {
								$cont = -1;
                                while ($row = mysql_fetch_assoc($res)) {
                                    $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][] = array(
                                        "GYM_ID" => $row["id"],
                                        "GYM_IND" => ++$cont,
                                        "GYM_NAME" => $row["gym_name"],
                                        "GYM_HOST" => $row["db_host"],
                                        "GYM_USERNAME" => $row["db_username"],
                                        "GYM_DB_NAME" => $row["db_name"],
                                        "GYM_DB_PASSWORD" => $row["db_password"]
                                    );
                                }
                                $_SESSION["SETGYM"] = array(
                                    "GYM_ID" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_SESSION["SETGYM"]["GYM_IND"]]["GYM_ID"],
                                    "GYM_IND" => $_SESSION["SETGYM"]["GYM_IND"],
                                    "GYM_NAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_SESSION["SETGYM"]["GYM_IND"]]["GYM_NAME"],
                                    "GYM_HOST" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_SESSION["SETGYM"]["GYM_IND"]]["GYM_HOST"],
                                    "GYM_USERNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_SESSION["SETGYM"]["GYM_IND"]]["GYM_USERNAME"],
                                    "GYM_DB_NAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_SESSION["SETGYM"]["GYM_IND"]]["GYM_DB_NAME"],
                                    "GYM_DB_PASSWORD" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_SESSION["SETGYM"]["GYM_IND"]]["GYM_DB_PASSWORD"]
                                );
                            }
                        }
                    }
                    $flag = true;
                }
            }
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
function getUserTypeId($usertype = false) {
    $statname = ucfirst($usertype);
    $res = executeQuery('SELECT `id` FROM `user_type` WHERE `type` ="' . $usertype . '";');
    $row = mysql_fetch_assoc($res);
    return $row["id"];
}
function fetchAddress($gymid = false) {
    $gname = "";
    $gympic = '';
    $address = "";
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $query = 'SELECT
					ur.*,
					CASE WHEN ur.`photo_id` IS NULL OR ur.`photo_id`=""
						 THEN \'' . GYM_ANON_IMAGE . '\'
						 ELSE CONCAT(\'' . URL . ASSET_DIR . '\',ph3.`ver3`)
					END AS photo
				FROM `gym_profile` AS ur
				LEFT JOIN `gym_photo` AS ph3 ON ur.`photo_id` = ph3.`id`
				WHERE ur.`id`=\'' . mysql_real_escape_string($gymid) . '\';';
            $res = executeQuery($query);
            if (get_resource_type($res) == 'mysql result') {
                if (mysql_num_rows($res) > 0) {
                    $row = mysql_fetch_assoc($res);
                    $address .= "<table border='0' >
								<tr>
									<td  valign='top'>
									<span style='font-size:17px;color:#666;'>Address</span>
										<br />
										" . $row['gym_name'] . ",
										" . $row['addressline'] . ",
										" . $row['city'] . " - " . $row['zipcode'] . "
										<br />
										ph:-" . $row['cell_number'] . "
										<br />
										email:- " . $row['email'] . "
										<br />
										website: -" . $row['website'] . "
									</td>
								</tr>
							</table>";
                    $gympic = $row["photo"];
                    $gname = $row["gym_name"];
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    $gymDATA = array(
        "gympic" => $gympic,
        "add" => $address,
        "gname" => $gname,
    );
    return $gymDATA;
}
function convert_number_to_words($number) {
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'fourty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    if (!is_numeric($number)) {
        return false;
    }
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
        );
        return false;
    }
    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    $string = $fraction = null;
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}
function convertNumberToWordsForIndia($number) {
    //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
    $words = array(
        '0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five',
        '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten',
        '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fouteen', '15' => 'fifteen',
        '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'fourty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninty');
    //First find the length of the number
    $number_length = strlen($number);
    //Initialize an empty array
    $number_array = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
    $received_number_array = array();
    //Store all received numbers into an array
    for ($i = 0; $i < $number_length; $i++) {
        $received_number_array[$i] = substr($number, $i, 1);
    }
    //Populate the empty array with the numbers received - most critical operation
    for ($i = 9 - $number_length, $j = 0; $i < 9; $i++, $j++) {
        $number_array[$i] = $received_number_array[$j];
    }
    $number_to_words_string = "";
    //Finding out whether it is teen ? and then multiplying by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
    for ($i = 0, $j = 1; $i < 9; $i++, $j++) {
        if ($i == 0 || $i == 2 || $i == 4 || $i == 7) {
            if ($number_array[$i] == "1") {
                $number_array[$j] = 10 + $number_array[$j];
                $number_array[$i] = 0;
            }
        }
    }
    $value = "";
    for ($i = 0; $i < 9; $i++) {
        if ($i == 0 || $i == 2 || $i == 4 || $i == 7) {
            $value = $number_array[$i] * 10;
        } else {
            $value = $number_array[$i];
        }
        if ($value != 0) {
            $number_to_words_string.= $words["$value"] . " ";
        }
        if ($i == 1 && $value != 0) {
            $number_to_words_string.= "Crores ";
        }
        if ($i == 3 && $value != 0) {
            $number_to_words_string.= "Lakhs ";
        }
        if ($i == 5 && $value != 0) {
            $number_to_words_string.= "Thousand ";
        }
        if ($i == 6 && $value != 0) {
            $number_to_words_string.= "Hundred &amp; ";
        }
    }
    if ($number_length > 9) {
        $number_to_words_string = "Sorry This does not support more than 99 Crores";
    }
    return ucwords(strtolower("Indian Rupees " . $number_to_words_string) . " Only.");
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
				if(is_dir($dir . $file)){
					if ($file != "." && $file != ".." && $file == $curr && file_exists($dir . $file . $curr) && is_dir($dir . $file . $curr)) {
						$num = Number_directories($dir . $file . $curr);
						if($num > 9999){
							$i++;
							continue;
						}
					}
				}
            }
        }
        closedir($dh);
    }
    // $curr = $curr . ";" . $i;
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
    if(isset($_SESSION["IP_INFO"]["status"]) && $_SESSION["IP_INFO"]["status"] != 'fail') {
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