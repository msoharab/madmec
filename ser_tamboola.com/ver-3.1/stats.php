<?php
class statsModule{
	protected $parameters = array();
	private $order   = array("\r\n", "\n", "\r", "\t");
	private $replace = '';
	function __construct($para	=	false){
		$this->parameters=$para;
	}
	public function accountStats(){
		$header = '';
		$Fee = '';
		$Package = '';
		$Expenses = '';
		$Payments = '';
		$Balance = '';
		$totalc = 0;
		$totald = 0;
		$total1 = 0;
		$atotal = 0;
		$ototal = 0;
		$ptotal = 0;
		$dtotal = 0;
		$num = 0;
		$collection = NULL;
		$collectionp = NULL;
		$deduction = NULL;
		$obj = new enquiry();
		$fac = $obj -> fetchInterestedIn();
		$faclen = sizeof($fac);
		for($i=0;$i<$faclen;$i++)
			$facility_type[] = $fac[$i]["name"];
		$reg_type = array('Group Registration','Registration');
		$default=getStatusId("show");
		$query ='SELECT
			b.`name`,
			a.`customer_pk` AS user_id,
			CONCAT(\'+91 \',b.`cell_number`) AS cell,
			c.`name` AS `offer_name`,
			c.`min_members` AS `members`,
			c.`duration_id` AS duration,
			c.`facility_id` AS facility_type,
			ofd .`duration` AS duration_name,
			fc.`name` AS facility_name,
			c.`cost`,
			STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') AS `payment_date`,
			STR_TO_DATE(a.`valid_from`, \'%Y-%m-%d\') AS `valid_from`,
			STR_TO_DATE(a.`valid_till`, \'%Y-%m-%d\') AS `valid_till`,
			a.`amount` AS oldfee,
			a.`receipt_no`,
			mo_tr.`mt_pk`,
			mo_tr.`mt_uid`,
			mo_tr.`mopid`,
			STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\') AS `mt_pod`,
			mo_tr.`mt_tt`,
			mo_tr.`mt_rpt`,
			mo_tr.`mop`,
			mo_tr.`action_id`,
			mo_tr.`action_no`,
			mo_tr.`ind_amt`,
			mo_tr.total_amt,
			mo_tr.`inv_users`,
			mo_tr.`inv_urls`,
			mo_tr.`due_amount`,
			STR_TO_DATE(mo_tr.`due_date`, \'%Y-%m-%d\') AS `due_date`,
			mo_tr.`due_user`,
			mo_tr.`due_status`
		FROM `fee` AS a
		INNER JOIN `customer` AS b ON a.`customer_pk` = b.`id`
		INNER JOIN `offers` AS c ON a.`offer_id` = c.`id`
		INNER JOIN `offerduration` as ofd ON c.`duration_id` = ofd.`id`
		INNER JOIN `facility` as fc ON c.`facility_id` = fc.`id`

		LEFT JOIN (
			SELECT
				mtr.`id`  			AS mt_pk,
				mtr.`customer_pk`			AS mt_uid,
				GROUP_CONCAT(mtr.`mop_id`) 	AS mopid,
				mtr.`pay_date`  			AS mt_pod,
				mtr.`transaction_type`  	AS mt_tt,
				mtr.`receipt_no`  			AS mt_rpt,
				GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = \'show\' )) AS mop,
				GROUP_CONCAT(mtr.`transaction_id`) AS action_id,
				GROUP_CONCAT(
					CONCAT(mtr.`total_amount` ,\' through \', (SELECT
							CASE WHEN `name` = \'Cash\'
								THEN \'Cash\'
								ELSE
									CASE WHEN mtr.`transaction_number` IS NULL
									THEN  `name`
									ELSE
										CASE WHEN LENGTH(mtr.`transaction_number`) = 0
											THEN CONCAT (`name`, \' and \', `name`, \' No = Not provided\')
											ELSE CONCAT (`name`, \' and \', `name`, \' No = \',mtr.`transaction_number`)
										END
									END
							END
						FROM `mode_of_payment`
						WHERE `id` = mtr.`mop_id`
						AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 ))
					)
				)AS action_no,
				GROUP_CONCAT(`total_amount`) AS ind_amt,
				SUM(`total_amount`) AS total_amt,
				inv.`inv_users`,
				inv.`inv_urls`,
				due.`due_amount`,
				due.`due_date`,
				due.`due_user`,
				due.`due_status`
			FROM `money_transactions` AS mtr
			LEFT JOIN (
				SELECT
					GROUP_CONCAT(`customer_pk`) AS inv_users,
					GROUP_CONCAT(`location`) AS inv_urls,
					`transaction_id`,
					`name`
				FROM `invoice`
				GROUP BY(`transaction_id`)
			) AS inv ON inv.`transaction_id` = mtr.`id`
			LEFT JOIN (
				SELECT
					`id`,
					`money_trans_id`,
					`due_amount`,
					`due_date`,
					`customer_pk` AS due_user,
					`status`  AS due_status
				FROM `money_trans_due`
			) AS due ON due.`money_trans_id` = mtr.`id` AND due.`due_user` = mtr.`customer_pk`
			GROUP BY(mtr.`receipt_no`)
		) AS mo_tr
			ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
			AND a.`id` = mo_tr.`action_id`
			AND a.`customer_pk` = mo_tr.`mt_uid`
		WHERE STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(NOW(),\'%Y-%m-%d\')';
		$res = executeQuery($query);
		$num= mysql_num_rows($res);
		if($num){
			$i=1;
			$collection = array();
			while($row = mysql_fetch_assoc($res)){
				$collection[$i]['No'] = $i;
				$collection[$i]['name'] = $row['name'];
				$collection[$i]['user_id'] = $row['user_id'];
				$collection[$i]['cell'] = $row['cell'];
				$collection[$i]['offer_name'] = $row['offer_name'];
				$collection[$i]['duration'] = $row['duration'];
				$collection[$i]['duration_name'] = $row['duration_name'];
				$collection[$i]['facility_type'] = $row['facility_type'];
				$collection[$i]['facility_name'] = $row['facility_name'];
				$collection[$i]['payment_date'] = date('j-M-Y', strtotime($row['payment_date']));
				$collection[$i]['valid_from'] = date('j-M-Y', strtotime($row['valid_from']));
				$collection[$i]['valid_till'] = date('j-M-Y', strtotime($row['valid_till']));
				$collection[$i]['amount'] = $row['oldfee'];
				if($row['receipt_no'] != NULL || $row['receipt_no'] != '')
					$collection[$i]['receipt_no'] = sprintf("%010s",$row['receipt_no']);
				else
					$collection[$i]['receipt_no'] = NULL;
				$collection[$i]['mt_tt'] = $row['mt_tt'];
				$collection[$i]['action_no'] = $row['action_no'];
				$collection[$i]['total_amt'] = $row['total_amt'];
				if($row['mt_rpt'] != NULL)
					$collection[$i]['mt_rpt'] = sprintf("%010s",$row['mt_rpt']);
				else
					$collection[$i]['mt_rpt'] = $row['mt_rpt'];
				if($row['receipt_no'] != NULL || $row['receipt_no'] != '')
					$collection[$i]['inv_urls'] = $row['inv_urls'];
				else
					$collection[$i]['inv_urls'] = NULL;
				$collection[$i]['due_amount'] = $row['due_amount'];
				if($row['due_date'] != NULL || $row['due_date'] != '')
					$collection[$i]['due_date'] = date('j-M-Y', strtotime($row['due_date']));
				else
					$collection[$i]['due_date'] = $row['due_date'];
				$collection[$i]['today']  = date('j-M-Y', strtotime($row['payment_date']));
				$atotal += $row['cost']; 		/* Actual fee */
				$ototal += $row['oldfee']; 		/* Old fee */
				$ptotal += $row['total_amt'];  	/* Paid fee */
				$dtotal += $row['due_amount'];  /* Due amount */
				$i++;
			}
		}
		$header .= '<h4 class="page-header">'.date("l jS \of F Y ").'Transactions</h4>';
		$Fee .= "<p></p><table class='table table-striped table-bordered table-hover' cellpadding='0' cellspacing='0'  bgcolor='#AFFAFF'>
			<tr>
			<td colspan='6'>
			<b class='head'>Offer Collection.</b>
			</td>
			</tr>";
		if($num){
			for($j=0;$j<sizeof($facility_type);$j++){
				$no = 1;
				$total1 = 0;
				$temp = $Fee;
				$Fee .=  "<tr><td colspan='6' align='center'><h4>".$facility_type[$j]."</h4></td></tr>
					  <tr><th>No</th><th>Name</th><th>Offer</th><th>Receipt</th><th>Today</th><th>Amount</th></tr>";
				for($i=1;$i<=$num && isset($collection[$i]['user_id']);$i++){
					if($collection[$i]['facility_name'] == $facility_type[$j]){
							$Fee .=  "<tr><td>".$no++."</td>
							<td>".$collection[$i]['name']."</td>
							<td>".$collection[$i]['mt_tt']."</td>
							<td><a href='javascript:void(0);' onClick=' var ulr = \"".$collection[$i]['inv_urls']."\"; if(ulr != \"NULL\") window.open(\"".$collection[$i]['inv_urls']."\"); ' >".$collection[$i]['mt_rpt']."</a></td>
							<td>".$collection[$i]['today']."</td>
							<td align='right'>".$collection[$i]['total_amt']."</td>
						</tr>";
						$totalc += $collection[$i]['total_amt'];
						$total1 += $collection[$i]['total_amt'];
					}
				}
				if($total1==0){
					 $Fee = $temp;
					 continue;
				}
				$Fee .=  "<tr>
					  <td colspan='5' align='right'><strong style='font-weight:900;'>".$facility_type[$j]." TOTAL</strong></td>
					  <td align='right'><strong style='color:#f00;'>".$total1."</strong></td>
					  </tr>";
			}
		}
		else{
			$Fee .= "<tr><td  colspan='6'><h3>Today's offer collection is 0 Rupees.</h3></td></tr>";
		}
		$query ='SELECT
			a.`id`,
			a.`name`,
			a.`email`,
			CONCAT(\'+91 \',a.`cell_number`) AS cell,
			STR_TO_DATE(a.`date_of_join`, \'%Y-%m-%d\') AS `date_of_join`,
			a.`receipt_no`,
			mo_tr.`mt_pk`,
			mo_tr.`mt_uid`,
			mo_tr.`mopid`,
			STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\') AS `mt_pod`,
			mo_tr.`mt_tt`,
			mo_tr.`mt_rpt`,
			mo_tr.`mop`,
			mo_tr.`action_id`,
			mo_tr.`action_no`,
			mo_tr.`ind_amt`,
			mo_tr.total_amt,
			mo_tr.`inv_users`,
			mo_tr.`inv_urls`
		FROM `customer` AS a
		LEFT JOIN (
			SELECT
				mtr.`id`  					AS mt_pk,
				mtr.`customer_pk`			AS mt_uid,
				GROUP_CONCAT(mtr.`mop_id`) 	AS mopid,
				mtr.`pay_date`  			AS mt_pod,
				mtr.`transaction_type`  	AS mt_tt,
				mtr.`receipt_no`  			AS mt_rpt,
				GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = \'show\' )) AS mop,
				GROUP_CONCAT(mtr.`transaction_id`) AS action_id,
				GROUP_CONCAT(
					CONCAT(mtr.`total_amount` ,\' through \', (SELECT
							CASE WHEN `name` = \'Cash\'
								THEN \'Cash\'
								ELSE
									CASE WHEN mtr.`transaction_number` IS NULL
									THEN  `name`
									ELSE
										CASE WHEN LENGTH(mtr.`transaction_number`) = 0
											THEN CONCAT (`name`, \' and \', `name`, \' No = Not provided\')
											ELSE CONCAT (`name`, \' and \', `name`, \' No = \',mtr.`transaction_number`)
										END
									END
							END
						FROM `mode_of_payment`
						WHERE `id` = mtr.`mop_id`
						AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 ))
					)
				)AS action_no,
				GROUP_CONCAT(`total_amount`) AS ind_amt,
				SUM(`total_amount`) AS total_amt,
				inv.`inv_users`,
				inv.`inv_urls`
			FROM `money_transactions` AS mtr
			LEFT JOIN (
				SELECT
					GROUP_CONCAT(`customer_pk`) AS inv_users,
					GROUP_CONCAT(`location`) AS inv_urls,
					`transaction_id`,
					`name`
				FROM `invoice`
				GROUP BY(`transaction_id`)
			) AS inv ON inv.`transaction_id` = mtr.`id`
			WHERE mtr.`transaction_type` = \'Group Registration\' OR mtr.`transaction_type` = \'Registration\'
			GROUP BY(mtr.`receipt_no`)
		) AS mo_tr
			ON STR_TO_DATE(a.`date_of_join`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
			AND a.`id` = mo_tr.`mt_uid`
		WHERE STR_TO_DATE(a.`date_of_join`, \'%Y-%m-%d\') = STR_TO_DATE(NOW(),\'%Y-%m-%d\')';
		$res = executeQuery($query);
		$num= mysql_num_rows($res);
		if($num){
			$i=1;
			$collection = array();
			while($row = mysql_fetch_assoc($res)){
				$collection[$i]['No'] = $i;
				$collection[$i]['name'] = $row['name'];
				$collection[$i]['user_id'] = $row['email'];
				$collection[$i]['cell'] = $row['cell'];
				$collection[$i]['payment_date'] = date('j-M-Y', strtotime($row['date_of_join']));
				if($row['receipt_no'] != NULL || $row['receipt_no'] != '')
					$collection[$i]['receipt_no'] = sprintf("%010s",$row['receipt_no']);
				else
					$collection[$i]['receipt_no'] = NULL;
				$collection[$i]['mt_tt'] = $row['mt_tt'];
				$collection[$i]['action_no'] = $row['action_no'];
				$collection[$i]['total_amt'] = $row['total_amt'];
				if($row['mt_rpt'] != NULL)
					$collection[$i]['mt_rpt'] = sprintf("%010s",$row['mt_rpt']);
				else
					$collection[$i]['mt_rpt'] = $row['mt_rpt'];
				if($row['receipt_no'] != NULL || $row['receipt_no'] != '')
					$collection[$i]['inv_urls'] = $row['inv_urls'];
				else
					$collection[$i]['inv_urls'] = NULL;
				$collection[$i]['today']  = date('j-M-Y', strtotime($row['date_of_join']));
				$ptotal += $row['total_amt'];  	/* Paid fee */
				$i++;
			}
		}
		if($num){
			for($j=0;$j<sizeof($reg_type);$j++){
				$no = 1;
				$total1 = 0;

				$Fee .= "<tr><td colspan='6' ><h4>".$reg_type[$j]."</h4></td></tr>
					  <tr><th>No</th><th>Name</th><th>".$reg_type[$j]."</th><th>Duration</th><th>Today</th><th>Amount</th></tr>";
				for($i=1;$i<=$num && isset($collection[$i]['user_id']);$i++){
					if($reg_type[$j] == $collection[$i]['mt_tt']){
							$Fee .= "<tr><td>".$no++."</td>
							<td>".$collection[$i]['name']."</td>
							<td>".$collection[$i]['mt_tt']."</td>
							<td><a href='javascript:void(0);' onClick=' var ulr = \"".$collection[$i]['inv_urls']."\"; if(ulr != \"NULL\") window.open(\"".$collection[$i]['inv_urls']."\"); ' >".$collection[$i]['mt_rpt']."</a></td>
							<td>".$collection[$i]['today']."</td>
							<td align='right'>".$collection[$i]['total_amt']."</td>
						</tr>";
						$totalc += $collection[$i]['total_amt'];
						$total1 += $collection[$i]['total_amt'];
					}
				}

				$Fee .= "<tr>
					  <td colspan='5' align='right'><strong style='font-weight:900;'>".$reg_type[$j]." TOTAL</strong></td>
					  <td align='right'><strong style='color:#f00;'>".$total1."</strong></td>
					  </tr>";
			}
		}
		else{
			$Fee .= "<tr><td  colspan='6'><h3>Today's Group Registration collection is 0 Rs</h3></td></tr>";
		}
		$Fee .= "</table>";
		/* Total package collection */
		$num = 0;
//		$query = 'SELECT
//			b.`name`,
//			a.`customer_pk` AS user_id,
//			CONCAT(\'+91 \',b.`cell_number`) AS cell,
//			pnm.`package_name` AS `pack_name`,
//			c.`number_of_sessions` AS `sessions`,
//			STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') AS `payment_date`,
//			CONCAT(pnm.`package_name`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`) AS tran_type,
//			a.`amount` AS oldfee,
//			a.`receipt_no`,
//			c.`cost` AS actfee,
//			mo_tr.`mt_pk`,
//			mo_tr.`mt_uid`,
//			mo_tr.`mopid`,
//			mo_tr.`mt_pod`,
//			mo_tr.`mt_tt`,
//			mo_tr.`mt_rpt`,
//			mo_tr.`mop`,
//			mo_tr.`action_id`,
//			mo_tr.`action_no`,
//			mo_tr.`ind_amt`,
//			mo_tr.total_amt,
//			mo_tr.`inv_users`,
//			mo_tr.`inv_urls`,
//			mo_tr.`due_amount`,
//			mo_tr.`due_date`,
//			mo_tr.`due_user`,
//			mo_tr.`due_status`
//		FROM `fee_packages` AS a
//		INNER JOIN `customer` AS b ON a.`customer_pk` = b.`id`
//		INNER JOIN `packages` AS c ON a.`package_id` = c.`id`
//		INNER JOIN `package_name` AS pnm ON pnm.`id` = c.`package_type_id`
//		LEFT JOIN (
//			SELECT
//				mtr.`id`  					AS mt_pk,
//				mtr.`customer_pk` 				AS mt_uid,
//				GROUP_CONCAT(mtr.`mop_id`) 	AS mopid,
//				mtr.`pay_date`  			AS mt_pod,
//				mtr.`transaction_type`  	AS mt_tt,
//				mtr.`receipt_no`  			AS mt_rpt,
//				GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = \'show\' )) AS mop,
//				GROUP_CONCAT(mtr.`transaction_id`) AS action_id,
//				GROUP_CONCAT(
//					CONCAT(mtr.`total_amount` ,\' through \', (SELECT
//								CASE WHEN `name` = \'Cash\'
//									THEN \'Cash\'
//									ELSE
//										CASE WHEN mtr.`transaction_number` IS NULL
//										THEN  `name`
//										ELSE
//											CASE WHEN LENGTH(mtr.`transaction_number`) = 0
//												THEN CONCAT (`name`, \' and \', `name`, \' No = Not provided\')
//												ELSE CONCAT (`name`, \' and \', `name`, \' No = \',mtr.`transaction_number`)
//											END
//										END
//								END
//							FROM `mode_of_payment`
//							WHERE `id` = mtr.`mop_id`
//							AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 ))
//					)
//				)AS action_no,
//				GROUP_CONCAT(`total_amount`) AS ind_amt,
//				SUM(`total_amount`) AS total_amt,
//				inv.`inv_users`,
//				inv.`inv_urls`,
//				due.`due_amount`,
//				due.`due_date`,
//				due.`due_user`,
//				due.`due_status`
//			FROM `money_transactions` AS mtr
//			LEFT JOIN (
//				SELECT pack.*,pcnm.`package_name`
//				FROM `packages` AS pack
//				LEFT JOIN `package_name` AS pcnm ON pcnm.`id` = pack.`package_type_id`
//			)AS pack ON  mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_name`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
//			LEFT JOIN (
//				SELECT
//					GROUP_CONCAT(`customer_pk`) AS inv_users,
//					GROUP_CONCAT(`location`) AS inv_urls,
//					`transaction_id`,
//					`name`
//				FROM `invoice`
//				GROUP BY(`transaction_id`)
//			) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE CONCAT(\'%\',pack.`package_name`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
//			LEFT JOIN (
//				SELECT
//					`id`,
//					`money_trans_id`,
//					`due_amount`,
//					`due_date`,
//					`customer_pk` AS due_user,
//					`status`  AS due_status
//				FROM `money_trans_due`
//			) AS due ON due.`money_trans_id` = mtr.`id` AND due.`due_user` = mtr.`customer_pk`
//			WHERE mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_name`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
//			GROUP BY(mtr.`receipt_no`)
//			ORDER BY(mtr.`id`)
//		) AS mo_tr
//			ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
//			AND a.`id` = mo_tr.`action_id`
//			AND a.`id` = mo_tr.`mt_uid`
//		WHERE mo_tr.`mt_tt` = CONCAT(pnm.`package_name`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`)
//		AND STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(NOW(), \'%Y-%m-%d\');';
                $query='SELECT feepack.* ,
                        ct.name,
                        ct.email AS custemail,
                        packname.package_name,
                        inv.name AS invoicename,
                        inv.location AS invoiceloc
                        FROM fee_packages feepack
                        LEFT JOIN customer ct
                        ON ct.id=feepack.customer_pk
                        LEFT JOIN packages pack
                        ON pack.id=feepack.package_id
                        LEFT JOIN package_name packname
                        ON packname.id=pack.package_type_id
                        LEFT JOIN money_transactions mtrans
                        ON mtrans.receipt_no=feepack.receipt_no
                        LEFT JOIN invoice inv
                        ON inv.transaction_id=mtrans.id
                        WHERE feepack.payment_date >=CONCAT(CURRENT_DATE," 00:00:00") AND feepack.payment_date <=CONCAT(CURRENT_DATE," 23:59:59")
                        AND feepack.status=4
                        ';
		$res = executeQuery($query);
		$num = mysql_num_rows($res);
		if($num){
			$collectionp = array();
			$i=1;
			while($row = mysql_fetch_assoc($res)){
                            $collectionp[]=$row;
//				$collectionp[$i]['No'] = $i; 															/* A */
//				$collectionp[$i]['name'] = $row['name'];
//				$collectionp[$i]['user_id'] = $row['user_id'];										/* C */
//				$collectionp[$i]['cell'] = $row['cell'];												/* D */
//				$collectionp[$i]['pack_name'] = $row['pack_name'];									/* E */
//				$collectionp[$i]['sessions'] = $row['sessions'];										/* F */
//				$collectionp[$i]['payment_date'] = date('j-M-Y', strtotime($row['payment_date']));	/* G */
//				// $collectionp[$i]['oldfee'] = $row['oldfee'];										/* H */
//				// if($row['receipt_no'] != NULL || $row['receipt_no'] != '0' || $row['receipt_no'] != '')
//					// $collectionp[$i]['receipt_no'] = sprintf("%010s",$row['receipt_no']); 			/* I */
//				// else
//					// $collectionp[$i]['receipt_no'] = NULL; 										/* I */
//				$collectionp[$i]['mt_tt'] = $row['mt_tt'];											/* J */
//				$collectionp[$i]['action_no'] = $row['action_no']; 									/* K */
//				$collectionp[$i]['total_amt'] = $row['total_amt']; 									/* L */
//				if($row['mt_rpt'] != NULL)
//					$collectionp[$i]['mt_rpt'] = sprintf("%010s",$row['mt_rpt']);	 					/* M */
//				else
//					$collectionp[$i]['mt_rpt'] = $row['mt_rpt'];	 									/* M */
//				if($row['receipt_no'] != NULL || $row['receipt_no'] != '')
//					$collectionp[$i]['inv_urls'] = $row['inv_urls'];									/* M */
//				else
//					$collectionp[$i]['inv_urls'] = NULL;								/* M */
//				$collectionp[$i]['due_amount'] = $row['due_amount']; 									/* N */
//				if($row['due_date'] != NULL || $row['due_date'] != '')
//					$collectionp[$i]['due_date'] = date('j-M-Y', strtotime($row['due_date']));  		/* O */
//				else
//					$collectionp[$i]['due_date'] = $row['due_date'];  								/* O */
//				$collectionp[$i]['today']  = date('j-M-Y', strtotime($row['payment_date']));
//				$atotal += $row['actfee']; 		/* Actual fee */
//				$ototal += $row['oldfee']; 		/* Old fee */
//				$ptotal += $row['total_amt'];  	/* Paid fee */
//				$dtotal += $row['due_amount'];  /* Due amount */
//				$i++;
			}
		}
		$Package .= "<p></p><table class='table table-striped table-bordered table-hover' cellpadding='0' cellspacing='0'  bgcolor='#AFFAFF'>
			<tr>
				<td colspan='8' >
					<b class='head'>Package Collection.</b>
				</td>
			</tr>";
		if($num){
			$no = 1;
			$total1 = 0;
			$temp = $Package;
			$Package .= "<tr><th>No</th><th>Name</th><th>Package type</th><th>Email Id</th><th>Receipt no</th><th>Today</th><th>Amount</th></tr>";
			for($i=0;$i<sizeof($collectionp);$i++){
				$Package .= "<tr><td>".$no++."</td>
					<td>".$collectionp[$i]['name']."</td>
					<td>".$collectionp[$i]['invoicename']."</td>
					<td>".$collectionp[$i]['custemail']."</td>
					<td><a href='javascript:void(0);' onClick=' var ulr = \"".$collectionp[$i]['invoiceloc']."\"; if(ulr != \"NULL\") window.open(\"".$collectionp[$i]['invoiceloc']."\"); ' >".$collectionp[$i]['receipt_no']."</a></td>
					<td>".date("Y-M-d",strtotime($collectionp[$i]['payment_date']))."</td>
					<td align='right'>".$collectionp[$i]['amount']."</td>
				</tr>";
				$totalc += $collectionp[$i]['amount'];
				$total1 += $collectionp[$i]['amount'];
			}
			$Package .= "<tr>
					  <td colspan='6' align='right'><strong style='font-weight:900;'>Packages TOTAL</strong></td>
					  <td align='right'><strong style='color:#f00;'>".$total1."</strong></td>
				  </tr>";
		}
		else{
			$Package .= "<tr><td  colspan='8'><h3>Today's package collection is 0 Rs</h3></td></tr>";
		}
		$Package .= "</table>";
		$query = "SELECT
			a.`id`  AS ID,
			a.`name`  AS NAME,
			a.`amount`  AS AMT,
			a.`pay_date`  AS DOP,
			a.`description`  AS DES,
			a.`receipt_no` AS RPT
			FROM `expenses` AS a
			WHERE STR_TO_DATE(NOW(),'%Y-%m-%d') = STR_TO_DATE(a.`pay_date` ,'%Y-%m-%d');";
		$res = executeQuery($query);
		$num= mysql_num_rows($res);
		if($num){
			$deduction = array();
			$i = 1;
			while( $row = mysql_fetch_assoc($res) ){
				$deduction[$i]['ID'] = $row['ID'];
				$deduction[$i]['NAME'] = $row['NAME'];
				$deduction[$i]['AMT'] = $row['AMT'];
				$deduction[$i]['DOP'] = date('j-M-Y', strtotime($row['DOP']));
				$deduction[$i]['DES'] = $row['DES'];
				$deduction[$i]['RPT'] = $row['RPT'];
				$deduction[$i]['TYPE'] ='Expenses';
				$i++;
			}
		}
		/* Total deduction */
		$Expenses .= "<p></p><table class='table table-striped table-bordered table-hover' cellpadding='0' cellspacing='0'  bgcolor='#AEEAF0'>
			<tr>
			<td colspan='8' >
			<b class='head'>Expenses Deduction.</b>
			</td>
			</tr>";
		if($num){
			$no = 1;
			$total1 = 0;
			for($i=1;$i<=$num && isset($deduction[$i]['ID']);$i++){
				$Expenses .=  "<tr><td>".$no++."</td>
					<td>".$deduction[$i]['NAME']."</td>
					<td>".$deduction[$i]['DOP']."</td>
					<td>".$deduction[$i]['RPT']."</td>
					<td align='right'>".$deduction[$i]['AMT']."</td>
					</tr>";
				$totald += $deduction[$i]['AMT'];
				$total1 += $deduction[$i]['AMT'];
			}
			$Expenses .=  "<tr>
				  <td colspan='4' align='right'><strong style='font-weight:900;'>Expenses TOTAL</strong></td>
				  <td align='right'><strong style='color:#f00;'>".$total1."</strong></td>
				  </tr>";
		}
		else{
			$Expenses .=  "<tr><td  colspan='8'><h3>Today's expenses is 0 Rs</h3></td></tr>";
		}
		$Expenses .=  "</table>";
		/* Total deduction payments */
		$query = "SELECT
			a.`id`  AS ID,
			a.`name`  AS NAME,
			a.`amount`  AS AMT,
			a.`pay_date`  AS DOP,
			a.`description`  AS DES,
			a.`receipt_no` AS RPT
			FROM `payments` AS a
			WHERE STR_TO_DATE(NOW(),'%Y-%m-%d') = STR_TO_DATE(a.`pay_date` ,'%Y-%m-%d');";
		$res = executeQuery($query);
		$num= mysql_num_rows($res);
		if($num){
			$deduction = array();
			$i = 1;
			while( $row = mysql_fetch_assoc($res) ){
				$deduction[$i]['ID'] = $row['ID'];
				$deduction[$i]['NAME'] = $row['NAME'];
				$deduction[$i]['AMT'] = $row['AMT'];
				$deduction[$i]['DOP'] = date('j-M-Y', strtotime($row['DOP']));
				$deduction[$i]['DES'] = $row['DES'];
				$deduction[$i]['RPT'] = $row['RPT'];
				$deduction[$i]['TYPE'] ='Payments';
				$i++;
			}
		}
		/* Total deduction payments*/
		$Payments .=  "<p></p><table class='table table-striped table-bordered table-hover' cellpadding='0' cellspacing='0'  bgcolor='#AEEAF0'>
			<tr>
			<td colspan='8' >
			<b class='head'>Payments Deduction.</b>
			</td>
			</tr>";
		if($num){
				$no = 1;
				$total1 = 0;
				for($i=1;$i<=$num && isset($deduction[$i]['ID']);$i++){
					$Payments .=  "<tr><td>".$no++."</td>
						<td>".$deduction[$i]['NAME']."</td>
						<td>".$deduction[$i]['DOP']."</td>
						<td>".$deduction[$i]['RPT']."</td>
						<td align='right'>".$deduction[$i]['AMT']."</td>
						</tr>";
					$totald += $deduction[$i]['AMT'];
					$total1 += $deduction[$i]['AMT'];
				}
				$Payments .=  "<tr>
					  <td colspan='4' align='right'><strong style='font-weight:900;'>Payments TOTAL</strong></td>
					  <td align='right'><strong style='color:#f00;'>".$total1."</strong></td>
					  </tr>";
		}
		else{
			$Payments .=  "<tr><td  colspan='8'><h3>Today's payments deduction is 0 Rs</h3></td></tr>";
		}
		$Payments .= "</table>";
		/* Balance */
		$Balance .=  "<p></p><table class='table table-striped table-bordered table-hover' cellpadding='0' cellspacing='0'  bgcolor='#AEEAF0'>
			<tr>
				<td colspan='8' ><b class='head'>Today's Balance.</b> </td>
			</tr>
			<tr>
				<td colspan='7' align='right'><b class='head'>Today's collection</b> </td>
				<td align='right'><strong style='color:#f00;'>".$totalc."</strong></td>
			</tr>
			<tr>
				<td colspan='7' align='right'><b class='head'>Today's deduction</b> </td>
				<td align='right'><strong style='color:#f00;'>".$totald."</strong></td>
			</tr>
			<tr>
				<td colspan='7' align='right'><b class='head'>Remaining balance</b> </td>
				<td align='right'><strong style='color:#f00;'>".($totalc - $totald)."</strong></td>
			</tr>
			</table>";
		$feecl =  $header.'<ul class="nav nav-tabs">
				<li class="active"><a href="#Feee" data-toggle="tab">Offer</a></li>
				<li><a href="#Package" data-toggle="tab">Package</a></li>
				<li><a href="#Expenses" data-toggle="tab">Expenses</a></li>
				<li><a href="#Payments" data-toggle="tab">Payments</a></li>
				<li><a href="#Balance" data-toggle="tab">Balance</a></li>
			    </ul>

			    <!-- Tab panes -->
			    <div class="tab-content">
				<div class="tab-pane fade in active" id="Feee">
				    <p><div class="table-responsive">'.$Fee.'</div></p>
				</div>
				<div class="tab-pane fade" id="Package">
				    <p><div class="table-responsive">'.$Package.'</div></p>
				</div>
				<div class="tab-pane fade" id="Expenses">
				    <p><div class="table-responsive">'.$Expenses.'</div></p>
				</div>
				<div class="tab-pane fade" id="Payments">
				    <p><div class="table-responsive">'.$Payments.'</div></p>
				</div>
				<div class="tab-pane fade" id="Balance">
				    <p><div class="table-responsive">'.$Balance.'</div></p>
				</div>
			    </div>';
		return str_replace($this->order,$this->replace, $feecl);
	}
	public function listRegistrationsStats(){
		$reg = '';
		$totalc = 0;
		$ptotal = 0;
		$reg_type = array('Group Registration','Registration');
		$query ='SELECT
					a.`id`,
					a.`name`,
					a.`email` AS email_id,
					CONCAT(\'+91 \',a.`cell_number`) AS cell,
					STR_TO_DATE(a.`date_of_join`, \'%Y-%m-%d\') AS `date_of_join`,
					a.`receipt_no`,
					mo_tr.`mt_pk`,
					mo_tr.`mt_uid`,
					mo_tr.`mopid`,
					STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\') AS `mt_pod`,
					mo_tr.`mt_tt`,
					mo_tr.`mt_rpt`,
					mo_tr.`mop`,
					mo_tr.`action_id`,
					mo_tr.`action_no`,
					mo_tr.`ind_amt`,
					mo_tr.total_amt,
					mo_tr.`inv_users`,
					mo_tr.`inv_urls`
				FROM `customer` AS a
				LEFT JOIN (
					SELECT
						mtr.`id`  					AS mt_pk,
						mtr.`customer_pk` 				AS mt_uid,
						GROUP_CONCAT(mtr.`mop_id`) 	AS mopid,
						mtr.`pay_date`  			AS mt_pod,
						mtr.`transaction_type`  	AS mt_tt,
						mtr.`receipt_no`  			AS mt_rpt,
						GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = \'show\' )) AS mop,
						GROUP_CONCAT(mtr.`transaction_id`) AS action_id,
						GROUP_CONCAT(
							CONCAT(mtr.`total_amount` ,\' through \', (SELECT
									CASE WHEN `name` = \'Cash\'
										THEN \'Cash\'
										ELSE
											CASE WHEN mtr.`transaction_number` IS NULL
											THEN  `name`
											ELSE
												CASE WHEN LENGTH(mtr.`transaction_number`) = 0
													THEN CONCAT (`name`, \' and \', `name`, \' No = Not provided\')
													ELSE CONCAT (`name`, \' and \', `name`, \' No = \',mtr.`transaction_number`)
												END
											END
									END
								FROM `mode_of_payment`
								WHERE `id` = mtr.`mop_id`
								AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 ))
							)
						)AS action_no,
						GROUP_CONCAT(`total_amount`) AS ind_amt,
						SUM(`total_amount`) AS total_amt,
						inv.`inv_users`,
						inv.`inv_urls`
					FROM `money_transactions` AS mtr
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(`customer_pk`) AS inv_users,
							GROUP_CONCAT(`location`) AS inv_urls,
							`transaction_id`,
							`name`
						FROM `invoice`
						GROUP BY(`transaction_id`)
					) AS inv ON inv.`transaction_id` = mtr.`id`
					WHERE mtr.`transaction_type` = \'Group Registration\' OR mtr.`transaction_type` = \'Registration\'
					GROUP BY(mtr.`receipt_no`)
				) AS mo_tr
					ON STR_TO_DATE(a.`date_of_join`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
					AND a.`id` = mo_tr.`mt_uid`
				WHERE STR_TO_DATE(a.`date_of_join`, \'%Y-%m-%d\') = STR_TO_DATE(NOW(),\'%Y-%m-%d\')';
				$res = executeQuery($query);
				$num= mysql_num_rows($res);
				if($num){
					$i=1;
					$collection = array();
					while($row = mysql_fetch_assoc($res)){
						$collection[$i]['No'] = $i;
						$collection[$i]['name'] = $row['name'];
						$collection[$i]['user_id'] = $row['email_id'];
						$collection[$i]['cell'] = $row['cell'];
						$collection[$i]['payment_date'] = date('j-M-Y', strtotime($row['date_of_join']));
						if($row['receipt_no'] != NULL || $row['receipt_no'] != '')
							$collection[$i]['receipt_no'] = sprintf("%010s",$row['receipt_no']);
						else
							$collection[$i]['receipt_no'] = NULL;
						$collection[$i]['mt_tt'] = $row['mt_tt'];
						$collection[$i]['action_no'] = $row['action_no'];
						$collection[$i]['total_amt'] = $row['total_amt'];
						if($row['mt_rpt'] != NULL)
							$collection[$i]['mt_rpt'] = sprintf("%010s",$row['mt_rpt']);
						else
							$collection[$i]['mt_rpt'] = $row['mt_rpt'];
						if($row['receipt_no'] != NULL || $row['receipt_no'] != '')
							$collection[$i]['inv_urls'] = $row['inv_urls'];
						else
							$collection[$i]['inv_urls'] = NULL;
						$collection[$i]['today']  = date('j-M-Y', strtotime($row['date_of_join']));
						$ptotal += $row['total_amt'];  	/* Paid fee */
						$i++;
					}
				}
				$reg .='<h4 class="page-header">'.date('l jS \of F Y ').'Customer registrations</h4>';
				$reg .= "<table cellpadding='0' cellspacing='0'  bgcolor='#AFFAFF' class='table table-striped table-bordered table-hover'>
					<tr>
					<td colspan='8' >
					<b class='head'>Total Registrations.</b>
					</td>
					</tr>";
				if($num){
					for($j=0;$j<sizeof($reg_type);$j++){
						$no = 1;
						$total1 = 0;
						$reg .= "<tr><td colspan='7' ><h2>".$reg_type[$j]."</h2></td></tr>
							  <tr><th>No</th><th>Name</th><th>Email Id</th><th>".$reg_type[$j]."</th><th>Receipt</th><th>Today</th><th>Amount</th></tr>";
						for($i=1;$i<=$num && isset($collection[$i]['user_id']);$i++){
							if($reg_type[$j] == $collection[$i]['mt_tt']){
									$reg .= "<tr><td>".$no++."</td>
									<td>".$collection[$i]['name']."</td>
									<td>".$collection[$i]['user_id']."</td>
									<td>".$collection[$i]['mt_tt']."</td>
									<td><a href='javascript:void(0);' onClick=' var ulr = \"".$collection[$i]['inv_urls']."\"; if(ulr != \"NULL\") window.open(\"".$collection[$i]['inv_urls']."\"); ' >".$collection[$i]['mt_rpt']."</a></td>
									<td>".$collection[$i]['today']."</td>
									<td align='right'>".$collection[$i]['total_amt']."</td>
								</tr>";
								$totalc += $collection[$i]['total_amt'];
								$total1 += $collection[$i]['total_amt'];
							}
						}
						$reg .= "<tr>
							  <td colspan='6' align='right'><strong style='font-weight:900;'>".$reg_type[$j]." TOTAL</strong></td>
							  <td align='right'><strong style='color:#f00;'>".$total1."</strong></td>
							  </tr>";
					}
				}
				else{
					$reg .= "<tr><td  colspan='8'><h3>Today's collection is 0 Rs</h3></td></tr>";
				}
				$reg .= "</table>";
			/* Balance */
			$reg .= "<p></p><table class='table table-bordered' cellpadding='0' cellspacing='0' >
				<tr>
					<td colspan='5' align='right'><b class='head'>Today's registration collection</b> </td>
					<td align='right' witdh='20%'><strong style='color:#f00;'>".$totalc."</strong></td>
				</tr>
				</table>";
			return $reg;
	}
	public function customersStats(){
		// --------------List cutomer --------------
                $no = 1;
		$header = '';
		$att = '';
		$exp = '';
		$query = 'SELECT
			DISTINCT a.`id` ,
			d.`id` AS pk_id,
			d.`name` ,
			d.`cell_number` ,
			d.`email` AS email_id ,
			b.`valid_till` AS exp_date,
			c.`name` AS offer,
			fc.`name` AS facility_type,
			a.`in_time` AS today,
			CASE WHEN d.`photo_id` IS NULL
				 THEN \''.USER_ANON_IMAGE.'\'
				 ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph3.`ver3`)
			END AS photo
			FROM `customer_attendence` AS a
			LEFT  JOIN `group_members` AS gm ON a.`customer_pk` = gm.`customer_pk`
			LEFT  JOIN `groups` AS gr ON gr.`id` = gm.`group_id`
			INNER  JOIN `fee` AS b ON a.`customer_pk` = b.`customer_pk` OR gr.`owner` = b.`customer_pk`
			INNER  JOIN `offers` AS c ON b.`offer_id` = c.`id`
			OR c.`facility_id` IN (SELECT `id` FROM `facility` WHERE `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 ))
			INNER  JOIN `facility` AS fc ON fc.`id` = a.`facility_id`
			INNER JOIN `customer` AS d ON d.`id` = a.`customer_pk` OR gr.`owner` = d.`id`
			LEFT JOIN `photo` AS ph3 ON d.`photo_id` = ph3.`id`
			WHERE STR_TO_DATE( \''.date('Y-m-d').'\', \'%Y-%m-%d\' ) = STR_TO_DATE(a.`in_time` , \'%Y-%m-%d\')
			AND b.`offer_id` = c.`id`
			GROUP BY a.`id`
			ORDER BY (a.`facility_id`)';
		$res = executeQuery($query);
		$i= mysql_num_rows($res);
		$header .='<h4 class="page-header">'.date('l jS \of F Y ').', Customers Attendance & Expired Customers</h4>';
		$att .= "<table cellpadding='0' cellspacing='0'  bgcolor='#AFFAFF' class='table table-bordered'>
			<tr><td colspan='8'><b class='head'>Customers Who Visited ".ucwords(GYMNAME)." Today.</b> </td></tr>
			<tr>
			<th>#</th>
			<th>Customer Name</th>
			<th>Email Id</th>
			<th>Cell Number</th>
			<th>Offer</th>
			<th>Facility</th>
			<th>Expiry</th>
			<th>When</th>
			</tr>";
		if(mysql_num_rows($res)){
			$no = 1;
			while($row = mysql_fetch_assoc($res)){
				$att .= "<tr><td>".$no++."</td>
				<!--<td><img src=\"".$row['photo']."\" width=\"35\" alt=\"User Avatar\" class=\"img-circle\" /></td>-->
                                <td>".$row['name']."</td>
				<td>".$row['email_id']."</td>
				<td>".$row['cell_number']."</td>
				<td>".$row['offer']."</td>
				<td>".$row['facility_type']."</td>
				<td>".date('j-M-Y', strtotime($row['exp_date']))."</td>
				<td>".date('j-M-Y', strtotime($row['today']))."</td></tr>";
			}
		}
		else{
			$att .=  '<tr><td colspan="8"><b class="head"><h3>No Customers Visited The Club !!!</h3>.</b> </td></tr>';
		}
		$att .=  '</table>';
		$_SESSION['expiry_list'] = NULL;
		$obj = new enquiry();
		$fac = $obj -> fetchInterestedIn();
		$faclen = sizeof($fac);
		for($i=0;$i<$faclen;$i++)
			$facility_type[] = $fac[$i]["name"];
		$query = 'SELECT
			par.`upk` AS id,
			par.`uname` AS name,
			par.`ucell` AS cell_number,
			par.`uemail` AS email_id,
			par.`use_me`,
			par.`photo`,
			par.`counter`,
			par.`gr_fee_id`,
			par.`gr_offer_id`,
			par.`gr_no_of_days`,
			par.`gr_payment_date`,
			par.`vfrom`,
			par.`vto` AS exp_date,
			par.`since_when`,
			par.`offerss` AS offer,
			par.`gr_fac_typ`,
			par.`facility_id` AS facility_type,
			par.`status`
		FROM(
			SELECT
				a.`upk`,
				a.`uname`,
				a.`ucell`,
				a.`uemail`,
				a.`use_me`,
				a.`photo`,
				b.`counter`,
				b.`gr_fee_id`,
				b.`gr_offer_id`,
				b.`gr_no_of_days`,
				b.`gr_payment_date`,
				b.`vfrom`,
				b.`vto`,
				b.`since_when`,
				b.`offerss`,
				b.`gr_fac_typ`,
				b.`facility_id`,
				b.`status`
			FROM(
				SELECT
				temp.`id` AS upk,
				temp.`name` AS uname,
				temp.`cell_number` AS ucell,
				temp.`email` AS uemail,
				CASE
					WHEN (SELECT TRUE FROM `group_members` WHERE `customer_pk` = temp.`id`)
					THEN (SELECT `owner` FROM `groups` WHERE `id` = (SELECT `group_id` FROM `group_members` WHERE `customer_pk` = temp.`id`))
					ELSE temp.`id`
				END AS use_me,
				CASE
					WHEN (SELECT TRUE FROM `group_members` WHERE `customer_pk` = temp.`id`)
					THEN (SELECT `customer_pk` FROM `groups` WHERE `id` = (SELECT `group_id` FROM `group_members` WHERE `customer_pk` = temp.`id`))
					ELSE temp.`id`
				END AS usepk_me,
				CASE WHEN temp.`photo_id` IS NULL
					 THEN \''.USER_ANON_IMAGE.'\'
					 ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph3.`ver3`)
				END AS photo
				FROM `customer` AS temp
				LEFT JOIN `photo` AS ph3 ON temp.`photo_id` = ph3.`id`
				WHERE  (temp.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Registered\' AND `status`=1 )  OR temp.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Joined\' AND `status`=1 ))
			) AS a
			INNER JOIN(
				SELECT
					COUNT(fe.`id`) AS counter,
					fe.`customer_pk` AS fee_user_id,
					GROUP_CONCAT(fe.`id` ORDER BY fe.`id`) AS gr_fee_id,
					GROUP_CONCAT(fe.`offer_id` ORDER BY fe.`id`) AS gr_offer_id,
					GROUP_CONCAT(fe.`no_of_days` ORDER BY fe.`id`)AS gr_no_of_days,
					GROUP_CONCAT(fe.`payment_date` ORDER BY fe.`id`)AS gr_payment_date,
					GROUP_CONCAT(fe.`valid_from`  ORDER BY fe.`id`) AS vfrom,
					GROUP_CONCAT(fe.`valid_till` ORDER BY fe.`id`) AS vto,
					GROUP_CONCAT(DATEDIFF(NOW(),fe.`valid_till`) ORDER BY fe.`id`) AS since_when,
					GROUP_CONCAT(fe.`customer_pk`),
					GROUP_CONCAT(CONCAT(ofs.`facility_id`,\' - \',ofs.`name`,\' - \',ofs.`duration_id`,\' - \',ofs.`cost`)) AS offerss,
					GROUP_CONCAT(ofs.`facility_id`) AS gr_fac_typ,
					ofs.`facility_id`,
					GROUP_CONCAT(
					(CASE WHEN (STR_TO_DATE(fe.`valid_till`,\'%Y-%m-%d\') < STR_TO_DATE(NOW(),\'%Y-%m-%d\'))
						THEN \'Expired\'
						ELSE \'Valid\'
					END)) AS status
				FROM `fee` AS fe
				INNER JOIN `offers` AS ofs ON ofs.`id` = fe.`offer_id`
				WHERE STR_TO_DATE(fe.`valid_till`,\'%Y-%m-%d\') < STR_TO_DATE(NOW(),\'%Y-%m-%d\')
				AND fe.`customer_pk` NOT IN (SELECT `customer_pk` FROM `fee`
							WHERE STR_TO_DATE(`valid_till`,\'%Y-%m-%d\') >= STR_TO_DATE(NOW(),\'%Y-%m-%d\')
							AND STR_TO_DATE(`valid_from`,\'%Y-%m-%d\') <= STR_TO_DATE(NOW(),\'%Y-%m-%d\'))
				GROUP BY fe.`customer_pk`
			) AS b ON (b.`fee_user_id` = a.`use_me`)
		)AS par
		ORDER BY (par.`facility_id`);';
		$res = executeQuery($query);
		$i= mysql_num_rows($res);
		$button = '';
		if($i > 0){
			$button = '<button class="btn btn-danger btn-block" id="btn_send_exp" style="display:none;">Send</button><br /><label id="msg_loader"></label>';
		}
		$exp .= "<table cellpadding='0' cellspacing='0'  bgcolor='#AFFAFF' class='table table-bordered'>
			<tr><td colspan='6'><b class='head'>Expiry Intimation.</b></td><td>".$button."</td></tr>
			<tr>
			<th>#</th>
			<th>Customer Name</th>
			<th>Email Id</th>
			<th>Cell Number</th>
			<th>Offer</th>
			<th>Since When</th>
			<th>Expiry</th>
			</tr>";
		if(mysql_num_rows($res)){
			$i = 1;
			$direction = ($i % 2 == 0) ? "" : "";
			$_SESSION['expiry_list'] = array();
			while($row = mysql_fetch_assoc($res)){
				$_SESSION['expiry_list'][$i]['id'] = $row['id'];
				$_SESSION['expiry_list'][$i]['email'] = $row['email_id'];
				$_SESSION['expiry_list'][$i]['cell'] = $row['cell_number'];
				$_SESSION['expiry_list'][$i]['name'] = $row['name'];
				$_SESSION['expiry_list'][$i]['photo'] = ($row['photo'] == NULL || empty($row['photo'])) ? USER_ANON_IMAGE : $row['photo'];
				if($row['counter'] > 1){
					$offer = explode(",",$row['offer'])[sizeof(explode(",",$row['offer']))-1];
					$since_when = explode(",",$row['since_when'])[sizeof(explode(",",$row['since_when']))-1];
					$status = explode(",",$row['status'])[sizeof(explode(",",$row['status']))-1];
					$exp_date = date('j-M-Y',strtotime(explode(",",$row['exp_date'])[sizeof(explode(",",$row['exp_date']))-1]));
				}
				else{
					$expiry_list[$i] = $row['email_id'];
					$offer = $row['offer'];
					$since_when = $row['since_when'];
					$status = $row['status'];
					$exp_date = date('j-M-Y',strtotime($row['exp_date']));
				}
				// <td><img src=\"".$row['photo']."\" width=\"35\" alt=\"User Avatar\" class=\"img-circle\" /></td>
				$exp .= "<tr><td>".$no++."</td>
				<td>".$row['name']."</td>
				<td>".$row['email_id']."</td>
				<td>".$row['cell_number']."</td>
				<td>".$offer."</td>
				<td>".$status."</td>
				<td>".$exp_date."</td></tr>";
			}
		}
		else{
			$expiry_list = NULL;
			$exp .=  '<tr><td colspan="7"><b class="head"><h3>No Customers With Expired Validity !!!</h3>.</b> </td></tr>';
		}
		$exp .=  '</table>';

		$html = $header.'<ul class="nav nav-tabs">
			<li class="active"><a href="#Attend" data-toggle="tab">Attend</a></li>
			<li><a href="#Expired" data-toggle="tab">Expired</a></li>
		    </ul>

		    <!-- Tab panes -->
		    <div class="tab-content">
			<div class="tab-pane fade in active" id="Attend">
			    <p><div class="table-responsive">'.$att.'</div></p>
			</div>
			<div class="tab-pane fade" id="Expired">
			    <p><div class="table-responsive">'.$exp.'</div></p>
			</div>
		    </div>
		</div>';
		$customerst = array(
			"html" => str_replace($this->order,$this->replace, $html),
			"btnmsg" => "#btn_send_exp",
			"loader" =>"#msg_loader",
			"session" => $_SESSION['expiry_list']
		);
		return $customerst;
	}
	public function sendAllMsg(){
		$obj = new statsModule($this->parameters);
		$msg_to = $_SESSION['expiry_list'];
		$msg_sub = $this->parameters["GYMNAME"]." Reminder";
		$msg_content = "Dear Customer,<br />
						This is automated message sent you to inform you that your validity is expired,<br />
						so please renew your subscription and enjoy working out.
						<br />
						<br />
						Regards,<br />
						".$this->parameters["GYMNAME"]."<br />
						Happy Workout.";
		$obj -> SendAppMsg($msg_to,$msg_content);
		$obj -> SendEmailMsg($msg_to,$msg_sub,$msg_content);
		$obj -> SendSMSMsg($msg_to,$msg_content);
	}
	public function SendAppMsg($msg_to,$msg_content){
		$query = "";
		$total = sizeof($msg_to);
		if($total > 0){
			$query = "INSERT INTO `crm_messages`(`id`,`to_email`, `text`, `msg_type_id`, `date`, `to_status`, `status`, `customer_pk`)VALUES";
			for($i=1;$i<=$total;$i++){
				if($i == $total)
					$query .= "(NULL,'".mysql_real_escape_string($msg_to[$i]['email'])."','".mysql_real_escape_string($msg_content)."',3,NOW(),default,'13','".mysql_real_escape_string($msg_to[$i]['id'])."');";
				else
					$query .= "(NULL,'".mysql_real_escape_string($msg_to[$i]['email'])."','".mysql_real_escape_string($msg_content)."',3,NOW(),default,'13'),'".mysql_real_escape_string($msg_to[$i]['id'])."');";
			}
			executeQuery($query);
		}
	}
	public function SendEmailMsg($msg_to,$msg_sub,$msg_content){
		$query = "";
		$email = '';
		$password = '';
		$config = array();
		$transport = '';
		$mail = '';
		$recipients = array();
		$qut = 0;
		$rem = 0;
		$name = 'Customer';
		$m = 0;
		$total = sizeof($msg_to);
		if($total > 0){
			/* Build  recipients array one source thirty recipients */
			$i=1;
			$m=1;
			if($total > 30){
				$qut = floor($total / 30);
				$rem = $total % 30;
				for(;$i<=$qut;$i++){
					if(isset($_SESSION['SourceEmailIds'])){
						$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
						$email = $_SESSION['SourceEmailIds'][$index]['email'];
						$password = $_SESSION['SourceEmailIds'][$index]['password'];
					}
					else{
						$email = MAILUSER;
						$password = MAILPASS;
					}
					$config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
					$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
					$mail = new Zend_Mail();
					$mail->setBodyHtml($msg_content);
					$mail->setFrom($email, $this->parameters["GYMNAME"]);
					$mail->setSubject($msg_sub);
					$query = "INSERT INTO `crm_email`(`id``from_email`, `to_email`, `subject`, `text`, `msg_type_id`, `date`, `status`, `customer_pk`)VALUES";
					for($j=1;$j<=30;$j++){
						if($j ==  30)
							$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($msg_to[$i]['id'])."');";
						else
							$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($msg_to[$i]['id'])."');";
						$mail->addTo($msg_to[$m]['email'], $name);
						$m++;
					}
					try{
						$mail->send($transport);
						executeQuery($query);
					}
					catch(exceptoin $e){
					}
				}
				if($rem > 0){
					$remaining = $total - ($qut * 30);
					if(isset($_SESSION['SourceEmailIds'])){
						$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
						$email = $_SESSION['SourceEmailIds'][$index]['email'];
						$password = $_SESSION['SourceEmailIds'][$index]['password'];
					}
					else{
						$email = MAILUSER;
						$password = MAILPASS;
					}
					$config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
					$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
					$mail = new Zend_Mail();
					$mail->setBodyHtml($msg_content);
					$mail->setFrom($email, $this->parameters["GYMNAME"]);
					$mail->setSubject($msg_sub);
					$query = "INSERT INTO `crm_email`(`id`,`from_email`, `to_email`, `subject`, `text`, `msg_type_id`, `date`, `status`, `customer_pk`)VALUES";
					for($j=1;$j<=$remaining;$j++){
						if($j ==  $remaining)
							$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($msg_to[$i]['id'])."');";
						else
							$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($msg_to[$i]['id'])."');";
						$mail->addTo($msg_to[$m]['email'], $name);
						$m++;
					}
					try{
						$mail->send($transport);
						executeQuery($query);
					}
					catch(exceptoin $e){
					}
				}
			}
			else if($total < 31 && $total >= 1){
				if(isset($_SESSION['SourceEmailIds'])){
					$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
					$email = $_SESSION['SourceEmailIds'][$index]['email'];
					$password = $_SESSION['SourceEmailIds'][$index]['password'];
				}
				else{
					$email = MAILUSER;
					$password = MAILPASS;
				}
				$config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
				$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
				$mail = new Zend_Mail();
				$mail->setBodyHtml($msg_content);
				$mail->setFrom($email, $this->parameters["GYMNAME"]);
				$mail->setSubject($msg_sub);
				$query = "INSERT INTO `crm_email`(`id`,`from_email`, `to_email`, `subject`, `text`, `msg_type_id`, `date`, `status`, `customer_pk`)VALUES";
				for($j=1;$j<=$total;$j++){
					if($j ==  $total)
						$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($msg_to[$i]['id'])."');";
					else
						$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($msg_to[$m]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($msg_to[$i]['id'])."');";
					$mail->addTo($msg_to[$m]['email'], $name);
					$m++;
				}
				try{
					$mail->send($transport);
					executeQuery($query);
				}
				catch(exceptoin $e){
				}
			}
		}
	}
	public function SendSMSMsg($msg_to,$msg_content){
		$query = "";
		$total = sizeof($msg_to);
		if($total > 0){
			$query = "INSERT INTO `crm_sms` ( `id`, `to_email`,`to_mobile`, `text`, `msg_type_id`, `date`, `status`, `customer_pk`)VALUES";
			for($i=1;$i<=$total;$i++){
				$to_mobile = $msg_to[$i]['cell'];
				if($i == $total)
					$query .= "(NULL,'".mysql_real_escape_string($msg_to[$i]['email'])."','".mysql_real_escape_string($to_mobile)."','".mysql_real_escape_string($msg_content)."','".mysql_real_escape_string('4')."',NOW(),'14','".mysql_real_escape_string($msg_to[$i]['id'])."');";
				else
					$query .= "(NULL,'".mysql_real_escape_string($msg_to[$i]['email'])."','".mysql_real_escape_string($to_mobile)."','".mysql_real_escape_string($msg_content)."','".mysql_real_escape_string('4')."',NOW(),'14','".mysql_real_escape_string($msg_to[$i]['id'])."');";
			}
			executeQuery($query);
		}
	}
	public function listEmpState(){
		$header = '';
		$att = '';
		$query = 'SELECT
			a.`id` ,
			b.`user_name` AS name ,
			b.`cell_number` ,
			b.`email` AS email_id,
			fc.`name` AS facility_type,
			a.`in_time` AS today
			FROM `employee_attendence` AS a
			INNER JOIN `employee` AS b ON b.`id` = a.`employee_id`
			LEFT JOIN `facility` as fc ON a.`facility_id` = fc.`id`
			WHERE STR_TO_DATE( NOW(),\'%Y-%m-%d\' ) = STR_TO_DATE( `in_time` , \'%Y-%m-%d\' )
			ORDER BY b.`id` DESC';
		$res = executeQuery($query);
		$i= mysql_num_rows($res);
		$header .='<h4 class="page-header">'.date('l jS \of F Y ').', Trainers Attendance</h4>';
		$att .= "<div class='table-responsive'><table cellpadding='0' cellspacing='0'  bgcolor='#AFFAFF' class='table table-bordered' id='listempattn'>

			<thead><tr>
			<th>#</th>
			<th>Name</th>
			<th>Email Id</th>
			<th>Cell Number</th>
			<th>Facility</th>
			<th>When</th>
			</tr></thead><tbody>
                        ";
		if(mysql_num_rows($res)){
			$no = 1;
			while($row = mysql_fetch_assoc($res)){
				// $direction = ($no % 2 == 0) ? "left" : "right";
				$direction = ($no % 2 == 0) ? "" : "";
				$att .= "<tr><td>".$no++."</td>
				<td>".$row['name']."</td>
				<td>".$row['email_id']."</td>
				<td>".$row['cell_number']."</td>
				<td>".$row['facility_type']."</td>
				<td>".date('j-M-Y', strtotime($row['today']))."</td></tr>";
			}
                        $att .=  '</tbody></table></div>';
		}
		else{
			$att =  '<b class="head"><h3>No Employee Visited The Club !!!</h3>.</b> ';
		}

		$html = $header.$att;
		return str_replace($this->order,$this->replace, $html);
	}
}
?>
