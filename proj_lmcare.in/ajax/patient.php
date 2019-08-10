<?php
class patient {
    protected $parameters = array();
                function __construct($parameters = false) {
                    $this->parameters = $parameters;
		}
                public function fetchdocappointmentdetails() {
                $pdetails=array();
                $pdata1=array();
                $appids=array();
                $appfromtime=array();
                $apptotime=array();
                $applocation=array();
                $appfrequency=array();
                $dates=array();
                $weekoftheday=array('','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
                $query='SELECT ap.`weekofday`,
                        GROUP_CONCAT(apd.`fromtime`) AS fromtime,
                        GROUP_CONCAT(apd.`totime`) AS totime,
                        GROUP_CONCAT(apd.`location`) AS location,
                        GROUP_CONCAT(apd.`frequency`) AS frequency,
                        GROUP_CONCAT(apd.`date`) AS date,
                        GROUP_CONCAT(apd.`filled`) AS filled,
                        GROUP_CONCAT(apd.`id`) AS apptid
                        FROM `appointment` ap
                        LEFT JOIN 
                       `appointment_descb` apd
                        ON ap.`id`=apd.`appoint_id`
                        WHERE ap.`status_id`=4 AND apd.`status_id`=4 AND ap.`doctorid`='.$_SESSION['userdata']['doctor_id'].'
                        GROUP BY (apd.`appoint_id`)
                        ORDER BY (ap.`weekofday`)';
                $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $pdetails[]=$row;
                      }
                    }
                    if(is_array($pdetails))
                    $num = sizeof($pdetails);
                    $theader1='<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                                <tbody><tr><th>#</th><th>Appointment Details</th><th>Option</th></tr>';
                    
                    $tablefooter='</tbody></table></div>';
                    if($num)
                    {
                          for($i=0;$i<$num;$i++)
                          {
                                $fromtimee=array();
                                $totimee=array();
                                $location=array();
                                $frequency=array();
                                $filled=array();
                                $grpappid=array();
                                $grpdates=array();
                                $p=1;
                                
                                $pdata1[$i] ='<div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#viewappoint" href="#editappointt'.$i.'" class="collapsed">'.$weekoftheday[$pdetails[$i]['weekofday']].'</a>
                                        </h4>
                                        </div><div id="editappointt'.$i.'" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">'.$theader1.'';
                                         $fromtimee=  explode(',', $pdetails[$i]['fromtime']); 
                                         $totimee=  explode(',', $pdetails[$i]['totime']); 
                                         $location=  explode(',', $pdetails[$i]['location']); 
                                         $frequency=  explode(',', $pdetails[$i]['frequency']); 
                                         $filled=  explode(',', $pdetails[$i]['filled']); 
                                         $grpappid=  explode(',', $pdetails[$i]['apptid']);
                                         $grpdates=  explode(',', $pdetails[$i]['date']);
                                         for($k=0;$k<sizeof($fromtimee);$k++)
                                         {
                                         $appids[]=$grpappid[$k];
                                         $dates[]=$grpdates[$k];
                                         $appfromtime[]=$fromtimee[$k];
                                         $apptotime[]=$totimee[$k];
                                         $applocation[]=$location[$k];
                                         $appfrequency[]=$frequency[$k];    
                                         $pdata1[$i] .='<tr id="row_id'.$grpappid[$k].'"><td>'.$p++.'</td>
                                                    <td>Time :  '.$fromtimee[$k].' - '.$totimee[$k].'<br/> Location : '.$location[$k].'<br/>no of slots : '.$frequency[$k].'<br/> Available : '.($frequency[$k]-$filled[$k]).'</td>';
                                         if(($frequency[$k]-$filled[$k])<= 0)
                                         {
                                        $pdata1[$i] .='<td>;
                                           <button class="btn btn-danger  btn-md" ><i class="fa fa-edit fa-fw fa-x2"></i>  Not Available</button>&nbsp;</td></tr>';    
                                         }
                                         else {
                                        $pdata1[$i] .= '<td>;
                                           <button class="btn btn-success  btn-md" name="'.$grpappid[$k].'" id="delete_apptt_'.$grpappid[$k].'" data-toggle="modal" data-target="#myModal_'.$grpappid[$k].'"><i class="fa fa-edit fa-fw fa-x2"></i> Book Now</button>&nbsp;
								<div class="modal fade" id="myModal_'.$grpappid[$k].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_'.$grpappid[$k].'" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModalLabel_'.$grpappid[$k].'">Book Appointment entry</h4>
								</div>
								<div class="modal-body">
								Do You really want to Book the Appointment  ?? press <strong>OK</strong> to Book
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="bookOk_'.$grpappid[$k].'">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_'.$grpappid[$k].'">Cancel</button>
								</div>
								</div>
								</div>
								</div> '     
                                        . '</td></tr>';
                                         }
                                         }
                                $pdata1[$i] .=$tablefooter.'</div>
                                        </div></div>';
                             }
                    }
                 $jsonmess=array(
                   "divheader1"=>'<div class="row"><div class="col-md-12"><div class="panel panel-success">
                                <div class="panel-heading">Appointments</div><div class="panel-body"><div class="panel-group" id="viewappoint">' ,  
                  "divfooter" => '</div></div></div></div></div>',
                  "pdata1"       =>$pdata1 , 
                  "appids"      => $appids,
                  "fromtime"    => $appfromtime,
                  "totime"      => $apptotime,
                  "location"    => $applocation,
                   "frequency"  => $appfrequency,
                   "dates"      => $dates,  
                     );   
                     return $jsonmess;      
                }
                public function fetchpatientcurrentpres() {
                    $prescription=array();
                    $presdata='';
                    $query='SELECT GROUP_CONCAT(pd.`tablet_name` ) AS tablet_name,
                            GROUP_CONCAT(pd.`morning`) AS morning,
                            GROUP_CONCAT(pd.`afternoon`) AS afternoon,
                            GROUP_CONCAT(pd.`evening`) AS evening,
                            GROUP_CONCAT(pd.`frequency`) AS frequency,
                            GROUP_CONCAT(pd.`dosage`) AS dosage
                            FROM `prescription_descb` pd
                            LEFT JOIN `status` s
                            ON s.`id`=pd.`morning` AND s.`id`=pd.`afternoon` AND s.`id`=pd.`evening`
                            WHERE  `presciption_id`=
                            (SELECT `id` FROM `prescription`
                            WHERE `patientid`='.$_SESSION['userdata']['id'].' 
                            ORDER BY `id` DESC
                            LIMIT 0,1 
                            )
                            GROUP BY pd.presciption_id';
                    $result=  executeQuery($query);
                    while($row=  mysql_fetch_assoc($result))
                    {
                     $prescription[]=$row;   
                    }
                    $s=1;
                    for($i=0;$i<sizeof($prescription);$i++)
                    {
                       $tablets=array();
                       $morning=array();
                       $afternoon=array();
                       $evening=array();
                       $frequency=array();
                       $dosage=array();
                       $tablets=  explode(',', $prescription[$i]['tablet_name']);
                       $morning=  explode(',', $prescription[$i]['morning']);
                       $afternoon=  explode(',', $prescription[$i]['afternoon']);
                       $evening=  explode(',', $prescription[$i]['evening']);
                       $frequency=explode(',', $prescription[$i]['frequency']);
                       $dosage=  explode(',', $prescription[$i]['dosage']);
                       for($j=0;$j<sizeof($tablets);$j++)
                       {
                           if($morning[$j]=='0'|| $morning[$j]== '27' )
                           {
                               $mor='';
                           }
                            else {
                              $mor=$_SESSION['status'][$morning[$j]].' Breakfast <br/>' ; 
     
                                }
                            if($afternoon[$j]== '0' || $afternoon[$j]== '27' )
                            {
                               $aft='';
                            }
                            else {
                              $aft=$_SESSION['status'][$afternoon[$j]].' Lunch <br/>' ; 
     
                                }   
                            if($evening[$j]== '0' || $evening[$j]== '27' )
                                {
                               $eve='';
                                }
                           else {
                              $eve=$_SESSION['status'][$evening[$j]].' Dinner <br/>' ; 
     
                                } 
                           $presdata .= '<tr><td>'.$s++.'</td><td>'.$tablets[$j].'</td><td>'.$mor.' '.$aft.''
                                   . ''.$eve.''.$frequency[$j].' Days<br/> Dosage -'.$dosage[$j].'</td></tr>';
                       }
                       $header='<div class="panel panel-danger">
				<div class="panel-heading">
				Prescription
					</div>
                                <div class="panel-body">
                                <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                        <tr>
                                                    <th>#</th>
                                                    <th>Tabet Name</th>
                                                    <th>Prescription</th>
                            `			</tr>
                                                  </thead>
					<tbody>';
                       $footer=' </tbody></table></div></div></div>';
                       return $header.$presdata.$footer;
                    }
                    
                
                }
                public function fetchPatientPresciptionHistory()
                    {
                        $pdetails=array();
                        $pdata=array();
                        $query='SELECT padescb.`currentassesment`,padescb.`date` AS DATE,padescb.`remark` ,
                                GROUP_CONCAT(presdescb.`tablet_name`) AS tabletnam,
			CASE WHEN (presdescb.`tablet_name` IS NULL OR presdescb.`tablet_name` = "" ) THEN "-" ELSE GROUP_CONCAT(presdescb.`tablet_name`)  end AS tabletname,
                        GROUP_CONCAT(presdescb.`morning`)AS mornin,
                        CASE WHEN ((presdescb.`morning` IS NULL OR presdescb.`morning` = "" )  and presdescb.`morning` != 0) THEN "0" ELSE GROUP_CONCAT(presdescb.`morning`)  END AS morning,
                        GROUP_CONCAT(presdescb.`afternoon`)AS afternoo,
                        CASE WHEN ((presdescb.`afternoon` IS NULL OR presdescb.`afternoon` = "" )  and presdescb.`afternoon` != 0 ) THEN "0" ELSE GROUP_CONCAT(presdescb.`afternoon`)  END AS afternoon,
                        GROUP_CONCAT(presdescb.`evening`)AS evenin,
                        CASE WHEN ((presdescb.`evening` IS NULL OR presdescb.`evening` = "" )  and presdescb.`evening` != 0 ) THEN "0" ELSE GROUP_CONCAT(presdescb.`evening`)  END AS evening,
                                GROUP_CONCAT(presdescb.`frequency`)AS frequency,
                                GROUP_CONCAT(presdescb.`dosage`)AS dosage
                                FROM `passesment_descb` padescb
                                LEFT JOIN `prescription` pres
                                ON pres.passemt_descb_id=padescb.id
                                LEFT JOIN `prescription_descb` presdescb
                                ON presdescb.`presciption_id`=pres.`id` 
                                WHERE padescb.`patient_id`='.$_SESSION['userdata']['id'].'
                                GROUP BY presdescb.`presciption_id`
                                ORDER BY padescb.`date` DESC ';
                        $result=  executeQuery($query);
                        $patientdata=array();
                        while ($row = mysql_fetch_assoc($result)) {
                           $pdetails[]=$row; 
                        }
                        
                        $theader='<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                                 <thead>
                                 <tr>
                                  <th>#</th>
                                  <th>Tabet Name</th>
                                  <th>Prescription</th>
          `			</tr>
                                </thead><tbody>';
                        $tablefooter='</tbody></table></div>';
                        $num=  sizeof($pdetails);
                         for($i=0;$i<$num;$i++)
                          {
                              $tabletname=array();
                              $morning=array();
                              $afternoon=array();
                              $evening=array();
                              $frequency=array();
                              $dosage=array();
                              $tabletname=  explode(',', $pdetails[$i]['tabletname']);
                              $morning=  explode(',', $pdetails[$i]['morning']);
                              $afternoon=  explode(',', $pdetails[$i]['afternoon']);
                              $evening=  explode(',', $pdetails[$i]['evening']);
                              $frequency=  explode(',', $pdetails[$i]['frequency']);
                              $dosage=  explode(',', $pdetails[$i]['dosage']);
                        $pdata[$i]='<div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#phistory" href="#phistoryy'.$i.'" class="collapsed">'.$pdetails[$i]['DATE'].'</a>
                                        </h4>
                                        </div><div id="phistoryy'.$i.'" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">'.$theader.'
                                        <tr>';
                                $k=1;
                            if($tabletname[0]=='-')
                            {
                                
                            }
                            else {
                            for($j=0;$j<sizeof($tabletname);$j++) 
                            {
                            if($morning[$j]=='0'|| $morning[$j]== '27' )
                            {
                               $mor='';
                            }
                            else {
                              $mor=$_SESSION['status'][$morning[$j]].' Breakfast <br/>' ; 
                                }
                            if($afternoon[$j]== '0' || $afternoon[$j]== '27' )
                            {
                               $aft='';
                            }
                            else {
                              $aft=$_SESSION['status'][$afternoon[$j]].' Lunch <br/>' ; 
                                }   
                            if($evening[$j]== '0' || $evening[$j]== '27' )
                                {
                               $eve='';
                                }
                           else {
                              $eve=$_SESSION['status'][$evening[$j]].' Dinner <br/>' ; 
                                } 
                            $pdata[$i] .='<td>'.$k++.' </td><td>'. $tabletname[$j].' </td><td> '.$mor.''.$aft.' '.$eve.''.' '.
                                     '     '.$frequency[$j].' Days<br/> Dosage - '.$dosage[$j].'</td></tr>'  ;             
                                       }
                            }       
                            $pdata[$i] .= '    
                                        '.$tablefooter.'</div>
                                    </div></div>';
                          }
                        $jsonmess=array(
                  "divheader"=>'<div class="row"><div class="col-md-12"><div class="panel panel-danger">
                                <div class="panel-heading">Patient History</div><div class="panel-body"><div class="panel-group" id="phistory">' ,  
                  "divfooter" => '</div></div></div></div></div>',
                  "pdata" =>$pdata  
                     );   
                     return $jsonmess;    
                    }   
                public function bookSlot() {
                $query='SELECT * FROM  `bookinghistory` WHERE `apptdescb_id`='.mysql_real_escape_string($this->parameters['slotid']).''
                        . ' AND `date`="'.mysql_real_escape_string($this->parameters['date']).'"  AND `patientid`=
                         '.mysql_real_escape_string($_SESSION['userdata']['id']).';';  
                $result=  executeQuery($query);
                $check=  mysql_num_rows($result);
                if($check)
                {
                    return $check;   
                }  
                else {
                 $query1='INSERT INTO `bookinghistory`(`id`,`apptdescb_id`,`date`,`patientid`,`bookdetails`,`status_id`) VALUES(null,"'
                         .mysql_real_escape_string($this->parameters['slotid']).'","'
                         .mysql_real_escape_string($this->parameters['date']).'","'
                         .mysql_real_escape_string($_SESSION['userdata']['id']).'",CURRENT_TIMESTAMP(),4'
                         . ');'  ; 
                 if(executeQuery($query1))
                 {
                     $query='UPDATE `appointment_descb` SET `filled` = `filled`+1 WHERE `id`="'
                             . mysql_real_escape_string($this->parameters['slotid']).'" AND `date`="'
                             . mysql_real_escape_string($this->parameters['date']).'"';
                     executeQuery($query);
                 }
                 
                 return $check;
                }
                    }
                function fetchAppointmentBookingHistory()
                    {
                    $appdetails=array();
                    $appdeta='';
                       $query='SELECT bh.`date` AS DATE,
                                ad.fromtime AS fromtime,
                                ad.totime AS totime,
                                ad.location AS location,
                                bh.bookdetails AS bookingDetails
                                FROM `bookinghistory`  bh
                                LEFT JOIN
                                `appointment_descb` ad
                                ON bh.`apptdescb_id`=ad.`id`  
                               WHERE `patientid`="'.mysql_real_escape_string($_SESSION['userdata']['id']).'" ORDER BY `date` DESC LIMIT 0,15';
                       $result=  executeQuery($query);
                       if(mysql_num_rows($result)>0)
                       {
                           while ($row = mysql_fetch_assoc($result)) {
                             $appdetails[]=$row;  
                           }
                       }
                       $j=1;
                       for($i=0;$i<sizeof($appdetails);$i++)
                       {
                         $appdeta .= '<tr><td>'.$j++.'</td><td> Date : '.$appdetails[$i]['DATE'].''
                                    . '<br/> Time : '.$appdetails[$i]['fromtime'].' - '
                                    . ''.$appdetails[$i]['totime'].''
                                    . '<br/> Location : '.$appdetails[$i]['location'].''
                                    . '<br/> Booked at : '.$appdetails[$i]['bookingDetails'].'</td>'
                                    . '</tr>';  
                       }
                       $tableheader='<div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                    <th>Booked Details</th>
                            `			</tr>
                                                  </thead>
					<tbody>';
                     $tablefooter='</tbody></table></div>'  ;
                     return $tableheader.$appdeta.$tablefooter;
                    }
}
