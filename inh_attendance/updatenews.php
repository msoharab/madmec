<?php
	$uid = $_GET["uid"];
	$message1 = $_POST["textfield1"];
	
	$message2 = $_POST["textfield2"];
	$message3 = $_POST["textfield3"];
	$message4 = $_POST["textfield4"];
	$message5 = $_POST["textfield5"];
	$message6 = $_POST["textfield6"];
	$message7 = $_POST["textfield7"];
	$message8 = $_POST["textfield8"];
	$message9 = $_POST["textfield9"];
	$message10 = $_POST["textfield10"];
	$message11 = $_POST["textfield11"];
	$message12 = $_POST["textfield12"];
	$message13 = $_POST["textfield13"];
	$message14 = $_POST["textfield14"];
	$message15 = $_POST["textfield15"];
	$message16 = $_POST["textfield16"];
	$message17 = $_POST["textfield17"];
	$message18 = $_POST["textfield18"];
	$message19 = $_POST["textfield19"];
	$message20 = $_POST["textfield20"];
	$message21 = $_POST["textfield21"];
	$message22 = $_POST["textfield22"];
	$message23 = $_POST["textfield23"];
	$message24 = $_POST["textfield24"];
	$message25 = $_POST["textfield25"];



	
	include_once("include/config.php");
	$af1 = mysql_query("update dailynews set ndescription ='".$message1."' where nid=1");
	$af2 = mysql_query("update dailynews set ndescription ='".$message2."' where nid=2");
	$af3 = mysql_query("update dailynews set ndescription ='".$message3."' where nid=3");
    	$af4 = mysql_query("update dailynews set ndescription ='".$message4."' where nid=4");
    	$af5 = mysql_query("update dailynews set ndescription ='".$message5."' where nid=5");
	$af6 = mysql_query("update dailynews set ndescription ='".$message6."' where nid=6");
	$af7 = mysql_query("update dailynews set ndescription ='".$message7."' where nid=7");
	$af8 = mysql_query("update dailynews set ndescription ='".$message8."' where nid=8");
	$af9 = mysql_query("update dailynews set ndescription ='".$message9."' where nid=9");
	$af10 = mysql_query("update dailynews set ndescription ='".$message10."' where nid=10");
	$af11 = mysql_query("update dailynews set ndescription ='".$message11."' where nid=11");
	$af12 = mysql_query("update dailynews set ndescription ='".$message12."' where nid=12");
	$af13 = mysql_query("update dailynews set ndescription ='".$message13."' where nid=13");
	$af14 = mysql_query("update dailynews set ndescription ='".$message14."' where nid=14");
	$af15 = mysql_query("update dailynews set ndescription ='".$message15."' where nid=15");
	$af16 = mysql_query("update dailynews set ndescription ='".$message16."' where nid=16");
	$af17 = mysql_query("update dailynews set ndescription ='".$message17."' where nid=17");
	$af18 = mysql_query("update dailynews set ndescription ='".$message18."' where nid=18");
	$af19 = mysql_query("update dailynews set ndescription ='".$message19."' where nid=19");
	$af20 = mysql_query("update dailynews set ndescription ='".$message20."' where nid=20");
	$af21 = mysql_query("update dailynews set ndescription ='".$message21."' where nid=21");
	$af22 = mysql_query("update dailynews set ndescription ='".$message22."' where nid=22");
	$af23 = mysql_query("update dailynews set ndescription ='".$message23."' where nid=23");
	$af24 = mysql_query("update dailynews set ndescription ='".$message24."' where nid=24");
	$af25 = mysql_query("update dailynews set ndescription ='".$message25."' where nid=25");

	
	header("Location:admin.php?uid=".$uid);
	exit;
	

?>
