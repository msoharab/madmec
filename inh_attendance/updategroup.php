<?php 
	$uid = $_GET["uid"];
	$gid =$_GET["gid"];
	include_once("include/config.php");
	$groupname = $_POST["textfield1"];
	$absentfine = $_POST["textfield2"];
	$hoursfine = $_POST["textfield3"];
	
	$query = "update groups set absentfine='$absentfine', hoursfine='$hoursfine' where gid=".$gid;
	
	$af = mysql_query($query);
	if($af>=1){
	header("Location:groups.php?uid=".$uid);
	exit;
	}
	
?>
