<?php
   include_once("include/checksession.php");
   $uid = $_GET["uid"];
?>
<?php		
	include_once("include/config.php");
	
?>
<html>
<head>
<title>Attendance System</title>
<script>
	function mychange() 
	{
		document.form1.action = "nwdays.php?declare=1&uid=<?php echo $uid?>";		
		document.form1.submit();
		
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
<style>
body,td,th {
	font-family: Verdana;
	font-size: 13px;		
}
</style>
<body bgcolor="#f2f2f2">
<form name="form1" method="post" action="">
      

<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="2">
				
					<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
					<!-- fwtable fwsrc="sub.png" fwbase="user.jpg" fwstyle="Dreamweaver" fwdocid = "255186328" fwnested="0" -->
					  <tr>
					   <td><img src="images/spacer.gif" width="17" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="74" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="28" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="12" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="25" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="21" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="299" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="29" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="18" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="34" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="18" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="28" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="15" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="41" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="8" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="41" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="11" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="30" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="11" height="1" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="1" height="1" border="0" alt=""></td>
					  </tr>
					
					  <tr>
					   <td colspan="19"><img name="user_r1_c1" src="images/user_r1_c1.jpg" width="760" height="5" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="1" height="5" border="0" alt=""></td>
					  </tr>
					  <tr>
					   <td colspan="7"><img name="user_r2_c1" src="images/user_r2_c1.jpg" width="476" height="45" border="0" alt=""></td>
					   <td><a href="admin.php?uid=<?php echo $uid?>"><img name="user_r2_c8" src="images/user_r2_c8.jpg" width="29" height="45" border="0" alt=""></a></td>
					   <td><img name="user_r2_c9" src="images/user_r2_c9.jpg" width="18" height="45" border="0" alt=""></td>
					   <td><a href="pass.php?uid=<?php echo $uid?>"><img name="pass_r2_c7" src="images/pass_r2_c7.jpg" width="39" height="45" border="0" alt=""></a></td>
					   <td><img name="user_r2_c11" src="images/user_r2_c11.jpg" width="18" height="45" border="0" alt=""></td>
					   <td><a href="aureports.php?uid=<?php echo $uid?>"><img name="user_r2_c12" src="images/user_r2_c12.jpg" width="28" height="45" border="0" alt=""></a></td>
					   <td><img name="user_r2_c13" src="images/user_r2_c13.jpg" width="15" height="45" border="0" alt=""></td>
					   <td><a href="nwdays.php?show=1&uid=<?php echo $uid?>"><img name="attendance_r2_c14" src="images/attendance_r2_c14.jpg" width="41" height="45" border="0" alt=""></a></td>
					   <td><img name="user_r2_c15" src="images/user_r2_c15.jpg" width="8" height="45" border="0" alt=""></td>
					   <td><a href="news.php?uid=<?php echo $uid?>"><img name="user_r2_c16" src="images/user_r2_c16.jpg" width="41" height="45" border="0" alt=""></a></td>
					   <td><img name="user_r2_c17" src="images/user_r2_c17.jpg" width="11" height="45" border="0" alt=""></td>
					   <td><a href="logout.php"><img name="user_r2_c18" src="images/user_r2_c18.jpg" width="30" height="45" border="0" alt=""></a></td>
					   <td><img name="user_r2_c19" src="images/user_r2_c19.jpg" width="11" height="45" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="1" height="45" border="0" alt=""></td>
					  </tr>
					  <tr>
					   <td colspan="19"><img name="user_r3_c1" src="images/user_r3_c1.jpg" width="760" height="34" border="0" alt=""></td>
					   <td><img src="images/spacer.gif" width="1" height="34" border="0" alt=""></td>
					  </tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top">
					<table width="160" cellpadding="0" cellspacing="0">
						 <br><br><br><br><br><br><br><br><br>
						  <tr>
						   <td colspan="6" valign="bottom"><img name="user_r10_c1" src="images/user_r10_c1.jpg" width="177" height="293" border="0" alt=""></td>
						   <td><img src="images/spacer.gif" width="1" height="293" border="0" alt=""></td>
						  </tr>
					</table>

				</td>
				<td valign="top"><br>
				
			<?php	
			    if($_GET["nwd2"]==1) 
					{
					   echo "<center><font color='red'>Full Leave is already declared for this employee ...</font></center><br>";
					}
					if($_GET["nwd2"]==3) 
					{
					   echo "<center><font color='red'>Half Leave is already declared for this employee ...</font></center><br>";
					}
					if($_GET["nwd2"]==2) 
					{
					   echo "<center><font color='red'>This day is already declared as Public Holiday ...</font></center><br>";
					}
					if($_GET["nwd2"]==4) 
					{
					   echo "<center><font color='red'>Absent is already declared ...</font></center><br>";
					}
					if($_GET["del"]==1)
					{
					   echo"<center><font color='green'>The Day has been deleted</font></center><br>";
					}
					
	      ?>
	
				    <center><table>
						 <tr><td>Select Date
						 <?php
							 if ( $_GET["declare"] == 1 )
								  echo '<input type="text"  name="date1" value ="'.$_POST["date1"].'" readonly >';		 
							 elseif ( $_GET["show"] == 1 )
									  echo '<input type="text"  name="date1" value ="'. Date("Y-m-d").'" readonly >';
							 else				      
									  echo '<input type="text"  name="date1" value ="'. $_GET["cdate"].'" readonly >';	  
					     ?>	 		  
										
							<a href="#" border="0" id="atagclicked" onclick="calobj=this.parentNode.previousSibling;document.getElementById('calendarframe').style.display='inline';clicked='true';"><img id="btnimg" border="0" src="../attendance/calendaropen.gif" style="position:relative"></a>
							<iframe align="center" src="calendar.html" id="calendarframe" align="left" marginheight="0" marginwidth="0" scrolling="no"  style="position:absolute;z-index:100;display:none;width:160px;height:200px" frameborder="none"></iframe>
							 
						</td></tr></table> 
						
							<br>
									
								<table border="1">
									  <tr>
										<th colspan="2" align="center">Declare Non Working Day</th>
									  </tr>
									  <tr></tr>
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
											<option value="2">Holiday</option>
											<option value="3">Absent</option>
										  </select> </td>
									  </tr>
									  <tr></tr>
									  <tr>
										<td colspan="2" align="center">
											<input name="button1" type="button" value="Declare" onClick="declare()">
										</td>
									  </tr>
								</table></center>
								
								<?php
										if($_GET["declare"]==1) 
										{
											
											$datespecified = $_POST["date1"];
											if ( $datespecified == "" )
												 $datespecified = Date("Y-m-d");
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
										if( ($_GET["nwd"]==1) || ($_GET["nwd2"]==1) || ($_GET["nwd2"]==2) || ($_GET["nwd2"]==3) || ($_GET["nwd2"]==4) ) 
										{		
										   $month = $_GET["month"];
										   
										   $year = $_GET["year"];
										  
										   $foruser = $_GET["foruser"];
										   
										   $holidaytype = $_GET["holidaytype"];
										  
										}
										if( $_GET["del"] == 1  ) 
										{
										   $datespecified = $_GET["cdate"];
										   if ( $datespecified == "" )
												$datespecified = Date("Y-m-d");
														
										   $datespecified = split ("-",$datespecified);
										   
										   $year = $datespecified[0];
											
										   $month = $datespecified[1];
										   
										   $day = $datespecified[2];
										  
										   $foruser = $_GET["foruser"];
										   
										   $holidaytype = $_GET["holidaytype"];
										  
										}
									?>
									 
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
										
										echo "<br>";
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
																  <th>Presents</th>
																  <th>Full Leaves</th>
																  <th>Half Leaves</th>
																  <th>Holidays</th>
																  <th>Absents</th>
															  </tr>";    
												 for ( $i = 0; $i < $count; $i++)
												 {
													  $absent = 0;			 
													  $recordset = mysql_query("select * from presence where date between '".$date1."' and '".$date2."' and uid= '$uid1[$i]' ");
													  echo "<tr><td >".$uname1[$i]."</td>";
													  echo "<td align='center'>".mysql_num_rows($recordset)."</td>"; 
													  $present = mysql_num_rows($recordset);
															  
													  $recordset = mysql_query("select * from nwdays where uid=".$uid1[$i]." and nwdate between '".$date1."' and '".$date2."' and holidaytype=0 order by nwdate");
													  echo "<td align='center'>".mysql_num_rows($recordset)."</td>"; 
													  $full = mysql_num_rows($recordset);
													  
													  $recordset = mysql_query("select * from nwdays where uid=".$uid1[$i]." and nwdate between '".$date1."' and '".$date2."' and holidaytype=1 order by nwdate");
													  echo "<td align='center'>".mysql_num_rows($recordset)."</td>"; 
													  $half = mysql_num_rows($recordset);
													  
													  $recordset = mysql_query("select * from nwdays where uid= 0 and nwdate between '".$date1."' and '".$date2."' and holidaytype=2 order by nwdate");
													  echo "<td align='center'>".mysql_num_rows($recordset)."</td>"; 
													  $public = mysql_num_rows($recordset);
													  
													  $recordset = mysql_query("select * from nwdays where uid=".$uid1[$i]." and nwdate between '".$date1."' and '".$date2."' and holidaytype=3 order by nwdate");
													  echo "<td align='center'>".mysql_num_rows($recordset)."</td>"; 
													  $absent = mysql_num_rows($recordset);
													  
													  
																				  
													  
													  
												}
										  }
										  else
										  {
												 $present = 0;
												 $full = 0;
												 $half = 0;
												 $public = 0;
												 $absent = 0;
											?>
												 <table border="1">
												 <tr>
												 <td valign="top"><table>
												 <tr><th>Presents</th></tr>
												<?php
												 $recordset = mysql_query("select * from presence where date between '".$date1."' and '".$date2."' and uid = $foruser order by date ");		    			  			 
												 while ( $row = mysql_fetch_array($recordset) )
												 {
															  
														 if ( $_GET["nwd"] == 1 || $_GET["del"] == 1)
															  echo "<tr><td width='140' align='center'>".$row["date"]." <a href='deletenwdays.php?pid=",$row["pid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_GET["cdate"],"'>Delete</a></td></tr>"; 
														 else	  
															  echo "<tr><td width='140' align='center'>".$row["date"]." <a href='deletenwdays.php?pid=",$row["pid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_POST["date1"],"'>Delete</a></td></tr>"; 
														 $present++;
												 }
												 
												 echo"</table></td>
												  <td valign='top'><table>		 
												  <tr><th>Full Leaves</th></tr>";
												 $recordset = mysql_query("select * from nwdays where uid=".$foruser." and nwdate between '".$date1."' and '".$date2."' and holidaytype=0 order by nwdate");
												 while ( $row = mysql_fetch_array($recordset) )
												 {
														 if ( $_GET["nwd"] == 1 || $_GET["del"] == 1)
															  echo "<tr><td width='140' align='center'>".$row["nwdate"]." <a href='deletenwdays.php?nwid=",$row["nwid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_GET["cdate"],"'>Delete</a></td></tr>"; 
														 else	  
															  echo "<tr><td width='140' align='center'>".$row["nwdate"]." <a href='deletenwdays.php?nwid=",$row["nwid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_POST["date1"],"'>Delete</a></td></tr>"; 
														 $full++;
												 }
												 
												 echo"</table></td>
												  <td valign='top'><table >		 
												  <tr><th>Half Leaves</th></tr>";		 
												 $recordset = mysql_query("select * from nwdays where uid=".$foruser." and nwdate between '".$date1."' and '".$date2."' and holidaytype=1 order by nwdate");
												 while ( $row = mysql_fetch_array($recordset) )
												 {
														 if ( $_GET["nwd"] == 1 || $_GET["del"] == 1)
															  echo "<tr><td width='140' align='center'>".$row["nwdate"]." <a href='deletenwdays.php?nwid=",$row["nwid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_GET["cdate"],"'>Delete</a></td></tr>"; 
														 else	  
															  echo "<tr><td width='140' align='center'>".$row["nwdate"]." <a href='deletenwdays.php?nwid=",$row["nwid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_POST["date1"],"'>Delete</a></td></tr>"; 
														 $half++;
												 }
												 
												  echo"</table></td>
												  <td valign='top'><table>		 
												  <tr><th>Holidays</th></tr>";		 
												 $recordset = mysql_query("select * from nwdays where uid= 0 and nwdate between '".$date1."' and '".$date2."' and holidaytype=2 order by nwdate");
												 while ( $row = mysql_fetch_array($recordset) )
												 {
														 if ( $_GET["nwd"] == 1 || $_GET["del"] == 1)
															  echo "<tr><td width='140' align='center'>".$row["nwdate"]." <a href='deletenwdays.php?nwid=",$row["nwid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_GET["cdate"],"'>Delete</a></td></tr>"; 
														 else	  
															  echo "<tr><td width='140' align='center'>".$row["nwdate"]." <a href='deletenwdays.php?nwid=",$row["nwid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_POST["date1"],"'>Delete</a></td></tr>"; 
														 $public++;
												 }
												 
												 echo"</table></td>
												  <td valign='top'><table >		 
												  <tr><th>Absents</th></tr>";		 
												 $recordset = mysql_query("select * from nwdays where uid=".$foruser." and nwdate between '".$date1."' and '".$date2."' and holidaytype=3 order by nwdate");
												 while ( $row = mysql_fetch_array($recordset) )
												 {
														 if ( $_GET["nwd"] == 1 || $_GET["del"] == 1)
															  echo "<tr><td width='140' align='center'>".$row["nwdate"]." <a href='deletenwdays.php?nwid=",$row["nwid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_GET["cdate"],"'>Delete</a></td></tr>"; 
														 else	  
															  echo "<tr><td width='140' align='center'>".$row["nwdate"]." <a href='deletenwdays.php?nwid=",$row["nwid"],"&uid=".$uid."&holidaytype=",$holidaytype,"&foruser=",$foruser,"&cdate=",$_POST["date1"],"'>Delete</a></td></tr>"; 
														 $absent++;
												 }
												 
												
															  
										
										echo "</table><tr><th align='center'>$present</th>
																 <th align='center'>$full</th>
																 <th align='center'>$half</th>
																 <th align='center'>$public</th>
																 <th align='center'>$absent</th>
																 </tr></table>";
											   }					 
																					   
										?>	   
										
									  </form>
								
			</td></tr>
			
			
			
			</table>
		</td>
	</tr>
</table>
<div align="center"><align='center'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
