<?php
   include_once("include/uchecksession.php");
   $uid = $_SESSION["uid"];  
?>
<?php		
	include_once("include/config.php");
	$recordset = mysql_query ("select * from users where uid = $uid ");
	while ( $row = mysql_fetch_array($recordset) )
	{
	        $utype= $row["utype"];
			if ( $utype == 1)
			{
			     header("Location:changepassword.php?uid=".$uid);
				 exit;
			}	 
			else
			{	 
			    header("Location:changeuserpassword.php?uid=".$uid);
				exit;
		    }		
	}			 
	
?>