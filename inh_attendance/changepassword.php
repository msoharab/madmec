<?php
   include_once("include/uchecksession.php");
   $uid = $_SESSION["uid"];  
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
<form name="form1" method="post" action="changepassword1.php?uid=<?php echo $uid?>">
      

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
					   <td><a href="pass.php?uid=<?php echo $uid?>"><img name="pass1_r2_c7" src="images/pass1_r2_c7.jpg" width="39" height="45" border="0" alt=""></a></td>
					   <td><img name="user_r2_c11" src="images/user_r2_c11.jpg" width="18" height="45" border="0" alt=""></td>
					   <td><a href="aureports.php?uid=<?php echo $uid?>"><img name="user_r2_c12" src="images/user_r2_c12.jpg" width="28" height="45" border="0" alt=""></a></td>
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
						 <br><br><br><br><br><br><br><br><br>
						  <tr>
						   <td colspan="6" valign="bottom"><img name="user_r10_c1" src="images/user_r10_c1.jpg" width="177" height="293" border="0" alt=""></td>
						   <td><img src="images/spacer.gif" width="1" height="293" border="0" alt=""></td>
						  </tr>
					</table>

				</td>
				<td valign="top"><br>

<?php				   
                 if ( $_GET["invalid"] == 1 )
	                  echo "<br><br><center><font color=red >Enter Valid Old Password.</font></center>";			 
	             if ( $_GET["invalid"] == 2 )
	                  echo "<br><br><center><font color=red >New Password and Confirm Password do not match.</font></center>";	 
				 if ( $_GET["invalid"] == 3 )
	                  echo "<br><br><center><font color=red >Password cannot be empty.</font></center>";	 	  
?>		 
				    <br><br>
					<table >
							   
							   <tr><td>Enter Old Password</td><td><input type="password" name="old" value="<?php echo $_GET["old"]; ?>" /></td></tr>
							   <tr><td>Enter New Password</td><td><input type="password" name="new" value="<?php echo $_GET["new"]; ?>" /></td></tr>
							   <tr><td>Confirm New Password</td><td><input type="password" name="confirm" value="<?php echo $_GET["confirm"]; ?>" /></td></tr>
							   <tr><td></td></tr>
							   <tr><td></td><td><input type="submit" value="Change"></td></tr>
					</table>
						<script language="JavaScript">
						form1.old.focus();
						</script>	   
			</td></tr>
			
			</form>
			
			</table>
		</td>
	</tr>
</table>
<div align="right"><align='right'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
