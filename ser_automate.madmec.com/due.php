<?php
class due {
    protected $parameters = array();
                function __construct($parameters = false) {
                    $this->parameters = $parameters;
		}
                public function projduelist()
                {
                    $jsonmo=array();
                    $dueids=array();
                    $dues=array();
                    $clientids=array();
                    $projectids=array();
                    $dueamount=array();
                    $html=array();
                    $query='SELECT t1.`due_date` AS duedate,t1.`id` AS dueid,
                            up.`user_name` AS clientname,
                            t1.`incoming_proj_id` AS projid,
                            p.`name` AS projname,
                            qt.`net_total` AS rngtotal,
                            t1.`due_amount` AS dueamount,
                            r.`from_pk` AS clientid,
                            t2.maxid
                            FROM `due` t1
                            INNER JOIN
                            (
                            SELECT MAX(`id`) maxid, `incoming_proj_id`
                            FROM `due`
                            GROUP BY `incoming_proj_id`
                            ) t2
                            ON t1.`incoming_proj_id` = t2.`incoming_proj_id`
                            AND t1.`id` = t2.`maxid`  AND t1.`status_id`=4
                            LEFT JOIN `project` AS p 
                            ON p.`id`=t1.`incoming_proj_id`
                            LEFT JOIN `requirements` r ON
                            r.`id`=p.`requi_id`
                            LEFT JOIN `user_profile` up
                            ON up.`id`=r.`from_pk`
                            LEFT JOIN `quotation` qt
                            ON qt.`requi_id`=r.`id`';
                    $result=executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $dues[]=$row;
                      }
                    }
                      if(is_array($dues))
                        $num = sizeof($dues);
			if($num){
                            $j=0;
			for($i=0;$i<$num;$i++){
					$html[] = '<tr id="due_row_'.$dues[$i]["dueid"].'"><th>'.++$j.'</th><th>'.$dues[$i]["projname"].'</th><th class="text-right">'.$dues[$i]["clientname"].'</th><th class="text-center">'.$dues[$i]["rngtotal"].'</th>
                                                                <th class="text-center">'.$dues[$i]["dueamount"].'</th><th class="text-center">'.$dues[$i]["duedate"].'</th><th>
								<button class="btn btn-success  btn-md" name="'.$dues[$i]["dueid"].'" id="delete_moitem_'.$dues[$i]["dueid"].'" data-toggle="modal" data-target="#myModal_'.$dues[$i]["dueid"].'"><i class=""></i> Pay</button>&nbsp;
								<div class="modal fade" id="myModal_'.$dues[$i]["dueid"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_'.$dues[$i]["dueid"].'" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModalLabel_'.$dues[$i]["dueid"].'">Pay Due Amount  entry</h4>
								</div>
								<div class="modal-body">
								Do You really want to Pay the Due Amout ?? press <strong>OK</strong> to Pay
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteOk_'.$dues[$i]["dueid"].'">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_'.$dues[$i]["dueid"].'">Cancel</button>
								</div>
								</div>
								</div>
								</div>
						</th></tr>';
						$projectids[] = $dues[$i]["projid"];
                                                $dueids[]=$dues[$i]["dueid"];
                                                $clientids[]=$dues[$i]["clientid"];
                                                $dueamount[]=$dues[$i]["dueamount"];
                                                
                        }
                        }
                         $jsonmo = array("header_html"	=> '<div class="panel panel-warning">
                                                            <div class="panel-heading"> <strong>Due Details</strong>&nbsp; </div>',
                                          "tableheader"=>   '<div class="panel-body"> <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover" id="dataTables-projectdue"><thead><tr><th class="text-right">#</th><th>Project Name</th><th>Client Name</th><th>Grand Total</th><th>Due Amount</th><th>Due Date</th><th>Option</th></tr></thead><tbody>',
                                                                "html"          =>  $html,
								"Projectids"      => $projectids,
                                                                "dueids"        => $dueids,
                                                                "clientids"     => $clientids,
                                                                "dueamount"     => $dueamount,
								"duerow" 	=> '#due_row_',
								"ds" 		=> '#delete_moitem_',
								"alert" 	=> '#myModal_',
								"deleteOk" 	=> '#deleteOk_',
								"deleteCancel" 	=> '#deleteCancel_',
                                                                "footer" => '</tbody></table></div></div></div>');
                        return $jsonmo;
                }
                public function payduecash(){
                    $flag=false;
                    executeQuery("SET AUTOCOMMIT=0;");
                    executeQuery("START TRANSACTION;");
                    $query='INSERT INTO `incoming_proj`(`id`,`from_pk`,`to_pk`,`proj_id`,`amount`,`dopaid`,`remark`,`status_id`)'
                            . 'VALUES(null,'
                            . '"'.  mysql_real_escape_string($this->parameters['clientid']).'",9,"'
                            .mysql_real_escape_string($this->parameters['projid']).'","'
                            .mysql_real_escape_string($this->parameters['dueamount']).'",now(),"Pay by Due Amount",4'
                            . ')';
                    if(executeQuery($query))
                    {
                        $query='UPDATE `due` SET `status_id`=5 WHERE `incoming_proj_id`='.  mysql_real_escape_string($this->parameters['projid']);
                        executeQuery($query);
                        $query='UPDATE `follow_up` SET `status_id`=5 WHERE `incoming_proj_id`='. mysql_real_escape_string($this->parameters['projid']);
                        $res=  executeQuery($query);
                        if($res)
                        {
                          executeQuery("COMMIT;");
                          $flag=true;
                        }
                      
                        
                    }
                    return  $res;
                   
                }
        }
