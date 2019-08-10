<?php
   include_once("include/uchecksession.php");
   $uid = $_GET["uid"];
  
?>
<?php		
	include_once("include/config.php");
	 $new = $_POST["new"];
	$old = $_POST["old"];
	$confirm = $_POST["confirm"];
	
				  
    $recordset = mysql_query ("select * from users where uid = $uid ");
	while ( $row = mysql_fetch_array($recordset) )
	{
	        if ( $row["upassword"] <> $old )
		    {
		         header("Location:changeuserpassword.php?invalid=1&old=".$old."&new=".$new."&confirm=".$confirm);
			  	 exit;
		    }
			if ( $_POST["new"] == "" && $_POST["confirm"] == "" )
		    {
		         header("Location:changeuserpassword.php?invalid=3&old=".$old."&new=".$new."&confirm=".$confirm);
				 exit;
		    }
			if ( $_POST["new"] <> $confirm )
		    {
		         header("Location:changeuserpassword.php?invalid=2&old=".$old."&new=".$new."&confirm=".$confirm);
				 exit;
		    }							 		   				           		    
	 }	   
	
?>
<html>
<head>
<title>Attendance System</title>
<style>
<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
</style>
<meta http-equiv="Content-Type" content="text/html;">
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Mon Aug 22 13:42:02 GMT+0500 (West Asia Standard Time) 2005-->
</head>
<body bgcolor="#f2f2f2">
<form name="form1" method="post" action="changeuserpassword1.php?uid=<?=$uid?>">
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
					$recordset = mysql_query ("select * from users where uid = $uid ");
					while ( $row = mysql_fetch_array($recordset) )
					{
					        $query = "update users set upassword = '".$new."' where uid = $uid ";
						   
					        $af = mysql_query($query);
					        if ( $af >= 1)
					        {

					            echo "<br><font color=blue>Your Password has been changed.</font>";
					        }
					}	   
						 
?>
					</center>
					

           </td>
     </tr>
	 
	 <tr><th width="26%" valign="bottom" scope="col"><img name="management_r5_c7" src="images/management_r5_c7.jpg" width="164" height="143" border="0" alt=""></th></tr>
	 
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
