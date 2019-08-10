<?php

class Attendance {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';

    public function __construct($para = false) {
        $this->parameters = $para;
    }

    public function customer_att() {
        // $name = false,$mobile = false,$email = false,$offer = false,$duration = false,$package = false,$jnd = false,$exp_date = false
        $listusers = array();
        $query = '';
        $subquery = '';
        switch ($this->parameters["user"]) {
            case "customer": {
                    switch ($this->parameters["action"]) {
                        case "markCustAtt": {
                                $subquery = "AND cust.`id` IN  (
								SELECT
									DISTINCT(a.`id`) AS cust_pk
								FROM  `customer` AS a
								INNER JOIN  `customer_attendence` AS d ON d.`customer_pk` =  a.`id`
								WHERE d.`facility_id` = '" . $this->parameters["fid"] . "'
								AND STR_TO_DATE(NOW(),'%Y-%m-%d') = STR_TO_DATE(d.`in_time` ,'%Y-%m-%d')
								AND d.`status` = 12
							)";
                                break;
                            }
                        case "unmarkCustAtt": {
                                $subquery = "AND cust.`id` IN (
								SELECT
									DISTINCT(a.`id`) AS cust_pk
								FROM  `customer` AS a
								INNER JOIN  `customer_attendence` AS d ON d.`customer_pk` =  a.`id`
								WHERE d.`facility_id` = '" . $this->parameters["fid"] . "'
								AND STR_TO_DATE(NOW(),'%Y-%m-%d') = STR_TO_DATE(d.`in_time` ,'%Y-%m-%d')
								AND d.`status` = 11
							)";
                                break;
                            }
                        default: {
                                /*
                                  $subquery = "AND cust.`id` NOT IN  (
                                  SELECT
                                  DISTINCT(a.`id`) AS cust_pk
                                  FROM  `customer` AS a
                                  INNER JOIN  `customer_attendence` AS d ON d.`customer_pk` =  a.`id`
                                  WHERE d.`facility_id` = '" . $this->parameters["fid"] . "'
                                  AND STR_TO_DATE(NOW(),'%Y-%m-%d') = STR_TO_DATE(d.`in_time` ,'%Y-%m-%d')
                                  AND d.`status` = 12 OR d.`status` = 11
                                  )";
                                 */
                                $subquery = "";
                                break;
                            }
                    }
                    $query = "SELECT
						GROUP_CONCAT(g.`id`,'☻☻♥♥☻☻') AS cust_id,
						GROUP_CONCAT(g.`cust_name`,'☻☻♥♥☻☻') AS cust_name,
						GROUP_CONCAT(g.`cust_email`,'☻☻♥♥☻☻') AS cust_email,
						GROUP_CONCAT(g.`cnum`,'☻☻♥♥☻☻') AS cnum,
						g.`facility_id`,
						(SELECT `name` FROM `facility` WHERE `id` = g.`facility_id`) AS facility_name,
						GROUP_CONCAT(g.`uphoto`,'☻☻♥♥☻☻') AS cphoto
					FROM(
						SELECT
							cft.`facility_id` AS facility_id,
							cust.`id` AS id,
							cust.`name` AS cust_name,
							cust.`email` AS cust_email,
							cust.`cell_number` AS cnum,
							CASE
								WHEN ph.`ver2` IS NOT NULL
								THEN CONCAT('" . URL . DIRS . "', ph.`ver2`)
								ELSE '" . USER_ANON_IMAGE . "'
							END AS uphoto
						FROM `customer` As cust
						LEFT  JOIN  `group_members` AS gm ON cust.`id` =  gm.`customer_pk` AND gm.`status` = (SELECT id FROM `status` WHERE statu_name = 'Joined' and `status`=1)
						LEFT  JOIN  `groups` AS gr ON gr.`id` =  gm.`group_id` AND gr.`status` = (SELECT id FROM `status` WHERE statu_name = 'Show' and `status`=1)
						LEFT  JOIN  `photo` AS ph ON ph.`id` = cust.`photo_id`
						LEFT  JOIN  `customer_facility` AS cft ON cft.`customer_pk` = cust.`id` AND cft.`status` =(SELECT id FROM `status` WHERE statu_name = 'Show' and `status`=1)
						WHERE cft.`customer_pk` = cust.`id`
						" . $subquery . "
						AND cft.`facility_id` != 0
					) as g
					WHERE g.`facility_id` = '" . $this->parameters["fid"] . "';";
                    break;
                }
            case "employee": {
                    switch ($this->parameters["action"]) {
                        case "markCustAtt": {
                                $subquery = "AND cust.`id` IN  (
								SELECT
									DISTINCT(a.`id`) AS cust_pk
								FROM  `employee` AS a
								INNER JOIN  `employee_attendence` AS d ON d.`employee_id` =  a.`id`
								WHERE d.`facility_id` = '" . $this->parameters["fid"] . "'
								AND STR_TO_DATE(NOW(),'%Y-%m-%d') = STR_TO_DATE(d.`in_time` ,'%Y-%m-%d')
								AND d.`status` = 12
							)";
                                break;
                            }
                        case "unmarkCustAtt": {
                                $subquery = "AND cust.`id` IN (
								SELECT
									DISTINCT(a.`id`) AS cust_pk
								FROM  `employee` AS a
								INNER JOIN  `employee_attendence` AS d ON d.`employee_id` =  a.`id`
								WHERE d.`facility_id` = '" . $this->parameters["fid"] . "'
								AND STR_TO_DATE(NOW(),'%Y-%m-%d') = STR_TO_DATE(d.`in_time` ,'%Y-%m-%d')
								AND d.`status` = 11
							)";
                                break;
                            }
                        default: {
                                /*
                                  $subquery = "AND cust.`id` NOT IN  (
                                  SELECT
                                  DISTINCT(a.`id`) AS cust_pk
                                  FROM  `employee` AS a
                                  INNER JOIN  `employee_attendence` AS d ON d.`employee_id` =  a.`id`
                                  WHERE d.`facility_id` = '" . $this->parameters["fid"] . "'
                                  AND STR_TO_DATE(NOW(),'%Y-%m-%d') = STR_TO_DATE(d.`in_time` ,'%Y-%m-%d')
                                  AND d.`status` = 12 OR d.`status` = 11
                                  )";
                                 */
                                $subquery = "";
                                break;
                            }
                    }
                    $query = "SELECT
						GROUP_CONCAT(g.`id`,'☻☻♥♥☻☻') AS cust_id,
						GROUP_CONCAT(g.`cust_name`,'☻☻♥♥☻☻') AS cust_name,
						GROUP_CONCAT(g.`cust_email`,'☻☻♥♥☻☻') AS cust_email,
						GROUP_CONCAT(g.`cnum`,'☻☻♥♥☻☻') AS cnum,
						g.`facility_id`,
						(SELECT `name` FROM `facility` WHERE `id` = g.`facility_id`) AS facility_name,
						GROUP_CONCAT(g.`uphoto`,'☻☻♥♥☻☻') AS cphoto
					FROM(
						SELECT
							cft.`facility_id` AS facility_id,
							cust.`id` AS id,
							cust.`user_name` AS cust_name,
							cust.`email` AS cust_email,
							cust.`cell_number` AS cnum,
							CASE
								WHEN ph.`ver2` IS NOT NULL
								THEN CONCAT('" . URL . DIRS . "', ph.`ver2`)
								ELSE '" . TRAIN_ANON_IMAGE . "'
							END AS uphoto
						FROM `employee` As cust
						LEFT  JOIN  `photo` AS ph ON ph.`id` = cust.`photo_id`
						LEFT  JOIN  `employee_facility` AS cft ON cft.`employee_id` = cust.`id` AND cft.`status` =(SELECT id FROM `status` WHERE statu_name = 'Show' and status=1)
						WHERE cft.`employee_id` = cust.`id`
						" . $subquery . "
						AND cft.`facility_id` != 0
					) as g
					WHERE g.`facility_id` = '" . $this->parameters["fid"] . "';";
                    break;
                }
        }
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            // $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                array_push($listusers, array(
                    'id' => $row['cust_id'],
                    'name' => $row['cust_name'],
                    'email_id' => $row['cust_email'],
                    'cnum' => $row['cnum'],
                    'facility_type' => $row['facility_id'],
                    'uphoto' => $row['cphoto'],
                    'facility_id' => $row['facility_id'],
                    'facility_name' => $row['facility_name']
                ));
                // $listusers[$i]['id'] = array_push()$row['cust_id'];
                // $listusers[$i]['name'] = $row['cust_name'];
                // $listusers[$i]['email_id'] = $row['cust_email'];
                // $listusers[$i]['cnum'] = $row['cnum'];
                // $listusers[$i]['facility_type'] = $row['facility_id'];
                // $listusers[$i]['uphoto'] = $row['cphoto'];
                // $listusers[$i]['facility_id'] = $row['facility_id'];
                // $listusers[$i]['facility_name'] = $row['facility_name'];
                // $i++;
            }
        }
        $this->DisplayList($listusers);
    }

    public function DisplayList($listusers) {
        $users = array();
        $total = sizeof($listusers);
        $facility_id = $listusers[0]['facility_id'];
        $facility_name = $listusers[0]['facility_name'];
        $htm = '';
        $sct = '';
        $tableid = 'attednaceTable' . mt_rand(99, 99999);
        $flag = false;
        if ($total) {
            for ($i = 0; $i < $total; $i++) {
                $users[$i]["uphoto"] = explode("☻☻♥♥☻☻", $listusers[$i]["uphoto"]);
                $users[$i]["cust_id"] = explode("☻☻♥♥☻☻", $listusers[$i]["id"]);
                $users[$i]["name"] = explode("☻☻♥♥☻☻", $listusers[$i]["name"]);
                $users[$i]["email_id"] = explode("☻☻♥♥☻☻", $listusers[$i]["email_id"]);
                $users[$i]["cnum"] = explode("☻☻♥♥☻☻", $listusers[$i]["cnum"]);
                $users[$i]["facility_type"] = explode("☻☻♥♥☻☻", $listusers[$i]["facility_type"]);
                $flag = true;
            }
        } else {
            $users = NULL;
        }
        // $num_posts = sizeof($listusers);
        $htm .= str_replace($this->order, $this->replace, '
			<table class="table table-striped table-bordered table-hover" id="' . $tableid . '">
	  	       <thead>
		       <tr>
	  	        <th>No</th>
	  	        <!--<th>Avatar</th> -->
	  	        <th>Details</th>
	  	        <th>In Time</th>
	  	        <th>Out Time</th>
	  	        <th>Status</th>
	  	      </tr>
		      </thead><tbody>');
        if ($flag) {
            $name = '';
            $email = '';
            $cnum = '';
            $totalname = 0;
            $totalemail = 0;
            for ($i = 0; $i < $total; $i++) {
                for ($k = 0; $k < sizeof($users[$i]["name"]) && !empty($users[$i]["name"][$k]) && $users[$i]["name"][$k] != ""; $k++) {
                    // if($this->CheckValidity(ltrim($users[$i]["cust_id"][$k]),",")){
                    if ($this->parameters["user"] == 'customer') {
                        if (!$this->CheckValidity(preg_replace('/^[,\s]+|[\s,]+$/', '', $users[$i]["cust_id"][$k]))) {
                            continue;
                        }
                    }
                    $name = ltrim($users[$i]["name"][$k], ',');
                    $id = ltrim($users[$i]["cust_id"][$k], ',');
                    if (!isset($name))
                        $name = '<strong>Not Provided</strong>';
                    $photo = isset($users[$i]["uphoto"][$k]) ? ltrim($users[$i]["uphoto"][$k], ',') : '';
                    if (!isset($photo))
                        $photo = USER_ANON_IMAGE;
                    $email = isset($users[$i]["email_id"][$k]) ? ltrim($users[$i]["email_id"][$k], ',') : '';
                    if (!isset($email))
                        $email = '<strong>Not Provided</strong>';
                    $cnum = isset($users[$i]["cnum"][$k]) ? ltrim($users[$i]["cnum"][$k], ',') : '';
                    if (!isset($cnum))
                        $cnum = '<strong>Not Provided</strong>';
                    $tdayat = $this->AttendanceToday($id, $facility_id);
                    $row = $tdayat["rec"];
                    $mark = '';
                    $in_time = '---';
                    $out_time = '---';
                    $color = '<span class="text-danger"><i class="fa  fa-circle fa-3x fa-fw"></i></span>';
                    $aid = "NULL";
                    if (isset($row["att_id"])) {
                        if ($row != NULL && $row['status'] == 11) {
                            $in_time = date('g:i a', strtotime($row['in_time']));
                            if ($row['status'] == 12)
                                $out_time = date('g:i a', strtotime($row['out_time']));
                            else {
                                $out_time = '---';
                                $mark = 'checked';
                                $color = '<span class="text-success"><i class="fa  fa-check-circle fa-3x fa-fw"></i></span>';
                            }
                            $aid = $row['att_id'];
                        }
                        if ($row != NULL && $row['status'] == 12) {
                            $in_time = date('g:i a', strtotime($row['in_time']));
                            if ($row['status'] == 12)
                                $out_time = date('g:i a', strtotime($row['out_time']));
                            else {
                                $out_time = '---';
                                //$mark = 'checked';
                                $color = '<span class="text-danger"><i class="fa  fa-circle fa-3x fa-fw"></i></span>';
                            }
                            $aid = $row['att_id'];
                        }
                    }
                    $htm .= str_replace($this->order, $this->replace, '<tr id="user_row_' . $k . '">
			       <td>' . ($k + 1) . '</td>
				 <!--<td>
				<div style="float:left; overflow:hidden;" id="uimgs_' . $k . '">
				<img src=' . USER_ANON_IMAGE . ' width="45" class="img-circle"/>
				</div>
				</td> -->
				<td>
				<div style="float:left;" id="details_' . $k . '">
				' . $name . ' <br />
				' . $email . ' <br />
				    ' . $cnum . ' <br />
				</div>
				</td>
				<td id="' . $facility_id . '_' . $k . '_intime">' . $in_time . '</td>
				<td id="' . $facility_id . '_' . $k . '_outtime">' . $out_time . '</td>
				<td style="cursor:pointer;" id="mark_' . $k . '">' . $color . '</td>
			      </tr>');
                    $sct .= str_replace($this->order, $this->replace, '
					$("#mark_' . $k . '").bind("click",function(){
						var att = {
							id		:	"' . $id . '",
							attid	:	"' . $aid . '",
							index	:	"' . $k . '",
							facility	:	"' . $facility_id . '",
							symbol  : 	"#mark_' . $k . '",
							resin	:	"#' . $facility_id . '_' . $k . '_intime",
							resout	:	"#' . $facility_id . '_' . $k . '_outtime",
							user	:	"' . $this->parameters["user"] . '"
						};
						var obj = new controlManage();
						obj.update_attendance(att);
						$("#user_row_' . $k . '").css("opacity","0.3");
						$("#user_row_' . $k . '").remove();
					});');
                }
            }
        } else {
            $htm .= '<tr><td colspan="5">No Customer Purchased The Offer In ' . $facility_name . '.</td></tr>';
        }
        $htm .= '</tbody></table>';
        echo json_encode(array(
            "html" => $htm . '<script>' . $sct . '</script>',
            "id" => $tableid
        ));
    }

    public function AttendanceToday($id, $facility_type) {
        $flag = NULL;
        $table1 = '';
        $table2 = '';
        $ids = '';
        switch ($this->parameters["user"]) {
            case "customer": {
                    $table1 = '`customer`';
                    $table2 = '`customer_attendence`';
                    $ids = '`customer_pk`';
                    break;
                }
            case "employee": {
                    $table1 = '`employee`';
                    $table2 = '`employee_attendence`';
                    $ids = '`employee_id`';
                    break;
                }
        }
        $query = "SELECT
			a.`id` AS cust_pk,
			d.`id` AS att_id,
			d.`in_time`,
			d.`out_time`,
			d.`status`
		FROM  " . $table1 . " AS a
		INNER JOIN  " . $table2 . " AS d ON d." . $ids . " =  a.`id`
		WHERE a.`id` =  '" . $id . "'
		AND " . $ids . " =  '" . $id . "'
		AND d.`facility_id` = '" . $facility_type . "'
		AND d.in_time LIKE '" . date('Y-m-d') . "%'
		ORDER BY d.`id` DESC
		LIMIT 1;";
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $flag = mysql_fetch_assoc($res);
        }
        $todayatt = array(
            "rec" => $flag,
            "que" => $query,
        );
        return $todayatt;
    }

    public function UpdateAtd() {
        $id = $this->parameters["pid"];
        $aid = $this->parameters["aid"];
        $ftype = $this->parameters["ftype"];
        $flag = false;
        $status = 0;
        switch ($this->parameters["user"]) {
            case "customer": {
                    if ($aid != "NULL") {
                        $res = executeQuery("SELECT `status` FROM `customer_attendence` WHERE `status` = 12 AND `id` = '" . mysql_real_escape_string($aid) . "';");
                        $status = mysql_result($res, 0);
                        if ($status == 12) {
                            $res = executeQuery("UPDATE `customer_attendence`
							SET `in_time` = NOW(), `out_time` = NOW()+ INTERVAL 2 HOUR, `status` = 11
							WHERE `id` = '" . mysql_real_escape_string($aid) . "'
							AND STR_TO_DATE(NOW(),'%Y-%m-%d %H:%i:%s') >= STR_TO_DATE(`in_time`,'%Y-%m-%d %H:%i:%s')
							AND `status` = 12;");
                        } else {
                            $res = executeQuery("UPDATE `customer_attendence`
							SET `out_time` = NOW(), `status` = 12
							WHERE `id` = '" . mysql_real_escape_string($aid) . "'
							AND STR_TO_DATE(NOW(),'%Y-%m-%d %H:%i:%s') >= STR_TO_DATE(`in_time`,'%Y-%m-%d %H:%i:%s')
							AND `status` = 11;");
                        }
                        if ($res)
                            echo '0';
                        else
                            echo '-1';
                    }
                    else {
                        $res = executeQuery("INSERT INTO `customer_attendence` (`id`,`in_time`, `out_time`, `facility_id`,`status`,`customer_pk` )
						VALUES (NULL,NOW() ,NOW()+ INTERVAL 2 HOUR ," . $ftype . ", 11," . $id . ");");
                        if ($res)
                            echo '1';
                        else
                            echo '-2';
                    }
                    break;
                }
            case "employee": {
                    echo 'I am here';
                    if ($aid != "NULL") {
                        $res = executeQuery("SELECT `status` FROM `employee_attendence` WHERE `status` = 12 AND `id` = '" . mysql_real_escape_string($aid) . "';");
                        $status = mysql_result($res, 0);
                        if ($status == 12) {
                            $res = executeQuery("UPDATE `employee_attendence`
							SET `in_time` = NOW(), `out_time` = NOW()+ INTERVAL 2 HOUR, `status` = 11
							WHERE `id` = '" . mysql_real_escape_string($aid) . "'
							AND STR_TO_DATE(NOW(),'%Y-%m-%d %H:%i:%s') >= STR_TO_DATE(`in_time`,'%Y-%m-%d %H:%i:%s')
							AND `status` = 12;");
                        } else {
                            $res = executeQuery("UPDATE `employee_attendence`
							SET `out_time` = NOW(), `status` = 12
							WHERE `id` = '" . mysql_real_escape_string($aid) . "'
							AND STR_TO_DATE(NOW(),'%Y-%m-%d %H:%i:%s') >= STR_TO_DATE(`in_time`,'%Y-%m-%d %H:%i:%s')
							AND `status` = 11;");
                        }
                        if ($res)
                            echo '0';
                        else
                            echo '-1';
                    }
                    else {
                        $res = executeQuery("INSERT INTO `employee_attendence` (`id`,`employee_id`,`in_time`, `out_time`, `facility_id`,`status` )
						VALUES (NULL," . $id . ",NOW() ,NOW()+ INTERVAL 8 HOUR ," . $ftype . ", 11);");
                        if ($res)
                            echo '1';
                        else
                            echo '-2';
                    }
                    break;
                }
        }
    }

    public function CheckValidity($pk_id = false) {
        $flag = false;
        $query = "SELECT
			b.`id`	AS fee_id
			FROM `fee` AS b
			WHERE  b.`customer_pk` = '" . $pk_id . "'
			AND STR_TO_DATE(NOW(),'%Y-%m-%d')>= STR_TO_DATE( b.`valid_from`,'%Y-%m-%d')
			AND STR_TO_DATE(NOW(),'%Y-%m-%d')<= STR_TO_DATE( b.`valid_till`,'%Y-%m-%d')
			ORDER BY b.`id` DESC LIMIT 1;";
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0)
            $flag = true;
        return $flag;
    }

}

?>