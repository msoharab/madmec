<?php
	session_start();
	error_reporting(0);
	date_default_timezone_set('Asia/Kolkata');

	/* Database constraints */
	define("DBHOST","localhost");
	define("DBUSER","root");
	// define("DBPASS","9743967575");
	define("DBPASS","madmec@418133");
	define("DBNAME_MAST","madmec_data");
	define("DBNAME_ZERO","ser_autotrade-master");
	
	// define("URL","http://local.auto.autotrade.com/");
	//define("URL","http://autotrade.localmm.com/");
	define("URL","http://autotrade.madmec.com/");
?>
