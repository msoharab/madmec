<?php
	session_start();
	/*error_reporting(0);*/
	date_default_timezone_set('Asia/Kolkata');
	//include_once('mysql2i.class.php');
	/* Database constraints */
	define("DBHOST","localhost");
	define("DBUSER","root");
	define("DBPASS","madmec@418133");
	define("DBNAME_ZERO","tamboola_mobile_avdt");
	define("DBNAME_MAST","madmec_data");
	$temp = explode("/",rtrim($_SERVER['DOCUMENT_ROOT'],"/"));
	$doc_path = $_SERVER['DOCUMENT_ROOT']."/";
	$libroot = str_replace($temp[count($temp)-1],"library",$_SERVER['DOCUMENT_ROOT'])."/";
	define("DOC_ROOT",$doc_path);
	define("LIB_ROOT",$libroot);
	/* BIGROCK HOST */
	define("BIGROCK","208.91.199.224");
	/* BIGROCK PORT */
	define("BIGROCK_PORT",587);
	/* GMAIL HOST */
	define("GMAIL","smtp.gmail.com");
	/* GMAIL PORT */
	define("GMAIL_PORT",587);
	/* MADMEC HOST */
	define("MADMEC","182.18.131.149");
	/* MADMEC PORT */
	define("MAILPORT",465);
	define("IMG_CONST",400);
	define("MAILUSER","gift11@madmec.com");
	define("MAILPASS","splasher777@");
	define("MODULE_ZEND_1","Zend/Mail.php");
	define("MODULE_ZEND_2","Zend/Mail/Transport/Smtp.php");
	 /* define("URL","http://local.tamboola.mobileavdt.com/");*/
	define("URL","http://findmygym.tamboola.com/");
	/* define("URL","http://local.fmg.com/");*/
	/*define("URL","http://tamboola-avdt.localmm.com/");*/
	/* define("URL","http://www.tamboola.com/");*/
	define("INC","inc/");
	define("DOWNLOADS","downloads/");
	define("UPLOADS","uploads/");
	define("ASSET_DIR","assets/");
	define("ASSET_JSF","assets/js/");
	define("ASSET_CSS","assets/css/");
	define("ASSET_IMG","assets/images/");
	define("ASSET_JQF","jQuery/");
	define("ASSET_BSF","bootstrap/");
	define("ICON_THEME","set1/");
	/* define("ICON_THEME","set2/");*/
	define("DGYM_ID","#printrs");
	define("GYMNAME",isset($_SESSION["SETGYM"]["GYM_NAME"])	?	$_SESSION["SETGYM"]["GYM_NAME"]:"SELECT GYM");
	define("REG_FEE",500);
	define("START_DATE","2014-02-03");
	define("ST_PER",0.1236);
	define("CELL_CODE","+91");
	define("CURRENCY_SYM_1X","<i class='fa fa-inr'></i>");
	define("CURRENCY_SYM_2X","<i class='fa fa-inr fa-2x'></i>");
	define("CURRENCY_SYM_3X","<i class='fa fa-inr fa-3x'></i>");
	define("CURRENCY_SYM_4X","<i class='fa fa-inr fa-4x'></i>");
	define("CURRENCY_SYM_5X","<i class='fa fa-inr fa-5x'></i>");
	define("GYM_LOGO",URL.ASSET_IMG."short-logo.jpg");
	$bootstrapProperties = array(
		"pageheader_color" => "text-primary",
		"panel_color" => ""
	);
	/*Customer constraints*/
	define("USER_ANON_IMAGE",URL.ASSET_IMG."any.png");
	/*gym constraints*/
	define("GYM_ANON_IMAGE",URL.ASSET_IMG."any.png");
	/*Admin constraints*/
	define("ADMIN_ANON_IMAGE",URL.ASSET_IMG."any.png");
	 /*Trainer constraints*/
	define("TRAIN_ANON_IMAGE",URL.ASSET_IMG."any.png");
	function validateUserName($uname){
		if(preg_match('%^[A-Z_a-z\."\- 0-9]{3,100}%',stripslashes(trim($uname)))){
			return $uname;
		}
		else{
			return NULL;
		}
	}
	function validatePassword($pass){
		if(strlen($pass) > 3){
			return $pass;
		}
		else{
			return NULL;
		}
	}
	function validateEmail($email){
		if(preg_match('%^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})%',stripslashes(trim($email)))){
			return $email;
		}
		else{
			return NULL;
		}
	}
	function ValidateAdmin(){
		$flag = false;
		if(!isset($_SESSION["USER_LOGIN_DATA"])){
			return $flag;
		}
		else if( isset($_SESSION["USER_LOGIN_DATA"]["STATUS"]) && $_SESSION["USER_LOGIN_DATA"]["STATUS"] == 'success' ){
		
			$query = 'SELECT *
				FROM `user_profile` 
				WHERE 
				`email_id`=\''.mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_EMAIL"]).'\' 
				AND 
				`password`=\''.mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_PASS"]).'\';';
			$res = executeQuery($query);
			if(mysql_num_rows($res)){
				$row = mysql_fetch_assoc($res);
				$query1='select t.`type`
				from `user_type` as t
				join `userprofile_type` as utp
				on t.`id`=utp.`usertype_id`
				join `user_profile` as up
				on utp.`user_pk`=\''.$row["id"].'\'
				WHERE
				t.`status`=(SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND status=1)
				group by t.`type`;';
				
				$res1 = executeQuery($query1);
				if(get_resource_type($res1) == 'mysql result'){
					if(mysql_num_rows($res1) > 0){
						$row1 = mysql_fetch_assoc($res1);
					$_SESSION["USER_LOGIN_DATA"] = array(
					"USER_EMAIL" 	=> $row["email_id"],
					"USER_PASS" 	=> $row["password"],
					"USER_ID" 		=> $row["id"],
					"USER_NAME" 	=> $row["user_name"],
					"USER_TYPE" 	=> $row1["type"],
					"GYM_DETAILS" => array(),
					"STATUS" 		=> 'success'
					);
				if($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"]=="Admin"){
					$numgym=0;
					$query = 'SELECT g.*
					FROM `gym_profile` AS g 
					JOIN `userprofile_gymprofile` AS ug
					ON g.`id`=ug.`gym_id`
					JOIN user_profile AS u
					ON ug.`user_pk`=\''.$row["id"].'\'
					WHERE
					ug.`status`=(SELECT `id` FROM `status` WHERE `statu_name`=\'Active\' AND status=1)
					GROUP BY g.`gym_name`;';
					$res = executeQuery($query);
					if(get_resource_type($res) == 'mysql result'){
						if(mysql_num_rows($res) > 1){
							while($row = mysql_fetch_assoc($res)){
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_ID"]			=	$row["id"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_NAME"]		=	$row["gym_name"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_HOST"]		=	$row["db_host"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_USERNAME"]	=	$row["db_username"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_DB_NAME"]		=	$row["db_name"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_DB_PASSWORD"]	=	$row["db_password"];
								$numgym++;
								$_SESSION["SETGYM"]=array(
									"GYM_ID"	=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_ID"],
									"GYM_NAME"	=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_NAME"],
									"GYM_HOST"			=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_HOST"],
									"GYM_USERNAME"		=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_USERNAME"],
									"GYM_DB_NAME"		=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_DB_NAME"],
									"GYM_DB_PASSWORD"	=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_DB_PASSWORD"],
								);
							}
					}
					elseif(mysql_num_rows($res) == 1){
								$row = mysql_fetch_assoc($res);
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_ID"]			=	$row["id"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_NAME"]		=	$row["gym_name"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_HOST"]		=	$row["db_host"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_USERNAME"]	=	$row["db_username"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_DB_NAME"]		=	$row["db_name"];
								$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_DB_PASSWORD"]	=	$row["db_password"];
								$_SESSION["SETGYM"]=array(
									"GYM_ID"	=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_ID"],
									"GYM_NAME"	=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_NAME"],
									"GYM_HOST"			=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_HOST"],
									"GYM_USERNAME"		=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_USERNAME"],
									"GYM_DB_NAME"		=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_DB_NAME"],
									"GYM_DB_PASSWORD"	=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$numgym]["GYM_DB_PASSWORD"],
								);
					}
				}
			}
			$flag = true;
					}
				}
			
			}
		}
		return $flag;
	}
	function returnDirectory(& $parameters,$pk_id){
		$query = 'SELECT `directory` FROM `user_profile` WHERE `email_id`=\''.mysql_real_escape_string($parameters["email"]).'\';';
		$res = executeQuery($query);
		$row = mysql_fetch_assoc($res);
		if(!empty($row["directory"])){
			$parameters["directory"] = mysql_result($res,0);
			/* Create directory if does not exist */
			createdirectories($parameters["directory"]);
		}
		else{
			/* Create directory if does not exist */
			$directory = createdirectories($parameters["directory"]);
			/* Update the directory in users table */
			$query = 'UPDATE `user_profile` SET `directory` = \''.$directory.'\' WHERE `email_id`=\''.mysql_real_escape_string($parameters["email"]).'\' AND `id` = \''.$pk_id.'\';';
			executeQuery($query);
		}
	}
	function generateRandomString($length = 6){
		/* $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';*/
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$randomString = '';
		for ($i = 0; $i < $length; $i++){
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		if(strlen($randomString) > 5)
			return $randomString;
		else
			generateRandomString();
	}
	function getStatusId($statname = false){
		$row = 0;
		$statname = ucfirst($statname);
		$res=executeQuery('SELECT `id` FROM `status` WHERE `statu_name` =\''.$statname.'\';');
		if(mysql_num_rows($res)){
			$row = mysql_result($res,0);
		}
		return $row;
	}
	function getUserTypeId($usertype = false){
		$statname = ucfirst($usertype);
		$res=executeQuery('SELECT `id` FROM `user_type` WHERE `type` ="'.$usertype.'";');
		$row = mysql_fetch_assoc($res);
		return $row["id"];
	}
	function fetchAddress($gymid = false){	
		$gympic = '';
		$address = "";
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = 'SELECT
					ur.*,
					CASE WHEN ur.`photo_id` IS NULL
						 THEN \''.GYM_ANON_IMAGE.'\'
						 ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph3.`ver3`)
					END AS photo
				FROM `gym_profile` AS ur
				LEFT JOIN `gym_photo` AS ph3 ON ur.`photo_id` = ph3.`id`
				WHERE ur.`id`=\''.mysql_real_escape_string($gymid).'\';';
				$res = executeQuery($query);
				if(get_resource_type($res) == 'mysql result'){
					if(mysql_num_rows($res) > 0){
						$row = mysql_fetch_assoc($res);
						$address .= "<table border='0' >
								<tr>
									<td  valign='top'>
									<span style='font-size:17px;color:#666;'>Address</span>
										<br />
										".$row['gym_name'].",
										".$row['addressline'].",
										".$row['city']." - ".$row['zipcode']."
										<br />
										ph:-".$row['cell_number']."
										<br />
										email:- ".$row['email']."
										<br />
										website: -".$row['website']."
									</td>
								</tr>
							</table>";
						$gympic = $row["photo"];
						$gname = $row["gym_name"];
					}
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		
		$gymDATA = array(
			"gympic" => $gympic,
			"add"	=> $address,
			"gname"	=> $gname,
		);	
		return $gymDATA;
	}
	function createdirectories($directory){
		/* LOCAL VARIABLES DECLARAION */
		/*Conditional flags*/
		$flag = false;
		$i = 0;
		$temp = '';
		/* Get current user directory*/
		$temp = getCurrUserDir();
		$temp = explode(";",$temp);
		$curr_dir = $temp[0];
		$curr_num = $temp[1];
		$i = Number_directories(DOC_ROOT.ASSET_DIR.$curr_dir);
		if($i < 100001){
			$sruct_array = array(
				DOC_ROOT.ASSET_DIR."$curr_dir/$directory/",
				DOC_ROOT.ASSET_DIR."$curr_dir/$directory/temp/",
				DOC_ROOT.ASSET_DIR."$curr_dir/$directory/profile/",
				DOC_ROOT.ASSET_DIR."$curr_dir/$directory/profile/temp");
		}
		else{
			$curr_num++;
			$curr_dir = "res_".$curr_num;
			createDirectory(DOC_ROOT.ASSET_DIR.$curr_dir);
			file_put_contents(DOC_ROOT.ASSET_DIR.$curr_dir."/index.php","<?php header('Location:".URL."'); ?>");
			$sruct_array = array(
				DOC_ROOT.ASSET_DIR."$curr_dir/$directory/temp/",
				DOC_ROOT.ASSET_DIR."$curr_dir/$directory/profile/",
				DOC_ROOT.ASSET_DIR."$curr_dir/$directory/profile/temp");
		}
		createDirectory(DOC_ROOT.ASSET_DIR.$curr_dir);
		file_put_contents(DOC_ROOT.ASSET_DIR.$curr_dir."/index.php","<?php header('Location:".URL."'); ?>");
		for($i = 0;$i < sizeof($sruct_array); $i++){
			if(PHP_OS == 'WINNT' || PHP_OS == 'WIN32'){
				if(!file_exists($sruct_array[$i])){
					if (!mkdir($sruct_array[$i], 0, true)  && !is_dir($sruct_array[$i]) ){
						$flag = false;
						break;
					}
					else{
						$flag = true;
					}
				}
			}
			if(PHP_OS == 'Linux'){
				if(!file_exists($sruct_array[$i])){
					if (!mkdir($sruct_array[$i], 0755, true)  && !is_dir($sruct_array[$i]) ) {
						$flag = false;
						break;
					}
					else{
						$flag = true;
					}
				}
			}
			file_put_contents($sruct_array[$i]."/index.php","<?php header('Location:".URL."'); ?>");
		}
		if($flag){
			$curr_dir = $curr_dir."/".$directory;
			return $curr_dir;
		}
		else
			return NULL;
	}
	function getCurrUserDir(){
		$i = 2;
		$dir = DOC_ROOT.ASSET_DIR;
		$curr = '';
		$total = 0;
		if (is_dir($dir)){
			if ($dh = opendir($dir)){
				while ($file = readdir($dh)){
					if(is_dir($dir.$file)){
						$curr = "res_".$i;
						if($file == "." || $file == ".." || $file == "css" || $file == "js" || $file == "images")
							continue;
						if($file == $curr)
							$i++;
						if($file != $curr){
							$i--;
							$curr = "res_".$i;
							break;
						}
					}
				}
			}
			closedir($dh);
		}
		$curr = $curr.";".$i;
		return $curr;
	}
	function Number_directories($dir){
		$i = 0;
		if (is_dir($dir)){
			if ($dh = opendir($dir)){
				while ($file = readdir($dh)){
					if(is_dir($dir."/".$file) && $file != "." && $file != ".."){
						$i++;
					}
				}
			}
			closedir($dh);
		}
		return $i;
	}
	function createDirectory($path1){
		if(PHP_OS == 'WINNT' || PHP_OS == 'WIN32'){
			if(!file_exists($path1)){
				mkdir($path1, 0, true);
			}
		}
		if(PHP_OS == 'Linux'){
			if(!file_exists($path1)){
				mkdir($path1, 0777, true);
			}
			}
	
		file_put_contents($path1."/index.php","<?php header('Location:".URL."'); ?>");
	}
	function delete_temp_files($source){
		if(is_dir($source)){
			$files = scandir($source);
			foreach ($files as $file){
				if (in_array($file, array(".","..","temp","index.php")))
					continue;
				unlink($source.$file);
			}
		}
		else
			createDirectory($source);
	}
	function checkExistence($parameters){
		/* Does not exist */
		$flag = 0; 
		$query = '';
		if(isset($parameters["cell_number"]) && $parameters["cell_number"]){
			$query = 'SELECT `cell_number` FROM `user_profile` AS cell WHERE `cell_number` = \''.mysql_real_escape_string($parameters["cell_number"]).'\';';
		}
		else if(isset($parameters["email"]) && $parameters["email"]){
			if(validateEmail($parameters["email"]))
				$query = 'SELECT `email_id` FROM `user_profile` WHERE `email_id` = \''.mysql_real_escape_string($parameters["email"]).'\';';
		}
		else if(isset($parameters["acs_id"]) && $parameters["acs_id"]){
			$query = 'SELECT `acs_id` FROM `user_profile` WHERE `acs_id` = \''.mysql_real_escape_string($parameters["acs_id"]).'\';';
		}
		if(!empty($query)){
			$num = mysql_num_rows(executeQuery($query));
			if($num != 0){
				/* Does exist */
				$flag = 1; 
			}
		}
		return $flag;
	}
	function returnRandomSourceEmail(){
		require_once(LIB_ROOT."PHPExcel_1.7.9/Classes/PHPExcel.php");
		/*$thefile1 = LIB_ROOT."CMS-EmailIds-madmec-Export.xlsx";*/
		$thefile2 = LIB_ROOT."CMS-EmailIds-bigrock-Export.xlsx";
		/*$thefile3 = LIB_ROOT."CMS-EmailIds-gmail-Export.xlsx";*/
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		/*$objPHPExcel = $objReader->load($thefile1);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		if ($highestRow > 0){
			$_SESSION['MADMECMAILS'] = array();
			for ($row = 1,$j = 0; $row <= $highestRow; ++$row,$j++) {
				$_SESSION['MADMECMAILS'][$j]['email'] = preg_replace('~\x{00a0}~','',$objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
				$_SESSION['MADMECMAILS'][$j]['password'] = preg_replace('~\x{00a0}~','',$objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
			}
		}*/
		$objPHPExcel = $objReader->load($thefile2);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		if ($highestRow > 0){
			$_SESSION['BIGROCKMAILS'] = array();
			for ($row = 1,$j = 0; $row <= $highestRow; ++$row,$j++) {
				$_SESSION['BIGROCKMAILS'][$j]['email'] = preg_replace('~\x{00a0}~','',$objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
				$_SESSION['BIGROCKMAILS'][$j]['password'] = preg_replace('~\x{00a0}~','',$objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
			}
		}
		/*$objPHPExcel = $objReader->load($thefile3);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		if ($highestRow > 0){
			$_SESSION['GMAIL'] = array();
			for ($row = 1,$j = 0; $row <= $highestRow; ++$row,$j++) {
				$_SESSION['GMAIL'][$j]['email'] = preg_replace('~\x{00a0}~','',$objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
				$_SESSION['GMAIL'][$j]['password'] = preg_replace('~\x{00a0}~','',$objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
			}
		}*/
		$objPHPExcel->disconnectWorksheets();
		unset($objPHPExcel);
		unset($objReader);
	}
?>
