<?php

class user {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    //Fetching Gender and Occupation
    public function fetchGendernOccupation() {
        $fetchdata1 = array();
        $data1 = '';
        $fetchdata2 = array();
        $data2 = '';
        $query1 = 'SELECT * FROM `gender` WHERE `status`=4';
        $result1 = executeQuery($query1);
        if (mysql_num_rows($result1)) {

            while ($row1 = mysql_fetch_assoc($result1)) {
                $fetchdata1[] = $row1;
            }
            for ($i = 0; $i < sizeof($fetchdata1); $i++) {
                $data1 .='<option value="' . $fetchdata1[$i]['id'] . '">' . $fetchdata1[$i]['gender_name'] . '</option>';
            }
        }
        $jsondata = array(
            "data1" => $data1,
            "data2" => $data2
        );
        return $jsondata;
    }

    /* Adding Individual Donor  */

    public function addEmployee() {
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $pass = generateRandomString();
        $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
								NULL,NULL,NULL,NULL,NULL,NULL);';
        if (executeQuery($query1)) {
            $photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            $query = "INSERT INTO `user_profile`(`id`,
                `user_name`,
                `emp_id`,
                `email_id`,
                `photo_id`,
                `password`,
                `passwordreset`,
                `authenticatkey`,
                `user_type_id`,
                `status`,
                `date_of_join`,
                `gender_id`,
                `cell_number`,
                `telephone`,
                `address`)
                VALUES (NULL,
                '" . mysql_real_escape_string($this->parameters['name']) . "',
                '" . mysql_real_escape_string($this->parameters['empid']) . "',
                '" . mysql_real_escape_string($this->parameters['email']) . "',
                '" . mysql_real_escape_string($photo_pk) . "',
                '" . mysql_real_escape_string($pass) . "',
                '" . mysql_real_escape_string(md5($pass)) . "',NULL,2,
                4,
                NOW(),
                '" . mysql_real_escape_string($this->parameters['gender']) . "',
                '" . mysql_real_escape_string($this->parameters['mobile']) . "',
                '" . mysql_real_escape_string($this->parameters['landline']) . "',
                '" . mysql_real_escape_string($this->parameters['addrs']) . "');";
            executeQuery($query);
            $user_pk = mysql_insert_id();
            $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_employee_' . $user_pk);
            executeQuery('UPDATE `user_profile` SET `directory` = \'' . $directory_customer . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
            executeQuery("COMMIT;");
            return true;
        }
    }

    //Fetch List of Individual Donors
    public function fetchListOfEmployees() {
        $fetchdata = array();
        $donorids = array();
        $alldata = array();
        $data = '';
        $query = 'SELECT *,
                up.id AS donorid,
                gen.id AS genderid
                FROM `user_profile` up
                LEFT JOIN `gender` gen
                ON gen.`id`=up.`gender_id`
                WHERE up.`status`=4 AND up.`user_type_id`=2';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['emp_id'] . '</td><td>' . $fetchdata[$i]['user_name'] . '</td><td>' . $fetchdata[$i]['cell_number'] . '</td><td>' . $fetchdata[$i]['email_id'] . '</td>'
                        . '<td>' . $fetchdata[$i]['gender_name'] . '</td>'
                        . '<td><button type="button" class="btn btn-info" id="donordet_' . $fetchdata[$i]['donorid'] . '"  title="Details"><i class="fa fa-reorder fa-1x"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete"><i class="fa fa-trash fa-1x"></i></button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['user_name'] . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="donordel_' . $fetchdata[$i]['donorid'] . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>'
                        . '</tr>';
                $donorids[$i] = $fetchdata[$i]['donorid'];
                $alldata[$i] = $fetchdata[$i];
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data,
                "donorids" => $donorids,
                "alldata" => $alldata,
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL
            );
            return $jsondata;
        }
    }

    /*  Checking UserName */

    public function CheckEmail() {
        if (isset($this->parameters['donorid'])) {
            $query = "SELECT * FROM `user_profile` WHERE `email_id`='" . mysql_real_escape_string($this->parameters['email']) . "' AND `id` !='" . mysql_real_escape_string($this->parameters['donorid']) . "';";
            $reslut = executeQuery($query);
            return mysql_num_rows($reslut);
        }
        $query = "SELECT * FROM `user_profile` WHERE `email_id`='" . mysql_real_escape_string($this->parameters['email']) . "';";
        $reslut = executeQuery($query);
        return mysql_num_rows($reslut);
    }

    /*  Checking UserName */

    public function checkEmpId() {
        if (isset($this->parameters['donorid'])) {
            $query = "SELECT * FROM `user_profile` WHERE `emp_id`='" . mysql_real_escape_string($this->parameters['email']) . "' AND `id` !='" . mysql_real_escape_string($this->parameters['donorid']) . "';";
            $reslut = executeQuery($query);
            return mysql_num_rows($reslut);
        }
        $query = "SELECT * FROM `user_profile` WHERE `emp_id`='" . mysql_real_escape_string($this->parameters['email']) . "';";
        $reslut = executeQuery($query);
        return mysql_num_rows($reslut);
    }

    /* Updating Donor Details */

    public function updateDonorDetails() {
        if ($this->parameters['request'] == "personal") {
            $query = 'UPDATE `user_profile` SET `user_name`="' . mysql_real_escape_string($this->parameters['name']) . '",'
                    . '`email_id`="' . mysql_real_escape_string($this->parameters['email']) . '",
      `cell_number`="' . mysql_real_escape_string($this->parameters['mobile']) . '",
              `gender_id`="' . mysql_real_escape_string($this->parameters['gender']) . '",
                  `address`="' . mysql_real_escape_string($this->parameters['addrs']) . '",
                      `emp_id`="' . mysql_real_escape_string($this->parameters['eempid']) . '",
             `telephone`="' . mysql_real_escape_string($this->parameters['landline']) . '" WHERE `id`="' . mysql_real_escape_string($this->parameters['donorid']) . '";';
            return executeQuery($query);
        } else if ($this->parameters['request'] == "commu") {
            $query = 'UPDATE `user_profile` SET `addressline`="' . mysql_real_escape_string($this->parameters['addrs']) . '",'
                    . '`city`="' . mysql_real_escape_string($this->parameters['city_town']) . '",
      `town`="' . mysql_real_escape_string($this->parameters['st_loc']) . '",
          `district`="' . mysql_real_escape_string($this->parameters['district']) . '",
              `province`="' . mysql_real_escape_string($this->parameters['province']) . '",
                  `country`="' . mysql_real_escape_string($this->parameters['country']) . '",
                `zipcode`="' . mysql_real_escape_string($this->parameters['zipcode']) . '",
             `website`="' . mysql_real_escape_string($this->parameters['website']) . '" WHERE `id`="' . mysql_real_escape_string($this->parameters['donorid']) . '";';
            return executeQuery($query);
        } else {

        }
    }

    /*  Delete Donor  */

    public function deleteDonor() {
        $query = 'UPDATE `user_profile` SET `status`=6 WHERE `id`=' . mysql_real_escape_string($this->parameters['donorid']) . ';';
        return executeQuery($query);
    }

}
