<?php

define("MODULE_0", "config.php");
require_once(MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
$module = array(
    "dashAdmin" => preg_replace("/\s+/", " ", file_get_contents(DASHBOARD_Admin)),
    "dashVendor" => preg_replace("/\s+/", " ", file_get_contents(DASHBOARD_Vend)),
    "dashUser" => preg_replace("/\s+/", " ", file_get_contents(DASHBOARD_User)),
    "VEHICLETYPE" => preg_replace("/\s+/", " ", file_get_contents(VEHICLETYPE)),
    "VEHICLEMODEL" => preg_replace("/\s+/", " ", file_get_contents(VEHICLEMODEL)),
    "VEHICLEMAKE" => preg_replace("/\s+/", " ", file_get_contents(VEHICLEMAKE)),
    "VENDOR" => preg_replace("/\s+/", " ", file_get_contents(VENDOR)),
    "USERS" => preg_replace("/\s+/", " ", file_get_contents(USERS)),
    "COMPLAINTS" => preg_replace("/\s+/", " ", file_get_contents(COMPLAINTS)),
    "CHANGEPASSWORD" => preg_replace("/\s+/", " ", file_get_contents(CHANGEPASSWORD)),
    "REPORT" => preg_replace("/\s+/", " ", file_get_contents(REPORT)),
    "VEN_APPOINTMENT" => preg_replace("/\s+/", " ", file_get_contents(VEN_APPOINTMENT)),
    "VEN_CONFIGURE" => preg_replace("/\s+/", " ", file_get_contents(VEN_CONFIGURE)),
    "VEN_UPCOMING" => preg_replace("/\s+/", " ", file_get_contents(VEN_UPCOMING)),
    "VEN_INLINE" => preg_replace("/\s+/", " ", file_get_contents(VEN_INLINE)),
    "VEN_REPORT" => preg_replace("/\s+/", " ", file_get_contents(VEN_REPORT)),
    "VENDOR_PROFILE" => preg_replace("/\s+/", " ", file_get_contents(VENDOR_PROFILE)),
    "USER_APPOINTMENT" => preg_replace("/\s+/", " ", file_get_contents(USER_APPOINTMENT)),
    "USER_VEHICLE" => preg_replace("/\s+/", " ", file_get_contents(USER_VEHICLE)),
    "USER_HISTORY" => preg_replace("/\s+/", " ", file_get_contents(USER_HISTORY)),
    "USER_PROFILE" => preg_replace("/\s+/", " ", file_get_contents(USER_PROFILE))
);
echo json_encode($module);
?>
