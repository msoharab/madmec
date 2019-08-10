<?php

class engage {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function addActivity() {
        $query = 'INSERT INTO `engage`(`id`, `project_activity_id`, `created_by`, `in_time`, `status_id`)'
                . ' VALUES (NULL,'
                . '"'.  mysql_real_escape_string($this->parameters['selectactivity']).'",'
                . '"'.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']).'",now(),15);';
        return executeQuery($query);
    }

    public function fetchprojects() {
        $query = 'SELECT
                    DISTINCT(p.project_id),
                    up.project_name
                  FROM `projects_activity` p
                    LEFT JOIN projects up
                      ON up.id = p.project_id
                  WHERE p.`status_id` = 4
                      AND up.`status_id` = 4
                      AND p.created_by = "' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '";';
        $result = executeQuery($query);
        $jsondata = array(
            "status" => "failure",
        );
        $data = '';
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $data .='<option value="' . $row['project_id'] . '">' . $row['project_name'] . '</option>';
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data,
            );
        }
        return $jsondata;
    }

    public function fetchActivities() {
        $query = 'SELECT
                    p.*,
                    up.project_name
                  FROM `projects_activity` p
                    LEFT JOIN projects up
                      ON up.id = p.project_id
                  WHERE p.`status_id` = 4
                      AND up.`status_id` = 4
                      AND p.project_id="'.mysql_real_escape_string($this->parameters['projid']) .'"
                      AND p.created_by = "' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']) . '";';
        $result = executeQuery($query);
        $jsondata = array(
            "status" => "failure",
        );
        $data = '';
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $data .='<option value="' . $row['id'] . '">' . $row['activity_name'] . '</option>';
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

    //Check Login Status
    public function checkLoginStatus() {
        $query='SELECT
                en.`in_time`,
                en.`id`,
                pa.`activity_name`,
                pa.`description`,
                p.`project_name`
              FROM `engage` en
                LEFT JOIN `projects_activity` pa
                  ON pa.`id` = en.`project_activity_id`
                LEFT JOIN `projects` p
                  ON p.`id` = pa.`project_id`
              WHERE en.`status_id` = 15
                  AND en.`created_by` = "'.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]['USER_ID']).'" ';
        $result=  executeQuery($query);
        $jsondata=array(
            "status" => "failure",
        );
        if(mysql_num_rows($result))
        {
             $row=  mysql_fetch_assoc($result);
             $data ='<table class="table"><tbody>'
                     . '<tr><td>Project Name</td><td>'.$row['project_name'].'</td></tr>'
                      . '<tr><td>Activity Name</td><td>'.$row['activity_name'].'</td></tr>'
                      . '<tr><td>Activity Description</td><td>'.$row['description'].'</td></tr>'
                      . '<tr><td>Engange Time</td><td>'.$row['in_time'].'</td></tr>'
                     . '<tr><td colspan="2">&nbsp;</td></tr>'
                     . '<tr><td colspan="2" class="text-center"><button type="button" class="btn btn-danger" id="logout'.$row['id'].'">DisEngage</td></tr>'
                     . '</tbody></table>';
              $jsondata=array(
            "status" => "success",
                  "data" => $data,
                  "id" =>$row['id'],
            );

        }
        return $jsondata;
    }

    //Logout From the Project
    public function disengage() {
        $query = 'UPDATE `engage` SET `status_id`=16,`out_time`=now() WHERE `id`=' . mysql_real_escape_string($this->parameters['typeid']) . ';';
        return executeQuery($query);
    }
}
