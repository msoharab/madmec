<?php
include_once("include/checksession.php");
?>
<html>
<head>
<title>Attendance System</title>
<?php	
include_once("include/config.php");
$uid = $_GET["uid"];
include_once("include/links.php");
	$user = $_GET["user"];
?>
<script>
	function saveinfo() {
		login = form1.textfield1.value;
		pwd = form1.textfield2.value;
		type = form1.textfield3.value;
		if(login==""){
		alert("Enter Login Name");
		form1.textfield1.focus();
		return;
		}
		if(pwd==""){
		alert("Enter Password");
		form1.textfield2.focus();
		return;
		}
		if(type==""){
		alert("Enter Type");
		form1.textfield3.focus();
		return;
		}
			form1.action = "insert.php?";
	}
	function cancel() {
	form1.action ="user.php?uid=<?php echo $uid?>";
	form1.submit();
	}
</script>
</head>
<body bgcolor="silver">
<form method="post" name="form1" action="">
<br><center>
<table border="1">
<tr><td colspan="2" align="center">User Information</td></tr>
<tr>
<td>Login Name </td>
<td><input type="text" name="textfield1"></td></tr>
<tr><td>Password</td>
<td><input type="text" name="textfield2"></td></tr>
<tr><td>Designation</td>
<td><select name="select1">
<?php 
$recordset = mysql_query ("select * from designation");
while($record = mysql_fetch_array($recordset)){
echo"<option value=".$record["did"].">".$record["dname"]."</option>";
}
	echo"<script>form1.select1.options[0].selected=true;</script>";
?>
</select></td></tr>
<tr><td>Group</td>
<td><select name="select2">
<?php 
$recordset1 = mysql_query("select * from groups");
while($record1 = mysql_fetch_array($recordset1)){
echo"<option value=".$record1["gid"].">".$record1["gname"]."</option>";
}
	echo"<script>form1.select2.options[0].selected=true;</script>";
?>
</select></td></tr>
<tr>
<tr><td>Team</td>
<td><select name="select3">
<?php 
$recordset2 = mysql_query ("select * from team");
while($record2 = mysql_fetch_array($recordset2)){
echo"<option value=".$record2["tid"].">".$record2["tname"]."</option>";
	}
	echo"<script>form1.select3.options[0].selected=true;</script>";
?>
</select></td></tr>
<tr><td>Type</td>
<td><input type="text" name="textfield3" size="8" value="0"></td></tr>
<tr><td></td>
<td><input type="button" name="button1" value=" Save " onClick="saveinfo()">
<input type="button" name="button1" value="Cancel" onClick="cancel()"</td></tr>
</table></center>
<?php 
	if($_GET["action"]==1){
		$recordset3 = mysql_query("select * from users where uid=".$user);
		while($record3 = mysql_fetch_array($recordset3)){
		echo"<script> form1.textfield1.value = '".$record3["login"]."';
		form1.textfield2.value = '".$record3["password"]."';
		form1.textfield3.value = '".$record3["type"]."';
		for(i=0; i< form1.select1.length; i++) {
			if(form1.select1.options[i].text =='".$record3["designation"]."') {
			form1.select1.options[i].selected = true;
			} 
		}
		for(j=0; j< form1.select2.length; j++) {
			if(form1.select2.options[j].text =='".$record3["group"]."') {
			form1.select2.options[j].selected = true;
			}
		}
		for(k=0; k< form1.select3.length; k++) {
			if(form1.select3.options[k].text =='".$record3["team"]."') {
			form1.select3.options[k].selected = true;
			}
		}
		</script>";
		}
	}
?>
</form>
</body>
<div align="center"><align='center'>A Product of  <a href="http://corp.madmec.com">MadMec</a>
</align></div>
</html>
