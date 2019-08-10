<?php 
	include_once("include/config.php");
	$uid = $_GET["uid"];
	$nwid = $_GET["nwid"];
	$pid = $_GET["pid"];
	$foruser = $_GET["foruser"];
	

	$holidaytype = $_GET["holidaytype"];
	
	$cdate = $_GET["cdate"];
	
	if ( $pid <> "" )
	{
	     $query = "delete from presence where pid =".$pid;
		 $af = mysql_query($query);
	     if($af>=1) 
		 {
	        header("Location:nwdays.php?del=1&uid=".$uid."&foruser=".$foruser."&holidaytype=".$holidaytype."&cdate=".$cdate);
	        exit;
	     }	 
	}
	if ( $nwid <> "" )
	{	 
	     $query = "delete from nwdays where nwid =".$nwid;
	     $af = mysql_query($query);
	     if($af>=1) 
		 {
	        header("Location:nwdays.php?del=1&uid=".$uid."&foruser=".$foruser."&holidaytype=".$holidaytype."&cdate=".$cdate);
	        exit;
		 }
	}
?>
