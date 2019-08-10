<?php

session_start();
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_database = "infinizy";
//$mysql_password = "9743967575";
$mysql_password = "madmec@418133";
$prefix = "";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");



