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
<style>
body,td,th {
	font-family: Verdana;
	font-size: 13px;		
}
</style>
<body bgcolor="#f2f2f2">
<form name="form1" method="post" action="fine.php?show=1&uid=<?php echo $uid?>" >

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
					   <td><a href="aureports.php?uid=<?php echo $uid?>"><img name="attendance_r2_c12" src="images/attendance_r2_c12.jpg" width="28" height="45" border="0" alt=""></a></td>
					   <td><img name="user_r2_c13" src="images/user_r2_c13.jpg" width="15" height="45" border="0" alt=""></td>
					   <td><a href="nwdays.php?show=1&uid=<?php echo $uid?>"><img name="user_r2_c14" src="images/user_r2_c14.jpg" width="41" height="45" border="0" alt=""></a></td>
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
						<tr>
						   <td colspan="6" valign="top"><img name="user_r4_c1" src="images/user_r4_c1.jpg" width="177" height="24" border="0" alt=""></td>
						   <td rowspan="7" colspan="13"><p>&nbsp;</p>
							<p>&nbsp;</p>    </td>
						   <td><img src="images/spacer.gif" width="1" height="24" border="0" alt=""></td>
						  </tr>
						  <tr>
						   <td colspan="4" valign="top"><a href="aureports.php?uid=<?php echo $uid?>"><img name="user_r7_c2" src="images/user_r7_c2.jpg" width="139" height="30" border="0" alt=""></a></td>
						   <td rowspan="3">&nbsp;</td>
						   <td><img src="images/spacer.gif" width="1" height="30" border="0" alt=""></td>
						  </tr>
						  <tr>
						   <td colspan="5" valign="top"><a href="user.php?uid=<?php echo $uid?>"><img name="user_r6_c2" src="images/user_r6_c2.jpg" width="160" height="31" border="0" alt=""></a></td>
						   <td><img src="images/spacer.gif" width="1" height="31" border="0" alt=""></td>
						  </tr>
						  
						  <tr>
						   <td valign="top"><a href="fine.php?uid=<?php echo $uid?>"><img name="sub_r8_c2" src="images/sub_r8_c2.jpg" width="74" height="30" border="0" alt=""></a></td>
						   <td colspan="3">&nbsp;</td>
						   <td><img src="images/spacer.gif" width="1" height="30" border="0" alt=""></td>
						  </tr>
						  <tr>
						   <td colspan="2" valign="top"><a href="groups.php?uid=<?php echo $uid?>"><img name="user_r9_c2" src="images/user_r9_c2.jpg" width="102" height="31" border="0" alt=""></a></td>
						   <td colspan="2">&nbsp;</td>
						   <td><img src="images/spacer.gif" width="1" height="31" border="0" alt=""></td>
						  </tr>
						  <tr>
						   <td colspan="6" valign="bottom"><img name="user_r10_c1" src="images/user_r10_c1.jpg" width="177" height="293" border="0" alt=""></td>
						   <td><img src="images/spacer.gif" width="1" height="293" border="0" alt=""></td>
						  </tr>
					</table>

				</td>
				<td valign="top"><br>
					<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td valign="top">
								<center><table border="0" >
									  <tr><td align="left">Select Month</td>
										<td align="right"><select name="select1">
										  <option value="1">January</option>
										  <option value="2">February</option>
										  <option value="3">March</option>
										  <option value="4">April</option>
										  <option value="5">May</option>
										  <option value="6">June</option>
										  <option value="7">July</option>
										  <option value="8">August</option>
										  <option value="9">September</option>
										  <option value="10">October</option>
										  <option value="11">November</option>
										  <option value="12">December</option>
										</select></td>
									  </tr>
									  <tr><td align="left">Select Year</td>
									  <td align="right"><select name="select2">
									  <option value="2004">2004</option><option value="2005">2005</option>
									  <option value="2006">2006</option><option value="2007">2007</option>
									  <option value="2008">2008</option><option value="2009">2009</option>
									  <option value="2010">2010</option><option value="2011">2011</option>
									  <option value="2012">2012</option><option value="2013">2013</option>
									  <option value="2014">2014</option><option value="2015">2015</option>
									  <option value="2016">2016</option><option value="2017">2017</option>
									  <option value="2018">2018</option><option value="2019">2019</option>
									  <option value="2020">2020</option><option value="2021">2021</option>
									  <option value="2022">2022</option><option value="2023">2023</option>
									  <option value="2024">2024</option><option value="2025">2025</option>
									  <option value="2026">2026</option><option value="2027">2027</option>
									  <option value="2028">2028</option><option value="2029">2029</option>
									  <option value="2030">2030</option><option value="2031">2031</option>
									  </select></td></tr>
									  <tr></tr>
									  <tr><td colspan="2" align="center">
									  <input type="submit" value="Show" name="button">
									  </td></tr>
									  </table></center>

											  
										<br>	  
											  
							  <table border="1" cellpadding="2" cellspacing="2" width="100%">
									<tr><th>User Name</th><th>Min Time Req.</th><th>Total Time Spent</th><th>Less Time</th>
									<th>Time Fine</th><th>Absents</th><th>Absent Fine</th><th>Total Fine </th>
									<?php 
										function calculate($timein, $timeout) {
										$timespentin = split(":",$timein,3);
										$timespentout = split(":",$timeout,3);
										//print_r($timespentin);
										//print_r($timespentout);
										$t1 = $timespentin[0]*60 + $timespentin[1];
										$t2 = $timespentout[0]*60 + $timespentout[1];
										$timespent = round(($t2 - $t1)/60,2);
										//echo $timespent;
										return $timespent;
										}
										if($_GET["show"]==1) {
											$month = $_POST["select1"];
											$year = $_POST["select2"];
										}else {
											$month = date("m");
											$year = date("Y");
										 }
										 $startday = 1;
										 if($month==1||$month==3||$month==5||$month==7||$month==8||$month==10||$month==12) {
											$endday = 31; 
										 }
										 if($month==4||$month==6||$month==9||$month==11) {
											$endday = 30;
										 }
										 if($month==2){
											if($year%4==0){
												$endday = 29;
											}else {
												$endday = 28;
											 }
										 }
										 echo "<script language = 'javascript'>
										form1.select1.options[",$month-1,"].selected = true;
										form1.select2.options[",$year-2004,"].selected = true;
										</script>";
											if ($month == date('m')) { $endday = date('d');}
											$date1 = $year."-".$month."-".$startday;
											$date2 = $year."-".$month."-".$endday;
											
											$recordset5 = mysql_query("select * from nwdays where nwdate between '".$date1."' and '".$date2."' and uid=0 order by nwdate");
											$days = 0;
											while($record5 = mysql_fetch_array($recordset5)) 
											{
												$days = $days + 1;
											}
											$wdays1 = $endday - $days;
											//$whours = $wdays *8;
										$query = "select * from users";
										$recordset = mysql_query($query);
										while($record = mysql_fetch_array($recordset)) 
										{
										
										$recordset15 = mysql_query("select * from nwdays where nwdate between '".$date1."' and '".$date2."' and uid=".$record["uid"]." and holidaytype=0 order by nwdate");
											$undays = 0;
											while($record15 = mysql_fetch_array($recordset15))
											{
												$undays = $undays + 1;
											}
										$recordset115 = mysql_query("select * from nwdays where nwdate between '".$date1."' and '".$date2."' and uid=".$record["uid"]." and holidaytype=1 order by nwdate");
										$halfleaves = 0;
										while($record115 = mysql_fetch_array($recordset115))
										{
											$halfleaves = $halfleaves + 1;
										}
											
										$wdays = $wdays1 - $undays;
										$whours1 = $record["uwhours"];
										$whours = $wdays * $whours1;
										
										$totaltime = 0;
										$presents = 0;
										
										$query1 = "select * from presence where uid =".$record["uid"]." and date between '".$date1."' and '".$date2."' order by date";
										$recordset1 = mysql_query($query1);
										while($record1 = mysql_fetch_array($recordset1)) 
										{
											  $timein = $record1["timein"];
											  $timeout = $record1["timeout"];
											  $totaltime = $totaltime + calculate($timein, $timeout);
											  $presents = $presents + 1;
										//$timespent = split(":",$timein,2);
										//print_r($timespent);
										}
										//$holidays = $wdays - $presents - $halfleaves;
										//if($holidays <0) 
										//{ 
										   //$holidays = 0; 
										//}
										
										$myquery = "select * from nwdays where uid =".$record["uid"]." and holidaytype=3 and nwdate between '".$date1."' and '".$date2."' order by nwdate";										
										$myrecordset = mysql_query($myquery);										
										$holidays = mysql_num_rows($myrecordset);										     
										
										$lesshours = $whours - $totaltime;
										$fineholidays = $holidays;
										if($fineholidays <0) 
										{ 
										   $fineholidays = 0; 
										}
										if($lesshours < 0)
										{
										   $lesshours = 0; 
										}
										
										$recordset9 = mysql_query("select * from configuration where setname='relaxedhours'");
										while($record9 = mysql_fetch_array($recordset9)) 
										{
											  $relaxedhours = $record9["setvalue"];
										}
										
										$finehours = $lesshours - $relaxedhours;
										if ($finehours < 0) { $finehours = 0;}
										$recordset8 = mysql_query("select * from groups where gname='".$record["ugroup"]."'");
										while ($record8 = mysql_fetch_array ($recordset8)) 
										{ 
											   $absentfine = $fineholidays * $record8["absentfine"];
											   $hoursfine = round ($finehours * $record8["hoursfine"],0);
											   $totalfine = $absentfine + $hoursfine;
										}
													
										$ttimehm = explode(".",$totaltime,2);
										$hours = $ttimehm[0];
										$ttimehm = split(".",$totaltime,2);
										$minutes = round ($ttimehm[1]*60,0);
										if ($minutes >59) {$minutes = $minutes%60;}
										$div = $minutes/10;
										if($div<1) {$minutes = "0".$minutes;}
										$totaltime = $hours.":".$minutes;
										
										$ltimehm = explode(".",$lesshours,2);
										$hours = $ltimehm[0];
										$ltimehm = split(".",$lesshours,2);
										$minutes = round ($ltimehm[1]*60,0);
										if ($minutes >59) {$minutes = $minutes%60;}
										$div = $minutes/10;
										if($div<1) 
										{
										   $minutes = "0".$minutes;
										}
										   $lesshours = $hours.":".$minutes;
										
										$latehours = 0;
										$daybuffer = 0;
										$myquery = "select * from presence where uid =".$record["uid"]." and date between '".$date1."' and '".$date2."' order by date";
										$myrecordset = mysql_query($myquery);
										while($row = mysql_fetch_array($myrecordset)) 
										{
											  $myflag = 0;
											  $myrecordset1 = mysql_query("select * from nwdays where uid = 0 and nwdate between '".$date1."' and '".$date2."' order by nwdate");
											  while ( $row1 = mysql_fetch_array($myrecordset1) )
											  {
													  if ( $row["date"] == $row1["nwdate"] )
														   $myflag = 1;
											  }
											  if ( $myflag == 0 )
											  {
												   $timein = $row["timein"];
												   $timein = split(":",$timein,3);
												   if ( $timein[0] >= 13 )
												   {
												         if ( $daybuffer > 3 )
														 {
														       $latehours = $latehours + (($timein[0] - 13) * 60) + $timein[1];
														 }	   
														 else
														 {		  
														         if ( $timein[0] >= 14 )
														         { 														   															  
															         $latehours = $latehours + (($timein[0] - 14) * 60) + $timein[1];
																 }
														  }		  	 
													      $daybuffer++;		 
												  }
											}		 	 
										 }          
										
											 if ( $latehours >= 60 )
											 {
												  $latehr = intval($latehours/60) ;
												  $latemin = $latehours%60;			 
											  }
											  else
											  {
												  $latehr = 0;
												  $latemin = $latehours;
											  }
											  
											  if ( $latemin <10 )
												   $latemin = "0".$latemin;
											  //$hoursfine = $hoursfine + $latehours;
											  //$totalfine = $totalfine + $latehours;	   
											  $latehours = $latehr.":".$latemin;	  

														
										echo"<tr><td align='left' width='55'>",$record["ulogin"],"</td><td align='center' width='75'>",$whours,"</td>
										         <td align='center' width='100'>",$totaltime,"</td><td align='center' width='50'>",$lesshours,"</td>
												 <td align='left' width='70'>Rs ",$hoursfine,"</td>
										         <td align='center'>",$holidays,"</td>
										         <td align='left' width='75'>Rs ",$absentfine,"</td>";
										         
										
										if($totalfine>0) 
										{
										   echo"<td align='left' width='70'>Rs <font color='red'>",$totalfine,"</td></tr></font>";
										} 
										else 
										{
										  echo"<td align='left' width='70'>Rs ",$totalfine,"</td></tr>";
										}	
									  }
									?>
									</tr>
									</table>

			</td></tr>
			
			
			
			</table>
		</td>
	</tr>
</table>
</form>
<div align="right"><align='right'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
