<?php

class collection {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    public function addIncommingAmt() {
        $bank_ac = $this->parameters["ac_id"];
        $out = 0;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        if ($this->parameters["pay_ac"] == 'Add') {
            $query = 'INSERT INTO  `bank_accounts` (`id`,
									`user_pk`,
									`bank_name`,
									`ac_no`,
									`branch`,
									`branch_code`,
									`IFSC`,
									`status_id` )  VALUES(
									NULL,
									\'' . mysql_real_escape_string($this->parameters["retailer"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["account"]["bankname"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["account"]["accno"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["account"]["braname"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["account"]["bracode"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["account"]["IFSC"]) . '\',
									4);';
            if (executeQuery($query)) {
                $bank_ac = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            }
        }
        $query = 'INSERT INTO  `incomming` (`id`,
								`from_pk`,
								`to_pk`,
								`arrival`,
								`mop`,
								`bank_acc_id`,
								`amount`,
								`remark`,
								`status_id` )  VALUES(
								NULL,
								\'' . mysql_real_escape_string($this->parameters["retailer"]) . '\',
								\'' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["date"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["mop"]) . '\',
								\'' . mysql_real_escape_string($bank_ac) . '\',
								\'' . mysql_real_escape_string($this->parameters["amount"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["rmk"]) . '\',
								4);';
        if (executeQuery($query)) {
            $out = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            $invno = sprintf("%010s", mysql_result(executeQuery('SELECT COUNT(`id`) FROM `receipt`;'), 0) + 1);
            $genpdf = new generatePDF();
            $pdffiel = $genpdf->generateIncommingAmontBill($this->parameters);
            executeQuery("COMMIT");
        }
        return $pdffiel;
    }

    public function listColls() {
        $colls = array();
        executeQuery('SET SESSION group_concat_max_len = 1000000;');
        $query = 'SELECT
						i.`incid`,
						i.`user_name`,
						i.`colldate`,
						i.`incamt`,
						i.`incrmk`,
						i.`incmop`,
						i.`incbname`,
						i.`incbacno`,
						i.`incbranch`,
						i.`incifsc`
					FROM (
						SELECT
							inc.`from_pk`,
							(SELECT `user_name` FROM `user_profile` WHERE `id` = inc.`from_pk`) AS user_name ,
							inc.`id` AS incid,
							DATE_FORMAT(inc.`arrival`,"%Y-%c-%d") AS colldate,
							inc.`amount` AS incamt,
							inc.`remark` AS incrmk,
							m.`mop` AS incmop,
							ba.`bank_name` AS incbname,
							ba.`ac_no` AS incbacno,
							CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
								 THEN "Not provided"
								 ELSE ba.`branch`
							END  AS incbranch,
							CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
								 THEN "Not provided"
								 ELSE ba.`branch_code`
							END AS incbrcode,
							CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
								 THEN "Not provided"
								 ELSE ba.`IFSC`
							END AS incifsc
						FROM `incomming` AS inc
						LEFT JOIN `bank_accounts` AS ba ON ba.`id` = inc.`bank_acc_id`
						LEFT JOIN `mode_of_payment` AS m ON m.`id` = inc.`mop`
						WHERE inc.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						ORDER BY (inc.`id`) DESC
					) AS i
					ORDER BY (i.`incid`) DESC;';
        $res = executeQuery($query);
        executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $colls[] = $row;
            }
        }
        $total = sizeof($colls);
        if ($total) {
            $_SESSION["listofcolls"] = $colls;
        } else {
            $_SESSION["listofcolls"] = NULL;
        }
        return $_SESSION["listofcolls"];
    }

    public function displayCollsList($para = false) {
        $this->parameters = $para;
        $colls = array();
        $num_posts = 0;
        if (isset($_SESSION['listofcolls']) && $_SESSION['listofcolls'] != NULL)
            $colls = $_SESSION['listofcolls'];
        else
            $colls = NULL;
        if ($colls != NULL)
            $num_posts = sizeof($colls);
        /* Transactions */
        $incomming = '';
        $bankdet = '';
        /* Incomming */
        if ($num_posts > 0) {
            for ($i = $this->parameters["initial"]; $i < $this->parameters["final"] && $i < $num_posts && isset($colls[$i]['incid']); $i++) {
                $mop = $colls[$i]["incmop"];
                if ($mop != 'Cash') {
                    $bankdet = $colls[$i]["incbname"] .
                            $colls[$i]["incbacno"] .
                            $colls[$i]["incbranch"] .
                            $colls[$i]["incifsc"];
                } else
                    $bankdet = 'Cash';
                $incomming .= '<tr>
										<td>' . ($i + 1) . '</td>
										<td>' . date("j-M-Y", strtotime($colls[$i]["colldate"])) . '</td>
										<td>' . $colls[$i]["user_name"] . '</td>
										<td class="text-right">' . $colls[$i]["incamt"] . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
										<td class="text-right">' . $colls[$i]["incrmk"] . '</td>
										<td class="text-right">' . $colls[$i]["incmop"] . '</td>
										<td class="text-right">' . $bankdet . '</td>
									</tr>';
            }
            echo '<table class="table table-striped table-bordered table-hover" id="displaycollet-datatable"><thead><tr><th colspan="7">Incomming Transactions</th></tr><tr><th>#</th><th>Date</th><th>Name</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>' . $incomming . '</table>';
        }
        else {
            echo '<strong class="text-danger">There are no Collections available !!!!</strong>';
        }
    }

    public function fetchprojectcliens() {
        $htm = '';
        $clientdetails = array();
        $query = 'SELECT id AS id,user_name AS user_name,
                  CASE WHEN email IS NULL THEN "not provided" ELSE email END AS email,
                    CASE WHEN cell_number IS NULL THEN "not provided" ELSE cell_number END AS cell_number FROM user_profile
                     WHERE user_type_id=14';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $clientdetails[] = $row;
            }
        }
        if (is_array($clientdetails))
            $num = sizeof($clientdetails);
        for ($i = 0; $i < $num; $i++) {
            $htm .='<option value="' . $clientdetails[$i]["id"] . '">' . $clientdetails[$i]["user_name"] . '--' . $clientdetails[$i]["email"] . '--' . $clientdetails[$i]["cell_number"] . '';
        }
        return $htm;
    }

    public function fetchclientprojects($clientid) {
        $htm = '';
        $clientdetails = array();
        $query = 'SELECT p.`id` AS id ,
                            p.`name` AS NAME,
                            qt.`net_total` AS grd_total
                            FROM `project` p,
                            `requirements` r,
                            `quotation` qt
                            WHERE r.`id`=p.`requi_id` AND qt.`requi_id`=r.`id`
                            AND r.`from_pk`=' . trim($clientid) . '
                            AND qt.`net_total`  > (SELECT CASE WHEN SUM(amount) IS NULL THEN 0 ELSE SUM(amount) END AS amountpaid
                            FROM `incoming_proj` WHERE `proj_id`=p.`id`);';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $clientdetails[] = $row;
            }
        }
        if (is_array($clientdetails))
            $num = sizeof($clientdetails);
        for ($i = 0; $i < $num; $i++) {
            $htm .='<option value="' . $clientdetails[$i]["id"] . '">' . $clientdetails[$i]["NAME"] . '';
        }
        return $htm;
    }

    public function fetchdueamountofclientprojects($projid) {
        $htm = '';
        $clientdetails = array();
        $query = 'SELECT qt.`net_total`  AS grandtotal,
                        (qt.`net_total`-(SELECT CASE WHEN SUM(amount) IS NULL THEN 0 ELSE SUM(amount) END
                        FROM `incoming_proj` WHERE `proj_id`=' . mysql_real_escape_string($projid) . ')) AS currentdue
                        FROM `requirements` r, quotation qt
                        WHERE qt.`requi_id`=r.`id` AND
                        r.`id`=(SELECT `requi_id` FROM `project` WHERE `id`=' . mysql_real_escape_string($projid) . ');';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            $row = mysql_fetch_assoc($res);
            return $row["grandtotal"] . '-' . $row["currentdue"];
        } else {
            return "0-0";
        }
    }

    public function addProjCollection() {
        $query = 'INSERT INTO `incoming_proj`(`id`,`from_pk`,`to_pk`,`proj_id`,`amount`,`dopaid`,`remark`,`status_id`)'
                . 'VALUES(null,'
                . '"' . mysql_real_escape_string($this->parameters['clientid']) . '",9,"'
                . mysql_real_escape_string($this->parameters['projid']) . '","'
                . mysql_real_escape_string($this->parameters['amount']) . '","'
                . mysql_real_escape_string($this->parameters['dateofpay']) . '","'
                . mysql_real_escape_string($this->parameters['remark']) . '",4'
                . ')';
        executeQuery("SET AUTOCOMMIT=0");
        executeQuery("START TRANSACTION");
        if (executeQuery($query)) {
            $incomproj_id = mysql_insert_id();
            if (mysql_real_escape_string($this->parameters['duedate']) > 0) {
                $query = 'INSERT INTO `due`(`id`,`incoming_proj_id`,`due_date`,`due_amount`,`status_id`) '
                        . 'VALUES(null,'
                        . mysql_real_escape_string($this->parameters['projid']) . ',"'
                        . mysql_real_escape_string($this->parameters['duedate']) . '","'
                        . mysql_real_escape_string($this->parameters['dueamount']) . '",4'
                        . ')';
                executeQuery($query);
                $dueid = mysql_insert_id();
                if (is_array($this->parameters["followupdates"]) && sizeof($this->parameters["followupdates"]) > -1) {
                    $query = 'INSERT INTO  `follow_up` (`id`,`incoming_proj_id`,`due_id`,`followup_dates`,`status_id` ) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["followupdates"]); $i++) {
                        if ($i == sizeof($this->parameters["followupdates"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($this->parameters['projid']) . '\',\'' . $dueid . '\',\'' . mysql_real_escape_string($this->parameters["followupdates"][$i]) . '\',4);';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($this->parameters['projid']) . '\',\'' . $dueid . '\',\'' . mysql_real_escape_string($this->parameters["followupdates"][$i]) . '\',4),';
                    }
                    executeQuery($query);
                }
            }
            else {
                $query = 'UPDATE `due` SET `status_id`=5 WHERE `incoming_proj_id`=' . mysql_real_escape_string($this->parameters['projid']);
                executeQuery($query);
                $query = 'UPDATE `follow_up` SET `status_id`=5 WHERE `incoming_proj_id`=' . mysql_real_escape_string($this->parameters['projid']);
                executeQuery($query);
            }
            executeQuery("COMMIT");

            $genpdf = new generatePDF();
            $pdffiel = $genpdf->generateProjectIncommingAmontBill($this->parameters);
        }
        return $pdffiel;
    }

}

?>