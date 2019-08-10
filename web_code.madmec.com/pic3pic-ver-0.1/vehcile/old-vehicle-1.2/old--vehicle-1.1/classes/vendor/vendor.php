<?php
class doctor {
    protected $parameters = array();
                function __construct($parameters = false) {
                    $this->parameters = $parameters;
		}
                public function adddoctorinfo()
                {
                   $callparameters1='"'.mysql_real_escape_string($this->parameters["doctorname"]).'","'.
                                    mysql_real_escape_string($this->parameters["doctorid"]).'","' .
                                    mysql_real_escape_string($this->parameters["clinicname"]).'","'.
                                    mysql_real_escape_string($this->parameters["doctorcellnum"]).'","'.
                                    mysql_real_escape_string($this->parameters["doctoremail"]).'","'.
                                    mysql_real_escape_string($this->parameters["doctoraddress"]).'",'.
                                    $_SESSION["USER_LOGIN_DATA"]["USER_ID"]; 
                        $res=executeQuery("CALL updatedoctorinfo(".$callparameters1.")");
                        return $res;
                }
                public function checkdoctorinfo()
                {
                    $query="SELECT `username` AS details FROM `user_profie` WHERE (`doctor_id` IS NULL) AND id=".$_SESSION["USER_LOGIN_DATA"]["USER_ID"]." AND user_type_id=1";
                    $res=executeQuery($query);
                    $num=  mysql_num_rows($res);
                    return $num;
                }
                public function addpatientinfo() 
                {
                  $callparameters1='"'.mysql_real_escape_string($this->parameters["patientname"]).'","'.
                                    mysql_real_escape_string($this->parameters["patientage"]).'","' .
                                    mysql_real_escape_string($this->parameters["patientgender"]).'","'.
                                    mysql_real_escape_string($this->parameters["patientaddress"]).'","'.
                                    mysql_real_escape_string($this->parameters["patientcellnum"]).'","'.
                                    mysql_real_escape_string($this->parameters["patientemail"]).'","'.
                                    mysql_real_escape_string($this->parameters["patientgname"]).'","'.
                                    mysql_real_escape_string($this->parameters["patientgcellnum"]).'","'.
                                    mysql_real_escape_string($_SESSION['imagepath']).'","'.
                                    mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).'",'.
                                    mysql_real_escape_string($this->parameters["usertypeid"]);
                        $res=executeQuery("CALL insertPatientinfo(".$callparameters1.")");
                        return $res;  
                }
                 public function addpharmacyinfo() 
                {
                  $callparameters='"'.mysql_real_escape_string($this->parameters["usertypeid"]).'","'.
                                    mysql_real_escape_string($this->parameters["ppname"]).'","' .
                                    mysql_real_escape_string($this->parameters["pharmacyname"]).'","'.
                                    mysql_real_escape_string($this->parameters["pharaddress"]).'","'.
                                    mysql_real_escape_string($this->parameters["pphonenum"]).'","'.
                                    mysql_real_escape_string($this->parameters["pharemail"]).'","'.
                                    mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).'"';
                        $res=executeQuery("CALL insertpharmacyinfo(".$callparameters.")");
                        return $res;  
                }
                public function addpatientassesmentinfo() {
                  $_SESSION['downloadprespatientid']=mysql_real_escape_string($this->parameters['patientid']);
                    $lastid='';
//                    executeQuery("SET AUTOCOMMIT=0;");
//                    executeQuery("START TRANSACTION;");
                if(mysql_real_escape_string($this->parameters['bg']) != "")
                {
                $query='UPDATE `user_details` SET `bloodgroup`='.mysql_real_escape_string($this->parameters['bg']).' WHERE `user_pk`='.mysql_real_escape_string($this->parameters['patientid']);;    
                executeQuery($query);
                }
                if(mysql_real_escape_string($this->parameters['cpatientid'])=='0')
                {
                $query='INSERT INTO `passesment`(`id`,`patientid`,`doctorid`,`previoushistory`,`disease`,`status_id`)VALUES(null,'
                         . '"'.  mysql_real_escape_string($this->parameters['patientid']).'",'
                         . '"'.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).'",'
                        . '"'.  mysql_real_escape_string($this->parameters['phh']).'",'
                         . '"'.  mysql_real_escape_string($this->parameters['disease']).'",'
                         . '4)' ; 
                }
                else
                {
                $query='UPDATE `passesment` SET `disease`="'.mysql_real_escape_string($this->parameters['disease']).'" '
                         . ' WHERE `patientid`='.mysql_real_escape_string($this->parameters['patientid']).' AND `doctorid`='.mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]); 
                }
                 if(executeQuery($query))
                 {
                     $query='INSERT INTO `passesment_descb`(`id`,`patient_id`,`doctorid`,`currentassesment`,`date`,`remark`)VALUES(null,'
                         . '"'.  mysql_real_escape_string($this->parameters['patientid']).'",'
                             . '"'.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).'",'
                         . '"'.  mysql_real_escape_string($this->parameters['cass']).'",now(),'
                         . '"'.  mysql_real_escape_string($this->parameters['cassrem']).'"'
                         . ')' ; 
                 if(executeQuery($query))
                 {
                    $lastid=  mysql_insert_id(); 
                    if(is_array($this->parameters["habits"]) && sizeof($this->parameters["habits"]) > -1){
						$query = 'INSERT INTO  `patient_habit` (`id`,`patientid`,`passesment_id`,`habit`,`status_id` ) VALUES';
						for($i=0;$i<sizeof($this->parameters["habits"]);$i++){
							if($i == sizeof($this->parameters["habits"])-1)
								$query .= '(NULL,"'.mysql_real_escape_string ($this->parameters['patientid']).'",'
                                                                . '"'.  mysql_real_escape_string($lastid).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['habits'][$i]).'",4);';
							else
								$query .= '(NULL,"'.mysql_real_escape_string ($this->parameters['patientid']).'",'
                                                                . '"'.  mysql_real_escape_string($lastid).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['habits'][$i]).'",4),';
						}
                    }
                    executeQuery($query);
                    
                 }
                }
                  $flag=false;
                    if(is_array($this->parameters["tablets"]) && sizeof($this->parameters["tablets"]) > -1){
                    $query='INSERT INTO `prescription`(`id`,`passemt_descb_id`,`doctorid`,`patientid`,`status_id`) VALUES(null,'
                            . ''. mysql_real_escape_string($lastid).','
                            . ''. mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).','
                            . ''.  mysql_real_escape_string($this->parameters['patientid']).','
                            . '4)';
                    if(executeQuery($query))
                    {
                        $lastid1=  mysql_insert_id();
                        $_SESSION['downloadprespatientid']=$lastid1;
                        if(is_array($this->parameters["tablets"]) && sizeof($this->parameters["tablets"]) > -1){
						$query = 'INSERT INTO  `prescription_descb` (`id`,`presciption_id`,`tablet_name`,`morning`,`afternoon`,`evening`,`frequency`,`dosage` ) VALUES';
						for($i=0;$i<sizeof($this->parameters["tablets"]);$i++){
							if($i == sizeof($this->parameters["tablets"])-1)
								$query .= '(NULL,"'.mysql_real_escape_string ($lastid1).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['tablets'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['morning'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['afternoon'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['dinner'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['frequency'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['dosage'][$i]).'");';
							else
								$query .= '(NULL,"'.mysql_real_escape_string ($lastid1).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['tablets'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['morning'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['afternoon'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['dinner'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['frequency'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['dosage'][$i]).'"),';
						}
                           executeQuery($query);
                           }
                    }
                     }
                          if(mysql_real_escape_string($this->parameters['pharid']) != "")
                          {
                                $query='INSERT INTO `pharmacy`(`id`,`doctorid`,`pharmacyid`,`prescribtion_id`,`date-time`,`status_id`)VALUES(null,'
                                        . '"'.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).'",'
                                        . '"'.  mysql_real_escape_string($this->parameters['pharid']).'",'
                                        . '"'.  mysql_real_escape_string($lastid1).'",'
                                        . 'CURRENT_TIMESTAMP,4);';
                                 executeQuery($query);
                            }
                   
                    if($flag)
                    {
//                        executeQuery('COMMIT');
                    }
                    $down=new download();
                    $down->downloadPatientPrescription(mysql_real_escape_string($this->parameters['patientid']),$lastid1);
                }
                public function configureappointment() {
                    $lastid='';
                   if(is_array($this->parameters["days"]) && sizeof($this->parameters["days"]) > -1){
                                      $num= sizeof($this->parameters['days']);
                                        for($i=0;$i<$num;$i++)
                                        {
                                    $query='UPDATE `appointment` SET `status_id`=5 WHERE `doctorid`='.mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).' AND `weekofday`='.mysql_real_escape_string($this->parameters['days'][$i]);
                                    executeQuery($query);
                                    $query = 'INSERT INTO  `appointment` (`id`,`doctorid`,`weekofday`,`status_id` ) VALUES(null,'
                                            . ''.mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).','.mysql_real_escape_string($this->parameters['days'][$i]).',4);';
                                            executeQuery($query);
                                            $lastid=  mysql_insert_id();
                                            $query='';
//                                            $tempres=executeQuery("SELECT DAYOFWEEK(NOW()) as weekofday");
//                                            $rowdat=  mysql_fetch_assoc($tempres);
//                                            $nextdate=(mysql_real_escape_string($this->parameters['days'][$i])+7)-  executeQuery("SELECT DAYOFWEEK(NOW()) as ");
                                            $query1='INSERT INTO  `appointment_descb` (`id`,`appoint_id`,`fromtime`,`totime`,`location`,`frequency`,`date` ) VALUES';
                                                for($j=0;$j<sizeof($this->parameters["fromtime"]);$j++){
                                            if($j == sizeof($this->parameters["fromtime"])-1){
                                                   $tempres=executeQuery("SELECT DAYOFWEEK(NOW()) as weekofday");
                                                $rowdat=  mysql_fetch_assoc($tempres);
                                                if( $this->parameters['days'][$i] < $rowdat['weekofday']) {
                                                      $query1 .= '(NULL,"'.mysql_real_escape_string ($lastid).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['fromtime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['totime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['location'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['frequency'][$j]).'",(DATE_ADD(NOW(), INTERVAL ('.(mysql_real_escape_string($this->parameters['days'][$i])+7).' - DAYOFWEEK(NOW())) DAY)));';
                                                   }else{
                                                        $query1 .= '(NULL,"'.mysql_real_escape_string ($lastid).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['fromtime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['totime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['location'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['frequency'][$j]).'",(DATE_ADD(NOW(), INTERVAL ('.(mysql_real_escape_string($this->parameters['days'][$i])).' - DAYOFWEEK(NOW())) DAY)));';
                                                   }
                                                      
                                              }else{
                                                     $tempres=executeQuery("SELECT DAYOFWEEK(NOW()) as weekofday");
                                                $rowdat=  mysql_fetch_assoc($tempres);
                                                if( $this->parameters['days'][$i] < $rowdat['weekofday']) {
                                                    $query1 .= '(NULL,"'.mysql_real_escape_string ($lastid).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['fromtime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['totime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['location'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['frequency'][$j]).'",(DATE_ADD(NOW(), INTERVAL ('.(mysql_real_escape_string($this->parameters['days'][$i])+7).' - DAYOFWEEK(NOW())) DAY))),';
                                                   }else{
                                                       $query1 .= '(NULL,"'.mysql_real_escape_string ($lastid).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['fromtime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['totime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['location'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['frequency'][$j]).'",(DATE_ADD(NOW(), INTERVAL ('.(mysql_real_escape_string($this->parameters['days'][$i])).' - DAYOFWEEK(NOW())) DAY))),';
                                                   }
                                              }//else
                                                }          
                                                       
                                            executeQuery($query1);
//                                            $query1='';
                                        }   
                                         return $query1;
                    }
                }
                public function econfigureappointment() {
                  if(is_array($this->parameters["fromtime"]) && sizeof($this->parameters["fromtime"]) > -1){
                     $query1='INSERT INTO  `appointment_descb` (`id`,`appoint_id`,`fromtime`,`totime`,`location`,`frequency`,`date` ) VALUES';
                      for($j=0;$j<sizeof($this->parameters["fromtime"]);$j++){
                                            if($j == sizeof($this->parameters["fromtime"])-1){
                                                   $tempres=executeQuery("SELECT DAYOFWEEK(NOW()) as weekofday");
                                                $rowdat=  mysql_fetch_assoc($tempres);
                                                if( $this->parameters['days'] < $rowdat['weekofday']) {
                                                      $query1 .= '(NULL,"'.mysql_real_escape_string ($this->parameters['weekidd']).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['fromtime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['totime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['location'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['frequency'][$j]).'",(DATE_ADD(NOW(), INTERVAL ('.(mysql_real_escape_string($this->parameters['days'])+7).' - DAYOFWEEK(NOW())) DAY)));';
                                                   }else{
                                                        $query1 .= '(NULL,"'.mysql_real_escape_string ($this->parameters['weekidd']).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['fromtime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['totime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['location'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['frequency'][$j]).'",(DATE_ADD(NOW(), INTERVAL ('.(mysql_real_escape_string($this->parameters['days'])).' - DAYOFWEEK(NOW())) DAY)));';
                                                   }
                                                      
                                              }else{
                                                     $tempres=executeQuery("SELECT DAYOFWEEK(NOW()) as weekofday");
                                                $rowdat=  mysql_fetch_assoc($tempres);
                                                if( $this->parameters['days'] < $rowdat['weekofday']) {
                                                    $query1 .= '(NULL,"'.mysql_real_escape_string ($this->parameters['weekidd']).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['fromtime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['totime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['location'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['frequency'][$j]).'",(DATE_ADD(NOW(), INTERVAL ('.(mysql_real_escape_string($this->parameters['days'])+7).' - DAYOFWEEK(NOW())) DAY))),';
                                                   }else{
                                                       $query1 .= '(NULL,"'.mysql_real_escape_string ($this->parameters['weekidd']).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['fromtime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['totime'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['location'][$j]).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['frequency'][$j]).'",(DATE_ADD(NOW(), INTERVAL ('.(mysql_real_escape_string($this->parameters['days'])).' - DAYOFWEEK(NOW())) DAY))),';
                                                   }
                                              }//else
                                                }          
                                                       
                                            executeQuery($query1);
                     
                  }
                }
                public function editappointment() {
                    $query='UPDATE `appointment_descb` SET `fromtime`="'.  mysql_real_escape_string($this->parameters['fromtime']).'",'
                            . '`totime`="'.mysql_real_escape_string($this->parameters['totime']).'",'
                            . '`location`="'.mysql_real_escape_string($this->parameters['location']).'",'
                            . '`frequency`="'.mysql_real_escape_string($this->parameters['frequency']).'" WHERE `id`='.trim($this->parameters['appid']);
                    executeQuery($query);
                }
                public function deleteappointment($apptid) {
                $query='UPDATE `appointment_descb` SET `status_id`=5 WHERE `id`='.trim($apptid);
                    executeQuery($query);    
                    
                }
                public function addTesttoPatient() {
                    $query='INSERT INTO `diagnostic`(`id`,`doctorid`,`diagnostic_to_id`,`patient_id`,`date_time`,`status_id`)VALUES(NULL,'
                            . '"'.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).'",'
                            . '"'.  mysql_real_escape_string($this->parameters['diagid']).'",'
                            . '"'.  mysql_real_escape_string($this->parameters['pid']).'",'
                            . 'now(),4)';
                    if(executeQuery($query))
                    {
                        $lastid=  mysql_insert_id();
                        if(is_array($this->parameters["tests"]) && sizeof($this->parameters["tests"]) > -1){
                                      $num= sizeof($this->parameters['tests']);
                                      $query1='INSERT INTO  `diagnostic_descb` (`id`,`diagnostics_id`,`test_subtype_id` ) VALUES';
                                        for($j=0;$j<$num;$j++)
                                        {
                                            if($j == sizeof($this->parameters["tests"])-1)
                                                    $query1 .= '(NULL,"'.mysql_real_escape_string ($lastid).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['tests'][$j]).'");';
                                            else
                                                    $query1 .= '(NULL,"'.mysql_real_escape_string ($lastid).'",'
                                                    . '"'.  mysql_real_escape_string($this->parameters['tests'][$j]).'"),';
                                                }
                                        $result=executeQuery($query1);
                                        return $result;
                                        }
                        }
                    }
                public function fetchpatientdetails()
                {
                    $pdetails=array();
                    $pids=array();
                    $pdata=array();
                    $jsonmsg=array();
                    $query='SELECT u.`name`,u.`id`,u.`cell_number`,u.`email_id`,ud.`sex`
                            FROM `user_profie` u,`relations` r,`user_details` ud
                            WHERE r.`from_pk`='.$_SESSION["USER_LOGIN_DATA"]["USER_ID"].' AND r.`to_pk`=u.`id`
                            AND u.`id`=ud.`user_pk`
                            AND u.`user_type_id`=2;';
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $pdetails[]=$row;
                      }
                    }
                      if(is_array($pdetails))
                        $num = sizeof($pdetails);
                      if($num)
                      {
                          $j=1;
                          for($i=0;$i<$num;$i++)
                          {
                             $pdata[$i]='<tr><td>'.$j.'</td><td>P'.$pdetails[$i]["id"].'-'.$pdetails[$i]["name"].' -'
                                     .$pdetails[$i]["cell_number"].' -'.$pdetails[$i]["sex"].'</td>'
                                     . '<td><a id="view_history_'.$pdetails[$i]["id"].'" class="btn btn-success">View History</a></td></tr>'; 
                             ++$j;
                             $pids[$i]=$pdetails[$i]["id"];
                             }
                      }
                    $divheader='<div class="panel panel-danger">
                                <div class="panel-heading">
				Patient List
				</div>
				<div class="panel-body">';
                    $theader='<div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="dataTable-patientlist">
                                <thead><tr><th>#</th><th>Patient Details</th><th>Option</th></tr></thead><tbody>';
                    $tablefooter='</tbody></table></div>';
		    $divfooter='</div></div>';
                    $jsonmsg=array(
                       "divheader" => $divheader,
                       "divfooter" => $divfooter,
                       "pdata"  => $pdata,
                       "viewhistory" => '#view_history_',
                        "pids"  =>$pids,
                       "tableheader" => $theader,
                        "tablefooter" => $tablefooter
                    );
                    return $jsonmsg;
			
                }
                public function fetchTestCategory() {
                  $pdetails=array(); 
                  $pdata='';
                  $query='SELECT * FROM `test_type` WHERE `status_id`=4';  
                  $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $pdetails[]=$row;
                      }
                    }
                      if(is_array($pdetails))
                        $num = sizeof($pdetails);
                      if($num)
                      {
                          for($i=0;$i<$num;$i++)
                          {
                             $pdata .='<option value="'.$pdetails[$i]['id'].'">'.$pdetails[$i]['test_cat_name'].'</option>'; 
                             }
                             return $pdata;
                      } 
                }
                public function fetchSubTypeTest($catid) {
                   $testdetails=array();
                   $testdata='';
                   $query='SELECT * FROM `test_subtype` WHERE `status_id`=4 AND `test_id`='.  mysql_real_escape_string($catid); 
                   $result=  executeQuery($query);
                   $num=mysql_num_rows($result);
                   if($num>0)
                   {
                       while ($row = mysql_fetch_assoc($result)) {
                           $testdetails[]=$row;
                       }
                       for($i=0;$i<sizeof($testdetails);$i++)
                       {
                           $testdata .='<input type="checkbox" id="patienttestdiag'.$i.'" name="patienttestdiag" value="'.$testdetails[$i]['id'].'">   '.$testdetails[$i]['test_name'].'<br/>';
                       }
                       $jsonmess=array(
                          "testdata"=>$testdata,
                           "nooftests" =>$num,
                       );
                       return $jsonmess;
                   }
                }
                public function fetchdiagnosticsdetails()
                {
                $pdetails=array();
                    $pdata='';
                    $query='SELECT u.`name`,u.`id`,u.`clinicname`,u.`cell_number`,u.`email_id`,ud.`sex`
                            FROM `user_profie` u,`relations` r,`user_details` ud
                            WHERE r.`from_pk`='.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).' AND r.`to_pk`=u.id
                            AND u.`id`=ud.`user_pk` AND u.`status_id`=4
                            AND u.`user_type_id`=4;';
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $pdetails[]=$row;
                      }
                    }
                      if(is_array($pdetails))
                        $num = sizeof($pdetails);
                      if($num)
                      {
                          $j=1;
                          for($i=0;$i<$num;$i++)
                          {
                             $pdata .='<tr><td>'.$j.'</td><td>D'.$pdetails[$i]["id"].'-'.$pdetails[$i]["name"].'</td><td>'.$pdetails[$i]["clinicname"].'- Cell :'.$pdetails[$i]["cell_number"].'</td></tr>'; 
                             ++$j;
                             }
                      }
                    $divheader='<div class="panel panel-danger">
					<div class="panel-heading">
						Diagnostic Center List
					</div>
					<div class="panel-body">';
                    $theader='<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                                                    <thead>
							<tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Diagnostic Details</th>
                                                            
                                                        </tr>
                                                    </thead>
							<tbody>';
                    $tablefooter='</tbody>
                                    </table>
                                    </div>';
		    $divfooter='</div>
				</div>';
                    if($num)
                    {
                        return $divheader.$theader.$pdata.$tablefooter.$divfooter;
                    }
                    else
                    {
                        return $divheader."No Registered Diagnostic centers".$divfooter;
                    }    
                }
                public function fetchpatienthistory($pid) {
                $pdata=array();    
                $pdetails=array();  
                $period=array(
                    "0" => 'N/A',
                    "25" => 'Before',
                    "26" => 'After',
                    "27" => 'N/A'
                );
                
                $query='SELECT `previoushistory`,`disease` FROM `passesment` WHERE `patientid`='
                         . ''.mysql_real_escape_string($pid).' AND `doctorid`='.mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).' AND `status_id`=4';
                $res=  executeQuery($query);
                if(mysql_num_rows($res))
                {
                    $row1=  mysql_fetch_assoc($res);
                }
                $query1='SELECT padescb.`currentassesment`,padescb.`date` AS date,padescb.`remark` ,	
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
                        WHERE padescb.`patient_id`='
                         . ''.mysql_real_escape_string($pid).' AND padescb.`doctorid`='.mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).' GROUP BY presdescb.`presciption_id`
                        ORDER BY padescb.`date` DESC ';
                    $result=executeQuery($query1);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $pdetails[]=$row;
                      }
                    }
                    if(is_array($pdetails))
                    $num = sizeof($pdetails);
                    $theader='<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                                <tbody>';
                    $tablefooter='</tbody></table></div>';
                    if($num)
                    {
                    
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
                                        <a data-toggle="collapse" data-parent="#phistory" href="#phistoryy'.$i.'" class="collapsed">'.$pdetails[$i]['date'].'</a>
                                        </h4>
                                        </div><div id="phistoryy'.$i.'" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">'.$theader.'
                                        <tr><td>Date</td><td>'.$pdetails[$i]['date'].'</td></tr>
                                        <tr><td>Previous Health History</td><td>'.$row1['previoushistory'].'</td></tr>
                                        <tr><td>Disease</td><td>'.$row1['disease'].'</td></tr>
                                        <tr><td>Assessment</td><td>'.$pdetails[$i]['currentassesment'].'</td></tr>    
                                        <tr><td>Remark</td><td>'.$pdetails[$i]['remark'].'</td></tr> 
                                        <tr><td>Presciption</td><td>';
                                $k=1;
                                        if($tabletname[0] == '-')
                                        {
                                            
                                        }
                                        else
                                        {
                                       for($j=0;$j<sizeof($tabletname);$j++) 
                                       {
                                        if($morning[$j]=='0'|| $morning[$j]== '27' )
                                        {
                                           $mor='';
                                        }
                                        else {
                                          $mor=$_SESSION['status'][$morning[$j]].' Breakfast -' ; 
                                            }
                                        if($afternoon[$j]== '0' || $afternoon[$j]== '27' )
                                        {
                                           $aft='';
                                        }
                                        else {
                                          $aft=$_SESSION['status'][$afternoon[$j]].' Lunch -' ; 
                                            }   
                                        if($evening[$j]== '0' || $evening[$j]== '27' )
                                            {
                                           $eve='';
                                            }
                                       else {
                                          $eve=$_SESSION['status'][$evening[$j]].' Dinner ' ; 
                                            }
                                        $pdata[$i] .=$k++.' '. $tabletname[$j].' ( '.$mor.' '.$aft.' '.$eve.' )'.'<br/>'
                                                . '       '.$frequency[$j].' Days, Dosage - '.$dosage[$j].'<br/>'  ;             
                                                   }
                                        }
                                        $pdata[$i] .= '</td></tr>     
                                                    '.$tablefooter.'</div>
                                                </div></div>'; 
                             }
                    }
                 $jsonmess=array(
                  "divheader"=>'<div class="row"><div class="col-md-12"><div class="panel panel-default">
                                <div class="panel-heading">Patient History</div><div class="panel-body"><div class="panel-group" id="phistory">' ,  
                  "divfooter" => '</div></div></div></div></div>',
                  "pdata" =>$pdata  
                     );   
                     return $jsonmess;
                }
                public function fetchPharmacydetails()
                {
                 $pdetails=array();
                    $pdata='';
                    $query='SELECT u.name,u.clinicname,u.cell_number,u.email_id,ud.sex
                            FROM user_profie u,relations r,user_details ud
                            WHERE r.from_pk='.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).' AND r.to_pk=u.id
                            AND u.id=ud.user_pk AND u.status_id=4
                            AND u.user_type_id=3;';
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $pdetails[]=$row;
                      }
                    }
                      if(is_array($pdetails))
                        $num = sizeof($pdetails);
                      if($num)
                      {
                          $j=1;
                          for($i=0;$i<$num;$i++)
                          {
                             $pdata .='<tr><td>'.$j.'</td><td>'.$pdetails[$i]["name"].'</td><td>'.$pdetails[$i]["clinicname"].' Cell:'.$pdetails[$i]["cell_number"].'</td></tr>'; 
                             ++$j;
                             }
                      }
                    $divheader='<div class="panel panel-danger">
					<div class="panel-heading">
						Pharmacy List
					</div>
					<div class="panel-body">';
                    $theader='<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                                                    <thead>
							<tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Pharmacy Details</th>
                                                        </tr>
                                                    </thead>
							<tbody>';
                    $tablefooter='</tbody>
                                    </table>
                                    </div>';
		    $divfooter='</div>
				</div>';
                    if($num)
                    {
                        return $divheader.$theader.$pdata.$tablefooter.$divfooter;
                    }
                    else
                    {
                        return $divheader."No Registered Pharmacy centers".$divfooter;
                    }   
                }
                public function fetchconfiguredappointment() {
                    $appointdata=array();
                    $appdata=array();
                    $weekoftheday=array('','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
                    $data='';
                    $query='SELECT ap.`weekofday` FROM `appointment` ap
                            LEFT JOIN `appointment_descb` apd
                            ON ap.`id`=apd.`appoint_id`
                            WHERE ap.`doctorid`='.$_SESSION["USER_LOGIN_DATA"]["USER_ID"].' AND ap.`status_id`=4
                            AND apd.`status_id`=4
                            GROUP BY (apd.`appoint_id`)
                            ORDER BY ap.`weekofday`';
                    $result=  executeQuery($query);
                    $num=  mysql_num_rows($result);
                    $data ='<label>Days</label>
                                    <br/>';
                    if($num)
                    {
                       while($row=  mysql_fetch_assoc($result))
                       {
                          $appointdata[]=$row; 
                       }
                       $k=0;
                       for($j=0;$j<sizeof($appointdata);$j++)
                       {
                          $appdata[++$k] =$appointdata[$j]['weekofday'];
                       }
                       $datalength=sizeof($appointdata);
                       $flag=false;
                       
                       for($i=1;$i<=7;$i++)
                       {
                           for($j=1;$j<=$datalength;$j++)
                           {
                               if($appdata[$j]==$i)
                               {
                                   $flag=false;
                                   break; 
                               }
                               else
                               {
                                   $flag=true;
                               }
                           }
                        if($flag) 
                        {
                        $data .='<input type="checkbox" name="day'.$i.'" value="'.$i.'" >     '.$weekoftheday[$i].'<br />';  
                        }
                       }
                    }
                    else
                    {
                        for($i=1;$i<=7;$i++)
                        {
                          $data .='<input type="checkbox" name="day'.$i.'" value="'.$i.'" >     '.$weekoftheday[$i].'<br />';   
                        }
                    }
                    $data .='<p class="help-block"> Select all days which have same schedule slots and to configure it once</p>'
                               . '<div class="form-group">
                                    <label>Add Slots</label>
                                    <button  id="plus_slots_" type="button" class="text-primary btn btn-success  btn-md"><i class="fa fa-plus fa-fw "></i> </button>
                                    <div class="col-md-12" id="multiple_slots"> </div>  
                                    <p class="help-block" id="multiple_slotsmsg"></p>
                                </div>
                                 <div id="appointbutton">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                        <button type="button" id="appointsubmitBut" class="btn btn-danger">save</button>
                                        </div>
                                    </div>
                                 </div>';
                    $jsondata=array(
                        "data" => $data,
                        "num" =>$num,
                    );
                    return $jsondata;
                                            }
                public function sendPatientHistory() {
                    $pdetails=array();
                  $query="SELECT  
                      bg.bloodgroup as bgroup,
                        up.*,
                        passd.*,
                        ud.*
                FROM user_profie up
                LEFT JOIN user_details ud
                ON ud.user_pk=up.id
                LEFT JOIN bloodgroup bg
                ON bg.id=ud.bloodgroup 
                    LEFT JOIN 
                    (
                    SELECT 
		pass.`id` AS passesment_descb_id, 
		pass.`patient_id`,
		GROUP_CONCAT(pass.`doctorid`,',~~9743~~') AS passesment_descb_did,
		GROUP_CONCAT(pass.`currentassesment`,',~~9743~~') AS passesment_descb_curass,
		GROUP_CONCAT(pass.`date`,',~~9743~~') AS passesment_descb_date,
		GROUP_CONCAT(pass.`remark`,',~~9743~~') AS passesment_descb_rem,
		GROUP_CONCAT(pres.`ppid`,',~~9743~~') AS prescription_pid,
		GROUP_CONCAT(pres.`pppassemt_descb_id`,',~~9743~~') AS prescription_pdecid,
		GROUP_CONCAT(pres.`ppdoctorid`,',~~9743~~') AS prescription_did,
		GROUP_CONCAT(pres.`pppatientid`,',~~9743~~') AS prescription_spid,
		GROUP_CONCAT(pres.`ppstatus_id`,',~~9743~~') AS prescription_stid,
		GROUP_CONCAT(pres.`preid`,',~~9743~~') AS prescription_descb_id,
		GROUP_CONCAT(pres.`ppdesid`,',~~9743~~') AS prescription_ppdesid,
		GROUP_CONCAT(pres.`ppdes_tablet_name`,',~~9743~~')  AS prescription_descb_tnam,
		GROUP_CONCAT(pres.`ppdes_morning`,',~~9743~~')  AS prescription_descb_mrn,
		GROUP_CONCAT(pres.`ppdes_afternoon`,',~~9743~~')  AS prescription_descb_afn,
		GROUP_CONCAT(pres.`ppdes_evening`,',~~9743~~')  AS prescription_descb_evn,
		GROUP_CONCAT(pres.`ppdes_frequency`,',~~9743~~')  AS prescription_descb_frq,
		GROUP_CONCAT(pres.`ppdes_dosage`,',~~9743~~')  AS prescription_descb_dos
	FROM `passesment_descb` AS pass
	LEFT JOIN 
	(
		SELECT
			pp.`id` AS ppid,
			pp.`passemt_descb_id` AS pppassemt_descb_id,
			pp.`doctorid`  AS ppdoctorid,
			pp.`patientid`  AS pppatientid,
			pp.`status_id`  AS ppstatus_id,
			ppdes.`preid` AS preid,
			ppdes.`presciption_id`  AS ppdesid,
			ppdes.`tablet_name`  AS ppdes_tablet_name,
			ppdes.`morning`  AS ppdes_morning,
			ppdes.`afternoon`  AS ppdes_afternoon,
			ppdes.`evening`  AS ppdes_evening,
			ppdes.`frequency`  AS ppdes_frequency,
			ppdes.`dosage`  AS ppdes_dosage
		FROM prescription pp 
		LEFT JOIN (
			SELECT
				GROUP_CONCAT(`id`,'~~9916282628~~') AS preid,
				`presciption_id`,
				GROUP_CONCAT(`tablet_name`,'~~9916282628~~') AS tablet_name,
				GROUP_CONCAT(`morning`,'~~9916282628~~') AS morning,
				GROUP_CONCAT(`afternoon`,'~~9916282628~~') AS afternoon,
				GROUP_CONCAT(`evening`,'~~9916282628~~') AS evening,
				GROUP_CONCAT(`frequency`,'~~9916282628~~') AS frequency,
				GROUP_CONCAT(`dosage`,'~~9916282628~~') AS dosage
                                FROM prescription_descb
                                GROUP BY(presciption_id)
                                ORDER BY(presciption_id)
                        ) AS  ppdes ON  pp.`id` = ppdes.`presciption_id`
                        WHERE pp.`status_id` = 4 AND passemt_descb_id IS NOT NULL OR passemt_descb_id != NULL
                        ORDER BY (passemt_descb_id)
                ) AS pres ON pres.`pppassemt_descb_id` = pass.`id`
                GROUP BY (pass.`patient_id`)
                ORDER BY (pass.`patient_id`)
                    ) AS passd ON passd.patient_id=up.id
                    WHERE up.id = ".$this->parameters['patientid']."
                    GROUP BY (up.id)
                    ORDER BY (up.id)
             ";
                $result=  executeQuery($query);
                if(mysql_num_rows($result)>0)
                {
                   $row = mysql_fetch_assoc($result);
                       $pdetails=  $row; 
                    
                }
//                echo print_r($pdetails);
                    $down=new download();
                    $down->downloadPatientHistory($pdetails);
                    $to=  $this->parameters['email'];
                    $filename=$_SESSION['filename'];
                                $message="Hi Doctor, <br /> You are recieving this patient history FROM LMCare App  <br />  <br />  <br />  
                                         <br />  Thanks & Regards <br />  LMCare";
                                $subject="Patient History Report";
				$flag = false;
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
						$mail->setFrom(MAILUSER, "Loginics Pvt Ltd.");
						$mail->addTo($to,"Dear User");
						$mail->setSubject($subject);
						$flag = true;
					}
				}
				if($flag){
					if(file_exists($_SESSION['path'])){
						$content = file_get_contents($_SESSION['path']);
						$attachment = new Zend_Mime_Part($content);
						$attachment->type = 'application/pdf';
						$attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
						$attachment->encoding = Zend_Mime::ENCODING_BASE64;
						$attachment->filename = $_SESSION['filename'].$_SESSION['ext'];
						$mail->addAttachment($attachment); 
					}
					try{

						$mail->send($transport);
						unset($mail);
						unset($transport);
						$flag = true;
					}
						catch(exceptoin $e){
						// echo 'Invalid email id :- '.$to.'<br />';
						$flag = false;
					}
				}
				//return $flag;
                }
                public function fetchPharmacyFullDetailsdetails($pharid) {
                    $query='SELECT up.`clinicname`,up.`cell_number` ,ud.`address`
                            FROM `user_profie` up
                            LEFT JOIN `user_details` ud
                            ON up.`id`=ud.`user_pk`
                            WHERE up.`id`='.  mysql_real_escape_string($pharid);
                    $result=  executeQuery($query);
                    $row=  mysql_fetch_assoc($result);
                    $phardata='Pharmacy Name : '.$row['clinicname'].'<br/> Address : '.$row['address'].'<br/> Mobile Number : '.$row['cell_number'];
                    return $phardata;
                }
                public function fetchAppointeeDetails() {
                    $appointdetails=array();
                    $appointdata='';
                    $query='SELECT bh.`date`,up.id,up.name,up.cell_number
                            FROM `bookinghistory` bh
                            LEFT JOIN user_profie up
                            ON up.id=bh.patientid
                            WHERE bh.`apptdescb_id`="'.mysql_real_escape_string($this->parameters['appid']).'" AND bh.`date`="'.mysql_real_escape_string($this->parameters['date']).'"';  
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0)
                    {
                        while ($row = mysql_fetch_assoc($result)) {
                        $appointdetails[]=$row;    
                        }   
                        $j=1;
                        for($i=0;$i<sizeof($appointdetails);$i++)
                        {
                           $appointdata .= $j++.'.   P'.$appointdetails[$i]['id'].' - '.$appointdetails[$i]['name'].' - '.$appointdetails[$i]['cell_number'].'<br/>'; 
                        }
                    }
                    $theader1='<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><tbody>';
                    $tablefooter='</tbody></table></div>';
                    return $appointdata;
                }
                public function fetchusertypes()
                {
                    $udata='';
                    $userdetails=array();
                   $query='SELECT * FROM `user_type` WHERE `status_id`=4 AND `id` NOT IN(1,5)';
                   $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $userdetails[]=$row;
                      }
                    }
                      if(is_array($userdetails))
                        $num = sizeof($userdetails);
                      if($num)
                      {
                          for($i=0;$i<$num;$i++)
                          {
                             $udata .='<option value="'.$userdetails[$i]["id"].'">'.$userdetails[$i]["type"].'</option>';
                          }
                      }
                     $selectheader='<select class="form-control" id="user_type_id" name="user_type_id"><option value="">Please select usertype</option>' ;
                     $selectfooter='</select>';
                     return $selectheader.$udata.$selectfooter;
                   
                }
                public function fetchmessagetypes() {
                    $jsondata=array();
                    $messagedata=array();
                    $typenum=array();
                    $data='';
                    if($_SESSION['userdata']['user_type'] == 1)
                    {
                       $notin="(5)"; 
                    }
                    else
                    {
                      $notin="(1,2,3,4)";  
                    }
                    $query="SELECT * FROM `message_type` WHERE `status_id`=4  AND `id` NOT IN".$notin.';';
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result))
                    {
                        while($row=  mysql_fetch_assoc($result))
                        {
                           $messagedata[]=$row; 
                        }
                        for($i=0;$i<sizeof($messagedata);$i++)
                        {
                            $data .= '<li><a href="javascript:void(0);" id="messagetype'.$i.'">'.$messagedata[$i]['message_type'].'</a></li>';
                            $typenum[]=$messagedata[$i]['id'];
                        }
                        $jsondata=array(
                                "data"  =>$data,
                                "num" =>sizeof($messagedata),
                            "typenum" => $typenum,
                                );
                        return $jsondata;
                    }
                    else
                    {
                        return $data;
                    }
                }
                public function fetchmessagetypeschatdel($typeid) {
                 $chatusers=array();
                 $chatdata=array();
                 $messageid=array();
                 $messagefrom=array();
                 $names=array();
                 $mobile=array();
                 $email=array();
                 $photopath=array();
                 $messagetime=array();
                 if($_SESSION['userdata']['user_type']==1)
                 $query="SELECT mes.`id` AS messageid,
                        up.`name` AS namee,
                        up.`cell_number` AS mobile,
                        up.`email_id` AS email,
                        CASE WHEN (up.`photo` IS NULL  OR up.`photo`='') THEN '".USERLOGO."'
                        ELSE up.`photo`
                        END AS photopath,
                        GROUP_CONCAT(med.`message`) AS messages,
                        GROUP_CONCAT(med.`mess_from`) AS frommess,
                        GROUP_CONCAT(med.`msgtime`) AS messtime
                        FROM `message` mes
                        LEFT JOIN 
                        `message_details` med
                        ON mes.`id`=med.`mess_id`
                        LEFT JOIN `user_profie` up
                        ON (CASE WHEN mes.`from_message` = '".$_SESSION["USER_LOGIN_DATA"]["USER_ID"]."' THEN up.`id`=mes.`to_message`
                        ELSE
                        up.`id`=mes.`from_message` END)
                        LEFT JOIN `photo` p
                        ON p.`user_pk`=up.`id`
                        WHERE mes.`status_id`=4 AND med.`status_id`=4 AND
                        (mes.`message_type`=".  mysql_real_escape_string($typeid)."   OR mes.`to_message_type`=".  mysql_real_escape_string($typeid)." )
                        AND (mes.from_message='".$_SESSION["USER_LOGIN_DATA"]["USER_ID"]."' OR mes.to_message='".$_SESSION["USER_LOGIN_DATA"]["USER_ID"]."')
                        GROUP BY(med.`mess_id`)
                        ORDER BY (up.name) ;";  
                else
                  $query="SELECT mes.`id` AS messageid,
                        up.`name` AS namee,
                        up.`cell_number` AS mobile,
                        up.`email_id` AS email,
                        CASE WHEN (up.`photo` IS NULL  OR up.`photo`='') THEN '".USERLOGO."'
                        ELSE up.`photo`
                        END AS photopath,
                        GROUP_CONCAT(med.`message`) AS messages,
                        GROUP_CONCAT(med.`mess_from`) AS frommess,
                        GROUP_CONCAT(med.`msgtime`) AS messtime
                        FROM `message` mes
                        LEFT JOIN 
                        `message_details` med
                        ON mes.`id`=med.`mess_id`
                        LEFT JOIN `user_profie` up
                        ON (CASE WHEN mes.`from_message` = '".$_SESSION["USER_LOGIN_DATA"]["USER_ID"]."' THEN up.`id`=mes.`to_message`
                        ELSE
                        up.`id`=mes.`from_message` END)
                        LEFT JOIN `photo` p
                        ON p.`user_pk`=up.`id`
                        WHERE mes.`status_id`=4 AND med.`to_status_id`=4 AND
                        (mes.`message_type`=".  mysql_real_escape_string($typeid)."   OR mes.`to_message_type`=".  mysql_real_escape_string($typeid)." )
                        AND (mes.from_message='".$_SESSION["USER_LOGIN_DATA"]["USER_ID"]."' OR mes.to_message='".$_SESSION["USER_LOGIN_DATA"]["USER_ID"]."')
                        GROUP BY(med.`mess_id`)
                        ORDER BY (up.name) ;";    
//                 echo $query;
                        $result=  executeQuery($query);
                        if(mysql_num_rows($result))
                        {
                            while ($row = mysql_fetch_assoc($result)) {
                                $chatusers[]=$row;
                            }
                            for($i=0;$i<sizeof($chatusers);$i++)
                            {
                               $chatdata[$i]=$chatusers[$i]['messages']; 
                               $messageid[$i]=$chatusers[$i]['messageid'];
                               $messagefrom[$i]=$chatusers[$i]['frommess'];
                               $names[$i]=$chatusers[$i]['namee'];
                               $mobile[$i]=$chatusers[$i]['mobile'];
                               $email[$i]=$chatusers[$i]['email'];
                               $photopath[$i]=$chatusers[$i]['photopath'];
                               $messagetime[$i]=$chatusers[$i]['messtime'];
                            }
                            $jsondata=array(
                                "messages" =>$chatdata,
                                "messageids" => $messageid,
                                "messagefrom"  => $messagefrom,
                                "name" =>$names,
                                "mobile" => $mobile,
                                "email" => $email,
                                "photopath" => $photopath,
                                "userid" => $_SESSION["USER_LOGIN_DATA"]["USER_ID"],
                                "userphoto" => $_SESSION['userdata']['photo'],
                                "msgtime" => $messagetime,
                            );
                            return $jsondata;
                        }
                        else
                        {
                            $jsondata=array(
                                "messages" =>"",
                                "messageids" => "",
                                "messagefrom"  => "",
                                "name" =>"",
                                "mobile" => "",
                                "email" => "",
                                "photopath" => "",
                                "userid" => "",
                                "msgtime" => "",
                            );
                            return $jsondata;
                        }
                }
                public function refreshchatHistory($messid) {
                 $chatdata=array();
                 $frommessage=array();
                 $messages=array();
                 $messtine=array();
                 $jsondata=array();
                 if($_SESSION['userdata']['user_type']==1) 
                 $query='SELECT 
                            GROUP_CONCAT(`mess_from`) AS frommess,
                            GROUP_CONCAT(`message`) AS messages,
                            GROUP_CONCAT(`msgtime`) AS messtime
                            FROM `message_details` 
                            WHERE  `status_id`=4  AND mess_id='.$messid.'
                            GROUP BY(`mess_id`)
                            ORDER BY (msgtime) DESC';   
                 else
                  $query='SELECT 
                            GROUP_CONCAT(`mess_from`) AS frommess,
                            GROUP_CONCAT(`message`) AS messages,
                            GROUP_CONCAT(`msgtime`) AS messtime
                            FROM `message_details` 
                            WHERE  `to_status_id`=4  AND mess_id='.$messid.'
                            GROUP BY(`mess_id`)
                            ORDER BY (msgtime) DESC';    
                $result=  executeQuery($query);
                if(mysql_num_rows($result))
                {
                    while ($row = mysql_fetch_assoc($result)) {
                        $chatdata[]=$row;
                    } 
                    for($i=0;$i<sizeof($chatdata);$i++)
                    {
                        $frommessage[$i]=$chatdata[$i]['frommess'];
                        $messages[$i]=$chatdata[$i]['messages'];
                        $messtine[$i]=$chatdata[$i]['messtime'];
                    }
                    $jsondata=array(
                        "frommess" => $frommessage,
                        "messages" => $messages,
                        "messtime"  => $messtine,
                         "userid" =>  $_SESSION["USER_LOGIN_DATA"]["USER_ID"]  ,
                        "userphoto" => $_SESSION['userdata']['photo'],
                    ); 
                    return $jsondata;
                }
                else
                {
                    $jsondata=array(
                        "frommess" => "",
                        "messages" => "",
                        "messtime"  => "",
                         "userid" => ""  
                    ); 
                    return $jsondata;
                }
                }
                public function clearChatHistory($messid) {
                if($_SESSION['userdata']['user_type']==1)    
                 $query='UPDATE `message_details` SET `status_id`=5 WHERE `mess_id`='.trim($messid);
                else
                  $query='UPDATE `message_details` SET `to_status_id`=5 WHERE `mess_id`='.trim($messid);  
                 $result=  executeQuery($query);
                 return $result;
                }
                public function sendChatMessage($messid,$message) {
                  $query='INSERT INTO `message_details`(`id`,`mess_id`,`message`,`mess_from`,`msgtime`,`status_id`)'
                          . 'VALUES(null,"'.  mysql_real_escape_string($messid).'",'
                          . '"'.mysql_real_escape_string($message).'","'.$_SESSION["USER_LOGIN_DATA"]["USER_ID"].'",CURRENT_TIMESTAMP,4)';  
                  $result=  executeQuery($query);
                  return $result;
                }
                public function fetchAllUserUndertype($typeid) {
                if($typeid == 1)        
                $userid= 2 ;
                else if($typeid == 2)
                 $userid= 3 ;
                else if($typeid == 3)
                 $userid= 4 ; 
                else if($typeid == 5)
                 $userid= 1 ;
                else
                $userid=2;
                $userdata=array();
                $names=array();
                $toids=array();
                $mobles=array();
                $photos=array();
                $clinicname=array();
                if($_SESSION['userdata']['user_type'] == 1)
                {
                $query='SELECT r.`to_pk`,up.`name`,up.`clinicname`,up.`cell_number`,up.`photo`
                        FROM `relations` r
                        LEFT JOIN `user_profie` up
                        ON up.`id`=r.`to_pk`
                        WHERE r.`from_pk`='.$_SESSION["USER_LOGIN_DATA"]["USER_ID"].' AND r.`to_pk`=up.`id` AND up.`status_id`=4 AND up.`user_type_id`='.$userid;
                }
                else
                {
                 $query='SELECT r.`from_pk` as to_pk,up.`name`,up.`clinicname`,up.`cell_number`,up.`photo`
                        FROM `relations` r
                        LEFT JOIN `user_profie` up
                        ON up.`id`=r.`from_pk`
                        WHERE r.`to_pk`='.$_SESSION["USER_LOGIN_DATA"]["USER_ID"].' AND  r.`from_pk`=up.`id` AND up.`status_id`=4 AND up.`user_type_id`='.$userid;
                }
                $result=  executeQuery($query);
                if(mysql_num_rows($result))
                {
                     while ($row = mysql_fetch_assoc($result)) {
                     $userdata[]=$row;   
                    } 
                    for($i=0;$i<sizeof($userdata);$i++)
                    {
                        $names[$i]=$userdata[$i]['name'];
                        $toids[$i]=$userdata[$i]['to_pk'];
                        $mobles[$i]=$userdata[$i]['cell_number'];
                        $photos[$i]=$userdata[$i]['photo'];
                        $clinicname[$i]=$userdata[$i]['clinicname'];
                    }
                    $jsondata=array(
                        "names" => $names,
                        "toids" => $toids,
                        "mobiles" => $mobles,
                        "photos"  => $photos,
                        "clinicnames" =>$clinicname,
                    );
                    return $jsondata;
                }
                else
                {
                  $jsondata=array(
                        "names" => "",
                        "toids" => "",
                        "mobiles" => "",
                        "photos"  => "",
                      "clinicnames" =>"",
                    );  
                  return $jsondata;
                }
                }
                public function checkForChatHistory($topk,$typeid) {
                    $messid=0;
                  $query="SELECT mes.`id`,up.name,up.photo
                        FROM message mes
                        LEFT JOIN `user_profie` up
                        ON (CASE WHEN mes.`from_message` = '".$_SESSION["USER_LOGIN_DATA"]["USER_ID"]."' THEN up.`id`=mes.`to_message`
                        ELSE
                        up.`id`=mes.`from_message` END)
                        LEFT JOIN `photo` p
                        ON p.`user_pk`=up.`id`
                        WHERE (`from_message`=".  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"])." AND `to_message`=".  mysql_real_escape_string($topk).") 
                        OR (`from_message`=".  mysql_real_escape_string($topk)." AND `to_message`=".  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).") ;";
                  $result= executeQuery($query);
                  if(mysql_num_rows($result))
                  {
                      $row=  mysql_fetch_assoc($result);
                      $messid=$row['id'];
                      $jsondata=array(
                          "messid" =>$messid,
                          "name" => $row['name'],
                          "photopath" => $row['photo'],
                      );
                      return $jsondata;
                  }
                  else
                  {
                      $jsondata=array(
                          "messid" =>$messid,
                      );
                    return $jsondata;  
                  }
                }
                public function startNewChart($topk,$typeid,$message) {
                if($_SESSION['userdata']['user_type']==1)
                    $totypeid = 5;
                else if($_SESSION['userdata']['user_type']==2)
                    $totypeid = 1;
                else if($_SESSION['userdata']['user_type']==3)
                    $totypeid = 2;
                else if($_SESSION['userdata']['user_type']==4)
                    $totypeid = 3;
                else
                    $totypeid = 4;
                 $lastid=0;
                 $query='INSERT INTO `message`(`id`,`from_message`,`to_message`,`message_type`,`to_message_type`,`status_id`)VALUES('
                         . 'null,'
                         . '"'.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).'",'
                         . '"'.  mysql_real_escape_string($topk).'",'
                         . '"'.  mysql_real_escape_string($typeid).'",'
                         . '"'.  mysql_real_escape_string($totypeid).'",'
                         . '4);'  ;
                if( executeQuery($query))
                {
                 $lastid=  mysql_insert_id();
                 $query='INSERT INTO `message_details`(`id`,`mess_id`,`message`,`mess_from`,`msgtime`,`status_id`)VALUES('
                         . 'null,'
                         . '"'.  mysql_real_escape_string($lastid).'",'
                         . '"'.  mysql_real_escape_string($message).'",'
                         . '"'.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).'",CURRENT_TIMESTAMP,'
                         . '4);'  ;
                 executeQuery($query);
                 return $lastid;
                }
                else
                {
                    $lastid=0;
                }
                }
                public function fetchappointmentdetails() {
                $weekofdayid=array();    
                $weekofdays=array();    
                $pdetails=array();
                $pdata=array();
                $pdata1=array();
                $appids=array();
                $appfromtime=array();
                $apptotime=array();
                $applocation=array();
                $appfrequency=array();
                $dates=array();
                $weekoftheday=array('','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
                $query='SELECT ap.`id`,ap.`weekofday`,
                        GROUP_CONCAT(apd.`fromtime`) AS fromtime,
                        GROUP_CONCAT(apd.`totime`) AS totime,
                        GROUP_CONCAT(apd.`location`) AS location,
                        GROUP_CONCAT(apd.`frequency`) AS frequency,
                        GROUP_CONCAT(apd.`filled`) AS filled,
                        GROUP_CONCAT(apd.`date`) AS date,
                        GROUP_CONCAT(apd.`id`) AS apptid
                        FROM `appointment` ap
                        LEFT JOIN 
                       `appointment_descb` apd
                        ON ap.`id`=apd.`appoint_id`
                        WHERE ap.`status_id`=4 AND apd.`status_id`=4 AND ap.`doctorid`='.$_SESSION["USER_LOGIN_DATA"]["USER_ID"].'
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
                    $theader='<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                                <tbody><tr><th>#</th><th>Slot Details</th><th>Details</th></tr>';
                    $theader1='<div class="table-responsive"><table class="table table-striped table-bordered table-hover">
                                <tbody><tr><th>#</th><th>Slot Details</th><th>Option</th></tr>';
                    
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
                                $j=1;
                                $p=1;
                                $pdata[$i] ='<div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#viewappoint" href="#viewappointt'.$i.'" class="collapsed">'.$weekoftheday[$pdetails[$i]['weekofday']].'</a>
                                        </h4>
                                        </div><div id="viewappointt'.$i.'" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">'.$theader.'';
                                         $weekofdays[]=$pdetails[$i]['weekofday'];
                                         $weekofdayid[]=$pdetails[$i]['id'];
                                         $fromtimee= explode(',', $pdetails[$i]['fromtime']);  
                                         $totimee=  explode(',', $pdetails[$i]['totime']);  
                                         $location=  explode(',', $pdetails[$i]['location']);  
                                         $frequency=  explode(',', $pdetails[$i]['frequency']);  
                                         $filled=  explode(',', $pdetails[$i]['filled']); 
                                         $grpappid=  explode(',', $pdetails[$i]['apptid']); 
                                         $grpdates=  explode(',', $pdetails[$i]['date']); 
                                         for($k=0;$k<sizeof($fromtimee);$k++)
                                         {
//                                             <br/> Location : '.$location[$k].' 
                                $pdata[$i] .='<tr><td>'.$j++.'
                                        </td><td> Time : '.$fromtimee[$k].'
                                         - '.$totimee[$k].'  
                                        <br/> no of slots : '.$frequency[$k].'<br/> Filled : '.$filled[$k].'</td>'
                                        . '<td><button type="button" class="btn btn-success  btn-md" id="viewappointee_'.$grpappid[$k].'"><i class="fa fa-file fa-fw "></i>View</button></td></tr><tr><td colspan="3"><div id="viewappointeedis_'.$grpappid[$k].'"></div></td></tr>';
                                        $appids[]=$grpappid[$k];
                                        $dates[]=$grpdates[$k];
                                        $appfromtime[]=$fromtimee[$k];
                                        $apptotime[]=$totimee[$k];
                                        $applocation[]=$location[$k];
                                        $appfrequency[]=$frequency[$k];
                                         }
                                $pdata[$i] .=$tablefooter.'</div>
                                        </div></div>'; 
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
                                         for($k=0;$k<sizeof($fromtimee);$k++)
                                         {
//                                             Location : '.$location[$k].'<br/>
                                $pdata1[$i] .='<tr id="row_id'.$grpappid[$k].'"><td>'.$p++.'</td>
                                        <td> Time : '.$fromtimee[$k].' - 
                                        '.$totimee[$k].'<br/>    
                                         no of slots : '.$frequency[$k].'</td>'
                                        . '<td><button type="button" class="btn btn-warning  btn-md" id="edit_app'.$grpappid[$k].'"><i class="fa fa-edit fa-fw "></i>Edit</button><br/><br/>'
                                        . '<button class="btn btn-danger  btn-md" name="'.$grpappid[$k].'" id="delete_apptt_'.$grpappid[$k].'" data-toggle="modal" data-target="#myModal_'.$grpappid[$k].'"><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp;
								<div class="modal fade" id="myModal_'.$grpappid[$k].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_'.$grpappid[$k].'" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModalLabel_'.$grpappid[$k].'">Delete Appointment entry</h4>
								</div>
								<div class="modal-body">
								Do You really want to delete the Appointment entry ?? press <strong>OK</strong> to delete
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteOk_'.$grpappid[$k].'">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_'.$grpappid[$k].'">Cancel</button>
								</div>
								</div>
								</div>
								</div></td></tr><tr>
                                                                <td colspan="7"><div id="edit_details_'.$grpappid[$k].'"></div></td></tr>';
                                         }
                                $pdata1[$i] .='<tr><td colspan="3"><button  id="eplus_slots_'.$pdetails[$i]['weekofday'].'" type="button" class="text-primary btn btn-success  btn-md"><i class="fa fa-plus fa-fw "></i> </button>
                                                                <div class="col-md-12" id="emultiple_slots'.$pdetails[$i]['weekofday'].'"> <br/>
                                                                   </div>  
                                                                <p class="help-block" id="emultiple_slotsmsg"></p></td></tr><tr><td colspan="3"><button type="button" class="btn btn-danger" id="eaddappointSubmit'.$pdetails[$i]['weekofday'].'">&nbsp;Save</button><br/><p class="help-block" id="eappointconfgmsg"></p></td></tr>'.$tablefooter.'</div>
                                        </div></div>';
                             }
                    }
                 $jsonmess=array(
                  "divheader"=>'<div id="viewappoint">' ,  
                  "divheader1"=>'<div id="viewappoint">' ,  
                  "divfooter" => '</div></div></div></div></div>',
//                  "divheader"=>'<div class="row"><div class="col-md-12"><div class="panel panel-success">
//                                <div class="panel-heading">View Appointments</div><div class="panel-body"><div class="panel-group" id="viewappoint">' ,  
//                  "divheader1"=>'<div class="row"><div class="col-md-12"><div class="panel panel-info">
//                                <div class="panel-heading">Edit Appointments</div><div class="panel-body"><div class="panel-group" id="viewappoint">' ,  
//                  "divfooter" => '</div></div></div></div></div>',
                  "pdata"       =>$pdata , 
                  "pdata1"      => $pdata1 ,
                  "appids"      => $appids,
                  "fromtime"    => $appfromtime,
                  "totime"      => $apptotime,
                  "location"    => $applocation,
                   "frequency"  => $appfrequency ,
                   "dates"     => $dates,  
                   "weekofdays" =>$weekofdays, 
                    "weekofdayid" =>$weekofdayid, 
                     );   
                     return $jsonmess;     
                    
                }
                public function fetchpatientpharmacy() {
                  $pdetails=array();
                    $pdata='';
                    $query='SELECT u.`name`,u.`id`
                            FROM `user_profie` u,`relations` r,`user_details` ud
                            WHERE r.`from_pk`='.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).' AND r.`to_pk`=u.id
                            AND u.`id`=ud.`user_pk` AND u.`status_id`=4
                            AND u.`user_type_id`=3;';
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $pdetails[]=$row;
                      }
                    }
                      if(is_array($pdetails))
                        $num = sizeof($pdetails);
                      if($num)
                      {
                          for($i=0;$i<$num;$i++)
                          {
                             $pdata .='<option value="'.$pdetails[$i]['id'].'">Med'.$pdetails[$i]['id'].'-'.$pdetails[$i]['name'].'</option>'; 
                             }
                      }  
                    $petdetails=array();
                    $petdata='';
                    $query1='SELECT u.`name`,u.`id`
                            FROM `user_profie` u,`relations` r,`user_details` ud
                            WHERE r.`from_pk`='.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).' AND r.`to_pk`=u.id
                            AND u.`id`=ud.`user_pk` AND u.`status_id`=4
                            AND u.`user_type_id`=2;';
                    $result1=  executeQuery($query1);
                    if(mysql_num_rows($result1)>0){
                      while ($row=  mysql_fetch_assoc($result1))
                     {
                      $petdetails[]=$row;
                      }
                    }
                      if(is_array($petdetails))
                        $num1 = sizeof($petdetails);
                      if($num1)
                      {
                          for($i=0;$i<$num1;$i++)
                          {
                             $petdata .='<option value="'.$petdetails[$i]['id'].'">P'.$petdetails[$i]['id'].'-'.$petdetails[$i]['name'].'</option>'; 
                             }
                      }
                      $jsonmess=array(
                        "patientdetails"  => $petdata,
                        "pharmacydetails" => $pdata
                      );
                      return $jsonmess;
                } 
                public function fetchpassesmentpatient() {
                    $pdetails=array();
                    $pdata='';
                    $query='SELECT u.`name`,u.`id`,u.`clinicname`
                            FROM `user_profie` u,`relations` r,`user_details` ud
                            WHERE r.`from_pk`='.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).' AND r.`to_pk`=u.id
                            AND u.`id`=ud.`user_pk` AND u.`status_id`=4
                            AND u.`user_type_id`=4;';
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $pdetails[]=$row;
                      }
                    }
                      if(is_array($pdetails))
                        $num = sizeof($pdetails);
                      if($num)
                      {
                          for($i=0;$i<$num;$i++)
                          {
                             $pdata .='<option value="'.$pdetails[$i]['id'].'">Diagnotic '.$pdetails[$i]['id'].'-'.$pdetails[$i]['clinicname'].'</option>'; 
                             }
                      } 
                  $petdetails=array();
                    $petdata='';
                    $pids=array();
                    $query1='SELECT u.`name`,u.`id`
                            FROM `user_profie` u,`relations` r,`user_details` ud
                            WHERE r.`from_pk`='.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).' AND r.`to_pk`=u.id
                            AND u.`id`=ud.`user_pk`
                            AND u.`user_type_id`=2;';
                    $result1=  executeQuery($query1);
                    if(mysql_num_rows($result1)>0){
                      while ($row=  mysql_fetch_assoc($result1))
                     {
                      $petdetails[]=$row;
                      }
                    }
                      if(is_array($petdetails))
                        $num1 = sizeof($petdetails);
                      if($num1)
                      {
                          for($i=0;$i<$num1;$i++)
                          {
                            $petdata .='<option value="'.$petdetails[$i]['id'].'">P'.$petdetails[$i]['id'].'-'.$petdetails[$i]['name'].'</option>'; 
                            $pids[$i]=$petdetails[$i]['id'];
                          }
                      }
                      $jsonmess=array(
                          "pdetails" => $petdata,
                          "pids"    =>$pids,
                          "diagnostic" => $pdata,
                      );
                     return $jsonmess;  
                }
                public function fetchbloodgroup() {
                 $petdetails=array();
                    $petdata='';
                    $query1='SELECT * from `bloodgroup` WHERE `status_id`=4';
                    $result1=  executeQuery($query1);
                    if(mysql_num_rows($result1)>0){
                      while ($row=  mysql_fetch_assoc($result1))
                     {
                      $petdetails[]=$row;
                      }
                    }
                      if(is_array($petdetails))
                        $num1 = sizeof($petdetails);
                      if($num1)
                      {
                          for($i=0;$i<$num1;$i++)
                          {
                             $petdata .='<option value="'.$petdetails[$i]['id'].'">'.$petdetails[$i]['bloodgroup'].'</option>'; 
                             }
                      }
                    $habits=array();
                    $habitdata='';
                    $query='SELECT * from `habits` WHERE `status_id`=4';
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $habits[]=$row;
                      }
                    }
                      if(is_array($habits))
                        $num1 = sizeof($habits);
                      if($num1)
                      {
                          for($i=0;$i<$num1;$i++)
                          {
                             $habitdata .='<div class="col-md-4"><input type="checkbox"  value="'.$habits[$i]['id'].'" id="habbitsdelt'.$i.'" name="habbitsdelt'.$i.'">   '.$habits[$i]['habits'].'</div>'; 
                             }
                      }
                    $jsondel=array(
                        "bloogroups" => $petdata,
                        "habits"   => $habitdata,
                        "noofhabits" => $num1
                    ); 
                      return $jsondel;     
                }
                public function addprescibtioninfo() {
                    $flag=false;
                    executeQuery("SET AUTOCOMMIT=0;");
                    executeQuery("START TRANSACTION;");
                    $query='INSERT INTO `prescription`(`id`,`passemt_descb_id`,`doctorid`,`patientid`,`status_id`) VALUES(null,'
                            . ''. mysql_real_escape_string($passment_descb_id).','
                            . ''. mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).','
                            . ''.  mysql_real_escape_string($this->parameters['patientid']).','
                            . '4)';
                    if(executeQuery($query))
                    {
                        $lastid=  mysql_insert_id();
                        if(is_array($this->parameters["tablets"]) && sizeof($this->parameters["tablets"]) > -1){
						$query = 'INSERT INTO  `prescription_descb` (`id`,`presciption_id`,`tablet_name`,`morning`,`afternoon`,`evening`,`frequency`,`dosage` ) VALUES';
						for($i=0;$i<sizeof($this->parameters["tablets"]);$i++){
							if($i == sizeof($this->parameters["tablets"])-1)
								$query .= '(NULL,"'.mysql_real_escape_string ($lastid).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['tablets'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['morning'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['afternoon'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['dinner'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['frequency'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['dosage'][$i]).'");';
							else
								$query .= '(NULL,"'.mysql_real_escape_string ($lastid).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['tablets'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['morning'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['afternoon'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['dinner'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['frequency'][$i]).'",'
                                                                . '"'.  mysql_real_escape_string($this->parameters['dosage'][$i]).'"),';
						}
                            if(executeQuery($query))
                            {
                                $query='INSERT INTO `pharmacy`(`id`,`doctorid`,`pharmacyid`,`prescribtion_id`,`date-time`,`status_id`)VALUES(null,'
                                        . '"'.  mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]).'",'
                                        . '"'.  mysql_real_escape_string($this->parameters['pharid']).'",'
                                        . '"'.  mysql_real_escape_string($lastid).'",'
                                        . 'CURRENT_TIMESTAMP,4);';
                            }
                            if(executeQuery($query))
                            {
                                $flag=true;
                            }
				}
                    }
                    if($flag)
                    {
                        executeQuery('COMMIT');
                    }
                }
                public function fetchpatientassesmentdetails($pid) {
                   $query12='SELECT `photo` FROM `user_profie` WHERE id='.  mysql_real_escape_string($pid); 
                   $result12=  executeQuery($query12);
                   $row12=  mysql_fetch_assoc($result12);
                   $photo=$row12['photo'];
                   $query='SELECT * FROM `passesment` WHERE `patientid`='.$pid.' AND `doctorid`='.$_SESSION["USER_LOGIN_DATA"]["USER_ID"].' AND `status_id`=4; ';
                    $res=  executeQuery($query);
                    $row= mysql_fetch_assoc($res);
                    $previoushistory=$row['previoushistory'];
                    $disease=$row['disease'];
                    $query1='SELECT b.`bloodgroup` FROM `user_details` u,`bloodgroup` b WHERE b.`id`=u.`bloodgroup` AND `user_pk`='.trim($pid);
                    $res1=  executeQuery($query1);
                    $row1= mysql_fetch_assoc($res1);
                    if($row1['bloodgroup']=='NULL')
                    {
                        $bg='';
                    }
                    else
                    {
                      $bg= $row1['bloodgroup']; 
                    }
                    if(mysql_num_rows($res))
                    {
                      $count=mysql_num_rows($res);  
                    }
                    else
                    {
                      $count=0;  
                    }
                    $habits=array();
                    $habitids=array();
                    $query='SELECT DISTINCT(`habit`) FROM `patient_habit` WHERE `patientid`='.  trim($pid).' ORDER BY `habit`';
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result)>0){
                      while ($row=  mysql_fetch_assoc($result))
                     {
                      $habits[]=$row;
                      }
                    }
                      if(is_array($habits))
                        $num1 = sizeof($habits);
                      if($num1)
                      {
                          for($i=0;$i<$num1;$i++)
                          {
                            $habitids[$i]= $habits[$i]['habit'];
                             }
                      }
                    $jsonmess=array(
                     "previoushistory" => $previoushistory,
                     "disease" => $disease,
                     "bg"   =>$bg,
                     "count" => $count,
                     "habits" => $habitids,
                     "photo" =>$photo,   
                    );
                    return $jsonmess;
                    
                }    
        }
