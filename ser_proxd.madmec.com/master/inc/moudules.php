<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	$module = array(
                "client" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_CLIENT)),
                "admincollection" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_ADMINCOLLECTION)),
                "notify" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_NOTIFY)),
	       "orderfollowups" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_FOLLOWUP)),
                "duefollowups" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_DUEFOLLOWUP)),
                "dueadmin" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_DUE)),
            );
	echo json_encode($module);
?>