<?php
session_start();
include("db.class.php");

// Open the base (construct the object):
$rstoreid=$_SESSION['storeid'];
$base="fur_sapna_stock";
$server="localhost";
$user="root";
$pass="splasher777@yahoo.com";
$db = new DB($base, $server, $user, $pass);
/*

$base="arstock";
$server="arstock.db.5298872.hostedresource.com";
$user="arstock";
$pass="Reset123";
$db = new DB($base, $server, $user, $pass);
*/
?>