<?php

$temp = rtrim($_SERVER['DOCUMENT_ROOT'], "/");
$temp = explode("/", $temp);
$config_root = str_replace($temp[count($temp) - 1], "library/" . $temp[count($temp) - 1], $_SERVER['DOCUMENT_ROOT']) . "/";
define("CONFIG_ROOT", $config_root);
?>