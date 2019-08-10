<?php

define("MODULE_0", "config.php");
require_once(MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
$module = array(
    "dash" => preg_replace("/\s+/", " ", file_get_contents(DASHBOARD)),
    "VEHICLETYPE" => preg_replace("/\s+/", " ", file_get_contents(VEHICLETYPE)),
    "VEHICLEMODEL" => preg_replace("/\s+/", " ", file_get_contents(VEHICLEMODEL)),
    "VEHICLEMAKE" => preg_replace("/\s+/", " ", file_get_contents(VEHICLEMAKE)),
    "VENDOR" => preg_replace("/\s+/", " ", file_get_contents(VENDOR)),
    "USERS" => preg_replace("/\s+/", " ", file_get_contents(USERS)),
    "COMPLAINTS" => preg_replace("/\s+/", " ", file_get_contents(COMPLAINTS)),
    "CHANGEPASSWORD" => preg_replace("/\s+/", " ", file_get_contents(CHANGEPASSWORD)),
    "REPORT" => preg_replace("/\s+/", " ", file_get_contents(REPORT)),
);
echo json_encode($module);
?>
