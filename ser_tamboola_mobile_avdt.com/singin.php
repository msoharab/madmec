<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	$parameters = array(
		"autoloader" 	=> isset($_POST["autoloader"])							? $_POST["autoloader"]		: false,
		"action"	=> isset($_POST["action"])							? $_POST["action"]		: false,
		"email"		=> (isset($_POST["email"]) && validateEmail($_POST["email"]))			? $_POST["email"] 		: false,
		"password"	=> (isset($_POST["password"]) && validatePassword($_POST["password"]))		? $_POST["password"]		: false,
		"browser"	=> isset($_POST["browser"])							? $_POST["browser"]		: false
	);
	unset($_POST);
	function main($parameters){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$flag = ValidateAdmin();
				if($flag){
					echo "login";
				}
				else if(!$flag){
					switch($parameters["action"]){
						case "signIn":
							$userdata = userLogin($parameters);
							echo $userdata["STATUS"];
						break;
						case "checkExistence":
							echo checkExistence($parameters);
						break;
					}
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		exit(0);
	}
	function userLogin($parameters){
		$userdata = array(
			"USER_EMAIL" 	=> NULL,
			"USER_PASS" 	=> NULL,
			"USER_ID"	=> NULL,
			"USER_NAME" 	=> NULL,
			"USER_TYPE" 	=> NULL,
			"ACS_ID" 	=> NULL,
			"STATUS"	=> 'error'
		);
		/* check username and password */
		$query = 'SELECT up.`id`,
					up.`user_name`,
					up.`password`,
					up.`email_id`,
					up.`acs_id`,
					ut.`type`
					FROM `user_profile` AS up
					RIGHT JOIN `userprofile_type` AS upt  ON up.`id` = upt.`user_pk`
					LEFT JOIN `user_type` AS ut ON upt.`usertype_id`= ut.`id` 
					WHERE `email_id`=\''.mysql_real_escape_string($parameters["email"]).'\' 
					AND  `password`=\''.mysql_real_escape_string($parameters["password"]).'\';';
		$res = executeQuery($query);
		if(get_resource_type($res) == 'mysql result'){
			if(mysql_num_rows($res) > 0){
				$row = mysql_fetch_assoc($res);
				if( $row["email_id"] 	== $parameters["email"] &&
					$row["password"] == $parameters["password"]
				){
					$userdata = array(
							"USER_EMAIL" 	=> $row["email_id"],
							"USER_PASS" 	=> $row["password"],
							"USER_ID"	=> $row["id"],
							"USER_NAME" 	=> $row["user_name"],
							"USER_TYPE" 	=> $row["type"],
							"ACS_ID" 	=> $row["acs_id"],
							"STATUS"	=> 'success'
					);
					if($userdata["USER_TYPE"]=="Admin"){
						$_SESSION["SETGYM"] = array();
						$query = 'SELECT g.*
						FROM `gym_profile` AS g 
						JOIN `userprofile_gymprofile` AS ug
						ON g.`id`=ug.`gym_id`
						JOIN user_profile AS u
						ON ug.`user_pk`=\''.$row["id"].'\'
						WHERE
						ug.`status`=(SELECT `id` FROM `status` WHERE `statu_name`=\'Active\' AND status=1);';
						$res = executeQuery($query);
						if(get_resource_type($res) == 'mysql result'){
							if(mysql_num_rows($res) > 0){
								$row = mysql_fetch_assoc($res);
								$_SESSION["SETGYM"]=array(
									"GYM_ID"	=>	$row["id"],
									"GYM_NAME"	=>	$row["gym_name"]
								);
							}
						}
					}
					$query = 'UPDATE `user_profile` SET `login` = 1 WHERE `email_id` = \''.mysql_real_escape_string($parameters["email"]).'\' 
										AND  `password` = \''.mysql_real_escape_string($parameters["password"]).'\'
										AND `id` = \''.$userdata["USER_ID"].'\';';
					executeQuery($query);
				}else if($row["email_id"] == $parameters["email"] && 
					$row["password"] != $parameters["password"]){
					$userdata = array(
						"USER_EMAIL" 	=> NULL,
						"USER_PASS" 	=> $parameters["password"],
						"USER_ID"	=> NULL,
						"USER_NAME" 	=> $parameters["user_name"],
						"STATUS"	=> 'password'
					);
				}
			}
		}
		$_SESSION["USER_LOGIN_DATA"] = $userdata;
		return $userdata;
	}
	function updateUserlog($parameters,$id){
		$curr_time = mysql_result(executeQuery("SELECT NOW();"),0);
		$query = 'INSERT INTO `user_logs` (`id`,
					`ip`,
					`host`,
					`city`,
					`zipcode`,
					`province`,
					`province_code`,
					`country`,
					`country_code`,
					`latitude`,
					`longitude`,
					`timezone`,
					`organization`,
					`isp`,
					`browser`,
					`user_pk`,
					`in_time`)  VALUES(
				NULL,
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["query"]).'\',
				\''.mysql_real_escape_string($_SERVER["SERVER_ADDR"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["city"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["zip"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["regionName"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["region"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["country"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["countryCode"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["lat"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["lon"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["timezone"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["org"].'♥♥♥'.$_SESSION["IP_INFO"]["as"].'♥♥♥'.$_SESSION["IP_INFO"]["isp"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["isp"]).'\',
				\''.mysql_real_escape_string($parameters["browser"]).'\',
				\''.mysql_real_escape_string($id).'\',
				default);';
		executeQuery($query);
	}
	if(isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true'){
		global $parameters;
		main($parameters);
	}
?>