<?php
define("MODULE_0","config.php");
require_once (MODULE_0);
require_once (MODULE_1);
require_once (MODULE_CONTROLLER);
$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
            switch ($_POST['action'])
            {
             case "addnews" : {
                                $details=array(
                                 "heading" => isset($_POST["details"]["heading"]) ? $_POST["details"]["heading"] : false, 
                                 "descb" => isset($_POST["details"]["descb"]) ? $_POST["details"]["descb"] : false,  
                                );
                                $obj=new controller($details);
                                echo json_encode($obj->addNEWS());
                                }
                                break; 
            case "fetchnews" : {
                                $obj=new controller();
                                echo json_encode($obj->fetchNEWS());
                                }
                                break;    
            case "addbusiness" : {
                                $details=array(
                                 "businame" => isset($_POST["details"]["businame"]) ? $_POST["details"]["businame"] : false, 
                                 "addr" => isset($_POST["details"]["addr"]) ? $_POST["details"]["addr"] : false,  
                                "mobile" => isset($_POST["details"]["mobile"]) ? $_POST["details"]["mobile"] : false, 
                                "email" => isset($_POST["details"]["email"]) ? $_POST["details"]["email"] : false, 
                                "descb" => isset($_POST["details"]["descb"]) ? $_POST["details"]["descb"] : false, 
                                );
                                $obj=new controller($details);
                                echo json_encode($obj->addBusiness());
                                }
                                break;                 
            case "fetchbusiness" : {
                                $obj=new controller();
                                echo json_encode($obj->fetchBusiness());
                                }
                                break; 
            case "verifyuser" : {
                                   $details=array(
                                       "username" => isset($_POST["username"]) ? $_POST["username"] : false,
                                       "password" => isset($_POST["password"]) ? $_POST["password"] : false,
                                   );
                                $obj=new controller($details);
                                echo json_encode($obj->verifyUser());
                                }
                                break;  
            case "sigup" : {
                                   $details=array(
                                       "name" => isset($_POST['name']) ? $_POST['name'] : false,
                                       "regemobile" => isset($_POST['regemobile']) ? $_POST['regemobile'] : false,
                                       "regemail" => isset($_POST['regemail']) ? $_POST['regemail'] : false,
                                       "regcpass" => isset($_POST['regcpass']) ? $_POST['regcpass'] : false,
                                       "password" => isset($_POST['regpass']) ? $_POST['regpass'] : false,
                                   );
                                $obj=new controller($details);
                                echo json_encode($obj->signup());
                                }
                                break;       
            case "checkemail" : {
                                $obj=new controller();
                                echo json_encode($obj->checkEmail(isset($_POST['email']) ? $_POST['email'] : false));
                                }
                                break;          
            case "addspon" : {
                                $obj=new controller();
                                echo json_encode($obj->addSPON(isset($_POST['imgurl']) ? $_POST['imgurl'] : false));
                                }
                                break;       
             case "fetchspons" : {
                                $obj=new controller();
                                echo json_encode($obj->fetchSpons());
                                }
                                break;  
            case "deletebuzz" : {
                                $obj=new controller();
                                echo json_encode($obj->deleteBuzzPost(isset($_POST['bid']) ? $_POST['bid'] : false));
                                }
                                break;                 
            case "deletenews" : {
                                $obj=new controller();
                                echo json_encode($obj->deleteNEWSPost(isset($_POST['bid']) ? $_POST['bid'] : false));
                                }
                                break;     
            case "deletsponz" : {
                                $obj=new controller();
                                echo json_encode($obj->deleteSponzPost(isset($_POST['bid']) ? $_POST['bid'] : false));
                                }
                                break  ;              
            }
                    
            } 
}

