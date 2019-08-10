<?php
class registrationreport{
	protected $parameters = array();
	private $order   = array("\r\n", "\n", "\r", "\t");
	private $replace = '';
	function __construct($para	=	false){
		$this->parameters=$para;
	}
	public function RegistrationReport(){
		$from=$this->parameters["from"];
		$to=$this->parameters["to"];
		$fromdate=$this->parameters["fromdate"];
		$todate=$this->parameters["todate"];
		$flag = false;
		$res = '';
		$userfields = array();
		$total = 0;
		$ntotal = 0;
		$ototal = 0;
		if($fromdate != 0 || $todate != 0){
			$query = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$query = 'SELECT
							usr.`id` AS usrid,
							mo_tr.`mt_pk`,
							usr.`name`,
							usr.`email` AS email_id,
							usr.`fee` AS ufee,
							CONCAT(\'+91 \',usr.`cell_number`) AS cell,
							STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') AS doj,
							mo_tr.`mt_tt`,
							mo_tr.`mt_rpt`,
							mo_tr.`action_no`,
							mo_tr.`total_amt`,
							mo_tr.`inv_urls`,
							STR_TO_DATE(mo_tr.`due_date`, \'%Y-%m-%d\') AS due_date,
							mo_tr.`due_amount`,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN 0
								ELSE usr.`fee`
							END AS old_fee,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN \'\'
								ELSE usr.`receipt_no`
							END AS old_rpt,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN \'\'
								ELSE usr.`mode_of_payment`
							END AS old_mop
						FROM `customer` AS usr
						LEFT JOIN(
							SELECT
								mtr.`id` 									AS mt_pk,
								mtr.`customer_pk` 							AS mt_uid,
								mtr.`transaction_type`  					AS mt_tt,
								mtr.`receipt_no`  							AS mt_rpt,
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
																			AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))
									)
								)AS action_no,
								/* GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))) AS mop, */
								/* GROUP_CONCAT(mtr.`mop_id`) 				AS mopid, */
								/* mtr.`pay_date`  							AS mt_pod, */
								/* GROUP_CONCAT(mtr.`transaction_id`) AS action_id, */
								/* GROUP_CONCAT(`total_amount`) AS ind_amt, */
								/* inv.`inv_users`, */
								SUM(`total_amount`) AS total_amt,
								inv.`inv_urls`,
								due.`due_date`,
								due.`due_amount`
								/* due.`due_user`, */
								/* due.`due_status`, */
							FROM `money_transactions` AS mtr
							LEFT JOIN (
								SELECT
									/*
									GROUP_CONCAT(`customer_pk`) AS inv_users,
									GROUP_CONCAT(`location`) AS inv_urls,
									*/
									`customer_pk` AS inv_users,
									`location` AS inv_urls,
									`transaction_id`,
									`name`
								FROM `invoice`
								GROUP BY(`transaction_id`)
							) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE \'%registration%\'
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
							WHERE mtr.`transaction_type` LIKE \'%registration%\'
							GROUP BY(mtr.`receipt_no`)
							ORDER BY (mtr.`id`)
						) AS mo_tr ON mo_tr.`mt_uid` = usr.`id`
						WHERE STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\', \'%Y-%m-%d\')
						AND STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\', \'%Y-%m-%d\')
						AND usr.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Left\' AND `status`=1)
						AND usr.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Delete\' AND `status`=1);';
			}
			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
					$query = 'SELECT
							usr.`id` AS usrid,
							mo_tr.`mt_pk`,
							usr.`name`,
							usr.`email` AS email_id,
							usr.`fee` AS ufee,
							CONCAT(\'+91 \',usr.`cell_number`) AS cell,
							STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') AS doj,
							mo_tr.`mt_tt`,
							mo_tr.`mt_rpt`,
							mo_tr.`action_no`,
							mo_tr.`total_amt`,
							mo_tr.`inv_urls`,
							STR_TO_DATE(mo_tr.`due_date`, \'%Y-%m-%d\') AS due_date,
							mo_tr.`due_amount`,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN 0
								ELSE usr.`fee`
							END AS old_fee,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN \'\'
								ELSE usr.`receipt_no`
							END AS old_rpt,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN \'\'
								ELSE usr.`mode_of_payment`
							END AS old_mop
						FROM `customer` AS usr
						LEFT JOIN(
							SELECT
								mtr.`id` 									AS mt_pk,
								mtr.`customer_pk` 								AS mt_uid,
								mtr.`transaction_type`  					AS mt_tt,
								mtr.`receipt_no`  							AS mt_rpt,
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
																			AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))
									)
								)AS action_no,
								/* GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))) AS mop, */
								/* GROUP_CONCAT(mtr.`mop_id`) 				AS mopid, */
								/* mtr.`pay_date`  							AS mt_pod, */
								/* GROUP_CONCAT(mtr.`transaction_id`) AS action_id, */
								/* GROUP_CONCAT(`total_amount`) AS ind_amt, */
								/* inv.`inv_users`, */
								SUM(`total_amount`) AS total_amt,
								inv.`inv_urls`,
								due.`due_date`,
								due.`due_amount`
								/* due.`due_user`, */
								/* due.`due_status`, */
							FROM `money_transactions` AS mtr
							LEFT JOIN (
								SELECT
									/*
									GROUP_CONCAT(`customer_pk`) AS inv_users,
									GROUP_CONCAT(`location`) AS inv_urls,
									*/
									`customer_pk` AS inv_users,
									`location` AS inv_urls,
									`transaction_id`,
									`name`
								FROM `invoice`
								GROUP BY(`transaction_id`)
							) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE \'%registration%\'
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
							WHERE mtr.`transaction_type` LIKE \'%registration%\'
							GROUP BY(mtr.`receipt_no`)
							ORDER BY (mtr.`id`)
						) AS mo_tr ON mo_tr.`mt_uid` = usr.`id`
							WHERE STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') = STR_TO_DATE(\''.$onedate.'\', \'%Y-%m-%d\')
							AND usr.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Left\' AND `status`=1)
						AND usr.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Delete\' AND `status`=1);';
			}
			if($query){
						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							// echo mysql_num_rows($res) ."<br />";
							$i=1;
							while($row = mysql_fetch_assoc($res)){

								$userfields[$i]['No'] = $i; /* A */
								$userfields[$i]['name'] = $row['name']; /* B */
								$userfields[$i]['email_id'] = $row['email_id']; /* C */
								$userfields[$i]['cell_number'] = $row['cell']; /* D */
								$userfields[$i]['date_of_join'] = date('j-M-Y', strtotime($row['doj'])); /* E */
								$userfields[$i]['mt_tt'] = $row['mt_tt']; /* F */
								if($row['mt_rpt'] != NULL)
									$userfields[$i]['mt_rpt'] = sprintf("%010s",$row['mt_rpt']); /* G */
								else
									$userfields[$i]['mt_rpt'] = $row['mt_rpt']; /* G */
								$userfields[$i]['action_no'] = $row['action_no']; /* H */
								$userfields[$i]['fee'] = $row['ufee']; /* I */
								$userfields[$i]['inv_urls'] = $row['inv_urls']; /* J */
								if($row['due_date'] != NULL || $row['due_date'] != '')
									$userfields[$i]['due_date'] = date('j-M-Y', strtotime($row['due_date'])); /* K */
								else
									$userfields[$i]['due_date'] = $row['due_date']; /* K */
								$userfields[$i]['due_amount'] = $row['due_amount']; /* L */
								$userfields[$i]['old_fee'] = $row['old_fee']; /* M */
								if($row['old_rpt'] != NULL || $row['old_rpt'] != '')
									$userfields[$i]['old_rpt'] = sprintf("%010s",$row['old_rpt']); /* N */
								else
									$userfields[$i]['old_rpt'] = $row['old_rpt']; /* N */
								if($userfields[$i]['old_rpt'] == '0000000000')
									$userfields[$i]['old_rpt'] = NULL;
								$userfields[$i]['old_mop'] = $row['old_mop']; /* O */
								$total += ($row['old_fee'] + $row['total_amt']);
								$ntotal += $row['ufee'];
								$ototal += $row['old_fee'];
								// echo '<p>'.$userfields[$i]['inv_urls'].'</p>';
								$i++;
							}
							$flag = true;
						}
						else
							$userfields = NULL;

				if($userfields != NULL){
					$objPHPExcel = new PHPExcel();
					$headers = array('font'=> array('bold'=> true,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Arial'),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),);
					$sheet=$objPHPExcel->getActiveSheet();
					$rows = 1;
					$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
												 ->setLastModifiedBy($this->parameters["GYMNAME"])
												 ->setTitle("Customer Registrations")
												 ->setSubject("Customer Registrations Report")
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
								->setOddHeader('&C&H Customer Registrations report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
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
								->setCellValueByColumnAndRow(0,1, 'No')
								->setCellValueByColumnAndRow(1,1, 'Customer Name')
								->setCellValueByColumnAndRow(2,1, 'Email Id')
								->setCellValueByColumnAndRow(3,1, 'Cell Number')
								->setCellValueByColumnAndRow(4,1, 'Joining Date')
								->setCellValueByColumnAndRow(5,1, 'Transaction type')
								->setCellValueByColumnAndRow(6,1, 'Invoice no')
								->setCellValueByColumnAndRow(7,1, 'Mode Of Payment')
								->setCellValueByColumnAndRow(8,1, 'Registration Fee')
								->setCellValueByColumnAndRow(9,1, 'Invoice URLS')
								->setCellValueByColumnAndRow(10,1, 'Due Date')
								->setCellValueByColumnAndRow(11,1, 'Due amt')
								->setCellValueByColumnAndRow(12,1, 'Old fee')
								->setCellValueByColumnAndRow(13,1, 'Old invoice')
								->setCellValueByColumnAndRow(14,1, 'Old MOP');

					/*header bold*/
					$sheet->getStyle($rows)->applyFromArray($headers);
					/* Setting a column’s width */
					foreach(range('A','O') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);
					}
					/* 4.6.12.	Center a page horizontally/vertically */
					$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
					/* 4.6.33.	Group/outline a row */
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
					for($i = 1;$i<=sizeof($userfields);$i++){
						$objPHPExcel->getActiveSheet()
									->setCellValueByColumnAndRow(0,($i+1), $userfields[$i]['No'])
									->setCellValueByColumnAndRow(1,($i+1), $userfields[$i]['name'])
									->setCellValueByColumnAndRow(2,($i+1), $userfields[$i]['email_id'])
									->setCellValueByColumnAndRow(3,($i+1), $userfields[$i]['cell_number'])
									->setCellValueByColumnAndRow(4,($i+1), $userfields[$i]['date_of_join'])
									->setCellValueByColumnAndRow(5,($i+1), $userfields[$i]['mt_tt'])
									->setCellValueByColumnAndRow(7,($i+1), $userfields[$i]['action_no'])
									->setCellValueByColumnAndRow(8,($i+1), $userfields[$i]['fee'])
									->setCellValueByColumnAndRow(10,($i+1), $userfields[$i]['due_date'])
									->setCellValueByColumnAndRow(11,($i+1), $userfields[$i]['due_amount'])
									->setCellValueByColumnAndRow(12,($i+1), $userfields[$i]['old_fee']);
						$objPHPExcel->getActiveSheet()
									->getCellByColumnAndRow(6,($i+1))
									->setValueExplicit($userfields[$i]['mt_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2);
						if($userfields[$i]['inv_urls'] != NULL || $userfields[$i]['inv_urls'] != ''){
							$objPHPExcel->getActiveSheet()
									->getCellByColumnAndRow(9,($i+1))
									->setValueExplicit($userfields[$i]['mt_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2);
							$objPHPExcel->getActiveSheet()
										->getCellByColumnAndRow(9,($i+1))
										->getHyperlink()
										->setUrl(trim($userfields[$i]['inv_urls']));
						}
						$objPHPExcel->getActiveSheet()
									->getCellByColumnAndRow(13,($i+1))
									->setValueExplicit($userfields[$i]['old_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2);
						if($userfields[$i]['old_rpt'] != NULL)
							$objPHPExcel->getActiveSheet()
										->setCellValueByColumnAndRow(14,($i+1), $userfields[$i]['old_mop']);
						else
							$objPHPExcel->getActiveSheet()
										->setCellValueByColumnAndRow(14,($i+1), NULL);
					}
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(7,($i+2),'New total')
								->setCellValueByColumnAndRow(8,($i+2),$ntotal)
								->setCellValueByColumnAndRow(11,($i+2),'Old total')
								->setCellValueByColumnAndRow(12,($i+2),$ototal);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(4,($i+3),'New total')
								->setCellValueByColumnAndRow(5,($i+3),$ntotal)
								->setCellValueByColumnAndRow(4,($i+4),'Old total')
								->setCellValueByColumnAndRow(5,($i+4),$ototal)
								->setCellValueByColumnAndRow(4,($i+5),'Grand total')
								->setCellValueByColumnAndRow(5,($i+5),$total);
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
					$filename = $this->parameters["GYMNAME"].'_'.$objPHPExcel->getProperties()->getTitle().'_'.date('j-M-Y').'_'. date('j-M-Y', strtotime($from)) .'_'.date('j-M-Y', strtotime($to)).'_'.$callStartTime.'.xlsx';
					$objWriter->save(DOC_ROOT.DOWNLOADS.$filename);
					unset($objWriter);
					unset($objPHPExcel);
					echo '<center><h3>Click on below link to download</h3><h4><a target="_blank" href="'.URL.DOWNLOADS.$filename.'">'.$filename.'</a></h4></center>';
				}
			}
		}
		if(!$flag){
			echo '<center><h2>No records found!!!</h2></center>';
		}
	}
	public function PaymentsReport(){
		$from=$this->parameters["from"];
		$to=$this->parameters["to"];
		$fromdate=$this->parameters["fromdate"];
		$todate=$this->parameters["todate"];
		$flag = false;
		$res = '';
		$expensesfields = array();
		$total = 0;
//                echo print_r($this->parameters);
//                exit(0);
		if($fromdate != 0 || $todate != 0){
			$query = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$query ='SELECT a.`name` AS  `nam` ,
								a.`amount` AS  `amt` ,
								STR_TO_DATE( a.`pay_date` ,  \'%Y-%m-%d\' ) AS  `pod` ,
								a.`receipt_no` AS  `rpt`
						FROM  `payments` AS a
						WHERE STR_TO_DATE(a.`pay_date`, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\', \'%Y-%m-%d\')
						AND STR_TO_DATE(a.`pay_date`, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\', \'%Y-%m-%d\');';
			}

			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
				$query ='SELECT a.`name` AS  `nam` ,
								a.`amount` AS  `amt` ,
								STR_TO_DATE( a.`pay_date` ,  \'%Y-%m-%d\' ) AS  `pod` ,
								a.`receipt_no` AS  `rpt`
						FROM  `payments` AS a
						WHERE STR_TO_DATE( a.`pay_date` ,  \'%Y-%m-%d\' ) = STR_TO_DATE(\''.$onedate.'\',  \'%Y-%m-%d\' );';
			}
			if($query){

						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							$i=1;
							while($row = mysql_fetch_assoc($res)){
								$expensesfields[$i]['No'] = $i; /* A */
								$expensesfields[$i]['name'] = $row['nam']; /* B */
								$expensesfields[$i]['pod'] = date('j-M-Y', strtotime($row['pod'])); /* C */
								//$expensesfields[$i]['rpt'] = $row['rpt']; /* D */
								$expensesfields[$i]['amt'] = $row['amt']; /* E */
								$total += $row['amt'];
								$i++;
							}
							$flag = true;
						}
						else
							$expensesfields = NULL;

				if($expensesfields != NULL){
					$objPHPExcel = new PHPExcel();
					$headers = array('font'=> array('bold'=> true,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Arial'),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),);
					$sheet=$objPHPExcel->getActiveSheet();
					$rows = 1;
					$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
												 ->setLastModifiedBy($this->parameters["GYMNAME"])
												 ->setTitle("Payments")
												 ->setSubject("Payments Report")
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
								->setOddHeader('&C&H Payments report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
					/* Add a footer */
					$objPHPExcel->getActiveSheet()
								->getHeaderFooter()
								->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
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
								->setCellValueByColumnAndRow(0,1, 'No')
								->setCellValueByColumnAndRow(1,1, 'Payee')
								->setCellValueByColumnAndRow(2,1, 'Payment Date')
								//->setCellValueByColumnAndRow(3,1, 'Receipt No')
								->setCellValueByColumnAndRow(3,1, 'Amount');
					/* Setting a column’s width */
					/*header bold*/
					$sheet->getStyle($rows)->applyFromArray($headers);
					foreach(range('A','E') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);
					}
					/* 4.6.12.	Center a page horizontally/vertically */
					$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
					/* 4.6.33.	Group/outline a row */
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
					for($i = 1;$i<=sizeof($expensesfields);$i++){
						$objPHPExcel->getActiveSheet()
									->setCellValueByColumnAndRow(0,($i+1), $expensesfields[$i]['No'])
									->setCellValueByColumnAndRow(1,($i+1), $expensesfields[$i]['name'])
									->setCellValueByColumnAndRow(2,($i+1), $expensesfields[$i]['pod'])
									//->setCellValueByColumnAndRow(3,($i+1), $expensesfields[$i]['rpt'])
									->setCellValueByColumnAndRow(3,($i+1), $expensesfields[$i]['amt']);
					}
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(3,($i+2),$total);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(2,($i+2),'Total');
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$callStartTime = microtime(true);
					$filename = $this->parameters["GYMNAME"].'_'.$objPHPExcel->getProperties()->getTitle().'_'.date('j-M-Y').'_'. date('j-M-Y', strtotime($from)) .'_'.date('j-M-Y', strtotime($to)).'_'.$callStartTime.'.xlsx';
					$objWriter->save(DOC_ROOT.DOWNLOADS.$filename);
					unset($objWriter);
					unset($objPHPExcel);
					echo '<center><h3>Click on below link to download</h3><h4><a target="_blank" href="'.URL.DOWNLOADS.$filename.'">'.$filename.'</a></h4></center>';
				}
			}
		}
		if(!$flag){
			echo '<center><h2>No records found!!!</h2></center>';
		}
	}
	public function ExpensesReport(){

		$from=$this->parameters["from"];
		$to=$this->parameters["to"];
		$fromdate=$this->parameters["fromdate"];
		$todate=$this->parameters["todate"];
		$flag = false;
		$res = '';
		$expensesfields = array();
		$total = 0;
		if($fromdate != 0 || $todate != 0){
			$query = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$query ='SELECT a.`name` AS  `nam` ,
								a.`amount` AS  `amt` ,
								STR_TO_DATE( a.`pay_date` ,  \'%Y-%m-%d\' ) AS  `pod` ,
								a.`receipt_no` AS  `rpt`
						FROM  `expenses` AS a
						WHERE STR_TO_DATE(a.`pay_date`, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\', \'%Y-%m-%d\')
						AND STR_TO_DATE(a.`pay_date`, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\', \'%Y-%m-%d\');';
			}
			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
				$query ='SELECT a.`name` AS  `nam` ,
								a.`amount` AS  `amt` ,
								STR_TO_DATE( a.`pay_date` ,  \'%Y-%m-%d\' ) AS  `pod` ,
								a.`receipt_no` AS  `rpt`
						FROM  `expenses` AS a
						WHERE STR_TO_DATE( a.`pay_date` ,  \'%Y-%m-%d\' ) = STR_TO_DATE(\''.$onedate.'\',  \'%Y-%m-%d\' );';
			}
			if($query){

						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							$i=1;
							while($row = mysql_fetch_assoc($res)){
								$expensesfields[$i]['No'] = $i; /* A */
								$expensesfields[$i]['name'] = $row['nam']; /* B */
								$expensesfields[$i]['pod'] = date('j-M-Y', strtotime($row['pod'])); /* C */
								$expensesfields[$i]['rpt'] = $row['rpt']; /* D */
								$expensesfields[$i]['amt'] = $row['amt']; /* E */
								$total += $row['amt'];
								$i++;
							}
							$flag = true;
						}
						else
							$expensesfields = NULL;

				if($expensesfields != NULL){
					$objPHPExcel = new PHPExcel();
					$headers = array('font'=> array('bold'=> true,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Arial'),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),);
					$sheet=$objPHPExcel->getActiveSheet();
					$rows = 1;
					$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
												 ->setLastModifiedBy($this->parameters["GYMNAME"])
												 ->setTitle("Expenses")
												 ->setSubject("Expenses Report")
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
								->setOddHeader('&C&H Expenses report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
					/* Add a footer */
					$objPHPExcel->getActiveSheet()
								->getHeaderFooter()
								->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
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
								->setCellValueByColumnAndRow(0,1, 'No')
								->setCellValueByColumnAndRow(1,1, 'Payee')
								->setCellValueByColumnAndRow(2,1, 'Payment Date')
								->setCellValueByColumnAndRow(3,1, 'Receipt No')
								->setCellValueByColumnAndRow(4,1, 'Amount');
					/* Setting a column’s width */
					/*header bold*/
					$sheet->getStyle($rows)->applyFromArray($headers);
					foreach(range('A','E') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);
					}
					/* 4.6.12.	Center a page horizontally/vertically */
					$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
					/* 4.6.33.	Group/outline a row */
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
					for($i = 1;$i<=sizeof($expensesfields);$i++){
						$objPHPExcel->getActiveSheet()
									->setCellValueByColumnAndRow(0,($i+1), $expensesfields[$i]['No'])
									->setCellValueByColumnAndRow(1,($i+1), $expensesfields[$i]['name'])
									->setCellValueByColumnAndRow(2,($i+1), $expensesfields[$i]['pod'])
									->setCellValueByColumnAndRow(3,($i+1), $expensesfields[$i]['rpt'])
									->setCellValueByColumnAndRow(4,($i+1), $expensesfields[$i]['amt']);
					}
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(4,($i+2),$total);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(3,($i+2),'Total');
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$callStartTime = microtime(true);
					$filename = $this->parameters["GYMNAME"].'_'.$objPHPExcel->getProperties()->getTitle().'_'.date('j-M-Y').'_'. date('j-M-Y', strtotime($from)) .'_'.date('j-M-Y', strtotime($to)).'_'.$callStartTime.'.xlsx';
					$objWriter->save(DOC_ROOT.DOWNLOADS.$filename);
					unset($objWriter);
					unset($objPHPExcel);
					echo '<center><h3>Click on below link to download</h3><h4><a target="_blank" href="'.URL.DOWNLOADS.$filename.'">'.$filename.'</a></h4></center>';
				}
			}
		}
		if(!$flag){
			echo '<center><h2>No records found!!!</h2></center>';
		}
	}
	public function BalanceSheet(){
		$from=$this->parameters["from"];
		$to=$this->parameters["to"];
		$fromdate=$this->parameters["fromdate"];
		$todate=$this->parameters["todate"];
		$flag = false;
		$res = '';
		$expensesfields = NULL;
		$paymentsfields = NULL;
		$feesfields = NULL;
		$packagefields = NULL;

		$expensestotal = 0;
		$paymentstotal = 0;
		$feestotal = 0;

		$obj = new enquiry();
		$fac = $obj -> fetchInterestedIn();
		$faclen = sizeof($fac);

		for($i=0;$i<$faclen;$i++)
		{
			$facility_type[] = $fac[$i]["name"];
			$facility_total[$fac[$i]["name"]] = 0;
		}
		array_push($facility_type,"Pacakges","Registration");
		$facility_total["Pacakges"] = 0;
		$facility_total["Registration"] = 0;
		if($fromdate != 0 || $todate != 0){
			$expenses = '';
			$payments = '';
			$fee = '';
			$package = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$expenses ='SELECT exp.`name` AS exp_name, exp.`amount` AS exp_amount,exp.`pay_date` AS exp_date,exp.`receipt_no` AS exp_receipt
							FROM `expenses` AS exp
							WHERE STR_TO_DATE(exp.`pay_date`,\'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\',\'%Y-%m-%d\')
							AND STR_TO_DATE(exp.`pay_date`,\'%Y-%m-%d\')  <= STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\');';
				$payments ='SELECT pay.`name` AS pay_name, pay.`amount` AS pay_amount,pay.`pay_date` AS pay_date,pay.`receipt_no` AS pay_receipt
							FROM `payments` AS pay
							WHERE STR_TO_DATE(pay.`pay_date`,\'%Y-%m-%d\')>= STR_TO_DATE(\''.$from.'\',\'%Y-%m-%d\')
							AND STR_TO_DATE(pay.`pay_date`,\'%Y-%m-%d\')  <= STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\');';

			}
			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
				$expenses ='SELECT exp.`name` AS exp_name, exp.`amount` AS exp_amount,exp.`pay_date` AS exp_date,exp.`receipt_no` AS exp_receipt
							FROM `expenses` AS exp
							WHERE STR_TO_DATE(exp.`pay_date`,\'%Y-%m-%d\') = STR_TO_DATE(\''.$onedate.'\',\'%Y-%m-%d\');';
				$payments ='SELECT  pay.`name` AS pay_name, pay.`amount` AS pay_amount,pay.`pay_date` AS pay_date,pay.`receipt_no` AS pay_receipt
							FROM `payments` AS pay
							WHERE STR_TO_DATE(pay.`pay_date`,\'%Y-%m-%d\')= STR_TO_DATE(\''.$onedate.'\',\'%Y-%m-%d\');';

			}
			if($expenses && $payments ){
						$res1 = executeQuery($expenses);
						$res2 = executeQuery($payments);
						if(mysql_num_rows($res1)){
							$i=1;
							while($row = mysql_fetch_assoc($res1)){
								$expensesfields[$i]['No'] = $i; /* A */
								$expensesfields[$i]['exp_name'] = $row['exp_name']; /* B */
								$expensesfields[$i]['exp_amount'] = $row['exp_amount']; /* C */
								$expensesfields[$i]['exp_date'] = date('j-M-Y', strtotime($row['exp_date'])); /* D */
								$expensesfields[$i]['exp_receipt'] = $row['exp_receipt']; /* E */
								$expensestotal += $row['exp_amount'];
								$i++;
							}
						}
						if(mysql_num_rows($res2)){
							$i=1;
							while($row = mysql_fetch_assoc($res2)){
								$paymentsfields[$i]['No'] = $i; /* A */
								$paymentsfields[$i]['pay_name'] = $row['pay_name']; /* B */
								$paymentsfields[$i]['pay_amount'] = $row['pay_amount']; /* C */
								$paymentsfields[$i]['pay_date'] = date('j-M-Y', strtotime($row['pay_date'])); /* D */
								$paymentsfields[$i]['pay_receipt'] = $row['pay_receipt']; /* E */
								$paymentstotal += $row['pay_amount'];
								$i++;
							}
						}
			}
			$objPHPExcel = new PHPExcel();
			$headers = array('font'=> array('bold'=> true,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Arial'),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),);
					$sheet=$objPHPExcel->getActiveSheet();
					$rows = 1;
			$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
										 ->setLastModifiedBy($this->parameters["GYMNAME"])
										 ->setTitle("Balance Sheet")
										 ->setSubject("Accounts calculations")
										 ->setDescription("Report generated by CMS (Club Management System) Powered By MadMec.")
										 ->setKeywords("MadMec")
										 ->setCategory("Reports");
			if($expensesfields != NULL){
				$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Expenses report');
				// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
				$objPHPExcel->addSheet($myWorkSheet, 0);
				/* Set active sheet */
				$objPHPExcel->setActiveSheetIndexByName('Expenses report');
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
							->setOddHeader('&C&H Expenses report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
				/* Add a footer */
				$objPHPExcel->getActiveSheet()
							->getHeaderFooter()
							->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
				/* Add titles  of the columns */
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(0,1, 'No')
							->setCellValueByColumnAndRow(1,1, 'Payee')
							->setCellValueByColumnAndRow(2,1, 'Payment date')
							->setCellValueByColumnAndRow(3,1, 'Receipt No')
							->setCellValueByColumnAndRow(4,1, 'Amount');
				/*header bold*/
				$sheet->getStyle($rows)->applyFromArray($headers);
				/* Setting a column’s width */
				foreach(range('A','Z') as $columnID) {
					$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
						->setAutoSize(true);
				}
				/* 4.6.12.	Center a page horizontally/vertically */
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				/* 4.6.33.	Group/outline a row */
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
				for($i = 1;$i<=sizeof($expensesfields);$i++){
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(0,($i+1), $expensesfields[$i]['No'])
								->setCellValueByColumnAndRow(1,($i+1), $expensesfields[$i]['exp_name'])
								->setCellValueByColumnAndRow(2,($i+1), $expensesfields[$i]['exp_date'])
								->setCellValueByColumnAndRow(3,($i+1), $expensesfields[$i]['exp_receipt'])
								->setCellValueByColumnAndRow(4,($i+1), $expensesfields[$i]['exp_amount']);
				}
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(3,($i+2),'Total')
							->setCellValueByColumnAndRow(4,($i+2),$expensestotal);
			}
			if($paymentsfields != NULL){
				$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Payments report');
				// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
				$objPHPExcel->addSheet($myWorkSheet, 0);
				/* Set active sheet */
				$objPHPExcel->setActiveSheetIndexByName('Payments report');
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
							->setOddHeader('&C&H Payments report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
				/* Add a footer */
				$objPHPExcel->getActiveSheet()
							->getHeaderFooter()
							->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
				/* Add titles  of the columns */
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(0,1, 'No')
							->setCellValueByColumnAndRow(1,1, 'Payee')
							->setCellValueByColumnAndRow(2,1, 'Payment date')
							->setCellValueByColumnAndRow(3,1, 'Receipt No')
							->setCellValueByColumnAndRow(4,1, 'Amount');
				/* Setting a column’s width */
				foreach(range('A','Z') as $columnID) {
					$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
						->setAutoSize(true);
				}
				/* 4.6.12.	Center a page horizontally/vertically */
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				/* 4.6.33.	Group/outline a row */
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
				for($i = 1;$i<=sizeof($paymentsfields);$i++){
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(0,($i+1), $paymentsfields[$i]['No'])
								->setCellValueByColumnAndRow(1,($i+1), $paymentsfields[$i]['pay_name'])
								->setCellValueByColumnAndRow(2,($i+1), $paymentsfields[$i]['pay_date'])
								->setCellValueByColumnAndRow(3,($i+1), $paymentsfields[$i]['pay_receipt'])
								->setCellValueByColumnAndRow(4,($i+1), $paymentsfields[$i]['pay_amount']);
				}
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(4,($i+2),$paymentstotal);
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(3,($i+2),'Total');
			}
			/* facility array will be here */
			$obj = new registrationreport($this->parameters);
			for($fi=0;$fi<$faclen;$fi++)
				$facility_total[$fac[$fi]["name"]] = $obj-> FeeReport($from,$to,$fromdate,$todate,$objPHPExcel,$fac[$fi]["id"],$fac[$fi]["name"]);

			$facility_total["Pacakges"] =  $obj-> balPackageReport($from,$to,$fromdate,$todate,$objPHPExcel);
			$facility_total["Registration"] = $obj-> balRegistrationReport($from,$to,$fromdate,$todate,$objPHPExcel);

			for($fj=0;$fj<$faclen;$fj++)
				$feestotal += $facility_total[$fac[$fj]["name"]];
			$feestotal += $facility_total["Pacakges"];
			$feestotal += $facility_total["Registration"];

			/* facility array will be complete */
			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Balance sheet');
			// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
			$objPHPExcel->addSheet($myWorkSheet, 0);
			/* Set active sheet */
			$objPHPExcel->setActiveSheetIndexByName('Balance sheet');
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
						->setOddHeader('&C&H Balance sheet for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
			/* Add a footer */
			$objPHPExcel->getActiveSheet()
						->getHeaderFooter()
						->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
			/* Decorate the main heading 1 */
			$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(0,1, 'Total Collection of Club'.$faclen.'--'.$fi.'--'.$fj.'--'.sizeof($facility_type));
			$styleArray = array(
				'borders' => array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
						'color' => array('argb' => 'FFFF0000'),
					),
				),
			);
			$myWorkSheet->getStyle('A1:E1')->applyFromArray($styleArray);
			$myWorkSheet->getStyle("A1:E1")
						 ->getAlignment()
						 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			/* Add titles  of the columns */
			/* Fee collection from Facilities */
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(0,2, 'No')
						->setCellValueByColumnAndRow(1,2, 'Facility type')
						->setCellValueByColumnAndRow(2,2, 'From')
						->setCellValueByColumnAndRow(3,2, 'To')
						->setCellValueByColumnAndRow(4,2, 'Total');
			$newArray1 = array_keys($facility_total);
			$newArray2 = array_values($facility_total);
			for($i=0,$j=3;$i<sizeof($facility_type);$i++,$j++){
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(0,$j, ($i+1))
							->setCellValueByColumnAndRow(1,$j, $newArray1[$i])
							->setCellValueByColumnAndRow(2,$j, date('j-M-Y', strtotime($from)))
							->setCellValueByColumnAndRow(3,$j, date('j-M-Y', strtotime($to)))
							->setCellValueByColumnAndRow(4,$j, $newArray2[$i]);
			}
			// /* Package collection from Facilities */
			// $i += 1;
			// $objPHPExcel->getActiveSheet()
						// ->setCellValueByColumnAndRow(0,$j, $i)
						// ->setCellValueByColumnAndRow(1,$j, 'Packages')
						// ->setCellValueByColumnAndRow(2,$j, date('j-M-Y', strtotime($from)))
						// ->setCellValueByColumnAndRow(3,$j, date('j-M-Y', strtotime($to)))
						// ->setCellValueByColumnAndRow(4,$j, $packagetotal);
			/* Total collection */
			$j += 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3,$j,'Total collection')
						->setCellValueByColumnAndRow(4,$j, ($feestotal));
			$j += 2;
			$i += 1;
			/* Decorate the main heading 2 */
			$objPHPExcel->getActiveSheet()->mergeCells("A".$j.":E".$j);
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(0,$j, 'Total Deduction of Club');
			$styleArray = array(
				'borders' => array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
						'color' => array('argb' => 'FFFF0000'),
					),
				),
			);
			$myWorkSheet->getStyle("A".$j.":E".$j)->applyFromArray($styleArray);
			$myWorkSheet->getStyle("A".$j.":E".$j)
						 ->getAlignment()
						 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			/* Add titles  of the columns */
			$j += 1;
			$i += 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(0,$j, 'No')
						->setCellValueByColumnAndRow(1,$j, 'Type')
						->setCellValueByColumnAndRow(2,$j, 'From')
						->setCellValueByColumnAndRow(3,$j, 'To')
						->setCellValueByColumnAndRow(4,$j, 'Total');

			/* Expenses */
			$j += 1;
			$i = 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(0,$j, $i)
						->setCellValueByColumnAndRow(1,$j, 'Expenses')
						->setCellValueByColumnAndRow(2,$j, date('j-M-Y', strtotime($from)))
						->setCellValueByColumnAndRow(3,$j, date('j-M-Y', strtotime($to)))
						->setCellValueByColumnAndRow(4,$j, $expensestotal);
			/* Payments */
			$j += 1;
			$i += 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(0,$j, $i)
						->setCellValueByColumnAndRow(1,$j, 'Paymnets')
						->setCellValueByColumnAndRow(2,$j, date('j-M-Y', strtotime($from)))
						->setCellValueByColumnAndRow(3,$j, date('j-M-Y', strtotime($to)))
						->setCellValueByColumnAndRow(4,$j, $paymentstotal);

			/* Total deduction */
			$j += 1;
			$i += 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3,$j, 'Total Deduction')
						->setCellValueByColumnAndRow(4,$j, ($paymentstotal+$expensestotal));

			/* Total collection */
			$j += 2;
			$i += 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3,$j,'Total collection')
						->setCellValueByColumnAndRow(4,$j, ($feestotal));
			/* Total deduction */
			$j += 1;
			$i += 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3,$j, 'Total Deduction')
						->setCellValueByColumnAndRow(4,$j, ($paymentstotal+$expensestotal));

			/* Balance */
			$j += 1;
			$i += 1;
			$balance = ($feestotal) - ($paymentstotal+$expensestotal);
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3,$j, 'Balance')
						->setCellValueByColumnAndRow(4,$j, $balance);

			/* Setting a column’s width */
			foreach(range('A','Z') as $columnID) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
					->setAutoSize(true);
			}
			$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
										 ->setLastModifiedBy($this->parameters["GYMNAME"])
										 ->setTitle("Balance Sheet")
										 ->setSubject("Accounts calculations")
										 ->setDescription("Report generated by CMS (Club Management System) Powered By MadMec.")
										 ->setKeywords("MadMec")
										 ->setCategory("Reports");
			/* 4.6.12.	Center a page horizontally/vertically */
			$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
			/* 4.6.33.	Group/outline a row */
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$callStartTime = microtime(true);
			$filename = $this->parameters["GYMNAME"].'_'.$objPHPExcel->getProperties()->getTitle().'_'.date('j-M-Y').'_'. date('j-M-Y', strtotime($from)) .'_'.date('j-M-Y', strtotime($to)).'_'.$callStartTime.'.xlsx';
			$objWriter->save(DOC_ROOT.DOWNLOADS.$filename);
			unset($objWriter);
			unset($objPHPExcel);
			echo '<center><h3>Click on below link to download</h3><h4><a target="_blank" href="'.URL.DOWNLOADS.$filename.'">'.$filename.'</a></h4></center>';
		}

	}
	public function FeeReport($from,$to,$fromdate,$todate,$objPHPExcel,$fid,$fnm){
		$from=$from;
		$to=$to;
		$fromdate=$fromdate;
		$todate=$todate;
		$fname=$fnm;
		$fct_id=$fid;
		$flag = false;
		$res = '';
		$feefields = array();
		$atotal = 0;
		$ototal = 0;
		$ptotal = 0;
		$dtotal = 0;
		if($fromdate != 0 || $todate != 0){
			$query = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$query ='SELECT
			b.`name`,
			b.`email` AS email,
			a.`customer_pk` AS user_id,
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
			) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE "%'.$fname.'%"
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
			WHERE mtr.`transaction_type` LIKE "%'.$fname.'%"
			GROUP BY(mtr.`receipt_no`)
		) AS mo_tr
			ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
			AND a.`id` = mo_tr.`action_id`
			AND a.`customer_pk` = mo_tr.`mt_uid`
		WHERE STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\', \'%Y-%m-%d\')
				AND STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\', \'%Y-%m-%d\')
		AND c.`facility_id` = "'.$fct_id.'"';
			}


			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
					$query ='SELECT
			b.`name`,
			b.`email` AS email,
			a.`customer_pk` AS user_id,
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
																		AND `status` = \'show\')
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
			) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE "%'.$fname.'%"
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
			WHERE mtr.`transaction_type` LIKE "%'.$fname.'%"
			GROUP BY(mtr.`receipt_no`)
		) AS mo_tr
			ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
			AND a.`id` = mo_tr.`action_id`
			AND a.`customer_pk` = mo_tr.`mt_uid`
		WHERE STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(\''.$onedate.'\',\'%Y-%m-%d\')
		AND c.`facility_id` = "'.$fct_id.'"';
			}

			if($query){
						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							$i=1;
							while($row = mysql_fetch_assoc($res)){
								$feefields[$i]['No'] = $i; 														/* A */
								$feefields[$i]['name'] = $row['name'];											/* B */
								$feefields[$i]['user_id'] = $row['email'];									/* C */
								$feefields[$i]['cell'] = $row['cell'];											/* D */
								$feefields[$i]['offer_name'] = $row['offer_name'];								/* E */
								$feefields[$i]['duration'] = $row['duration'];									/* F */
								$feefields[$i]['facility_type'] = $row['facility_type'];						/* G */
								$feefields[$i]['payment_date'] = date('j-M-Y', strtotime($row['payment_date']));/* H */
								$feefields[$i]['valid_from'] = date('j-M-Y', strtotime($row['valid_from']));	/* I */
								$feefields[$i]['valid_till'] = date('j-M-Y', strtotime($row['valid_till']));	/* J */
								$feefields[$i]['amount'] = $row['oldfee'];										/* K */
								if($row['receipt_no'] != NULL || $row['receipt_no'] != '')
									$feefields[$i]['receipt_no'] = sprintf("%010s",$row['receipt_no']); 		/* L */
								else
									$feefields[$i]['receipt_no'] = NULL;			 							/* L */
								$feefields[$i]['mt_tt'] = $row['mt_tt'];										/* M */
								$feefields[$i]['action_no'] = $row['action_no']; 								/* N */
								$feefields[$i]['total_amt'] = $row['total_amt']; 								/* O */
								if($row['mt_rpt'] != NULL)
									$feefields[$i]['mt_rpt'] = sprintf("%010s",$row['mt_rpt']);	 				/* P */
								else
									$feefields[$i]['mt_rpt'] = $row['mt_rpt'];	 								/* P */
								if($row['receipt_no'] != NULL || $row['receipt_no'] != '')
									$feefields[$i]['inv_urls'] = $row['inv_urls']; 								/* P */
								else
									$feefields[$i]['inv_urls'] = NULL; 											/* P */
								if($row['total_amt'] < $row['cost'] || $row['oldfee'] < $row['cost']){
									if($row['oldfee'] != 0)
										$row['due_amount'] = $row['cost'] - $row['oldfee'];
									else
										$row['due_amount'] = $row['cost'] - $row['total_amt'];
								}
								if($row['cost'] != NULL || $row['cost'] != 0)
									$atotal += $row['cost']; 		/* Actual fee */
								if($row['oldfee'] != NULL || $row['oldfee'] != 0)
									$ototal += $row['oldfee']; 		/* Old fee */
								if($row['total_amt'] != NULL || $row['total_amt'] != 0)
									$ptotal += $row['total_amt'];  	/* Paid fee */
								if($row['due_amount'] != NULL || $row['due_amount'] != 0)
									$dtotal += $row['due_amount'];  /* Due amount */
								$feefields[$i]['due_amount'] = $row['due_amount']; 								/* Q */
								if($row['due_date'] != NULL || $row['due_date'] != '')
									$feefields[$i]['due_date'] = date('j-M-Y', strtotime($row['due_date']));  	/* R */
								else if($row['due_amount'] != 0)
									$feefields[$i]['due_date'] = 'Not provided';
								else
									$feefields[$i]['due_date'] = $row['due_date'];  							/* R */
								$i++;
							}
							$flag = true;
						}
						else
							$feefields = NULL;

				if($feefields != NULL){
					$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, $fname.' fee collection report');
					$headers = array('font'=> array('bold'=> true,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Arial'),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),);
					$sheet=$objPHPExcel->getActiveSheet();
					$rows = 1;
					// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
					$objPHPExcel->addSheet($myWorkSheet, 0);
					/* Set active sheet */
					$objPHPExcel->setActiveSheetIndexByName($fname.' fee collection report');
					$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
												 ->setLastModifiedBy($this->parameters["GYMNAME"])
												 ->setTitle("Fee Collection")
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
								->setOddHeader('&C&H Gym Fee collection report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
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
								->setCellValueByColumnAndRow(0,1, 'No') 						/* A */
								->setCellValueByColumnAndRow(1,1, 'Customer Name') 				/* B */
								->setCellValueByColumnAndRow(2,1, 'Customer E-mail') 			/* C */
								->setCellValueByColumnAndRow(3,1, 'Customer Cell') 				/* D */
								->setCellValueByColumnAndRow(4,1, 'Offer') 						/* E */
								->setCellValueByColumnAndRow(5,1, 'Duration') 					/* F */
								->setCellValueByColumnAndRow(6,1, 'Facility type') 				/* G */
								->setCellValueByColumnAndRow(7,1, 'Payment date') 				/* H */
								->setCellValueByColumnAndRow(8,1, 'Joining Date') 				/* I */
								->setCellValueByColumnAndRow(9,1, 'Expiry date') 				/* J */
								->setCellValueByColumnAndRow(10,1, 'Old fee') 					/* K */
								->setCellValueByColumnAndRow(11,1, 'Old invoice')				/* L */
								->setCellValueByColumnAndRow(12,1, 'Transaction type')			/* M */
								->setCellValueByColumnAndRow(13,1, 'Mode Of Payment')			/* N */
								->setCellValueByColumnAndRow(14,1, 'Paid amt')					/* O */
								->setCellValueByColumnAndRow(15,1, 'Invoice no')				/* P */
								->setCellValueByColumnAndRow(16,1, 'Due amt')					/* Q */
								->setCellValueByColumnAndRow(17,1, 'Due Date');					/* R */
					/*header bold*/
					$sheet->getStyle($rows)->applyFromArray($headers);
					/* Setting a column’s width */
					foreach(range('A','Z') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);
					}
					/* 4.6.12.	Center a page horizontally/vertically */
					$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
					/* 4.6.33.	Group/outline a row */
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
					for($i = 1;$i<=sizeof($feefields);$i++){
						//$feefields[$i]['mt_tt'] = str_replace($fct_id,$fname,$feefields[$i]['mt_tt']);
						$objPHPExcel->getActiveSheet()
									->setCellValueByColumnAndRow(0,($i+1), $feefields[$i]['No'])
									->setCellValueByColumnAndRow(1,($i+1), $feefields[$i]['name'])
									->setCellValueByColumnAndRow(2,($i+1), $feefields[$i]['user_id'])
									->setCellValueByColumnAndRow(3,($i+1), $feefields[$i]['cell'])
									->setCellValueByColumnAndRow(4,($i+1), $feefields[$i]['offer_name'])
									->setCellValueByColumnAndRow(5,($i+1), $feefields[$i]['duration'])
									->setCellValueByColumnAndRow(6,($i+1), $feefields[$i]['facility_type'])
									->setCellValueByColumnAndRow(7,($i+1), $feefields[$i]['payment_date'])
									->setCellValueByColumnAndRow(8,($i+1), $feefields[$i]['valid_from'])
									->setCellValueByColumnAndRow(9,($i+1), $feefields[$i]['valid_till'])
									->setCellValueByColumnAndRow(10,($i+1), $feefields[$i]['amount'])
									->setCellValueByColumnAndRow(12,($i+1), $feefields[$i]['mt_tt'])
									->setCellValueByColumnAndRow(13,($i+1), $feefields[$i]['action_no'])
									->setCellValueByColumnAndRow(14,($i+1), $feefields[$i]['total_amt'])
									->setCellValueByColumnAndRow(16,($i+1), $feefields[$i]['due_amount'])
									->setCellValueByColumnAndRow(17,($i+1), $feefields[$i]['due_date']);
						if($feefields[$i]['receipt_no'] != NULL){
							$objPHPExcel->getActiveSheet()
										->getCellByColumnAndRow(11,($i+1))
										->setValueExplicit($feefields[$i]['receipt_no'], PHPExcel_Cell_DataType::TYPE_STRING2);
						}
						$objPHPExcel->getActiveSheet()
									->getCellByColumnAndRow(15,($i+1))
									->setValueExplicit($feefields[$i]['mt_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2);
						if($feefields[$i]['inv_urls'] != NULL ){
							$objPHPExcel->getActiveSheet()
										->getCellByColumnAndRow(15,($i+1))
										->getHyperlink()
										->setUrl($feefields[$i]['inv_urls']);
						}
					}
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(9,($i+2),'Old fee total')
								->setCellValueByColumnAndRow(10,($i+2),$ototal);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(13,($i+2),'New fee total')
								->setCellValueByColumnAndRow(14,($i+2),$ptotal);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(15,($i+2),'Due amount')
								->setCellValueByColumnAndRow(16,($i+2),$dtotal);

					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(4,($i+4),'Actual fee total')
								->setCellValueByColumnAndRow(5,($i+4),$atotal)
								->setCellValueByColumnAndRow(4,($i+5),'Paid fee total')
								->setCellValueByColumnAndRow(5,($i+5),($ototal))
								->setCellValueByColumnAndRow(4,($i+6),'Due')
								->setCellValueByColumnAndRow(5,($i+6),($atotal - $ototal));
				}
			}
		}
		return $ototal;
	}
	public function PackageReport(){
		$from=$this->parameters["from"];
		$to=$this->parameters["to"];
		$fromdate=$this->parameters["fromdate"];
		$todate=$this->parameters["todate"];

		$flag = false;
		$res = '';
		$feefields = array();
		$atotal = 0; 		/* Actual fee */
		$ototal = 0; 		/* Old fee */
		$ptotal = 0;  		/* Paid fee */
		$dtotal = 0;  		/* Due amount */
		if($fromdate != 0 && $todate != 0){
			$query = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$query = 'SELECT
							b.`name`,
							b.`email`,
							a.`customer_pk`,
							CONCAT(\'+91 \',b.`cell_number`) AS cell,
							cpknm.`package_name` AS `pack_name`,
							c.`number_of_sessions` AS `sessions`,
							STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') AS `payment_date`,
							CONCAT(c.`package_type_id`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`) AS tran_type,
							a.`amount` AS oldfee,
							a.`receipt_no`,
							c.`cost` AS actfee,
							mo_tr.`mt_pk`,
							mo_tr.`mt_uid`,
							mo_tr.`mopid`,
							mo_tr.`mt_pod`,
							mo_tr.`mt_tt`,
							mo_tr.`mt_rpt`,
							mo_tr.`mop`,
							mo_tr.`action_id`,
							mo_tr.`action_no`,
							mo_tr.`ind_amt`,
							mo_tr.`total_amt`,
							mo_tr.`inv_users`,
							mo_tr.`inv_urls`,
							mo_tr.`due_amount`,
							mo_tr.`due_date`,
							mo_tr.`due_user`,
							mo_tr.`due_status`
						FROM `fee_packages` AS a
						INNER JOIN `customer` AS b ON a.`customer_pk` = b.`id`
						INNER JOIN `packages` AS c ON a.`package_id` = c.`id`
						LEFT JOIN `package_name` AS cpknm ON  c.`package_type_id` = cpknm.`id`
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
																			AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))
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
								SELECT packnm.`package_name` AS package_id,
										pks.`number_of_sessions`,
										pks.`cost`
										FROM `packages` AS pks
									LEFT JOIN `package_name` AS packnm ON  pks.`package_type_id` = packnm.`id`
							)AS pack ON  mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
							LEFT JOIN (
								SELECT
									GROUP_CONCAT(`customer_pk`) AS inv_users,
									GROUP_CONCAT(`location`) AS inv_urls,
									`transaction_id`,
									`name`
								FROM `invoice`
								GROUP BY(`transaction_id`)
							) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
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
							WHERE mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
							GROUP BY(mtr.`receipt_no`)
							ORDER BY(mtr.`id`)
						) AS mo_tr
							ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
							AND a.`id` = mo_tr.`action_id`
							AND a.`customer_pk` = mo_tr.`mt_uid`
						WHERE mo_tr.`mt_tt` = CONCAT(cpknm.`package_name`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`)
						AND STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\', \'%Y-%m-%d\')
						AND STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\', \'%Y-%m-%d\');';
			}
			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
					$query = 'SELECT
							b.`name`,
							b.`email`,
							a.`customer_pk`,
							CONCAT(\'+91 \',b.`cell_number`) AS cell,
							cpknm.`package_name` AS `pack_name`,
							c.`number_of_sessions` AS `sessions`,
							STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') AS `payment_date`,
							CONCAT(c.`package_type_id`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`) AS tran_type,
							a.`amount` AS oldfee,
							a.`receipt_no`,
							c.`cost` AS actfee,
							mo_tr.`mt_pk`,
							mo_tr.`mt_uid`,
							mo_tr.`mopid`,
							mo_tr.`mt_pod`,
							mo_tr.`mt_tt`,
							mo_tr.`mt_rpt`,
							mo_tr.`mop`,
							mo_tr.`action_id`,
							mo_tr.`action_no`,
							mo_tr.`ind_amt`,
							mo_tr.`total_amt`,
							mo_tr.`inv_users`,
							mo_tr.`inv_urls`,
							mo_tr.`due_amount`,
							mo_tr.`due_date`,
							mo_tr.`due_user`,
							mo_tr.`due_status`
						FROM `fee_packages` AS a
						INNER JOIN `customer` AS b ON a.`customer_pk` = b.`id`
						INNER JOIN `packages` AS c ON a.`package_id` = c.`id`
						LEFT JOIN `package_name` AS cpknm ON  c.`package_type_id` = cpknm.`id`
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
																			AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))
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
								SELECT packnm.`package_name` AS package_id,
										pks.`number_of_sessions`,
										pks.`cost`
										FROM `packages` AS pks
									LEFT JOIN `package_name` AS packnm ON  pks.`package_type_id` = packnm.`id`
							)AS pack ON  mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
							LEFT JOIN (
								SELECT
									GROUP_CONCAT(`customer_pk`) AS inv_users,
									GROUP_CONCAT(`location`) AS inv_urls,
									`transaction_id`,
									`name`
								FROM `invoice`
								GROUP BY(`transaction_id`)
							) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
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
							WHERE mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
							GROUP BY(mtr.`receipt_no`)
							ORDER BY(mtr.`id`)
						) AS mo_tr
							ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
							AND a.`id` = mo_tr.`action_id`
							AND a.`customer_pk` = mo_tr.`mt_uid`
						WHERE mo_tr.`mt_tt` = CONCAT(cpknm.`package_name`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`)
						AND STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(\''.$onedate.'\', \'%Y-%m-%d\');';
			}
			if($query){
						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							$i=1;
							while($row = mysql_fetch_assoc($res)){
								$feefields[$i]['No'] = $i; 															/* A */
								$feefields[$i]['name'] = $row['name'];												/* B */
								$feefields[$i]['user_id'] = $row['email'];											/* C */
								$feefields[$i]['cell'] = $row['cell'];												/* D */
								$feefields[$i]['pack_name'] = $row['pack_name'];									/* E */
								$feefields[$i]['sessions'] = $row['sessions'];										/* F */
								$feefields[$i]['payment_date'] = date('j-M-Y', strtotime($row['payment_date']));	/* G */

								// $feefields[$i]['oldfee'] = $row['oldfee'];										/* H */
								// if($row['receipt_no'] != NULL || $row['receipt_no'] != '0' || $row['receipt_no'] != '')
									// $feefields[$i]['receipt_no'] = sprintf("%010s",$row['receipt_no']); 			/* I */
								// else
									// $feefields[$i]['receipt_no'] = NULL; 										/* I */

								$feefields[$i]['mt_tt'] = $row['mt_tt'];											/* J */
								$feefields[$i]['action_no'] = $row['action_no']; 									/* K */
								$feefields[$i]['total_amt'] = $row['total_amt']; 									/* L */
								if($row['mt_rpt'] != NULL)
									$feefields[$i]['mt_rpt'] = sprintf("%010s",$row['mt_rpt']);	 					/* M */
								else
									$feefields[$i]['mt_rpt'] = $row['mt_rpt'];	 									/* M */
								$feefields[$i]['inv_urls'] = $row['inv_urls']; 										/* M */
								if($row['total_amt'] < $row['actfee'] || $row['oldfee'] < $row['actfee']){
									if($row['oldfee'] != 0)
										$row['due_amount'] = $row['actfee'] - $row['oldfee'];
									else
										$row['due_amount'] = $row['actfee'] - $row['total_amt'];
								}
								if($row['actfee'] != NULL || $row['actfee'] != 0)
									$atotal += $row['actfee']; 		/* Actual fee */
								if($row['oldfee'] != NULL || $row['oldfee'] != 0)
									$ototal += $row['oldfee']; 		/* Old fee */
								if($row['total_amt'] != NULL || $row['total_amt'] != 0)
									$ptotal += $row['total_amt'];  	/* Paid fee */
								if($row['due_amount'] != NULL || $row['due_amount'] != 0)
									$dtotal += $row['due_amount'];  /* Due amount */
								$feefields[$i]['due_amount'] = $row['due_amount']; 								/* Q */
								if($row['due_date'] != NULL || $row['due_date'] != '')
									$feefields[$i]['due_date'] = date('j-M-Y', strtotime($row['due_date']));  	/* R */
								else if($row['due_amount'] != 0)
									$feefields[$i]['due_date'] = 'Not provided';
								else
									$feefields[$i]['due_date'] = $row['due_date'];  							/* R */
								$i++;
							}
							$flag = true;
						}
						else
							$feefields = NULL;

				if($feefields != NULL){
					$objPHPExcel = new PHPExcel();
					$headers = array('font'=> array('bold'=> true,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Arial'),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),);
					$sheet=$objPHPExcel->getActiveSheet();
					$rows = 1;
					$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
												 ->setLastModifiedBy($this->parameters["GYMNAME"])
												 ->setTitle("Package Fee Collection")
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
								->setOddHeader('&C&H Package Fee collection report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
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
								->setCellValueByColumnAndRow(0,1, 'No') 					/* A */
								->setCellValueByColumnAndRow(1,1, 'Customer Name') 			/* B */
								->setCellValueByColumnAndRow(2,1, 'Customer E-mail') 		/* C */
								->setCellValueByColumnAndRow(3,1, 'Customer Cell') 			/* D */
								->setCellValueByColumnAndRow(4,1, 'Package Name') 			/* E */
								->setCellValueByColumnAndRow(5,1, 'Sessions') 				/* F */
								->setCellValueByColumnAndRow(6,1, 'Payment date') 			/* G */
								// ->setCellValueByColumnAndRow(7,1, 'Old fee') 			/* H */
								// ->setCellValueByColumnAndRow(8,1, 'Old invoice') 		/* I */
								->setCellValueByColumnAndRow(7,1, 'Transaction type') 		/* J */
								->setCellValueByColumnAndRow(8,1, 'Mode Of Payment') 		/* K */
								->setCellValueByColumnAndRow(9,1, 'Paid fee') 				/* L */
								->setCellValueByColumnAndRow(10,1, 'Invoice no') 			/* M */
								->setCellValueByColumnAndRow(11,1, 'Due amt') 				/* N */
								->setCellValueByColumnAndRow(12,1, 'Due Date'); 			/* O */
					/*header bold*/
					$sheet->getStyle($rows)->applyFromArray($headers);
					/* Setting a column’s width */
					foreach(range('A','Z') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);
					}
					/* 4.6.12.	Center a page horizontally/vertically */
					$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
					/* 4.6.33.	Group/outline a row */
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
					for($i = 1;$i<=sizeof($feefields);$i++){
						$objPHPExcel->getActiveSheet()
									->setCellValueByColumnAndRow(0,($i+1), $feefields[$i]['No']) 			/* A */
									->setCellValueByColumnAndRow(1,($i+1), $feefields[$i]['name']) 			/* B */
									->setCellValueByColumnAndRow(2,($i+1), $feefields[$i]['user_id']) 		/* C */
									->setCellValueByColumnAndRow(3,($i+1), $feefields[$i]['cell']) 			/* D */
									->setCellValueByColumnAndRow(4,($i+1), $feefields[$i]['pack_name']) 	/* E */
									->setCellValueByColumnAndRow(5,($i+1), $feefields[$i]['sessions']) 		/* F */
									->setCellValueByColumnAndRow(6,($i+1), $feefields[$i]['payment_date']) 	/* G */
									// ->setCellValueByColumnAndRow(7,($i+1), $feefields[$i]['oldfee']) 	/* H */
									->setCellValueByColumnAndRow(7,($i+1), $feefields[$i]['mt_tt']) 		/* J */
									->setCellValueByColumnAndRow(8,($i+1), $feefields[$i]['action_no']) 	/* K */
									->setCellValueByColumnAndRow(9,($i+1), $feefields[$i]['total_amt']) 	/* L */
									->setCellValueByColumnAndRow(11,($i+1), $feefields[$i]['due_amount']) 	/* N */
									->setCellValueByColumnAndRow(12,($i+1), $feefields[$i]['due_date']); 	/* O */
						// if($feefields[$i]['receipt_no'])
							// $objPHPExcel->getActiveSheet()
										// ->getCellByColumnAndRow(8,($i+1))
										// ->setValueExplicit($feefields[$i]['receipt_no'], PHPExcel_Cell_DataType::TYPE_STRING2); /* I */

						$objPHPExcel->getActiveSheet()
									->getCellByColumnAndRow(10,($i+1))
									->setValueExplicit($feefields[$i]['mt_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2); 		/* M */

						if($feefields[$i]['inv_urls'] != NULL || $feefields[$i]['inv_urls'] != ''){
							$objPHPExcel->getActiveSheet()
										->getCellByColumnAndRow(10,($i+1))
										->getHyperlink()
										->setUrl($feefields[$i]['inv_urls']); 													/* M */
						}
					}
					// $objPHPExcel->getActiveSheet()
								// ->setCellValueByColumnAndRow(6,($i+2),'Old fee total')
								// ->setCellValueByColumnAndRow(7,($i+2),$ototal);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(8,($i+2),'Paid fee total')
								->setCellValueByColumnAndRow(9,($i+2),$ptotal);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(10,($i+2),'Due fee total')
								->setCellValueByColumnAndRow(11,($i+2),$dtotal);

					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(4,($i+4),'Actual fee total')
								->setCellValueByColumnAndRow(5,($i+4),$atotal)
								->setCellValueByColumnAndRow(4,($i+5),'Paid fee total')
								->setCellValueByColumnAndRow(5,($i+5),$ptotal)
								->setCellValueByColumnAndRow(4,($i+6),'Balance')
								->setCellValueByColumnAndRow(5,($i+6),($atotal - $ptotal));
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
					$filename = $this->parameters["GYMNAME"].'_'.$objPHPExcel->getProperties()->getTitle().'_'.date('j-M-Y').'_'. date('j-M-Y', strtotime($from)) .'_'.date('j-M-Y', strtotime($to)).'_'.$callStartTime.'.xlsx';
					$objWriter->save(DOC_ROOT.DOWNLOADS.$filename);
					unset($objWriter);
					unset($objPHPExcel);
					echo '<center><h3>Click on below link to download</h3><h4><a target="_blank" href="'.URL.DOWNLOADS.$filename.'">'.$filename.'</a></h4></center>';
				}
			}
		}if(!$flag){
			echo '<center><h2>No records found!!!</h2></center>';
		}
	}
	public function CustomerAttendanceReport(){
		$from=$this->parameters["from"];
		$to=$this->parameters["to"];
		$fromdate=$this->parameters["fromdate"];
		$todate=$this->parameters["todate"];

		$flag = false;
		$res = '';
		$cattendancefields = array();
		$total = 0;
		if($fromdate != 0 || $todate != 0){
			$query = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$query = 'SELECT d.`id`,
								 a.`name`,
								 a.`email`,
								 d.`customer_pk` AS user_id,
								 a.`cell_number`,
								 d.`in_time`,
								 d.`facility_id`,
								 fct.`name` AS facility_type,
								 c.`name` AS offer,
								 c.`duration_id` ,
								 ofd.`duration`  AS duration,
							STR_TO_DATE(b.`valid_from`,\'%Y-%m-%d\') AS from_date,
							STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\') AS to_date,
							COUNT(DISTINCT(STR_TO_DATE(d.`in_time`,\'%Y-%m-%d\'))) AS attended_days,
							DATEDIFF(STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\'),STR_TO_DATE(\''.$from.'\',\'%Y-%m-%d\')) AS total_days
							FROM  `customer` AS a
							LEFT JOIN  `group_members` AS gm ON a.`id` =  gm.`customer_pk`
							LEFT JOIN  `groups` AS gr ON gr.`id` =  gm.`group_id`
							INNER JOIN  `fee` AS b ON a.`id` = b.`customer_pk`
							INNER JOIN  `offers` AS c ON b.`offer_id` = c.`id`
							INNER JOIN  `customer_attendence` AS d ON d.`customer_pk` =  a.`id` AND d.`facility_id` = c.`facility_id`
							INNER JOIN `facility` AS  fct ON d.`facility_id`=fct.`id`
							INNER JOIN `offerduration` AS ofd ON c.`duration_id`= ofd.`id`
							WHERE a.`id` =  b.`customer_pk` OR gr.`owner` =  b.`customer_pk`
							AND b.`customer_pk` =  d.`customer_pk`
							AND STR_TO_DATE(d.`in_time`,\'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\',\'%Y-%m-%d\')
							AND STR_TO_DATE(d.`in_time`,\'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\')
							GROUP BY(d.`customer_pk`)
							ORDER BY d.`id` DESC;';
			}
			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
				$query = 'SELECT d.`id`,
								 a.`name`,
								 a.`email`,
								 d.`customer_pk` AS user_id,
								 a.`cell_number`,
								 d.`in_time`,
								 d.`facility_id` AS facility_type,
								 c.`name` AS offer,
								 c.`duration_id`,
								 fct.`name` AS facility_type,
								 ofd.`duration`  AS duration,
							STR_TO_DATE(b.`valid_from`,\'%Y-%m-%d\') AS from_date,
							STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\') AS to_date,
							COUNT(DISTINCT(STR_TO_DATE(d.`in_time`,\'%Y-%m-%d\'))) AS attended_days,
							DATEDIFF(STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\'),STR_TO_DATE(\''.$from.'\',\'%Y-%m-%d\')) AS total_days
							FROM  `customer` AS a
							LEFT JOIN  `group_members` AS gm ON a.`id` =  gm.`customer_pk`
							LEFT JOIN  `groups` AS gr ON gr.`id` =  gm.`group_id`
							INNER JOIN  `fee` AS b ON a.`id` = b.`customer_pk`
							INNER JOIN  `offers` AS c ON b.`offer_id` = c.`id`
							INNER JOIN  `customer_attendence` AS d ON d.`customer_pk` =  a.`id` AND d.`facility_id` = c.`facility_id`
							INNER JOIN `facility` AS  fct ON d.`facility_id`=fct.`id`
							INNER JOIN `offerduration` AS ofd ON c.`duration_id`= ofd.`id`
							WHERE a.`id` =  b.`customer_pk` OR gr.`owner` =  b.`customer_pk`
							AND b.`customer_pk` =  d.`customer_pk`
							AND STR_TO_DATE(d.`in_time`,\'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\',\'%Y-%m-%d\')
							AND STR_TO_DATE(d.`in_time`,\'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\')
							GROUP BY(d.`customer_pk`)
							ORDER BY d.`id` DESC;
						';
			}
			if($query){

						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							$i=1;
							while($row = mysql_fetch_assoc($res)){
								$cattendancefields[$i]['No'] = $i; /* A */
								$cattendancefields[$i]['name'] = $row['name']; /* B */
								$cattendancefields[$i]['email'] = $row['email']; /* C */
								$cattendancefields[$i]['facility_type'] = $row['facility_type']; /* D */
								$cattendancefields[$i]['offer'] = $row['offer']; /* E */
								$cattendancefields[$i]['duration'] = $row['duration']; /* F */
								$cattendancefields[$i]['attended_days'] = $row['attended_days']; /* G */
								$cattendancefields[$i]['total_days'] = $row['total_days'];  /* H */
								$i++;
							}
							$flag = true;
						}
						else
							$cattendancefields = NULL;

				if($cattendancefields != NULL){
					$objPHPExcel = new PHPExcel();
					$headers = array('font'=> array('bold'=> true,'color' => array('rgb' => '000000'),'size'  => 10,'name'  => 'Arial'),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),);
					$sheet=$objPHPExcel->getActiveSheet();
					$rows = 1;
					$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
												 ->setLastModifiedBy($this->parameters["GYMNAME"])
												 ->setTitle("Customer attendance report")
												 ->setSubject("Attendance Report")
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
								->setOddHeader('&C&H Customer attendance report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
					/* Add a footer */
					$objPHPExcel->getActiveSheet()
								->getHeaderFooter()
								->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
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
								->setCellValueByColumnAndRow(0,1, 'No')
								->setCellValueByColumnAndRow(1,1, 'Name')
								->setCellValueByColumnAndRow(2,1, 'Email Id')
								->setCellValueByColumnAndRow(3,1, 'Facility type')
								->setCellValueByColumnAndRow(4,1, 'Offer')
								->setCellValueByColumnAndRow(5,1, 'Duration')
								->setCellValueByColumnAndRow(6,1, 'Attendance')
								->setCellValueByColumnAndRow(7,1, 'Total');
								/*header bold*/
				$sheet->getStyle($rows)->applyFromArray($headers);
					/* Setting a column’s width */
					foreach(range('A','H') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);
					}
					/* 4.6.12.	Center a page horizontally/vertically */
					$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
					/* 4.6.33.	Group/outline a row */
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
					for($i = 1;$i<=sizeof($cattendancefields);$i++){
						$objPHPExcel->getActiveSheet()
									->setCellValueByColumnAndRow(0,($i+1), $cattendancefields[$i]['No'])
									->setCellValueByColumnAndRow(1,($i+1), $cattendancefields[$i]['name'])
									->setCellValueByColumnAndRow(2,($i+1), $cattendancefields[$i]['email'])
									->setCellValueByColumnAndRow(3,($i+1), $cattendancefields[$i]['facility_type'])
									->setCellValueByColumnAndRow(4,($i+1), $cattendancefields[$i]['offer'])
									->setCellValueByColumnAndRow(5,($i+1), $cattendancefields[$i]['duration'])
									->setCellValueByColumnAndRow(6,($i+1), $cattendancefields[$i]['attended_days'])
									->setCellValueByColumnAndRow(7,($i+1), $cattendancefields[$i]['total_days']);
					}
					/*header bold*/
					$sheet->getStyle($rows)->applyFromArray($headers);
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$callStartTime = microtime(true);
					$filename = $this->parameters["GYMNAME"].'_'.$objPHPExcel->getProperties()->getTitle().'_'.date('j-M-Y').'_'. date('j-M-Y', strtotime($from)) .'_'.date('j-M-Y', strtotime($to)).'_'.$callStartTime.'.xlsx';
					$objWriter->save(DOC_ROOT.DOWNLOADS.$filename);
					unset($objWriter);
					unset($objPHPExcel);
					echo '<center><h3>Click on below link to download</h3><h4><a target="_blank" href="'.URL.DOWNLOADS.$filename.'">'.$filename.'</a></h4></center>';
				}
			}
		}
		if(!$flag){
			echo '<center><h2>No records found!!!</h2></center>';
		}
	}
	public function TrainerAttendanceReport(){
		$from=$this->parameters["from"];
		$to=$this->parameters["to"];
		$fromdate=$this->parameters["fromdate"];
		$todate=$this->parameters["todate"];
		$flag = false;
		$res = '';
		$tattendancefields = array();
		$total = 0;
		if($fromdate != 0 || $todate != 0){
			$query = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$query = 'SELECT b.`id`,
								 a.`user_name`,
								 a.`email`,
								 a.`cell_number`,
								 b.`in_time`,
								 b.`facility_id`,
								 fct.`name` AS facility_type,

							COUNT(DISTINCT(STR_TO_DATE(b.`in_time`,\'%Y-%m-%d\'))) AS attended_days,
							DATEDIFF(STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\'),STR_TO_DATE(\''.$from.'\',\'%Y-%m-%d\')) AS total_days
							FROM  `employee` AS a
							LEFT JOIN  `employee_attendence` AS b ON b.`employee_id` =  a.`id`
							INNER JOIN `facility` AS  fct ON b.`facility_id`=fct.`id`
							WHERE STR_TO_DATE(b.`in_time`,\'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\',\'%Y-%m-%d\')
							AND STR_TO_DATE(b.`in_time`,\'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\',\'%Y-%m-%d\');';
			}
			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
				$query = 'SELECT  b.`id`,
								  a.`user_name`,
								  a.`email`,
								  a.`cell_number`,
								  b.`in_time`,
								  b.`facility_id`,
								  fct.`name` AS facility_type,

							COUNT(DISTINCT(STR_TO_DATE(b.`in_time`,\'%Y-%m-%d\'))) AS attended_days,
							DATEDIFF(STR_TO_DATE(\''.$onedate.'\',\'%Y-%m-%d\'),STR_TO_DATE(\''.$onedate.'\',\'%Y-%m-%d\')) AS total_days
							FROM  `employee` AS a
							LEFT JOIN  `employee_attendence` AS b ON b.`employee_id` =  a.`id`
							INNER JOIN `facility` AS  fct ON b.`facility_id`=fct.`id`
							WHERE  STR_TO_DATE(\''.$onedate.'\',\'%Y-%m-%d\') = STR_TO_DATE(b.`in_time`,\'%Y-%m-%d\');';
			}
			if($query){
						$res = executeQuery($query);
						if(mysql_num_rows($res)){
							$i=1;
							while($row = mysql_fetch_assoc($res)){
								$tattendancefields[$i]['No'] = $i; /* A */
								$tattendancefields[$i]['user_name'] = $row['user_name']; /* B */
								$tattendancefields[$i]['email'] = $row['email']; /* C */
								$tattendancefields[$i]['facility_type'] = $row['facility_type']; /* D */
								$tattendancefields[$i]['attended_days'] = $row['attended_days']; /* E */
								$tattendancefields[$i]['total_days'] = $row['total_days'];  /* F */
								$i++;
							}
							$flag = true;
						}
						else
							$tattendancefields = NULL;
				if($tattendancefields != NULL){
					$objPHPExcel = new PHPExcel();
					$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
												 ->setLastModifiedBy($this->parameters["GYMNAME"])
												 ->setTitle("Trainer attendance report")
												 ->setSubject("Attendance Report")
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
								->setOddHeader('&C&H Trainer attendance report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
					/* Add a footer */
					$objPHPExcel->getActiveSheet()
								->getHeaderFooter()
								->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
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
								->setCellValueByColumnAndRow(0,1, 'No')
								->setCellValueByColumnAndRow(1,1, 'Name')
								->setCellValueByColumnAndRow(2,1, 'Email Id')
								->setCellValueByColumnAndRow(3,1, 'Facility type')
								->setCellValueByColumnAndRow(4,1, 'Attendance')
								->setCellValueByColumnAndRow(5,1, 'Total');
					/* Setting a column’s width */
					foreach(range('A','F') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);
					}
					/* 4.6.12.	Center a page horizontally/vertically */
					$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
					/* 4.6.33.	Group/outline a row */
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
					for($i = 1;$i<=sizeof($tattendancefields);$i++){
						$objPHPExcel->getActiveSheet()
									->setCellValueByColumnAndRow(0,($i+1), $tattendancefields[$i]['No'])
									->setCellValueByColumnAndRow(1,($i+1), $tattendancefields[$i]['user_name'])
									->setCellValueByColumnAndRow(2,($i+1), $tattendancefields[$i]['email'])
									->setCellValueByColumnAndRow(3,($i+1), $tattendancefields[$i]['facility_type'])
									->setCellValueByColumnAndRow(4,($i+1), $tattendancefields[$i]['attended_days'])
									->setCellValueByColumnAndRow(5,($i+1), $tattendancefields[$i]['total_days']);
					}
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$callStartTime = microtime(true);
					$filename = $this->parameters["GYMNAME"].'_'.$objPHPExcel->getProperties()->getTitle().'_'.date('j-M-Y').'_'. date('j-M-Y', strtotime($from)) .'_'.date('j-M-Y', strtotime($to)).'_'.$callStartTime.'.xlsx';
					$objWriter->save(DOC_ROOT.DOWNLOADS.$filename);
					unset($objWriter);
					unset($objPHPExcel);
					echo '<center><h3>Click on below link to download</h3><h4><a target="_blank" href="'.URL.DOWNLOADS.$filename.'">'.$filename.'</a></h4></center>';
				}
			}
		}
		if(!$flag){
			echo '<center><h2>No records found!!!</h2></center>';
		}
	}
	/* Packages */
	public function balPackageReport($from,$to,$fromdate,$todate,$objPHPExcel){
		$atotal = 0; 		/* Actual fee */
		$ototal = 0; 		/* Old fee */
		$ptotal = 0;  		/* Paid fee */
		$dtotal = 0;  		/* Due amount */
		if($fromdate != 0 && $todate != 0){
			$query = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$query = 'SELECT
							b.`name`,
							b.`email`,
							a.`customer_pk`,
							CONCAT(\'+91 \',b.`cell_number`) AS cell,
							cpknm.`package_name` AS `pack_name`,
							c.`number_of_sessions` AS `sessions`,
							STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') AS `payment_date`,
							CONCAT(c.`package_type_id`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`) AS tran_type,
							a.`amount` AS oldfee,
							a.`receipt_no`,
							c.`cost` AS actfee,
							mo_tr.`mt_pk`,
							mo_tr.`mt_uid`,
							mo_tr.`mopid`,
							mo_tr.`mt_pod`,
							mo_tr.`mt_tt`,
							mo_tr.`mt_rpt`,
							mo_tr.`mop`,
							mo_tr.`action_id`,
							mo_tr.`action_no`,
							mo_tr.`ind_amt`,
							mo_tr.`total_amt`,
							mo_tr.`inv_users`,
							mo_tr.`inv_urls`,
							mo_tr.`due_amount`,
							mo_tr.`due_date`,
							mo_tr.`due_user`,
							mo_tr.`due_status`
						FROM `fee_packages` AS a
						INNER JOIN `customer` AS b ON a.`customer_pk` = b.`id`
						INNER JOIN `packages` AS c ON a.`package_id` = c.`id`
						LEFT JOIN `package_name` AS cpknm ON  c.`package_type_id` = cpknm.`id`
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
																			AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))
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
								SELECT packnm.`package_name` AS package_id,
										pks.`number_of_sessions`,
										pks.`cost`
										FROM `packages` AS pks
									LEFT JOIN `package_name` AS packnm ON  pks.`package_type_id` = packnm.`id`
							)AS pack ON  mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
							LEFT JOIN (
								SELECT
									GROUP_CONCAT(`customer_pk`) AS inv_users,
									GROUP_CONCAT(`location`) AS inv_urls,
									`transaction_id`,
									`name`
								FROM `invoice`
								GROUP BY(`transaction_id`)
							) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
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
							WHERE mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
							GROUP BY(mtr.`receipt_no`)
							ORDER BY(mtr.`id`)
						) AS mo_tr
							ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
							AND a.`id` = mo_tr.`action_id`
							AND a.`customer_pk` = mo_tr.`mt_uid`
						WHERE mo_tr.`mt_tt` = CONCAT(cpknm.`package_name`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`)
						AND STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\', \'%Y-%m-%d\')
						AND STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\', \'%Y-%m-%d\');';
			}
			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
					$query = 'SELECT
							b.`name`,
							b.`email`,
							a.`customer_pk`,
							CONCAT(\'+91 \',b.`cell_number`) AS cell,
							cpknm.`package_name` AS `pack_name`,
							c.`number_of_sessions` AS `sessions`,
							STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') AS `payment_date`,
							CONCAT(c.`package_type_id`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`) AS tran_type,
							a.`amount` AS oldfee,
							a.`receipt_no`,
							c.`cost` AS actfee,
							mo_tr.`mt_pk`,
							mo_tr.`mt_uid`,
							mo_tr.`mopid`,
							mo_tr.`mt_pod`,
							mo_tr.`mt_tt`,
							mo_tr.`mt_rpt`,
							mo_tr.`mop`,
							mo_tr.`action_id`,
							mo_tr.`action_no`,
							mo_tr.`ind_amt`,
							mo_tr.`total_amt`,
							mo_tr.`inv_users`,
							mo_tr.`inv_urls`,
							mo_tr.`due_amount`,
							mo_tr.`due_date`,
							mo_tr.`due_user`,
							mo_tr.`due_status`
						FROM `fee_packages` AS a
						INNER JOIN `customer` AS b ON a.`customer_pk` = b.`id`
						INNER JOIN `packages` AS c ON a.`package_id` = c.`id`
						LEFT JOIN `package_name` AS cpknm ON  c.`package_type_id` = cpknm.`id`
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
																			AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))
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
								SELECT packnm.`package_name` AS package_id,
										pks.`number_of_sessions`,
										pks.`cost`
										FROM `packages` AS pks
									LEFT JOIN `package_name` AS packnm ON  pks.`package_type_id` = packnm.`id`
							)AS pack ON  mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
							LEFT JOIN (
								SELECT
									GROUP_CONCAT(`customer_pk`) AS inv_users,
									GROUP_CONCAT(`location`) AS inv_urls,
									`transaction_id`,
									`name`
								FROM `invoice`
								GROUP BY(`transaction_id`)
							) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
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
							WHERE mtr.`transaction_type` LIKE CONCAT(\'%\',pack.`package_id`,\' - \',pack.`number_of_sessions`,\' - \',pack.`cost`,\'%\')
							GROUP BY(mtr.`receipt_no`)
							ORDER BY(mtr.`id`)
						) AS mo_tr
							ON STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(mo_tr.`mt_pod`, \'%Y-%m-%d\')
							AND a.`id` = mo_tr.`action_id`
							AND a.`customer_pk` = mo_tr.`mt_uid`
						WHERE mo_tr.`mt_tt` = CONCAT(cpknm.`package_name`,\' - \',c.`number_of_sessions`,\' - \',c.`cost`)
							AND STR_TO_DATE(a.`payment_date`, \'%Y-%m-%d\') = STR_TO_DATE(\''.$onedate.'\', \'%Y-%m-%d\');';
			}
			if($query){
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					$i=1;
					while($row = mysql_fetch_assoc($res)){
						$feefields[$i]['No'] = $i; 															/* A */
						$feefields[$i]['name'] = $row['name'];												/* B */
						$feefields[$i]['user_id'] = $row['email'];											/* C */
						$feefields[$i]['cell'] = $row['cell'];												/* D */
						$feefields[$i]['pack_name'] = $row['pack_name'];									/* E */
						$feefields[$i]['sessions'] = $row['sessions'];										/* F */
						$feefields[$i]['payment_date'] = date('j-M-Y', strtotime($row['payment_date']));	/* G */

						// $feefields[$i]['oldfee'] = $row['oldfee'];										/* H */
						// if($row['receipt_no'] != NULL || $row['receipt_no'] != '0' || $row['receipt_no'] != '')
							// $feefields[$i]['receipt_no'] = sprintf("%010s",$row['receipt_no']); 			/* I */
						// else
							// $feefields[$i]['receipt_no'] = NULL; 										/* I */

						$feefields[$i]['mt_tt'] = $row['mt_tt'];											/* J */
						$feefields[$i]['action_no'] = $row['action_no']; 									/* K */
						$feefields[$i]['total_amt'] = $row['total_amt']; 									/* L */
						if($row['mt_rpt'] != NULL)
							$feefields[$i]['mt_rpt'] = sprintf("%010s",$row['mt_rpt']);	 					/* M */
						else
							$feefields[$i]['mt_rpt'] = $row['mt_rpt'];	 									/* M */
						$feefields[$i]['inv_urls'] = $row['inv_urls']; 										/* M */
						if($row['total_amt'] < $row['actfee'] || $row['oldfee'] < $row['actfee']){
							if($row['oldfee'] != 0)
								$row['due_amount'] = $row['actfee'] - $row['oldfee'];
							else
								$row['due_amount'] = $row['actfee'] - $row['total_amt'];
						}
						if($row['actfee'] != NULL || $row['actfee'] != 0)
							$atotal += $row['actfee']; 		/* Actual fee */
						if($row['oldfee'] != NULL || $row['oldfee'] != 0)
							$ototal += $row['oldfee']; 		/* Old fee */
						if($row['total_amt'] != NULL || $row['total_amt'] != 0)
							$ptotal += $row['total_amt'];  	/* Paid fee */
						if($row['due_amount'] != NULL || $row['due_amount'] != 0)
							$dtotal += $row['due_amount'];  /* Due amount */
						$feefields[$i]['due_amount'] = $row['due_amount']; 								/* Q */
						if($row['due_date'] != NULL || $row['due_date'] != '')
							$feefields[$i]['due_date'] = date('j-M-Y', strtotime($row['due_date']));  	/* R */
						else if($row['due_amount'] != 0)
							$feefields[$i]['due_date'] = 'Not provided';
						else
							$feefields[$i]['due_date'] = $row['due_date'];  							/* R */
						$i++;
					}
					$flag = true;
				}
				else
					$feefields = NULL;
				if($feefields != NULL){
					$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Package fee collection report');
					// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
					$objPHPExcel->addSheet($myWorkSheet, 0);
					/* Set active sheet */
					$objPHPExcel->setActiveSheetIndexByName('Package fee collection report');
					$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
												 ->setLastModifiedBy($this->parameters["GYMNAME"])
												 ->setTitle("Package Fee Collection")
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
								->setOddHeader('&C&H Package Fee collection report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
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
								->setCellValueByColumnAndRow(0,1, 'No') 					/* A */
								->setCellValueByColumnAndRow(1,1, 'Customer Name') 			/* B */
								->setCellValueByColumnAndRow(2,1, 'Customer E-mail') 		/* C */
								->setCellValueByColumnAndRow(3,1, 'Customer Cell') 			/* D */
								->setCellValueByColumnAndRow(4,1, 'Package Name') 			/* E */
								->setCellValueByColumnAndRow(5,1, 'Sessions') 				/* F */
								->setCellValueByColumnAndRow(6,1, 'Payment date') 			/* G */
								// ->setCellValueByColumnAndRow(7,1, 'Old fee') 			/* H */
								// ->setCellValueByColumnAndRow(8,1, 'Old invoice') 		/* I */
								->setCellValueByColumnAndRow(7,1, 'Transaction type') 		/* J */
								->setCellValueByColumnAndRow(8,1, 'Mode Of Payment') 		/* K */
								->setCellValueByColumnAndRow(9,1, 'Paid fee') 				/* L */
								->setCellValueByColumnAndRow(10,1, 'Invoice no') 			/* M */
								->setCellValueByColumnAndRow(11,1, 'Due amt') 				/* N */
								->setCellValueByColumnAndRow(12,1, 'Due Date'); 			/* O */
					/* Setting a column’s width */
					foreach(range('A','Z') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);
					}
					/* 4.6.12.	Center a page horizontally/vertically */
					$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
					/* 4.6.33.	Group/outline a row */
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
					for($i = 1;$i<=sizeof($feefields);$i++){
						$objPHPExcel->getActiveSheet()
									->setCellValueByColumnAndRow(0,($i+1), $feefields[$i]['No']) 			/* A */
									->setCellValueByColumnAndRow(1,($i+1), $feefields[$i]['name']) 			/* B */
									->setCellValueByColumnAndRow(2,($i+1), $feefields[$i]['user_id']) 		/* C */
									->setCellValueByColumnAndRow(3,($i+1), $feefields[$i]['cell']) 			/* D */
									->setCellValueByColumnAndRow(4,($i+1), $feefields[$i]['pack_name']) 	/* E */
									->setCellValueByColumnAndRow(5,($i+1), $feefields[$i]['sessions']) 		/* F */
									->setCellValueByColumnAndRow(6,($i+1), $feefields[$i]['payment_date']) 	/* G */
									// ->setCellValueByColumnAndRow(7,($i+1), $feefields[$i]['oldfee']) 	/* H */
									->setCellValueByColumnAndRow(7,($i+1), $feefields[$i]['mt_tt']) 		/* J */
									->setCellValueByColumnAndRow(8,($i+1), $feefields[$i]['action_no']) 	/* K */
									->setCellValueByColumnAndRow(9,($i+1), $feefields[$i]['total_amt']) 	/* L */
									->setCellValueByColumnAndRow(11,($i+1), $feefields[$i]['due_amount']) 	/* N */
									->setCellValueByColumnAndRow(12,($i+1), $feefields[$i]['due_date']); 	/* O */
						// if($feefields[$i]['receipt_no'])
							// $objPHPExcel->getActiveSheet()
										// ->getCellByColumnAndRow(8,($i+1))
										// ->setValueExplicit($feefields[$i]['receipt_no'], PHPExcel_Cell_DataType::TYPE_STRING2); /* I */

						$objPHPExcel->getActiveSheet()
									->getCellByColumnAndRow(10,($i+1))
									->setValueExplicit($feefields[$i]['mt_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2); 		/* M */

						if($feefields[$i]['inv_urls'] != NULL || $feefields[$i]['inv_urls'] != ''){
							$objPHPExcel->getActiveSheet()
										->getCellByColumnAndRow(10,($i+1))
										->getHyperlink()
										->setUrl($feefields[$i]['inv_urls']); 													/* M */
						}
					}
					// $objPHPExcel->getActiveSheet()
								// ->setCellValueByColumnAndRow(6,($i+2),'Old fee total')
								// ->setCellValueByColumnAndRow(7,($i+2),$ototal);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(8,($i+2),'Paid fee total')
								->setCellValueByColumnAndRow(9,($i+2),$ptotal);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(10,($i+2),'Due fee total')
								->setCellValueByColumnAndRow(11,($i+2),$dtotal);

					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(4,($i+4),'Actual fee total')
								->setCellValueByColumnAndRow(5,($i+4),$atotal)
								->setCellValueByColumnAndRow(4,($i+5),'Paid fee total')
								->setCellValueByColumnAndRow(5,($i+5),$ptotal)
								->setCellValueByColumnAndRow(4,($i+6),'Balance')
								->setCellValueByColumnAndRow(5,($i+6),($atotal - $ptotal));
				}
			}
		}
		return $ptotal;
	}
	/* Registrations */
	public function balRegistrationReport($from,$to,$fromdate,$todate,$objPHPExcel){
		$res = '';
		$userfields = array();
		$total = 0;
		$ntotal = 0;
		$ototal = 0;
		if($fromdate != 0 || $todate != 0){
			$query = '';
			if($fromdate < $todate && $fromdate != 0 && $todate != 0){
				$query = 'SELECT
							usr.`id` AS usrid,
							mo_tr.`mt_pk`,
							usr.`name`,
							usr.`email` AS email_id,
							CONCAT(\'+91 \',usr.`cell_number`) AS cell,
							STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') AS doj,
							mo_tr.`mt_tt`,
							mo_tr.`mt_rpt`,
							mo_tr.`action_no`,
							mo_tr.`total_amt`,
							mo_tr.`inv_urls`,
							STR_TO_DATE(mo_tr.`due_date`, \'%Y-%m-%d\') AS due_date,
							mo_tr.`due_amount`,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN 0
								ELSE usr.`fee`
							END AS old_fee,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN \'\'
								ELSE usr.`receipt_no`
							END AS old_rpt,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN \'\'
								ELSE usr.`mode_of_payment`
							END AS old_mop
						FROM `customer` AS usr
						LEFT JOIN(
							SELECT
								mtr.`id` 									AS mt_pk,
								mtr.`customer_pk` 							AS mt_uid,
								mtr.`transaction_type`  					AS mt_tt,
								mtr.`receipt_no`  							AS mt_rpt,
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
																			AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))
									)
								)AS action_no,
								/* GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))) AS mop, */
								/* GROUP_CONCAT(mtr.`mop_id`) 				AS mopid, */
								/* mtr.`pay_date`  							AS mt_pod, */
								/* GROUP_CONCAT(mtr.`transaction_id`) AS action_id, */
								/* GROUP_CONCAT(`total_amount`) AS ind_amt, */
								/* inv.`inv_users`, */
								SUM(`total_amount`) AS total_amt,
								inv.`inv_urls`,
								due.`due_date`,
								due.`due_amount`
								/* due.`due_user`, */
								/* due.`due_status`, */
							FROM `money_transactions` AS mtr
							LEFT JOIN (
								SELECT
									/*
									GROUP_CONCAT(`customer_pk`) AS inv_users,
									GROUP_CONCAT(`location`) AS inv_urls,
									*/
									`customer_pk` AS inv_users,
									`location` AS inv_urls,
									`transaction_id`,
									`name`
								FROM `invoice`
								GROUP BY(`transaction_id`)
							) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE \'%registration%\'
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
							WHERE mtr.`transaction_type` LIKE \'%registration%\'
							GROUP BY(mtr.`receipt_no`)
							ORDER BY (mtr.`id`)
						) AS mo_tr ON mo_tr.`mt_uid` = usr.`id`
						WHERE STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$from.'\', \'%Y-%m-%d\')
						AND STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$to.'\', \'%Y-%m-%d\')
						AND usr.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Left\' AND `status`=1)
						AND usr.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Delete\' AND `status`=1);';
			}
			else if($fromdate || $todate && ($fromdate != 0 || $todate != 0)){
				$onedate = NULL;
				if($fromdate)
					$onedate = $from;
				else if($todate)
					$onedate = $to;
				else if($fromdate == $todate && $fromdate != 0 && $todate != 0)
					$onedate = $from;
				if($onedate)
					$query = 'SELECT
							usr.`id` AS usrid,
							mo_tr.`mt_pk`,
							usr.`name`,
							usr.`email` AS email_id,
							CONCAT(\'+91 \',usr.`cell_number`) AS cell,
							STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') AS doj,
							mo_tr.`mt_tt`,
							mo_tr.`mt_rpt`,
							mo_tr.`action_no`,
							mo_tr.`total_amt`,
							mo_tr.`inv_urls`,
							STR_TO_DATE(mo_tr.`due_date`, \'%Y-%m-%d\') AS due_date,
							mo_tr.`due_amount`,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN 0
								ELSE usr.`fee`
							END AS old_fee,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN \'\'
								ELSE usr.`receipt_no`
							END AS old_rpt,
							CASE
								WHEN usr.`mode_of_payment` IS NULL
								THEN \'\'
								ELSE usr.`mode_of_payment`
							END AS old_mop
						FROM `customer` AS usr
						LEFT JOIN(
							SELECT
								mtr.`id` 									AS mt_pk,
								mtr.`customer_pk` 							AS mt_uid,
								mtr.`transaction_type`  					AS mt_tt,
								mtr.`receipt_no`  							AS mt_rpt,
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
																			AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))
									)
								)AS action_no,
								/* GROUP_CONCAT((SELECT `name` FROM `mode_of_payment` WHERE `id` = mtr.`mop_id` AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1))) AS mop, */
								/* GROUP_CONCAT(mtr.`mop_id`) 				AS mopid, */
								/* mtr.`pay_date`  							AS mt_pod, */
								/* GROUP_CONCAT(mtr.`transaction_id`) AS action_id, */
								/* GROUP_CONCAT(`total_amount`) AS ind_amt, */
								/* inv.`inv_users`, */
								SUM(`total_amount`) AS total_amt,
								inv.`inv_urls`,
								due.`due_date`,
								due.`due_amount`
								/* due.`due_user`, */
								/* due.`due_status`, */
							FROM `money_transactions` AS mtr
							LEFT JOIN (
								SELECT
									/*
									GROUP_CONCAT(`customer_pk`) AS inv_users,
									GROUP_CONCAT(`location`) AS inv_urls,
									*/
									`customer_pk` AS inv_users,
									`location` AS inv_urls,
									`transaction_id`,
									`name`
								FROM `invoice`
								GROUP BY(`transaction_id`)
							) AS inv ON inv.`transaction_id` = mtr.`id` AND inv.`name` LIKE \'%registration%\'
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
							WHERE mtr.`transaction_type` LIKE \'%registration%\'
							GROUP BY(mtr.`receipt_no`)
							ORDER BY (mtr.`id`)
						) AS mo_tr ON mo_tr.`mt_uid` = usr.`id`
						WHERE STR_TO_DATE(usr.`date_of_join`, \'%Y-%m-%d\') = STR_TO_DATE(\''.$onedate.'\', \'%Y-%m-%d\')
						AND usr.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Left\' AND `status`=1)
						AND usr.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Delete\' AND `status`=1);';
			}
			if($query){
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					// echo mysql_num_rows($res) ."<br />";
					$i=1;
					while($row = mysql_fetch_assoc($res)){
						$userfields[$i]['No'] = $i; /* A */
						$userfields[$i]['name'] = $row['name']; /* B */
						$userfields[$i]['email_id'] = $row['email_id']; /* C */
						$userfields[$i]['cell_number'] = $row['cell']; /* D */
						$userfields[$i]['date_of_join'] = date('j-M-Y', strtotime($row['doj'])); /* E */
						$userfields[$i]['mt_tt'] = $row['mt_tt']; /* F */
						if($row['mt_rpt'] != NULL)
							$userfields[$i]['mt_rpt'] = sprintf("%010s",$row['mt_rpt']); /* G */
						else
							$userfields[$i]['mt_rpt'] = $row['mt_rpt']; /* G */
						$userfields[$i]['action_no'] = $row['action_no']; /* H */
						$userfields[$i]['total_amt'] = $row['total_amt']; /* I */
						$userfields[$i]['inv_urls'] = $row['inv_urls']; /* J */
						if($row['due_date'] != NULL || $row['due_date'] != '')
							$userfields[$i]['due_date'] = date('j-M-Y', strtotime($row['due_date'])); /* K */
						else
							$userfields[$i]['due_date'] = $row['due_date']; /* K */
						$userfields[$i]['due_amount'] = $row['due_amount']; /* L */
						$userfields[$i]['old_fee'] = $row['old_fee']; /* M */
						if($row['old_rpt'] != NULL || $row['old_rpt'] != '')
							$userfields[$i]['old_rpt'] = sprintf("%010s",$row['old_rpt']); /* N */
						else
							$userfields[$i]['old_rpt'] = $row['old_rpt']; /* N */
						if($userfields[$i]['old_rpt'] == '0000000000')
							$userfields[$i]['old_rpt'] = NULL;
						$userfields[$i]['old_mop'] = $row['old_mop']; /* O */
						$total += ($row['old_fee'] + $row['total_amt']);
						$ntotal += $row['total_amt'];
						$ototal += $row['old_fee'];
						// echo '<p>'.$userfields[$i]['inv_urls'].'</p>';
						$i++;
					}
					$flag = true;
				}
				else
					$userfields = NULL;
				if($userfields != NULL){
					$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Customer Registrations fee');
					// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
					$objPHPExcel->addSheet($myWorkSheet, 0);
					/* Set active sheet */
					$objPHPExcel->setActiveSheetIndexByName('Customer Registrations fee');
					$objPHPExcel->getProperties()->setCreator($this->parameters["GYMNAME"])
												 ->setLastModifiedBy($this->parameters["GYMNAME"])
												 ->setTitle("Customer Registrations")
												 ->setSubject("Customer Registrations Report")
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
								->setOddHeader('&C&H Customer Registrations report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
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
								->setCellValueByColumnAndRow(0,1, 'No')
								->setCellValueByColumnAndRow(1,1, 'Customer Name')
								->setCellValueByColumnAndRow(2,1, 'Email Id')
								->setCellValueByColumnAndRow(3,1, 'Cell Number')
								->setCellValueByColumnAndRow(4,1, 'Joining Date')
								->setCellValueByColumnAndRow(5,1, 'Transaction type')
								->setCellValueByColumnAndRow(6,1, 'Invoice no')
								->setCellValueByColumnAndRow(7,1, 'Mode Of Payment')
								->setCellValueByColumnAndRow(8,1, 'Registration Fee')
								->setCellValueByColumnAndRow(9,1, 'Invoice URLS')
								->setCellValueByColumnAndRow(10,1, 'Due Date')
								->setCellValueByColumnAndRow(11,1, 'Due amt')
								->setCellValueByColumnAndRow(12,1, 'Old fee')
								->setCellValueByColumnAndRow(13,1, 'Old invoice')
								->setCellValueByColumnAndRow(14,1, 'Old MOP');
					/* Setting a column’s width */
					foreach(range('A','O') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
							->setAutoSize(true);
					}
					/* 4.6.12.	Center a page horizontally/vertically */
					$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
					/* 4.6.33.	Group/outline a row */
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
					for($i = 1;$i<=sizeof($userfields);$i++){
						$objPHPExcel->getActiveSheet()
									->setCellValueByColumnAndRow(0,($i+1), $userfields[$i]['No'])
									->setCellValueByColumnAndRow(1,($i+1), $userfields[$i]['name'])
									->setCellValueByColumnAndRow(2,($i+1), $userfields[$i]['email_id'])
									->setCellValueByColumnAndRow(3,($i+1), $userfields[$i]['cell_number'])
									->setCellValueByColumnAndRow(4,($i+1), $userfields[$i]['date_of_join'])
									->setCellValueByColumnAndRow(5,($i+1), $userfields[$i]['mt_tt'])
									->setCellValueByColumnAndRow(7,($i+1), $userfields[$i]['action_no'])
									->setCellValueByColumnAndRow(8,($i+1), $userfields[$i]['total_amt'])
									->setCellValueByColumnAndRow(10,($i+1), $userfields[$i]['due_date'])
									->setCellValueByColumnAndRow(11,($i+1), $userfields[$i]['due_amount'])
									->setCellValueByColumnAndRow(12,($i+1), $userfields[$i]['old_fee']);
						$objPHPExcel->getActiveSheet()
									->getCellByColumnAndRow(6,($i+1))
									->setValueExplicit($userfields[$i]['mt_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2);

						if($userfields[$i]['inv_urls'] != NULL || $userfields[$i]['inv_urls'] != ''){
							$objPHPExcel->getActiveSheet()
									->getCellByColumnAndRow(9,($i+1))
									->setValueExplicit($userfields[$i]['mt_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2);
							$objPHPExcel->getActiveSheet()
										->getCellByColumnAndRow(9,($i+1))
										->getHyperlink()
										->setUrl(trim($userfields[$i]['inv_urls']));
						}
						$objPHPExcel->getActiveSheet()
									->getCellByColumnAndRow(13,($i+1))
									->setValueExplicit($userfields[$i]['old_rpt'], PHPExcel_Cell_DataType::TYPE_STRING2);
						if($userfields[$i]['old_rpt'] != NULL)
							$objPHPExcel->getActiveSheet()
										->setCellValueByColumnAndRow(14,($i+1), $userfields[$i]['old_mop']);
						else
							$objPHPExcel->getActiveSheet()
										->setCellValueByColumnAndRow(14,($i+1), NULL);
					}
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(7,($i+2),'New total')
								->setCellValueByColumnAndRow(8,($i+2),$ntotal)
								->setCellValueByColumnAndRow(11,($i+2),'Old total')
								->setCellValueByColumnAndRow(12,($i+2),$ototal);
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(4,($i+3),'New total')
								->setCellValueByColumnAndRow(5,($i+3),$ntotal)
								->setCellValueByColumnAndRow(4,($i+4),'Old total')
								->setCellValueByColumnAndRow(5,($i+4),$ototal)
								->setCellValueByColumnAndRow(4,($i+5),'Grand total')
								->setCellValueByColumnAndRow(5,($i+5),$total);
				}
			}
		}
		return $total;
	}
}
?>
