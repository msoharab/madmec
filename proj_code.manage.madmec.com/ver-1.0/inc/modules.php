<?php
define("MODULE_0", "config.php");
require_once(MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
$module = array(
    "ADM_DASH" => preg_replace("/\s+/", " ", file_get_contents(ADM_DASH)),
    "ADM_EMPS" => preg_replace("/\s+/", " ", file_get_contents(ADM_EMPS)),
    "ADM_PROJ" => preg_replace("/\s+/", " ", file_get_contents(ADM_PROJ)),
    "ADM_IMPT" => preg_replace("/\s+/", " ", file_get_contents(ADM_IMPT)),
    "ADM_SECT" => preg_replace("/\s+/", " ", file_get_contents(ADM_SECT)),
    "ADM_REPT" => preg_replace("/\s+/", " ", file_get_contents(ADM_REPT)),
    "ADM_PROF" => preg_replace("/\s+/", " ", file_get_contents(ADM_PROF))
);
echo json_encode($module);
?>
