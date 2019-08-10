<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
        if($_SESSION['USERTYPE'] != "admin")
                header("Location:".URL);
	require_once(LIB_ROOT."PHPExcel_1.7.9/Classes/PHPExcel.php");
	function main(){
		if(!ValidateAdmin()){
			session_destroy();
			header('Location:'.URL);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'report_form'){
			ReportForm();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'gen_report'){
			GenReport();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'checkBalanceSheet'){
			checkBalanceSheet();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'function_login_report_sheet'){
				if($_POST['email']=="" && $_POST['pass']=="")
					echo "not valid";
				else{
					$email=$_POST['email'];
					$pass=$_POST['pass'];
					checkUserSheet($email,$pass);
				}
				unset($_POST);
				exit(0);
			}


	}
	function checkBalanceSheet(){
				$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
				if(get_resource_type($link) == 'mysql link'){
				if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					$query='SELECT *
							FROM settings
							WHERE
							`password_status` = (SELECT `id` FROM `status` WHERE `statu_name` = "on" AND `status` = 1)';
						$res=executeQuery($query);
						if(mysql_num_rows($res))
							echo "allow";
						else
							echo "Not allow";
					}
				}
		unset($_POST);
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		}
	function checkUserSheet($email,$pass){
		$eml=$email;
		$pas = hash('sha256', $pass, false);
		$ida=$_SESSION['ADMIN_ID'];
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
				if(get_resource_type($link) == 'mysql link'){
				if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					$query='SELECT *
							FROM settings
							WHERE
							ac_user_name="'.$eml.'" AND
							ac_password = "'.$pas.'" AND
							admin_id="'.$ida.'" AND
							password_status = (SELECT `id` FROM `status` WHERE `statu_name` = "on" AND `status` = 1) ';

						$res=executeQuery($query);
						if(mysql_num_rows($res))
							echo "valid";
						else
							echo "Not valid";
					}
				}
		unset($_POST);
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
	}

		function GenReport(){
		$from_temp = explode("-",$_POST['from']);
		$to_temp = explode("-",$_POST['to']);
		$from = $from_temp[2].'-'.$from_temp[1].'-'.$from_temp[0];
		$to = $to_temp[2].'-'.$to_temp[1].'-'.$to_temp[0];
		$diff=date_diff( date_create($from),date_create($to) );
		$interval = $diff->format('%R%a');
		if($interval > 0 )
			BalanceSheet($from,$to);
		else
			echo "<h3>Error!!! Incorrect Dates, please enter the proper date, (From date should be smaller then To date).</h3>";
	}
	function BalanceSheet($from,$to){
		$flag = false;
		$incomefields = array();
		$paymentsfields = array();
		$source_balance = FetchSrcAc($from,$to);
		$incometotal = 0;
		$paymentstotal = 0;
		$feestotal = 0;

		if(!$flag){
			$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
			if(get_resource_type($link) == 'mysql link'){
				if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					$income = "SELECT a.*,
					b.`source_id`,
					b.`don_type`,
					b.`for`,
					b.`amount` AS inc_amount,
					b.`date` AS inc_date,
					c.`pre_name`,
					c.`tar_name`
					FROM
					`receipt` AS a JOIN `income` AS b ON a.`income_id` = b.`id`
					JOIN `target` AS c on b.`target_id` = c.`id`
					WHERE (b.`date` LIKE '".$from."%') OR (b.`date` BETWEEN '".$from."%' AND '".$to."%') OR (b.`date` LIKE '".$to."%')
					ORDER BY `id` ASC";

					$payments = "SELECT a.*,
					b.`pay_type`,
					b.`source_id`,
					b.`cheque_no`,
					b.`amount` AS pay_amount,
					b.`towards`,
					b.`date` AS pay_date,
					c.`pre_name`,
					c.`tar_name`
					FROM
					`voucher` AS a JOIN `payments` AS b ON a.`payment_id` = b.`id`
					JOIN `target`AS c on b.`target_id` = c.`id`
					WHERE (b.`date` LIKE '".$from."%') OR (b.`date` BETWEEN '".$from."%' AND '".$to."%') OR (b.`date` LIKE '".$to."%')
					ORDER BY `id` ASC";

					$res1 = executeQuery($income);
					$res2 = executeQuery($payments);
					if(mysql_num_rows($res1)){
						$i=1;
						while($row = mysql_fetch_assoc($res1)){
							$incomefields[$i]['No'] = $i; /* A */
							$incomefields[$i]['inc_name'] = $row['pre_name'].$row['tar_name']; /* B */
							$incomefields[$i]['inc_amount'] = $row['inc_amount']; /* C */
							$incomefields[$i]['inc_date'] = date('j-M-Y', strtotime($row['inc_date'])); /* D */
							$incomefields[$i]['inc_receipt'] = $row['rec_no']; /* F */
							$incomefields[$i]['inc_towards'] = $row['for']; /* F */
							$incometotal += $row['inc_amount'];
							$i++;
						}
					}
					if(mysql_num_rows($res2)){
						$i=1;
						while($row = mysql_fetch_assoc($res2)){
							$paymentsfields[$i]['No'] = $i; /* A */
							$paymentsfields[$i]['pay_name'] = $row['pre_name'].$row['tar_name']; /* B */
							$paymentsfields[$i]['pay_amount'] = $row['pay_amount']; /* C */
							$paymentsfields[$i]['pay_date'] = date('j-M-Y', strtotime($row['pay_date'])); /* D */
							$paymentsfields[$i]['pay_receipt'] = $row['sl_no']; /* E */
							$paymentsfields[$i]['pay_towards'] = $row['towards']; /* E */
							$paymentstotal += $row['pay_amount'];
							$i++;
						}
					}

				}
			}
			if(get_resource_type($link) == 'mysql link')
				mysql_close($link);
		}
		if($from != 0 || $to != 0){
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator(ORGNAME)
										 ->setLastModifiedBy(ORGNAME)
										 ->setTitle("Balance Sheet")
										 ->setSubject("Accounts calculations")
										 ->setDescription("Report generated by Prox(Procurement Expert) Powered By MadMec.")
										 ->setKeywords("MadMec")
										 ->setCategory("Reports");
			if($source_balance != NULL){
				$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Source Account');
				// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
				$objPHPExcel->addSheet($myWorkSheet, 0);
				/* Set active sheet */
				$objPHPExcel->setActiveSheetIndexByName('Source Account');
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
							->setOddHeader('&C&H Source Account for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
				/* Add a footer */
				$objPHPExcel->getActiveSheet()
							->getHeaderFooter()
							->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
				/* Add titles  of the columns */
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(0,1, 'Source Account')
							->setCellValueByColumnAndRow(1,1, 'From('.date('j-M-Y', strtotime($from)).')')
							->setCellValueByColumnAndRow(2,1, 'To('.date('j-M-Y', strtotime($to)).')');
				/* Setting a column’s width */
				foreach(range('A','Z') as $columnID) {
					$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
						->setAutoSize(true);
				}
				/* 4.6.12.	Center a page horizontally/vertically */
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				/* 4.6.33.	Group/outline a row */
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
				for($i = 1;$i<=sizeof($source_balance);$i++){
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(0,($i+1), $source_balance[$i]['src_ac'])
								->setCellValueByColumnAndRow(1,($i+1), $source_balance[$i]['src_from'])
								->setCellValueByColumnAndRow(2,($i+1), $source_balance[$i]['src_to']);
				}
			}
			if($incomefields != NULL){
				$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Income report');
				// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
				$objPHPExcel->addSheet($myWorkSheet, 0);
				/* Set active sheet */
				$objPHPExcel->setActiveSheetIndexByName('Income report');
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
							->setOddHeader('&C&H Income report for date range '.date('j-M-Y', strtotime($from)) .' - '.date('j-M-Y', strtotime($to)));
				/* Add a footer */
				$objPHPExcel->getActiveSheet()
							->getHeaderFooter()
							->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
				/* Add titles  of the columns */
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(0,1, 'No')
							->setCellValueByColumnAndRow(1,1, 'Payer')
							->setCellValueByColumnAndRow(2,1, 'Income date')
							->setCellValueByColumnAndRow(3,1, 'Receipt No')
							->setCellValueByColumnAndRow(4,1, 'Amount')
							->setCellValueByColumnAndRow(5,1, 'Towards');
				/* Setting a column’s width */
				foreach(range('A','Z') as $columnID) {
					$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
						->setAutoSize(true);
				}
				/* 4.6.12.	Center a page horizontally/vertically */
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				/* 4.6.33.	Group/outline a row */
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
				for($i = 1;$i<=sizeof($incomefields);$i++){
					$objPHPExcel->getActiveSheet()
								->setCellValueByColumnAndRow(0,($i+1), $incomefields[$i]['No'])
								->setCellValueByColumnAndRow(1,($i+1), $incomefields[$i]['inc_name'])
								->setCellValueByColumnAndRow(2,($i+1), $incomefields[$i]['inc_date'])
								->setCellValueByColumnAndRow(3,($i+1), $incomefields[$i]['inc_receipt'])
								->setCellValueByColumnAndRow(4,($i+1), $incomefields[$i]['inc_amount'])
								->setCellValueByColumnAndRow(5,($i+1), $incomefields[$i]['inc_towards']);
				}
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(3,($i+2),'Total')
							->setCellValueByColumnAndRow(4,($i+2),$incometotal);
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
							->setCellValueByColumnAndRow(4,1, 'Amount')
							->setCellValueByColumnAndRow(5,1, 'Towards');
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
								->setCellValueByColumnAndRow(4,($i+1), $paymentsfields[$i]['pay_amount'])
								->setCellValueByColumnAndRow(5,($i+1), $paymentsfields[$i]['pay_towards']);
				}
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(4,($i+2),$paymentstotal);
				$objPHPExcel->getActiveSheet()
							->setCellValueByColumnAndRow(3,($i+2),'Total');
			}

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
						->setCellValueByColumnAndRow(0,1, 'Total Collection of '.ORGNAME);
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
						->setCellValueByColumnAndRow(1,2, 'Type')
						->setCellValueByColumnAndRow(2,2, 'From')
						->setCellValueByColumnAndRow(3,2, 'To')
						->setCellValueByColumnAndRow(4,2, 'Total');

			/* Incomes */
			$j = 3;
			$i = 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(0,$j, $i)
						->setCellValueByColumnAndRow(1,$j, 'Incomes')
						->setCellValueByColumnAndRow(2,$j, date('j-M-Y', strtotime($from)))
						->setCellValueByColumnAndRow(3,$j, date('j-M-Y', strtotime($to)))
						->setCellValueByColumnAndRow(4,$j, $incometotal);

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
						->setCellValueByColumnAndRow(4,$j, ($incometotal));
			$j += 2;
			$i += 1;
			/* Decorate the main heading 2 */
			$objPHPExcel->getActiveSheet()->mergeCells("A".$j.":E".$j);
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(0,$j, 'Total Deduction of '.ORGNAME);
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
						->setCellValueByColumnAndRow(4,$j, ($paymentstotal));

			/* Total collection */
			$j += 2;
			$i += 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3,$j,'Total collection')
						->setCellValueByColumnAndRow(4,$j, ($incometotal));
			/* Total deduction */
			$j += 1;
			$i += 1;
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3,$j, 'Total Deduction')
						->setCellValueByColumnAndRow(4,$j, ($paymentstotal));

			/* Balance */
			$j += 1;
			$i += 1;
			$balance = ($incometotal) - ($paymentstotal);
			/*
			$objPHPExcel->getActiveSheet()
						->setCellValueByColumnAndRow(3,$j, 'Balance')
						->setCellValueByColumnAndRow(4,$j, $balance);
			*/

			/* Setting a column’s width */
			foreach(range('A','Z') as $columnID) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
					->setAutoSize(true);
			}
			$objPHPExcel->getProperties()->setCreator(ORGNAME)
										 ->setLastModifiedBy(ORGNAME)
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
			$filename = ORGNAME.'_'.$objPHPExcel->getProperties()->getTitle().'_'.date('j-M-Y').'_'. date('j-M-Y', strtotime($from)) .'_'.date('j-M-Y', strtotime($to)).'_'.$callStartTime.'.xlsx';
			$objWriter->save(DOC_ROOT.DOWNLOADS.$filename);
			unset($objWriter);
			unset($objPHPExcel);
			echo '<center><h3>Click on below link to download</h3><h4><a target="_blank" href="'.URL.DOWNLOADS.$filename.'">'.$filename.'</a></h4></center>';
		}
	}
	function FetchSrcAc($from,$to){
		$source_balance = array();
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT * FROM `source`
				ORDER BY `id` DESC; ";
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					$i=1;
					while( $row = mysql_fetch_assoc($res)){
						$source_balance[$i]['No'] = $row['src_ac_no']; /* A */
						$source_balance[$i]['src_ac'] = $row['src_ac_name'].' - '.$row['src_bank'].' - '.$row['src_branch']; /* B */
						$source_balance[$i]['src_from'] = FetchBalance($row['id'],$from); /* C */
						$source_balance[$i]['src_to'] = FetchBalance($row['id'],$to); /* E */
						$i++;
					}
				}
				else{

				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		return $source_balance;
	}





	function FetchBalance($id,$date){
		/*$query = "SELECT (SELECT SUM(amt) FROM (
		(SELECT SUM(`amount`)AS amt FROM `income` WHERE `source_id` = '".$id."')
		UNION ALL
		(SELECT SUM(`amount`) AS amt FROM `source_balance` WHERE `source_id` = '".$id."' AND `action` = 'increment')
		) a )
        -
		(SELECT SUM(amt) FROM (
		(SELECT SUM(`amount`)AS amt FROM `payments` WHERE `source_id` = '".$id."')
		UNION ALL
		(SELECT SUM(`amount`) AS amt FROM `source_balance` WHERE `source_id` = '".$id."' AND `action` = 'decrement')
		) s )";*/
		$income = "SELECT SUM(amt) FROM(
		(SELECT SUM(`amount`) AS amt FROM `income` WHERE `source_id` = '".$id."' AND `date` < '".$date."%')
		UNION ALL
		(SELECT SUM(`amount`) AS amt FROM `source_balance` WHERE `source_id` = '".$id."' AND `action` = 'increment' AND `date` < '".$date."%')
		)a ";
		$payments = "SELECT SUM(amt) FROM (
		(SELECT SUM(`amount`)AS amt FROM `payments` WHERE `source_id` = '".$id."' AND `date` < '".$date."%')
		UNION ALL
		(SELECT SUM(`amount`) AS amt FROM `source_balance` WHERE `source_id` = '".$id."' AND `action` = 'decrement' AND `date` < '".$date."%')
		)s ";
		$inc = mysql_result(executeQuery($income),0);
		$pay = mysql_result(executeQuery($payments),0);
		$bal = $inc - $pay;
		return moneyFormatIndia($bal);
	}
	function ReportForm(){
		$rep =  'Balance & Accounts';
		echo '<form role="form">
				<center class="form-group">
					<h3>'.$rep.'</h3>
					<span class="manditory">*</span>
					<label>From :</label>
					<input id="from" type="text" readonly="">
					<script type="text/javascript">
						$("#from").datepicker({ dateFormat: "dd-mm-yy",changeMonth : true,changeYear : true, maxDate:0 });
					</script>
					<span class="text-danger" id="err_from">Invalid</span>
					<span class="manditory">*</span>
					<label>TO :</label>
					<input id="to" type="text" readonly="">
					<script type="text/javascript">
						$("#to").datepicker({ dateFormat: "dd-mm-yy",changeMonth : true,changeYear : true, maxDate:0});
					</script>
					<span class="text-danger" id="err_from">Invalid</span>
					<br /><br />
					<button  onclick="javasript:gen_report();" type="button" class="btn btn-danger"><i class="fa fa-bar-chart"></i>&nbsp;Get Report</button>
				</center>
			</form>';
	}
	main();
?>

<?php include_once(DOC_ROOT.PHP.INC."header.php"); ?>
<div id="page-wrapper" >
	<div id="page-inner">
		<div id="error_msg"></div>
		<div class="row" id="report" style="display:none">
			<div class="col-md-12">
				<div class="panel panel-default">

					<div class="panel-heading">
						Reports and Summary
					</div>
					<div id="screen1" class="panel-body">
						<div class="row" style="color:WHITE !important;" >
							<div align="middle" class="col-md-12 report_menu">
								<div class="bg-red">
									<a id="rec_nav" href="javascript:void(0);" onclick="javascript:report_form();">  <img src="<?php echo URL.ASSET_IMG.'report.png';?>" height="50" width="50"/> <h2>Generate Balance Report</h2> </a>
								</div>
							</div>

						</div>
                        <!-- <div class="row" style="color:WHITE !important;">
							<div align="middle" class="col-md-6 report_menu">
								<div class="bg-green">
									<a id="src_nav" href="javascript:void(0);" onclick="javascript:report_form('src_Ac');"><i class="fa fa-star fa-5x"></i><h2> Source Accounts</h2> </a>
								</diV>
							</div>
							<div align="middle" class="col-md-6 report_menu">
								<div class="bg-red">
									<a id="tar_nav" href="javascript:void(0);" onclick="javascript:report_form('tar_ac');"><i class="fa fa-crosshairs fa-5x"></i><h2> Target Accounts</h2> </a>
								</div>
							</div>
						</div> -->
					</div>
					<div id="screen2" class="panel-body" style="display:none;">
						<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/></center>
					</div>

				</div>
			</div>
        </div>
					<div id="formclass" style="display:none">
						<form class="form-signin" role="form" id="form_sign" method="POST">
								<h1 class="form-signin-heading">Please sign in</h1>
								<input type="email" id="email_report" class="form-control" placeholder="Email address" required autofocus>
								<input type="password" id="password_report" class="form-control" placeholder="Password" required>
								<label class="btn btn-lg btn-danger btn-block" onclick="javascript: report_status();" >Processed</label>
								<br />
							<div id="passauth"></div>
						</form><br/>
                                            `<div id="displayreportingraph"></div>
					</div>
		<!-- /. ROW  -->
    </div>
	<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<html lang="en">
  <head>
   <!-- Bootstrap core CSS -->
    <link href="<?php echo URL.ASSET_CSS; ?>bootstrap.css" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="<?php echo URL.ASSET_CSS; ?>signin.css" rel="stylesheet">
    <!-- CUSTOM STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>custom.css" rel="stylesheet" />
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="<?php echo URL.ASSET_JS; ?>ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo URL.ASSET_JS; ?>ie-emulation-modes-warning.js"></script>
  	<script src="<?php echo URL.ASSET_JS; ?>config.js"></script>
    <script src="<?php echo URL.ASSET_JS; ?>ie10-viewport-bug-workaround.js"></script>
     </head>

</html>

<?php include_once(DOC_ROOT.PHP.INC."footer.php"); ?>
<script src="<?php echo URL.ASSET_JS; ?>reports.js"></script>
<script>
		$("#rep_nav").addClass("active-menu");

</script>
