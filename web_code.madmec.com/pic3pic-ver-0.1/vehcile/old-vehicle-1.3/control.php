<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
define("MODULE_2", "Date.php");
require_once(MODULE_0);
//require_once(CONFIG_ROOT . MODULE_3);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);
//Importing DAO Classes
require_once(DOC_ROOT . CLASSES . SUPERADMIN . DAO_VEHICLE);
require_once(DOC_ROOT . CLASSES . SUPERADMIN . DAO_VENDOR);
require_once(DOC_ROOT . CLASSES . SUPERADMIN . DAO_USER);
require_once(DOC_ROOT . CLASSES . SUPERADMIN . DAO_COMPLAINTS);
require_once(DOC_ROOT . CLASSES . SUPERADMIN . DAO_REPORT);
require_once(DOC_ROOT . CLASSES . SUPERADMIN . DAO_CHANGEPASSWORD);
require_once(DOC_ROOT . CLASSES . VENDOR_MOD . DAO_VENDOR);
require_once(DOC_ROOT . CLASSES . VENDOR_MOD . DAO_VENDORPROFILE);

require_once(DOC_ROOT . CLASSES . USER_MOD . DAO_USERVEHICLE);
require_once(DOC_ROOT . CLASSES . USER_MOD . DAO_USERAPPOINTMENT);
require_once(DOC_ROOT . CLASSES . USER_MOD . DAO_USERHISTORY);
require_once(DOC_ROOT . CLASSES . USER_MOD . DAO_USERPROFILE);
require_once(LIB_ROOT . 'PHPExcel_1.7.9/Classes/PHPExcel.php');
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
);

function main() {
    global $parameters;
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            if (!ValidateAdmin()) {
                session_destroy();
                echo "logout";
            } else {
                $request = explode('/', $parameters["action"]);
                if (sizeof($request) == 2) {
                    switch ($request[1]) {
                        case 'econfigureappointment' : {
                                $appconfiginfo = array(
                                    "days" => isset($_POST["configureappt"]["day"]) ? $_POST["configureappt"]["day"] : false,
                                    "weekidd" => isset($_POST["configureappt"]["weekidd"]) ? $_POST["configureappt"]["weekidd"] : false,
                                    "fromtime" => isset($_POST["configureappt"]["fromtime"]) ? $_POST["configureappt"]["fromtime"] : false,
                                    "totime" => isset($_POST["configureappt"]["totime"]) ? $_POST["configureappt"]["totime"] : false,
                                    "location" => isset($_POST["configureappt"]["location"]) ? $_POST["configureappt"]["location"] : false,
                                    "frequency" => isset($_POST["configureappt"]["frequency"]) ? $_POST["configureappt"]["frequency"] : false,
                                );
                                $obj = new $request[0]($appconfiginfo);
                                echo json_encode($obj->$request[1]());
                                break;
                            }
                        case 'deleteappointment' : {
                                $apptid = isset($_POST["apptid"]) ? $_POST["apptid"] : false;
                                $obj = new $request[0]($appconfiginfo);
                                echo json_encode($obj->$request[1]($apptid));
                                break;
                            }
                        case 'editappointment' : {
                                $appconfiginfo = array(
                                    "appid" => isset($_POST["editappt"]["apptid"]) ? $_POST["editappt"]["apptid"] : false,
                                    "fromtime" => isset($_POST["editappt"]["fromtime"]) ? $_POST["editappt"]["fromtime"] : false,
                                    "totime" => isset($_POST["editappt"]["totime"]) ? $_POST["editappt"]["totime"] : false,
                                    "location" => isset($_POST["editappt"]["location"]) ? $_POST["editappt"]["location"] : false,
                                    "frequency" => isset($_POST["editappt"]["frequency"]) ? $_POST["editappt"]["frequency"] : false,
                                );
                                $obj = new $request[0]($appconfiginfo);
                                echo json_encode($obj->$request[1]());
                                break;
                            }
                        case 'configureappointment' : {
                                $appconfiginfo = array(
                                    "days" => isset($_POST["configureappt"]["days"]) ? $_POST["configureappt"]["days"] : false,
                                    "fromtime" => isset($_POST["configureappt"]["fromtime"]) ? $_POST["configureappt"]["fromtime"] : false,
                                    "totime" => isset($_POST["configureappt"]["totime"]) ? $_POST["configureappt"]["totime"] : false,
                                    "location" => isset($_POST["configureappt"]["location"]) ? $_POST["configureappt"]["location"] : false,
                                    "frequency" => isset($_POST["configureappt"]["frequency"]) ? $_POST["configureappt"]["frequency"] : false,
                                );
                                $obj = new $request[0]($appconfiginfo);
                                echo json_encode($obj->$request[1]());
                                break;
                            }
                        case 'fetchAppointeeDetails' : {
                                $appconfiginfo = array(
                                    "appid" => isset($_POST["inputinfo"]["appid"]) ? $_POST["inputinfo"]["appid"] : false,
                                    "date" => isset($_POST["inputinfo"]["date"]) ? $_POST["inputinfo"]["date"] : false,
                                );
                                $obj = new $request[0]($appconfiginfo);
                                echo json_encode($obj->$request[1]());
                                break;
                            }
                        case 'bookSlot' : {
                                $inpudelt = array(
                                    "slotid" => isset($_POST['inputdetl']['apptid']) ? $_POST['inputdetl']['apptid'] : false,
                                    "date" => isset($_POST['inputdetl']['date']) ? $_POST['inputdetl']['date'] : false,
                                    "vhid" => isset($_POST['inputdetl']['vhid']) ? $_POST['inputdetl']['vhid'] : false,
                                    "rowid" => isset($_POST['inputdetl']['rowid']) ? $_POST['inputdetl']['rowid'] : false,
                                    "servid" => isset($_POST['inputdetl']['servid']) ? $_POST['inputdetl']['servid'] : false,
                                    "bookaservice" => isset($_POST['inputdetl']['bookaservice']) ? $_POST['inputdetl']['bookaservice'] : false,
                                    "typeofservice" => isset($_POST['inputdetl']['typeofservice']) ? $_POST['inputdetl']['typeofservice'] : false,
                                );
                                $obj = new $request[0]($inpudelt);
                                echo json_encode($obj->$request[1]());
                                break;
                            }
                        default: {
                                $obj = new $request[0]($_POST);
                                echo json_encode($obj->$request[1]());
                                break;
                            }
                    }
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
}

if (isset($parameters['autoloader']) && $parameters['autoloader'] == 'true') {
    main();
    unset($_POST);
    exit(0);
} else {

}
$menufilename=isset($_SESSION['USER_LOGIN_DATA']['MENU_FILE']) ? $_SESSION['USER_LOGIN_DATA']['MENU_FILE'] : 'adminmenu';
require_once(DOC_ROOT . INC . $menufilename.'.php');
require_once(DOC_ROOT . INC . 'res-footer.php');
?>