<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	require_once (MODULE_USER);
	require_once (MODULE_PROJECT);
	require_once (MODULE_STOCK);
	require_once (MODULE_MORDER);
	require_once (MODULE_COLLECTION);
	require_once (MODULE_PAYMENT);
	require_once (MODULE_PETTYCASH);
	require_once (MODULE_REPORT);
	require_once (DUE);
        require_once (SETTING);
        require_once (USER_PROFILE);
	require_once (FOLLOWUP);
	require_once (MODULE_PETTYCASH);
	require_once (GENERATEPDF);

        /* SUPER ADMIN FILES INCLUDEING */
        require_once (SA_ADMIN_COLLECTION);
        require_once (SA_CLIENT);
        require_once (SA_ORDER);
        require_once (SA_DUE);
        require_once (SA_FALLOWUP);

	/* Add requirement */
	$req_add = array(
		"prj_name" => isset($_POST["reqadd"]["prj_name"]) ? $_POST["reqadd"]["prj_name"] : false,
		"cliid" => isset($_POST["reqadd"]["cliid"]) ? $_POST["reqadd"]["cliid"] : false,
		"ethid" => isset($_POST["reqadd"]["ethid"]) ? $_POST["reqadd"]["ethid"] : false,
		"cpnid" => isset($_POST["reqadd"]["cpnid"]) ? $_POST["reqadd"]["cpnid"] : false,
		"doe" 	=> isset($_POST["reqadd"]["doe"]) ? $_POST["reqadd"]["doe"] : false,
		"part" 	=> isset($_POST["reqadd"]["part"]) ? (array) $_POST["reqadd"]["part"] : false,
		"paint" => isset($_POST["reqadd"]["paint"]) ? (array) $_POST["reqadd"]["paint"] : false
	);
	/* Add quotation */
	$qut_add = array(
		"prjname" => isset($_POST["req"]["prjname"]) ? $_POST["req"]["prjname"] : false,
		"prjmid" => isset($_POST["req"]["prjmid"]) ? $_POST["req"]["prjmid"] : false,
		"requi_id" => isset($_POST["req"]["requi_id"]) ? $_POST["req"]["requi_id"] : false,
		"quot_id" => isset($_POST["req"]["quot_id"]) ? $_POST["req"]["quot_id"] : false,
		"po_id" => isset($_POST["req"]["po_id"]) ? $_POST["req"]["po_id"] : false,
		"inv_id"	=> isset($_POST["req"]["inv_id"]) ? $_POST["req"]["inv_id"] : false,
		"client_id"	=> isset($_POST["req"]["client_id"]) ?  $_POST["req"]["client_id"] : false,
		"ethno_id" => isset($_POST["req"]["ethno_id"]) ?  $_POST["req"]["ethno_id"] : false,
		"ind" => isset($_POST["req"]["ind"]) ?  $_POST["req"]["ind"] : false,
		"rep_id" => isset($_POST["req"]["rep_id"]) ?  $_POST["req"]["rep_id"] : false,
		"ref_no" => isset($_POST["req"]["ref_no"]) ?  $_POST["req"]["ref_no"] : false,
		"ethno" => isset($_POST["req"]["ethno"]) ?  $_POST["req"]["ethno"] : false,
		"rep" => isset($_POST["req"]["rep"]) ?  $_POST["req"]["rep"] : false,
		"doethn" => isset($_POST["req"]["doethn"]) ?  $_POST["req"]["doethn"] : false,
		"artype" => isset($_POST["req"]["artype"]) ?  $_POST["req"]["artype"] : false,
		"sub" => isset($_POST["req"]["sub"]) ?  $_POST["req"]["sub"] : false,
		"qdesc" => isset($_POST["req"]["qdesc"]) ?  $_POST["req"]["qdesc"] : false,
		"ptotal" => isset($_POST["req"]["ptotal"]) ?  $_POST["req"]["ptotal"] : false,
		"stc1" => isset($_POST["req"]["stc1"]) ?  $_POST["req"]["stc1"] : false,
		"ecess1" => isset($_POST["req"]["ecess1"]) ?  $_POST["req"]["ecess1"] : false,
		"hecess1" => isset($_POST["req"]["hecess1"]) ?  $_POST["req"]["hecess1"] : false,
		"nptot" => isset($_POST["req"]["nptot"]) ?  $_POST["req"]["nptot"] : false,
		"totins" => isset($_POST["req"]["totins"]) ?  $_POST["req"]["totins"] : false,
		"stc2" => isset($_POST["req"]["stc2"]) ?  $_POST["req"]["stc2"] : false,
		"ecess2" => isset($_POST["req"]["ecess2"]) ?  $_POST["req"]["ecess2"] : false,
		"hecess2" => isset($_POST["req"]["hecess2"]) ?  $_POST["req"]["hecess2"] : false,
		"ninstot" => isset($_POST["req"]["ninstot"]) ?  $_POST["req"]["ninstot"] : false,
		"totsup" => isset($_POST["req"]["totsup"]) ?  $_POST["req"]["totsup"] : false,
		"vat" => isset($_POST["req"]["vat"]) ?  $_POST["req"]["vat"] : false,
		"nsuptot" => isset($_POST["req"]["nsuptot"]) ?  $_POST["req"]["nsuptot"] : false,
		"qgtot" => isset($_POST["req"]["qgtot"]) ?  $_POST["req"]["qgtot"] : false
	);
	/* Add CPO */
	$cpo_add = array(
		"prjname" => isset($_POST["prjname"]) ? $_POST["prjname"] : false,
		"prjmid" => isset($_POST["prjmid"]) ? $_POST["prjmid"] : false,
		"requi_id" => isset($_POST["requi_id"]) ? $_POST["requi_id"] : false,
		"quot_id" => isset($_POST["quot_id"]) ? $_POST["quot_id"] : false,
		"po_id" => isset($_POST["po_id"]) ? $_POST["po_id"] : false,
		"inv_id"	=> isset($_POST["inv_id"]) ? $_POST["inv_id"] : false,
		"client_id"	=> isset($_POST["client_id"]) ?  $_POST["client_id"] : false,
		"ethno_id" => isset($_POST["ethno_id"]) ?  $_POST["ethno_id"] : false,
		"ind" => isset($_POST["ind"]) ?  $_POST["ind"] : false,
		"rep_id" => isset($_POST["rep_id"]) ?  $_POST["rep_id"] : false,
		"ref_no" => isset($_POST["ref_no"]) ?  $_POST["ref_no"] : false,
		"ethno" => isset($_POST["ethno"]) ?  $_POST["ethno"] : false,
		"rep" => isset($_POST["rep"]) ?  $_POST["rep"] : false,
		"artype" => isset($_POST["artype"]) ?  $_POST["artype"] : false,
		"cporefno" => isset($_POST["refno"]) ?  $_POST["refno"] : false,
		"doi" => isset($_POST["doi"]) ?  $_POST["doi"] : false,
		"filename" => isset($_FILES["cpo_file_upload"]["name"]) ?  $_FILES["cpo_file_upload"]["name"] : false,
		"mmtype" => isset($_FILES["cpo_file_upload"]["type"]) ?  $_FILES["cpo_file_upload"]["type"] : false,
		"tmp_name" => isset($_FILES["cpo_file_upload"]["tmp_name"]) ?  $_FILES["cpo_file_upload"]["tmp_name"] : false,
		"error" => isset($_FILES["cpo_file_upload"]["error"]) ?  $_FILES["cpo_file_upload"]["error"] : false,
		"size" => isset($_FILES["cpo_file_upload"]["size"]) ?  $_FILES["cpo_file_upload"]["size"] : false
	);
        /*  Drawing   */
        $drawing_add = array(
		"prjname" => isset($_POST["prjname"]) ? $_POST["prjname"] : false,
		"prjmid" => isset($_POST["prjmid"]) ? $_POST["prjmid"] : false,
                "projdescid" => isset($_POST["projdescid"]) ? $_POST["projdescid"] : false,
                "designerid" => isset($_POST["designerid"]) ? $_POST["designerid"] : false,
		"requi_id" => isset($_POST["requi_id"]) ? $_POST["requi_id"] : false,
		"quot_id" => isset($_POST["quot_id"]) ? $_POST["quot_id"] : false,
		"po_id" => isset($_POST["po_id"]) ? $_POST["po_id"] : false,
		"inv_id"	=> isset($_POST["inv_id"]) ? $_POST["inv_id"] : false,
		"client_id"	=> isset($_POST["client_id"]) ?  $_POST["client_id"] : false,
		"ethno_id" => isset($_POST["ethno_id"]) ?  $_POST["ethno_id"] : false,
		"ind" => isset($_POST["ind"]) ?  $_POST["ind"] : false,
		"rep_id" => isset($_POST["rep_id"]) ?  $_POST["rep_id"] : false,
		"ref_no" => isset($_POST["refno"]) ?  $_POST["refno"] : false,
		"ethno" => isset($_POST["ethno"]) ?  $_POST["ethno"] : false,
		"rep" => isset($_POST["rep"]) ?  $_POST["rep"] : false,
		"artype" => isset($_POST["artype"]) ?  $_POST["artype"] : false,
		"cporefno" => isset($_POST["refno"]) ?  $_POST["refno"] : false,
		"doi" => isset($_POST["doi"]) ?  $_POST["doi"] : false,
		"filename" => isset($_FILES["draw_file_upload"]["name"]) ?  $_FILES["draw_file_upload"]["name"] : false,
		"mmtype" => isset($_FILES["draw_file_upload"]["type"]) ?  $_FILES["draw_file_upload"]["type"] : false,
		"tmp_name" => isset($_FILES["draw_file_upload"]["tmp_name"]) ?  $_FILES["draw_file_upload"]["tmp_name"] : false,
		"error" => isset($_FILES["draw_file_upload"]["error"]) ?  $_FILES["draw_file_upload"]["error"] : false,
		"size" => isset($_FILES["draw_file_upload"]["size"]) ?  $_FILES["draw_file_upload"]["size"] : false
	);
	/* Add PP */
	$pp_add = array(
		"pname" => isset($_POST["pp"]["pname"]) ? $_POST["pp"]["pname"] : false,
		"prjname" => isset($_POST["pp"]["prjname"]) ? $_POST["pp"]["prjname"] : false,
		"prjmid" => isset($_POST["pp"]["prjmid"]) ? $_POST["pp"]["prjmid"] : false,
		"requi_id" => isset($_POST["pp"]["requi_id"]) ? $_POST["pp"]["requi_id"] : false,
		"quot_id" => isset($_POST["pp"]["quot_id"]) ? $_POST["pp"]["quot_id"] : false,
		"po_id" => isset($_POST["pp"]["po_id"]) ? $_POST["pp"]["po_id"] : false,
		"inv_id"	=> isset($_POST["pp"]["inv_id"]) ? $_POST["pp"]["inv_id"] : false,
		"client_id"	=> isset($_POST["pp"]["client_id"]) ?  $_POST["pp"]["client_id"] : false,
		"ethno_id" => isset($_POST["pp"]["ethno_id"]) ?  $_POST["pp"]["ethno_id"] : false,
		"ind" => isset($_POST["pp"]["ind"]) ?  $_POST["pp"]["ind"] : false,
		"rep_id" => isset($_POST["pp"]["rep_id"]) ?  $_POST["pp"]["rep_id"] : false,
		"ref_no" => isset($_POST["pp"]["ref_no"]) ?  $_POST["pp"]["ref_no"] : false,
		"ethno" => isset($_POST["pp"]["ethno"]) ?  $_POST["pp"]["ethno"] : false,
		"rep" => isset($_POST["pp"]["rep"]) ?  $_POST["pp"]["rep"] : false,
		"doethn" => isset($_POST["pp"]["doethn"]) ?  $_POST["pp"]["doethn"] : false,
		"artype" => isset($_POST["pp"]["artype"]) ?  $_POST["pp"]["artype"] : false,
		"mdid" => isset($_POST["pp"]["mdid"]) ?  $_POST["pp"]["mdid"] : false,
		"mngid" => isset($_POST["pp"]["mngid"]) ?  $_POST["pp"]["mngid"] : false,
		"engid" => isset($_POST["pp"]["engid"]) ?  $_POST["pp"]["engid"] : false,
		"hldid" => isset($_POST["pp"]["hldid"]) ?  $_POST["pp"]["hldid"] : false,
		"sd" => isset($_POST["pp"]["sd"]) ?  $_POST["pp"]["sd"] : false,
		"cd" => isset($_POST["pp"]["cd"]) ?  $_POST["pp"]["cd"] : false,
		"sn" => isset($_POST["pp"]["sn"]) ?  $_POST["pp"]["sn"] : false,
		"st" => isset($_POST["pp"]["st"]) ?  $_POST["pp"]["st"] : false,
		"mt" => isset($_POST["pp"]["mt"]) ?  $_POST["pp"]["mt"] : false,
		"prod" => isset($_POST["pp"]["prod"]) ?  (array) $_POST["pp"]["prod"] : false,
		"assn" => isset($_POST["pp"]["assn"]) ?  (array)  $_POST["pp"]["assn"] : false
	);
	/* Add PCC */
	$pcc_add = array(
		"pname" => isset($_POST["pcc"]["pname"]) ? $_POST["pcc"]["pname"] : false,
		"prjname" => isset($_POST["pcc"]["prjname"]) ? $_POST["pcc"]["prjname"] : false,
		"prjmid" => isset($_POST["pcc"]["prjmid"]) ? $_POST["pcc"]["prjmid"] : false,
		"prjid" => isset($_POST["pcc"]["prjid"]) ? $_POST["pcc"]["prjid"] : false,
		"requi_id" => isset($_POST["pcc"]["requi_id"]) ? $_POST["pcc"]["requi_id"] : false,
		"quot_id" => isset($_POST["pcc"]["quot_id"]) ? $_POST["pcc"]["quot_id"] : false,
		"po_id" => isset($_POST["pcc"]["po_id"]) ? $_POST["pcc"]["po_id"] : false,
		"inv_id"	=> isset($_POST["pcc"]["inv_id"]) ? $_POST["pcc"]["inv_id"] : false,
		"client_id"	=> isset($_POST["pcc"]["client_id"]) ?  $_POST["pcc"]["client_id"] : false,
		"ethno_id" => isset($_POST["pcc"]["ethno_id"]) ?  $_POST["pcc"]["ethno_id"] : false,
		"ind" => isset($_POST["pcc"]["ind"]) ?  $_POST["pcc"]["ind"] : false,
		"rep_id" => isset($_POST["pcc"]["rep_id"]) ?  $_POST["pcc"]["rep_id"] : false,
		"ref_no" => isset($_POST["pcc"]["ref_no"]) ?  $_POST["pcc"]["ref_no"] : false,
		"ethno" => isset($_POST["pcc"]["ethno"]) ?  $_POST["pcc"]["ethno"] : false,
		"rep" => isset($_POST["pcc"]["rep"]) ?  $_POST["pcc"]["rep"] : false,
		"doethn" => isset($_POST["pcc"]["doethn"]) ?  $_POST["pcc"]["doethn"] : false,
		"artype" => isset($_POST["pcc"]["artype"]) ?  $_POST["pcc"]["artype"] : false,
		"taskid" => isset($_POST["pcc"]["taskid"]) ?  $_POST["pcc"]["taskid"] : false,
		"pccn" => isset($_POST["pcc"]["pccn"]) ?  $_POST["pcc"]["pccn"] : false,
		"pccl" => isset($_POST["pcc"]["pccl"]) ?  $_POST["pcc"]["pccl"] : false,
		"pccc" => isset($_POST["pcc"]["pccc"]) ?  $_POST["pcc"]["pccc"] : false,
		"pccfc" => isset($_POST["pcc"]["pccfc"]) ?  $_POST["pcc"]["pccfc"] : false,
		"pccwh" => isset($_POST["pcc"]["pccwh"]) ?  $_POST["pcc"]["pccwh"] : false,
		"pcctw" => isset($_POST["pcc"]["pcctw"]) ?  $_POST["pcc"]["pcctw"] : false,
		"pccrv" => isset($_POST["pcc"]["pccrv"]) ?  $_POST["pcc"]["pccrv"] : false,
		"pccsdw" => isset($_POST["pcc"]["pccsdw"]) ?  $_POST["pcc"]["pccsdw"] : false,
		"pccsdm" => isset($_POST["pcc"]["pccsdm"]) ?  $_POST["pcc"]["pccsdm"] : false,
		"pccdd" => isset($_POST["pcc"]["pccdd"]) ?  $_POST["pcc"]["pccdd"] : false,
		"taskdescp" => isset($_POST["pcc"]["taskdescp"]) ?  (array) $_POST["pcc"]["taskdescp"] : false
	);
	/* Add Invoice */
	$inv_add = array(
		"prjname" => isset($_POST["inv"]["prjname"]) ? $_POST["inv"]["prjname"] : false,
		"prjmid" => isset($_POST["inv"]["prjmid"]) ? $_POST["inv"]["prjmid"] : false,
		"requi_id" => isset($_POST["inv"]["requi_id"]) ? $_POST["inv"]["requi_id"] : false,
		"quot_id" => isset($_POST["inv"]["quot_id"]) ? $_POST["inv"]["quot_id"] : false,
		"po_id" => isset($_POST["inv"]["po_id"]) ? $_POST["inv"]["po_id"] : false,
		"inv_id"	=> isset($_POST["inv"]["inv_id"]) ? $_POST["inv"]["inv_id"] : false,
		"client_id"	=> isset($_POST["inv"]["client_id"]) ?  $_POST["inv"]["client_id"] : false,
		"ethno_id" => isset($_POST["inv"]["ethno_id"]) ?  $_POST["inv"]["ethno_id"] : false,
		"ind" => isset($_POST["inv"]["ind"]) ?  $_POST["inv"]["ind"] : false,
		"rep_id" => isset($_POST["inv"]["rep_id"]) ?  $_POST["inv"]["rep_id"] : false,
		"ref_no" => isset($_POST["inv"]["ref_no"]) ?  $_POST["inv"]["ref_no"] : false,
		"ethno" => isset($_POST["inv"]["ethno"]) ?  $_POST["inv"]["ethno"] : false,
		"rep" => isset($_POST["inv"]["rep"]) ?  $_POST["inv"]["rep"] : false,
		"doethn" => isset($_POST["inv"]["doethn"]) ?  $_POST["inv"]["doethn"] : false,
		"artype" => isset($_POST["inv"]["artype"]) ?  $_POST["inv"]["artype"] : false,
		"transid" => isset($_POST["inv"]["transid"]) ?  $_POST["inv"]["transid"] : false,
		"drivid" => isset($_POST["inv"]["drivid"]) ?  $_POST["inv"]["drivid"] : false,
		"motid" => isset($_POST["inv"]["motid"]) ?  $_POST["inv"]["motid"] : false,
		"vhno" => isset($_POST["inv"]["vhno"]) ?  $_POST["inv"]["vhno"] : false,
		"dlepla" => isset($_POST["inv"]["dlepla"]) ?  $_POST["inv"]["dlepla"] : false,
		"lrno" => isset($_POST["inv"]["lrno"]) ?  $_POST["inv"]["lrno"] : false,
		"sub" => isset($_POST["inv"]["sub"]) ?  $_POST["inv"]["sub"] : false,
		"qdesc" => isset($_POST["inv"]["qdesc"]) ?  $_POST["inv"]["qdesc"] : false,
		"ptotal" => isset($_POST["inv"]["ptotal"]) ?  $_POST["inv"]["ptotal"] : false,
		"stc1" => isset($_POST["inv"]["stc1"]) ?  $_POST["inv"]["stc1"] : false,
		"ecess1" => isset($_POST["inv"]["ecess1"]) ?  $_POST["inv"]["ecess1"] : false,
		"hecess1" => isset($_POST["inv"]["hecess1"]) ?  $_POST["inv"]["hecess1"] : false,
		"nptot" => isset($_POST["inv"]["nptot"]) ?  $_POST["inv"]["nptot"] : false,
		"totins" => isset($_POST["inv"]["totins"]) ?  $_POST["inv"]["totins"] : false,
		"stc2" => isset($_POST["inv"]["stc2"]) ?  $_POST["inv"]["stc2"] : false,
		"ecess2" => isset($_POST["inv"]["ecess2"]) ?  $_POST["inv"]["ecess2"] : false,
		"hecess2" => isset($_POST["inv"]["hecess2"]) ?  $_POST["inv"]["hecess2"] : false,
		"ninstot" => isset($_POST["inv"]["ninstot"]) ?  $_POST["inv"]["ninstot"] : false,
		"totsup" => isset($_POST["inv"]["totsup"]) ?  $_POST["inv"]["totsup"] : false,
		"vat" => isset($_POST["inv"]["vat"]) ?  $_POST["inv"]["vat"] : false,
		"nsuptot" => isset($_POST["inv"]["nsuptot"]) ?  $_POST["inv"]["nsuptot"] : false,
		"qgtot" => isset($_POST["inv"]["qgtot"]) ?  $_POST["inv"]["qgtot"] : false
	);
        /* Change Password */
        $channgepass=array(
            "newpassword" => isset($_POST["details"]["newpassword"]) ?  $_POST["details"]["newpassword"] : false,
            "confirmpassword" => isset($_POST["details"]["confirmpassword"]) ?  $_POST["details"]["confirmpassword"] : false,
        );
	/* Add collection */
	$col_add = array(
		"uindex" => isset($_POST["colls"]["uindex"]) ? $_POST["colls"]["uindex"] : false,
		"retailer" => isset($_POST["colls"]["uid"]) ? $_POST["colls"]["uid"] : false,
		"date" => isset($_POST["colls"]["pdate"]) ? $_POST["colls"]["pdate"] : false,
		"pay_ac" => isset($_POST["colls"]["pay_ac"]) ? $_POST["colls"]["pay_ac"] : false,
		"mop" => isset($_POST["colls"]["mop"]) ? $_POST["colls"]["mop"] : false,
		"ac_id" => isset($_POST["colls"]["ac_id"]) ? $_POST["colls"]["ac_id"] : false,
		"account" => isset($_POST["colls"]["account"]) ? $_POST["colls"]["account"] : false,
		"amount" => isset($_POST["colls"]["pamt"]) ? $_POST["colls"]["pamt"] : false,
		"rmk" => isset($_POST["colls"]["rmk"]) ? $_POST["colls"]["rmk"] : false
	);
	/* Add project Collection */
	$prof_col_add = array(
		"clientid" => isset($_POST["projcolls"]["clientid"]) ? $_POST["projcolls"]["clientid"] : false,
		"projid" => isset($_POST["projcolls"]["projid"]) ? $_POST["projcolls"]["projid"] : false,
		"amount" => isset($_POST["projcolls"]["amount"]) ? $_POST["projcolls"]["amount"] : false,
		"dateofpay" => isset($_POST["projcolls"]["dateofpay"]) ? $_POST["projcolls"]["dateofpay"] : false,
		"remark" => isset($_POST["projcolls"]["remark"]) ? $_POST["projcolls"]["remark"] : false,
		"cdue" => isset($_POST["projcolls"]["cdue"]) ? $_POST["projcolls"]["cdue"] : false,
		"totalamountt" => isset($_POST["projcolls"]["totalamountt"]) ? $_POST["projcolls"]["totalamountt"] : false,
		"duedate" => isset($_POST["projcolls"]["duedate"]) ? $_POST["projcolls"]["duedate"] : false,
		"dueamount" => isset($_POST["projcolls"]["dueamount"]) ? $_POST["projcolls"]["dueamount"] : false,
		"followupdates" =>isset($_POST["projcolls"]["folldates"]) ? $_POST["projcolls"]["folldates"] : false
	);
	/* POST add payments */
	$pay_add = array(
		"uindex" => isset($_POST["payms"]["uindex"]) ? $_POST["payms"]["uindex"] : false,
		"supplier" => isset($_POST["payms"]["uid"]) ? $_POST["payms"]["uid"] : false,
		"date" => isset($_POST["payms"]["pdate"]) ? $_POST["payms"]["pdate"] : false,
		"pay_ac" => isset($_POST["payms"]["pay_ac"]) ? $_POST["payms"]["pay_ac"] : false,
		"mop" => isset($_POST["payms"]["mop"]) ? $_POST["payms"]["mop"] : false,
		"ac_id" => isset($_POST["payms"]["ac_id"]) ? $_POST["payms"]["ac_id"] : false,
		"account" => isset($_POST["payms"]["account"]) ? $_POST["payms"]["account"] : false,
		"amount" => isset($_POST["payms"]["pamt"]) ? $_POST["payms"]["pamt"] : false,
		"availpettycash" =>isset($_POST["payms"]["availpettycash"]) ? $_POST["payms"]["availpettycash"] : false,
		"rmk" => isset($_POST["payms"]["rmk"]) ? $_POST["payms"]["rmk"] : false
	);
	/* Due payments */
	$pay_pdue=array(
		"dueid" => isset($_POST["payduecash"]["dueid"]) ? $_POST["payduecash"]["dueid"] : false,
		"projid" => isset($_POST["payduecash"]["projid"]) ? $_POST["payduecash"]["projid"] : false,
		"clientid" => isset($_POST["payduecash"]["clientid"]) ? $_POST["payduecash"]["clientid"] : false,
		"dueamount" => isset($_POST["payduecash"]["dueamount"]) ? $_POST["payduecash"]["dueamount"] : false
	);
	/* User Type */
	$utype = array(
		"utype" => isset($_POST["utype"]) ? $_POST["utype"] : false,
		"uid" => isset($_POST["uid"]) ? $_POST["uid"] : false,
		"utyp" => isset($_POST["utyp"]) ? (array) $_POST["utyp"] : false
	);
	/* Add user */
	$usr_add = array(
		"user_type" => isset($_POST["usradd"]["user_type"]) ? $_POST["usradd"]["user_type"] : false,
		"name" => isset($_POST["usradd"]["name"]) ? $_POST["usradd"]["name"] : false,
		"crname" => isset($_POST["usradd"]["crname"]) ? (array) $_POST["usradd"]["crname"] : false,
		"acs" => generateRandomString(), "email" => isset($_POST["usradd"]["email"]) ? (array) $_POST["usradd"]["email"] : false,
		"name" => isset($_POST["usradd"]["name"]) ? $_POST["usradd"]["name"] : false,
		"crname" => isset($_POST["usradd"]["crname"]) ? (array) $_POST["usradd"]["crname"] : false,
		"pan" => isset($_POST["usradd"]["pan"]) ? (array) $_POST["usradd"]["pan"] : false,
		"tin" => isset($_POST["usradd"]["tin"]) ? (array) $_POST["usradd"]["tin"] : false,
		"svt" => isset($_POST["usradd"]["svt"]) ? (array) $_POST["usradd"]["svt"] : false,
		"acs" => generateRandomString(), "email" => isset($_POST["usradd"]["email"]) ? (array) $_POST["usradd"]["email"] : false,
		"cellnumbers" => isset($_POST["usradd"]["cellnumbers"]) ? (array) $_POST["usradd"]["cellnumbers"] : false,
		"accounts" => isset($_POST["usradd"]["accounts"]) ? (array) $_POST["usradd"]["accounts"] : false,
		"products" => isset($_POST["usradd"]["products"]) ? (array) $_POST["usradd"]["products"] : false,
		"country" => isset($_POST["usradd"]["country"]) ? $_POST["usradd"]["country"] : false,
		"countryCode" => isset($_POST["usradd"]["countryCode"]) ? $_POST["usradd"]["countryCode"] : false,
		"province" => isset($_POST["usradd"]["province"]) ? $_POST["usradd"]["province"] : false,
		"provinceCode" => isset($_POST["usradd"]["provinceCode"]) ? $_POST["usradd"]["provinceCode"] : false,
		"district" => isset($_POST["usradd"]["district"]) ? $_POST["usradd"]["district"] : false,
		"city_town" => isset($_POST["usradd"]["city_town"]) ? $_POST["usradd"]["city_town"] : false,
		"st_loc" => isset($_POST["usradd"]["st_loc"]) ? $_POST["usradd"]["st_loc"] : false,
		"addrsline" => isset($_POST["usradd"]["addrsline"]) ? $_POST["usradd"]["addrsline"] : false,
		"tphone" => isset($_POST["usradd"]["tphone"]) ? $_POST["usradd"]["tphone"] : false,
		"pcode" => isset($_POST["usradd"]["pcode"]) ? $_POST["usradd"]["pcode"] : false,
		"zipcode" => isset($_POST["usradd"]["zipcode"]) ? $_POST["usradd"]["zipcode"] : false,
		"website" => isset($_POST["usradd"]["website"]) ? $_POST["usradd"]["website"] : false,
		"gmaphtml" => isset($_POST["usradd"]["gmaphtml"]) ? $_POST["usradd"]["gmaphtml"] : false,
		"timezone" => isset($_POST["usradd"]["timezone"]) ? $_POST["usradd"]["timezone"] : false,
		"lat" => isset($_POST["usradd"]["lat"]) ? $_POST["usradd"]["lat"] : false,
		"lon" => isset($_POST["usradd"]["lon"]) ? $_POST["usradd"]["lon"] : false,
		"password" => generateRandomString()
	);
	/* List DOCS */
	$lst_doc = array(
		"display" => isset($_POST["display"]) ? $_POST["display"] : false,
		"what" => isset($_POST["what"]) ? $_POST["what"] : false
	);
	/* Report */
	$report = array(
		"dfrom" => isset($_POST["rep"]["dfrom"]) ? $_POST["rep"]["dfrom"] : false,
		"dto" => isset($_POST["rep"]["dto"]) ? $_POST["rep"]["dto"] : false
	);
        $billingdetails= array(
            "companyname" => isset($_POST["details"]["companyname"]) ? $_POST["details"]["companyname"] : false,
            "companyaddress" => isset($_POST["details"]["companyaddress"]) ? $_POST["details"]["companyaddress"] : false,
            "companyemail" => isset($_POST["details"]["companyemail"]) ? $_POST["details"]["companyemail"] : false,
            "companymobile" => isset($_POST["details"]["companymobile"]) ? $_POST["details"]["companymobile"] : false,
            "termsncondition" => isset($_POST["details"]["termsncondition"]) ? $_POST["details"]["termsncondition"] : false,
            "footermsg" => isset($_POST["details"]["footermsg"]) ? $_POST["details"]["footermsg"] : false,
            "companylandline" => isset($_POST["details"]["companylandline"]) ? $_POST["details"]["companylandline"] : false,
            "check" => isset($_POST["details"]["check"]) ? $_POST["details"]["check"] : false,
        );
	/* POST Variables pool */
	$parameters = array(
		"autoloader"            => isset($_POST["autoloader"]) 		? $_POST["autoloader"] 		: false,
		"action" 	 	=> isset($_POST["action"]) 			? $_POST["action"]			: false,
                "type"                  => isset($_POST['type']) ? $_POST['type'] : false,
		"soruce" 	 	=> isset($_POST["soruce"]) 			? $_POST["soruce"]			: false,
		"utype" 	 	=> isset($utype) 					? $utype					: false,
		"req_add" 	 	=> isset($req_add) 					? (array) $req_add			: false,
		"qut_add" 	 	=> isset($qut_add) 					? (array) $qut_add			: false,
		"drawing_add"	=> isset($drawing_add)				? (array) $drawing_add		: false,
		"cpo_add" 	 	=> isset($cpo_add) 					? (array) $cpo_add			: false,
		"pp_add" 	 	=> isset($pp_add) 					? (array) $pp_add			: false,
		"pcc_add" 	 	=> isset($pcc_add) 					? (array) $pcc_add			: false,
		"inv_add" 	 	=> isset($inv_add) 					? (array) $inv_add			: false,
		"col_add" 	 	=> isset($col_add) 					? (array) $col_add			: false,
		"prof_col_add" 	=> isset($prof_col_add) 			? (array) $prof_col_add		: false,
		"pay_add" 		=> isset($pay_add) 					? (array) $pay_add			: false,
		"pay_pdue" 		=> isset($pay_pdue) 				? (array) $pay_pdue			: false,
		"usr_add" 		=> isset($usr_add) 					? (array) $usr_add			: false,
		"lst_doc" 	 	=> isset($lst_doc) 					? (array) $lst_doc			: false,
		"report" 	 	=> isset($report) 					? (array) $report			: false,
                "billingdetails"        => isset($billingdetails) 		? (array) $billingdetails			: false,
                "changepassword"        =>  isset($channgepass) ? (array)$channgepass : false,
	);
        if(isset($_POST['action1']))
            $parameters['action']=$_POST['action1'];

	function main($parameters){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if(!ValidateAdmin()){
					session_destroy();
					echo "logout";
				}else{
					selectDB($_SESSION["USER_LOGIN_DATA"]['slavedb'],$link);
					switch ($parameters["action"]) {
						case "fetchUnits":{
								echo(json_encode(fetchUnits()));
							}
						break;
						case "fetchProducts":{
								echo(json_encode(getProducts()));
							}
						break;
						case "fetchMOPTypes":{
                                                        $param=isset($_POST["incoming"]) ? $_POST["incoming"]	: false;
								echo(json_encode(getMOPTypes($param)));
							}
						break;
						case "fetchBankAccount":{
								echo(json_encode(getBankAccounts($parameters)));
							}
						break;
						case "fetchAvailablePettyCash":{
							echo(json_encode(fetchAvailablePettyCash()));
						}
						break;
						case "logout":{
								session_destroy();
								echo "logout";
							}
						break;
						/*
							START project.php
						*/
						case "fetchPrjStatus":{
								echo(json_encode(getPrjStatus()));
							}
						break;
						case "addRequirements":{
								$requi = new project($parameters["req_add"]);
								echo(json_encode($requi->addRequi()));
							}
						break;
						case "fetchRequirement":{
								$quot = new project();
								echo(json_encode($quot->fetchRequirement()));
							}
						break;
						case "generateQuot":{
								$quot = new project($parameters["qut_add"]);
								echo json_encode($quot->generateQuot());
							}
						break;
						case "uploadCPO":{
								// echo print_r($_POST).'<br />';
								// echo print_r($_FILES).'<br />';
								$cpo = new project($parameters["cpo_add"]);
								echo json_encode($cpo->uploadCPO());
							}
						break;
                                                case "uploadDrawing":{
								// echo print_r($_POST).'<br />';
								// echo print_r($_FILES).'<br />';
								$cpo = new project($parameters["drawing_add"]);
								echo json_encode($cpo->uploadDrawing());
							}
						break;
						case "createProjectPlan":{
								$pp = new project($parameters["pp_add"]);
								echo json_encode($pp->createProjectPlan());
							}
						break;
						case "addPCC":{
								$pcc = new project($parameters["pcc_add"]);
								echo json_encode($pcc->addPCC());
							}
						break;
                                                /* Billing Fetails */
                                                case "addbillingdetails":{
								$stn = new setting($parameters["billingdetails"]);
								echo json_encode($stn->addBillingDetails());
							}
						break;
                                                case "fetchbillingdetails":{
								$stn = new setting();
								echo json_encode($stn->fetchBillingDetails());
							}
						break;
						case "fetchModeOfTransport":{
								echo(json_encode(fetchModeOfTransport()));
							}
						break;
						case "generateInvoice":{
								$inv = new project($parameters["inv_add"]);
								echo json_encode($inv->generateInvoice());
							}
						break;
						case "listDOCS":{
								$docs = new project($parameters["lst_doc"]);
								echo(json_encode($docs->ListDocs()));
							}
						break;
						case "generateReport":{
								$rep = new report($parameters["report"]);
								// echo(json_encode($rep->generateReport()));
								$rep->generateReport();
							}
						break;
						/*
							END project.php
						*/
						/*
							START collection.php
						*/
						case "addCollection":{
								$sale = new collection($parameters["col_add"]);
								echo json_encode($sale->addIncommingAmt());
							}
						break;
						case "addProjCollection":{
								$ppayment = new collection($parameters["prof_col_add"]);
								echo json_encode($ppayment->addProjCollection());
							}
						break;
						/*
							START payment.php
						*/
						case "addPayment":{
								$payment = new payment($parameters["pay_add"]);
								echo json_encode($payment->addOutgoingAmt());
							}
						break;
						case "fetchPaymentUsers":{
								$jsonutype = getPaymentUsers();
								echo(json_encode($jsonutype));
							}
						break;
						/*
							END payment.php
						*/
						/*
							START due.php
						*/
						case "projdue" : {
							$due=new due();
							echo json_encode($due->projduelist());
						}
						break;
						case "fetchfollowup" : {
							$follow=new followup();
							echo json_encode($follow->fetchfollowups());
						}
						break;
						case "payprojdueamount" : {
							$due = new due($parameters["pay_pdue"]);
							echo json_encode($due->payduecash());
						}
						break;
						/*
							START user.php
						*/
						case "fetchUserTypes":{
								echo(json_encode(getUserTypes()));
							}
						break;
						case "fetchUsers":{
								$jsonutype = getUsers($parameters["utype"]);
								echo(json_encode($jsonutype));
							}
						break;
						case "userAdd":{
								$user = new user($parameters["usr_add"]);
								echo (json_encode($user->addUser()));
							}
						break;
                                                case "fetchDesigner":{
							$user = new user();
							echo json_encode($user->fetchDesigner());
						}
						break;
						case "DisplayUserList":{
							$user = new user();
							$_SESSION['listofusers'] = $user->listUser();
							if(isset($_SESSION['listofusers']) && sizeof($_SESSION['listofusers']) > 0){
								$_SESSION["initial"] = 0;
								$_SESSION["final"] = 19;
								$para["initial"] = $_SESSION["initial"];
								$para["final"] = $_SESSION["final"];
								echo json_encode($user->displayUserList($para));
							}
							else{
								$para["initial"] = 0;
								$para["final"] = 0;
								echo json_encode($user->displayUserList($para));
							}
						}
						break;
						case "DisplayUpdatedUserList":{
							$user = new user();
							if(isset($_SESSION["initial"]) && isset($_SESSION["final"])){
								if(isset($_SESSION['listofusers']) && sizeof($_SESSION['listofusers']) > 0){
									if($_SESSION["final"] >= sizeof($_SESSION['listofusers'])){
										unset($_SESSION["initial"]);
										unset($_SESSION["final"]);
										$temp[] = array(
											"html" => '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>',
											"uid"			=> 0,
											"sr"			=> '',
											"alertUSRDEL"	=> '',
											"usrdelOk" 		=> '',
											"usrdelCancel" 	=> ''
										);
										echo json_encode($temp);
									}
									else{
										$_SESSION["initial"] = $_SESSION["final"]+1;
										$_SESSION["final"] += 20;
										$para["initial"] = $_SESSION["initial"];
										$para["final"] = $_SESSION["final"];
										echo json_encode($user->displayUserList($para));
									}
								}
							}
						}
						break;
						case "deleteUser":{
							$patty_delete_sale = array(
								"entry" 	=> isset($_POST["ptydeletesale"]["entid"]) 		? $_POST["ptydeletesale"]["entid"]	: false
							);
							$user = new user($patty_delete_sale);
							echo $user->deleteUser();
						}
						break;
						case "loadEmailIdForm":{
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]			: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]			: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]		: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]	: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]			: false,
								"email"		=> isset($_POST["det"]["email"]) 	? $_POST["det"]["email"]		: false,
								"msgDiv"	=> isset($_POST["det"]["msgDiv"]) 	? $_POST["det"]["msgDiv"]		: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]			: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]		: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]		: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]		: false
							);
							$user = new user($det);
							echo (json_encode($user->loadEmailIdForm()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "editEmailId":{
							$emailids = array(
								"emailids"	=> isset($_POST["emailids"]) 	? $_POST["emailids"]	: false
							);
							$user = new user($emailids);
							echo (json_encode($user->editEmailId()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "deleteEmailId":{
							$emailid = array(
								"eid"	=> isset($_POST["eid"]) 	? $_POST["eid"]	: false
							);
							$user = new user($emailid);
							echo $user->deleteEmailId();
						}
						break;
						case "listEmailIds":{
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$user = new user($para);
							echo $user->listEmailIds();
						}
						break;
                                                case "loadPanForm":{
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]			: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]			: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]		: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]	: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]			: false,
								"pan"		=> isset($_POST["det"]["pan"]) 	? $_POST["det"]["pan"]		: false,
								"msgDiv"	=> isset($_POST["det"]["msgDiv"]) 	? $_POST["det"]["msgDiv"]		: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]			: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]		: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]		: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]		: false
							);
							$user = new user($det);
							echo (json_encode($user->loadPanForm()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "editPan":{
							$pans = array(
								"pans"	=> isset($_POST["pans"]) 	? $_POST["pans"]	: false
							);
							$user = new user($pans);
							echo (json_encode($user->editPan()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "deletePan":{
							$pan = array(
								"pid"	=> isset($_POST["pid"]) 	? $_POST["pid"]	: false
							);
							$user = new user($pan);
							echo $user->deletePan();
						}
						break;

						case "listPans":{
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$user = new user($para);
							echo $user->listPans();
						}
						break;
                                                case "loadStcForm":{
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]			: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]			: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]		: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]	: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]			: false,
								"stc"		=> isset($_POST["det"]["stc"]) 	? $_POST["det"]["stc"]		: false,
								"msgDiv"	=> isset($_POST["det"]["msgDiv"]) 	? $_POST["det"]["msgDiv"]		: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]			: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]		: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]		: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]		: false
							);
							$user = new user($det);
							echo (json_encode($user->loadStcForm()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "editStc":{
							$stcs = array(
								"stcs"	=> isset($_POST["stcs"]) 	? $_POST["stcs"]	: false
							);
							$user = new user($stcs);
							echo (json_encode($user->editStc()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "deleteStc":{
							$pan = array(
								"sid"	=> isset($_POST["pid"]) 	? $_POST["pid"]	: false
							);
							$user = new user($pan);
							echo $user->deleteStc();
						}
						break;
						case "listStcs":{
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$user = new user($para);
							echo $user->listStcs();
						}
						break;
                                                case "loadCrnForm":{
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]			: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]			: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]		: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]	: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]			: false,
								"stc"		=> isset($_POST["det"]["stc"]) 	? $_POST["det"]["stc"]		: false,
								"msgDiv"	=> isset($_POST["det"]["msgDiv"]) 	? $_POST["det"]["msgDiv"]		: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]			: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]		: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]		: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]		: false
							);
							$user = new user($det);
							echo (json_encode($user->loadCrnForm()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "editCrn":{
							$stcs = array(
								"stcs"	=> isset($_POST["stcs"]) 	? $_POST["stcs"]	: false
							);
							$user = new user($stcs);
							echo (json_encode($user->editCrn()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "deleteCrn":{
							$pan = array(
								"sid"	=> isset($_POST["pid"]) 	? $_POST["pid"]	: false
							);
							$user = new user($pan);
							echo $user->deleteCrn();
						}
						break;
						case "listCrns":{
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$user = new user($para);
							echo $user->listCrns();
						}
						break;
                                                 case "loadTinForm":{
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]			: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]			: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]		: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]	: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]			: false,
								"tin"		=> isset($_POST["det"]["tin"]) 	? $_POST["det"]["tin"]		: false,
								"msgDiv"	=> isset($_POST["det"]["msgDiv"]) 	? $_POST["det"]["msgDiv"]		: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]			: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]		: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]		: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]		: false
							);
							$user = new user($det);
							echo (json_encode($user->loadTinForm()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "editTin":{
							$stcs = array(
								"tins"	=> isset($_POST["tins"]) 	? $_POST["tins"]	: false
							);
							$user = new user($stcs);
							echo (json_encode($user->editTin()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "deleteTin":{
							$pan = array(
								"tid"	=> isset($_POST["pid"]) 	? $_POST["pid"]	: false
							);
							$user = new user($pan);
							echo $user->deleteTin();
						}
						break;
						case "listTins":{
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$user = new user($para);
							echo $user->listTins();
						}
						break;
						case "loadCellNumForm":{
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]		: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]		: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]	: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]		: false,
								"cnumber"	=> isset($_POST["det"]["cnumber"]) 	? $_POST["det"]["cnumber"]	: false,
								"msgDiv"	=> isset($_POST["det"]["msgDiv"]) 	? $_POST["det"]["msgDiv"]	: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]		: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]	: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]	: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]	: false
							);
							$user = new user($det);
							echo (json_encode($user->loadCellNumForm()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "editCellNum":{
							$cnums = array(
								"CellNums"	=> isset($_POST["CellNums"]) 		? $_POST["CellNums"]		: false
							);
							$user = new user($cnums);
							echo (json_encode($user->editCellNum()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "deleteCellNum":{
							$cnums = array(
								"eid"	=> isset($_POST["eid"]) 		? $_POST["eid"]		: false
							);
							$user = new user($cnums);
							echo $user->deleteCellNum();
						}
						break;
						case "listCellNums":{
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$user = new user($para);
							echo $user->listCellNums();
						}
						break;
						case "loadPrdNameForm":{
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]		: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]		: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]	: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]		: false,
								"prdname"	=> isset($_POST["det"]["prdname"]) 	? $_POST["det"]["prdname"]	: false,
								"msgDiv"	=> isset($_POST["det"]["msgDiv"]) 	? $_POST["det"]["msgDiv"]	: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]		: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]	: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]	: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]	: false
							);
							$user = new user($det);
							echo (json_encode($user->loadPrdNameForm()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "editPrdName":{
							$prdnames = array(
								"PrdNames"	=> isset($_POST["PrdNames"]) 	? $_POST["PrdNames"]	: false
							);
							$user = new user($prdnames);
							echo (json_encode($user->editPrdName()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "deletePrdName":{
							$prdnames = array(
								"eid"	=> isset($_POST["eid"]) 	? $_POST["eid"]	: false
							);
							$user = new user($prdnames);
							echo $user->deletePrdName();
						}
						break;
						case "listPrdNames":{
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$user = new user($para);
							echo $user->listPrdNames();
						}
						break;
						case "loadBankAcForm":{
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]			: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]			: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]		: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]	: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]			: false,
								"bankname"	=> isset($_POST["det"]["bankname"]) ? $_POST["det"]["bankname"]		: false,
								"nmsg"		=> isset($_POST["det"]["nmsg"]) 	? $_POST["det"]["nmsg"]			: false,
								"accno"		=> isset($_POST["det"]["accno"]) 	? $_POST["det"]["accno"]		: false,
								"nomsg"		=> isset($_POST["det"]["nomsg"]) 	? $_POST["det"]["nomsg"]		: false,
								"braname"	=> isset($_POST["det"]["braname"]) 	? $_POST["det"]["braname"]		: false,
								"bnmsg"		=> isset($_POST["det"]["bnmsg"]) 	? $_POST["det"]["bnmsg"]		: false,
								"bracode"	=> isset($_POST["det"]["bracode"]) 	? $_POST["det"]["bracode"]		: false,
								"bcmsg"		=> isset($_POST["det"]["bcmsg"]) 	? $_POST["det"]["bcmsg"]		: false,
								"IFSC"		=> isset($_POST["det"]["IFSC"]) 	? $_POST["det"]["IFSC"]			: false,
								"IFSCmsg"	=> isset($_POST["det"]["IFSCmsg"]) 	? $_POST["det"]["IFSCmsg"]		: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]			: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]		: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]		: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]		: false
							);
							$user = new user($det);
							echo (json_encode($user->loadBankAcForm()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "editBankAc":{
							$bankacs = array(
								"BankAcs"	=> isset($_POST["BankAcs"]) 		? $_POST["BankAcs"]		: false
							);
							$user = new user($bankacs);
							echo (json_encode($user->editBankAc()));
							// echo print_r($_SESSION["list_of_users"]);
						}
						break;
						case "deleteBankAc":{
							$bankacs = array(
								"eid"	=> isset($_POST["eid"]) 		? $_POST["eid"]		: false
							);
							$user = new user($bankacs);
							echo $user->deleteBankAc();
						}
						break;
						case "listBankAcs":{
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$user = new user($para);
							echo $user->listBankAcs();
						}
						break;
						case "editAddress":{
							$address = array(
								"index"			=> isset($_POST["address"]["index"]) 		? $_POST["address"]["index"]		: false,
								"sindex"		=> isset($_POST["address"]["listindex"]) 	? $_POST["address"]["listindex"]	: false,
								"uid"			=> isset($_POST["address"]["uid"]) 			? $_POST["address"]["uid"]			: false,
								"country"		=> isset($_POST["address"]["country"]) 		? $_POST["address"]["country"]		: false,
								"countryCode"	=> isset($_POST["address"]["countryCode"]) 	? $_POST["address"]["countryCode"]	: false,
								"province"		=> isset($_POST["address"]["province"]) 	? $_POST["address"]["province"]		: false,
								"provinceCode"	=> isset($_POST["address"]["provinceCode"]) ? $_POST["address"]["provinceCode"]	: false,
								"district"		=> isset($_POST["address"]["district"]) 	? $_POST["address"]["district"]		: false,
								"city_town"		=> isset($_POST["address"]["city_town"]) 	? $_POST["address"]["city_town"]	: false,
								"st_loc"		=> isset($_POST["address"]["st_loc"]) 		? $_POST["address"]["st_loc"]		: false,
								"addrsline"		=> isset($_POST["address"]["addrsline"]) 	? $_POST["address"]["addrsline"]	: false,
								"zipcode"		=> isset($_POST["address"]["zipcode"]) 		? $_POST["address"]["zipcode"]		: false,
								"website"		=> isset($_POST["address"]["website"]) 		? $_POST["address"]["website"]		: false,
								"gmaphtml"		=> isset($_POST["address"]["gmaphtml"]) 	? $_POST["address"]["gmaphtml"]		: false,
								"timezone"		=> isset($_POST["address"]["timezone"]) 	? $_POST["address"]["timezone"]		: false,
								"lat"			=> isset($_POST["address"]["lat"]) 			? $_POST["address"]["lat"]			: false,
								"lon"			=> isset($_POST["address"]["lon"]) 			? $_POST["address"]["lon"]			: false
							);
							$user = new user($address);
							echo $user->editAddress();
						}
						break;
						case "listAddress":{
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$user = new user($para);
							echo $user->listAddress();
						}
						break;
						case "editBasicInfo":{
							$para = array(
								"uid" 			=> isset($_POST["binfo"]["uid"]) 		? $_POST["binfo"]["uid"]				: false,
								"index" 		=> isset($_POST["binfo"]["index"]) 		? $_POST["binfo"]["index"]				: false,
								"sindex" 		=> isset($_POST["binfo"]["listindex"]) 	? $_POST["binfo"]["listindex"]			: false,
								"user_type" 	=> isset($_POST["binfo"]["user_type"]) 	? $_POST["binfo"]["user_type"]			: false,
								"name" 			=> isset($_POST["binfo"]["name"]) 		? $_POST["binfo"]["name"]				: false,
								"otamt"			=> isset($_POST["binfo"]["otamt"]) 		? $_POST["binfo"]["otamt"]				: false,
								"acs" 			=> generateRandomString(),
								"pcode"			=> isset($_POST["binfo"]["pcode"]) 		? $_POST["binfo"]["pcode"]				: false,
								"tphone"		=> isset($_POST["binfo"]["tphone"]) 	? $_POST["binfo"]["tphone"]				: false
							);
							$user = new user($para);
							echo $user->editBasicInfo();
						}
						break;
						/*
							END user.php
						*/
                                                /* Billing Details  */
                                                case "compnaydetails" :
                                                {
                                                    if(sizeof($_FILES))
                                                     {
                                                    $temp_name= isset($_FILES["file"]['tmp_name'])?$_FILES["file"]['tmp_name'] : false;
                                                        $ext= GetImageExtension(isset($_FILES["file"]['type']) ? $_FILES["file"]['type'] : 'jpg');
                                                        $imagename=time().'.jpg';
                                        //                $target_path = DOC_ROOT."assets/img/".$imagename;
//                                                        echo print_r($_SESSION["USER_LOGIN_DATA"]);
                                                        if($_SESSION["USER_LOGIN_DATA"]["USER_DIRECTORY"] != ''){
                                                            $target_path = ASSET_DIR.$_SESSION["USER_LOGIN_DATA"]['USER_DIRECTORY'].'/'.$imagename;
                                                            if(move_uploaded_file($temp_name, $target_path)) {

                                                                if(file_exists($target_path)){
                                                                   $companydetails=array(
                                                                        "companyname" => isset($_POST["companyname"]) ? $_POST["companyname"] : false,
                                                                        "companyaddress" => isset($_POST["companyaddress"]) ? $_POST["companyaddress"] : false,
                                                                        "companyemail" => isset($_POST["companyemail"]) ? $_POST["companyemail"] : false,
                                                                        "companymobile" => isset($_POST["companymobile"]) ? $_POST["companymobile"] : false,
                                                                        "termsncondition" => isset($_POST["termsncondition"]) ? $_POST["termsncondition"] : false,
                                                                        "footermsg" => isset($_POST["footermsg"]) ? $_POST["footermsg"] : false,
                                                                        "companylandline" => isset($_POST["companylandline"]) ? $_POST["companylandline"] : false,
                                                                        "check" => isset($_POST["check"]) ? $_POST["check"] : false,
                                                                        "logopath" => $target_path,
                                                                    );
                                                                     $stn = new setting($companydetails);
                                                                     echo json_encode($stn->addBillingDetails());
                                                                     exit(0);
                                                                }
                                                            }
                                                            else{
                                                                exit("Error While uploading image on the server");
                                                            }
                                                        }else{
                                                            echo 'Directory not found';
                                                        }
                                                            }
                                                         $companydetails=array(
                                                            "companyname" => isset($_POST["companyname"]) ? $_POST["companyname"] : false,
                                                            "companyaddress" => isset($_POST["companyaddress"]) ? $_POST["companyaddress"] : false,
                                                            "companyemail" => isset($_POST["companyemail"]) ? $_POST["companyemail"] : false,
                                                            "companymobile" => isset($_POST["companymobile"]) ? $_POST["companymobile"] : false,
                                                            "termsncondition" => isset($_POST["termsncondition"]) ? $_POST["termsncondition"] : false,
                                                            "footermsg" => isset($_POST["footermsg"]) ? $_POST["footermsg"] : false,
                                                            "companylandline" => isset($_POST["companylandline"]) ? $_POST["companylandline"] : false,
                                                            "check" => isset($_POST["check"]) ? $_POST["check"] : false,
                                                            "logopath" => "",
                                                        );
                                                         $stn = new setting($companydetails);
                                                         echo json_encode($stn->addBillingDetails());
                                                }
                                                break;

						/*
							START stock.php
						*/
						case "fetchItems":{
								echo(json_encode(fetchItems()));
							}
						break;
						case "fetchorderItems":{
								$material_order = new materialorder();
								echo(json_encode($material_order->fetchorderItems()));
							}
						break;
						case "fetchVendor":{
								$material_order = new materialorder();
								echo(json_encode($material_order->fetchVendors()));
							}
						break;
						case "fetchmaterialordered":{
								$material_order = new materialorder();
								echo(json_encode($material_order->fetchmaterialordered()));
							}
						break;
						case "fetchAvaliableStock":{
								$stock = new stock();
								echo(json_encode($stock->fetchAvaliableStocks()));
							}
						break;
						case "moentrydelete":{
								$orderedid = isset($_POST['attr']) ? $_POST['attr'] : false;
								$materialorder = new materialorder();
								echo $materialorder->delete_mo_descb_entry($orderedid);
							}
						break;
                                                case "mopdfgen":{
								$orderedid = isset($_POST['attr']) ? $_POST['attr'] : false;
								$materialorder = new materialorder();
								echo $materialorder->GeneratePDFMO($orderedid);
							}
						break;
						case "updatestockin":{
								$stockindetail = array(
									"moid" => isset($_POST['stockindetails']['moid']) ? $_POST['stockindetails']['moid'] : false,
									"qtyin" => isset($_POST['stockindetails']['qtyyin']) ? $_POST['stockindetails']['qtyyin'] : false
								);
								$materialorder = new materialorder($stockindetail);
								echo $materialorder->updatestockin();
							}
						break;
						case "fetchvendorOrderedDeails":{
								$moid = isset($_POST['attr']) ? $_POST['attr'] : false;
								$materialorder = new materialorder();
								echo(json_encode($materialorder->fetchvendorOrderedDeails($moid)));
							}
						break;
						case "modetails":{
								$materialorder = new materialorder();
								echo(json_encode($materialorder->fetchmaterialordereddetails()));
							}
						break;
						case "mosdetails":{
								$materialorder = new materialorder();
								echo(json_encode($materialorder->fetchitemsupplieddetails()));
							}
						break;
						case "checkitem":{
								$check_item_add = isset($_POST["checkitemnamee"]) ? $_POST["checkitemnamee"] : false;
								echo(json_encode(checkitemadd($check_item_add)));
							}
						break;
						case "itemAdd":{
								$item_add = array("name" => isset($_POST["itmemadd"]["name"]) ? $_POST["itmemadd"]["name"] : false,
                                                  "min" => isset($_POST["itmemadd"]["min"]) ? $_POST["itmemadd"]["min"] : false
								);
								$stock = new stock($item_add);
								echo $stock->itemAdd();
							}
						break;
						case "projincomclient" : {
							$colls=new collection();
							echo (json_encode($colls->fetchprojectcliens()));
						}
						break;
						case "fetchclientprojects" : {
							$clientid=  isset($_POST["clientid"]) ? $_POST["clientid"] : false;
							$colls=new collection();
							echo (json_encode($colls->fetchclientprojects($clientid)));
						}
						break;
						case "fetchdueamountofclientprojects" : {
							$projid=  isset($_POST["projid"]) ? $_POST["projid"] : false;
							$colls=new collection();
							echo (json_encode($colls->fetchdueamountofclientprojects($projid)));
						}
						break;
						case "pettycashadd":{
							$petty_add = array(
								"pettyamount" => isset($_POST["petyadd"]["amount"]) ? $_POST["petyadd"]["amount"] : false,
								"pettyremark" => isset($_POST["petyadd"]["remark"]) ? $_POST["petyadd"]["remark"] : false
							);
							$ptycash = new pettycash($petty_add);
							echo $ptycash->addpettycash();
						}
						break;
						case "fetchpettycashhistory":{
							$ptycash = new pettycash();
							echo (json_encode($ptycash->fetchpettycashhistory()));
						}
						break;
						case "updateStock":{
								$stock_add = array(
									"qty" => isset($_POST["stockupdate"]["qty"]) ? $_POST["stockupdate"]["qty"] : false,
									"iid" => isset($_POST["stockupdate"]["iid"]) ? $_POST["stockupdate"]["iid"] : false
								);
								$stock = new stock($stock_add);
								echo $stock->updateStock();
							}
						break;
						/*
							END stock.php
						*/
						case "creat_material_Order":{
								$add_materialOrder = array(
									"qty" => isset($_POST["materialOrder"]["qty"]) ? $_POST["materialOrder"]["qty"] : false,
									"iid" => isset($_POST["materialOrder"]["iid"]) ? $_POST["materialOrder"]["iid"] : false,
									"vid" => isset($_POST["materialOrder"]["venid"]) ? $_POST["materialOrder"]["venid"] : false,
									"doo" => isset($_POST["materialOrder"]["doo"]) ? $_POST["materialOrder"]["doo"] : false,
									"edod" => isset($_POST["materialOrder"]["edod"]) ? $_POST["materialOrder"]["edod"] : false
								);
								$materialorder = new materialorder($add_materialOrder);
								echo $materialorder->creatmeterialOrder();
							}
						break;
						case "additemtoexistingorder":{
								$add_materialOrder = array(
									"qty" => isset($_POST["materialOrder"]["qty"]) ? $_POST["materialOrder"]["qty"] : false,
									"iid" => isset($_POST["materialOrder"]["iid"]) ? $_POST["materialOrder"]["iid"] : false,
									"oid" => isset($_POST["materialOrder"]["oid"]) ? $_POST["materialOrder"]["oid"] : false,
									"doo" => isset($_POST["materialOrder"]["doo"]) ? $_POST["materialOrder"]["doo"] : false,
									"edod" => isset($_POST["materialOrder"]["edod"]) ? $_POST["materialOrder"]["edod"] : false,
									"mo_descb_id" => isset($_POST["materialOrder"]["mo_descb_id"]) ? $_POST["materialOrder"]["mo_descb_id"] : false
								);
								$materialorder = new materialorder($add_materialOrder);
								echo $materialorder->additemtoexistingorder();
							}
						break;
						case "DisplayCollsList":{
								$colls = new collection();
								$_SESSION['listofcolls'] = $colls->listColls();
								if (isset($_SESSION['listofcolls']) && sizeof($_SESSION['listofcolls']) > 0) {
									$_SESSION["initial"] = 0;
									$_SESSION["final"] = 19;
									$para["initial"] = $_SESSION["initial"];
									$para["final"] = $_SESSION["final"];
									$colls->DisplayCollsList($para);
								} else {
									$para["initial"] = 0;
									$para["final"] = 0;
									$colls->DisplayCollsList($para);
									echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
								}
							}
						break;
//						case "DisplayUpdatedCollsList":{
//								if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
//									if (isset($_SESSION['listofcolls']) && sizeof($_SESSION['listofcolls']) > 0) {
//										if ($_SESSION["final"] >= sizeof($_SESSION['listofcolls'])) {
//											unset($_SESSION["initial"]);
//											unset($_SESSION["final"]);
//											echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
//										} else {
//											$_SESSION["initial"] = $_SESSION["final"] + 1;
//											$_SESSION["final"] += 20;
//											$para["initial"] = $_SESSION["initial"];
//											$para["final"] = $_SESSION["final"];
//											$colls->DisplayCollsList($para);
//										}
//									}
//								}
//							}
//						break;
						case "DisplayPaymsList":{
								$payms = new payment();
								$_SESSION['listofpayms'] = $payms->listPayms();
								if (isset($_SESSION['listofpayms']) && sizeof($_SESSION['listofpayms']) > 0) {
									$_SESSION["initial"] = 0;
									$_SESSION["final"] = 19;
									$para["initial"] = $_SESSION["initial"];
									$para["final"] = $_SESSION["final"];
									$payms->DisplayPaymsList($para);
								} else {
									$para["initial"] = 0;
									$para["final"] = 0;
									$payms->DisplayPaymsList($para);
									echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
								}
							}
						break;
						case "DisplayUpdatedPaymsList":{
								if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
									if (isset($_SESSION['listofpayms']) && sizeof($_SESSION['listofpayms']) > 0) {
										if ($_SESSION["final"] >= sizeof($_SESSION['listofpayms'])) {
											unset($_SESSION["initial"]);
											unset($_SESSION["final"]);
											echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
										} else {
											$_SESSION["initial"] = $_SESSION["final"] + 1;
											$_SESSION["final"] += 20;
											$para["initial"] = $_SESSION["initial"];
											$para["final"] = $_SESSION["final"];
											$payms->DisplayPaymsList($para);
										}
									}
								}
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
        function  mastermain($parameters)
        {
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
//			if(($db_select = selectDB(MASTER_DBNAME_ZERO,$link)) == 1){
                            if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if(!ValidateAdmin()){
					session_destroy();
					echo "logout";
				}else{
					switch($parameters["action"])
                                    {
						case "clientAdd":
						if($_POST["distributer_name"]!="" && $_POST["owners_name"]!="" && preg_match('%^[A-Z_a-z\."\-]{3,100}%', $_POST["distributer_name"])&& preg_match('%^[A-Z_a-z\."\-]{3,100}%', $_POST["owners_name"])){
								$client_add = array(
								"name" 			=> isset($_POST["distributer_name"]) 			? $_POST["distributer_name"]					: false,
								"username" 		=> isset($_POST["usernameclient"]) 			? $_POST["usernameclient"]					: false,
                                                                "owner" 		=> isset($_POST["owners_name"]) 			? $_POST["owners_name"]					: false,
								"type" 			=> isset($_POST["validity_type"]) 			? $_POST["validity_type"]					: false,
								"paydate"		=> isset($_POST["payment_date"]) 				? $_POST["payment_date"]					: false,
								"subdate"		=> isset($_POST["subscribe_date"]) 				? $_POST["subscribe_date"]					: false,
								"email"			=> isset($_POST["email"]) 			? (array) $_POST["email"]		: false,
								"cellnumbers"           => isset($_POST["cellnumbers"]) 		? (array) $_POST["cellnumbers"]	: false,
								"doctype"		=> isset($_POST["doc_type"]) 				? $_POST["doc_type"]					: false,
								"docno"			=> isset($_POST["doc_number"]) 				? $_POST["doc_number"]					: false,
								"pcode"			=> isset($_POST["pcode"]) 			? $_POST["pcode"]				: false,
								"tphone"		=> isset($_POST["telephone"]) 			? $_POST["telephone"]				: false,
								"sms"			=> isset($_POST["sms_cost"]) 				? $_POST["sms_cost"]					: false,
								"country"		=> isset($_POST["country"]) 			? $_POST["country"]				: false,
								"countryCode"           => isset($_POST["countryCode"]) 		? $_POST["countryCode"]			: false,
								"province"		=> isset($_POST["province"]) 		? $_POST["province"]				: false,
								"provinceCode"          => isset($_POST["provinceCode"])		? $_POST["provinceCode"]			: false,
								"district"		=> isset($_POST["district"]) 		? $_POST["district"]				: false,
								"city_town"		=> isset($_POST["city_town"]) 		? $_POST["city_town"]			: false,
								"st_loc"		=> isset($_POST["st_loc"]) 			? $_POST["st_loc"]				: false,
								"addrsline"		=> isset($_POST["addrs"]) 		? $_POST["addrs"]			: false,
								"zipcode"		=> isset($_POST["zipcode"]) 			? $_POST["zipcode"]				: false,
								"website"		=> isset($_POST["website"]) 			? $_POST["website"]				: false,
								"gmaphtml"	=> isset($_POST["gmaphtml"]) 		? $_POST["gmaphtml"]				: false,
								"timezone"	=> isset($_POST["timezone"]) 		? $_POST["timezone"]				: false,
								"lat"			=> isset($_POST["lat"]) 				? $_POST["lat"]					: false,
								"lon"			=> isset($_POST["lon"]) 				? $_POST["lon"]					: false,
								"db_host" 		=> 'localhost',
								"db_username" 	=> 'root',
								"db_name"		=> 'mis_slave'.generateRandomString().time(),
								"db_password" 	=> DBPASS,
								"password"		=> generateRandomString(),
								"acs" 			=> generateRandomString(),
							);
							$obj = new client($client_add);
							echo json_encode($obj-> clientadd($_FILES));
						}
						else
							echo false;
							exit(0);
						break;
						case "fetchValidityTypes":
							$obj = new client();
							echo (json_encode($obj->fetchValidityTypes()));
						break;
                                            case "checkclientusername":
							$obj = new client();
                                                        $chkusername=  isset($_POST['chkusername']) ? $_POST['chkusername'] : false;
							echo (json_encode($obj->CheckClientUserName($chkusername)));
						break;
						case "fetchDistributor":
							$obj = new admincollection();
							echo (json_encode($obj->fetchDistributor()));
						break;
						case "fetchMOPTypes":
							echo (json_encode(getSAMOPTypes()));
						break;
						case "fetchBankAccount":
							echo (json_encode(getBankAccounts($parameters)));
						break;
						case "DisplayUserList":
							$obj = new client();
							$_SESSION["listofclients"]= $obj->clientProfile();
							if(isset($_SESSION["listofclients"]) && sizeof($_SESSION["listofclients"]) > 0){
								$_SESSION["initial"] = 0;
								$_SESSION["final"] = 10;
								$para["initial"] = $_SESSION["initial"];
								$para["final"] = $_SESSION["final"];
								echo json_encode($obj->displayUserList($para));
							}
							else{
								$para["initial"] = 0;
								$para["final"] = 0;
								echo json_encode($obj->displayUserList($para));
							}
						break;

						case "DisplayUpdatedUserList":
							$obj = new client();
							if(isset($_SESSION["initial"]) && isset($_SESSION["final"])){
								if(isset($_SESSION["listofclients"]) && sizeof($_SESSION["listofclients"]) > 0){
									if($_SESSION["final"] >= sizeof($_SESSION["listofclients"])){
										unset($_SESSION["initial"]);
										unset($_SESSION["final"]);
										$temp[] = array(
											"html" => '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>',
											"uid"			=> 0,
											"sr"			=> '',
										);
										echo json_encode($temp);
									}
									else{
										$_SESSION["initial"] = $_SESSION["final"]+1;
										$_SESSION["final"] += 4;
										$para["initial"] = $_SESSION["initial"];
										$para["final"] = $_SESSION["final"];
									echo json_encode($obj->displayUserList($para));
									}
								}
							}
						break;

						case "loadEmailIdForm":
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]			: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]			: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]		: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]	: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]			: false,
								"email"		=> isset($_POST["det"]["email"]) 	? $_POST["det"]["email"]		: false,
								"msgDiv"	=> isset($_POST["det"]["msgDiv"]) 	? $_POST["det"]["msgDiv"]		: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]			: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]		: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]		: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]		: false
							);
							$obj = new client($det);
							echo (json_encode($obj->loadEmailIdForm()));
							// echo print_r($_SESSION["list_of_users"]);
						break;
						case "editEmailId":
							$emailids = array(
								"emailids"	=> isset($_POST["emailids"]) 	? $_POST["emailids"]	: false
							);
							$obj = new client($emailids);
							echo (json_encode($obj->editEmailId()));
							// echo print_r($_SESSION["list_of_users"]);
						break;
						case "deleteEmailId":
							$emailid = array(
								"eid"	=> isset($_POST["eid"]) 	? $_POST["eid"]	: false
							);
							$obj = new client($emailid);
							echo $obj->deleteEmailId();
						break;
						case "listEmailIds":
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$obj = new client($para);
							echo $obj->listEmailIds();
						break;
						case "loadCellNumForm":
							$det = array(
								"num"		=> isset($_POST["det"]["num"]) 		? $_POST["det"]["num"]		: false,
								"uid"		=> isset($_POST["det"]["uid"])		? $_POST["det"]["uid"]		: false,
								"index"		=> isset($_POST["det"]["index"])	? $_POST["det"]["index"]	: false,
								"sindex"	=> isset($_POST["det"]["listindex"])? $_POST["det"]["listindex"]: false,
								"form"		=> isset($_POST["det"]["form"]) 	? $_POST["det"]["form"]		: false,
								"cnumber"	=> isset($_POST["det"]["cnumber"]) 	? $_POST["det"]["cnumber"]	: false,
								"msgDiv"	=> isset($_POST["det"]["msgDiv"]) 	? $_POST["det"]["msgDiv"]	: false,
								"plus"		=> isset($_POST["det"]["plus"]) 	? $_POST["det"]["plus"]		: false,
								"minus"		=> isset($_POST["det"]["minus"])	? $_POST["det"]["minus"]	: false,
								"saveBut"	=> isset($_POST["det"]["saveBut"])	? $_POST["det"]["saveBut"]	: false,
								"closeBut"	=> isset($_POST["det"]["closeBut"])	? $_POST["det"]["closeBut"]	: false
							);
							$obj = new client($det);
							echo (json_encode($obj->loadCellNumForm()));
							// echo print_r($_SESSION["list_of_users"]);
						break;
						case "editCellNum":
							$cnums = array(
								"CellNums"	=> isset($_POST["CellNums"]) 		? $_POST["CellNums"]		: false
							);
							$obj = new client($cnums);
							echo (json_encode($obj->editCellNum()));
							// echo print_r($_SESSION["list_of_users"]);
						break;
						case "deleteCellNum":
							$cnums = array(
								"eid"	=> isset($_POST["eid"]) 		? $_POST["eid"]		: false
							);
							$obj = new client($cnums);
							echo $obj->deleteCellNum();
						break;
						case "listCellNums":
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$obj = new client($para);
							echo $obj->listCellNums();
						break;
						case "editAddress":
							$address = array(
								"index"			=> isset($_POST["address"]["index"]) 		? $_POST["address"]["index"]		: false,
								"sindex"		=> isset($_POST["address"]["listindex"]) 	? $_POST["address"]["listindex"]	: false,
								"uid"			=> isset($_POST["address"]["uid"]) 			? $_POST["address"]["uid"]			: false,
								"country"		=> isset($_POST["address"]["country"]) 		? $_POST["address"]["country"]		: false,
								"countryCode"	=> isset($_POST["address"]["countryCode"]) 	? $_POST["address"]["countryCode"]	: false,
								"province"		=> isset($_POST["address"]["province"]) 	? $_POST["address"]["province"]		: false,
								"provinceCode"	=> isset($_POST["address"]["provinceCode"]) ? $_POST["address"]["provinceCode"]	: false,
								"district"		=> isset($_POST["address"]["district"]) 	? $_POST["address"]["district"]		: false,
								"city_town"		=> isset($_POST["address"]["city_town"]) 	? $_POST["address"]["city_town"]	: false,
								"st_loc"		=> isset($_POST["address"]["st_loc"]) 		? $_POST["address"]["st_loc"]		: false,
								"addrsline"		=> isset($_POST["address"]["addrsline"]) 	? $_POST["address"]["addrsline"]	: false,
								"zipcode"		=> isset($_POST["address"]["zipcode"]) 		? $_POST["address"]["zipcode"]		: false,
								"website"		=> isset($_POST["address"]["website"]) 		? $_POST["address"]["website"]		: false,
								"gmaphtml"		=> isset($_POST["address"]["gmaphtml"]) 	? $_POST["address"]["gmaphtml"]		: false,
								"timezone"		=> isset($_POST["address"]["timezone"]) 	? $_POST["address"]["timezone"]		: false,
								"lat"			=> isset($_POST["address"]["lat"]) 			? $_POST["address"]["lat"]			: false,
								"lon"			=> isset($_POST["address"]["lon"]) 			? $_POST["address"]["lon"]			: false
							);
							$obj = new client($address);
							echo $obj->editAddress();
						break;
						case "listAddress":
							$para = array(
								"uid"		=> isset($_POST["para"]["uid"]) 		? $_POST["para"]["uid"]			: false,
								"index"		=> isset($_POST["para"]["index"]) 		? $_POST["para"]["index"]		: false,
								"sindex"	=> isset($_POST["para"]["listindex"]) 	? $_POST["para"]["listindex"]	: false
							);
							$obj = new client($para);
							echo $obj->listAddress();
						break;
						case "deleteUser":
							$delete = array(
								"entry" 	=> isset($_POST["ptydeletesale"]) 		? $_POST["ptydeletesale"]	: false
							);
							$obj = new client($delete);
							echo $obj->deleteUser();
						break;
                                            case "fetchadminnotify":
							$obj = new order();
							echo json_encode($obj->fetchAdminNotify());
                                                        break;
                                            case "deletentfyUser":
							$delete_ntfy = array(
								"entry" 	=> isset($_POST["ptydeletesale"]["entid"]) 		? $_POST["ptydeletesale"]["entid"]	: false
							);
							$obj = new order($delete_ntfy);
							echo $obj->deletentfyUser();
						break;

						case "edituser":
							$user = array(
								"usrid" 	=> isset($_POST["usrid"]) 		? $_POST["usrid"]	: false
							);
							$obj = new client($user);
							$obj->editUser();
						break;

						case "flagUser":
						   $flag_user = array(
								"uid"		=> isset($_POST["fuser"])		? $_POST["fuser"]			: false,
							);
							$obj = new client($flag_user);
							echo $obj->flagUser();
						break;
						case "unflagUser":
						   $unflag_user = array(
								"uid"		=> isset($_POST["ufuser"])		? $_POST["ufuser"]			: false,
							);
							$obj = new client($unflag_user);
							echo $obj->unflagUser();
						break;
						case "addCollection":
							$colls = array(
								"cindex" 	=> isset($_POST["colls"]["coltrind"]) ? $_POST["colls"]["coltrind"]	: false,
								"collector"	=> isset($_POST["colls"]["coltrid"]) ? $_POST["colls"]["coltrid"]	: false,
								"uindex" 	=> isset($_POST["colls"]["uindex"]) ? $_POST["colls"]["uindex"]	: false,
								"distributor" 	=> isset($_POST["colls"]["user"]) 	? $_POST["colls"]["user"]	: false,
								"date"		=> isset($_POST["colls"]["pdate"]) 	? $_POST["colls"]["pdate"]	: false,
								"pay_ac"	=> isset($_POST["colls"]["pay_ac"]) ? $_POST["colls"]["pay_ac"]	: false,
								"mop"		=> isset($_POST["colls"]["mop"]) 	? $_POST["colls"]["mop"] 	: false,
								"ac_id"		=> isset($_POST["colls"]["ac_id"]) 	? $_POST["colls"]["ac_id"]	: false,
								"account"	=> isset($_POST["colls"]["account"])? $_POST["colls"]["account"]: false,
								"amount"	=> isset($_POST["colls"]["pamt"]) 	? $_POST["colls"]["pamt"]	: false,
								"amountpaid"=> isset($_POST["colls"]["amtpaid"]) 	? $_POST["colls"]["amtpaid"]	: false,
								"amountdue"	=> isset($_POST["colls"]["amtdue"]) 	? $_POST["colls"]["amtdue"]	: false,
								"duedate"		=> isset($_POST["colls"]["duedate"]) 	? $_POST["colls"]["duedate"]	: false,
								"rmk"		=> isset($_POST["colls"]["rmk"]) 	? $_POST["colls"]["rmk"]	: false,
                                                                "clientid"   => isset($_POST["colls"]["clientid"]) ? $_POST["colls"]["clientid"]	: false,
                                                                "subdate"   => isset($_POST["colls"]["subsdate"]) ? $_POST["colls"]["subsdate"]	: false,
                                                                "type"   => isset($_POST["colls"]["type"]) ? $_POST["colls"]["type"]	: false,
                                                                "followupdates" =>isset($_POST["colls"]["folldates"]) ? $_POST["colls"]["folldates"] : false
							);
							$obj = new admincollection($colls);
							echo $obj->addIncommingAmt();
						break;
						case "DisplayCollsList":
							$colls = new admincollection();
							echo json_encode($colls->listColls());

						break;
						case "orderfollowupsAdd":
							$client_add = array(
								"name" 			=> isset($_POST["clientadd"]["name"]) 			? $_POST["clientadd"]["name"]					: false,
								"email"			=> isset($_POST["clientadd"]["email"]) 		?  $_POST["clientadd"]["email"]			: false,
								"cellnumbers"	=> isset($_POST["clientadd"]["cellnumber"]) 	? $_POST["clientadd"]["cellnumber"]	: false,
								"handeledBy"	=> isset($_POST["clientadd"]["handledby"]) 	?  $_POST["clientadd"]["handledby"]	: false,
								"ReferedBy"		=> isset($_POST["clientadd"]["refby"]) 	? $_POST["clientadd"]["refby"]	: false,
								"OrderProbability"	=> isset($_POST["clientadd"]["ord_prb"]) 	? $_POST["clientadd"]["ord_prb"]	: false,
								"date"			=> isset($_POST["clientadd"]["cdate"]) 	?  $_POST["clientadd"]["cdate"]	: false,
								"comment"			=> isset($_POST["clientadd"]["comment"]) 	?  $_POST["clientadd"]["comment"]	: false
							);
							$order = new order($client_add);
							echo $order->addClient();
						break;
						case "DisplayorderClientList":
							$orders = new order();
							echo json_encode($orders->listorders());
							break;
                                                case "deleteordfoll":
                                                        $ofid=  isset($_POST['ofid']) ? $_POST['ofid'] : false;
							$orders = new order();
							echo json_encode($orders->deleteOrderFollowup($ofid));
							break;
						case "DisplayNotificationList":
							$notify = new order();
							$_SESSION['listofnotifications'] = $notify->listnotification();
							//print_r($_SESSION['listofnotifications']);
							if(isset($_SESSION['listofnotifications']) && sizeof($_SESSION['listofnotifications']) > 0){
								$_SESSION["initial"] = 0;
								$_SESSION["final"] = 6;
								$para["initial"] = $_SESSION["initial"];
								$para["final"] = $_SESSION["final"];
								echo json_encode($notify->displayNotificationList($para));
							}
							else{
								$para["initial"] = 0;
								$para["final"] = 0;
								echo json_encode($notify->displayNotificationList($para));
							}
						break;
                                                case "changepassword" :
                                                            {
                                                            $obj=new userprofile();
                                                            $newpass=  isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : false;
                                                            echo json_encode($obj->changePassword($newpass));
                                                            }
                                                            break;
                                                case "fetchclientprofile" :
                                                            {
                                                            $obj=new userprofile();
                                                            echo json_encode($obj->fetchClientProfile());
                                                            }
                                                            break;
                                                case "fetchadmindues" :
                                                            {
                                                            $obj=new dueadmin();
                                                            echo json_encode($obj->fetchAdminDues());
                                                            }
                                                            break;
                                                case "payadmindues" :
                                                            {
                                                            $details=array(
                                                                "userpk" => isset($_POST['details']['userpk']) ? $_POST['details']['userpk'] : false,
                                                                "amt" => isset($_POST['details']['amt']) ? $_POST['details']['amt'] : false,
                                                               "mop" => isset($_POST['details']['mop']) ? $_POST['details']['mop'] : false,
                                                            );
                                                            $obj=new dueadmin($details);
                                                            echo json_encode($obj->payAdminDue());
                                                            }
                                                            break;
                                                    /* Follow Ups */
                                                  case "fetchcurrfollowup" :
                                                            {
                                                            $obj=new adminfollowup();
                                                            echo json_encode($obj->FetchCurrentFollowUp());
                                                            }
                                                            break;
                                                case "fetchpendingfollowup" :
                                                            {
                                                            $obj=new adminfollowup();
                                                            echo json_encode($obj->FetchPendingFollowUp());
                                                            }
                                                            break;
                                                case "fetchexpiredfollowup" :
                                                            {
                                                            $obj=new adminfollowup();
                                                            echo json_encode($obj->FetchExpiredFollowUp());
                                                            }
                                                            break;
						case "logout":
							session_destroy();
							echo "logout";
						break;
					}
				}
			}
		}
	}
        if((isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') && ((isset($parameters["type"])) && $parameters["type"]=='master') )
        {
          global $parameters;
          mastermain($parameters);
          unset($_POST);
          exit(0);
        }
        else if(isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true' ){
            global $parameters;
            main($parameters);
            unset($_POST);
            exit(0);
                }
	require_once(DOC_ROOT.INC.'header.php');
        if($_SESSION["USER_LOGIN_DATA"]['user_type_id']=="9")
        {
	require_once(DOC_ROOT.INC.'menu.php');
        }
        else
        {
        require_once(DOC_ROOT.INC.'menuadmin.php');
        }
	require_once(DOC_ROOT.INC.'interface.php');
	require_once(DOC_ROOT.INC.'footer.php');
        function GetImageExtension($imagetype)
	     {
	       if(empty($imagetype)) return false;
	       switch($imagetype)
	       {
	           case 'image/bmp': return '.bmp';
	           case 'image/gif': return '.gif';
	           case 'image/jpeg': return '.jpg';
	           case 'image/png': return '.png';
	           default: return false;
	       }
	    }
?>