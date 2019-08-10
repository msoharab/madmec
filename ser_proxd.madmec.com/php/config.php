<?php
        
	$temp = rtrim($_SERVER['DOCUMENT_ROOT'],"/");
	$temp = explode("/",$temp);
	$config_root = str_replace($temp[count($temp)-1],"library/".$temp[count($temp)-1],$_SERVER['DOCUMENT_ROOT'])."/";
	define("CONFIG_ROOT",$config_root);
	define("MODULE_1","config.php");
	define("MODULE_2","database.php");
	
?>