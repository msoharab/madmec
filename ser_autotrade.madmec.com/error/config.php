<?php
	$temp = rtrim($_SERVER['DOCUMENT_ROOT'],"/");
	$temp = explode("/",$temp);
	$config_root = str_replace($temp[count($temp)-1],"library/".$temp[count($temp)-1],$_SERVER['DOCUMENT_ROOT'])."/";
	define("CONFIG_ROOT",$config_root);
	define("MODULE_1","database.php");
	define("MODULE_USER","user.php");
	define("MODULE_PRODUCT","product.php");
	define("MODULE_SALE","sale.php");
	define("MODULE_PURCHASE","purchase.php");
	define("MODULE_COLLECTION","collection.php");
	define("MODULE_PAYMENT","payment.php");
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
?>