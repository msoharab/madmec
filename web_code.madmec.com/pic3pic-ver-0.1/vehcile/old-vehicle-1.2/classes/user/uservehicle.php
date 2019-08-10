<?php

class uservehicle {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    //Adding User Vehicle
    public function addVehicle() {
        $query = 'INSERT INTO `user_vehicle`(`id`,`vehicle_nickname`,`vehicle_number`,`vehicle_model`,`comment`,`preferred_service_center`,`user_id`,`created_at`,`updated_at`,`status_id`)VALUES(NULL,'
                . '"' . mysql_real_escape_string($this->parameters['vehiclenickname']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['vehicleregno']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['vehiclemodel']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['comment']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['psid']) . '",'
                . '"' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . '",now(),now(),4'
                . ')';
        return executeQuery($query);
    }

    public function fetchListOfVehicles() {
        $query = 'SELECT
                    vm.id               AS vehiclemodel,
                    vm.name             AS vehiclemodelname,
                    uv.vehicle_nickname,
                    uv.vehicle_number,
                    uv.comment,
                    uv.id AS uvid,
                    vmake.id            AS vmakeid,
                    vmake.name          AS vmakename,
                    vtype.id            AS vtypeid,
                    vtype.name          AS vtypename
                  FROM user_vehicle uv
                    LEFT JOIN vehicle_model vm
                      ON vm.id = uv.vehicle_model
                    LEFT JOIN vehicle_make vmake
                      ON vmake.id = vm.vehicle_make_id
                    LEFT JOIN vehicle_type vtype
                      ON vtype.id = vmake.vehicle_type_id
                  WHERE uv.status_id = 4
                      AND uv.user_id = "' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . '"';
        $result = executeQuery($query);
        $fetchdata = array();
        $data = '';
        $appdata='';
        $typeid = array();
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $appdata .='<option value="'.$fetchdata[$i]['uvid'].'">'.$fetchdata[$i]['vehicle_nickname'] .'</option>';
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['vehicle_nickname'] . '</td><td>' . $fetchdata[$i]['vehicle_number'] . '</td><td>' . $fetchdata[$i]['vehiclemodelname'] . '</td><td>' . $fetchdata[$i]['comment'] . '</td>'
                        . '<td><button type="button" class="btn btn-warning" id="donordet_' . $fetchdata[$i]['uvid'] . '"  title="EDIT"><i class="fa fa-pencil fa-1x"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete"><i class="fa fa-trash fa-1x"></i></button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['vehicle_nickname'] . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="donordel_' . $fetchdata[$i]['uvid'] . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>'
                        . '</tr>';
                $typeid[$i] = $fetchdata[$i]['uvid'];
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data,
                "appdata" => $appdata,
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

    public function fetchServiceCenters() {
        $query='SELECT * FROM `user_profile` WHERE `user_type_id`=2 AND `status`=4';
        $result=  executeQuery($query);
        $data=array();
        $fetchdata=array();
        $ids=array();
        if(mysql_num_rows($result))
        {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[]=$row;
            }
            for($i=0;$i<sizeof($fetchdata);$i++)
            {
                $data[$i]=$fetchdata[$i]['user_name'].'--'.$data[$i]=$fetchdata[$i]['addressline'].'--'.$data[$i]=$fetchdata[$i]['town'].'--'.$data[$i]=$fetchdata[$i]['city'].'--'.$data[$i]=$fetchdata[$i]['district'].'--'.$data[$i]=$fetchdata[$i]['province'].'--'.$data[$i]=$fetchdata[$i]['cell_number'];
                $ids[$i]=$fetchdata[$i]['id'];
            }
            $jsondata=array(
                "status"  => "success",
                "data" => $data,
                "ids" => $ids
            );
            return $jsondata;
        }
        else
        {
            $jsondata=array(
                "status"  => "failure",
                "data" => NULL,
                "ids" => NULL,
            );
            return $jsondata;
        }
    }

    public function deleteVehicle() {
        $query = 'UPDATE `user_vehicle` SET `status_id`="6" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function updateUserVehicle() {
        $query = 'UPDATE `user_vehicle` SET `vehicle_nickname`="' . mysql_real_escape_string($this->parameters['evehiclenickname']) . '",
                `vehicle_number`="' . mysql_real_escape_string($this->parameters['evehicleregno']) . '",
                `comment`="' . mysql_real_escape_string($this->parameters['ecomment']) . '",
                `vehicle_model`="' . mysql_real_escape_string($this->parameters['evehiclemodel']) . '",`updated_at`=now()
                WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

}

?>