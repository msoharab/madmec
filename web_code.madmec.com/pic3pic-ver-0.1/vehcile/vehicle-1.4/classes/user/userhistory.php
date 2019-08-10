<?php

class userhistory {
   protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
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
                  WHERE bh.`status_id`=36
                      AND bh.patientid ='".  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"])."'
                      ORDER BY apdesc.`date`";
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
}
?>
