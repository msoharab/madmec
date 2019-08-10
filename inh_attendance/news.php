<?php
   include_once("include/checksession.php");
   $uid = $_GET["uid"];
?>
<?php		
	include_once("include/config.php");
	$user = $_GET["user"];
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
<form name="form1" method="post" action="updatenews.php?uid=<?php echo $uid?>">
<body>
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
					   <td><a href="nwdays.php?show=1&uid=<?php echo $uid?>"><img name="user_r2_c14" src="images/user_r2_c14.jpg" width="41" height="45" border="0" alt=""></a></td>
					   <td><img name="user_r2_c15" src="images/user_r2_c15.jpg" width="8" height="45" border="0" alt=""></td>
					   <td><a href="news.php?uid=<?php echo $uid?>"><img name="attendance_r2_c16" src="images/attendance_r2_c16.jpg" width="41" height="45" border="0" alt=""></a></td>
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
				<td align="left" valign="bottom">
					<table width="160" cellpadding="0" cellspacing="0">
						 <br><br><br><br><br><br><br><br><br>
						  <tr>
						   <td colspan="6" valign="bottom"><img name="user_r10_c1" src="images/user_r10_c1.jpg" width="177" height="293" border="0" alt=""></td>
						   <td><img src="images/spacer.gif" width="1" height="293" border="0" alt=""></td>
						  </tr>
					</table>

				</td>
				<td valign="top"><br><br>
					<center><table>
							<?php
								 $recordset = mysql_query("select * from dailynews where ndescription !='' ");
								
								 $no = mysql_num_rows($recordset);									
								 $i = 1;
								 while ( $row = mysql_fetch_array($recordset) )
								 {
								          
							?>	 	 
						                 
							
							<tr><td align="center">Message<?php echo $i?></td></tr>
							<tr><td align="center">
							  <textarea name="textfield<?php echo $i?>" rows="7" cols="25" ><?php echo $row["ndescription"];?></textarea>
							</td></tr>			
							<?php 
									  $i++;
								  }
								  if ( $no == 0 )
								  {
							?>
								  <tr><td align="center">Message</td></tr>
								  <tr><td align="center">
									   <textarea name="textfield<?php echo $no+1?>" rows="7" cols="25" ></textarea>
								  </td></tr>			
							<?php 	
								  }
								  
								  if ( $_GET["show"] == 1 )
								  {     
									   if ( $no < 50 && $no > 0 )
									   {
							?>
							
							<tr><td align="center">Message<?php echo $no+1?></td></tr>
							<tr><td align="center">
							  <textarea name="textfield<?php echo $no+1?>" rows="7" cols="25"></textarea>
							</td></tr>			
							<?php          
									   }
									   
									   if ( $no == 50 )
											echo "<center><font color=red>You cannot add more message.</font></center>";
												
								  }	
							?>	
								
							<tr></tr>
							<tr>
							<td align="center">
							<input type="submit" name="button1" value="Update">
							</td>
							
							</td>
							
							</tr>
							</table></form>
							
							<form name="f1" action="news.php?uid=<?php echo $uid ?>&show=1"  method="post">
							<table>
							<tr><td></td>
							<td align="center">
							
							<input type="Submit" value="Add Message" >
							</td>
							</tr>
							</table></center>
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
