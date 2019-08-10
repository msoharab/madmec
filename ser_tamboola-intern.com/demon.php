<?php
	define("MODULE_0","config.php");
	define("MODULE_1","database.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	function main(){
		$pre_date = date('Y-m-d', strtotime("+3 days"));
		$today = date('Y-m-d');
		$post_date = date('Y-m-d', strtotime("-3 days"));
		if(!isset($_SESSION['SourceEmailIds'])){
			returnRandomSourceEmail();
		}
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$result_pre = TestExpiry($pre_date,false);
				$result_today = TestExpiry($today,false);
				$result_post = TestExpiry($post_date,false);
				$result_pre1 = TestExpiry($pre_date,true);
				$result_today1 = TestExpiry($today,true);
				$result_post1 = TestExpiry($post_date,true);
				$_SESSION['IPaddress'] = get_client_ip();
				if($result_pre){
					$subject = "GYMNAME: Expiry Reminder.";
					$message = "Hi,<br /> You gym subscription is expiring on ".date('d-m-y', strtotime("+3 days")).", please extend your validity and enjoy workout.";
					SendAppMsg($result_pre,$message);
					SendEmailMsg($result_pre1,$subject,$message);
					SendSMSMsg($result_pre,$message);
				}
				else if($result_today){
					$subject = "GYMNAME: Expiry Reminder.";
					$message = "Hi,<br /> You gym subscription is expiring Today, please extend your validity and enjoy workout.";
					SendAppMsg($result_today,$message);
					SendEmailMsg($result_today1,$subject,$message);
					SendSMSMsg($result_today,$message);
				}
				else if($result_post){
					$subject = "GYMNAME: Expiry Reminder.";
					$message = "Hi,<br /> You gym subscription has expired, please extend your validity and enjoy workout.";
					SendAppMsg($result_post,$message);
					SendEmailMsg($result_post1,$subject,$message);
					SendSMSMsg($result_post,$message);
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		exit(0);
	}
	function get_client_ip(){
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else if(isset($_SERVER['REMOTE_HOST']))
			$ipaddress = $_SERVER['REMOTE_HOST'];
		else
			$ipaddress = NULL;
		return $ipaddress;
	}
	function TestExpiry($days,$dummy){
		$msg_to = false;
		if($dummy)
			$query = "SELECT * FROM `fee` WHERE  user_id` NOT IN (SELECT `user_id` FROM `dummy_email_ids`);";
		else
			$query = "SELECT * FROM `fee` WHERE `valid_till` LIKE '".$days."%';";
		$res = executeQuery($query);
		if(get_resource_type($res) == 'mysql result'){
			if(mysql_num_rows($res) > 0){
				$i = 1;
				$msg_to = array();
				while($row = mysql_fetch_assoc($res)){
					$msg_to[$i]['email'] = $row['user_id'];
					$msg_to[$i]['cell'] = $row['cell_number'];
					$i++;
				}
			}
		}
		return $msg_to;
	}
	function SendAppMsg($msg_to,$msg_content){
		$str = "";
		$query = "";
		$total = sizeof($msg_to);
		if($total > 0){
			$query = "INSERT INTO `crm_messages`(`id`,`from`, `to_email`, `text`, `msg_type`, `date`, `to_status`, `status`)VALUES";
			for($i=1;$i<=$total;$i++){
				if($i == $total)
					$query .= "(NULL,'automatic','".mysql_real_escape_string($msg_to[$i]['email'])."','".mysql_real_escape_string($msg_content)."',3,NOW(),default,'sent');";
				else
					$query .= "(NULL,'automatic','".mysql_real_escape_string($msg_to[$i]['email'])."','".mysql_real_escape_string($msg_content)."',3,NOW(),default,'sent'),";
				$str .= $_SESSION['IPaddress']." -- ".$msg_to[$i]." -- ".date("d/m/Y, G:i:s") ." => APP Msg has been sent.\n";
			}
			executeQuery($query);
		}
		else{
			$str .= $_SESSION['IPaddress']." -- ".$$msg_to[$i]['email']." -- ".date("d/m/Y, G:i:s") ." => Didn't find any expired customers.\n";
		}
		add_logs($str);
		return $flag;
	}
	function SendEmailMsg($msg_to,$msg_sub,$msg_content){
		$str = "";
		$query = "";
		$email = '';
		$password = '';
		$config = array();
		$transport = '';
		$mail = '';
		$recipients = array();
		$qut = 0;
		$rem = 0;
		$name = 'Customer';
		$m = 0;
		$total = sizeof($msg_to);
		if($total > 0){
			/* Build  recipients array one source thirty recipients */
			$i=1;
			$m=1;
			$to = '';
			set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
			require_once(LIB_ROOT.MODULE_ZEND_1);
			require_once(LIB_ROOT.MODULE_ZEND_2);
			if($total > 30){
				$qut = floor($total / 30);
				$rem = $total % 30;
				for(;$i<=$qut;$i++){
					if(isset($_SESSION['SourceEmailIds'])){
						$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
						$email = $_SESSION['SourceEmailIds'][$index]['email'];
						$password = $_SESSION['SourceEmailIds'][$index]['password'];
					}
					else{
						$email = MAILUSER;
						$password = MAILPASS;
					}
					$config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
					$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
					$mail = new Zend_Mail();
					$mail->setBodyHtml($msg_content);
					$mail->setFrom($email, GYMNAME);
					$mail->setSubject($msg_sub);
					$query = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES";
					for($j=1;$j<=30 && $m <= $total;$j++){
					$query = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES";
						if($j ==  30)
							$query .= "(NULL,'automatic','".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'sent');";
						else
							$query .= "(NULL,'automatic','".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'sent'),";
						$mail->addTo($msg_to[$m]['email'], $name);
						$to .= $msg_to[$m]['email'] .',';
						$m++;
					}
					try{
						$mail->send($transport);
						$str .= $_SESSION['IPaddress']." -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email has been sent.\n";
						executeQuery($query);
					}
					catch(exceptoin $e){
						$str .= $_SESSION['IPaddress']." -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email could not be sent.\n";
					}
					unset($mail);
					unset($transport);
				}
				if($rem > 0){
					$to ='';
					$remaining = $total - ($qut * 30);
					if(isset($_SESSION['SourceEmailIds'])){
						$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
						$email = $_SESSION['SourceEmailIds'][$index]['email'];
						$password = $_SESSION['SourceEmailIds'][$index]['password'];
					}
					else{
						$email = MAILUSER;
						$password = MAILPASS;
					}
					$config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
					$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
					$mail = new Zend_Mail();
					$mail->setBodyHtml($msg_content);
					$mail->setFrom($email, GYMNAME);
					$mail->setSubject($msg_sub);
					$query = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES";
					for($j=1;$j<=$remaining && $m <= $total-1;$j++){
						if($j ==  $remaining)
							$query .= "(NULL,'automatic','".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'sent');";
						else
							$query .= "(NULL,'automatic','".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'sent'),";
						$mail->addTo($msg_to[$m]['email'], $name);
						$to .= $msg_to[$m]['email'] .',';
						$m++;
					}
					try{
						$mail->send($transport);
						$str .= $_SESSION['IPaddress']." -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email has been sent.\n";
						executeQuery($query);
					}
					catch(exceptoin $e){
						$str .= $_SESSION['IPaddress']." -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email could not be sent.\n";
					}
					unset($mail);
					unset($transport);
				}
			}
			else if($total < 31 && $total >= 1){
				$to ='';
				if(isset($_SESSION['SourceEmailIds'])){
					$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
					$email = $_SESSION['SourceEmailIds'][$index]['email'];
					$password = $_SESSION['SourceEmailIds'][$index]['password'];
				}
				else{
					$email = MAILUSER;
					$password = MAILPASS;
				}
				$config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
				$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
				$mail = new Zend_Mail();
				$mail->setBodyHtml($msg_content);
				$mail->setFrom($email, GYMNAME);
				$mail->setSubject($msg_sub);
				$query = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES";
				for($j=1;$j<=$total && $m <= $total-1;$j++){
					if($j ==  $total)
						$query .= "(NULL,'automatic','".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'sent');";
					else
						$query .= "(NULL,'automatic','".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'sent'),";
					$mail->addTo($msg_to[$m]['email'], $name);
					$to .= $msg_to[$m]['email'] .',';
					$m++;
				}
				try{
					$mail->send($transport);
					$str .= $_SESSION['IPaddress']." -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email has been sent.\n";
					executeQuery($query);
				}
				catch(exceptoin $e){
					$str .= $_SESSION['IPaddress']." -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email could not be sent.\n";
				}
				unset($mail);
				unset($transport);
			}
		}
		if(strlen($str))
			add_logs($str);
	}
	function SendSMSMsg($msg_to,$msg_content){
		$str = "";
		$query = "";
		$total = sizeof($msg_to);
		if($total > 0){
			$query = "INSERT INTO `crm_sms` ( `id`, `from`, `to_email`,`to_mobile`, `text`, `msg_type`, `date`, `status`) VALUES";
			for($i=1;$i<=$total;$i++){
				$to_mobile = $msg_to[$i]['cell'];
				if($i == $total)
					$query .= "(NULL,'automatic','".mysql_real_escape_string($msg_to[$i]['email'])."','".mysql_real_escape_string($to_mobile)."','".mysql_real_escape_string($msg_content)."','".mysql_real_escape_string('4')."',NOW(),'".mysql_real_escape_string('pending')."'),";
				else
					$query .= "(NULL,'automatic','".mysql_real_escape_string($msg_to[$i]['email'])."','".mysql_real_escape_string($to_mobile)."','".mysql_real_escape_string($msg_content)."','".mysql_real_escape_string('4')."',NOW(),'".mysql_real_escape_string('pending')."'),";
				$res = executeQuery($query);
				if($res){
					$str .= $_SESSION['IPaddress']." -- ".$msg_to[$i]['cell']."(".$to_mobile.")"." -- ".date("d/m/Y, G:i:s")." => SMS has been sent.\n";
				}
			}
		}
		if(strlen($str))
			add_logs($str);
	}
	function add_logs($str){
		$file = DOC_ROOT.ASSET_DIR.'logs/msg_logs.txt';
		$fh = fopen($file,"a+");
		fwrite($fh,$str);
		fclose($fh);
	}
	main();
?>