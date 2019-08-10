<?php

class activity {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function addActivity() {
        $query = 'INSERT INTO `projects_activity`(`id`, `project_id`, `created_by`, `created_at`, `updated_at`, `activity_name`,
                `description`, `status_id`)
                VALUES (NULl,
                "' . mysql_real_escape_string($this->parameters['selectproject']) . '",
                     "' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '",now(),now(),
                          "' . mysql_real_escape_string($this->parameters['name']) . '",
                               "' . mysql_real_escape_string($this->parameters['description']) . '",4);';
        return executeQuery($query);
    }

    public function fetchActivities() {
        $query = 'SELECT * FROM `projects` WHERE `status_id`=4';
        $result = executeQuery($query);
        $jsondata = array(
            "status" => "failure",
        );
        $data = '';
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $data .='<option value="' . $row['id'] . '">' . $row['project_name'] . '</option>';
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data,
            );
        }
        return $jsondata;
    }

    //Fetch List of Activities
    public function fetchListOfActivities() {
        $fetchdata = array();
        $donorids = array();
        $alldata = array();
        $data = '';
        $query = 'SELECT
                    p.*,
                    up.project_name
                  FROM `projects_activity` p
                    LEFT JOIN projects up
                      ON up.id = p.project_id
                  WHERE p.`status_id` = 4
                      AND up.`status_id` = 4
                      AND p.created_by = "' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '";';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['project_name'] . '</td><td>' . $fetchdata[$i]['activity_name'] . '</td><td>' . $fetchdata[$i]['description'] . '</td>'
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
										Do you really want to delete {' . $fetchdata[$i]['activity_name'] . '} <br />
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

    //Update Project Activity
    public function updateProjectActivity() {
        $query = 'UPDATE `projects_activity` SET `activity_name`="' . mysql_real_escape_string($this->parameters['name']) . '",
                `description`="' . mysql_real_escape_string($this->parameters['description']) . '",
                `updated_at`=now(),
                 `project_id`="' . mysql_real_escape_string($this->parameters['selectproject']) . '"
                  WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    // Delete Activity
     public function deleteActivity() {
        $query = 'UPDATE `projects_activity` SET `status_id`=6 WHERE `id`=' . mysql_real_escape_string($this->parameters['typeid']) . ';';
        return executeQuery($query);
    }
}
