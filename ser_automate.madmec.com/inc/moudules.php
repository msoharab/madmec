<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	$module = array(
		"cpo" => preg_replace("/\s+/", " ", file_get_contents(MODULE_CPO)),
		"due" => preg_replace("/\s+/", " ", file_get_contents(MODULE_DUE)),
		"draw" => preg_replace("/\s+/", " ", file_get_contents(MODULE_DRAW)),
		"followup" => preg_replace("/\s+/", " ", file_get_contents(MODULE_FOLLOW_UP)),
		"incomming" => preg_replace("/\s+/", " ", file_get_contents(MODULE_INCOMMING)),
		"invoice" => preg_replace("/\s+/", " ", file_get_contents(MODULE_INVOICE)),
		"mo" => preg_replace("/\s+/", " ", file_get_contents(MODULE_MO)),
		"outgoing" => preg_replace("/\s+/", " ", file_get_contents(MODULE_OUTGOING)),
		"pcc" => preg_replace("/\s+/", " ", file_get_contents(MODULE_PCC)),
		"pcash" => preg_replace("/\s+/", " ", file_get_contents(MODULE_PCASH)),
		"pp" => preg_replace("/\s+/", " ", file_get_contents(MODULE_PP)),
		"quot" => preg_replace("/\s+/", " ", file_get_contents(MODULE_QUOT)),
		"rep" => preg_replace("/\s+/", " ", file_get_contents(MODULE_REP)),
		"req" => preg_replace("/\s+/", " ", file_get_contents(MODULE_REQ)),
		"sout" => preg_replace("/\s+/", " ", file_get_contents(MODULE_SIGNOUT)),
		"stock" => preg_replace("/\s+/", " ", file_get_contents(MODULE_STCK)),
		"user" => preg_replace("/\s+/", " ", file_get_contents(MODULE_USR)),
               "userprofile" => preg_replace("/\s+/", " ", file_get_contents(MODULE_USERPROFILE)),
                "setting" => preg_replace("/\s+/", " ", file_get_contents(MODULE_SETTING)),
                "client" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_CLIENT)),
                "admincollection" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_ADMINCOLLECTION)),
                "notify" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_NOTIFY)),
	       "orderfollowups" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_FOLLOWUP)),
            "duefollowups" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_DUEFOLLOWUP)),
            "dueadmin" => preg_replace("/\s+/", " ", file_get_contents(SU_MODULE_DUE)),
            );
	echo json_encode($module);
?>