<?php

class profile {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public static function adminProfile() {
        $query = 'SELECT
					c.`cnumber`,
					b.`email_pk`,
					c.`cnumber_pk`,
					b.`email_ids`,
					a.`user_name`,
					a.`password`,
					a.`id`,
					a.`user_type_id`,
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
						THEN "' . USER_ANON_IMAGE . '"
						ELSE CONCAT("' . URL . ASSET_DIR . '",p.`ver2`)
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
					WHERE a.`user_name`="' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) . '"
					AND a.`password`="' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_PASS"]) . '"
					AND a.`id`="' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]) . '"
					;';
        //print_r($query);
        $res = executeQuery($query);
        $_SESSION["profileData"]=false;
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
            $_SESSION["profileData"] = $USER_LOGIN_DATA;
        }
        return $_SESSION["profileData"];
    }

    function LoadProfile() {
        $USER_LOGIN_DATA = profile::adminProfile();
        /* Email */
//        $users=array();
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
        /* Cell number */
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
        echo '<form action="control.php" name="changePic" id="changePic" method="post" enctype="multipart/form-data">
				 <fieldset>
				 <input type="hidden" name="formid" value="changePic" />
				   	 <input type="hidden" name="action1" value="picChange" />
					 <input type="hidden" name="autoloader" value="true" />
					  <input type="hidden" name="type" value="master" />
					 <input type="hidden" name="uid" value="' . $USER_LOGIN_DATA["USER_ID"] . '"/>
					 <div class="modal" id="myModal_Photo" tabindex="-1" role="dialog" aria-labelledby="myModal_Photo_Label_' . $USER_LOGIN_DATA["USER_ID"] . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div class="modal-content" style="color:#000;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModal_Photo_Label_' . $USER_LOGIN_DATA["USER_ID"] . '">Flag User entry</h4>
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
        echo '<div class="col-lg-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4>Photo</h4>
							</div>
							<div class="panel-body" id="usrphoto_">
								<img src="' . $USER_LOGIN_DATA["USER_PHOTO"] . '" width="150" />
							</div>
							<div class="panel-footer">
								<button class="btn btn-primary btn-md" id="photo_but_edit"  data-toggle="modal" data-target="#myModal_Photo"><i class="fa fa-edit fa-fw "></i>Change Img</button>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-green">
							<div class="panel-heading">
								<h4>Email ids</h4>
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
								<h4>Cell numbers</h4>
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
											<div class="help-block"  id="oldpwd_msg">Press enter or go button to move to next field.</div>
										</div>
										<div class="col-lg-12">
											<input class="form-control" type="password" id="newpassword" placeholder="New Password"/>
											<p class="help-block"  id="newpwd_msg">Press enter or go button to move to next field.</p>
										</div>
										<div class="col-lg-12">
											<input class="form-control" type="password" id="confirmpassword" placeholder="Confirm Password"/>
											<p class="help-block"  id="confirm_msg">Press enter or go button to Change Password.</p>
										</div>
									<br></br>
								</div>
							</div>
							<div class="panel-footer">
								<button class="btn btn-success btn-md" onClick="$(\'#pass_toggle\').show(300);$(\'#pass_msg\').html(\'\')" id="change_pwd_but"><i class="fa fa-edit fa-fw "></i>Change Password</button>&nbsp&nbsp
								<button class="btn btn-success btn-md" id="save_pwd_but"><i class="fa fa-edit fa-fw "></i> Save</button>
								<button class="btn btn-success btn-md" id="can_pwd_but" onClick="$(\'#pass_toggle\').hide(300);$(\'#change_pwd_but\').show(300);$(\'#save_pwd_but\').hide(300);$(this).hide(300);$(\'#pass_msg\').html(\'To change password click below button\')"><i class="fa fa-edit fa-fw "></i> Cancel</button>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4>Address</h4>
							</div>
							<div class="panel-body" id="usradd" style="display:block;">
								<ul>
									<li><strong>Address line : </strong>' . $_SESSION["profileData"]["ADDRESSLINE"] . '</li>
									<li><strong>Street / Locality : </strong>' . $_SESSION["profileData"]["TOWN"] . '</li>
									<li><strong>City / Town : </strong>' . $_SESSION["profileData"]["CITY"] . '</li>
									<li><strong>District / Department : </strong>' . $_SESSION["profileData"]["DISTRICT"] . '</li>
									<li><strong>State / Provice : </strong>' . $_SESSION["profileData"]["PROVINCE"] . '</li>
									<li><strong>Country : </strong>' . $_SESSION["profileData"]["COUNTRY"] . '</li>
									<li><strong>Zipcode : </strong>' . $_SESSION["profileData"]["ZIPCODE"] . '</li>
									<li><strong>Website : </strong>' . $_SESSION["profileData"]["WEBSITE"] . '</li>
									<li><strong>Google Map : </strong>' . $_SESSION["profileData"]["GMAPHTML"] . '</li>
								</ul>
							</div>
							<div class="panel-body" id="usradd_edit" style="display:none;">
								<form id="user_address_edit_form">
								<!-- Country -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Country <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Country" name="country" type="text" id="country" maxlength="100" value="' . $_SESSION["profileData"]["COUNTRY"] . '"/>
										<p class="help-block" id="comsg">Press enter or go button to move to next field.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- State / Province -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> State / Province <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="State / Province" name="province" type="text" id="province" maxlength="150" value="' . $_SESSION["profileData"]["PROVINCE"] . '"/>
										<p class="help-block" id="prmsg">Press enter or go button to move to next field.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- District / Department -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> District / Department <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="District / Department" name="district" type="text" id="district" maxlength="100" value="' . $_SESSION["profileData"]["DISTRICT"] . '"/>
										<p class="help-block" id="dimsg">Press enter or go button to move to next field.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- City / Town -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> City / Town <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="City / Town" name="city_town" type="text" id="city_town" maxlength="100" value="' . $_SESSION["profileData"]["CITY"] . '"/>
										<p class="help-block" id="citmsg">Press enter or go button to move to next field.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Street / Locality -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Street / Locality <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Street / Locality" name="st_loc" type="text" id="st_loc" maxlength="100" value="' . $_SESSION["profileData"]["TOWN"] . '"/>
										<p class="help-block" id="stlmsg">Press enter or go button to move to next feild.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Address Line -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Address Line <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Address Line" name="addrs" type="text" id="addrs" maxlength="200" value="' . $_SESSION["profileData"]["ADDRESSLINE"] . '"/>
										<p class="help-block" id="admsg">Press enter or go button to move to next field.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Zipcode -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Zipcode <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Zipcode" name="zipcode" type="text" id="zipcode" maxlength="25" value="' . $_SESSION["profileData"]["ZIPCODE"] . '"/>
										<p class="help-block" id="zimsg">Press enter or go button to move to next field.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Personal Website -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Personal Website <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Personal Website" name="website" type="text" id="website" maxlength="250" value="' . $_SESSION["profileData"]["WEBSITE"] . '"/>
										<p class="help-block" id="wemsg">Press enter or go button to move to next field.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Google Map URL -->
								<div class="row">
									<div class="col-lg-12">
										<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Google Map URL <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input class="form-control" placeholder="Google Map URL" name="gmaphtml" type="text" id="gmaphtml" value="' . $_SESSION["profileData"]["GMAPHTML"] . '"/>
										<p class="help-block" id="gmmsg">Press enter or go button to update user address.</p>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Update -->
								<div class="row">
									<div class="col-lg-12">&nbsp;</div>
									<div class="col-lg-12 text-center">
										<button class="btn btn-primary btn-md" id="usr_address_update_but"><i class="fa fa-upload fa-fw "></i> Update</button>
										&nbsp;<button class="btn btn-primary btn-md" id="usr_address_close_but"><i class="fa fa-close fa-fw "></i> Close</button>
									</div>
								</div>
								</form>
							</div>
							<div class="panel-footer" style="display:none;">
								<button class="btn btn-primary btn-md" id="usraddr_but_edit"><i class="fa fa-edit fa-fw "></i> Edit</button>
							</div>
						</div>
					</div>

				</div>';
        echo '<script>
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
					var obj = new profileController();
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
					var obj = new profileController();
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
						url 	   : window.location.href
					};
					var obj = new profileController();
					obj.editChangePassword(editChangePassword);
					var editUserAddress = {
						autoloader 		: true,
						action 	   		: "loadAddressForm",
						outputDiv  		: "#output",
						showDiv 		: "#usradd",
						updateDiv 		: "#usradd_edit",
						but	   			: "#usraddr_but_edit",
						saveBut	   		: "#usr_address_update_but",
						closeBut   		: "#usr_address_close_but",
						form 	   		: "#usrbankname_form",
						country 		: "#country",
						countryCode 	: null,
						countryId 		: null,
						comsg 			: "#comsg",
						province 		: "#province",
						provinceCode	: null,
						provinceId 		: null,
						prmsg 			: "#prmsg",
						district 		: "#district",
						districtCode	: null,
						districtId 		: null,
						dimsg 			: "#dimsg",
						city_town 		: "#city_town",
						city_townCode	: null,
						city_townId 	: null,
						citmsg 			: "#citmsg",
						st_loc 			: "#st_loc",
						st_locCode 		: null,
						st_locId 		: null,
						stlmsg 			: "#stlmsg",
						addrs 			: "#addrs",
						admsg 			: "#admsg",
						zipcode 		: "#zipcode",
						zimsg 			: "#zimsg",
						website 		: "#website",
						wemsg 			: "#wemsg",
						tphone 			: "#telephone",
						gmaphtml 		: "#gmaphtml",
						gmmsg 			: "#gmmsg",
						lat 			: null,
						lon 			: null,
						timezone 		: null,
						PCR_reg 		: null,
						url				: URL+"address.php",
						Updateurl		: window.location.href
					};
					var obj = new profileController();
					obj.editUserAddress(editUserAddress);
				});
		  </script>';
    }

    public function profileEmailIdForm() {
        $_SESSION["profileData"] = profile::adminProfile();
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
							<input class="form-control" placeholder="Email ID"  type="text" id="' . $emailids["oldemail"][$j]["textid"] . '" maxlength="100" value="' . ltrim($_SESSION["profileData"]["USER_EMAIL"][$j], ',') . '" />
							<span class="input-group-addon">
								<button class="btn btn-danger btn-circle" id="' . $emailids["oldemail"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myEmailModal_' . $j . '">
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
						<button class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus "></i></button>
						<button class="btn btn-success btn-circle" id="' . $this->parameters["minus"] . '"><i class="fa fa-minus fa-fw "></i></button>
						<button class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button></div>
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
            $query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status_id` ) VALUES';
            for ($i = 0; $i < sizeof($this->parameters["emailids"]["insert"]); $i++) {
                if ($i == sizeof($this->parameters["emailids"]["insert"]) - 1)
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',4);';
                else
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',4),';
            }
            executeQuery($query);
            executeQuery('UPDATE `user_profile` SET `email`= \'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][0]) . '\'
							WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
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
					 SET `status_id` = 6
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
        $_SESSION["profileData"] = profile::adminProfile();
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

    public function editChangePwd() {
        $_SESSION["profileData"] = profile::adminProfile();
        $flag = false;
        if ($this->parameters["oldpwd"] == $_SESSION["profileData"]["USER_PASS"]) {
            if ($this->parameters["newpwd"] == $this->parameters["confirmpwd"]) {
                $query = 'UPDATE `user_profile` SET `password` = "' . $this->parameters["newpwd"] . '", `apassword` = MD5("' . $this->parameters["newpwd"] . '") WHERE `user_profile`.`id` = ' . $_SESSION["profileData"]["USER_ID"] . '';
//                executeQuery($query);
                session_destroy();
                $flag = true;
            }
        }
        return $flag;
    }

    public function loadProfileCellNumForm() {
        $_SESSION["profileData"] = profile::adminProfile();
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
							<input class="form-control" placeholder="Email ID"  type="text" id="' . $cnums["oldcnums"][$j]["textid"] . '" maxlength="100" value="' . ltrim($_SESSION["profileData"]["USER_C"][$j], ',') . '" />
							<span class="input-group-addon">
								<button class="btn btn-danger btn-circle" id="' . $cnums["oldcnums"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myEmailModal_' . $j . '">
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
					<button class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus "></i></button>
					<button class="btn btn-success btn-circle" id="' . $this->parameters["minus"] . '"><i class="fa fa-minus fa-fw "></i></button>
					<button class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button></div>
				<br></br><div class="col-lg-16">' . str_replace($this->order, $this->replace, $cnumHTM) . '</div>';
        $cnums["html"] = $html;
        return $cnums;
    }

    public function editProfileCellNum() {
        $_SESSION["profileData"] = profile::adminProfile();
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $_SESSION["profileData"]["USER_ID"];
        /* Cell Numbers Insert */
        if (isset($this->parameters["CellNums"]["insert"]) && is_array($this->parameters["CellNums"]["insert"]) && sizeof($this->parameters["CellNums"]["insert"]) > -1 && $user_pk > 0) {
            $query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_number`,`status_id`) VALUES';
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
        $_SESSION["profileData"] = profile::adminProfile();
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
					 SET `status_id` = 6
					 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function editProfileAddress() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Profile Address */
        $query = 'UPDATE  `user_profile`
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
				WHERE `id` = 1';
        $flag = executeQuery($query);
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listProfileAddress() {
        $_SESSION["profileData"] = profile::adminProfile();
        $flag = false;
        if (is_array($_SESSION["profileData"])) {
            $flag = true;
            $addrHTM = '';
            $addrHTM .= '<ul>
                <li><strong>Address line : </strong>' . $_SESSION["profileData"]['ADDRESSLINE'] . '</li>
                <li><strong>Street / Locality : </strong>' . $_SESSION["profileData"]['TOWN'] . '</li>
                <li><strong>City / Town : </strong>' . $_SESSION["profileData"]['CITY'] . '</li>
                <li><strong>District / Department : </strong>' . $_SESSION["profileData"]['DISTRICT'] . '</li>
                <li><strong>State / Provice : </strong>' . $_SESSION["profileData"]['PROVINCE'] . '</li>
                <li><strong>Country : </strong>' . $_SESSION["profileData"]['COUNTRY'] . '</li>
                <li><strong>Zipcode : </strong>' . $_SESSION["profileData"]['ZIPCODE'] . '</li>
                <li><strong>Website : </strong>' . $_SESSION["profileData"]['WEBSITE'] . '</li>
                <li><strong>Google Map : </strong>' . $_SESSION["profileData"]['GMAPHTML'] . '</li>
            </ul>';
        }
        return $addrHTM;
    }

}
?>
