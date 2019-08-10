<?php
//$connection = mysql_connect("localhost", "root", "");
//$db = mysql_select_db("attendance", $connection);
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "9743967575";
$dbname = "attendance";

$conn = mysql_connect($dbhost, $dbuser, $dbpassword) or die ('Error connecting to mysql');
mysql_select_db($dbname);
?>
