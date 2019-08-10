<?php
	define("MODULE_0","config.php");
	define("MODULE_1","database.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	function main(){
		$flag = false;
		if(isset($_POST['action']) && 
		$_POST['action'] == 'sendsingle' && 
		preg_match('%^[A-Za-z0-9 ()\.\-_,]{1,160}$%',stripslashes(trim($_POST['msg_txt']))) && 
		preg_match('%[0-9]{10}$%',stripslashes(trim($_POST['to_num'])))){
			require_once "sms-config.php";
			require_once "EnvayaSMS.php";
			$message = new EnvayaSMS_OutgoingMessage();
			$message->id = uniqid("");
			$message->to = $_POST['to_num'];
			$message->message = $_POST['msg_txt'];
			$sms_id = $_POST['sms_id'];
			if(file_put_contents("$OUTGOING_DIR_NAME/{$message->id}.json", json_encode($message))){
				$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
				if(get_resource_type($link) == 'mysql link'){
					if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
						$res = executeQuery("UPDATE `crm_sms` SET `status`='sent' WHERE `id` = '".mysql_real_escape_string($sms_id)."';");
						if($res)
							$flag = true;
					}
				}
				if(get_resource_type($link) == 'mysql link')
					mysql_close($link);
			}
		}
		if(!$flag)
			echo '0';
		else
			echo '1';
		return;
	}
	main();
?>