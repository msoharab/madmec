<?php 
	$uid = $_GET["uid"];
	include_once("include/config.php");
	
	$datespecified = $_POST["date1"];
		
    $datespecified = split ("-",$datespecified);
	
	$year = $datespecified[0];
	
		
	$month = $datespecified[1];
	   
	$day = $datespecified[2]; 
	
	$foruser = $_POST["select4"];
	
	$holidaytype = $_POST["select5"];
	
	$nwd = $year."-".$month."-".$day;
	
	$all = 0;



    $recordset1 = mysql_query("select * from nwdays where nwdate = '".$nwd."' and uid=".$foruser." and holidaytype=1");
	if ( mysql_num_rows($recordset1) <> 0 ) 
	{
	      $count1 = 1;
	}
			
	if($count1 == 1) 
	{
       header("Location:nwdays.php?nwd2=3&uid=".$uid."&month=".$month."&year=".$year."&foruser=".$foruser."&holidaytype=".$holidaytype."&cdate=".$nwd);
	   exit;
	}
    $recordset = mysql_query("select * from nwdays where nwdate = '".$nwd."' and uid=".$foruser." and holidaytype= 0");
	if ( mysql_num_rows($recordset) <> 0 )
	{
		$count = 1;
	}
	if($count == 1) 
	{
	   header("Location:nwdays.php?nwd2=1&uid=".$uid."&month=".$month."&year=".$year."&foruser=".$foruser."&holidaytype=".$holidaytype."&cdate=".$nwd);
	   exit;
	} 
    $recordset = mysql_query("select * from nwdays where nwdate = '".$nwd."' and uid=".$foruser." and holidaytype= 3");
	if ( mysql_num_rows($recordset) <> 0 )
	{
		$count = 1;
	}
	if($count == 1) 
	{
	   header("Location:nwdays.php?nwd2=4&uid=".$uid."&month=".$month."&year=".$year."&foruser=".$foruser."&holidaytype=".$holidaytype."&cdate=".$nwd);
	   exit;
	}
	$recordset = mysql_query("select * from nwdays where nwdate = '".$nwd."' and uid=".$all." and holidaytype= 0");
	if ( mysql_num_rows($recordset) <> 0 )
	{
		$count = 1;
	}
	if($count == 1) 
	{
	   header("Location:nwdays.php?nwd2=1&uid=".$uid."&month=".$month."&year=".$year."&foruser=".$foruser."&holidaytype=".$holidaytype."&cdate=".$nwd);
	   exit;
	}
	$recordset = mysql_query("select * from nwdays where nwdate = '".$nwd."' and uid=".$all." and holidaytype= 2");
	if ( mysql_num_rows($recordset) <> 0 )
	{
		$count = 1;
	}
	if($count == 1) 
	{
	   header("Location:nwdays.php?nwd2=2&uid=".$uid."&month=".$month."&year=".$year."&foruser=".$foruser."&holidaytype=".$holidaytype."&cdate=".$nwd);
	   exit;
	}

	
			
	$query = "insert into nwdays(nwdate,uid,holidaytype) values ('$nwd','$foruser','$holidaytype')";
	$af = mysql_query($query);
	if($af>=1) 
	{
	   header("Location:nwdays.php?nwd=1&uid=".$uid."&month=".$month."&year=".$year."&foruser=".$foruser."&holidaytype=".$holidaytype."&cdate=".$nwd);
	}
	
?>
