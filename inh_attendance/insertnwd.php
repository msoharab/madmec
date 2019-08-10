<?php 
	$uid = $_GET["uid"];
	include_once("include/config.php");
	
	$holidaytype = $_POST["select5"];
	
	$count = 0;
	$datespecified = $_POST["date1"];
    
	$datespecified = split ("-",$datespecified);
	
	$year = $datespecified[0];
		
	$month = $datespecified[1];
	   
	$day = $datespecified[2]; 
	
	$nwd = $year."-".$month."-".$day;
	
	
	$all =0;
	
	if ( $holidaytype == 2)
	{
	    $recordset = mysql_query("select * from nwdays where nwdate = '".$nwd."' and uid=".$all." and holidaytype = 2");				
	    if ( mysql_num_rows($recordset) <> 0 )
	    {
		      $count = 1;
	    }
	    if($count == 1) 
	    {
	       header("Location:nwdays.php?nwd2=2&uid=".$uid."&month=".$month."&year=".$year."&foruser=".$all."&cdate=".$nwd."&holidaytype=".$holidaytype);
		   exit;
	    }
		
	 }	
	 if ( $holidaytype == 0)
	 {
	      $query = "select * from nwdays where nwdate = '".$nwd."' and uid=".$all." and holidaytype = 0" ;
	      $recordset = mysql_query($query);
		
		  if ( mysql_num_rows($recordset) <> 0)
		       $count = 1;
		  
		  
		 
	      if($count == 1) 
	      {
	         header("Location:nwdays.php?nwd2=1&uid=".$uid."&month=".$month."&year=".$year."&foruser=".$all."&cdate=".$nwd."&holidaytype=".$holidaytype);
			 exit;
	      }
		
	 }	 
	
	    $query = "insert into nwdays(nwdate,holidaytype) values ('$nwd',$holidaytype)";
	    $af = mysql_query($query);
	    mysql_query("delete from nwdays where nwdate = '".$nwd."' and uid!=".$all);
		mysql_query("delete from nwdays where nwdate = '".$nwd."' and uid=".$all." and holidaytype != $holidaytype");
	    if($af>=1) 
	    {
	       header("Location:nwdays.php?nwd=1&uid=".$uid."&month=".$month."&year=".$year."&foruser=".$all."&cdate=".$nwd."&holidaytype=".$holidaytype);
	    }
	 
?>
