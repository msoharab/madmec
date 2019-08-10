<?php

class payment {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    public function addOutgoingAmt() {
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
									\'' . mysql_real_escape_string($this->parameters["supplier"]) . '\',
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
        echo $this->parameters["availpettycash"];
        if ($this->parameters["availpettycash"] != 0) {
            $query = 'INSERT INTO  `pettycash_withdraw` (`id`,
                                                                        `wcash`,
                                                                        `dow`,
									`user_pk`,
                                                                        `Avaliablebal`,
									`status_id` )  VALUES(
									NULL,
                                                                        \'' . mysql_real_escape_string($this->parameters["amount"]) . '\',
                                                                        CURRENT_TIMESTAMP,
									\'' . mysql_real_escape_string($this->parameters["supplier"]) . '\',
                                                                        \'' . (mysql_real_escape_string($this->parameters["availpettycash"]) - mysql_real_escape_string($this->parameters["amount"])) . '\',
									4);';
            if (executeQuery($query)) {
                $query = 'UPDATE `pettycash` SET `availablecash` = `availablecash` - ' . mysql_real_escape_string($this->parameters["amount"]);

                executeQuery($query);
            }
        }

        $query = 'INSERT INTO  `outgoing` (`id`,
								`from_pk`,
								`to_pk`,
								`departure`,
								`mop`,
								`bank_acc_id`,
								`amount`,
								`remark`,
								`status_id` )  VALUES(
								NULL,
								\'' . mysql_real_escape_string($_SESSION["IOS"]["id"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["supplier"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["date"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["mop"]) . '\',
								\'' . mysql_real_escape_string($bank_ac) . '\',
								\'' . mysql_real_escape_string($this->parameters["amount"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["rmk"]) . '\',
								4);';
        if (executeQuery($query)) {
            $out = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            executeQuery("COMMIT");
        }
        return $out;
    }

    public function listPayms() {
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
							(SELECT `user_name` FROM `user_profile` WHERE `id` = inc.`to_pk`) AS user_name ,
							inc.`id` AS incid,
							DATE_FORMAT(inc.`departure`,"%Y-%c-%d") AS colldate,
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
						FROM `outgoing` AS inc
						LEFT JOIN `bank_accounts` AS ba ON ba.`id` = inc.`bank_acc_id`
						LEFT JOIN `mode_of_payment` AS m ON m.`id` = inc.`mop`
						WHERE inc.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						ORDER BY (inc.`id`) DESC
					) AS i
					ORDER BY (i.`incid`) DESC;';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $colls[] = $row;
            }
        }
        $total = sizeof($colls);
        if ($total) {
            $_SESSION["listofpayms"] = $colls;
        } else {
            $_SESSION["listofpayms"] = NULL;
        }
        return $_SESSION["listofpayms"];
    }

    public function DisplayPaymsList($para = false) {
        $this->parameters = $para;
        $colls = array();
        $num_posts = 0;
        if (isset($_SESSION['listofpayms']) && $_SESSION['listofpayms'] != NULL)
            $colls = $_SESSION['listofpayms'];
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
            echo '<table class="table table-striped table-bordered table-hover" id="outgoingtrans-data"><thead><tr><th colspan="7">Outgoing Transactions</th></tr><tr><th>#</th><th>Date</th><th>Name</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>' . $incomming . '</table>';
        }
        else {
            echo '<strong class="text-danger">There are no Outgoing transactions !!!!</strong>';
        }
    }

}

?>