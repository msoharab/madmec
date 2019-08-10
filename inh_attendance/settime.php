<?php
	$uid = $_GET["uid"];
	//if($uid==""){
	//header("Location:login.php");
	//}
	include_once("include/config.php");
	//include_once("include\menu.php");
	
	$date = date('Y-m-d');
	$settime = date('H:i');
	$query = "update presence set timeout = '".$settime."' where uid=".$uid." and date='".$date."'";
	$af = mysql_query($query);
	if($_GET["admin"]==1){
	header("Location:admin.php?uid=".$uid);
	
	} else{
	header("Location:home.php?uid=".$uid);
	
	}
	
?>

