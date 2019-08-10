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
?>
<style>
body,td,th {
	font-family: Verdana;
	font-size: 13px;		
}
</style>
</head>
<body bgcolor="silver">
<form name="form1" method="post" action="reports.php?show=1&uid=<?php echo $uid?>" >
<center><br>
<table border="0">
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
  </table>
<br><br>
<table border="1">
<tr><th>User Name</th><th>Total Time Req</th><th>Total Time Spent</th>
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
		
		$recordset5 = mysql_query("select * from nwdays where nwdate between '".$date1."' and '".$date2."' and uid=0 order by nwdate");
		$days = 0;
		while($record5 = mysql_fetch_array($recordset5)) {
			$days = $days + 1;
		}
		$wdays1 = $endday - $days;
		//$whours = $wdays *8;
	$query = "select * from users";
	$recordset = mysql_query($query);
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
	
	echo"<tr><td align='center'>",$record["ulogin"],"</td>
	<td align='center'>",$whours,"</td><td align='center'>",$totaltime,"</td></tr>";
	}
?>
</tr>
</table>
</center>
</form>
<div align="center"><align='center'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
