<?php		
	include_once("include/checksession.php");
	$uid = $_GET["uid"];			
	include_once("include/config.php");
?>
<script language="javascript">
	
	function timeout() {
	document.form1.action = "settime.php?admin=1&uid=<?php echo $uid?>";
	document.form1.submit();
	}
</script>
<html>
<head>
<title>Attendance - Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Mon Aug 22 13:28:21 GMT+0500 (West Asia Standard Time) 2005-->
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana;
	font-size: 9px;
	color: #333333;
	
}
-->
</style>
</head>
<body bgcolor="#f2f2f2">
<form name="form1" method="post" action= "" >
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="attendance.png" fwbase="home.jpg" fwstyle="Dreamweaver" fwdocid = "255186328" fwnested="0" -->
	<tr>
	   <td><img src="images/spacer.gif" width="36" height="1" border="0" alt=""></td>
	   <td><img src="images/spacer.gif" width="218" height="1" border="0" alt=""></td>
	   <td><img src="images/spacer.gif" width="15" height="1" border="0" alt=""></td>
	   <td><img src="images/spacer.gif" width="207" height="1" border="0" alt=""></td>
	   <td><img src="images/spacer.gif" width="29" height="1" border="0" alt=""></td>
	   <td><img src="images/spacer.gif" width="18" height="1" border="0" alt=""></td>
	   <td><img src="images/spacer.gif" width="4" height="1" border="0" alt=""></td>
	   <td><img src="images/spacer.gif" width="30" height="1" border="0" alt=""></td>
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
	   <td colspan="17"><img name="home_r1_c1" src="images/home_r1_c1.jpg" width="760" height="5" border="0" alt=""></td>
	   <td><img src="images/spacer.gif" width="1" height="5" border="0" alt=""></td>
	</tr>
	<tr>
	   <td colspan="4"><img name="home_r2_c1" src="images/home_r2_c1.jpg" width="476" height="45" border="0" alt=""></td>
	   <td><a href="admin.php?uid=<?php echo $uid?>"><img name="attendance_r2_c5" src="images/attendance_r2_c5.jpg" width="29" height="45" border="0" alt=""></a></td>
	   <td><img name="home_r2_c6" src="images/home_r2_c6.jpg" width="18" height="45" border="0" alt=""></td> 
	   <td colspan="2" align="right"><a href="aureports.php?uid=<?php echo $uid?>"><img name="home_r2_c10" src="images/home_r2_c10.jpg" width="28" height="45" border="0" alt=""></a></td>
	   <td><img name="home_r2_c11" src="images/home_r2_c11.jpg" width="10" height="45" border="0" alt=""></td> 
	   <td><a href="pass.php?uid=<?php echo $uid?>"><img name="pass_r2_c7" src="images/pass_r2_c7.jpg" width="38" height="45" border="0" alt=""></a></td>
	   <td><img name="home_r2_c9" src="images/home_r2_c9.jpg" width="18" height="45" border="0" alt=""></td> 
	   <td><a href="nwdays.php?show=1&uid=<?php echo $uid?>"><img name="home_r2_c12" src="images/home_r2_c12.jpg" width="41" height="45" border="0" alt=""></a></td>
	   <td><img name="home_r2_c13" src="images/home_r2_c13.jpg" width="8" height="45" border="0" alt=""></td> 
	   <td><a href="news.php?uid=<?php echo $uid?>"><img name="home_r2_c14" src="images/home_r2_c14.jpg" width="41" height="45" border="0" alt=""></a></td>
	   <td><img name="home_r2_c15" src="images/home_r2_c15.jpg" width="11" height="45" border="0" alt=""></td> 
	   <td><a href="logout.php"><img name="home_r2_c16" src="images/home_r2_c16.jpg" width="30" height="45" border="0" alt=""></a></td>
	   <td><img name="home_r2_c17" src="images/home_r2_c17.jpg" width="11" height="45" border="0" alt=""></td>
	   <td><img src="images/spacer.gif" width="1" height="45" border="0" alt=""></td>
	</tr>
	<tr>
		<td colspan="17"><img name="home_r3_c1" src="images/home_r3_c1.jpg" width="760" height="50" border="0" alt=""></td>
		<td><img src="images/spacer.gif" width="1" height="50" border="0" alt=""></td>
	</tr>
	<tr>
		<td colspan="3"><img name="home_r4_c1" src="images/home_r4_c1.jpg" width="269" height="70" border="0" alt=""></td>
		<td colspan="4" rowspan="4" valign="top" background="images/home_r4_c4.jpg"><br>    
			<table width="256" border="1" bordercolor="#CCCCCC">
				<tr> 
					<th width="82" scope="col"><div align="center">User Name </div></th>
					<th width="82" scope="col">Time Req. </th>
					<th width="78" scope="col">Time Spent </th>
				</tr>
				<?php 
					$result = $_GET["result"];				
					$date = date('Y-m-d');
					$day = date('l');
					$min = date('i');
					$hour = date('H');
					
					$min = $min - 5;
					if($min<0){ $hour=$hour-1; $min=$min+60;}
					$time = $hour.":".$min;
					$settime = $time;
					$settime1 = date('H:i');
					
					$query = "select * from presence where uid=".$uid." and date='".$date."'";
					$recordset = mysql_query($query);
					while($record = mysql_fetch_array($recordset)){
						$count = 1;
						//echo "<td>Today you Timed in at:- ",$record["timein"],"</td></tr><br></table>";
						//$lasttimeout = $record["timeout"];
					}
					if($count!=1) 
					{
						$query2 = "insert into presence(timein, timeout, date, uid, pday) 
						values('$settime', '$settime1', '$date', $uid, '$day')";
						$af = mysql_query($query2);
						//echo "<td>Today you Timed in at:- ",$settime,"</td></tr><br></table>";
						$lasttimeout = date('H:i');
					}
					//echo "<table><tr><td>Today you last Timed out at:- ",$lasttimeout," 
					//</td></tr></table>";
					$array1 = array();
					$array2 = array();
					$array3 = array();
					$array4 = array();
					$userid = array();
					$great = 0;
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
						
						
					
					$month = date("m");
					$year = date("Y");
					 
					 $startday = 1;
					 $endday = date("d");
								
					$date1 = $year."-".$month."-".$startday;
					$date2 = $year."-".$month."-".$endday;		
					
					$recordset9 = mysql_query("select * from configuration where setname='relaxedhours'");
					while($record9 = mysql_fetch_array($recordset9)) {
						$relaxedhours = $record9["setvalue"];
					}
					
					$recordset4 = mysql_query("select * from nwdays where nwdate 
					between '".$date1."' and '".$date2."' and uid=0 and holidaytype=2 order by nwdate");
					
					$days = 0;
					while($record4 = mysql_fetch_array($recordset4)) {
						$days = $days + 1;
					}
					$wdays1 = $endday - $days;
					//$whours = $wdays *8;
					
					$recordset = mysql_query("select * from users");
					while($record = mysql_fetch_array($recordset)) {
					
					$recordset15 = mysql_query("select * from nwdays where nwdate between '".$date1."' and '".$date2."' and uid=".$record["uid"]." and holidaytype=0 order by nwdate");
						$undays = 0;
						while($record15 = mysql_fetch_array($recordset15)) {
							$undays = $undays + 1;
						}
						$wdays = $wdays1 - $undays;
						
					$whours1 = $record["uwhours"];
					$whours = $wdays * $whours1;
					$totaltime = 0;
					$query1 = "select * from presence where uid =".$record["uid"]." and date between '".$date1."' and '".$date2."' order by date";
					$recordset1 = mysql_query($query1);
					while($record1 = mysql_fetch_array($recordset1)) {
					$timein = $record1["timein"];
					$timeout = $record1["timeout"];
					$totaltime = $totaltime + calculate($timein, $timeout);
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
					
						$userid["$great"] = $record["uid"];		
						$array1["$great"] = $record["ulogin"];		
						$array2["$great"] = $whours;
						$array3["$great"] = $totaltime;
						
						$great++;
								
					}
					
					$greatest = 0;
					for ( $i=0; $i < $great; $i++ )
					{
						 $greatest = $array3[$i];
						 $greatest = split(":",$greatest,"2");
						 $array3[$i] = ($greatest[0] * 60) + $greatest[1];
						 
					}      	 
						
					for ( $i=0; $i < $great; $i++)
					{
						 for ( $j=$i+1; $j < $great; $j++ )
						 {		       			   
							   if ( $array3[$j] > $array3[$i])
							   {			        
									$temp1 = $array1[$j];
									$temp2 = $array2[$j];
									$temp3 = $array3[$j];
									$temp4 = $userid[$j];					
									
									$array1[$j] = $array1[$i];
									$array2[$j] = $array2[$i];
									$array3[$j] = $array3[$i];
									$userid[$j] = $userid[$i];
									
									$array1[$i] = $temp1;
									$array2[$i] = $temp2;
									$array3[$i] = $temp3;
									$userid[$i] = $temp4;					
							   }		
						 }
					}
					 
					for ( $i=0; $i < $great; $i++ )
					{
						  //echo $array3[$i],"<br>";
						  $totaltime = $array3[$i];
						  $totalhours = intval($totaltime/60);     
						  $totalminutes = $totaltime%60;
						  if($totalminutes<10) {$totalminutes = "0".$totalminutes;}
						  $array3[$i] = $totalhours.":".$totalminutes;
								  
								 
						  if(($array3[$i]+$relaxedhours)< $array2[$i]) 
						  {
							  if ( $uid == $userid["$i"] )
								   echo"<tr bgcolor='skyblue'>
										   <td>
											   <div align='left'>",$array1["$i"],"</div>
										   </td>
										   <td align='center'>",$array2[$i],"</td>
										   <td align='center'><font color='red' align='center'>",$array3[$i],"</font></td>
									   </tr>";	
							  else		  
								   echo"<tr>
										   <td>
											   <div align='left'>",$array1["$i"],"</div>
											</td>
											<td align='center'>",$array2[$i],"</td>
											<td align='center'><font color='red' align='center'>",$array3[$i],"</font></td>
										</tr>";
						  }
						  
						  else
						  {
							  if ( $uid == $userid["$i"] )
								   echo"<tr bgcolor='skyblue'>
										   <td>
										   		<div align='left'>",$array1["$i"],"</div>
										   </td>
										   <td align='center'>",$array2[$i],"</td>
										   <td align='center'>",$array3[$i],"</td>
									   </tr>";
							  else
								  echo"<tr>
										   <td>
											  <div align='left'>",$array1["$i"],"</div>
										   </td>
										   <td align='center'>",$array2[$i],"</td>
										   <td align='center'>",$array3[$i],"</td>
									  </tr>";
						   }
					}
				?> 
			</table>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
		</td>
		<td rowspan="5" colspan="10"><img name="home_r4_c8" src="images/home_r4_c8.jpg" width="233" height="410" border="0" alt=""></td>
		<td><img src="images/spacer.gif" width="1" height="70" border="0" alt=""></td>
	</tr>
	<tr>
		<td rowspan="3"><img name="home_r5_c1" src="images/home_r5_c1.jpg" width="36" height="318" border="0" alt=""></td>
		<td background="images/home_r5_c2.jpg" >
			<center>
			<table>
				<tr>
					<td>
						<?php 
							$query = "select * from presence where uid=".$uid." and date='".$date."'";
							$recordset = mysql_query($query);
							while($record = mysql_fetch_array($recordset)){
							$count = 1;
							//echo "<td>Your Time In :==: ",$record["timein"],"</td></tr><br></table>";
							echo "<center><table><tr><td>Your Time In :==: ",$record["timein"],"</td></tr></table></center>";
							$lasttimeout = $record["timeout"];
							}
							
							echo "<center><table><tr><td>Your Time Out :=: ",$lasttimeout,"</td></tr></table></center>";
						?>
						<br>
					</td>
				</tr>
			</table>
			</center>
			<center>
			<table>
				<tr>
					<td>
						<input type="button" name="button2" value="Time Out" onClick="timeout()">
					</td>
				</tr>
			</table>
			</center>
		</td>
		<td rowspan="3"><img name="home_r5_c3" src="images/home_r5_c3.jpg" width="15" height="318" border="0" alt=""></td>
		<td><img src="images/spacer.gif" width="1" height="109" border="0" alt=""></td>
	</tr>
	<tr>
		<td><img name="home_r6_c2" src="images/home_r6_c2.jpg" width="218" height="83" border="0" alt=""></td>
		<td><img src="images/spacer.gif" width="1" height="83" border="0" alt=""></td>
	</tr>
	<tr>
		<td valign="top" class="pannelRepTxt" background="images/home_r7_c2.jpg">
			<script language="javascript" src="rotator.js" type="text/javascript"></script>
			<?php  
				$recordset = mysql_query("select * from dailynews where ndescription != '' ");
				 $counter = 0;
				if ( mysql_num_rows($recordset) > 0)
				{
					 if ( mysql_num_rows($recordset) == 1 )
					 {
						  while ( $record = mysql_fetch_array($recordset) )
								  echo $record["ndescription"];
					 }			  
					 else
					 {	  
			?>
					  
					 <div id="Rotator1"  onMouseOver="ie_MsOver(this, rco_Rotator1);" onMouseOut="ie_MsOut(this, rco_Rotator1);" style="height:119px;width:215px;overflow:hidden;">                                
					 
					  <div id="Rotator1_SlideContainer" style="position:relative;visibility:hidden;"> 
						<?php 		  
					 while($record = mysql_fetch_array($recordset))
					 {
			?>
						<div id="Rotator1_slide<?php echo $counter?>" style="padding:7px; " > 
						  <div> 
							<?php 	
								   echo $record["ndescription"];
								   $counter++;
								?>
						  </div>
						</div>
						<?php 	     } ?>
					  </div>
			
			
					   <script  language="JavaScript">
			// Initialize rotator instance -------------------------------------------------
			
					   var rco_Rotator1 = new ComponentArt_Rotator(); 
							rco_Rotator1.GlobalID = 'rco_Rotator1'; 
							rco_Rotator1.ElementID = 'Rotator1';
							rco_Rotator1.ContainerID = 'Rotator1_SlideContainer';
							rco_Rotator1.ContainerRowID = 'Rotator1_ContainerRow';
							rco_Rotator1.AutoStart = true;
							rco_Rotator1.SlidePause = 4000;
							rco_Rotator1.HideEffect = null; 
							rco_Rotator1.HideEffectDuration = 250;
							rco_Rotator1.Loop = true; 
							rco_Rotator1.PauseOnMouseOver = true;
							rco_Rotator1.RotationType = 'ContentScroll';
							rco_Rotator1.ScrollDirection = 'up'; 
							rco_Rotator1.ScrollInterval = 15; 
							rco_Rotator1.ShowEffect = null; 
							rco_Rotator1.ShowEffectDuration = 250;
							rco_Rotator1.SmoothScrollSpeed = 'Slow';
							rco_Rotator1.Slides = new Array();
						<?php  
						   for($i = 0;$i<$counter;$i++) 
						   { ?>
							   rco_Rotator1.Slides[<?php echo $i?>] = 'Rotator1_slide<?php echo $i?>'
						<?php  } ?>
						rco_Rotator1.HasTickers = false; 
						
						if (rco_Rotator1.AutoStart) 
							rcr_Start(rco_Rotator1); 
						</script>
						</div>					
			<?php  
				 } 
			 }	  
			?>    
		</td>   
		<td><img src="images/spacer.gif" width="1" height="126" border="0" alt=""></td>
	</tr>
	<tr>
		<td colspan="7"><img name="home_r8_c1" src="images/home_r8_c1.jpg" width="527" height="22" border="0" alt=""></td>
		<td><img src="images/spacer.gif" width="1" height="22" border="0" alt=""></td>
	</tr>
	<tr>
		<td colspan="17"><img name="home_r9_c1" src="images/home_r9_c1.jpg" width="760" height="40" border="0" alt=""></td>
		<td><img src="images/spacer.gif" width="1" height="40" border="0" alt=""></td>
	</tr>
</table>
</form>
<div align="right"><align='right'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
