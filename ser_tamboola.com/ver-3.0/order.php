<?php

class order {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    public function addClient() {

        $user_pk = $_SESSION["USER_LOGIN_DATA"]["USER_ID"];
        $product_pk = 0;
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $date = date_create(mysql_real_escape_string($this->parameters["date"]));
        $enqdate = date_format($date, 'Y-m-d H:i:s');
        $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
        $query = 'INSERT INTO  `order_follows` (
							`user_pk`,
							`client_name`,
							`cell_number`,
							`email_id`,
							`handled_by`,
							`referred_by`,
							`order_of_probability`,
							`comments`,
							`date`,
							`status`
							)  VALUES(
						\'' . $user_pk . '\',
						\'' . mysql_real_escape_string($this->parameters["name"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["cellnumbers"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["email"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["handelpk"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["referpk"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["OrderProbability"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["comment"]) . '\',
						\'' . mysql_real_escape_string($enqdate) . '\',
						14);';
        if (executeQuery($query)) {
            $flag = true;
        }

        if (flag == true) {
            executeQuery("COMMIT");
        }
    }

    public function listorders() {
        $orders = array();
        $clientorder = '';
        $ids = array();
        executeQuery('SET SESSION group_concat_max_len = 1000000;');
        $query = 'SELECT a.*,
                        mmuph.id AS hid,
                        mmuth.user_type AS husertype,
                        mmuph.user_name AS husername,
                        CASE WHEN mmuph.email IS NULL OR mmuph.email=""
                        THEN "Email-NOT Provided"
                        ELSE
                        mmuph.email
                        END AS hemail,
                        CASE WHEN mmuph.cell_number IS NULL OR mmuph.cell_number=""
                        THEN "CellPhone-NOT Provided"
                        ELSE
                        mmuph.cell_number
                        END AS hcell,
                        mmupr.id AS rid,
                        mmutr.user_type AS rusertype,
                        mmupr.user_name AS rusername,
                        CASE WHEN mmupr.email IS NULL OR mmupr.email=""
                        THEN "Email-NOT Provided"
                        ELSE
                        mmupr.email
                        END AS remail,
                        CASE WHEN mmupr.cell_number IS NULL OR mmupr.cell_number=""
                        THEN "CellPhone-NOT Provided"
                        ELSE
                        mmupr.cell_number
                        END AS rcell
                        FROM `order_follows` a
                        LEFT JOIN ' . MADMEC_MANAGE . '.user_profile mmuph
                        ON mmuph.id=a.handled_by
                        LEFT JOIN ' . MADMEC_MANAGE . '.user_profile mmupr
                        ON mmupr.id=a.referred_by
                        LEFT JOIN ' . MADMEC_MANAGE . '.user_type mmuth
                        ON mmuth.id=mmuph.user_type_id
                        LEFT JOIN  ' . MADMEC_MANAGE . '.user_type mmutr
                        ON mmutr.id=mmupr.user_type_id
                        WHERE a.`status`=14';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $orders[] = $row;
            }
            for ($i = 0; $i < sizeof($orders); $i++) {
                $ids[$i] = $orders[$i]['id'];
                $clientorder .= '<tr>
                                    <td>' . ($i + 1) . '</td>
                                    <td>' . $orders[$i]["client_name"] . '</td>
                                    <td>' . $orders[$i]["cell_number"] . '</td>
                                    <td class="text-right">' . $orders[$i]["email_id"] . '</td>
                                    <td class="text-right">' . $orders[$i]["husertype"] .'--'.$orders[$i]["husername"]. '--'.$orders[$i]["hemail"]. '--'.$orders[$i]["hcell"]. '</td>
                                    <td class="text-right">' . $orders[$i]["rusertype"] .'--'.$orders[$i]["rusername"]. '--'.$orders[$i]["remail"]. '--'.$orders[$i]["rcell"]. '</td>
                                    <td class="text-right">' . $orders[$i]["order_of_probability"] . '</td>
                                    <td class="text-right">' . $orders[$i]["date"] . '</td>
                                    <td class="text-right">' . $orders[$i]["comments"] . '</td>
                                    <td><button class="btn btn-primary" type="button"  id="delorderfoll' . $orders[$i]["id"] . '" data-toggle="modal" data-target="#myModal_' . $orders[$i]["id"] . '"><i class="fa fa-trash fa-fw fa-x2"></i>Delete</button>
                                    <div class="modal fade" id="myModal_' . $orders[$i]['id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_' . $orders[$i]['id'] . '" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                    <div class="modal-content" style="color:#000;">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel_' . $orders[$i]['id'] . '">Delete Order Follow-up entry</h4>
                                    </div>
                                    <div class="modal-body">
                                    Do You really want to delete the Order Follow-up entry ?? press <strong>OK</strong> to delete
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteOk_' . $orders[$i]['id'] . '">Ok</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_' . $orders[$i]['id'] . '">Cancel</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                </td>
                            </tr>';
            }
            $jsondata = array(
                "status" => "success",
                "data" => $clientorder,
                "ids" => $ids,
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL,
            );
            return $jsondata;
        }
    }

    public function displayClientList($para = false) {
        $this->parameters = $para;
        $orders = array();
        $num_posts = 0;
        if (isset($_SESSION['listoforders']) && $_SESSION['listoforders'] != NULL)
            $orders = $_SESSION['listoforders'];
        else
            $orders = NULL;
        if ($orders != NULL)
            $num_posts = sizeof($orders);
        /* Transactions */
        $clientorder = '';
        /* Incomming */
        if ($num_posts > 0) {
            //for($i=$this->parameters["initial"];$i<$this->parameters["final"] && $i < $num_posts && isset($colls[$i]['incid']);$i++){
            for ($i = 0; $i < $num_posts; $i++) {

                $clientorder .= '<tr>
										<td>' . ($i + 1) . '</td>
										<td>' . $orders[$i]["client_name"] . '</td>
										<td>' . $orders[$i]["cell_number"] . '</td>
										<td class="text-right">' . $orders[$i]["email_id"] . '</td>
										<td class="text-right">' . $orders[$i]["handled_by"] . '</td>
										<td class="text-right">' . $orders[$i]["referred_by"] . '</td>
										<td class="text-right">' . $orders[$i]["order_of_probability"] . '</td>
										<td class="text-right">' . $orders[$i]["date"] . '</td>
										<td class="text-right">' . $orders[$i]["comments"] . '</td>
										<td><button class="btn btn-primary" onClick="#" href="javascript:void();" data-toggle="modal" data-target="#myModal_' . $ptype[$i]["mo_id"] . '" ><i class="fa fa-trash fa-fw fa-x2"></i> Delete</button>
                                                                                <div class="modal fade" id="myModal_' . $ptype[$i]["mo_id"] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_' . $ptype[$i]["mo_id"] . '" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                <div class="modal-content" style="color:#000;">
                                                                                <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                <h4 class="modal-title" id="myModalLabel_' . $ptype[$i]["mo_id"] . '">Delete Item entry</h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                Do You really want to delete the Item entry ?? press <strong>OK</strong> to delete
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteOk_' . $ptype[$i]["mo_id"] . '">Ok</button>
                                                                                <button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_' . $ptype[$i]["mo_id"] . '">Cancel</button>
                                                                                </div>
                                                                                </div>
                                                                                </div>
                                                                                </div>
                                                                            </td>
									</tr>';
            }
            //echo '<table class="table table-striped table-bordered table-hover"><thead><tr><th colspan="7">Incomming Transactions</th></tr><tr><th>#</th><th>Date</th><th>Collector</th><th>Payee</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode Of Payment</th><th class="text-right">Bank details</th></tr></thead>'.$incomming.'</table>';
            echo $clientorder;
        } else {
            //echo '<strong class="text-danger">There are no Collections available !!!!</strong>';
            echo '<tr><td colspan="8"><strong class="text-danger">There are no Collections available !!!!</strong></td></tr>';
        }
    }

    public static function listnotification($para = false) {
        $datetime = new DateTime();
        $datetime->add(new DateInterval('P1M'));
        $validity_expire = $datetime->format('Y-m-d');
        $users = array();
        $utype = (isset($para["utype"]) && !empty($para["utype"])) ? ' AND f.`user_type` LIKE "%' . $para["utype"] . '%"' : '';
        $uid = (isset($para["uid"]) && !empty($para["uid"])) ? ' AND a.`id` = "' . $para["uid"] . '"' : '';
        $status = $para["status"];
        $success = "succ";
        if ($status == $success) {
            $searchqr = $para["var"];
        } else {
            $searchqr = '';
        }
        executeQuery('SET SESSION group_concat_max_len = 1000000;');
        $query = 'SELECT
					c.`cnumber`,
					b.`email_pk`,
					c.`cnumber_pk`,
					b.`email_ids`,
					a.`user_name`,
					a.`password`,
					a.`id` AS usrid,
					a.`user_type_id`,
					v.`expiry_date`,
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
					LEFT JOIN (
						SELECT vl.`expiry_date`,
								vl.	`user_pk`
							FROM validity AS vl
							WHERE vl.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
					)AS v ON a.`id` = v.`user_pk`
					WHERE a.`user_type_id` !=  10 and v.`expiry_date` BETWEEN  "' . date("Y-m-d") . '" AND "' . $validity_expire . '"
					AND a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive"))';

        $res = executeQuery($query);

        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $users[] = $row;
            }
        }
        $total = sizeof($users);
        if ($total) {
            for ($i = 0; $i < $total; $i++) {
                $users[$i]["email_pk"] = explode("☻☻♥♥☻☻", $users[$i]["email_pk"]);
                $users[$i]["email"] = explode("☻☻♥♥☻☻", $users[$i]["email"]);
                $users[$i]["cnumber_pk"] = explode("☻☻♥♥☻☻", $users[$i]["cnumber_pk"]);
                $users[$i]["cnumber"] = explode("☻☻♥♥☻☻", $users[$i]["cnumber"]);
                $users[$i]["expiry_date"] = $users[$i]["expiry_date"];
            }
            $_SESSION["listofusers"] = $users;
        } else {
            $_SESSION["listofusers"] = NULL;
        }
        //	print_r($_SESSION["listofusers"]);
        return $_SESSION["listofusers"];
    }

    public function displayNotificationList($para = false) {
        $this->parameters = $para;
        $users = array();
        $html = '';

        $listusers = array(
            "html" => '<strong class="text-danger">There are no users available !!!!</strong>',
            "uid" => 0,
            "sr" => '',
            "alertUSRDEL" => '',
            "usrdelOk" => '',
            "usrdelCancel" => '',
            "alertUSRFLG" => '',
            "usrflgOk" => '',
            "usrflgCancel" => '',
            "butuflg" => '',
            "alertUSRUFLG" => '',
            "usruflgOk" => '',
            "usruflgCancel" => ''
        );
        $num_posts = 0;

        if (isset($_SESSION["listofusers"]) && $_SESSION["listofusers"] != NULL)
            $users = $_SESSION["listofusers"];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        if ($num_posts > 0) {
            $listusers = array();
            for ($i = $this->parameters["initial"]; $i < $this->parameters["final"] && $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                /* Basic info */
                $email = $cnumber = $backac = $prd = '';
                $email_no = $cnum_no = $bank_no = $prd_no = -1;
                /* Email */

                if (is_array($users[$i]["email"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                        $flag = true;
                        $email .= '<li>' . ltrim($users[$i]["email"][$j], ',') . '</li>';
                        $email_no++;
                    }
                    if (!$flag) {
                        $email = '<li>Not Provided</li>';
                    }
                }
                /* Cell Number */
                if (is_array($users[$i]["cnumber"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                        $flag = true;
                        $cnumber .= '<li>' . ltrim($users[$i]["cnumber"][$j], ',') . '</li>';
                        $cnum_no++;
                    }
                    if (!$flag) {
                        $cnumber = '<li>Not Provided</li>';
                    }
                }
                $basicinfo = '<div class="row"><div class="col-lg-12">&nbsp;</div><div class="col-lg-4"><div class="panel panel-yellow"><div class="panel-heading"><h4>Photo</h4></div><div class="panel-body" id="usrphoto_' . $users[$i]["usrid"] . '"><img src="' . $users[$i]["usrphoto"] . '" width="150" /></div><div class="panel-footer" style="display:none;"><button class="btn btn-yellow btn-md" id="usrphoto_but_edit_' . $users[$i]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div>
					<div class="col-lg-4"><div class="panel panel-green"><div class="panel-heading"><h4>Email Ids</h4></div><div class="panel-body" id="usremail_"><ul>' . $email . '</ul></div></div></div>
					<div class="col-lg-4"><div class="panel panel-primary"><div class="panel-heading"><h4>Cell Numbers</h4></div><div class="panel-body" id="usrcnum_"><ul>' . $cnumber . '</ul></div></div></div></div><div class="row"><div class="col-lg-12">&nbsp;</div>
					<div class="col-lg-8"><div class="panel panel-red"><div class="panel-heading"><h4>Address</h4></div>
					<div class="panel-body" id="usradd_" style="display:block;">
						<ul>
							<li><strong>Address line :</strong>' . $users[$i]["addressline"] . '</li>
							<li><strong>Street / Locality :</strong>' . $users[$i]["town"] . '</li>
							<li><strong>City / Town :</strong>' . $users[$i]["city"] . '</li>
							<li><strong>District / Department :</strong>' . $users[$i]["district"] . '</li>
							<li><strong>State / Provice :</strong>' . $users[$i]["province"] . '</li>
							<li><strong>Country :</strong>' . $users[$i]["country"] . '</li>
							<li><strong>Zipcode :</strong>' . $users[$i]["zipcode"] . '</li>
							<li><strong>Website :</strong>' . $users[$i]["website"] . '</li>
							<li><strong>Google Map :</strong>' . $users[$i]["website"] . '</li>
						</ul>
					</div>
					';
                $html = '<div class="panel panel-default" id="usr_row' . $users[$i]["usrid"] . '">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-6">
									<a data-toggle="collapse" data-parent="#accorlistuser" href="#user_type_' . $users[$i]["usrid"] . '">
										{' . ($i + 1) . '} - {' . $users[$i]["user_name"] . '} -- {' . $users[$i]["tnumber"] . '} - {' . $users[$i]["country"] . '}
									</a>
								</div>
								<div class="col-md-6 text-right">';

                if (($users[$i]["status_id"]) == '1') {
                    $html .= '<button class="btn btn-primary btn-md" id="usr_but_flag_' . $users[$i]["usrid"] . '" data-toggle="modal" data-target="#myModal_flag' . $users[$i]["usrid"] . '"><i class="fa fa-flag fa-fw "></i> Flag</button>&nbsp;';
                } else if (($users[$i]["status_id"]) == '7') {
                    $html .= '<button class="btn btn-primary btn-md" id="usr_but_unflag_' . $users[$i]["usrid"] . '" data-toggle="modal" data-target="#myModal_unflag' . $users[$i]["usrid"] . '"><i class="fa fa-flag fa-fw "></i> Unflag</button>&nbsp;';
                }
                $html .= '<button class="btn btn-danger btn-md" id="usr_but_trash_' . $users[$i]["usrid"] . '" data-toggle="modal" data-target="#myUSRDELModal_' . $users[$i]["usrid"] . '" ><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp;
								</div>
							<div class="modal fade" id="myUSRDELModal_' . $users[$i]["usrid"] . '" tabindex="-1" role="dialog" aria-labelledby="myUSRDELModalLabel_' . $users[$i]["usrid"] . '" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content" style="color:#000;">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myUSRDELModalLabel_' . $users[$i]["usrid"] . '">Select Cell Numbers to send SMS</h4>
											</div>
											<div class="modal-body" id="myUSRDEL_' . $users[$i]["usrid"] . '">
												Do you really want to delete {' . $users[$i]["user_name"] . '} - {' . $users[$i]["user_type"] . '} - {' . $users[$i]["tnumber"] . '}<br />
												Press OK to delete ??
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteUSRDELOk_' . $users[$i]["usrid"] . '">Ok</button>
											<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteUSRDELCancel_' . $users[$i]["usrid"] . '">Cancel</button>
										</div>
									</div>
								</div>


							</div>
						</div>
						<div id="user_type_' . $users[$i]["usrid"] . '" class="panel-body panel-collapse collapse" style="height: 0px;">
							<ul class="nav nav-pills">
								<li class="active"><a href="#info_user_type_' . $users[$i]["usrid"] . '" data-toggle="tab">Basic info</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade in active" id="info_user_type_' . $users[$i]["usrid"] . '">
									<h4>&nbsp;</h4>
									<p>' . str_replace($this->order, $this->replace, $basicinfo) . '</p>
								</div>
									</div>
								</div>
							</div>
						</div>
					</div>';

                $listusers[] = array(
                    "html" => (string) $html,
                    "uid" => $users[$i]["usrid"],
                    "sr" => '#usr_row' . $users[$i]["usrid"],
                    "alertUSRDEL" => '#myUSRDELModal_' . $users[$i]["usrid"],
                    "usrdelOk" => '#deleteUSRDELOk_' . $users[$i]["usrid"],
                    "usrdelCancel" => '#deleteUSRDELCancel_' . $users[$i]["usrid"],
                    "alertUSRFLG" => '#myModal_flag' . $users[$i]["usrid"] . '',
                    "usrflgOk" => '#flagOk_' . $users[$i]["usrid"] . '',
                    "usrflgCancel" => '#flagCancel_' . $users[$i]["usrid"] . '',
                    "butuflg" => '#usr_but_unflag_' . $users[$i]["usrid"] . '',
                    "alertUSRUFLG" => '#myModal_unflag' . $users[$i]["usrid"] . '',
                    "usruflgOk" => '#unflagOk_' . $users[$i]["usrid"] . '',
                    "usruflgCancel" => '#unflagCancel_' . $users[$i]["usrid"] . ''
                );
            }
            return $listusers;
        }
    }

    public function fetchAdminNotify() {
        $notifydata = array();
        $data = '';
        $query = 'SELECT v.`user_pk`,
                            v.`expiry_date`,
                            up.`user_name`,
                            up.`owner_name`,
                            up.`email`,
                            up.`cell_code`,
                            up.`cell_number`,
                            CASE WHEN up.zipcode IS NULL OR up.zipcode=""
                            THEN
                            "NOT PROVIDED"
                            ELSE
                            up.zipcode END
                            AS zipcode,
                            CASE WHEN up.city IS NULL OR up.city=""
                            THEN
                            "NOT PROVIDED"
                            ELSE
                            up.city END
                            AS city
                            FROM `validity` v
                            LEFT JOIN `user_profile` up
                            ON up.`id`=v.`user_pk`
                            WHERE (`expiry_date` BETWEEN CURRENT_DATE AND DATE(CURRENT_DATE + INTERVAL 1 MONTH)
                            OR `expiry_date` < CURRENT_DATE )  AND `status`=4';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            $m = 1;
            $data .='<table class="table table-striped table-bordered table-hover" id="listnotifycations-example"><thead><tr><th>#</th><th>UserName</th><th>Owner Name</th><th>Cell Number</th><th>Email Id</th><th>City</th><th>Zipcode</th><th>Expire on</th></tr></thead><tbody>';
            while ($row = mysql_fetch_assoc($result)) {
                $notifydata[] = $row;
            }
            for ($i = 0; $i < sizeof($notifydata); $i++) {
                $data .='<tr><td>' . $m++ . '</td><td>' . $notifydata[$i]['user_name'] . '</td>'
                        . '<td>' . $notifydata[$i]['owner_name'] . '</td>'
                        . '<td>' . $notifydata[$i]['cell_code'] . ' - ' . $notifydata[$i]['cell_number'] . '</td>'
                        . '<td>' . $notifydata[$i]['email'] . '</td>'
                        . '<td>' . $notifydata[$i]['city'] . '</td>'
                        . '<td>' . $notifydata[$i]['zipcode'] . '</td>'
                        . '<td>' . $notifydata[$i]['expiry_date'] . '</td>'
                        . '</tr>';
            }
            $data .='</tbody></table>';
            $jsondata = array(
                "status" => "success",
                "data" => $data,
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL,
            );
            return $jsondata;
        }
    }

    public function deletentfyUser() {
        $flag = false;
        $query = NULL;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `user_profile` SET `status_id`=6 WHERE `id` = "' . mysql_real_escape_string($this->parameters["entry"]) . '";';
        if (executeQuery($query)) {
            $flag = true;
            executeQuery("COMMIT;");
        }
        return $flag;
    }

    public function deleteOrderFollowup($ofid) {
        $query = 'UPDATE `order_follows` SET `status`=6 WHERE `id`="' . mysql_real_escape_string($ofid) . '"';
        $res = executeQuery($query);
        return $res;
    }

}
