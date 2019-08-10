<?php
	class PageLoad {
		protected $parameters = array();
		private $order = array("\r\n", "\n", "\r", "\t");
		private $replace = '';
		function __construct($para = false) {
			$this->parameters = $para;
		}
		public function LoadGymNames() {
			$htm = '';
			if(isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]) && is_array($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"])){
				$htm .= str_replace($this->order, $this->replace,'<div class="row">
				<div class="col-lg-12">
				<div class="panel panel-danger">
				<div class="panel-heading">
				<h4>' . ucwords($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) . '\'s Club</h4>
				</div>
				<div class="panel-body">');
				for ($i = 0; $i <= sizeof($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]) - 1; $i++) {
					$htm .= str_replace($this->order, $this->replace,'<div class="col-lg-3 col-md-6">
					<div class="panel panel-primary">
					<div class="panel-heading">
					<div class="row">
					<div class="col-xs-3"><img src="' . LOGO_1 . '" class="img-circle" width="50" /></div>
					<div class="col-xs-9 text-right">
					<div class="huge">&nbsp;</div>
					<div>' . ucwords($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]["GYM_NAME"]) . '</div>
					</div>
					</div>
					</div>
					<a href="javascript:void(0)" class="gymLink" id="' . $i . '" data-toggle="modal" data-target="#myGYMSelectModal_' . $i . '">
					<div class="panel-footer gymlist_' . ucwords($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]["GYM_NAME"]) . '" id="' . $i . '">
					<span class="pull-left">Select Club</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
					</div>
					</a>
					</div>
					</div>
					<div class="modal fade" id="myGYMSelectModal_' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myGYMSelectModalLabel_' . $i . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog ">
					<div class="modal-content">
					<div class="modal-header">
					<div style="float:right"><button type="button" class="btn btn-success" data-dismiss="modal" >Ok</button></div>
					<div style="float:left">
					<h4 class="modal-title" id="myGYMSelectModalLabel_' . $i . '">' . $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]["GYM_NAME"] . ' Selected</h4>
					</div>
					<br /><br />
					</div>
					</div>
					</div>
					</div>');
				}
				$htm .= str_replace($this->order, $this->replace,'</div><!-- panel body -->
				</div>
				</div><!-- col-lg-12 -->
				</div><script>
				$(document).ready(function(){
				var gymdynamic = {
				nav : 	".gymLink",
				outdiv	: "#printrs",
				};
				var obj=new load_dashboard();
				obj.selectGYM(gymdynamic);
				});</script>');
			}
			$gymload = array(
				"htm" => (string) $htm,
			);
			return $gymload;
		}
		public function fetchUserRequest() {
			if ($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "Owner") {
				$query = 'SELECT usreq.*,
				up.user_name,
				up.email_id,
				up.cell_number,
				gp.gym_name,
				gp.email,
				gp.gym_type,
				gp.addressline,
				gp.town,
				gp.city
				FROM userrequest usreq
				LEFT JOIN userprofile_gymprofile upgp
				ON upgp.id=usreq.upgp_id
				LEFT JOIN gym_profile gp
				ON gp.id=upgp.gym_id
				LEFT JOIN user_profile up
				ON up.id=upgp.user_pk
				WHERE usreq.status=4
				AND upgp.status=14
				AND usreq.ownerid= ' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]);
				$result = executeQuery($query);
				return mysql_num_rows($result);
			}
		}
		public function fetchCustRequest() {
			$in = '';
			if (sizeof($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"])) {
				for ($i = 0; $i < sizeof($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]); $i++) {
					if ($i == sizeof($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]) - 1) {
						$in .=$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]['GYM_ID'];
						} else {
						$in .=$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]['GYM_ID'] . ',';
					}
				}
				$query = 'SELECT * FROM `customer_request` WHERE `status`=14 AND `gym_id` IN(' . $in . ');';
				$result = executeQuery($query);
				return mysql_num_rows($result);
			}
		}
		public function fetchUserRequestDetails() {
			if ($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "Owner") {
				$query = 'SELECT usreq.*,
				up.`user_name`,
				up.`email_id`,
				up.`cell_number`,
				gp.`gym_name`,
				gp.`email`,
				gp.`gym_type`,
				gp.`addressline`,
				gp.`town`,
				gp.`city`
				FROM `userrequest` usreq
				LEFT JOIN `userprofile_gymprofile` upgp
				ON upgp.`id`=usreq.`upgp_id`
				LEFT JOIN `gym_profile` gp
				ON gp.`id`=upgp.`gym_id`
				LEFT JOIN `user_profile` up
				ON up.`id`=upgp.`user_pk`
				WHERE usreq.`status`=4
				AND upgp.`status`=14
				AND usreq.`ownerid`= ' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]);
			}
			$result = executeQuery($query);
			$fetchdata = array();
			$ugpgids = array();
			$data = '';
			if (mysql_num_rows($result)) {
				while ($row = mysql_fetch_assoc($result)) {
					$fetchdata[] = $row;
				}
				for ($i = 0; $i < sizeof($fetchdata); $i++) {
					$data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['user_name'] . ' - ' . $fetchdata[$i]['email_id'] . ' - ' . $fetchdata[$i]['cell_number'] . '  </td>'
					. '<td>' . $fetchdata[$i]['gym_name'] . ' - ' . $fetchdata[$i]['email'] . ' - ' . $fetchdata[$i]['addressline'] . ' - ' . $fetchdata[$i]['town'] . ' - ' . $fetchdata[$i]['city'] . ' - </td>'
					. '<td><button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal_open' . $fetchdata[$i]['upgp_id'] . '" title="Accept" id="myModal_enqaddbtn">Accept</button>
					<div class="modal fade" id="myModal_open' . $fetchdata[$i]['upgp_id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_open" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModal_title">
					<i class="fa fa-bell fa-fw fa-x2"/> Accept</h4>
					</div>
					<div class="modal-body" id="myModal_enqaddbody">
					Do you Really Want to Accept This Request
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal" id="accep_' . $fetchdata[$i]['upgp_id'] . '">OK</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
					</div>
					</div>
					</div>
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal_open1' . $fetchdata[$i]['upgp_id'] . '" title="Accept" id="myModal_enqaddbtn">Reject</button>
					<div class="modal fade" id="myModal_open1' . $fetchdata[$i]['upgp_id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_open" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModal_title">
					<i class="fa fa-bell fa-fw fa-x2"/> Reject</h4>
					</div>
					<div class="modal-body" id="myModal_enqaddbody">
					Do you Really Want to Delete This Request
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal" id="delt_' . $fetchdata[$i]['upgp_id'] . '">OK</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
					</div>
					</div>
					</div>
					</td>'
					. '</tr>';
					$ugpgids[$i] = $fetchdata[$i]['upgp_id'];
				}
				$jsondata = array(
                "status" => "success",
                "data" => $data,
                "ugpgids" => $ugpgids
				);
				return $jsondata;
				exit(0);
				} else {
				$jsondata = array(
                "status" => "failure",
                "data" => NULL,
                "ugpgids" => NULL
				);
				return $jsondata;
				exit(0);
			}
		}
		public function fetchCustRequestDetails() {
			$in = '';
			if (sizeof($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"])) {
				for ($i = 0; $i < sizeof($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]); $i++) {
					if ($i == sizeof($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]) - 1) {
						$in .=$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]['GYM_ID'];
						} else {
						$in .=$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]['GYM_ID'] . ',';
					}
				}
				$query = 'SELECT up.*,
				cr.id AS upgp_id,
				gen.gender_name AS gend
				FROM `customer_request` cr
				LEFT JOIN user_profile up
				ON up.id=cr.user_pk
				LEFT JOIN gender gen
				ON gen.id=up.gender
				WHERE `gym_id` IN(' . $in . ') AND cr.`status`=14;';
				$result = executeQuery($query);
				$fetchdata = array();
				$ugpgids = array();
				$data = '';
				if (mysql_num_rows($result)) {
					while ($row = mysql_fetch_assoc($result)) {
						$fetchdata[] = $row;
					}
					for ($i = 0; $i < sizeof($fetchdata); $i++) {
						$data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['user_name'] . ' </td><td> ' . $fetchdata[$i]['email_id'] . '</td><td>' . $fetchdata[$i]['gend'] . '  </td>'
						. '<td><button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal_open' . $fetchdata[$i]['upgp_id'] . '" title="Accept" id="myModal_enqaddbtn">Accept</button>&nbsp;&nbsp;
						<div class="modal fade" id="myModal_open' . $fetchdata[$i]['upgp_id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_open" aria-hidden="true" style="display: none;">
						<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModal_title">
						<i class="fa fa-bell fa-fw fa-x2"/> Accept</h4>
						</div>
						<div class="modal-body" id="myModal_enqaddbody">
						Do you Really Want to Accept This Request
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal" id="accep_' . $fetchdata[$i]['upgp_id'] . '">OK</button>&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						</div>
						</div>
						</div>
						</div>
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal_open1' . $fetchdata[$i]['upgp_id'] . '" title="Accept" id="myModal_enqaddbtn">Reject</button>
						<div class="modal fade" id="myModal_open1' . $fetchdata[$i]['upgp_id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_open" aria-hidden="true" style="display: none;">
						<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModal_title">
						<i class="fa fa-bell fa-fw fa-x2"/> Reject</h4>
						</div>
						<div class="modal-body" id="myModal_enqaddbody">
						Do you Really Want to Delete This Request
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal" id="delt_' . $fetchdata[$i]['upgp_id'] . '">OK</button>&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						</div>
						</div>
						</div>
						</div>
						</td>'
						. '</tr>';
						$ugpgids[$i] = $fetchdata[$i]['upgp_id'];
					}
					$jsondata = array(
                    "status" => "success",
                    "data" => $data,
                    "ugpgids" => $ugpgids
					);
					return $jsondata;
					exit(0);
					} else {
					$jsondata = array(
                    "status" => "failure",
                    "data" => NULL,
                    "ugpgids" => NULL
					);
					return $jsondata;
					exit(0);
				}
			}
		}
		public function AcceptnReject() {
			if ($this->parameters['req'] == "accept") {
				$query = 'UPDATE `userprofile_gymprofile` SET `status`=11 WHERE `id`=' . mysql_real_escape_string($this->parameters['reqid']);
				executeQuery($query);
				} else {
				$query = 'UPDATE `userprofile_gymprofile` SET `status`=6 WHERE `id`=' . mysql_real_escape_string($this->parameters['reqid']);
				executeQuery($query);
			}
			$query = 'UPDATE `userrequest` SET `status`=6 WHERE `upgp_id`=' . mysql_real_escape_string($this->parameters['reqid']);
			executeQuery($query);
			$jsondata = array(
            "status" => "success",
            "req" => $this->parameters['req']
			);
			return $jsondata;
		}
		public function custAcceptnReject() {
			if ($this->parameters['req'] == "accept") {
				$query = 'SELECT * FROM `customer_request` cr
				LEFT JOIN gym_profile gp
				on gp.id=cr.gym_id
				WHERE cr.`status`=14 AND cr.`id`=' . mysql_real_escape_string($this->parameters['reqid']) . ';';
				$result = executeQuery($query);
				if (mysql_num_rows($result)) {
					$row = mysql_fetch_assoc($result);
					$query = 'INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`)VALUES(NULL,'
					. '"' . mysql_real_escape_string($row['user_pk']) . '",'
					. '"' . mysql_real_escape_string($row['gym_id']) . '",'
					. '11)';
					executeQuery($query);
					$query = 'UPDATE `customer_request` SET `status`=4 WHERE `id`=' . mysql_real_escape_string($this->parameters['reqid']) . ';';
					executeQuery($query);
					$this->addCustomerToSlaveDB($row);
				}
				} else {
				$query = 'UPDATE `customer_request` SET `status`=6 WHERE `id`=' . mysql_real_escape_string($this->parameters['reqid']) . ';';
				executeQuery($query);
			}
			$jsondata = array(
            "status" => "success",
            "req" => $this->parameters['req']
			);
			return $jsondata;
		}
		public function addCustomerToSlaveDB($row) {
			$query='SELECT * FROM `user_profile` WHERE `id`='.$row['user_pk'].';';
			$result=  executeQuery($query);
			if(mysql_num_rows($result))
			{
				$row1=  mysql_fetch_assoc($result);
				$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
				if (get_resource_type($link) == 'mysql link') {
                    if (($db_select = selectDB($row['db_name'], $link)) == 1) {
                        $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
						\'' . mysql_real_escape_string($row1["photo_id"]) . '\',
						NULL,
						NULL,NULL,NULL,NULL,NULL);';
						if (executeQuery($query1)) {
							$photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
							//$obj->updateSlavePhoto($dbpath,$photo_id);
							$query2 = 'INSERT INTO `customer`
							(`id`,
							`name`,
							`email`,
							`acs_id`,
							`photo_id`,
							`directory`,
							`cell_code`,
							`cell_number`,
							`occupation`,
							`company`,
							`dob`,
							`sex`,
							`date_of_join`,
							`master_pk`,
							`status`) VALUES
							(NULL,
							\'' . mysql_real_escape_string($row1["user_name"]) . '\',
							\'' . mysql_real_escape_string($row1["email_id"]) . '\',
							\'' . mysql_real_escape_string($row1["acsid"]) . '\',
							\'' . mysql_real_escape_string($photo_pk) . '\',
							\'' . mysql_real_escape_string($row1["directory"]) . '\',
							\'' . mysql_real_escape_string('+91') . '\',
							\'' . mysql_real_escape_string($row1["cell_num"]) . '\',
							\'' . mysql_real_escape_string('NULL') . '\',
							\'' . mysql_real_escape_string('NULL') . '\',
							\'' . mysql_real_escape_string('NULL') . '\',
							\'' . mysql_real_escape_string($row1["gender"]) . '\',
							CURRENT_TIMESTAMP,
							\'' . mysql_real_escape_string($row1["id"]) . '\',
							2)';
							executeQuery($query2);
						}
					}
				}
				if (get_resource_type($link) == 'mysql link')
				mysql_close($link);
			}
		}
		//fetch owner Users
		public function fetchOwnerUser() {
			$query = "SELECT up.*,
			GROUP_CONCAT(upgp.`id`,'☻☻') AS asingymid,
			GROUP_CONCAT(gp.`gym_name`,'☻☻') AS gymname,
			GROUP_CONCAT(gp.`email`,'☻☻') AS gymemail,
			GROUP_CONCAT(gp.`gym_type`,'☻☻') AS gymtype,
			GROUP_CONCAT(gp.`addressline`,'☻☻') AS gymaddress,
			GROUP_CONCAT(gp.`town`,'☻☻') AS gymtown,
			GROUP_CONCAT(gp.`city`,'☻☻') AS gymcity
			FROM `userprofile_gymprofile` upgp
			LEFT JOIN `gym_profile` gp
			ON gp.`id`=upgp.`gym_id`
			LEFT JOIN `user_profile` up
			ON up.`id`=upgp.`user_pk`
			LEFT JOIN `userprofile_type` upt
			ON upt.`user_pk`=up.`id`
			LEFT JOIN `user_type` ut
			ON ut.`id`=upt.`usertype_id`
			WHERE upgp.`gym_id` IN (SELECT upgp.`gym_id`
			FROM `userprofile_gymprofile` upgp
			LEFT JOIN `gym_profile` gp
			ON gp.`id`=upgp.`gym_id`
			LEFT JOIN `user_profile` up
			ON up.`id`=upgp.`user_pk`
			WHERE upgp.`user_pk`=" . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]) . "
			GROUP BY upgp.`gym_id`)
			AND upt.`usertype_id`=3
			AND upgp.`status`=11
			GROUP BY up.`id`";
			$result = executeQuery($query);
			$fetchdata = array();
			$data = '';
			$userids = array();
			$flagids = array();
			$unflagids = array();
			$assigngymids = array();
			if (mysql_num_rows($result)) {
				while ($row = mysql_fetch_assoc($result)) {
					$fetchdata[] = $row;
				}
				for ($i = 0; $i < sizeof($fetchdata); $i++) {
					$data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['user_name'] . ' -- ' . $fetchdata[$i]['email_id'] . '-- ' . $fetchdata[$i]['cell_number'] . '</td><td><table>';
					$tempgymname = explode('☻☻', $fetchdata[$i]['gymname']);
					$tempgymemail = explode('☻☻', $fetchdata[$i]['gymemail']);
					$tempgymaddress = explode('☻☻', $fetchdata[$i]['gymaddress']);
					$tempgymtown = explode('☻☻', $fetchdata[$i]['gymtown']);
					$tempgymcity = explode('☻☻', $fetchdata[$i]['gymcity']);
					$tempgymassnids = explode('☻☻', $fetchdata[$i]['asingymid']);
					if (is_array($tempgymname) && sizeof($tempgymname) > 0)
                    for ($j = 0; $j < sizeof($tempgymname) && $tempgymname[$j] != ""; $j++) {
                        $data .='<tr><td><span class="text-left">' . ($j + 1) . ' -- ' . trim($tempgymname[$j], ',') . ' -- ' . trim($tempgymemail[$j], ',') . ' -- ' . trim($tempgymemail[$j], ',') . ' -- ' . trim($tempgymtown[$j], ',') . ' -- ' . trim($tempgymcity[$j], ',') . ' -- </span></td>';
                        $data .='<td><span class="pull-right"><button type="button" class="btn btn-danger" title="Delete GYM" data-toggle="modal" data-target="#myModal_open22' . trim($tempgymassnids[$j], ',') . '"><i class="fa fa-trash" id="deletegydm_' . $fetchdata[$i]['id'] . '"></i></button></span>';
                        $data .='<div class="modal fade" id="myModal_open22' . trim($tempgymassnids[$j], ',') . '" tabindex="-1" role="dialog" aria-labelledby="myModal_open" aria-hidden="true" style="display: none;">
						<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModal_title">
						<i class="fa fa-bell fa-fw fa-x2"/>Delete GYM</h4>
						</div>
						<div class="modal-body" id="myModal_enqaddbody">
						Do You Really Want to Delete this for User
						</div>
						<div class="modal-footer">
						<button type="buttton" class="btn btn-success" data-dismiss="modal" id="deletegym_' . trim($tempgymassnids[$j], ',') . '">OK</button>&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						</div>
						</div>
						</div>
						</div></td></tr>';
                        $assigngymids[] = trim($tempgymassnids[$j], ',');
					}
					$data .='</table></td>';
					$data .='<td><button type="button" class="btn btn-info" title="Change Password" data-toggle="modal" data-target="#myModal_open' . $fetchdata[$i]['id'] . '"><i class="fa fa-edit fa-fw" id="changepass_' . $fetchdata[$i]['id'] . '"></i></button></td>';
					$data .='<div class="modal fade" id="myModal_open' . $fetchdata[$i]['id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_open" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModal_title">
					<i class="fa fa-bell fa-fw fa-x2"/> Change Password</h4>
					</div>
					<div class="modal-body" id="myModal_enqaddbody">
					<div class="col-lg-12">&nbsp;</div>
					<div class="col-lg-12">
					<div class="col-lg-6">
					<input type="password" name="newpass' . $fetchdata[$i]['id'] . '" placeholder="New Password" id="newpass' . $fetchdata[$i]['id'] . '" class="form-control" required=""/>
					</div>
					</div>
					<div class="col-lg-12">&nbsp;</div>
					<div class="col-lg-12">
					<div class="col-lg-6">
					<input type="password" name="cnfpass' . $fetchdata[$i]['id'] . '" placeholder="Confirm Password" id="cnfpass' . $fetchdata[$i]['id'] . '" class="form-control" required=""/>
					<input type="hidden" name="regid_' . $fetchdata[$i]['id'] . '" id="regid_' . $fetchdata[$i]['id'] . '" value="' . $fetchdata[$i]['id'] . '" class="form-control"/>
					</div>
					</div>
					</div>
					<div class="modal-footer">
					<button type="buttton" class="btn btn-success" data-dismiss="modal" id="changepass_' . $fetchdata[$i]['id'] . '">OK</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
					</div>
					</div>
					</div>';
					if ((int) $fetchdata[$i]['status'] == 11) {
						$data .='<td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal_open1' . $fetchdata[$i]['id'] . '" title="Flag"><i class="fa fa-flag fa-fw" id="sdd' . $fetchdata[$i]['id'] . '"></i>&nbsp;Flag</button></td>';
						$flagids[] = $fetchdata[$i]['id'];
						} else {
						$data .='<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal_open1' . $fetchdata[$i]['id'] . '" title="UnFlag"><i class="fa fa-flag fa-fw" id="sdd' . $fetchdata[$i]['id'] . '"></i>&nbsp;UnFlag</button></td>';
						$unflagids[] = $fetchdata[$i]['id'];
					}
					$data .='<div class="modal fade" id="myModal_open1' . $fetchdata[$i]['id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_open" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModal_title">
					<i class="fa fa-bell fa-fw fa-x2"/> Alert</h4>
					</div>
					<div class="modal-body" id="myModal_enqaddbody">';
					if ((int) $fetchdata[$i]['status'] == 11) {
						$data .=' Do you Really Want to Flag This User';
						} else {
						$data .=' Do you Really Want to UnFlag This User';
					}
					$data .='                    </div>
					<div class="modal-footer">';
					if ((int) $fetchdata[$i]['status'] == 11) {
						$data .='  <button type="button" class="btn btn-success" data-dismiss="modal" id="flag_' . $fetchdata[$i]['id'] . '">OK</button>&nbsp;&nbsp;&nbsp;';
						} else {
						$data .='  <button type="button" class="btn btn-success" data-dismiss="modal" id="unflag_' . $fetchdata[$i]['id'] . '">OK</button>&nbsp;&nbsp;&nbsp;';
					}
					$data .=' <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
					</div>
					</div>
					</div>';
					$data .= '</tr>';
					$userids[$i] = $fetchdata[$i]['id'];
				}
				$jsondata = array(
                "status" => "success",
                "data" => $data,
                "userid" => $userids,
                "flagids" => $flagids,
                "unflagids" => $unflagids,
                "assigngyms" => $assigngymids,
				);
				return $jsondata;
				} else {
				$jsondata = array(
                "status" => "failure",
                "data" => NULL
				);

			}
                        return $jsondata;
		}
		public function makeFlagnUnflag() {
			if ($this->parameters['req'] == "flag") {
				$query = 'UPDATE `user_profile` SET `status`=7 WHERE `id`=' . mysql_real_escape_string($this->parameters['reqid']) . ';';
				executeQuery($query);
				} else {
				$query = 'UPDATE `user_profile` SET `status`=11 WHERE `id`=' . mysql_real_escape_string($this->parameters['reqid']) . ';';
				executeQuery($query);
			}
			$jsondata = array(
            "status" => "success",
            "req" => $this->parameters['req']
			);
			return $jsondata;
		}
		public function userDeleteGym() {
			$query = 'UPDATE `userprofile_gymprofile` SET `status`=6 WHERE `id`=' . mysql_real_escape_string($this->parameters['gymid']) . ';';
			executeQuery($query);
			$jsondata = array(
            "status" => "success",
            "req" => $this->parameters['req']
			);
			return $jsondata;
		}
		public function changeUserPassword() {
			$query = 'UPDATE `user_profile` SET `password`="' . mysql_real_escape_string($this->parameters['newpass']) . '" WHERE `id`=' . mysql_real_escape_string($this->parameters['regid']) . ';';
			executeQuery($query);
			$jsondata = array(
            "status" => "success",
            "req" => $this->parameters['reqid']
			);
			return $jsondata;
		}
		public function setGYM($id) {
			$_SESSION["SETGYM"] = array(
            "GYM_ID" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_ID"],
            "GYM_NAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_NAME"],
            "GYM_HOST" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_HOST"],
            "GYM_USERNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_USERNAME"],
            "GYM_DB_NAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_DB_NAME"],
            "GYM_DB_PASSWORD" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_DB_PASSWORD"],
			);
			echo ucwords($_SESSION["SETGYM"]["GYM_NAME"]);
			exit(0);
		}
		public function loadSingleDash() {
			$activeMem = '';
			$newReg = '';
			$totIncome = '';
			$count = 0;
			$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
			$activeMem .= '<div class="row">
			<div class="col-lg-12">
			<div class="panel panel-danger">
			<div class="panel-heading">
			<h4>Active Customers</h4>
			</div>
			<div class="panel-body">';
			$limit = date('Y-m', strtotime('-3 months')); //direct calculating the month
			$temp = explode('-', $limit);
			$year = $temp[0];
			$month = $temp[1];
			$color = ["green", "custom1", "yellow", "red"];
			/* TO display Active Members every month */
			for ($i = 0; $i < 4; $i++) {
				if ($month == 13) {
					$month = 1;
					$year++;
					} else {
					$month = $month + 0;
				}
				$month = ($month < 10) ? "0" . $month : $month;
				$count = mysql_num_rows(executeQuery("SELECT  DISTINCT `customer_pk` FROM `fee` WHERE `valid_from` <= '" . $year . "-" . $month . "-31 00:00:00' AND `valid_till` >=  '" . $year . "-" . $month . "-01 00:00:00';"));
				$activeMem .= '<div class="col-lg-3 col-md-6">
				<div class="panel panel-' . $color[$i % 4] . '">
				<div class="panel-heading">
				<div class="row">
				<div class="col-xs-3">
				<i class="fa fa-users fa-4x"></i>
				</div>
				<div class="col-xs-9 text-right">
				<div class="huge">' . $count . '</div>
				<div><b>Active Members <br /> ' . $mons[$month - 0] . '/' . $year . '</b></div>
				</div>
				</div>
				</div>
				</div>
				</div>';
				$month++;
			}
			/* TO display new registration every month */
			$activeMem .= '</div><!-- panel body -->
			</div>
			</div><!-- col-lg-12 -->
			</div>';
			$count = 0;
			$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
			$newReg .= '<div class="row">
			<div class="col-lg-12">
			<div class="panel  panel-danger">
			<div class="panel-heading">
			<h4>Total New Registration/Customers</h4>
			</div>
			<div class="panel-body">';
			$limit = date('Y-m', strtotime('-3 months')); //direct calculating the month
			$temp = explode('-', $limit);
			$year = $temp[0];
			$month = $temp[1];
			$color = ["green", "custom1", "yellow", "red"];
			/* TO display Active Members every month */
			for ($i = 0; $i < 4; $i++) {
				if ($month == 13) {
					$month = 1;
					$year++;
					} else {
					$month = $month + 0;
				}
				$month = ($month < 10) ? "0" . $month : $month;
				$count = mysql_num_rows(executeQuery("SELECT * FROM `customer` WHERE `date_of_join` BETWEEN '" . $year . "-" . $month . "-01 00:00:00' AND '" . $year . "-" . $month . "-31 00:00:00';"));
				$newReg .= '<div class="col-lg-3 col-md-6">
				<div class="panel panel-' . $color[$i % 4] . '">
				<div class="panel-heading">
				<div class="row">
				<div class="col-xs-3">
				<i class="fa fa-rocket fa-4x"></i>
				</div>
				<div class="col-xs-9 text-right">
				<div class="huge">' . $count . '</div>
				<div><b>Total New Registration <br /> ' . $mons[$month - 0] . '/' . $year . '</b></div>
				</div>
				</div>
				</div>
				</div>
				</div>';
				$month++;
			}
			/* TO display new registration every month */
			$newReg .= '</div><!-- panel body -->
			</div>
			</div><!-- col-lg-12 -->
			</div>';
			$count = 0;
			$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
			$totIncome .= '<div class="row">
			<div class="col-lg-12">
			<div class="panel  panel-danger">
			<div class="panel-heading">
			<h4>Total Income</h4>
			</div>
			<div class="panel-body">';
			$limit = date('Y-m', strtotime('-3 months')); //direct calculating the month
			$temp = explode('-', $limit);
			$year = $temp[0];
			$month = $temp[1];
			$color = ["green", "custom1", "yellow", "red"];
			/* TO display Active Members every month */
			for ($i = 0; $i < 4; $i++) {
				$total = 0;
				if ($month == 13) {
					$month = 1;
					$year++;
					} else {
					$month = $month + 0;
				}
				$month = ($month < 10) ? "0" . $month : $month;
				$query = "SELECT `total_amount` FROM `money_transactions` WHERE `pay_date` BETWEEN '" . $year . "-" . $month . "-01 00:00:00' AND '" . $year . "-" . $month . "-31 00:00:00';";
				$res = executeQuery($query);
				$j = 1;
				while ($row = mysql_fetch_assoc($res)) {
					$total = $total + $row['total_amount'];
					$j++;
				}
				$totIncome .= '<div class="col-lg-3 col-md-6">
				<div class="panel panel-' . $color[$i % 4] . '">
				<div class="panel-heading">
				<div class="row">
				<div class="col-xs-3">
				<i class="fa fa-inr fa-4x"></i>
				</div>
				<div class="col-xs-9 text-right">
				<div class="huge">' . $total . '</div>
				<div><b>Total Income<br />(including due) <br /> ' . $mons[$month - 0] . '/' . $year . '</b></div>
				</div>
				</div>
				</div>
				</div>
				</div>';
				$month++;
			}
			/* TO display new registration every month */
			$totIncome .= '</div><!-- panel body -->
			</div>
			</div><!-- col-lg-12 -->
			</div>';
			$data = array(
            "one" => $activeMem,
            "two" => $newReg,
            "thr" => $totIncome,
            "nm" => $this->parameters["GYMNAME"],
			);
			return $data;
		}
		public function addfacility($factNm, $factST) {
			$result = false;
			$dupquery = 'SELECT `id` FROM `facility` WHERE `name` = "' . $factNm . '"';
			$result = executeQuery($dupquery);
			if (mysql_num_rows($result) > 0) {
				echo "duplicate";
				return;
			}
			$query = 'INSERT INTO `facility` (`id`, `name`, `status`) VALUES (NULL, "' . $factNm . '",' . $factST . ');';
			$result = executeQuery($query);
			if ($result) {
				echo "success";
				} else {
				echo "unsuccess";
			}
		}
		public function showhidefacility() {
			$result = false;
			$i = 0;
			$num = 0;
			$query = 'SELECT ft.`id` AS fact_id,
			ft.`name` AS fact_name
			FROM `facility` as ft,
			`status` as st
			WHERE ft.`status`= st.`id` AND
			st.`statu_name`="Hide" AND st.`status`=1
			ORDER BY(ft.`name`);';
			$result = executeQuery($query);
			$num = mysql_num_rows($result);
			if ($num != 0) {
				$i = 0;
				echo '<div class="row">';
				while ($row = mysql_fetch_assoc($result)) {
					$i++;
					$fid = $row["fact_id"];
					echo str_replace($this->order, $this->replace, '<div class="col-lg-12" id="actfacility_' . $fid . '">
					<div class="panel panel-info">
					<div class="panel-heading">
					<div class="row">
					<div class="col-lg-12">
					<div class="col-lg-6 text-left">' . ucwords($row["fact_name"]) . '</div>
					<div class="col-lg-6 text-right"><a href="javascript:void(0)" class="btn btn-success" id="actlistfactall_' . $fid . '">Activate</a></div>
					</div>
					</div>
					</div>
					</div>
					</div>');
					echo '<script>
					$(document).ready(function(){
					$("#actlistfactall_' . $fid . '").click(function(){
					var ft = {
					action		:	"showhide",
					outdiv2		:	"#actfacility_' . $fid . '",
					outdiv1		:	"' . $fid . '",
					factNm		:	"' . ucwords($row["fact_name"]) . '"
					};
					var obj=new controlManageTwo();
					obj.handlefacility(ft);
					});
					});
					</script>';
				}
				echo '</div>';
				} else {
				return false;
			}
		}
		public function showhideft($id) {
			$result = false;
			$query = 'UPDATE `facility` SET status=(SELECT id FROM `status` WHERE statu_name="Show" and status=1) WHERE id=' . $id . '';
			$result = executeQuery($query);
			if ($result)
            echo 'success';
		}
		public function getfacility($id) {
			$result = false;
			$i = 0;
			$query = 'SELECT ft.`id` AS fact_id,
			ft.`name` AS fact_name
			FROM `facility` as ft,
			`status` as st
			WHERE ft.`status`= st.`id` AND
			st.`statu_name`="Show" AND st.`status`=1
			ORDER BY(ft.`name`);';
			$result = executeQuery($query);
			echo '<div class="row">';
			while ($row = mysql_fetch_assoc($result)) {
				$i++;
				$_SESSION["facility"][$i]["name"] = ucwords($row["fact_name"]);
				$_SESSION["facility"][$i]["id"] = $row["fact_id"];
				$fid = $row["fact_id"];
				echo str_replace($this->order, $this->replace, '<div class="col-lg-12" id="allfacility_' . $fid . '">
				<div class="panel panel-info">
				<div class="panel-heading">
				<div class="row">
				<div class="col-lg-12">
				<div class="col-lg-6 text-left">' . ucwords($row["fact_name"]) . '</div>
				<div class="col-lg-6 text-right"><a href="javascript:void(0)" class="btn btn-danger" id="listfactall_' . $fid . '">DeActivate</a></div>
				</div>
				</div>
				</div>
				</div>
				</div>');
				echo '<script>
				$(document).ready(function(){
				$("#listfactall_' . $fid . '").click(function(){
				var ft = {
				action		:	"deactiveFact",
				outdiv2		:	"#allfacility_' . $fid . '",
				outdiv1		:	"' . $fid . '",
				factNm		:	"' . $_SESSION["facility"][$i]["name"] . '"
				};
				var obj=new controlManageTwo();
				obj.handlefacility(ft);
				});
				});
				</script>';
			}
			echo '</div>';
		}
		public function getallfacility() {
			$result = false;
			$i = 0;
			$query = 'SELECT ft.`id` AS fact_id,
			ft.`name` AS fact_name
			FROM `facility` as ft,
			`status` as st
			WHERE ft.`status`= st.`id` AND
			st.`statu_name`="Show" AND st.`status`=1';
			$result = executeQuery($query);
			echo '<select name="of_facility" id="of_facility" class="form-control">
			<option value=null>Select Facility</option>';
			while ($row = mysql_fetch_assoc($result)) {
				echo '<option value=' . $row["fact_id"] . ' >' . ucwords($row["fact_name"]) . '</option>';
			}
			echo '</select></span><p class="help-block" id="valid_fact">&nbsp;</p>';
		}
		public function getallfacility1($id) {
			$result = false;
			$i = 0;
			$query = 'SELECT ft.`id` AS fact_id,
			ft.`name` AS fact_name
			FROM `facility` as ft,
			`status` as st
			WHERE ft.`status`= st.`id` AND
			st.`statu_name`="Show" AND st.`status`=1';
			$result = executeQuery($query);
			echo '<select name="of_facility" id="of_facility" class="form-control">
			<option value=null>Select Facility</option>';
			while ($row = mysql_fetch_assoc($result)) {
				if ($id == $row["fact_id"]) {
					echo '<option selected value=' . $row["fact_id"] . ' >' . ucwords($row["fact_name"]) . '</option>';
					} else {
					echo '<option value=' . $row["fact_id"] . ' >' . ucwords($row["fact_name"]) . '</option>';
				}
			}
			echo '</select></span><p class="help-block" id="valid_fact">&nbsp;</p>';
		}
		public function getallduration() {
			$result = false;
			$query = 'SELECT ofd.`id` AS duration_id,
			ofd.`duration` AS duration_name,
			ofd.`days` AS days
			FROM `offerduration` as ofd,
			`status` as st
			WHERE ofd.`status`= st.`id` AND
			st.`statu_name`="Show" AND st.`status`=1';
			$result = executeQuery($query);
			echo '<select name="cust_duration" id="cust_duration" class="form-control">
			<option value=null>Select Duration</option>';
			while ($row = mysql_fetch_assoc($result)) {
				echo '<option value=' . $row["duration_id"] . ' >' . ucwords($row["duration_name"]) . '-' . $row["days"] . '</option>';
			}
			echo '</select></span><p class="help-block" id="valid_duration">&nbsp;</p>';
		}
		public function getallduration1($dura) {
			$result = false;
			$query = 'SELECT ofd.`id` AS duration_id,
			ofd.`duration` AS duration_name,
			ofd.`days` AS days
			FROM `offerduration` as ofd,
			`status` as st
			WHERE ofd.`status`= st.`id` AND
			st.`statu_name`="Show" AND st.`status`=1';
			$result = executeQuery($query);
			echo '<select name="cust_duration" id="cust_duration" class="form-control">
			<option value=null>Select Duration</option>';
			while ($row = mysql_fetch_assoc($result)) {
				if ($dura == $row["duration_id"])
                echo '<option selected value=' . $row["duration_id"] . ' >' . ucwords($row["duration_name"]) . '-' . $row["days"] . '</option>';
				else
                echo '<option value=' . $row["duration_id"] . ' >' . ucwords($row["duration_name"]) . '-' . $row["days"] . '</option>';
			}
			echo '</select></span><p class="help-block" id="valid_duration">&nbsp;</p>';
		}
		public function deactivefacility($id) {
			$result = false;
			$query = 'UPDATE `facility` SET status=(SELECT id FROM `status` WHERE statu_name="Hide" and status=1) WHERE id=' . $id . '';
			$result = executeQuery($query);
			if ($result)
            echo 'success';
		}
		public function addnewoffer($data) {
			$data["description"] = isset($data["description"]) ? $data["description"] : '';
			$result = false;
			$status = 4;
			$query = 'INSERT INTO `offers` (`id`, `name`, `duration_id`, `num_of_days`, `facility_id`, `description`, `cost`, `min_members`, `status`) VALUES (NULL,"' . $data["name"] . '",' . $data["duration"] . ',' . $data["days"] . ',' . $data["facility"] . ',"' . $data["description"] . '",' . $data["prizing"] . ',' . $data["member"] . ',' . $status . ') ';
			$result = executeQuery($query);
			if ($result)
            echo 'success';
		}
	}
?>