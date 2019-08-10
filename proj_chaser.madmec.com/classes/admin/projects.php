<?php

class adminProjects {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function addProject() {
        $query = 'INSERT INTO `projects`(`id`, `created_by`, `created_at`, `updated_at`, `project_name`, `status_id`)VALUES(NULL,'
                . '"' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['projectdate']) . '",'
                . 'now(),'
                . '"' . mysql_real_escape_string($this->parameters['projectname']) . '",4);';
        return executeQuery($query);
    }

    //Fetch List of Individual Donors
    public function fetchListOfProjects() {
        $fetchdata = array();
        $donorids = array();
        $alldata = array();
        $data = '';
        $query = 'SELECT
                    p.*,
                    up.`user_name`
                  FROM `projects` p
                    LEFT JOIN `user_profile` up
                      ON up.`id` = p.`created_by`
                  WHERE `status_id` = 4 ;';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['project_name'] . '</td><td>' . $fetchdata[$i]['user_name'] . '</td><td>' . $fetchdata[$i]['created_at'] . '</td>'
                        . ''
                        . '<td><button type="button" class="btn btn-info" id="donordet_' . $fetchdata[$i]['id'] . '"  title="Details"><i class="fa fa-reorder fa-1x"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete"><i class="fa fa-trash fa-1x"></i></button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['project_name'] . '} <br />
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
                $donorids[$i] = $fetchdata[$i]['id'];
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

    public function updateProjectDetails() {
        $query = 'UPDATE `projects` SET `project_name`="' . mysql_real_escape_string($this->parameters['projectname']) . '",`created_at`="' . mysql_real_escape_string($this->parameters['eprojectdate']) . '",`updated_at`=now() WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function deleteProject() {
        $query = 'UPDATE `projects` SET `status_id`="6" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function checkProjectName() {
        if (isset($this->parameters['donorid'])) {
            $query = "SELECT * FROM `projects` WHERE `project_name`='" . mysql_real_escape_string($this->parameters['proname']) . "' AND `id` !='" . mysql_real_escape_string($this->parameters['donorid']) . "';";
            $reslut = executeQuery($query);
            return mysql_num_rows($reslut);
        }
        $query = "SELECT * FROM `projects` WHERE `project_name`='" . mysql_real_escape_string($this->parameters['proname']) . "';";
        $reslut = executeQuery($query);
        return mysql_num_rows($reslut);
    }

}
?>