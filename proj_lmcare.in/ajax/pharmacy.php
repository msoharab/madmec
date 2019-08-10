<?php

class pharmacy {
    protected $parameters = array();
                function __construct($parameters = false) {
                    $this->parameters = $parameters;
		}
                public function fetchPharmacyPatienrtList() {
                    $pdetails=array();
                    $pdata=array();
                    $query='SELECT up.`id`,up.`cell_number`,up.`name`,phar.`date-time`,
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
                            FROM `pharmacy` phar
                            LEFT JOIN `prescription` pres
                            ON pres.id=phar.prescribtion_id
                            LEFT JOIN `prescription_descb` presdescb
                            ON presdescb.`presciption_id`=pres.`id` 
                            LEFT JOIN `user_profie` up
                            ON up.id=pres.patientid
                            WHERE (phar.`date-time` BETWEEN DATE_SUB(CURDATE(),INTERVAL 3 DAY)  AND CURDATE()) AND phar.pharmacyid='.$_SESSION['userdata']['id'].'
                            GROUP BY presdescb.`presciption_id`
                            ORDER BY phar.`date-time` DESC ' ; 
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0)
                    {
                        while ($row=  mysql_fetch_assoc($result))
                        {
                            $pdetails[]=$row;
                        }
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
                                        <a data-toggle="collapse" data-parent="#phistory" href="#phistoryy'.$i.'" class="collapsed">P-'.$pdetails[$i]['id'].' - '.$pdetails[$i]['name'].' - '.$pdetails[$i]['cell_number'].'</a>
                                        </h4>
                                        </div><div id="phistoryy'.$i.'" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">'.$theader.'
                                        <tr>';
                                $k=1;
                                if($tabletname[0] != '-')
                                {
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
                            $pdata[$i] .='<td>'.$k++.' </td><td>'. $tabletname[$j].' </td><td> '.$mor.''.$aft.''.$eve.''.
                                        '     '.$frequency[$j].' Days<br/> Dosage  '.$dosage[$j].'</td></tr>'  ;             
                                       }
                                }       
                            $pdata[$i] .= '    
                                        '.$tablefooter.'</div>
                                    </div></div>';
                          }
                        $jsonmess=array(
                  "divheader"=>'<div class="row"><div class="col-md-12"><div class="panel panel-danger">
                                <div class="panel-heading">Patient List</div><div class="panel-body"><div class="panel-group" id="phistory">' ,  
                  "divfooter" => '</div></div></div></div></div>',
                  "pdata" =>$pdata  
                     );   
                     return $jsonmess;    
                    }   
                    
                }    

