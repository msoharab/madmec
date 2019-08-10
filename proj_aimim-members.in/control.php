<?php
define("MODULE_1","config.php");
define("MODULE_2","database.php");
define("DAO", "dao.php");
require_once(MODULE_1);
require_once(CONFIG_ROOT.MODULE_1);
require_once(CONFIG_ROOT.MODULE_2);
require_once(DAO);
    //admin add param
    $addadminmember=array(
        "name" => isset($_POST['name']) ? $_POST['name'] : false,
        "mobile" => isset($_POST['mobile']) ? $_POST['mobile'] : false,
        "email" => isset($_POST['email']) ? $_POST['email'] : false,
        "dob" => isset($_POST['dob']) ? $_POST['dob'] : false,
        "gender" => isset($_POST['gender']) ? $_POST['gender'] : false,
        "zipcode" => isset($_POST['zipcode']) ? $_POST['zipcode'] : false,
        "address" => isset($_POST['address']) ? $_POST['address'] : false,
        "locality" => isset($_POST['locality']) ? $_POST['locality'] : false,
        "city" => isset($_POST['city']) ? $_POST['city'] : false,
        "province" => isset($_POST['province']) ? $_POST['province'] : false,
        "usertype" => isset($_POST['usertype']) ? $_POST['usertype'] : false,
    );
    $sendmessage=array(
        "message" => isset($_POST['message']) ? $_POST['message'] : false,
        "usertype" => isset($_POST['usertype']) ? $_POST['usertype'] : false,
    );

	/* POST Variables pool */
	$parameters = array(
		"autoloader" 	=> isset($_POST["autoloader"]) 		? $_POST["autoloader"] 		: false,
		"action" 	 	=> isset($_POST["action"]) 			? $_POST["action"]			: false,
                "addadminmember" => isset($addadminmember) ? (array)$addadminmember : false,
                "sendmessage" => isset($sendmessage) ? (array)$sendmessage : false,
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

                                            case "fetchmembers":{
							 $appobj=new dao();
                                                         echo json_encode($appobj->fetchMembers());
							}
						break;
                                            case "addadminmember":{
							 $appobj=new dao($parameters['addadminmember']);
                                                         echo json_encode($appobj->addadminparam());
							}
						break;
                                            case "fetchusertype":{
							 $appobj=new dao();
                                                         echo json_encode($appobj->fetchUserType());
							}
						break;
                                            case "sendmessage":{
							 $appobj=new dao($parameters['sendmessage']);
                                                         echo json_encode($appobj->sendMessage());
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