<?php
require_once('var_config.php');
//include_once('mysql2i.class.php');
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
define("MODULE_ZEND_1", "Zend/Mail.php");
define("MODULE_ZEND_2", "Zend/Mail/Transport/Smtp.php");
define("LAND_PAGE", URL . "control.php");
define("ERROR_000", URL . "error/page_000.php");
define("ERROR_402", URL . "error/page_402.php");
define("ERROR_404", URL . "error/page_402.php");
define("ERROR_505", URL . "error/page_402.php");
define("INC", "inc/");
define("INC_MOD", INC . "modules/");

/* defining modules for each html file */
define("MOD_USER", DOC_ROOT . INC_MOD . "user.html");
define("MOD_PRODUCT", DOC_ROOT . INC_MOD . "product.html");
define("MOD_SALES", DOC_ROOT . INC_MOD . "sales.html");
define("MOD_PURCHASE", DOC_ROOT . INC_MOD . "purchase.html");
define("MOD_PAYMENT", DOC_ROOT . INC_MOD . "payment.html");
define("MOD_DUES", DOC_ROOT . INC_MOD . "dues.html");
define("MOD_COLLECTION", DOC_ROOT . INC_MOD . "collection.html");
define("MOD_SIGNOUT", DOC_ROOT . INC_MOD . "signout.html");
define("MOD_PROFILE", DOC_ROOT . INC_MOD . "profile.html");
define("MOD_ORDFOLUPS", DOC_ROOT . INC_MOD . "orderfollowups.html");
define("MOD_NOTIFY", DOC_ROOT . INC_MOD . "notify.html");
define("MOD_CLIENT", DOC_ROOT . INC_MOD . "client.html");
define("MOD_ADMINPAYMENT", DOC_ROOT . INC_MOD . "admincollection.html");
define("MOD_ADMINDUES", DOC_ROOT . INC_MOD . "dueadmin.html");
define("MOD_ADMINFOLLOWUP", DOC_ROOT . INC_MOD . "duefallowups.html");
define("MOD_BILLLIST", DOC_ROOT . INC_MOD . "billlist.html");
define("MOD_SALE", DOC_ROOT . INC_MOD . "sale.html");
define("MOD_Setting", DOC_ROOT . INC_MOD . "setting.html");

define("DOWNLOADS", "downloads/");
define("UPLOADS", "uploads/");
define("ASSET_DIR", "assets/");
define("ASSET_JSF", "assets/js/");
define("ASSET_IMG", "assets/images/");
define("ASSET_CSS", "assets/css/");
define("JSF_AUTOTRADE", "autotrade/");
define("JSF_JQUERY", "jQuery/");
define("JSF_JPEGCAM", "jpegcam/");
define("PLUGINS", "plugins/");
define("DATATABLES", "dataTables/");
define("FLOT", "flot/");
define("METISMENU", "metisMenu/");
define("MORRIS", "morris/");
// define("FONT","font-awesome-4.1.0/css/");
define("FONT", "font-awesome-4.2.0/css/");
define("SOFT_NAME", "AutoTRADE");
/* Customer constraints */
define("LOGO_IMAGE", URL . ASSET_IMG . "logo.png");
define("USER_ANON_IMAGE", URL . ASSET_IMG . "user.png");
define("VEGIE_IMAGE", URL . ASSET_IMG . "vege.png");
function generateRandomString($length = 6) {
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    if (strlen($randomString) > 5)
        return $randomString;
    else
        generateRandomString();
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
function getPackTypes() {
    $ptype = array();
    $jsonptype = array();
    $query = 'SELECT `id`, `packing_type` AS type FROM `packing_type` WHERE `status_id` = 4;';
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $ptype[] = $row;
        }
    }
    if (is_array($ptype))
        $num = count($ptype);
    if ($num) {
        for ($i = 0; $i < $num; $i++) {
            $jsonptype[] = array(
                "html" => '<option  value="' . $ptype[$i]["id"] . '" >' . ucfirst($ptype[$i]["type"]) . '</option>',
                "ptype" => $ptype[$i]["type"],
                "id" => $ptype[$i]["id"]
            );
        }
    }
    return $jsonptype;
}
function getCommisions() {
    $ctype = array();
    $jsonctype = array();
    $query = 'SELECT `id`, `percentage` AS type FROM `commission` WHERE `status_id` = 4;';
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $ctype[] = $row;
        }
    }
    if (is_array($ctype))
        $num = count($ctype);
    if ($num) {
        for ($i = 0; $i < $num; $i++) {
            $jsonctype[] = array(
                "html" => '<option  value="' . $ctype[$i]["id"] . '" >' . $ctype[$i]["type"] . '</option>',
                "ctype" => $ctype[$i]["type"],
                "id" => $ctype[$i]["id"]
            );
        }
    }
    return $jsonctype;
}
function getUserTypes() {
    $utype = NULL;
    $jsonutype = NULL;
    $num = 0;
    $query = 'SELECT `id`, `user_type` AS type FROM `user_type` WHERE `status_id` = 4 AND `id` != 3 AND `id` != 9;';
    // $query = 'SELECT `id`, `user_type` AS type FROM `user_type` WHERE `status_id` = 4;';
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $utype[] = $row;
        }
    }
    if (is_array($utype))
        $num = count($utype);
    if ($num) {
        for ($i = 0; $i < $num; $i++) {
            $jsonutype[] = array(
                "html" => '<option  value="' . $utype[$i]["id"] . '" >' . ucfirst($utype[$i]["type"]) . '</option>',
                "utype" => $utype[$i]["type"],
                "id" => $utype[$i]["id"]
            );
        }
    }
    return $jsonutype;
}
function getMOPTypes() {
    $moptype = NULL;
    $jsonmoptype = NULL;
    $num = 0;
    $query = 'SELECT `id`, `name` AS type FROM `mode_of_payment` WHERE `status_id` = 4;';
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $moptype[] = $row;
        }
    }
    if (is_array($moptype))
        $num = count($moptype);
    if ($num) {
        for ($i = 0; $i < $num; $i++) {
            $jsonmoptype[] = array(
                "html" => '<option  value="' . $moptype[$i]["id"] . '" >' . $moptype[$i]["type"] . '</option>',
                "moptype" => $moptype[$i]["type"],
                "id" => $moptype[$i]["id"]
            );
        }
    }
    return $jsonmoptype;
}
function getSAMOPTypes() {
    $moptype = NULL;
    $jsonmoptype = NULL;
    $num = 0;
    $query = 'SELECT `id`, `mop` AS type FROM `mode_of_payment` WHERE `status_id` = 4;';
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $moptype[] = $row;
        }
    }
    if (is_array($moptype))
        $num = count($moptype);
    if ($num) {
        for ($i = 0; $i < $num; $i++) {
            $jsonmoptype[] = array(
                "html" => '<option  value="' . $moptype[$i]["id"] . '" >' . $moptype[$i]["type"] . '</option>',
                "moptype" => $moptype[$i]["type"],
                "id" => $moptype[$i]["id"]
            );
        }
    }
    return $jsonmoptype;
}
function getProducts() {
    $products = array();
    $jsonproducts = array();
    $query = 'SELECT
                `id`,
                `name`,
                `photo_id`,
                `directory`,
                `doc`,
                `status_id`
        FROM `product`
        WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
        UNION DISTINCT
        SELECT
                `id`,
                `name`,
                `photo_id`,
                `directory`,
                `doc`,
                `status_id`
        FROM `product`
        WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1);';
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $products[] = $row;
        }
    }
    $total = count($products);
    if ($total) {
        for ($i = 0; $i < $total; $i++) {
            $jsonproducts[] = array("html" => '<option  value="' . $products[$i]["id"] . '" >' . $products[$i]["name"] . '</option>',
                "label" => $products[$i]["name"],
                "value" => $i,
                "id" => $products[$i]["id"],
                "name" => $products[$i]["name"]);
        }
        $_SESSION["list_of_users"] = $products;
    } else {
        $_SESSION["list_of_users"] = NULL;
    }
    return $jsonproducts;
}
function getPatty() {
    $pattys = array();
    $jsonpattys = array();
    $query = 'SELECT
        a.`id` AS pattyid,
        a.`from_pk`,
        a.`to_pk`,
        a.`product_id`,
        a.`vehicle_id`,
        DATE_FORMAT(a.`sales_date`,\'%Y-%m-%d\') AS sales_date,
        a.`patti_ref_no`,
        a.`total_packs` AS sal_totpck,
        a.`total_weight`,
        a.`balance`,
        b.`id` AS uid,
        b.`user_name`,
        b.`usrphoto`,
        b.`email`,
        b.`cnumber`,
        b.`bank_id`,
        b.`bank_name`,
        b.`ac_no`,
        b.`branch`,
        b.`branch_code`,
        b.`IFSC`,
        c.`id` AS prdid,
        c.`name`,
        c.`prdphoto`,
        d.`id` AS vhid,
        d.`consignee`,
        d.`driver`,
        d.`vehicle_no`,
        d.`packing_type` AS packtype,
        d.`total_packs` AS vh_totpck,
        d.`total_weight`,
        d.`loaded_weight`,
        d.`empty_weight`,
        d.`advance_amt`,
        d.`rent`,
        d.`arrival`,
        d.`departure`,
        e.`id` AS prchid,
        e.`from_pk`,
        e.`to_pk`,
        e.`sales_id`,
        e.`vehicle_id`,
        e.`product_id`,
        e.`patti_ref_no`,
        e.`patti_date`,
        e.`total_sale`,
        e.`total_exp`,
        e.`net_sales`,
        e.`location`,
        e.`lorry_hire`,
        e.`commision_cash`,
        e.`labour`,
        e.`association_fee`,
        e.`post_fee`,
        e.`total`,
        e.`packing_type`,
        e.`quantity`,
        e.`particulars`,
        e.`weight_kg`,
        e.`rate`,
        e.`amount`,
        f.`id` AS conid,
        f.`consignee`,
        f.`consignor`,
        f.`vehicle_id`,
        f.`product_id`,
        f.`purchase_id`,
        f.`sales_id`,
        f.`consignment_date`
        FROM `sales` AS a
        LEFT JOIN (
            SELECT
                a.`id`,
                a.`user_name`,
                a.`acs_id`,
                a.`directory`,
                a.`password`,
                CASE WHEN (a.`addressline` IS NULL OR a.`addressline` = "" )
                         THEN "Not provided"
                         ELSE a.`addressline`
                END AS addressline,
                CASE WHEN (a.`town` IS NULL OR a.`town` = "" )
                         THEN "Not provided"
                         ELSE a.`town`
                END AS town,
                CASE WHEN (a.`city` IS NULL OR a.`city` = "" )
                         THEN "Not provided"
                         ELSE a.`city`
                END AS city,
                CASE WHEN (a.`district` IS NULL OR a.`district` = "" )
                         THEN "Not provided"
                         ELSE a.`district`
                END AS district,
                CASE WHEN (a.`province` IS NULL OR a.`province` = "" )
                         THEN "Not provided"
                         ELSE a.`province`
                END AS province,
                CASE WHEN (a.`province_code` IS NULL OR a.`province_code` = "" )
                         THEN NULL
                         ELSE a.`province_code`
                END AS province_code,
                CASE WHEN (a.`country` IS NULL OR a.`country` = "" )
                         THEN "Not provided"
                         ELSE a.`country`
                END AS country,
                CASE WHEN (a.`country_code` IS NULL OR a.`country_code` = "" )
                         THEN NULL
                         ELSE a.`country_code`
                END AS country_code,
                CASE WHEN (a.`zipcode` IS NULL OR a.`zipcode` = "" )
                         THEN "Not provided"
                         ELSE a.`zipcode`
                END AS zipcode,
                CASE WHEN (a.`website` IS NULL OR a.`website` = "" )
                         THEN "Not provided"
                         ELSE a.`website`
                END AS website,
                CONCAT(
                        CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
                                 THEN "---"
                                 ELSE a.`postal_code`
                        END,
                        CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
                                 THEN "Not provided"
                                 ELSE a.`telephone`
                        END
                ) AS tnumber,
                CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "")
                         THEN "' . USER_ANON_IMAGE . '"
                         ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
                END AS usrphoto,
                a.`status_id`,
                b.`email` AS email,
                c.`cnumber` AS cnumber,
                d.`id` AS bank_id,
                d.`bank_name` AS bank_name,
                d.`ac_no` AS ac_no,
                d.`branch` AS branch,
                d.`branch_code` AS branch_code,
                d.`IFSC` AS IFSC,
                e.`name` AS prdname,
                e.`prdphoto` AS prdphoto,
                f.`user_type`,
                g.`gender_name`
            FROM `user_profile` AS a
            /* User photo */
            LEFT JOIN `photo` AS ph ON a.`photo_id` = ph.`id`
            /* User email */
            LEFT JOIN (
                SELECT
                        em.`id`,
                        GROUP_CONCAT(em.`email`,"??????") AS email,
                        em.`user_pk`
                FROM `email_ids` AS em
                WHERE em.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                GROUP BY (em.`user_pk`)
                ORDER BY (em.`user_pk`)
            )  AS b ON a.`id` = b.`user_pk`
            /* User cnumber */
            LEFT JOIN (
                SELECT
                        cn.`id`,
                        cn.`user_pk`,
                        GROUP_CONCAT(CONCAT(cn.`cell_code`,"-",cn.`cell_number`),"??????") AS cnumber
                FROM `cell_numbers` AS cn
                WHERE cn.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                GROUP BY (cn.`user_pk`)
                ORDER BY (cn.`user_pk`)
            ) AS c ON a.`id` = c.`user_pk`
            /* User bank account */
            LEFT JOIN (
                SELECT
                        ba.`id`,
                        ba.`user_pk`,
                        GROUP_CONCAT(ba.`bank_name`,"??????") AS bank_name,
                        GROUP_CONCAT(ba.`ac_no`,"??????") AS ac_no,
                        GROUP_CONCAT(
                                CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
                                         THEN "Not provided"
                                         ELSE ba.`branch`
                                END,"??????"
                        ) AS branch,
                        GROUP_CONCAT(
                                CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
                                         THEN "Not provided"
                                         ELSE ba.`branch_code`
                                END,"??????"
                        ) AS branch_code,
                        GROUP_CONCAT(
                                CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
                                         THEN "Not provided"
                                         ELSE ba.`IFSC`
                                END,"??????"
                        ) AS IFSC,
                        ba.`status_id`
                FROM `bank_accounts` AS ba
                WHERE ba.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                GROUP BY (ba.`user_pk`)
                ORDER BY (ba.`user_pk`)
            ) AS d ON a.`id` = d.`user_pk`
            /* User product */
            LEFT JOIN (
                SELECT
                        prd.`id`,
                        GROUP_CONCAT(prd.`name`,"??????") AS name,
                        GROUP_CONCAT(
                                CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
                                         THEN "' . VEGIE_IMAGE . '"
                                         ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
                                END,"??????"
                        ) AS prdphoto,
                        urpd.`user_pk`
                FROM `product` AS prd
                LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
                INNER JOIN `user_product` AS urpd ON prd.`id` = urpd.`product_id` AND urpd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                INNER JOIN `user_profile` AS up ON up.id = urpd.`user_pk` AND up.`status_id` = 1
                WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                GROUP BY (urpd.`user_pk`)
                ORDER BY (urpd.`user_pk`)
            ) AS e ON a.`id` = e.`user_pk`
            /* User type */
            LEFT JOIN (
                SELECT
                        utype.`id`,
                        utype.`user_type`
                FROM `user_type` AS utype
                WHERE utype.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            ) AS f ON a.`user_type_id` = f.`id`
            LEFT JOIN `gender` AS g ON a.`gender` = g.`id`
            WHERE (f.`id` !=  9)
            AND a.`status_id` = 1
            ORDER BY (a.`id`)
        ) AS b  ON b.`id` = a.`from_pk`
        /* sold product */
        LEFT JOIN (
            SELECT
                prd.`id`,
                prd.`name` AS name,
                CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
                         THEN "' . VEGIE_IMAGE . '"
                         ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
                END AS prdphoto
            FROM `product` AS prd
            LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
            WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
        ) AS c ON c.`id` = a.`product_id`
        /* vehicle */
        LEFT JOIN (
            SELECT
                    a.`id`,
                    a.`consignee`,
                    a.`driver`,
                    a.`vehicle_no`,
                    b.`packing_type`,
                    a.`total_packs`,
                    a.`total_weight`,
                    a.`loaded_weight`,
                    a.`empty_weight`,
                    a.`advance_amt`,
                    a.`rent`,
                    DATE_FORMAT(a.`arrival`,\'%d-%b-%Y\') AS arrival,
                    a.`departure`
            FROM `vehicle` AS a
            LEFT JOIN (
                    SELECT
                            `id`,
                            `packing_type`,
                            `remark`
                    FROM `packing_type`
                    WHERE `status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            ) AS b ON b.`id` = a.`packing_type_id`
            WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
        ) AS d ON d.`id` = a.`vehicle_id` AND  d.`consignee` = a.`from_pk`
        /* purchase */
        LEFT JOIN (
            SELECT
                    a.`id`,
                    a.`from_pk`,
                    a.`to_pk`,
                    a.`sales_id`,
                    a.`vehicle_id`,
                    a.`product_id`,
                    a.`packing_type_id`,
                    a.`patti_ref_no`,
                    DATE_FORMAT(a.`patti_date`,\'%d-%b-%Y\') AS patti_date,
                    a.`total_sale`,
                    a.`total_exp`,
                    a.`net_sales`,
                    a.`location`,
                    b.`lorry_hire`,
                    b.`commision_cash`,
                    b.`labour`,
                    b.`association_fee`,
                    b.`post_fee`,
                    b.`total`,
                    c.`packing_type`,
                    c.`quantity`,
                    c.`particulars`,
                    c.`weight_kg`,
                    c.`rate`,
                    c.`amount`
            FROM `purchase` AS a
            LEFT JOIN (
                    SELECT
                            a.`id`,
                            a.`purchase_id`,
                            a.`lorry_hire`,
                            a.`commision_id`,
                            a.`commision_cash`,
                            a.`labour`,
                            a.`association_fee`,
                            a.`post_fee`,
                            a.`total`,
                            b.`percentage`
                    FROM `purchase_expenses` AS a
                    LEFT JOIN (
                            SELECT
                                    `id`,
                                    `percentage`
                            FROM `commission`
                            WHERE `status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                    ) AS b ON a.`commision_id` = b.`id`
                    WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            ) AS b ON b.`purchase_id` = a.`id`
            LEFT JOIN (
                    SELECT
                            a.`id`,
                            a.`purchase_id`,
                            a.`product_id`,
                            GROUP_CONCAT(b.`packing_type`,"??????") AS packing_type,
                            GROUP_CONCAT(a.`quantity`,"??????") AS quantity,
                            GROUP_CONCAT(a.`particulars`,"??????") AS particulars,
                            GROUP_CONCAT(a.`weight_kg`,"??????") AS weight_kg,
                            GROUP_CONCAT(a.`rate`,"??????") AS rate,
                            GROUP_CONCAT(a.`amount`,"??????") AS amount
                    FROM `purchase_fields` AS a
                    LEFT JOIN (
                            SELECT
                                    `id`,
                                    `packing_type`,
                                    `remark`
                            FROM `packing_type`
                            WHERE `status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                    ) AS b ON b.`id` = a.`packing_type_id`
                    WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            ) AS c  ON c.`purchase_id` = a.`id`
            WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
        ) AS e ON e.`patti_ref_no` = a.`patti_ref_no` AND e.`sales_id` = a.`id`
        /* consignment */
        LEFT JOIN (
            SELECT
                `id`,
                `consignee`,
                `consignor`,
                `vehicle_id`,
                `product_id`,
                `purchase_id`,
                `sales_id`,
                `consignment_date`
            FROM `consignment`
        ) AS f ON f.`sales_id` = a.`id`
        WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
        /* AND a.`location` IS NULL */
        GROUP BY (a.`id`)
        ORDER BY (a.`id`) DESC;';
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $pattys[] = $row;
        }
    }
    $total = count($pattys);
    if ($total) {
        for ($i = 0; $i < $total; $i++) {
            $email = '';
            $cellnumber = '';
            $tnumber = '';
            $packing_type = '';
            $quantity = '';
            $particulars = '';
            $weight_kg = '';
            $rate = '';
            // d.`bank_id`,bank_id
            // b.`bank_name`,
            // b.`ac_no`,
            // b.`branch`,
            // b.`branch_code`,
            // b.`IFSC`,
            $pattys[$i]["email"] = explode("??????", $pattys[$i]["email"]);
            $pattys[$i]["cnumber"] = explode("??????", $pattys[$i]["cnumber"]);
            $pattys[$i]["packing_type"] = explode("??????", $pattys[$i]["packing_type"]);
            $pattys[$i]["quantity"] = explode("??????", $pattys[$i]["quantity"]);
            $pattys[$i]["particulars"] = explode("??????", $pattys[$i]["particulars"]);
            $pattys[$i]["weight_kg"] = explode("??????", $pattys[$i]["weight_kg"]);
            $pattys[$i]["rate"] = explode("??????", $pattys[$i]["rate"]);
            $pattys[$i]["bank_id"] = explode("??????", $pattys[$i]["bank_id"]);
            $pattys[$i]["bank_name"] = explode("??????", $pattys[$i]["bank_name"]);
            $pattys[$i]["ac_no"] = explode("??????", $pattys[$i]["ac_no"]);
            $pattys[$i]["branch"] = explode("??????", $pattys[$i]["branch"]);
            $pattys[$i]["branch_code"] = explode("??????", $pattys[$i]["branch_code"]);
            $pattys[$i]["IFSC"] = explode("??????", $pattys[$i]["IFSC"]);
            $email = (isset($pattys[$i]["email"][0]) && $pattys[$i]["email"][0] != '') ? $pattys[$i]["email"][0] : '';
            $cellnumber = (isset($pattys[$i]["cnumber"][0]) && $pattys[$i]["cnumber"][0] != '') ? $pattys[$i]["cnumber"][0] : '';
            $tnumber = (isset($pattys[$i]["tnumber"]) && $pattys[$i]["tnumber"] != '') ? $pattys[$i]["tnumber"] : '';
            for ($j = 0; $j < count($pattys[$i]["packing_type"]) && isset($pattys[$i]["packing_type"][$j]) && $pattys[$i]["packing_type"][$j] != ''; $j++) {
                // $packing_type .= ltrim($pattys[$i]["packing_type"][$j],",") . ' - ';
                $packing_type .= $pattys[$i]["packing_type"][$j];
            }
            for ($j = 0; $j < count($pattys[$i]["quantity"]) && isset($pattys[$i]["quantity"][$j]) && $pattys[$i]["quantity"][$j] != ''; $j++) {
                // $quantity .= ltrim($pattys[$i]["quantity"][$j],",") . ' - ';
                $quantity .= $pattys[$i]["quantity"][$j];
            }
            for ($j = 0; $j < count($pattys[$i]["particulars"]) && isset($pattys[$i]["particulars"][$j]) && $pattys[$i]["particulars"][$j] != ''; $j++) {
                // $particulars .= ltrim($pattys[$i]["particulars"][$j],",") . ' - ';
                $particulars .= $pattys[$i]["particulars"][$j];
            }
            for ($j = 0; $j < count($pattys[$i]["weight_kg"]) && isset($pattys[$i]["weight_kg"][$j]) && $pattys[$i]["weight_kg"][$j] != ''; $j++) {
                // $weight_kg .= ltrim($pattys[$i]["weight_kg"][$j],",") . ' - ';
                $weight_kg .= $pattys[$i]["weight_kg"][$j];
            }
            for ($j = 0; $j < count($pattys[$i]["rate"]) && isset($pattys[$i]["rate"][$j]) && $pattys[$i]["rate"][$j] != ''; $j++) {
                // $rate .= ltrim($pattys[$i]["rate"][$j],",") . ' - ';
                $rate .= $pattys[$i]["rate"][$j];
            }
            $jsonpattys[] = array("html" => '<option  value="' . $pattys[$i]["pattyid"] . '" > ' . $pattys[$i]["user_name"] . ' - ' . $pattys[$i]["sales_date"] . ' - ' . $pattys[$i]["name"] . ' - ' . $pattys[$i]["vehicle_no"] . ' - ' . $pattys[$i]["packtype"] . ' - ' . $pattys[$i]["sal_totpck"] . '</option>',
                // "label" =>  $pattys[$i]["user_name"] .' ? '. date("d-m-Y",strtotime($pattys[$i]["sales_date"]))  .' ? '. $pattys[$i]["name"]  .' ? '.
                "label" => $pattys[$i]["user_name"] . ' ? ' . $pattys[$i]["sales_date"] . ' ? ' . $pattys[$i]["name"] . ' ? ' .
                $pattys[$i]["vehicle_no"] . ' ? ' . $pattys[$i]["packtype"] . ' ? ' . $pattys[$i]["sal_totpck"],
                "value" => $i,
                "packtype" => $pattys[$i]["packtype"],
                "prdphoto" => $pattys[$i]["prdphoto"],
                "pname" => $pattys[$i]["name"],
                "uid" => $pattys[$i]["uid"],
                "id" => $pattys[$i]["pattyid"]);
        }
        $_SESSION["list_of_pattys"] = $pattys;
    } else {
        $_SESSION["list_of_pattys"] = NULL;
    }
    return $jsonpattys;
}
function getBankAccounts($para) {
    $jsonba = array();
    $num = array();
    $bankaccounts = '';
    $index = $para["soruce"]["select"]["sessind"];
    $jsonba[] = array("html" => '<option  value="Add" >Add</option>', "id" => 'Add');
    if (isset($_SESSION[$index]) && $_SESSION[$index] != NULL) {
        $arr = $_SESSION[$index];
        $num = count($arr);
    }
    if ($num) {
        $index = $para["soruce"]["select"]["pindex"];
        $total = count($arr[$index]["bank_id"]);
        if ($total) {
            for ($j = 0; $j < $total && isset($arr[$index]["bank_id"][$j]) && $arr[$index]["bank_id"][$j] != ''; $j++) {
                $bankaccounts = ltrim($arr[$index]["bank_name"][$j], ",") . ' - ' .
                        ltrim($arr[$index]["ac_no"][$j], ",") . ' - ' .
                        ltrim($arr[$index]["branch"][$j], ",") . ' - ' .
                        ltrim($arr[$index]["branch_code"][$j], ",") . ' - ' .
                        ltrim($arr[$index]["IFSC"][$j], ",");
                $jsonba[] = array(
                    "html" => '<option  value="' . ltrim($arr[$index]["bank_id"][$j], ",") . '" >' . $bankaccounts . '</option>',
                    "id" => ltrim($arr[$index]["bank_id"][$j])
                );
            }
        }
    }
    return $jsonba;
}
function getUsers($para) {
    $bankacc = $_SESSION["USER_LOGIN_DATA"]["USER_ID"];
    $users = array();
    $jsonusers = array();
    $prdhtml = array();
    $utype = (isset($para["utype"]) && !empty($para["utype"]) && $para["utype"]) ? ' AND f.`user_type` LIKE "%' . $para["utype"] . '%"' : '';
    $uid = (isset($para["uid"]) && !empty($para["uid"]) && $para["uid"]) ? ' AND a.`id` = "' . $para["uid"] . '"' : '';
    $query = 'SELECT
                a.`id`,
                a.`user_name`,
                a.`acs_id`,
                a.`directory`,
                a.`password`,
                CASE WHEN (a.`addressline` IS NULL OR a.`addressline` = "" )
                         THEN "Not provided"
                         ELSE a.`addressline`
                END AS addressline,
                CASE WHEN (a.`town` IS NULL OR a.`town` = "" )
                         THEN "Not provided"
                         ELSE a.`town`
                END AS town,
                CASE WHEN (a.`city` IS NULL OR a.`city` = "" )
                         THEN "Not provided"
                         ELSE a.`city`
                END AS city,
                CASE WHEN (a.`district` IS NULL OR a.`district` = "" )
                         THEN "Not provided"
                         ELSE a.`district`
                END AS district,
                CASE WHEN (a.`province` IS NULL OR a.`province` = "" )
                         THEN "Not provided"
                         ELSE a.`province`
                END AS province,
                CASE WHEN (a.`province_code` IS NULL OR a.`province_code` = "" )
                         THEN NULL
                         ELSE a.`province_code`
                END AS province_code,
                CASE WHEN (a.`country` IS NULL OR a.`country` = "" )
                         THEN "Not provided"
                         ELSE a.`country`
                END AS country,
                CASE WHEN (a.`country_code` IS NULL OR a.`country_code` = "" )
                         THEN NULL
                         ELSE a.`country_code`
                END AS country_code,
                CASE WHEN (a.`zipcode` IS NULL OR a.`zipcode` = "" )
                         THEN "Not provided"
                         ELSE a.`zipcode`
                END AS zipcode,
                CASE WHEN (a.`website` IS NULL OR a.`website` = "" )
                         THEN "Not provided"
                         ELSE a.`website`
                END AS website,
                CONCAT(
                        CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
                                 THEN "---"
                                 ELSE a.`postal_code`
                        END,
                        CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
                                 THEN "Not provided"
                                 ELSE a.`telephone`
                        END
                ) AS tnumber,
                CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "")
                         THEN "' . USER_ANON_IMAGE . '"
                         ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
                END AS usrphoto,
                a.`status_id`,
                b.`email` AS email,
                c.`cnumber` AS cnumber,
                d.`id` AS bank_id,
                d.`bank_name` AS bank_name,
                d.`ac_no` AS ac_no,
                d.`branch` AS branch,
                d.`branch_code` AS branch_code,
                d.`IFSC` AS IFSC,
                e.`id` AS prdid,
                e.`name` AS prdname,
                e.`prdphoto` AS prdphoto,
                f.`user_type`,
                g.`gender_name`
        FROM `user_profile` AS a
        LEFT JOIN `photo` AS ph ON a.`photo_id` = ph.`id`
        LEFT JOIN (
            SELECT
                em.`id`,
                GROUP_CONCAT(em.`email`,"??????") AS email,
                em.`user_pk`
            FROM `email_ids` AS em
            WHERE em.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            GROUP BY (em.`user_pk`)
            ORDER BY (em.`user_pk`)
        )  AS b ON a.`id` = b.`user_pk`
        LEFT JOIN (
            SELECT
                cn.`id`,
                cn.`user_pk`,
                GROUP_CONCAT(CONCAT(cn.`cell_code`,"-",cn.`cell_number`),"??????") AS cnumber
            FROM `cell_numbers` AS cn
            WHERE cn.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            GROUP BY (cn.`user_pk`)
            ORDER BY (cn.`user_pk`)
        ) AS c ON a.`id` = c.`user_pk`
        LEFT JOIN (
            SELECT
                ba.`id`,
                ba.`user_pk`,
                GROUP_CONCAT(ba.`bank_name`,"??????") AS bank_name,
                GROUP_CONCAT(ba.`ac_no`,"??????") AS ac_no,
                GROUP_CONCAT(
                        CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
                                 THEN "Not provided"
                                 ELSE ba.`branch`
                        END,"??????"
                ) AS branch,
                GROUP_CONCAT(
                        CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
                                 THEN "Not provided"
                                 ELSE ba.`branch_code`
                        END,"??????"
                ) AS branch_code,
                GROUP_CONCAT(
                        CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
                                 THEN "Not provided"
                                 ELSE ba.`IFSC`
                        END,"??????"
                ) AS IFSC,
                ba.`status_id`
            FROM `bank_accounts` AS ba
            WHERE  ba.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            GROUP BY (ba.`user_pk`)
            ORDER BY (ba.`user_pk`)
        ) AS d ON a.`id` = d.`user_pk`
        LEFT JOIN (
            SELECT
                GROUP_CONCAT(prd.`id`,"??????") AS id,
                GROUP_CONCAT(prd.`name`,"??????") AS name,
                GROUP_CONCAT(
                        CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
                                 THEN "' . VEGIE_IMAGE . '"
                                 ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
                        END,"??????"
                ) AS prdphoto,
                urpd.`user_pk`
            FROM `product` AS prd
            LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
            LEFT JOIN `user_product` AS urpd ON prd.`id` = urpd.`product_id`
            INNER JOIN `user_profile` AS up ON up.id = urpd.`user_pk` AND up.`status_id` = 1
            WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            AND urpd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            GROUP BY (urpd.`user_pk`)
            ORDER BY (urpd.`user_pk`)
        ) AS e ON a.`id` = e.`user_pk`
        LEFT JOIN (
            SELECT
                utype.`id`,
                utype.`user_type`
            FROM `user_type` AS utype
            WHERE utype.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
        ) AS f ON a.`user_type_id` = f.`id`
        LEFT JOIN `gender` AS g ON a.`gender` = g.`id`
        WHERE f.`id` !=  9
        ' . $utype . '
        ' . $uid . '
        AND a.`status_id` = 1
        ORDER BY (a.`id`) DESC;';
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            array_push($users, $row);
        }
    }
    $total = count($users);
    if ($total) {
        for ($i = 0; $i < $total; $i++) {
            $email = '';
            $cellnumber = '';
            $tnumber = '';
            $product = '';
            $bankaccounts = '';
            $users[$i]["email"] = explode("??????", $users[$i]["email"]);
            $users[$i]["cnumber"] = explode("??????", $users[$i]["cnumber"]);
            $users[$i]["bank_id"] = explode("??????", $users[$i]["bank_id"]);
            $users[$i]["bank_name"] = explode("??????", $users[$i]["bank_name"]);
            $users[$i]["ac_no"] = explode("??????", $users[$i]["ac_no"]);
            $users[$i]["branch"] = explode("??????", $users[$i]["branch"]);
            $users[$i]["branch_code"] = explode("??????", $users[$i]["branch_code"]);
            $users[$i]["IFSC"] = explode("??????", $users[$i]["IFSC"]);
            $users[$i]["prdid"] = explode("??????", $users[$i]["prdid"]);
            $users[$i]["prdname"] = explode("??????", $users[$i]["prdname"]);
            $users[$i]["prdphoto"] = explode("??????", $users[$i]["prdphoto"]);
            $email = (isset($users[$i]["email"][0]) && $users[$i]["email"][0] != '') ? $users[$i]["email"][0] : '';
            $cellnumber = (isset($users[$i]["cnumber"][0]) && $users[$i]["cnumber"][0] != '') ? $users[$i]["cnumber"][0] : '';
            $tnumber = (isset($users[$i]["tnumber"]) && $users[$i]["tnumber"] != '') ? $users[$i]["tnumber"] : '';
            for ($j = 0; $j < count($users[$i]["prdid"]) && isset($users[$i]["prdid"][$j]) && $users[$i]["prdid"][$j] != ''; $j++) {
                // $product .= ltrim($users[$i]["prdname"][$j],",") . ' - ';
                array_push($prdhtml, array("html" => '<option  value="' . ltrim($users[$i]["prdid"][$j], ",") . '" > ' . ltrim($users[$i]["prdname"][$j], ",") . '</option>',
                    "label" => ltrim($users[$i]["prdname"][$j], ","),
                    "prdname" => ltrim($users[$i]["prdname"][$j], ","),
                    "value" => $j,
                    "id" => ltrim($users[$i]["prdid"][$j], ",")));
                //$product .= $users[$i]["prdname"][$j];
            }

            for ($j = 0; $j < count($users[$i]["bank_name"]) && isset($users[$i]["bank_name"][$j]) && $users[$i]["bank_name"][$j] != ''; $j++) {
                $bankaccounts .= '{' . ltrim($users[$i]["bank_name"][$j], ",") . ' - ' . ltrim($users[$i]["ac_no"][$j], ",") . '} - ';
            }
            $jsonusers[] = array("html" => '<option  value="' . $users[$i]["id"] . '" > ' . $users[$i]["user_name"] . ' - ' . $email . ' - ' . $cellnumber . ' - ' . $tnumber . ' - ' . $bankaccounts . '</option>',
                "label" => $users[$i]["user_name"] . ' - ' . $email . ' - ' . $cellnumber . ' - ' . $tnumber . ' - ' . $bankaccounts,
                "id" => $users[$i]["id"],
                //"prdhtml" => $prdhtml,
                "value" => $i,
                "name" => $users[$i]["user_name"],
                "img" => '<img src="' . $users[$i]["usrphoto"] . '" height="30" width="30" />');
        }
        $_SESSION["list_of_users"] = $users;
    } else {
        $_SESSION["list_of_users"] = NULL;
    }
    return $jsonusers;
}
function fetchUserProduct($param = false) {
    $users = array();
    $query = 'SELECT
                a.`id`,
                e.`id` AS prdid,
                e.`name` AS prdname,
                e.`prdphoto` AS prdphoto
            FROM `user_profile` AS a
            LEFT JOIN (
                SELECT
                    GROUP_CONCAT(prd.`id`,"??????") AS id,
                    GROUP_CONCAT(prd.`name`,"??????") AS name,
                    GROUP_CONCAT(
                            CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
                                     THEN "' . VEGIE_IMAGE . '"
                                     ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
                            END,"??????"
                    ) AS prdphoto,
                    urpd.`user_pk`
                FROM `product` AS prd
                LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
                LEFT JOIN `user_product` AS urpd ON prd.`id` = urpd.`product_id`
                WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                AND urpd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                GROUP BY (urpd.`user_pk`)
                ORDER BY (urpd.`user_pk`)
            ) AS e ON a.`id` = e.`user_pk`
            WHERE  a.id = "'.  mysql_real_escape_string($param).'"
            AND a.`status_id` = 1';
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            array_push($users, $row);
        }
    }
    $total = count($users);
    $prdhtml = array();
    if ($total) {
        for ($i = 0; $i < $total; $i++) {
            $users[$i]["prdid"] = explode("??????", $users[$i]["prdid"]);
            $users[$i]["prdname"] = explode("??????", $users[$i]["prdname"]);
            $users[$i]["prdphoto"] = explode("??????", $users[$i]["prdphoto"]);
            for ($j = 0; $j < count($users[$i]["prdid"]) && isset($users[$i]["prdid"][$j]) && $users[$i]["prdid"][$j] != ''; $j++) {
                // $product .= ltrim($users[$i]["prdname"][$j],",") . ' - ';
                array_push($prdhtml, array("html" => '<option  value="' . ltrim($users[$i]["prdid"][$j], ",") . '" > ' . ltrim($users[$i]["prdname"][$j], ",") . '</option>',
                    "label" => ltrim($users[$i]["prdname"][$j], ","),
                    "prdname" => ltrim($users[$i]["prdname"][$j], ","),
                    "value" => $j,
                    "id" => ltrim($users[$i]["prdid"][$j], ",")));
                //$product .= $users[$i]["prdname"][$j];
            }
    }
    return $prdhtml;
}
}
function jsonifyUser($type = false) {
    $user = $_SESSION["list_of_users"];
    $prdname = NULL;
    $email = NULL;
    $cnumber = NULL;
    $bank = NULL;
    $address = NULL;
    $tnumber = NULL;
    $jsonuser = array("lable" => NULL,
        "uid" => NULL,
        "name" => NULL,
        "usrimg" => NULL,
        "emails" => NULL,
        "cellnumbers" => NULL,
        "tnumber" => NULL,
        "bankaccounts" => NULL,
        "address" => NULL,
        "products" => NULL,
        "value" => 0
    );
    if (is_array($user)) {
        for ($i = 0; $i < count($user); $i++) {
            /* Address */
            if ($type == 'bill') {
                $address = '<br />' . $user[$i]["addressline"] . ',' . $user[$i]["town"] . ',' . $user[$i]["city"] . ',' . $user[$i]["district"] .
                        ',' . $user[$i]["province"] . ',' . $user[$i]["country"] . ',' . $user[$i]["zipcode"] . ',' . $user[$i]["website"];
            } else {
                $address = '<br /><strong>Address line :- </strong>' . $user[$i]["addressline"] .
                        '<br /><strong>Street / Locality :- </strong>' . $user[$i]["town"] .
                        '<br /><strong>City :- </strong>' . $user[$i]["city"] .
                        '<br /><strong>District / Department :- </strong>' . $user[$i]["district"] .
                        '<br /><strong>State / Provice :- </strong>' . $user[$i]["province"] .
                        '<br /><strong>Country :- </strong>' . $user[$i]["country"] .
                        '<br /><strong>Zipcode :- </strong>' . $user[$i]["zipcode"] .
                        '<br /><strong>Website :- </strong>' . $user[$i]["website"];
            }
            /* Telephone number */
            $tnumber = (isset($user[$i]["tnumber"]) && $user[$i]["tnumber"] != '') ? $user[$i]["tnumber"] : '';
            /* Email */
            if (count($user[$i]["email"]) > 0) {
                for ($j = 0; $j < count($user[$i]["email"]) && isset($user[$i]["email"][$j]) && $user[$i]["email"][$j] != ''; $j++) {
                    $email[] = ltrim($user[$i]["email"][$j], ",");
                }
            } else {
                $email = 'Not Provided';
            }
            /* Cell numbers */
            if (count($user[$i]["cnumber"]) > 0) {
                for ($j = 0; $j < count($user[$i]["cnumber"]) && isset($user[$i]["cnumber"][$j]) && $user[$i]["cnumber"][$j] != ''; $j++) {
                    $cnumber[] = ltrim($user[$i]["cnumber"][$j], ",");
                }
            } else {
                $cnumber = 'Not Provided';
            }
            /* Product Name */
            if (count($user[$i]["prdname"]) > 0) {
                for ($j = 0; $j < count($user[$i]["prdname"]) && isset($user[$i]["prdname"][$j]) && $user[$i]["prdname"][$j] != ''; $j++) {
                    $prdname[$j]["name"] = ltrim($user[$i]["prdname"][$j], ",");
                    $prdname[$j]["img"] = '<img src="' . ltrim($user[$i]["prdphoto"][$j], ",") . '" height="30" width="30" />&nbsp;';
                }
            } else {
                $prdname = 'Not Provided';
            }
            /* Bank accounts */
            if (count($user[$i]["bank_name"]) > 0) {
                for ($j = 0; $j < count($user[$i]["bank_name"]) && isset($user[$i]["bank_name"][$j]) && $user[$i]["bank_name"][$j] != ''; $j++) {
                    $bank[$j]["bank_name"] = ltrim($user[$i]["bank_name"][$j], ",");
                    $bank[$j]["ac_no"] = ltrim($user[$i]["ac_no"][$j], ",");
                    $bank[$j]["branch"] = ltrim($user[$i]["branch"][$j], ",");
                    $bank[$j]["branch_code"] = ltrim($user[$i]["branch_code"][$j], ",");
                    $bank[$j]["IFSC"] = ltrim($user[$i]["IFSC"][$j], ",");
                }
            } else {
                $bank = 'Not Provided';
            }
            $jsonuser = array("lable" => $user[$i]["id"] . ' - <img src="' . $user[$i]["usrphoto"] . '" height="30" width="30" />&nbsp;' . $user[$i]["user_name"],
                "uid" => $user[$i]["id"],
                "name" => $user[$i]["user_name"],
                "usrimg" => $user[$i]["usrphoto"],
                "emails" => $email,
                "cellnumbers" => $cnumber,
                "tnumber" => $tnumber,
                "bankaccounts" => $bank,
                "address" => $address,
                "products" => $prdname,
                "value" => $i);
        }
    }
    return $jsonuser;
}
function billingDetails() {
    $query = "SELECT * FROM `billing_details` WHERE `status_id`=4";
    $result = executeQuery($query);
    $num = mysql_num_rows($result);
    if ($num) {
        $row = mysql_fetch_assoc($result);
        $jsondata = array(
            "noofrecords" => $num,
            "billlogo" => $row['billlogo'],
            "companyname" => $row['companyname'],
            "address" => $row['address'],
            "landline" => $row['landline'],
            "email" => $row['email'],
            "mobile" => $row['mobile'],
            "termsncondition" => $row['termsncondition'],
            "footermessage" => $row['footermessage'],
        );
        return $jsondata;
    }
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
function linear_search($key, $listtypes) {
    for ($i = 0; $i < count($listtypes); $i++)
        if ($key == $listtypes[$i])
            return true;
    return false;
}
function validateUserName($uname) {
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
}
function validatePassword($pass) {
    if (strlen($pass) > 3) {
        return $pass;
    } else {
        return NULL;
    }
}
/* Change the redirection url */
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
    echo $i;
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
    for ($i = 0; $i < count($sruct_array); $i++) {
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
function createImage($imageprop, $path, $file) {
    switch ($imageprop) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($path . "/" . $file);
        case IMAGETYPE_JPEG2000:
            return imagecreatefromjpeg($path . "/" . $file);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($path . "/" . $file);
        case IMAGETYPE_PNG:
            $imgPng = imagecreatefrompng($path . "/" . $file);
            $imgPng = imagetranstowhite($imgPng);
            return $imgPng;
        case IMAGETYPE_WBMP:
            return imagecreatefromwbmp($path . "/" . $file);
        case IMAGETYPE_XBM:
            return imagecreatefromxbm($path . "/" . $file);
        default:
            return false;
    }
}
function imagetranstowhite($trans) {
    // Create a new true color image with the same size
    $w = imagesx($trans);
    $h = imagesy($trans);
    $white = imagecreatetruecolor($w, $h);
    // Fill the new image with white background
    $bg = imagecolorallocate($white, 255, 255, 255);
    imagefill($white, 0, 0, $bg);
    // Copy original transparent image onto the new image
    imagecopy($white, $trans, 0, 0, 0, 0, $w, $h);
    return $white;
}
function outputImageToBrowser($image_p, $path, $name, $extension) {
    if ($extension == "jpg" || $extension == "JPG")
        imagejpeg($image_p, $path . "/" . $name);
    if ($extension == "jpe" || $extension == "JPE")
        imagejpeg($image_p, $path . "/" . $name);
    if ($extension == "jpeg" || $extension == "JPEG")
        imagejpeg($image_p, $path . "/" . $name);
    if ($extension == "png" || $extension == "PNG")
        imagepng($image_p, $path . "/" . $name);
    if ($extension == "gif" || $extension == "GIF")
        imagegif($image_p, $path . "/" . $name);
    if ($extension == "wbmp" || $extension == "WBMP")
        imagewbmp($image_p, $path . "/" . $name);
    if ($extension == "xbm" || $extension == "XBM")
        imagexbm($image_p, $path . "/" . $name);
}
function ValidateAdmin() {
    $flag = false;
    if (!isset($_SESSION["USER_LOGIN_DATA"])) {
        return $flag;
    } else if (isset($_SESSION["USER_LOGIN_DATA"]["STATUS"]) && $_SESSION["USER_LOGIN_DATA"]["STATUS"] == 'success') {
        $query = 'SELECT a.*,
                    CASE WHEN p.`ver2` IS NULL
                                 THEN \'' . USER_ANON_IMAGE . '\'
                                 ELSE CONCAT(\'' . URL . ASSET_DIR . '\',p.`ver2`)
                    END AS photo
         FROM `user_profile` AS a
         LEFT JOIN `photo` AS p ON p.`id` = a.`photo_id`
         WHERE a.`user_name`=\'' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) . '\'
         AND a.`password`=\'' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_PASS"]) . '\'
         ';
        $res = executeQuery($query);
        if (get_resource_type($res) == 'mysql result') {
            if (mysql_num_rows($res) > 0) {
                $row = mysql_fetch_assoc($res);
                // echo '<br />'.print_r($row);
                if ($row["user_name"] == $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] &&
                        $row["password"] == $_SESSION["USER_LOGIN_DATA"]["USER_PASS"]
                ) {
                    //check usertype
                    $query1 = 'select t.`user_type`
                            from `user_type` as t
                        left join `user_profile` as up
                        on up.`user_type_id`= t.`id`
                        where up.`id` = \'' . $row["id"] . '\'
                            AND up.`status_id`=(SELECT `id` FROM `status` WHERE `statu_name`=\'Registered\' AND status=1)
                        group by t.`user_type`;';
                    $res1 = executeQuery($query1);
                    if (get_resource_type($res1) == 'mysql result') {
                        if (mysql_num_rows($res1) > 0) {
                            $row1 = mysql_fetch_assoc($res1);

                            $userdata = array(
                                "USER_EMAIL" => $row["email"],
                                "USER_PASS" => $row["password"],
                                "USER_ID" => $row["id"],
                                "USER_NAME" => $row["user_name"],
                                "USER_PHOTO" => $row["photo"],
                                "USER_TYPE" => $row1["user_type"],
                                "STATUS" => 'success'
                            );
                            //updateUserlog($parameters,$row["id"]);
                        }
                    }
                } else if ($row["user_name"] == $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] &&
                        $row["password"] != $_SESSION["USER_LOGIN_DATA"]["USER_PASS"]) {
                    $userdata = array(
                        "USER_EMAIL" => NULL,
                        "USER_PASS" => $_SESSION["USER_LOGIN_DATA"]["USER_PASS"],
                        "USER_ID" => NULL,
                        "USER_NAME" => $_SESSION["USER_LOGIN_DATA"]["USER_NAME"],
                        "USER_PHOTO" => NULL,
                        "STATUS" => 'password'
                    );
                }
            }
        }
        $flag = true;
    }
    return $flag;
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
function returnRandomSourceEmail() {
    require_once(LIB_ROOT . "PHPExcel_1.7.9/Classes/PHPExcel.php");
    $thefile1 = LIB_ROOT . "CMS-EmailIds-madmec-Export.xlsx";
    $thefile2 = LIB_ROOT . "CMS-EmailIds-bigrock-Export.xlsx";
    $thefile3 = LIB_ROOT . "CMS-EmailIds-gmail-Export.xlsx";
    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($thefile1);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow();
    if ($highestRow > 0) {
        $_SESSION['MADMECMAILS'] = array();
        for ($row = 1, $j = 0; $row <= $highestRow; ++$row, $j++) {
            $_SESSION['MADMECMAILS'][$j]['email'] = preg_replace('~\x{00a0}~', '', $objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
            $_SESSION['MADMECMAILS'][$j]['password'] = preg_replace('~\x{00a0}~', '', $objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
        }
    }
    $objPHPExcel = $objReader->load($thefile2);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow();
    if ($highestRow > 0) {
        $_SESSION['BIGROCKMAILS'] = array();
        for ($row = 1, $j = 0; $row <= $highestRow; ++$row, $j++) {
            $_SESSION['BIGROCKMAILS'][$j]['email'] = preg_replace('~\x{00a0}~', '', $objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
            $_SESSION['BIGROCKMAILS'][$j]['password'] = preg_replace('~\x{00a0}~', '', $objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
        }
    }
    $objPHPExcel = $objReader->load($thefile3);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow();
    if ($highestRow > 0) {
        $_SESSION['GMAIL'] = array();
        for ($row = 1, $j = 0; $row <= $highestRow; ++$row, $j++) {
            $_SESSION['GMAIL'][$j]['email'] = preg_replace('~\x{00a0}~', '', $objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
            $_SESSION['GMAIL'][$j]['password'] = preg_replace('~\x{00a0}~', '', $objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
        }
    }
    $objPHPExcel->disconnectWorksheets();
    unset($objPHPExcel);
    unset($objReader);
}
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
function generateInvoice($receipt) {
    return "<html>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<title>" . $receipt["title"] . "</title>
		</head>
		<body>
		<table width='800' border='0' align='center' cellpadding='5' cellspacing='2' style='border: solid 1px; font-size:18px;'>
		<tr>
		<th colspan='2' align='center'>Invoice</th>
		</tr>
		<tr>
		<td width='430'>
		<div align='left' id='comp_logo'>
		<img height='100' width='100' src='" . URL . $receipt["companydet"]["billlogo"] . "'></img><br />

		</div>
		Invoice no : <span style='color:red;'>" . $receipt["invoiceno"] . "</span><br />
		Invoice Date :&nbsp;<span><u>" . $receipt["invoicedate"] . "</u></span>
		</td>
		<td width='354'>
		<div align='right' id='comp_logo'>
		<img width='300' src='" . URL . $receipt["companydet"]["billlogo"] . "'></img>
		</div>
		<div id='comp_add' align='left'>
		" . $receipt["companydet"]["address"] . "
		</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Name of the member :&nbsp;</div>
		<div style='width:615px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . $receipt["retailer"] . "</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Address :&nbsp;</div>
		<div style='width:710px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . $receipt["ret_address"] . "</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Product :&nbsp;</div>
		<div style='width:655px; float:right;border-bottom: dashed 1px;'>" . $receipt["product_det"] . "</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Paid amount :&nbsp;</div>
		<div style='width:590px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . $receipt["pamount"] . "</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Total amount (in words) :&nbsp;</div>
		<div style='width:590px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . $receipt["amt_in_words"] . "</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td>
		<div style='float:left;'>Balance amt due :&nbsp;</div>
		<div style='width:285px; float:right;border-bottom: dashed 1px;'>" . $receipt["due_amt"] . "</div>
		</td>
		<td>
		<div style='float:left;'>Due date :&nbsp;</div>
		<div style='width:270px; float:right;border-bottom: dashed 1px;'>" . $receipt["due_date"] . "</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td>
		Member signature
		</td>
		<td align='right'>
		Authorized signature
		</td>
		</tr>
		<tr>
		<td align='right'>
		Non-Transferable
		</td>
		<td>
		Non-Refundable
		</td>
		</tr>
		<tr>
		<td colspan='2' align='center'>
		<div style='width:800px; float:right;border-bottom: dashed 1px;'>Powered By MadMec&copy;</div>
		</td>
		</tr>
		</table>
		</body>
		</html>";
}
function generateBill($bill) {
    return '<table width="800" border="0" align="center" cellpadding="3" cellspacing="3" style=" border: solid 1px #99CC66;">
            <caption>
            <strong>' . $bill["title"] . ' </strong>
            </caption>
            <tr>
            <th colspan="7" align="center" valign="top" scope="col">' . $bill["header"] . '<hr /></th>
            </tr>
            <tr>
            <th colspan="5" align="left" scope="col">NO:-<u>' . $bill["invoiceno"] . '</u></th>
            <th colspan="2" align="left" scope="col">Date:-<u>' . $bill["billdate"] . '</u></th>
            </tr>
            <tr>
            <th colspan="7" align="left" scope="col">M/S :- <u>' . $bill["supplier"] . '</u></th>
            </tr>
            <tr>
            <td colspan="7"><strong>RECEIVED ON :-<u>' . $bill["receivedon"] . '</u></strong></td>
            </tr>
            <tr>
            <td colspan="7" valign="bottom"><hr  style="color:#9C0;"/></td>
            </tr>
            <tr>
            <td width="37" align="center" bgcolor="#FF0000"><strong style="color:#FFF">Qty</strong></td>
            <td width="285" align="center" bgcolor="#FF0000"><strong style="color:#FFF">Particulars</strong></td>
            <td width="74" align="center" bgcolor="#FF0000"><strong style="color:#FFF">Weight in KG</strong></td>
            <td width="44" align="center" bgcolor="#FF0000"><strong style="color:#FFF">Rate</strong></td>
            <td width="76" align="center" bgcolor="#FF0000"><strong style="color:#FFF">Amount<br />
            Rupees</strong></td>
            <td width="86" align="center" bgcolor="#FF0000"><strong style="color:#FFF">Expenses</strong></td>
            <td width="116" align="center" bgcolor="#FF0000"><strong style="color:#FFF">Amount<br />
            Rupees</strong></td>
            </tr>
            <tr>
            <td height="550" align="left" valign="top">
            <table width="100%" border="0" cellspacing="3" cellpadding="0" style="font-weight:bold">
            <tr>
            <td align="center" height="30">' . $bill["qty1"] . '</td>
            </tr>
            <tr>
            <td align="center" height="30">' . $bill["qty2"] . '</td>
            </tr>
            <tr>
            <td align="center" height="30">' . $bill["qty3"] . '</td>
            </tr>
            <tr>
            <td align="center" height="30">&nbsp;</td>
            </tr>
            <tr>
            <td align="center" height="30">&nbsp;</td>
            </tr>
            <tr>
            <td align="center" height="30">&nbsp;</td>
            </tr>
            <tr>
            <td align="center" height="30">&nbsp;</td>
            </tr>
            <tr>
            <td align="center" height="30">&nbsp;</td>
            </tr>
            <tr>
            <td align="center" height="30">&nbsp;</td>
            </tr>
            <tr>
            <td align="center" height="30">&nbsp;</td>
            </tr>
            <tr>
            <td align="center" height="30">&nbsp;</td>
            </tr>
            <tr>
            <td align="center" height="30">&nbsp;</td>
            </tr>
            </table></td>
            <td height="550" align="left" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0" style="font-weight:bold">
            <tr>
            <td align="left"  height="30"  valign="bottom">' . $bill["prtlr1"] . '</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">' . $bill["prtlr2"] . '</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">' . $bill["prtlr3"] . '</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            </table></td>
            <td height="550" align="left" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0" style="font-weight:bold">
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">' . $bill["wt1"] . '</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">' . $bill["wt2"] . '</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">' . $bill["wt3"] . '</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            </table></td>
            <td height="550" align="left" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0" style="font-weight:bold">
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">' . $bill["avgrt1"] . '</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">' . $bill["avgrt2"] . '</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">' . $bill["avgrt3"] . '</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"   height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            </table></td>
            <td height="550" align="left" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0" style="font-weight:bold">
            <tr>
            <td align="right"  height="30"  valign="bottom">' . $bill["amt1"] . '</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">' . $bill["amt2"] . '</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">' . $bill["amt3"] . '</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  height="30"  valign="bottom">&nbsp;</td>
            </tr>
            </table></td>
            <td height="550" align="left" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0" style="font-weight:bold">
            <tr>
            <td align="center" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">Lorry Hire</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">CASH</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">LABOUR</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">ASSN. FEE</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">TELE &amp; POST</td>
            </tr>
            <tr>
            <td align="center" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="left" valign="bottom">RMC</td>
            </tr>
            <tr>
            <td align="center" valign="bottom">&nbsp;</td>
            </tr>
            </table>
            </td>
            <td height="550" align="left" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0" style="font-weight:bold">
            <tr>
            <td align="right"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">' . $bill["hire"] . '</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">' . $bill["cash"] . '</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">' . $bill["labour"] . '</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">' . $bill["assnfee"] . '</td>
            </tr>
            <tr>
            <td align="right" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">' . $bill["assnfee"] . '</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">&nbsp;</td>
            </tr>
            <tr>
            <td align="right"  valign="bottom">' . $bill["rmc"] . '</td>
            </tr>
            </table></td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" align="right"><strong>Gross Sales : </strong></td>
            <td align="right"  height="30" >' . $bill["totsal"] . '</td>
            <td><strong>Total Exp.</strong></td>
            <td align="right"  height="30" >' . $bill["totexp"] . '</td>
            </tr>
            <tr>
            <td colspan="2" rowspan="3" align="left" valign="top"><strong> Rupees in words :- </strong><u>' . $bill["nsalesinwords"] . '</u></td>
            <td colspan="2" rowspan="3" align="right" valign="top"><strong>Net Sales : </strong></td>
            <td colspan="3" align="right">' . $bill["nsales"] . '</td>
            </tr>
            <tr>
            <td colspan="3"><div style="border-bottom:solid 2px #FF0000; height:35px; width:100%; position:relative;"></div></td>
            </tr>
            <tr>
            <td colspan="3"><strong style="color:#F00;">For ' . $bill["companyname"] . '</strong></td>
            </tr>
            </table>';
}
function generateReceipt($bill) {
    return '<table width="500" width="600" border="0" align="center" cellpadding="3" cellspacing="3" style=" border: solid 1px #99CC66;">
        <caption>
        <strong>' . $bill["title"] . ' CASH RECEIPT</strong>
        </caption>
        <tr>
        <th colspan="2" align="center" valign="top" scope="col">' . $bill["header"] . '<hr /></th>
        </tr>
        <tr>
        <th align="left" scope="col" width="300">NO:-<u>' . $bill["invoiceno"] . '</u></th>
        <th align="left" scope="col"width="200">Date:-<u>' . $bill["billdate"] . '</u></th>
        </tr>
        <tr>
        <th colspan="2" align="left" scope="col">M/S :- <u>' . $bill["retailer"] . '</u><hr /></th>
        </tr>
        <tr>
        <td colspan="2" align="left" scope="col">Received Cash :- <u>' . $bill["receivedcash"] . '</u><hr /></th>
        </tr>
        <tr>
        <td colspan="2" align="left" scope="col">Rupees :- <u>' . $bill["cashinwords"] . '</u><hr /></th>
        </tr>
        <tr>
        <td colspan="2" align="left" scope="col">Signature :- <hr /></th>
        </tr>
        </table>';
}
function returnDirectoryReceipt(& $dirparameters, $parameters) {
    $dirparameters["filename"] = md5(rand(999, 999999) . microtime()) . '_.html';
    $query = 'SELECT `directory` FROM `user_profile` WHERE `id`=\'' . mysql_real_escape_string($parameters["uid"]) . '\';';
    $res = executeQuery($query);
    if (mysql_num_rows($res)) {
        $dirparameters["directory"] = mysql_result($res, 0);
    }
    if ($dirparameters["directory"]) {
        $dirparameters["filedirectory"] = DOC_ROOT . ASSET_DIR . $dirparameters["directory"] . '/' . $dirparameters["filename"];
        $dirparameters["urlpath"] = URL . ASSET_DIR . $dirparameters["directory"] . '/' . $dirparameters["filename"];
        $dirparameters["url"] = ASSET_DIR . $dirparameters["directory"] . '/' . $dirparameters["filename"];
    } else {
        /* Create directory if does not exist */
        $dirparameters["directory"] = substr(md5(microtime()), 0, 6) . '_user_' . $parameters["uid"];
        $dirparameters["directory"] = createdirectories($dirparameters["directory"]);
        $dirparameters["filedirectory"] = DOC_ROOT . ASSET_DIR . $dirparameters["directory"] . '/' . $dirparameters["filename"];
        $dirparameters["urlpath"] = URL . ASSET_DIR . $dirparameters["directory"] . '/' . $dirparameters["filename"];
        $dirparameters["url"] = ASSET_DIR . $dirparameters["directory"] . '/' . $dirparameters["filename"];
        /* Update the directory in users table */
        $query = 'UPDATE `user_profile` SET `directory` = \'' . $dirparameters["directory"] . '\' WHERE `id`=\'' . mysql_real_escape_string($parameters["uid"]) . '\';';
        executeQuery($query);
    }
}
function getStatusId($statname = false) {
    $row = 0;
    $statname = ucfirst($statname);
    $res = executeQuery('SELECT `id` FROM `status` WHERE `statu_name` =\'' . $statname . '\';');
    if (mysql_num_rows($res)) {
        $row = mysql_result($res, 0);
    }
    return $row;
}
?>
