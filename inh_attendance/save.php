<?php
   include_once("include/checksession.php");
?>
<html>
<head>
<title>Attendance System</title>
<?php	
	$uid = $_GET["uid"];
	include_once("include/links.php");
	include_once("include/config.php");
	if($_GET["nwd2"]==1) 
	{
	   echo "<br><center><font color='red'>This day is already declared as Non Working Day ...</font></center>";
	}
	if($_GET["nwd2"]==3) 
	{
	   echo "<br><center><font color='red'>Half Leave is already declared for this employee ...</font></center>";
	}
	if($_GET["nwd2"]==2) 
	{
	   echo "<br><center><font color='red'>This day is already declared as Public Holiday ...</font></center>";
	}
	if($_GET["del"]==1)
	{
 	   echo"<br><center><font color='green'>The Day has been deleted</font></center>";
	}
	
?>

<script>
	function mychange() 
	{
		form1.action = "nwdays.php?declare=1&uid=<?php echo $uid?>";
		form1.submit();
		
	}
	function declare() 
	{
		tell = confirm("Are you sure to declare this day as Non Working Day?");
		if(tell) 
		{
			foruser = form1.select4.options[form1.select4.selectedIndex].text ;
				
			if (foruser=="All") 
			{
			    form1.action = "insertnwd.php?uid=<?php echo $uid?>";
			    form1.submit();
			}
			else 
			{
			    form1.action = "insertunwd.php?uid=<?php echo $uid?>";
			    form1.submit();
			}
		}
	}
</script>
</head>
	     <center><br><form name="form1" method="post" action="">
      
	  <table>
	         <tr><td>Select Date
			 <?php
			     if ( $_GET["declare"] == 1 )
				 	  echo '<input type="text"  name="date1" value ="'.$_POST["date1"].'" readonly >';		 
			     else
				      echo '<input type="text"  name="date1" value ="'. $_GET["cdate"].'" readonly >';
			   ?>	 		  
                
                <a href="#" border="0" id="atagclicked" onclick="calobj=this.parentNode.previousSibling;document.getElementById('calendarframe').style.display='inline';clicked='true';"><img id="btnimg" border="0" src="../attendance/calendaropen.gif" style="position:relative"></a>
                <iframe align="center" src="calendar.html" id="calendarframe" align="left" marginheight="0" marginwidth="0" scrolling="no"  style="position:absolute;z-index:100;display:none;width:160px;height:200px" frameborder="none"></iframe>
     
</center></td></tr></table> 


<body bgcolor="silver">

<br><center>

<table border="1">
  <tr>
    <th colspan="2" align="center">Declare Non Working Day</th>
  </tr>
  <tr></tr>
<?php
    if($_GET["declare"]==1) 
	{
		
		$datespecified = $_POST["date1"];
		$datespecified = split ("-",$datespecified);
		$year = $datespecified[0];
		
		$month = $datespecified[1];
	   
		$day = $datespecified[2];
				
		$foruser = $_POST["select4"];
		
		$holidaytype = $_POST["select5"];
	}
	else 
	{
		$month = date("m");
		$year = date("Y");
		$foruser = 0;
		$holidaytype = 0;
	} 
 	if( ($_GET["nwd"]==1) || ($_GET["nwd2"]==1) || ($_GET["nwd2"]==2) || ($_GET["nwd2"]==3) ) 
	{		
	   $month = $_GET["month"];
	   
	   $year = $_GET["year"];
	  
	   $foruser = $_GET["foruser"];
	   
	   $holidaytype = $_GET["holidaytype"];
	  
	}
?>
  <tr>
    <td>For</td>
    <td>
	    <select name="select4" onChange="mychange()">
               <option value="0">All</option>
<?php 
    $recordset = mysql_query("select * from users");
    while ($record = mysql_fetch_array($recordset))  
	{
           echo "<option value='",$record["uid"],"'>",$record["ulogin"],"</option>";
    }
?>
       </select> </td>
  </tr>
  <tr></tr>
  <tr>
    <td>Holiday Type</td>
    <td> <select name="select5">
        <option value="0">Full Leave</option>
        <option value="1">Half Leave</option>
		<option value="2">Public Holiday</option>
      </select> </td>
  </tr>
  <tr></tr>
  <tr>
    <td colspan="2" align="center">
        <input name="button1" type="button" value="Declare" onClick="declare()">
    </td>
  </tr>
</table>
<?php
   echo "<script language = 'javascript'>
		
	for(i=0; i< form1.select4.length; i++) 
	{
		if(form1.select4.options[i].value == ",$foruser,")
		{
	   	   form1.select4.options[i].selected = true;
		}
	}
	for(i=0; i< form1.select5.length; i++) 
	{
		if(form1.select5.options[i].value == ",$holidaytype,")
		{
	   	   form1.select5.options[i].selected = true;
		}
	}
	
	     </script>";
	
  	$sd =1;
	$ed = 31;
    $date1 = $year."-".$month."-".$sd;
	$date2 = $year."-".$month."-".$ed;
     /*
	$recordset5 = mysql_query("select * from nwdays where uid=".$foruser." and nwdate between '".$date1."' and '".$date2."' and holidaytype=0 order by nwdate");
	echo "<br><br><table border='1'><tr><th colspan='2'>Non Working Days of the Month</th></tr><tr>
	<td align='center'>Date</td><td align='center'>Delete</td></tr>";
	while($record5 = mysql_fetch_array($recordset5))
	{
	      echo "<tr><td align='center'>",$record5["nwdate"],"</td><td align='center'>
	            <a href='deletenwdays.php?nwid=",$record5["nwid"],"&uid=",$uid,"'>Delete</a></td></tr>";
	}
	echo"</table>";
	
	$recordset15 = mysql_query("select * from nwdays where uid=".$foruser." and nwdate between '".$date1."' and '".$date2."' and holidaytype=1 order by nwdate");
	echo "<br><br><table border='1'><tr><th colspan='2'>Half Working Days of the Month</th></tr><tr>
	<td align='center'>Date</td><td align='center'>Delete</td></tr>";
	while($record15 = mysql_fetch_array($recordset15))
	{
	      echo "<tr><td align='center'>",$record15["nwdate"],"</td><td align='center'>
 	            <a href='deletenwdays.php?nwid=",$record15["nwid"],"&uid=",$uid,"'>Delete</a></td></tr>";
	}*/
echo "<br><br>";
	    if($month==1||$month==3||$month==5||$month==7||$month==8||$month==10||$month==12) 
		{
	       $endday = 31; 
	    }
	    if($month==4||$month==6||$month==9||$month==11) 
		{
	       $endday = 30;
	    }
	    if($month==2)
	    {
		   if($year%4==0)
		   {
		   	  $endday = 29;
           }
	 	   else 
		   {
			  $endday = 28;
           }
        }
		
	    $count = 0;
	    $uid1 = array();
		$uname1 = array();
		$recordset = mysql_query ("select * from users");
		while ( $row = mysql_fetch_array($recordset) )
		{
		        $uid1["$count"] = $row["uid"];
				$uname1["$count"] = $row["ulogin"];
				$count++;
		}		  
	    if ( $foruser == 0 || $foruser == "All")
		{
		     echo "<table border=1>
			              <tr>
						      <th>User Name</th>
						      <th>Present</th>
	                          <th>Full Leaves</th>
			                  <th>Half Leaves</th>
			                  <th>Public Holidays</th>
			                  <th>Absent</th>
						  </tr>";    
		     for ( $i = 0; $i < $count; $i++)
			 {			 
		          $recordset = mysql_query("select * from presence where date between '".$date1."' and '".$date2."' and uid= '$uid1[$i]' ");
				  echo "<tr><td>".$uname1[$i]."</td>";
				  echo "<td>".mysql_num_rows($recordset)."</td>"; 
				  $present = mysql_num_rows($recordset);
				          
	              $recordset = mysql_query("select * from nwdays where uid= 0 and nwdate between '".$date1."' and '".$date2."' and holidaytype=0 order by nwdate");
				  echo "<td>".mysql_num_rows($recordset)."</td>"; 
				  $full = mysql_num_rows($recordset);
				  
				  $recordset = mysql_query("select * from nwdays where uid=".$uid1[$i]." and nwdate between '".$date1."' and '".$date2."' and holidaytype=1 order by nwdate");
				  echo "<td>".mysql_num_rows($recordset)."</td>"; 
				  $half = mysql_num_rows($recordset);
				  
				  $recordset = mysql_query("select * from nwdays where uid= 0 and nwdate between '".$date1."' and '".$date2."' and holidaytype=2 order by nwdate");
				  echo "<td>".mysql_num_rows($recordset)."</td>"; 
				  $public = mysql_num_rows($recordset);
				  
				   
				  $absent = $endday - $present - $full - $half - $public;
				  echo "<td>".$absent."</td></tr>";
				  
			}
	  }
	  else
	  {
	         $present = 0;
			 $full = 0;
			 $half = 0;
			 $public = 0;
			 $absent = 0;
        	 echo "<table border='1' >
	                      <tr>
		                      <th>Present</th>
							  <th>Full Leaves</th>
							  <th>Half Leaves</th>
							  <th>Public Holidays</th>
	                          <th>Absent</th>
		                  </tr>";
			 		    			  
			 $recordset = mysql_query("select * from presence where date between '".$date1."' and '".$date2."' and uid = $foruser order by date ");
			 while ( $row = mysql_fetch_array($recordset) )
			 {
			         echo "<tr><td>".$row["date"]."</td></tr>"; 
					 $present++;
			 }
			 
			 echo "<tr><th>Full Leaves</th></tr>";		 
			 $recordset = mysql_query("select * from nwdays where uid= 0 and nwdate between '".$date1."' and '".$date2."' and holidaytype=0 order by nwdate");
			 while ( $row = mysql_fetch_array($recordset) )
			 {
			         echo "<tr><td>".$row["nwdate"]."</td></tr>"; 
					 $full++;
			 }
			 
			 echo "<tr><th>Half Leaves</th></tr>";		 
			 $recordset = mysql_query("select * from nwdays where uid=".$foruser." and nwdate between '".$date1."' and '".$date2."' and holidaytype=1 order by nwdate");
			 while ( $row = mysql_fetch_array($recordset) )
			 {
			         echo "<tr><td>".$row["nwdate"]."</td></tr>"; 
					 $half++;
			 }
			 
			 echo "<tr><th>Public Holidays</th></tr>";		 
			 $recordset = mysql_query("select * from nwdays where uid= 0 and nwdate between '".$date1."' and '".$date2."' and holidaytype=2 order by nwdate");
			 while ( $row = mysql_fetch_array($recordset) )
			 {
			         echo "<tr><td>".$row["nwdate"]."</td></tr>"; 
					 $public++;
			 }
			 
			 echo "<tr><th>Absent</th></tr>";		 
			 $recordset = mysql_query("select * from nwdays where nwdate between '".$date1."' and '".$date2."' order by nwdate");			  
			 $recordset1 = mysql_query("select * from presence where date between '".$date1."' and '".$date2."' order by date");			  
			 $flag = 0;
			 if ( $month == Date("m") )
			 {
			      for ( $i = 1; $i <= Date("d"); $i++)
				  { 
				        $testingdate = $year."-".$month."-".$i; 
                        
						while ( $row = mysql_fetch_array($recordset) )
						{
						        if ( $testingdate == $row["nwdate"] )
								{
								     $flag = 1;
								}
					    }
						if ( $flag <> 1 )
						{ 				 
					        while ( $row1 = mysql_fetch_array($recordset1) )
						    {
						            if ( $testingdate == $row1["nwdate"] )
						            {
									     $flag = 1;
									}
						     }
						 }
						 if ( $flag == 0 )
						 {
						      echo "<tr><td>".$testingdate."</td></tr>";
							  $absent++;
						 }	  	 				  
				    }
			 }
			 else
			 {
			        for ( $i = 1; $i <= $endday; $i++)
				    { 
				        $testingdate = $year."-".$month."-".$i; 
                        
						while ( $row = mysql_fetch_array($recordset) )
						{
						        if ( $testingdate == $row["nwdate"] )
								{
								     $flag = 1;
								}
					    }
						if ( $flag <> 1 )
						{ 				 
					        while ( $row1 = mysql_fetch_array($recordset1) )
						    {
						            if ( $testingdate == $row1["nwdate"] )
						            {
									     $flag = 1;
									}
						     }
						 }
						 if ( $flag == 0 )
						 {
						      echo "<tr><td>".$testingdate."</td></tr>";
							  $absent++;
						 }	  	 				  
				    }
			 }			 
	   }	        		  
						  			   
	?>	   
	</table>
  </form>
<div align="center"><align='center'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body> </html>
