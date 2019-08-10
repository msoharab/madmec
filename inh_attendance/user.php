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
							function confirmdel(){
							tell=confirm("Do You really want to delete this user?");
							if(tell) return true; 
							else return false;
							}
							function addnew() {
								form1.action = "adduser.php?action=3&uid=<?php echo $uid?>";
								form1.submit();
							}
						</script>

<style>
body,td,th {
	font-family: Verdana;
	font-size: 12px;		
}
</style>						
</head>
<body bgcolor="#f2f2f2">
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
					   <td><a href="pass.php?uid=<?php echo $uid?>"><img name="pass_r2_c7" src="images/pass_r2_c7.jpg" width="34" height="45" border="0" alt=""></a></td>
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
						   <td colspan="5" valign="top"><a href="user.php?uid=<?php echo $uid?>"><img name="sub_r6_c2" src="images/sub_r6_c2.jpg" width="160" height="31" border="0" alt=""></a></td>
						   <td><img src="images/spacer.gif" width="1" height="31" border="0" alt=""></td>
						  </tr>
						  
						  <tr>
						   <td valign="top"><a href="fine.php?uid=<?php echo $uid?>"><img name="user_r8_c2" src="images/user_r8_c2.jpg" width="74" height="30" border="0" alt=""></a></td>
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
						
						<?php	
						
						 if($_GET["del"]==1){
							echo"<center><font color='green'>The user has been deleted</font></center>";
							}
							$query = "select * from users";
							$recordset = mysql_query($query);
							echo"<body bgcolor='silver'>
							<form name='form1' action='' method='post'>";
							
							echo "<br><center><table border='1' width='500' cellspacing='4'>";
							echo"<tr><th align='center'>Name</th><th align='center'>Designation</th><th align='center'>Group</th>
							<th align='center'>Division</th><th align='center'>Hours</th><th align='center'>Edit</th>
							<th align='center'>Delete</th>";
							while($record = mysql_fetch_array($recordset)) {
							echo "<tr><td align='center'>".$record["ulogin"]."</td><td align='center'>".$record["udesignation"]."</td>
							<td align='center'>".$record["ugroup"]."</td><td align='center'>".$record["uteam"]."</td>
							<td align='center'>".$record["uwhours"]."</td>
							<td><a href='edituser.php?action=1&user=".$record["uid"]."&uid=".$uid."'>Edit</a></td>
							<td><a href='deleteuser.php?action=2&user=".$record["uid"]."&uid=".$uid."' onClick='return confirmdel()'>
							Delete</a></td></center>";
							}
							echo"</table>";
						?>
						<br>


                            <table align="center"><tr><td> <input type="button" name="button1" value="Add User" onClick="addnew()">
                             </td></tr></table>

			</td></tr>
			
			
			
			</table>
		</td>
	</tr>
</table>
</form>
<div align="center"><align='center'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
