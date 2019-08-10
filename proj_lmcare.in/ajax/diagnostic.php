<?php

class diagnostic {
     protected $parameters = array();
                function __construct($parameters = false) {
                    $this->parameters = $parameters;
		}
                public function fetchDiagnosticsTests() {
                    $pdetails=array();
                    $pdata=array();
                  $query='SELECT GROUP_CONCAT(ddb.`test_subtype_id`) AS testids,
                            GROUP_CONCAT(tst.`test_name`) as testname,
                            dd.`patient_id` as patientid,
                            up.`name` AS patientname,
                            up.`cell_number` AS mobile
                            FROM `diagnostic`dd
                            LEFT JOIN
                            `diagnostic_descb` ddb
                            ON dd.`id`=ddb.`diagnostics_id`
                            LEFT JOIN
                            `test_subtype` tst
                            ON tst.`id`=ddb.`test_subtype_id`
                            LEFT JOIN `user_profie` up
                            ON up.`id`=dd.`patient_id`
                            WHERE dd.`diagnostic_to_id`='.$_SESSION['userdata']['id'].' AND (dd.`date_time` BETWEEN DATE_SUB(CURDATE(),INTERVAL 3 DAY)  AND CURDATE())
                            GROUP BY ddb.`diagnostics_id`
                            ORDER BY dd.`date_time` DESC ';  
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
                                  <th>Test</th>
          `			</tr>
                                </thead><tbody>';
                        $tablefooter='</tbody></table></div>';
                        $num=  sizeof($pdetails);
                         for($i=0;$i<$num;$i++)
                          {
                              $tabletname=  explode(',', $pdetails[$i]['testname']);
                        $pdata[$i]='<div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#phistory" href="#phistoryy'.$i.'" class="collapsed">P-'.$pdetails[$i]['patientid'].' - '.$pdetails[$i]['patientname'].' - '.$pdetails[$i]['mobile'].'</a>
                                        </h4>
                                        </div><div id="phistoryy'.$i.'" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">'.$theader.'
                                        <tr>';
                                $k=1;
                                       for($j=0;$j<sizeof($tabletname);$j++) 
                                       {
                            $pdata[$i] .='<td>'.$k++.' </td><td>'. $tabletname[$j].' </td></tr>'  ;             
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

