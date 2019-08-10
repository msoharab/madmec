<?php
	define("MODULE_0","config.php");
	define("MODULE_1","database.php");
	define("MODULE_2","PHPExcel_1.7.9/Classes/PHPExcel.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(LIB_ROOT.MODULE_2);
	function main(){
		if(!ValidateAdmin()){
			session_destroy();
			echo 'logout';
			exit(0);
		}
		if(isset($_FILES['xls_users_file']) && ($_FILES['xls_users_file']['error'] == UPLOAD_ERR_OK)){
			ImportUsers();
			unset($_FILE);
			exit(0);
		}
	}
	function ImportUsers(){
		$flag = false;
		$importdata = NULL;
		$importdata['NAME'] = NULL;
		$importdata['GENDER'] = NULL;
		$importdata['MOBILE'] = NULL;
		$importdata['DOB'] = NULL;
		$importdata['EMAIL'] = NULL;
		$importdata['OCCUPATION'] = NULL;
		$importdata['ACS_ID'] = NULL;
		if(strtolower($_FILES["xls_users_file"]['type']) == "application/vnd.ms-excel" ||
		strtolower($_FILES["xls_users_file"]['type']) == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
			$path1 = DOC_ROOT."/uploads";
			$temp = explode(".",$_FILES["xls_users_file"]['name']);
			$order   = array("_"," ");
			$replace = '-';
			$fname1 = md5(date('h-i-s,_j-m-y,_it_is_w_Day_u')."-".rand(1,99))."_".str_replace($order, $replace,$_FILES["xls_users_file"]['name']);
			$thefile1 = $path1 ."/". $fname1;
			if(move_uploaded_file($_FILES["xls_users_file"]['tmp_name'], $thefile1)){
				if(is_file($thefile1)){
					if(strtolower($_FILES["xls_users_file"]['type']) == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
						$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					if(strtolower($_FILES["xls_users_file"]['type']) == "application/vnd.ms-excel")
						$objReader = new PHPExcel_Reader_Excel5();
					$objReader->setReadDataOnly(true);
					$objPHPExcel = $objReader->load($thefile1);
					$objWorksheet = $objPHPExcel->getActiveSheet();
					$highestRow = $objWorksheet->getHighestRow(); 
					$highestColumn = $objWorksheet->getHighestColumn(); 
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); 
					if ($highestRow > 0 && $highestColumnIndex > 0){
						$importdata = array();
						for ($col = 0; $col < $highestColumnIndex; ++$col) {
							if($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_NAME){
								for ($row = 2,$j = 1; $row <= $highestRow; ++$row,$j++) {
									$temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
									$importdata['NAME'][$j] = isset($temp) ? $temp : NULL;
								}
							}
							else if($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_GENDER){
								for ($row = 2,$j = 1; $row <= $highestRow; ++$row,$j++) {
									$temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
									$importdata['GENDER'][$j] = isset($temp) ? $temp : NULL;
								}
							}
							else if($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_DOB){
								for ($row = 2,$j = 1; $row <= $highestRow; ++$row,$j++) {
									$temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
									$importdata['DOB'][$j] = isset($temp) ? $temp : NULL;
								}
							}
							else if($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_MOBILE){
								for ($row = 2,$j = 1; $row <= $highestRow; ++$row,$j++) {
									$temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
									$importdata['MOBILE'][$j] = isset($temp) ? $temp : NULL;
								}
							}
							else if($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_EMAIL){
								for ($row = 2,$j = 1; $row <= $highestRow; ++$row,$j++) {
									$temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
									$importdata['EMAIL'][$j] = isset($temp) ? $temp : NULL;
								}
							}
							else if($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_OCCUPATION){
								for ($row = 2,$j = 1; $row <= $highestRow; ++$row,$j++) {
									$temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
									$importdata['OCCUPATION'][$j] = isset($temp) ? $temp : NULL;
								}
							}
							else if($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_ACCESS_ID){
								for ($row = 2,$j = 1; $row <= $highestRow; ++$row,$j++) {
									$temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
									$importdata['ACS_ID'][$j] = isset($temp) ? $temp : NULL;
								}
							}
						}
						if($importdata){
							if(!checkForDuplicate($importdata,true,false)){ /* Email id duplication */
								if(!checkForDuplicate($importdata,false,true)){ /* Cell number duplication */
									if(!checkForBulkExistence($importdata,true,false)){ /* Email id duplication in database */
										if(!checkForBulkExistence($importdata,false,true)){ /* Cell number duplication in database */
											if(AddBulk($importdata)){
												$objPHPExcel->disconnectWorksheets();
												unset($objPHPExcel);
												$flag = true;
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		if(!$flag)
			echo '<h2>0 records in file!!!</h2>';
	}
	function checkForDuplicate($fields,$email = false,$cell_number = false){
		$total = sizeof($fields['EMAIL']);
		$flag = false;
		if($total){
			$k = 1;
			echo '<table border="1" cellpadding="2" cellspacing="2" width="920" align="center">';
			if($email){
				echo '<tr><td align="center" colspan="8">Duplicate email ids in '.$_FILES["xls_users_file"]['name'].'</td></tr>
					<tr>
						<td align="right">No</td>
						<td align="center">NAME</td>
						<td align="center">GENDER</td>
						<td align="center">DOB</td>
						<td align="center">MOBILE</td>
						<td align="center">EMAIL</td>
						<td align="center">OCCUPATION</td>
						<td align="center">ACS ID</td>
					</tr>';
				for($i=1;$i<=$total;$i++){
					for($j=$i+1;$j<=$total;$j++){
						if($fields['EMAIL'][$i] == $fields['EMAIL'][$j] && $fields['EMAIL'][$j]){
							echo '<tr>
									<td>'.$k.'</td>
									<td>'.$fields['NAME'][$j].'</td>
									<td>'.$fields['GENDER'][$j].'</td>
									<td align="right">'.$fields['DOB'][$j].'</td>
									<td align="right">'.$fields['MOBILE'][$j].'</td>
									<td>'.$fields['EMAIL'][$j].'</td>
									<td>'.$fields['OCCUPATION'][$j].'</td>
									<td align="right">'.$fields['ACS_ID'][$j].'</td>
								</tr>';
							$fields['EMAIL'][$j] = NULL;
							$flag = true;
							$k++;
						}
					}
				}
				if(!$flag){
					echo '<tr><td align="center" colspan="8">No duplicatie email ids '.$_FILES["xls_users_file"]['name'].'</td></tr>';
				}
			}
			else if($cell_number){
				echo '<tr><td align="center" colspan="8">Duplicate cell numbers in '.$_FILES["xls_users_file"]['name'].'</td></tr>
					<tr>
						<td align="right">No</td>
						<td align="center">NAME</td>
						<td align="center">GENDER</td>
						<td align="center">DOB</td>
						<td align="center">MOBILE</td>
						<td align="center">EMAIL</td>
						<td align="center">OCCUPATION</td>
						<td align="center">ACS ID</td>
					</tr>';
				for($i=1;$i<=$total;$i++){
					for($j=$i+1;$j<=$total;$j++){
						if($fields['MOBILE'][$i] == $fields['MOBILE'][$j] && $fields['MOBILE'][$j]){
							echo '<tr>
									<td>'.$k.'</td>
									<td>'.$fields['NAME'][$j].'</td>
									<td>'.$fields['GENDER'][$j].'</td>
									<td align="right">'.$fields['DOB'][$j].'</td>
									<td align="right">'.$fields['MOBILE'][$j].'</td>
									<td>'.$fields['EMAIL'][$j].'</td>
									<td>'.$fields['OCCUPATION'][$j].'</td>
									<td align="right">'.$fields['ACS_ID'][$j].'</td>
								</tr>';
							$fields['MOBILE'][$j] = NULL;
							$flag = true;
							$k++;
						}
					}
				}
				if(!$flag){
					echo '<tr><td align="center" colspan="8">No duplicatie cell numbers  in '.$_FILES["xls_users_file"]['name'].'</td></tr>';
				}
			}
			echo '</table><p>&nbsp;</p>';
		}
		return $flag;
	}
	function checkForBulkExistence($fields,$email = false,$cell_number = false){
		$flag = false;
		$query1 = false;
		$query2 = false;
		$total = sizeof($fields['EMAIL']);
		$email_ids = NULL;
		$cell_numbers = NULL;
		if($total){
			$k = 1;
			$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
			if(get_resource_type($link) == 'mysql link'){
				if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					echo '<table border="1" cellpadding="2" cellspacing="2" width="920" align="center">';
					if($email){
						$query = 'SELECT `email_id` AS email FROM `users` 
								  UNION
								  SELECT `user_id` FROM `email_ids`;';
						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							$email_ids = array();
							$i=1;
							while($row = mysql_fetch_assoc($res)){
								$email_ids[$i] = $row['email'];
								$i++;
							}
						}
						if(is_array($email_ids)){
							echo '<tr><td align="center" colspan="8">Duplicate email ids  in database</td></tr>
								<tr>
									<td align="center">No</td>
									<td align="center">NAME</td>
									<td align="center">GENDER</td>
									<td align="center">DOB</td>
									<td align="center">MOBILE</td>
									<td align="center">EMAIL</td>
									<td align="center">OCCUPATION</td>
									<td align="center">ACS ID</td>
								</tr>';
							for($i=1;$i<=$total;$i++){
								for($j=1;$j<=sizeof($email_ids);$j++){
									if($fields['EMAIL'][$i] == $email_ids[$j] && $email_ids[$j]){
										echo '<tr>
												<td>'.$k.'</td>
												<td>'.$fields['NAME'][$i].'</td>
												<td>'.$fields['GENDER'][$i].'</td>
												<td align="right">'.$fields['DOB'][$i].'</td>
												<td align="right">'.$fields['MOBILE'][$i].'</td>
												<td>'.$fields['EMAIL'][$i].'</td>
												<td>'.$fields['OCCUPATION'][$i].'</td>
												<td align="right">'.$fields['ACS_ID'][$i].'</td>
											</tr>';
										$flag = true;
										$email_ids[$j] = NULL;
										$k++;
									}
								}
							}
						}
						if(!$flag){
							echo '<tr><td align="center" colspan="8">No duplicatie email ids in database</td></tr>';
						}
					}
					else if($cell_number){
						$query = 'SELECT `cell_number` AS cell FROM `users` 
								  UNION
								  SELECT `cell_number` FROM `cell_numbers`;';
						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							$cell_numbers = array();
							$i=1;
							while($row = mysql_fetch_assoc($res)){
								$cell_numbers[$i] = $row['cell'];
								$i++;
							}
						}
						if(is_array($cell_numbers)){
							echo '<tr><td align="center" colspan="8">Duplicate cell numbers  in database</td></tr>
								<tr>
									<td align="center">No</td>
									<td align="center">NAME</td>
									<td align="center">GENDER</td>
									<td align="center">DOB</td>
									<td align="center">MOBILE</td>
									<td align="center">EMAIL</td>
									<td align="center">OCCUPATION</td>
									<td align="center">ACS ID</td>
								</tr>';
							for($i=1;$i<=$total;$i++){
								for($j=1;$j<=sizeof($cell_numbers);$j++){
									if($fields['MOBILE'][$i] == $cell_numbers[$j] && $cell_numbers[$j]){
										echo '<tr>
												<td>'.$k.'</td>
												<td>'.$fields['NAME'][$i].'</td>
												<td>'.$fields['GENDER'][$i].'</td>
												<td align="right">'.$fields['DOB'][$i].'</td>
												<td align="right">'.$fields['MOBILE'][$i].'</td>
												<td>'.$fields['EMAIL'][$i].'</td>
												<td>'.$fields['OCCUPATION'][$i].'</td>
												<td align="right">'.$fields['ACS_ID'][$i].'</td>
											</tr>';
										$flag = true;
										$k++;
									}
								}
							}
						}
						if(!$flag){
							echo '<tr><td align="center" colspan="8">No duplicatie cell numbers  in database</td></tr>';
						}
					}
					echo '</table><p>&nbsp;</p>';
				}
			}
			if(get_resource_type($link) == 'mysql link')
				mysql_close($link);
		}
		return $flag;
	}
	function AddBulk($fields){
		$flag = false;
		$query = false;
		$total = sizeof($fields['EMAIL']);
		$k = 1;
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$curr_time = mysql_result(executeQuery("SELECT NOW();"),0);
				$password = array();
				if($total > 1999){
					$qut = floor($total / 2000);
					$rem = $total % 2000;
					for($i=1;$i<=$qut;$i++){
						$query = 'INSERT INTO `users`(`id`,`name`,`email_id`,`acs_id`,`password`,`apassword`,`cell_number`,`occupation`,`dob`,`sex`,`date_of_join`,`date_of_left`,`passwordreset`,`status`,`mode_of_payment`)  VALUES';
						$query0 = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES";
						for($j=1;$j<=2000&& $j <= $num1;$j++){
							if(checkExistence(false,$fields['EMAIL'][$k],false) == 'failed'){
								$password[$k] = generateRandomString();
								$pass = md5($password[$k]);
								$msg_content = "<html><body><table width='80%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td colspan='2'><span style='font-weight:900; font-size:24px;  color:#999;'>".GYMNAME." account details.</span><br></td></tr><td colspan='2'>&nbsp;</td></tr><tr><td width='50%' align='right'>Name : </td><td width='50%'>".$fields['NAME'][$k]."</td></tr><tr><td width='50%' align='right'>Login id : </td><td width='50%'>".$fields['EMAIL'][$k]."</td></tr><tr><td width='50%' align='right'>Password : </td><td width='50%'>".$password[$k]."</td></tr><tr><td width='50%' align='right'>Access Id : </td><td width='50%'>".$fields['ACS_ID'][$k]."</td></tr><tr><td colspan='2'>Regards,<br>The MadMec team</td></tr></table></body></html>";
								$msg_sub = GYMNAME." : Congrats you have successfully registered.";						
								if(isset($_SESSION['SourceEmailIds'])){
									$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
									$from = $_SESSION['SourceEmailIds'][$index]['email'];
									// $password = $_SESSION['SourceEmailIds'][$index]['password'];
								}
								else{
									$from = MAILUSER;
									// $password = MAILPASS;
								}
								if($j == 2000){
									$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',\''.mysql_real_escape_string($fields['OCCUPATION'][$k]).'\',\''.mysql_real_escape_string($fields['DOB'][$k]).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($curr_time).'\',NULL,NULL,default,NULL);';
									$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
								}
								else{
									$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',\''.mysql_real_escape_string($fields['OCCUPATION'][$k]).'\',\''.mysql_real_escape_string($fields['DOB'][$k]).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($curr_time).'\',NULL,NULL,default,NULL),';
									$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending'),";
								}
								$k++;
							}
						}
					}
					if($rem > 0){
						$query = 'INSERT INTO `users`(`id`,`name`,`email_id`,`acs_id`,`password`,`apassword`,`cell_number`,`occupation`,`dob`,`sex`,`date_of_join`,`date_of_left`,`passwordreset`,`status`,`mode_of_payment`)  VALUES';
						$remaining = $total - ($qut * 2000);
						$query0 = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES (NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
						for($j=1;$j<=$remaining;$j++){
							if(checkExistence(false,$fields['EMAIL'][$k],false) == 'failed'){
								$password[$k] = generateRandomString();
								$pass = md5($password[$k]);
								$msg_content = "<html><body><table width='80%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td colspan='2'><span style='font-weight:900; font-size:24px;  color:#999;'>".GYMNAME." account details.</span><br></td></tr><td colspan='2'>&nbsp;</td></tr><tr><td width='50%' align='right'>Name : </td><td width='50%'>".$fields['NAME'][$k]."</td></tr><tr><td width='50%' align='right'>Login id : </td><td width='50%'>".$fields['EMAIL'][$k]."</td></tr><tr><td width='50%' align='right'>Password : </td><td width='50%'>".$password[$k]."</td></tr><tr><td width='50%' align='right'>Access Id : </td><td width='50%'>".$fields['ACS_ID'][$k]."</td></tr><tr><td colspan='2'>Regards,<br>The MadMec team</td></tr></table></body></html>";
								$msg_sub = GYMNAME." : Congrats you have successfully registered.";						
								if(isset($_SESSION['SourceEmailIds'])){
									$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
									$from = $_SESSION['SourceEmailIds'][$index]['email'];
									// $password = $_SESSION['SourceEmailIds'][$index]['password'];
								}
								else{
									$from = MAILUSER;
									// $password = MAILPASS;
								}
								if($j == $remaining){
									$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',\''.mysql_real_escape_string($fields['OCCUPATION'][$k]).'\',\''.mysql_real_escape_string($fields['DOB'][$k]).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($curr_time).'\',NULL,NULL,default,NULL);';
									$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
								}
								else{
									$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',\''.mysql_real_escape_string($fields['OCCUPATION'][$k]).'\',\''.mysql_real_escape_string($fields['DOB'][$k]).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($curr_time).'\',NULL,NULL,default,NULL),';
									$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending'),";
								}
								$k++;
							}
						}
					}
				}
				else if($total < 2000 && $total >= 1){
					$query = 'INSERT INTO `users`(`id`,`name`,`email_id`,`acs_id`,`password`,`apassword`,`cell_number`,`occupation`,`dob`,`sex`,`date_of_join`,`date_of_left`,`passwordreset`,`status`,`mode_of_payment`)  VALUES';
					$query0 = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES (NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
					for($j=1;$j<=$total;$j++){
						if(checkExistence(false,$fields['EMAIL'][$k],false) == 'failed'){
							$password[$k] = generateRandomString();
							$pass = md5($password[$k]);
							$msg_content = "<html><body><table width='80%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td colspan='2'><span style='font-weight:900; font-size:24px;  color:#999;'>".GYMNAME." account details.</span><br></td></tr><td colspan='2'>&nbsp;</td></tr><tr><td width='50%' align='right'>Name : </td><td width='50%'>".$fields['NAME'][$k]."</td></tr><tr><td width='50%' align='right'>Login id : </td><td width='50%'>".$fields['EMAIL'][$k]."</td></tr><tr><td width='50%' align='right'>Password : </td><td width='50%'>".$password[$k]."</td></tr><tr><td width='50%' align='right'>Access Id : </td><td width='50%'>".$fields['ACS_ID'][$k]."</td></tr><tr><td colspan='2'>Regards,<br>The MadMec team</td></tr></table></body></html>";
							$msg_sub = GYMNAME." : Congrats you have successfully registered.";						
							if(isset($_SESSION['SourceEmailIds'])){
								$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
								$from = $_SESSION['SourceEmailIds'][$index]['email'];
								// $password = $_SESSION['SourceEmailIds'][$index]['password'];
							}
							else{
								$from = MAILUSER;
								// $password = MAILPASS;
							}
							if($j == $total){
								$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',\''.mysql_real_escape_string($fields['OCCUPATION'][$k]).'\',\''.mysql_real_escape_string($fields['DOB'][$k]).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($curr_time).'\',NULL,NULL,default,NULL);';
								$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
							}
							else{
								$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',\''.mysql_real_escape_string($fields['OCCUPATION'][$k]).'\',\''.mysql_real_escape_string($fields['DOB'][$k]).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($curr_time).'\',NULL,NULL,default,NULL),';
								$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending'),";
							}
							$k++;
						}
					}
				}
				if($total){
					$res = executeQuery($query);
					if($res){
						executeQuery($query0);
						$flag = true;
						echo '<h2>'.$k .' customers have been inserted in to database!!!</h2>';
					}
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		return $flag;
	}
	main();
?>