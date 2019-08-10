<?php
class user {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }
    /* Adding Individual Donor  */
    public function addEmployee() {
        $flag=false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query1 = 'INSERT INTO  `continents` (`id`,`continent_name`,`created_at`,`updated_at`,`description`,`status_id` )
            VALUES(
            NULL,
            "'.mysql_real_escape_string(strtolower($this->parameters['name'])).'",
                NOW(),
                NULL,
                "'.mysql_real_escape_string($this->parameters['addrs']).'",
                default);';
        if (executeQuery($query1)) {
            $photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            executeQuery("COMMIT;");
            $flag=true;
        }
        return $flag;
    }
    //Fetch List of Individual Donors
    public function fetchListOfEmployees() {
//        echo $_SESSION["USER_LOGIN_DATA"]['USER_TYPE'];
        $fetchdata = array();
        $donorids = array();
        $alldata = array();
        $data = '';
        $query = 'SELECT
                `id`             AS donorid,
                `continent_name` AS user_name,
                IF(`created_at` IS NOT NULL,DATE_FORMAT(`created_at`,"%d-%b-%y"),`created_at` ) AS `created_at`,
                IF(`updated_at` IS NOT NULL,DATE_FORMAT(`updated_at`,"%d-%b-%y"),`updated_at` ) AS `updated_at`,
                `description`,
                `status_id`
              FROM `continents` up
              WHERE up.`status_id` = 4;';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['user_name'] . '</td><td>' . $fetchdata[$i]['created_at'] . '</td><td>' . $fetchdata[$i]['updated_at'] . '</td>'
                        . '<td>' . $fetchdata[$i]['description'] . '</td>'
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
            $query = "SELECT * FROM `continents` WHERE `continent_name` = '" . mysql_real_escape_string(strtolower($this->parameters['email'])) . "' AND `id` !='" . mysql_real_escape_string($this->parameters['donorid']) . "';";
            $reslut = executeQuery($query);
            return mysql_num_rows($reslut);
        }
        $query = "SELECT * FROM `continents` WHERE `continent_name`='" . mysql_real_escape_string(strtolower($this->parameters['email'])) . "';";
        $reslut = executeQuery($query);
        return mysql_num_rows($reslut);
    }
    /* Updating Donor Details */
    public function updateDonorDetails() {
        if ($this->parameters['request'] == "personal") {
            $query = 'UPDATE `continents` SET `continent_name`="' . mysql_real_escape_string($this->parameters['ename']) . '",
                   `description`="' . mysql_real_escape_string($this->parameters['addrs']) . '",
                    `updated_at`=now()
               WHERE `id`="' . mysql_real_escape_string($this->parameters['donorid']) . '";';
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
        $query = 'UPDATE `continents` SET `status_id`=6 WHERE `id`=' . mysql_real_escape_string($this->parameters['donorid']) . ';';
        return executeQuery($query);
    }
}