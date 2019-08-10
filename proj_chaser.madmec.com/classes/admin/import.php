<?php

class adminImport {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    /* Import Individual Donors */

    public function importEmployees() {
        if (isset($_FILES['xls_cust_file']) && ($_FILES['xls_cust_file']['error'] == UPLOAD_ERR_OK)) { {
                $flag = false;
                $importdata = NULL;
//                $importdata['NAME'] = NULL;
//                $importdata['GENDER'] = NULL;
//                $importdata['MOBILE'] = NULL;
//                $importdata['EMAIL'] = NULL;
//                $importdata['ACS_ID'] = NULL;
//                $importdata['CUSTOMERGYM'] = NULL;
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
                                    } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_EMPLOYEEID) {
                                        $importdata['EMPLOYEEID'] = array();
                                        for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                            $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                            $importdata['EMPLOYEEID'][$j] = isset($temp) ? $temp : NULL;
                                        }
                                    } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_TELEPHONE) {
                                        $importdata['TELEPHONE'] = array();
                                        for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                            $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                            $importdata['TELEPHONE'][$j] = isset($temp) ? $temp : NULL;
                                        }
                                    } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_ADDRESS) {
                                        $importdata['ADDRESS'] = array();
                                        for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                            $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                            $importdata['ADDRESS'][$j] = isset($temp) ? $temp : NULL;
                                        }
                                    }
                                }
                                if (is_array($importdata)) {
                                    if (!$this->checkForDuplicate($importdata, true, false)) { /* Email Id duplication */
                                        if (!$this->checkForBulkExistence($importdata, true, false)) { /* Email Id duplication in database */
                                              if (!$this->checkForDuplicateEmpID($importdata, true, false)) {
                                                  if (!$this->checkForBulkExistenceEmpID($importdata, true, false)) {
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
            unset($_FILE);
        }
    }

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
					<td align="center">MOBILE</td>
					<td align="center">EMAIL</td>
                                        <td align="center">EMPLOYEEID</td>
					<td align="center">TELEPHONE</td>
                                        <td align="center">ADDRESS</td>
					</tr>';
                for ($i = 1; $i <= $total; $i++) {
                    for ($j = $i + 1; $j <= $total; $j++) {
                        if ($fields['EMAIL'][$i] == $fields['EMAIL'][$j] && $fields['EMAIL'][$j]) {
                            echo '<tr>
								<td>' . $k . '</td>
								<td>' . $fields['NAME'][$j] . '</td>
								<td>' . $fields['GENDER'][$j] . '</td>
								<td align="right">' . $fields['MOBILE'][$j] . '</td>
								<td>' . $fields['EMAIL'][$j] . '</td>
								<td align="right">' . $fields['EMPLOYEEID'][$j] . '</td>
                                                                <td align="right">' . $fields['TELEPHONE'][$j] . '</td>
                                                                <td align="right">' . $fields['ADDRESS'][$j] . '</td>
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
            }
            echo '</table><p>&nbsp;</p>';
        }
        return $flag;
    }

    public function checkForDuplicateEmpID($fields, $email = false, $cell_number = false) {
        $total = sizeof($fields['EMPLOYEEID']);
        $flag = false;
        if ($total) {
            $k = 1;
            echo '<table border="1" cellpadding="2" cellspacing="2" width="920" align="center">';
            if ($email) {
                echo '<tr><td align="center" colspan="8">Duplicate Employee Ids in ' . $_FILES["xls_cust_file"]['name'] . '</td></tr>
					<tr>
					<td align="right">No</td>
					<td align="center">NAME</td>
					<td align="center">GENDER</td>
					<td align="center">MOBILE</td>
					<td align="center">EMAIL</td>
                                        <td align="center">EMPLOYEEID</td>
					<td align="center">TELEPHONE</td>
                                        <td align="center">ADDRESS</td>
					</tr>';
                for ($i = 1; $i <= $total; $i++) {
                    for ($j = $i + 1; $j <= $total; $j++) {
                        if ($fields['EMPLOYEEID'][$i] == $fields['EMPLOYEEID'][$j] && $fields['EMPLOYEEID'][$j]) {
                            echo '<tr>
								<td>' . $k . '</td>
								<td>' . $fields['NAME'][$j] . '</td>
								<td>' . $fields['GENDER'][$j] . '</td>
								<td align="right">' . $fields['MOBILE'][$j] . '</td>
								<td>' . $fields['EMAIL'][$j] . '</td>
								<td align="right">' . $fields['EMPLOYEEID'][$j] . '</td>
                                                                <td align="right">' . $fields['TELEPHONE'][$j] . '</td>
                                                                <td align="right">' . $fields['ADDRESS'][$j] . '</td>
								</tr>';
                            $fields['EMPLOYEEID'][$j] = NULL;
                            $flag = true;
                            $k++;
                        }
                    }
                }
                if (!$flag) {
                    echo '<tr><td align="center" colspan="8">No duplicatie Employee Ids ' . $_FILES["xls_cust_file"]['name'] . '</td></tr>';
                }
            }
            echo '</table><p>&nbsp;</p>';
        }
        return $flag;
    }

    /* This  */

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
                        $query = 'SELECT `email_id` AS email FROM `user_profile`;';
                        $res = executeQuery($query);
                        if (mysql_num_rows($res)) {
                            $email_ids = array();
                            $i = 1;
                            while ($row = mysql_fetch_assoc($res)) {
                                $email_ids[$i] = $row['email'];
                                $i++;
                            }
                        }
//                        echo print_r($email_ids);
                        if (is_array($email_ids)) {
                            echo '<tr><td align="center" colspan="8">Duplicate Email Ids  in database</td></tr>
								<tr>
								<td align="right">No</td>
                                                                <td align="center">NAME</td>
                                                                <td align="center">GENDER</td>
                                                                <td align="center">MOBILE</td>
                                                                <td align="center">EMAIL</td>
                                                                <td align="center">EMPLOYEEID</td>
                                                                <td align="center">TELEPHONE</td>
                                                                <td align="center">ADDRESS</td>
								</tr>';
                            for ($i = 1; $i <= $total; $i++) {
                                for ($j = 1; $j <= sizeof($email_ids); $j++) {
                                    if (($fields['EMAIL'][$i] == $email_ids[$j]) && $email_ids[$j]) {
                                        echo '<tr>
								<td>' . $k . '</td>
								<td>' . $fields['NAME'][$i] . '</td>
								<td>' . $fields['GENDER'][$i] . '</td>
								<td align="right">' . $fields['MOBILE'][$i] . '</td>
								<td>' . $fields['EMAIL'][$i] . '</td>
								<td align="right">' . $fields['EMPLOYEEID'][$i] . '</td>
                                                                    <td>' . $fields['TELEPHONE'][$i] . '</td>
                                                                        <td>' . $fields['ADDRESS'][$i] . '</td>
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
                    }
                    echo '</table><p>&nbsp;</p>';
                }
            }
            if (get_resource_type($link) == 'mysql link')
                mysql_close($link);
        }
        return $flag;
    }

    public function checkForBulkExistenceEmpID($fields, $email = false, $cell_number = false) {
        $flag = false;
        $query1 = false;
        $query2 = false;
        $total = sizeof($fields['EMPLOYEEID']);
        $email_ids = NULL;
        $cell_numbers = NULL;
        if ($total) {
            $k = 1;
            $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
            if (get_resource_type($link) == 'mysql link') {
                if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
                    echo '<table border="1" cellpadding="2" cellspacing="2" width="920" align="center">';
                    if ($email) {
                        $query = 'SELECT `emp_id` AS email FROM `user_profile`;';
                        $res = executeQuery($query);
                        if (mysql_num_rows($res)) {
                            $email_ids = array();
                            $i = 1;
                            while ($row = mysql_fetch_assoc($res)) {
                                $email_ids[$i] = $row['email'];
                                $i++;
                            }
                        }
//                        echo print_r($email_ids);
                        if (is_array($email_ids)) {
                            echo '<tr><td align="center" colspan="8">Duplicate EMPLOYEE Ids  in database</td></tr>
								<tr>
								<td align="right">No</td>
                                                                <td align="center">NAME</td>
                                                                <td align="center">GENDER</td>
                                                                <td align="center">MOBILE</td>
                                                                <td align="center">EMAIL</td>
                                                                <td align="center">EMPLOYEEID</td>
                                                                <td align="center">TELEPHONE</td>
                                                                <td align="center">ADDRESS</td>
								</tr>';
                            for ($i = 1; $i <= $total; $i++) {
                                for ($j = 1; $j <= sizeof($email_ids); $j++) {
                                    if (($fields['EMPLOYEEID'][$i] == $email_ids[$j]) && $email_ids[$j]) {
                                        echo '<tr>
								<td>' . $k . '</td>
								<td>' . $fields['NAME'][$i] . '</td>
								<td>' . $fields['GENDER'][$i] . '</td>
								<td align="right">' . $fields['MOBILE'][$i] . '</td>
								<td>' . $fields['EMAIL'][$i] . '</td>
								<td align="right">' . $fields['EMPLOYEEID'][$i] . '</td>
                                                                    <td>' . $fields['TELEPHONE'][$i] . '</td>
                                                                        <td>' . $fields['ADDRESS'][$i] . '</td>
								</tr>';
                                        $flag = true;
                                        $email_ids[$j] = NULL;
                                        $k++;
                                    }
                                }
                            }
                        }
                        if (!$flag) {
                            echo '<tr><td align="center" colspan="8">No duplicatie EMPLOYEE Ids in database</td></tr>';
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
                    $kk = $k;
                    executeQuery("SET AUTOCOMMIT=0;");
                    executeQuery("START TRANSACTION;");
                    for ($i = 1; $i <= $qut; $i++) {
                        $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        for ($j = 1; $j <= 2000 && $j <= $num1; $j++) {
                            if ($j == 2000) {
                                $query1 .='(NULL,NULL,NULL,NULL,NULL,NULL);';
                            } else {
                                $query1 .='(NULL,NULL,NULL,NULL,NULL,NULL),';
                            }
                            $k++;
                        }
                        if (executeQuery($query1)) {
                            $lastid = mysql_insert_id();
                            $noofrowsaffted = mysql_affected_rows();
                            if ($this->addcustomerImportData($k, $fields, $lastid, $noofrowsaffted)) {
                                executeQuery("COMMIT;");
                                $flag = true;
                            }
                        }
                    }
                    if ($rem > 0) {
                        executeQuery("SET AUTOCOMMIT=0;");
                        executeQuery("START TRANSACTION;");
                        $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                        $remaining = $total - ($qut * 2000);
                        for ($j = 1; $j <= $remaining; $j++) {
                            if ($i == $remaining) {
                                $query1 .='(NULL,NULL,NULL,NULL,NULL,NULL);';
                            } else {
                                $query1 .='(NULL,NULL,NULL,NULL,NULL,NULL),';
                            }
                            $k++;
                        }
                        if (executeQuery($query1)) {
                            $lastid = mysql_insert_id();
                            $noofrowsaffted = mysql_affected_rows();
                            if ($this->addcustomerImportData($k, $fields, $lastid, $noofrowsaffted)) {
                                executeQuery("COMMIT;");
                                $flag = true;
                            }
                        }
                    }
                } else if ($total < 2000 && $total >= 1) {
                    executeQuery("SET AUTOCOMMIT=0;");
                    executeQuery("START TRANSACTION;");
                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES';
                    for ($i = 1; $i <= $total; $i++) {
                        if ($i == $total) {
                            $query1 .='(NULL,NULL,NULL,NULL,NULL,NULL);';
                        } else {
                            $query1 .='(NULL,NULL,NULL,NULL,NULL,NULL),';
                        }
                        $k++;
                    }
                    if (executeQuery($query1)) {
                        $lastid = mysql_insert_id();
                        $noofrowsaffted = mysql_affected_rows();
                        if ($this->addcustomerImportData($k, $fields, $lastid, $noofrowsaffted)) {
                            executeQuery("COMMIT;");
                            $flag = true;
                        }
                    }
                }
                if ($total && $flag) {
                    echo '<h2>' . ($k - 1) . ' Employees have been inserted in to database!!!</h2>';
                }
            }
        }
        if (get_resource_type($link) == 'mysql link')
            mysql_close($link);
        return $flag;
    }

    public function addcustomerImportData($k, $fields, $lastid, $noofrowsaffted) {
        --$k;
        $query = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`emp_id`,`photo_id`,`directory`,`password`,`passwordreset`,`user_type_id`,
                `status`,`date_of_join`,`gender_id`,`cell_number`,`telephone`,`address`)  VALUES';
        for ($i = 0; $i < $noofrowsaffted; $i++) {
            $password = generateRandomString();
            $pass = md5($password);
            $gender_id = getGenderId($fields['GENDER'][$k]);
//            $occupation_id = getOccupationId($fields['OCCUPATION'][$k]);
            $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_customer_import_p' . $lastid);
            if ($i == ($noofrowsaffted - 1)) {
                $query .= '(NULL,

									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
                                                                            \'' . mysql_real_escape_string($fields['EMPLOYEEID'][$k]) . '\',
									\'' . mysql_real_escape_string(($lastid)) . '\',
									\'' . mysql_real_escape_string($directory_customer) . '\',
									\'' . mysql_real_escape_string($password) . '\',
									\'' . mysql_real_escape_string($pass) . '\',2,4,now(),
									\'' . mysql_real_escape_string($gender_id) . '\',
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
                                                                            \'' . mysql_real_escape_string($fields['TELEPHONE'][$k]) . '\',
                                                                            \'' . mysql_real_escape_string($fields['ADDRESS'][$k]) . '\');';
            } else {
                $query .= '(NULL,

									\'' . mysql_real_escape_string($fields['NAME'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['EMAIL'][$k]) . '\',
                                                                            \'' . mysql_real_escape_string($fields['EMPLOYEEID'][$k]) . '\',
									\'' . mysql_real_escape_string(($lastid)) . '\',
									\'' . mysql_real_escape_string($directory_customer) . '\',
									\'' . mysql_real_escape_string($password) . '\',
									\'' . mysql_real_escape_string($pass) . '\',2,4,now(),
									\'' . mysql_real_escape_string($gender_id) . '\',
									\'' . mysql_real_escape_string($fields['MOBILE'][$k]) . '\',
                                                                            \'' . mysql_real_escape_string($fields['TELEPHONE'][$k]) . '\',
                                                                            \'' . mysql_real_escape_string($fields['ADDRESS'][$k]) . '\'),';
            }
            $k--;
            $lastid++;
        }
        if (executeQuery($query)) {
            return true;
        }
    }

}

?>