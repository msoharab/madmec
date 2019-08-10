<?php

class profile {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public static function fetchAdminDetails() {
        $query = 'SELECT 
					c.`cnumber`,
					b.`email_pk`,
					c.`cnumber_pk`,
					b.`email_ids`,
					a.`user_name`,
					a.`password`,
					a.`id`,
					a.`photo_id`,
					   CASE WHEN p.`ver2` IS NULL
						THEN "' . USER_ANON_IMAGE . '"
						ELSE CONCAT("' . URL . DIRS . '",p.`ver2`)
				   END AS photo
					FROM `user_profile` AS a
					LEFT JOIN `photo` AS p ON p.`id` = a.`photo_id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(em.`id`) AS email_pk,
							GROUP_CONCAT(em.`email`) AS email_ids,
							em.`user_pk`
						FROM `email_ids` AS em
						WHERE em.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
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
						WHERE cn.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
						GROUP BY (cn.`user_pk`)
						ORDER BY (cn.`user_pk`)
					) AS c ON a.`id` = c.`user_pk`
					WHERE a.`user_name`="' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) . '"
					AND a.`password`="' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_PASS"]) . '"
					AND a.`id`="' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]) . '"';
        //print_r($query);
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $row = mysql_fetch_assoc($res);
            $admin_email_id = explode(",", $row["email_pk"]);
            $admin_cnum_id = explode(",", $row["cnumber_pk"]);
            $admin_email = explode(",", $row["email_ids"]);
            $admin_cnumber = explode(",", $row["cnumber"]);
            $USER_LOGIN_DATA = array(
                "USER_PASS" => $row["password"],
                "USER_ID" => $row["id"],
                "USER_NAME" => $row["user_name"],
                "USER_PHOTO" => $row["photo"],
                "PHOTO_ID" => $row["photo_id"],
                "USER_EMAIL_ID" => $admin_email_id,
                "USER_CNUM_ID" => $admin_cnum_id,
                "USER_EMAIL" => $admin_email,
                "USER_C" => $admin_cnumber,
            );
            $_SESSION["profileData"] = $USER_LOGIN_DATA;
        }
        return $_SESSION["profileData"];
    }

    public function LoadAdminDetails() {
        $result = false;
        $htm = '';
        $admin_id = $_SESSION["USER_LOGIN_DATA"]["USER_ID"];
        $USER_LOGIN_DATA = profile::fetchAdminDetails();
        /* Email */
        $email = $cnumber = '';
        $email_no = $cnum_no = -1;
        if (is_array($USER_LOGIN_DATA["USER_EMAIL"])) {
            $flag = false;
            for ($j = 0; $j < sizeof($USER_LOGIN_DATA["USER_EMAIL"]) && isset($USER_LOGIN_DATA["USER_EMAIL"][$j]) && $USER_LOGIN_DATA["USER_EMAIL"][$j] != ''; $j++) {
                $flag = true;
                $email .= '<li>' . ltrim($USER_LOGIN_DATA["USER_EMAIL"][$j], ',') . '</li>';
                $email_no++;
            }
            if (!$flag) {
                $email = '<li>Not Provided</li>';
            }
        }
        /* Cell Number */
        if (is_array($USER_LOGIN_DATA["USER_C"])) {
            $flag = false;
            for ($j = 0; $j < sizeof($USER_LOGIN_DATA["USER_C"]) && isset($USER_LOGIN_DATA["USER_C"][$j]) && $USER_LOGIN_DATA["USER_C"][$j] != ''; $j++) {
                $flag = true;
                $cnumber .= '<li>' . ltrim($USER_LOGIN_DATA["USER_C"][$j], ',') . '</li>';
                $cnum_no++;
            }
            if (!$flag) {
                $cnumber = '<li>Not Provided</li>';
            }
        }
        $htm .= '
		<form action="control.php" name="changePic" id="changePic" method="post" enctype="multipart/form-data">
		<fieldset>
			<input type="hidden" name="formid" value="changePic" />
			<input type="hidden" name="action1" value="picChange" />
			<input type="hidden" name="autoloader" value="true" />
			<input type="hidden" name="uid" value="' . $admin_id . '" />
			<input type="hidden" name="type" value="master" />
		<div class="modal" id="myModal_pf" tabindex="-1" role="dialog" aria-labelledby="myModal_pf_Label_' . $admin_id . '" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content" style="color:#000;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title" id="myModal_pf_Label_' . $admin_id . '">Change Picture</h4>
						</div>
						<div class="modal-body">
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
							<button type="submit" name="submit" class="btn btn-success" id="addusrBut" >Change Picture</button>
							<button type="button" class="btn btn-success" data-dismiss="modal" id="picCancel">Cancel</button>
						</div>
					</div>
				</div>
			</div>
			</fieldset>
		</form>
		';
        $htm .= '<div class="row">
				<div class="col-lg-12">&nbsp;</div>
					<div class="col-lg-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4>Photo</h4>
							</div>
							<div class="panel-body" id="usrphoto_">
								<img src="' . $USER_LOGIN_DATA["USER_PHOTO"] . '" width="150" />
							</div>
						    <div class="panel-footer">
								<button type="button" class="btn btn-primary btn-md" id="usr_but_pf" title="Flag" data-toggle="modal" data-target="#myModal_pf"><i class="fa fa-edit fa-fw "></i> Change Picture</button>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-green">
							<div class="panel-heading">
								<h4>Email Ids</h4>
							</div>
							<div class="panel-body" id="usremail_">
								<ul>' . $email . '</ul>
							</div>
							<div class="panel-footer" style="display:none">
								<button type="button" class="btn btn-success btn-md"  id="usremail_but_edit"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
								<button type="button" class="btn btn-success btn-md" id="usremail_but"><i class="fa fa-edit fa-fw "></i> Save</button>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4>Cell Numbers</h4>
							</div>
							<div class="panel-body" id="usrcnum_">
								<ul>' . $cnumber . '</ul>
							</div>
							<div class="panel-footer" style="display:none">
								<button type="button" class="btn btn-primary btn-md" id="usrcnum_but_edit"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
								<button type="button" class="btn btn-primary btn-md" id="usrcnum_but"><i class="fa fa-edit fa-fw "></i> Save</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">&nbsp;</div>
					<div class="col-lg-4">
						<div class="panel panel-green">
							<div class="panel-heading">
								<h4>Change Password</h4>
							</div>
							<div class="panel-body" id="profile_pwd">
								<label id="pass_msg">To change password click below button</label>
								<div id="pass_toggle" style="display:none">
									<div class="col-lg-12">Change Password:</div>
										<div class="col-lg-12">
											<input class="form-control" type="password" id="oldpassword" placeholder="Old Password"/>
											<div class="help-block"  id="oldpwd_msg">&nbsp;</div>
										</div>
										<div class="col-lg-12">
											<input class="form-control" type="password" id="newpassword" placeholder="New Password"/>
											<p class="help-block"  id="newpwd_msg">&nbsp;</p>
										</div>
										<div class="col-lg-12">
											<input class="form-control" type="password" id="confirmpassword" placeholder="Confirm Password"/>
											<p class="help-block"  id="confirm_msg">Press enter or go button to Change Password.</p>
										</div>
									<br></br>
								</div>
							</div>
							<div class="panel-footer">
								<button type="button" class="btn btn-success btn-md" onClick="$(\'#pass_toggle\').show(300);$(\'#pass_msg\').html(\'\')" id="change_pwd_but"><i class="fa fa-edit fa-fw "></i>Change Password</button>&nbsp&nbsp
								<button type="button" class="btn btn-success btn-md" id="save_pwd_but"><i class="fa fa-edit fa-fw "></i> Save</button>
								<button type="button" class="btn btn-success btn-md" id="can_pwd_but" onClick="$(\'#pass_toggle\').hide(300);$(\'#change_pwd_but\').show(300);$(\'#save_pwd_but\').hide(300);$(this).hide(300);$(\'#pass_msg\').html(\'To change password click below button\')"><i class="fa fa-edit fa-fw "></i> Cancel</button>
							</div>
						</div>
					</div>
					
				</div>';
        $htm .= '<script>
				$(document).ready(function(){
					var editProfileEmailIds = {
						autoloader : true,
						action 	   : "loadEmailIdForm",
						outputDiv  : "#output",
						parentDiv  : "#usremail_",
						but  	   : "#usremail_but_edit",
						num   	   : ' . $email_no . ',
						form 	   : "email_id_",
						email 	   : "email_",
						msgDiv 	   : "email_msg_",
						plus 	   : "plus_email",
						minus 	   : "minus_email",
						saveBut	   : "usremail_but",
						closeBut   : "usremail_close",
						minu		: "usremail_close_",
						url 	   : window.location.href
					};
					var obj = new controlProfile();
					obj.editProfileEmailIds(editProfileEmailIds);	
					var editProfileCellNumbers = {
						autoloader : true,
						action 	   : "loadCellNumForm",
						outputDiv  : "#output",
						parentDiv  : "#usrcnum_",
						but  	   : "#usrcnum_but_edit",
						num   	   : ' . $cnum_no . ',
						form 	   : "cnum_id_",
						cnumber	   : "cnum_",
						msgDiv 	   : "cnum_msg_",
						plus 	   : "plus_cnum",
						minus 	   : "minus_cnum",
						saveBut	   : "usrcnum_but",
						closeBut   : "usrcnum_close",
						url 	   : window.location.href
					};
					var obj = new controlProfile();
					obj.editProfileCellNumbers(editProfileCellNumbers);
					
					var editChangePassword = {
						outputDiv  : "#output",
						parentDiv  : "#profile_pwd",
						but  	   : "#change_pwd_but",
						oldpwd	   : "#oldpassword",
						newpwd	   : "#newpassword",
						confirmpwd : "#confirmpassword",
						divtoggle  : "#pass_toggle",
						msgdiv	   : "#pass_msg",
						oldmsg	   : "oldpwd_msg",
						newmsg	   : "newpwd_msg",
						confirmmsg : "confirmpwd_msg",
						saveBut	   : "#save_pwd_but",
						canBut	   : "#can_pwd_but",
						url 	   : window.location.href
					};
					var obj = new controlProfile();
					obj.editChangePassword(editChangePassword);
				});	
		  </script>';
        $admindetails = array(
            "htm" => (string) $htm,
        );

        echo json_encode($admindetails);
    }

    public function profileEmailIdForm() {
        $_SESSION["profileData"] = profile::fetchAdminDetails();
        $html = '';
        $emailHTM = '';
        $emailids = array(
            "oldemail" => array(),
            "html" => NULL
        );
        if (is_array($_SESSION["profileData"])) {
            $flag = false;
            for ($j = 0; $j < sizeof($_SESSION["profileData"]["USER_EMAIL"]) && isset($_SESSION["profileData"]["USER_EMAIL"][$j]) && $_SESSION["profileData"]["USER_EMAIL"][$j] != ''; $j++) {
                $emailids["oldemail"][$j] = array(
                    "id" => $_SESSION["profileData"]["USER_EMAIL_ID"][$j],
                    "value" => ltrim($_SESSION["profileData"]["USER_EMAIL"][$j], ','),
                    "form" => $this->parameters["form"] . $j,
                    "textid" => $this->parameters["email"] . $j,
                    "msgid" => $this->parameters["msgDiv"] . $j,
                    "deleteid" => $this->parameters["email"] . $j . '_delete',
                    "deleteOk" => 'deleteEmlOk_' . $j,
                    "deleteCancel" => 'deleteEmlCancel_' . $j
                );
                $emailHTM .= '<div id="' . $emailids["oldemail"][$j]["form"] . '">
							<div class="form-group input-group">
							<input class="form-control" placeholder="Email Id"  type="text" id="' . $emailids["oldemail"][$j]["textid"] . '" maxlength="100" value="' . ltrim($_SESSION["profileData"]["USER_EMAIL"][$j], ',') . '" />
							<span class="input-group-addon">
								<button type="button" class="btn btn-danger btn-circle" id="' . $emailids["oldemail"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myEmailModal_' . $j . '">
									<i class="fa fa-trash fa-fw "></i>
								</button>
								<div class="modal fade" id="myEmailModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myEmailModalLabel_' . $j . '" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myEmailModalLabel_' . $j . '">Delete Email Id</h4>
								</div>
								<div class="modal-body">
								Do You really want to delete <strong>' . ltrim($_SESSION["profileData"]["USER_EMAIL"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $emailids["oldemail"][$j]["deleteOk"] . '">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="' . $emailids["oldemail"][$j]["deleteCancel"] . '">Cancel</button>
								</div>
								</div>
								</div>
								</div>
							</span>
							</div>
							<div class="col-lg-16" id="' . $emailids["oldemail"][$j]["form"] . '">
								<p class="help-block" id="' . $emailids["oldemail"][$j]["msgid"] . '">Valid.</p>
							</div>
						</div>';
            }
        }
        $html = '<div class="col-lg-16">Add extra :
						<button type="button" class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus "></i></button>
						<button type="button" class="btn btn-success btn-circle" id="' . $this->parameters["minus"] . '"><i class="fa fa-minus fa-fw "></i></button>
						<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button></div>
					<br></br><div class="col-lg-16">' . str_replace($this->order, $this->replace, $emailHTM) . '</div>';
        $emailids["html"] = $html;

        return $emailids;
    }

    public function editProfileEmailId() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $_SESSION["profileData"]["USER_ID"];
        /* Emails Insert */
        if (isset($this->parameters["emailids"]["insert"]) && is_array($this->parameters["emailids"]["insert"]) && sizeof($this->parameters["emailids"]["insert"]) > -1 && $user_pk > 0) {
            $query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status` ) VALUES';
            for ($i = 0; $i < sizeof($this->parameters["emailids"]["insert"]); $i++) {
                if ($i == sizeof($this->parameters["emailids"]["insert"]) - 1)
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',4);';
                else
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',4),';
            }
            executeQuery($query);
            $flag = true;
        }
        /* Emails Update */
        if (isset($this->parameters["emailids"]["update"]) && is_array($this->parameters["emailids"]["update"]) && sizeof($this->parameters["emailids"]["update"]) > -1 && $user_pk > 0) {
            for ($i = 0; $i < sizeof($this->parameters["emailids"]["update"]); $i++) {
                $query = 'UPDATE  `email_ids`
						 SET `email` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["email"]) . '\'
						 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["id"]) . '\';';
                executeQuery($query);
            }
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function deleteProfileEmailId() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Emails Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `email_ids`
					 SET `status` = 6
					 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listProfileEmailIds() {
        $_SESSION["profileData"] = profile::fetchAdminDetails();
        $flag = false;
        if (is_array($_SESSION["profileData"])) {
            $flag = true;
            $emailHTM = '';
            for ($j = 0; $j < sizeof($_SESSION["profileData"]["USER_EMAIL"]) && isset($_SESSION["profileData"]["USER_EMAIL"][$j]) && $_SESSION["profileData"]["USER_EMAIL"][$j] != ''; $j++) {
                $emailHTM .= '<ul><li>' . ltrim($_SESSION["profileData"]["USER_EMAIL"][$j], ',') . '</li></ul>';
            }
        }
        if (!$flag) {
            $emailHTM .= '<ul><li>Not Provided</li></ul>';
        }
        return $emailHTM;
    }

    public function loadProfileCellNumForm() {
        $_SESSION["profileData"] = profile::fetchAdminDetails();
        $html = '';
        $cnumHTM = '';
        $cnums = array(
            "oldcnums" => array(),
            "html" => NULL
        );
        if (is_array($_SESSION["profileData"])) {
            $flag = false;
            for ($j = 0; $j < sizeof($_SESSION["profileData"]["USER_C"]) && isset($_SESSION["profileData"]["USER_C"][$j]) && $_SESSION["profileData"]["USER_C"][$j] != ''; $j++) {
                $cnums["oldcnums"][$j] = array(
                    "id" => $_SESSION["profileData"]["USER_CNUM_ID"][$j],
                    "value" => ltrim($_SESSION["profileData"]["USER_C"][$j], ','),
                    "form" => $this->parameters["form"] . $j,
                    "textid" => $this->parameters["cnumber"] . $j,
                    "msgid" => $this->parameters["msgDiv"] . $j,
                    "deleteid" => $this->parameters["cnumber"] . $j . '_delete',
                    "deleteOk" => 'deleteCellOk_' . $j,
                    "deleteCancel" => 'deleteCellCancel_' . $j
                );
                $cnumHTM .= '<div id="' . $cnums["oldcnums"][$j]["form"] . '">
							<div class="form-group input-group">
							<input class="form-control" placeholder="Email Id"  type="text" id="' . $cnums["oldcnums"][$j]["textid"] . '" maxlength="100" value="' . ltrim($_SESSION["profileData"]["USER_C"][$j], ',') . '" />
							<span class="input-group-addon">
								<button type="button" class="btn btn-danger btn-circle" id="' . $cnums["oldcnums"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myPfCellModal_' . $j . '">
									<i class="fa fa-trash fa-fw "></i>
								</button>
								<div class="modal fade" id="myPfCellModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myPfCellModalLabel_' . $j . '" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myPfCellModalLabel_' . $j . '">Delete Email Id</h4>
								</div>
								<div class="modal-body">
								Do You really want to delete <strong>' . ltrim($_SESSION["profileData"]["USER_C"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $cnums["oldcnums"][$j]["deleteOk"] . '">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="' . $cnums["oldcnums"][$j]["deleteCancel"] . '">Cancel</button>
								</div>
								</div>
								</div>
								</div>
							</span>
							</div>
							<div class="col-lg-16" id="' . $cnums["oldcnums"][$j]["form"] . '">
								<p class="help-block" id="' . $cnums["oldcnums"][$j]["msgid"] . '">Valid.</p>
							</div>
						</div>';
            }
        }
        $html = '<div class="col-lg-16">Add extra :
					<button type="button" class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus "></i></button>
					<button type="button" class="btn btn-success btn-circle" id="' . $this->parameters["minus"] . '"><i class="fa fa-minus fa-fw "></i></button>
					<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button></div>
				<br></br><div class="col-lg-16">' . str_replace($this->order, $this->replace, $cnumHTM) . '</div>';
        $cnums["html"] = $html;
        return $cnums;
    }

    public function editProfileCellNum() {
        $_SESSION["profileData"] = profile::fetchAdminDetails();
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $_SESSION["profileData"]["USER_ID"];
        /* Cell Numbers Insert */
        if (isset($this->parameters["CellNums"]["insert"]) && is_array($this->parameters["CellNums"]["insert"]) && sizeof($this->parameters["CellNums"]["insert"]) > -1 && $user_pk > 0) {
            $query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_number`,`status`) VALUES';
            for ($i = 0; $i < sizeof($this->parameters["CellNums"]["insert"]); $i++) {
                if ($i == sizeof($this->parameters["CellNums"]["insert"]) - 1)
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',4);';
                else
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',4),';
            }
            executeQuery($query);
            executeQuery('UPDATE `user_profile` SET `cell_number`= \'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][0]) . '\'
								WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
            $flag = true;
        }
        /* Cell Numbers Update */
        if (isset($this->parameters["CellNums"]["update"]) && is_array($this->parameters["CellNums"]["update"]) && sizeof($this->parameters["CellNums"]["update"]) > -1 && $user_pk > 0) {
            for ($i = 0; $i < sizeof($this->parameters["CellNums"]["update"]); $i++) {
                $query = 'UPDATE  `cell_numbers`
							 SET `cell_number` = \'' . mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["cnumber"]) . '\'
							 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["id"]) . '\';';
                executeQuery($query);
            }
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listProfileCellNums() {
        $_SESSION["profileData"] = profile::fetchAdminDetails();
        $flag = false;
        if (is_array($_SESSION["profileData"])) {
            $flag = true;
            $cnumHTM = '';
            for ($j = 0; $j < sizeof($_SESSION["profileData"]["USER_C"]) && isset($_SESSION["profileData"]["USER_C"][$j]) && $_SESSION["profileData"]["USER_C"][$j] != ''; $j++) {
                $cnumHTM .= '<ul><li>' . ltrim($_SESSION["profileData"]["USER_C"][$j], ',') . '</li></ul>';
            }
        }
        if (!$flag) {
            $cnumHTM .= '<ul><li>Not Provided</li></ul>';
        }
        return $cnumHTM;
    }

    public function deleteProfileCellNum() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Emails Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `cell_numbers`
					 SET `status` = 6
					 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function editChangePwd() {
        $_SESSION["profileData"] = profile::fetchAdminDetails();
        $admin_id = $_SESSION["USER_LOGIN_DATA"]["USER_ID"];
        $flag = false;
        if ($this->parameters["oldpwd"] == $_SESSION["profileData"]["USER_PASS"]) {
            if ($this->parameters["newpwd"] == $this->parameters["confirmpwd"]) {
                $query = 'UPDATE `user_profile` SET `password` = "' . $this->parameters["newpwd"] . '", `apassword` = MD5("' . $this->parameters["newpwd"] . '") WHERE `user_profile`.`id` = ' . $admin_id;
                executeQuery($query);
                $flag = true;
            }
        }
        return $flag;
    }

    public static function fetchGymDetails($id = false) {
        $gym_id = $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_ID"];
        $query = 'SELECT 
					c.`cnumber`,
					b.`email_pk`,
					c.`cnumber_pk`,
					b.`email_ids`,
					a.*,
					CASE WHEN p.`ver2` IS NULL
						THEN "' . USER_ANON_IMAGE . '"
						ELSE CONCAT("' . URL . DIRS . '",p.`ver2`)
				   END AS photo
					FROM `gym_profile` AS a
					LEFT JOIN `gym_photo` AS p ON p.`id` = a.`photo_id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(em.`id`) AS email_pk,
							GROUP_CONCAT(em.`email`) AS email_ids,
							em.`user_pk`
						FROM `gym_email_ids` AS em
						WHERE em.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
						GROUP BY (em.`user_pk`)
						ORDER BY (em.`user_pk`)
						) AS b ON b.`user_pk` = a.`id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(cn.`id`) AS cnumber_pk,
							cn.`user_pk`,
							/* GROUP_CONCAT(CONCAT(cn.`cell_code`,"-",cn.`cell_number`)) AS cnumber */
							GROUP_CONCAT(cn.`cell_number`) AS cnumber
						FROM `gym_cell_numbers` AS cn
						WHERE cn.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
						GROUP BY (cn.`user_pk`)
						ORDER BY (cn.`user_pk`)
					) AS c ON a.`id` = c.`user_pk`
					WHERE a.`id`="' . mysql_real_escape_string($gym_id) . '"';

        $res = executeQuery($query);
        if (get_resource_type($res) == 'mysql result') {
            if (mysql_num_rows($res) > 0) {
                $row = mysql_fetch_assoc($res);
                $admin_email_id = explode(",", $row["email_pk"]);
                $admin_cnum_id = explode(",", $row["cnumber_pk"]);
                $admin_email = explode(",", $row["email_ids"]);
                $admin_cnumber = explode(",", $row["cnumber"]);
                $USER_DATA = array(
                    "USER_ID" => $row["id"],
                    "GYM_NAME" => $row["gym_name"],
                    "USER_PHOTO" => $row["photo"],
                    "directory" => $row["directory"],
                    "photo_id" => $row["photo_id"],
                    "USER_EMAIL_ID" => $admin_email_id,
                    "USER_CNUM_ID" => $admin_cnum_id,
                    "USER_EMAIL" => $admin_email,
                    "USER_C" => $admin_cnumber,
                    "COUNTRY" => $row["country"],
                    "PROVINCE" => $row["province"],
                    "DISTRICT" => $row["district"],
                    "CITY" => $row["city"],
                    "TOWN" => $row["town"],
                    "ADDRESSLINE" => $row["addressline"],
                    "ZIPCODE" => $row["zipcode"],
                    "WEBSITE" => $row["website"],
                    "GMAPHTML" => $row["gmaphtml"],
                );
            } else {
                echo "Please update your Gym address and details.<div style=''><a href='javascript:void(0);' id='edit_gym'>Update</a></div>";
            }
        }
        return $USER_DATA;
    }

    public function LoadGymDetails($id = false) {
        $USER_DATA = profile::fetchGymDetails($id);
        $htm = '';
        $email = $cnumber = '';
        $email_no = $cnum_no = -1;
        if (is_array($USER_DATA["USER_EMAIL"])) {
            $flag = false;
            for ($j = 0; $j < sizeof($USER_DATA["USER_EMAIL"]) && isset($USER_DATA["USER_EMAIL"][$j]) && $USER_DATA["USER_EMAIL"][$j] != ''; $j++) {
                $flag = true;
                $email .= '<li>' . ltrim($USER_DATA["USER_EMAIL"][$j], ',') . '</li>';
                $email_no++;
            }
            if (!$flag) {
                $email = '<li>Not Provided</li>';
            }
        }
        /* Cell Number */
        if (is_array($USER_DATA["USER_C"])) {
            $flag = false;
            for ($j = 0; $j < sizeof($USER_DATA["USER_C"]) && isset($USER_DATA["USER_C"][$j]) && $USER_DATA["USER_C"][$j] != ''; $j++) {
                $flag = true;
                $cnumber .= '<li>' . ltrim($USER_DATA["USER_C"][$j], ',') . '</li>';
                $cnum_no++;
            }
            if (!$flag) {
                $cnumber = '<li>Not Provided</li>';
            }
        }
        $htm .= '<form action="control.php" name="changePic" id="changePic" method="post" enctype="multipart/form-data">
				 <fieldset>
				 <input type="hidden" name="formid" value="changePic" />
				   	 <input type="hidden" name="action1" value="picChangeGYM" />
					 <input type="hidden" name="autoloader" value="true" />
					  <input type="hidden" name="type" value="master" />
					 <input type="hidden" name="uid" value="' . $id . '"/>
					 <div class="modal" id="myModal_Photo" tabindex="-1" role="dialog" aria-labelledby="myModal_Photo_Label_' . $USER_DATA["USER_ID"] . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div class="modal-content" style="color:#000;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModal_Photo_Label_' . $USER_DATA["USER_ID"] . '">Change Photo</h4>
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
								<button type="button" class="btn btn-success" data-dismiss="modal" id="photoCancel">Cancel</button>
							</div>
						</div>
					</div>
				</div>
				 </fieldset>
			  </form>';
        $htm .= '<br />
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<center><h4>' . ucfirst($USER_DATA["GYM_NAME"]) . '</h4></center>
					</div>
				 </div>
			</div>
		</div>
		<div class="col-lg-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4>Photo</h4>
					</div>
					<div class="panel-body" id="usrphoto_">
						<img src="' . $USER_DATA["USER_PHOTO"] . '" width="150" />
					</div>
					<div class="panel-footer">
						<button class="btn btn-primary btn-md" id="photo_but_edit"  data-toggle="modal" data-target="#myModal_Photo"><i class="fa fa-edit fa-fw "></i>Change Img</button>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="panel panel-green">
					<div class="panel-heading">
						<h4>Email Ids</h4>
					</div>
					<div class="panel-body" id="usremail_">
						<ul>' . $email . '</ul>
					</div>
					<div class="panel-footer" style="display:none;">
						<button class="btn btn-success btn-md"  id="usremail_but_edit"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
						<button class="btn btn-success btn-md" id="usremail_but"><i class="fa fa-edit fa-fw "></i> Save</button>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4>Cell Numbers</h4>
					</div>
					<div class="panel-body" id="usrcnum_">
						<ul>' . $cnumber . '</ul>
					</div>
					<div class="panel-footer" style="display:none;">
						<button class="btn btn-primary btn-md" id="usrcnum_but_edit"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
						<button class="btn btn-primary btn-md" id="usrcnum_but"><i class="fa fa-edit fa-fw "></i> Save</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">&nbsp;</div>
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">
								<h3>Address</h3>
							</div>
							<div class="panel-body" id="pf_usradd" style="display:block;">
								<ul>
									<li><strong>Address line :</strong>' . $USER_DATA["ADDRESSLINE"] . '</li>
									<li><strong>Street / Locality :</strong>' . $USER_DATA["TOWN"] . '</li>
									<li><strong>City / Town :</strong>' . $USER_DATA["CITY"] . '</li>
									<li><strong>District / Department :</strong>' . $USER_DATA["DISTRICT"] . '</li>
									<li><strong>State / Provice :</strong>' . $USER_DATA["PROVINCE"] . '</li>
									<li><strong>Country :</strong>' . $USER_DATA["COUNTRY"] . '</li>
									<li><strong>Zipcode :</strong>' . $USER_DATA["ZIPCODE"] . '</li>
									<li><strong>Website :</strong>' . $USER_DATA["WEBSITE"] . '</li>
									<li><strong>Google Map :</strong>' . $USER_DATA["GMAPHTML"] . '</li>
								</ul>
							</div>
					<div class="panel-body" id="pf_usradd_edit" style="display:none;">
								<form id="pf_user_address_edit_form">
								<!-- Country -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"></span> Country  :<i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Country" name="country" type="text" id="pf_country" maxlength="100" value="' . $USER_DATA["COUNTRY"] . '"/>
										<p class="help-block" id="pf_comsg">&nbsp;</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- State / Province -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"></span> State / Province  :<i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="State / Province" name="province" type="text" id="pf_province" maxlength="150" value="' . $USER_DATA["PROVINCE"] . '"/>
										<p class="help-block" id="pf_prmsg">&nbsp;</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- District / Department -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"></span> District / Department  :<i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="District / Department" name="district" type="text" id="pf_district" maxlength="100" value="' . $USER_DATA["DISTRICT"] . '"/>
										<p class="help-block" id="pf_dimsg">&nbsp;</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- City / Town -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"></span> City / Town  :<i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="City / Town" name="city_town" type="text" id="pf_city_town" maxlength="100" value="' . $USER_DATA["CITY"] . '"/>
										<p class="help-block" id="pf_citmsg">&nbsp;</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Street / Locality -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"></span> Street / Locality  :<i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Street / Locality" name="st_loc" type="text" id="pf_st_loc" maxlength="100" value="' . $USER_DATA["TOWN"] . '"/>
										<p class="help-block" id="pf_stlmsg">&nbsp;</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Address Line -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"></span> Address Line  :<i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Address Line" name="addrs" type="text" id="pf_addrs" maxlength="200" value="' . $USER_DATA["ADDRESSLINE"] . '"/>
										<p class="help-block" id="pf_admsg">&nbsp;</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Zipcode -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"></span> Zipcode  :<i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Zipcode" name="zipcode" type="text" id="pf_zipcode" maxlength="25" value="' . $USER_DATA["ZIPCODE"] . '"/>
										<p class="help-block" id="pf_zimsg">&nbsp;</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Personal Website -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"></span> Personal Website  :<i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Personal Website" name="website" type="text" id="pf_website" maxlength="250" value="' . $USER_DATA["WEBSITE"] . '"/>
										<p class="help-block" id="pf_wemsg">&nbsp;</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Google Map URL -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"></span> Google Map URL  :<i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Google Map URL" name="gmaphtml" type="text" id="pf_gmaphtml" value="' . $USER_DATA["GMAPHTML"] . '"/>
										<p class="help-block" id="pf_gmmsg">Press enter or go button to update user address.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Update -->
								<div class="row">
									<div class="col-lg-12">&nbsp;</div>
									<div class="col-lg-12 text-center">
										<button type="button" class="btn btn-primary btn-md" id="pf_usr_address_update_but"><i class="fa fa-upload fa-fw "></i> Update</button>
										&nbsp;<button type="button" class="btn btn-primary btn-md" id="pf_usr_address_close_but"><i class="fa fa-close fa-fw "></i> Close</button>
									</div>
								</div>
								</form>
							</div>
							<div class="panel-footer" style="display:none"><button type="button" class="btn btn-primary btn-md" id="pf_usraddr_but_edit"><i class="fa fa-edit fa-fw "></i> Edit</button></div>
						</div>
						</div>
			</div>
			
		</div>';

        $gymprofile = array(
            "htm" => (string) $htm,
        );

        echo json_encode($gymprofile);

        /* $htm .= '<script>
          $(document).ready(function(){

          var editProfileUserAddress = {
          pfautoloader 		: true,
          pfaction 	   		: "loadAddressForm",
          pfgymid				: "#gym_id",
          pfoutputDiv  		: "#pf_output",
          pfshowDiv 			: "#pf_usradd",
          pfupdateDiv 		: "#pf_usradd_edit",
          pfbut	   			: "#pf_usraddr_but_edit",
          pfsaveBut	   		: "#pf_usr_address_update_but",
          pfcloseBut   		: "#pf_usr_address_close_but",
          pfform 	   			: "#pf_usrbankname_form",
          pfcountry 			: "#pf_country",
          pfcountryCode 		: null,
          pfcountryId 		: null,
          pfcomsg 			: "#pf_comsg",
          pfprovince 			: "#pf_province",
          pfprovinceCode		: null,
          pfprovinceId 		: null,
          pfprmsg 			: "#pf_prmsg",
          pfdistrict 			: "#pf_district",
          pfdistrictCode		: null,
          pfdistrictId 		: null,
          pfdimsg 			: "#pf_dimsg",
          pfcity_town 		: "#pf_city_town",
          pfcity_townCode		: null,
          pfcity_townId 		: null,
          pfcitmsg 			: "#pf_citmsg",
          pfst_loc 			: "#pf_st_loc",
          pfst_locCode 		: null,
          pfst_locId 			: null,
          pfstlmsg 			: "#pf_stlmsg",
          pfaddrs 			: "#pf_addrs",
          pfadmsg 			: "#pf_admsg",
          pfzipcode 			: "#pf_zipcode",
          pfzimsg 			: "#pf_zimsg",
          pfwebsite 			: "#pf_website",
          pfwemsg 			: "#pf_wemsg",
          pftphone 			: "#pf_telephone",
          pfgmaphtml 			: "#pf_gmaphtml",
          pfgmmsg 			: "#pf_gmmsg",
          pflat 				: null,
          pflon 				: null,
          pftimezone 			: null,
          pfPCR_reg 			: null,
          pfurl				: URL+"address.php",
          pfUpdateurl			: window.location.href
          };
          var obj = new controlProfile();
          obj.editGYMAddress(editProfileUserAddress);
          });
          </script>'; */
    }

    public function changeGYMPic($fl) {
        $gym_id = $this->parameters["usrid"];
        $users = profile::fetchGymDetails($gym_id);
        $target_dir = DOC_ROOT . DIRS . $users["directory"] . "/profile/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $fn = explode(".", basename($_FILES["file"]["name"]));
        $ext = $fn[(sizeof($fn)) - 1];
        $fname = $target_dir . md5(generateRandomString()) . "." . $ext;
        $dbpath = str_replace(DOC_ROOT . DIRS, "", $fname);
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
        if ($_FILES["file"]["size"] > 500000) {
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
                executeQuery('UPDATE `gym_photo` SET `ver2`= \'' . mysql_real_escape_string($dbpath) . '\'
										WHERE `id` = \'' . mysql_real_escape_string($users["photo_id"]) . '\'');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        //----------------- FILE DATA OVER 
    }

    public function editProfileAddress() {
        $flag = false;
        $id = mysql_real_escape_string($this->parameters["gymid"]);
        $gym_id = $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_ID"];
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Profile Address */
        $query = 'UPDATE  `gym_profile`  
				SET `addressline` = \'' . mysql_real_escape_string($this->parameters["addrsline"]) . '\',
					`town` = \'' . mysql_real_escape_string($this->parameters["st_loc"]) . '\',
					`city` = \'' . mysql_real_escape_string($this->parameters["city_town"]) . '\',
					`district` = \'' . mysql_real_escape_string($this->parameters["district"]) . '\',
					`province` = \'' . mysql_real_escape_string($this->parameters["province"]) . '\',
					`province_code` = \'' . mysql_real_escape_string($this->parameters["provinceCode"]) . '\',
					`country` = \'' . mysql_real_escape_string($this->parameters["country"]) . '\',
					`country_code` = \'' . mysql_real_escape_string($this->parameters["countryCode"]) . '\',
					`zipcode` = \'' . mysql_real_escape_string($this->parameters["zipcode"]) . '\',
					`website` = \'' . mysql_real_escape_string($this->parameters["website"]) . '\',
					`latitude` = \'' . mysql_real_escape_string($this->parameters["lat"]) . '\',
					`longitude` = \'' . mysql_real_escape_string($this->parameters["lon"]) . '\',
					`timezone` = \'' . mysql_real_escape_string($this->parameters["timezone"]) . '\',
					`gmaphtml` = \'' . mysql_real_escape_string($this->parameters["gmaphtml"]) . '\'
				WHERE `id` = ' . $gym_id;
        $flag = executeQuery($query);
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listProfileAddress() {
        $id = mysql_real_escape_string($this->parameters["gymid"]);
        $addDataFull = profile::fetchGymDetails($id);
        $gymadd = $addDataFull["data"];
        $flag = false;
        if (is_array($gymadd)) {
            $flag = true;
            $addrHTM = '';
            $addrHTM .= '<ul>
									<li><strong>Address line :</strong>' . $gymadd["addressline"] . '</li>
									<li><strong>Street / Locality :</strong>' . $gymadd["town"] . '</li>
									<li><strong>City / Town :</strong>' . $gymadd["city"] . '</li>
									<li><strong>District / Department :</strong>' . $gymadd["district"] . '</li>
									<li><strong>State / Provice :</strong>' . $gymadd["province"] . '</li>
									<li><strong>Country :</strong>' . $gymadd["country"] . '</li>
									<li><strong>Zipcode :</strong>' . $gymadd["zipcode"] . '</li>
									<li><strong>Website :</strong>' . $gymadd["website"] . '</li>
									<li><strong>Google Map :</strong>' . $gymadd["gmaphtml"] . '</li>
							</ul>';
        }
        return $addrHTM;
    }

    public function addProfile() {
        $user_pk = 0;
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
        $db_host = mysql_real_escape_string($this->parameters["db_host"]);
        $db_user = mysql_real_escape_string($this->parameters["db_user"]);
        $db_name = mysql_real_escape_string($this->parameters["db_name"]);
        $db_pass = mysql_real_escape_string($this->parameters["db_pass"]);
        if (mysql_real_escape_string($this->parameters["type"]) == "main")
            $type = "main";
        else if (mysql_real_escape_string($this->parameters["type"]) == "branch")
            $type = "branch";
        /* Photo */
        $query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
					NULL,NULL,NULL,NULL,NULL,NULL);';
        if (executeQuery($query)) {
            /* Profile */
            $query1 = 'INSERT INTO  `gym_profile` (`id`, 
						`gym_name`,
						`gym_type`,
						`db_host`,
						`db_username`,
						`db_name`, 
						`db_password`, 
						`short_logo`, 
						`header_logo`,
						`postal_code`, 
						`telephone`, 
						`directory`, 
						`currency_code`, 
						`reg_fee`, 
						`service_tax`, 
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
						`gmaphtml`, 
						`status`)
					
					VALUES(
						NULL,
						\'' . mysql_real_escape_string($this->parameters["name"]) . '\',
						\'' . $type . '\',
						\'' . mysql_real_escape_string($db_host) . '\',
						\'' . mysql_real_escape_string($db_user) . '\',
						\'' . mysql_real_escape_string($db_name) . '\',
						\'' . mysql_real_escape_string($db_pass) . '\',  
						NULL,
						NULL,
						\'' . mysql_real_escape_string($this->parameters["pcode"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["tphone"]) . '\',
						NULL,
						NULL,
						\'' . mysql_real_escape_string($this->parameters["fee"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["tax"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["addrsline"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["st_loc"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["city_town"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["district"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["province"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["provinceCode"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["country"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["countryCode"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["zipcode"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["website"]) . '\',
						NULL,
						NULL,
						NULL,
						NULL,
						4)';
            if (executeQuery($query1)) {
                $user_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                /* emails */
                if (is_array($this->parameters["email"]) && sizeof($this->parameters["email"]) > -1) {
                    $query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status` ) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["email"]); $i++) {
                        if ($i == sizeof($this->parameters["email"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',4);';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',4),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `gym_profile` SET `email`= \'' . mysql_real_escape_string($this->parameters["email"][0]) . '\'
										WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
                }
                /* cell_numbers */
                if (is_array($this->parameters["cellnumbers"]) && sizeof($this->parameters["cellnumbers"]) > -1) {
                    $query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_code`,`cell_number`,`status`) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["cellnumbers"]); $i++) {
                        if ($i == sizeof($this->parameters["cellnumbers"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
										\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]) . '\',
										\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]) . '\',
										4);';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
										\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]) . '\',
										\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]) . '\',
										4),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `user_profile` SET `cell_code`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["codep"]) . '\',
											`cell_number`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["nump"]) . '\'
										WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
                }
                $directory_user = createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $user_pk);
                executeQuery('UPDATE `gym_profile` SET `directory` = \'' . $directory_user . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
                executeQuery('CALL slaveDbCreate("' . $db_name . '")');
                $flag = true;
            }
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

}

?>
