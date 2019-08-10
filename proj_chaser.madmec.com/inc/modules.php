<?php
define("MODULE_0", "config.php");
require_once(MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
$module = array(
    "ADM_DASH" => preg_replace("/\s+/", " ", file_get_contents(ADM_DASH)),
    "ADM_EMPS" => preg_replace("/\s+/", " ", file_get_contents(ADM_EMPS)),
    "ADM_PROJ" => preg_replace("/\s+/", " ", file_get_contents(ADM_PROJ)),
    "ADM_IMPT" => preg_replace("/\s+/", " ", file_get_contents(ADM_IMPT)),
    "ADM_REPT" => preg_replace("/\s+/", " ", file_get_contents(ADM_REPT)),
    "ADM_PROF" => preg_replace("/\s+/", " ", file_get_contents(ADM_PROF)),
    "EMP_DASH" => preg_replace("/\s+/", " ", file_get_contents(EMP_DASH)),
    "EMP_ACTIVITY" => preg_replace("/\s+/", " ", file_get_contents(EMP_ACTIVITY)),
    "EMP_ENGE" => preg_replace("/\s+/", " ", file_get_contents(EMP_ENGE)),
    "EMP_IMPT" => preg_replace("/\s+/", " ", file_get_contents(EMP_IMPT)),
    "EMP_PROF" => preg_replace("/\s+/", " ", file_get_contents(EMP_PROF))
);
echo json_encode($module);
?>
