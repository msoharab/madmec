<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	include_once("include/config.php");
	
?>
<html>
<head>
<title>Attendance - Login</title>
<meta http-equiv="Content-Type" content="text/html;">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Mon Aug 22 13:24:15 GMT+0500 (West Asia Standard Time) 2005-->
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana;
	font-size: 10px;
	color: #333333;
	
}
-->
</style>
</head>
<form name="form1" method="post" action="verify.php" onSubmit="return verify()">
<body bgcolor="#f2f2f2">
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="Copy of attendance.png" fwbase="login.jpg" fwstyle="Dreamweaver" fwdocid = "255186328" fwnested="0" -->
  <tr>
   <td><img src="images/spacer.gif" width="153" height="1" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="257" height="1" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="350" height="1" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr>
   <td colspan="3"><img name="login_r1_c1" src="images/login_r1_c1.jpg" width="380" height="58" border="0" alt=""><font  color="silver" size="5px">Attendance System</font></td>
   <td><img src="images/spacer.gif" width="1" height="118" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="3"><img name="login_r2_c1" src="images/login_r2_c1.jpg" width="760" height="113" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="1" height="113" border="0" alt=""></td>
  </tr>
  <tr>
   <td><img name="login_r3_c1" src="images/login_r3_c1.jpg" width="153" height="137" border="0" alt=""></td>
   <td background="images/login_r3_c2.jpg">
   
   
   
   <?php 
	
	
	echo "<script language = 'javascript'>";
	echo "function verify(){
	login = form1.textfield1.value;
	password = form1.textfield2.value;
	if(login == ''){
	alert('Enter Login');
	form1.textfield1.focus();
	return false;
					}
	if(password == ''){
	alert('Enter Password');
	form1.textfield2.focus();
	return false;
					}
	}
		function clearvalues(){
			 form1.textfield1.value='';
	     	 form1.textfield2.value='';
		     form1.textfield1.focus();
		}	
		
</script>";					
?>	

<table cellpadding="0" cellspacing="2">
<tr><td></td></tr><br>
<?php
if($_GET["invalid"]==1)
	echo"<tr><td></td><td><font color='red'>Incorrect Information!</font></td></tr>";
if($_GET["invalid"]==2)
	echo "<tr><td></td><td><font color=blue>Session Expired!</font></td></tr>";
	
?>


<tr><td></td></tr>
  <tr>
<td align="left">Login</td>
<td align="center">
<input type = "text" name="textfield1" >
</td>
</tr>
<tr><td align="left">Password</td>
<td align="center">
<input type = "password" name="textfield2" >
</td>
</tr>
<tr><td></td></tr><tr><td></td></tr>
<tr>
<td></td>
<td align="center" >
  <input type="submit" name="submit1" value="  Login  ">  
  <input type="button" name="button1" value="  Clear " onClick="clearvalues()"></td>
</tr>
<tr></tr>
</table>



<?php 
	echo "<script> 
	form1.textfield1.focus();
	</script>";
?>
 
   </td>
   <td><img name="login_r3_c3" src="images/login_r3_c3.jpg" width="350" height="137" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="1" height="137" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="3"><img name="login_r4_c1" src="images/login_r4_c1.jpg" width="760" height="37" border="0" alt=""></td>
   <td><img src="images/spacer.gif" width="1" height="37" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="3">&nbsp;</td>
   <td><img src="images/spacer.gif" width="1" height="145" border="0" alt=""></td>
  </tr>
</table>
</form>
<div align="center"><align='center'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</body>
</html>
