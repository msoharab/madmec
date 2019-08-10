<?php
	$temp = rtrim($_SERVER['DOCUMENT_ROOT'],"/");
	$temp = explode("/",$temp);
	$config_root = str_replace($temp[count($temp)-1],"library/".$temp[count($temp)-1],$_SERVER['DOCUMENT_ROOT'])."/";
	define("CONFIG_ROOT",$config_root);
	define("MODULE_1","database.php");
	define("MODULE_2","PHPExcel_1.7.9/Classes/PHPExcel.php");
	define("MODULE_USER","user.php");
	define("MODULE_PROJECT","project.php");
	define("MODULE_STOCK","stock.php");
	define("MODULE_MORDER","materialorder.php");
	define("MODULE_PAYMENT","payment.php");
	define("MODULE_COLLECTION","collection.php");
	define("MODULE_PETTYCASH", "pettycash.php");
	define("MODULE_REPORT", "report.php");
	define("DUE", "due.php");
	define("FOLLOWUP", "followup.php");
        define("SETTING", "setting.php");
        define("USER_PROFILE", "userprofile.php");
	define("GENERATEPDF", "generatePDF.php");
        
        
        /* SUPER ADMIM FILES */
        define("SA_CLIENT","client.php");
        define("SA_ADMIN_COLLECTION","admincollection.php");
        define("SA_ORDER","order.php");
        define("SA_DUE","dueadmin.php");
        define("SA_FALLOWUP","duefallowup.php");
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(LIB_ROOT.MODULE_2);
	require_once(PDF);
?>