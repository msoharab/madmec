<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
//require_once(CONFIG_ROOT . MODULE_3);
require_once(MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
$statuss=  isset($_SESSION["USER_LOGIN_DATA"]["STATUS"]) ? $_SESSION["USER_LOGIN_DATA"]["STATUS"] : false;
if ($statuss != 'success') {
    ?>
    <script type="text/javascript">
        window.location.href = "index.php";
    </script>
    <?php
}

//Importing DAO Classes
require_once(DOA_ADM_DASH);
require_once(DOA_ADM_EMPS);
require_once(DOA_ADM_PROJ);
require_once(DOA_ADM_IMPT);
require_once(DOA_ADM_REPT);
require_once(DOA_ADM_PROF);
require_once(DOA_EMP_DASH);
require_once(DOA_EMP_ACTIVITY);
require_once(DOA_EMP_ENGE);
require_once(DOA_EMP_IMPT);
require_once(DOA_EMP_PROF);
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
                    if (isset($_POST['document'])) {
                        $obj = new $request[0]($_FILES);
                    } else {
                        $obj = new $request[0]($_POST);
                    }
                    echo json_encode($obj->$request[1]());
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
require_once(DOC_ROOT . INC . $_SESSION['USER_LOGIN_DATA']['MENU_FILE'] . '.php');
require_once(DOC_ROOT . INC . 'res-footer.php');
?>