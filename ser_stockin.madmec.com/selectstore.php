<?php
session_start();
if(!isset($_SESSION['username'])){ // if session variable "username" does not exist.
header("location:index.php?msg=Please%20login%20to%20access%20admin%20area%20!&type=error"); // Re-direct to index.php
}
list($storeid,$storename)=  explode(',', $_GET['storeid']);
$_SESSION['storeid']=$storeid;
$_SESSION['storename']=$storename;
header("Location:dashboard.php");
?>

