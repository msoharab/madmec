<?php 
	$uid = $_GET["uid"];
	$user = $_GET["user"];
	$pid = $_GET["pid"];
	include_once("include/config.php");
	$timein = $_POST["textfield3"];
	$timeout = $_POST["textfield4"];
	
	$query = "update presence set timein='$timein', timeout='$timeout' where pid=".$pid;
	
	$af = mysql_query($query);
	 if($af>=1){
	 header("Location:aureports.php?uid=".$uid."&cuser=".$user."&can=1");
	 exit;
	 }
?>
