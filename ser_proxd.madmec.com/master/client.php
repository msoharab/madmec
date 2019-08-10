<?php
class client{
	protected $parameters = array();
	private $order   = array("\r\n", "\n", "\r", "\t");
	private $replace = '';
	private $clientQuery = array(
				"var"	=>	''
			);
	function __construct($para	=	false){
		$this->parameters=$para;
                 $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
                    selectDB(DBNAME_MASTER,$link);
	}
	public function fetchValidityTypes(){
		$moptype = NULL;
		$jsonmoptype = NULL;
		$num = 0;
		$query = 'SELECT `id`, `type` AS vtype,`amount` FROM `validity_type` WHERE `status` = 4;';
		$res = executeQuery($query);
		if(mysql_num_rows($res) > 0){
			while($row = mysql_fetch_assoc($res)){
				$moptype[] = $row;
			}
		}
		if(is_array($moptype))
			$num = sizeof($moptype);
		if($num){
			for($i=0;$i<$num;$i++){
				$jsonmoptype[] = array(
					"html" => '<option  value="'.$moptype[$i]["id"].'" >'.$moptype[$i]["vtype"].'</option>',
					"moptype" => $moptype[$i]["vtype"],
					"id" => $moptype[$i]["id"],
                                        "amount" => $moptype[$i]["amount"]
				);
			}
		}
		return $jsonmoptype;
	}
	public function CheckClientUserName($chkusername) {
            $query='SELECT `user_name` FROM `user_profile` WHERE `user_name`="'.  mysql_real_escape_string($chkusername).'" AND `status_id` != 6';
            $result=  executeQuery($query);
            return mysql_num_rows($result);
        }
	function clientadd($fl){
			$user_pk = 0;
			$product_pk = 0;
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$curr_time = mysql_result(executeQuery("SELECT NOW();"),0);
			$db_host = mysql_real_escape_string($this->parameters["db_host"]);
			$db_user = mysql_real_escape_string($this->parameters["db_username"]);
			$db_name = mysql_real_escape_string($this->parameters["db_name"]);
			$db_pass =  mysql_real_escape_string($this->parameters["db_password"]);
			$pass = md5($this->parameters["password"]);
			/* Photo */
			$query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
					NULL,NULL,NULL,NULL,NULL,NULL);';
			if(executeQuery($query)){
				/* Profile */
				$query = 'INSERT INTO  `user_profile` (`id`,
							`user_name`,
							`owner_name`,
                                                        `business_name`,
							`db_host`,
							`db_username`,

							`db_password`,
							`acs_id`,
							`photo_id`,
							`password`,
							`apassword`,
							`passwordreset`,
							`authenticatkey`,
							`sms_cost`,
							`validity`,
							`postal_code`,
							`telephone`,
							`dob`,
							`gender`,
							`date_of_join`,
							`user_type_id`,
							`status_id`,
							`addressline`,
							`town`,
							`city`,
							`district`,
							`province`,
							`province_code`,
							`country`,
							`country_code`,
							`zipcode`,
							`website`,
							`latitude`,
							`longitude`,
							`timezone`,
							`gmaphtml` )  VALUES(
						NULL,
						\''.mysql_real_escape_string($this->parameters["username"]).'\',
						\''.mysql_real_escape_string($this->parameters["owner"]).'\',
                                                \''.mysql_real_escape_string($this->parameters["name"]).'\',
						\''.mysql_real_escape_string($db_host).'\',
						\''.mysql_real_escape_string($db_user).'\',

						\''.mysql_real_escape_string($db_pass).'\',
						\''.mysql_real_escape_string($this->parameters["acs"]).'\',
						LAST_INSERT_ID(),
						\''.mysql_real_escape_string($this->parameters["password"]).'\',
						\''.mysql_real_escape_string($pass).'\',
						NULL,
						NULL,
						\''.mysql_real_escape_string($this->parameters["sms"]).'\',
						\''.mysql_real_escape_string($this->parameters["type"]).'\',
						\''.mysql_real_escape_string($this->parameters["pcode"]).'\',
						\''.mysql_real_escape_string($this->parameters["tphone"]).'\',
						\''.mysql_real_escape_string(date('Y-m-d')).'\',
						3,
						default,
						9,
						1,
						\''.mysql_real_escape_string($this->parameters["addrsline"]).'\',
						\''.mysql_real_escape_string($this->parameters["st_loc"]).'\',
						\''.mysql_real_escape_string($this->parameters["city_town"]).'\',
						\''.mysql_real_escape_string($this->parameters["district"]).'\',
						\''.mysql_real_escape_string($this->parameters["province"]).'\',
						\''.mysql_real_escape_string($this->parameters["provinceCode"]).'\',
						\''.mysql_real_escape_string($this->parameters["country"]).'\',
						\''.mysql_real_escape_string($this->parameters["countryCode"]).'\',
						\''.mysql_real_escape_string($this->parameters["zipcode"]).'\',
						\''.mysql_real_escape_string($this->parameters["website"]).'\',
						\''.mysql_real_escape_string($this->parameters["lat"]).'\',
						\''.mysql_real_escape_string($this->parameters["lon"]).'\',
						\''.mysql_real_escape_string($this->parameters["timezone"]).'\',
						\''.mysql_real_escape_string($this->parameters["gmaphtml"]).'\');';
			if(executeQuery($query)){
					$user_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
					if($this->parameters["type"]	==	1){
						$datetime=date_create($this->parameters["subdate"]);
						$datetime->add(new DateInterval('P6M'));
						$validity_expire=$datetime->format('Y-m-d');
					}
					else if($this->parameters["type"]	==	2){
						$datetime=date_create($this->parameters["subdate"]);
						$datetime->add(new DateInterval('P12M'));
						$validity_expire=$datetime->format('Y-m-d');
					}
					/* emails */
					if(is_array($this->parameters["email"]) && sizeof($this->parameters["email"]) > -1){
						$query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status_id` ) VALUES';
						for($i=0;$i<sizeof($this->parameters["email"]);$i++){
							if($i == sizeof($this->parameters["email"])-1)
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["email"][$i]).'\',4);';
							else
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["email"][$i]).'\',4),';
						}
						executeQuery($query);
						executeQuery('UPDATE `user_profile` SET `email`= \''.mysql_real_escape_string($this->parameters["email"][0]).'\'
										WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
					}
					/* cell_numbers */
					if(is_array($this->parameters["cellnumbers"]) && sizeof($this->parameters["cellnumbers"]) > -1){
						$query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_code`,`cell_number`,`status_id`) VALUES';
						for($i=0;$i<sizeof($this->parameters["cellnumbers"]);$i++){
							if($i == sizeof($this->parameters["cellnumbers"])-1)
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',
										\''.mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]).'\',
										\''.mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]).'\',
										4);';
							else
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',
										\''.mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]).'\',
										\''.mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]).'\',
										4),';
						}
						executeQuery($query);
						executeQuery('UPDATE `user_profile` SET `cell_code`= \''.mysql_real_escape_string($this->parameters["cellnumbers"][0]["codep"]).'\',
											`cell_number`= \''.mysql_real_escape_string($this->parameters["cellnumbers"][0]["nump"]).'\'
										WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
					}
					$db_name.=$user_pk;
					$directory_user = createdirectories(substr(md5(microtime()),0,6).'_client_'.$user_pk);
					executeQuery('UPDATE `user_profile` SET `directory` = \''.$directory_user.'\' WHERE `id`=\''.mysql_real_escape_string($user_pk).'\';');
					executeQuery('UPDATE `user_profile` SET `db_name` = \''.$db_name.'\' WHERE `id`=\''.mysql_real_escape_string($user_pk).'\';');
					$query1 = 'INSERT INTO  `validity` (`id`,
								`user_pk`,
								`validity_type_pk`,
								`payment_date`,
								`subscribe_date`,
								`expiry_date`,
								`status`)  VALUES(
							NULL,
							\''.mysql_real_escape_string($user_pk).'\',
							\''.mysql_real_escape_string($this->parameters["type"]).'\',
							now(),now(),now(),
							4
							);';
					executeQuery($query1);
					// ----------------------------------FILE DATA START

					$target_dir = DOC_ROOT.ASSET_DIR.$directory_user;
					$target_file = $target_dir . basename($_FILES["file"]["name"]);
					$fn = explode(".",basename($_FILES["file"]["name"]));
					$ext = $fn[(sizeof($fn))-1];
					$fname = $target_dir . md5(generateRandomString()) .".". $ext;
					$dbpath=str_replace(DOC_ROOT.ASSET_DIR,"",$fname);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					// Check if image file is a actual image or fake image
					if(isset($_POST["submit"])) {
						$check = getimagesize($_FILES["file"]["tmp_name"]);
						if($check !== false) {
							$uploadOk = 1;
						} else {
							echo "File is not an image.";
							$uploadOk = 0;
						}
					}
					// Check if file already exists
					if (file_exists($target_file)) {
						echo "Sorry, file already exists.";
						$uploadOk = 0;
					}
					// Check file size
					if ($_FILES["file"]["size"] > 5000000) {
						echo "Sorry, your file is too large.";
						$uploadOk = 0;
					}
					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ) {
						echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
						$uploadOk = 0;
					}
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
						echo "Sorry, your file was not uploaded.";
					// if everything is ok, try to upload file
					} else {
						if (move_uploaded_file($_FILES["file"]["tmp_name"], $fname)) {

						} else {
							echo "Sorry, there was an error uploading your file.";
						}
					}
					//----------------- FILE DATA OVER

					$docqr = 'INSERT INTO `user_documents`(`id`,
								`user_pk`,
								`document_type`,
								`document_number`,
								`document_path`,
								`status`)

								VALUES(
								NULL,
								\''.mysql_real_escape_string($user_pk).'\',
								\''.mysql_real_escape_string($this->parameters["doctype"]).'\',
								\''.mysql_real_escape_string($this->parameters["docno"]).'\',
								\''.mysql_real_escape_string($dbpath).'\',
								1
								)';
							executeQuery($docqr);
					executeQuery('CALL slaveDbCreate("'.$db_name.'")');
					$flag = true;
				}
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $this->parameters;


	}
	public static function clientProfile($para = false){
		$client	=	$para["var"];
		$query ='SELECT
					c.`cnumber`,
					b.`email_pk`,
					c.`cnumber_pk`,
					b.`email_ids`,
					a.`user_name`,
					a.`password`,
					a.`id` AS usrid,
					a.`user_type_id`,
					a.`photo_id`,
					a.`status_id`,
					a.`directory`,
                                        a.`owner_name`,
                                        a.`cell_code`,
                                        a.`cell_number`,
                                        a.`email`,
					d.`user_type`,
						CASE WHEN (a.`addressline` IS NULL OR a.`addressline` = "" )
							 THEN "Not provided"
							 ELSE a.`addressline`
						END AS addressline,
						CASE WHEN (a.`town` IS NULL OR a.`town` = "" )
							 THEN "Not provided"
							 ELSE a.`town`
						END AS town,
						CASE WHEN (a.`city` IS NULL OR a.`city` = "" )
							 THEN "Not provided"
							 ELSE a.`city`
						END AS city,
						CASE WHEN (a.`district` IS NULL OR a.`district` = "" )
							 THEN "Not provided"
							 ELSE a.`district`
						END AS district,
						CASE WHEN (a.`province` IS NULL OR a.`province` = "" )
							 THEN "Not provided"
							 ELSE a.`province`
						END AS province,
						CASE WHEN (a.`province_code` IS NULL OR a.`province_code` = "" )
							 THEN NULL
							 ELSE a.`province_code`
						END AS province_code,
						CASE WHEN (a.`country` IS NULL OR a.`country` = "" )
							 THEN "Not provided"
							 ELSE a.`country`
						END AS country,
						CASE WHEN (a.`country_code` IS NULL OR a.`country_code` = "" )
							 THEN NULL
							 ELSE a.`country_code`
						END AS country_code,
						CASE WHEN (a.`zipcode` IS NULL OR a.`zipcode` = "" )
							 THEN "Not provided"
							 ELSE a.`zipcode`
						END AS zipcode,
						CASE WHEN (a.`website` IS NULL OR a.`website` = "" )
							 THEN "http://"
							 ELSE a.`website`
						END AS website,
						CASE WHEN (a.`gmaphtml` IS NULL OR a.`gmaphtml` = "" )
							 THEN "http://"
							 ELSE a.`gmaphtml`
						END AS gmaphtml,
						CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
							 THEN "---"
							 ELSE a.`postal_code`
						END  AS pcode,
						CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
							 THEN "Not provided"
							 ELSE a.`telephone`
						END AS tnumber,
					   CASE WHEN p.`ver2` IS NULL
						THEN "NOT PROVIDED"
						ELSE CONCAT("'.URL.ASSET_DIR.'",p.`ver2`)
					   END AS photo
					FROM `user_profile` AS a
					LEFT JOIN `photo` AS p ON p.`id` = a.`photo_id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(em.`id`) AS email_pk,
							GROUP_CONCAT(em.`email`) AS email_ids,
							em.`user_pk`
						FROM `email_ids` AS em
						WHERE em.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (em.`user_pk`)
						ORDER BY (em.`user_pk`)
						) AS b ON b.`user_pk` = a.`id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(cn.`id`) AS cnumber_pk,
							cn.`user_pk`,
							/* GROUP_CONCAT(CONCAT(cn.`cell_code`,"-",cn.`cell_number`)) AS cnumber */
							GROUP_CONCAT(cn.`cell_number`) AS cnumber
						FROM `cell_numbers` AS cn
						WHERE cn.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (cn.`user_pk`)
						ORDER BY (cn.`user_pk`)
					) AS c ON a.`id` = c.`user_pk`
					 LEFT JOIN (
						select t.`user_type`,t.`id`
						from `user_type` as t
						 LEFT JOIN `user_profile` as up
						 on up.`user_type_id`= t.`id`
						 where up.`status_id`=(SELECT `id` FROM `status` WHERE `statu_name`="Registered" AND status=1)
						 group by t.`user_type`
					) AS d ON d.`id`= a.`user_type_id`
					WHERE a.`user_type_id` !=10 AND a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive"))
																 '.$client.';';




			//print_r($query);
                        $users=array();
			$res = executeQuery($query);
			if(mysql_num_rows($res) > 0){
				while($row = mysql_fetch_assoc($res)){
					$users[] = $row;
				}
			}
			$total = sizeof($users);
                        $_SESSION["listofclients"]= $users;
			if($total){
				for($i=0;$i<$total;$i++){
					$users[$i]["cnumber"] = explode(",",$users[$i]["cnumber"]);
					$users[$i]["email_pk"] = explode(",",$users[$i]["email_pk"]);
					$users[$i]["cnumber_pk"] = explode(",",$users[$i]["cnumber_pk"]);
					$users[$i]["email_ids"] = explode(",",$users[$i]["email_ids"]);
					//$users[$i]["usrid"] = $users[$i]["usrid"];
				}
				$_SESSION["listofclients"] = $users;
			}
//			$console_php->log($_SESSION["listofclients"]);
			//print_r($_SESSION["USER_LOGIN_DATA"]);
			//if(mysql_num_rows($res)){
				//$row = mysql_fetch_assoc($res);
				//$admin_email_id = explode(",",$row["email_pk"]);
				//$admin_cnum_id = explode(",",$row["cnumber_pk"]);
				//$admin_email = explode(",",$row["email_ids"]);
				//$admin_cnumber = explode(",",$row["cnumber"]);
				//$USER_LOGIN_DATA	= array(
					//"USER_NAME" 	=> $row["user_name"],
					//"USER_PHOTO" 	=> $row["photo"],
					//"USER_EMAIL_ID"	=> $admin_email_id,
					//"USER_CNUM_ID"	=> $admin_cnum_id,
					//"USER_EMAIL"	=> $admin_email,
					//"USER_C"		=> $admin_cnumber,
					//"COUNTRY"		=> $row["country"],
					//"PROVINCE"		=> $row["province"],
					//"DISTRICT"		=> $row["district"],
					//"CITY"			=> $row["city"],
					//"TOWN"			=> $row["town"],
					//"ADDRESSLINE"	=> $row["addressline"],
					//"ZIPCODE"		=> $row["zipcode"],
					//"WEBSITE"		=> $row["website"],
					//"GMAPHTML"		=> $row["gmaphtml"],
				//);
				//$_SESSION["listofclient"]	=	$USER_LOGIN_DATA;
			//}

		return $_SESSION["listofclients"];
	}
	public function displayUserList($para = false) {
//			require_once(DOC_ROOT.INC.'FirePHPCore/FirePHP.class.php');
//			$console_php = FirePHP::getInstance(true);
			$this->parameters = $para;

			$users = array();
			$html='';
			$listusers = array(
				"html"	=> '<strong class="text-danger">There are no users available !!!!</strong>',
				"uid"	=> 0,
				"sr"	=> '',
				"alertUSRDEL"	=> '',
				"usrdelOk" 		=> '',
				"usrdelCancel" 	=> '',
				"alertUSRFLG"	=> '',
				"usrflgOk" 		=> '',
				"usrflgCancel" 	=> '',
				"butuflg"		=> '',
				"alertUSRUFLG"	=> '',
				"usruflgOk" 	=> '',
				"usruflgCancel" => '',
				"usredit"		=> ''
			);
                        $num_posts=0;
			if(isset($_SESSION["listofclients"]) && $_SESSION["listofclients"] != NULL)
				$users = $_SESSION["listofclients"];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			if($num_posts > 0){
				$listusers = array();
				//for($i=$this->parameters["initial"];$i<$this->parameters["final"] && $i < $num_posts && isset($users[$i]['usrid']);$i++){
					for($i=0;$i < $num_posts;$i++){
					/* Basic info */
					$email = $cnumber = $backac = $prd = '';
					$email_no = $cnum_no = $bank_no = $prd_no = -1;
					/* Email */
					if(is_array($users[$i]["email_ids"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["email_ids"]) && isset($users[$i]["email_ids"][$j]) && $users[$i]["email_ids"][$j] != '';$j++){
							$flag = true;
							$email .= '<li>'.ltrim($users[$i]["email_ids"][$j] ,',').'</li>';
							$email_no++;
						}
						if(!$flag){
							$email = '<li>Not Provided</li>';
						}
					}
					/* Cell number */
					if(is_array($users[$i]["cnumber"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != '';$j++){
							$flag = true;
							$cnumber .= '<li>'.ltrim($users[$i]["cnumber"][$j] ,',').'</li>';
							$cnum_no++;
						}
						if(!$flag){
							$cnumber = '<li>Not Provided</li>';
						}
					}
						$html = '<tr>
									<td>'.($i+1).'</td>
									<td>'.$users[$i]["user_name"].'</td>
                                                                        <td>'.$users[$i]["owner_name"].'</td>
                                                                            <td>'.$users[$i]["cell_code"].' '.$users[$i]["cell_number"].'</td>
                                                                        <td>'.$users[$i]["email"].'</td>
									<td class="text-left">'.$users[$i]["user_type"].'&nbsp;</td>
									<td class="text-center"><button class="btn btn-danger btn-md" id="usr_but_trash_'.$users[$i]["usrid"].'" data-toggle="modal" data-target="#myUSRDELModal_'.$users[$i]["usrid"].'" ><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp;';
									if(($users[$i]["status_id"])=='1'){
										$html .= '<button class="btn btn-primary btn-md" id="usr_but_flag_'.$users[$i]["usrid"].'" data-toggle="modal" data-target="#myModal_flag'.$users[$i]["usrid"].'"><i class="fa fa-flag fa-fw "></i> Flag</button>&nbsp;';
									}else if(($users[$i]["status_id"])=='7') {
										$html.='<button class="btn btn-primary btn-md" id="usr_but_unflag_'.$users[$i]["usrid"].'" data-toggle="modal" data-target="#myModal_unflag'.$users[$i]["usrid"].'"><i class="fa fa-flag fa-fw "></i> Unflag</button>&nbsp;';
									}$html.='<button class="btn btn-success btn-md" id="usr_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button>
									</td>
								</tr>';
						$html.='<div class="modal fade" id="myUSRDELModal_'.$users[$i]["usrid"].'" tabindex="-1" role="dialog" aria-labelledby="myUSRDELModalLabel_'.$users[$i]["usrid"].'" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																<h4 class="modal-title" id="myUSRDELModalLabel_'.$users[$i]["usrid"].'">Select Cell Numbers to send SMS</h4>
														</div>
														<div class="modal-body" id="myUSRDEL_'.$users[$i]["usrid"].'">
															Do you really want to delete {'.$users[$i]["user_name"].'} - {'.$users[$i]["tnumber"].'}<br />
															Press OK to delete ??
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteUSRDELOk_'.$users[$i]["usrid"].'">Ok</button>
														<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteUSRDELCancel_'.$users[$i]["usrid"].'">Cancel</button>
													</div>
												</div>
											</div>
											<div class="modal fade" id="myModal_flag'.$users[$i]["usrid"].'" tabindex="-1" role="dialog" aria-labelledby="myModal_flag_Label_'.$users[$i]["usrid"].'" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
															<h4 class="modal-title" id="myModal_flag_Label_'.$users[$i]["usrid"].'">Flag User entry</h4>
														</div>
														<div class="modal-body">
															Do You really want to flag the User '.$users[$i]["user_name"].' entry ?? press <strong>OK</strong> to flag
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-danger" data-dismiss="modal" onClick="$(\'#usr_but_unflag_'.$users[$i]["usrid"].'\').show(300);$(\'#usr_but_flag_'.$users[$i]["usrid"].'\').hide(300);" name=".modal-backdrop" id="flagOk_'.$users[$i]["usrid"].'">Ok</button>
															<button type="button" class="btn btn-success" data-dismiss="modal" id="flagCancel_'.$users[$i]["usrid"].'">Cancel</button>
														</div>
													</div>
												</div>
											</div>
											<div class="modal fade" id="myModal_unflag'.$users[$i]["usrid"].'" tabindex="-1" role="dialog" aria-labelledby="myModal_unflag_Label_'.$users[$i]["usrid"].'" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
															<h4 class="modal-title" id="myModal_unflag_Label_'.$users[$i]["usrid"].'">UnFlag User entry</h4>
														</div>
														<div class="modal-body">
															Do You really want to UnFlag the User '.$users[$i]["user_name"].' entry ?? press <strong>OK</strong> to UnFlag
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="unflagOk_'.$users[$i]["usrid"].'">Ok</button>
															<button type="button" class="btn btn-success" data-dismiss="modal" id="unflagCancel_'.$users[$i]["usrid"].'">Cancel</button>
														</div>
													</div>
												</div>
											</div>';
					$listusers[] = array(
						"html"			=> (string) $html,
						"uid"			=> $users[$i]["usrid"],
						"sr"			=> '#usr_row'.$users[$i]["usrid"],
						"alertUSRDEL"	=> '#myUSRDELModal_'.$users[$i]["usrid"],
						"usrdelOk" 		=> '#deleteUSRDELOk_'.$users[$i]["usrid"],
						"usrdelCancel" 	=> '#deleteUSRDELCancel_'.$users[$i]["usrid"],
						"alertUSRFLG"	=> '#myModal_flag'.$users[$i]["usrid"].'',
						"usrflgOk" 		=> '#flagOk_'.$users[$i]["usrid"].'',
						"usrflgCancel" 	=> '#flagCancel_'.$users[$i]["usrid"].'',
						"butuflg"		=> '#usr_but_unflag_'.$users[$i]["usrid"].'',
						"alertUSRUFLG"	=> '#myModal_unflag'.$users[$i]["usrid"].'',
						"usruflgOk" 	=> '#unflagOk_'.$users[$i]["usrid"].'',
						"usruflgCancel"	=> '#unflagCancel_'.$users[$i]["usrid"].'',
						"usredit"		=> '#usr_but_edit_'.$users[$i]["usrid"].''
						);
				}

			}
		return $listusers;
	}
	public function editUser(){
//		require_once(DOC_ROOT.INC.'FirePHPCore/FirePHP.class.php');
//		$console_php = FirePHP::getInstance(true);

		$user_id=$this->parameters["usrid"]!=""		?	' AND a.`id` LIKE CONCAT('.$this->parameters["usrid"].')'	:	'';
		$clientQuery["var"]=$user_id;
		$users = client::clientProfile($clientQuery);
		$email = $cnumber = $backac = $prd = '';
		$email_no = $cnum_no = $bank_no = $prd_no = -1;
		/* Email */
		if(is_array($users[0]["email_ids"])){
			$flag = false;
			for($j=0;$j<sizeof($users[0]["email_ids"]) && isset($users[0]["email_ids"][$j]) && $users[0]["email_ids"][$j] != '';$j++){
				$flag = true;
				$email .= '<li>'.ltrim($users[0]["email_ids"][$j] ,',').'</li>';
				$email_no++;
			}
			if(!$flag){
				$email = '<li>Not Provided</li>';
			}
		}
		/* Cell number */
		if(is_array($users[0]["cnumber"])){
			$flag = false;
			for($j=0;$j<sizeof($users[0]["cnumber"]) && isset($users[0]["cnumber"][$j]) && $users[0]["cnumber"][$j] != '';$j++){
				$flag = true;
				$cnumber .= '<li>'.ltrim($users[0]["cnumber"][$j] ,',').'</li>';
				$cnum_no++;
			}
			if(!$flag){
				$cnumber = '<li>Not Provided</li>';
			}
		}
		echo '<form action="control.php" name="changePic" id="changePic" method="post" enctype="multipart/form-data">
				 <fieldset>
				 <input type="hidden" name="formid" value="changePic" />
				   	 <input type="hidden" name="action1" value="picChange" />
					 <input type="hidden" name="autoloader" value="true" />
					  <input type="hidden" name="type" value="master" />
					 <input type="hidden" name="uid" value="'.$users[0]["usrid"].'"/>
					 <div class="modal" id="myModal_Photo" tabindex="-1" role="dialog" aria-labelledby="myModal_Photo_Label_'.$users[0]["usrid"].'" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div class="modal-content" style="color:#000;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModal_Photo_Label_'.$users[0]["usrid"].'">Flag User entry</h4>
							</div>
							<div class="modal-body">
									<!-- begin_picedit_box -->
									<div class="picedit_box">
									    <!-- Placeholder for messaging -->
									    <div class="picedit_message">
									    	 <span class="picedit_control ico-picedit-close" data-action="hide_messagebox"></span>
									        <div></div>
									    </div>
									    <!-- Picedit navigation -->
									    <div class="picedit_nav_box picedit_gray_gradient">
									    	<div class="picedit_pos_elements"></div>
									       <div class="picedit_nav_elements">
												<!-- Picedit button element begin -->
												<div class="picedit_element">
									           	 <span class="picedit_control picedit_action ico-picedit-pencil" title="Pen Tool"></span>
									             	 <div class="picedit_control_menu">
									               	<div class="picedit_control_menu_container picedit_tooltip picedit_elm_3">
									                    <label class="picedit_colors">
									                      <span title="Black" class="picedit_control picedit_action picedit_black active" data-action="toggle_button" data-variable="pen_color" data-value="black"></span>
									                      <span title="Red" class="picedit_control picedit_action picedit_red" data-action="toggle_button" data-variable="pen_color" data-value="red"></span>
									                      <span title="Green" class="picedit_control picedit_action picedit_green" data-action="toggle_button" data-variable="pen_color" data-value="green"></span>
									                    </label>
									                    <label>
									                    	<span class="picedit_separator"></span>
									                    </label>
									                    <label class="picedit_sizes">
									                      <span title="Large" class="picedit_control picedit_action picedit_large" data-action="toggle_button" data-variable="pen_size" data-value="16"></span>
									                      <span title="Medium" class="picedit_control picedit_action picedit_medium" data-action="toggle_button" data-variable="pen_size" data-value="8"></span>
									                      <span title="Small" class="picedit_control picedit_action picedit_small" data-action="toggle_button" data-variable="pen_size" data-value="3"></span>
									                    </label>
									                  </div>
									               </div>
									           </div>
									           <!-- Picedit button element end -->
												<!-- Picedit button element begin -->
												<div class="picedit_element">
													<span class="picedit_control picedit_action ico-picedit-insertpicture" title="Crop" data-action="crop_open"></span>
									           </div>
									           <!-- Picedit button element end -->
												<!-- Picedit button element begin -->
												<div class="picedit_element">
									           	 <span class="picedit_control picedit_action ico-picedit-redo" title="Rotate"></span>
									             	 <div class="picedit_control_menu">
									               	<div class="picedit_control_menu_container picedit_tooltip picedit_elm_1">
									                    <label>
									                      <span>90° CW</span>
									                      <span class="picedit_control picedit_action ico-picedit-redo" data-action="rotate_cw"></span>
									                    </label>
									                    <label>
									                      <span>90° CCW</span>
									                      <span class="picedit_control picedit_action ico-picedit-undo" data-action="rotate_ccw"></span>
									                    </label>
									                  </div>
									               </div>
									           </div>
									           <!-- Picedit button element end -->
									           <!-- Picedit button element begin -->
									            <div class="picedit_element">
									           	 <span class="picedit_control picedit_action ico-picedit-arrow-maximise" title="Resize"></span>
									             	 <div class="picedit_control_menu">
									               	<div class="picedit_control_menu_container picedit_tooltip picedit_elm_2">
									                    <label>
															<span class="picedit_control picedit_action ico-picedit-checkmark" data-action="resize_image"></span>
															<span class="picedit_control picedit_action ico-picedit-close" data-action=""></span>
									                    </label>
									                    <label>
									                      <span>Width (px)</span>
									                      <input type="text" class="picedit_input" data-variable="resize_width" value="0">
									                    </label>
									                    <label class="picedit_nomargin">
									                    	<span class="picedit_control ico-picedit-link" data-action="toggle_button" data-variable="resize_proportions"></span>
									                    </label>
									                    <label>
									                      <span>Height (px)</span>
									                      <input type="text" class="picedit_input" data-variable="resize_height" value="0">
									                    </label>
									                  </div>
									               </div>
									           </div>
									           <!-- Picedit button element end -->
									       </div>
										</div>
										<!-- Picedit canvas element -->
										<div class="picedit_canvas_box">
											<div class="picedit_painter">
												<canvas></canvas>
											</div>
											<div class="picedit_canvas">
												<canvas></canvas>
											</div>
											<div class="picedit_action_btns active">
									          <div class="picedit_control ico-picedit-picture" data-action="load_image"></div>
									          <div class="picedit_control ico-picedit-camera" data-action="camera_open"></div>
									          <div class="center">or copy/paste image here</div>
											</div>
										</div>
										<!-- Picedit Video Box -->
										<div class="picedit_video">
									    	<video autoplay></video>
											<div class="picedit_video_controls">
												<span class="picedit_control picedit_action ico-picedit-checkmark" data-action="take_photo"></span>
												<span class="picedit_control picedit_action ico-picedit-close" data-action="camera_close"></span>
											</div>
									    </div>
																												<!-- Picedit draggable and resizeable div to outline cropping boundaries -->
									    <div class="picedit_drag_resize">
									    	<div class="picedit_drag_resize_canvas"></div>
											<div class="picedit_drag_resize_box">
												<div class="picedit_drag_resize_box_corner_wrap">
									           	<div class="picedit_drag_resize_box_corner"></div>
												</div>
												<div class="picedit_drag_resize_box_elements">
													<span class="picedit_control picedit_action ico-picedit-checkmark" data-action="crop_image"></span>
													<span class="picedit_control picedit_action ico-picedit-close" data-action="crop_close"></span>
												</div>
									       </div>
									    </div>
									</div>
									<!-- end_picedit_box -->
							</div>
							<div class="modal-footer">
								<button type="submit" name="submit" class="btn btn-success" id="addusrBut">Change Picture</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="photoCancel_'.$users[0]["usrid"].'">Cancel</button>
							</div>
						</div>
					</div>
				</div>
				 </fieldset>
			  </form>';
		echo '<div class="row">
				<div class="col-lg-12">&nbsp;</div>
				<div class="col-lg-4">
					<div class="panel panel-yellow">
						<div class="panel-heading">
							<h4>Photo</h4>
						</div>
						<div class="panel-body" id="usrphoto_'.$users[0]["usrid"].'">
							<img src="'.$users[0]["photo"].'" width="150" />
						</div>
						<div class="panel-footer">
							<button class="btn btn-yellow btn-md" id="usrphoto_but_edit_'.$users[0]["usrid"].'" data-toggle="modal" data-target="#myModal_Photo"><i class="fa fa-edit fa-fw "></i> Edit</button>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="panel panel-green">
						<div class="panel-heading">
							<h4>Email ids</h4>
						</div>
						<div class="panel-body" id="usremail_'.$users[0]["usrid"].'">
							<ul>'.$email.'</ul>
						</div>
						<div class="panel-footer">
							<button class="btn btn-success btn-md" id="usremail_but_edit_'.$users[0]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
							<button class="btn btn-success btn-md" id="usremail_but_'.$users[0]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Save</button>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4>Cell numbers</h4>
						</div>
						<div class="panel-body" id="usrcnum_'.$users[0]["usrid"].'">
							<ul>'.$cnumber.'</ul>
						</div>
						<div class="panel-footer">
							<button class="btn btn-primary btn-md" id="usrcnum_but_edit_'.$users[0]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
							<button class="btn btn-primary btn-md" id="usrcnum_but_'.$users[0]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Save</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">&nbsp;</div>
				<div class="col-lg-8">
					<div class="panel panel-red">
						<div class="panel-heading">
							<h4>Address</h4>
						</div>
						<div class="panel-body" id="usradd_'.$users[0]["usrid"].'" style="display:block;">
							<ul>
								<li><strong>Address line : </strong>'.$users[0]["addressline"].'</li>
								<li><strong>Street / Locality : </strong>'.$users[0]["town"].'</li>
								<li><strong>City / Town : </strong>'.$users[0]["city"].'</li>
								<li><strong>District / Department : </strong>'.$users[0]["district"].'</li>
								<li><strong>State / Provice : </strong>'.$users[0]["province"].'</li>
								<li><strong>Country : </strong>'.$users[0]["country"].'</li>
								<li><strong>Zipcode : </strong>'.$users[0]["zipcode"].'</li>
								<li><strong>Website : </strong>'.$users[0]["website"].'</li>
								<li><strong>Google Map : </strong>'.$users[0]["website"].'</li>
							</ul>
						</div>
						<div class="panel-body" id="usradd_edit_'.$users[0]["usrid"].'" style="display:none;">
							<form id="user_address_edit_form_'.$users[0]["usrid"].'">
							<!-- Country -->
							<div class="row">
								<div class="col-lg-6">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Country <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Country" name="country" type="text" id="country_'.$users[0]["usrid"].'" maxlength="100" value="'.$users[0]["country"].'"/>
										<p class="help-block" id="comsg_'.$users[0]["usrid"].'">Enter/ Select.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- State / Province -->
								<div class="col-lg-6">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> State / Province <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="State / Province" name="province" type="text" id="province_'.$users[0]["usrid"].'" maxlength="150" value="'.$users[0]["province"].'"/>
										<p class="help-block" id="prmsg_'.$users[0]["usrid"].'">Enter/ Select.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</div>
							<!-- District / Department -->
							<div class="row">
								<div class="col-lg-6">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> District / Department <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="District / Department" name="district" type="text" id="district_'.$users[0]["usrid"].'" maxlength="100" value="'.$users[0]["district"].'"/>
										<p class="help-block" id="dimsg_'.$users[0]["usrid"].'">Enter/ Select.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- City / Town -->
								<div class="col-lg-6">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> City / Town <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="City / Town" name="city_town" type="text" id="city_town_'.$users[0]["usrid"].'" maxlength="100" value="'.$users[0]["city"].'"/>
										<p class="help-block" id="citmsg_'.$users[0]["usrid"].'">Enter/ Select.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</div>
							<!-- Street / Locality -->
							<div class="row">
								<div class="col-lg-6">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Street / Locality <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Street / Locality" name="st_loc" type="text" id="st_loc_'.$users[0]["usrid"].'" maxlength="100" value="'.$users[0]["town"].'"/>
										<p class="help-block" id="stlmsg'.$users[0]["usrid"].'">Press enter or go button to move to next feild.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Address Line -->
								<div class="col-lg-6">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Address Line <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Address Line" name="addrs" type="text" id="addrs_'.$users[0]["usrid"].'" maxlength="200" value="'.$users[0]["addressline"].'"/>
										<p class="help-block" id="admsg_'.$users[0]["usrid"].'">Enter/ Select.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</div>
							<!-- Zipcode -->
							<div class="row">
								<div class="col-lg-6">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Zipcode <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Zipcode" name="zipcode" type="text" id="zipcode_'.$users[0]["usrid"].'" maxlength="25" value="'.$users[0]["zipcode"].'"/>
										<p class="help-block" id="zimsg_'.$users[0]["usrid"].'">Enter/ Select.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Personal Website -->
								<div class="col-lg-6">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Personal Website <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Personal Website" name="website" type="text" id="website_'.$users[0]["usrid"].'" maxlength="250" value="'.$users[0]["website"].'"/>
										<p class="help-block" id="wemsg_'.$users[0]["usrid"].'">Enter/ Select.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</div>
							<!-- Google Map URL -->
							<div class="row">
								<div class="col-lg-6">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Google Map URL <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Google Map URL" name="gmaphtml" type="text" id="gmaphtml_'.$users[0]["usrid"].'" value="'.$users[0]["gmaphtml"].'"/>
										<p class="help-block" id="gmmsg_'.$users[0]["usrid"].'">Press enter or go button to update user address.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</div>
							<!-- Update -->
							<div class="row">
								<div class="col-lg-12">&nbsp;</div>
								<div class="col-lg-12 text-center">
									<button type="button" class="btn btn-danger btn-md" id="usr_address_update_but_'.$users[0]["usrid"].'"><i class="fa fa-upload fa-fw "></i> Update</button>
									&nbsp;<button type="button" class="btn btn-danger btn-md" id="usr_address_close_but_'.$users[0]["usrid"].'"><i class="fa fa-close fa-fw "></i> Close</button>
								</div>
							</div>
							</form>
						</div>
						<div class="panel-footer"><button type="button" class="btn btn-danger btn-md" id="usraddr_but_edit_'.$users[0]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
				<div class="col-lg-12">&nbsp;</div>
				<div class="col-lg-12">
						<button type="button" class="btn btn-primary btn-md" id="usr_but_close_'.$users[0]["usrid"].'"><i class="fa fa-close fa-fw "></i>close</button>
				</div>
		<script>
			$(document).ready(function(){
			var close = {
				closeDiv	:	"#usr_but_close_'.$users[0]["usrid"].'",
				clisttab	:	"#listbut",
			};
			var obj = new clientController();
			obj.close(close);
				var editUserEmailIds = {
					autoloader : true,
					action 	   : "loadEmailIdForm",
					outputDiv  : "#output",
					parentDiv  : "#usremail_'.$users[0]["usrid"].'",
					but  	   : "#usremail_but_edit_'.$users[0]["usrid"].'",
					num   	   : '.$email_no.',
					uid	   	   : '.$users[0]["usrid"].',
					index  	   : 0,
					listindex  : "listofclients",
					form 	   : "email_id_'.$users[0]["usrid"].'_",
					email 	   : "email_'.$users[0]["usrid"].'_",
					msgDiv 	   : "email_msg_'.$users[0]["usrid"].'_",
					plus 	   : "plus_email_'.$users[0]["usrid"].'_",
					minus 	   : "minus_email_'.$users[0]["usrid"].'_",
					saveBut	   : "usremail_but_'.$users[0]["usrid"].'",
					closeBut   : "usremail_close_'.$users[0]["usrid"].'",
					url 	   : window.location.href
				};
				var obj = new clientController();
				obj.editUserEmailIds(editUserEmailIds);
				var editUserCellNumbers = {
					autoloader : true,
					action 	   : "loadCellNumForm",
					outputDiv  : "#output",
					parentDiv  : "#usrcnum_'.$users[0]["usrid"].'",
					but  	   : "#usrcnum_but_edit_'.$users[0]["usrid"].'",
					num   	   : '.$cnum_no.',
					uid	   	   : '.$users[0]["usrid"].',
					index  	   : 0,
					listindex  : "listofclients",
					form 	   : "cnum_id_'.$users[0]["usrid"].'_",
					cnumber	   : "cnum_'.$users[0]["usrid"].'_",
					msgDiv 	   : "cnum_msg_'.$users[0]["usrid"].'_",
					plus 	   : "plus_cnum_'.$users[0]["usrid"].'_",
					minus 	   : "minus_cnum_'.$users[0]["usrid"].'_",
					saveBut	   : "usrcnum_but_'.$users[0]["usrid"].'",
					closeBut   : "usrcnum_close_'.$users[0]["usrid"].'",
					url 	   : window.location.href
				};
				var obj = new clientController();
				obj.editUserCellNumbers(editUserCellNumbers);
				var editUserAddress = {
					autoloader 		: true,
					action 	   		: "loadAddressForm",
					outputDiv  		: "#output",
					showDiv 		: "#usradd_'.$users[0]["usrid"].'",
					updateDiv 		: "#usradd_edit_'.$users[0]["usrid"].'",
					uid	   	   		: '.$users[0]["usrid"].',
					index  	   		: 0,
					listindex  		: "listofclients",
					but	   			: "#usraddr_but_edit_'.$users[0]["usrid"].'",
					saveBut	   		: "#usr_address_update_but_'.$users[0]["usrid"].'",
					closeBut   		: "#usr_address_close_but_'.$users[0]["usrid"].'",
					form 	   		: "#usrbankname_form_'.$users[0]["usrid"].'_",
					country 		: "#country_'.$users[0]["usrid"].'",
					countryCode 	: null,
					countryId 		: null,
					comsg 			: "#comsg_'.$users[0]["usrid"].'",
					province 		: "#province_'.$users[0]["usrid"].'",
					provinceCode	: null,
					provinceId 		: null,
					prmsg 			: "#prmsg_'.$users[0]["usrid"].'",
					district 		: "#district_'.$users[0]["usrid"].'",
					districtCode	: null,
					districtId 		: null,
					dimsg 			: "#dimsg_'.$users[0]["usrid"].'",
					city_town 		: "#city_town_'.$users[0]["usrid"].'",
					city_townCode	: null,
					city_townId 	: null,
					citmsg 			: "#citmsg_'.$users[0]["usrid"].'",
					st_loc 			: "#st_loc_'.$users[0]["usrid"].'",
					st_locCode 		: null,
					st_locId 		: null,
					stlmsg 			: "#stlmsg_'.$users[0]["usrid"].'",
					addrs 			: "#addrs_'.$users[0]["usrid"].'",
					admsg 			: "#admsg_'.$users[0]["usrid"].'",
					zipcode 		: "#zipcode_'.$users[0]["usrid"].'",
					zimsg 			: "#zimsg_'.$users[0]["usrid"].'",
					website 		: "#website_'.$users[0]["usrid"].'",
					wemsg 			: "#wemsg_'.$users[0]["usrid"].'",
					tphone 			: "#telephone_'.$users[0]["usrid"].'",
					gmaphtml 		: "#gmaphtml_'.$users[0]["usrid"].'",
					gmmsg 			: "#gmmsg_'.$users[0]["usrid"].'",
					lat 			: null,
					lon 			: null,
					timezone 		: null,
					PCR_reg 		: null,
					url				: URL+"address.php",
					Updateurl		: window.location.href
				};
				var obj = new clientController();
				obj.editUserAddress(editUserAddress);

		});
		</script>';
	}
	/*edit email ids*/
	public function loadEmailIdForm() {
			$user_id=$this->parameters["uid"]!=""		?	' AND a.`id` LIKE CONCAT('.$this->parameters["uid"].')'	:	'';
			$clientQuery["var"]=$user_id;
			$users = client::clientProfile($clientQuery);
			$html = '';
			$emailHTM = '';
			$num_posts = 0;

			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$emailids = array(
				"oldemail" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Email */
						if(is_array($users[$i]["email_ids"])){
							for($j=0;$j<=sizeof($users[$i]["email_ids"]) && isset($users[$i]["email_ids"][$j]) && $users[$i]["email_ids"][$j] != '';$j++){
								$flag = true;
								$emailids["oldemail"][$j] =  array(
													"id" 		=> ltrim($users[$i]["email_pk"][$j] ,','),
													"value" 	=> ltrim($users[$i]["email_ids"][$j] ,','),
													"form" 		=> $this->parameters["form"].$j,
													"textid" 	=> $this->parameters["email"].$j,
													"msgid" 	=> $this->parameters["msgDiv"].$j,
													"deleteid" 	=> $this->parameters["email"].$j.'_delete',
													"deleteOk"  => 'deleteEmlOk_'.ltrim($users[$i]["email_pk"][$j] ,',').'_'.$j,
													"deleteCancel" => 'deleteEmlCancel_'.ltrim($users[$i]["email_pk"][$j] ,',').'_'.$j
												);
								$emailHTM .= '<div id="'.$emailids["oldemail"][$j]["form"].'">
												<div class="form-group input-group">
												<input class="form-control" placeholder="Email ID" name="'.$emailids["oldemail"][$j]["id"].'" type="text" id="'.$emailids["oldemail"][$j]["textid"].'" maxlength="100" value="'.ltrim( $users[$i]["email_ids"][$j] ,',').'" />
												<span class="input-group-addon">
													<button class="btn btn-danger btn-circle" id="'.$emailids["oldemail"][$j]["deleteid"].'" data-toggle="modal" data-target="#myEmailModal_'.$j.'">
														<i class="fa fa-trash fa-fw "></i>
													</button>
													<div class="modal fade" id="myEmailModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="myEmailModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
													<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myEmailModalLabel_'.$j.'">Delete Email Id</h4>
													</div>
													<div class="modal-body">
													Do You really want to delete <strong>'.ltrim( $users[$i]["email_ids"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
													</div>
													<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$emailids["oldemail"][$j]["deleteOk"].'">Ok</button>
													<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$emailids["oldemail"][$j]["deleteCancel"].'">Cancel</button>
													</div>
													</div>
													</div>
													</div>
												</span>
												</div>
												<div class="col-lg-16" id="'.$emailids["oldemail"][$j]["form"].'">
													<p class="help-block" id="'.$emailids["oldemail"][$j]["msgid"].'">Valid.</p>
												</div>
											</div>';
										}
						}
					}
				}
				$html = '<div class="col-lg-16">
							Add extra email ids : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["minus"].'"><i class="fa fa-close fa-minus "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>

						</div><div class="class="col-lg-16">'.str_replace($this->order, $this->replace, $emailHTM).'</div>';
				$emailids["html"] = $html;
			}
			return $emailids;
		}
	public function editEmailId() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["emailids"]["uid"];
			/* Emails Insert */
			if(isset($this->parameters["emailids"]["insert"]) && is_array($this->parameters["emailids"]["insert"]) && sizeof($this->parameters["emailids"]["insert"]) > -1 && $user_pk > 0){
				$query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status_id` ) VALUES';
				for($i=0;$i<sizeof($this->parameters["emailids"]["insert"]);$i++){
					if($i == sizeof($this->parameters["emailids"]["insert"])-1)
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]).'\',4);';
					else
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]).'\',4),';
				}
				executeQuery($query);
				executeQuery('UPDATE `user_profile` SET `email`= \''.mysql_real_escape_string($this->parameters["emailids"]["insert"][0]).'\'
								WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
				$flag = true;
			}
			/* Emails Update */
			if(isset($this->parameters["emailids"]["update"]) && is_array($this->parameters["emailids"]["update"]) && sizeof($this->parameters["emailids"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["emailids"]["update"]);$i++){
					$query = 'UPDATE  `email_ids`
							 SET `email` = \''.mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["email"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
	public function deleteEmailId() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* Emails Update */
			if(isset($this->parameters["eid"]) && $this->parameters["eid"] > -1){
				$query = 'UPDATE  `email_ids`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["eid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
	public function listEmailIds() {
			$user_id=$this->parameters["uid"]!=""		?	' AND a.`id` LIKE CONCAT('.$this->parameters["uid"].')'	:	'';
			$clientQuery["var"]=$user_id;
			$users = client::clientProfile($clientQuery);
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$emailHTM = '<li>Not Provided</li>';
			$emailHTM = '<ul>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Email */
						if(is_array($users[$i]["email_ids"]) && $users[$i]["email_ids"][0] != ''){

							for($j=0;$j<=sizeof($users[$i]["email_ids"]) && isset($users[$i]["email_ids"][$j]) && $users[$i]["email_ids"][$j] != '';$j++){
									$emailHTM .= '<li>'.ltrim($users[$i]["email_ids"][$j] ,',').'</li>';
							}
						}
					}
				}
			}
			$emailHTM .= '</ul>';
			return $emailHTM;
		}
	/* Cell numbers */
	public function loadCellNumForm() {
			$user_id=$this->parameters["uid"]!=""		?	' AND a.`id` LIKE CONCAT('.$this->parameters["uid"].')'	:	'';
			$clientQuery["var"]=$user_id;
			$users = client::clientProfile($clientQuery);
			$html = '';
			$cnumHTM = '';
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$cnums = array(
				"oldcnum" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						$cnumHTM = '';
						/* Cell numbers */
						if(is_array($users[$i]["cnumber"])){
							for($j=0;$j<=sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != '';$j++){
								$flag = true;
								$cnums["oldcnum"][$j] =  array(
													"id" 		=> ltrim($users[$i]["cnumber_pk"][$j] ,','),
													"value" 	=> ltrim($users[$i]["cnumber"][$j] ,','),
													"form" 		=> $this->parameters["form"].$j,
													"textid" 	=> $this->parameters["cnumber"].$j,
													"msgid" 	=> $this->parameters["msgDiv"].$j,
													"deleteid" 	=> $this->parameters["cnumber"].$j.'_delete',
													"deleteOk"  => 'deleteCnumOk_'.ltrim($users[$i]["cnumber_pk"][$j] ,',').'_'.$j,
													"deleteCancel" => 'deleteCnumCancel_'.ltrim($users[$i]["cnumber_pk"][$j] ,',').'_'.$j
												);
								$cnumHTM .= '<div id="'.$cnums["oldcnum"][$j]["form"].'">
												<div class="form-group input-group">
												<input class="form-control" placeholder="Cell number" name="'.$cnums["oldcnum"][$j]["id"].'" type="text" min="0" id="'.$cnums["oldcnum"][$j]["textid"].'" maxlength="10" value="'.ltrim( $users[$i]["cnumber"][$j] ,',').'" />
												<span class="input-group-addon">
													<button class="btn btn-danger btn-circle" id="'.$cnums["oldcnum"][$j]["deleteid"].'" data-toggle="modal" data-target="#myCnumModal_'.$j.'">
														<i class="fa fa-trash fa-fw"></i>
													</button>
													<div class="modal fade" id="myCnumModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="myCnumModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
													<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myCnumModalLabel_'.$j.'">Delete Cell Number</h4>
													</div>
													<div class="modal-body">
													Do You really want to delete <strong>'.ltrim( $users[$i]["cnumber"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
													</div>
													<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$cnums["oldcnum"][$j]["deleteOk"].'">Ok</button>
													<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$cnums["oldcnum"][$j]["deleteCancel"].'">Cancel</button>
													</div>
													</div>
													</div>
													</div>
												</span>
												</div>
												<div class="col-lg-16" id="'.$cnums["oldcnum"][$j]["form"].'">
													<p class="help-block" id="'.$cnums["oldcnum"][$j]["msgid"].'">Valid.</p>
												</div>
											</div>';
							}
						}
					}
				}
				$html = '<div class="col-lg-16">
							Add extra Cell NO : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							<button class="btn btn-success btn-circle" id="'.$this->parameters["minus"].'"><i class="fa fa-minus fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>
						</div><div class="class="col-lg-16">'.str_replace($this->order, $this->replace, $cnumHTM).'</div>';
				$cnums["html"] = $html;
			}
			return $cnums;
		}
	public function editCellNum() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["CellNums"]["uid"];
			/* Cell Numbers Insert */
			if(isset($this->parameters["CellNums"]["insert"]) && is_array($this->parameters["CellNums"]["insert"]) && sizeof($this->parameters["CellNums"]["insert"]) > -1 && $user_pk > 0){
				$query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_number`,`status_id`) VALUES';
				for($i=0;$i<sizeof($this->parameters["CellNums"]["insert"]);$i++){
					if($i == sizeof($this->parameters["CellNums"]["insert"])-1)
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]).'\',4);';
					else
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]).'\',4),';
				}
				executeQuery($query);
				executeQuery('UPDATE `user_profile` SET `cell_number`= \''.mysql_real_escape_string($this->parameters["CellNums"]["insert"][0]).'\'
								WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
				$flag = true;
			}
			/* Cell Numbers Update */
			if(isset($this->parameters["CellNums"]["update"]) && is_array($this->parameters["CellNums"]["update"]) && sizeof($this->parameters["CellNums"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["CellNums"]["update"]);$i++){
					$query = 'UPDATE  `cell_numbers`
							 SET `cell_number` = \''.mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["cnumber"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
	public function deleteCellNum() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* Emails Update */
			if(isset($this->parameters["eid"]) && $this->parameters["eid"] > -1){
				$query = 'UPDATE  `cell_numbers`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["eid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
	public function listCellNums() {
			$user_id=$this->parameters["uid"]!=""		?	' AND a.`id` LIKE CONCAT('.$this->parameters["uid"].')'	:	'';
			$clientQuery["var"]=$user_id;
			$users = client::clientProfile($clientQuery);
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$cnumHTM = '<li>Not Provided</li>';
			$cnumHTM = '<ul>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Cell numbers */
						if(is_array($users[$i]["cnumber"]) && $users[$i]["cnumber"][0] != ''){

							for($j=0;$j<=sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != '';$j++){
								$cnumHTM .= '<li>'.ltrim( $users[$i]["cnumber"][$j] ,',').'</li>';
							}
						}
					}
				}
			}
			$cnumHTM .= '</ul>';
			return $cnumHTM;
		}
	/* Address */
	public function editAddress(){
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["uid"];
			/* Profile Address */
			$query = 'UPDATE  `user_profile`
					SET `addressline` = \''.mysql_real_escape_string($this->parameters["addrsline"]).'\',
						`town` = \''.mysql_real_escape_string($this->parameters["st_loc"]).'\',
						`city` = \''.mysql_real_escape_string($this->parameters["city_town"]).'\',
						`district` = \''.mysql_real_escape_string($this->parameters["district"]).'\',
						`province` = \''.mysql_real_escape_string($this->parameters["province"]).'\',
						`province_code` = \''.mysql_real_escape_string($this->parameters["provinceCode"]).'\',
						`country` = \''.mysql_real_escape_string($this->parameters["country"]).'\',
						`country_code` = \''.mysql_real_escape_string($this->parameters["countryCode"]).'\',
						`zipcode` = \''.mysql_real_escape_string($this->parameters["zipcode"]).'\',
						`website` = \''.mysql_real_escape_string($this->parameters["website"]).'\',
						`latitude` = \''.mysql_real_escape_string($this->parameters["lat"]).'\',
						`longitude` = \''.mysql_real_escape_string($this->parameters["lon"]).'\',
						`timezone` = \''.mysql_real_escape_string($this->parameters["timezone"]).'\',
						`gmaphtml` = \''.mysql_real_escape_string($this->parameters["gmaphtml"]).'\'
					WHERE `id` = \''.mysql_real_escape_string($user_pk).'\';';
			$flag = executeQuery($query);
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
	public function listAddress(){
			$user_id=$this->parameters["uid"]!=""		?	' AND a.`id` LIKE CONCAT('.$this->parameters["uid"].')'	:	'';
			$clientQuery["var"]=$user_id;
			$users = client::clientProfile($clientQuery);
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$addrHTM = '';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						$addrHTM .= '<ul>
										<li><strong>Address line : </strong>'.$users[$i]["addressline"].'</li>
										<li><strong>Street / Locality : </strong>'.$users[$i]["town"].'</li>
										<li><strong>City / Town : </strong>'.$users[$i]["city"].'</li>
										<li><strong>District / Department : </strong>'.$users[$i]["district"].'</li>
										<li><strong>State / Provice : </strong>'.$users[$i]["province"].'</li>
										<li><strong>Country : </strong>'.$users[$i]["country"].'</li>
										<li><strong>Zipcode : </strong>'.$users[$i]["zipcode"].'</li>
										<li><strong>Website : </strong>'.$users[$i]["website"].'</li>
										<li><strong>Google Map : </strong>'.$users[$i]["website"].'</li>
									</ul>';
					}
				}
			}
			return $addrHTM;
		}
	/*delete flag unflag*/
	public function deleteUser() {
		$flag = false;
		$query = NULL;
		executeQuery("SET AUTOCOMMIT=0;");
		executeQuery("START TRANSACTION;");
		$query = 'UPDATE  `user_profile` SET `status_id`=6 WHERE `id` = "'.mysql_real_escape_string($this->parameters["entry"]).'";';
		if(executeQuery($query)){
			$flag = true;
			executeQuery("COMMIT;");
		}
		return $flag;
	}
	public function flagUser() {
		$flag = false;
		$query = NULL;
		executeQuery("SET AUTOCOMMIT=0;");
		executeQuery("START TRANSACTION;");
		$query = 'UPDATE  `user_profile` SET `status_id`=7 WHERE `id` = "'.mysql_real_escape_string($this->parameters["uid"]).'";';
				if(executeQuery($query)){
					executeQuery("COMMIT");
					$flag = true;
				}
		return $flag;
	}
	public function unflagUser() {
		$flag = false;
		$query = NULL;
		executeQuery("SET AUTOCOMMIT=0;");
		executeQuery("START TRANSACTION;");
		$query = 'UPDATE  `user_profile` SET `status_id`=1 WHERE `id` = "'.mysql_real_escape_string($this->parameters["uid"]).'";';
				if(executeQuery($query)){
					executeQuery("COMMIT");
					$flag = true;
				}
		return $flag;
	}

	public function changeClientPic($fl){
           
//		require_once(DOC_ROOT.INC.'FirePHPCore/FirePHP.class.php');
//				$console_php = FirePHP::getInstance(true);
		$user_id=$this->parameters["usrid"]!=""		?	' AND a.`id` LIKE CONCAT('.$this->parameters["usrid"].')'	:	'';
		$clientQuery["var"]=$user_id;
		$users = client::clientProfile($clientQuery);
		$users = $users[0];
//		$console_php->log($users);
		$target_dir = DOC_ROOT.ASSET_DIR.$users["directory"]."/profile/";
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		$fn = explode(".",basename($_FILES["file"]["name"]));
		$ext = $fn[(sizeof($fn))-1];
		$fname = $target_dir . md5(generateRandomString()) .".". $ext;
		$dbpath=str_replace(DOC_ROOT.ASSET_DIR,"",$fname);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["file"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["file"]["size"] > 5000000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $fname)) {

//				$console_php->log($dbpath);
//				$console_php->log($users["photo_id"]);

				executeQuery('UPDATE `photo` SET `ver2`= \''.mysql_real_escape_string($dbpath).'\'
										WHERE `id` = \''.mysql_real_escape_string($users["photo_id"]).'\'');

			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		//----------------- FILE DATA OVER
		echo $target_dir.mysql_real_escape_string($users["photo_id"]);
	}

        public function fetchMops() {
            $mopsdata=array();
            $data='';
         $query='SELECT `id`, `mop` AS type FROM `mode_of_payment` WHERE `status_id` = 4;';
            $result=  executeQuery($query);
            if(mysql_num_rows($result))
            {
                while ($row = mysql_fetch_assoc($result)) {
                    $mopsdata[]=$row;
                }
                for($i=0;$i<sizeof($mopsdata);$i++)
                {
                   $data .='<option value="'.$mopsdata[$i]['id'].'">'.$mopsdata[$i]['type'].'</option>';
                }
                $jsondata=array(
                    "status" => "success",
                    "data" => $data
                );
                return $jsondata;

            }
            else {
                $jsondata=array(
                               "status" => "failure",
                               "data" => NULL
                           );
                           return $jsondata;
            }

        }
}
?>
