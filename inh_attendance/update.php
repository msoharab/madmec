<?php 
	$uid = $_GET["uid"];
	$user =$_GET["user"];
	include_once("include/config.php");
	$login = $_POST["textfield1"];
	$pwd = $_POST["textfield2"];
	$desig = $_POST["select1"];
	$group = $_POST["select2"];
	$team = $_POST["select3"];
	$type = $_POST["textfield3"];
	$whours = $_POST["textfield4"];	
	
	$query = "update users set ulogin='$login', upassword='$pwd', udesignation='$desig', ugroup='$group',  
	uteam='$team', utype='$type', uwhours='$whours' where uid=".$user;
	
	$af = mysql_query($query);
    if($af>=1){
	header("Location:user.php?uid=".$uid);
	exit;
	 }
?>
