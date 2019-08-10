<?php

class groups {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';
    private static $sid = '';

    public function __construct($para = false) {
        $this->parameters = $para;
    }

    /* Main */

    public function returnListofPeoples() {
        $listofPeoples = NULL;
        $query = 'SELECT ph1.ver1,ad.`id` AS pk,
			ad.`user_name` AS name,
			ad.`email_id` AS email,
			ad.`cell_number` AS cell,
			CASE WHEN ad.`photo_id` IS NULL OR ad.`photo_id`  = ""
			THEN \'' . ADMIN_ANON_IMAGE . '\'
			ELSE CONCAT(\'' . URL . DIRS . '\',ph1.`ver3`)
			END AS photos
			FROM `user_profile` AS ad
			LEFT JOIN `photo` AS ph1 ON ad.`photo_id` = ph1.`id`;';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $i = 1;
            $listofPeoples = array();
            while ($row = mysql_fetch_assoc($res)) {
                $listofPeoples[$i]['pk'] = $row['pk'];
                $listofPeoples[$i]['name'] = $row['name'];
                $listofPeoples[$i]['email'] = $row['email'];
                $listofPeoples[$i]['cell'] = $row['cell'];
                $listofPeoples[$i]['photos'] = $row['photos'];
                $i++;
            }
        }
        $_SESSION['listofPeoples'] = $listofPeoples;
        // $value["item"]=array($listofPeoples);
        echo json_encode($listofPeoples);
        // print_r($listofPeoples);
    }

    /* Slave */

    public function listGRPDel($id) {
        $result = false;
        $query = 'UPDATE `group_members` SET status = (SELECT id FROM `status` WHERE statu_name="Left" and status=1) WHERE customer_pk=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    /* Slave */

    public function listGRPFlag($id) {
        $result = false;
        $query = 'UPDATE `group_members` SET status = (SELECT id FROM `status` WHERE statu_name="Flag" and status=1) WHERE customer_pk=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    /* Slave */

    public function listGRPunFlag($id) {
        $result = false;
        $query = 'UPDATE `group_members` SET status = (SELECT id FROM `status` WHERE statu_name="Joined" and status=1) WHERE customer_pk=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    /* Slave */

    public function gRPDel($id) {
        $result = false;
        $query = 'UPDATE `groups` SET status = (SELECT id FROM `status` WHERE statu_name="Delete" and status=1) WHERE id=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    /* Slave */

    public function gRPFlag($id) {
        $result = false;
        $query = 'UPDATE `groups` SET status = (SELECT id FROM `status` WHERE statu_name="Flag" and status=1) WHERE id=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    /* Slave */

    public function gRPunFlag($id) {
        $result = false;
        $query = 'UPDATE `groups` SET status = (SELECT id FROM `status` WHERE statu_name="Show" and status=1) WHERE id=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    /* Slave */

    public function editCustomerlistgrp($fid, $cid, $tabid, $i, $j, $mtid) {
        $temp = 1;
        $listinfocustgp = array();
        $status = $name = $email = $cell = $occ = $dob = $doj = $editdata = '';
        $cust_pk = 0;
        if (isset($_SESSION["listofgroup"]) && $_SESSION["listofgroup"] != NULL) {
            $listinfocustgp = $_SESSION["listofgroup"];
            //  unset($_SESSION["list0f_client"]);
            $status = ltrim($listinfocustgp[$i]['grcust']['grcust_status'][$j], ',');
            $name = ltrim($listinfocustgp[$i]['grcust']['grcust_name'][$j], ',');
            $cust_pk = ltrim($listinfocustgp[$i]['grcust']['grcust_pk'][$j], ',');
            $master_pk = ltrim($listinfocustgp[$i]['grcust']['grcust_m_pk'][$j], ',');
            $email = ltrim($listinfocustgp[$i]['grcust']['grcust_email'][$j], ',');
            $cell = ltrim($listinfocustgp[$i]['grcust']['grcust_cell'][$j], ',');
            $occ = ltrim($listinfocustgp[$i]['grcust']['grcust_occu'][$j], ',');
            $dob = ltrim($listinfocustgp[$i]['grcust']['grcust_dob'][$j], ',');
            $doj = ltrim($listinfocustgp[$i]['grcust']['grcust_doj'][$j], ',');
        } else
            $guserlist = NULL;
        $personalinfo = str_replace($this->order, $this->replace, '
			<div class="row">
			<div class="col-lg-12">&nbsp;</div>
			<div class="col-lg-8">
			<div class="panel panel-green">
			<div class="panel-heading">
			<h4>Personal-Info</h4>
			</div>
			<div class="panel-body" id="subcustdatacgp_' . $temp . '">
			<ul>
			<li><strong>Name :</strong>' . $name . '</li>
			<li><strong>Email :</strong>' . $email . '</li>
			<li><strong>Cell Number  :</strong>' . $cell . '</li>
			<li><strong>DOB :</strong>' . date("j-M-Y", strtotime($dob)) . '</li>
			<li><strong>Joining Date :</strong>' . date("j-M-Y h:i:s A", strtotime($doj)) . '</li>
			<li><strong>Occupation :</strong>' . $occ . '</li>
			</ul>
			</div>
			<div class="panel-body" id="subcustinfoEDITdatacgp_' . $temp . '" style="display:none">
			<form id="subcust_info_edit_formcgp_' . $temp . '">
			<div class="row">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> Name  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="Name" name="custname_cgp' . $temp . '" type="text" id="custname_cgp' . $temp . '" maxlength="100" value="' . $name . '"/>
			<p class="help-block" id="custnmsg_cgp' . $temp . '">Enter/ Select.</p>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			</div>
			<!--Customer Email  -->
			<div class="row">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> Email_id  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="Email Id" name="custemail_cgp' . $temp . '" type="text" id="custemail_cgp' . $temp . '" maxlength="100" value="' . $email . '"/>
			<p class="help-block" id="custemmsg_cgp' . $temp . '">Enter/ Select.</p>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			</div>
			<!-- Customer Cell Number -->
			<div class="row">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> cell_Number  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="DB Host" name="custcell_cgp' . $temp . '" type="text" id="custcell_cgp' . $temp . '" maxlength="100" value="' . $cell . '"/>
			<p class="help-block" id="custcellmsg_cgp' . $temp . '">Enter/ Select.</p>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			</div>
			<!-- DOB -->
			<div class="row">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> DOB  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="DOB" name="custdob_cgp' . $temp . '" type="text" id="custdob_cgp' . $temp . '" maxlength="100" value="' . date("j-M-Y", strtotime($dob)) . '"/>
			<p class="help-block" id="custdobmsg_cgp' . $temp . '">Enter/ Select.</p>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			</div>
			<!-- date of join -->
			<div class="row">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> Date of Join  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="Date OF Joining" name="custdoj_cgp' . $temp . '" type="text" id="custdoj_cgp' . $temp . '" maxlength="100" value="' . $doj . '"/>
			<p class="help-block" id="custdojmmsg_cgp' . $temp . '">Enter/ Select.</p>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			</div>
			<!-- occupation -->
			<div class="row">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> Occupation  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<select  name="custocc_cgp' . $temp . '" id="custocc_cgp' . $temp . '" type="text" class="form-control" >
			<option value="NULL">Select Occupation</option>
			<option value="Student">Student</option>
			<option value="Professional">Professional</option>
			<option value="Other">Other</option>
			</select>
			<p class="help-block" id="custocmsg_cgp' . $temp . '">Enter/ Select.</p>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			</div>
			<!-- Update -->
			<div class="row">
			<div class="col-lg-12">&nbsp;</div>
			<div class="col-lg-12 text-center">
			<button type="button" class="btn btn-danger btn-md" id="subcust_info_update_but_cgp' . $temp . '"><i class="fa fa-upload fa-fw "></i> Update</button>
			&nbsp;<button type="button" class="btn btn-danger btn-md" id="subcust_info_close_but_cgp' . $temp . '"><i class="fa fa-close fa-fw "></i> Close</button>
			</div>
			</div>
			</form>
			</div>
			<div class="panel-footer">
			<button type="button" class="btn btn-danger btn-md" id="subcustinfo_but_edit_cgp' . $temp . '" style="display:none;">
			<i class="fa fa-edit fa-fw "></i> Edit
			</button>
			</div>
			</div>
			</div>
			</div>');
        //  offer data
        $offerdata = ' ';
        if (isset($listinfocustgp[$i]["fee"]["offer_name"][$j])) {
            $listinfocustgp[0]["fee"]["offer_name"] = explode("☻☻", $listinfocustgp[$i]["fee"]["offer_name"][$j]);
            $listinfocustgp[0]["fee"]["duration"] = explode("☻☻", $listinfocustgp[$i]["fee"]["duration"][$j]);
            $listinfocustgp[0]["fee"]["payment_date"] = explode("☻☻", $listinfocustgp[$i]["fee"]["payment_date"][$j]);
            $listinfocustgp[0]["fee"]["valid_from"] = explode("☻☻", $listinfocustgp[$i]["fee"]["valid_from"][$j]);
            $listinfocustgp[0]["fee"]["valid_till"] = explode("☻☻", $listinfocustgp[$i]["fee"]["valid_till"][$j]);
            $count = sizeof($listinfocustgp[0]["fee"]["offer_name"]);
            if ($count > 0) {
                for ($l = 0; $l < $count && isset($listinfocustgp[0]["fee"]["offer_name"][$l]) && $listinfocustgp[0]["fee"]["offer_name"][$l] != ''; $l++) {
                    $offerdata .= '<tr><td>' . ($l + 1) .
                            '</td><td>' . trim($listinfocustgp[0]["fee"]["offer_name"][$l], ',') .
                            '</td><td>' . trim($listinfocustgp[0]["fee"]["duration"][$l], ',') .
                            '</td><td>' . trim($listinfocustgp[0]["fee"]["payment_date"][$l], ',') .
                            '</td><td>' . trim($listinfocustgp[0]["fee"]["valid_from"][$l], ',') .
                            '</td><td>' . trim($listinfocustgp[0]["fee"]["valid_till"][$l], ',') . '</td></tr>';
                }
            }
        }
        // package data
        $packdata = ' ';
        if (isset($listinfocustgp[$i]["fee_package"]["package_type"][$j])) {
            $listinfocustgp[0]["fee_package"]["package_type"] = explode("☻☻", $listinfocustgp[$i]["fee_package"]["package_type"][$j]);
            $listinfocustgp[0]["fee_package"]["payment_date"] = explode("☻☻", $listinfocustgp[$i]["fee_package"]["payment_date"][$j]);
            $listinfocustgp[0]["fee_package"]["num_sessions"] = explode("☻☻", $listinfocustgp[$i]["fee_package"]["num_sessions"][$j]);
            $listinfocustgp[0]["fee_package"]["id"] = explode("☻☻", $listinfocustgp[$i]["fee_package"]["id"][$j]);
            $count1 = sizeof($listinfocustgp[0]["fee_package"]["id"]);
            if ($count1 > 0) {
                for ($l = 0; $l < $count1 && isset($listinfocustgp[0]["fee_package"]["id"][$l]) && $listinfocustgp[0]["fee_package"]["id"][$l] != ''; $l++) {
                    $packdata .= '<tr><td>' . ($l + 1) .
                            '</td><td>' . trim($listinfocustgp[0]["fee_package"]["package_type"][$l], ',') .
                            '</td><td>' . trim($listinfocustgp[0]["fee_package"]["num_sessions"][$l], ',') .
                            '</td><td>' . trim($listinfocustgp[0]["fee_package"]["payment_date"][$l], ',') . '</td></tr>';
                }
            }
        }
        //  attendance data
        if (isset($listinfocustgp[$i]['attendance']['id'][$j])) {
            $listinfocustgp[0]['attendance']['id'] = explode("☻☻", $listinfocustgp[$i]['attendance']['id'][$j]);
            $listinfocustgp[0]['attendance']['in_time'] = explode("☻☻", $listinfocustgp[$i]['attendance']['in_time'][$j]);
            $listinfocustgp[0]['attendance']['out_time'] = explode("☻☻", $listinfocustgp[$i]['attendance']['out_time'][$j]);
            $count2 = sizeof($listinfocustgp[0]['attendance']['id']);
            if ($count2 > 0) {
                $attendance_html = '';
                $attendance_html .= '<div class="col-lg-12">
					<div class="panel panel-primary">
					<div class="panel-heading">
					<strong>Facility Attendance</strong>
					</div>
					<div class="panel-body" id="attgpicker">';
                $attedata = 'var mark_dates = [';
                for ($l = 0; $l < $count2 && isset($listinfocustgp[0]['attendance']['id'][$l]) && $listinfocustgp[0]['attendance']['id'][$l] != ''; $l++) {
                    if ($l == 0) {
                        $attedata .= "'" . date('Y-n-j', strtotime(trim($listinfocustgp[0]['attendance']['in_time'][$l], ','))) . "'";
                    } else {
                        $attedata .= ",'" . date('Y-n-j', strtotime(trim($listinfocustgp[0]['attendance']['in_time'][$l], ','))) . "'";
                    }
                }
                $attedata .= "];";
                $attendance_html .= '</div></div></div>
					<script language="javascript" type="text/javascript" >
					' . $attedata . '
					$( "#attgpicker" ).datepicker({
					dateFormat: \'yy-mm-dd\',
					changeYear: true,
					changeMonth: true,
					yearRange:\'2014:' . (date('Y') + 2) . '\',
					beforeShowDay: function(date) {
					var mark = Number(date.getFullYear()) +\'-\'+ (Number(date.getMonth())+1) +\'-\'+ Number(date.getDate());
					for (i = 0; i < mark_dates.length; i++) {
					if(mark == mark_dates[i]) {
					return [true, \'Highlighted\', \'\'];
					}
					}
					return [true];
					}
					});
					setTimeout(function(){
					$(\'.ui-state-active\').removeClass(\'ui-state-default\');
					$(\'.ui-state-active\').removeClass(\'ui-datepicker-days-cell-over\');
					$(\'.ui-state-active\').removeClass(\'ui-datepicker-today\');
					},1500);
					</script>';
            }
        } else {
            $attendance_html = '<center><h2>' . $name . ' has not attended.</h2></center>';
        }
        //  transaction data
        $accountdata = ' ';
        if (isset($listinfocustgp[$i]["accounts"]["inv_tt"][$j]) && isset($listinfocustgp[$i]["accounts"]["inv_urls"][$j])) {
            $listinfocustgp[$i]["accounts"]["inv_tt"][$j] = ltrim($listinfocustgp[$i]["accounts"]["inv_tt"][$j], ',');
            $listinfocustgp[$i]["accounts"]["inv_urls"][$j] = ltrim($listinfocustgp[$i]["accounts"]["inv_urls"][$j], ',');
            $listinfocustgp[$i]["accounts"]["mt_rpt"][$j] = ltrim($listinfocustgp[$i]["accounts"]["mt_rpt"][$j], ',');
            $listinfocustgp[$i]["accounts"]["mt_pod"][$j] = ltrim($listinfocustgp[$i]["accounts"]["mt_pod"][$j], ',');
            $listinfocustgp[$i]["accounts"]["due_amount"][$j] = ltrim($listinfocustgp[$i]["accounts"]["due_amount"][$j], ',');
            $listinfocustgp[$i]["accounts"]["due_date"][$j] = ltrim($listinfocustgp[$i]["accounts"]["due_date"][$j], ',');
            $listinfocustgp[$i]["accounts"]["due_status"][$j] = ltrim($listinfocustgp[$i]["accounts"]["due_status"][$j], ',');
            if (isset($listinfocustgp[$i]["accounts"]["mt_uid"][$j])) {
                $listinfocustgp[0]["accounts"]["inv_tt"] = explode(",", $listinfocustgp[$i]["accounts"]["inv_tt"][$j]);
                $listinfocustgp[0]["accounts"]["inv_urls"] = explode(",", $listinfocustgp[$i]["accounts"]["inv_urls"][$j]);
                $listinfocustgp[0]["accounts"]["mt_rpt"] = explode(",", $listinfocustgp[$i]["accounts"]["mt_rpt"][$j]);
                $listinfocustgp[0]["accounts"]["mt_pod"] = explode(",", $listinfocustgp[$i]["accounts"]["mt_pod"][$j]);
                $listinfocustgp[0]["accounts"]["mop"] = explode("),", $listinfocustgp[$i]["accounts"]["mop"][$j]);
                $listinfocustgp[0]["accounts"]["due_amount"] = explode(",", $listinfocustgp[$i]["accounts"]["due_amount"][$j]);
                $listinfocustgp[0]["accounts"]["due_date"] = explode(",", $listinfocustgp[$i]["accounts"]["due_date"][$j]);
                $listinfocustgp[0]["accounts"]["due_status"] = explode(",", $listinfocustgp[$i]["accounts"]["due_status"][$j]);
                $count3 = sizeof($listinfocustgp[0]["accounts"]["inv_tt"]);
                if ($count3 > 0) {
                    for ($j = 0; $j < $count3; $j++) {
                        if ($j % 2 != 0)
                            $accountdata .= '<tr><td>' . ($j + 1) .
                                    '</td><td>' . $listinfocustgp[0]['accounts']['inv_tt'][$j] .
                                    '</td><td><a onclick=\"window.open(\'' . URL . $listinfocustgp[0]['accounts']['inv_urls'][$j] . '\');\" href=\"javascript:void(0);\">' . $listinfocustgp[0]['accounts']['mt_rpt'][$j] .
                                    '</a></td><td>' . $listinfocustgp[0]['accounts']['mt_pod'][$j] .
                                    '</td><td>' . trim($listinfocustgp[0]['accounts']['mop'][$j], ',') .
                                    '</td><td><font color=red>' . $listinfocustgp[0]['accounts']['due_amount'][$j] .
                                    '</font></td><td>' . $listinfocustgp[0]['accounts']['due_date'][$j] .
                                    '</td><td>' . $listinfocustgp[0]['accounts']['due_status'][$j] . '</td></tr>';
                        else
                            $accountdata .= '<tr><td>' . ($j + 1) .
                                    '</td><td>' . $listinfocustgp[0]['accounts']['inv_tt'][$j] .
                                    '</td><td><a onclick=\"window.open(\'' . URL . $listinfocustgp[0]['accounts']['inv_urls'][$j] . '\');\" href=\"javascript:void(0);\">' . $listinfocustgp[0]['accounts']['mt_rpt'][$j] .
                                    '</a></td><td>' . $listinfocustgp[0]['accounts']['mt_pod'][$j] .
                                    '</td><td>' . trim($listinfocustgp[0]['accounts']['mop'][$j], ',') . ')' .
                                    '</td><td><font color=red>' . $listinfocustgp[0]['accounts']['due_amount'][$j] .
                                    '</font></td><td>' . $listinfocustgp[0]['accounts']['due_date'][$j] .
                                    '</td><td>' . $listinfocustgp[0]['accounts']['due_status'][$j] . '</td></tr>';
                    }
                }
            }
        }
        echo str_replace($this->order, $this->replace, '<div class="row">
			<div class="col-lg-12">
				<div class="col-md-6">
					<a data-toggle="collapse" data-parent="#accorlistgym' . $temp . '" href="#subuser_list_cgp' . $temp . '">{Customer Name:-' . $name . '}</a>
				</div>
				<div class="col-md-6 text-right">
					<!--<button class="text-center btn btn-danger btn-md" id="custeditlist_Back_But_cgp' . $temp . '"><i class="fa fa-reply fa-fw "></i>Back</button>-->
				</div>
			</div>
			<div class="col-lg-12">
				<ul class="nav nav-pills">
				<li class="active"><a href="#info_subuser_list_cgp' . $temp . '" data-toggle="tab">Personal Info</a></li>
				<li><a href="#offer_subuser_list_cgp' . $temp . '" data-toggle="tab">Offer</a></li>
				<li><a href="#package_subuser_list_cgp' . $temp . '" data-toggle="tab">Package</a></li>
				<li><a href="#attendance_subuser_list_cgp' . $temp . '" data-toggle="tab">Attendance</a></li>
				<li><a href="#transaction_subuser_list_cgp' . $temp . '" data-toggle="tab">Transaction</a></li>
				</ul>
				<div class="tab-content">
				<div class="tab-pane fade in active" id="info_subuser_list_cgp' . $temp . '"><p>' . $personalinfo . '</p></div>
				<div class="tab-pane fade" id="offer_subuser_list_cgp' . $temp . '"><p></p></div>
				<div class="tab-pane fade" id="package_subuser_list_cgp' . $temp . '"><p></p></div>
				<div class="tab-pane fade" id="attendance_subuser_list_cgp' . $temp . '"><p>' . $attendance_html . '</p></div>
				<div class="tab-pane fade" id="transaction_subuser_list_cgp' . $temp . '"><p></p></div>
				</div>
			</div>
			</div>');
        echo '<script>
			$(document).ready(function(){
			var ltcustgpi = {
				cust_id			:	"' . $cust_pk . '",
				master_pk		:	"' . $mtid . '",
				factid			:	"' . $fid . '",
				infoform		:	"#subcust_info_edit_formcgp_' . $temp . '",
				infoEditBtn		:	"#subcustinfo_but_edit_cgp' . $temp . '",
				infoEditPanel	:	"#subcustinfoEDITdatacgp_' . $temp . '",
				infobody		:	"#subcustdatacgp_' . $temp . '",
				infoCloseBtn	:	"#subcust_info_close_but_cgp' . $temp . '",
				infoUpdateBtn	:	"#subcust_info_update_but_cgp' . $temp . '",
				custdob			:	"#custdob_cgp' . $temp . '",
				custdoj			:	"#custdoj_cgp' . $temp . '",
				backBtn			:	"#custeditlist_Back_But_cgp' . $temp . '",
				tabId			:	"' . $tabid . '",
				offerTab		:	"#offer_subuser_list_cgp' . $temp . '",
				packageTab		:	"#package_subuser_list_cgp' . $temp . '",
				transactionTab	:	"#transaction_subuser_list_cgp' . $temp . '",
				attendanceTab	:	"#attendance_subuser_list_cgp' . $temp . '",
				offerData		:	 "' . $offerdata . '",
				packageData		:	"' . $packdata . '",
				accountData		:	"' . $accountdata . '",
				cname			:	"#custname_cgp' . $temp . '",
				cemail			:	"#custemail_cgp' . $temp . '",
				ccell			:	"#custcell_cgp' . $temp . '",
				cdob			:	"#custdob_cgp' . $temp . '",
				cdoj			:	"#custdoj_cgp' . $temp . '",
				cocc			:	"#custocc_cgp' . $temp . '"
			};
			var obj = new controlCustomerListGroup();
			obj.listeditcustgrponfo(ltcustgpi);
			});
			</script>';
    }

    /* Slave */

    public function list_group($fid, $tabid) {
        $facilitywise = $regwise = '';
        $fid = trim($fid);
        if ($fid == "false") {
            $facilitywise = 'AND g.`reg_type` like "%Registration%"';
        } else {
            $facilitywise = 'AND custdfact.`facility_id` = ' . $fid;
        }
        $query = 'SELECT grp.`id` AS grid,
			grp.`name` AS gr_name,
			grp.`owner` AS gr_own,
			grp.`no_of_members` AS gr_mems,
			grp.`group_type` AS gr_type,
			grp.`fee` AS gr_fee,
			grp.`receipt_no` AS gr_rpt_no,
			grp.`customer_pk` AS gr_user_pk,
			grp.`status` AS status,
			g.`grcust_pk`,
			g.`grcust_m_pk`,
			g.`grcust_doj`,
			g.`grcust_name`,
			g.`grcust_cell`,
			g.`grcust_occu`,
			g.`grcust_dob`,
			g.`grcust_doj`,
			g.`grcust_email`,
			g.`grcust_status`,
			g.offer_name,
			g.`fee_pk`,
			g.`facility_type`,
			g.`offer_name`,
			g.`duration`,
			g.`duration_name`,
			g.`fee_payment_date`,
			g.`valid_from`,
			g.`valid_till`,
			g.`pack_pk`,
			g.`package_type_id`,
			g.`package_name`,
			g.`number_of_sessions`,
			g.`pck_pay_date`,
			g.attn_id,
			g.in_time,
			g.out_time,
			g.`reg_type`,
			g.`mt_pk`,
			g.`mt_uid`,
			g.`inv_tt`,
			g.`inv_tid`,
			g.`mt_pod`,
			g.`mt_rpt`,
			g.`tot_amt`,
			g.`mop`,
			g.`inv_urls`,
			g.`money_trans_id`,
			g.`due_id`,
			g.`due_amount`,
			g.`due_date`,
			g.`due_status`
			FROM `groups` AS grp
			LEFT  JOIN  `customer_facility` AS custdfact ON grp.`customer_pk` = custdfact.`customer_pk`
			LEFT JOIN(
			SELECT
			grpm.`customer_pk`,
			grpm.`group_id`,
			e.`reg_type`,
			GROUP_CONCAT(e.`mt_pk`,"☻☻♥♥☻☻") AS mt_pk,
			GROUP_CONCAT(e.`mt_uid`,"☻☻♥♥☻☻") AS mt_uid,
			GROUP_CONCAT(e.`inv_tt`,"☻☻♥♥☻☻") AS inv_tt,
			GROUP_CONCAT(e.`inv_tid`,"☻☻♥♥☻☻") AS inv_tid,
			GROUP_CONCAT(e.`mt_pod`,"☻☻♥♥☻☻") AS mt_pod,
			GROUP_CONCAT(e.`mt_rpt`,"☻☻♥♥☻☻") AS mt_rpt,
			GROUP_CONCAT(e.`tot_amt`,"☻☻♥♥☻☻") AS tot_amt,
			GROUP_CONCAT(e.`mop`,"☻☻♥♥☻☻") AS mop,
			GROUP_CONCAT(e.`inv_urls`,"☻☻♥♥☻☻") AS inv_urls,
			GROUP_CONCAT(e.`money_trans_id`,"☻☻♥♥☻☻") AS money_trans_id,
			GROUP_CONCAT(e.`due_id`,"☻☻♥♥☻☻") AS due_id,
			GROUP_CONCAT(e.`due_amount`,"☻☻♥♥☻☻") AS due_amount,
			GROUP_CONCAT(e.`due_date`,"☻☻♥♥☻☻") AS due_date,
			GROUP_CONCAT(e.`due_status`,"☻☻♥♥☻☻") AS due_status,
			GROUP_CONCAT(b.`offer_name`,"☻☻♥♥☻☻") AS offer_name,
			GROUP_CONCAT(b.`fee_pk`,"☻☻♥♥☻☻") AS fee_pk,
			GROUP_CONCAT(b.`facility_type`,"☻☻♥♥☻☻") AS facility_type,
			GROUP_CONCAT(b.`duration`,"☻☻♥♥☻☻") AS duration,
			GROUP_CONCAT(b.`duration_name`,"☻☻♥♥☻☻") AS duration_name,
			GROUP_CONCAT(b.`fee_payment_date`,"☻☻♥♥☻☻") AS fee_payment_date,
			GROUP_CONCAT(b.`valid_from`,"☻☻♥♥☻☻") AS valid_from,
			GROUP_CONCAT(b.`valid_till`,"☻☻♥♥☻☻") AS valid_till,
			GROUP_CONCAT(c.`pack_pk`,"☻☻♥♥☻☻") AS pack_pk,
			GROUP_CONCAT(c.`package_type_id`,"☻☻♥♥☻☻") AS package_type_id,
			GROUP_CONCAT(c.`package_name`,"☻☻♥♥☻☻") AS package_name,
			GROUP_CONCAT(c.`number_of_sessions`,"☻☻♥♥☻☻") AS number_of_sessions,
			GROUP_CONCAT(c.`pck_pay_date`,"☻☻♥♥☻☻") AS pck_pay_date,
			GROUP_CONCAT(d.`attn_id`,"☻☻♥♥☻☻") AS attn_id,
			GROUP_CONCAT(d.`in_time`,"☻☻♥♥☻☻") AS in_time,
			GROUP_CONCAT(d.`out_time`,"☻☻♥♥☻☻") AS out_time,
			GROUP_CONCAT(grpm.`customer_pk`,"☻☻♥♥☻☻") AS grcust_pk,
			GROUP_CONCAT(cust.`name`,"☻☻♥♥☻☻") AS grcust_name,
			GROUP_CONCAT(cust.`master_pk`,"☻☻♥♥☻☻") AS grcust_m_pk,
			GROUP_CONCAT(cust.`email`,"☻☻♥♥☻☻") AS grcust_email,
			GROUP_CONCAT(cust.`cell_number`,"☻☻♥♥☻☻") AS grcust_cell,
			GROUP_CONCAT(cust.`occupation`,"☻☻♥♥☻☻") AS grcust_occu,
			GROUP_CONCAT(cust.`dob`,"☻☻♥♥☻☻") AS grcust_dob,
			GROUP_CONCAT(grpm.`status`,"☻☻♥♥☻☻") AS grcust_status,
			GROUP_CONCAT(grpm.`date_of_join`,"☻☻♥♥☻☻") AS grcust_doj
			FROM `group_members` AS grpm,`customer` AS cust
			LEFT  JOIN (
			SELECT
			GROUP_CONCAT(mtr.`id`)  			AS mt_pk,
			mtr.`customer_pk` 					AS mt_uid,
			GROUP_CONCAT(inv.`name`) 			AS inv_tt,
			GROUP_CONCAT(inv.`transaction_id`) 	AS inv_tid,
			GROUP_CONCAT((SELECT `pay_date` FROM `money_transactions` WHERE `id` = inv.`transaction_id`))	AS mt_pod,
			GROUP_CONCAT(DISTINCT(mtr.`receipt_no`))AS mt_rpt,
			GROUP_CONCAT(temp1.`total`)			AS tot_amt,
			GROUP_CONCAT(temp2.`gmop`)			AS mop,
			GROUP_CONCAT(inv.`inv_urls`) 		AS inv_urls,
			due.`duser` 						AS due_user,
			GROUP_CONCAT(due.`money_trans_id`) 	AS money_trans_id,
			GROUP_CONCAT(due.`due_id`) 			AS due_id,
			GROUP_CONCAT(due.`damt`) 			AS due_amount,
			GROUP_CONCAT(due.`ddate`) 			AS due_date,
			GROUP_CONCAT(due.`dstatus`) 		AS due_status,
			mtr.transaction_type				AS reg_type
			FROM `money_transactions` AS mtr
			LEFT JOIN (
			SELECT
			IF(temp3.`due_id` IS NULL, \'NA\', temp3.`due_id`) AS due_id,
			IF(temp3.`due_amt` IS NULL, \'NA\', temp3.`due_amt`) AS damt,
			IF(temp3.`due_date` IS NULL, \'NA\', temp3.`due_date`) AS ddate,
			IF(temp3.`due_status` IS NULL, \'NA\', temp3.`due_status`) AS dstatus,
			temp3.`duser` AS duser,
			IF(temp3.`money_trans_id` IS NULL, \'NA\', temp3.`money_trans_id`) AS money_trans_id,
			temp3.`rrr`
			FROM (
			SELECT
			tmtr.`receipt_no` 		AS rrr,
			tinv.`id` 			AS due_id,
			tinv.`money_trans_id` 		AS money_trans_id,
			tinv.`due_amount`		AS due_amt,
			tinv.`due_date` 		AS due_date,
			tmtr.`customer_pk` 			AS duser,
			tinv.`status` 			AS due_status
			FROM `money_transactions` AS tmtr
			LEFT JOIN (
			SELECT mtmt.`id`,
			mtmt.`money_trans_id`,
			mtmt.`due_amount`,
			mtmt.`due_date`,
			mtmt.`customer_pk`,
			st.`statu_name` AS status
			FROM `money_trans_due` AS mtmt
			LEFT  JOIN  `status` AS st ON st.`id` = mtmt.`status`
			) AS tinv ON tmtr.`id` = tinv.`money_trans_id`
			GROUP BY (tmtr.`id`)
			) AS temp3
			GROUP BY (temp3.`rrr`)
			) AS due ON due.`rrr` = mtr.`receipt_no`
			LEFT JOIN (
			SELECT
			`customer_pk`	AS inv_users,
			`location` 	AS inv_urls,
			`transaction_id`,
			`name`
			FROM `invoice`
			GROUP BY(`transaction_id`)
			) AS inv ON inv.`transaction_id` = mtr.`id`
			LEFT JOIN(
			SELECT
			`id`,
			`receipt_no`,
			SUM(`total_amount`) AS total
			FROM `money_transactions`
			GROUP BY (`receipt_no`)
			) AS temp1 ON temp1.`id` = mtr.`id`
			LEFT JOIN(
			SELECT
			`id`,
			`receipt_no`,
			CONCAT(\'(\',GROUP_CONCAT(CONCAT(`total_amount` ,\' through \', (SELECT CASE WHEN `name` = \'Cash\' THEN \'Cash\' ELSE CASE WHEN `transaction_number` IS NULL THEN  `name` ELSE CASE WHEN LENGTH(`transaction_number`) = 0 THEN CONCAT (`name`, \' and \', `name`, \' No = Not provided\')  ELSE CONCAT (`name`, \' and \', `name`, \' No = \',`transaction_number`) END END END  FROM `mode_of_payment`  WHERE `id` = `mop_id`  AND `status` = 4)  )),\')\') AS gmop
			FROM `money_transactions`
			GROUP BY (`receipt_no`)
			) AS temp2 ON temp2.`id` = mtr.`id`
			GROUP BY (mtr.`customer_pk`)
			) AS e ON e.`mt_uid` = cust.`id`
			LEFT  JOIN (
			SELECT 	GROUP_CONCAT(DISTINCT (fe.`id`),"☻☻") 	AS fee_pk,
			fe.`id`                             AS fe_id,
			fe.`offer_id`,
			fe.`customer_pk` 					AS user_id,
			GROUP_CONCAT(fep.`facility_id`,"☻☻") 	AS facility_type,
			GROUP_CONCAT(fep.`name`,"☻☻")  			AS offer_name,
			GROUP_CONCAT(fep.`duration_id`,"☻☻")	AS duration,
			GROUP_CONCAT(od.`duration`,"☻☻")		AS duration_name,
			GROUP_CONCAT(fep.`min_members`,"☻☻") 	AS min_members,
			GROUP_CONCAT(fe.`payment_date`,"☻☻") 	AS fee_payment_date,
			GROUP_CONCAT(fe.`valid_from`,"☻☻") 		AS valid_from,
			GROUP_CONCAT(fe.`valid_till`,"☻☻") 		AS valid_till
			FROM `fee` AS fe
			INNER  JOIN  `offers` AS fep ON fep.`id` = fe.`offer_id`
			LEFT  JOIN  `offerduration` AS od ON od.`id` = fep.`duration_id`
			WHERE fep.`id` = fe.`offer_id`
			GROUP BY (fe.`customer_pk`)
			ORDER BY (fe.`id`) DESC
			)AS b ON b.`user_id` = cust.`id`
			LEFT  JOIN (
			SELECT 	GROUP_CONCAT(DISTINCT (fepack.`id`)) AS pack_pk,
			GROUP_CONCAT(pac.`package_type_id`,"☻☻") AS package_type_id,
			GROUP_CONCAT(pac.`number_of_sessions`,"☻☻") AS number_of_sessions,
			GROUP_CONCAT(pname.`package_name`,"☻☻") AS package_name,
			GROUP_CONCAT(fepack.`payment_date`,"☻☻") AS pck_pay_date,
			fepack.`customer_pk` AS user_id
			FROM 	`fee_packages` AS fepack
			INNER  	JOIN  `packages` AS pac ON pac.`id` = fepack.`package_id`
			LEFT  JOIN  `package_name` AS pname ON pname.`id` = pac.`package_type_id`
			WHERE 	pac.`id` = fepack.`package_id`
			GROUP BY(fepack.`customer_pk`)
			ORDER BY (fepack.`id`) DESC
			) AS c ON c.`user_id` = cust.`id`
			LEFT  JOIN (
			SELECT 	GROUP_CONCAT(DISTINCT (attn.`id`),"☻☻") AS attn_id,
			GROUP_CONCAT(attn.`in_time`,"☻☻") AS in_time,
			GROUP_CONCAT(attn.`out_time`,"☻☻") AS out_time,
			GROUP_CONCAT(attn.`facility_id`,"☻☻") AS facility_type,
			attn.`customer_pk` AS user_id
			FROM `customer_attendence` AS attn
			GROUP BY(attn.`customer_pk`)
			) AS d ON d.`user_id` = cust.`id`
			WHERE cust.`id` = grpm.`customer_pk`
			AND grpm.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
			`statu_name` = "Hide" OR
			`statu_name` = "Delete" OR
			`statu_name` = "Fired" OR
			`statu_name` = "Inactive"))
			AND cust.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
			`statu_name` = "Hide" OR
			`statu_name` = "Delete" OR
			`statu_name` = "Fired" OR
			`statu_name` = "Inactive"))
			GROUP BY (grpm.`group_id`)
			ORDER BY (grpm.`group_id`)
			)AS g ON g.`group_id` = grp.`id`
			WHERE grp.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
			`statu_name` = "Hide" OR
			`statu_name` = "Delete" OR
			`statu_name` = "Fired" OR
			`statu_name` = "Inactive"))
			' . $facilitywise . ';';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $j = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $groupslist[$j]['grid'] = $row['grid'];
                $groupslist[$j]['gr_name'] = $row['gr_name'];
                $groupslist[$j]['gr_own'] = $row['gr_own'];
                $groupslist[$j]['gr_mems'] = $row['gr_mems'];
                $groupslist[$j]['gr_type'] = $row['gr_type'];
                $groupslist[$j]['gr_fee'] = $row['gr_fee'];
                $groupslist[$j]['gr_rpt_no'] = $row['gr_rpt_no'];
                $groupslist[$j]['gr_user_pk'] = $row['gr_user_pk'];
                $groupslist[$j]['status'] = $row['status'];
                //  customer of group
                if ($row['grcust_pk']) {
                    $groupslist[$j]['grcust'] = array();
                    $groupslist[$j]['grcust']['grcust_pk'] = explode("☻☻♥♥☻☻", $row['grcust_pk']);
                    $groupslist[$j]['grcust']['grcust_m_pk'] = explode("☻☻♥♥☻☻", $row['grcust_m_pk']);
                    $groupslist[$j]['grcust']['grcust_doj'] = explode("☻☻♥♥☻☻", $row['grcust_doj']);
                    $groupslist[$j]['grcust']['grcust_name'] = explode("☻☻♥♥☻☻", $row['grcust_name']);
                    $groupslist[$j]['grcust']['grcust_cell'] = explode("☻☻♥♥☻☻", $row['grcust_cell']);
                    $groupslist[$j]['grcust']['grcust_occu'] = explode("☻☻♥♥☻☻", $row['grcust_occu']);
                    $groupslist[$j]['grcust']['grcust_dob'] = explode("☻☻♥♥☻☻", $row['grcust_dob']);
                    $groupslist[$j]['grcust']['grcust_doj'] = explode("☻☻♥♥☻☻", $row['grcust_doj']);
                    $groupslist[$j]['grcust']['grcust_email'] = explode("☻☻♥♥☻☻", $row['grcust_email']);
                    $groupslist[$j]['grcust']['grcust_status'] = explode("☻☻♥♥☻☻", $row['grcust_status']);
                } else {
                    $groupslist[$j]['grcust'] = NULL;
                }
                // fee info
                if ($row['fee_pk']) {
                    $groupslist[$j]['fee'] = array();
                    $groupslist[$j]['fee']['id'] = explode("☻☻♥♥☻☻", $row['fee_pk']);
                    //  $groupslist[$i]['fee']['facility_type'] = explode("",$row1['facility_type']);
                    $groupslist[$j]['fee']['offer_name'] = explode("☻☻♥♥☻☻", $row['offer_name']);
                    $groupslist[$j]['fee']['duration'] = explode("☻☻♥♥☻☻", $row['duration_name']);
                    $groupslist[$j]['fee']['payment_date'] = explode("☻☻♥♥☻☻", $row['fee_payment_date']);
                    $groupslist[$j]['fee']['valid_from'] = explode("☻☻♥♥☻☻", $row['valid_from']);
                    $groupslist[$j]['fee']['valid_till'] = explode("☻☻♥♥☻☻", $row['valid_till']);
                } else {
                    $groupslist[$j]['fee'] = NULL;
                }
                /* Fee package history */
                if ($row['pack_pk']) {
                    $groupslist[$j]['fee_package'] = array();
                    $groupslist[$j]['fee_package']['id'] = explode("☻☻♥♥☻☻", $row['pack_pk']);
                    $groupslist[$j]['fee_package']['package_type'] = explode("☻☻♥♥☻☻", $row['package_name']);
                    $groupslist[$j]['fee_package']['num_sessions'] = explode("☻☻♥♥☻☻", $row['number_of_sessions']);
                    $groupslist[$j]['fee_package']['payment_date'] = explode("☻☻♥♥☻☻", $row['pck_pay_date']);
                } else {
                    $groupslist[$j]['fee_package'] = NULL;
                }
                // attendance history
                if ($row['attn_id']) {
                    $groupslist[$j]['attendance'] = array();
                    $groupslist[$j]['attendance']['id'] = explode("☻☻♥♥☻☻", $row['attn_id']);
                    $groupslist[$j]['attendance']['in_time'] = explode("☻☻♥♥☻☻", $row['in_time']);
                    $groupslist[$j]['attendance']['out_time'] = explode("☻☻♥♥☻☻", $row['out_time']);
                    $groupslist[$j]['attendance']['facility_type'] = explode("☻☻♥♥☻☻", $row['facility_type']);
                } else {
                    $groupslist[$j]['attendance'] = NULL;
                }
                /* Account stats */
                if ($row['mt_uid']) {
                    $groupslist[$j]['accounts'] = array();
                    $groupslist[$j]['accounts']['mt_uid'] = $row['mt_uid'];
                    $groupslist[$j]['accounts']['inv_tt'] = explode("☻☻♥♥☻☻", $row['inv_tt']);
                    $groupslist[$j]['accounts']['mt_pod'] = explode("☻☻♥♥☻☻", $row['mt_pod']);
                    $groupslist[$j]['accounts']['mt_rpt'] = explode("☻☻♥♥☻☻", $row['mt_rpt']);
                    $groupslist[$j]['accounts']['tot_amt'] = explode("☻☻♥♥☻☻", $row['tot_amt']);
                    $groupslist[$j]['accounts']['mop'] = explode("☻☻♥♥☻☻", $row['mop']);
                    $groupslist[$j]['accounts']['inv_urls'] = explode("☻☻♥♥☻☻", $row['inv_urls']);
                    $groupslist[$j]['accounts']['due_amount'] = explode("☻☻♥♥☻☻", $row['due_amount']);
                    $groupslist[$j]['accounts']['due_id'] = explode("☻☻♥♥☻☻", $row['due_id']);
                    $groupslist[$j]['accounts']['money_trans_id'] = explode("☻☻♥♥☻☻", $row['money_trans_id']);
                    $groupslist[$j]['accounts']['due_date'] = explode("☻☻♥♥☻☻", $row['due_date']);
                    $groupslist[$j]['accounts']['due_status'] = explode("☻☻♥♥☻☻", $row['due_status']);
                } else {
                    $groupslist[$j]['accounts'] = NULL;
                }
                if ($row['valid_till'])
                    $groupslist[$j]['exp_date'] = date('j-M-Y', strtotime($groupslist[$j]['fee']['valid_till'][sizeof($groupslist[$j]['fee']['valid_till']) - 1]));
                else
                    $groupslist[$j]['exp_date'] = NULL;
                $j++;
            }//  while loop over
        } else
            $groupslist = null;
        $_SESSION["listofgroup"] = $groupslist;
        $this->ListofAllGroup($groupslist, $fid, $tabid);
    }

    /* Slave */

    public function list_groupmem($gid, $tabid, $data) {
        $c = 0;
        $guserlist = array();
        if (isset($_SESSION["listofgroup"]) && $_SESSION["listofgroup"] != NULL) {
            $guserlist = $_SESSION["listofgroup"];
            //  unset($_SESSION["list0f_client"]);
        } else
            $guserlist = NULL;
        if ($guserlist != NULL)
            $num_posts = sizeof($guserlist);
        else
            $num_posts = 0;
        if ($num_posts > 0) {
            $status = $name = $email = $cell = $occ = $dob = $doj = $editdata = '';
            $cust_pk = 0;
            for ($i = 0; $i < $num_posts; $i++) {
                if (($guserlist[$i]["grid"]) == $gid) {
                    if (isset($guserlist[$i]["grcust"]["grcust_pk"][0])) {
                        for ($j = 0; $j < sizeof($guserlist[$i]["grcust"]["grcust_pk"]) && isset($guserlist[$i]["grcust"]["grcust_pk"][$j]) && $guserlist[$i]["grcust"]["grcust_pk"][$j] != ''; $j++) {
                            $flagbut = '';
                            $status = ltrim($guserlist[$i]['grcust']['grcust_status'][$j], ',');
                            $master_pk = ltrim($guserlist[$i]['grcust']['grcust_m_pk'][$j], ',');
                            $name = ltrim($guserlist[$i]['grcust']['grcust_name'][$j], ',');
                            $cust_pk = ltrim($guserlist[$i]['grcust']['grcust_pk'][$j], ',');
                            $email = ltrim($guserlist[$i]['grcust']['grcust_email'][$j], ',');
                            $cell = ltrim($guserlist[$i]['grcust']['grcust_cell'][$j], ',');
                            $occ = isset($guserlist[$i]['grcust']['grcust_occu'][$j]) ? ltrim($guserlist[$i]['grcust']['grcust_occu'][$j], ',') : '';
                            $dob = ltrim($guserlist[$i]['grcust']['grcust_dob'][$j], ',');
                            $doj = ltrim($guserlist[$i]['grcust']['grcust_doj'][$j], ',');
                            if ($status == 2) {
                                $flagbut = '<button type="button" class="btn btn-primary btn-md" id="listcustFLAGgrp_' . $j . '" title="Flag" data-toggle="modal" data-target="#myModal_flag' . $j . '"><i class="fa fa-flag-o fa-fw"></i></button>';
                            } else if ($status == 7) {
                                $flagbut = '<button class="bbtn btn-danger btn-md" id="listcustUNFLAGgrp_' . $j . '" data-toggle="modal" data-target="#myModal_unflag' . $j . '" title="UnFlag"><i class="fa fa-flag-o fa-fw"></i></button>';
                            }
                            echo str_replace($this->order, $this->replace, '<tr>
									<td>' . ($j + 1) . '</td>
									<td>' . $name . '</td>
									<td>' . $email . '</td>
									<td>' . $cell . '</td>
									<td>' . $occ . '</td>
									<td>' . date("j-M-Y", strtotime($dob)) . '</td>
									<td>' . date("j-M-Y h:i:s A", strtotime($doj)) . '</td>
									<td class="text-center">
									<button type="button" id="listcustEDITgrp_' . $j . '" title="Edit" class="btn btn-info btn-md" ><i class="fa fa-edit fa-fw"></i></button> - 
									<button type="button" class="btn btn-danger btn-md" id="listcustDELgrp_' . $j . '" class="btn btn-danger btn-md" title="Delete" data-toggle="modal" data-target="#myUSRLISTGRPDELModal_' . $j . '"><i class="fa fa-trash-o fa-fw"></i></button> - 
									' . $flagbut . '
									</td></tr><div style="display:none" class="modal fade" id="myUSRLISTGRPDELModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $j . '" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
									<div class="modal-content" style="color:#000;">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myUSRDELModalLabel_' . $j . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $j . '">
									Do you really want to delete {' . $email . '} <br />
									Press OK to delete ??
									</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deletelltGRPDELOk_' . $j . '">Ok</button>
									<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $j . '">Cancel</button>
									</div>
									</div>
									</div>
									</div>
									<div class="modal fade" id="myModal_flag' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myModal_flag_Label_' . $j . '" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
									<div class="modal-content" style="color:#000;">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModal_flag_Label_' . $j . '">Flag User entry</h4>
									</div>
									<div class="modal-body">
									Do You really want to flag the User {' . $email . '} entry ?? press <strong>OK</strong> to flag
									</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="flaglltOkGRP_' . $j . '">Ok</button>
									<button type="button" class="btn btn-success" data-dismiss="modal" id="flaglltCancel_' . $j . '">Cancel</button>
									</div>
									</div>
									</div>
									</div>
									<div class="modal fade" id="myModal_unflag' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myModal_unflag_Label_' . $j . '" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
									<div class="modal-content" style="color:#000;">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModal_unflag_Label_' . $j . '">UnFlag User entry</h4>
									</div>
									<div class="modal-body">
									Do You really want to UnFlag the User {' . $email . '} entry ?? press <strong>OK</strong> to UnFlag
									</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="unflaglltOkGRP_' . $j . '">Ok</button>
									<button type="button" class="btn btn-success" data-dismiss="modal" id="unflaglltCancel_' . $j . '">Cancel</button>
									</div>
									</div>
									</div>
									</div><script>
									$(document).ready(function(){
									var ltcustgp = {
									cust_id		:	' . $cust_pk . ',
									master_pk	:	' . $master_pk . ',
									index1		:	' . $i . ',
									index2		:	' . $j . ',
									editBtn 	:	"#listcustEDITgrp_' . $j . '",
									delBtn 		:	"#listcustDELgrp_' . $j . '",
									delOkBtn 	:	"#deletelltGRPDELOk_' . $j . '",
									flagBtn 	:	"#listcustFLAGgrp_' . $j . '",
									flagokBtn	:	"#flaglltOkGRP_' . $j . '",
									unflagBtn	:	"#listcustUNFLAGgrp_' . $j . '",
									unflagokBtn :	"#unflaglltOkGRP_' . $j . '",
									factid		:	"' . $data . '",
									tabId		:	"' . $tabid . '",
									group_id	:	' . $gid . ',
									editpanel	:	"' . $editdata . '",
									};
									var obj = new controlCustomerListGroup();
									obj.listcustgpdata(ltcustgp);
									});
									</script>');
                        }
                    }
                }
            }
        }
    }

    /* Slave */

    public function addGroup() {
        $flag = false;
        $parameters = $this->parameters["gpdata"];
        $array = $parameters["array"];
        $members = $parameters["members"];
        $max_mop = $parameters["max_mop"];
        $amount = $parameters["amount"];
        $sum_amount = $parameters["sum_amount"];
        $mod_pay = $parameters["mod_pay"];
        $transaction_number = $parameters["transaction_number"];
        $groupname = $parameters["name"];
        $groupdescp = $parameters["descp"];
        $gtype = (sizeof($members) == 2) ? 'Couple' : 'Group';
        $jsondata = array();
        $recpamount = 0;
        $feehtml = 0;
        if ($parameters["status"]) {
            $flag = false;
            $query = false;
            $total = sizeof($members);
            $show = getStatusId("show");
            $joined = getStatusId("joined");
            $receiptno = sprintf("%010s", mysql_result(executeQuery('SELECT COUNT(DISTINCT(`receipt_no`)) FROM `' . $parameters["GYM_DB_NAME"] . '`.`money_transactions`;'), 0) + 1);
            $query = 'INSERT INTO `' . $parameters["GYM_DB_NAME"] . '`.`groups`
						(`id`,
						`name`,
						`owner`,
						`description`,
						`fee`,
						`no_of_members`,
						`group_type`,
						`status`,
						`customer_pk`) VALUES
						(NULL,
						\'' . mysql_real_escape_string($groupname) . '\',
						\'' . mysql_real_escape_string($_SESSION[$array][$members[0]["index"]]["email_id"]) . '\',
						\'' . mysql_real_escape_string($groupdescp) . '\',
						' . $sum_amount . ',
						' . $total . ',
						\'' . mysql_real_escape_string($gtype) . '\',
						\'' . mysql_real_escape_string($show) . '\',
						\'' . mysql_real_escape_string($members[0]["id"]) . '\');';
            if (executeQuery($query)) {
                $query1 = 'SELECT LAST_INSERT_ID();';
                $group_pk = mysql_result(executeQuery($query1), 0);
                $query2 = 'INSERT INTO `' . $parameters["GYM_DB_NAME"] . '`.`group_members` (`id`,`group_id`,`date_of_join`,`customer_pk`,`status`) VALUES';
                for ($i = 0; $i < $total; $i++) {
                    if ($i == $total - 1) {
                        $query2 .= '(NULL,
								\'' . mysql_real_escape_string($group_pk) . '\',
								NOW(),
								\'' . mysql_real_escape_string($members[$i]["id"]) . '\',
								\'' . mysql_real_escape_string($joined) . '\');';
                    } else {
                        $query2 .= '(NULL,
								\'' . mysql_real_escape_string($group_pk) . '\',
								NOW(),
								\'' . mysql_real_escape_string($members[$i]["id"]) . '\',
								\'' . mysql_real_escape_string($joined) . '\'),';
                    }
                }
                if (executeQuery($query2)) {
                    $query3 = 'INSERT INTO `' . $parameters["GYM_DB_NAME"] . '`.`money_transactions` (`id`, `mop_id`, 
									`pay_date`, `transaction_type`, `receipt_no`, `transaction_id`, `transaction_number`, 
									`total_amount`, `customer_pk`, `status`) VALUES';
                    for ($i = 0; $i < $max_mop; $i++) {
                        $recpamount += $amount[$i];
                        if (($transaction_number) === '') {
                            $transaction_number[$i] = '';
                        }
                        if ($i == ($max_mop - 1)) {
                            $query3 .='(NULL,
									\'' . mysql_real_escape_string($mod_pay[$i]) . '\',
									NOW(),
									\'Group Registration\',
									\'' . mysql_real_escape_string($receiptno) . '\',
									NULL,
									\'' . mysql_real_escape_string($transaction_number[$i]) . '\',
									\'' . mysql_real_escape_string($amount[$i]) . '\',
									' . $members[0]["id"] . ',
									\'' . mysql_real_escape_string($show) . '\');';
                        } else {
                            $query3 .='(NULL,
										\'' . mysql_real_escape_string($mod_pay[$i]) . '\',
										NOW(),
										\'Group Registration\',
										\'' . mysql_real_escape_string($receiptno) . '\',
										NULL,
										\'' . mysql_real_escape_string($transaction_number[$i]) . '\',
										\'' . mysql_real_escape_string($amount[$i]) . '\',
										' . $members[0]["id"] . ',
										\'' . mysql_real_escape_string($show) . '\'),';
                        }
                    }
                    if (executeQuery($query3)) {
                        $mey_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                        $feehtml .= '<tr><td align="right" style="border-bottom: solid 1px;">' . mysql_real_escape_string($mod_pay[0]) . ' :</td>
										<td width="139" align="right" style="border-bottom: solid 1px;">' . $mey_pk . '</td>
										<td width="84" align="right" style="border-bottom: solid 1px;">' . $recpamount . ' </td> </tr>';
                        for ($i = 0; $i < $total; $i++) {
                            $filename = md5(rand(999, 999999) . microtime()) . '_' . str_replace(" ", "_", mysql_real_escape_string($mod_pay[0])) . '_' . $members[$i]["id"] . '.html';
                            $directory = mysql_result(executeQuery('SELECT `directory` FROM `' . $parameters["GYM_DB_NAME"] . '`.`customer` WHERE `id`="' . $members[$i]["id"] . '";'), 0);
                            $filedirectory = DOC_ROOT . DIRS . $directory . '/profile/' . $filename;
                            $invloc = DIRS . $directory . '/profile/' . $filename;
                            $urlpath = URL . DIRS . $directory . '/profile/' . $filename;
                            $query5 = 'INSERT INTO `' . $parameters["GYM_DB_NAME"] . '`.`invoice`
											(`id`,
											`transaction_id`,
											`name`,
											`location`,
											`customer_pk`,
											`status`) VALUES (NULL,
											' . $mey_pk . ',
											\'Group Registration\',
											\'' . mysql_real_escape_string($invloc) . '\',
											' . $members[$i]["id"] . ',
											\'' . mysql_real_escape_string($show) . '\');';
                            if (executeQuery($query5)) {
                                $gym_addresss = array();
                                $gym_addresss = fetchAddress($parameters['GYM_ID']);
                                $invoice = str_replace($this->order, $this->replace, "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><title>" . mysql_real_escape_string($mod_pay[0]) . " Invoice</title></head>
									<body>
									<table width='800' border='0' align='center' cellpadding='5' cellspacing='2' style='border: solid 1px; font-size:18px;'>
									<tr>
									<th colspan='2' align='center'>Invoice</th>
									</tr>
									<tr>
									<td width='430'>
									Invoice no : <span style='color:red;'>" . $receiptno . "</span><br />
									Invoice Date :&nbsp;<span><u>" . date('d-M-Y') . "</u></span>
									</td>
									<td width='354'>
									<div align='center' id='comp_logo'>
									<img height='100' src='" . $gym_addresss['gympic'] . "'></img>
									</div>
									<div id='comp_add' align='left'>
									" . $gym_addresss['add'] . "
									</div>
									</td>
									</tr>
									<tr>
									<td colspan='2'>&nbsp;</td>
									</tr>
									<tr>
									<td>Reg Date :&nbsp;<span><u>" . date('d-M-Y') . "</u></span></td>
									<td>Start / Joining Date :&nbsp;<span><u>" . date('d-M-Y') . "</u></span></td>
									</tr>
									<tr>
									<td colspan='2'>&nbsp;</td>
									</tr>
									<tr>
									<td colspan='2'>
									<div style='float:left;'>Name of the member :&nbsp;</div>
									<div style='width:615px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . mysql_real_escape_string($groupname) . "</div>
									</td>
									</tr>
									<tr>
									<td colspan='2'>
									<div style='float:left;'>Cell number :&nbsp;</div>
									<div style='width:680px; float:right;border-bottom: dashed 1px;'>+91 " . mysql_real_escape_string($_SESSION[$array][$members[$i]["index"]]["cell_number"]) . "</div>
									</td>
									</tr>
									<tr>
									<td colspan='2'>
									<div style='float:left;'>Email id :&nbsp;</div>
									<div style='width:705px; float:right;border-bottom: dashed 1px;'>" . mysql_real_escape_string($_SESSION[$array][$members[$i]["index"]]["email_id"]) . "</div>
									</td>
									</tr>
									<tr>
									<td colspan='2'>
									<div style='float:left;'>Offer / Package :&nbsp;</div>
									<div style='width:655px; float:right;border-bottom: dashed 1px;'>" . mysql_real_escape_string($mod_pay[0]) . "</div>
									</td>
									</tr>
									<tr>
									<td colspan='2' align='center'>
									<table cellpadding='0' cellspacing='0' style='border: solid 1px; font-size:24px;' width='400'>
									<tr>
									<td style='border-bottom: solid 1px;' align='right'>" . mysql_real_escape_string($mod_pay[0]) . " fee :</td>
									<td style='border-bottom: solid 1px;' align='right'>" . $recpamount . " &nbsp;र;</td>
									</tr>
									<tr>
									<td style='border-bottom: solid 1px;' align='right'>Service tax :</td>
									<td style='border-bottom: solid 1px;' align='right'>0 &nbsp;र;</td>
									</tr>
									<tr>
									<td style='border-bottom: solid 1px;' align='right'>Total :</td>
									<td style='border-bottom: solid 1px;' align='right'>" . $recpamount . " &nbsp;र;</td>
									</tr>
									</table>
									</td>
									</tr>
									<tr>
									<td colspan='2'>
									<div style='float:left;'>Total amount (in words) :&nbsp;</div>
									<div style='width:590px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . convert_number_to_words($recpamount) . " </div>
									</td>
									</tr>
									<tr>
									<td>
									<div style='float:left;'>Balance amt due :&nbsp;</div>
									<div style='width:285px; float:right;border-bottom: dashed 1px;'>0000</div>
									</td>
									<td>
									<div style='float:left;'>Due date :&nbsp;</div>
									<div style='width:270px; float:right;border-bottom: dashed 1px;'>--------</div>
									</td>
									</tr>
									<tr>
									<td colspan='2'>&nbsp;</td>
									</tr>
									<tr>
									<td colspan='2'>
									<div style='width:800px; float:right;border-bottom: dashed 1px;'>&nbsp;</div>
									</td>
									</tr>
									<tr>
									<td>
									Member signature
									</td>
									<td align='right'>
									Authorized signature
									</td>
									</tr>
									<tr>
									<td align='right'>
									Non-Transferable
									</td>
									<td>
									Non-Refundable
									</td>
									</tr>
									</table>
									");
                                $fh = fopen($filedirectory, 'w');
                                fwrite($fh, $invoice);
                                fclose($fh);
                                array_push($jsondata, array(
                                    "status" => "success",
                                    "data" => '',
                                    "url" => $urlpath
                                ));
                                $flag = true;
                            }
                        }
                        if ($flag)
                            executeQuery("COMMIT");
                    }
                }
            }
        }
        return $jsondata;
    }

    /* This */

    public function ListofAllGroup($groupslist, $fid, $tabid) {
        $group = array();
        if ($groupslist != null) {
            $total = sizeof($groupslist);
            for ($i = 0; $i < $total; $i++) {
                if (($groupslist[$i]["status"]) != 7) {
                    $flagbut = '<button type="button" class="btn btn-primary btn-md" id="listFLAGgrp_' . $i . '" title="Flag" data-toggle="modal" data-target="#myModal_flag' . $i . '"><i class="fa fa-flag-o fa-fw"></i></button>';
                } else if (($groupslist[$i]["status"]) == 7) {
                    $flagbut = '<button class="btn btn-danger btn-md" id="listUNFLAGgrp_' . $i . '" data-toggle="modal" data-target="#myModal_unflag' . $i . '" title="UnFlag"><i class="fa fa-flag-o fa-fw"></i></button>';
                }
                echo str_replace($this->order, $this->replace, '<tr>
					<td>' . ($i + 1) . '</td>
					<td>' . $groupslist[$i]["gr_name"] . '</td>
					<td>' . $groupslist[$i]["gr_own"] . '</td>
					<td>' . $groupslist[$i]["gr_mems"] . '</td>
					<td>' . $groupslist[$i]["gr_type"] . '</td>
					<td>' . $groupslist[$i]["gr_fee"] . '</td>
					<td>' . $groupslist[$i]["gr_rpt_no"] . '</td>
					<td class="text-center">
						<button type="button" id="listGROUP_' . $i . '" title="List" class="btn btn-info btn-md" ><i class="fa fa-list fa-fw"></i></button> - 
						<button type="button" class="btn btn-danger btn-md" id="listDELgrp_' . $i . '" title="Delete" data-toggle="modal" data-target="#myUSRLISTDELModal_' . $i . '"><i class="fa fa-trash-o fa-fw"></i></button> - 
						' . $flagbut . '
					</td>
					</tr><div class="modal fade" id="myUSRLISTDELModal_' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content" style="color:#000;">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
					</div>
					<div class="modal-body" id="myUSRDEL_' . $i . '">
					Do you really want to delete {' . $groupslist[$i]["gr_name"] . '} <br />
					Press OK to delete ??
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deletelltDELOk_' . $i . '">Ok</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
					</div>
					</div>
					</div>
					</div>
					<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myModal_flag_Label_' . $i . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content" style="color:#000;">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModal_flag_Label_' . $i . '">Flag User entry</h4>
					</div>
					<div class="modal-body">
					Do You really want to flag the User {' . $groupslist[$i]["gr_name"] . '} entry ?? press <strong>OK</strong> to flag
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="flaglltOk_' . $i . '">Ok</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" id="flaglltCancel_' . $i . '">Cancel</button>
					</div>
					</div>
					</div>
					</div>
					<div class="modal fade" id="myModal_unflag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myModal_unflag_Label_' . $i . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content" style="color:#000;">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModal_unflag_Label_' . $i . '">UnFlag User entry</h4>
					</div>
					<div class="modal-body">
					Do You really want to UnFlag the User {' . $groupslist[$i]["gr_name"] . '} entry ?? press <strong>OK</strong> to UnFlag
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="unflaglltOk_' . $i . '">Ok</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" id="unflaglltCancel_' . $i . '">Cancel</button>
					</div>
					</div>
					</div>
					</div>
					<script>
					$(document).ready(function(){
					var ltgop = {
					group_id	:	' . $groupslist[$i]["grid"] . ',
					index		:	' . $i . ',
					listBtn		:	"#listGROUP_' . $i . '",
					editBtn 	:	"#listEDITgrp_' . $i . '",
					delBtn 		:	"#listDELgrp_' . $i . '",
					delOkBtn 	:	"#deletelltDELOk_' . $i . '",
					flagBtn 	:	"#listFLAGcgrp_' . $i . '",
					flagokBtn	:	"#flaglltOk_' . $i . '",
					unflagBtn	:	"#listUNFLAGgrp_' . $i . '",
					unflagokBtn :	"#unflaglltOk_' . $i . '",
					factid		:	"' . $fid . '",
					tabId		:	"' . $tabid . '",
					};
					var obj = new controlCustomerListGroup();
					obj.listgrptabledata(ltgop);
					});
					</script>');
            }
        }
    }

    /* This */

    public function sendMail($parameters) {
        $message = '<table width="80%" border="0" align="center" cellpadding="3" cellspacing="3">
			<tr>
			<td><p><span style="font-weight:900; font-size:24px;  color:#999;">' . GYMNAME . ' account details.</span></p></td>
			<td><img src="' . GYM_LOGO . '" width="75" alt="Gym Avatar"/></td>
			</tr>
			<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
			<td width="50%" align="right">Name :</td>
			<td width="50%">' . $parameters["name"] . '</td>
			</tr>
			<tr>
			<td width="50%" align="right">Login id :</td>
			<td width="50%">' . $parameters["login_id"] . '</td>
			</tr>
			<tr>
			<td width="50%" align="right">Password :</td>
			<td width="50%">' . $parameters["password"] . '</td>
			</tr>
			<tr>
			<td width="50%" align="right">Access Id :</td>
			<td width="50%">' . $parameters["acs_id"] . '</td>
			</tr>
			<tr>
			<td colspan="2"><p>you received this email because you are member of ' . GYMNAME . '.</p></td>
			</tr>
			<tr>
			<td colspan="2">Regards,<br />The MadMec team</td>
			</tr>
			<tr>
			<td colspan="2"><p><a href="https:</www.facebook.com/madmec2013"><img src="http:</code.madmec.com/images/f_logo.jpg" alt="" width="40" height="40" /></a> <a href="http:</www.linkedin.com/company/madmec"><img src="http:</code.madmec.com/images/li.jpg" alt="" width="40" height="40" /></a> <a href="http:</madmecteam.blogspot.in/2013_12_01_archive.html"><img src="http:</code.madmec.com/images/bs.jpg" alt="" width="40" height="40" /></a> <a href="https:</plus.google.com/103775735801000838114/posts"><img src="http:</code.madmec.com/images/gp.jpg" alt="" width="40" height="40" /></a> <a href="https:</www.google.co.in/maps/place/MadMec/@12.898059,77.588587,17z/data=!3m1!4b1!4m2!3m1!1s0x3bae153e3a2818d3:0x90da24ba7189f291"><img src="http:</code.madmec.com/images/map.jpg" alt="" width="40" height="40" /></a></p></td>
			</tr>
			<tr>
			<td colspan="2"><p><h4>Do not reply to this mail.</h4></p></td>
			</tr>
			</table>';
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

    /* This */

    public function jsonifyListOfPeoples($arrayindex) {
        $listofPeoples = (isset($_SESSION[$arrayindex]) && $_SESSION[$arrayindex] != NULL) ? $_SESSION[$arrayindex] : NULL;
        $colleagueshtml = array();
        $colleaguesimghtml = array();
        if (is_array($listofPeoples)) {
            for ($i = 0; $i < sizeof($listofPeoples); $i++) {
                $colleagueshtml[] = array(
                    "label" => $listofPeoples[$i]["name"] . ' - ' .
                    $listofPeoples[$i]["email_id"] . ' - ' .
                    $listofPeoples[$i]["cell_number"] . ' - ',
                    "id" => $listofPeoples[$i]["id"],
                    "master_pk" => $listofPeoples[$i]["master_pk"],
                    "value" => $i
                );
                $colleaguesimghtml[] = array(
                    "label" => '<img src="' . $listofPeoples[$i]["photo"] . '" height="30" width="30" alt="User Avatar" class="img-circle" />',
                    "value" => $i
                );
            }
        }/*
          $listofPeoples = array(
          "colleagueshtml" => 'var listofPeoples = '.json_encode($colleagueshtml).';',
          "colleaguesimghtml" =>	'var listofimages = '.json_encode($colleaguesimghtml).';'
          ); */
        $listofPeoples = array(
            "colleagueshtml" => (array) $colleagueshtml,
            "colleaguesimghtml" => (array) $colleaguesimghtml
        );
        return $listofPeoples;
    }

    /* Slave */

    public function listGroupMembers() {
        $listofPeoples = NULL;
        $colleagueshtml = array();
        $colleaguesimghtml = array();
        $jsondata = array(
            "html" => str_replace($this->order, $this->replace, '<div class="row"><div class="col-lg-12">&nbsp;</div>
					<div class="col-lg-12"><strong>No customers found for this criteria.</strong></div></div>'),
            "listofPeoples" => $colleagueshtml,
            "listofimages" => $colleaguesimghtml,
            "total" => 0,
            "listdiv" => '',
            "mem_counter" => '',
            "mem_remaining" => '',
            "mem_sent" => '',
            "msg_to" => '',
            "item" => '',
            "removeme" => '',
            "reset" => '',
            "clear" => '',
            "save" => '',
            "array" => 'listofreg',
            "status" => false
        );
        $obj = new addcustomer();
        $obj->listRegCust(false);
        $listofPeoples = $this->jsonifyListOfPeoples('listofreg');
        $colleagueshtml = $listofPeoples["colleagueshtml"];
        $colleaguesimghtml = $listofPeoples["colleaguesimghtml"];
        if (sizeof($listofPeoples) > 0) {
            $counter = sizeof($_SESSION['listofreg']);
            $jsondata = array(
                "html" => str_replace($this->order, $this->replace, '<div class="row"><div class="col-lg-12">&nbsp;</div>
						<div class="col-lg-12">
						<div class="chat-panel panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-comments fa-fw"></i>
							Selected : (<div id="mem_counter" style="display:inline;">0</div>)&nbsp;
							Remaining : (<div id="mem_remaining" style="display:inline;">' . $counter . '</div>)&nbsp;
							Sent : (<div id="mem_sent" style="display:inline;">0</div>)&nbsp;
							<div class="btn-group pull-right">
							<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-chevron-down"></i>
							</button>
							<ul class="dropdown-menu slidedown">
								<li>
								<a href="#" id="_reset">
									<i class="fa fa-refresh fa-fw"></i> Refresh
								</a>
								</li>
								<li>
								<a href="#" id="_clear">
									<i class="fa fa-check-circle fa-fw"></i> Clear
								</a>
								</li>
							</ul>
							</div>
						</div>
						<div class="panel-body" style="height:200px;">
							<ul class="chat" id="selectedusers_prod"></ul>
						</div>
						<div class="panel-footer">
								<div class="form-group">
									<div class="input-group input-group-lg">
										<input class="form-control" id="msg_to" name="msg_to" type="text" placeholder="Select customers to add in group."/>
										<span class="input-group-addon text-warning"><i class="fa fa-users fa-fw"></i></span>
									</div>
								</div>
							</div>
						</div>
					</div></div></div>'),
                "listofPeoples" => $colleagueshtml,
                "listofimages" => $colleaguesimghtml,
                "total" => sizeof($_SESSION['listofreg']),
                "listdiv" => '#selectedusers_prod',
                "mem_counter" => '#mem_counter',
                "mem_remaining" => '#mem_remaining',
                "mem_sent" => '#mem_sent',
                "msg_to" => '#msg_to',
                "item" => 'item_',
                "removeme" => 'removeme_',
                "reset" => '#_reset',
                "clear" => '#_clear',
                "save" => '#compsend',
                "array" => 'listofreg',
                "status" => true
            );
        }
        return $jsondata;
    }

}
?>