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
define("MAILPORT",587);
define("MAILHOST","208.91.199.224");
define("MAILUSER", "gift11@madmec.com");
define("MAILPASS", "splasher777@");
define("MODULE_ZEND_1", "Zend/Mail.php");
define("MODULE_ZEND_2", "Zend/Mail/Transport/Smtp.php");

define("INC", "inc/");
define("INC_MOD", INC . "modules/");
define("INC_SUPMOD", INC . "superadmin/");
define("INC_VENDOR", INC . "vendor/");
define("INC_USER", INC . "user/");
define("CLASSES", "classes/");
define("SUPERADMIN", "superadmin/");
define("VENDOR_MOD", "vendor/");
define("USER_MOD", "user/");


/* defining modules for each html file */
define("DASHBOARD_Admin", DOC_ROOT . INC_SUPMOD . "dashboard.html");
define("DASHBOARD_Vend", DOC_ROOT . INC_VENDOR . "dashboard.html");
define("DASHBOARD_User", DOC_ROOT . INC_USER . "dashboard.html");
define("VEHICLETYPE", DOC_ROOT . INC_SUPMOD . "vehicletype.html");
define("VEHICLEMODEL", DOC_ROOT . INC_SUPMOD . "vehiclemodel.html");
define("VEHICLEMAKE", DOC_ROOT . INC_SUPMOD . "vehiclemake.html");
define("VENDOR", DOC_ROOT . INC_SUPMOD . "vendor.html");
define("USERS", DOC_ROOT . INC_SUPMOD . "users.html");
define("COMPLAINTS", DOC_ROOT . INC_SUPMOD . "complaints.html");
define("CHANGEPASSWORD", DOC_ROOT . INC_SUPMOD . "changepassword.html");
define("REPORT", DOC_ROOT . INC_SUPMOD . "report.html");

define("VEN_APPOINTMENT", DOC_ROOT . INC_VENDOR . "appointment.html");
define("VEN_CONFIGURE", DOC_ROOT . INC_VENDOR . "configure.html");
define("VEN_UPCOMING", DOC_ROOT . INC_VENDOR . "upcoming.html");
define("VEN_INLINE", DOC_ROOT . INC_VENDOR . "inline.html");
define("VEN_COMPL", DOC_ROOT . INC_VENDOR . "completed.html");
define("VEN_REPORT", DOC_ROOT . INC_VENDOR . "report.html");
define("VENDOR_PROFILE", DOC_ROOT . INC_VENDOR . "vendorprofile.html");

define("USER_APPOINTMENT", DOC_ROOT . INC_USER . "appopintment.html");
define("USER_VEHICLE", DOC_ROOT . INC_USER . "vehicle.html");
define("USER_HISTORY", DOC_ROOT . INC_USER . "history.html");
define("USER_PROFILE", DOC_ROOT . INC_USER . "userprofile.html");
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

/* XLS FILE CONSTANT */
define('EXCEL_NAME', "NAME");
define('EXCEL_GENDER', "GENDER");
define('EXCEL_DOB', "DOB");
define('EXCEL_MOBILE', "MOBILE");
define('EXCEL_EMAIL', "EMAIL");
define('EXCEL_OCCUPATION', "OCCUPATION");
define('EXCEL_ACCESS_ID', "ACS ID");

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

        $query = 'SELECT *,up.`id` as userid
		FROM `user_profile` up
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

// Change the redirection url
function createdirectories($directory) {
    // LOCAL VARIABLES DECLARAION
    //Conditional flags
    $flag = false;
    $i = 0;
    $temp = '';
    // Get current user directory
    $temp = getCurrUserDir();
    $temp = explode(";", $temp);
    $curr_dir = $temp[0];
    $curr_num = $temp[1];
    $i = Number_directories(DOC_ROOT . ASSET_DIR . $curr_dir);
    if ($i < 100001) {
        $sruct_array = array(
            DOC_ROOT . ASSET_DIR . "$curr_dir/$directory/",
            DOC_ROOT . ASSET_DIR . "$curr_dir/$directory/temp/",
            DOC_ROOT . ASSET_DIR . "$curr_dir/$directory/profile/",
            DOC_ROOT . ASSET_DIR . "$curr_dir/$directory/profile/temp");
    } else {
        $curr_num++;
        $curr_dir = "res_" . $curr_num;
        createDirectory(DOC_ROOT . ASSET_DIR . $curr_dir);
        file_put_contents(DOC_ROOT . ASSET_DIR . $curr_dir . "/index.php", "<?php header('Location:" . URL . "'); ?>");
        $sruct_array = array(
            DOC_ROOT . ASSET_DIR . "$curr_dir/$directory/temp/",
            DOC_ROOT . ASSET_DIR . "$curr_dir/$directory/profile/",
            DOC_ROOT . ASSET_DIR . "$curr_dir/$directory/profile/temp");
    }
    createDirectory(DOC_ROOT . ASSET_DIR . $curr_dir);
    file_put_contents(DOC_ROOT . ASSET_DIR . $curr_dir . "/index.php", "<?php header('Location:" . URL . "'); ?>");
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
                if (!mkdir($sruct_array[$i], 0755, true) && !is_dir($sruct_array[$i])) {
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
    $i = 2;
    $dir = DOC_ROOT . ASSET_DIR;
    $curr = '';
    $total = 0;
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while ($file = readdir($dh)) {
                if (is_dir($dir . $file)) {
                    $curr = "res_" . $i;
                    if ($file == "." || $file == ".." || $file == "css" || $file == "js" || $file == "images")
                        continue;
                    if ($file == $curr)
                        $i++;
                    if ($file != $curr) {
                        $i--;
                        $curr = "res_" . $i;
                        break;
                    }
                }
            }
        }
        closedir($dh);
    }
    $curr = $curr . ";" . $i;
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

?>
