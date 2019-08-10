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
            }
                    
            } 
}

