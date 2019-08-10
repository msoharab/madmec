<?php
error_reporting(0);
define("URL", "http://".$_SERVER["HTTP_HOST"]."/");
define("phpMyAdmin_URL", URL ."phpMyAdmin/");
define("APP_URL", URL ."app/");
#DOC_APP_LIB_ROOT
define("DOC_APP_LIB_ROOT", $_SERVER["DOCUMENT_ROOT"] . "\\library\\");
#DOC_ROOT
define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"] . "\\");
#DOC_APP_ROOT
define("DOC_APP_ROOT", $_SERVER["DOCUMENT_ROOT"] . "\\app\\");
#MYSQL_ROOT
$temp = rtrim($_SERVER["DOCUMENT_ROOT"], "\\");
$temp = explode("\\", $temp);
$temp[count($temp) - 1] = "mysql\\";
$mysql_root = implode($temp,"\\");
define("MYSQL_ROOT", $mysql_root);
#WEBCACHE_ROOT
$temp = rtrim($_SERVER["DOCUMENT_ROOT"], "\\");
$temp = explode("\\", $temp);
$temp[count($temp) - 1] = "webcache\\";
$webcache_root = implode($temp,"\\");
define("WEBCACHE_ROOT", $webcache_root);
#PHP_ROOT
$temp = rtrim($_SERVER["DOCUMENT_ROOT"], "\\");
$temp = explode("\\", $temp);
$temp[count($temp) - 1] = "php\\";
$mysql_root = implode($temp,"\\");
define("PHP_ROOT", $mysql_root);
#SQL_ROOT
define("SQL_ROOT", $_SERVER["DOCUMENT_ROOT"] . "\\sql\\");
#phpMyAdmin_ROOT
define("phpMyAdmin_ROOT", $_SERVER["DOCUMENT_ROOT"] . "\\phpMyAdmin\\");
#TMPDIR
define("TMPDIR", $_SERVER["TMPDIR"]."\\");
?>