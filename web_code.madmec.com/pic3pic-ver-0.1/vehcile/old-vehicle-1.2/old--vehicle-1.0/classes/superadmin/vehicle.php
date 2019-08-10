<?php

class vehicle {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function addVehicleType() {
        $query = 'INSERT INTO `vehicle_type`(`id`,`name`,`comment`,`createdby`)VALUES(NULL,'
                . '"' . mysql_real_escape_string($this->parameters['vehicletype']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['comment']) . '",'
                . '"' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . '"'
                . ')';
        return executeQuery($query);
    }

    public function addVehicleMake() {
        $query = 'INSERT INTO `vehicle_make`(`id`,`vehicle_type_id`,`name`,`comment`,`createdby`)VALUES(NULL,'
                . '"' . mysql_real_escape_string($this->parameters['vehicletype']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['vehiclemake']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['comment']) . '",'
                . '"' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . '"'
                . ')';
        return executeQuery($query);
    }

    public function addVehicleModel() {
        $query = 'INSERT INTO `vehicle_model`(`id`,`vehicle_make_id`,`name`,`comment`,`createdby`)VALUES(NULL,'
                . '"' . mysql_real_escape_string($this->parameters['vehicalmakee']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['vehiclemodel']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['comment']) . '",'
                . '"' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . '"'
                . ')';
        return executeQuery($query);
    }

    public function checkVehicleType() {
        $query = 'SELECT * FROM `vehicle_type` WHERE `name`="' . mysql_real_escape_string($this->parameters['vehicletype']) . '" AND `status_id`=4 AND `id` !="' . mysql_real_escape_string($this->parameters['typeid']) . '";';
        $result = executeQuery($query);
        return mysql_num_rows($result);
        exit(0);
    }

    public function checkVehicleMake() {
        $query = 'SELECT * FROM `vehicle_make` WHERE `name`="' . mysql_real_escape_string($this->parameters['vehicletype']) . '" AND `status_id`=4 AND `id` !="' . mysql_real_escape_string($this->parameters['typeid']) . '";';
        $result = executeQuery($query);
        return mysql_num_rows($result);
        exit(0);
    }

    public function checkVehicleModel() {
        $query = 'SELECT * FROM `vehicle_model` WHERE `name`="' . mysql_real_escape_string($this->parameters['vehicletype']) . '" AND `status_id`=4 AND `id` !="' . mysql_real_escape_string($this->parameters['typeid']) . '";';
        $result = executeQuery($query);
        return mysql_num_rows($result);
        exit(0);
    }

    public function fetchVehicleType() {
        $query = 'SELECT * FROM `vehicle_type` WHERE `status_id`=4';
        $result = executeQuery($query);
        $fetchdata = array();
        $data = '';
        $typeid = array();
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['name'] . '</td><td>' . $fetchdata[$i]['comment'] . '</td>'
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

    public function fetchVehicleMake() {
        $query = 'SELECT
                    *,
                    vm.id AS vmakeid,
                    vm.comment AS vmakecomment,
                    vt.id AS vtid,
                    vt.name AS vtname,
                    vm.name AS vmname
                  FROM vehicle_make vm
                    LEFT JOIN vehicle_type vt
                      ON vt.id = vm.vehicle_type_id
                  WHERE vm.status_id = 4
                      AND vt.status_id = 4';
        $result = executeQuery($query);
        $fetchdata = array();
        $data = '';
        $typeid = array();
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['vtname'] . '</td><td>' . $fetchdata[$i]['vmname'] . '</td><td>' . $fetchdata[$i]['vmakecomment'] . '</td>'
                        . '<td><button type="button" class="btn btn-warning" id="donordet_' . $fetchdata[$i]['vmakeid'] . '"  title="EDIT"><i class="fa fa-pencil fa-1x"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete"><i class="fa fa-trash fa-1x"></i></button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['vmname'] . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="donordel_' . $fetchdata[$i]['vmakeid'] . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>'
                        . '</tr>';
                $typeid[$i] = $fetchdata[$i]['vmakeid'];
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

    public function fetchVehicleModel() {
        $query = 'SELECT
                    *,
                    vm.id       AS vmakeid,
                    vt.id       AS vtid,
                    vt.name     AS vtname,
                    vm.name     AS vmname,
                    vmodel.id   AS vmodelid,
                    vmodel.name AS vmodelname,
                    vmodel.comment AS vmodelcomment
                  FROM vehicle_model vmodel
                    LEFT JOIN vehicle_make vm
                      ON vmodel.vehicle_make_id = vm.id
                    LEFT JOIN vehicle_type vt
                      ON vt.id = vm.vehicle_type_id
                  WHERE vm.status_id = 4
                      AND vt.status_id = 4
                      AND vmodel.status_id = 4';
        $result = executeQuery($query);
        $fetchdata = array();
        $data = '';
        $typeid = array();
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['vtname'] . '</td><td>' . $fetchdata[$i]['vmname'] . '</td><td>' . $fetchdata[$i]['vmodelname'] . '</td><td>' . $fetchdata[$i]['vmodelcomment'] . '</td>'
                        . '<td><button type="button" class="btn btn-warning" id="donordet_' . $fetchdata[$i]['vmodelid'] . '"  title="EDIT"><i class="fa fa-pencil fa-1x"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete"><i class="fa fa-trash fa-1x"></i></button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['vmodelname'] . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="donordel_' . $fetchdata[$i]['vmodelid'] . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>'
                        . '</tr>';
                $typeid[$i] = $fetchdata[$i]['vmodelid'];
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
        $query = 'UPDATE `vehicle_type` SET `name`="' . mysql_real_escape_string($this->parameters['evehicletype']) . '",`comment`="' . mysql_real_escape_string($this->parameters['ecomment']) . '" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function updateVehicleMake() {
        $query = 'UPDATE `vehicle_make` SET `vehicle_type_id`="' . mysql_real_escape_string($this->parameters['evehicletype']) . '",`name`="' . mysql_real_escape_string($this->parameters['evehiclemake']) . '",`comment`="' . mysql_real_escape_string($this->parameters['ecomment']) . '" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function updateVehicleModel() {
        $query = 'UPDATE `vehicle_model` SET `vehicle_make_id`="' . mysql_real_escape_string($this->parameters['evehicalmakee']) . '",`name`="' . mysql_real_escape_string($this->parameters['evehiclemodell']) . '",`comment`="' . mysql_real_escape_string($this->parameters['ecomment']) . '" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function deleteVehicleType() {
        $query = 'UPDATE `vehicle_type` SET `status_id`="6" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function deleteVehicleMake() {
        $query = 'UPDATE `vehicle_make` SET `status_id`="6" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function deleteVehicleModel() {
        $query = 'UPDATE `vehicle_model` SET `status_id`="6" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function fetchVehicleTypes() {
        $query = 'SELECT * FROM `vehicle_type` WHERE `status_id`=4';
        $result = executeQuery($query);
        $fetchdata = array();
        $option = array();
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $option[$i]='<option value="'.$fetchdata[$i]['id'].'">'.$fetchdata[$i]['name'].'</option>';
            }
            $jsondata=array(
                "status" => "success",
                "data" => $option,
            );
            return $jsondata;
        }
        else{
            $jsondata=array(
                "status" => "failure",
                "data" => $option,
            );
            return $jsondata;
        }
    }

     public function fetchVehicleMakes() {
        $query = 'SELECT * FROM `vehicle_make` WHERE `status_id`=4 AND `vehicle_type_id`="'.  mysql_real_escape_string($this->parameters['vtypeid']).'";';
        $result = executeQuery($query);
        $fetchdata = array();
        $option = array();
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $option[$i]='<option value="'.$fetchdata[$i]['id'].'">'.$fetchdata[$i]['name'].'</option>';
            }
            $jsondata=array(
                "status" => "success",
                "data" => $option,
            );
            return $jsondata;
        }
        else{
            $jsondata=array(
                "status" => "failure",
                "data" => $option,
            );
            return $jsondata;
        }
    }

}
