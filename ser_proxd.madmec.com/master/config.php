<?php
	$temp = rtrim($_SERVER['DOCUMENT_ROOT'],"/");
	$temp = explode("/",$temp);
	$config_root = str_replace($temp[count($temp)-1],"library/".$temp[count($temp)-1],$_SERVER['DOCUMENT_ROOT'])."/";
	define("CONFIG_ROOT",$config_root);
	define("MODULE_1","database.php");
	define("MODULE_2","PHPExcel_1.7.9/Classes/PHPExcel.php");
        
        
        /* SUPER ADMIM FILES */
        define("SA_CLIENT","client.php");
        define("SA_ADMIN_COLLECTION","admincollection.php");
        define("SA_ORDER","order.php");
        define("SA_DUE","dueadmin.php");
        define("SA_FALLOWUP","duefallowup.php");
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(LIB_ROOT.MODULE_2);
?>