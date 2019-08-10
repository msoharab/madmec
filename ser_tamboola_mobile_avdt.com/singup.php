<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	define("ZEND_PATH",LIB_ROOT."zend");
	set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
	require_once(LIB_ROOT.MODULE_ZEND_1);
	require_once(LIB_ROOT.MODULE_ZEND_2);
	$parameters = array(
		"autoloader" 		=> isset($_POST["autoloader"])							? $_POST["autoloader"]			: false,
		"action"		=> isset($_POST["action"])							? $_POST["action"]			: false,
		"name"			=> isset($_POST["name"])							? $_POST["name"]			: false,
		"email"			=> (isset($_POST["email"]) && validateEmail($_POST["email"]))			? $_POST["email"]			: false,
		"acs_id"		=> isset($_POST["acs_id"])							? $_POST["acs_id"]			: false,
		"photo_id"		=> isset($_POST["photo_id"])							? $_POST["photo_id"]			: false,
		"directory"		=> (isset($_POST["email"]) && validateEmail($_POST["email"]))			? md5($_POST["email"]).'_user'		: false,
		"password"		=> (isset($_POST["password1"]) && validatePassword($_POST["password1"])) 	? $_POST["password1"]			: false,
		"apassword"		=> (isset($_POST["password2"]) && validatePassword($_POST["password2"])) 	? md5($_POST["password2"])		: false,
		"passwordreset"		=> isset($_POST["passwordreset"])						? $_POST["passwordreset"]		: false,
		"cell_code"		=> isset($_POST["cell_code"])							? $_POST["cell_code"]			: false,
		"cell_number"		=> isset($_POST["cell_number"])							? $_POST["cell_number"]			: false,
		"dob"			=> isset($_POST["dob"])								? $_POST["dob"]				: false,
		"gender"		=> isset($_POST["gender"]) 							? $_POST["gender"]			: 3,
		"date_of_join"		=> isset($_POST["date_of_join"]) 						? $_POST["date_of_join"]		: false,
		"status_id"		=> isset($_POST["status_id"]) 							? $_POST["status_id"]			: 1,
		"addressline"		=> isset($_POST["addressline"]) 						? $_POST["addressline"]			: false,
		"town"			=> isset($_SESSION["IP_INFO"]["town"]) 						? $_SESSION["IP_INFO"]["town"]		: false,
		"city"			=> isset($_SESSION["IP_INFO"]["city"]) 						? $_SESSION["IP_INFO"]["city"]		: false,
		"district"		=> isset($_SESSION["IP_INFO"]["district"]) 					? $_SESSION["IP_INFO"]["district"]	: false,
		"province"		=> isset($_SESSION["IP_INFO"]["regionName"]) 					? $_SESSION["IP_INFO"]["regionName"] 	: false,
		"province_code"		=> isset($_SESSION["IP_INFO"]["region"]) 					? $_SESSION["IP_INFO"]["region"]	: false,
		"country"		=> isset($_SESSION["IP_INFO"]["country"]) 					? $_SESSION["IP_INFO"]["country"]	: false,
		"country_code"		=> isset($_SESSION["IP_INFO"]["countryCode"]) 					? $_SESSION["IP_INFO"]["countryCode"] 	: false,
		"zipcode"		=> isset($_SESSION["IP_INFO"]["zip"]) 						? $_SESSION["IP_INFO"]["zip"]		: false,
		"website"		=> false,
		"latitude"		=> isset($_SESSION["IP_INFO"]["lat"]) 						? $_SESSION["IP_INFO"]["lat"]		: false,
		"longitude"		=> isset($_SESSION["IP_INFO"]["lon"]) 						? $_SESSION["IP_INFO"]["lon"]		: false,
		"timezone"		=> isset($_SESSION["IP_INFO"]["timezone"]) 					? $_SESSION["IP_INFO"]["timezone"]	: false,
		"gmaphtml"		=> false
		/* "town"		=> isset($_POST["town"])							? $_POST["town"]			: false,*/
		/* "city"		=> isset($_POST["city"]) 							? $_POST["city"]			: isset($_SESSION["IP_INFO"]["city"]) 			? $_SESSION["IP_INFO"]["city"] 			: false,*/
		/* "district"		=> isset($_POST["district"]) 							? $_POST["district"]  			: isset($_SESSION["IP_INFO"]["city"]) 			? $_SESSION["IP_INFO"]["city"] 			: false,*/
		/* "province"		=> isset($_POST["province"]) 							? $_POST["province"] 			: isset($_SESSION["IP_INFO"]["regionName"]) 	? $_SESSION["IP_INFO"]["regionName"] 	: false,*/
		/* "province_code"	=> isset($_POST["province_code"]) 						? $_POST["province_code"] 		: isset($_SESSION["IP_INFO"]["region"]) 		? $_SESSION["IP_INFO"]["region"] 		: false,*/
		/* "country"		=> isset($_POST["country"]) 							? $_POST["country"]  			: isset($_SESSION["IP_INFO"]["country"]) 		? $_SESSION["IP_INFO"]["country"] 		: false,*/
		/* "country_code"	=> isset($_POST["country_code"]) 						? $_POST["country_code"]  		: isset($_SESSION["IP_INFO"]["countryCode"]) 	? $_SESSION["IP_INFO"]["countryCode"] 	: false,*/
		/* "zipcode"		=> isset($_POST["zipcode"]) 							? $_POST["zipcode"] 			: isset($_SESSION["IP_INFO"]["zip"]) 			? $_SESSION["IP_INFO"]["zip"] 			: false,*/
		/* "website"		=> isset($_POST["website"]) 							? $_POST["website"] 			: false,*/
		/* "latitude"		=> isset($_POST["latitude"]) 							? $_POST["latitude"] 			: isset($_SESSION["IP_INFO"]["lat"]) 			? $_SESSION["IP_INFO"]["lat"] 			: false,*/
		/* "longitude"		=> isset($_POST["longitude"]) 							? $_POST["longitude"] 			: isset($_SESSION["IP_INFO"]["lon"]) 			? $_SESSION["IP_INFO"]["lon"] 			: false,*/
		/* "timezone"		=> isset($_POST["timezone"]) 							? $_POST["timezone"] 			: isset($_SESSION["IP_INFO"]["timezone"]) 		? $_SESSION["IP_INFO"]["longitude"] 	: false,*/
		/* "gmaphtml"		=> isset($_POST["gmaphtml"]) 							? $_POST["gmaphtml"] 			: false*/
	);
	/* echo '<br />'.print_r($_POST);*/
	unset($_POST);
	function main($parameters){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				switch($parameters["action"]){
					case "signUp":
						signUp($parameters);
					break;
					case "checkExistence":
						echo checkExistence($parameters);
					break;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		exit(0);
	}
	function signUp($parameters){
		$query = '';
		$pk_id = 0;
		$res = 0;
		$flag = 0;
		if(checkExistence($parameters) == 0){
			/* Create directory if does not exist */
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$authenticatkey = md5(date('h-i-s,_j-m-y,_it_is_w_Day_u')."-random resetin the password-".rand(999,999999)."-microtime-".microtime());
			$authlink = urldecode(URL.'authenticate.php?auth='.$authenticatkey);
			$query = 'INSERT INTO `photo` (`id`) VALUES (NULL)';
			executeQuery($query);
			$query = 'INSERT INTO `user_profile` (`id`,
						`user_name`,
						`email_id`,
						`acs_id`,
						`photo_id`,
						`password`,
						`apassword`,
						`authenticatkey`,
						`gender`,
						`status`,
						`city`,
						`province`,
						`province_code`,
						`country`,
						`country_code`,
						`zipcode`,
						`latitude`,
						`longitude`,
						`timezone`)  VALUES(
					NULL,
					\''.mysql_real_escape_string($parameters["name"]).'\',
					\''.mysql_real_escape_string($parameters["email"]).'\',
					\''.mysql_real_escape_string(generateRandomString()).'\',
					LAST_INSERT_ID(),
					\''.mysql_real_escape_string($parameters["password"]).'\',
					\''.mysql_real_escape_string($parameters["apassword"]).'\',
					\''.mysql_real_escape_string($authenticatkey).'\',
					\''.mysql_real_escape_string($parameters["gender"]).'\',
					\''.mysql_real_escape_string($parameters["status_id"]).'\',
					\''.mysql_real_escape_string($parameters["city"]).'\',
					\''.mysql_real_escape_string($parameters["province"]).'\',
					\''.mysql_real_escape_string($parameters["province_code"]).'\',
					\''.mysql_real_escape_string($parameters["country"]).'\',
					\''.mysql_real_escape_string($parameters["country_code"]).'\',
					\''.mysql_real_escape_string($parameters["zipcode"]).'\',
					\''.mysql_real_escape_string($parameters["latitude"]).'\',
					\''.mysql_real_escape_string($parameters["longitude"]).'\',
					\''.mysql_real_escape_string($parameters["timezone"]).'\');';
			$res = executeQuery($query);
			if($res){
				$pk_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
				returnDirectory($parameters,$pk_id);
				$query = 'INSERT INTO `userprofile_type` (`id`,
						`user_pk`,
						`usertype_id`,
						`status`)  VALUES(
					NULL,
					\''.mysql_real_escape_string($pk_id).'\',
					\''.mysql_real_escape_string(10).'\',
					default);';
				$res = executeQuery($query);
				if($res){
					$flag = 1;
				}
			}
		}
		if($flag){
			$message = '<table width="80%" border="0" align="center" cellpadding="3" cellspacing="3">
						<tr>
							<td><p><span style="font-weight:900; font-size:24px;  color:#999;">Find My Gym App account details.</span></p></td>
							<td><img src="'.USER_ANON_IMAGE.'" width="75" alt="Gym Avatar"/></td>
						</tr>
						<tr>
							<td colspan="2">Advertise</td>
						</tr>
						<tr>
							<td width="50%" align="right">Name : </td>
							<td width="50%">'.$parameters["name"].'</td>
						</tr>
						<tr>
							<td width="50%" align="right">Login id : </td>
							<td width="50%">'.$parameters["email"].'</td>
						</tr>
						<tr>
							<td width="50%" align="right">Password : </td>
							<td width="50%">'.$parameters["password"].'</td>
						</tr>
						<tr>
							<td colspan="2" ><a href="'.$authlink.'" style="padding:4px; color:#FFFFFF; text-decoration:none;">Verify '.$parameters["email"].'</a></td>
						</tr>
						<tr>
							<td colspan="2" >Thank you for registering to . Find My Gym App</td>
						</tr>
						<tr>
							<td colspan="2"><p>you received this email because now you are member of Find My Gym App</p></td>
						</tr>
						<tr>
							<td colspan="2">Regards,<br />The MadMec team</td>
						</tr>
						<tr>
							<td colspan="2"><p><a href="https://www.facebook.com/madmec2013"><img src="http://code.madmec.com/images/f_logo.jpg" alt="" width="40" height="40" /></a> <a href="http://www.linkedin.com/company/madmec"><img src="http://code.madmec.com/images/li.jpg" alt="" width="40" height="40" /></a> <a href="http://madmecteam.blogspot.in/2013_12_01_archive.html"><img src="http://code.madmec.com/images/bs.jpg" alt="" width="40" height="40" /></a> <a href="https://plus.google.com/103775735801000838114/posts"><img src="http://code.madmec.com/images/gp.jpg" alt="" width="40" height="40" /></a> <a href="https://www.google.co.in/maps/place/MadMec/@12.898059,77.588587,17z/data=!3m1!4b1!4m2!3m1!1s0x3bae153e3a2818d3:0x90da24ba7189f291"><img src="http://code.madmec.com/images/map.jpg" alt="" width="40" height="40" /></a></p></td>
						</tr>
						<tr>
							<td colspan="2"><p><h4>Do not reply to this mail.</h4></p></td>
						</tr>
					</table>';
			$msg_sub = 'MadMec :: Congrats you have successfully registered in Find My Gym App. Powered By MadMec.';
			if(isset($_SESSION['BIGROCKMAILS'])){
				$index = mt_rand(1,sizeof($_SESSION['BIGROCKMAILS']));
				$email = $_SESSION['BIGROCKMAILS'][$index]['email'];
				$password = $_SESSION['BIGROCKMAILS'][$index]['password'];
			}
			else{
				$email = MAILUSER;
				$password = MAILPASS;
			}
			$config = array('auth' => 'login','port' => BIGROCK_PORT,'username' => $email,'password' => $password);
			$transport = new Zend_Mail_Transport_Smtp(BIGROCK, $config);
			$mail = new Zend_Mail();
			$mail->setBodyHtml($message);
			$mail->setFrom($email, "Find My Gym");
			$mail->setSubject($msg_sub);
			$mail->addTo($parameters["email"], $parameters["name"]);
			try{
				$mail->send($transport);
				executeQuery("COMMIT");
				echo '<div class="row">
						<div class="col-lg-12">
							<font color="#999" size="+2">Registration successfull.</font><br />
							<hr size="1" noshade="noshade" />
							Hi&nbsp;<font color="#000" size="+1" style="font-weight:bold">'.$parameters["name"].',</font>
							<font size="+1">
								Please go to your inbox to complete the sign-up process by a click on link provided.<br />
								<hr size="1" noshade="noshade" />
								'.$parameters["email"].' -- '.date("d/m/Y, G:i:s").' => Email has been sent.<br />
							</font>
						</div>
					</div>';
				echo ' -- '.$parameters["email"].' -- '.date("d/m/Y, G:i:s").' => Email has been sent.<br />';
			}
			catch(exceptoin $e){
				echo '<div class="row">
						<div class="col-lg-12">
							Hi&nbsp;<font color="#000" size="+1" style="font-weight:bold">'.$parameters["name"].',</font>
							<font color="#FF0000" size="+2">Registration unsuccessfull.</font><br />
							<hr size="1" noshade="noshade" />
							'.$parameters["email"].' -- '.date("d/m/Y, G:i:s").' => Email could not be sent.<br />
						</div>
					</div>';
			}
			unset($mail);
			unset($transport);
		}
		else{
			executeQuery("ROLLBACK");
		}
		return $flag;
	}
	if(isset($parameters['autoloader']) && $parameters['autoloader'] == 'true'){
		global $parameters;
		main($parameters);
	}
?>