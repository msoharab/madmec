<?php
class superadmin {
    protected $parameters=array();
    public function __construct($paramaters=false) {
        $this->parameters=$paramaters;
    }
    public function createDoctor() {
            $query='INSERT INTO `user_profie`(`id`,`username`,`password`,`email_id`,`user_type_id`,`status_id`) VALUES(NULL,'
                                                . '"'.  mysql_real_escape_string($this->parameters['doctorusername']).'",'
                                                . '"'.  mysql_real_escape_string($this->parameters['doctorpassword']).'",'
                                                . '"'.  mysql_real_escape_string($this->parameters['docotoremailid']).'",1,4'
                                                . ');' ;  
            $result=  executeQuery($query);
            $from='no-reply@madmec.com';
            $to= mysql_real_escape_string($this->parameters['docotoremailid']);
            $message="Hi Doctor, <br /> You have been Successfully Registered with LMCare, below are the Credentials  <br />  <br />  <br />  Username:".mysql_real_escape_string($this->parameters['doctorusername'])
                    .' <br />  Password: '.mysql_real_escape_string($this->parameters['doctorpassword']).' <br />  <br />  <br />  Thanks & Regards <br />  LMCare';
            $subject="LMCare Registration";
				
				$flag1 = false;
				$mail = '';
				set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
				require_once(LIB_ROOT.MODULE_ZEND_1);
				require_once(LIB_ROOT.MODULE_ZEND_2);
				$config = array('auth' => 'login',
							'port' => MAILPORT,
							'username' => MAILUSER,
							'password' => MAILPASS);
						$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
						if($transport){
							$mail = new Zend_Mail();
							if($mail){
								$mail->setBodyHtml($message);
								$mail->setFrom(MAILUSER, ALTEMAIL);
								$mail->addTo($to, 'Dear User');
								$mail->setSubject(ORGNAME.$subject);
								$flag1 = true;
							}
						}
						if($flag1){
							try{
								$mail->send($transport);
								unset($mail);
								unset($transport);
								$flag1 = true;
							}
							catch(exceptoin $e){
								echo 'Invalid email id :- '.$to.'<br />';
								$flag1 = false;
							}
						}
						//return $flag1;
						
			
            return $result;
    }
    public function checkdocemail($docemail,$docotoremailidreq,$reqid) {
            if(mysql_real_escape_string($docotoremailidreq) == "req")
            {
                $query='SELECT * FROM `user_profie` WHERE `email_id`="'.  mysql_real_escape_string($docemail).'" AND `id` != '.mysql_real_escape_string($reqid);
            }
            else
            {
            $query='SELECT * FROM `user_profie` WHERE `email_id`="'.  mysql_real_escape_string($docemail).'"';
            }
            $result=  executeQuery($query);
            return mysql_num_rows($result);
    } 
    public function checkdocuser($docuser) {
            $query='SELECT * FROM `user_profie` WHERE `username`="'.  mysql_real_escape_string($docuser).'"';
            $result=  executeQuery($query);
            return mysql_num_rows($result);
    }
    public function fetchListOfDoctors() {
            $docdetails=array();
            $docids=array();
            $docdata='';
            $query='SELECT * FROM `user_profie` WHERE `user_type_id`=1 ORDER BY id';
            $result=  executeQuery($query);
            if(mysql_num_rows($result)>0)
            {
                while ($row=  mysql_fetch_assoc($result))
                {
                   $docdetails[]=$row; 
                }
                $j=1;
                for($i=0;$i<sizeof($docdetails);$i++)
                {
                    $docids[]=$docdetails[$i]['id'];
                 $docdata .= '<tr><td>'.$j++.'<td> D'.$docdetails[$i]['id'].' - '.$docdetails[$i]['name'].'<br/> Cell no '.$docdetails[$i]['cell_number'].'</td>'
                         . '';  
                 if($docdetails[$i]['status_id']=='4')
                 {
                   $docdata .='<td>Active</td><td><button class="btn btn-danger" id="inactive_'.$docdetails[$i]['id'].'" type="button">inActive</td>';   
                 }
                 else
                 {
                 $docdata .='<td>InActive</td><td><button class="btn btn-success" id="active_'.$docdetails[$i]['id'].'" type="button">Active</td></tr>';   
                 }
                }
                $tableheader='<table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name/Details</th>
                                            <th>Status</th>
                                            <th>Critical Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                $tablefooter='  </tbody>
                                </table>';
                $jsonnmess=array(
                    "docdata" => $tableheader.$docdata.$tablefooter,
                    "docids" =>$docids,
                );
                return $jsonnmess;
            }
            else
            {
                $jsonnmess=array(
                    "docdata" => "Not Yet Doctor has Registered",
                    "docids" =>$docids,
                );
                return $jsonnmess;
            }
        
    }
    public function makeDoctorInactive($did) {
        $query='UPDATE `user_profie` SET `status_id`=12 WHERE `id`='.  mysql_real_escape_string($did);
        $res=  executeQuery($query);
        return $res;
    }
    public function makeDoctorActive($did) {
        $query='UPDATE `user_profie` SET `status_id`=4 WHERE `id`='.  mysql_real_escape_string($did);
        $res=  executeQuery($query);
        return $res;
    }
    public function fetchDoctorsRequest() {
        $reqdetails=array();
        $reqids=array();
        $reqdata='';
        $query='SELECT GROUP_CONCAT(r.`to_pk`) AS reqid,
                COUNT(r.`to_pk`) AS noofreq,
                r.`from_pk` AS doctorid,
                (SELECT `name` FROM user_profie WHERE `id`=r.`from_pk`) AS doctorname,
                GROUP_CONCAT(up.`name`) AS reqname,
                GROUP_CONCAT(up.`email_id`) AS reqemail,
                GROUP_CONCAT(up.`cell_number`) AS reqmobile 
                FROM `relations` r
                LEFT JOIN `user_profie` up
                ON r.`to_pk`=up.`id`
                WHERE up.`status_id`=19
                GROUP BY `from_pk`';
        $result=  executeQuery($query);
        if(mysql_num_rows($result)>0)
        {
            while ($row = mysql_fetch_assoc($result)) {
               $reqdetails[]=$row; 
            }
            for($i=0;$i<sizeof($reqdetails);$i++)
            {
                $reqnames=  explode(',', $reqdetails[$i]['reqname']);
                $reqemails=  explode(',', $reqdetails[$i]['reqemail']);
                $reqnumbers=  explode(',', $reqdetails[$i]['reqmobile']);
                $grpreqids=explode(',',$reqdetails[$i]['reqid']);
                $divheader='<div class="panel-group" id="accordion">';
                $divfooter='</div>';
               $reqdata .= '<div class="panel panel-default">
                            <div class="panel-heading">
                            <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#doctorreqcollapse'.$i.'" class="collapsed">D'.$reqdetails[$i]['doctorid'].' -- '.$reqdetails[$i]['doctorname'].'</a>
                                    <span class="btn-danger btn-rounded">'.$reqdetails[$i]['noofreq'].'</span>
                            </h4>
                            </div><div id="doctorreqcollapse'.$i.'" class="panel-collapse collapse" style="height: 0px;">
                            <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name of patient/pharmacy/diagnostic</th>
                                                        <th>Create Credentials</th>
                                                        <th>Option</th>
                                                    </tr>
                                            </thead>
                                            <tbody>'; 
                                $k=1;
                                for($j=0;$j<sizeof ($reqnames);$j++) 
                                {
                                    $reqids[]=$grpreqids[$j];
                                   $reqdata .='<tr id="actrowid_'.$grpreqids[$j].'"><td>'.$k++.'</td><td> Name  :'.$reqnames[$j].'<br/> Cell  : '.$reqnumbers[$j].'<br/> Email : '.$reqemails[$j].'</td>
                                                <td>
                                                <div class="form-group">
                                                    <input class="form-control" id="requseremail'.$grpreqids[$j].'" value="'.  trim($reqemails[$j]).'"  placeholder="Enter the Emailid">
                                                                <p class="help-block" id="requseremailmsg'.$grpreqids[$j].'"></p>
                                                                    <input type="text" id="hidrequseremail'.$grpreqids[$j].'" hidden=""><input type="text" id="hidrequsername'.$grpreqids[$j].'" hidden="">
                                                        </div>
                                                <div class="form-group">
                                                    <input class="form-control" id="requsername'.$grpreqids[$j].'"  placeholder="Enter the User ID">
                                                                <p class="help-block" id="requsernamemsg'.$grpreqids[$j].'"></p>
                                                        </div>
                                                        <div class="form-group">
                                                                <input class="form-control" id="reqpassword'.$grpreqids[$j].'" type="password" placeholder="Enter the Password">
                                                                <p class="help-block" id="reqpasswordmsg'.$grpreqids[$j].'"></p>
                                                        </div></td><td>
                                                        <button class="btn btn-danger" id="sendreqemail'.$grpreqids[$j].'">Send Email</button></td></tr>';
                                }
                                $reqdata .='</tbody></table></div></div></div>';
               
            }
            $jsonmess=array(
              "reqids" => $reqids,
              "reqdata" => $divheader.$reqdata.$divfooter,  
            );
            return $jsonmess;
        }
        else
        {
            $jsonmess=array(
              "reqids" => $reqids,
              "reqdata" => "No Requests"  
            );
            return $jsonmess;
        }
    }
    public function activateUserAccount() {
        $query='UPDATE `user_profie` SET `username`="'.  mysql_real_escape_string($this->parameters['requsername']).'",'
                . '`password`="'. mysql_real_escape_string($this->parameters['reqpassword']).'",'
                . '`email_id`="'. mysql_real_escape_string($this->parameters['reqemail']).'", `status_id`=4 WHERE `id`='.mysql_real_escape_string($this->parameters['reqid']);
        $result=  executeQuery($query);
        $from='no-reply@madmec.com';
            $to= mysql_real_escape_string($this->parameters['reqemail']);
            $message="Hi ,<br />You Account have been Successfully Activated , below are the Credentials <br /><br /><br /> Username:".mysql_real_escape_string($this->parameters['requsername'])
                    .'<br /> Password: '.mysql_real_escape_string($this->parameters['reqpassword']).'<br /><br /><br /> Thanks & Regards <br /> LMCare';
            $subject="LMCare Account Activation";
           	
				$flag1 = false;
				$mail = '';
				set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
				require_once(LIB_ROOT.MODULE_ZEND_1);
				require_once(LIB_ROOT.MODULE_ZEND_2);
				$config = array('auth' => 'login',
							'port' => MAILPORT,
							'username' => MAILUSER,
							'password' => MAILPASS);
						$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
						if($transport){
							$mail = new Zend_Mail();
							if($mail){
								$mail->setBodyHtml($message);
								$mail->setFrom(MAILUSER, ALTEMAIL);
								$mail->addTo($to, 'Dear User');
								$mail->setSubject(ORGNAME.$subject);
								$flag1 = true;
							}
						}
						if($flag1){
							try{
								$mail->send($transport);
								unset($mail);
								unset($transport);
								$flag1 = true;
							}
							catch(exceptoin $e){
								echo 'Invalid email id :- '.$to.'<br />';
								$flag1 = false;
							}
						}
						//return $flag1;
						
        return $result;
    }
    public function createTest() {
        $query='SELECT `id` FROM `test_type` WHERE `test_cat_name`="'.mysql_real_escape_string($this->parameters['testcat']).'"';
        $result=executeQuery($query);
        if(mysql_num_rows($result)>0)
        {
         $row=  mysql_fetch_assoc($result);
         $lastid=$row['id'];
         $query='INSERT INTO `test_subtype`(`id`,`test_id`,`test_name`,`status_id`)VALUES(null,'
                .$lastid.',"'.mysql_real_escape_string($this->parameters['testname']).'",4)';
        $result=executeQuery($query);
        return $result;
        }
        else
        {
        $query='INSERT INTO `test_type`(`id`,`test_cat_name`,`status_id`)VALUES(null,'
                . '"'.mysql_real_escape_string($this->parameters['testcat']).'",4)';
        if(executeQuery($query))
        {
            $lastid=  mysql_insert_id();
            $query='INSERT INTO `test_subtype`(`id`,`test_id`,`test_name`,`status_id`)VALUES(null,'
                .$lastid.',"'.mysql_real_escape_string($this->parameters['testname']).'",4)';
        $result=executeQuery($query);
        return $result;
        }
        }
    }
    public function fetchDiagnosticTests() {
        $testdetails=array();
        $testids=array();
        $testdata='';
        $query='SELECT GROUP_CONCAT(tst.`test_name`) AS testname,
                GROUP_CONCAT(tst.`id`) AS testid,
                tt.test_cat_name AS cate
                FROM `test_subtype` tst
                LEFT JOIN
                `test_type` tt
                ON tt.id=tst.test_id
                WHERE tst.status_id=4 AND tt.status_id=4
                GROUP BY tst.test_id
                ORDER BY tt.test_cat_name ';
        $result=  executeQuery($query);
        if(mysql_num_rows($result)>0)
        {
            while ($row = mysql_fetch_assoc($result)) {
                $testdetails[]=$row;
            }
            for($i=0;$i<sizeof($testdetails);$i++)
            {
                $testnames=  explode(',', $testdetails[$i]['testname']);
                $grptestids=explode(',',$testdetails[$i]['testid']);
                $divheader='<div class="panel-group" id="accordion1">';
                $divfooter='</div>';  
                $testdata .= '<div class="panel panel-default">
                            <div class="panel-heading">
                            <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#testviewcollapse'.$i.'" class="collapsed">'.$testdetails[$i]['cate'].'</a>
                            </h4>
                            </div><div id="testviewcollapse'.$i.'" class="panel-collapse collapse" style="height: 0px;">
                            <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name of Test</th>
                                                        <th>Option</th>
                                                    </tr>
                                            </thead>
                                            <tbody>'; 
                                $k=1;
                                for($j=0;$j<sizeof ($testnames);$j++) 
                                {
                                    $testids[]=$grptestids[$j];
                                   $testdata .='<tr id="viewtests_'.$grptestids[$j].'"><td>'.$k++.'</td><td> '.$testnames[$j].'</td>
                                                <td>
                                                <button class="btn btn-danger  btn-md" name="'.$grptestids[$j].'" id="delete_apptt_'.$grptestids[$j].'" data-toggle="modal" data-target="#myModal_'.$grptestids[$j].'"><i class="fa fa-trash fa-fw fa-x2"></i> Delete</button>&nbsp;
                                                        <div class="modal fade" id="myModal_'.$grptestids[$j].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_'.$grptestids[$j].'" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content" style="color:#000;">
                                                        <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myModalLabel_'.$grptestids[$j].'">Delete Test entry</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                        Do You really want to delete the Test entry ?? press <strong>OK</strong> to delete
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deletetest_'.$grptestids[$j].'">Ok</button>
                                                        <button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_'.$grptestids[$j].'">Cancel</button>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div></td></tr>';
                                }
                                $testdata .='</tbody></table></div></div></div>';
            }
            $jsonmess=array(
              "reqids" => $testids,
              "reqdata" => $divheader.$testdata.$divfooter,  
            );
            return $jsonmess;
        }
        else
        {
            $jsonmess=array(
              "reqids" => $testids,
              "reqdata" => "No Requests"  
            );
            return $jsonmess;
        }
            
        }
    public function DeleteTest($testid) {
        $query='UPDATE `test_subtype` SET `status_id`=6 WHERE `id`='.  mysql_real_escape_string($testid);
        $result=  executeQuery($query);
        return $result;
    }    
    public function fetchTestTypes() {
        $testdetails=array();
        $testdata=array();
        $query='SELECT `test_cat_name` FROM `test_type` WHERE `status_id`=4';
        $result=  executeQuery($query);
        if(mysql_num_rows($result)>0)
        {
            while ($row = mysql_fetch_assoc($result)) {
                $testdetails[]=$row;
            }
            for($i=0;$i<sizeof($testdetails);$i++)
            {
                    $testdata []=$testdetails[$i]['test_cat_name'];
            }
            return $testdata;
        }
    }
    }
