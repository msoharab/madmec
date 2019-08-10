<?php
session_start(); // Use session variable on this page. This function must put on the top of page.
$ttstoreid=$_SESSION['storeid'];
define('STOREID', $ttstoreid);
if(!isset($_SESSION['username'])){ // if session variable "username" does not exist.
header("location:index.php?msg=Please%20login%20to%20access%20admin%20area%20!&type=error"); // Re-direct to index.php
}
error_reporting (E_ALL ^ E_NOTICE);
include("lib/db.class.php");
        if(!include_once "config.php"){
           header("location:install.php");
 }

// Open the base (construct the object):
$db = new DB($config['database'], $config['host'], $config['username'], $config['password']);

# Note that filters and validators are separate rule sets and method calls. There is a good reason for this. 
	require "lib/gump.class.php";

$gump = new GUMP(); 
// Messages Settings
$MADMEC = array();
$MADMEC['username'] = $_SESSION['username'];
$MADMEC['usertype'] = $_SESSION['usertype'];
$MADMEC['msg'] 		= '';
if(isset($_REQUEST['msg']) && isset($_REQUEST['type']) ) {
		
				if($_REQUEST['type'] == "error")
					$MADMEC['msg'] = "<div class='error-box round'>".$_REQUEST['msg']."</div>";
				else if($_REQUEST['type'] == "warning")
					$MADMEC['msg'] = "<div class='warning-box round'>".$_REQUEST['msg']."</div>"; 
				else if($_REQUEST['type'] == "confirmation")
					$MADMEC['msg'] = "<div class='confirmation-box round'>".$_REQUEST['msg']."</div>"; 
				else if($_REQUEST['type'] == "infomation")
					$MADMEC['msg'] = "<div class='information-box round'>".$_REQUEST['msg']."</div>"; 
}
?>