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
						   <td valign="top"><a href="fine.php?uid=<?php echo $uid?>"><img name="user_r8_c2" src="images/user_r8_c2.jpg" width="74" height="30" border="0" alt=""></a></td>
						   <td colspan="3">&nbsp;</td>
						   <td><img src="images/spacer.gif" width="1" height="30" border="0" alt=""></td>
						  </tr>
						  <tr>
						   <td colspan="2" valign="top"><a href="groups.php?uid=<?php echo $uid?>"><img name="sub_r9_c2" src="images/sub_r9_c2.jpg" width="102" height="31" border="0" alt=""></a></td>
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
					<br><table border="1" cellpadding="3" cellspacing="3">
								
								<tr>
								<th align="center">Group Name</th><th>Absent Fine</th><th>Hours Fine</th><th>Edit</th>
								</tr>
								<?php 
									$recordset = mysql_query("select * from groups");
									while($record = mysql_fetch_array($recordset))
									{
									echo"<tr><td align='center'>",$record["gname"],"</td><td align='center'>",$record["absentfine"],"</td>
									<td align='center'>",$record["hoursfine"],"</td>
									<td><a href='editgroup.php?gid=".$record["gid"]."&uid=".$uid."'>Edit</a></td>
									</tr>";
									}
								?>
				   </table>
			</td></tr>
			
			
			
			</table>
		</td>
	</tr>
</table>
<div align="right"><align='right'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
