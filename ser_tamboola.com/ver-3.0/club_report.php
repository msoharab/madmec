<?php
class gymreport {
    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';
    function __construct($para = false) {
        $this->parameters = $para;
    }
    function GymFeeReport() {
        $list_type = $this->parameters["list_type"];
        $from = $this->parameters["from"];
        $to = $this->parameters["to"];
        $fromdate = $this->parameters["fromdate"];
        $todate = $this->parameters["todate"];
        $fname = $this->parameters["fname"];
        $fct_id = $this->parameters["fct_id"];
        $flag = false;
        $res = '';
        $feefields = array();
        $atotal = 0;
        $ototal = 0;
        $ptotal = 0;
        $dtotal = 0;
        if ($fromdate != 0 || $todate != 0) {
            $query = '';
            if ($fromdate < $todate && $fromdate != 0 && $todate != 0) {
                $query = 'SELECT
			b.`name`,
			a.`customer_pk` AS user_id,
			b.`email` As email,
			CONCAT(\'+91 \',b.`cell_number`) AS cell,
			c.`name` AS `offer_name`,
			c.`min_members` AS `members`,
			c.`duration_id`,
			ofd.`duration`  AS duration,
			c.`facility_id`,
			c.`cost`,
			fct.`name` AS facility_type,
			STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') AS `payment_date`,
			STR_TO_DATE(a.`valid_from`, \'%Y-%m-%d\') AS `valid_from`,
			STR_TO_DATE(a.`valid_till`, \'%Y-%m-%d\') AS `valid_till`,
			a.`amount` AS oldfee,
			a.`receipt_no`,
			mo_tr.`mt_pk`,
			mo_tr.`mt_uid`,
			mo_tr.`mopid`,
			STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\') AS `mt_pod`,
			CASE WHEN mo_tr.`mt_tt` IS NULL
				THEN CONCAT(c.`facility_id`,\' - \',c.`name`,\' - \',c.`duration_id`,\' - \',c.`cost`)
				ELSE mo_tr.`mt_tt`
			END AS mt_tt,
			mo_tr.`mt_rpt`,
			mo_tr.`mop`,
			mo_tr.`action_id`,
			mo_tr.`action_no`,
			mo_tr.`ind_amt`,
			mo_tr.`total_amt`,
			mo_tr.`inv_users`,
			mo_tr.`inv_urls`,
			mo_tr.`due_amount`,
			STR_TO_DATE(mo_tr.`due_date`, \'%Y-%m-%d\') AS `due_date`,
			mo_tr.`due_user`,
			mo_tr.`due_status`
		FROM `fee` AS a
		INNER JOIN `customer` AS b ON a.`customer_pk` = b.`id`
		INNER JOIN `offers` AS c ON a.`offer_id` = c.`id`
		INNER JOIN `facility` AS fct ON c.`facility_id`= fct.`id`
		LEFT JOIN `offerduration` AS ofd ON c.`duration_id`= ofd.`id`
		LEFT JOIN (
			SELECT
				mtr.`id`  					AS mt_pk,
				mtr.`customer_pk` 			AS mt_uid,
				GROUP_CONCAT(mtr.`mop_id`) 	AS mopid,
				mtr.`pay_date`  			AS mt_pod,
				mtr.`transaction_type`  	AS mt_tt,
				mtr.`receipt_no`  			AS mt_rpt,
				GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = 4 )) AS mop,
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
																		AND `status` = 4)
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
			) AS inv ON inv.`transaction_id` = mtr.`id` AND (inv.`name` LIKE "%' . $fname . '%" OR inv.`name` LIKE "%Due%")
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
			WHERE mtr.`transaction_type` LIKE "%' . $fname . '%"
			OR mtr.`transaction_type` LIKE "%Due%"
			GROUP BY(mtr.`receipt_no`)
		) AS mo_tr
			ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
			AND a.`id` = mo_tr.`action_id`
			AND a.`customer_pk` = mo_tr.`mt_uid`
			WHERE STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') >= STR_TO_DATE(\'' . $from . '\', \'%Y-%m-%d\')
				AND STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') <= STR_TO_DATE(\'' . $to . '\', \'%Y-%m-%d\')
		AND c.`facility_id` = "' . $fct_id . '"';
            } else if ($fromdate || $todate && ($fromdate != 0 || $todate != 0)) {
                $onedate = NULL;
                if ($fromdate)
                    $onedate = $from;
                else if ($todate)
                    $onedate = $to;
                else if ($fromdate == $todate && $fromdate != 0 && $todate != 0)
                    $onedate = $from;
                if ($onedate)
                    $query = 'SELECT
			b.`name`,
			a.`customer_pk` AS user_id,
			b.`email` As email,
			CONCAT(\'+91 \',b.`cell_number`) AS cell,
			c.`name` AS `offer_name`,
			c.`min_members` AS `members`,
			c.`duration_id` ,
			ofd.`duration`  AS duration ,
			c.`facility_id`,
			c.`cost`,
			fct.`name` AS facility_type,
			STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') AS `payment_date`,
			STR_TO_DATE(a.`valid_from`, \'%Y-%m-%d\') AS `valid_from`,
			STR_TO_DATE(a.`valid_till`, \'%Y-%m-%d\') AS `valid_till`,
			a.`amount` AS oldfee,
			a.`receipt_no`,
			mo_tr.`mt_pk`,
			mo_tr.`mt_uid`,
			mo_tr.`mopid`,
			STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\') AS `mt_pod`,
			CASE WHEN mo_tr.`mt_tt` IS NULL
				THEN CONCAT(c.`facility_id`,\' - \',c.`name`,\' - \',c.`duration_id`,\' - \',c.`cost`)
				ELSE mo_tr.`mt_tt`
			END AS mt_tt,
			mo_tr.`mt_rpt`,
			mo_tr.`mop`,
			mo_tr.`action_id`,
			mo_tr.`action_no`,
			mo_tr.`ind_amt`,
			mo_tr.`total_amt`,
			mo_tr.`inv_users`,
			mo_tr.`inv_urls`,
			mo_tr.`due_amount`,
			STR_TO_DATE(mo_tr.`due_date`, \'%Y-%m-%d\') AS `due_date`,
			mo_tr.`due_user`,
			mo_tr.`due_status`
		FROM `fee` AS a
		INNER JOIN `customer` AS b ON a.`customer_pk` = b.`id`
		INNER JOIN `offers` AS c ON a.`offer_id` = c.`id`
		INNER JOIN `facility` AS fct ON c.`facility_id`= fct.`id`
		LEFT JOIN `offerduration` AS ofd ON c.`duration_id`= ofd.`id`
		LEFT JOIN (
			SELECT
				mtr.`id`  					AS mt_pk,
				mtr.`customer_pk` 			AS mt_uid,
				GROUP_CONCAT(mtr.`mop_id`) 	AS mopid,
				mtr.`pay_date`  			AS mt_pod,
				mtr.`transaction_type`  	AS mt_tt,
				mtr.`receipt_no`  			AS mt_rpt,
				GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = 4 )) AS mop,
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
																		AND `status` = 4)
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
			) AS inv ON inv.`transaction_id` = mtr.`id` AND (inv.`name` LIKE "%' . $fname . '%" OR inv.`name` LIKE "%Due%")
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
			WHERE mtr.`transaction_type` LIKE "%' . $fname . '%"
			OR mtr.`transaction_type` LIKE "%Due%"
			GROUP BY(mtr.`receipt_no`)
		) AS mo_tr
			ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
			AND a.`id` = mo_tr.`action_id`
			AND a.`customer_pk` = mo_tr.`mt_uid`
		WHERE STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(\'' . $onedate . '\',\'%Y-%m-%d\')
		AND c.`facility_id` = "' . $fct_id . '"';
            }
            if ($query) {
                $res = executeQuery($query);
                if (mysql_num_rows($res)) {
                    $i = 1;
                    while ($row = mysql_fetch_assoc($res)) {
                        $feefields[$i]['No'] = $i;               /* A */
                        $feefields[$i]['name'] = $row['name'];           /* B */
                        $feefields[$i]['user_id'] = $row['email'];          /* C */
                        $feefields[$i]['cell'] = $row['cell'];           /* D */
                        $feefields[$i]['offer_name'] = $row['offer_name'];        /* E */
                        $feefields[$i]['duration'] = $row['duration'];         /* F */
                        $feefields[$i]['facility_type'] = $row['facility_type'];      /* G */
                        $feefields[$i]['payment_date'] = date('j-M-Y', strtotime($row['payment_date'])); /* H */
                        $feefields[$i]['valid_from'] = date('j-M-Y', strtotime($row['valid_from'])); /* I */
                        $feefields[$i]['valid_till'] = date('j-M-Y', strtotime($row['valid_till'])); /* J */
                        if ($row['mt_tt'] == "Due payment") /* K */
                            $feefields[$i]['amount'] = 0;
                        else
                            $feefields[$i]['amount'] = $row['oldfee'];
                        if ($row['receipt_no'] != NULL || $row['receipt_no'] != '')
                            $feefields[$i]['receipt_no'] = sprintf("%010s", $row['receipt_no']);   /* L */
                        else
                            $feefields[$i]['receipt_no'] = NULL;           /* L */
                        $feefields[$i]['mt_tt'] = $row['mt_tt'];          /* M */
                        $feefields[$i]['action_no'] = $row['action_no'];         /* N */
                        $feefields[$i]['total_amt'] = $row['total_amt'];         /* O */
                        if ($row['mt_rpt'] != NULL)
                            $feefields[$i]['mt_rpt'] = sprintf("%010s", $row['mt_rpt']);      /* P */
                        else
                            $feefields[$i]['mt_rpt'] = $row['mt_rpt'];          /* P */
                        if ($row['receipt_no'] != NULL || $row['receipt_no'] != '')
                            $feefields[$i]['inv_urls'] = URL.''.$row['inv_urls'];         /* P */
                        else
                            $feefields[$i]['inv_urls'] = NULL;            /* P */
                        //~ if($row['total_amt'] < $row['cost'] || $row['oldfee'] < $row['cost']){
                        //~ if($row['oldfee'] != 0)
                        //~ $row['due_amount'] = $row['cost'] - $row['oldfee'];
                        //~ else
                        //~ $row['due_amount'] = $row['cost'] - $row['total_amt'];
                        //~ }
                        if ($row['cost'] != NULL || $row['cost'] != 0)
                            $atotal += $row['cost'];   /* Actual fee */
                        if ($row['mt_tt'] == "Due payment") {
                            $feefields[$i]['receipt_no'] = "";
                        } else if ($row['oldfee'] != NULL || $row['oldfee'] != 0)
                            $ototal += $row['oldfee'];   /* Old fee */
                        if ($row['total_amt'] != NULL || $row['total_amt'] != 0)
                            $ptotal += $row['total_amt'];   /* Paid fee */
                        if ($row['due_amount'] != NULL || $row['due_amount'] != 0)
                            $dtotal += $row['due_amount'];  /* Due amount */
                        $feefields[$i]['due_amount'] = $row['due_amount'];         /* Q */
                        if ($row['due_date'] != NULL || $row['due_date'] != '')
                            $feefields[$i]['due_date'] = date('j-M-Y', strtotime($row['due_date']));   /* R */
                        else if ($row['due_amount'] != 0)
                            $feefields[$i]['due_date'] = 'Not provided';
                        else
                            $feefields[$i]['due_date'] = $row['due_date'];         /* R */
                        $i++;
                    }
                    $flag = true;
                } else
                    $feefields = NULL;
                if ($feefields != NULL) {
                    $objPHPExcel = new PHPExcel();
                    $headers = array('font' => array('bold' => true, 'color' => array('rgb' => '000000'), 'size' => 10, 'name' => 'Arial'), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),);
                    $sheet = $objPHPExcel->getActiveSheet();
                    $rows = 1;
                    $objPHPExcel->getProperties()->setCreator(GYMNAME)
                            ->setLastModifiedBy(GYMNAME)
                            ->setTitle($fname . " Fee Collection")
                            ->setSubject("Fee Collection Report")
                            ->setDescription("Report generated by CMS (Club Management System) Powered By MadMec.")
                            ->setKeywords("MadMec")
                            ->setCategory("Reports");
                    /* Set active sheet */
                    $objPHPExcel->setActiveSheetIndex(0);
                    /* Set page size */
                    $objPHPExcel->getActiveSheet()
                            ->getPageSetup()
                            ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                    $objPHPExcel->getActiveSheet()
                            ->getPageSetup()
                            ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    /* Add a header */
                    $objPHPExcel->getActiveSheet()
                            ->getHeaderFooter()
                            ->setOddHeader('&C&H ' . $fname . ' Fee collection report for date range ' . date('j-M-Y', strtotime($from)) . ' - ' . date('j-M-Y', strtotime($to)));
                    /* Add a footer */
                    $objPHPExcel->getActiveSheet()
                            ->getHeaderFooter()
                            ->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
                    $objPHPExcel->getActiveSheet()->setShowGridlines(true);
                    /*
                      Set printing area
                      $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H1');
                     */
                    /*
                      Set printing break
                      $objPHPExcel->getActiveSheet()->setBreak( 'A47' , PHPExcel_Worksheet::BREAK_ROW );
                     */
                    /* Add titles  of the columns */
                    $objPHPExcel->getActiveSheet()
                            ->setCellValueByColumnAndRow(0, 1, 'No') /* A */
                            ->setCellValueByColumnAndRow(1, 1, 'Customer Name') /* B */
                            ->setCellValueByColumnAndRow(2, 1, 'Customer E-mail') /* C */
                            ->setCellValueByColumnAndRow(3, 1, 'Customer Cell') /* D */
                            ->setCellValueByColumnAndRow(4, 1, 'Offer') /* E */
                            ->setCellValueByColumnAndRow(5, 1, 'Duration') /* F */
                            ->setCellValueByColumnAndRow(6, 1, 'Facility type') /* G */
                            ->setCellValueByColumnAndRow(7, 1, 'Payment date') /* H */
                            ->setCellValueByColumnAndRow(8, 1, 'Joining Date') /* I */
                            ->setCellValueByColumnAndRow(9, 1, 'Expiry date') /* J */
                            ->setCellValueByColumnAndRow(10, 1, 'Old fee') /* K */
                            ->setCellValueByColumnAndRow(11, 1, 'Old invoice') /* L */
                            ->setCellValueByColumnAndRow(12, 1, 'Transaction type') /* M */
                            ->setCellValueByColumnAndRow(13, 1, 'Mode Of Payment') /* N */
                            ->setCellValueByColumnAndRow(14, 1, 'Paid amt') /* O */
                            ->setCellValueByColumnAndRow(15, 1, 'Invoice no') /* P */
                            ->setCellValueByColumnAndRow(16, 1, 'Due amt') /* Q */
                            ->setCellValueByColumnAndRow(17, 1, 'Due Date');     /* R */
                    /* header bold */
                    $sheet->getStyle($rows)->applyFromArray($headers);
                    /* Setting a column’s width */
                    foreach (range('A', 'Z') as $columnID) {
                        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                                ->setAutoSize(true);
                    }
                    /* 4.6.12.	Center a page horizontally/vertically */
                    $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
                    /* 4.6.33.	Group/outline a row */
                    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
                    $attl = 0;
                    $ttv = array();
                    for ($i = 1; $i <= sizeof($feefields); $i++) {
                        $feefields[$i]['mt_tt'] = str_replace($fct_id, $fname, $feefields[$i]['mt_tt']);
                        if ($feefields[$i]['mt_tt'] != "Due payment") {
                            $resultss = explode("-", $feefields[$i]['mt_tt']);
                            $attl += (int) trim(end($resultss));
                        }
                        $objPHPExcel->getActiveSheet()
                                ->setCellValueByColumnAndRow(0, ($i + 1), $feefields[$i]['No'])
                                ->setCellValueByColumnAndRow(1, ($i + 1), $feefields[$i]['name'])
                                ->setCellValueByColumnAndRow(2, ($i + 1), $feefields[$i]['user_id'])
                                ->setCellValueByColumnAndRow(3, ($i + 1), $feefields[$i]['cell'])
                                ->setCellValueByColumnAndRow(4, ($i + 1), $feefields[$i]['offer_name'])
                                ->setCellValueByColumnAndRow(5, ($i + 1), $feefields[$i]['duration'])
                                ->setCellValueByColumnAndRow(6, ($i + 1), $feefields[$i]['facility_type'])
                                ->setCellValueByColumnAndRow(7, ($i + 1), $feefields[$i]['payment_date'])
                                ->setCellValueByColumnAndRow(8, ($i + 1), $feefields[$i]['valid_from'])
                                ->setCellValueByColumnAndRow(9, ($i + 1), $feefields[$i]['valid_till'])
                                ->setCellValueByColumnAndRow(10, ($i + 1), $feefields[$i]['amount'])
                                ->setCellValueByColumnAndRow(12, ($i + 1), $feefields[$i]['mt_tt'])
                                ->setCellValueByColumnAndRow(13, ($i + 1), $feefields[$i]['action_no'])
                                ->setCellValueByColumnAndRow(14, ($i + 1), $feefields[$i]['total_amt'])
                                ->setCellValueByColumnAndRow(15, ($i + 1), $feefields[$i]['inv_urls'])
                                ->setCellValueByColumnAndRow(16, ($i + 1), $feefields[$i]['due_amount'])
                                ->setCellValueByColumnAndRow(17, ($i + 1), $feefields[$i]['due_date']);
                        if ($feefields[$i]['receipt_no'] != NULL) {
                            $objPHPExcel->getActiveSheet()
                                    ->getCellByColumnAndRow(11, ($i + 1))
                                    ->setValueExplicit($feefields[$i]['receipt_no'], PHPExcel_Cell_DataType::TYPE_STRING2);
                        }
                        $objPHPExcel->getActiveSheet()
                                ->getCellByColumnAndRow(15, ($i + 1))
                                ->setValueExplicit($feefields[$i]['mt_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2);
                        if ($feefields[$i]['inv_urls'] != NULL) {
                            $objPHPExcel->getActiveSheet()
                                    ->getCellByColumnAndRow(15, ($i + 1))
                                    ->getHyperlink()
                                    ->setUrl(trim($feefields[$i]['inv_urls']));
                        }
                    }
                    $objPHPExcel->getActiveSheet()
                            ->setCellValueByColumnAndRow(9, ($i + 2), 'Old fee total')
                            ->setCellValueByColumnAndRow(10, ($i + 2), $ototal);
                    $objPHPExcel->getActiveSheet()
                            ->setCellValueByColumnAndRow(13, ($i + 2), 'New fee total')
                            ->setCellValueByColumnAndRow(14, ($i + 2), $ptotal);
                    $objPHPExcel->getActiveSheet()
                            ->setCellValueByColumnAndRow(15, ($i + 2), 'Due amount')
                            ->setCellValueByColumnAndRow(16, ($i + 2), $dtotal);
                    $objPHPExcel->getActiveSheet()
                            ->setCellValueByColumnAndRow(4, ($i + 4), 'Actual fee total')
                            ->setCellValueByColumnAndRow(5, ($i + 4), $attl)
                            ->setCellValueByColumnAndRow(4, ($i + 5), 'Paid fee total')
                            ->setCellValueByColumnAndRow(5, ($i + 5), $ptotal)
                            ->setCellValueByColumnAndRow(4, ($i + 6), 'Due')
                            ->setCellValueByColumnAndRow(5, ($i + 6), ($atotal - $ototal));
                    /*
                      Export it to browser
                      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                      header('Content-Disposition: attachment;filename="myfile.xlsx"');
                      header('Cache-Control: max-age=0');
                      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                      $objWriter->save('php://output');
                     */
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    // $objWriter->save(str_replace('.php', '.xlsx','./Gym'. __FILE__));
                    $callStartTime = microtime(true);
                    $filename = GYMNAME . '_' . $objPHPExcel->getProperties()->getTitle() . '_' . date('j-M-Y') . '_' . date('j-M-Y', strtotime($from)) . '_' . date('j-M-Y', strtotime($to)) . '_' . $callStartTime . '.xlsx';
                    $objWriter->save(DOC_ROOT . DOWNLOADS . $filename);
                    unset($objWriter);
                    unset($objPHPExcel);
                    echo '<center><h3>Click on below link to download</h3><h4><a target="_blank" id="printButGen" href="' . URL . DOWNLOADS . $filename . '">' . $filename . '</a></h4></center>';
                }
            }
        }
        if (!$flag) {
            echo '<center><h2>No records found!!!</h2></center>';
        }
    }
}
?>