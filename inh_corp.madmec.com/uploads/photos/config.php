<?php
$temp = rtrim($_SERVER['DOCUMENT_ROOT'], "/");
$temp = explode("/", $temp);
$config_root = str_replace($temp[count($temp) - 1], "library", $_SERVER['DOCUMENT_ROOT']) . "/".$temp[count($temp) - 1]."/";
define("CONFIG_ROOT", $config_root);
?>
