<?php
	$temp = rtrim($_SERVER['DOCUMENT_ROOT'],"/");
	$temp = explode("/",$temp);
	$config_root = str_replace($temp[count($temp)-1],"library/".$temp[count($temp)-1],$_SERVER['DOCUMENT_ROOT'])."/";
	define("CONFIG_ROOT",$config_root);
	define("MODULE_CLIENTADD","clientadd.php");
	define("MODULE_ADDRESS","address.php");
	define("MODULE_GYMLIST","gymLoad.php");
	define("MODULE_PROFILE","profile.php");
	define("MODULE_ADDCUSTOMER","addcustomer.php");
	define("MODULE_CUSTOMER","customer.php");
	define("MODULE_ENQUIRY","enquiry.php");
	define("MODULE_PAYMENT","payment.php");
	define("MODULE_SHOWSTATUS","showstatus.php");
	define("MODULE_ACCOUNT","account.php");
	define("MODULE_MANAGE","manage.php");
	define("MODULE_STATS","stats.php");
	define("MODULE_TRAINER","trainer.php");
	define("MODULE_CLUB","club_report.php");
	define("MODULE_REPORT","registration_report.php");
	define("RECEIPTS_REPORT","receipt.php");
	define("MODULE_CRM","crm.php");
?>
