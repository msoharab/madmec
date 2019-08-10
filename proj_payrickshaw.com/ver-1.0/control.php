<?php
define("MODULE_1","config.php");
define("MODULE_2","database.php");
define("APP_MODULE","appcontroller.php");
define("ACCOUNT_MODULE","account.php");
require_once(MODULE_1);
require_once(CONFIG_ROOT.MODULE_1);
require_once(CONFIG_ROOT.MODULE_2);
require_once(LIB_ROOT.PDF);
require_once (APP_MODULE);
require_once (ACCOUNT_MODULE);
//require_once (PDFBILLGEN);
    $billdetails=array(
        "regdno"   => isset($_POST['attr']['regdno']) ? $_POST['attr']['regdno'] : false,
        "drivername"   => isset($_POST['attr']['drivername']) ? $_POST['attr']['drivername'] : false,
        "drivermobile"   => isset($_POST['attr']['drivermobile']) ? $_POST['attr']['drivermobile'] : false,
        "passengermobile"   => isset($_POST['attr']['passengermobile']) ? $_POST['attr']['passengermobile'] : false,
        "passengername"   => isset($_POST['attr']['passengername']) ? $_POST['attr']['passengername'] : false,
        "passngeraddress"   => isset($_POST['attr']['passngeraddress']) ? $_POST['attr']['passngeraddress'] : false,
        "source"   => isset($_POST['attr']['source']) ? $_POST['attr']['source'] : false,
        "destination"   => isset($_POST['attr']['destination']) ? $_POST['attr']['destination'] : false,
        "distance"   => isset($_POST['attr']['distance']) ? $_POST['attr']['distance'] : false,
        "amount"   => isset($_POST['attr']['amount']) ? $_POST['attr']['amount'] : false,
        "drivercheck"   => isset($_POST['attr']['drivercheck']) ? $_POST['attr']['drivercheck'] : false,
        "passcheck"   => isset($_POST['attr']['passcheck']) ? $_POST['attr']['passcheck'] : false,
        "passid"   => isset($_POST['attr']['passid']) ? $_POST['attr']['passid'] : false,
        "driverid"   => isset($_POST['attr']['driverid']) ? $_POST['attr']['driverid'] : false,
    );
    $payments=array(
        "driverid" => isset($_POST['details']['driverid'])? $_POST['details']['driverid'] : false,
        "amount" => isset($_POST['details']['amount'])? $_POST['details']['amount'] : false,
        "remark" => isset($_POST['details']['remark'])? $_POST['details']['remark'] : false,
    );
	/* POST Variables pool */
	$parameters = array(
		"autoloader" 	=> isset($_POST["autoloader"]) 		? $_POST["autoloader"] 		: false,
		"action" 	 	=> isset($_POST["action"]) 			? $_POST["action"]			: false,
                "billdetails" 	=> isset($billdetails) 		? (array)$billdetails		: false,
                 "addpayment" => isset($payments)  ? (array)$payments : false,
		);
	function main($parameters){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if(!ValidateAdmin()){
					session_destroy();
					echo "logout";
				}else{
					switch ($parameters["action"]) {
						
						case "logout":{
								session_destroy();
								echo "logout";
							}
						break;
                                            case "genretebill":{
							 $appobj=new app($parameters['billdetails']);
                                                         echo json_encode($appobj->generateBill());
							}
						break; 
                                            case "fetchregdnumber":{
							 $appobj=new app();
                                                         echo json_encode($appobj->fetchRegdNumbers());
							}
						break; 
                                             case "addpayment":{
							 $appobj=new account($parameters['addpayment']);
                                                         echo json_encode($appobj->addpayment());
							}
						break;
                                            case "fetchpaymenthistory":{
                                                        $driverid=  isset($_POST['driverid']) ? $_POST['driverid'] : false;
							 $appobj=new account();
                                                         echo json_encode($appobj->fetchPaymentHistory($driverid));
							}
						break;
					}
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		unset($_POST);
		exit(0);
	}
	if(isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true'){
		global $parameters;
		main($parameters);
	}
	
?>