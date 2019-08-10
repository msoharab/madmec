<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
//require_once(CONFIG_ROOT . MODULE_3);
require_once(MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
require_once(LIB_ROOT . 'PHPExcel_1.7.9/Classes/PHPExcel.php');

class empImport {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function importTimeLogger() {
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
                                    if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_ACTIVITY) {
                                        $importdata['ACTIVITY'] = array();
                                        for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                            $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                            $importdata['ACTIVITY'][$j] = isset($temp) ? $temp : NULL;
                                        }
                                    } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_ACTIVITY_DESC) {
                                        $importdata['DESCRIPTION'] = array();
                                        for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                            $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                            $importdata['DESCRIPTION'][$j] = isset($temp) ? $temp : NULL;
                                        }
                                    } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_ACTIVITY_FROM) {
                                        $importdata['FROM'] = array();
                                        for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                            $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                            $importdata['FROM'][$j] = isset($temp) ? $temp : NULL;
                                        }
                                    } else if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() == EXCEL_ACTIVITY_TO) {
                                        $importdata['TO'] = array();
                                        for ($row = 2, $j = 1; $row <= $highestRow; ++$row, $j++) {
                                            $temp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                            $importdata['TO'][$j] = isset($temp) ? $temp : NULL;
                                        }
                                    }
                                }
                                if (is_array($importdata)) {
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
                if (!$flag)
                    echo '<h2>0 records in file!!!</h2>';
            }
            unset($_FILE);
        }
    }

    public function checkForBulkExistenceEmpID($fields, $email = false, $cell_number = false) {
        $flag = false;
        $query1 = false;
        $query2 = false;
        $total = sizeof($fields['ACTIVITY']);
        $email_ids = array();
        $cell_numbers = NULL;
        if ($total) {
            $k = 1;
            echo '<table border="1" cellpadding="2" cellspacing="2" width="920" align="center">';
            if ($email) {
                $m = 1;
                for ($i = 1; $i <= $total; $i++) {
                    if (date("Y-m-d H:i:s", strtotime($fields['FROM'][$i])) > date("Y-m-d H:i:s", strtotime($fields['TO'][$i]))) {
                        $email_ids[$m++] = $i;
                    }
                }
                if (sizeof($email_ids)) {
                    echo '<tr><td align="center" colspan="8">INVALID LOGIN TIMES</td></tr>
								<tr>
								<td align="right">No</td>
                                                                <td align="center">ACTIVITY</td>
                                                                <td align="center">DESCRIPTION</td>
                                                                <td align="center">FROM</td>
                                                                <td align="center">TO</td>
								</tr>';
                    for ($j = 1; $j <= sizeof($total); $j++) {
                        if ($email_ids[$j] == $j) {
                            echo '<tr>
								<td>' . $k . '</td>
								<td>' . $fields['ACTIVITY'][$j] . '</td>
								<td>' . $fields['DESCRIPTION'][$j] . '</td>
								<td>' . $fields['FROM'][$j] . '</td>
								<td>' . $fields['TO'][$j] . '</td>
								</tr>';
                            $flag = true;
                            $k++;
                        }
                    }
                }
                if (!$flag) {
                    echo '<tr><td align="center" colspan="5">Vaild Data</td></tr>';
                }
            }
            echo '</table><p>&nbsp;</p>';
        }
        return $flag;
    }

    public function AddBulk($fields) {
        $flag = false;
        $query = false;
        $total = sizeof($fields['ACTIVITY']);
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
                        $query1 = 'INSERT INTO  `projects_activity` (`id`, `project_id`, `created_by`, `created_at`, `updated_at`, `activity_name`, `description`, `status_id`)  VALUES';
                        for ($j = 1; $j <= 2000 && $j <= $num1; $j++) {
                            if ($j == 2000) {
                                $query1 .='(NULL,"' . mysql_real_escape_string($this->parameters['selectproject']) . '",'
                                        . '"' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '",now(),now(),'
                                        . '"' . mysql_real_escape_string($fields['ACTIVITY'][$j]) . '",'
                                        . '"' . mysql_real_escape_string($fields['DESCRIPTION'][$j]) . '",'
                                        . '4);';
                            } else {
                                $query1 .='(NULL,"' . mysql_real_escape_string($this->parameters['selectproject']) . '",'
                                        . '"' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '",now(),now(),'
                                        . '"' . mysql_real_escape_string($fields['ACTIVITY'][$j]) . '",'
                                        . '"' . mysql_real_escape_string($fields['DESCRIPTION'][$j]) . '",'
                                        . '4),';
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
                        $query1 = 'INSERT INTO  `projects_activity` (`id`, `project_id`, `created_by`, `created_at`, `updated_at`, `activity_name`, `description`, `status_id`)  VALUES';
                        $remaining = $total - ($qut * 2000);
                        for ($j = 1; $j <= $remaining; $j++) {
                            if ($i == $remaining) {
                                $query1 .='(NULL,"' . mysql_real_escape_string($_POST['selectproject']) . '",'
                                        . '"' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '",now(),now(),'
                                        . '"' . mysql_real_escape_string($fields['ACTIVITY'][$j]) . '",'
                                        . '"' . mysql_real_escape_string($fields['DESCRIPTION'][$j]) . '",'
                                        . '4);';
                            } else {
                                $query1 .='(NULL,"' . mysql_real_escape_string($_POST['selectproject']) . '",'
                                        . '"' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '",now(),now(),'
                                        . '"' . mysql_real_escape_string($fields['ACTIVITY'][$j]) . '",'
                                        . '"' . mysql_real_escape_string($fields['DESCRIPTION'][$j]) . '",'
                                        . '4),';
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
                    $query1 = 'INSERT INTO  `projects_activity` (`id`, `project_id`, `created_by`, `created_at`, `updated_at`, `activity_name`, `description`, `status_id`)  VALUES';
                    for ($i = 1; $i <= $total; $i++) {
                        if ($i == $total) {
                            $query1 .='(NULL,"' . mysql_real_escape_string($_POST['selectproject']) . '",'
                                    . '"' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '",now(),now(),'
                                    . '"' . mysql_real_escape_string($fields['ACTIVITY'][$i]) . '",'
                                    . '"' . mysql_real_escape_string($fields['DESCRIPTION'][$i]) . '",'
                                    . '4);';
                        } else {
                            $query1 .='(NULL,"' . mysql_real_escape_string($_POST['selectproject']) . '",'
                                    . '"' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '",now(),now(),'
                                    . '"' . mysql_real_escape_string($fields['ACTIVITY'][$i]) . '",'
                                    . '"' . mysql_real_escape_string($fields['DESCRIPTION'][$i]) . '",'
                                    . '4),';
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
                    echo '<h2>' . ($k - 1) . ' Details have been inserted in to database!!!</h2>';
                }
            }
        }
        if (get_resource_type($link) == 'mysql link')
            mysql_close($link);
        return $flag;
    }

    public function addcustomerImportData($kk, $fields, $lastid, $noofrowsaffted) {
        $k=$kk-$noofrowsaffted;
        $query = 'INSERT INTO `engage`(`id`, `project_activity_id`, `created_by`, `in_time`, `out_time`, `status_id`)  VALUES';
        for ($i = 0; $i < $noofrowsaffted; $i++) {
            if ($i == ($noofrowsaffted - 1)) {
                $query .= '(NULL,
                    \'' . mysql_real_escape_string(($lastid)) . '\',
                        \'' . mysql_real_escape_string(($_SESSION["USER_LOGIN_DATA"]['USER_ID'])) . '\',
									\'' . mysql_real_escape_string($fields['FROM'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['TO'][$k]) . '\',16);';
            } else {
                $query .= '(NULL,
                    \'' . mysql_real_escape_string(($lastid)) . '\',
                        \'' . mysql_real_escape_string(($_SESSION["USER_LOGIN_DATA"]['USER_ID'])) . '\',
									\'' . mysql_real_escape_string($fields['FROM'][$k]) . '\',
									\'' . mysql_real_escape_string($fields['TO'][$k]) . '\',16),';
            }
            $k++;
            $lastid++;
        }
        if (executeQuery($query)) {
            return true;
        }
    }

	public function languagesXLS(){
        $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
        if (get_resource_type($link) == 'mysql link') {
            if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
				$files = array(
					'./languages/AFRICA.xlsx',
					'./languages/ASIA.xlsx',
					'./languages/CARIBBEAN.xlsx',
					'./languages/Europe.xlsx',
					'./languages/MIDDLE_EAST.xlsx',
					'./languages/North_AndCentral_America.xlsx',
					'./languages/Oceania.xlsx',
					'./languages/South_America.xlsx'
				);
				for($i=0;$i<sizeof($files);$i++){
					$thefile1 = $files[$i];
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$objReader->setReadDataOnly(true);
					$objPHPExcel = $objReader->load($thefile1);
					for ($j=0; $j<$objPHPExcel->getSheetCount(); $j++){
						$objPHPExcel->setActiveSheetIndex($j);
						$objWorksheet = $objPHPExcel->getActiveSheet();
						$highestRow = $objWorksheet->getHighestRow();
						$highestColumn = $objWorksheet->getHighestColumn();
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
						if ($highestRow > 0 && $highestColumnIndex > 0) {
							$importdata = array();
							for ($row = 1; $row <= $highestRow; ++$row) {
								$query1 = 'INSERT INTO  `languages` (`Language Name`,`country_id`)  VALUES (';
								for ($col = 0; $col < $highestColumnIndex; ++$col) {
									if($col == ( $highestColumnIndex - 1)){
										$id = (int) $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
										if(gettype ($id) != 'integer'){
											echo '<p>'.$id .' = is not a number.</p>';
										}
										$query1 .= '"'.mysql_real_escape_string($id).'"';
									}
									else
										$query1 .= '"'.mysql_real_escape_string($objWorksheet->getCellByColumnAndRow($col, $row)->getValue()).'",';
								}
								$query1 .= ');';
								//executeQuery($query1);
								echo $query1 .'<hr />';
							}
						}
					}					
				}
			}
		}			
        if (get_resource_type($link) == 'mysql link')
            mysql_close($link);
	}
}

$obj = new empImport();
$obj->languagesXLS();
?>