<?php
   include_once("include/uchecksession.php");
   $uid = $_SESSION["uid"];
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
<meta http-equiv="Content-Type" content="text/html;">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Mon Aug 22 13:42:02 GMT+0500 (West Asia Standard Time) 2005-->
</head>
<body bgcolor="#f2f2f2">
<form name="form1" method="post" action="ureports.php?show=1&uid=<?php echo $uid?>">
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="sub2.png" fwbase="management.jpg" fwstyle="Dreamweaver" fwdocid = "255186328" fwnested="0" -->
  <tr>
   <td><img src="images/spacer.gif" width="476" height="1" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="29" height="1" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="18" height="1" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="34" height="1" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="18" height="1" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="21" height="1" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="7" height="1" border="0" alt=""></td>
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
   <td colspan="14"><img name="management_r1_c1" src="images/management_r1_c1.jpg" width="760" height="5" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="1" height="5" border="0" alt=""></td>
  </tr>
  <tr>
   <td><img name="management_r2_c1" src="images/management_r2_c1.jpg" width="476" height="45" border="0" alt=""></td>
   <td colspan="3">&nbsp;</td>
   <td><img name="management_r2_c5" src="images/management_r2_c5.jpg" width="18" height="45" border="0" alt=""></td>
   <td colspan="2"><a href="home.php"><img name="management_r2_c2" src="images/management_r2_c2.jpg" width="29" height="45" border="0" alt=""></a></td>
   <td>&nbsp;</td>
   <td><a href="pass.php"><img src="images/attendance_r2_c7.jpg" width="39" height="45" border="0"></a></td>
   <td><img name="management_r2_c12" src="images/management_r2_c12.jpg" width="11" height="45" border="0" alt=""></td>
   <td><a href="ureports.php"><img name="attendance_r2_c9" src="images/attendance_r2_c9.jpg" width="34" height="45" border="0" alt=""></a></td>
   <td><img name="management_r2_c10" src="images/management_r2_c10.jpg" width="8" height="45" border="0" alt=""></td>
   
   <td><a href="logout.php"><img name="management_r2_c13" src="images/management_r2_c13.jpg" width="30" height="45" border="0" alt=""></a></td>
   <td><img name="management_r2_c14" src="images/management_r2_c14.jpg" width="11" height="45" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="1" height="45" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="14"><img name="management_r3_c1" src="images/management_r3_c1.jpg" width="760" height="36" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="1" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="14" rowspan="2">
   
   <table width="100%" height="100%" border="0">
     <tr><br><br>
       <th width="26%" valign="middle" scope="col"><img name="management_r5_c7" src="images/management_r5_c7.jpg" width="164" height="143" border="0" alt=""></th>
       <td width="74%" scope="col" valign="top">
			<center><table border="0" >
					  <tr><td align="left">Select Month</td>
						<td align="left"><select name="select1">
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
					  <td align="left"><select name="select2">
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
					  </table>
					<br>
					<table border="1" cellpadding="2" cellspacing="2">
					<tr><th>Date</th><th>Day</th><th>Time In</th><th>Time Out</th><th>Time Spent</th></tr>
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
							
							$date1 = $year."-".$month."-".$startday;
							$date2 = $year."-".$month."-".$endday;
														
							$recordset5 = mysql_query("select * from nwdays where nwdate between '".$date1."' and '".$date2."' and 
							(uid=0 or (uid=".$uid." and holidaytype=0)) order by nwdate");
							$days = 0;
							while($record5 = mysql_fetch_array($recordset5)) {
								$days = $days + 1;
							}
							$wdays = $endday - $days;
							//$whours = $wdays *8;
						$query = "select * from users where uid =".$uid;
						$recordset = mysql_query($query);
						while($record = mysql_fetch_array($recordset)) {
						$whours1 = $record["uwhours"];
						$whours = $wdays * $whours1;
						$totaltime = 0;
						$query1 = "select * from presence where uid =".$uid." and date between '".$date1."' and '".$date2."' order by date";
						$recordset1 = mysql_query($query1);
						while($record1 = mysql_fetch_array($recordset1)) {
						$timein = $record1["timein"];
						$timeout = $record1["timeout"];
						$daytime = calculate($timein, $timeout);
						$totaltime = $totaltime + $daytime;
						
						$dtimehm = explode(".",$daytime,2);
						$hours = $dtimehm[0];
						$dtimehm = split(".",$daytime,2);
						$minutes = round ($dtimehm[1]*60,0);
						if ($minutes >59) {$minutes = $minutes%60;}
						$div = $minutes/10;
						if($div<1) {$minutes = "0".$minutes;}
						$daytime = $hours.":".$minutes;
						
						echo"<tr><td align='center'>",$record1["date"],"</td><td align='center'>",$record1["pday"],"</td>
						<td align='center'>",$timein,"</td><td align='center'>",$timeout,"</td><td align='center'>",$daytime,"</td></tr>";
						
						//$timespent = split(":",$timein,2);
						//print_r($timespent);
						}
						$ttimehm = explode(".",$totaltime,2);
						$hours = $ttimehm[0];
						$ttimehm = split(".",$totaltime,2);
						$minutes = round ($ttimehm[1]*60,0);
						if ($minutes >59) {$minutes = $minutes%60;}
						$div = $minutes/10;
						if($div<1) {$minutes = "0".$minutes;}
						$totaltime = $hours.":".$minutes;
						
						echo"</table>";
						echo"<table><tr><th align='left'>Total Time Spent in this Month</th><th>",$totaltime,"</th></tr>
						<tr><th align='left'>Total Time Required for this Month </th><th>",$whours,"</th></tr></table>";
						}
					?>
					
					</table>
					</center>
					</form>

           </td>
     </tr>
	 
	 </table></td>
   <td><img src="images/spacer.gif" width="1" height="321" border="0" alt=""></td>
  </tr>
  
  <tr>
   <td><img src="images/spacer.gif" width="1" height="143" border="0" alt=""> </td>
  </tr>
</table>
<div align="center"><align='center'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
