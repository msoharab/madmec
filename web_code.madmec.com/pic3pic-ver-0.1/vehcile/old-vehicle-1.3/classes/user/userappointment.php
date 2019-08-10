<?php

class userappointment {

    protected $parameters = array();
    protected $venidd = 0;
    protected $vendata = '';
    function __construct($para = false) {
        $this->parameters = $para;
        $this->venidd = isset($this->parameters['venidd']) ? $this->parameters['venidd'] : 0;
        $this->vendata = isset($this->parameters['vendata']) ? $this->parameters['vendata'] : 0;
    }

    public function checkForPreferedCenter() {
        $query = 'SELECT preferred_service_center FROM user_vehicle WHERE status_id=4 AND id="' . mysql_real_escape_string($this->parameters['userid']) . '";';
        $result = executeQuery($query);
        $_SESSION["vehicleid"] = $this->parameters['userid'];
        if (mysql_num_rows($result)) {
            $row1 = mysql_fetch_assoc($result);
            if ((int) $row1['preferred_service_center']) {
                $this->venidd = (int) $row1['preferred_service_center'];
                $query = 'SELECT * FROM `user_profile` WHERE `id`=' . $this->venidd . ' AND `status`=4';
                $result = executeQuery($query);
                if (mysql_num_rows($result)) {
                    $row = mysql_fetch_assoc($result);
                    $this->vendata = $row['user_name'] . '--' . $row['addressline'] . '--' . $row['town'] . '--' . $row['city'] . '--' . $row['district'] . '--' . $row['province'] . '--' . $row['cell_number'];
                    return $this->fetchappointmentdetails($this->vendata);
                }
            } else {
                return $this->fetchServiceCenters($this->parameters['ventype']);
            }
        }
    }
    public function  fetchBookedAppointments(){
        $query="SELECT
                    *,
                    bh.id AS bookingid,
                    bh.`status_id` AS bookingstatus
                  FROM `bookinghistory` bh
                    LEFT JOIN appointment_descb apdesc
                      ON apdesc.id = bh.apptdescb_id
                    LEFT JOIN appointment appnt
                      ON appnt.id = apdesc.appoint_id
                    LEFT JOIN user_profile up
                      ON up.id = appnt.doctorid
                    LEFT JOIN user_vehicle uv
                      ON uv.id = bh.vehicle_id
                    LEFT JOIN vehicle_model vm
                      ON vm.id = uv.vehicle_model
                  WHERE bh.`status_id` IN (4,35)
                      AND bh.patientid ='".  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"])."'";
        $result=  executeQuery($query);
        $fetchdata=array();
        $typeid=array();
        $addpdescbid=array();
        $data='';
        $jsondata=array(
            "status" => "failure"
        );
        if(mysql_num_rows($result))
        {
            while ($row = mysql_fetch_assoc($result)) {
                    $fetchdata[]=$row;
            }
            for($i=0;$i<sizeof($fetchdata);$i++)
            {
             $data .='<tr><td>'.($i+1).'</td><td>'.$fetchdata[$i]['name'].'</td><td>'.$fetchdata[$i]['date'].'</td><td>'.$fetchdata[$i]['fromtime'].' -- '.$fetchdata[$i]['totime'].'</td>'
                     . '<td>'.$fetchdata[$i]['servicetype'].'</td><td>'.$fetchdata[$i]['bookservice'].'</td>'
                     . '<td>'.$fetchdata[$i]['user_name'] . '--' .
                        $fetchdata[$i]['addressline'] . '--' .
                        $fetchdata[$i]['town'] . '--' .
                        $fetchdata[$i]['city'] . '--' .
                        $fetchdata[$i]['cell_number'].'</td>';
             if((int)$fetchdata[$i]['bookingstatus'] == 4)
             {
             $data.= '<td><button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete"><i class="fa fa-trash fa-1x"></i></button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['name'] . ' Booking} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="donordel_' . $fetchdata[$i]['bookingid'] . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>';
             }
            else {
              $data.= '<td>In-progress</td>';
            }
             $data .='</tr>';
             $typeid[$i] = $fetchdata[$i]['bookingid'];
             $addpdescbid[$i]=$fetchdata[$i]['apptdescb_id'];
            }
            $jsondata=array(
            "status" => "success",
            "data" => $data,
            "donorids" => $typeid,
            "addpdescbid" => $addpdescbid,
        );
        }
        return $jsondata;

    }

    public function fetchServiceCenters($ventype) {
        $query = 'SELECT * FROM `user_profile` WHERE `user_type_id`=2 AND `status`=4 AND `vendor_id`="'.  mysql_real_escape_string($ventype).'"';
        $result = executeQuery($query);
        $data = array();
        $fetchdata = array();
        $ids = array();
        $json = array(
            "status" => "failure",
            "res" => "",
            "data" => NULL,
            "ids" => NULL
        );
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data[$i] = $fetchdata[$i]['user_name'] . '--' .
                        $fetchdata[$i]['addressline'] . '--' .
                        $fetchdata[$i]['town'] . '--' .
                        $fetchdata[$i]['city'] . '--' .
                        $fetchdata[$i]['district'] . '--' .
                        $fetchdata[$i]['province'] . '--' .
                        $fetchdata[$i]['cell_number'];
                $ids[$i] = $fetchdata[$i]['id'];
            }
            $json = array(
                "status" => "success",
                "res" => "suggest",
                "data" => (array) $data,
                "ids" => (array) $ids
            );
        }
        return (array) $json;
    }

    public function fetchappointmentdetails() {

        $ctquery='SELECT * FROM `complaint_type` WHERE `status_id`=4 AND `vendor_id`="'.  mysql_real_escape_string($this->venidd).'";';
//        echo $ctquery;
        $ctresult=  executeQuery($ctquery);
        $ctdata='';
        $ctfetchdata=array();
        if(mysql_num_rows($ctresult))
        {
            while ($row1 = mysql_fetch_array($ctresult)) {
                $ctfetchdata[]=$row1;
            }
            for($j=0;$j<sizeof($ctfetchdata);$j++)
            {
                $ctdata .='<div class="col-lg-2"><input type="checkbox" value="'.$ctfetchdata[$j]['id'].'"/> &nbsp;&nbsp;<strong>'.$ctfetchdata[$j]['name'].'</strong></div>';
            }
        }

        $weekofdayid = array();
        $weekofdays = array();
        $pdetails = array();
        $pdata = array();
        $pdata1 = array();
        $appids = array();
        $appfromtime = array();
        $apptotime = array();
        $applocation = array();
        $appfrequency = array();
        $dates = array();
        $weekoftheday = array('', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $query = 'SELECT
                            ap.`id`,
                            ap.`weekofday`,
                            GROUP_CONCAT(apd.`fromtime`) AS fromtime,
                            GROUP_CONCAT(apd.`totime`) AS totime,
                            GROUP_CONCAT(apd.`location`) AS location,
                            GROUP_CONCAT(apd.`frequency`) AS frequency,
                            GROUP_CONCAT(apd.`filled`) AS filled,
                            GROUP_CONCAT(apd.`date`) AS date,
                            GROUP_CONCAT(apd.`id`) AS apptid
                        FROM `appointment` ap
                        LEFT JOIN `appointment_descb` apd ON ap.`id`=apd.`appoint_id`
                        WHERE ap.`status_id`=4 AND apd.`status_id`=4 AND ap.`doctorid`=' . $this->venidd . '
                        GROUP BY (apd.`appoint_id`)
                        ORDER BY(apd.`id`) ASC; ';
        $result = executeQuery($query);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                $pdetails[] = $row;
            }
        }
        if (is_array($pdetails))
            $num = sizeof($pdetails);
        $theader = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                                <tbody><tr><th>#</th><th>Slot Details</th><th>Details</th></tr>';
        $theader1 = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                                <tbody><tr><th>#</th><th>Slot Details</th><th>Option</th></tr>';

        $tablefooter = '</tbody></table></div>';
        if ($num) {
            for ($i = 0; $i < $num; $i++) {
                $fromtimee = array();
                $totimee = array();
                $location = array();
                $frequency = array();
                $filled = array();
                $grpappid = array();
                $grpdates = array();
                $j = 1;
                $p = 1;
                $pdata[$i] = '<div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#viewappoint" href="#viewappointt' . $i . '" class="collapsed">' . $weekoftheday[$pdetails[$i]['weekofday']] . '</a>
                                        </h4>
                                        </div><div id="viewappointt' . $i . '" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">' . $theader . '';
                $weekofdays[] = $pdetails[$i]['weekofday'];
                $weekofdayid[] = $pdetails[$i]['id'];
                $fromtimee = explode(',', $pdetails[$i]['fromtime']);
                $totimee = explode(',', $pdetails[$i]['totime']);
                $location = explode(',', $pdetails[$i]['location']);
                $frequency = explode(',', $pdetails[$i]['frequency']);
                $filled = explode(',', $pdetails[$i]['filled']);
                $grpappid = explode(',', $pdetails[$i]['apptid']);
                $grpdates = explode(',', $pdetails[$i]['date']);
                for ($k = 0; $k < sizeof($fromtimee); $k++) {
//                                             <br/> Location : '.$location[$k].'
                    $pdata[$i] .='<tr id="bookapprow'.$grpappid[$k].'"><td>' . $j++ . '
                                        </td><td> Time : ' . $fromtimee[$k] . '
                                         - ' . $totimee[$k] . '
                                        <br/> Avaliable Slots : ' . ((int)$location[$k] - (int)$filled[$k]) . '</td>'
                            . '<td><button type="button" class="btn btn-success  btn-md" id="viewappointee_' . $grpappid[$k] . '"><i class="fa fa-book fa-fw "></i>Book</button>                                            <script>
                                                $("#viewappointee_' . $grpappid[$k] . '").click(function(){
                                                    var obj = new appointment();
                                                    obj.bookSlot({apptid: "'.$grpappid[$k].'",
                                                        date: "'.$grpdates[$k].'",
                                                            rowid:"#bookapprow'.$grpappid[$k].'",
                                                                vhid : "'.$_SESSION["vehicleid"] .'",
                                                                    servid : "'.$this->venidd .'",
                                                                    bookaservice : $("#bookaservice").val(),
                                                                    typeofservice : $("#typeofservice").val(),
                                                                    });
                                                });
                                            </script>
</td></tr><tr><td colspan="3"><div id="viewappointeedis_' . $grpappid[$k] . '"></div></td></tr>';
                    $appids[] = $grpappid[$k];
                    $dates[] = $grpdates[$k];
                    $appfromtime[] = $fromtimee[$k];
                    $apptotime[] = $totimee[$k];
                    $applocation[] = $location[$k];
                    $appfrequency[] = $frequency[$k];
                }
                $pdata[$i] .=$tablefooter . '</div>
                                        </div></div>';
                $pdata1[$i] = '<div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#viewappoint" href="#editappointt' . $i . '" class="collapsed">' . $weekoftheday[$pdetails[$i]['weekofday']] . '</a>
                                        </h4>
                                        </div><div id="editappointt' . $i . '" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">' . $theader1 . '';
                $fromtimee = explode(',', $pdetails[$i]['fromtime']);
                $totimee = explode(',', $pdetails[$i]['totime']);
                $location = explode(',', $pdetails[$i]['location']);
                $frequency = explode(',', $pdetails[$i]['frequency']);
                $filled = explode(',', $pdetails[$i]['filled']);
                for ($k = 0; $k < sizeof($fromtimee); $k++) {
//                                             Location : '.$location[$k].'<br/>
                    $pdata1[$i] .='<tr id="row_id' . $grpappid[$k] . '"><td>' . $p++ . '</td>
                                        <td> Time : ' . $fromtimee[$k] . ' -
                                        ' . $totimee[$k] . '<br/>
                                         No of Vehicles : ' . $location[$k] . '</td>'
                            . '<td><button type="button" class="btn btn-warning  btn-md" id="edit_app' . $grpappid[$k] . '"><i class="fa fa-edit fa-fw "></i>Edit</button><br/><br/>'
                            . '<button class="btn btn-danger  btn-md" name="' . $grpappid[$k] . '" id="delete_apptt_' . $grpappid[$k] . '" data-toggle="modal" data-target="#myModal_' . $grpappid[$k] . '"><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp;
								<div class="modal fade" id="myModal_' . $grpappid[$k] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_' . $grpappid[$k] . '" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModalLabel_' . $grpappid[$k] . '">Delete Appointment entry</h4>
								</div>
								<div class="modal-body">
								Do You really want to delete the Appointment entry ?? press <strong>OK</strong> to delete
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteOk_' . $grpappid[$k] . '">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_' . $grpappid[$k] . '">Cancel</button>
								</div>
								</div>
								</div>
								</div></td></tr><tr>
                                                                <td colspan="7"><div id="edit_details_' . $grpappid[$k] . '"></div></td></tr>';
                }
                $pdata1[$i] .='<tr style="display:none;"><td colspan="3"><button  id="eplus_slots_' . $pdetails[$i]['weekofday'] . '" type="button" class="text-primary btn btn-success  btn-md"><i class="fa fa-plus fa-fw "></i> </button>
                                                                <div class="col-md-12" id="emultiple_slots' . $pdetails[$i]['weekofday'] . '"> <br/>
                                                                   </div>
                                                                <p class="help-block" id="emultiple_slotsmsg"></p></td></tr><tr><td colspan="3"><button type="button" class="btn btn-danger" id="eaddappointSubmit' . $pdetails[$i]['weekofday'] . '">&nbsp;Save</button><br/><p class="help-block" id="eappointconfgmsg"></p></td></tr>' . $tablefooter . '</div>
                                        </div></div>';
            }
        } else {
            $pdata1[0] = 'No appoints to configure.';
            $pdata1[0] = 'No appoints to configure.';
        }
        $jsonmess = array(
            "status" => "success",
            "det" => $this->vendata,
            "serviceid" => $this->venidd,
            "ctdata" => $ctdata,
            "divheader" => '<div id="viewappoint">',
            "divheader1" => '<div id="viewappoint">',
            "divfooter" => '</div></div></div></div></div>',
//                  "divheader"=>'<div class="row"><div class="col-md-12"><div class="panel panel-success">
//                                <div class="panel-heading">View Appointments</div><div class="panel-body"><div class="panel-group" id="viewappoint">' ,
//                  "divheader1"=>'<div class="row"><div class="col-md-12"><div class="panel panel-info">
//                                <div class="panel-heading">Edit Appointments</div><div class="panel-body"><div class="panel-group" id="viewappoint">' ,
//                  "divfooter" => '</div></div></div></div></div>',
            "pdata" => $pdata,
            "pdata1" => $pdata1,
            "appids" => $appids,
            "fromtime" => $appfromtime,
            "totime" => $apptotime,
            "location" => $applocation,
            "frequency" => $appfrequency,
            "dates" => $dates,
            "weekofdays" => $weekofdays,
            "weekofdayid" => $weekofdayid,
        );
        return $jsonmess;
    }

    public function bookSlot() {
        $query = 'SELECT * FROM  `bookinghistory` WHERE `apptdescb_id`=' . mysql_real_escape_string($this->parameters['slotid']) . ''
                . ' AND `date`="' . mysql_real_escape_string($this->parameters['date']) . '"  AND `vehicle_id` = "'.mysql_real_escape_string($this->parameters['vhid']).'" AND `patientid`=
                         "' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]) . '";';
        $result = executeQuery($query);
        $check = mysql_num_rows($result);
        $data = array(
            "status" => "failure",
            "userid" => $_SESSION["USER_LOGIN_DATA"]["USER_ID"],
            "rowid" => $this->parameters['rowid']
        );
         if ($check) {
        } else {
            $query1 = 'INSERT INTO `bookinghistory`(`id`,`apptdescb_id`,`date`,`patientid`,`vehicle_id`,`servicetype`,`bookservice`,`bookdetails`,`status_id`) VALUES(null,"'
                    . mysql_real_escape_string($this->parameters['slotid']) . '","'
                    . mysql_real_escape_string($this->parameters['date']) . '","'
                    . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]) . '","'
                    . mysql_real_escape_string($this->parameters['vhid']) . '","'
                    . mysql_real_escape_string($this->parameters['typeofservice']) . '","'
                    . mysql_real_escape_string($this->parameters['bookaservice']) . '",'
                    . 'CURRENT_TIMESTAMP(),4'
                    . ');';
            if (executeQuery($query1)) {
                $query = 'UPDATE `appointment_descb` SET `filled` = `filled`+1 WHERE `id`="'
                        . mysql_real_escape_string($this->parameters['slotid']) . '" AND `date`="'
                        . mysql_real_escape_string($this->parameters['date']) . '"';
                executeQuery($query);
                $query = 'UPDATE `user_vehicle` SET `preferred_service_center` ="'.$this->parameters['servid'].'" WHERE `id`="'.  mysql_real_escape_string($this->parameters['vhid']).'";';
                executeQuery($query);
            }
            $data = array(
                "status" => "success",
                "userid" => $_SESSION["USER_LOGIN_DATA"]["USER_ID"],
                "rowid" => $this->parameters['rowid']
            );
        }
        return $data;
    }

    public function deleteAppointment() {
        $query = 'UPDATE `bookinghistory` SET `status_id`="6" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
         executeQuery($query);
        $query = 'UPDATE `appointment_descb` SET `filled`=`filled`-1 WHERE `id`="' . mysql_real_escape_string($this->parameters['addpdescbid']) . '"';
        return executeQuery($query);
    }

}

?>
