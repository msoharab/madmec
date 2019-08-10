<?php

class complaints {
    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function addVehicleType() {
        $query = 'SELECT * FROM `complaint_type` WHERE `name`="' . mysql_real_escape_string($this->parameters['vehicletype']) . '" AND `status_id`=4;';
        $result = executeQuery($query);
        if(mysql_num_rows($result))
        {
            return "exist";
            exit(0);
        }
        else
        {
        $query = 'INSERT INTO `complaint_type`(`id`,`name`,`createdby`)VALUES(NULL,'
                . '"' . mysql_real_escape_string($this->parameters['vehicletype']) . '",'
                . '"' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . '"'
                . ')';
        return executeQuery($query);
        }
    }


    public function checkVehicleType() {
        $query = 'SELECT * FROM `complaint_type` WHERE `name`="' . mysql_real_escape_string($this->parameters['vehicletype']) . '" AND `status_id`=4 AND `id` !="' . mysql_real_escape_string($this->parameters['typeid']) . '";';
        $result = executeQuery($query);
        return mysql_num_rows($result);
        exit(0);
    }




    public function fetchVehicleType() {
        $query = 'SELECT * FROM `complaint_type` WHERE `status_id`=4';
        $result = executeQuery($query);
        $fetchdata = array();
        $data = '';
        $typeid = array();
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['name'] . '</td>'
                        . '<td><button type="button" class="btn btn-warning" id="donordet_' . $fetchdata[$i]['id'] . '"  title="EDIT"><i class="fa fa-pencil fa-1x"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete"><i class="fa fa-trash fa-1x"></i></button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['name'] . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="donordel_' . $fetchdata[$i]['id'] . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>'
                        . '</tr>';
                $typeid[$i] = $fetchdata[$i]['id'];
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data,
                "donorids" => $typeid,
                "alldata" => $fetchdata
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL,
                "donorids" => NULL,
                "alldata" => $fetchdata
            );
            return $jsondata;
        }
    }


    public function updateVehicleType() {
        $query = 'SELECT * FROM `complaint_type` WHERE `name`="' . mysql_real_escape_string($this->parameters['evehicletype']) . '" AND `status_id`=4;';
        $result = executeQuery($query);
        if(mysql_num_rows($result))
        {
            return "exist";
            exit(0);
        }
        else
        {
        $query = 'UPDATE `complaint_type` SET `name`="' . mysql_real_escape_string($this->parameters['evehicletype']) . '"  WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
        }
    }


    public function deleteVehicleType() {
        $query = 'UPDATE `complaint_type` SET `status_id`="6" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

}

