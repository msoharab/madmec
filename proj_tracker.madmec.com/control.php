<?php
define("MODULE_1", "config.php");
define("MODULE_2", "database.php");
define("APP_MODULE", "appcontroller.php");
require_once(MODULE_1);
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);
require_once(LIB_ROOT . PDF);
require_once (APP_MODULE);
$driver = array(
    "regdno" => isset($_POST['attr']['regdno']) ? $_POST['attr']['regdno'] : false,
    "drivername" => isset($_POST['attr']['drivername']) ? $_POST['attr']['drivername'] : false,
    "driveremail" => isset($_POST['attr']['driveremail']) ? $_POST['attr']['driveremail'] : false,
    "drivermobile" => isset($_POST['attr']['drivermobile']) ? $_POST['attr']['drivermobile'] : false,
    "usertype" => isset($_POST['attr']['usertype']) ? $_POST['attr']['usertype'] : false
);
$locations = array(
    "loc" => isset($_POST['locations']) ? $_POST['locations'] : false,
);
/* POST Variables pool */
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
    "billdetails" => isset($driver) ? (array) $driver : false,
    "locations" => isset($locations) ? (array) $locations : false,
);
function main($parameters) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            if (!ValidateAdmin()) {
                session_destroy();
                echo "logout";
            } else {
                switch ($parameters["action"]) {

                    case "logout": {
                            session_destroy();
                            echo "logout";
                        }
                        break;
                    case "saveUserDetails": {
                            $appobj = new app($parameters['billdetails']);
                            echo json_encode($appobj->saveUserDetails());
                        }
                        break;
                    case 'checkemail': {
                            $query = "SELECT `email` FROM `user_profile` WHERE `email`='" . mysql_real_escape_string($_POST['email']) . "';";
                            $result = executeQuery($query);
                            echo mysql_num_rows($result);
                            break;
                        }
                    case 'checkRegdNo': {
                            $query = "SELECT `regdno` FROM `user_profile` WHERE `regdno`='" . mysql_real_escape_string($_POST['email']) . "';";
                            $result = executeQuery($query);
                            echo mysql_num_rows($result);
                            break;
                        }
                    case 'saveLocations': {
                            $appobj = new app($parameters['locations']);
                            echo json_encode($appobj->saveLocations());
                            break;
                        }
                    case 'updateLocation': {
                            $appobj = new app($parameters['locations']);
                            echo json_encode($appobj->updateLocation());
                            break;
                        }
                    case 'getLocations': {
                            $appobj = new app();
                            echo json_encode($appobj->getLocations());
                            break;
                        }
                    case 'getUsers': {
                            $appobj = new app();
                            echo json_encode($appobj->getUsers());
                            break;
                        }
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    unset($_POST);
    exit(0);
}
if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') {
    global $parameters;
    main($parameters);
}
?>