<?php
        session_start();
	error_reporting(0);
	define("DBHOST","localhost");
	define("DBUSER","root");
//	define("DBPASS","9743967575");
	 define("DBPASS","madmec@418133");
	// define("URL","http://mis.localmm.com/");
//	define("URL","http://local.automate.madmec.com/");
	 define("URL","http://automate.madmec.com/");
	define("DBNAME_MAST","madmec_data");

//	define("MASTER_DBNAME_ZERO","mis-master");
        $clientdb=isset($_SESSION["USER_LOGIN_DATA"]['slavedb']) ? $_SESSION["USER_LOGIN_DATA"]['slavedb'] : false;
//        echo $clientdb." db name";
        define("DBNAME_ZERO", "ser_automate-master");
//        define("DBNAME_ZERO", "mis-master");
?>