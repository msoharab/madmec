<?php
include_once("include/config.php");
	$uid = $_GET["uid"];
	$user = $_GET["user"];
	if($_GET["action"]==2){
	$query = "delete from users where uid =".$user;
	$query1 = "delete from presence where uid = ".$user;
	$af = mysql_query($query);
	mysql_query($query1);
		if($af>=1){
		header("Location:user.php?del=1&uid=".$uid);
		exit;
		}
	}
?>
