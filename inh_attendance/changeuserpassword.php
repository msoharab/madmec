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
<meta http-equiv="Content-Type" content="text/html;">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Mon Aug 22 13:42:02 GMT+0500 (West Asia Standard Time) 2005-->
</head>
<body bgcolor="#f2f2f2">
<form name="form1" method="post" action="changeuserpassword1.php?uid=<?php echo $uid?>">
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
   <td><a href="pass.php"><img src="images/pass1_r2_c7.jpg" width="39" height="45" border="0"></a></td>
   <td><img name="management_r2_c12" src="images/management_r2_c12.jpg" width="11" height="45" border="0" alt=""></td>
   <td><a href="ureports.php"><img name="management_r2_c4" src="images/management_r2_c4.jpg" width="34" height="45" border="0" alt=""></a></td>
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
     <tr><th width="26%" valign="bottom" scope="col"></th>
       
       <td width="74%" scope="col" valign="top">
			<center>

<?php				   
                 if ( $_GET["invalid"] == 1 )
	                  echo "<center><font color=red >Enter Valid Old Password.</font></center>";			 
	             if ( $_GET["invalid"] == 2 )
	                  echo "<center><font color=red >New Password and Confirm Password do not match.</font></center>";	 
				 if ( $_GET["invalid"] == 3 )
	                  echo "<center><font color=red >Password cannot be empty.</font></center>";	 	  
?>		 
				    <br>
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
			</td></tr><br><br><br>
			<tr><th width="26%" valign="bottom" scope="col"><img name="management_r5_c7" src="images/management_r5_c7.jpg" width="164" height="143" border="0" alt=""></th></tr>
			</form>
			
			</table>
					</center>
					

           </td>
     </tr>
	 </table></td>
   <td><img src="images/spacer.gif" width="1" height="321" border="0" alt=""></td>
  </tr>
  <tr>
   <td><img src="images/spacer.gif" width="1" height="143" border="0" alt=""> </td>
  </tr>
</table>
<div align="right"><align='right'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
