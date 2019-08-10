<?php
class trainer {
    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';
    function __construct($para = false) {
        $this->parameters = $para;
    }
    public function fetchTrainerType() {
        $moptype = NULL;
        $jsonmoptype = NULL;
        $num = 0;
        $query = 'SELECT ut.`id` AS id,
	               ut.`type` AS vtype
	        FROM `user_type` as ut,
	             `status` as st
	        WHERE ut.`status`= st.`id` AND
	              st.`statu_name`="Show" AND st.`status`=1 AND
	              ut.`type` NOT IN (SELECT type FROM user_type WHERE `type` = "Owner" OR
								`type` = "Manager" OR
								`type` = "Admin" OR
								`type` = "Trainer" OR
								`type` = "Customer" OR
								`type` = "Organization" OR
								`type` = "Marketing company / manager" OR
								`type` = "MMAdmin")';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $moptype[] = $row;
            }
        }
        if (is_array($moptype))
            $num = sizeof($moptype);
        if ($num) {
            for ($i = 0; $i < $num; $i++) {
                $jsonmoptype[] = array(
                    "html" => $moptype[$i]["vtype"],
                    "name" => $moptype[$i]["vtype"],
                    "id" => $moptype[$i]["id"]
                );
            }
        }
        return $jsonmoptype;
    }
    public function AddDummyEmail() {
        $email = NULL;
        $GYMNAME = $this->parameters["GYM_NAME"];
        $GYMNAME = strtolower(str_replace(" ", "_", $GYMNAME));
        $res = executeQuery("SELECT status FROM `dummy_email_ids` ORDER BY id DESC LIMIT 1;");
        $num = mysql_num_rows($res);
        if ($num > 0)
            $status = mysql_result($res, 0);
        else
            $status = 0;
        if ($status == 21) {
            $email = mysql_result(executeQuery("SELECT user_id FROM `dummy_email_ids` ORDER BY id DESC  LIMIT 1;"), 0);
            $emailqr = 'SELECT `id`
					FROM `user_profile`
					WHERE `email_id` = "' . mysql_real_escape_string($email) . '"';
            $res = executeQuery($emailqr);
            if ($res) {
                $row = mysql_num_rows($res);
                if ($row > 0) {
                    $num = mysql_result(executeQuery("SELECT COUNT(`id`) FROM `dummy_email_ids`;"), 0) + 1;
                    $email = $GYMNAME . '_' . sprintf("%04s", $num) . '@madmec.com';
                    executeQuery('INSERT INTO `dummy_email_ids` (`id`,`user_id`,`status`) VALUES(NULL,\'' . $email . '\',default);');
                }
            }
        } else {
            $num = mysql_result(executeQuery("SELECT COUNT(`id`) FROM `dummy_email_ids`;"), 0) + 1;
            $email = $GYMNAME . '_' . sprintf("%04s", $num) . '@madmec.com';
            executeQuery('INSERT INTO `dummy_email_ids` (`id`,`user_id`,`status`) VALUES(NULL,\'' . $email . '\',default);');
        }
        $_SESSION['DummyEmail'] = $email;
        return $email;
    }
    public function addMasterTrainer() {
        $data = array(
            "photo_id" => '',
            "user_id" => '',
            "directory" => '',
            "sphoto_pk" => '',
            "semp_pk" => '',
        );
        $link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link1) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
                $undelte = getStatusId("undelete");
//                $user_type = getUserTypeId("trainer");
                $user_type = $this->parameters['trainer_type'];
                $active = getStatusId("active");
                $show = getStatusId("show");
                /* Photo */
                $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
								NULL,NULL,NULL,NULL,NULL,NULL);';
                if (executeQuery($query1)) {
                    $photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                    if ($_SESSION['DummyEmail'] == $this->parameters["email"]) {
                        executeQuery('UPDATE `dummy_email_ids` SET `status` = 20 WHERE `user_id` = "' . $this->parameters["email"] . '";');
                    }
                    /* Trainer */
                    $query2 = 'INSERT INTO `user_profile`
								(`id`,
								 `user_name`,
								 `email_id`,
								 `acs_id`,
							     `photo_id`,
							     `password`,
							     `apassword`,
							     `passwordreset`,
							     `authenticatkey`,
							     `cell_code`,
							     `cell_number`,
							     `dob`,
								 `gender`,
								 `date_of_join`,
								 `status`) VALUES
								  (NULL,
								   \'' . mysql_real_escape_string($this->parameters["name"]) . '\',
								   \'' . mysql_real_escape_string($this->parameters["email"]) . '\',
								   \'' . mysql_real_escape_string($this->parameters["acsid"]) . '\',
								   \'' . mysql_real_escape_string($photo_pk) . '\',
								   \'' . mysql_real_escape_string($this->parameters["pass"]) . '\',
								   \'' . mysql_real_escape_string($this->parameters["auth"]) . '\',
								   NULL,
								   \'' . mysql_real_escape_string($this->parameters["auth"]) . '\',
								   \'' . mysql_real_escape_string($this->parameters["cellcode"]) . '\',
								   \'' . mysql_real_escape_string($this->parameters["cellnum"]) . '\',
								   \'' . mysql_real_escape_string($this->parameters["dob"]) . '\',
								   \'' . mysql_real_escape_string($this->parameters["sex_type"]) . '\',
								   \'' . mysql_real_escape_string($this->parameters["doj"]) . '\',
								   \'' . mysql_real_escape_string($active) . '\')';
                    if (executeQuery($query2)) {
                        $user_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                        $query3 = 'INSERT INTO `userprofile_type`
									 (`id`,
									  `user_pk`,
									  `usertype_id`,
									  `status`) VALUES
									  (NULL,
									  \'' . mysql_real_escape_string($user_pk) . '\',
									  \'' . mysql_real_escape_string($user_type) . '\',
									  \'' . mysql_real_escape_string($show) . '\')';
                        if (executeQuery($query3)) {
                            $query4 = 'INSERT INTO `userprofile_gymprofile`
										 (`id`,
										  `user_pk`,
										  `gym_id`,
										  `status`) VALUES
										  (NULL,
										   \'' . mysql_real_escape_string($user_pk) . '\',
										   \'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
										   \'' . mysql_real_escape_string($active) . '\')';
                            if (executeQuery($query4)) {
                                $directory_trainer = createdirectories(substr(md5(microtime()), 0, 6) . '_trainer_' . $user_pk);
                                executeQuery('UPDATE `user_profile` SET `directory` = \'' . $directory_trainer . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
                            }
                        }
                    }
                }
            }
        }
        if (get_resource_type($link1) == 'mysql link')
            mysql_close($link1);
        $data["photo_id"] = $photo_pk;
        $data["user_id"] = $user_pk;
        $data["directory"] = $directory_trainer;
        //~ $obj=new trainer();
        //~ $obj->addSlaveTrainer($trainer,$data);
        return $data;
    }
    public function addSlaveTrainer($data) {
        $flag = false;
        $link = MySQLconnect($this->parameters["GYM_HOST"], $this->parameters["GYM_USERNAME"], $this->parameters["GYM_DB_PASSWORD"]);
        if (get_resource_type($link) == 'mysql link') {
            if (($db_select = selectDB($this->parameters["GYM_DB_NAME"], $link)) == 1) {
                $undelte = getStatusId("undelete");
                //$user_type = getUserTypeId("trainer");
                $active = getStatusId("active");
                $show = getStatusId("show");
                //~ /* Photo */
                $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
					\'' . mysql_real_escape_string($data["photo_id"]) . '\',
					NULL,NULL,NULL,NULL,NULL,NULL);';
                if (executeQuery($query1)) {
                    $sphoto_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                    $query2 = 'INSERT INTO `employee`
					(`id`,
					 `user_name`,
					 `email`,
					 `acs_id`,
					 `photo_id`,
					 `cell_code`,
					 `cell_number`,
					 `directory`,
					 `dob`,
					 `gender`,
					 `date_of_join`,
					 `master_pk`,
					 `status`) VALUES
					 (NULL,
					  \'' . mysql_real_escape_string($this->parameters["name"]) . '\',
					  \'' . mysql_real_escape_string($this->parameters["email"]) . '\',
					  \'' . mysql_real_escape_string($this->parameters["acsid"]) . '\',
					  \'' . mysql_real_escape_string($sphoto_pk) . '\',
					  \'' . mysql_real_escape_string($this->parameters["cellcode"]) . '\',
					  \'' . mysql_real_escape_string($this->parameters["cellnum"]) . '\',
					  \'' . mysql_real_escape_string($data["directory"]) . '\',
					  \'' . mysql_real_escape_string($this->parameters["dob"]) . '\',
				      \'' . mysql_real_escape_string($this->parameters["sex_type"]) . '\',
				      \'' . mysql_real_escape_string($this->parameters["doj"]) . '\',
				      \'' . mysql_real_escape_string($data["user_id"]) . '\',
				      2)';
                    if (executeQuery($query2)) {
                        $semp_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                        $query3 = 'INSERT INTO `employee_facility`
						(`id`,
						 `employee_id`,
						 `facility_id`,
						 `status`) VALUES
						 (NULL,
						  \'' . mysql_real_escape_string($semp_pk) . '\',
						  \'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
						 4)';
                        executeQuery($query3);
                        $flag = true;
                        $data["sphoto_pk"] = $sphoto_pk;
                        $data["semp_pk"] = $semp_pk;
                    }
                }
            }
        }
        if (get_resource_type($link) == 'mysql link')
            mysql_close($link);
        return $data;
    }
    public function trainerPhotoUpload() {
        $dir = mysql_result(executeQuery('SELECT directory FROM `employee` WHERE `id`="' . $this->parameters["photo_id"] . '"'), 0);
        $photo = mysql_result(executeQuery('SELECT photo_id FROM `employee` WHERE `id`="' . $this->parameters["photo_id"] . '"'), 0);
        $obj = new trainer();
        $photo_id = $this->parameters["user_id"];
        $target_dir = DOC_ROOT . ASSET_DIR . $dir . "/profile/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $fn = explode(".", basename($_FILES["file"]["name"]));
        $ext = $fn[(sizeof($fn)) - 1];
        $fname = $target_dir . md5(generateRandomString()) . "." . $ext;
        $dbpath = str_replace(DOC_ROOT . ASSET_DIR, "", $fname);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if ($check !== false) {
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
        if ($_FILES["file"]["size"] > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $fname)) {
                executeQuery('UPDATE `photo` SET `ver2`= \'' . mysql_real_escape_string($dbpath) . '\'
										WHERE `id` = \'' . mysql_real_escape_string($photo) . '\'');
                $obj->updateMasterPhoto($dbpath, $photo_id);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        //----------------- FILE DATA OVER
        echo $target_dir;
    }
    public function updateMasterPhoto($dbpath, $photo_id) {
        $flag = false;
        $link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link1) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
                $mphoto_id = mysql_result(executeQuery('SELECT photo_id FROM `user_profile` WHERE `id`="' . $photo_id . '"'), 0);
                $query = 'UPDATE `photo` SET `ver2`= \'' . mysql_real_escape_string($dbpath) . '\'
										WHERE `id` = \'' . mysql_real_escape_string($mphoto_id) . '\'';
                if (executeQuery($query)) {
                    $flag = true;
                }
            }
        }
        return $flag;
    }
    public Static function listTrainer($para = false) {
        $trainer = $para["var"];
        $query = 'SELECT
					 a.*,
					 b.fid,
					 c.fname,
                                         d.usertypename,
					 CASE WHEN p.`ver2` IS NULL
						THEN "' . USER_ANON_IMAGE . '"
						ELSE CONCAT("' . URL . ASSET_DIR . '",p.`ver2`)
					   END AS photo
					FROM `employee` AS a
					LEFT JOIN `photo` AS p ON p.`id` = a.`photo_id`
					LEFT JOIN (
						SELECT
							 fa.`employee_id` AS eid,
							 fa.`facility_id` AS fid
						FROM `employee_facility` AS fa
						WHERE fa.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						) AS b ON b.`eid` = a.`id`
					LEFT JOIN (
						SELECT
							 f.`id` AS id,
							 f.`name` AS fname
						FROM `facility` AS f
						WHERE f.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						) AS c ON c.`id` = b.`fid`
                                        LEFT JOIN (
                                                SELECT
                                                         usertype.`user_pk` AS id,
                                                         upt.`type` AS usertypename
                                                FROM `'.DBNAME_ZERO.'`.userprofile_type AS usertype
                                                left join `'.DBNAME_ZERO.'`.user_type upt
                                                on upt.id=usertype.usertype_id
                                                WHERE usertype.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
                                                ) AS d ON d.`id` = a.`master_pk`
					WHERE a.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive"))
																' . $trainer . ';';
//        echo $query;
//        exit(0);
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $trainers[] = $row;
                $name[$i]["name"] = $row["user_name"];
                $name[$i]["email"] = $row["email"];
                $name[$i]["fname"] = $row["fname"];
                $i++;
            }
        } else {
        }
        if (isset($name) && isset($trainers)) {
            $clients = array(
                "listofPeoples" => $name,
                "trainer" => $trainers,
            );
        } else
            $clients = array();
        $_SESSION["listoftrainers"] = $clients;
        return $_SESSION["listoftrainers"];
    }
    public function displayListTrainer() {
        $trainer = array();
        $trainer = trainer::listTrainer();
        $html = '';
        $listtrainer = array(
            "html" => '<strong class="text-danger">There are no Employee available !!!!</strong>',
            "uid" => 0,
            "m_uid" => 0,
            "sr" => '',
            "name" => array(),
            "alertUSRDEL" => '',
            "usrdelOk" => '',
            "usrdelCancel" => '',
            "alertUSRFLG" => '',
            "usrflgOk" => '',
            "usrflgCancel" => '',
            "butuflg" => '',
            "alertUSRUFLG" => '',
            "usruflgOk" => '',
            "usruflgCancel" => '',
            "usredit" => ''
        );
        if (isset($_SESSION["listoftrainers"]) && $_SESSION["listoftrainers"] != NULL)
            $trainer = $_SESSION["listoftrainers"]["trainer"];
        else
            $trainer = NULL;
        if ($trainer != NULL)
            $num_posts = sizeof($trainer);
        if (isset($num_posts) && $num_posts > 0) {
            $name = array();
            $listtrainer = array();
            for ($i = 0; $i < $num_posts; $i++) {
                $doj = explode(" ", $trainer[$i]["date_of_join"]);
                $doj = $doj[0];
                $html = '<tr>
							<td class="details-control"></td>
							<td>' . ($i + 1) . '</td>
							<td>' . $trainer[$i]["user_name"] . '</td>
							<td class="text-right">' . $trainer[$i]["email"] . '&nbsp;</td>
							<td class="text-right">' . $trainer[$i]["cell_number"] . '&nbsp;</td>
                                                        <td class="text-right">' . $trainer[$i]["fname"] . '&nbsp;</td>
                                                        <td class="text-right">' . $trainer[$i]["usertypename"] . '&nbsp;</td>
							<td class="text-center"><button class="btn btn-danger btn-md" id="tra_but_trash_'.$trainer[$i]["id"].'" data-toggle="modal" data-target="#myTRADELModal_'.$trainer[$i]["id"].'" title="Delete"><i class="fa fa-trash  "></i> </button>&nbsp;';
							if(($trainer[$i]["status"])!='7'){
								$html .= '<button class="btn btn-primary btn-md" id="tra_but_flag_'.$trainer[$i]["id"].'" data-toggle="modal" data-target="#myModal_flag'.$trainer[$i]["id"].'" title="Flag"><i class="fa fa-flag  " ></i> </button>&nbsp;';
							}else if(($trainer[$i]["status"])=='7') {
								$html.='<button class="btn btn-warning btn-md" id="tra_but_unflag_'.$trainer[$i]["id"].'" data-toggle="modal" data-target="#myModal_unflag'.$trainer[$i]["id"].'" title="UnFlag"><i class="fa fa-flag  "></i> </button>&nbsp;';
							}$html.='<button class="btn btn-info btn-md" id="tra_but_edit_' . $trainer[$i]["id"] . '" title="Edit"><i class="fa fa-edit"></i> </button>
							</td>
							<td style="display:none";>  ' . $trainer[$i]["fname"] . '</td>
							<td style="display:none";>  ' . date('d-M-Y', strtotime($trainer[$i]["dob"])) . '</td>
							<td style="display:none";>  ' . date('d-M-Y h:i:s A', strtotime($doj)) . '</td>
						</tr>';
                $html.='<div class="modal fade" id="myTRADELModal_' . $trainer[$i]["id"] . '" tabindex="-1" role="dialog" aria-labelledby="myTRADELModalLabel_' . $trainer[$i]["id"] . '" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
															<h4 class="modal-title" id="myTRADELModalLabel_' . $trainer[$i]["id"] . '">Flag Trainer Entry</h4>
														</div>
														<div class="modal-body" id="myTRADEL_' . $trainer[$i]["id"] . '">
															Do you really want to delete {' . $trainer[$i]["user_name"] . '} <br />
															Press OK to delete ??
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-danger" data-dismiss="modal"  name=".modal-backdrop" id="deleteTRADELOk_' . $trainer[$i]["id"] . '">Ok</button>
															<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteTRADELCancel_' . $trainer[$i]["id"] . '">Cancel</button>
														</div>
													</div>
												</div>
											</div>
											<div class="modal fade" id="myModal_flag' . $trainer[$i]["id"] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_flag_Label_' . $trainer[$i]["id"] . '" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
															<h4 class="modal-title" id="myModal_flag_Label_' . $trainer[$i]["id"] . '">Flag Trainer Entry</h4>
														</div>
														<div class="modal-body">
															Do You really want to flag the Trainer ' . $trainer[$i]["user_name"] . ' entry ?? press <strong>OK</strong> to flag
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-danger" data-dismiss="modal"  name=".modal-backdrop" id="flagOk_' . $trainer[$i]["id"] . '">Ok</button>
															<button type="button" class="btn btn-success" data-dismiss="modal" id="flagCancel_' . $trainer[$i]["id"] . '">Cancel</button>
														</div>
													</div>
												</div>
											</div>
											<div class="modal fade" id="myModal_unflag' . $trainer[$i]["id"] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_unflag_Label_' . $trainer[$i]["id"] . '" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
															<h4 class="modal-title" id="myModal_unflag_Label_' . $trainer[$i]["id"] . '">UnFlag Trainer entry</h4>
														</div>
														<div class="modal-body">
															Do You really want to UnFlag the Trainer ' . $trainer[$i]["user_name"] . ' entry ?? press <strong>OK</strong> to UnFlag
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="unflagOk_' . $trainer[$i]["id"] . '">Ok</button>
															<button type="button" class="btn btn-success" data-dismiss="modal" id="unflagCancel_' . $trainer[$i]["id"] . '">Cancel</button>
														</div>
													</div>
												</div>
											</div>';
                $name[$i] = $trainer[$i]["user_name"];
                $listtrainer[] = array(
                    "html" => (string) str_replace($this->order, $this->replace,$html),
                    "uid" => $trainer[$i]["id"],
                    "m_uid" => $trainer[$i]["master_pk"],
                    "sr" => $trainer[$i]["id"],
                    "alertUSRDEL" => '#myTRADELModal_' . $trainer[$i]["id"],
                    "usrdelOk" => '#deleteTRADELOk_' . $trainer[$i]["id"],
                    "usrdelCancel" => '#deleteTRADELCancel_' . $trainer[$i]["id"],
                    "alertUSRFLG" => '#myModal_flag' . $trainer[$i]["id"] . '',
                    "usrflgOk" => '#flagOk_' . $trainer[$i]["id"] . '',
                    "usrflgCancel" => '#flagCancel_' . $trainer[$i]["id"] . '',
                    "butuflg" => '#usr_but_unflag_' . $trainer[$i]["id"] . '',
                    "alertUSRUFLG" => '#myModal_unflag' . $trainer[$i]["id"] . '',
                    "usruflgOk" => '#unflagOk_' . $trainer[$i]["id"] . '',
                    "usruflgCancel" => '#unflagCancel_' . $trainer[$i]["id"] . '',
                    "usredit" => '#tra_but_edit_' . $trainer[$i]["id"] . ''
                );
            }
        } else
            $listtrainer = array();;
        return $listtrainer;
    }
    public function edittrainer() {
        $TrainerQuery = array(
            "var" => ''
        );
        $trainer_id = $this->parameters["trainerid"]["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["trainerid"]["uid"] . ')' : '';
        $TrainerQuery["var"] = $trainer_id;
        $trainer = trainer::listTrainer($TrainerQuery);
        $trainer = $_SESSION["listoftrainers"]["trainer"];
        $doj = explode(" ", $trainer[0]["date_of_join"]);
        echo str_replace($this->order, $this->replace,'<div class="row">
				<div class="col-lg-12">&nbsp;</div>
				<div class="col-lg-4">
					<div class="panel panel-yellow">
						<div class="panel-heading">
							<h4>Photo</h4>
						</div>
						<div class="panel-body" id="usrphoto_' . $trainer[0]["id"] . '">
							<img src="' . $trainer[0]["photo"] . '" width="150" />
						</div>
						<div class="panel-footer">
							<button class="btn btn-yellow btn-md" id="usrphoto_but_edit_' . $trainer[0]["id"] . '" data-toggle="modal" data-target="#myModal_Photo1"><i class="fa fa-edit fa-fw "></i> Edit</button>
						</div>
					</div>
				</div>
				<div class="col-lg-8">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4>Trainer Details</h4>
							</div>
							<div class="panel-body" id="trainer" style="display:block;">
								<ul>
									<li><strong>Name : ' . $trainer[0]["user_name"] . '</strong></li>
									<li><strong>Facility Type : ' . $trainer[0]["fname"] . '</strong></li>
									<li><strong>E-Mail : ' . $trainer[0]["email"] . '</strong></li>
									<li><strong>Cell Number : ' . $trainer[0]["cell_number"] . '</strong></li>
									<li><strong>Date Of Birth : ' . date('d-M-Y', strtotime($trainer[0]["dob"])) . '</strong></li>
									<li><strong>Date Of Join : ' . date('d-M-Y h:i:s A', strtotime($doj[0])) . '</strong></li>
								</ul>
							</div>
							<div class="panel-body" id="trainer_edit" style="display:none;">
								<form id="trainer_edit_form">
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<span id="u_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>Name :</label>
													<span>
														<input  name="tra_name" type="text" class="form-control"  id="tra_name" value="' . $trainer[0]["user_name"] . '"/>
														<p class="help-block" id="un_msg">&nbsp;</p>
													</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<span id="eamil_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>E-mail :</label>
													<span>
														<input name="email" type="text" class="form-control" placeholder="ex@example.com" id="tra_email" value="' . $trainer[0]["email"] . '"/>
														<p class="help-block" id="em_msg">&nbsp;</p>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<span id="code_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>Cell Code:</label>
													<span>
														<input name="cellcode" type="text" class="form-control"  placeholder="91" maxlength="4" id="cellcode" value="91"/>
														<p class="help-block" id="cell_msg">&nbsp;</p>
													</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<span id="cell_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>Cell Number :</label>
													<span>
														<input name="mobile" type="text" class="form-control"  placeholder="9999999999" maxlength="10" id="tra_mobile" value="' . $trainer[0]["cell_number"] . '"/>
														<p class="help-block" id="mob_msg">&nbsp;</p>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<strong>Date Of Birth : </strong>
													<input name="dob" type="text" class="form-control" id="tra_dob" readonly="readonly" value="' . date('d-M-Y', strtotime($trainer[0]["dob"])) . '"/>
													<p class="help-block" id="tradob_msg">&nbsp;</p>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<strong>Date Of Join : </strong>
													<input name="doj" type="text" class="form-control" id="tra_doj" readonly="readonly" value="' . date('d-M-Y h:i:s A', strtotime($doj[0])) . '"/>
													<p class="help-block" id="tradoj_msg">&nbsp;</p>
												</div>
											</div>
										</div>
									</div>
								<!-- Update -->
								<div class="row">
									<div class="col-lg-12">&nbsp;</div>
									<div class="col-lg-12 text-center">
										<button type="button" class="btn btn-primary btn-md" id="trainer_update_but"><i class="fa fa-upload fa-fw "></i> Update</button>
										&nbsp;<button type="button" class="btn btn-primary btn-md" id="trainer_close_but"><i class="fa fa-close fa-fw "></i> Close</button>
									</div>
								</div>
								</form>
							</div>
							<div class="panel-footer">
								<button class="btn btn-primary btn-md" id="trainer_but_edit"><i class="fa fa-edit fa-fw "></i> Edit</button>
							</div>
						</div>
					</div>
				<div class="row">
					<div class="col-lg-12">&nbsp;</div>
						<div class="col-lg-12">
							<button type="button" class="btn btn-primary btn-md" id="usr_but_close_' . $trainer[0]["id"] . '"><i class="fa fa-close fa-fw "></i>close</button>
						</div>
			</div>
			<script>
				$(document).ready(function(){
					var close = {
						closeDiv	:	"#usr_but_close_' . $trainer[0]["id"] . '",
						clisttab	:	"#TrainerList",
					};
					var obj = new controlListTrainer();
					obj.close(close);
					var editTrainer = {
						autoloader 		: true,
						action 	   		: "loadTrainerForm",
						uid	   	   	: ' . $trainer[0]["id"] . ',
						m_uid	   	   	: ' . $trainer[0]["master_pk"] . ',
						email_val		: "' . $trainer[0]["email"] . '",
						outputDiv  		: "#output",
						showDiv 		: "#trainer",
						updateDiv 		: "#trainer_edit",
						but	   		: "#trainer_but_edit",
						saveBut	   		: "#trainer_update_but",
						closeBut   		: "#trainer_close_but",
						name			: "#tra_name",
						nmsg			: "#un_msg",
						sex			: "#tra_sex",
						smsg			: "#gender_msg",
						email			: "#tra_email",
						emsg			: "#em_msg",
						mobile			: "#tra_mobile",
						mmsg			: "#mob_msg",
						ccode			: "#cellcode",
						cmsg			: "#cell_msg",
						ftype			: "#tra_facility",
						fmsg			: "#type_msg",
						ttype			: "#tra_gym",
						tmsg			: "#tra_msg",
						dob			: "#tra_dob",
						doj			: "#tra_doj",
						dob_msg			: "tradob_msg",
						doj_msg			: "tradoj_msg",
						form 	   		: "#usrbankname_form",
						Updateurl		: window.location.href
					};
					var obj = new controlListTrainer();
					obj.editTrainer(editTrainer);
				});
			</script>');
        echo str_replace($this->order, $this->replace,'<form action="control.php" name="updatePic" id="changePic" method="post" enctype="multipart/form-data">
				 <fieldset>
				 <input type="hidden" name="formid" value="updatePic" />
				   	 <input type="hidden" name="action1" value="picUpdate" />
					 <input type="hidden" name="autoloader" value="true" />
					  <input type="hidden" name="type" value="slave" />
					 <input type="hidden" name="photo_id" value="' . $trainer[0]["id"] . '"/>
					 <input type="hidden" name="user_id" value="' . $trainer[0]["master_pk"] . '"/>
					 <div class="modal" id="myModal_Photo1" tabindex="-1" role="dialog" aria-labelledby="myModal_Photo_Label_' . $trainer[0]["id"] . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div class="modal-content" style="color:#000;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModal_Photo_Label_' . $trainer[0]["id"] . '">Update Trainer Photo</h4>
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
								<button type="button" class="btn btn-success" data-dismiss="modal" id="photoCancel_' . $trainer[0]["id"] . '">Cancel</button>
							</div>
						</div>
					</div>
				</div>
				 </fieldset>
			  </form>');
    }
    public function emailExistEmp() {
        $dataCheck = array(
            "flag" => true,
            "query" => '',
        );
        $empidcheck = '';
        if (isset($this->parameters["empid"]) && $this->parameters["empid"] != false || $this->parameters["empid"] != "cust")
            $empidcheck = 'AND `id` != "' . mysql_real_escape_string($this->parameters["empid"]) . '"';
        $emailqr = 'SELECT `id`,`email_id`
					FROM `user_profile`
					WHERE `email_id` = "' . mysql_real_escape_string($this->parameters["email"]) . '"
					' . $empidcheck . '';
        $dataCheck ["query"] = $emailqr;
        $res = executeQuery($emailqr);
        if ($res) {
            $row = mysql_num_rows($res);
            if ($row > 0) {
                $dataCheck ["flag"] = false;
            }
        }
        if ((isset($this->parameters["empid"]) && $this->parameters["empid"] != false))
            return $dataCheck ["flag"];
        else
            return $dataCheck;
    }
    /* update trainer */
    public function updateMasterTrainer() {
        $flag = false;
        $link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link1) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
                $query = 'UPDATE `user_profile` SET
						  `user_name` =  \'' . mysql_real_escape_string($this->parameters["name"]) . '\',
						  `email_id` = \'' . mysql_real_escape_string($this->parameters["email"]) . '\',
						  `cell_code` = \'' . mysql_real_escape_string($this->parameters["cellcode"]) . '\',
						  `cell_number` = \'' . mysql_real_escape_string($this->parameters["cellnum"]) . '\',
						  `dob` = \'' . mysql_real_escape_string($this->parameters["dob"]) . '\',
						  `date_of_join` = \'' . mysql_real_escape_string($this->parameters["doj"]) . '\'
						  WHERE `id` = \'' . mysql_real_escape_string($this->parameters["upuid"]["m_uid"]) . '\'';
                if (executeQuery($query)) {
                    $flag = true;
                }
            }
        }
        if (get_resource_type($link1) == 'mysql link')
            mysql_close($link1);
        return $flag;
    }
    public function updateSlaveTrainer() {
        $flag = false;
        $link = MySQLconnect($this->parameters["GYM_HOST"], $this->parameters["GYM_USERNAME"], $this->parameters["GYM_DB_PASSWORD"]);
        if (get_resource_type($link) == 'mysql link') {
            if (($db_select = selectDB($this->parameters["GYM_DB_NAME"], $link)) == 1) {
                $query = 'UPDATE `employee` SET
								 `user_name` =  \'' . mysql_real_escape_string($this->parameters["name"]) . '\',
								  `email` = \'' . mysql_real_escape_string($this->parameters["email"]) . '\',
								  `cell_code` = \'' . mysql_real_escape_string($this->parameters["cellcode"]) . '\',
								  `cell_number` = \'' . mysql_real_escape_string($this->parameters["cellnum"]) . '\',
								  `dob` = \'' . mysql_real_escape_string($this->parameters["dob"]) . '\',
								  `date_of_join` = \'' . mysql_real_escape_string($this->parameters["doj"]) . '\'
								  WHERE `id` = \'' . mysql_real_escape_string($this->parameters["upuid"]["uid"]) . '\'';
                if (executeQuery($query)) {
                    $flag = true;
                }
            }
        }
        if (get_resource_type($link) == 'mysql link')
            mysql_close($link);
        return $flag;
    }
    /* delete flag unflag */
    public function deleteTrainer() {
        $flag = false;
        $id = $this->parameters["entry"]["uid"];
        $query = NULL;
        $obj = new trainer();
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `employee` SET `status`=6 WHERE `id` = "' . mysql_real_escape_string($id) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT;");
            if ($obj->deleteMasterTrainer($this->parameters["entry"]["m_uid"])) {
                $flag = true;
            }
        }
        return $flag;
    }
    public function deleteMasterTrainer($id) {
        $flag = false;
        $query = NULL;
        $link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link1) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
                executeQuery("SET AUTOCOMMIT=0;");
                executeQuery("START TRANSACTION;");
                $query = 'UPDATE  `user_profile` SET `status`=6 WHERE `id` = "' . mysql_real_escape_string($id) . '";';
                if (executeQuery($query)) {
                    $flag = true;
                    executeQuery("COMMIT;");
                }
            }
        }
        return $flag;
    }
    public function flagTrainer() {
        $flag = false;
        $id = $this->parameters["fuid"]["uid"];
        $query = NULL;
        $obj = new trainer($this->parameters["fuid"]);
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `employee` SET `status`=7 WHERE `id` = "' . mysql_real_escape_string($id) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            if ($obj->flagMasterTrainer($this->parameters["fuid"]["m_uid"])) {
                $flag = true;
            }
        }
        return $flag;
    }
    public function flagMasterTrainer($id) {
        $flag = false;
        $query = NULL;
        $link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link1) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
                executeQuery("SET AUTOCOMMIT=0;");
                executeQuery("START TRANSACTION;");
                $query = 'UPDATE  `user_profile` SET `status`=7 WHERE `id` = "' . mysql_real_escape_string($id) . '";';
                if (executeQuery($query)) {
                    $flag = true;
                    executeQuery("COMMIT;");
                }
            }
        }
        return $flag;
    }
    public function unflagTrainer() {
        $flag = false;
        $id = $this->parameters["ufuid"]["uid"];
        $query = NULL;
        $obj = new trainer();
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `employee` SET `status`= 2 WHERE `id` = "' . mysql_real_escape_string($id) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            if ($obj->unflagMasterTrainer($this->parameters["ufuid"]["m_uid"])) {
                $flag = true;
            }
        }
        return $flag;
    }
    public function unflagMasterTrainer($id) {
        $flag = false;
        $query = NULL;
        $link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link1) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
                executeQuery("SET AUTOCOMMIT=0;");
                executeQuery("START TRANSACTION;");
                $query = 'UPDATE  `user_profile` SET `status`= 11 WHERE `id` = "' . mysql_real_escape_string($id) . '";';
                if (executeQuery($query)) {
                    $flag = true;
                    executeQuery("COMMIT;");
                }
            }
        }
        return $flag;
    }
    /* upload XLS File */
    function ImportUsers() {
        $flag = false;
        $obj = new trainer($this->parameters);
        $importdata = NULL;
        $importdata['NAME'] = NULL;
        $importdata['GENDER'] = NULL;
        $importdata['MOBILE'] = NULL;
        $importdata['EMAIL'] = NULL;
        $importdata['DOB'] = NULL;
        $importdata['ACS_ID'] = NULL;
        $importdata['TRAINERGYM'] = NULL;
        if (strtolower($_FILES["xls_users_file"]['type']) == "application/vnd.ms-excel" ||
                strtolower($_FILES["xls_users_file"]['type']) == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $path1 = DOC_ROOT . "/uploads";
            $temp = explode(".", $_FILES["xls_users_file"]['name']);
            $order = array("_", " ");
            $replace = '-';
            $fname1 = md5(date('h-i-s,_j-m-y,_it_is_w_Day_u') . "-" . rand(1, 99)) . "_" . str_replace($order, $replace, $_FILES["xls_users_file"]['name']);
            $thefile1 = $path1 . "/" . $fname1;
            if (move_uploaded_file($_FILES["xls_users_file"]['tmp_name'], $thefile1)) {
                if (is_file($thefile1)) {
                    if (strtolower($_FILES["xls_users_file"]['type']) == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
                        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                    if (strtolower($_FILES["xls_users_file"]['type']) == "application/vnd.ms-excel")
                        $objReader = new PHPExcel_Reader_Excel5();
                    $objReader->setReadDataOnly(true);
                    $objPHPExcel = $objReader->load($thefile1);
                    $objWorksheet = $objPHPExcel->getActiveSheet();
                    $highestRow = $objWorksheet->getHighestRow();
                    $highestColumn = $objWorksheet->getHighestColumn();
                    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                    if ($highestRow > 0 && $highestColumnIndex > 0) {
                        $importdata = array();
                        for ($col = 0; $col < $highestColumnIndex; ++$col) {
                            if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_NAME) {
                                $importdata['NAME'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['NAME'][$j] = isset($temp) ? $temp : NULL;
                                }
                            } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_GENDER) {
                                $importdata['GENDER'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['GENDER'][$j] = isset($temp) ? $temp : NULL;
                                }
                            }
                            else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_DOB) {
                                $importdata['DOB'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['DOB'][$j] = isset($temp) ? $temp : NULL;
                                }
                            } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_MOBILE) {
                                $importdata['MOBILE'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['MOBILE'][$j] = isset($temp) ? $temp : NULL;
                                }
                            } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_EMAIL) {
                                $importdata['EMAIL'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['EMAIL'][$j] = isset($temp) ? $temp : NULL;
                                }
                            }
                            // else if($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_TRAINERGYM){
                            // $importdata['TRAINERGYM'] = array();
                            // for ($row = 2,$j = 1; $row <= $highestRow; ++$row,$j++) {
                            // $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                            // if($temp == '' || $temp == 'NULL')
                            // $temp = 0;
                            // else
                            // $temp = 1;
                            // $importdata['TRAINERGYM'][$j] = $temp;
                            // }
                            // }
                            else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_ACCESS_ID) {
                                $importdata['ACS_ID'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['ACS_ID'][$j] = isset($temp) ? $temp : NULL;
                                }
                            }
                        }
                        if ($importdata) {
                            if (!$obj->checkForDuplicate($importdata, true, false)) { /* Email Id duplication */
                                if (!$obj->checkForDuplicate($importdata, false, true)) { /* Cell Number duplication */
                                    if (!$obj->checkForBulkExistence($importdata, true, false)) { /* Email Id duplication in database */
                                        if (!$obj->checkForBulkExistence($importdata, false, true)) { /* Cell Number duplication in database */
                                            if ($obj->AddBulk($importdata)) {
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
        if (!$flag)
            echo '<h2>0 records in file!!!</h2>';
    }
    function checkForDuplicate($fields, $email = false, $cell_number = false) {
        $total = sizeof($fields['EMAIL']);
        $flag = false;
        if ($total) {
            $k = 1;
            echo '<table border="1" cellpadding="2" cellspacing="2" width="920" align="center">';
            if ($email) {
                echo str_replace($this->order, $this->replace,'<tr><td align="center" colspan="8">Duplicate Email Ids in ' . $_FILES["xls_users_file"]['name'] . '</td></tr>
					<tr>
						<td align="right">No</td>
						<td align="center">NAME</td>
						<td align="center">GENDER</td>
						<td align="center">DOB</td>
						<td align="center">MOBILE</td>
						<td align="center">EMAIL</td>
						<td align="center">ACS ID</td>
					</tr>');
                for ($i = 1; $i <= $total; $i++) {
                    for ($j = $i + 1; $j <= $total; $j++) {
                        if ($fields['EMAIL'][$i] == $fields['EMAIL'][$j] && $fields['EMAIL'][$j]) {
                            echo str_replace($this->order, $this->replace,'<tr>
									<td>' . $k . '</td>
									<td>' . $fields['NAME'][$j] . '</td>
									<td>' . $fields['GENDER'][$j] . '</td>
									<td align="right">' . $fields['DOB'][$j] . '</td>
									<td align="right">' . $fields['MOBILE'][$j] . '</td>
									<td>' . $fields['EMAIL'][$j] . '</td>
									<td align="right">' . $fields['ACS_ID'][$j] . '</td>
								</tr>');
                            $fields['EMAIL'][$j] = NULL;
                            $flag = true;
                            $k++;
                        }
                    }
                }
                if (!$flag) {
                    echo '<tr><td align="center" colspan="8">No duplicatie Email Ids ' . $_FILES["xls_users_file"]['name'] . '</td></tr>';
                }
            } else if ($cell_number) {
                echo str_replace($this->order, $this->replace,'<tr><td align="center" colspan="8">Duplicate Cell Numbers in ' . $_FILES["xls_users_file"]['name'] . '</td></tr>
					<tr>
						<td align="right">No</td>
						<td align="center">NAME</td>
						<td align="center">GENDER</td>
						<td align="center">DOB</td>
						<td align="center">MOBILE</td>
						<td align="center">EMAIL</td>
						<td align="center">ACS ID</td>
					</tr>');
                for ($i = 1; $i <= $total; $i++) {
                    for ($j = $i + 1; $j <= $total; $j++) {
                        if ($fields['MOBILE'][$i] == $fields['MOBILE'][$j] && $fields['MOBILE'][$j]) {
                            echo str_replace($this->order, $this->replace,'<tr>
									<td>' . $k . '</td>
									<td>' . $fields['NAME'][$j] . '</td>
									<td>' . $fields['GENDER'][$j] . '</td>
									<td align="right">' . $fields['DOB'][$j] . '</td>
									<td align="right">' . $fields['MOBILE'][$j] . '</td>
									<td>' . $fields['EMAIL'][$j] . '</td>
									<td align="right">' . $fields['ACS_ID'][$j] . '</td>
								</tr>');
                            $fields['MOBILE'][$j] = NULL;
                            $flag = true;
                            $k++;
                        }
                    }
                }
                if (!$flag) {
                    echo '<tr><td align="center" colspan="8">No duplicatie Cell Numbers  in ' . $_FILES["xls_users_file"]['name'] . '</td></tr>';
                }
            }
            echo '</table><p>&nbsp;</p>';
        }
        return $flag;
    }
    function checkForBulkExistence($fields, $email = false, $cell_number = false) {
        $flag = false;
        $query1 = false;
        $query2 = false;
        $total = sizeof($fields['EMAIL']);
        $email_ids = NULL;
        $cell_numbers = NULL;
        if ($total) {
            $k = 1;
            $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
            if (get_resource_type($link) == 'mysql link') {
                if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
                    echo '<table border="1" cellpadding="2" cellspacing="2" width="920" align="center">';
                    if ($email) {
                        $query = 'SELECT `email_id` AS email FROM `user_profile`
								  UNION
								  SELECT `user_pk` FROM `email_ids`;';
                        $res = executeQuery($query);
                        if (mysql_num_rows($res)) {
                            $email_ids = array();
                            $i = 1;
                            while ($row = mysql_fetch_assoc($res)) {
                                $email_ids[$i] = $row['email'];
                                $i++;
                            }
                        }
                        if (is_array($email_ids)) {
                            echo str_replace($this->order, $this->replace,'<tr><td align="center" colspan="8">Duplicate Email Ids  in database</td></tr>
								<tr>
									<td align="center">No</td>
									<td align="center">NAME</td>
									<td align="center">GENDER</td>
									<td align="center">DOB</td>
									<td align="center">MOBILE</td>
									<td align="center">EMAIL</td>
									<td align="center">ACS ID</td>
								</tr>');
                            for ($i = 1; $i <= $total; $i++) {
                                for ($j = 1; $j <= sizeof($email_ids); $j++) {
                                    if ($fields['EMAIL'][$i] == $email_ids[$j] && $email_ids[$j]) {
                                        echo str_replace($this->order, $this->replace,'<tr>
												<td>' . $k . '</td>
												<td>' . $fields['NAME'][$i] . '</td>
												<td>' . $fields['GENDER'][$i] . '</td>
												<td align="right">' . $fields['DOB'][$i] . '</td>
												<td align="right">' . $fields['MOBILE'][$i] . '</td>
												<td>' . $fields['EMAIL'][$i] . '</td>
												<td align="right">' . $fields['ACS_ID'][$i] . '</td>
											</tr>');
                                        $flag = true;
                                        $email_ids[$j] = NULL;
                                        $k++;
                                    }
                                }
                            }
                        }
                        if (!$flag) {
                            echo '<tr><td align="center" colspan="8">No duplicatie Email Ids in database</td></tr>';
                        }
                    } else if ($cell_number) {
                        $query = 'SELECT `cell_number` AS cell FROM `user_profile`
								  UNION
								  SELECT `cell_number` FROM `cell_numbers`;';
                        $res = executeQuery($query);
                        if (mysql_num_rows($res)) {
                            $cell_numbers = array();
                            $i = 1;
                            while ($row = mysql_fetch_assoc($res)) {
                                $cell_numbers[$i] = $row['cell'];
                                $i++;
                            }
                        }
                        if (is_array($cell_numbers)) {
                            echo str_replace($this->order, $this->replace,'<tr><td align="center" colspan="8">Duplicate Cell Numbers  in database</td></tr>
								<tr>
									<td align="center">No</td>
									<td align="center">NAME</td>
									<td align="center">GENDER</td>
									<td align="center">DOB</td>
									<td align="center">MOBILE</td>
									<td align="center">EMAIL</td>
									<td align="center">ACS ID</td>
								</tr>');
                            for ($i = 1; $i <= $total; $i++) {
                                for ($j = 1; $j <= sizeof($cell_numbers); $j++) {
                                    if ($fields['MOBILE'][$i] == $cell_numbers[$j] && $cell_numbers[$j]) {
                                        echo str_replace($this->order, $this->replace,'<tr>
												<td>' . $k . '</td>
												<td>' . $fields['NAME'][$i] . '</td>
												<td>' . $fields['GENDER'][$i] . '</td>
												<td align="right">' . $fields['DOB'][$i] . '</td>
												<td align="right">' . $fields['MOBILE'][$i] . '</td>
												<td>' . $fields['EMAIL'][$i] . '</td>
												<td align="right">' . $fields['ACS_ID'][$i] . '</td>
											</tr>');
                                        $flag = true;
                                        $k++;
                                    }
                                }
                            }
                        }
                        if (!$flag) {
                            echo '<tr><td align="center" colspan="8">No duplicatie Cell Numbers  in database</td></tr>';
                        }
                    }
                    echo '</table><p>&nbsp;</p>';
                }
            }
            if (get_resource_type($link) == 'mysql link')
                mysql_close($link);
        }
        return $flag;
    }
    function AddBulk($fields) {
        $flag = false;
        $query = false;
        $obj = new trainer($this->parameters);
        $total = sizeof($fields['EMAIL']);
        $k = 1;
        $data = array(
            "user_id" => '',
            "directory" => '',
        );
        $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
                $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
                $password = array();
                $undelte = getStatusId("undelete");
//                $user_type = getUserTypeId("trainer");
                $user_type = $this->parameters['facility_type'];
                $active = getStatusId("active");
                $show = getStatusId("show");
                if ($total > 1999) {
                    $qut = floor($total / 2000);
                    $rem = $total % 2000;
                    for ($i = 1; $i <= $qut; $i++) {
                        $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                        $photo_pk = mysql_result(executeQuery($query1), 0);
                        $query2 = 'SELECT `id` FROM `user_profile` ORDER BY `id` DESC LIMIT 1';
                        $user_pk = mysql_result(executeQuery($query2), 0);
                        //$query = 'INSERT INTO `employee`(`id`,`user_name`,`email`,`acs_id`,`password`,`apassword`,`gender`,`cell_number`,`status`,`passwordreset`,`date_of_join`,`fired_date`,`Gym`,`Aerobics`,`Dance`,`Yoga`,`Zumba`)  VALUES';
                        $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        $query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`acs_id`,`photo_id`,`directory`,`password`,`apassword`,`gender`,`dob`,`cell_code`,`cell_number`,`status`,`passwordreset`,`date_of_join`)  VALUES';
                        $query3 = 'INSERT INTO `userprofile_type`(`id`,`user_pk`,`usertype_id`,`status`) VALUES';
                        $query4 = 'INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`) VALUES';
                        //$query0 = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES";
                        for ($j = 1; $j <= 2000 && $j <= $num1; $j++) {
                            $password[$k] = generateRandomString();
                            $pass = md5($password[$k]);
                            $directory_trainer = createdirectories(substr(md5(microtime()), 0, 6) . '_trainer_' . ($user_pk + $k));
                            //~ $obj->sendMail(array (
                            //~ "name" 		=> $fields["NAME"][$k],
                            //~ "login_id" 	=> $fields["EMAIL"][$k],
                            //~ "password" 	=> $password[$k],
                            //~ "acs_id" 	=> $fields["ACS_ID"][$k]
                            //~ ));
                            if ($j == 2000) {
                                $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												\'' . mysql_real_escape_string($directory_trainer[$k]) . '\',
												\'' . mysql_real_escape_string($password[$k]) . '\',
												\'' . mysql_real_escape_string($pass) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												2,
												NULL,
												\'' . mysql_real_escape_string($curr_time) . '\');';
                                $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL);';
                                $query3 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($user_type) . '\',
										        \'' . mysql_real_escape_string($show) . '\');';
                                $query4 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
												\'' . mysql_real_escape_string($active) . '\');';
                                //$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
                            } else {
                                $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												\'' . mysql_real_escape_string($directory_trainer[$k]) . '\',
												\'' . mysql_real_escape_string($password[$k]) . '\',
												\'' . mysql_real_escape_string($pass) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												2,
												NULL,
												\'' . mysql_real_escape_string($curr_time) . '\'),';
                                $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL),';
                                $query3 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($user_type) . '\',
										        \'' . mysql_real_escape_string($show) . '\'),';
                                $query4 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
												\'' . mysql_real_escape_string($active) . '\'),';
                                //$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending'),";
                            }
                            $k++;
                        }
                    }
                    //$query = 'INSERT INTO `trainers`(`id`,`name`,`email_id`,`acs_id`,`password`,`apassword`,`sex`,`cell_number`,`status`,`passwordreset`,`hired_date`,`fired_date`,`Gym`,`Aerobics`,`Dance`,`Yoga`,`Zumba`)  VALUES';
                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                    $query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`acs_id`,`photo_id`,`directory`,`password`,`apassword`,`gender`,`dob`,`cell_code`,`cell_number`,`status`,`passwordreset`,`date_of_join`)  VALUES';
                    $query3 = 'INSERT INTO `userprofile_type`(`id`,`user_pk`,`usertype_id`,`status`) VALUES';
                    $query4 = 'INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`) VALUES';
                    if ($rem > 0) {
                        $remaining = $total - ($qut * 2000);
                        for ($j = 1; $j <= $remaining; $j++) {
                            //if(checkExistence(false,$fields['EMAIL'][$k],false) == 'failed'){
                            $password[$k] = generateRandomString();
                            $pass = md5($password[$k]);
                            $directory_trainer = createdirectories(substr(md5(microtime()), 0, 6) . '_trainer_' . ($user_pk + $k));
                            //~ $obj->sendMail(array (
                            //~ "name" 		=> $fields["NAME"][$k],
                            //~ "login_id" 	=> $fields["EMAIL"][$k],
                            //~ "password" 	=> $password[$k],
                            //~ "acs_id" 	=> $fields["ACS_ID"][$k]
                            //~ ));
                            if ($j == $remaining) {
                                //$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',default,NULL,\''.mysql_real_escape_string($curr_time).'\',NULL,\''.mysql_real_escape_string($fields['TRAINERGYM'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERAER'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERDAN'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERYOG'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERZUM'][$k]).'\');';
                                $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												\'' . mysql_real_escape_string($directory_trainer[$k]) . '\',
												\'' . mysql_real_escape_string($password[$k]) . '\',
												\'' . mysql_real_escape_string($pass) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												2,
												NULL,
												\'' . mysql_real_escape_string($curr_time) . '\');';
                                $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL);';
                                $query3 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($user_type) . '\',
										        \'' . mysql_real_escape_string($show) . '\');';
                                $query4 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
												\'' . mysql_real_escape_string($active) . '\');';
                                //$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
                            } else {
                                //$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',default,NULL,\''.mysql_real_escape_string($curr_time).'\',NULL,\''.mysql_real_escape_string($fields['TRAINERGYM'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERAER'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERDAN'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERYOG'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERZUM'][$k]).'\'),';
                                $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												\'' . mysql_real_escape_string($directory_trainer[$k]) . '\',
												\'' . mysql_real_escape_string($password[$k]) . '\',
												\'' . mysql_real_escape_string($pass) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												2,
												NULL,
												\'' . mysql_real_escape_string($curr_time) . '\'),';
                                $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL),';
                                $query3 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($user_type) . '\',
										        \'' . mysql_real_escape_string($show) . '\'),';
                                $query4 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
												\'' . mysql_real_escape_string($active) . '\'),';
                                //$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending'),";
                            }
                            $k++;
                            //}
                        }
                    }
                } else if ($total < 2000 && $total >= 1) {
                    $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                    $photo_pk = mysql_result(executeQuery($query1), 0);
                    $query2 = 'SELECT `id` FROM `user_profile` ORDER BY `id` DESC LIMIT 1';
                    $user_pk = mysql_result(executeQuery($query2), 0);
                    //$query = 'INSERT INTO `trainers`(`id`,`name`,`email_id`,`acs_id`,`password`,`apassword`,`sex`,`cell_number`,`status`,`passwordreset`,`hired_date`,`fired_date`,`Gym`,`Aerobics`,`Dance`,`Yoga`,`Zumba`)  VALUES';
                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                    $query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`acs_id`,`photo_id`,`directory`,`password`,`apassword`,`gender`,`dob`,`cell_code`,`cell_number`,`status`,`passwordreset`,`date_of_join`)  VALUES';
                    $query3 = 'INSERT INTO `userprofile_type`(`id`,`user_pk`,`usertype_id`,`status`) VALUES';
                    $query4 = 'INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`) VALUES';
                    for ($i = 1; $i <= $total; $i++) {
                        //if(checkExistence(false,$fields['EMAIL'][$k],false) == 'failed'){
                        $password[$k] = generateRandomString();
                        $pass = md5($password[$k]);
                        $directory_trainer = createdirectories(substr(md5(microtime()), 0, 6) . '_trainer_' . ($user_pk + $k));
                        //~ $obj->sendMail(array (
                        //~ "name" 		=> $fields["NAME"][$k],
                        //~ "login_id" 	=> $fields["EMAIL"][$k],
                        //~ "password" 	=> $password[$k],
                        //~ "acs_id" 	=> $fields["ACS_ID"][$k]
                        //~ ));
                        if ($i == $total) {
                            //$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',default,NULL,\''.mysql_real_escape_string($curr_time).'\',NULL,\''.mysql_real_escape_string($fields['TRAINERGYM'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERAER'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERDAN'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERYOG'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERZUM'][$k]).'\');';
                            $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												\'' . mysql_real_escape_string($directory_trainer) . '\',
												\'' . mysql_real_escape_string($password[$k]) . '\',
												\'' . mysql_real_escape_string($pass) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												2,
												NULL,
												\'' . mysql_real_escape_string($curr_time) . '\');';
                            $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL);';
                            $query3 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($user_type) . '\',
										        \'' . mysql_real_escape_string($show) . '\');';
                            $query4 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
												\'' . mysql_real_escape_string($active) . '\');';
                            //$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
                        } else {
                            //$query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',default,NULL,\''.mysql_real_escape_string($curr_time).'\',NULL,\''.mysql_real_escape_string($fields['TRAINERGYM'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERAER'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERDAN'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERYOG'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERZUM'][$k]).'\'),';
                            $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												\'' . mysql_real_escape_string($directory_trainer) . '\',
												\'' . mysql_real_escape_string($password[$k]) . '\',
												\'' . mysql_real_escape_string($pass) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												2,
												NULL,
												\'' . mysql_real_escape_string($curr_time) . '\'),';
                            $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL),';
                            $query3 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($user_type) . '\',
										        \'' . mysql_real_escape_string($show) . '\'),';
                            $query4 .='(NULL,
												\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
												\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
												\'' . mysql_real_escape_string($active) . '\'),';
                            //$query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending'),";
                        }
                        $data[] = array(
                            "user_id" => $user_pk + $k,
                            "directory" => $directory_trainer,
                        );
                        $k++;
                        //}
                    }
                }
                if ($total) {
                    if (executeQuery($query1)) {
                        $res = executeQuery($query);
                        if ($res) {
                            $res = executeQuery($query3);
                            if ($res) {
                                $res = executeQuery($query4);
                                if ($res) {
                                    $obj->slaveAddBulk($data, $fields);
                                    $flag = true;
                                    echo '<h2>' . ($k - 1) . ' trainers have been inserted in to database!!!</h2>';
                                }
                            }
                        }
                    }
                }
            }
        }
        if (get_resource_type($link) == 'mysql link')
            mysql_close($link);
        return $flag;
    }
    function slaveAddBulk($data, $fields) {
        $flag = false;
        $query = false;
        $total = sizeof($fields['EMAIL']);
        $k = 1;
        $link = MySQLconnect($this->parameters["GYM_HOST"], $this->parameters["GYM_USERNAME"], $this->parameters["GYM_DB_PASSWORD"]);
        if (get_resource_type($link) == 'mysql link') {
            if (($db_select = selectDB($this->parameters["GYM_DB_NAME"], $link)) == 1) {
                $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
                $password = array();
                if ($total > 1999) {
                    $qut = floor($total / 2000);
                    $rem = $total % 2000;
                    for ($i = 1; $i <= $qut; $i++) {
                        $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                        $photo_pk = mysql_result(executeQuery($query1), 0);
                        $query2 = 'SELECT `id` FROM `employee` ORDER BY `id` DESC LIMIT 1';
                        $user_pk = mysql_result(executeQuery($query2), 0);
                        //all querry for trainer save entry
                        $query = 'INSERT INTO `employee` (`id`,`user_name`,`email`,`acs_id`,`photo_id`,`cell_code`,`cell_number`,`directory`,`dob`,`gender`,`master_pk`,`status`) VALUES ';
                        $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        $query2 = 'INSERT INTO `employee_facility`(`id`,`employee_id`,`facility_id`,`status`) VALUES';
                        for ($j = 1; $j <= 2000 && $j <= $num1; $j++) {
                            if ($i == $total) {
                                $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
												2);';
                                $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
											 \'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
											 NULL,NULL,NULL,NULL,NULL);';
                                $query2 .='(NULL,
											  \'' . mysql_real_escape_string(($user_pk + $k)) . '\',
											  \'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
											 4);';
                            } else {
                                $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
												2),';
                                $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
											 \'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
											 NULL,NULL,NULL,NULL,NULL),';
                                $query2 .='(NULL,
											  \'' . mysql_real_escape_string(($user_pk + $k)) . '\',
											  \'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
											 4),';
                            }
                            $k++;
                        }
                    }
                    $query = 'INSERT INTO `employee` (`id`,`user_name`,`email`,`acs_id`,`photo_id`,`cell_code`,`cell_number`,`directory`,`dob`,`gender`,`master_pk`,`status`) VALUES ';
                    $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                    $query2 = 'INSERT INTO `employee_facility`(`id`,`employee_id`,`facility_id`,`status`) VALUES';
                    if ($rem > 0) {
                        $remaining = $total - ($qut * 2000);
                        for ($j = 1; $j <= $remaining; $j++) {
                            if ($i == $total) {
                                $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
												2);';
                                $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
											 \'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
											 NULL,NULL,NULL,NULL,NULL);';
                                $query2 .='(NULL,
											  \'' . mysql_real_escape_string(($user_pk + $k)) . '\',
											  \'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
											 4);';
                            } else {
                                $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
												2),';
                                $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
											 \'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
											 NULL,NULL,NULL,NULL,NULL),';
                                $query2 .='(NULL,
											  \'' . mysql_real_escape_string(($user_pk + $k)) . '\',
											  \'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
											 4),';
                            }
                            $k++;
                        }
                    }
                } else if ($total < 2000 && $total >= 1) {
                    $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                    $photo_pk = mysql_result(executeQuery($query1), 0);
                    $query2 = 'SELECT `id` FROM `employee` ORDER BY `id` DESC LIMIT 1';
                    $user_pk = mysql_result(executeQuery($query2), 0);
                    //all querry for trainer save entry
                    $query = 'INSERT INTO `employee` (`id`,`user_name`,`email`,`acs_id`,`photo_id`,`cell_code`,`cell_number`,`directory`,`dob`,`gender`,`master_pk`,`status`) VALUES ';
                    $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                    $query2 = 'INSERT INTO `employee_facility`(`id`,`employee_id`,`facility_id`,`status`) VALUES';
                    //$query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                    //$query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`acs_id`,`photo_id`,`directory`,`password`,`apassword`,`gender`,`dob`,`cell_code`,`cell_number`,`status`,`passwordreset`,`date_of_join`)  VALUES';
                    //$query3='INSERT INTO `userprofile_type`(`id`,`user_pk`,`usertype_id`,`status`) VALUES';
                    //$query4='INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`) VALUES';
                    for ($i = 1; $i <= $total; $i++) {
                        if ($i == $total) {
                            $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
												2);';
                            $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
											 \'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
											 NULL,NULL,NULL,NULL,NULL);';
                            $query2 .='(NULL,
											  \'' . mysql_real_escape_string(($user_pk + $k)) . '\',
											  \'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
											 4);';
                        } else {
                            $query .= '(NULL,
												\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
												\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
												91,
												\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
												\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
												\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
												\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
												2),';
                            $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
											 \'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
											 NULL,NULL,NULL,NULL,NULL),';
                            $query2 .='(NULL,
											  \'' . mysql_real_escape_string(($user_pk + $k)) . '\',
											  \'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
											 4),';
                        }
                        $k++;
                    }
                }
                if ($total) {
                    if (executeQuery($query1)) {
                        $res = executeQuery($query);
                        if ($res) {
                            $res = executeQuery($query2);
                            if ($res) {
                                $flag = true;
                                //echo '<h2>'.($k-1) .' trainers have been inserted in to database!!!</h2>';
                            }
                        }
                    }
                }
            }
        }
        if (get_resource_type($link) == 'mysql link')
            mysql_close($link);
        return $flag;
    }
    function sendMail($parameters) {
        $message = str_replace($this->order, $this->replace,'<table width="80%" border="0" align="center" cellpadding="3" cellspacing="3">
					<tr>
						<td><p><span style="font-weight:900; font-size:24px;  color:#999;">' . GYMNAME . ' account details.</span></p></td>
						<td><img src="' . GYM_LOGO . '" width="75" alt="Gym Avatar"/></td>
					</tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td width="50%" align="right">Name : </td>
						<td width="50%">' . $parameters["name"] . '</td>
					</tr>
					<tr>
						<td width="50%" align="right">Login id : </td>
						<td width="50%">' . $parameters["login_id"] . '</td>
					</tr>
					<tr>
						<td width="50%" align="right">Password : </td>
						<td width="50%">' . $parameters["password"] . '</td>
					</tr>
					<tr>
						<td width="50%" align="right">Access Id : </td>
						<td width="50%">' . $parameters["acs_id"] . '</td>
					</tr>
					<tr>
						<td colspan="2"><p>you received this email because you are member of ' . GYMNAME . '.</p></td>
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
				</table>');
        $mailParameters = array(
            "server" => mt_rand(0, 2),
            "target_host" => explode("@", $fields["EMAIL"])[1],
            "to" => $fields["EMAIL"],
            "title" => GYMNAME,
            "subject" => GYMNAME . " :: Congrats you have successfully registered.",
            "message" => $message,
            "message_type" => "Reset"
        );
        Alert($mailParameters);
    }
}
?>