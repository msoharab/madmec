<?php

define("MODULE_0", "config.php");
require_once(MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
$module = array(
    "user" => preg_replace("/\s+/", " ", file_get_contents(MOD_USER)),
    "product" => preg_replace("/\s+/", " ", file_get_contents(MOD_PRODUCT)),
    "sales" => preg_replace("/\s+/", " ", file_get_contents(MOD_SALES)),
    "purchase" => preg_replace("/\s+/", " ", file_get_contents(MOD_PURCHASE)),
    "payment" => preg_replace("/\s+/", " ", file_get_contents(MOD_PAYMENT)),
    "dues" => preg_replace("/\s+/", " ", file_get_contents(MOD_DUES)),
    "collection" => preg_replace("/\s+/", " ", file_get_contents(MOD_COLLECTION)),
    "signout" => preg_replace("/\s+/", " ", file_get_contents(MOD_SIGNOUT)),
    "orderfollowups" => preg_replace("/\s+/", " ", file_get_contents(MOD_ORDFOLUPS)),
    "notify" => preg_replace("/\s+/", " ", file_get_contents(MOD_NOTIFY)),
    "profile" => preg_replace("/\s+/", " ", file_get_contents(MOD_PROFILE)),
    "client" => preg_replace("/\s+/", " ", file_get_contents(MOD_CLIENT)),
    "admincollection" => preg_replace("/\s+/", " ", file_get_contents(MOD_ADMINPAYMENT)),
    "dueadmin" => preg_replace("/\s+/", " ", file_get_contents(MOD_ADMINDUES)),
    "duefollowups" => preg_replace("/\s+/", " ", file_get_contents(MOD_ADMINFOLLOWUP)),
    "billlist" => preg_replace("/\s+/", " ", file_get_contents(MOD_BILLLIST)),
    "sale" => preg_replace("/\s+/", " ", file_get_contents(MOD_SALE)),
    "Setting" => preg_replace("/\s+/", " ", file_get_contents(MOD_Setting)),
);
echo json_encode($module);
?>
