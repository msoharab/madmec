<?php
class menu1 {
    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';
    private $statu = array();
    function __construct($para = false){
        $this->parameters=$para;
        $this->statu["undel"]=getStatusId("Undelete");
        $this->statu["del"]=getStatusId("delete");
        $this->statu["flag"]=getStatusId("flag");
        $this->statu["active"]=getStatusId("active");
    }
    // List user query
    public static function mmtable_list($para = false) {
        $idqr = $para["var"];
        $users = array();
        executeQuery('SET SESSION group_concat_max_len = 1000000;');
        $query = 'SELECT
                a.`id` AS usrid,
                a.`user_name`,
                a.`email_id` AS client_email,
                a.`acs_id`,
                a.`directory`,
                a.`password`,
                a.`dob`,
                a.`date_of_join`,
                CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "")
                    THEN "' . USER_ANON_IMAGE . '"
                    ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
                END AS usrphoto,
                a.`photo_id`,
                a.`status`,
                ut.`type`,
                b.`email_pk`  AS email_pk,
                b.`email` AS email,
                c.`cnumber_pk` AS cnumber_pk,
                c.`cnumber` AS cnumber,
                g.`gender_name`
            FROM `user_profile` AS a
            LEFT JOIN `photo` AS ph ON a.`photo_id` = ph.`id`
            LEFT JOIN (
                SELECT
                        GROUP_CONCAT(em.`id`,"☻☻♥♥☻☻") AS email_pk,
                        GROUP_CONCAT(em.`email`,"☻☻♥♥☻☻") AS email,
                        em.`user_pk`
                FROM `email_ids` AS em
                WHERE em.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
                GROUP BY (em.`user_pk`)
                ORDER BY (em.`user_pk`)
            )  AS b ON a.`id` = b.`user_pk`
            LEFT JOIN (
                SELECT
                        GROUP_CONCAT(cn.`id`,"☻☻♥♥☻☻") AS cnumber_pk,
                        cn.`user_pk`,
                        GROUP_CONCAT(CONCAT(cn.`cell_number`),"☻☻♥♥☻☻") AS cnumber
                        /* GROUP_CONCAT(cn.`cell_number`,"☻☻♥♥☻☻") AS cnumber */
                FROM `cell_numbers` AS cn
                WHERE cn.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
                GROUP BY (cn.`user_pk`)
                ORDER BY (cn.`user_pk`)
            ) AS c ON a.`id` = c.`user_pk`
            LEFT JOIN `gender` AS g ON a.`gender` = g.`id`
            RIGHT JOIN `userprofile_type` AS ust ON ust.`user_pk` = a.`id`
            LEFT JOIN user_type AS ut ON ust.`usertype_id` = ut.`id`
            WHERE ut.`type` = "MMAdmin" AND ut.`status`= (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
            AND a.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
                                                                `statu_name` = "Hide" OR
                                                                `statu_name` = "Delete" OR
                                                                `statu_name` = "Fired" OR
                                                                `statu_name` = "Inactive"))
                                                                ' . $idqr . ';';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            $users = mysql_fetch_assoc($res);
        }
        $total = sizeof($users);
        if ($total) {
            $users["email_pk"] = explode("☻☻♥♥☻☻", $users["email_pk"]);
            $users["cnumber_pk"] = explode("☻☻♥♥☻☻", $users["cnumber_pk"]);
            $users["email"] = explode("☻☻♥♥☻☻", $users["email"]);
            $users["cnumber"] = explode("☻☻♥♥☻☻", $users["cnumber"]);
            $_SESSION["list0f_client"] = $users;
        } else {
            $_SESSION["list0f_client"] = NULL;
        }
        return $users;
    }
    // edit on dataTable and edit interface for single edit client
    function editClient() {
        $user_id = $this->parameters["usrid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["usrid"] . ') LIMIT 1' : '';
        $clientQuery["var"] = $user_id;
        $users = menu1::mmtable_list($clientQuery);
        if (is_array($users)) {
            $email = $cnumber = '';
            $email_no = $cnum_no = 0;
            /* Email */
            if (is_array($users["email"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users["email"]) && isset($users["email"][$j]) && $users["email"][$j] != ''; $j++) {
                    $flag = true;
                    $email .= '<li>' . ltrim($users["email"][$j], ',') . '</li>';
                    $email_no++;
                }
                if (!$flag) {
                    $email = '<li>Not Provided</li>';
                }
            }
            /* Cell number */
            if (is_array($users["cnumber"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users["cnumber"]) && isset($users["cnumber"][$j]) && $users["cnumber"][$j] != ''; $j++) {
                    $flag = true;
                    $cnumber .= '<li>' . ltrim($users["cnumber"][$j], ',') . '</li>';
                    $cnum_no++;
                }
                if (!$flag) {
                    $cnumber = '<li>Not Provided</li>';
                    $cnum_no = -1;
                }
            }
            if (isset($users["usrid"]) && !empty($users["usrid"]) && $users["usrid"] != '') {
                echo '<!--<form action="control.php" name="changePic" id="changePic" method="post" enctype="multipart/form-data">
                    <fieldset>
                      <input type="hidden" name="formid" value="changePic" />
                      <input type="hidden" name="action1" value="picChange" />
                      <input type="hidden" name="autoloader" value="true" />
                      <input type="hidden" name="uid" value="' . $users["usrid"] . '" />
                      <input type="hidden" name="type" value="master" />
                      <div class="modal" id="myModal_pf" tabindex="-1" role="dialog" aria-labelledby="myModal_pf_Label_' . $users["usrid"] . '" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                          <div class="modal-content" style="color:#000;">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                              <h4 class="modal-title" id="myModal_pf_Label_' . $users["usrid"] . '">Change Picture</h4>
                            </div>
                            <div class="modal-body">
                              <div class="picedit_box">
                                <div class="picedit_message">
                                  <span class="picedit_control ico-picedit-close" data-action="hide_messagebox"></span>
                                  <div></div>
                                </div>
                                <div class="picedit_nav_box picedit_gray_gradient">
                                  <div class="picedit_pos_elements"></div>
                                  <div class="picedit_nav_elements">
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
                                    <div class="picedit_element">
                                      <span class="picedit_control picedit_action ico-picedit-insertpicture" title="Crop" data-action="crop_open"></span>
                                    </div>
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
                                  </div>
                                </div>
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
                                <div class="picedit_video">
                                  <video autoplay></video>
                                  <div class="picedit_video_controls">
                                    <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="take_photo"></span>
                                    <span class="picedit_control picedit_action ico-picedit-close" data-action="camera_close"></span>
                                  </div>
                                </div>
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
                            </div>
                            <div class="modal-footer">
                              <button type="submit" name="submit" class="btn btn-danger" id="addusrBut">Change Picture</button>
                              <button type="button" class="btn btn-danger" data-dismiss="modal" id="picCancel">Cancel</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </form>-->
                  <div class="row">
                    <div class="col-lg-12">&nbsp;</div>
                    <!--<div class="col-lg-4">
                      <div class="panel panel-green">
                        <div class="panel-heading">
                          <h4>Photo</h4>
                        </div>
                        <div class="panel-body" id="usrphoto_' . $users["usrid"] . '">
                          <img src="' . $users["usrphoto"] . '" width="150" />
                        </div>
                        <div class="panel-footer">
                          <button type="button" class="btn btn-danger btn-md" id="usr_but_pf_' . $users["usrid"] . '" title="Flag" data-toggle="modal" data-target="#myModal_pf"><i class="fa fa-edit fa-fw "></i> Change Picture</button>
                        </div>
                      </div>
                    </div>-->
                    <div class="col-lg-6">
                      <div class="panel panel-red">
                        <div class="panel-heading">
                          <h4>Email ids</h4>
                        </div>
                        <div class="panel-body" id="usremail_' . $users["usrid"] . '">
                          <ul>' . $email . '</ul>
                        </div>
                        <div class="panel-footer">
                          <button type="button" class="btn btn-danger btn-md" id="usremail_but_addd_' . $users["usrid"] . '"><i class="fa fa-plus fa-fw "></i> Add</button>&nbsp&nbsp
                          <button type="button" class="btn btn-danger btn-md" id="usremail_but_edit_' . $users["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
                          <button type="button" class="btn btn-danger btn-md" id="usremail_but_delt_' . $users["usrid"] . '"><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp&nbsp
                          <button type="button" class="btn btn-danger btn-md" style="display:none" id="usremail_but_' . $users["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Save</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="panel panel-red">
                        <div class="panel-heading">
                          <h4>Cell numbers</h4>
                        </div>
                        <div class="panel-body" id="usrcnum_' . $users["usrid"] . '">
                          <ul>' . $cnumber . '</ul>
                        </div>
                        <div class="panel-footer">
                          <button type="button" class="btn btn-danger btn-md" id="usrcnum_but_addd_' . $users["usrid"] . '"><i class="fa fa-plus fa-fw "></i> Add</button>&nbsp&nbsp
                          <button type="button" class="btn btn-danger btn-md" id="usrcnum_but_edit_' . $users["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
                          <button type="button" class="btn btn-danger btn-md" id="usrcnum_but_delt_' . $users["usrid"] . '"><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp&nbsp
                          <button type="button" class="btn btn-danger btn-md" style="display:none" id="usrcnum_but_' . $users["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <script>
                    $(document).ready(function() {
                      var alterUserEmailIds = {
                        autoloader: true,
                        action: "loadClientEmailId",
                        outputDiv: "#output",
                        parentDiv: "#usremail_' . $users["usrid"] . '",
                        addd: "#usremail_but_addd_' . $users["usrid"] . '",
                        edit: "#usremail_but_edit_' . $users["usrid"] . '",
                        delt: "#usremail_but_delt_' . $users["usrid"] . '",
                        num: Number(' . ($email_no-1) . '),
                        uid: "' . $users["usrid"] . '",
                        index: 0,
                        listindex: "list0f_client",
                        form: "email_id_' . $users["usrid"] . '_",
                        email: "email_' . $users["usrid"] . '_",
                        msgDiv: "email_msg_' . $users["usrid"] . '_",
                        plus: "plus_email_' . $users["usrid"] . '_",
                        minus: "minus_email_' . $users["usrid"] . '_",
                        saveBut: "usremail_but_' . $users["usrid"] . '",
                        closeBut: "usremail_close_' . $users["usrid"] . '",
                        url: window.location.href
                      };
                      var obj = new menu1();
                      obj.alterClientEmailIds(alterUserEmailIds);
                      var editUserCellNumbers = {
                        autoloader: true,
                        action: "loadCellNumForm",
                        outputDiv: "#output",
                        parentDiv: "#usrcnum_' . $users["usrid"] . '",
                        addd: "#usrcnum_but_addd_' . $users["usrid"] . '",
                        edit: "#usrcnum_but_edit_' . $users["usrid"] . '",
                        delt: "#usrcnum_but_delt_' . $users["usrid"] . '",
                        num: Number(' . ($cnum_no-1) . '),
                        uid: ' . $users["usrid"] . ',
                        index: 0,
                        listindex: "list0f_client",
                        form: "cnum_id_' . $users["usrid"] . '_",
                        cnumber: "cnum_' . $users["usrid"] . '_",
                        msgDiv: "cnum_msg_' . $users["usrid"] . '_",
                        plus: "plus_cnum_' . $users["usrid"] . '_",
                        minus: "minus_cnum_' . $users["usrid"] . '_",
                        saveBut: "usrcnum_but_' . $users["usrid"] . '",
                        closeBut: "usrcnum_close_' . $users["usrid"] . '",
                        url: window.location.href
                      };
                      var obj = new menu1();
                      obj.alterClientCellNumbers(editUserCellNumbers);
                    });
                  </script>';
            }
        } else {
            echo 'Invalid User Id';
        }
    }
    // edit email address
    function loadClientEmailIdEditForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = menu1::mmtable_list($clientQuery);
        $html = '';
        $emailHTM = 'Not Provided';
        $num_posts = 0;
        $email_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailids = array(
            "oldemail" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            if (is_array($users["email"])) {
                for ($j = 0; $j < sizeof($users["email"]) && isset($users["email"][$j]) && $users["email"][$j] != ''; $j++) {
                    $flag = true;
                    $emailids["oldemail"][$j] = array(
                        "id" => ltrim($users["email_pk"][$j], ','),
                        "value" => ltrim($users["email"][$j], ','),
                        "form" => $this->parameters["form"] . $j,
                        "textid" => $this->parameters["email"] . $j,
                        "msgid" => $this->parameters["msgDiv"] . $j,
                    );
                    $emailHTM .= '<div id="' . $emailids["oldemail"][$j]["form"] . '">
                            <div class="form-group">
                                <input class="form-control" placeholder="Email ID" name="' . $emailids["oldemail"][$j]["id"] . '" type="text" id="' . $emailids["oldemail"][$j]["textid"] . '" maxlength="100" value="' . ltrim($users["email"][$j], ',') . '" />
                                    <p class="help-block" id="' . $emailids["oldemail"][$j]["msgid"] . '">Valid.</p>
                            </div>
                    </div>';
                    $email_no++;
                }
            }
            $html = '<div class="col-lg-12 text-right">&nbsp;<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '">
                        <i class="fa fa-close fa-fw "></i></button>
                    </div>
                    <div class="col-lg-12">&nbsp;</div><div class="class="col-lg-12">' . str_replace($this->order, $this->replace, $emailHTM) . '</div>';
            $emailids["html"] = $html;
            $emailids["num"] = $email_no;
        }
        return $emailids;
    }
    function loadClientEmailIdDeltForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = menu1::mmtable_list($clientQuery);
        $html = '';
        $emailHTM = 'Not Provided';
        $num_posts = 0;
        $email_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailids = array(
            "oldemail" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            if (is_array($users["email"])) {
                for ($j = 0; $j < sizeof($users["email"]) && isset($users["email"][$j]) && $users["email"][$j] != ''; $j++) {
                    $flag = true;
                    $emailids["oldemail"][$j] = array(
                        "id" => ltrim($users["email_pk"][$j], ','),
                        "value" => ltrim($users["email"][$j], ','),
                        "form" => $this->parameters["form"] . $j,
                        "textid" => $this->parameters["email"] . $j,
                        "msgid" => $this->parameters["msgDiv"] . $j,
                        "deleteid" => $this->parameters["email"] . $j . '_delete',
                        "deleteOk" => 'deleteEmlOk_' . ltrim($users["email_pk"][$j], ',') . '_' . $j,
                        "deleteCancel" => 'deleteEmlCancel_' . ltrim($users["email_pk"][$j], ',') . '_' . $j
                    );
                    $emailHTM .= '<div id="' . $emailids["oldemail"][$j]["form"] . '">
                            <div class="form-group input-group">
                            <input class="form-control" placeholder="Email ID" name="' . $emailids["oldemail"][$j]["id"] . '" type="text" id="' . $emailids["oldemail"][$j]["textid"] . '" maxlength="100" value="' . ltrim($users["email"][$j], ',') . '" readonly="readonly"/>
                            <span class="input-group-addon">
                                    <button type="button" class="btn btn-danger btn-circle" id="' . $emailids["oldemail"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myEmailModal_' . $j . '">
                                            <i class="fa fa-trash-o fa-fw"></i>
                                    </button>
                                    <div class="modal fade" id="myEmailModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myEmailModalLabel_' . $j . '" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                    <div class="modal-content" style="color:#000;">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myEmailModalLabel_' . $j . '">Delete Email Id</h4>
                                    </div>
                                    <div class="modal-body">
                                    Do You really want to delete <strong>' . ltrim($users["email"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $emailids["oldemail"][$j]["deleteOk"] . '">Ok</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="' . $emailids["oldemail"][$j]["deleteCancel"] . '">Cancel</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                            </span>
                            </div>
                    </div>';
                    $email_no++;
                }
            }
            $html = '<div class="col-lg-12 text-right">
                        &nbsp;<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
                </div><div class="col-lg-12">&nbsp;</div><div class="class="col-lg-12">' . str_replace($this->order, $this->replace, $emailHTM) . '</div>';
            $emailids["html"] = $html;
            $emailids["num"] = sizeof($users["email"]);
        }
        return $emailids;
    }
    function adddClientEmailId() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["emailids"]["uid"];
        /* Emails Insert */
        $query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status` ) VALUES';
        for ($i = 0; $i < sizeof($this->parameters["emailids"]["insert"]); $i++) {
            if ($i == sizeof($this->parameters["emailids"]["insert"]) - 1)
                $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
                                \'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',
                                \'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
            else
                $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
                            \'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',
                            \'' . mysql_real_escape_string($this->statu["undel"]) . '\'),';
        }
        if(executeQuery($query)){
            $flag = true;
			executeQuery('UPDATE `user_profile` SET `email_id`= \'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][0]) . '\'
							WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
		}
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }
    function editClientEmailId() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["emailids"]["uid"];
        for ($i = 0; $i < sizeof($this->parameters["emailids"]["update"]); $i++) {
            $query = 'UPDATE  `email_ids`
                SET `email` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["email"]) . '\'
                WHERE `id` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["id"]) . '\';';
            if(executeQuery($query))
                $flag = true;
            else{
                $flag = false;
                break;
            }
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }
    function deleteClientEmailId() {
        $flag = false;
        $del = getStatusId("delete");
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Emails Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `email_ids`
					 SET `status` = \'' . mysql_real_escape_string($del) . '\'
					 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }
    function listClientEmailIds() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = menu1::mmtable_list($clientQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailHTM = '<li>Not Provided</li>';
        if ($num_posts > 0) {
            if (is_array($users["email"]) && $users["email"][0] != '') {
                $emailHTM = '<ul>';
                for ($j = 0; $j <= sizeof($users["email"]) && isset($users["email"][$j]) && $users["email"][$j] != ''; $j++) {
                    $emailHTM .= '<li>' . ltrim($users["email"][$j], ',') . '</li>';
                }
                $emailHTM .= '</ul>';
            }
        }
        return $emailHTM;
    }
    //edit cell number
    function loadClientCellNumEditForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = menu1::mmtable_list($clientQuery);
        $html = '';
        $cnumHTM = 'Not Provided';
        $num_posts = 0;
		$cnum_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnums = array(
            "oldcnum" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            /* Cell numbers */
            if (is_array($users["cnumber"])) {
                for ($j = 0; $j < sizeof($users["cnumber"]) && isset($users["cnumber"][$j]) && $users["cnumber"][$j] != ''; $j++) {
                    $flag = true;
                    $cnums["oldcnum"][$j] = array(
                        "id" => ltrim($users["cnumber_pk"][$j], ','),
                        "value" => ltrim($users["cnumber"][$j], ','),
                        "form" => $this->parameters["form"] . $j,
                        "textid" => $this->parameters["cnumber"] . $j,
                        "msgid" => $this->parameters["msgDiv"] . $j
                    );
                    $cnumHTM .= '<div id="' . $cnums["oldcnum"][$j]["form"] . '">
                                <div class="form-group">
                                <input class="form-control" placeholder="Cell number" name="' . $cnums["oldcnum"][$j]["id"] . '" type="text" min="0" id="' . $cnums["oldcnum"][$j]["textid"] . '" maxlength="10" value="' . ltrim($users["cnumber"][$j], ',') . '" />
                                </div>
                                <div class="col-lg-12" id="' . $cnums["oldcnum"][$j]["form"] . '">
                                        <p class="help-block" id="' . $cnums["oldcnum"][$j]["msgid"] . '">Valid.</p>
                                </div>
                        </div>';
					$cnum_no++;
                }
            }
            $html = '<div class="col-lg-12 text-right">
                        &nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
                </div><div class="col-lg-12">&nbsp;</div><div class="class="col-lg-12">' . str_replace($this->order, $this->replace, $cnumHTM) . '</div>';
            $cnums["html"] = $html;
            $cnums["num"] = $cnum_no;
        }
        return $cnums;
    }
    function loadClientCellNumDeltForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = menu1::mmtable_list($clientQuery);
        $html = '';
        $cnumHTM = 'Not Provided';
        $num_posts = 0;
		$cnum_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnums = array(
            "oldcnum" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            /* Cell numbers */
            if (is_array($users["cnumber"])) {
                for ($j = 0; $j < sizeof($users["cnumber"]) && isset($users["cnumber"][$j]) && $users["cnumber"][$j] != ''; $j++) {
                    $flag = true;
                    $cnums["oldcnum"][$j] = array(
                        "id" => ltrim($users["cnumber_pk"][$j], ','),
                        "value" => ltrim($users["cnumber"][$j], ','),
                        "form" => $this->parameters["form"] . $j,
                        "textid" => $this->parameters["cnumber"] . $j,
                        "msgid" => $this->parameters["msgDiv"] . $j,
                        "deleteid" => $this->parameters["cnumber"] . $j . '_delete',
                        "deleteOk" => 'deleteCnumOk_' . ltrim($users["cnumber_pk"][$j], ',') . '_' . $j,
                        "deleteCancel" => 'deleteCnumCancel_' . ltrim($users["cnumber_pk"][$j], ',') . '_' . $j
                    );
                    $cnumHTM .= '<div id="' . $cnums["oldcnum"][$j]["form"] . '">
                                <div class="form-group input-group">
                                <input class="form-control" placeholder="Cell number" name="' . $cnums["oldcnum"][$j]["id"] . '" type="text" min="0" id="' . $cnums["oldcnum"][$j]["textid"] . '" maxlength="10" value="' . ltrim($users["cnumber"][$j], ',') . '" readonly="readonly" />
                                <span class="input-group-addon">
                                        <button type="button" class="btn btn-danger btn-circle" id="' . $cnums["oldcnum"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myCnumModal_' . $j . '">
                                                <i class="fa fa-trash-o fa-fw"></i>
                                        </button>
                                        <div class="modal fade" id="myCnumModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myCnumModalLabel_' . $j . '" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                        <div class="modal-content" style="color:#000;">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="myCnumModalLabel_' . $j . '">Delete Cell Number</h4>
                                        </div>
                                        <div class="modal-body">
                                        Do You really want to delete <strong>' . ltrim($users["cnumber"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $cnums["oldcnum"][$j]["deleteOk"] . '">Ok</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="' . $cnums["oldcnum"][$j]["deleteCancel"] . '">Cancel</button>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                </span>
                                </div>
                        </div>';
					$cnum_no++;
                }
            }
            $html = '<div class="col-lg-12 text-right">
                        &nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
                </div><div class="col-lg-12">&nbsp;</div><div class="class="col-lg-12">' . str_replace($this->order, $this->replace, $cnumHTM) . '</div>';
            $cnums["html"] = $html;
            $cnums["num"] = $cnum_no;
        }
        return $cnums;
    }
    function adddClientCellNum() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["CellNums"]["uid"];
        /* Cell Numbers Insert */
		$query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_number`,`status`) VALUES';
		for ($i = 0; $i < sizeof($this->parameters["CellNums"]["insert"]); $i++) {
			if ($i == sizeof($this->parameters["CellNums"]["insert"]) - 1)
				$query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
							\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',
							\'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
			else
				$query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
							\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',
							\'' . mysql_real_escape_string($this->statu["undel"]) . '\'),';
		}
		if(executeQuery($query)){
			$flag = true;
			executeQuery('UPDATE `user_profile` SET `cell_number`= \'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][0]) . '\'
							WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
		}
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }
    function editClientCellNum() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["CellNums"]["uid"];
        /* Cell Numbers Insert */
        if (isset($this->parameters["CellNums"]["insert"]) && is_array($this->parameters["CellNums"]["insert"]) && sizeof($this->parameters["CellNums"]["insert"]) > -1 && $user_pk > 0) {
            $query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_number`,`status`) VALUES';
            for ($i = 0; $i < sizeof($this->parameters["CellNums"]["insert"]); $i++) {
                if ($i == sizeof($this->parameters["CellNums"]["insert"]) - 1)
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
								\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',
								\'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
                else
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
								\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',
								\'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
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
    function deleteClientCellNum() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Emails Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `cell_numbers`
                        SET `status` = \'' . mysql_real_escape_string($this->statu["del"]) . '\'
                        WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }
    function listClientCellNums() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = menu1::mmtable_list($clientQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnumHTM = '<li>Not Provided</li>';
        if ($num_posts > 0) {
            if (is_array($users["cnumber"]) && $users["cnumber"][0] != '') {
                $cnumHTM = '<ul>';
                for ($j = 0; $j <= sizeof($users["cnumber"]) && isset($users["cnumber"][$j]) && $users["cnumber"][$j] != ''; $j++) {
                    $cnumHTM .= '<li>' . ltrim($users["cnumber"][$j], ',') . '</li>';
                }
                $cnumHTM .= '</ul>';
            }
        }
        return $cnumHTM;
    }
    //chnage pic
    function changeClientPic($fl) {
        $user_id = $this->parameters["usrid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["usrid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = menu1::mmtable_list($clientQuery);
        $users = $users[0];
        $target_dir = DOC_ROOT . ASSET_DIR . $users["directory"] . "/profile/";
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
                executeQuery('UPDATE `photo` SET `ver2`= \'' . mysql_real_escape_string($dbpath) . '\'
										WHERE `id` = \'' . mysql_real_escape_string($users["photo_id"]) . '\'');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        //----------------- FILE DATA OVER 
    }
    function editChangePwd(){
        $_SESSION["profileData"]=profile::fetchAdminDetails();
        $admin_id=$_SESSION["USER_LOGIN_DATA"]["USER_ID"];
        $flag = false;
        if($this->parameters["oldpwd"]==$_SESSION["profileData"]["USER_PASS"]){
                if($this->parameters["newpwd"]==$this->parameters["confirmpwd"]){
                        $query='UPDATE `user_profile` SET `password` = "'.$this->parameters["newpwd"].'", `apassword` = MD5("'.$this->parameters["newpwd"].'") WHERE `user_profile`.`id` = '.$admin_id;
                        executeQuery($query);
                        $flag = true;
                }
        }
        return $flag;
    }
    function editProfileAddress(){
            $flag = false;
            $id=mysql_real_escape_string($this->parameters["gymid"]);
            $gym_id=$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_ID"];
            executeQuery("SET AUTOCOMMIT=0;");
            executeQuery("START TRANSACTION;");
            /* Profile Address */
            $query = 'UPDATE  `gym_profile`  
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
                            WHERE `id` = '.$gym_id;
            require_once(DOC_ROOT.INC.'FirePHPCore/FirePHP.class.php');
            $console_php = FirePHP::getInstance(true);
            $console_php->log($query);
            $flag = executeQuery($query);
            if($flag){
                    executeQuery("COMMIT");
            }
            return $flag;
    }
    function listProfileAddress(){
            $id = mysql_real_escape_string($this->parameters["gymid"]);
            $addDataFull=profile::fetchGymDetails($id);
            $gymadd = $addDataFull["data"];
            $flag = false;
            if(is_array($gymadd)){
                $flag = true;
                $addrHTM  = '';
                $addrHTM .= '<ul>
                        <li><strong>Address line : </strong>'.$gymadd["addressline"].'</li>
                        <li><strong>Street / Locality : </strong>'.$gymadd["town"].'</li>
                        <li><strong>City / Town : </strong>'.$gymadd["city"].'</li>
                        <li><strong>District / Department : </strong>'.$gymadd["district"].'</li>
                        <li><strong>State / Provice : </strong>'.$gymadd["province"].'</li>
                        <li><strong>Country : </strong>'.$gymadd["country"].'</li>
                        <li><strong>Zipcode : </strong>'.$gymadd["zipcode"].'</li>
                        <li><strong>Website : </strong>'.$gymadd["website"].'</li>
                        <li><strong>Google Map : </strong>'.$gymadd["gmaphtml"].'</li>
                    </ul>';
            }
            return $addrHTM;
    }
}
?>