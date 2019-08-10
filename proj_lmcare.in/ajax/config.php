<?php
	$temp = rtrim($_SERVER['DOCUMENT_ROOT'],"/");
	$temp = explode("/",$temp);
	$config_root = str_replace($temp[count($temp)-1],"library/".$temp[count($temp)-1],$_SERVER['DOCUMENT_ROOT'])."/";
	define("CONFIG_ROOT",$config_root);
	define("MODULE_1","database.php");
	define("MODULE_DOCTOR","doctor.php");
	define("MODULE_PATIENT","patient.php");
	define("MODULE_PHARMACY","pharmacy.php");
	define("MODULE_DIAGNOSTICS","diagnostic.php");
	define("MODULE_SUPERADMIN","superadmin.php");
	define("MODULE_SIGNIN","signin.php");
        define("MODULE_DOWNLOADFILES","download.php");
	define("MODULE_RESET","resetpassword.php");
	require_once(CONFIG_ROOT.MODULE_0);
        require_once(CONFIG_ROOT.MODULE_1);
        require_once(LIB_ROOT.PDF);
?>