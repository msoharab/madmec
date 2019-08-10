<?php
define("MODULE_0","config.php");
require_once (MODULE_0);
require_once (MODULE_SIGNIN);
require_once (MODULE_DOWNLOADFILES);
require_once (MODULE_DOCTOR);
require_once (MODULE_PATIENT);
require_once (MODULE_DIAGNOSTICS);
require_once (MODULE_PHARMACY);
require_once (MODULE_SUPERADMIN);
require_once (MODULE_RESET);
//echo '<br/>'.print_r($_POST);
$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
            switch ($_POST['action'])
            {
				/* by naseer */
                case 'send_email' : 
									{ 
										ResetNow($_POST['email']);
									}
									break;
				/* by naseer */	
                case 'verifyuser' :
                                        {
                                        $verifydata=array(
                                         "username" => isset($_POST["singindata"]["username"]) ? $_POST["singindata"]["username"] : false, 
                                         "password" => isset($_POST["singindata"]["password"]) ? $_POST["singindata"]["password"] : false,  
                                        );
                                        $sing=new signin($verifydata);
                                        echo json_encode($sing->userveify());
                                        }
                                        break;
                case 'checkdoctorinfo' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->checkdoctorinfo());
                                        }
                                        break;  
                case 'fetchusertypes' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchusertypes());
                                        }
                                        break;     
                 case 'fetchmessagetypes' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchmessagetypes());
                                        }
                                        break;  
                case 'fetchmessagetypeschatdel' :
                                        {
                                        $doctor=new doctor();
                                        $typeid=  isset($_POST['typeid']) ? $_POST['typeid'] : false;
                                        echo json_encode($doctor->fetchmessagetypeschatdel($typeid));
                                        }
                                        break;   
                case 'refreshchatHistory' :
                                        {
                                        $doctor=new doctor();
                                        $typeid=  isset($_POST['messid']) ? $_POST['messid'] : false;
                                        echo json_encode($doctor->refreshchatHistory($typeid));
                                        }
                                        break; 
                case 'clearchathistory' :
                                        {
                                        $doctor=new doctor();
                                        $typeid=  isset($_POST['messid']) ? $_POST['messid'] : false;
                                        echo json_encode($doctor->clearChatHistory($typeid));
                                        }
                                        break;       
                case 'sendchatmessage' :
                                        {
                                        $doctor=new doctor();
                                        $typeid=  isset($_POST['messid']) ? $_POST['messid'] : false;
                                        $message= isset($_POST['message']) ? $_POST['message'] : false;
                                        echo json_encode($doctor->sendChatMessage($typeid,$message));
                                        }
                                        break;      
                case 'fetchalluserundertype' :
                                        {
                                        $doctor=new doctor(); 
                                        $typeid=  isset($_POST['typeid']) ? $_POST['typeid'] : false;
                                        echo json_encode($doctor->fetchAllUserUndertype($typeid));
                                        }
                                        break;    
                case 'checkforchathistory' :
                                        {
                                        $doctor=new doctor();
                                        $topk=  isset($_POST['topk']) ? $_POST['topk'] : false;
                                        $typeid=  isset($_POST['typeid']) ? $_POST['typeid'] : false;
                                        echo json_encode($doctor->checkForChatHistory($topk,$typeid));
                                        }
                                        break; 
                case 'startnewChat' :
                                        {
                                        $doctor=new doctor();
                                        $topk=  isset($_POST['details']['topk']) ? $_POST['details']['topk'] : false;
                                        $typeid=  isset($_POST['details']['typeid']) ? $_POST['details']['typeid'] : false;
                                        $message = isset($_POST['details']['message']) ? $_POST['details']['message'] : false;
                                        echo json_encode($doctor->startNewChart($topk,$typeid,$message));
                                        }
                                        break;                    
                case 'fetchappointmentdetails' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchappointmentdetails());
                                        }
                                        break;                     
                case 'addpresciption'  : {
                                        $prescinfo=array(
                                         "patientid" => isset($_POST['presciptioninfo']['patientid']) ? $_POST['presciptioninfo']['patientid'] : false,
                                         "pharid" => isset($_POST['presciptioninfo']['pharid']) ? $_POST['presciptioninfo']['pharid'] : false, 
                                         "tablets" => isset($_POST['presciptioninfo']['tablets']) ? $_POST['presciptioninfo']['tablets'] : false,
                                         "morning" => isset($_POST['presciptioninfo']['morning']) ? $_POST['presciptioninfo']['morning'] : false,
                                         "afternoon" => isset($_POST['presciptioninfo']['afternoon']) ? $_POST['presciptioninfo']['afternoon'] : false,
                                         "dinner" => isset($_POST['presciptioninfo']['dinner']) ? $_POST['presciptioninfo']['dinner'] : false,
                                         "frequency" => isset($_POST['presciptioninfo']['frequency']) ? $_POST['presciptioninfo']['frequency'] : false,
                                         "dosage" => isset($_POST['presciptioninfo']['dosage']) ? $_POST['presciptioninfo']['dosage'] : false,   
                                        );
                                        $doctor=new doctor($prescinfo);
                                        echo $doctor->addprescibtioninfo();
                                         }
                                         break;
                case 'adddoctorinfo'   :
                                        {
                                        $docinfo=array(
                                        "doctorname" => isset($_POST["doctorinfo"]["doctorname"]) ? $_POST["doctorinfo"]["doctorname"] : false,
                                        "doctorid" => isset($_POST["doctorinfo"]["doctorid"]) ? $_POST["doctorinfo"]["doctorid"] : false, 
                                        "clinicname" => isset($_POST["doctorinfo"]["clinicname"]) ? $_POST["doctorinfo"]["clinicname"] : false,
                                        "doctoraddress" => isset($_POST["doctorinfo"]["doctoraddress"]) ? $_POST["doctorinfo"]["doctoraddress"] : false,
                                        "doctorcellnum" => isset($_POST["doctorinfo"]["doctorcellnum"]) ? $_POST["doctorinfo"]["doctorcellnum"] : false,
                                        "doctoremail" => isset($_POST["doctorinfo"]["doctoremail"]) ? $_POST["doctorinfo"]["doctoremail"] : false,
                                        );
                                        $doctor=new doctor($docinfo);
                                        echo $doctor->adddoctorinfo();
                                        }
                                        break; 
                case 'addpatientinfo' :
                                        {
                                        function GetImageExtension($imagetype)
                                        {
                                          if(empty($imagetype)) return false;
                                          switch($imagetype)
                                          {
                                              case 'image/bmp': return '.bmp';
                                              case 'image/gif': return '.gif';
                                              case 'image/jpeg': return '.jpg';
                                              case 'image/png': return '.png';
                                              default: return false;
                                          }
                                       }
                                       if (!empty($_POST["patientinfo"]["patientpic"])) {
                                       $file_name=$_FILES[$_POST["patientinfo"]["patientpic"]]["name"];
                                       $temp_name=$_FILES[$_POST["patientinfo"]["patientpic"]]["tmp_name"];
                                       $imgtype=$_FILES[$_POST["patientinfo"]["patientpic"]]["type"];
                                       $ext= GetImageExtension($imgtype);
                                       $imagename=date("d-m-Y")."-".time().$ext;
                                       $target_path = "assets/patientphotos/".$imagename;
                                       if(move_uploaded_file($temp_name, $target_path)) {
                                       $_SESSION['imagepath']=$target_path;
                                        }else{
                                       exit("Error While uploading image on the server");
                                        }
                                        } 
                                        $patientinfo=array(
                                        "patientname" => isset($_POST["patientinfo"]["patientname"]) ? $_POST["patientinfo"]["patientname"] : false,
                                        "patientage" => isset($_POST["patientinfo"]["patientage"]) ? $_POST["patientinfo"]["patientage"] : false,
                                        "patientgender" => isset($_POST["patientinfo"]["patientgender"]) ? $_POST["patientinfo"]["patientgender"] : false,
                                        "patientaddress" => isset($_POST["patientinfo"]["patientaddress"]) ? $_POST["patientinfo"]["patientaddress"] : false,
                                        "patientcellnum" => isset($_POST["patientinfo"]["patientcellnum"]) ? $_POST["patientinfo"]["patientcellnum"] : false,
                                        "patientemail" => isset($_POST["patientinfo"]["patientemail"]) ? $_POST["patientinfo"]["patientemail"] : false,
                                        "patientgname" => isset($_POST["patientinfo"]["patientgname"]) ? $_POST["patientinfo"]["patientgname"] : false,
                                        "patientgcellnum" => isset($_POST["patientinfo"]["patientgcellnum"]) ? $_POST["patientinfo"]["patientgcellnum"] : false,
                                        "usertypeid" => isset($_POST["patientinfo"]["usertypeid"]) ? $_POST["patientinfo"]["usertypeid"] : false,
                                            );
                                        $doctor=new doctor($patientinfo);
                                        echo $doctor->addpatientinfo();
                                        }
                                        break; 
                case 'addpharmacysinfo' :
                                        {
                                        $pharmacyinfo=array(
                                        "usertypeid" => isset($_POST["pharmacyinfoinfo"]["usertypeid"]) ? $_POST["pharmacyinfoinfo"]["usertypeid"] : false,
                                        "ppname" => isset($_POST["pharmacyinfoinfo"]["ppname"]) ? $_POST["pharmacyinfoinfo"]["ppname"] : false,    
                                        "pharmacyname" => isset($_POST["pharmacyinfoinfo"]["pharmacyname"]) ? $_POST["pharmacyinfoinfo"]["pharmacyname"] : false,    
                                        "pharaddress" => isset($_POST["pharmacyinfoinfo"]["pharaddress"]) ? $_POST["pharmacyinfoinfo"]["pharaddress"] : false,    
                                        "pphonenum" => isset($_POST["pharmacyinfoinfo"]["pphonenum"]) ? $_POST["pharmacyinfoinfo"]["pphonenum"] : false,    
                                        "pharemail" => isset($_POST["pharmacyinfoinfo"]["pharemail"]) ? $_POST["pharmacyinfoinfo"]["pharemail"] : false,    
                                            );
                                        $doctor=new doctor($pharmacyinfo);
                                        echo $doctor->addpharmacyinfo();
                                        }
                                        break;    
                case 'addpatientassesment' :
                                        {
                                        $passestinfo=array(
                                        "patientid" => isset($_POST["patientassinfo"]["patientid"]) ? $_POST["patientassinfo"]["patientid"] : false,
                                        "cpatientid" => isset($_POST["patientassinfo"]["cpatientid"]) ? $_POST["patientassinfo"]["cpatientid"] : false,  
                                        "phh" => isset($_POST["patientassinfo"]["phh"]) ? $_POST["patientassinfo"]["phh"] : false,
                                        "count" => isset($_POST["patientassinfo"]["count"]) ? $_POST["patientassinfo"]["count"] : false,     
                                        "disease" => isset($_POST["patientassinfo"]["disease"]) ? $_POST["patientassinfo"]["disease"] : false, 
                                        "bg" => isset($_POST["patientassinfo"]["bg"]) ? $_POST["patientassinfo"]["bg"] : false, 
                                        "cass" => isset($_POST["patientassinfo"]["cass"]) ? $_POST["patientassinfo"]["cass"] : false, 
                                        "cassrem" => isset($_POST["patientassinfo"]["cassrem"]) ? $_POST["patientassinfo"]["cassrem"] : false,
                                        "habits" => isset($_POST["patientassinfo"]["habits"]) ? $_POST["patientassinfo"]["habits"] : false, 
                                        "pharid" => isset($_POST['patientassinfo']['pharid']) ? $_POST['patientassinfo']['pharid'] : false, 
                                         "tablets" => isset($_POST['patientassinfo']['tablets']) ? $_POST['patientassinfo']['tablets'] : false,
                                         "morning" => isset($_POST['patientassinfo']['morning']) ? $_POST['patientassinfo']['morning'] : false,
                                         "afternoon" => isset($_POST['patientassinfo']['afternoon']) ? $_POST['patientassinfo']['afternoon'] : false,
                                         "dinner" => isset($_POST['patientassinfo']['dinner']) ? $_POST['patientassinfo']['dinner'] : false,
                                         "frequency" => isset($_POST['patientassinfo']['frequency']) ? $_POST['patientassinfo']['frequency'] : false,
                                         "dosage" => isset($_POST['patientassinfo']['dosage']) ? $_POST['patientassinfo']['dosage'] : false,   
                                            );
                                        $doctor=new doctor($passestinfo);
                                        echo $doctor->addpatientassesmentinfo();
                                        }
                                        break;  
                case 'sendPatienthis'      : {
                                        $passestinfo=array(
                                        "patientid" => isset($_POST["inputinfo"]["patientid"]) ? $_POST["inputinfo"]["patientid"] : false,
                                        "email" => isset($_POST["inputinfo"]["email"]) ? $_POST["inputinfo"]["email"] : false,
                                            );
                                        $doctor=new doctor($passestinfo);
                                        echo json_encode($doctor->sendPatientHistory()); 
                                         }
                                         break;
                case 'configureappointment' :
                                        {
                                        $appconfiginfo=array(
                                        "days" => isset($_POST["configureappt"]["days"]) ? $_POST["configureappt"]["days"] : false,
                                        "fromtime" => isset($_POST["configureappt"]["fromtime"]) ? $_POST["configureappt"]["fromtime"] : false,
                                        "totime" => isset($_POST["configureappt"]["totime"]) ? $_POST["configureappt"]["totime"] : false,
                                        "location" => isset($_POST["configureappt"]["location"]) ? $_POST["configureappt"]["location"] : false,
                                        "frequency" => isset($_POST["configureappt"]["frequency"]) ? $_POST["configureappt"]["frequency"] : false,    
                                            );
                                        $doctor=new doctor($appconfiginfo);
                                        echo $doctor->configureappointment();
                                        }
                                        break;  
                case 'econfigureappointment' :
                                        {
                                        $appconfiginfo=array( 
                                        "days" => isset($_POST["configureappt"]["day"]) ? $_POST["configureappt"]["day"] : false,    
                                        "weekidd" => isset($_POST["configureappt"]["weekidd"]) ? $_POST["configureappt"]["weekidd"] : false,
                                        "fromtime" => isset($_POST["configureappt"]["fromtime"]) ? $_POST["configureappt"]["fromtime"] : false,
                                        "totime" => isset($_POST["configureappt"]["totime"]) ? $_POST["configureappt"]["totime"] : false,
                                        "location" => isset($_POST["configureappt"]["location"]) ? $_POST["configureappt"]["location"] : false,
                                        "frequency" => isset($_POST["configureappt"]["frequency"]) ? $_POST["configureappt"]["frequency"] : false,    
                                            );
                                        $doctor=new doctor($appconfiginfo);
                                        echo $doctor->econfigureappointment();
                                        }
                                        break;                    
                                    
                case 'editappointment' :
                                        {
                                        $appconfiginfo=array(
                                        "appid" => isset($_POST["editappt"]["apptid"]) ? $_POST["editappt"]["apptid"] : false,
                                        "fromtime" => isset($_POST["editappt"]["fromtime"]) ? $_POST["editappt"]["fromtime"] : false,
                                        "totime" => isset($_POST["editappt"]["totime"]) ? $_POST["editappt"]["totime"] : false,
                                        "location" => isset($_POST["editappt"]["location"]) ? $_POST["editappt"]["location"] : false,
                                        "frequency" => isset($_POST["editappt"]["frequency"]) ? $_POST["editappt"]["frequency"] : false,    
                                            );
                                        $doctor=new doctor($appconfiginfo);
                                        echo $doctor->editappointment();
                                        }
                                        break;    
                case 'adddiagtopatient' :
                                        {
                                        $inputinfo=array(
                                        "pid" => isset($_POST["inputinfo"]["pid"]) ? $_POST["inputinfo"]["pid"] : false,
                                        "diagid" => isset($_POST["inputinfo"]["diagid"]) ? $_POST["inputinfo"]["diagid"] : false,
                                        "tests" => isset($_POST["inputinfo"]["tests"]) ? $_POST["inputinfo"]["tests"] : false,    
                                            );
                                        $doctor=new doctor($inputinfo);
                                        echo $doctor->addTesttoPatient();
                                        }
                                        break;                    
                case 'deleteappointment' :
                                        {
                                        $apptid = isset($_POST["apptid"]) ? $_POST["apptid"] : false;
                                        $doctor=new doctor();
                                        echo $doctor->deleteappointment($apptid);
                                        }
                                        break;                    
                case 'fetchpatientdetails' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchpatientdetails());
                                        }
                                        break;     
                case 'fetchtestcate' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchTestCategory());
                                        }
                                        break;    
                case 'fetchsubtypeoftest' :
                                        {
                                        $catid=isset($_POST['catid'])?$_POST['catid']:false;
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchSubTypeTest($catid));
                                        }
                                        break;                    
                case 'fetchpatientpharmacy' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchpatientpharmacy());
                                        }
                                        break;   
                case 'fetchpassesmentpatient' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchpassesmentpatient());
                                        }
                                        break;  
                case 'fetchbloodgroup' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchbloodgroup());
                                        }
                                        break;  
                case 'fetchpatientassesmentdetails' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchpatientassesmentdetails($_POST['passmtid']));
                                        }
                                        break;                    
                case 'fetchdiagnosticsdetails' :
                                        {
                                        $doctor=new doctor();
                                        echo $doctor->fetchdiagnosticsdetails();
                                        }
                                        break;  
                case 'fetchpatienthistory' :
                                        {
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchpatienthistory($_POST['pid']));
                                        }
                                        break;                    
                case 'fetchPharmacydetails' :
                                        {
                                        
                                        $doctor=new doctor();
                                        echo $doctor->fetchPharmacydetails();
                                        }
                                        break; 
                case 'fetchfullpharmacydel' :
                                        {
                                        $pharid=  isset($_POST['pharid']) ?$_POST['pharid'] :false;
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchPharmacyFullDetailsdetails($pharid));
                                        }
                                        break;   
                case 'fetchconfiguredappointment' :
                                        {
                                        
                                        $doctor=new doctor();
                                        echo json_encode($doctor->fetchconfiguredappointment());
                                        }
                                        break;                     
                case 'fetchappointeedetails' :
                                        {
                                        $inputinfo=array(
                                            "appid" => isset($_POST["inputinfo"]["appid"]) ? $_POST["inputinfo"]["appid"] : false,
                                            "date" => isset($_POST["inputinfo"]["date"]) ? $_POST["inputinfo"]["date"] : false,
                                        );
                                        $doctor=new doctor($inputinfo);
                                        echo json_encode($doctor->fetchAppointeeDetails());
                                        }
                                        break;                    
                //patients execution start
                case 'fetchdocappointmentdetails' :
                                        {
                                        $patient=new patient();
                                        echo json_encode($patient->fetchdocappointmentdetails());
                                        }
                                        break; 
                case 'fetchpatientcurrentpres'  :
                                         {
                                        $patient=new patient();
                                        echo json_encode($patient->fetchpatientcurrentpres());
                                        break; 
                                         
                                          }
                    
                 case 'bookappointment'  :
                                         {
                                         $inpudelt=array(
                                          "slotid" => isset($_POST['inputdetl']['apptid'])  ?  $_POST['inputdetl']['apptid'] : false,
                                           "date" => isset($_POST['inputdetl']['date'])  ?  $_POST['inputdetl']['date'] : false,   
                                         );
                                        $patient=new patient($inpudelt);
                                        echo json_encode($patient->bookSlot());
                                        break; 
                                         }        
                case 'fetchappointbookinghis'  :
                                         {
                                        $patient=new patient();
                                        echo json_encode($patient->fetchAppointmentBookingHistory());
                                        break; 
                                         } 
                case 'fetchpatienthistorydes'  :
                                         {
                                        $patient=new patient();
                                        echo json_encode($patient->fetchPatientPresciptionHistory());
                                        break; 
                                         } 
                //Pharmacy Module Start
                case 'fetchpharmacypatientdetails'  :
                                         {
                                        $pharmacy=new pharmacy();
                                        echo json_encode($pharmacy->fetchPharmacyPatienrtList());
                                        break; 
                                         }  
                //Diagnostics Module Start
                case 'fetchpatienttestss'  :
                                         {
                                        $diag=new diagnostic();
                                        echo json_encode($diag->fetchDiagnosticsTests());
                                        break; 
                                         }                        
                //Super Admin Module Start
                case 'createdoctor'  :
                                         {
                                         $inpudelt=array(
                                          "docotoremailid" => isset($_POST['cdocotorinfo']['docotoremailid'])  ?  $_POST['cdocotorinfo']['docotoremailid'] : false,
                                          "doctorusername" => isset($_POST['cdocotorinfo']['doctorusername'])  ?  $_POST['cdocotorinfo']['doctorusername'] : false,
                                          "doctorpassword" => isset($_POST['cdocotorinfo']['doctorpassword'])  ?  $_POST['cdocotorinfo']['doctorpassword'] : false,  
                                         );
                                        $admin=new superadmin($inpudelt);
                                        echo json_encode($admin->createDoctor());
                                        break; 
                                         } 
                 case 'checkdoceml'  :
                                        {
                                        $reqid = isset($_POST['reqid'])  ?  $_POST['reqid'] : false;
                                        $docotoremailidreq = isset($_POST['req'])  ?  $_POST['req'] : false;
                                        $docotoremailid = isset($_POST['docemail'])  ?  $_POST['docemail'] : false;
                                        $admin=new superadmin();
                                        echo json_encode($admin->checkdocemail($docotoremailid,$docotoremailidreq,$reqid));
                                        break; 
                                         }            
                case 'checkdocusr'  :
                                        {
                                        $docotoremailid = isset($_POST['docuser'])  ?  $_POST['docuser'] : false;
                                        $admin=new superadmin();
                                        echo json_encode($admin->checkdocuser($docotoremailid));
                                        break; 
                                         }       
                case 'fetchlistofdoctor'  :
                                        {
                                        $admin=new superadmin();
                                        echo json_encode($admin->fetchListOfDoctors());
                                        break; 
                                         } 
                case 'makedocinact'  :
                                        {
                                        $did=isset($_POST['did']) ? $_POST['did'] : false;
                                        $admin=new superadmin();
                                        echo json_encode($admin->makeDoctorInactive($did));
                                        break; 
                                         }          
                case 'makedocact'  :
                                        {
                                        $did=isset($_POST['did']) ? $_POST['did'] : false;
                                        $admin=new superadmin();
                                        echo json_encode($admin->makeDoctorActive($did));
                                        break; 
                                         }      
                case 'fetchdocreq'  :
                                        {
                                        $admin=new superadmin();
                                        echo json_encode($admin->fetchDoctorsRequest());
                                        break; 
                                         }    
                case 'activateuseraccount'  :
                                         {
                                         $inpudelt=array(
                                          "reqid" => isset($_POST['inputinfo']['reqid'])  ?  $_POST['inputinfo']['reqid'] : false,
                                          "reqemail" => isset($_POST['inputinfo']['reqemail'])  ?  $_POST['inputinfo']['reqemail'] : false,
                                          "requsername" => isset($_POST['inputinfo']['requsername'])  ?  $_POST['inputinfo']['requsername'] : false,
                                          "reqpassword" => isset($_POST['inputinfo']['reqpassword'])  ?  $_POST['inputinfo']['reqpassword'] : false, 
                                         );
                                        $admin=new superadmin($inpudelt);
                                        echo json_encode($admin->activateUserAccount());
                                        break; 
                                         }     
                case 'addtest'  :
                                         {
                                         $inpudelt=array(
                                          "testcat" => isset($_POST['inputinfo']['testcat'])  ?  $_POST['inputinfo']['testcat'] : false,
                                          "testname" => isset($_POST['inputinfo']['testname'])  ?  $_POST['inputinfo']['testname'] : false,
                                           );
                                        $admin=new superadmin($inpudelt);
                                        echo json_encode($admin->createTest());
                                        break; 
                                         }     
                 case 'fetchdiagtest'  :
                                        {
                                        $admin=new superadmin();
                                        echo json_encode($admin->fetchDiagnosticTests());
                                        break; 
                                         }       
                case 'deltest'  :
                                        {
                                        $did=isset($_POST['testid']) ? $_POST['testid'] : false;
                                        $admin=new superadmin();
                                        echo json_encode($admin->DeleteTest($did));
                                        break; 
                                         }      
                case 'fetchtypesoftest'  :
                                        {
                                        $admin=new superadmin();
                                        echo json_encode($admin->fetchTestTypes());
                                        break; 
                                         }                          
                        }
                }
            }    
?>

