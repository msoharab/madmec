<?php
	function ResetNow($email){
		$reset_link = ResetLink($email);
		if( $reset_link )
		{
			$reset_url = URL.'ajax/recover.php?r='.$reset_link.'&e='.base64_encode($email);
			SendEmail($reset_url,$email);
			echo '<h3 style="color:GREEN;">Please Check your email Id to Reset Password</h3>';
		}
		else{
			echo '<h3 style="color:RED;">The email Id you have entered is not a user please try with different Email ID</h3>';
		}
	}
	function ResetLink($email){
		$reset_link = false;
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$res0 =  mysql_fetch_assoc( executeQuery("SELECT EXISTS(SELECT * FROM `user_profie` WHERE `email_id` = '".mysql_real_escape_string($email)."' ) AS test;") );
				if( $res0['test'] == 1){
					$reset_link = base64_encode($email.rand(0,9999));
					$query = "UPDATE `user_profie` SET 
							`resetreq` = '".mysql_real_escape_string($reset_link)."'
							WHERE 
							`email_id` = '".mysql_real_escape_string($email)."' 
							;";
					$res = executeQuery($query);
				}
				else{
					//since the row does not exist returning false//
					$reset_link = false;
				}
			}
		}
		unset($_POST);
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		return $reset_link;
	}
	function SendEmail($reset_link,$email){
		$flag = false;
		$mail = '';
		set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
		require_once(LIB_ROOT.MODULE_ZEND_1);
		require_once(LIB_ROOT.MODULE_ZEND_2);
		$config = array('auth' => 'login',
					'port' => MAILPORT,
					'username' => MAILUSER,
					'password' => MAILPASS);
			$message = 'Hi, <br />
						To reset your password please click the link below
						<br />
						<br />
						<a href="'.$reset_link.'">Reset Link</a>';
				$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
				if($transport){
					$mail = new Zend_Mail();
					if($mail){
						$mail->setBodyHtml($message);
						$mail->setFrom(MAILUSER, ALTEMAIL);
						$mail->addTo($email, 'Dear User');
						$mail->setSubject(ORGNAME.' password reset link.');
						$flag = true;
					}
				}
				if($flag){
					try{
						$mail->send($transport);
						unset($mail);
						unset($transport);
						$flag = true;
					}
					catch(exceptoin $e){
						echo 'Invalid email id :- '.$email.'<br />';
						$flag = false;
					}
				}
				return $flag;
	}
	
?>

