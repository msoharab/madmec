<?php 
	$uid = $_GET["uid"];
	include_once("include/config.php");
	$login = $_POST["textfield1"];
	$pwd = $_POST["textfield2"];
	$desig = $_POST["select1"];
	$group = $_POST["select2"];
	$team = $_POST["select3"];
	$type = $_POST["textfield3"];
	$whours = $_POST["textfield4"];
	
	$query = "insert into users(ulogin, upassword, udesignation, ugroup, uteam, utype, uwhours) 
	values('$login', '$pwd', '$desig', '$group', '$team', '$type', '$whours')";
	
	$af = mysql_query($query);
	 if($af>=1){
	 header("Location:user.php?uid=".$uid);
	 exit;
	 }
?>
