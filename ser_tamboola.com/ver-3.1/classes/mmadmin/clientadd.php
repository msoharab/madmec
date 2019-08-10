<?php

class clientadd {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';
    private $statu = array();

    public function __construct($para = false) {
        $this->parameters = $para;
        $this->statu["undel"] = getStatusId("Undelete");
        $this->statu["del"] = getStatusId("delete");
        $this->statu["flag"] = getStatusId("flag");
        $this->statu["active"] = getStatusId("active");
        $this->statu["Pending"] = getStatusId("Pending");
    }

    public function fetchUsersnGyms() {
        $fetchdata = array();
        $usersdata = array();
        $gymdata = array();
        $userid = array();
        $gymid = array();
        $ownerdata = array();
        $ownerid = array();
        $query = 'SELECT up.*
			FROM `user_profile` up
			LEFT JOIN `userprofile_type` upt
			ON upt.`user_pk`=up.`id`
			WHERE up.`status`=11
			AND upt.`usertype_id`=1
			AND upt.`status`=4';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata2[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata2); $i++) {
                $ownerdata[$i] = $fetchdata2[$i]['user_name'] . ' -- ' . $fetchdata2[$i]['email_id'] . ' -- ' . $fetchdata2[$i]['cell_number'] . ' -- ' . $fetchdata2[$i]['acs_id'];
                $ownerid[$i] = $fetchdata2[$i]['id'];
            }
        }
        $query = 'SELECT up.*
			FROM `user_profile` up
			LEFT JOIN `userprofile_type` upt
			ON upt.`user_pk`=up.`id`
			WHERE up.`status`=11
			AND upt.`usertype_id`=3
			AND upt.`status`=4';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $userdata[$i] = $fetchdata[$i]['user_name'] . ' -- ' . $fetchdata[$i]['email_id'] . ' -- ' . $fetchdata[$i]['cell_number'] . ' -- ' . $fetchdata[$i]['acs_id'];
                $userid[$i] = $fetchdata[$i]['id'];
            }
        }
        $query = "SELECT * FROM `gym_profile` WHERE `status`=4";
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata1[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata1); $i++) {
                $gymdata[$i] = $fetchdata1[$i]['gym_name'] . ' -- ' . $fetchdata1[$i]['gym_type'] . ' -- ' . $fetchdata1[$i]['addressline'] . ' -- ' . $fetchdata1[$i]['town'] . ' -- ' . $fetchdata1[$i]['city'] . ' -- ' . $fetchdata1[$i]['district'] . ' -- ' . $fetchdata1[$i]['province'];
                $gymid[$i] = $fetchdata1[$i]['id'];
            }
        }
        $jsondata = array(
            "userdata" => $userdata,
            "gymdata" => $gymdata,
            "userids" => $userid,
            "gymids" => $gymid,
            "ownerdata" => $ownerdata,
            "ownerids" => $ownerid,
        );
        return $jsondata;
    }

    public function displayAllGymsOfOwner() {
        $gymdata = array();
        $gymid = array();
        $query = 'SELECT gp.* FROM gym_profile gp
			LEFT JOIN userprofile_gymprofile upgp
			ON upgp.gym_id=gp.id
			WHERE gp.status=4 AND upgp.user_pk=' . mysql_real_escape_string($this->parameters['ownerid']);
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata1[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata1); $i++) {
                $gymdata[$i] = $fetchdata1[$i]['gym_name'] . ' -- ' . $fetchdata1[$i]['gym_type'] . ' -- ' . $fetchdata1[$i]['addressline'] . ' -- ' . $fetchdata1[$i]['town'] . ' -- ' . $fetchdata1[$i]['city'] . ' -- ' . $fetchdata1[$i]['district'] . ' -- ' . $fetchdata1[$i]['province'];
                $gymid[$i] = $fetchdata1[$i]['id'];
            }
        }
        $jsondata = array(
            "gymdata" => $gymdata,
            "gymids" => $gymid,
        );
        return $jsondata;
        exit(0);
    }

    public function addUserToGym() {
        $query = 'SELECT * FROM `userprofile_gymprofile` WHERE `user_pk`="' . mysql_real_escape_string($this->parameters['det']['userid']) . '"  '
                . 'AND `gym_id`= "' . mysql_real_escape_string($this->parameters['det']['gymid']) . '" AND `status`=11';
        $result = executeQuery($query);
        $query1 = 'SELECT * FROM `userprofile_gymprofile` WHERE `user_pk`="' . mysql_real_escape_string($this->parameters['det']['userid']) . '"  '
                . 'AND `gym_id`= "' . mysql_real_escape_string($this->parameters['det']['gymid']) . '" AND `status`=14';
        $result1 = executeQuery($query1);
        if (mysql_num_rows($result)) {
            $jsondata = array(
                "status" => "alreadyexist",
            );
            return $jsondata;
        } else if (mysql_num_rows($result1)) {
            $jsondata = array(
                "status" => "pending",
            );
            return $jsondata;
        } else {
            $query = 'INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`)VALUES(NULL,'
                    . '"' . mysql_real_escape_string($this->parameters['det']['userid']) . '",'
                    . '"' . mysql_real_escape_string($this->parameters['det']['gymid']) . '",'
                    . '14)';
            executeQuery($query);
            $lastid = mysql_insert_id();
            $query = 'INSERT INTO `userrequest`(`id`,`upgp_id`,`ownerid`,`status`)VALUES(NULL,'
                    . '"' . mysql_real_escape_string($lastid) . '",'
                    . '"' . mysql_real_escape_string($this->parameters['det']['ownerid']) . '",'
                    . '4)';
            executeQuery($query);
            $jsondata = array(
                "status" => "success",
            );
            return $jsondata;
        }
    }

    //List Owner Request
    public function fetchOwnerRequest() {
        $jsondata = array(
            "status" => "failure"
        );
        $query = 'SELECT *,up.id AS useridd
                            FROM `user_profile` up
                              LEFT JOIN `userprofile_type` upt
                                ON upt.`user_pk` = up.`id`
                              LEFT JOIN gender gen
                                ON gen.id = up.gender
                            WHERE up.`status` = 14
                                AND upt.`status` = 14';
        $result = executeQuery($query);
        $fetchdata = array();
        $userids = array();
        $mobiles=array();
        $data = '';
        if (mysql_num_rows($result)) {
            while ($roq = mysql_fetch_assoc($result)) {
                $fetchdata[] = $roq;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['user_name'] . '</td>'
                        . '<td>' . $fetchdata[$i]['email_id'] . '</td>'
                        . '<td>' . $fetchdata[$i]['cell_number'] . '</td>'
                        . '<td>' . $fetchdata[$i]['gender_name'] . '</td>'
                        . '<td><button type="button" class="btn btn-success" id="accept_' . $fetchdata[$i]['useridd'] . '"  title="Accept">Accept</button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete/Reject">Reject</button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['user_name'] . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deletereq' . $fetchdata[$i]['useridd'] . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>'
                        . '</tr>';
                $userids[$i] = $fetchdata[$i]['useridd'];
                $mobiles[$i]= $fetchdata[$i]['cell_number'];
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data,
                "userids" => $userids,
                "mobiles" => $mobiles,
            );
        }
        return $jsondata;
    }

    //Actived Owner Request
    public function OwnerRequest() {
        if (mysql_real_escape_string($this->parameters['req']) == "accept") {
            $query = 'UPDATE `user_profile` SET `status`=11 WHERE `id`=' . mysql_real_escape_string($this->parameters['userid']) . ';';
            executeQuery($query);
            $query = 'UPDATE `userprofile_type` SET `status`=4 WHERE `user_pk`=' . mysql_real_escape_string($this->parameters['userid']) . ';';
            if(executeQuery($query))
            {
            $message='Your Account Has been Succesfully Activated Visit www.tamboola.com online fitness software contact 7676463644 / 7676063644';
            $restPara = array(
                            "user" 		=> 'madmec',
                            "password"          => 'madmec',
                            "mobiles"           =>  mysql_real_escape_string($this->parameters["cell_number"]),
                            "sms" 		=> $message,
                            "senderid" 		=> 'MADMEC',
                            "version" 		=> 3,
                            "accountusagetypeid" => 1
                    );
                    $url = 'http://trans.profuseservices.com/sendsms.jsp?'.http_build_query($restPara);
                    $response2 = file_get_contents($url);
            }
            return $response2;

        } else {
            $query = 'UPDATE `user_profile` SET `status`=6 WHERE `id`=' . mysql_real_escape_string($this->parameters['userid']) . ';';
            executeQuery($query);
            $query = 'UPDATE `userprofile_type` SET `status`=6 WHERE `user_pk`=' . mysql_real_escape_string($this->parameters['userid']) . ';';
            if(executeQuery($query))
            {
            $message='Your Request Has been Rejected,Please Contact 7676463644 / 7676063644';
            $restPara = array(
                            "user" 		=> 'madmec',
                            "password"          => 'madmec',
                            "mobiles"           =>  mysql_real_escape_string($this->parameters["cell_number"]),
                            "sms" 		=> $message,
                            "senderid" 		=> 'MADMEC',
                            "version" 		=> 3,
                            "accountusagetypeid" => 1
                    );
                    $url = 'http://trans.profuseservices.com/sendsms.jsp?'.http_build_query($restPara);
                    $response2 = file_get_contents($url);
            }
            return $response2;
        }
    }

     //Actived GYM Request
    public function GYMRequest() {
        if (mysql_real_escape_string($this->parameters['req']) == "accept") {
            executeQuery('CALL slaveDbCreate("' . $this->parameters['dbname'] . '");');
            $query = 'UPDATE `gym_profile` SET `status`=4 WHERE `id`=' . mysql_real_escape_string($this->parameters['userid']) . ';';
            return executeQuery($query);
        } else {
            $query = 'UPDATE `gym_profile` SET `status`=6 WHERE `id`=' . mysql_real_escape_string($this->parameters['userid']) . ';';
            return executeQuery($query);
        }
    }

    //List GYM Request
     public function fetchGYMRequest() {
        $jsondata = array(
            "status" => "failure"
        );
        $query = 'SELECT
                    up.*,
                    up.id       AS useridd,
                    a.user_name
                  FROM `gym_profile` up
                    LEFT JOIN userprofile_gymprofile ug
                      ON ug.gym_id = up.id
                    LEFT JOIN user_profile a
                      ON a.id = ug.user_pk
                  WHERE up.`status` = 14
                                ';
        $result = executeQuery($query);
        $fetchdata = array();
        $userids = array();
        $rdbnames=array();
        $data = '';
        if (mysql_num_rows($result)) {
            while ($roq = mysql_fetch_assoc($result)) {
                $fetchdata[] = $roq;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td>'
                        . '<td>' . $fetchdata[$i]['user_name'] . '</td>'
                        .'<td>' . $fetchdata[$i]['gym_name'] . '</td>'
                        . '<td>' . $fetchdata[$i]['email'] . '</td>'
                        . '<td>' . $fetchdata[$i]['cell_number'] . '</td>'
                        . '<td>' . $fetchdata[$i]['gym_type'] . '</td>'
                         . '<td>' . $fetchdata[$i]['district'] . ' - '.$fetchdata[$i]['zipcode'] .'</td>'
                        . '<td><button type="button" class="btn btn-success" id="accept_' . $fetchdata[$i]['useridd'] . '"  title="Accept">Accept</button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete/Reject">Reject</button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['gym_name'] . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deletereq' . $fetchdata[$i]['useridd'] . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>'
                        . '</tr>';
                $userids[$i] = $fetchdata[$i]['useridd'];
                $rdbnames[$i] = $fetchdata[$i]['db_name'];
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data,
                "userids" => $userids,
                "db_name" => $rdbnames,
            );
        }
        return $jsondata;
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
			g.`gender_name`,
			gn.`gym_id`,
			gn.`gym_name`,
			gn.`gym_type`,
			gn.`db_host`,
			gn.db_username,
			gn.db_name,
			gn.db_password,
			gn.gym_short_logo,
			gn.gym_header_logo,
			gn.gym_postal_code,
			gn.gym_telephone,
			gn.gym_directory,
			gn.gym_currency_code,
			gn.reg_fee,
			gn.service_tax,
			gn.gym_addressline,
			gn.gym_town,
			gn.gym_city,
			gn.gym_district,
			gn.gym_province,
			gn.gym_province_code,
			gn.gym_country,
			gn.gym_country_code,
			gn.gym_zipcode,
			gn.gym_website,
			gn.gym_latitude,
			gn.gym_longitude,
			gn.gym_timezone,
			gn.gym_gmaphtml,
			gn.gymemail,
			gn.gymemailid1,
			gn.gymemailpk12,
			gn.gymcell_num,
			gn.group_gymem_id,
			gn.gym_status,
			gn.gymemail_pk
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
			LEFT JOIN(
			SELECT
			GROUP_CONCAT(upgp.`gym_id`,"☻☻♥♥☻☻") AS gym_id,
			upgp.`user_pk`,
			gymp.`id` AS gymid,
			gymeem.group_gymem_id,
			gymeem.gymemail,
			gymeem.gymemail_pk,
			gymcelln.`gymcell_no`,
			gymp.`status` AS gym_status1,
			GROUP_CONCAT(gymeem.`gymemail_pk`,"☻☻♥♥☻☻") AS gymemailpk12,
			GROUP_CONCAT(gymeem.`gymemail`,"☻☻♥♥☻☻") AS gymemailid1,
			GROUP_CONCAT(gymcelln.`gymcell_no`,"☻☻♥♥☻☻") AS gymcell_num,
			GROUP_CONCAT(gymp.`gym_name`,"☻☻♥♥☻☻") AS gym_name,
			GROUP_CONCAT(gymp.`gym_type`,"☻☻♥♥☻☻") AS gym_type,
			GROUP_CONCAT(gymp.`db_host`,"☻☻♥♥☻☻") AS db_host,
			GROUP_CONCAT(gymp.`db_username`,"☻☻♥♥☻☻") AS db_username,
			GROUP_CONCAT(gymp.`db_name`,"☻☻♥♥☻☻") AS db_name,
			GROUP_CONCAT(gymp.`db_password`,"☻☻♥♥☻☻") AS db_password,
			GROUP_CONCAT(gymp.`short_logo`,"☻☻♥♥☻☻") AS gym_short_logo,
			GROUP_CONCAT(gymp.`header_logo`,"☻☻♥♥☻☻") AS gym_header_logo,
			GROUP_CONCAT(gymp.`postal_code`,"☻☻♥♥☻☻") AS gym_postal_code,
			GROUP_CONCAT(gymp.`telephone`,"☻☻♥♥☻☻") AS gym_telephone,
			GROUP_CONCAT(gymp.`directory`,"☻☻♥♥☻☻") AS gym_directory,
			GROUP_CONCAT(gymp.`currency_code`,"☻☻♥♥☻☻") AS gym_currency_code,
			GROUP_CONCAT(gymp.`reg_fee`,"☻☻♥♥☻☻") AS reg_fee,
			GROUP_CONCAT(gymp.`service_tax`,"☻☻♥♥☻☻") AS service_tax,
			GROUP_CONCAT(gymp.`addressline`,"☻☻♥♥☻☻") AS gym_addressline,
			GROUP_CONCAT(gymp.`town`,"☻☻♥♥☻☻") AS gym_town,
			GROUP_CONCAT(gymp.`city`,"☻☻♥♥☻☻") AS gym_city,
			GROUP_CONCAT(gymp.`district`,"☻☻♥♥☻☻") AS gym_district,
			GROUP_CONCAT(gymp.`province`,"☻☻♥♥☻☻") AS gym_province,
			GROUP_CONCAT(gymp.`province_code`,"☻☻♥♥☻☻") AS gym_province_code,
			GROUP_CONCAT(gymp.`country`,"☻☻♥♥☻☻") AS gym_country,
			GROUP_CONCAT(gymp.`country_code`,"☻☻♥♥☻☻") AS gym_country_code,
			GROUP_CONCAT(gymp.`zipcode`,"☻☻♥♥☻☻") AS gym_zipcode,
			GROUP_CONCAT(gymp.`website`,"☻☻♥♥☻☻") AS gym_website,
			GROUP_CONCAT(gymp.`latitude`,"☻☻♥♥☻☻") AS gym_latitude,
			GROUP_CONCAT(gymp.`longitude`,"☻☻♥♥☻☻") AS gym_longitude,
			GROUP_CONCAT(gymp.`timezone`,"☻☻♥♥☻☻") AS gym_timezone,
			GROUP_CONCAT(gymp.`gmaphtml`,"☻☻♥♥☻☻") AS gym_gmaphtml,
			GROUP_CONCAT(gymp.`status`,"☻☻♥♥☻☻") AS gym_status
			FROM `userprofile_gymprofile` AS upgp,gym_profile AS gymp
			LEFT JOIN(
			SELECT
			GROUP_CONCAT(gymem.`id`,"☻☻") AS gymemail_pk,
			GROUP_CONCAT(gymem.`email`,"☻☻") AS gymemail,
			GROUP_CONCAT(gymem.`user_pk`,"☻☻") AS group_gymem_id,
			gymem.`user_pk`
			FROM `gym_email_ids` AS gymem
			WHERE gymem.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
			Group By(gymem.`user_pk`)
			)AS gymeem ON  gymp.`id` = gymeem.`user_pk`
			LEFT JOIN(
			SELECT
			GROUP_CONCAT(gymcell.`id`,"☻☻") AS gymcell_id,
			GROUP_CONCAT(gymcell.`cell_number`,"☻☻") AS gymcell_no,
			GROUP_CONCAT(gymcell.`user_pk`,"☻☻") AS gymid_cell,
			gymcell.`user_pk`
			FROM `gym_cell_numbers` AS gymcell
			WHERE gymcell.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
			Group By(gymcell.`user_pk`)
			)AS gymcelln ON  gymp.`id` = gymcelln.`user_pk`
			WHERE upgp.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Active" AND `status` = 1) AND
			gymp.`id` = upgp.`gym_id` AND
			gymp.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
			`statu_name` = "Hide" OR
			`statu_name` = "Delete" OR
                        `statu_name` = "Pending" OR
			`statu_name` = "Fired" OR
			`statu_name` = "Inactive"))
			GROUP BY (upgp.`user_pk`)
			ORDER BY (upgp.`user_pk`)
			)AS gn ON a.`id` = gn.`user_pk`
			LEFT JOIN `gender` AS g ON a.`gender` = g.`id`
			RIGHT JOIN `userprofile_type` AS ust
			ON ust.`user_pk` = a.`id`
			LEFT JOIN user_type AS ut
			ON ust.`usertype_id` = ut.`id`
			WHERE (ut.`type` = "Admin" OR ut.`type` = "Owner") AND ut.`status`= (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
			AND a.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
			`statu_name` = "Hide" OR
			`statu_name` = "Delete" OR
                        `statu_name` = "Pending" OR
			`statu_name` = "Fired" OR
			`statu_name` = "Inactive"))
			' . $idqr . ';';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $users[] = $row;
            }
        }
        $total = sizeof($users);
        if ($total) {
            for ($i = 0; $i < $total; $i++) {
                $users[$i]["cnumber"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["cnumber"])));
                $users[$i]["gymemailid"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gymemailid1"])));
                $users[$i]["email_pk"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["email_pk"])));
                $users[$i]["gymcell_no"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gymcell_num"])));
                $users[$i]["cnumber_pk"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["cnumber_pk"])));
                $users[$i]["email"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["email"])));
                $users[$i]["gymemail"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gymemail"])));
                $users[$i]["gym_name"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_name"])));
                $users[$i]["gym_type"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_type"])));
                $users[$i]["db_host"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["db_host"])));
                $users[$i]["db_username"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["db_username"])));
                $users[$i]["db_name"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["db_name"])));
                $users[$i]["db_password"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["db_password"])));
                $users[$i]["gym_directory"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_directory"])));
                $users[$i]["gym_short_logo"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_short_logo"])));
                $users[$i]["gym_header_logo"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_header_logo"])));
                $users[$i]["gym_telephone"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_telephone"])));
                $users[$i]["gym_currency_code"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_currency_code"])));
                $users[$i]["gym_postal_code"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_postal_code"])));
                $users[$i]["gym_city"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_city"])));
                $users[$i]["gym_province"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_province"])));
                $users[$i]["gym_zipcode"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_zipcode"])));
                $users[$i]["gym_district"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_district"])));
                $users[$i]["gym_country"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_country"])));
                $users[$i]["gym_addressline"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_addressline"])));
                $users[$i]["gym_gmap"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_gmaphtml"])));
                $users[$i]["gym_website"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_website"])));
                $users[$i]["gym_status"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_status"])));
                $users[$i]["gym_id"] = array_values(array_filter(explode("☻☻♥♥☻☻", $users[$i]["gym_id"])));
            }
            $_SESSION["list0f_client"] = $users;
        } else {
            $_SESSION["list0f_client"] = NULL;
        }
        return $_SESSION["list0f_client"];
    }

    //display in table format with data table
    public function DisplayClietList() {
        $users = array();
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
            "usruflgCancel" => '',
            "usredit" => ''
        );
        if (isset($_SESSION["list0f_client"]) && $_SESSION["list0f_client"] != NULL) {
            $users = $_SESSION["list0f_client"];
            //unset($_SESSION["list0f_client"]);
        } else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        if ($num_posts > 0) {
            $listusers = array();
            for ($i = 0; $i < $num_posts; $i++) {
                $html = '';
                /* Basic info */
                $email = $cnumber = '';
                $email_no = $cnum_no = -1;
                /* Email */
                if (is_array($users[$i]["email"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                        $flag = true;
                        $email .= ltrim($users[$i]["email"][$j], ',') . '<br />';
                        $email_no++;
                    }
                    if (!$flag) {
                        $email = '<strong>Not Provided</strong>';
                    }
                }
                /* Cell Number */
                if (is_array($users[$i]["cnumber"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                        $flag = true;
                        $cnumber .= ltrim($users[$i]["cnumber"][$j], ',') . '<br />';
                        $cnum_no++;
                    }
                    if (!$flag) {
                        $cnumber = '<strong>Not Provided</strong>';
                    }
                }
                $html .='<tr>
					<td>' . ($i + 1) . '</td>
					<td>' . ucfirst($users[$i]["user_name"]) . '</td>
					<td>' . $users[$i]["type"] . '</td>
					<td>' . $email . '</td>
					<td>' . $cnumber . '</td>
					<td>' . $users[$i]["date_of_join"] . '</td>
					<td class="text-center"><button type="button" name="' . $users[$i]["password"] . '" class="btn btn-md" id="allGYMuser_' . $users[$i]["usrid"] . '" value="' . $users[$i]["usrid"] . '" title="All Branch" ><i class="fa fa-th-list fa-1x fa-fw"></i></button></td>
					<td class="text-center"><button type="button" class="btn btn-md" id="usr_but_edit_' . $users[$i]["usrid"] . '" title="Edit" ><i class="fa fa-edit fa-fw"></i></button></td>
					<td class="text-center"><button type="button" class="btn btn-md" id="usr_but_trash_' . $users[$i]["usrid"] . '" title="Delete" data-toggle="modal" data-target="#myUSRDELModal_' . $users[$i]["usrid"] . '"><i class="fa fa-trash-o fa-fw"></i></button></td>';
                if (($users[$i]["status"]) == $this->statu["active"]) {
                    $html .= '<td class="text-center"><button type="button" class="btn btn-success btn-md" id="usr_but_flag_' . $users[$i]["usrid"] . '" title="Flag" data-toggle="modal" data-target="#myModal_flag' . $users[$i]["usrid"] . '"><i class="fa fa-flag-o fa-fw"></i>Flag</button></td>';
                } else if (($users[$i]["status"]) == $this->statu["flag"]) {
                    $html.='<td class="text-center"><button type="button" class="btn btn-danger btn-md" id="usr_but_unflag_' . $users[$i]["usrid"] . '" data-toggle="modal" data-target="#myModal_unflag' . $users[$i]["usrid"] . '"><i class="fa fa-flag-o fa-fw"></i>Unflag</button></td>';
                }
                $html.=' <td class="text-center"><button type="button" class="btn btn-info btn-md" id="usr_but_send_' . $users[$i]["usrid"] . '" title="Send Credential" ><i class="fa fa-arrow-up fa-fw"></i>Send</button></td>';
                $html.='</tr>
					<div class="modal fade" id="myUSRDELModal_' . $users[$i]["usrid"] . '" tabindex="-1" role="dialog" aria-labelledby="myUSRDELModalLabel_' . $users[$i]["usrid"] . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content" style="color:#000;">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myUSRDELModalLabel_' . $users[$i]["usrid"] . '">Are you really want to delete</h4>
					</div>
					<div class="modal-body" id="myUSRDEL_' . $users[$i]["usrid"] . '">
					Do you really want to delete {' . $users[$i]["user_name"] . '} <br />
					Press OK to delete ??
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteUSRDELOk_' . $users[$i]["usrid"] . '">Ok</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteUSRDELCancel_' . $users[$i]["usrid"] . '">Cancel</button>
					</div>
					</div>
					</div>
					</div>
					<div class="modal fade" id="myModal_flag' . $users[$i]["usrid"] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_flag_Label_' . $users[$i]["usrid"] . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content" style="color:#000;">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModal_flag_Label_' . $users[$i]["usrid"] . '">Flag User entry</h4>
					</div>
					<div class="modal-body">
					Do You really want to flag the User ' . $users[$i]["user_name"] . ' entry ?? press <strong>OK</strong> to flag
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal" onClick="$(\'#usr_but_unflag_' . $users[$i]["usrid"] . '\').show(300);$(\'#usr_but_flag_' . $users[$i]["usrid"] . '\').hide(300);" name=".modal-backdrop" id="flagOk_' . $users[$i]["usrid"] . '">Ok</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" id="flagCancel_' . $users[$i]["usrid"] . '">Cancel</button>
					</div>
					</div>
					</div>
					</div>
					<div class="modal fade" id="myModal_unflag' . $users[$i]["usrid"] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_unflag_Label_' . $users[$i]["usrid"] . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
					<div class="modal-content" style="color:#000;">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModal_unflag_Label_' . $users[$i]["usrid"] . '">UnFlag User entry</h4>
					</div>
					<div class="modal-body">
					Do You really want to UnFlag the User ' . $users[$i]["user_name"] . ' entry ?? press <strong>OK</strong> to UnFlag
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="unflagOk_' . $users[$i]["usrid"] . '">Ok</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" id="unflagCancel_' . $users[$i]["usrid"] . '">Cancel</button>
					</div>
					</div>
					</div>
					</div>';
                $listusers[$i] = array(
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
                    "usruflgCancel" => '#unflagCancel_' . $users[$i]["usrid"] . '',
                    "usredit" => '#usr_but_edit_' . $users[$i]["usrid"] . '',
                    "usrsend" => '#usr_but_send_' . $users[$i]["usrid"] . '',
                    "showgym" => '#allGYMuser_' . $users[$i]["usrid"],
                );
            }
        }
        return $listusers;
    }

    // list the gym data
    public function displayUsrGymData($gymid) {
        $c = 0;
        $gymusers = array();
        $gymhtml = '';
        $listgymusers = array(
            "html" => '<strong class="text-danger">There are no users available !!!!</strong>',
            "uid" => 0,
        );
        if (isset($_SESSION["list0f_client"]) && $_SESSION["list0f_client"] != NULL) {
            $gymusers = $_SESSION["list0f_client"];
            //unset($_SESSION["list0f_client"]);
        } else
            $gymusers = NULL;
        if ($gymusers != NULL)
            $num_posts = sizeof($gymusers);
        if ($num_posts > 0) {
            $gmaildata = array();
            $celldata = array();
            $listgymusers = array();
            $email = array();
            $cell = array();
            for ($i = 0; $i < $num_posts && isset($gymusers[$i]); $i++) {
                if (($gymusers[$i]["usrid"]) == $gymid) {
                    //    ----------list Email Id----------------------
                    if (is_array($gymusers[$i]["gymemailid"])) {
                        for ($j = 0; $j < sizeof($gymusers[$i]["gymemailid"]) && isset($gymusers[$i]["gymemailid"][$j]) && $gymusers[$i]["gymemailid"][$j] != ''; $j++) {
                            $email[$j] = '';
                            $email_num[$j] = -1;
                            $gmaildata[$i]["email12"] = explode("☻☻", $gymusers[$i]["gymemailid"][$j]);
                            if (is_array($gmaildata[$i]["email12"])) {
                                $flag = false;
                                for ($k = 0; $k < sizeof($gmaildata[$i]["email12"]) && isset($gmaildata[$i]["email12"][$k]) && $gmaildata[$i]["email12"][$k] != ''; $k++) {
                                    $flag = true;
                                    $email[$j] .= trim($gmaildata[$i]["email12"][$k], ',') . '<br />';
                                    $email_num[$j] ++;
                                    $flag = false;
                                }
                                if (!$flag) {
                                    $email[$j + 1] = '<strong>Not Provided</strong>';
                                    $email_num[$j + 1] = 0;
                                }
                            }
                        }
                    }
                    ////////////////////list Cell Number
                    if (is_array($gymusers[$i]["gymcell_no"])) {
                        for ($j = 0; $j < sizeof($gymusers[$i]["gymcell_no"]) && isset($gymusers[$i]["gymcell_no"][$j]) && $gymusers[$i]["gymcell_no"][$j] != ''; $j++) {
                            $cellnumber[$j] = -1;
                            $cell[$j] = '';
                            $celldata[$i]["cell_num"] = explode("☻☻", $gymusers[$i]["gymcell_no"][$j]);
                            if (is_array($celldata[$i]["cell_num"])) {
                                $flag = false;
                                for ($k = 0; $k < sizeof($celldata[$i]["cell_num"]) && isset($celldata[$i]["cell_num"][$k]) && $celldata[$i]["cell_num"][$k] != ''; $k++) {
                                    $flag = true;
                                    $cell[$j] .= trim($celldata[$i]["cell_num"][$k], ',') . '<br />';
                                    $cellnumber[$j] ++;
                                    $flag = false;
                                }
                                if (!$flag) {
                                    $cell[$j + 1] = '<strong>Not Provided</strong>';
                                }
                            }
                        }
                    }
                    //// end of Cell Number listing
                    if (is_array($gymusers[$i]["gym_name"])) {
                        for ($j = 0; $j < (sizeof($gymusers[$i]["gym_name"]) - 1) && isset($gymusers[$i]["gym_name"][$j]) && $gymusers[$i]["gym_name"][$j] != ''; $j++) {
                            $temp = ltrim($gymusers[$i]["gym_id"][$j], ',');
                            $gymstatus = ltrim($gymusers[$i]["gym_status"][$j], ',');
                            $gymname[$j] = ltrim($gymusers[$i]["gym_name"][$j], ',');
                            $gymdbhost[$j] = ltrim($gymusers[$i]["db_host"][$j], ',');
                            $gymdbname[$j] = ltrim($gymusers[$i]["db_name"][$j], ',');
                            $gymdbusername[$j] = ltrim($gymusers[$i]["db_username"][$j], ',');
                            $gymdbpassword[$j] = ltrim($gymusers[$i]["db_password"][$j], ',');
                            $gymtype[$j] = ltrim($gymusers[$i]["gym_type"][$j], ',');
                            $gymcity[$j] = ltrim($gymusers[$i]["gym_city"][$j], ',');
                            //$gymemail[$j] = ltrim($gymusers[$i]["gymemail"][$j] ,',');
                            if ($gymcity[$j] == NULL || $gymcity[$j] == ' ')
                                $gymcity[$j] = "Not-provided";
                            $gymcountry[$j] = ltrim($gymusers[$i]["gym_country"][$j], ',');
                            if ($gymcountry[$j] == NULL || $gymcountry[$j] == ' ')
                                $gymcountry[$j] = "Not-provided";
                            $gymdistrict[$j] = ltrim($gymusers[$i]["gym_district"][$j], ',');
                            if ($gymdistrict[$j] == NULL || $gymdistrict[$j] == ' ')
                                $gymdistrict[$j] = "Not-provided";
                            if (sizeof($gymusers[$i]["gym_short_logo"]) > 0)
                                $gymstlogo[$j] = ltrim($gymusers[$i]["gym_short_logo"][$j], ',');
                            else
                                $gymstlogo[$j] = LOGO_1;
                            if (sizeof($gymusers[$i]["gym_header_logo"]) > 0)
                                $gymhdlogo[$j] = ltrim($gymusers[$i]["gym_header_logo"][$j], ',');
                            else
                                $gymhdlogo[$j] = LOGO_1;
                            $gymdirectory[$j] = ltrim($gymusers[$i]["gym_directory"][$j], ',');
                            //if(($gymusers[$i]["gym_province"][$j] != NULL) || ($gymusers[$i]["gym_province"][$j] != ' ') || ($gymusers[$i]["gym_province"][$j] != '')){
                            //if(isset($gymusers[$i]["gym_province"][$j])){
                            $gymprovince[$j] = ltrim($gymusers[$i]["gym_province"][$j], ',');
                            if (($gymprovince[$j] == NULL) || ($gymprovince[$j] == '') || ($gymprovince[$j] == ' ')) {
                                $gymprovince[$j] = '<strong>Not Provided</strong>';
                            }
                            $gymzipcode[$j] = ltrim($gymusers[$i]["gym_zipcode"][$j], ',');
                            if (($gymzipcode[$j] == NULL) || ($gymzipcode[$j] == '') || ($gymzipcode[$j] == ' ')) {
                                $gymzipcode[$j] = '<strong>Not Provided</strong>';
                            }
                            $gymwebsite[$j] = ltrim($gymusers[$i]["gym_website"][$j], ',');
                            if (($gymwebsite[$j] == NULL) || ($gymwebsite[$j] == '') || ($gymwebsite[$j] == ' ')) {
                                $gymwebsite[$j] = '<strong>Not Provided</strong>';
                            }
                            if ((!isset($email[$j])) || ($email[$j] == NULL) || ($email[$j] == '') || ($email[$j] == ' ')) {
                                $email_num[$j] = 0;
                                $email[$j] = '<strong>Not Provided</strong>';
                            }
                            if ((!isset($cell[$j])) || ($cell[$j] == NULL) || ($cell[$j] == '') || ($cell[$j] == ' ')) {
                                $cell[$j] = '<strong>Not Provided</strong>';
                            }
                            $gymaddress[$j] = ltrim($gymusers[$i]["gym_addressline"][$j], ',');
                            $gymtelephone[$j] = ltrim($gymusers[$i]["gym_telephone"][$j], ',');
                            $gymcycode[$j] = $gymusers[$i]["gym_currency_code"];
                            $html = '<tr>
								<td style="">' . ($j + 1) . '</td>
								<td>' . ucfirst($gymname[$j]) . '</td>
								<td>' . $gymtype[$j] . '</td>
								<td>' . $gymdbhost[$j] . '</td>
								<td>' . $gymdbusername[$j] . '</td>
								<td>' . $gymdbname[$j] . '</td>
								<td>' . $gymdbpassword[$j] . '</td>
								<td>' . $email[$j] . '</td>
								<td>' . $cell[$j] . '</td>
								<td>' . $gymcity[$j] . '</td>
								<td>' . $gymprovince[$j] . '</td>
								<td>' . $gymcountry[$j] . '</td>
								<td class="text-center"><button type="button" id="gym_but_edit_' . $temp . '" title="Edit" ><i class="fa fa-edit fa-fw"></i></button></td>
								<td class="text-center"><button type="button" class="btn btn-md" id="gym_but_trash_' . $temp . '" title="Delete" data-toggle="modal" data-target="#myUSRDELModal_' . $temp . '"><i class="fa fa-trash-o fa-fw"></i></button></td>';
                            if (($gymstatus) == 4) {
                                $html .= '<td class="text-center"><button type="button" class="btn btn-success btn-md" id="gym_but_flag_' . $temp . '" title="Flag" data-toggle="modal" data-target="#myModal_flag' . $temp . '"><i class="fa fa-flag-o fa-fw"></i>Flag</button></td>';
                            } else if (($gymstatus) == $this->statu["flag"]) {
                                $html.='<td class="text-center"><button class="btn btn-danger btn-md" id="gym_but_unflag_' . $temp . '" data-toggle="modal" data-target="#myModal_unflag' . $temp . '"><i class="fa fa-flag-o fa-fw"></i>Unflag</button></td>';
                            }
                            $html.='</tr>';
                            $html.='</tr>
								<div class="modal fade" id="myUSRDELModal_' . $temp . '" tabindex="-1" role="dialog" aria-labelledby="myUSRDELModalLabel_' . $temp . '" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myUSRDELModalLabel_' . $temp . '">Are you really want to delete</h4>
								</div>
								<div class="modal-body" id="myUSRDEL_' . $temp . '">
								Do you really want to delete {' . $gymname[$j] . '} <br />
								Press OK to delete ??
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteGYMDELOk_' . $temp . '">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteUSRDELCancel_' . $temp . '">Cancel</button>
								</div>
								</div>
								</div>
								</div>
								<div class="modal fade" id="myModal_flag' . $temp . '" tabindex="-1" role="dialog" aria-labelledby="myModal_flag_Label_' . $temp . '" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModal_flag_Label_' . $temp . '">Flag User entry</h4>
								</div>
								<div class="modal-body">
								Do You really want to flag the User ' . $gymname[$j] . ' entry ?? press <strong>OK</strong> to flag
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="flagOk_' . $temp . '">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="flagCancel_' . $temp . '">Cancel</button>
								</div>
								</div>
								</div>
								</div>
								<div class="modal fade" id="myModal_unflag' . $temp . '" tabindex="-1" role="dialog" aria-labelledby="myModal_unflag_Label_' . $temp . '" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModal_unflag_Label_' . $temp . '">UnFlag User entry</h4>
								</div>
								<div class="modal-body">
								Do You really want to UnFlag the User ' . $gymname[$j] . ' entry ?? press <strong>OK</strong> to UnFlag
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="unflagOk_' . $temp . '">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="unflagCancel_' . $temp . '">Cancel</button>
								</div>
								</div>
								</div>
								</div>';
                            $datadocumnetgyminfo = '<div class="row">
								<div class="col-lg-12">&nbsp;</div>
								<div class="col-lg-12">
								<div class="panel panel-yellow">
								<div class="panel-heading">
								<h4>Data Document</h4>
								</div>
								<div class="panel-body" id="subgymdata_' . $temp . '">
								<ul>
								<li><strong>Branch Name : </strong>' . $gymname[$j] . '</li>
								<li><strong>Branch Type : </strong>' . $gymtype[$j] . '</li>
								<li><strong>DB-HOST  : </strong>' . $gymdbhost[$j] . '</li>
								<li><strong>DB-USERNAME : </strong>' . $gymdbusername[$j] . '</li>
								<li><strong>DB-NAME : </strong>' . $gymdbname[$j] . '</li>
								<li><strong>DB-PASSWORD : </strong>' . $gymdbpassword[$j] . '</li>
								<li><strong>Short-LOGO : </strong>' . $gymstlogo[$j] . '</li>
								<li><strong>Header-LOGO : </strong>' . $gymhdlogo[$j] . '</li>
								</ul>
								</div >
								<div class="panel-body" id="subgymDocEDITdata_' . $temp . '" style="display:none">
								<form id="subgym_datadoc_edit_form_' . $temp . '">
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Name  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Branch Name" name="gymBname_' . $temp . '" type="text" id="gymBname_' . $temp . '" maxlength="100" value="' . $gymname[$j] . '"/>
								<p class="help-block" id="gymnmmsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!--Gym Type  -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Branch Type  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Branch Type" name="gymtype_' . $temp . '" type="text" id="gymtype_' . $temp . '" maxlength="100" value="' . $gymtype[$j] . '"/>
								<p class="help-block" id="gymtymsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- DB_HOST -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> DB Host  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="DB Host" name="gymdbhost_' . $temp . '" type="text" id="gymdbhost_' . $temp . '" maxlength="100" value="' . $gymdbhost[$j] . '"/>
								<p class="help-block" id="gymdhmsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- DB_USerNAme -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> DB UserName  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="DB UserName" name="gymdbusernm_' . $temp . '" type="text" id="gymdbusernm_' . $temp . '" maxlength="100" value="' . $gymdbusername[$j] . '"/>
								<p class="help-block" id="gymdumsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- DB_NAME -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> DB Name  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="DB Name" name="gymdbname_' . $temp . '" type="text" id="gymdbname_' . $temp . '" maxlength="100" value="' . $gymdbname[$j] . '"/>
								<p class="help-block" id="gymdbnmmsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- DB_PASSWORD -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> DB Password  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="DB Password" name="gymdbpass_' . $temp . '" type="text" id="gymdbpass_' . $temp . '" maxlength="100" value="' . $gymdbpassword[$j] . '"/>
								<p class="help-block" id="gymdpmsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- short logo -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Short-Logo Size  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Short-Logo Size" name="gymslogo_' . $temp . '" type="text" id="gymslogo_' . $temp . '" maxlength="100" value="' . $gymstlogo[$j] . '"/>
								<p class="help-block" id="gymslmsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- header_logo -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Header-logo Size  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Header-logo Size" name="gymhlogo_' . $temp . '" type="text" id="gymhlogo_' . $temp . '" maxlength="100" value="' . $gymhdlogo[$j] . '"/>
								<p class="help-block" id="gymhlmsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Update -->
								<div class="row">
								<div class="col-lg-12">&nbsp;</div>
								<div class="col-lg-12 text-center">
								<button type="button" class="btn btn-danger btn-md" id="subgym_datadoc_update_but_' . $temp . '"><i class="fa fa-upload fa-fw "></i> Update</button>
								&nbsp;<button type="button" class="btn btn-danger btn-md" id="subgym_datadoc_close_but_' . $temp . '"><i class="fa fa-close fa-fw "></i> Close</button>
								</div>
								</div>
								</form>
								</div>
								<div class="panel-footer">
								<button type="button" class="btn btn-danger btn-md" id="subgymdatadoc_but_edit_' . $temp . '">
								<i class="fa fa-edit fa-fw "></i> Edit
								</button>
								</div>
								</div>
								</div>
								</div>';
                            $gymaddressinfo = '<div class="row">
								<div class="col-lg-12">&nbsp;</div>
								<div class="col-lg-4">
								<div class="panel panel-yellow">
								<div class="panel-heading">
								<h4>Photo</h4>
								</div>
								<div class="panel-body" id="subgymphoto_' . $temp . '">
								<img src="" width="150" />
								</div>
								<div class="panel-footer" style="display:none;">
								<button  type="button" class="btn btn-yellow btn-md" id="subgymphoto_but_edit_' . $temp . '"><i class="fa fa-edit fa-fw "></i> Edit</button>
								</div>
								</div>
								</div>
								<div class="col-lg-4">
								<div class="panel panel-green">
								<div class="panel-heading">
								<h4>Email Ids</h4>
								</div>
								<div class="panel-body" id="usremail_' . $temp . '">
								<ul>' . $email[$j] . '</ul>
								</div>
								<div class="panel-footer">
								<button class="btn btn-success btn-md" id="usremail_but_edit_' . $temp . '"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
								<button class="btn btn-success btn-md" style="display:none" id="usremail_but_' . $temp . '"><i class="fa fa-edit fa-fw "></i> Save</button>
								</div>
								</div>
								</div>
								<div class="col-lg-4">
								<div class="panel panel-green">
								<div class="panel-heading">
								<h4>Cell Numbers</h4>
								</div>
								<div class="panel-body" id="usrcnum_' . $temp . '">
								<ul>' . $cell[$j] . '</ul>
								</div>
								<div class="panel-footer">
								<button class="btn btn-success btn-md" id="usrcnum_but_edit_' . $temp . '"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
								<button class="btn btn-success btn-md" id="usrcnum_but_' . $temp . '"><i class="fa fa-edit fa-fw "></i> Save</button>
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
								<div class="panel-body" id="subgymadd_' . $temp . '" style="display:block;">
								<ul>
								<li><strong>Address line : </strong>' . $gymaddress[$j] . '</li>
								<li><strong>Street / Locality : </strong>' . $gymdistrict[$j] . '</li>
								<li><strong>City / Town : </strong>' . $gymcity[$j] . '</li>
								<li><strong>District / Department : </strong>' . $gymdistrict[$j] . '</li>
								<li><strong>State / Provice : </strong>' . $gymprovince[$j] . '</li>
								<li><strong>Country : </strong>' . $gymcountry[$j] . '</li>
								<li><strong>Zipcode : </strong>' . $gymzipcode[$j] . '</li>
								<li><strong>Website : </strong>' . $gymwebsite[$j] . '</li>
								<li><strong>Google Map : </strong>' . $gymcountry[$j] . '</li>
								</ul>
								</div>
								<div class="panel-body" id="subgymadd_edit_' . $temp . '" style="display:none;">
								<form id="subgym_address_edit_form_' . $temp . '">
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Country  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Country" name="gymcountry_' . $temp . '" type="text" id="gymcountry_' . $temp . '" maxlength="100" value="' . $gymcountry[$j] . '"/>
								<p class="help-block" id="gymcomsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- State / Province -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> State / Province  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="State / Province" name="gymprovince_' . $temp . '" type="text" id="gymprovince_' . $temp . '" maxlength="150" value="' . $gymprovince[$j] . '"/>
								<p class="help-block" id="gymprmsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- District / Department -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> District / Department  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="District / Department" name="gymdistrict_' . $temp . '" type="text" id="gymdistrict_' . $temp . '" maxlength="100" value="' . $gymdistrict[$j] . '"/>
								<p class="help-block" id="gymdimsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- City / Town -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> City / Town  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="City / Town" name="gymcity_town_' . $temp . '" type="text" id="gymcity_town_' . $temp . '" maxlength="100" value="' . $gymcity[$j] . '"/>
								<p class="help-block" id="gymcitmsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Street / Locality -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Street / Locality  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Street / Locality" name="gymst_loc_' . $temp . '" type="text" id="gymst_loc_' . $temp . '" maxlength="100" value="' . $gymcountry[$j] . '"/>
								<p class="help-block" id="gymstlmsg' . $temp . '">&nbsp;</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Address Line -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Address Line  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Address Line" name="gymaddrs_' . $temp . '" type="text" id="gymaddrs_' . $temp . '" maxlength="200" value="' . $gymaddress[$j] . '"/>
								<p class="help-block" id="gymadmsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Zipcode -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Zipcode  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Zipcode" name="gymzipcode_' . $temp . '" type="text" id="gymzipcode_' . $temp . '" maxlength="25" value="' . $gymzipcode[$j] . '"/>
								<p class="help-block" id="gymzimsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Personal Website -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Personal Website  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Personal Website" name="gymwebsite_' . $temp . '" type="text" id="gymwebsite_' . $temp . '" maxlength="250" value="' . $gymwebsite[$j] . '"/>
								<p class="help-block" id="gymwemsg_' . $temp . '">Enter/ Select.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Google Map URL -->
								<div class="row">
								<div class="col-lg-12">
								<strong><span class="text-danger"></span> Google Map URL  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
								<input class="form-control" placeholder="Google Map URL" name="gymgmaphtml_' . $temp . '" type="text" id="gymgmaphtml_' . $temp . '" value="' . $gymcountry[$j] . '"/>
								<p class="help-block" id="gymgmmsg_' . $temp . '">Press enter or go button to update user address.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								</div>
								<!-- Update -->
								<div class="row">
								<div class="col-lg-12">&nbsp;</div>
								<div class="col-lg-12 text-center">
								<button type="button" class="btn btn-danger btn-md" id="subgym_address_update_but_' . $temp . '"><i class="fa fa-upload fa-fw "></i> Update</button>
								&nbsp;<button type="button" class="btn btn-danger btn-md" id="subgym_address_close_but_' . $temp . '"><i class="fa fa-close fa-fw "></i> Close</button>
								</div>
								</div>
								</form>
								</div>
								<div class="panel-footer">
								<button type="button" class="btn btn-danger btn-md" id="subgymaddr_but_edit_' . $temp . '">
								<i class="fa fa-edit fa-fw "></i> Edit
								</button>
								</div>
								</div>
								</div>
								</div>';
                            $gymedit = '<div class="panel-group" id="accorlistgym' . $temp . '">
								<div class="panel panel-default panel-success" id="subuser_' . $temp . '">
								<div class="panel-heading">
								<div class="row">
								<div class="col-md-6">
								<a data-toggle="collapse" data-parent="#accorlistgym' . $temp . '" href="#subuser_list_' . $temp . '">{Branch Name:-' . $gymname[$j] . '}</a>
								&nbsp;&nbsp;&nbsp;<button class="text-center btn btn-danger btn-md" id="gymeditlist_Close_But_' . $temp . '"><i class="fa fa-reply fa-fw "></i>Back</button>
								</div>
								</div>
								</div>
								<div id="subuser_list_' . $temp . '" class="panel-collapse collapse">
								<ul class="nav nav-pills">
								<div class="col-lg-12">&nbsp;</div>
								<li class="active"><a href="#info_subuser_list_' . $temp . '" data-toggle="tab">Basic info</a></li>
								<li><a href="#doc_subuser_list_' . $temp . '" data-toggle="tab">Data Documents</a></li>
								<li><a href="#history_subuser_list_' . $temp . '" data-toggle="tab">History</a></li>
								</ul>
								<div class="tab-content">
								<div class="tab-pane fade in active" id="info_subuser_list_' . $temp . '">
								<p>' . str_replace($this->order, $this->replace, $gymaddressinfo) . '</p>
								</div>
								<div class="tab-pane fade" id="doc_subuser_list_' . $temp . '">
								<p>' . str_replace($this->order, $this->replace, $datadocumnetgyminfo) . '</p>
								</div>
								<div class="tab-pane fade" id="history_subuser_list_' . $temp . '">
								<h4>History</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
								</div>
								</div>
								</div>
								</div>
								</div>
								<script>
								$(document).ready(function(){
								var editUserEmailIds = {
								autoloader : true,
								action 	   : "loadGYMEmailId",
								outputDiv  : "#output",
								parentDiv  : "#usremail_' . $temp . '",
								but  	   : "#usremail_but_edit_' . $temp . '",
								num   	   : ' . $email_num[$j] . ',
								uid	   	   : "' . $temp . '",
								index  	   : 0,
								listindex  : "list0f_client",
								form 	   : "email_id_' . $temp . '_",
								email 	   : "email_' . $temp . '_",
								msgDiv 	   : "email_msg_' . $temp . '_",
								plus 	   : "plus_email_' . $temp . '_",
								minus 	   : "minus_email_' . $temp . '_",
								saveBut	   : "usremail_but_' . $temp . '",
								closeBut   : "usremail_close_' . $temp . '",
								url 	   : window.location.href
								};
								var obj = new clientController();
								obj.editGYMEmailIds(editUserEmailIds);
								var editGYMCellNumbers = {
								autoloader : true,
								action 	   : "loadCellNumForm",
								outputDiv  : "#output",
								parentDiv  : "#usrcnum_' . $temp . '",
								but  	   : "#usrcnum_but_edit_' . $temp . '",
								num   	   : 2,
								uid	   	   : ' . $temp . ',
								index  	   : 0,
								listindex  : "list0f_client",
								form 	   : "cnum_id_' . $temp . '_",
								cnumber	   : "cnum_' . $temp . '_",
								msgDiv 	   : "cnum_msg_' . $temp . '_",
								plus 	   : "plus_cnum_' . $temp . '_",
								minus 	   : "minus_cnum_' . $temp . '_",
								saveBut	   : "usrcnum_but_' . $temp . '",
								closeBut   : "usrcnum_close_' . $temp . '",
								url 	   : window.location.href
								};
								var obj = new clientController();
								obj.editGYMCellNumbers(editGYMCellNumbers);
								var editdatadoc = {
								gymid				: ' . $temp . ',
								gymdocDiv			: "#subgymdata_' . $temp . '",
								gymdocEditDiv		: "#subgymDocEDITdata_' . $temp . '",
								gymBname      	: "#gymBname_' . $temp . '",
								gymType			: "#gymtype_' . $temp . '",
								gymdbHost			: "#gymdbhost_' . $temp . '",
								gymdbUsernm		: "#gymdbusernm_' . $temp . '",
								gymdbName			: "#gymdbname_' . $temp . '",
								gymdbPass			: "#gymdbpass_' . $temp . '",
								gymslogo			: "#gymslogo_' . $temp . '",
								gymhlogo			: "#gymhlogo_' . $temp . '",
								gymdocEditbtn 	: "#subgymdatadoc_but_edit_' . $temp . '",
								gymdocUpdatebtn	: "#subgym_datadoc_update_but_' . $temp . '",
								gymdocClosebtn	: "#subgym_datadoc_close_but_' . $temp . '",
								}
								var obj = new clientController();
								obj.editGYMDataDoc(editdatadoc);
								var deleteflagbtn1 = {
								gymdeletebtn		: "#gym_but_trash_' . $temp . '",
								gymdeleteokbtn  	: "#deleteGYMDELOk_' . $temp . '",
								gymflagbtn 		: "#flagOk_' . $temp . '",
								gymid				: "' . $temp . '",
								}
								var obj1 = new clientController();
								obj1.gymdeleteflag1(deleteflagbtn1);
								});
								</script>';
                            //var deleteflagbtn1 = {
                            //gymdeletebtn		: "#gym_but_trash_'.$temp.'",
                            //gymdeleteokbtn  	: "#deleteGYMDELOk_'.$temp.'",
                            //gymflagbtn 		: "#flagOk_'.$temp.'",
                            //gymid				: "'.$temp.'",
                            //}
                            //var obj1 = new clientController();
                            //obj1.gymdeleteflag1(deleteflagbtn1);
                            //});
                            $listgymusers[] = array(
                                "html" => (string) $html,
                                "gid" => $temp,
                                "gymeditBtn" => "#gym_but_edit_" . $temp,
                                "gymeditdiv" => "#gymuser_edit_" . $temp,
                                "gymEditDiv" => (string) $gymedit,
                                "gymaddDiv" => "#subgymadd_" . $temp,
                                "gymaddUpdateDiv" => "#subgymadd_edit_" . $temp,
                                "gymemailEditBut" => "#subgymemail_but_edit_" . $temp,
                                "gymdatadocEDITbtn" => "#subgymdatadoc_but_edit_" . $temp,
                                "gymcellEditBut" => "#subgymcnum_but_edit_" . $temp,
                                "gymid" => $temp,
                                "gymadd_index" => $j,
                                "gymaddEditBut" => "#subgymaddr_but_edit_" . $temp,
                                "gymaddSaveBut" => "#subgym_address_update_but_" . $temp,
                                "gymaddCloseBut" => "#subgym_address_close_but_" . $temp,
                                "addressform" => "#subgym_address_edit_form_" . $temp,
                                "gymcountry" => "#gymcountry_" . $temp,
                                "gvymcountryCode" => null,
                                "gymcountryId" => null,
                                "gymcomsg" => "#gymcomsg_" . $temp,
                                "gymprovince" => "#gymprovince_" . $temp,
                                "gymprovinceCode" => null,
                                "gymprovinceId" => null,
                                "gymprmsg" => "#gymprmsg_" . $temp,
                                "gymdistrict" => "#gymdistrict_" . $temp,
                                "gymdistrictCode" => null,
                                "gymdistrictId" => null,
                                "gymdimsg" => "#gymdimsg_" . $temp,
                                "gymcity_town" => "#gymcity_town_" . $temp,
                                "gymcity_townCode" => null,
                                "gymcity_townId" => null,
                                "gymcitymsg" => "#gymcitmsg_" . $temp,
                                "gymst_loc" => "#gymst_loc_" . $temp,
                                "gymst_locCode" => null,
                                "gymst_locId" => null,
                                "gymstlmsg" => "#gymstlmsg_" . $temp,
                                "gymaddrs" => "#gymaddrs_" . $temp,
                                "gymadmsg" => "#gymadmsg_" . $temp,
                                "gymzipcode" => "#gymzipcode_" . $temp,
                                "gymzimsg" => "#gymzimsg_" . $temp,
                                "gymwebsite" => "#gymwebsite_" . $temp,
                                "gymwemsg" => "#gymwemsg_" . $temp,
                                "gymtphone" => "#gymtelephone_" . $temp,
                                "gymgmaphtml" => "#gymgmaphtml_" . $temp,
                                "gymgmmsg" => "#gymgmmsg_" . $temp,
                                "gymlat" => null,
                                "gymlon" => null,
                                "gymtimezone" => null,
                                "gymeditlistclbtn" => "#gymeditlist_Close_But_" . $temp,
                                "gymdeleteokbtn" => "#deleteGYMDELOk_" . $temp,
                                "gymflagokbtn" => "#flagOk_" . $temp,
                                "gymunflagokbtn" => "#unflagOk_" . $temp,
                            );
                        }
                    }
                }
            }
        }
        return $listgymusers;
    }

    // edit on dataTable and edit interface for single edit client
    public function editClient() {
        $user_id = $this->parameters["usrid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["usrid"] . ') LIMIT 1' : '';
        $clientQuery["var"] = $user_id;
        $users = clientadd::mmtable_list($clientQuery);
        $users = $users[0];
        $email = $cnumber = '';
        $email_no = $cnum_no = -1;
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
        /* Cell Number */
        if (is_array($users["cnumber"])) {
            $flag = false;
            for ($j = 0; $j < sizeof($users["cnumber"]) && isset($users["cnumber"][$j]) && $users["cnumber"][$j] != ''; $j++) {
                $flag = true;
                $cnumber .= '<li>' . ltrim($users["cnumber"][$j], ',') . '</li>';
                $cnum_no++;
            }
            if (!$flag) {
                $cnumber = '<li>Not Provided</li>';
            }
        }
        echo '
			<form action="control.php" name="changePic" id="changePic" method="post" enctype="multipart/form-data">
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
        echo '<div class="row">
			<div class="col-lg-12">&nbsp;</div>
			<div class="col-lg-4">
			<div class="panel panel-green">
			<div class="panel-heading">
			<h4>Photo</h4>
			</div>
			<div class="panel-body" id="usrphoto_' . $users["usrid"] . '">
			<img src="' . $users["usrphoto"] . '" width="150" />
			</div>
			<div class="panel-footer">
			<button type="button" class="btn btn-success btn-md" id="usr_but_pf_' . $users["usrid"] . '" title="Flag" data-toggle="modal" data-target="#myModal_pf"><i class="fa fa-edit fa-fw "></i> Change Picture</button>
			</div>
			</div>
			</div>
			<div class="col-lg-4">
			<div class="panel panel-green">
			<div class="panel-heading">
			<h4>Email Ids</h4>
			</div>
			<div class="panel-body" id="usremail_' . $users["usrid"] . '">
			<ul>' . $email . '</ul>
			</div>
			<div class="panel-footer">
			<button type="button"  class="btn btn-success btn-md" id="usremail_but_edit_' . $users["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
			<button type="button"  class="btn btn-success btn-md" style="display:none" id="usremail_but_' . $users["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Save</button>
			</div>
			</div>
			</div>
			<div class="col-lg-4">
			<div class="panel panel-green">
			<div class="panel-heading">
			<h4>Cell Numbers</h4>
			</div>
			<div class="panel-body" id="usrcnum_' . $users["usrid"] . '">
			<ul>' . $cnumber . '</ul>
			</div>
			<div class="panel-footer">
			<button  type="button" class="btn btn-success btn-md" id="usrcnum_but_edit_' . $users["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
			<button type="button" class="btn btn-success btn-md" style="display:none" id="usrcnum_but_' . $users["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Save</button>
			</div>
			</div>
			</div>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			<div class="col-lg-12">
			<button type="button" class="btn btn-danger btn-md" id="usr_but_close_' . $users["usrid"] . '"><i class="fa fa-close fa-fw "></i>close</button>
			</div>
			<script>
			$(document).ready(function(){
			var close = {
			closeDiv	:	"#usr_but_close_' . $users["usrid"] . '",
			clisttab	:	"#listgymsbut",
			};
			var obj = new clientController();
			obj.close(close);
			var editUserEmailIds = {
			autoloader : true,
			action 	   : "loadClientEmailId",
			outputDiv  : "#output",
			parentDiv  : "#usremail_' . $users["usrid"] . '",
			but  	   : "#usremail_but_edit_' . $users["usrid"] . '",
			num   	   : ' . $email_no . ',
			uid	   	   : "' . $users["usrid"] . '",
			index  	   : 0,
			listindex  : "list0f_client",
			form 	   : "email_id_' . $users["usrid"] . '_",
			email 	   : "email_' . $users["usrid"] . '_",
			msgDiv 	   : "email_msg_' . $users["usrid"] . '_",
			plus 	   : "plus_email_' . $users["usrid"] . '_",
			minus 	   : "minus_email_' . $users["usrid"] . '_",
			saveBut	   : "usremail_but_' . $users["usrid"] . '",
			closeBut   : "usremail_close_' . $users["usrid"] . '",
			url 	   : window.location.href
			};
			var obj = new clientController();
			obj.editUserEmailIds(editUserEmailIds);
			var editUserCellNumbers = {
			autoloader : true,
			action 	   : "loadCellNumForm",
			outputDiv  : "#output",
			parentDiv  : "#usrcnum_' . $users["usrid"] . '",
			but  	   : "#usrcnum_but_edit_' . $users["usrid"] . '",
			num   	   : ' . $cnum_no . ',
			uid	   	   : ' . $users["usrid"] . ',
			index  	   : 0,
			listindex  : "list0f_client",
			form 	   : "cnum_id_' . $users["usrid"] . '_",
			cnumber	   : "cnum_' . $users["usrid"] . '_",
			msgDiv 	   : "cnum_msg_' . $users["usrid"] . '_",
			plus 	   : "plus_cnum_' . $users["usrid"] . '_",
			minus 	   : "minus_cnum_' . $users["usrid"] . '_",
			saveBut	   : "usrcnum_but_' . $users["usrid"] . '",
			closeBut   : "usrcnum_close_' . $users["usrid"] . '",
			url 	   : window.location.href
			};
			var obj = new clientController();
			obj.editUserCellNumbers(editUserCellNumbers);
			});
			</script>';
    }

    // edit email address
    public function loadClientEmailId() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = clientadd::mmtable_list($clientQuery);
        $html = '';
        $emailHTM = '';
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailids = array(
            "oldemail" => NULL,
            "html" => NULL
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Email */
                    if (is_array($users[$i]["email"])) {
                        for ($j = 1; $j <= sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                            $flag = true;
                            $emailids["oldemail"][$j] = array(
                                "id" => ltrim($users[$i]["email_pk"][$j], ','),
                                "value" => ltrim($users[$i]["email"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "textid" => $this->parameters["email"] . $j,
                                "msgid" => $this->parameters["msgDiv"] . $j,
                                "deleteid" => $this->parameters["email"] . $j . '_delete',
                                "deleteOk" => 'deleteEmlOk_' . ltrim($users[$i]["email_pk"][$j], ',') . '_' . $j,
                                "deleteCancel" => 'deleteEmlCancel_' . ltrim($users[$i]["email_pk"][$j], ',') . '_' . $j
                            );
                            $emailHTM .= '<div id="' . $emailids["oldemail"][$j]["form"] . '">
								<div class="form-group input-group">
								<input class="form-control" placeholder="Email Id" name="' . $emailids["oldemail"][$j]["id"] . '" type="text" id="' . $emailids["oldemail"][$j]["textid"] . '" maxlength="100" value="' . ltrim($users[$i]["email"][$j], ',') . '" />
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
								Do You really want to delete <strong>' . ltrim($users[$i]["email"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
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
                }
            }
            $html = '<div class="col-lg-16">
				Add extra Email Ids : <button type="button" class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus fa-fw "></i></button>
				&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["minus"] . '"><i class="fa fa-close fa-minus "></i></button>
				&nbsp;<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
				</div><div class="class="col-lg-16">' . str_replace($this->order, $this->replace, $emailHTM) . '</div>';
            $emailids["html"] = $html;
        }
        return $emailids;
    }

    public function editClientEmailId() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["emailids"]["uid"];
        /* Emails Insert */
        if (isset($this->parameters["emailids"]["insert"]) && is_array($this->parameters["emailids"]["insert"]) && sizeof($this->parameters["emailids"]["insert"]) > -1 && $user_pk > 0) {
            $query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status` ) VALUES';
            for ($i = 0; $i < sizeof($this->parameters["emailids"]["insert"]); $i++) {
                if ($i == sizeof($this->parameters["emailids"]["insert"]) - 1)
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
					\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',
					\'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
                else
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
					\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',
					\'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
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

    public function deleteClientEmailId() {
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

    public function listClientEmailIds() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = clientadd::mmtable_list($clientQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailHTM = '<li>Not Provided</li>';
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Email */
                    if (is_array($users[$i]["email"]) && $users[$i]["email"][0] != '') {
                        $emailHTM = '<ul>';
                        for ($j = 0; $j <= sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                            $emailHTM .= '<li>' . ltrim($users[$i]["email"][$j], ',') . '</li>';
                        }
                        $emailHTM .= '</ul>';
                    }
                }
            }
        }
        return $emailHTM;
    }

    //edit Cell Number
    public function loadClientCellNumForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = clientadd::mmtable_list($clientQuery);
        $html = '';
        $cnumHTM = '';
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnums = array(
            "oldcnum" => NULL,
            "html" => NULL
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    $cnumHTM = '';
                    /* Cell Numbers */
                    if (is_array($users[$i]["cnumber"])) {
                        for ($j = 0; $j <= sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                            $flag = true;
                            $cnums["oldcnum"][$j] = array(
                                "id" => ltrim($users[$i]["cnumber_pk"][$j], ','),
                                "value" => ltrim($users[$i]["cnumber"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "textid" => $this->parameters["cnumber"] . $j,
                                "msgid" => $this->parameters["msgDiv"] . $j,
                                "deleteid" => $this->parameters["cnumber"] . $j . '_delete',
                                "deleteOk" => 'deleteCnumOk_' . ltrim($users[$i]["cnumber_pk"][$j], ',') . '_' . $j,
                                "deleteCancel" => 'deleteCnumCancel_' . ltrim($users[$i]["cnumber_pk"][$j], ',') . '_' . $j
                            );
                            $cnumHTM .= '<div id="' . $cnums["oldcnum"][$j]["form"] . '">
								<div class="form-group input-group">
								<input class="form-control" placeholder="Cell Number" name="' . $cnums["oldcnum"][$j]["id"] . '" type="text" min="0" id="' . $cnums["oldcnum"][$j]["textid"] . '" maxlength="10" value="' . ltrim($users[$i]["cnumber"][$j], ',') . '" />
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
								Do You really want to delete <strong>' . ltrim($users[$i]["cnumber"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $cnums["oldcnum"][$j]["deleteOk"] . '">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="' . $cnums["oldcnum"][$j]["deleteCancel"] . '">Cancel</button>
								</div>
								</div>
								</div>
								</div>
								</span>
								</div>
								<div class="col-lg-16" id="' . $cnums["oldcnum"][$j]["form"] . '">
								<p class="help-block" id="' . $cnums["oldcnum"][$j]["msgid"] . '">Valid.</p>
								</div>
								</div>';
                        }
                    }
                }
            }
            $html = '<div class="col-lg-16">
				Add extra Cell NO : <button type="button" class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus fa-fw "></i></button>
				<button  type="button" class="btn btn-success btn-circle" id="' . $this->parameters["minus"] . '"><i class="fa fa-minus fa-fw "></i></button>
				&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
				</div><div class="class="col-lg-16">' . str_replace($this->order, $this->replace, $cnumHTM) . '</div>';
            $cnums["html"] = $html;
        }
        return $cnums;
    }

    public function editClientCellNum() {
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

    public function deleteClientCellNum() {
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

    public function listClientCellNums() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = clientadd::mmtable_list($clientQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnumHTM = '<li>Not Provided</li>';
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Cell Numbers */
                    if (is_array($users[$i]["cnumber"]) && $users[$i]["cnumber"][0] != '') {
                        $cnumHTM = '<ul>';
                        for ($j = 0; $j <= sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                            $cnumHTM .= '<li>' . ltrim($users[$i]["cnumber"][$j], ',') . '</li>';
                        }
                        $cnumHTM .= '</ul>';
                    }
                }
            }
        }
        return $cnumHTM;
    }

    //chnage pic
    public function changeClientPic($fl) {
        $user_id = $this->parameters["usrid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["usrid"] . ')' : '';
        $clientQuery["var"] = $user_id;
        $users = clientadd::mmtable_list($clientQuery);
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

    //delete client
    public function deleteClient() {
        $flag = false;
        $query = NULL;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `user_profile` SET `status`="' . mysql_real_escape_string($this->statu["del"]) . '" WHERE `id` = "' . mysql_real_escape_string($this->parameters["usrid"]) . '";';
        if (executeQuery($query)) {
            $flag = true;
            executeQuery("COMMIT;");
        }
        return $flag;
    }

    //flag
    public function flagClient() {
        $flag = false;
        $query = NULL;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `user_profile` SET `status`="' . mysql_real_escape_string($this->statu["flag"]) . '" WHERE `id` = "' . mysql_real_escape_string($this->parameters["uid"]) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            $flag = true;
        }
        return $flag;
    }

    public function sendCredential() {
        $query = 'SELECT email_id,password,cell_number FROM `user_profile` WHERE id="' . mysql_real_escape_string($this->parameters["uid"]) . '";';
        //                echo $query;
        //                exit(0);
        $result = executeQuery($query);
        $row = mysql_fetch_assoc($result);
        $mess = "Login Credentials username : " . $row['email_id'] . " Password : " . $row['password'];
        $restPara = array(
            "user" => 'madmec',
            "password" => 'madmec',
            "mobiles" => $row['cell_number'],
            "sms" => $mess,
            "senderid" => 'MADMEC',
            "version" => 3,
            "accountusagetypeid" => 1
        );
        $url = 'http://trans.profuseservices.com/sendsms.jsp?' . http_build_query($restPara);
        $response2 = file_get_contents($url);
        return $response2;
    }

    //unflag
    public function unflagClient() {
        $flag = false;
        $query = NULL;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `user_profile` SET `status`="' . mysql_real_escape_string($this->statu["active"]) . '" WHERE `id` = "' . mysql_real_escape_string($this->parameters["uid"]) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            $flag = true;
        }
        return $flag;
    }

    // Add gym
    function addGYMProfile() {
        // gym_profile ('show','hide','delete');
        // userprofile_gym_profile ('active','inactive','delete')
        // email and Cell Number ('delete','undelete')
        $undelte = getStatusId("undelete");
        $active = getStatusId("active");
//        echo $this->parameters['clientreq'];
//        exit(0);
        if ($this->parameters['clientreq']) {
            $show = getStatusId("Pending");
             $user_pkk = $_SESSION["USER_LOGIN_DATA"]['USER_ID'];
             $_SESSION["GYMREQPEN"]=true;
        } else {
            $show = getStatusId("show");
             $user_pkk = $this->parameters["userpk"];
        }
        $gym_pk = 0;
        $type = '';
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
					\'' . mysql_real_escape_string($show) . '\')';
            if (executeQuery($query1)) {
                $gym_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                /* emails */
                if (is_array($this->parameters["email"]) && sizeof($this->parameters["email"]) > -1) {
                    $query = 'INSERT INTO  `gym_email_ids` (`id`,`user_pk`,`email`,`status` ) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["email"]); $i++) {
                        if ($i == sizeof($this->parameters["email"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($gym_pk) . '\',
									  \'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',
									  \'' . mysql_real_escape_string($undelte) . '\');';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($gym_pk) . '\',
									  \'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',
									  \'' . mysql_real_escape_string($undelte) . '\'),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `gym_profile` SET `email`= \'' . mysql_real_escape_string($this->parameters["email"][0]) . '\'
									WHERE `id` = \'' . mysql_real_escape_string($gym_pk) . '\'');
                }
                /* cell_numbers */
                if (is_array($this->parameters["cellnumbers"]) && sizeof($this->parameters["cellnumbers"]) > -1) {
                    $query = 'INSERT INTO  `gym_cell_numbers` (`id`,`user_pk`,`cell_code`,`cell_number`,`status`) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["cellnumbers"]); $i++) {
                        if ($i == sizeof($this->parameters["cellnumbers"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($gym_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]) . '\',
									\'' . mysql_real_escape_string($undelte) . '\');';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($gym_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]) . '\',
									\'' . mysql_real_escape_string($undelte) . '\'),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `gym_profile` SET `cell_code`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["codep"]) . '\',
										`cell_number`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["nump"]) . '\'
									WHERE `id` = \'' . mysql_real_escape_string($gym_pk) . '\'');
                }
                $directory_user = createdirectories(substr(md5(microtime()), 0, 6) . '_gym_' . $gym_pk);
                $db_name.=$gym_pk;
                executeQuery('UPDATE `gym_profile` SET `directory` = \'' . $directory_user . '\' WHERE `id`=\'' . mysql_real_escape_string($gym_pk) . '\';');
                executeQuery('UPDATE `gym_profile` SET `db_name`  = \'' . mysql_real_escape_string($db_name) . '\' WHERE `id`=\'' . mysql_real_escape_string($gym_pk) . '\';');
                executeQuery('INSERT INTO `userprofile_gymprofile` VALUES (NULL,\'' . mysql_real_escape_string($user_pkk) . '\',\'' . mysql_real_escape_string($gym_pk) . '\',\'' . mysql_real_escape_string($active) . '\');');
                if (!$this->parameters['clientreq']) {
                    executeQuery('CALL slaveDbCreate("' . $db_name . '");');
                }
                $flag = true;
            }
        }
        if ($flag) {
            executeQuery("COMMIT");
            $cell_number = mysql_result(executeQuery('SELECT `cell_number` FROM `user_profile` WHERE `id` = "' . $this->parameters["userpk"] . '";'), 0);
            $msg = $this->parameters["name"] . ' fitness centre added to your account. for queries call [7676 06 3644] [7676 46 3644]';
            if ($cell_number != '' && !empty($cell_number)) {
                $restPara = array(
                    "user" => 'madmec',
                    "password" => 'madmec',
                    "mobiles" => $cell_number,
                    "sms" => $msg,
                    "senderid" => 'MADMEC',
                    "version" => 3,
                    "accountusagetypeid" => 1
                );
                $url = 'http://trans.profuseservices.com/sendsms.jsp?' . http_build_query($restPara);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                if (!preg_match('/error/', $response)) {
                    $query = "INSERT INTO `sms_record`
					( `user_pk`, `number`,  `msg`, `status`, `date`)
					VALUES
					(
					'" . mysql_real_escape_string($user_pkk) . "',
					'" . mysql_real_escape_string($cell_number) . "',
					'" . mysql_real_escape_string($msg) . "',
					default,
					NOW()
					);";
                    executeQuery($query);
                }
            }
        }
        return $flag;
    }

    // add new client
    public function addClientProfile($fl) {
        //        $user_type = getUserTypeId("admin");
        $user_type = mysql_real_escape_string($this->parameters["addusertype"]);
        $undelte = getStatusId("undelete");
        $active = getStatusId("active");
        $show = getStatusId("show");
        $user_pk = 0;
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
        $apass = md5(mysql_real_escape_string($this->parameters["pass"]));
        /* Photo */
        $query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
			NULL,NULL,NULL,NULL,NULL,NULL);';
        if (executeQuery($query) && $this->parameters["name"] != "") {
            $photo_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* Profile */
            $query1 = 'INSERT INTO  `user_profile` (`id`,
				`user_name`,
				`acs_id`,
				`photo_id`,
				`password`,
				`apassword`,
				`passwordreset`,
				`authenticatkey`,
				`dob`,
				`gender`,
				`date_of_join`,
				`status`)
				VALUES(
				NULL,
				\'' . mysql_real_escape_string($this->parameters["name"]) . '\',
				\'' . mysql_real_escape_string($this->parameters["acsid"]) . '\',
				\'' . mysql_real_escape_string($photo_id) . '\',
				\'' . mysql_real_escape_string($this->parameters["pass"]) . '\',
				\'' . mysql_real_escape_string($apass) . '\',
				NULL,
				\'' . mysql_real_escape_string($this->parameters["auth"]) . '\',
				\'' . mysql_real_escape_string($this->parameters["dob"]) . '\',
				\'' . mysql_real_escape_string($this->parameters["gender"]) . '\',
				\'' . mysql_real_escape_string($curr_time) . '\',
				\'' . mysql_real_escape_string($active) . '\'
				)';
            if (executeQuery($query1)) {
                $user_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                /* emails */
                if (is_array($this->parameters["email"]) && sizeof($this->parameters["email"]) > -1) {
                    $query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status` ) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["email"]); $i++) {
                        if ($i == sizeof($this->parameters["email"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
							\'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',
							\'' . mysql_real_escape_string($undelte) . '\');';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
							\'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',
							\'' . mysql_real_escape_string($undelte) . '\'),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `user_profile` SET `email_id`= \'' . mysql_real_escape_string($this->parameters["email"][0]) . '\'
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
							\'' . mysql_real_escape_string($undelte) . '\');';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
							\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]) . '\',
							\'' . mysql_real_escape_string($undelte) . '\'),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `user_profile` SET `cell_code`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["codep"]) . '\',
						`cell_number`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["nump"]) . '\'
						WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
                }
                $directory_user = createdirectories(substr(md5(microtime()), 0, 6) . '_client_' . $user_pk);
                executeQuery('UPDATE `user_profile` SET `directory` = \'' . $directory_user . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
                executeQuery('INSERT INTO `userprofile_type` VALUES (NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($user_type) . '\',\'' . mysql_real_escape_string($show) . '\');');
                // ----------------------------------FILE DATA START
                $target_dir = DOC_ROOT . ASSET_DIR . $directory_user . "/profile/";
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
					\'' . mysql_real_escape_string($user_pk) . '\',
					\'' . mysql_real_escape_string($this->parameters["dtype"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["dnum"]) . '\',
					\'' . mysql_real_escape_string($dbpath) . '\',
					\'' . mysql_real_escape_string($show) . '\');';
                executeQuery($docqr);
                $flag = true;
            }
        }
        if ($flag) {
            executeQuery("COMMIT");
            $cell_number = mysql_result(executeQuery('SELECT `cell_number` FROM `user_profile` WHERE `id` = "' . $user_pk . '";'), 0);
            $email_id = mysql_result(executeQuery('SELECT `email_id` FROM `user_profile` WHERE `id` = "' . $user_pk . '";'), 0);
            $msg = 'Hi ' . $this->parameters["name"]
                    . ' Website :- http://www.tamboola.com'
                    . ' Your Login Id :- ' . $email_id
                    . ' Your Password :- ' . $this->parameters["pass"] . ' your account successfully created. for queries call [7676 06 3644] [7676 46 3644]';
            if ($cell_number != '' && !empty($cell_number)) {
                $restPara = array(
                    "user" => 'madmec',
                    "password" => 'madmec',
                    "mobiles" => $cell_number,
                    "sms" => $msg,
                    "senderid" => 'MADMEC',
                    "version" => 3,
                    "accountusagetypeid" => 1
                );
                $url = 'http://trans.profuseservices.com/sendsms.jsp?' . http_build_query($restPara);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                if (!preg_match('/error/', $response)) {
                    $query = "INSERT INTO `sms_record`
						( `user_pk`, `number`,  `msg`, `status`, `date`)
						VALUES
						(
						'" . mysql_real_escape_string($user_pk) . "',
						'" . mysql_real_escape_string($cell_number) . "',
						'" . mysql_real_escape_string($msg) . "',
						default,
						NOW()
						);";
                    executeQuery($query);
                }
            }
        }
        return $flag;
    }

    public function userAutocomplete() {
        $name = Null;
        $query1 = 'SELECT
			a.`id`,
			a.`user_name`,
			a.`email_id`,
			a.`cell_code`,
			CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "")
			THEN "' . USER_ANON_IMAGE . '"
			ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
			END AS usrphoto,
			a.`cell_number`
			FROM `user_profile` AS a
			LEFT JOIN `photo` AS ph ON a.`photo_id` = ph.`id`
			RIGHT JOIN `userprofile_type` AS ust
			ON ust.`user_pk` = a.`id`
			LEFT JOIN user_type AS ut
			ON ust.`usertype_id` = ut.`id`
			WHERE ut.`type` = \'Owner\'
			AND ut.`status`= (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
			AND a.`status`= (SELECT `id` FROM `status` WHERE `statu_name` = "Active" AND `status` = 1);';
        $res = executeQuery($query1);
        if (mysql_num_rows($res) > 0) {
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $name[$i]["label"] = $row["user_name"] . " - " . $row["email_id"] . " - " . $row["cell_code"] . " - " . $row["cell_number"];
                $name[$i]["value"] = $i;
                $name[$i]["id"] = $row["id"];
                $i++;
            }
        }
        $clients = array(
            "listofClient" => $name,
        );
        return $clients;
    }

    // edit GYM email address
    public function loadGYMEmailId() {
        $users = NULL;
        $html = '';
        $emailHTM = '';
        $num_posts = 0;
        $query = 'SELECT
			GROUP_CONCAT(em.`id`,"☻☻♥♥☻☻") AS email_pk,
			GROUP_CONCAT(em.`email`,"☻☻♥♥☻☻") AS email,
			em.`user_pk`
			FROM `gym_email_ids` AS em
			WHERE em.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
			AND em.`user_pk` LIKE CONCAT(' . $this->parameters["uid"] . ')
			GROUP BY (em.`user_pk`)
			ORDER BY (em.`user_pk`)';
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
            }
        }
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailids = array(
            "oldemail" => NULL,
            "html" => NULL
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts; $i++) {
                /* Email */
                if (is_array($users[$i]["email"])) {
                    for ($j = 0; $j <= sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                        $flag = true;
                        $emailids["oldemail"][$j] = array(
                            "id" => ltrim($users[$i]["email_pk"][$j], ','),
                            "value" => ltrim($users[$i]["email"][$j], ','),
                            "form" => $this->parameters["form"] . $j,
                            "textid" => $this->parameters["email"] . $j,
                            "msgid" => $this->parameters["msgDiv"] . $j,
                            "deleteid" => $this->parameters["email"] . $j . '_delete',
                            "deleteOk" => 'deleteEmlOk_' . ltrim($users[$i]["email_pk"][$j], ',') . '_' . $j,
                            "deleteCancel" => 'deleteEmlCancel_' . ltrim($users[$i]["email_pk"][$j], ',') . '_' . $j
                        );
                        $emailHTM .= '<div id="' . $emailids["oldemail"][$j]["form"] . '">
							<div class="form-group input-group">
							<input class="form-control" placeholder="Email Id" name="' . $emailids["oldemail"][$j]["id"] . '" type="text" id="' . $emailids["oldemail"][$j]["textid"] . '" maxlength="100" value="' . ltrim($users[$i]["email"][$j], ',') . '" />
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
							Do You really want to delete <strong>' . ltrim($users[$i]["email"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
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
            }
            $html = '<div class="col-lg-16">
				Add extra Email Ids : <button type="button" class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus fa-fw "></i></button>
				&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["minus"] . '"><i class="fa fa-close fa-minus "></i></button>
				&nbsp;<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
				</div><div class="class="col-lg-16">' . str_replace($this->order, $this->replace, $emailHTM) . '</div>';
            $emailids["html"] = $html;
        }
        return $emailids;
    }

    public function editGYMEmailId() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["emailids"]["uid"];
        /* Emails Insert */
        if (isset($this->parameters["emailids"]["insert"]) && is_array($this->parameters["emailids"]["insert"]) && sizeof($this->parameters["emailids"]["insert"]) > -1 && $user_pk > 0) {
            $query = 'INSERT INTO  `gym_email_ids` (`id`,`user_pk`,`email`,`status` ) VALUES';
            for ($i = 0; $i < sizeof($this->parameters["emailids"]["insert"]); $i++) {
                if ($i == sizeof($this->parameters["emailids"]["insert"]) - 1)
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
					\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',
					\'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
                else
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
					\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',
					\'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
            }
            executeQuery($query);
            executeQuery('UPDATE `gym_profile` SET `email`= \'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][0]) . '\'
				WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
            $flag = true;
            $flag = true;
        }
        /* Emails Update */
        if (isset($this->parameters["emailids"]["update"]) && is_array($this->parameters["emailids"]["update"]) && sizeof($this->parameters["emailids"]["update"]) > -1 && $user_pk > 0) {
            for ($i = 0; $i < sizeof($this->parameters["emailids"]["update"]); $i++) {
                $query = 'UPDATE  `gym_email_ids`
					SET `email` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["email"]) . '\'
					WHERE `id` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["id"]) . '\';';
                executeQuery($query);
            }
            $query = 'UPDATE  `gym_profile`
				SET `email` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][0]["email"]) . '\'
				WHERE `id` = \'' . mysql_real_escape_string($this->parameters["emailids"]["uid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function deleteGYMEmailId() {
        $flag = false;
        $del = getStatusId("delete");
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Emails Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `gym_email_ids`
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

    public function listGYMEmailIds() {
        $users = NULL;
        $num_posts = 0;
        $query = 'SELECT
			GROUP_CONCAT(em.`id`,"☻☻♥♥☻☻") AS email_pk,
			GROUP_CONCAT(em.`email`,"☻☻♥♥☻☻") AS email,
			em.`user_pk`
			FROM `gym_email_ids` AS em
			WHERE em.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
			AND em.`user_pk` LIKE CONCAT(' . $this->parameters["uid"] . ')
			GROUP BY (em.`user_pk`)
			ORDER BY (em.`user_pk`)';
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
            }
        }
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailHTM = '<li>Not Provided</li>';
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts; $i++) {
                /* Email */
                if (is_array($users[$i]["email"]) && $users[$i]["email"][0] != '') {
                    $emailHTM = '<ul>';
                    for ($j = 0; $j <= sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                        $emailHTM .= '<li>' . ltrim($users[$i]["email"][$j], ',') . '</li>';
                    }
                    $emailHTM .= '</ul>';
                }
            }
        }
        return $emailHTM;
    }

    // edit gym Cell Number
    public function loadGYMCellNumForm() {
        $num_posts = 0;
        $html = '';
        $cnumHTM = '';
        $query = 'SELECT
			GROUP_CONCAT(cn.`id`,"☻☻♥♥☻☻") AS cell_pk,
			GROUP_CONCAT(cn.`cell_number`,"☻☻♥♥☻☻") AS cnumber,
			cn.`user_pk`
			FROM `gym_cell_numbers` AS cn
			WHERE cn.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
			AND cn.`user_pk` LIKE CONCAT(' . $this->parameters["uid"] . ')
			GROUP BY (cn.`user_pk`)
			ORDER BY (cn.`user_pk`)';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $users[] = $row;
            }
        }
        $total = sizeof($users);
        if ($total) {
            for ($i = 0; $i < $total; $i++) {
                $users[$i]["cnumber_pk"] = explode("☻☻♥♥☻☻", $users[$i]["cell_pk"]);
                $users[$i]["cnumber"] = explode("☻☻♥♥☻☻", $users[$i]["cnumber"]);
            }
        }
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnums = array(
            "oldcnum" => NULL,
            "html" => NULL
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts; $i++) {
                $cnumHTM = '';
                /* Cell Numbers */
                if (is_array($users[$i]["cnumber"])) {
                    for ($j = 0; $j <= sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                        $flag = true;
                        $cnums["oldcnum"][$j] = array(
                            "id" => ltrim($users[$i]["cnumber_pk"][$j], ','),
                            "value" => ltrim($users[$i]["cnumber"][$j], ','),
                            "form" => $this->parameters["form"] . $j,
                            "textid" => $this->parameters["cnumber"] . $j,
                            "msgid" => $this->parameters["msgDiv"] . $j,
                            "deleteid" => $this->parameters["cnumber"] . $j . '_delete',
                            "deleteOk" => 'deleteCnumOk_' . ltrim($users[$i]["cnumber_pk"][$j], ',') . '_' . $j,
                            "deleteCancel" => 'deleteCnumCancel_' . ltrim($users[$i]["cnumber_pk"][$j], ',') . '_' . $j
                        );
                        $cnumHTM .= '<div id="' . $cnums["oldcnum"][$j]["form"] . '">
							<div class="form-group input-group">
							<input class="form-control" placeholder="Cell Number" name="' . $cnums["oldcnum"][$j]["id"] . '" type="text" min="0" id="' . $cnums["oldcnum"][$j]["textid"] . '" maxlength="10" value="' . ltrim($users[$i]["cnumber"][$j], ',') . '" />
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
							Do You really want to delete <strong>' . ltrim($users[$i]["cnumber"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
							</div>
							<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $cnums["oldcnum"][$j]["deleteOk"] . '">Ok</button>
							<button type="button" class="btn btn-success" data-dismiss="modal" id="' . $cnums["oldcnum"][$j]["deleteCancel"] . '">Cancel</button>
							</div>
							</div>
							</div>
							</div>
							</span>
							</div>
							<div class="col-lg-16" id="' . $cnums["oldcnum"][$j]["form"] . '">
							<p class="help-block" id="' . $cnums["oldcnum"][$j]["msgid"] . '">Valid.</p>
							</div>
							</div>';
                    }
                }
            }
            $html = '<div class="col-lg-16">
				Add extra Cell NO : <button class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus fa-fw "></i></button>
				<button  type="button" class="btn btn-success btn-circle" id="' . $this->parameters["minus"] . '"><i class="fa fa-minus fa-fw "></i></button>
				&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
				</div><div class="class="col-lg-16">' . str_replace($this->order, $this->replace, $cnumHTM) . '</div>';
            $cnums["html"] = $html;
        }
        return $cnums;
    }

    public function editGYMCellNum() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["CellNums"]["uid"];
        /* Cell Numbers Insert */
        if (isset($this->parameters["CellNums"]["insert"]) && is_array($this->parameters["CellNums"]["insert"]) && sizeof($this->parameters["CellNums"]["insert"]) > -1 && $user_pk > 0) {
            $query = 'INSERT INTO  `gym_cell_numbers` (`id`,`user_pk`,`cell_number`,`status`) VALUES';
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
            executeQuery('UPDATE `gym_profile` SET `cell_number`= \'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][0]) . '\'
				WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
            $flag = true;
        }
        /* Cell Numbers Update */
        if (isset($this->parameters["CellNums"]["update"]) && is_array($this->parameters["CellNums"]["update"]) && sizeof($this->parameters["CellNums"]["update"]) > -1 && $user_pk > 0) {
            for ($i = 0; $i < sizeof($this->parameters["CellNums"]["update"]); $i++) {
                $query = 'UPDATE  `gym_cell_numbers`
					SET `cell_number` = \'' . mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["cnumber"]) . '\'
					WHERE `id` = \'' . mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["id"]) . '\';';
                executeQuery($query);
            }
            $query = 'UPDATE  `gym_profile`
				SET `cell_number` = \'' . mysql_real_escape_string($this->parameters["CellNums"]["update"][0]["cnumber"]) . '\'
				WHERE `id` = \'' . mysql_real_escape_string($this->parameters["CellNums"]["uid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function deleteGYMCellNum() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Emails Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `gym_cell_numbers`
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

    public function listGYMCellNums() {
        $users = NULL;
        $num_posts = 0;
        $query = 'SELECT
			GROUP_CONCAT(cn.`id`,"☻☻♥♥☻☻") AS cell_pk,
			GROUP_CONCAT(cn.`cell_number`,"☻☻♥♥☻☻") AS cnumber,
			cn.`user_pk`
			FROM `gym_cell_numbers` AS cn
			WHERE cn.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Undelete" AND `status` = 1)
			AND cn.`user_pk` LIKE CONCAT(' . $this->parameters["uid"] . ')
			GROUP BY (cn.`user_pk`)
			ORDER BY (cn.`user_pk`)';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $users[] = $row;
            }
        }
        $total = sizeof($users);
        if ($total) {
            for ($i = 0; $i < $total; $i++) {
                $users[$i]["cnumber_pk"] = explode("☻☻♥♥☻☻", $users[$i]["cell_pk"]);
                $users[$i]["cnumber"] = explode("☻☻♥♥☻☻", $users[$i]["cnumber"]);
            }
        }
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnumHTM = '<li>Not Provided</li>';
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts; $i++) {
                /* Cell Numbers */
                if (is_array($users[$i]["cnumber"]) && $users[$i]["cnumber"][0] != '') {
                    $cnumHTM = '<ul>';
                    for ($j = 0; $j <= sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                        $cnumHTM .= '<li>' . ltrim($users[$i]["cnumber"][$j], ',') . '</li>';
                    }
                    $cnumHTM .= '</ul>';
                }
            }
        }
        return $cnumHTM;
    }

    public function gymAddrsEdit($data) {
        $flag = false;
        $res = executeQuery('UPDATE `gym_profile` SET `country` = "' . $data["country"] . '",`province` = "' . $data["province"] . '",`district` = "' . $data["district"] . '",`city` = "' . $data["city_town"] . '",`town` = "' . $data["street"] . '",`addressline` = "' . $data["addrs"] . '",`zipcode` = "' . $data["zipcode"] . '",`website` = "' . $data["website"] . '",`gmaphtml` = "' . $data["gmaphtml"] . '" WHERE `id`=\'' . mysql_real_escape_string($data["gymid"]) . '\';');
        $htmdata = '
			<ul>
			<li><strong>Address line : </strong>' . $data["addrs"] . '</li>
			<li><strong>Street / Locality : </strong>' . $data["street"] . '</li>
			<li><strong>City / Town : </strong>' . $data["city_town"] . '</li>
			<li><strong>District / Department : </strong>' . $data["district"] . '</li>
			<li><strong>State / Provice : </strong>' . $data["province"] . '</li>
			<li><strong>Country : </strong>' . $data["country"] . '</li>
			<li><strong>Zipcode : </strong>' . $data["zipcode"] . '</li>
			<li><strong>Website : </strong>' . $data["website"] . '</li>
			<li><strong>Google Map : </strong>' . $data["gmaphtml"] . '</li>
			</ul>';
        if ($res)
            $flag = true;
        $updateAdd = array(
            "htm" => $htmdata,
            "status" => $flag,
        );
        return $updateAdd;
    }

    public function gymdatadocEdit($data) {
        $flag = false;
        $res = executeQuery('UPDATE `gym_profile` SET `gym_name` = "' . $data["gymBname"] . '",`gym_type` = "' . $data["gymType"] . '",`db_host` = "' . $data["gymdbHost"] . '",`db_username` = "' . $data["gymdbUsernm"] . '",`db_name` = "' . $data["gymdbName"] . '",`db_password` = "' . $data["gymdbPass"] . '",`short_logo` = "' . $data["gymslogo"] . '",`header_logo` = "' . $data["gymhlogo"] . '" WHERE `id`=\'' . mysql_real_escape_string($data["gymid"]) . '\';');
        $htmdata = '
			<ul>
			<li><strong>Branch Name : </strong>' . $data["gymBname"] . '</li>
			<li><strong>Branch Type : </strong>' . $data["gymType"] . '</li>
			<li><strong>DB-HOST  : </strong>' . $data["gymdbHost"] . '</li>
			<li><strong>DB-USERNAME : </strong>' . $data["gymdbUsernm"] . '</li>
			<li><strong>DB-NAME : </strong>' . $data["gymdbName"] . '</li>
			<li><strong>DB-PASSWORD : </strong>' . $data["gymdbPass"] . '</li>
			<li><strong>Short-LOGO : </strong>' . $data["gymslogo"] . '</li>
			<li><strong>Header-LOGO : </strong>' . $data["gymhlogo"] . '</li>
			</ul>';
        if ($res)
            $flag = true;
        $updateData = array(
            "htm" => $htmdata,
            "status" => $flag,
        );
        return $updateData;
    }

    public function gymDELETE($gymid) {
        $flag = false;
        $query = NULL;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `gym_profile` SET `status`="' . mysql_real_escape_string($this->statu["del"]) . '" WHERE `id` = "' . mysql_real_escape_string($gymid) . '";';
        if (executeQuery($query)) {
            $flag = true;
            executeQuery("COMMIT;");
        }
        return $flag;
    }

    //gYm flag
    public function flagGYM() {
        $flag = false;
        $query = NULL;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `gym_profile` SET `status`="' . mysql_real_escape_string($this->statu["flag"]) . '" WHERE `id` = "' . mysql_real_escape_string($this->parameters["uid"]) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            $flag = true;
        }
        return $flag;
    }

    //GYM unflag
    public function unflagGYM() {
        $flag = false;
        $query = NULL;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `gym_profile` SET `status`="' . mysql_real_escape_string($this->statu["active"]) . '" WHERE `id` = "' . mysql_real_escape_string($this->parameters["uid"]) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            $flag = true;
        }
        return $flag;
    }

}

?>