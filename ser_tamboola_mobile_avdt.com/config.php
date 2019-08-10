<?php
define("MODULE_1", "database.php");
define("MODULE_2", "Date.php");
$temp = rtrim($_SERVER['DOCUMENT_ROOT'], "/");
$temp = explode("/", $temp);
$config_root = str_replace($temp[count($temp) - 1], "library/" . $temp[count($temp) - 1], $_SERVER['DOCUMENT_ROOT']) . "/";
define("CONFIG_ROOT", $config_root);
define("MODULE_MENU1", "menu1.php");
define("MODULE_MENU2", "menu2.php");
define("MODULE_MENU3", "menu3.php");
define("MODULE_MENU4", "menu4.php");
define("MODULE_ADDRESS", "address.php");
?>
