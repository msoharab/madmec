<?php

class admincollection {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    public function fetchDistributor() {
        $distype = NULL;
        $jsondistype = NULL;
        $num = 0;
        $query = 'SELECT
					c.`cnumber`,
					b.`email_pk`,
					c.`cnumber_pk`,
					b.`email_ids`,
					a.`user_name`,
                                        a.`business_name`,
					a.`password`,
					a.`id` AS usrid,
					a.`user_type_id`,
					a.`status_id`,
					d.`id` AS bank_id,
					d.`bank_name` AS bank_name,
					d.`ac_no` AS ac_no,
					d.`branch` AS branch,
					d.`branch_code` AS branch_code,
					d.`IFSC` AS IFSC,
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
						SELECT
							ba.`id`,
							ba.`user_pk`,
							GROUP_CONCAT(ba.`bank_name`,"☻☻♥♥☻☻") AS bank_name,
							GROUP_CONCAT(ba.`ac_no`,"☻☻♥♥☻☻") AS ac_no,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch`
								END,"☻☻♥♥☻☻"
							) AS branch,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch_code`
								END,"☻☻♥♥☻☻"
							) AS branch_code,
							GROUP_CONCAT(
								CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
									 THEN "Not provided"
									 ELSE ba.`IFSC`
								END,"☻☻♥♥☻☻"
							) AS IFSC,
							ba.`status_id`
						FROM `bank_accounts` AS ba
						WHERE ba.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (ba.`user_pk`)
						ORDER BY (ba.`user_pk`)
					) AS d ON a.`id` = d.`user_pk`
					WHERE a.`user_type_id` !=  10
					AND a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive"));';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $distype[] = $row;
            }
        }
        //$console_php->log(print_r($distype));
        if (is_array($distype))
            $num = sizeof($distype);
        if ($num) {
            for ($i = 0; $i < $num; $i++) {
                $jsondistype[] = array(
                    "html" => $distype[$i]["user_name"] . '--' . $distype[$i]['business_name'],
                    "distype" => $distype[$i]["user_name"],
                    "id" => $distype[$i]["usrid"]
                );
            }
            $_SESSION["list_of_distributor"] = $distype;
        }
        return $jsondistype;
    }

    public function addIncommingAmt() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $date = date_create(mysql_real_escape_string($this->parameters["date"]));
        $paymentdate = date_format($date, 'Y-m-d H:i:s');
        $query = 'INSERT INTO  `transactions_details` (`id`,
								`user_pk`,
								`mop_id`,
								`date`,
								`amount`,
								`remark`,
								`status`)  VALUES(
								NULL,
								\'' . mysql_real_escape_string($this->parameters["clientid"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["mop"]) . '\',
								\'' . $paymentdate . '\',
								\'' . mysql_real_escape_string($this->parameters["amountpaid"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["rmk"]) . '\',
								4);';
        executeQuery($query);
        $transactions_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
        if (mysql_real_escape_string($this->parameters['amountdue']) > 0) {
            $query1 = 'INSERT INTO  `due` (`id`,
								`transactions_pk`,
								`user_pk`,
								`due_date`,
								`due_amount`,
								`status_id`)  VALUES(
								NULL,
								\'' . mysql_real_escape_string($transactions_pk) . '\',
								\'' . mysql_real_escape_string($this->parameters["clientid"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["duedate"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["amountdue"]) . '\',
								4);';
            executeQuery($query1);
            $due_pk = mysql_insert_id();
//                               echo  print_r($this->parameters["followupdates"]);
            if (is_array($this->parameters["followupdates"]) && sizeof($this->parameters["followupdates"]) > -1) {
                $query12 = 'INSERT INTO  `follow_ups` (`id`,`due_id`,`followup_date`,`status_id` ) VALUES';
                for ($i = 0; $i < sizeof($this->parameters["followupdates"]); $i++) {
                    if ($i == sizeof($this->parameters["followupdates"]) - 1)
                        $query12 .= '(NULL,' . $due_pk . ',"' . mysql_real_escape_string($this->parameters["followupdates"][$i]) . '",4);';
                    else
                        $query12 .= '(NULL,' . $due_pk . ',"' . mysql_real_escape_string($this->parameters["followupdates"][$i]) . '",4),';
                }
                if (executeQuery($query12)) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
        }
        if ($this->parameters["type"] == 1) {
            $addmonth = 6;
            $datetime = date_create($this->parameters["subdate"]);
            $datetime->add(new DateInterval('P6M'));
            $validity_expire = $datetime->format('Y-m-d');
        } else if ($this->parameters["type"] == 2) {
            $addmonth = 12;
            $datetime = date_create($this->parameters["subdate"]);
            $datetime->add(new DateInterval('P12M'));
            $validity_expire = $datetime->format('Y-m-d');
        }
//                                        $validityquery = 'INSERT INTO  `validity` (`id`,
//								`user_pk`,
//								`validity_type_pk`,
//								`payment_date`,
//								`subscribe_date`,
//								`expiry_date`,
//								`status`)  VALUES(
//							NULL,
//							\''.mysql_real_escape_string($this->parameters["clientid"]).'\',
//							\''.mysql_real_escape_string($this->parameters["type"]).'\',
//							\''.$paymentdate.'\',
//                                                       \''.mysql_real_escape_string($this->parameters["subdate"]).'\',
//                                                        \''.mysql_real_escape_string($validity_expire).'\',
//							4
//							);';
//
        $validitycheckquery = 'SELECT DATEDIFF(CURRENT_DATE,expiry_date) AS diff
                                                                FROM validity
                                                                WHERE user_pk="' . mysql_real_escape_string($this->parameters['clientid']) . '" AND STATUS=4';
        $result = executeQuery($validitycheckquery);
        $row = mysql_fetch_assoc($result);
        $diffdays = $row['diff'];
        if ((int) $diffdays > 0) {
            $validityquery = 'UPDATE validity SET expiry_date=DATE(CURRENT_DATE + INTERVAL ' . $addmonth . ' MONTH ) '
                    . 'WHERE user_pk="' . mysql_real_escape_string($this->parameters["clientid"]) . '"'
                    . ' AND STATUS=4';
        } else {
            $validityquery = 'UPDATE validity SET expiry_date=DATE(expiry_date + INTERVAL ' . $addmonth . ' MONTH ) '
                    . 'WHERE user_pk="' . mysql_real_escape_string($this->parameters["clientid"]) . '"'
                    . ' AND STATUS=4';
        }
        if (executeQuery($validityquery)) {
//                                            $lastid=  mysql_insert_id();
//                                            $query='UPDATE `validity` SET `status`=15 WHERE `user_pk`="'.mysql_real_escape_string($this->parameters["clientid"]).'" AND `id` !="'.  mysql_real_escape_string($lastid).'";';
//                                            executeQuery($query);
            executeQuery("COMMIT");
            $flag = true;
            return $flag;
        }
        return $flag;
    }

    public function listColls() {
        $colls = array();
        $incomming = '';
        executeQuery('SET SESSION group_concat_max_len = 1000000;');
        $query = 'SELECT td.date,
                                    td.amount,td.remark ,
                                    mop.mop,
                                    up.owner_name
                                    FROM transactions_details td
                                    LEFT JOIN mode_of_payment mop
                                    ON mop.id=td.mop_id
                                    LEFT JOIN user_profile up
                                    ON up.id=td.user_pk
                                    ORDER BY td.id DESC ';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $colls[] = $row;
            }
            for ($i = 0; $i < sizeof($colls); $i++) {
                $incomming .= '<tr>
                                    <td>' . ($i + 1) . '</td>
                                    <td>' . $colls[$i]["date"] . '</td>
                                    <td>' . $colls[$i]["owner_name"] . '</td>
                                    <td class="text-right">' . $colls[$i]["amount"] . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
                                    <td class="text-right">' . $colls[$i]["remark"] . '</td>
                                    <td class="text-right">' . $colls[$i]["mop"] . '</td>
                            </tr>';
            }
            $jsondata = array(
                "status" => "success",
                "data" => $incomming,
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => '<strong class="text-danger">There are no Collections available !!!!</strong>',
            );
            return $jsondata;
        }
    }

//		public function displayCollsList($para = false) {
//			$this->parameters = $para;
//			$colls = array();
//			$num_posts = 0;
//			if(isset($_SESSION['listofcolls']) && $_SESSION['listofcolls'] != NULL)
//				$colls = $_SESSION['listofcolls'];
//			else
//				$colls = NULL;
//			if($colls != NULL)
//				$num_posts = sizeof($colls);
//			/* Transactions */
//			$incomming = '';
//			$bankdet = '';
//			/* Incomming */
//			if($num_posts > 0){
//				//for($i=$this->parameters["initial"];$i<$this->parameters["final"] && $i < $num_posts && isset($colls[$i]['incid']);$i++){
//				for($i=0;$i < $num_posts;$i++){
//					//$mop = $colls[$i]["incmop"];
//					//if($mop != 'Cash'){
//						//$bankdet = $colls[$i]["incbname"].
//								   //$colls[$i]["incbacno"].
//								   //$colls[$i]["incbranch"].
//								  //$colls[$i]["incifsc"];
//					//}
//					//else
//						//$bankdet = 'Cash';
//
//				}
//				//echo '<table class="table table-striped table-bordered table-hover"><thead><tr><th colspan="7">Incomming Transactions</th></tr><tr><th>#</th><th>Date</th><th>Collector</th><th>Payee</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>'.$incomming.'</table>';
//				echo $incomming;
//			}
//			else{
//				//echo '<strong class="text-danger">There are no Collections available !!!!</strong>';
//				echo '<tr><td colspan="8"><strong class="text-danger">There are no Collections available !!!!</strong></td></tr>';
//			}
//		}
}

?>
