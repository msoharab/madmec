<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Remove duplicate emails..</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bgcolor="#999999">
<table border="1" align="center" cellpadding="5" cellspacing="5">
	<tr>
		<td colspan="2" align="center" bgcolor="#CCCCCC"><strong><h3>BulkEmail</h3></strong></td>
	</tr>
	<tr>
		<td bgcolor="#CCCCCC">
			<?php
				if(isset($_POST['submit']))
				{
					if(isset($_FILES['emailFile']) &&($_FILES['emailFile']['error'] == UPLOAD_ERR_OK))
					{
						$uploads_dir = './uploads';
						$tmp_name = $_FILES['emailFile']['tmp_name'];
						$name = $_FILES["emailFile"]["name"];
						$txt = '';
						if(move_uploaded_file($tmp_name,"$uploads_dir/$name") != false)
						{
							$content = file_get_contents("$uploads_dir/$name");
							$order   = array("\r\n", "\n", "\r","\n\r","\t");
							$replace = '';
							$newstr = str_replace($order, $replace, $content);
							$arr = explode(";",$newstr);
							$array = array_unique($arr);
							$j = 1;
							for($i=0;$i<sizeof($array);$i++)
							{
									if(isset($array[$i]) && preg_match('%^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})%',$array[$i]))
									{
										// echo "Email Ids :: -- ". $array[$i]."<br />";
										$txt .= strtolower($array[$i]).";\n";
										$j++;
									}
									else
										if(isset($array[$i]))
											echo "Invalid Email Ids :: -- ". $array[$i]."<br />";
							}
							file_put_contents("newEmail.txt",$txt);
						}
						else
							echo "<center><h3>Cannot upload the file.</h3></center>";
						echo "Total email ids:- ".$j."<h3><a href=\"index.php\">back</a></h3>";
					}
				}
				else
				{
			?>
				<form name="form1" action="removeDuplicate.php" method="post" enctype="multipart/form-data">
					Select a email processed file :: <input type="file" name="emailFile"  /><br />
					<input type="submit" name="submit" value="upload" />
				</form>
			<?php
				}
			?>
		</td>
	</tr>
</table>
</body>
</html>