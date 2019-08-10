<?php
require_once("config.php");
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);

function main() {
    if (!ValidateAdmin()) {
        session_destroy();
        header('Location:' . URL);
        exit(0);
    }
    /* elseif(isset($_POST['action']) && $_POST['action'] == 'dis_receipts'){
      $val = $_POST['val'];
      if($val == 'view'){
      DisAllReceipts($val);
      }else{
      DisReceipts();
      }
      unset($_POST);
      exit(0);
      } */ elseif (isset($_POST['action']) && $_POST['action'] == 'dis_receipts') {
        $val = $_POST['val'];
        if ($val == 'create') {
            DisReceipts();
        }
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'dis_receipts_scroll') {

        if (isset($_SESSION['patient']) && sizeof($_SESSION['patient']) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $para["initial"] = $_SESSION["initial"];
            $para["final"] = $_SESSION["final"];
            DisAllReceipts($para);
        } else {
            $para["initial"] = 0;
            $para["final"] = 0;
            DisAllReceipts($para);
            echo '<script language="javascript" >$(window).unbind();</script>';
        }


        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'dis_receipts_scroll_append' && $_POST['val'] != 'create') {

        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
            if (isset($_SESSION['patient']) && sizeof($_SESSION['patient']) > 0) {
                if ($_SESSION["final"] >= sizeof($_SESSION['patient'])) {
                    unset($_SESSION["initial"]);
                    unset($_SESSION["final"]);
                    echo '<script language="javascript" >$(window).unbind();</script>';
                } else {
                    $_SESSION["initial"] = $_SESSION["final"] + 1;
                    $_SESSION["final"] += 10;
                    $para["initial"] = $_SESSION["initial"];
                    $para["final"] = $_SESSION["final"];
                    DisAllReceiptsAppend($para);
                }
            }
        }


        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'load_tar_session') {
        $_SESSION['targets'] = LoadTarSession();
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'make_receipt') {
        MakeReceipt();
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'check_name_exist') {
        $result = CheckNameExist(strtolower($_POST['name']));
        echo $result;
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'load_all_receipts') {
        $_SESSION['patient'] = LoadAllReceipts();
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'auto_fill') {
        AutoFill($_POST['name']);
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'critical_action') {
        CriticalAction($_POST['id'], $_POST['val']);
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'update_patient') {
        UpdatePatient();
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'upload_image') {
        UploadImageDetails($_POST['val'], $_POST['tar_id']);
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'uploadpro_image') {
        UploadprofileImageDetails($_POST['val'], $_POST['tar_id']);
        unset($_POST);
        exit(0);
    }
}

function CriticalAction($id = false, $val = false) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            if ($val == 'edit') {
                $patient = $_SESSION['patient'];
                $end = sizeof($patient);
                for ($i = 0; $i < $end; $i++) {
                    if ($patient[$i]['id'] == $id) {
                        //$temp=explode("=",$patient[$i]['img_url']);
                        $patient[$i]['img_url'] = (($patient[$i]['img_url'] == "NOT PROVIDED")) ? PROFILE_IMG : $patient[$i]['img_url'];

                        echo '<div class="col-md-12">
									<div class="panel panel-warning">
										<div class="panel-heading">
										   Edit Patient
										</div>
										<div class="panel-body">
											<form role="form">
												<div class="row">
													<div class="col-lg-4" id="profiledata">
														<img class="pp" id="profile" src="' . $patient[$i]['img_url'] . '" height="120"></br></br>
														<div id="abcd">
															<button type="button" id="propic" class="btn btn-danger"><i class="fa fa-pencil"></i>&nbsp;Edit </button>
														</div>
													</div><!-- col-lg-4 -->
													<div class="col-lg-4" id="profilenewdata" style="display:none">
														<input type="file" id="newpics" name="newpics"></br>
														<div id="pri">
																<button type="button" id="imgupload" onclick="uploadprofile(\'pri\',\'' . $id . '\',\'newpics\');" class="btn btn-danger">Upload Image</button>
																<button type="button" id="imgcancle" class="btn btn-danger">cancel</button>
														</div>
													</div>

													<div class="col-lg-4">
															<div class="form-group">
																<span class="manditory">&nbsp</span>
																<label>Sur Name</label>
																<select id="pre_name" class="form-control" onchange="javascript:check_pre_name(this);">
																	<option value="Mr." value="Mr.">Mr</option>
																	<option value="Mrs." value="Mrs.">Mrs</option>
																	<option value="Miss." value="Miss.">Miss</option>
																	<option value="Dr." value="Dr.">Dr</option>
																	<option value="The" value="The ">The</option>
																</select>
																<script>
																		$("#pre_name option[value=\'' . $patient[$i]['pre_name'] . '\']").attr("selected","selected");
																</script>
																	<span class="text-danger" id="err_name">Invalid</span>
															</div>
													</div><!-- col-lg-4 -->

													<div class="col-lg-4">
														<div class="form-group">
															<span class="manditory">&nbsp</span>
															<label>&nbsp</label>
															<input id="name" name="name" type="text" class="form-control" placeholder="Name"  value="' . $patient[$i]['tar_name'] . '">
															<span class="text-danger" id="err_name">Invalid</span>
														</div>
													</div><!-- col-lg-4 -->
												</div><!-- row -->
												<hr />
										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label>User Type</label>
													<select id="user_type" class="form-control" READONLY>
															<option value="1" >Doctor</option>
															<option value="2" selected>Patient</option>
															<option value="3">Others</option>
													</select>
												</div>
											</div><!-- col-lg-4 -->
											<div class="col-lg-4">
												<div class="form-group">
													<label>Gender/Sex</label>
													<select id="sex" class="form-control">
														<option value="Male">Male</option>
														<option value="Female">Female</option>
													</select>
                                               <script>
                                                  $("#sex option[value=\'' . $patient[$i]['sex'] . '\']").attr("selected","selected");
                                               </script>
                                               </div>
                                                </div><!-- col-lg-4 -->
                                                <div class="col-lg-4">
                                               <div class="form-group">
														<label>Blood Group</label>
														<input id="bloodgroup" type="text" class="form-control" placeholder="AB+" value="' . $patient[$i]['bloodgroup'] . '">
														<span class="text-danger" id="err_bloodgroup">Invalid</span>
													</div>
															</div><!-- col-lg-4 -->
														</div><!-- row -->
														<div class="row">
															<div class="col-lg-4">
															   <div class="form-group">
																		<label>Date of Birth: </label>
																		<input type="text" id="dob" class="form-control" value="' . date("d-m-Y", strtotime($patient[$i]['dob'])) . '" >
																			<input type="hidden" id="altdob" value="' . date("Y-m-d", strtotime($patient[$i]['dob'])) . '" readonly>
																		<script type="text/javascript">
                                                                                                                                                                window.setTimeout(function(){
                                                                                                                                                                $("#dob").datepicker({
																					dateFormat: "dd-mm-yy",
																					altField: "#altdob",
																					altFormat: "yy-mm-dd",
                                                                                                                                                                        changeYear : true,
                                                                                                                                                                        changeMonth : true,
																				});
                                                                                                                                                                ),500);
																		</script>
																</div>
															</div><!-- col-lg-4 -->
															<div class="col-lg-4">
																<div class="form-group">
																	<label>Email Id</label>
																	<input id="email" type="text" class="form-control"  placeholder="abc@email.com" pattern="^.+@.+$" value="' . $patient[$i]['email'] . '" >
																	<span class="text-danger" id="err_email">Invalid</span>
																</div>
															</div><!-- col-lg-4 -->
															<div class="col-lg-4">
																<div class="form-group">
																		<label>Mobile Number</label>
																		<input id="mobile" type="text" class="form-control" placeholder="9900000000" value="' . $patient[$i]['phone'] . '" >
																		<span class="text-danger" id="err_mobile">Invalid</span>
																</div>
															</div><!-- col-lg-4 -->
														</div><!-- row -->

														<div class="form-group">
																<label id="res_at">Allergies</label>
																<textarea id="allergies" class="form-control"  placeholder="NILL" >' . $patient[$i]['allergies'] . '</textarea>
																<span class="text-danger" id="err_loc">Invalid</span>
														</div>
														<div class="form-group">
																<label id="res_at">Address</label>
																<textarea id="address"class="form-control"  placeholder="type Location" >' . $patient[$i]['address'] . '</textarea>
																<span class="text-danger" id="err_loc">Invalid</span>
														</div>
													<button id="make_receipt_btn" onclick="javasript:update_patient(' . $patient[$i]['id'] . ');" type="button" class="btn btn-danger form-control">Save Changes</button>
												</div>
											</form>
										</div>
									</div>
								</div>';
                    } else {
                        //dont print anything//
                    }
                }
            } elseif ($val == 'delete') {
                $query = "UPDATE `target` SET
					`status`= 'delete'
					WHERE
					`id` =  '" . mysql_real_escape_string($id) . "';";
                $res = executeQuery($query);
                if ($res) {
                    echo 'Patient Deleted Successfully';
                }
            } else {
                echo 'Error!!!';
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
}

function AutoFill($name) {
    $result = $_SESSION['targets'];
    foreach ($result as $key => $val) {
        if ($val['tar_name'] . ' - ' . $val['phone'] . ' - ' . $val['email'] === $name) {
            echo json_encode($val);
        }
    }
    exit(0);
}

function UpdatePatient() {
    $id = $_POST['id'];
    $pre_name = $_POST['pre_name'];
    $name = $_POST['name'];
    $user_type = $_POST['user_type'];
    $sex = $_POST['sex'];
    $bloodgroup = $_POST['bloodgroup'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $allergies = $_POST['allergies'];
    $address = $_POST['address'];
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $check_name = mysql_result(executeQuery("select count(*) from `target` where `tar_name` = '" . mysql_real_escape_string($name) . "'"), 0);
            if ($check_name) {
                echo $check_name;
                echo 'Patient name already exist please try agian with different user name';
                exit(0);
            }
            $query = "UPDATE `target` SET
                                `pre_name`='" . mysql_real_escape_string($pre_name) . "',
                                `tar_name`='" . mysql_real_escape_string($name) . "',
                                `address`='" . mysql_real_escape_string($address) . "',
                                `email`= '" . mysql_real_escape_string($email) . "',
                                `phone`='" . mysql_real_escape_string($mobile) . "'
                                WHERE
                                `id` = '" . mysql_real_escape_string($id) . "' ;
				";
            $res = executeQuery($query);
            if ($res) {
                $row_exist = mysql_result(executeQuery("SELECT count(*) FROM `user_details` WHERE `user_pk` = '" . mysql_real_escape_string($id) . "';"), 0);
                if ($row_exist) {
                    $query1 = "UPDATE `user_details` SET
                                        `bloodgroup`='" . mysql_real_escape_string($bloodgroup) . "',
                                        `dob`='" . mysql_real_escape_string($dob) . "',
                                        `sex`='" . mysql_real_escape_string($sex) . "',
                                        `allergies`='" . mysql_real_escape_string($allergies) . "'
                                        WHERE
                                        `user_pk` = '" . mysql_real_escape_string($id) . "' ;
                                        ";
                } else {
                    $query1 = "INSERT INTO `user_details`
                                        (`bloodgroup`, `dob`, `sex`, `allergies`)
                                        VALUES
                                        (
                                            '" . mysql_real_escape_string($bloodgroup) . "',
                                            '" . mysql_real_escape_string($dob) . "',
                                            '" . mysql_real_escape_string($sex) . "',
                                            '" . mysql_real_escape_string($allergies) . "'
                                        )
                                        WHERE
                                        `user_pk` = '" . mysql_real_escape_string($id) . "' ;
                                        ";
                }
                $res1 = executeQuery($query1);
                if ($res1)
                    echo 'Updated patient Successfully';
                else
                    echo 0;
            }
            else {
                echo 0;
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
}

function MakeReceipt() {
    $pre_name = $_POST['pre_name'];
    $name = strtolower($_POST['name']);
    $user_type = $_POST['user_type'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $loc = $_POST['loc'];
    $date_temp = explode("-", $_POST['dob']);
    $dob = $date_temp[2] . '-' . $date_temp[1] . '-' . $date_temp[0];
    $bloodgroup = $_POST['bloodgroup'];
    $sex = $_POST['sex'];
    $allergies = $_POST['allergies'];
    $dis = $_POST['dis'];

    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $check_name = mysql_result(executeQuery("select count(*) from `target` where `tar_name` = '" . mysql_real_escape_string($name) . "'"), 0);
            if ($check_name) {
                echo $check_name;
                echo "<h1>Patient name already exist please try agian with different user name</h1>";
                exit(0);
            }
            executeQuery("SET AUTOCOMMIT=0;");
            executeQuery("START TRANSACTION;");

            if (isset($_POST['target_id'])) {
                $tar_id = $_POST['target_id'];
                $res = true;
            } else {
                $query = "INSERT INTO `target`
					(`id`,`pre_name`, `tar_name`,`address`,`email`,`phone`,`user_type`, `date` )
					VALUES
					( null,'" . mysql_real_escape_string($pre_name) . "',
					'" . mysql_real_escape_string($name) . "',
					'" . mysql_real_escape_string($loc) . "',
					'" . mysql_real_escape_string($email) . "',
					'" . mysql_real_escape_string($mobile) . "',
					'" . mysql_real_escape_string($user_type) . "',
					NOW() ); ";
                $res = executeQuery($query);
                $tar_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            }
            if ($res) {
                $query1 = "INSERT INTO `user_details`
					(`user_pk`, `bloodgroup`, `dob`, `sex`, `allergies`,`disease`)
					VALUES
					('" . mysql_real_escape_string($tar_id) . "',
					'" . mysql_real_escape_string($bloodgroup) . "',
					'" . mysql_real_escape_string($dob) . "',
					'" . mysql_real_escape_string($sex) . "',
					'" . mysql_real_escape_string($allergies) . "',
					'" . mysql_real_escape_string($dis) . "'
					 ); ";
                $res1 = executeQuery($query1);
                if ($res1) {

                    echo '<h1 align="center">New Patient Added Successfully</h1>';
                    echo '<form>
                                                        <div id="treatment_img" >
                                                            <div class="form-group">
                                                                <h3> Patient Profile Photo</h3>
                                                                <hr />
                                                                <label>Select Image: </label><br/>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <input type="file" id="profile_img" name="profile_img" />
                                                                    </div>
                                                                    <div class="col-lg-6" id="pro_img_status">
                                                                        <button type="button" onclick="upload(\'pro_img_status\',\'' . $tar_id . '\',\'profile_img\');" class="btn btn-danger">Upload Images</button>
                                                                    </div>
                                                                </div>
                                                                <hr />
                                                            </div>
                                                        </div>
                                                    </form>';
                    executeQuery("COMMIT");
                    if (SEND_EMAIL == 'on')
                        Alert($email, $name, $towards, $recp);
                }
            }
            else {
                echo 0;
                executeQuery("ROLLBACK");
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
}

function UploadImageDetails($val, $tar_id) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $query = "INSERT INTO `profile_image`
                    (`tar_id`, `img_url`, `thumb_url`, `status_id`)
                    VALUES
                    (
                        '" . mysql_real_escape_string($tar_id) . "',
                        '" . mysql_real_escape_string($_SESSION['profile_img_details']['img_url']) . "',
                        '" . mysql_real_escape_string($_SESSION['profile_img_details']['thumb_url']) . "',
                        '" . mysql_real_escape_string('4') . "'
                    )";
            $res = executeQuery($query);
            unset($_SESSION['profile_img_details']);
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
}

function UploadprofileImageDetails($val, $tar_id) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $query1 = "SELECT id FROM `profile_image`
							WHERE
							`tar_id`='" . mysql_real_escape_string($tar_id) . "';
                 ";
            $res1 = executeQuery($query1);
            $console_php->log(mysql_num_rows($res1));
            if (mysql_num_rows($res1)) {
                $query = "UPDATE `profile_image` SET
									`img_url`= '" . mysql_real_escape_string($_SESSION['profile_img_details']['img_url']) . "',
									`thumb_url`='" . mysql_real_escape_string($_SESSION['profile_img_details']['thumb_url']) . "'
									WHERE
									`tar_id`='" . mysql_real_escape_string($tar_id) . "';
					 ";
                $console_php->log($query);
                $res = executeQuery($query);
            } else {
                $query = "INSERT INTO `profile_image` VALUES(NULL,
								'" . mysql_real_escape_string($tar_id) . "',
								'" . mysql_real_escape_string($_SESSION['profile_img_details']['img_url']) . "',
								'" . mysql_real_escape_string($_SESSION['profile_img_details']['thumb_url']) . "',
								4)
					 ";
                $console_php->log($query);
                $res = executeQuery($query);
            }
            unset($_SESSION['profile_img_details']);
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
}

function DisReceipts() {
    $targets = $_SESSION['targets'];
    $i = 0;
    $tar_names_arr = '';
    while ($i < sizeof($targets)) {
        if ($i == 0)
            $tar_names_arr = '"' . $targets[$i]['tar_name'] . ' - ' . $targets[$i]['phone'] . ' - ' . $targets[$i]['email'] . '"';
        else
            $tar_names_arr .= ',"' . $targets[$i]['tar_name'] . ' - ' . $targets[$i]['phone'] . ' - ' . $targets[$i]['email'] . '"';
        $i++;
    }
    echo '<div class="col-md-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                           Add New Patient
                        </div>
                        <div class="panel-body">
							<form role="form">
								<div class="form-group">
									<div class="row">
									  <div class="col-lg-2">

											<span class="manditory">*</span>
											<label>Sur Name</label>
										<select id="pre_name" class="form-control" onchange="javascript:check_pre_name(this);">
											<option value="Mr." selected>Mr</option>
											<option value="Mrs.">Mrs</option>
											<option value="Miss.">Miss</option>
											<option value="Dr.">Dr</option>
											<option value="The">The</option>
										</select>
									  </div><!-- /.col-lg-1 -->
									  <div class="col-lg-4">
                                          <span class="manditory">*</span>
                                          <label class="manditory">Name</label>
											<input id="name" name="name" type="text" class="form-control" onblur="javascript:auto_fill(this.value);" placeholder="Name">
									 		<script>
												$(function(){
													var availableTags = [' . $tar_names_arr . '];
													$( "#name" ).autocomplete({
														source: availableTags
													});
												});
											</script>
                                            <span class="text-danger" id="err_name">Invalid</span>
									  </div><!-- /.col-lg-4 -->
									  <div class="col-lg-2">
                                                                                        <div class="form-group">
                                                                                                <label>User Type</label>
                                                                                                <select id="user_type" class="form-control">
                                                                                                        <option value="1" >Doctor</option>
                                                                                                        <option value="2" selected>Patient</option>
                                                                                                        <option value="3">Others</option>
                                                                                                </select>
                                                                                        </div>
                                                                          </div><!-- /.col-lg-2 -->
									  <div class="col-lg-2">
                                                                                        <div class="form-group">
                                                                                                <label>Gender/Sex</label>
                                                                                                <select id="sex" class="form-control">
                                                                                                        <option value="Male">Male</option>
                                                                                                        <option value="Female">Female</option>
                                                                                                </select>
                                                                                        </div>
                                                                            </div><!-- /.col-lg-2 -->
									  <div class="col-lg-2">
                                                                                                        <div class="form-group">
														<label>Blood Group</label>
														<input id="bloodgroup" type="text" class="form-control" placeholder="AB+">
														<span class="text-danger" id="err_bloodgroup">Invalid</span>
													</div>
									  </div><!-- /.col-lg-2 -->



									</div><!-- /.row -->
									<span class="text-danger" id="err_name">Invalid</span>
								</div>




								<div id="user_details" style="display:none;">
                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                    <label>Date of Birth: </label>
                                                                                    <input type="text" id="dob" class="form-control" value="' . date("d-m-Y") . '" >
                                                                                    <script type="text/javascript">
                                                                                            $("#dob").datepicker({ dateFormat: "dd-mm-yy" ,changeMonth: true,
                                                                                                                    changeYear: true, maxDate : 0});
                                                                                    </script>
                                                                            </div>
                                                                        </div><!-- col-lg-4 -->
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <span class="manditory">*</span>
                                                                                <label class="manditory">Mobile Number</label>
                                                                                <input id="mobile" type="text" maxlength="10" onkeyDown="javascript:number_allow();" class="form-control" placeholder="9900000000">
                                                                                <span class="text-danger" id="err_mobile">Invalid</span>
                                                                        </div>
                                                                        </div><!-- col-lg-4 -->

                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
										<label>Email Id</label>
										<input id="email" type="text" class="form-control"  placeholder="abc@email.com" pattern="^.+@.+$">
										<span class="text-danger" id="err_email">Invalid</span>
                                                                            </div>
                                                                        </div><!-- col-lg-4 -->
                                                                    </div>






								    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
										<span class="manditory">*</span>
										<label class="manditory">Allergies</label>
										<textarea id="allergies"class="form-control"  placeholder="type allergies"></textarea>
										<span class="text-danger" id="err_allergies">Invalid</span>
                                                                            </div>
                                                                        </div><!-- col-lg-4 -->
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
										<span class="manditory">*</span>
										<label class="manditory">Associated Problems and Disease</label>
										<textarea id="dis" class="form-control"  placeholder="Diabeties,blood pressure, etc.."></textarea>
										<span class="text-danger" id="err_dis">Invalid</span>
                                                                            </div>
                                                                        </div><!-- col-lg-4 -->
                                                                        <div class="col-lg-4">

										<label>Address</label>
										<textarea id="loc"class="form-control"  placeholder="type Location"></textarea>
										<span class="text-danger" id="err_loc">Invalid</span>
                                                                            </div>
                                                                        </div><!-- col-lg-4 -->
                                                                    </div><!-- row -->
                                                                    <button id="make_receipt_btn" onclick="javasript:make_receipt();" type="button" class="btn btn-danger form-control">Save Changes</button>
								</div>
							</form>
                        </div>
                    </div>
                </div>';
}

function FecthRecNo() {
    $yy = date("Y");
    $mm = date("m");
    $sl_no = ($mm < 4) ? "FY" . ($yy - 1) . "R" : "FY" . ($yy) . "R";
    $query = "SELECT * FROM `receipt` ORDER BY `id` DESC LIMIT 1; ";
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $temp = explode("-", $row['rec_no']);
            if ($temp[0] != $sl_no) {
                $sl_no .= '-00001';
            } else {
                $sl_no .= "-" . sprintf("%05s", ++$temp[1]);
            }
        }
    } else {
        $sl_no .= '-00001';
    }
    return $sl_no;
}

function GetSrcAccount() {
    $result = '<option value="0">Cash</option>';
    $query = "SELECT * FROM `source` WHERE `status` = 'active' ORDER BY `id` DESC; ";
    $res = executeQuery($query);
    if (mysql_num_rows($res)) {
        while ($row = mysql_fetch_assoc($res)) {
            $result .= '<option value="' . $row['id'] . '">' . $row['src_ac_name'] . ' - ' . $row['src_ac_no'] . ' - ' . $row['src_branch'] . ' - ' . $row['src_ac_type'] . '</option>';
        }
    } else {
        echo 'No Accouts to be displayed,Please add new account.';
    }
    return $result;
}

function DisAllReceipts($val) {
    $patient = $_SESSION['patient'];
    $end = sizeof($patient);
    $parameters = $val;
    $num_posts = 0;
    if (isset($_SESSION['patient']) && $_SESSION['patient'] != NULL)
        $patient = $_SESSION['patient'];
    else
        $patient = NULL;
    if ($patient != NULL)
        $num_posts = sizeof($patient);
    //start for a search
    $patient = $_SESSION['patient'];
    $total_rec = '';
    $a = 0;
    while ($a < sizeof($patient)) {

        if ($a == 0)
            $total_rec = '"' . $patient[$a]['tar_name'] . ' - ' . $patient[$a]['phone'] . ' - ' . $patient[$a]['email'] . '"';
        else
            $total_rec .= ',"' . $patient[$a]['tar_name'] . ' - ' . $patient[$a]['phone'] . ' - ' . $patient[$a]['email'] . '"';
        $a++;
    }

    $total_rec1 = '';
    $b = 0;
    while ($b < sizeof($patient)) {

        if ($b == 0)
            $total_rec1 = '"' . $patient[$b]['phone'] . '"';
        else
            $total_rec1 .= ',"' . $patient[$b]['phone'] . '"';
        $b++;
    }

    $total_rec_email = '';
    $b = 0;

    while ($b < sizeof($patient)) {

        if ($b == 0)
            $total_rec_email = '"' . $patient[$b]['email'] . '"';
        else
            $total_rec_email .= ',"' . $patient[$b]['email'] . '"';
        $b++;
    }



    echo '
				<div class="row">
				<div class="col-md-12">
							<div class="col-md-9">
									<input id="name1" type="text" onKeyDown="javascript:if(event.keyCode==13 || event.keyCode==9)search_receipt_name(this.value);" class="form-control"   placeholder="Name/Mobile/email">
							</div>
							<!--<div class="col-md-3">
									<input id="mobile" type="text" onKeyDown="javascript:if(event.keyCode==13 || event.keyCode==9)search_receipt_mobile(this.value);" class="form-control"   placeholder="Search Mobile">
							</div>
							<div class="col-md-3">
									<input id="email" type="text"  onKeyDown="javascript:if(event.keyCode==13 || event.keyCode==9)search_receipt_email(this.value);" class="form-control"   placeholder="Search Email">
							</div>-->

					<div class="col-md-3">
						<button class="btn btn-danger" onclick="javascript:view_all_receipts();">
						<i class="fa fa-refresh"></i>
				 		Refersh
						</button>
					</div>

					</div>
				</div>

					<script>
						$(function() {
						var availableTags = [' . $total_rec . '];
						$( "#name1" ).autocomplete({
						source: availableTags

						});
						var availableTags1 = [' . $total_rec1 . '];
						$( "#mobile" ).autocomplete({
						source: availableTags1

						});
						var availableTags1 = [' . $total_rec_email . '];
						$( "#email" ).autocomplete({
						source: availableTags1

						});
					});
				</script>




				<br/>	';




    //end



    echo '<div class="row" >
                <div class="col-md-12" >
                    <div class="panel panel-info">
                        <div class="panel-heading">
							List patient
                        </div>
						<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" >
							<thead>
								<tr>
									<th width="10%">
										Profile Pic
									</th>
									<th>
										Name/Details
									</th>
									<th>
										Medical Details
									</th>
									<th>
										Critical Action
									</th>
								</tr>
							</thead>
							<tbody>
								';


    if ($num_posts > 0) {
        for ($i = $parameters["initial"]; $i < $parameters["final"] && $i < $num_posts; $i++) {
            $src_img = ($patient[$i]['img_url'] == "NOT PROVIDED") ? PROFILE_IMG : $patient[$i]['img_url'];
            //$temp=explode("=",$patient[$i]['img_url']);
            //$src_img = (($temp[(sizeof($temp))-1]=="") || ($patient[$i]['img_url'] == "NOT PROVIDED"))	? PROFILE_IMG : $patient[$i]['img_url'];

            echo '<tr>
                                    <td rowspan="2" align="center">
                                        <img src="' . $src_img . '" height="100">
                                    </td>
                                    <td rowspan="2">
                                            <strong style="color:#D9534F;">Name   : </strong><strong>' . $patient[$i]['pre_name'] . $patient[$i]['tar_name'] . '</strong><br />
                                            Sex  : ' . $patient[$i]['sex'] . '<br />
                                            Mobile : ' . $patient[$i]['phone'] . '<br />
                                            Email  : ' . $patient[$i]['email'] . '
                                    </td>
                                    <td rowspan="2">
                                            <strong style="color:#D9534F;">BloodGroup  : </strong><strong>' . $patient[$i]['bloodgroup'] . '</strong><br />
                                            <strong style="color:#D9534F;"> Associated problems/Disease  :</strong><strong> ' . $patient[$i]['disease'] . '</strong><br />
                                            Date of Birth : ' . $patient[$i]['dob'] . '
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" onclick="javasript:view_treatment(' . $patient[$i]['id'] . ');">
                                                <i class="fa fa-edit"></i>
                                                Dental History And Treatment
                                        </button>
                                    </td>
                                </tr>

                                </tr>

                                <tr>
                                    <!--<td>
                                         <strong style="color:#D9534F;">Balance Amount : </strong>
                                    </td>-->
                                    <td>
                                            <button class="btn btn-primary" onclick="javasript:critical_action(' . $patient[$i]['id'] . ',\'edit\');">
                                                    <i class="fa fa-edit"></i>
                                                     Edit
                                            </button>
                                            <button class="btn btn-danger" onclick="javasript:critical_action(' . $patient[$i]['id'] . ',\'delete\');">
                                                    <i class="fa fa-trash"></i>
                                                     Delete
                                            </button>
                                    </td>
				</tr>
		 		<tr><td colspan="3"></td></tr>';
        }
    } else {
        echo '				</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>';

        echo '<strong><h3 style="color:red;">No Result Found!!!!!!!!!!!!!!</h3></strong>';
    }
}

//Display the  append data function
function DisAllReceiptsAppend($val) {
    $patient = $_SESSION['patient'];
    $end = sizeof($patient);
    $parameters = $val;
    $num_posts = 0;
    if (isset($_SESSION['patient']) && $_SESSION['patient'] != NULL)
        $patient = $_SESSION['patient'];
    else
        $patient = NULL;
    if ($patient != NULL)
        $num_posts = sizeof($patient);

    echo '<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <table class="table table-striped table-bordered table-hover">
							<thead>

							</thead>
							<tbody>
								';

    if ($num_posts > 0) {
        for ($i = $parameters["initial"]; $i < $parameters["final"] && $i < $num_posts; $i++) {
            $src_img = ($patient[$i]['img_url'] == "NOT PROVIDED") ? PROFILE_IMG : $patient[$i]['img_url'];
            //$temp=explode("=",$patient[$i]['img_url']);
            //$src_img = (($temp[(sizeof($temp))-1]=="") || ($patient[$i]['img_url'] == "NOT PROVIDED"))	? PROFILE_IMG : $patient[$i]['img_url'];

            echo '<tr>
                                    <td rowspan="2" align="center">
                                        <img src="' . $src_img . '" height="100">
                                    </td>
                                    <td rowspan="2">
                                            <strong style="color:#D9534F;">Name   : ' . $patient[$i]['pre_name'] . $patient[$i]['tar_name'] . '</strong><br />
                                            Mobile : ' . $patient[$i]['phone'] . '<br />
                                            Email  : ' . $patient[$i]['email'] . '
                                    </td>
                                    <td rowspan="2">
                                            <strong style="color:#D9534F;">BloodGroup  : ' . $patient[$i]['bloodgroup'] . '</strong><br />
                                            Sex  : ' . $patient[$i]['sex'] . '<br />
                                            Date of Birth : ' . $patient[$i]['dob'] . '
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" onclick="javasript:view_treatment(' . $patient[$i]['id'] . ');">
                                                <i class="fa fa-edit"></i>
                                                Dental History And Treatment
                                        </button>
                                    </td>
                                </tr>

                                </tr>

                                <tr>
                                    <td>
                                            <button class="btn btn-primary" onclick="javasript:critical_action(' . $patient[$i]['id'] . ',\'edit\');">
                                                    <i class="fa fa-edit"></i>&nbsp;
                                                     Edit
                                            </button>
                                            <button class="btn btn-danger" onclick="javasript:critical_action(' . $patient[$i]['id'] . ',\'delete\');">
                                                    <i class="fa fa-trash"></i>
                                                     Delete
                                            </button>
                                    </td>
				</tr>
		 		<tr><td colspan="3"></td></tr>';
        }
    } else {
        echo '				</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>';

        echo '<strong><h3 style="color:red;">No Result Found!!!!!!!!!!!!!!</h3></strong>';
    }
}

function LoadTarSession() {
    $targets = array();
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $query = "SELECT * FROM `target` WHERE `status` = 'active' ;";
            $res = executeQuery($query);
            if (mysql_num_rows($res) > 0) {
                $i = 0;
                while ($row = mysql_fetch_assoc($res)) {
                    $targets[$i]['id'] = $row['id'];
                    $targets[$i]['pre_name'] = $row['pre_name'];
                    $targets[$i]['tar_name'] = $row['tar_name'];
                    $targets[$i]['address'] = $row['address'];
                    $targets[$i]['email'] = $row['email'];
                    $targets[$i]['phone'] = $row['phone'];
                    $i++;
                }
            } else {
                $targets = NULL;
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    return $targets;
}

function CheckNameExist($name) {
    $targets = $_SESSION['targets'];
    $i = 0;
    $tar_names_arr = '';
    while ($i < sizeof($targets)) {
        $tar_names_arr .= $targets[$i]['tar_name'] . "-";
        $i++;
    }
    $test = explode("-", $tar_names_arr);
    if (in_array($name, $test)) {
        $key = array_search($name, $test);
        $flag = $targets[$key]['id'];
    } else
        $flag = -1;
    return $flag;
}

function LoadAllReceipts() {
    $patient = array();
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            if (isset($_POST["name"])) {
                $name = explode("-", $_POST["name"]);
                $sub_query = ' AND 	(
                                        a.`tar_name` LIKE "%' . trim($name[0]) . '%"
                                        OR
                                        a.`phone` LIKE "%' . trim($name[0]) . '%"
                                        OR
                                        a.`email` LIKE "%' . trim($name[0]) . '%"
                                        )';
            } else {
                $sub_query = "";
            }
            $query = "
                                    SELECT a.*,
                                    CASE WHEN (b.bloodgroup IS NULL OR b.bloodgroup ='')
                                    THEN 'NOT PROVIDED'
                                    ELSE
                                    b.bloodgroup END AS bloodgroup,
                                    CASE WHEN (b.dob IS NULL OR b.dob ='')
                                    THEN 'NOT PROVIDED'
                                    ELSE
                                    b.dob END AS dob,
                                    CASE WHEN (b.sex IS NULL OR b.sex ='')
                                    THEN 'NOT PROVIDED'
                                    ELSE
                                    b.sex END AS sex,
                                    CASE WHEN (b.allergies IS NULL OR b.allergies ='')
                                    THEN 'NOT PROVIDED'
                                    ELSE
                                    b.allergies END AS allergies,
                                    CASE WHEN (b.disease IS NULL OR b.disease ='')
                                    THEN 'NOT PROVIDED'
                                    ELSE
                                    b.disease END AS disease,
                                    CASE WHEN (c.img_url IS NULL OR c.img_url ='')
                                    THEN 'NOT PROVIDED'
                                    ELSE
                                    c.img_url END AS img_url
                                    FROM `target` AS  a
                                    LEFT JOIN `user_details` AS b
                                    ON a.`id` = b.`user_pk`
                                    LEFT JOIN `profile_image` AS c
                                    ON c.`tar_id` = a.`id`
                                    WHERE
                                    a.`status` = 'active'
                                    AND
                                    a.`user_type` = '2'
                                    " . $sub_query . "
                                    ORDER BY a.`id` DESC
                                    ";
            $res = executeQuery($query);
            if (mysql_num_rows($res)) {
                $index = 0;
                while ($row = mysql_fetch_assoc($res)) {
                    $patient[$index]['id'] = $row['id'];
                    $patient[$index]['pre_name'] = $row['pre_name'];
                    $patient[$index]['tar_name'] = $row['tar_name'];
                    $patient[$index]['address'] = $row['address'];
                    $patient[$index]['email'] = $row['email'];
                    $patient[$index]['phone'] = $row['phone'];
                    $patient[$index]['dob'] = $row['dob'];
                    $patient[$index]['bloodgroup'] = $row['bloodgroup'];
                    $patient[$index]['sex'] = $row['sex'];
                    $patient[$index]['allergies'] = $row['allergies'];
                    $patient[$index]['disease'] = $row['disease'];
                    $patient[$index]['img_url'] = $row['img_url'];
                    $index++;
                }
            } else {
                $patient = NULL;
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    return $patient;
}

main();
?>
<?php include_once(DOC_ROOT . PHP . INC . "header.php"); ?>

<!-- /. NAV SIDE  -->
<div id="page-wrapper" >

    <div id="page-inner">

        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <button type="button" class="btn btn-warning btn-lg" onclick="javascript:dis_receipts('create')">Add New Paitent</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-info btn-lg" onclick="javascript:dis_receipts_scroll('view')">view Paitent</button>
            </div>
        </div>
        <hr/>
        <div id="rec_screen">
        </div>
        <!--Display the append data -->
        <div id="rec_screen_app">
        </div>
    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->

<?php include_once(DOC_ROOT . PHP . INC . "footer.php"); ?>
<script src="<?php echo URL . ASSET_JS; ?>config.js"></script>
<script src="<?php echo URL . ASSET_JS . DENTAL; ?>patient.js"></script>
<!-- DataTables JavaScript -->
<script>
                    $("#pat_nav").addClass("active-menu");
</script>
