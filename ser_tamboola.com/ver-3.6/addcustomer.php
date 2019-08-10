<?php

class addcustomer {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';
    private static $sid = '';

    public function __construct($para = false) {
        $this->parameters = $para;
    }

    /* Main */

    public function returnListofPeoples() {
        $listofPeoples = NULL;
        $query = 'SELECT ph1.ver1,ad.`id` AS pk,
			ad.`user_name` AS name,
			ad.`email_id` AS email,
			ad.`cell_number` AS cell,
			CASE WHEN ad.`photo_id` IS NULL OR ad.`photo_id`  = ""
			THEN \'' . ADMIN_ANON_IMAGE . '\'
			ELSE CONCAT(\'' . URL . DIRS . '\',ph1.`ver3`)
			END AS photos
			FROM `user_profile` AS ad
			LEFT JOIN `photo` AS ph1 ON ad.`photo_id` = ph1.`id`;';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $i = 1;
            $listofPeoples = array();
            while ($row = mysql_fetch_assoc($res)) {
                $listofPeoples[$i]['pk'] = $row['pk'];
                $listofPeoples[$i]['name'] = $row['name'];
                $listofPeoples[$i]['email'] = $row['email'];
                $listofPeoples[$i]['cell'] = $row['cell'];
                $listofPeoples[$i]['photos'] = $row['photos'];
                $i++;
            }
        }
        $_SESSION['listofPeoples'] = $listofPeoples;
        // $value["item"]=array($listofPeoples);
        echo json_encode($listofPeoples);
        // print_r($listofPeoples);
    }

    /* Main */

    public function AddDummyEmail() {
        $email = NULL;
        $GYMNAME = $this->parameters["GYM_NAME"];
        $GYMNAME = strtolower(str_replace(" ", "_", $GYMNAME));
        $res = executeQuery("SELECT status FROM `dummy_email_ids` ORDER BY id DESC LIMIT 1;");
        $num = mysql_num_rows($res);
        if ($num > 0)
            $status = mysql_result($res, 0);
        else
            $status = 0;
        if ($status == 21) {
            $email = mysql_result(executeQuery("SELECT user_id FROM `dummy_email_ids` ORDER BY id DESC  LIMIT 1;"), 0);
        } else {
            $num = mysql_result(executeQuery("SELECT COUNT(`id`) FROM `dummy_email_ids`;"), 0) + 1;
            $email = $GYMNAME . '_' . sprintf("%04s", $num) . '@madmec.com';
            executeQuery('INSERT INTO `dummy_email_ids` (`id`,`user_id`,`status`) VALUES(NULL,\'' . $email . '\',default);');
        }
        $_SESSION['DummyEmail'] = $email;
        return $email;
    }

    /* Main */

    public function customer_sex() {
        $result = false;
        $i = 1;
        $query = 'SELECT gd.*
			FROM `gender` as gd,
			`status` as st
			WHERE gd.`status`= st.`id` AND
			st.`statu_name`="Show" AND st.`status`=1';
        $result = executeQuery($query);
        echo '<span><select name="cust_sex" id="cust_sex" class="form-control">
			<option value="NULL" id="NULL">Select Gender</option>';
        while ($row = mysql_fetch_assoc($result)) {
            echo '<option value=' . $row["id"] . ' id=' . $row["gender_name"] . '_' . $row["id"] . $i . '>' . $row["gender_name"] . '</option>';
            $i++;
        }
        echo '</select></span><p class="help-block">&nbsp;</p>';
    }

    /* Main */

    public function ImportCustomer() {
        $flag = false;
        $importdata = NULL;
        $importdata['NAME'] = NULL;
        $importdata['GENDER'] = NULL;
        $importdata['MOBILE'] = NULL;
        $importdata['EMAIL'] = NULL;
        $importdata['ACS_ID'] = NULL;
        $importdata['CUSTOMERGYM'] = NULL;
        if (strtolower($_FILES["xls_cust_file"]['type']) == "application/vnd.ms-excel" ||
                strtolower($_FILES["xls_cust_file"]['type']) == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $path1 = DOC_ROOT . "/uploads";
            $temp = explode(".", $_FILES["xls_cust_file"]['name']);
            $order = array("_", " ");
            $replace = '-';
            $fname1 = md5(date('h-i-s,_j-m-y,_it_is_w_Day_u') . "-" . rand(1, 99)) . "_" . str_replace($order, $replace, $_FILES["xls_cust_file"]['name']);
            $thefile1 = $path1 . "/" . $fname1;
            if (move_uploaded_file($_FILES["xls_cust_file"]['tmp_name'], $thefile1)) {
                if (is_file($thefile1)) {
                    if (strtolower($_FILES["xls_cust_file"]['type']) == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
                        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                    if (strtolower($_FILES["xls_cust_file"]['type']) == "application/vnd.ms-excel")
                        $objReader = new PHPExcel_Reader_Excel5();
                    $objReader->setReadDataOnly(true);
                    $objPHPExcel = $objReader->load($thefile1);
                    $objWorksheet = $objPHPExcel->getActiveSheet();
                    $highestRow = $objWorksheet->getHighestRow();
                    $highestColumn = $objWorksheet->getHighestColumn();
                    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                    if ($highestRow > 0 && $highestColumnIndex > 0) {
                        $importdata = array();
                        for ($col = 0; $col < $highestColumnIndex; ++$col) {
                            if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_NAME) {
                                $importdata['NAME'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['NAME'][$j] = isset($temp) ? $temp : NULL;
                                }
                            } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_GENDER) {
                                $importdata['GENDER'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['GENDER'][$j] = isset($temp) ? $temp : NULL;
                                }
                            } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_DOB) {
                                $importdata['DOB'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['DOB'][$j] = isset($temp) ? $temp : NULL;
                                }
                            } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_MOBILE) {
                                $importdata['MOBILE'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['MOBILE'][$j] = isset($temp) ? $temp : NULL;
                                }
                            } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_EMAIL) {
                                $importdata['EMAIL'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['EMAIL'][$j] = isset($temp) ? $temp : NULL;
                                }
                            }
                            //  else if($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_CUSTOMERGYM){
                            //  $importdata['CUSTOMERGYM'] = array();
                            //  for ($row = 2,$j = 1; $row <= $highestRow; ++$row,$j++) {
                            //  $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                            //  if($temp == '' || $temp == 'NULL')
                            //  $temp = 0;
                            //  else
                            //  $temp = 1;
                            //  $importdata['CUSTOMERGYM'][$j] = $temp;
                            //  }
                            //  }
                            else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_ACCESS_ID) {
                                $importdata['ACS_ID'] = array();
                                for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                    $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                    $importdata['ACS_ID'][$j] = isset($temp) ? $temp : NULL;
                                }
                            }
                        }
                        if ($importdata) {
                            if (!$this->checkForDuplicate($importdata, true, false)) { /* Email Id duplication */
                                if (!$this->checkForDuplicate($importdata, false, true)) { /* Cell Number duplication */
                                    if (!$this->checkForBulkExistence($importdata, true, false)) { /* Email Id duplication in database */
                                        if (!$this->checkForBulkExistence($importdata, false, true)) { /* Cell Number duplication in database */
                                            if ($this->AddBulk($importdata)) {
                                                $objPHPExcel->disconnectWorksheets();
                                                unset($objPHPExcel);
                                                $flag = true;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!$flag)
            echo '<h2>0 records in file!!!</h2>';
    }

    /* Slave */

    public function addMasterCustomer() {
        $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
        $data = array(
            "photo_id" => '',
            "user_id" => '',
            "directory" => '',
            "curr_time" => $curr_time,
            "status" => 'error'
        );
        $flag = false;
        $link1 = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link1) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link1)) == 1) {
                // executeQuery("SET AUTOCOMMIT=0;");
                // executeQuery("START TRANSACTION;");
                // executeQuery("BEGIN;");
                $undelte = getStatusId("undelete");
                $user_type = getUserTypeId("customer");
                $active = getStatusId("active");
                $show = getStatusId("show");
                /* Photo */
                $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
				NULL,NULL,NULL,NULL,NULL,NULL);';
                if (executeQuery($query1)) {
                    $photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                    /* Customer */
                    $query2 = 'INSERT INTO `user_profile`
					(`id`,
					`user_name`,
					`email_id`,
					`acs_id`,
					`photo_id`,
					`password`,
					`apassword`,
					`passwordreset`,
					`authenticatkey`,
					`cell_code`,
					`cell_number`,
					`dob`,
					`gender`,
					`date_of_join`,
					`status`) VALUES
					(NULL,
					\'' . mysql_real_escape_string($this->parameters["name"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["email"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["acsid"]) . '\',
					\'' . mysql_real_escape_string($photo_pk) . '\',
					\'' . mysql_real_escape_string($this->parameters["pass"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["auth"]) . '\',
					NULL,
					\'' . mysql_real_escape_string($this->parameters["auth"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["cellcode"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["cellnum"]) . '\',
					NOW(),
					\'' . mysql_real_escape_string($this->parameters["sex_type"]) . '\',
					\'' . mysql_real_escape_string($curr_time) . '\',
					\'' . mysql_real_escape_string($active) . '\')';
                    if (executeQuery($query2)) {
                        $user_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                        $query3 = 'INSERT INTO `userprofile_type`
						(`id`,
						`user_pk`,
						`usertype_id`,
						`status`) VALUES
						(NULL,
						\'' . mysql_real_escape_string($user_pk) . '\',
						\'' . mysql_real_escape_string($user_type) . '\',
						\'' . mysql_real_escape_string($show) . '\')';
                        if (executeQuery($query3)) {
                            $query4 = 'INSERT INTO `userprofile_gymprofile`
							(`id`,
							`user_pk`,
							`gym_id`,
							`status`) VALUES
							(NULL,
							\'' . mysql_real_escape_string($user_pk) . '\',
							\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
							\'' . mysql_real_escape_string($active) . '\')';
                            if (executeQuery($query4)) {
                                /* emails */
                                $query5 = 'INSERT INTO  `email_ids`
								(`id`,
								`user_pk`,
								`email`,
								`status` ) VALUES
								(NULL,
								\'' . mysql_real_escape_string($user_pk) . '\',
								\'' . mysql_real_escape_string($this->parameters["email"]) . '\',
								\'' . mysql_real_escape_string($show) . '\')';
                                if (executeQuery($query5)) {
                                    /* cell_numbers */
                                    $query6 = 'INSERT INTO  `cell_numbers`
									(`id`,
									`user_pk`,
									`cell_code`,
									`cell_number`,
									`status`) VALUES
									(NULL,
									\'' . mysql_real_escape_string($user_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellcode"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnum"]) . '\',
									\'' . mysql_real_escape_string($show) . '\')';
                                    if (executeQuery($query6)) {
                                        $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_customer_' . $user_pk);
                                        executeQuery('UPDATE `user_profile` SET `directory` = \'' . $directory_customer . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
                                        $flag = true;
                                        $data["photo_id"] = $photo_pk;
                                        $data["user_id"] = $user_pk;
                                        $data["directory"] = $directory_customer;
                                        $data["status"] = "success";
                                    }//  query6
                                }//  query5
                            }//  query4
                        }//  query3
                    }//  query2
                }//  query1
            }
        }
        if ($flag) {
            // executeQuery("COMMIT;");
            // executeQuery("SET AUTOCOMMIT=1;");
        }
        if (get_resource_type($link1) == 'mysql link') {
            mysql_close($link1);
        }
        return $data;
    }

    /* Slave */

    public function addSlaveCustomer($data) {
        $flag = false;
        $jsondata = array(
            "status" => "error",
            "data" => '',
            "url" => ''
        );
        $link = MySQLconnect($this->parameters["GYM_HOST"], $this->parameters["GYM_USERNAME"], $this->parameters["GYM_DB_PASSWORD"]);
        if (get_resource_type($link) == 'mysql link') {
            if (($db_select = selectDB($this->parameters["GYM_DB_NAME"], $link)) == 1) {
                // echo $this->parameters["GYM_DB_NAME"]."\r\n";
                // echo var_dump($this->parameters["link"])."\r\n";
                // executeQuery("USE `".$this->parameters["GYM_DB_NAME"]."`;");
                // executeQuery("SET AUTOCOMMIT=0;");
                // executeQuery("START TRANSACTION;");
                // executeQuery("BEGIN;");
                $undelte = getStatusId("undelete");
                //  $user_type = getUserTypeId("trainer");
                $active = getStatusId("active");
                $show = getStatusId("show");
                $receiptno = sprintf("%010s", mysql_result(executeQuery('SELECT COUNT(DISTINCT(`receipt_no`)) FROM `' . $this->parameters["GYM_DB_NAME"] . '`.`money_transactions`;'), 0) + 1);
                // /* Photo */
                $query1 = 'INSERT INTO  `' . $this->parameters["GYM_DB_NAME"] . '`.`photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
				\'' . mysql_real_escape_string($data["photo_id"]) . '\',
				NULL,NULL,NULL,\'' . mysql_real_escape_string(isset($_SESSION["photopath"]) ? $_SESSION["photopath"] : false) . '\',NULL,NULL);';
                if (executeQuery($query1)) {
                    $photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                    //  $this->updateSlavePhoto($dbpath,$photo_id);
                    $query2 = 'INSERT INTO `' . $this->parameters["GYM_DB_NAME"] . '`.`customer`
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
					`emergency_name`,
					`emergency_num`,
					`addressline`,
					`town`,
					`city`,
					`district`,
					`province`,
					`country`,
					`receipt_no`,
					`fee`,
					`master_pk`,
					`status`) VALUES
					(NULL,
					\'' . mysql_real_escape_string($this->parameters["name"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["email"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["acsid"]) . '\',
					\'' . mysql_real_escape_string($photo_pk) . '\',
					\'' . mysql_real_escape_string($data["directory"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["cellcode"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["cellnum"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["occupation"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["company"]) . '\',
					\'' . mysql_real_escape_string($data["curr_time"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["sex_type"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["doj"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["emnm"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["emnum"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["addressline"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["town"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["city"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["district"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["province"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["country"]) . '\',
					\'' . mysql_real_escape_string($receiptno) . '\',
					\'' . mysql_real_escape_string($this->parameters["sum_amount"]) . '\',
					\'' . mysql_real_escape_string($data["user_id"]) . '\',
					2)';
                    if (executeQuery($query2)) {
                        $user_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                        $recpamount = 0;
                        $feehtml = '';
                        $query3 = 'INSERT INTO `' . $this->parameters["GYM_DB_NAME"] . '`.`money_transactions` (`id`, `mop_id`, `pay_date`, `transaction_type`, `receipt_no`, `transaction_id`, `transaction_number`, `total_amount`, `customer_pk`, `status`) VALUES';
                        for ($i = 1; $i <= $this->parameters["max_mop"]; $i++) {
                            $recpamount +=$this->parameters['amount'][$i];
                            if (($this->parameters['transaction_number']) === '') {
                                $this->parameters['transaction_number'][$i] = '';
                            }
                            if ($i == $this->parameters["max_mop"]) {
                                $query3 .='(NULL,
								\'' . mysql_real_escape_string($this->parameters['mod_pay'][$i]) . '\',
								\'' . mysql_real_escape_string($data["curr_time"]) . '\',
								\'Registration\',
								\'' . mysql_real_escape_string($receiptno) . '\',
								NULL,
								\'' . mysql_real_escape_string($this->parameters['transaction_number'][$i]) . '\',
								\'' . mysql_real_escape_string($this->parameters['amount'][$i]) . '\',
								' . $user_pk . ',
								\'' . mysql_real_escape_string($show) . '\');';
                            } else {
                                $query3 .='(NULL,
								\'' . mysql_real_escape_string($this->parameters['mod_pay'][$i]) . '\',
								\'' . mysql_real_escape_string($data["curr_time"]) . '\',
								\'Registration\',
								\'' . mysql_real_escape_string($receiptno) . '\',
								NULL,
								\'' . mysql_real_escape_string($this->parameters['transaction_number'][$i]) . '\',
								\'' . mysql_real_escape_string($this->parameters['amount'][$i]) . '\',
								' . $user_pk . ',
								\'' . mysql_real_escape_string($show) . '\'),';
                            }
                        }
                        if (executeQuery($query3)) {
                            $mey_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                            $feehtml .= '<tr>
							<td align="right" style="border-bottom: solid 1px;">' . mysql_real_escape_string($this->parameters['mod_pay'][0]) . ' :</td>
							<td width="139" align="right" style="border-bottom: solid 1px;">' . $mey_pk . '</td>
							<td width="84" align="right" style="border-bottom: solid 1px;">' . $recpamount . ' </td> </tr>';
                            $filename = md5(rand(999, 999999) . microtime()) . '_' . str_replace(" ", "_", mysql_real_escape_string($this->parameters['mod_pay'][0])) . '_' . $user_pk . '.html';
                            $filedirectory = DOC_ROOT . DIRS . $data["directory"] . '/profile/' . $filename;
                            $invloc = DIRS . $data["directory"] . '/profile/' . $filename;
                            $urlpath = URL . DIRS . $data["directory"] . '/profile/' . $filename;
                            $query5 = 'INSERT INTO `' . $this->parameters["GYM_DB_NAME"] . '`.`invoice`
							(`id`,
							`transaction_id`,
							`name`,
							`location`,
							`customer_pk`,
							`status`) VALUES
							(NULL,
							' . $mey_pk . ',
							\'Registration\',
							\'' . mysql_real_escape_string($invloc) . '\',
							' . $user_pk . ',
							\'' . mysql_real_escape_string($show) . '\')';
                            if (executeQuery($query5)) {
                                $query6 = 'UPDATE `' . $this->parameters["GYM_DB_NAME"] . '`.`enquiry` SET `status`=6 WHERE `cell_number`="' . mysql_real_escape_string($this->parameters["cellnum"]) . '";';
                                executeQuery($query6);
                                //	$query = 'INSERT INTO  `invoice` (`id`,`user_id`,`transaction_id`,`name`,`location`)  VALUES(
                                //	NULL,
                                //	\'' . mysql_real_escape_string($email) . '\',
                                //	LAST_INSERT_ID(),
                                //	\'' . mysql_real_escape_string($transaction_type) . '\',
                                //	\'' . mysql_real_escape_string($urlpath) . '\');';
                                //	$res = executeQuery($query);
                                //	if ($res) {
                                $gym_addresss = array();
                                $gym_addresss = fetchAddress($this->parameters['GYM_ID']);
                                $invoice = str_replace($this->order, $this->replace, "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><title>" . mysql_real_escape_string($this->parameters['mod_pay'][0]) . " Invoice</title></head>
								<body>
								<table width='800' border='0' align='center' cellpadding='5' cellspacing='2' style='border: solid 1px; font-size:18px;'>
								<tr>
								<th colspan='2' align='center'>Invoice</th>
								</tr>
								<tr>
								<td width='430'>
								Invoice no : <span style='color:red;'>" . $receiptno . "</span><br />
								Invoice Date :&nbsp;<span><u>" . $data["curr_time"] . "</u></span>
								</td>
								<td width='354'>
								<div align='center' id='comp_logo'>
								<img height='100' src='" . $gym_addresss['gympic'] . "'></img>
								</div>
								<div id='comp_add' align='left'>
								" . $gym_addresss['add'] . "
								</div>
								</td>
								</tr>
								<tr>
								<td colspan='2'>&nbsp;</td>
								</tr>
								<tr>
								<td>Reg Date :&nbsp;<span><u>" . $data["curr_time"] . "</u></span></td>
								<td>Start / Joining Date :&nbsp;<span><u>" . $this->parameters['doj'] . "</u></span></td>
								</tr>
								<tr>
								<td colspan='2'>&nbsp;</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='float:left;'>Name of the member :&nbsp;</div>
								<div style='width:615px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . mysql_real_escape_string($this->parameters["name"]) . "</div>
								</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='float:left;'>Address :&nbsp;</div>
								<div style='width:710px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . mysql_real_escape_string($this->parameters["addressline"]) . "</div>
								</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='float:left;'>Cell number :&nbsp;</div>
								<div style='width:680px; float:right;border-bottom: dashed 1px;'>+91 " . mysql_real_escape_string($this->parameters["cellnum"]) . "</div>
								</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='float:left;'>Email id :&nbsp;</div>
								<div style='width:705px; float:right;border-bottom: dashed 1px;'>" . mysql_real_escape_string($this->parameters["email"]) . "</div>
								</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='float:left;'>DOB :&nbsp;</div>
								<div style='width:730px; float:right;border-bottom: dashed 1px;'>" . mysql_real_escape_string($this->parameters["dob"]) . "</div>
								</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='float:left;'>Emergency name and number :&nbsp;</div>
								<div style='width:550px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . mysql_real_escape_string($this->parameters["emnm"]) . ",  +91 " . mysql_real_escape_string($this->parameters["emnum"]) . "</div>
								</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='float:left;'>Company :&nbsp;</div>
								<div style='width:700px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . mysql_real_escape_string($this->parameters["company"]) . "</div>
								</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='float:left;'>Offer / Package :&nbsp;</div>
								<div style='width:655px; float:right;border-bottom: dashed 1px;'>" . mysql_real_escape_string($this->parameters['mod_pay'][0]) . "</div>
								</td>
								</tr>
								<tr>
								<td colspan='2' align='center'>
								<table cellpadding='0' cellspacing='0' style='border: solid 1px; font-size:24px;' width='400'>
								<tr>
								<td style='border-bottom: solid 1px;' align='right'>" . mysql_real_escape_string($this->parameters['mod_pay'][0]) . " fee :</td>
								<td style='border-bottom: solid 1px;' align='right'>" . $recpamount . " &nbsp;र;</td>
								</tr>
								<tr>
								<td style='border-bottom: solid 1px;' align='right'>Service tax :</td>
								<td style='border-bottom: solid 1px;' align='right'>0 &nbsp;र;</td>
								</tr>
								<tr>
								<td style='border-bottom: solid 1px;' align='right'>Total :</td>
								<td style='border-bottom: solid 1px;' align='right'>" . $recpamount . " &nbsp;र;</td>
								</tr>
								</table>
								</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='float:left;'>Total amount (in words) :&nbsp;</div>
								<div style='width:590px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>" . convert_number_to_words($recpamount) . " </div>
								</td>
								</tr>
								<tr>
								<td>
								<div style='float:left;'>Balance amt due :&nbsp;</div>
								<div style='width:285px; float:right;border-bottom: dashed 1px;'>0000</div>
								</td>
								<td>
								<div style='float:left;'>Due date :&nbsp;</div>
								<div style='width:270px; float:right;border-bottom: dashed 1px;'>--------</div>
								</td>
								</tr>
								<tr>
								<td colspan='2'>&nbsp;</td>
								</tr>
								<tr>
								<td colspan='2'>
								<div style='width:800px; float:right;border-bottom: dashed 1px;'>&nbsp;</div>
								</td>
								</tr>
								<tr>
								<td>
								Member signature
								</td>
								<td align='right'>
								Authorized signature
								</td>
								</tr>
								<tr>
								<td align='right'>
								Non-Transferable
								</td>
								<td>
								Non-Refundable
								</td>
								</tr>
								</table>
								");
                                $fh = fopen($filedirectory, 'w');
                                fwrite($fh, $invoice);
                                fclose($fh);
                                $jsondata = array(
                                    "status" => "success",
                                    "data" => $data,
                                    "url" => $urlpath
                                );
                                executeQuery("COMMIT");
                                $flag = true;
                            }
                        }
                    }//  query2
                }//  query1
            }//  dbselect
        }//  get resouce type
        if ($flag) {
            // executeQuery("COMMIT;");
            // executeQuery("SET AUTOCOMMIT=1;");
        }
        if (get_resource_type($link) == 'mysql link') {
            mysql_close($link);
        }
        return $jsondata;
    }

    /* Slave */

    public function list_cust($data, $tabid) {
        $listusers = NULL;
        $query = 'SELECT a.`id`,
						CASE 
							WHEN a.`ver2` IS NULL OR a.`ver2` = ""
								THEN "' . USER_ANON_IMAGE . '"
							ELSE CONCAT (
									"' . URL . DIRS . '",
									a.`ver2`
									)
							END AS photo,
						a.`master_pk`,
						a.`name`,
						a.`email`,
						a.`acs_id`,
						a.`cell_number`,
						a.`dob`,
						a.`occupation`,
						a.`sex`,
						a.`date_of_join` AS jnd,
						a.`emergency_name`,
						a.`emergency_num`,
						a.`addressline`,
						a.`town`,
						a.`city`,
						a.`district`,
						a.`province`,
						a.`country`,
						a.`receipt_no` AS reg_rpt_no,
						a.`fee` AS reg_fee,
						a.`status`,
						a.`custdfact_id`
					FROM (
						SELECT u.*,
							p.`ver2`,
							custdfact.`id` AS custdfact_id,
							custdfact.`facility_id` AS custfactid
						FROM `customer` AS u
						LEFT JOIN `photo` AS p
							ON p.`id` = u.`photo_id`
						LEFT JOIN `customer_facility` AS custdfact
							ON u.`id` = custdfact.`customer_pk` AND custdfact.`status` = (
									SELECT `id`
									FROM `status`
									WHERE `statu_name` = "Show"
									)
						WHERE u.`status` NOT IN (
								SELECT `id`
								FROM `status`
								WHERE (`statu_name` = "Left" OR `statu_name` = "Hide" OR `statu_name` = "Delete" OR `statu_name` = "Fired" OR `statu_name` = "Inactive")
								) AND custdfact.`facility_id` = ' . $data . '
						) AS a;';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $i = 0;
            while ($row1 = mysql_fetch_assoc($res)) {
                $listusers[$i]['id'] = $row1['id'];
                $listusers[$i]['photo'] = $row1['photo'];
                $listusers[$i]['master_pk'] = $row1['master_pk'];
                $listusers[$i]['name'] = $row1['name'];
                $listusers[$i]['email_id'] = $row1['email'];
                $listusers[$i]['cell_number'] = $row1['cell_number'];
                $listusers[$i]['acs_id'] = $row1['acs_id'];
                $listusers[$i]['occupation'] = $row1['occupation'];
                $listusers[$i]['dob'] = $row1['dob'];
                $listusers[$i]['sex'] = $row1['sex'];
                $listusers[$i]['date_of_join'] = date('F j, Y, g:i a', strtotime($row1['jnd']));
                $listusers[$i]['status'] = $row1['status'];
                $i++;
            }
        }
        $_SESSION["listofcustomer"] = $listusers;
        $this->ListOutCust($listusers, $data, $tabid);
    }

    /* Slave */

    public function editCustomerList($fid, $id, $tabid) {
        $temp = 1;
        $query = 'SELECT
			a.`id`,
			CASE WHEN a.`ver2` IS NULL OR a.`ver2` = ""
			THEN "' . USER_ANON_IMAGE . '"
			ELSE CONCAT("' . URL . DIRS . '",a.`ver2`)
			END AS photo,
			a.`master_pk`,
			a.`name`,
			a.`email`,
			a.`acs_id`,
			a.`cell_number`,
			a.`dob`,
			a.`occupation`,
			a.`sex`,
			a.`date_of_join` AS jnd,
			a.`emergency_name`,
			a.`emergency_num`,
			a.`addressline`,
			a.`town`,
			a.`city`,
			a.`district`,
			a.`province`,
			a.`country`,
			a.`receipt_no` AS reg_rpt_no,
			a.`fee` AS reg_fee,
			a.`status`,
			a.`custdfact_id`,
			fact.`factnm`,
			b.`fee_pk`,
			b.`facility_type`,
			b.`offer_name`,
			b.`duration`,
			b.`duration_name`,
			b.`fee_payment_date`,
			b.`valid_from`,
			b.`valid_till`,
			c.`pack_pk`,
			c.`package_type_id`,
			c.`package_name`,
			c.`number_of_sessions`,
			c.`pck_pay_date`,
			d.`attn_id`,
			d.`in_time`,
			d.`out_time`,
			e.`mt_pk`,
			e.`mt_uid`,
			e.`inv_tt`,
			e.`inv_tid`,
			e.`mt_pod`,
			e.`mt_rpt`,
			e.`tot_amt`,
			e.`mop`,
			e.`inv_urls`,
			e.`money_trans_id`,
			e.`due_id`,
			e.`due_amount`,
			e.`due_date`,
			e.`due_status`
			FROM (
			SELECT u.*,
			p.`ver2`,
			custdfact.`id` AS custdfact_id,
			custdfact.`facility_id` AS custfactid
			FROM `customer` AS u
			LEFT JOIN `photo` AS p ON p.`id` = u.`photo_id`
			LEFT  JOIN  `customer_facility` AS custdfact ON u.`id` = custdfact.`customer_pk` AND custdfact.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show")
			WHERE u.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
			`statu_name` = "Hide" OR
			`statu_name` = "Delete" OR
			`statu_name` = "Fired" OR
			`statu_name` = "Inactive"))
			)AS a
			LEFT JOIN(
			SELECT
			f.`name` AS factnm,
			f.`id` AS faid
			FROM facility AS f
			WHERE f.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show")
			)AS fact ON a.`custfactid` = fact.`faid`
			LEFT  JOIN (
			SELECT 	GROUP_CONCAT(DISTINCT (fe.`id`)) 	AS fee_pk,
			fe.`id`                             AS fe_id,
			fe.`offer_id`,
			fe.`customer_pk` 					AS user_id,
			GROUP_CONCAT(fep.`facility_id`) 	AS facility_type,
			GROUP_CONCAT(fep.`name`)  			AS offer_name,
			GROUP_CONCAT(fep.`duration_id`)		AS duration,
			GROUP_CONCAT(od.`duration`)			AS duration_name,
			GROUP_CONCAT(fep.`min_members`) 	AS min_members,
			GROUP_CONCAT(fe.`payment_date`) 	AS fee_payment_date,
			GROUP_CONCAT(fe.`valid_from`) 		AS valid_from,
			GROUP_CONCAT(fe.`valid_till`) 		AS valid_till
			FROM `fee` AS fe
			INNER  JOIN  `offers` AS fep ON fep.`id` = fe.`offer_id`
			LEFT  JOIN  `offerduration` AS od ON od.`id` = fep.`duration_id`
			WHERE fep.`id` = fe.`offer_id`
			GROUP BY (fe.`customer_pk`)
			ORDER BY (fe.`id`) DESC
			)AS b ON b.`user_id` = a.`id`
			LEFT  JOIN (
			SELECT 	GROUP_CONCAT(DISTINCT (fepack.`id`)) AS pack_pk,
			pac.`package_type_id`,
			pac.`number_of_sessions`,
			pname.`package_name`,
			GROUP_CONCAT(fepack.`payment_date`) AS pck_pay_date,
			fepack.`customer_pk` AS user_id
			FROM 	`fee_packages` AS fepack
			INNER  	JOIN  `packages` AS pac ON pac.`id` = fepack.`package_id`
			LEFT  JOIN  `package_name` AS pname ON pname.`id` = pac.`package_type_id`
			WHERE 	pac.`id` = fepack.`package_id`
			GROUP BY(fepack.`customer_pk`)
			ORDER BY (fepack.`id`) DESC
			) AS c ON c.`user_id` = a.`id`
			LEFT  JOIN (
			SELECT 	GROUP_CONCAT(DISTINCT (attn.`id`)) AS attn_id,
			GROUP_CONCAT(attn.`in_time`) AS in_time,
			GROUP_CONCAT(attn.`out_time`) AS out_time,
			GROUP_CONCAT(attn.`facility_id`) AS facility_type,
			attn.`customer_pk` AS user_id
			FROM `customer_attendence` AS attn
			GROUP BY(attn.`customer_pk`)
			) AS d ON d.`user_id` = a.`id`
			LEFT  JOIN (
			SELECT
			GROUP_CONCAT(mtr.`id`)  			AS mt_pk,
			mtr.`customer_pk` 					AS mt_uid,
			GROUP_CONCAT(inv.`name`) 			AS inv_tt,
			GROUP_CONCAT(inv.`transaction_id`) 	AS inv_tid,
			GROUP_CONCAT((SELECT `pay_date` FROM `money_transactions` WHERE `id` = inv.`transaction_id`))	AS mt_pod,
			GROUP_CONCAT(DISTINCT(mtr.`receipt_no`))AS mt_rpt,
			GROUP_CONCAT(temp1.`total`)			AS tot_amt,
			GROUP_CONCAT(temp2.`gmop`)			AS mop,
			GROUP_CONCAT(inv.`inv_urls`) 		AS inv_urls,
			due.`duser` 						AS due_user,
			GROUP_CONCAT(due.`money_trans_id`) 	AS money_trans_id,
			GROUP_CONCAT(due.`due_id`) 			AS due_id,
			GROUP_CONCAT(due.`damt`) 			AS due_amount,
			GROUP_CONCAT(due.`ddate`) 			AS due_date,
			GROUP_CONCAT(due.`dstatus`) 		AS due_status
			FROM `money_transactions` AS mtr
			LEFT JOIN (
			SELECT
			IF(temp3.`due_id` IS NULL, \'NA\', temp3.`due_id`) AS due_id,
			IF(temp3.`due_amt` IS NULL, \'NA\', temp3.`due_amt`) AS damt,
			IF(temp3.`due_date` IS NULL, \'NA\', temp3.`due_date`) AS ddate,
			IF(temp3.`due_status` IS NULL, \'NA\', temp3.`due_status`) AS dstatus,
			temp3.`duser` AS duser,
			IF(temp3.`money_trans_id` IS NULL, \'NA\', temp3.`money_trans_id`) AS money_trans_id,
			temp3.`rrr`
			FROM (
			SELECT
			tmtr.`receipt_no` 		AS rrr,
			tinv.`id` 			AS due_id,
			tinv.`money_trans_id` 		AS money_trans_id,
			tinv.`due_amount`		AS due_amt,
			tinv.`due_date` 		AS due_date,
			tmtr.`customer_pk` 			AS duser,
			tinv.`status` 			AS due_status
			FROM `money_transactions` AS tmtr
			LEFT JOIN (
			SELECT `id`,
			`money_trans_id`,
			`due_amount`,
			`due_date`,
			`customer_pk`,
			`status`
			FROM `money_trans_due`
			) AS tinv ON tmtr.`id` = tinv.`money_trans_id`
			GROUP BY (tmtr.`id`)
			) AS temp3
			GROUP BY (temp3.`rrr`)
			) AS due ON due.`rrr` = mtr.`receipt_no`
			LEFT JOIN (
			SELECT
			`customer_pk`	AS inv_users,
			`location` 	AS inv_urls,
			`transaction_id`,
			`name`
			FROM `invoice`
			GROUP BY(`transaction_id`)
			) AS inv ON inv.`transaction_id` = mtr.`id`
			LEFT JOIN(
			SELECT
			`id`,
			`receipt_no`,
			SUM(`total_amount`) AS total
			FROM `money_transactions`
			GROUP BY (`receipt_no`)
			) AS temp1 ON temp1.`id` = mtr.`id`
			LEFT JOIN(
			SELECT
			`id`,
			`receipt_no`,
			CONCAT(\'(\',GROUP_CONCAT(CONCAT(`total_amount` ,\' through \', (SELECT CASE WHEN `name` = \'Cash\' THEN \'Cash\' ELSE CASE WHEN `transaction_number` IS NULL THEN  `name` ELSE CASE WHEN LENGTH(`transaction_number`) = 0 THEN CONCAT (`name`, \' and \', `name`, \' No = Not provided\')  ELSE CONCAT (`name`, \' and \', `name`, \' No = \',`transaction_number`) END END END  FROM `mode_of_payment`  WHERE `id` = `mop_id`  AND `status` = 4)  )),\')\') AS gmop
			FROM `money_transactions`
			GROUP BY (`receipt_no`)
			) AS temp2 ON temp2.`id` = mtr.`id`
			GROUP BY (mtr.`customer_pk`)
			) AS e ON e.`mt_uid` = a.`id`
			WHERE a.`custfactid` = "' . $fid . '" OR a.`id` = "' . $id . '";';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $i = 0;
            while ($row1 = mysql_fetch_assoc($res)) {
                $listusers[$i]['id'] = $row1['id'];
                $listusers[$i]['master_pk'] = $row1['master_pk'];
                $listusers[$i]['photo'] = $row1['photo'];
                $listusers[$i]['name'] = $row1['name'];
                $listusers[$i]['email_id'] = $row1['email'];
                $listusers[$i]['cell_number'] = $row1['cell_number'];
                $listusers[$i]['acs_id'] = $row1['acs_id'];
                $listusers[$i]['occupation'] = $row1['occupation'];
                $listusers[$i]['dob'] = $row1['dob'];
                $listusers[$i]['sex'] = $row1['sex'];
                $listusers[$i]['date_of_join'] = date('F j, Y, g:i a', strtotime($row1['jnd']));
                $listusers[$i]['status'] = $row1['status'];
                $listusers[$i]['factnm'] = $row1['factnm'];
                /* Photo */
                //  $listusers[$i]['photo'] = $row1['photo'];
                /* Fee history */
                //  	$listusers[$i]['avg_amt'] = 0;
                if ($row1['fee_pk']) {
                    $listusers[$i]['fee'] = array();
                    $listusers[$i]['fee']['id'] = explode(",", $row1['fee_pk']);
                    //  $listusers[$i]['fee']['facility_type'] = explode(",",$row1['facility_type']);
                    $listusers[$i]['fee']['offer_name'] = explode(",", $row1['offer_name']);
                    $listusers[$i]['fee']['duration'] = explode(",", $row1['duration_name']);
                    $listusers[$i]['fee']['payment_date'] = explode(",", $row1['fee_payment_date']);
                    $listusers[$i]['fee']['valid_from'] = explode(",", $row1['valid_from']);
                    $listusers[$i]['fee']['valid_till'] = explode(",", $row1['valid_till']);
                } else {
                    $listusers[$i]['fee'] = NULL;
                }
                /* Fee package history */
                if ($row1['pack_pk']) {
                    $listusers[$i]['fee_package'] = array();
                    $listusers[$i]['fee_package']['id'] = explode(",", $row1['pack_pk']);
                    $listusers[$i]['fee_package']['package_type'] = explode(",", $row1['package_name']);
                    $listusers[$i]['fee_package']['num_sessions'] = explode(",", $row1['number_of_sessions']);
                    $listusers[$i]['fee_package']['payment_date'] = explode(",", $row1['pck_pay_date']);
                } else {
                    $listusers[$i]['fee_package'] = NULL;
                }
                /* Attendance history */
                if ($row1['attn_id']) {
                    $listusers[$i]['attendance'] = array();
                    $listusers[$i]['attendance']['id'] = explode(",", $row1['attn_id']);
                    $listusers[$i]['attendance']['in_time'] = explode(",", $row1['in_time']);
                    $listusers[$i]['attendance']['out_time'] = explode(",", $row1['out_time']);
                    $listusers[$i]['attendance']['facility_type'] = explode(",", $row1['facility_type']);
                } else {
                    $listusers[$i]['attendance'] = NULL;
                }
                /* Account stats */
                if ($row1['mt_uid']) {
                    $listusers[$i]['accounts'] = array();
                    $listusers[$i]['accounts']['mt_uid'] = $row1['mt_uid'];
                    $listusers[$i]['accounts']['inv_tt'] = explode(",", $row1['inv_tt']);
                    $listusers[$i]['accounts']['mt_pod'] = explode(",", $row1['mt_pod']);
                    $listusers[$i]['accounts']['mt_rpt'] = explode(",", $row1['mt_rpt']);
                    $listusers[$i]['accounts']['tot_amt'] = explode(",", $row1['tot_amt']);
                    $listusers[$i]['accounts']['mop'] = explode("),", $row1['mop']);
                    $listusers[$i]['accounts']['inv_urls'] = explode(",", $row1['inv_urls']);
                    $listusers[$i]['accounts']['due_amount'] = explode(",", $row1['due_amount']);
                    $listusers[$i]['accounts']['due_id'] = explode(",", $row1['due_id']);
                    $listusers[$i]['accounts']['money_trans_id'] = explode(",", $row1['money_trans_id']);
                    $listusers[$i]['accounts']['due_date'] = explode(",", $row1['due_date']);
                    $listusers[$i]['accounts']['due_status'] = explode(",", $row1['due_status']);
                } else {
                    $listusers[$i]['accounts'] = NULL;
                }
                if ($row1['valid_till'])
                    $listusers[$i]['exp_date'] = date('j-M-Y', strtotime($listusers[$i]['fee']['valid_till'][sizeof($listusers[$i]['fee']['valid_till']) - 1]));
                else
                    $listusers[$i]['exp_date'] = NULL;
                $i++;
            }
        }
        $ft1 = '';
        $otherFact = 'SELECT fact.`id`,fact.`name` FROM `customer_facility` AS custfact
			LEFT JOIN `customer` AS cust ON cust.`id` = custfact.`customer_pk`
			LEFT JOIN `facility` AS fact ON fact.`id` = custfact.`facility_id`
			WHERE custfact.`customer_pk` = ' . $listusers[0]['id'] . '';
        $re = executeQuery($otherFact);
        $count = mysql_num_rows($re);
        if ($count > 1) {
            $ft1 .='<ul>';
            while ($ft = mysql_fetch_assoc($re)) {
                if ($ft["id"] != $fid)
                    $ft1 .= '<li><storng>' . $ft["name"] . '</storng></li>';
            }
            $ft1 .='</ul>';
        }
        else {
            $ft1 .= "<storng><font color=red>This customer has not opted for any offer.</font></storng>";
        }
        $personalinfo = str_replace($this->order, $this->replace, '<div class="row">
			<div class="col-lg-12">&nbsp;</div>
			<div class="col-lg-4">
			<div class="panel panel-green">
			<div class="panel-heading">
			<h4>Personal-Info</h4>
			</div>
			<div class="panel-body" id="subcustdata_' . $temp . '">
			<ul>
			<li><strong>Name :</strong>' . $listusers[0]['name'] . '</li>
			<li><strong>Email :</strong>' . $listusers[0]['email_id'] . '</li>
			<li><strong>Cell Number  :</strong>' . $listusers[0]['cell_number'] . '</li>
			<li><strong>DOB :</strong>' . date("j-M-Y", strtotime($listusers[0]['dob'])) . '</li>
			<li><strong>Joining Date :</strong>' . date("j-M-Y h:i:s A", strtotime($listusers[0]['date_of_join'])) . '</li>
			<li><strong>Occupation :</strong>' . $listusers[0]['occupation'] . '</li>
			</ul>
			</div>
			<div class="panel-body" id="subcustinfoEDITdata_' . $temp . '" style="display:none">
			<form id="subcust_info_edit_form_' . $temp . '">
			<div class="row">
			<div class="col-lg-6">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> Name  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="Name" name="custname_' . $temp . '" type="text" id="custname_' . $temp . '" maxlength="100" value="' . $listusers[0]['name'] . '"/>
			<p class="help-block" id="custnmsg_' . $temp . '">Enter/ Select.</p>
			</div>
			</div>
			<div class="col-lg-6">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> Email_id  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="Email Id" name="custemail_' . $temp . '" type="text" id="custemail_' . $temp . '" maxlength="100" value="' . $listusers[0]['email_id'] . '"/>
			<p class="help-block" id="custemmsg_' . $temp . '">Enter/ Select.</p>
			</div>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			</div>
			<!--Customer Email  -->
			<div class="row">
			<div class="col-lg-6">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> Cell Number  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="DB Host" name="custcell_' . $temp . '" type="text" id="custcell_' . $temp . '" maxlength="100" value="' . $listusers[0]['cell_number'] . '"/>
			<p class="help-block" id="custcellmsg_' . $temp . '">Enter/ Select.</p>
			</div>
			</div>
			<div class="col-lg-6">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> DOB  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="DOB" name="custdob_' . $temp . '" type="text" id="custdob_' . $temp . '" maxlength="100" value="' . date("j-M-Y", strtotime($listusers[0]['dob'])) . '" readonly="readonly"/>
			<p class="help-block" id="custdobmsg_' . $temp . '">Enter/ Select.</p>
			</div>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			</div>
			<!-- Customer Cell Number -->
			<div class="row">
			<div class="col-lg-6">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> Date of Join  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<input class="form-control" placeholder="Date OF Joining" name="custdoj_' . $temp . '" type="text" id="custdoj_' . $temp . '" maxlength="100" value="' . date("j-M-Y", strtotime($listusers[0]['date_of_join'])) . '" readonly="readonly"/>
			<p class="help-block" id="custdojmmsg_' . $temp . '">Enter/ Select.</p>
			</div>
			</div>
			<div class="col-lg-6">
			<div class="col-lg-12">
			<strong><span class="text-danger"></span> Occupation  :<i class="fa fa-caret-down fa-fw"></i></strong>
			</div>
			<div class="col-lg-12">
			<select  name="custocc_' . $temp . '" id="custocc_' . $temp . '" type="text" class="form-control" >
			<option value="NULL">Select Occupation</option>
			<option value="Student">Student</option>
			<option value="Professional">Professional</option>
			<option value="Other">Other</option>
			</select>
			<p class="help-block" id="custocmsg_' . $temp . '">Enter/ Select.</p>
			</div>
			</div>
			<div class="col-lg-12">&nbsp;</div>
			</div>
			<!-- Update -->
			<div class="row">
			<div class="col-lg-12">&nbsp;</div>
			<div class="col-lg-12 text-center">
			<button type="button" class="btn btn-danger btn-md" id="subcust_info_update_but_' . $temp . '"><i class="fa fa-upload fa-fw "></i> Update</button>
			&nbsp;<button type="button" class="btn btn-danger btn-md" id="subcust_info_close_but_' . $temp . '"><i class="fa fa-close fa-fw "></i> Close</button>
			</div>
			</div>
			</form>
			</div>
			<div class="panel-footer">
			<button type="button" class="btn btn-danger btn-md" id="subcustinfo_but_edit_' . $temp . '" style="display:none;">
			<i class="fa fa-edit fa-fw "></i> Edit
			</button>
			</div>
			</div>
			</div>
			<div class="col-lg-4">
			<div class="panel panel-yellow">
			<div class="panel-heading">
			<h4>Photo</h4>
			</div>
			<div class="panel-body" id="usrphoto_' . $temp . '">
			<img src="' . $listusers[0]['photo'] . '" width="150" class="img-circle" />
			</div>
			<div class="panel-footer">
			<button class="btn btn-info " style="display:none;" id="usrphoto_but_edit_' . $listusers[0]["id"] . '" data-toggle="modal" data-target="#myModal_Photo1"><i class="fa fa-edit fa-fw"></i> Edit</button>
			</div>
			</div>
			</div>
			<div class="col-lg-4">
			<div class="panel panel-primary">
			<div class="panel-heading">
			<h4>Other Facilities</h4>
			</div>
			<div class="panel-body" id="usrfacilty_' . $temp . '">
			' . $ft1 . '
			</div>
			</div>
			</div>
			</div>');
        if ($listusers[0]['attendance'] != NULL) {
            $attendance_html = '<p><strong>Facility type : ' . $listusers[0]['factnm'] . '</strong></p><div class="col-lg-4" id="attpicker"></div>';
            $mark_attendance_html = 'var mark_dates = [';
            for ($k = 0; $k < sizeof($listusers[0]['attendance']['id']); $k++) {
                if ($k == 0) {
                    $mark_attendance_html .= "'" . date('Y-n-j', strtotime($listusers[0]['attendance']['in_time'][$k])) . "'";
                } else {
                    $mark_attendance_html .= ",'" . date('Y-n-j', strtotime($listusers[0]['attendance']['in_time'][$k])) . "'";
                }
            }
            $mark_attendance_html .= "];";
            $attendance_html .= str_replace($this->order, $this->replace, '<script language="javascript" type="text/javascript" >
				' . $mark_attendance_html . '
				$( "#attpicker" ).datepicker({
				dateFormat: \'yy-mm-dd\',
				changeYear: true,
				changeMonth: true,
				yearRange:\'2014:' . (date('Y') + 2) . '\',
				beforeShowDay: function(date) {
				var mark = Number(date.getFullYear()) +\'-\'+ (Number(date.getMonth())+1) +\'-\'+ Number(date.getDate());
				for (i = 0; i < mark_dates.length; i++) {
				if(mark == mark_dates[i]) {
				return [true, \'Highlighted\', \'\'];
				}
				}
				return [true];
				}
				});
				setTimeout(function(){
				$(\'.ui-state-active\').removeClass(\'ui-state-default\');
				$(\'.ui-state-active\').removeClass(\'ui-datepicker-days-cell-over\');
				$(\'.ui-state-active\').removeClass(\'ui-datepicker-today\');
				},1500);
				</script>');
        } else {
            $attendance_html = '<center><h2>' . $listusers[0]['name'] . ' has not attended.</h2></center>';
        }
        //  offer data
        $offerdata = ' ';
        $count = sizeof($listusers[0]["fee"]["offer_name"]);
        if ($count > 0) {
            for ($j = 0; $j < $count; $j++) {
                $offerdata .= '<tr><td>' . ($j + 1) . '</td><td>' . $listusers[0]["fee"]["offer_name"][$j] . '</td><td>' . $listusers[0]["fee"]["duration"][$j] . '</td><td>' . date('d-M-Y', strtotime($listusers[0]["fee"]["payment_date"][$j])) . '</td><td>' . date('d-M-Y', strtotime($listusers[0]["fee"]["valid_from"][$j])) . '</td><td>' . date('d-M-Y', strtotime($listusers[0]["fee"]["valid_till"][$j])) . '</td></tr>';
            }
        }
        // package data
        $packdata = ' ';
        $count1 = sizeof($listusers[0]['fee_package']['id']);
        if ($count1 > 0) {
            for ($j = 0; $j < $count1; $j++) {
                $listusers[0]['fee_package']['package_type'][$j] = isset($listusers[0]['fee_package']['package_type'][$j]) ? $listusers[0]['fee_package']['package_type'][$j] : '<strong>Not Provided</strong>';
                $listusers[0]['fee_package']['num_sessions'][$j] = isset($listusers[0]['fee_package']['num_sessions'][$j]) ? $listusers[0]['fee_package']['num_sessions'][$j] : '<strong>Not Provided</strong>';
                $listusers[0]['fee_package']['payment_date'][$j] = isset($listusers[0]['fee_package']['payment_date'][$j]) ? $listusers[0]['fee_package']['payment_date'][$j] : '<strong>Not Provided</strong>';
                $packdata .= '<tr><td>' . ($j + 1) . '</td><td>' . $listusers[0]['fee_package']['package_type'][$j] . '</td><td>' . $listusers[0]['fee_package']['num_sessions'][$j] . '</td><td>' . date('d-M-Y', strtotime($listusers[0]['fee_package']['payment_date'][$j])) . '</td></tr>';
            }
        }
        //  transaction data
        $trandata = ' ';
        $count3 = sizeof($listusers[0]['accounts']['inv_tt']);
        if ($count3 > 0) {
            for ($j = 0; $j < $count3; $j++) {
                $listusers[0]['accounts']['inv_tt'][$j] = isset($listusers[0]['accounts']['inv_tt'][$j]) ? $listusers[0]['accounts']['inv_tt'][$j] : '<strong>Not Provided</strong>';
                $listusers[0]['accounts']['inv_urls'][$j] = isset($listusers[0]['accounts']['inv_urls'][$j]) ? $listusers[0]['accounts']['inv_urls'][$j] : 'null';
                $listusers[0]['accounts']['mt_rpt'][$j] = isset($listusers[0]['accounts']['mt_rpt'][$j]) ? $listusers[0]['accounts']['mt_rpt'][$j] : '<strong>Not Provided</strong>';
                $listusers[0]['accounts']['mt_pod'][$j] = isset($listusers[0]['accounts']['mt_pod'][$j]) ? $listusers[0]['accounts']['mt_pod'][$j] : '<strong>Not Provided</strong>';
                $listusers[0]['accounts']['mop'][$j] = isset($listusers[0]['accounts']['mop'][$j]) ? $listusers[0]['accounts']['mop'][$j] : '<strong>Not Provided</strong>';
                $listusers[0]['accounts']['due_amount'][$j] = isset($listusers[0]['accounts']['due_amount'][$j]) ? $listusers[0]['accounts']['due_amount'][$j] : '<strong>Not Provided</strong>';
                $listusers[0]['accounts']['due_date'][$j] = isset($listusers[0]['accounts']['due_date'][$j]) ? $listusers[0]['accounts']['due_date'][$j] : '<strong>Not Provided</strong>';
                $listusers[0]['accounts']['due_status'][$j] = isset($listusers[0]['accounts']['due_status'][$j]) ? $listusers[0]['accounts']['due_status'][$j] : '<strong>Not Provided</strong>';
                if ($listusers[0]['accounts']['due_date'][$j] == "NA")
                    $duedatee = $listusers[0]['accounts']['due_date'][$j];
                else
                    $duedatee = date('d-M-Y', strtotime($listusers[0]['accounts']['due_date'][$j]));
                $trandata .= str_replace($this->order, $this->replace, '<tr><td>' . ($j + 1) . '</td><td>' . $listusers[0]['accounts']['inv_tt'][$j] . '</td>'
                        . '<td><a style=\'cursor:pointer;\' onclick=\'window.open(\"' . URL . $listusers[0]['accounts']['inv_urls'][$j] . '\");\' href=\'javascript:void(0);\' >' . $listusers[0]['accounts']['mt_rpt'][$j] . '</a></td><td>' . date('d-M-Y', strtotime($listusers[0]['accounts']['mt_pod'][$j])) . '</td><td>' . $listusers[0]['accounts']['mop'][$j] . '</td><td><font color=red>' . $listusers[0]['accounts']['due_amount'][$j] . '</font></td><td>' . $duedatee . '</td><td>' . $listusers[0]['accounts']['due_status'][$j] . '</td></tr>');
            }
        }
        echo str_replace($this->order, $this->replace, '<div class="col-lg-12 text-right"><button class="text-center btn btn-danger btn-md" id="custeditlist_Back_But_' . $temp . '"><i class="fa fa-reply fa-fw "></i>Back</button></div>
			<ul class="nav nav-pills">
			<li class="active"><a href="#info_subuser_list_' . $temp . '" data-toggle="tab">Personal Info</a></li>
			<li><a href="#offer_subuser_list_' . $temp . '" data-toggle="tab">Offer</a></li>
			<li><a href="#package_subuser_list_' . $temp . '" data-toggle="tab">Package</a></li>
			<li><a href="#attendance_subuser_list_' . $temp . '" data-toggle="tab">Attendance</a></li>
			<li><a href="#transaction_subuser_list_' . $temp . '" data-toggle="tab">Transaction</a></li>
			</ul>
			<div class="tab-content">
			<div class="tab-pane fade in active" id="info_subuser_list_' . $temp . '"><p>' . str_replace($this->order, $this->replace, $personalinfo) . '</p></div>
			<div class="tab-pane fade table-responsive" id="offer_subuser_list_' . $temp . '"></div>
			<div class="tab-pane fade table-responsive" id="package_subuser_list_' . $temp . '"></div>
			<div class="tab-pane fade" id="attendance_subuser_list_' . $temp . '">
			' . $attendance_html . '
			</div>
			<div class="tab-pane fade table-responsive" id="transaction_subuser_list_' . $temp . '"></div>
			</div>
			<form action="control.php" name="updatePic" id="changePic" method="post" enctype="multipart/form-data">
			<fieldset>
			<input type="hidden" name="formid" value="updatePic" />
			<input type="hidden" name="action1" value="custpicUpdate" />
			<input type="hidden" name="autoloader" value="true" />
			<input type="hidden" name="type" value="slave" />
			<input type="hidden" name="photo_id" value="' . $listusers[0]["id"] . '"/>
			<input type="hidden" name="user_id" value="' . $listusers[0]["master_pk"] . '"/>
			<div class="modal" id="myModal_Photo1" tabindex="-1" role="dialog" aria-labelledby="myModal_Photo_Label_' . $listusers[0]["id"] . '" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
			<div class="modal-content" style="color:#000;">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModal_Photo_Label_' . $listusers[0]["id"] . '">Update Customer Photo</h4>
			</div>
			<div class="modal-body">
			<!-- begin_picedit_box -->
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
			<button type="submit" name="submit" class="btn btn-success" id="addusrBut">Change Picture</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" id="photoCancel_' . $listusers[0]["id"] . '">Cancel</button>
			</div>
			</div>
			</div>
			</div>
			</fieldset>
			</form>
			<script language="javascript" type="text/javascript">
			$(document).ready(function () {
				var ltcust = {
					cust_id : "' . $listusers[0]["id"] . '",
					master_pk : "' . $listusers[0]["master_pk"] . '",
					photo : "' . $listusers[0]["photo"] . '",
					factid : "' . $fid . '",
					infoform : "#subcust_info_edit_form_' . $temp . '",
					infoEditBtn : "#subcustinfo_but_edit_' . $temp . '",
					infoEditPanel : "#subcustinfoEDITdata_' . $temp . '",
					infobody : "#subcustdata_' . $temp . '",
					infoCloseBtn : "#subcust_info_close_but_' . $temp . '",
					infoUpdateBtn : "#subcust_info_update_but_' . $temp . '",
					custdob : "#custdob_' . $temp . '",
					custdoj : "#custdoj_' . $temp . '",
					backBtn : "#custeditlist_Back_But_' . $temp . '",
					tabId : "' . $tabid . '",
					offerTab : "#offer_subuser_list_' . $temp . '",
					packageTab : "#package_subuser_list_' . $temp . '",
					transactionTab : "#transaction_subuser_list_' . $temp . '",
					attendanceTab : "#attendance_subuser_list_' . $temp . '",
					offerData : "' . $offerdata . '",
					packageData : "' . $packdata . '",
					transnctionData : "' . $trandata . '",
					cname : "#custname_' . $temp . '",
					cemail : "#custemail_' . $temp . '",
					ccell : "#custcell_' . $temp . '",
					cdob : "#custdob_' . $temp . '",
					cdoj : "#custdoj_' . $temp . '",
					cocc : "#custocc_' . $temp . '"
				};
				var obj = new controlCustomeList();
				obj.listeditcust(ltcust);
			});
			</script>');
    }

    /* Slave */

    public function listDel($id) {
        $result = false;
        $query = 'UPDATE `customer` SET status = (SELECT id FROM `status` WHERE statu_name="Left" and status=1) WHERE id=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    /* Slave */

    public function listFlag($id, $sID) {
        $result = false;
        $query = 'UPDATE `customer` SET status = (SELECT id FROM `status` WHERE statu_name="Flag" and status=1) WHERE id=' . $id . '';
        $result = executeQuery($query);
        if ($result) {
            echo 'success';
        }
    }

    /* Slave */

    public function listunFlag($id, $sID) {
        $result = false;
        $query = 'UPDATE `customer` SET status = (SELECT id FROM `status` WHERE statu_name="Joined" and status=1) WHERE id=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    /* Slave */

    public function ModeOfPaymentselect() {
        $moptype = NULL;
        $jsonmoptype = NULL;
        $num = 0;
        $query = 'SELECT `id`, `name` AS vtype FROM `mode_of_payment` WHERE `status` = (SELECT `id` FROM `status` WHERE `statu_name`="Show");';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $moptype[] = $row;
            }
        }
        if (is_array($moptype))
            $num = sizeof($moptype);
        if ($num) {
            for ($i = 0; $i < $num; $i++) {
                $jsonmoptype[] = array(
                    "html" => '<option  value="' . $moptype[$i]["id"] . '" >' . $moptype[$i]["vtype"] . '</option>',
                    "mopname" => $moptype[$i]["vtype"],
                    "id" => $moptype[$i]["id"],
                );
            }
        }
        return $jsonmoptype;
    }

    /* This */

    public function ListOutCust($listusers, $data, $tabid) {
        $users = array();
        $total = sizeof($listusers);
        $tableid = 'listcusttabl' . mt_rand(99, 9999);
        echo str_replace($this->order, $this->replace, '<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" id="' . $tableid . '">
			<thead>
			<tr>
			<th>No</th>
			<th>Customer Name</th>
			<th>Email Id</th>
			<th>Cell Number</th>
			<!--
			<th>Occupation</th>
			<th>DOB</th>
			-->
			<th>DOJ</th>
			<th class="text-center">View - Delete - Flag/Unflag</th>
			</tr></thead>');
        $name = '';
        $email = '';
        $totalname = 0;
        $totalemail = 0;
        $flagbut = '';
        for ($i = 0; $i < $total; $i++) {
            echo str_replace($this->order, $this->replace, '<tr>
				<td>' . ($i + 1) . '</td>
				<td>' . $listusers[$i]["name"] . '</td>
				<td>' . $listusers[$i]["email_id"] . '</td>
				<td>' . $listusers[$i]["cell_number"] . '</td>
				<!--
				<td>' . $listusers[$i]["occupation"] . '</td>
				<td>' . date("j-M-Y", strtotime($listusers[$i]["dob"])) . '</td>
				-->
				<td>' . date("j-M-Y", strtotime($listusers[$i]["date_of_join"])) . '</td>');
            if (($listusers[$i]["status"]) != 7) {
                // $flagbut = '<td class="text-center"><button type="button" class="btn btn-primary btn-md" id="listFLAGcust_' . $i . '" title="Flag" data-toggle="modal" data-target="#myModal_flag' . $i . '"><i class="fa fa-flag-o fa-fw"></i>Flag</button></td>';
                $flagbut = '<button type="button" class="btn btn-primary btn-md" id="listFLAGcust_' . $i . '" title="Flag" data-toggle="modal" data-target="#myModal_flag' . $i . '"><i class="fa fa-flag-o fa-fw"></i></button>';
            } else if (($listusers[$i]["status"]) == 7) {
                // $flagbut = '<td class="text-center"><button class="btn btn-danger btn-md" id="listUNFLAGcust_' . $i . '" data-toggle="modal" data-target="#myModal_unflag' . $i . '"><i class="fa fa-flag-o fa-fw"></i>Unflag</button></td>';
                $flagbut = '<button class="btn btn-danger btn-md" id="listUNFLAGcust_' . $i . '" data-toggle="modal" data-target="#myModal_unflag' . $i . '"><i class="fa fa-flag-o fa-fw"></i></button>';
            }
            echo str_replace($this->order, $this->replace, '
				<td class="text-center">
				<button type="button" id="listEDITcust_' . $i . '" title="Edit" class="btn btn-info btn-md" ><i class="fa fa-edit fa-fw"></i></button> - 
				<button type="button" class="btn btn-danger btn-md" id="listDELcust_' . $i . '" title="Delete" data-toggle="modal" data-target="#myUSRLISTDELModal_' . $i . '"><i class="fa fa-trash-o fa-fw"></i></button> - 
				' . $flagbut . '</td>
				</tr>
				<div class="modal fade" id="myUSRLISTDELModal_' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
				<div class="modal-content" style="color:#000;">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
				</div>
				<div class="modal-body" id="myUSRDEL_' . $i . '">
				Do you really want to delete {' . $listusers[$i]["email_id"] . '} <br />
				Press OK to delete ??
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deletelltDELOk_' . $i . '">Ok</button>
				<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
				</div>
				</div>
				</div>
				</div>
				<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myModal_flag_Label_' . $i . '" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
				<div class="modal-content" style="color:#000;">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModal_flag_Label_' . $i . '">Flag User entry</h4>
				</div>
				<div class="modal-body">
				Do You really want to flag the User {' . $listusers[$i]["email_id"] . '} entry ?? press <strong>OK</strong> to flag
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="flaglltOk_' . $i . '">Ok</button>
				<button type="button" class="btn btn-success" data-dismiss="modal" id="flaglltCancel_' . $i . '">Cancel</button>
				</div>
				</div>
				</div>
				</div>
				<div class="modal fade" id="myModal_unflag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myModal_unflag_Label_' . $i . '" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
				<div class="modal-content" style="color:#000;">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModal_unflag_Label_' . $i . '">UnFlag User entry</h4>
				</div>
				<div class="modal-body">
				Do You really want to UnFlag the User {' . $listusers[$i]["email_id"] . '} entry ?? press <strong>OK</strong> to UnFlag
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="unflaglltOk_' . $i . '">Ok</button>
				<button type="button" class="btn btn-success" data-dismiss="modal" id="unflaglltCancel_' . $i . '">Cancel</button>
				</div>
				</div>
				</div>
				</div><script langauge="javascript" type="text/javascript">
				$(document).ready(function () {
					var ltcust = {
						cust_id : "' . $listusers[$i]["id"] . '",
						master_pk : "' . $listusers[$i]["master_pk"] . '",
						index : ' . $i . ',
						editBtn : "#listEDITcust_' . $i . '",
						delBtn : "#listDELcust_' . $i . '",
						delOkBtn : "#deletelltDELOk_' . $i . '",
						flagBtn : "#listFLAGcust_' . $i . '",
						flagokBtn : "#flaglltOk_' . $i . '",
						unflagBtn : "#listUNFLAGcust_' . $i . '",
						unflagokBtn : "#unflaglltOk_' . $i . '",
						factid : "' . $data . '",
						tabId : "' . $tabid . '",
						pillpanel_div : "#cpanel_div",
						editcustomerdiv : "#edit_customer",
						statusId : "' . $listusers[$i]['status'] . '"
					};
					var obj = new controlCustomeList();
					obj.listcusttabledata(ltcust);
				});
				</script>');
            //  }
        }
        echo str_replace($this->order, $this->replace, '</table><script>
			$(document).ready(function () {
				var att = {
					tableid : "#' . $tableid . '",
				};
				var obj = new controlCustomeList();
				obj.listcusttabledata(att);
			});
			</script>');
    }

    /* This */

    public function checkForDuplicate($fields, $email = false, $cell_number = false) {
        $total = sizeof($fields['EMAIL']);
        $flag = false;
        if ($total) {
            $k = 1;
            echo '<table border="1" cellpadding="2" cellspacing="2" width="920" align="center">';
            if ($email) {
                echo '<tr><td align="center" colspan="8">Duplicate Email Ids in ' . $_FILES["xls_cust_file"]['name'] . '</td></tr>
					<tr>
					<td align="right">No</td>
					<td align="center">NAME</td>
					<td align="center">GENDER</td>
					<td align="center">DOB</td>
					<td align="center">MOBILE</td>
					<td align="center">EMAIL</td>
					<td align="center">ACS ID</td>
					</tr>';
                for ($i = 1; $i <= $total; $i++) {
                    for ($j = $i + 1; $j <= $total; $j++) {
                        if ($fields['EMAIL'][$i] == $fields['EMAIL'][$j] && $fields['EMAIL'][$j]) {
                            echo '<tr>
								<td>' . $k . '</td>
								<td>' . $fields['NAME'][$j] . '</td>
								<td>' . $fields['GENDER'][$j] . '</td>
								<td align="right">' . $fields['DOB'][$j] . '</td>
								<td align="right">' . $fields['MOBILE'][$j] . '</td>
								<td>' . $fields['EMAIL'][$j] . '</td>
								<td align="right">' . $fields['ACS_ID'][$j] . '</td>
								</tr>';
                            $fields['EMAIL'][$j] = NULL;
                            $flag = true;
                            $k++;
                        }
                    }
                }
                if (!$flag) {
                    echo '<tr><td align="center" colspan="8">No duplicatie Email Ids ' . $_FILES["xls_cust_file"]['name'] . '</td></tr>';
                }
            } else if ($cell_number) {
                echo '<tr><td align="center" colspan="8">Duplicate Cell Numbers in ' . $_FILES["xls_cust_file"]['name'] . '</td></tr>
					<tr>
					<td align="right">No</td>
					<td align="center">NAME</td>
					<td align="center">GENDER</td>
					<td align="center">DOB</td>
					<td align="center">MOBILE</td>
					<td align="center">EMAIL</td>
					<td align="center">ACS ID</td>
					</tr>';
                for ($i = 1; $i <= $total; $i++) {
                    for ($j = $i + 1; $j <= $total; $j++) {
                        if ($fields['MOBILE'][$i] == $fields['MOBILE'][$j] && $fields['MOBILE'][$j]) {
                            echo '<tr>
								<td>' . $k . '</td>
								<td>' . $fields['NAME'][$j] . '</td>
								<td>' . $fields['GENDER'][$j] . '</td>
								<td align="right">' . $fields['DOB'][$j] . '</td>
								<td align="right">' . $fields['MOBILE'][$j] . '</td>
								<td>' . $fields['EMAIL'][$j] . '</td>
								<td align="right">' . $fields['ACS_ID'][$j] . '</td>
								</tr>';
                            $fields['MOBILE'][$j] = NULL;
                            $flag = true;
                            $k++;
                        }
                    }
                }
                if (!$flag) {
                    echo '<tr><td align="center" colspan="8">No duplicatie Cell Numbers  in ' . $_FILES["xls_cust_file"]['name'] . '</td></tr>';
                }
            }
            echo '</table><p>&nbsp;</p>';
        }
        return $flag;
    }

    /* This */

    public function checkForBulkExistence($fields, $email = false, $cell_number = false) {
        $flag = false;
        $query1 = false;
        $query2 = false;
        $total = sizeof($fields['EMAIL']);
        $email_ids = NULL;
        $cell_numbers = NULL;
        if ($total) {
            $k = 1;
            $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
            if (get_resource_type($link) == 'mysql link') {
                if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
                    echo '<table border="1" cellpadding="2" cellspacing="2" width="920" align="center">';
                    if ($email) {
                        $query = 'SELECT `email_id` AS email FROM `user_profile`
							UNION
							SELECT `user_pk` FROM `email_ids`;';
                        $res = executeQuery($query);
                        if (mysql_num_rows($res)) {
                            $email_ids = array();
                            $i = 1;
                            while ($row = mysql_fetch_assoc($res)) {
                                $email_ids[$i] = $row['email'];
                                $i++;
                            }
                        }
                        if (is_array($email_ids)) {
                            echo '<tr><td align="center" colspan="8">Duplicate Email Ids  in database</td></tr>
								<tr>
								<td align="center">No</td>
								<td align="center">NAME</td>
								<td align="center">GENDER</td>
								<td align="center">DOB</td>
								<td align="center">MOBILE</td>
								<td align="center">EMAIL</td>
								<td align="center">ACS ID</td>
								</tr>';
                            for ($i = 1; $i <= $total; $i++) {
                                for ($j = 1; $j <= sizeof($email_ids); $j++) {
                                    if ($fields['EMAIL'][$i] == $email_ids[$j] && $email_ids[$j]) {
                                        echo '<tr>
											<td>' . $k . '</td>
											<td>' . $fields['NAME'][$i] . '</td>
											<td>' . $fields['GENDER'][$i] . '</td>
											<td align="right">' . $fields['DOB'][$i] . '</td>
											<td align="right">' . $fields['MOBILE'][$i] . '</td>
											<td>' . $fields['EMAIL'][$i] . '</td>
											<td align="right">' . $fields['ACS_ID'][$i] . '</td>
											</tr>';
                                        $flag = true;
                                        $email_ids[$j] = NULL;
                                        $k++;
                                    }
                                }
                            }
                        }
                        if (!$flag) {
                            echo '<tr><td align="center" colspan="8">No duplicatie Email Ids in database</td></tr>';
                        }
                    } else if ($cell_number) {
                        $query = 'SELECT `cell_number` AS cell FROM `user_profile`
							UNION
							SELECT `cell_number` FROM `cell_numbers`;';
                        $res = executeQuery($query);
                        if (mysql_num_rows($res)) {
                            $cell_numbers = array();
                            $i = 1;
                            while ($row = mysql_fetch_assoc($res)) {
                                $cell_numbers[$i] = $row['cell'];
                                $i++;
                            }
                        }
                        if (is_array($cell_numbers)) {
                            echo '<tr><td align="center" colspan="8">Duplicate Cell Numbers  in database</td></tr>
								<tr>
								<td align="center">No</td>
								<td align="center">NAME</td>
								<td align="center">GENDER</td>
								<td align="center">DOB</td>
								<td align="center">MOBILE</td>
								<td align="center">EMAIL</td>
								<td align="center">ACS ID</td>
								</tr>';
                            for ($i = 1; $i <= $total; $i++) {
                                for ($j = 1; $j <= sizeof($cell_numbers); $j++) {
                                    if ($fields['MOBILE'][$i] == $cell_numbers[$j] && $cell_numbers[$j]) {
                                        echo '<tr>
											<td>' . $k . '</td>
											<td>' . $fields['NAME'][$i] . '</td>
											<td>' . $fields['GENDER'][$i] . '</td>
											<td align="right">' . $fields['DOB'][$i] . '</td>
											<td align="right">' . $fields['MOBILE'][$i] . '</td>
											<td>' . $fields['EMAIL'][$i] . '</td>
											<td align="right">' . $fields['ACS_ID'][$i] . '</td>
											</tr>';
                                        $flag = true;
                                        $k++;
                                    }
                                }
                            }
                        }
                        if (!$flag) {
                            echo '<tr><td align="center" colspan="8">No duplicatie Cell Numbers  in database</td></tr>';
                        }
                    }
                    echo '</table><p>&nbsp;</p>';
                }
            }
            if (get_resource_type($link) == 'mysql link')
                mysql_close($link);
        }
        return $flag;
    }

    /* This */

    public function AddBulk($fields) {
        $flag = false;
        $query = false;
        $total = sizeof($fields['EMAIL']);
        $k = 1;
        $data = array(
            "user_id" => '',
            "directory" => '',
        );
        $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
                $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
                $password = array();
                $undelte = getStatusId("undelete");
                $user_type = getUserTypeId("customer");
                $active = getStatusId("active");
                $show = getStatusId("show");
                if ($total > 1999) {
                    $qut = floor($total / 2000);
                    $rem = $total % 2000;
                    for ($i = 1; $i <= $qut; $i++) {
                        $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                        $photo_pk = mysql_result(executeQuery($query1), 0);
                        $query2 = 'SELECT `id` FROM `user_profile` ORDER BY `id` DESC LIMIT 1';
                        $user_pk = mysql_result(executeQuery($query2), 0);
                        //  $query = 'INSERT INTO `employee`(`id`,`user_name`,`email`,`acs_id`,`password`,`apassword`,`gender`,`cell_number`,`status`,`passwordreset`,`date_of_join`,`fired_date`,`Gym`,`Aerobics`,`Dance`,`Yoga`,`Zumba`)  VALUES';
                        $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        $query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`acs_id`,`photo_id`,`directory`,`password`,`apassword`,`gender`,`dob`,`cell_code`,`cell_number`,`status`,`passwordreset`,`date_of_join`)  VALUES';
                        $query3 = 'INSERT INTO `userprofile_type`(`id`,`user_pk`,`usertype_id`,`status`) VALUES';
                        $query4 = 'INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`) VALUES';
                        //  $query0 = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES";
                        for ($j = 1; $j <= 2000 && $j <= $num1; $j++) {
                            $password[$k] = generateRandomString();
                            $pass = md5($password[$k]);
                            $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_cust_' . ($user_pk + $k));
                            //  ~ $this->sendMail(array (
                            //  ~ "name" 		=> $fields["NAME"][$k],
                            //  ~ "login_id" 	=> $fields["EMAIL"][$k],
                            //  ~ "password" 	=> $password[$k],
                            //  ~ "acs_id" 	=> $fields["ACS_ID"][$k]
                            //  ~ ));
                            if ($j == 2000) {
                                $query .= '(NULL,
									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									\'' . mysql_real_escape_string($directory_customer[$k]) . '\',
									\'' . mysql_real_escape_string($password[$k]) . '\',
									\'' . mysql_real_escape_string($pass) . '\',
									\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
									91,
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
									11,
									NULL,
									\'' . mysql_real_escape_string($curr_time) . '\');';
                                $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL);';
                                $query3 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($user_type) . '\',
									\'' . mysql_real_escape_string($show) . '\');';
                                $query4 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
									\'' . mysql_real_escape_string($active) . '\');';
                                //  $query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
                            } else {
                                $query .= '(NULL,
									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									\'' . mysql_real_escape_string($directory_customer[$k]) . '\',
									\'' . mysql_real_escape_string($password[$k]) . '\',
									\'' . mysql_real_escape_string($pass) . '\',
									\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
									91,
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
									11,
									NULL,
									\'' . mysql_real_escape_string($curr_time) . '\'),';
                                $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL),';
                                $query3 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($user_type) . '\',
									\'' . mysql_real_escape_string($show) . '\'),';
                                $query4 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
									\'' . mysql_real_escape_string($active) . '\'),';
                                //  $query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending'),";
                            }
                            $k++;
                        }
                    }
                    //  $query = 'INSERT INTO `trainers`(`id`,`name`,`email_id`,`acs_id`,`password`,`apassword`,`sex`,`cell_number`,`status`,`passwordreset`,`hired_date`,`fired_date`,`Gym`,`Aerobics`,`Dance`,`Yoga`,`Zumba`)  VALUES';
                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                    $query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`acs_id`,`photo_id`,`directory`,`password`,`apassword`,`gender`,`dob`,`cell_code`,`cell_number`,`status`,`passwordreset`,`date_of_join`)  VALUES';
                    $query3 = 'INSERT INTO `userprofile_type`(`id`,`user_pk`,`usertype_id`,`status`) VALUES';
                    $query4 = 'INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`) VALUES';
                    if ($rem > 0) {
                        $remaining = $total - ($qut * 2000);
                        for ($j = 1; $j <= $remaining; $j++) {
                            //  if(checkExistence(false,$fields['EMAIL'][$k],false) == 'failed'){
                            $password[$k] = generateRandomString();
                            $pass = md5($password[$k]);
                            $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_cust_' . ($user_pk + $k));
                            //  ~ $this->sendMail(array (
                            //  ~ "name" 		=> $fields["NAME"][$k],
                            //  ~ "login_id" 	=> $fields["EMAIL"][$k],
                            //  ~ "password" 	=> $password[$k],
                            //  ~ "acs_id" 	=> $fields["ACS_ID"][$k]
                            //  ~ ));
                            if ($j == $remaining) {
                                //  $query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',default,NULL,\''.mysql_real_escape_string($curr_time).'\',NULL,\''.mysql_real_escape_string($fields['TRAINERGYM'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERAER'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERDAN'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERYOG'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERZUM'][$k]).'\');';
                                $query .= '(NULL,
									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									\'' . mysql_real_escape_string($directory_customer[$k]) . '\',
									\'' . mysql_real_escape_string($password[$k]) . '\',
									\'' . mysql_real_escape_string($pass) . '\',
									\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
									91,
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
									11,
									NULL,
									\'' . mysql_real_escape_string($curr_time) . '\');';
                                $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL);';
                                $query3 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($user_type) . '\',
									\'' . mysql_real_escape_string($show) . '\');';
                                $query4 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
									\'' . mysql_real_escape_string($active) . '\');';
                                //  $query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
                            } else {
                                //  $query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',default,NULL,\''.mysql_real_escape_string($curr_time).'\',NULL,\''.mysql_real_escape_string($fields['TRAINERGYM'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERAER'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERDAN'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERYOG'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERZUM'][$k]).'\'),';
                                $query .= '(NULL,
									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									\'' . mysql_real_escape_string($directory_customer[$k]) . '\',
									\'' . mysql_real_escape_string($password[$k]) . '\',
									\'' . mysql_real_escape_string($pass) . '\',
									\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
									91,
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
									11,
									NULL,
									\'' . mysql_real_escape_string($curr_time) . '\'),';
                                $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL),';
                                $query3 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($user_type) . '\',
									\'' . mysql_real_escape_string($show) . '\'),';
                                $query4 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
									\'' . mysql_real_escape_string($active) . '\'),';
                                //  $query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending'),";
                            }
                            $k++;
                            //  }
                        }
                    }
                } else if ($total < 2000 && $total >= 1) {
                    $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                    $photo_pk = mysql_result(executeQuery($query1), 0);
                    $query2 = 'SELECT `id` FROM `user_profile` ORDER BY `id` DESC LIMIT 1';
                    $user_pk = mysql_result(executeQuery($query2), 0);
                    //  $query = 'INSERT INTO `trainers`(`id`,`name`,`email_id`,`acs_id`,`password`,`apassword`,`sex`,`cell_number`,`status`,`passwordreset`,`hired_date`,`fired_date`,`Gym`,`Aerobics`,`Dance`,`Yoga`,`Zumba`)  VALUES';
                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                    $query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`acs_id`,`photo_id`,`directory`,`password`,`apassword`,`gender`,`dob`,`cell_code`,`cell_number`,`status`,`passwordreset`,`date_of_join`)  VALUES';
                    $query3 = 'INSERT INTO `userprofile_type`(`id`,`user_pk`,`usertype_id`,`status`) VALUES';
                    $query4 = 'INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`) VALUES';
                    for ($i = 1; $i <= $total; $i++) {
                        //  if(checkExistence(false,$fields['EMAIL'][$k],false) == 'failed'){
                        $password[$k] = generateRandomString();
                        $pass = md5($password[$k]);
                        $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_cust_' . ($user_pk + $k));
                        //  ~ $this->sendMail(array (
                        //  ~ "name" 		=> $fields["NAME"][$k],
                        //  ~ "login_id" 	=> $fields["EMAIL"][$k],
                        //  ~ "password" 	=> $password[$k],
                        //  ~ "acs_id" 	=> $fields["ACS_ID"][$k]
                        //  ~ ));
                        if ($i == $total) {
                            //  $query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',default,NULL,\''.mysql_real_escape_string($curr_time).'\',NULL,\''.mysql_real_escape_string($fields['TRAINERGYM'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERAER'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERDAN'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERYOG'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERZUM'][$k]).'\');';
                            $query .= '(NULL,
								\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
								\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
								\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
								\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
								\'' . mysql_real_escape_string($directory_customer) . '\',
								\'' . mysql_real_escape_string($password[$k]) . '\',
								\'' . mysql_real_escape_string($pass) . '\',
								\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
								\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
								91,
								\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
								11,
								NULL,
								\'' . mysql_real_escape_string($curr_time) . '\');';
                            $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL);';
                            $query3 .='(NULL,
								\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
								\'' . mysql_real_escape_string($user_type) . '\',
								\'' . mysql_real_escape_string($show) . '\');';
                            $query4 .='(NULL,
								\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
								\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
								\'' . mysql_real_escape_string($active) . '\');';
                            //  $query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending');";
                        } else {
                            //  $query .= '(NULL,\''.mysql_real_escape_string($fields['NAME'][$k]).'\',\''.mysql_real_escape_string($fields['EMAIL'][$k]).'\',\''.mysql_real_escape_string($fields['ACS_ID'][$k]).'\',\''.mysql_real_escape_string($password[$k]).'\',\''.mysql_real_escape_string($pass).'\',\''.mysql_real_escape_string($fields['GENDER'][$k]).'\',\''.mysql_real_escape_string($fields['MOBILE'][$k]).'\',default,NULL,\''.mysql_real_escape_string($curr_time).'\',NULL,\''.mysql_real_escape_string($fields['TRAINERGYM'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERAER'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERDAN'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERYOG'][$k]).'\',\''.mysql_real_escape_string($fields['TRAINERZUM'][$k]).'\'),';
                            $query .= '(NULL,
								\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
								\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
								\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
								\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
								\'' . mysql_real_escape_string($directory_customer) . '\',
								\'' . mysql_real_escape_string($password[$k]) . '\',
								\'' . mysql_real_escape_string($pass) . '\',
								\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
								\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
								91,
								\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
								11,
								NULL,
								\'' . mysql_real_escape_string($curr_time) . '\'),';
                            $query1 .='(\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',NULL,NULL,NULL,NULL,NULL),';
                            $query3 .='(NULL,
								\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
								\'' . mysql_real_escape_string($user_type) . '\',
								\'' . mysql_real_escape_string($show) . '\'),';
                            $query4 .='(NULL,
								\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
								\'' . mysql_real_escape_string($this->parameters["GYM_ID"]) . '\',
								\'' . mysql_real_escape_string($active) . '\'),';
                            //  $query0 .= "(NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($fields['EMAIL'][$k])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'pending'),";
                        }
                        $data[] = array(
                            "user_id" => $user_pk + $k,
                            "directory" => $directory_customer,
                        );
                        $k++;
                    }
                }
                if ($total) {
                    if (executeQuery($query1)) {
                        $res = executeQuery($query);
                        if ($res) {
                            $res = executeQuery($query3);
                            if ($res) {
                                $res = executeQuery($query4);
                                if ($res) {
                                    $this->slaveAddBulk($data, $fields);
                                    $flag = true;
                                    echo '<h2>' . ($k - 1) . ' customer have been inserted in to database!!!</h2>';
                                }
                            }
                        }
                    }
                }
            }
        }
        if (get_resource_type($link) == 'mysql link')
            mysql_close($link);
        return $flag;
    }

    /* This */

    public function slaveAddBulk($data, $fields) {
        $flag = false;
        $query = false;
        $total = sizeof($fields['EMAIL']);
        $k = 1;
        $link = MySQLconnect($this->parameters["GYM_HOST"], $this->parameters["GYM_USERNAME"], $this->parameters["GYM_DB_PASSWORD"]);
        if (get_resource_type($link) == 'mysql link') {
            if (($db_select = selectDB($this->parameters["GYM_DB_NAME"], $link)) == 1) {
                $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
                $password = array();
                if (($this->parameters["facility_type"]) == false) {
                    if ($total > 1999) {
                        $qut = floor($total / 2000);
                        $rem = $total % 2000;
                        for ($i = 1; $i <= $qut; $i++) {
                            $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                            $photo_pk = mysql_result(executeQuery($query1), 0);
                            $query2 = 'SELECT `id` FROM `customer` ORDER BY `id` DESC LIMIT 1';
                            $user_pk = mysql_result(executeQuery($query2), 0);
                            //  all querry for trainer save entry
                            $query = 'INSERT INTO `customer` (`id`,`name`,`email`,`acs_id`,`photo_id`,`cell_code`,`cell_number`,`directory`,`dob`,`sex`,`master_pk`,`status`) VALUES';
                            $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                            //  $query2='INSERT INTO `customer_facility`(`id`,`customer_pk`,`facility_id`,`status`) VALUES';
                            for ($j = 1; $j <= 2000 && $j <= $num1; $j++) {
                                if ($i == $total) {
                                    $query .= '(NULL,
										\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										91,
										\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
										\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										2);';
                                    $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										NULL,NULL,NULL,NULL,NULL);';
                                    //  $query2 .='(NULL,
                                    //  \''.mysql_real_escape_string(($user_pk+$k)).'\',
                                    //  \''.mysql_real_escape_string($this->parameters["facility_type"]).'\',
                                    //  4);';
                                } else {
                                    $query .= '(NULL,
										\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										91,
										\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
										\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										2),';
                                    $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										NULL,NULL,NULL,NULL,NULL),';
                                    //  $query2 .='(NULL,
                                    //  \''.mysql_real_escape_string(($user_pk+$k)).'\',
                                    //  \''.mysql_real_escape_string($this->parameters["facility_type"]).'\',
                                    //  4),';
                                }
                                $k++;
                            }
                        }
                        $query = 'INSERT INTO `customer` (`id`,`name`,`email`,`acs_id`,`photo_id`,`cell_code`,`cell_number`,`directory`,`dob`,`sex`,`master_pk`,`status`) VALUES';
                        $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        //  $query2='INSERT INTO `customer_facility`(`id`,`customer_pk`,`facility_id`,`status`) VALUES';
                        if ($rem > 0) {
                            $remaining = $total - ($qut * 2000);
                            for ($j = 1; $j <= $remaining; $j++) {
                                if ($i == $total) {
                                    $query .= '(NULL,
										\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										91,
										\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
										\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										2);';
                                    $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										NULL,NULL,NULL,NULL,NULL);';
                                    //  $query2 .='(NULL,
                                    //  \''.mysql_real_escape_string(($user_pk+$k)).'\',
                                    //  \''.mysql_real_escape_string($this->parameters["facility_type"]).'\',
                                    //  4);';
                                } else {
                                    $query .= '(NULL,
										\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										91,
										\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
										\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										2),';
                                    $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										NULL,NULL,NULL,NULL,NULL),';
                                    //  $query2 .='(NULL,
                                    //  \''.mysql_real_escape_string(($user_pk+$k)).'\',
                                    //  \''.mysql_real_escape_string($this->parameters["facility_type"]).'\',
                                    //  4),';
                                }
                                $k++;
                            }
                        }
                    } else if ($total < 2000 && $total >= 1) {
                        $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                        $photo_pk = mysql_result(executeQuery($query1), 0);
                        $query2 = 'SELECT `id` FROM `customer` ORDER BY `id` DESC LIMIT 1';
                        $user_pk = mysql_result(executeQuery($query2), 0);
                        //  all querry for trainer save entry
                        $query = 'INSERT INTO `customer` (`id`,`name`,`email`,`acs_id`,`photo_id`,`cell_code`,`cell_number`,`directory`,`dob`,`sex`,`master_pk`,`status`) VALUES';
                        $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        //  $query2='INSERT INTO `customer_facility`(`id`,`customer_pk`,`facility_id`,`status`) VALUES';
                        //  $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        //  $query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`acs_id`,`photo_id`,`directory`,`password`,`apassword`,`gender`,`dob`,`cell_code`,`cell_number`,`status`,`passwordreset`,`date_of_join`)  VALUES';
                        //  $query3='INSERT INTO `userprofile_type`(`id`,`user_pk`,`usertype_id`,`status`) VALUES';
                        //  $query4='INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`) VALUES';
                        for ($i = 1; $i <= $total; $i++) {
                            if ($i == $total) {
                                $query .= '(NULL,
									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									91,
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
									\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
									\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
									\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
									2);';
                                $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									NULL,NULL,NULL,NULL,NULL);';
                                //  $query2 .='(NULL,
                                //  \''.mysql_real_escape_string(($user_pk+$k)).'\',
                                //  \''.mysql_real_escape_string($this->parameters["facility_type"]).'\',
                                //  4);';
                            } else {
                                $query .= '(NULL,
									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									91,
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
									\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
									\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
									\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
									2),';
                                $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									NULL,NULL,NULL,NULL,NULL),';
                                //  $query2 .='(NULL,
                                //  \''.mysql_real_escape_string(($user_pk+$k)).'\',
                                //  \''.mysql_real_escape_string($this->parameters["facility_type"]).'\',
                                //  4),';
                            }
                            $k++;
                        }
                    }
                } else {
                    if ($total > 1999) {
                        $qut = floor($total / 2000);
                        $rem = $total % 2000;
                        for ($i = 1; $i <= $qut; $i++) {
                            $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                            $photo_pk = mysql_result(executeQuery($query1), 0);
                            $query2 = 'SELECT `id` FROM `customer` ORDER BY `id` DESC LIMIT 1';
                            $user_pk = mysql_result(executeQuery($query2), 0);
                            //  all querry for trainer save entry
                            $query = 'INSERT INTO `customer` (`id`,`name`,`email`,`acs_id`,`photo_id`,`cell_code`,`cell_number`,`directory`,`dob`,`sex`,`master_pk`,`status`) VALUES';
                            $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                            $query2 = 'INSERT INTO `customer_facility`(`id`,`customer_pk`,`facility_id`,`status`) VALUES';
                            for ($j = 1; $j <= 2000 && $j <= $num1; $j++) {
                                if ($i == $total) {
                                    $query .= '(NULL,
										\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										91,
										\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
										\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										2);';
                                    $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										NULL,NULL,NULL,NULL,NULL);';
                                    $query2 .='(NULL,
										\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
										\'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
										4);';
                                } else {
                                    $query .= '(NULL,
										\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										91,
										\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
										\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										2),';
                                    $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										NULL,NULL,NULL,NULL,NULL),';
                                    $query2 .='(NULL,
										\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
										\'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
										4),';
                                }
                                $k++;
                            }
                        }
                        $query = 'INSERT INTO `customer` (`id`,`name`,`email`,`acs_id`,`photo_id`,`cell_code`,`cell_number`,`directory`,`dob`,`sex`,`master_pk`,`status`) VALUES';
                        $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        $query2 = 'INSERT INTO `customer_facility`(`id`,`customer_pk`,`facility_id`,`status`) VALUES';
                        if ($rem > 0) {
                            $remaining = $total - ($qut * 2000);
                            for ($j = 1; $j <= $remaining; $j++) {
                                if ($i == $total) {
                                    $query .= '(NULL,
										\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										91,
										\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
										\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										2);';
                                    $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										NULL,NULL,NULL,NULL,NULL);';
                                    $query2 .='(NULL,
										\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
										\'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
										4);';
                                } else {
                                    $query .= '(NULL,
										\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										91,
										\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
										\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
										\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
										\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										2),';
                                    $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
										\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
										NULL,NULL,NULL,NULL,NULL),';
                                    $query2 .='(NULL,
										\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
										\'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
										4),';
                                }
                                $k++;
                            }
                        }
                    } else if ($total < 2000 && $total >= 1) {
                        $query1 = 'SELECT `id` FROM `photo` ORDER BY `id` DESC LIMIT 1';
                        $photo_pk = mysql_result(executeQuery($query1), 0);
                        $query2 = 'SELECT `id` FROM `customer` ORDER BY `id` DESC LIMIT 1';
                        $user_pk = mysql_result(executeQuery($query2), 0);
                        //  all querry for trainer save entry
                        $query = 'INSERT INTO `customer` (`id`,`name`,`email`,`acs_id`,`photo_id`,`cell_code`,`cell_number`,`directory`,`dob`,`sex`,`master_pk`,`status`) VALUES';
                        $query1 = 'INSERT INTO  `photo` (`master_pk`,`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        $query2 = 'INSERT INTO `customer_facility`(`id`,`customer_pk`,`facility_id`,`status`) VALUES';
                        //  $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        //  $query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`acs_id`,`photo_id`,`directory`,`password`,`apassword`,`gender`,`dob`,`cell_code`,`cell_number`,`status`,`passwordreset`,`date_of_join`)  VALUES';
                        //  $query3='INSERT INTO `userprofile_type`(`id`,`user_pk`,`usertype_id`,`status`) VALUES';
                        //  $query4='INSERT INTO `userprofile_gymprofile`(`id`,`user_pk`,`gym_id`,`status`) VALUES';
                        for ($i = 1; $i <= $total; $i++) {
                            if ($i == $total) {
                                $query .= '(NULL,
									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									91,
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
									\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
									\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
									\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
									2);';
                                $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									NULL,NULL,NULL,NULL,NULL);';
                                $query2 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
									4);';
                            } else {
                                $query .= '(NULL,
									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['ACS_ID'][$k]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									91,
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
									\'' . mysql_real_escape_string($data[$i - 1]["directory"]) . '\',
									\'' . mysql_real_escape_string($fields['DOB'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['GENDER'][$k]) . '\',
									\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
									2),';
                                $query1 .='(\'' . mysql_real_escape_string($data[$i - 1]["user_id"]) . '\',
									\'' . mysql_real_escape_string(($photo_pk + $k)) . '\',
									NULL,NULL,NULL,NULL,NULL),';
                                $query2 .='(NULL,
									\'' . mysql_real_escape_string(($user_pk + $k)) . '\',
									\'' . mysql_real_escape_string($this->parameters["facility_type"]) . '\',
									4),';
                            }
                            $k++;
                        }
                    }
                }
                if ($total) {
                    if (($this->parameters["facility_type"]) == false) {
                        if (executeQuery($query1)) {
                            $res = executeQuery($query);
                            if ($res) {
                                $flag = true;
                                //  echo '<h2>'.($k-1) .' customer have been inserted in to database!!!</h2>';
                            }
                        }
                    } else {
                        if (executeQuery($query1)) {
                            $res = executeQuery($query);
                            if ($res) {
                                $res = executeQuery($query2);
                                if ($res) {
                                    $flag = true;
                                    //  echo '<h2>'.($k-1) .' customer have been inserted in to database!!!</h2>';
                                }
                            }
                        }
                    }
                }
            }
        }
        if (get_resource_type($link) == 'mysql link')
            mysql_close($link);
        return $flag;
    }

    /* This */

    public function sendMail($parameters) {
        $message = '<table width="80%" border="0" align="center" cellpadding="3" cellspacing="3">
			<tr>
			<td><p><span style="font-weight:900; font-size:24px;  color:#999;">' . GYMNAME . ' account details.</span></p></td>
			<td><img src="' . GYM_LOGO . '" width="75" alt="Gym Avatar"/></td>
			</tr>
			<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
			<td width="50%" align="right">Name :</td>
			<td width="50%">' . $parameters["name"] . '</td>
			</tr>
			<tr>
			<td width="50%" align="right">Login id :</td>
			<td width="50%">' . $parameters["login_id"] . '</td>
			</tr>
			<tr>
			<td width="50%" align="right">Password :</td>
			<td width="50%">' . $parameters["password"] . '</td>
			</tr>
			<tr>
			<td width="50%" align="right">Access Id :</td>
			<td width="50%">' . $parameters["acs_id"] . '</td>
			</tr>
			<tr>
			<td colspan="2"><p>you received this email because you are member of ' . GYMNAME . '.</p></td>
			</tr>
			<tr>
			<td colspan="2">Regards,<br />The MadMec team</td>
			</tr>
			<tr>
			<td colspan="2"><p><a href="https:</www.facebook.com/madmec2013"><img src="http:</code.madmec.com/images/f_logo.jpg" alt="" width="40" height="40" /></a> <a href="http:</www.linkedin.com/company/madmec"><img src="http:</code.madmec.com/images/li.jpg" alt="" width="40" height="40" /></a> <a href="http:</madmecteam.blogspot.in/2013_12_01_archive.html"><img src="http:</code.madmec.com/images/bs.jpg" alt="" width="40" height="40" /></a> <a href="https:</plus.google.com/103775735801000838114/posts"><img src="http:</code.madmec.com/images/gp.jpg" alt="" width="40" height="40" /></a> <a href="https:</www.google.co.in/maps/place/MadMec/@12.898059,77.588587,17z/data=!3m1!4b1!4m2!3m1!1s0x3bae153e3a2818d3:0x90da24ba7189f291"><img src="http:</code.madmec.com/images/map.jpg" alt="" width="40" height="40" /></a></p></td>
			</tr>
			<tr>
			<td colspan="2"><p><h4>Do not reply to this mail.</h4></p></td>
			</tr>
			</table>';
        $mailParameters = array(
            "server" => mt_rand(0, 2),
            "target_host" => explode("@", $fields["EMAIL"])[1],
            "to" => $fields["EMAIL"],
            "title" => GYMNAME,
            "subject" => GYMNAME . " :: Congrats you have successfully registered.",
            "message" => $message,
            "message_type" => "Reset"
        );
        Alert($mailParameters);
    }

    /* This */

    public function listRegCust($tabId) {
        $listusers = NULL;
        $query = 'SELECT
				a.`id`,
				CASE WHEN a.`ver2` IS NULL OR a.`ver2` = ""
				THEN "' . USER_ANON_IMAGE . '"
				ELSE CONCAT("' . URL . DIRS . '",a.`ver2`)
				END AS photo,
				a.`master_pk`,
				a.`name`,
				a.`email`,
				a.`acs_id`,
				a.`cell_number`,
				a.`dob`,
				a.`occupation`,
				a.`sex`,
				a.`date_of_join` AS jnd,
				a.`emergency_name`,
				a.`emergency_num`,
				a.`addressline`,
				a.`town`,
				a.`city`,
				a.`district`,
				a.`province`,
				a.`country`,
				a.`receipt_no` AS reg_rpt_no,
				a.`fee` AS reg_fee,
				a.`status`,
				e.`mt_pk`,
				e.`mt_uid`,
				e.`inv_tt`,
				e.`inv_tid`,
				e.`mt_pod`,
				e.`mt_rpt`,
				e.`tot_amt`,
				e.`mop`,
				e.`inv_urls`,
				e.`money_trans_id`,
				e.`due_id`,
				e.`due_amount`,
				e.`due_date`,
				e.`due_status`
				FROM (
					SELECT c.*,p.`ver2`
					FROM `customer` AS c
					LEFT JOIN `photo` AS p ON p.`id` = c.`photo_id`
					WHERE  c.`master_pk` != 0
					AND c.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR `statu_name` = "Hide" OR `statu_name` = "Delete" OR `statu_name` = "Fired" OR `statu_name` = "Inactive"))
				)AS a
				LEFT  JOIN (
				SELECT
					GROUP_CONCAT(mtr.`id`)  			AS mt_pk,
					mtr.`customer_pk` 					AS mt_uid,
					GROUP_CONCAT(inv.`name`) 			AS inv_tt,
					GROUP_CONCAT(inv.`transaction_id`) 	AS inv_tid,
					GROUP_CONCAT((SELECT `pay_date` FROM `money_transactions` WHERE `id` = inv.`transaction_id`))	AS mt_pod,
					GROUP_CONCAT(DISTINCT(mtr.`receipt_no`))AS mt_rpt,
					GROUP_CONCAT(temp1.`total`)			AS tot_amt,
					GROUP_CONCAT(temp2.`gmop`)			AS mop,
					GROUP_CONCAT(inv.`inv_urls`) 		AS inv_urls,
					due.`duser` 						AS due_user,
					GROUP_CONCAT(due.`money_trans_id`) 	AS money_trans_id,
					GROUP_CONCAT(due.`due_id`) 			AS due_id,
					GROUP_CONCAT(due.`damt`) 			AS due_amount,
					GROUP_CONCAT(due.`ddate`) 			AS due_date,
					GROUP_CONCAT(due.`dstatus`) 		AS due_status
				FROM `money_transactions` AS mtr
				LEFT JOIN (
				SELECT
					IF(temp3.`due_id` IS NULL, \'NA\', temp3.`due_id`) AS due_id,
					IF(temp3.`due_amt` IS NULL, \'NA\', temp3.`due_amt`) AS damt,
					IF(temp3.`due_date` IS NULL, \'NA\', temp3.`due_date`) AS ddate,
					IF(temp3.`due_status` IS NULL, \'NA\', temp3.`due_status`) AS dstatus,
					temp3.`duser` AS duser,
					IF(temp3.`money_trans_id` IS NULL, \'NA\', temp3.`money_trans_id`) AS money_trans_id,
					temp3.`rrr`
				FROM (
					SELECT
						tmtr.`receipt_no` 		AS rrr,
						tinv.`id` 			AS due_id,
						tinv.`money_trans_id` 		AS money_trans_id,
						tinv.`due_amount`		AS due_amt,
						tinv.`due_date` 		AS due_date,
						tmtr.`customer_pk`		AS duser,
						tinv.`status` 			AS due_status
					FROM `money_transactions` AS tmtr
					LEFT JOIN (
						SELECT `id`,
							`money_trans_id`,
							`due_amount`,
							`due_date`,
							`customer_pk`,
							`status`
						FROM `money_trans_due`
					) AS tinv ON tmtr.`id` = tinv.`money_trans_id`
					GROUP BY (tmtr.`id`)
				) AS temp3
				GROUP BY (temp3.`rrr`)
			) AS due ON due.`rrr` = mtr.`receipt_no`
			LEFT JOIN (
				SELECT
					`customer_pk`	AS inv_users,
					`location` 	AS inv_urls,
					`transaction_id`,
					`name`
				FROM `invoice`
				GROUP BY(`transaction_id`)
			) AS inv ON inv.`transaction_id` = mtr.`id`
			LEFT JOIN(
				SELECT
					`id`,
					`receipt_no`,
					SUM(`total_amount`) AS total
				FROM `money_transactions`
				GROUP BY (`receipt_no`)
			) AS temp1 ON temp1.`id` = mtr.`id`
			LEFT JOIN(
				SELECT
					`id`,
					`receipt_no`,
					CONCAT(\'(\',GROUP_CONCAT(CONCAT(`total_amount` ,\' through \', (SELECT CASE WHEN `name` = \'Cash\' THEN \'Cash\' ELSE CASE WHEN `transaction_number` IS NULL THEN  `name` ELSE CASE WHEN LENGTH(`transaction_number`) = 0 THEN CONCAT (`name`, \' and \', `name`, \' No = Not provided\')  ELSE CONCAT (`name`, \' and \', `name`, \' No = \',`transaction_number`) END END END  FROM `mode_of_payment`  WHERE `id` = `mop_id`  AND `status` = 4)  )),\')\') AS gmop
				FROM `money_transactions`
				GROUP BY (`receipt_no`)
			) AS temp2 ON temp2.`id` = mtr.`id`
			GROUP BY (mtr.`customer_pk`)
			) AS e ON e.`mt_uid` = a.`id`
			ORDER BY (a.`id`) DESC;';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $i = 0;
            while ($row1 = mysql_fetch_assoc($res)) {
                $listusers[$i]['id'] = $row1['id'];
                $listusers[$i]['master_pk'] = $row1['master_pk'];
                $listusers[$i]['photo'] = $row1['photo'];
                $listusers[$i]['name'] = $row1['name'];
                $listusers[$i]['email_id'] = $row1['email'];
                $listusers[$i]['cell_number'] = $row1['cell_number'];
                $listusers[$i]['acs_id'] = $row1['acs_id'];
                $listusers[$i]['occupation'] = $row1['occupation'];
                $listusers[$i]['dob'] = $row1['dob'];
                $listusers[$i]['sex'] = $row1['sex'];
                $listusers[$i]['date_of_join'] = date('F j, Y, g:i a', strtotime($row1['jnd']));
                $listusers[$i]['status'] = $row1['status'];
                /* Account stats */
                if ($row1['mt_uid']) {
                    $listusers[$i]['accounts'] = array();
                    $listusers[$i]['accounts']['mt_uid'] = $row1['mt_uid'];
                    $listusers[$i]['accounts']['inv_tt'] = explode(",", $row1['inv_tt']);
                    $listusers[$i]['accounts']['mt_pod'] = explode(",", $row1['mt_pod']);
                    $listusers[$i]['accounts']['mt_rpt'] = explode(",", $row1['mt_rpt']);
                    $listusers[$i]['accounts']['tot_amt'] = explode(",", $row1['tot_amt']);
                    $listusers[$i]['accounts']['mop'] = explode("),", $row1['mop']);
                    $listusers[$i]['accounts']['inv_urls'] = explode(",", $row1['inv_urls']);
                    $listusers[$i]['accounts']['due_amount'] = explode(",", $row1['due_amount']);
                    $listusers[$i]['accounts']['due_id'] = explode(",", $row1['due_id']);
                    $listusers[$i]['accounts']['money_trans_id'] = explode(",", $row1['money_trans_id']);
                    $listusers[$i]['accounts']['due_date'] = explode(",", $row1['due_date']);
                    $listusers[$i]['accounts']['due_status'] = explode(",", $row1['due_status']);
                } else {
                    $listusers[$i]['accounts'] = NULL;
                }
                //  if($row1['valid_till'])
                //  $listusers[$i]['exp_date'] = date('j-M-Y', strtotime($listusers[$i]['fee']['valid_till'][sizeof($listusers[$i]['fee']['valid_till'])-1]));
                //  else
                //  $listusers[$i]['exp_date'] = NULL;
                $i++;
            }
        }
        $_SESSION["listofreg"] = $listusers;
        return $listusers;
    }

}
?>