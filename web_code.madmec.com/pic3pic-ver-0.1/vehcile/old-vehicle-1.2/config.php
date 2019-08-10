<?php

	$temp = rtrim($_SERVER['DOCUMENT_ROOT'],"/");
	$temp = explode("/",$temp);
	$config_root = str_replace($temp[count($temp)-1],"library/".$temp[count($temp)-1],$_SERVER['DOCUMENT_ROOT'])."/";
	define("CONFIG_ROOT",$config_root );
		//Modules DAO Classes Constants
        define("DAO_VEHICLE", "vehicle.php");
        define("DAO_VENDOR", "vendor.php");
        define("DAO_USER", "user.php");
        define("DAO_COMPLAINTS", "complaints.php");
        define("DAO_REPORT", "report.php");
        define("DAO_CHANGEPASSWORD", "changepassword.php");

        define("DAO_VENDORPROFILE", "vendorprofile.php");
        define("DAO_USERVEHICLE", "uservehicle.php");
        define("DAO_USERAPPOINTMENT", "userappointment.php");
        define("DAO_USERHISTORY", "userhistory.php");
        define("DAO_USERPROFILE", "userprofile.php");

?>
