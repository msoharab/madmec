<?php 
session_start();
include_once("include/config.php");
$login = $_POST["textfield1"];
$pwd = $_POST["textfield2"];
$recordset = mysql_query("select * from users");
while($record = mysql_fetch_array($recordset)){
if($login == $record["ulogin"] && $pwd == $record["upassword"]) {

$_SESSION["ulogin"] = $record["ulogin"];
$_SESSION["uid"] = $record["uid"];  
        if($record["utype"] == 1){
        $_SESSION["utype"] = $record["utype"];
        header("Location:admin.php?uid=".$record["uid"]);
        exit;
        }else{
    header("Location:home.php");
    exit;
    }
 }
} 

       header("Location:login.php?invalid=1");  
   ?>
