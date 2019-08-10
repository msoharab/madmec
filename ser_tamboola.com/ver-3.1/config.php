<?php
	$temp = rtrim($_SERVER['DOCUMENT_ROOT'],"/");
	$temp = explode("/",$temp);
	$config_root = str_replace($temp[count($temp)-1],"library/".$temp[count($temp)-1],$_SERVER['DOCUMENT_ROOT'])."/";
	define("CONFIG_ROOT",$config_root);
	define("MODULE_1", "database.php");
	define("MODULE_2", "Date.php");
	define("MODULE_ADDRESS","address.php");
	define("MODULE_GYMLIST","gymLoad.php");
	define("MODULE_PROFILE","profile.php");
	define("MODULE_ADDCUSTOMER","addcustomer.php");
	define("MODULE_GROUP","groups.php");
	define("MODULE_ENQUIRY","enquiry.php");
	define("MODULE_PAYMENT","payment.php");
	define("MODULE_SHOWSTATUS","showstatus.php");
	define("MODULE_ACCOUNT","account.php");
	define("MODULE_MANAGE","manage.php");
	define("MODULE_ATTENDANCE","attendance.php");
	define("MODULE_STATS","stats.php");
	define("MODULE_TRAINER","trainer.php");
	define("MODULE_CLUB","club_report.php");
	define("MODULE_REPORT","report.php");
	define("RECEIPTS_REPORT","receipt.php");
	define("MODULE_CRM","crm.php");
        define("MODULE_ADDGYM","addgym.php");
        define("MODULE_OWNERUSER","owneruser.php");
	/* Super Admin Module Integration */
	define("MODULE_CLIENTADD","classes/mmadmin/clientadd.php");
	define("SA_ADMIN_COLLECTION", "classes/mmadmin/admincollection.php");
	define("SA_ORDER", "classes/mmadmin/order.php");
	define("SA_ENQUIRY", "classes/mmadmin/enquiry_su.php");
	define("SA_DUE", "classes/mmadmin/dueadmin.php");
	define("SA_FALLOWUP", "classes/mmadmin/duefallowup.php");
	define("SA_ORDER_FALLOWUP", "classes/mmadmin/order_fallowup.php");
	define("SA_SMS", "classes/mmadmin/sms.php");
	//MADMEC_MANAGE
	define("MODULE_MADMEC_MANAGE","classes/manage/madmec_manage.php");
	//Customer App Modules
	define("MODULE_CUSTOMER","classes/customer/customer.php");
?>