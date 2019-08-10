<?php
class  dueadmin
{
   protected $parameters = array();
		function __construct($parameters = false) {
			$this->parameters = $parameters;
                        
		} 
                public function fetchAdminDues() {
                $duedata=array();  
                $dueids=array();
                $userpks=array();
                $dueamount=array();
                $ownername=array();
                $mobile=array();
                $email=array();
                $username=array();
                $duedate=array();
                $mop=array();
                $pay=array();
                $mopdatastr='';
                $mopdata=array();
                $mopquery="SELECT * FROM `mode_of_payment` WHERE `status_id`=4";
                $mopres=  executeQuery($mopquery);
                if(mysql_num_rows($mopres))
                {
                    while ($row = mysql_fetch_array($mopres)) {
                       $mopdata[]=$row;
                               
                    }
                    for($i=0;$i<sizeof($mopdata);$i++)
                    {
                    $mopdatastr .= '<option value="'.$mopdata[$i]['id'].'">'.$mopdata[$i]['mop'].'</option>';
                    }
                }
                else
                {
                   $mopdatastr='' ;
                }
                $data='';
                $query='SELECT d1.due_amount,
                        d1.id,
                        d1.due_date,
                        up.owner_name AS ownername,
                        up.cell_code,
                        up.cell_number,
                        up.email,
                        up.user_name,
                        d1.user_pk
                        FROM due d1
                        INNER JOIN (
                        SELECT MAX(id) AS maxid,
                        user_pk AS userpk
                        FROM due
                        GROUP BY user_pk
                        )d2
                        ON d1.user_pk=d2.userpk AND d2.maxid=d1.id
                        LEFT JOIN user_profile up
                        ON up.id=d1.user_pk
                        WHERE d1.status_id=4'    ;
                $result=  executeQuery($query);
                if(mysql_num_rows($result))
                {
                    $m=1;
                    while ($row = mysql_fetch_assoc($result)) {
                        $duedata[]=$row;
                    }
                    for($i=0;$i<sizeof($duedata);$i++)
                    {
                     $dueids[$i]=   $duedata[$i]['id'];
                     $userpks[$i] = $duedata[$i]['user_pk'];
                     $dueamount[$i] = $duedata[$i]['due_amount'];
                     $ownername[$i]=$duedata[$i]['ownername'];
                     $mobile[$i] = $duedata[$i]['cell_code'].' - '.$duedata[$i]['cell_number'];
                     $email[$i]=$duedata[$i]['email'];
                     $username[$i]=$duedata[$i]['user_name'];
                     $duedate[$i]=$duedata[$i]['due_date'];
                     $pay[$i]='<button type="button" class="btn btn-success" id="pay'.$duedata[$i]['id'].'" data-toggle="modal" data-target="#myModal_'.$duedata[$i]['id'].'"> &nbsp;Pay Now</button>'
                             . '<div class="modal fade" id="myModal_'.$duedata[$i]['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_'.$duedata[$i]['id'].'" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                <div class="modal-content" style="color:#000;">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel_'.$duedata[$i]['id'].'">Pay Due Amount</h4>
                                </div>
                                <div class="modal-body">
                                Do You really want to Pay Due Amount ?? press <strong>OK</strong> to Pay
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="payOk_'.$duedata[$i]['id'].'">Ok</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_'.$duedata[$i]['id'].'">Cancel</button>
                                </div>
                                </div>
                                </div>
                                </div>';
                     $mop[$i] = '<select class="form-control" id="duemop_'.$duedata[$i]['id'].'"><option value="hai">please select MOP</option>'.$mopdatastr.'</select>';
                     $data .='<tr><td>'.$m++.'</td><td>'.$duedata[$i]['ownername'].'</td><td>'.$duedata[$i]['cell_code'].' - '.$duedata[$i]['cell_number'].'</td><td>'.$duedata[$i]['email'].'</td>'
                             . '<td>'.$duedata[$i]['user_name'].'</td><td class="text-right">'.$duedata[$i]['due_amount'].'&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td><td>'.$duedata[$i]['due_date'].'</td>'
                              . '<td><select class="form-control" id="duemop_'.$duedata[$i]['id'].'"><option value="">please select MOP</option>'.$mopdatastr.'</select></td>'
                             . '<td><button type="button" class="btn btn-success" id="pay'.$duedata[$i]['id'].'" data-toggle="modal" data-target="#myModal_'.$duedata[$i]['id'].'"> &nbsp;Pay Now</button>'
                             . '<div class="modal fade" id="myModal_'.$duedata[$i]['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_'.$duedata[$i]['id'].'" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                <div class="modal-content" style="color:#000;">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel_'.$duedata[$i]['id'].'">Pay Due Amount</h4>
                                </div>
                                <div class="modal-body">
                                Do You really want to Pay Due Amount ?? press <strong>OK</strong> to Pay
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="payOk_'.$duedata[$i]['id'].'">Ok</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_'.$duedata[$i]['id'].'">Cancel</button>
                                </div>
                                </div>
                                </div>
                                </div>'
                             . '</td></tr>';   
                    } 
                    $jsondata=array(
                        "status" => "success",
                        "data" => $data,
                        "ids"  => $dueids,
                         "userpks" => $userpks,
                        "dueamount" => $dueamount,
                        "mop"   => $mopdatastr
                    );
                    return $jsondata;
                }
                else
                {
                    $jsondata=array(
                        "status" => "failure",
                        "data" => NULL,
                          "mop"   => $mopdatastr
                    );
                    return $jsondata;
                }
                
                
                }  
                public function payAdminDue() {
                  $query='INSERT INTO `transactions_details`(`id`,`user_pk`,`mop_id`,`date`,`amount`,`remark`,`status`)VALUES(NULL,'
                          . '"'.  mysql_real_escape_string($this->parameters['userpk']).'","'.  mysql_real_escape_string($this->parameters['mop']).'",now(),'
                          .'"'.  mysql_real_escape_string($this->parameters['amt']).'","due amount",4'
                          . ')';  
                  if(executeQuery($query))
                  {
                      $query='UPDATE `due` SET `status_id`=16 WHERE `user_pk`="'.mysql_real_escape_string($this->parameters['userpk']).'"';
                     $res= executeQuery($query);
                  }
                  return $res;
                }
}

?>

