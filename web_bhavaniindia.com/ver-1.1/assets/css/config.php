<?php
$temp = rtrim($_SERVER['DOCUMENT_ROOT'], "/");
$temp = explode("/", $temp);
$temp[count($temp) - 1] = "library/".$temp[count($temp) - 1]."/";
$config_root = implode($temp,"/");
//$config_root = str_replace($temp[count($temp) - 1], "library", $_SERVER['DOCUMENT_ROOT']) . "/".$temp[count($temp) - 1]."/";
define("CONFIG_ROOT", $config_root);
?>
