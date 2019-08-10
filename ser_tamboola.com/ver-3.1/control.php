<?php
	define("MODULE_0", "config.php");
	require_once(MODULE_0);
	require_once(MODULE_CLIENTADD);
	require_once(MODULE_GYMLIST);
	require_once(MODULE_PROFILE);
	require_once(MODULE_ADDCUSTOMER);
	require_once(MODULE_GROUP);
	require_once(MODULE_ENQUIRY);
	require_once(MODULE_PAYMENT);
	require_once(MODULE_SHOWSTATUS);
	require_once(MODULE_ACCOUNT);
	require_once(MODULE_MANAGE);
	require_once(MODULE_ATTENDANCE);
	require_once(MODULE_STATS);
	require_once(MODULE_TRAINER);
	require_once(MODULE_CLUB);
        require_once(MODULE_ADDGYM);
        require_once(MODULE_OWNERUSER);
	require_once(MODULE_REPORT);
	require_once(RECEIPTS_REPORT);
	require_once(MODULE_CRM);
	//require_once(CONFIG_ROOT . MODULE_3);
	require_once(CONFIG_ROOT . MODULE_0);
	require_once(CONFIG_ROOT . MODULE_1);
	require_once(CONFIG_ROOT . MODULE_2);
	/* SUPER ADMIN FILES INCLUDING */
	require_once(SA_ADMIN_COLLECTION);
	require_once(SA_ENQUIRY);
	require_once(SA_ORDER_FALLOWUP);
	require_once(SA_ORDER);
	require_once(SA_DUE);
	require_once(SA_FALLOWUP);
	require_once(SA_SMS);
	//MADMEC MANAGE
	require_once(MODULE_MADMEC_MANAGE);
	//Customer Classes
	require_once(MODULE_CUSTOMER);
	require_once(LIB_ROOT . 'PHPExcel_1.7.9/Classes/PHPExcel.php');
	$eq_add = array(
		"referpk" => isset($_POST["eadd"]["referpk"]) ? $_POST["eadd"]["referpk"] : false,
		"handelpk" => isset($_POST["eadd"]["handelpk"]) ? $_POST["eadd"]["handelpk"] : false,
		"email" => isset($_POST["eadd"]["email"]) ? $_POST["eadd"]["email"] : false,
		"ccode" => isset($_POST["eadd"]["ccode"]) ? $_POST["eadd"]["ccode"] : false,
		"cellnum" => isset($_POST["eadd"]["cell"]) ? $_POST["eadd"]["cell"] : false,
		"vname" => isset($_POST["eadd"]["vname"]) ? $_POST["eadd"]["vname"] : false,
		"ft_goal" => isset($_POST["eadd"]["fgoal"]) ? $_POST["eadd"]["fgoal"] : false,
		"comments" => isset($_POST["eadd"]["cmt"]) ? $_POST["eadd"]["cmt"] : false,
		"f1" => isset($_POST["eadd"]["f1"]) ? $_POST["eadd"]["f1"] : false,
		"f2" => isset($_POST["eadd"]["f2"]) ? $_POST["eadd"]["f2"] : false,
		"f3" => isset($_POST["eadd"]["f3"]) ? $_POST["eadd"]["f3"] : false,
		"med_ad" => isset($_POST["eadd"]["knwabt"]) ? $_POST["eadd"]["knwabt"] : false,
		"enquiry_on" => isset($_POST["eadd"]["instin"]) ? (array) $_POST["eadd"]["instin"] : false,
		"jop" => isset($_POST["eadd"]["jop"]) ? $_POST["eadd"]["jop"] : false,
		"sendcred" => isset($_POST["eadd"]["sendcred"]) ? $_POST["eadd"]["sendcred"] : false,
	);
        $gym_add = array(
                                                "clientreq" => isset($_POST["clientreq"]) ? true : false,
						"type" => isset($_POST["gymadd"]["type"]) ? $_POST["gymadd"]["type"] : false,
						"mgym" => isset($_POST["gymadd"]["mgym"]) ? $_POST["gymadd"]["mgym"] : false,
						"userpk" => isset($_POST["gymadd"]["userpk"]) ? $_POST["gymadd"]["userpk"] : false,
						"name" => isset($_POST["gymadd"]["name"]) ? $_POST["gymadd"]["name"] : false,
						"email" => isset($_POST["gymadd"]["email"]) ? (array) $_POST["gymadd"]["email"] : false,
						"cellnumbers" => isset($_POST["gymadd"]["cellnumbers"]) ? (array) $_POST["gymadd"]["cellnumbers"] : false,
						"fee" => isset($_POST["gymadd"]["fee"]) ? $_POST["gymadd"]["fee"] : false,
						"tax" => isset($_POST["gymadd"]["tax"]) ? $_POST["gymadd"]["tax"] : false,
						"country" => isset($_POST["gymadd"]["country"]) ? $_POST["gymadd"]["country"] : false,
						"countryCode" => isset($_POST["gymadd"]["countryCode"]) ? $_POST["gymadd"]["countryCode"] : false,
						"province" => isset($_POST["gymadd"]["province"]) ? $_POST["gymadd"]["province"] : false,
						"provinceCode" => isset($_POST["gymadd"]["provinceCode"]) ? $_POST["gymadd"]["provinceCode"] : false,
						"district" => isset($_POST["gymadd"]["district"]) ? $_POST["gymadd"]["district"] : false,
						"city_town" => isset($_POST["gymadd"]["city_town"]) ? $_POST["gymadd"]["city_town"] : false,
						"st_loc" => isset($_POST["gymadd"]["st_loc"]) ? $_POST["gymadd"]["st_loc"] : false,
						"addrsline" => isset($_POST["gymadd"]["addrsline"]) ? $_POST["gymadd"]["addrsline"] : false,
						"pcode" => isset($_POST["gymadd"]["pcode"]) ? $_POST["gymadd"]["pcode"] : false,
						"tphone" => isset($_POST["gymadd"]["tphone"]) ? $_POST["gymadd"]["tphone"] : false,
						"zipcode" => isset($_POST["gymadd"]["zipcode"]) ? $_POST["gymadd"]["zipcode"] : false,
						"website" => isset($_POST["gymadd"]["website"]) ? $_POST["gymadd"]["website"] : false,
						"gmaphtml" => isset($_POST["gymadd"]["gmaphtml"]) ? $_POST["gymadd"]["gmaphtml"] : false,
						"timezone" => isset($_POST["gymadd"]["timezone"]) ? $_POST["gymadd"]["timezone"] : false,
						"lat" => isset($_POST["gymadd"]["lat"]) ? $_POST["gymadd"]["lat"] : false,
						"lon" => isset($_POST["gymadd"]["lon"]) ? $_POST["gymadd"]["lon"] : false,
						"db_host" => 'localhost',
						"db_user" => 'root',
						"db_name" => 'tamboola_' . generateRandomString(),
						"db_pass" => DBPASS,
						);
	$parameters = array(
		"autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
		"action" => isset($_POST["action"]) ? $_POST["action"] : false,
		"master_slave_db" => isset($_POST["type"]) ? $_POST["type"] : false,
		"current_gym_id" => isset($_POST["gymid"]) ? $_POST["gymid"] : false,
		"enqparams" => isset($eq_add) ? (array) $eq_add : false,
            "gymAdd" => isset($gym_add) ? (array) $gym_add : false,
	);
	if (isset($_POST["action1"]))
		$parameters["action"] = $_POST["action1"];
	function superMain() {
		global $parameters;
		$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
		if (get_resource_type($link) == 'mysql link') {
			if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
				switch ($parameters["action"]) {
					//Super Admin Enquiry Module
					case "fetchKnowAboutUS": {
						$obj = new enquiry_su();
						echo(json_encode($obj->fetchKnowAboutUS()));
						break;
					}
					case "autoCompleteEnq": {
						$obj = new enquiry_su();
						echo(json_encode($obj->autoCompleteEnq()));
						break;
					}
					case "enqAdd": {
						$obj = new enquiry_su($parameters['enqparams']);
						echo(json_encode($obj->addEnquiry()));
						break;
					}
					case "DisplayEnquiryAll": {
						$para = array(
						"enquiry" => true,
						"list_type" => isset($_POST["list_type"]) ? $_POST["list_type"] : false,
						);
						$searchQuery = array(
						"searchQueryA" => ' ',
						"searchQueryB" => ' ',
						"searchQueryC" => ' ',
						"ListQuery" => ' '
						);
						$enq = new enquiry_su();
						$enq->returnSearchQuery($searchQuery, $para);
						$_SESSION['listofenquiries'] = $enq->listEnquiries($searchQuery);
						if (isset($_SESSION['listofenquiries']) && sizeof($_SESSION['listofenquiries']) > 0) {
							$_SESSION["initial"] = 1;
							$_SESSION["final"] = 10;
							$para["initial"] = $_SESSION["initial"];
							$para["final"] = $_SESSION["final"];
							echo $enq->displayEnquiresList($para["initial"], $para["final"]);
							} else {
							$para["initial"] = 0;
							$para["final"] = 0;
							echo $enq->displayEnquiresList($para["initial"], $para["final"]);
						}
						break;
					}
					case "UpdateListEnquiry": {
						$enq = new enquiry_su($parameters);
						if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
							if (isset($_SESSION['listofenquiries']) && sizeof($_SESSION['listofenquiries']) > 0) {
								if ($_SESSION["final"] >= sizeof($_SESSION['listofenquiries'])) {
									unset($_SESSION["initial"]);
									unset($_SESSION["final"]);
									echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
									} else {
									$_SESSION["initial"] = $_SESSION["final"] + 1;
									$_SESSION["final"] += 10;
									$enq->displayEnquiresList($_SESSION["initial"], $_SESSION["final"]);
								}
							}
						}
						break;
					}
					case "deleteEnquiry": {
						$del_enq = array(
						"id" => isset($_POST["id"]) ? $_POST["id"] : false,
						);
						$enq = new enquiry_su($del_enq);
						$delSucc = $enq->deleteEnquiry();
						if ($delSucc)
						echo "Deleted successfully";
						else
						echo "Failed to delete";
						break;
					}
					case "UpdateFollowUp": {
						$follow_cmt = array(
						"id" => isset($_POST["follow"]["id"]) ? $_POST["follow"]["id"] : false,
						"cmt" => isset($_POST["follow"]["com"]) ? $_POST["follow"]["com"] : false,
						);
						$enq = new enquiry_su($follow_cmt);
						$enq->updateFollowUp();
						break;
					}
					case "UpdateFinalStatus": {
						$stats_cmt = array(
						"id" => isset($_POST["stats"]["id"]) ? $_POST["stats"]["id"] : false,
						"cmt" => isset($_POST["stats"]["com"]) ? $_POST["stats"]["com"] : false,
						);
						$enq = new enquiry_su($stats_cmt);
						$enq->UpdateFinalStatus();
						break;
					}
					case "LoadSearchHTML": {
						$para = array(
						"Enquiry" => (isset($_POST["ser"]["Enquiry"]) && $_POST["ser"]["Enquiry"] == "true") ? true : false,
						"Group" => (isset($_POST["ser"]["Group"]) && $_POST["ser"]["Group"] == "true") ? true : false,
						"Personal" => (isset($_POST["ser"]["Personal"]) && $_POST["ser"]["Personal"] == "true") ? true : false,
						"Offer" => (isset($_POST["ser"]["Offer"]) && $_POST["ser"]["Offer"] == "true") ? true : false,
						"Package" => (isset($_POST["ser"]["Package"]) && $_POST["ser"]["Package"] == "true") ? true : false,
						"Date" => (isset($_POST["ser"]["Date"]) && $_POST["ser"]["Date"] == "true") ? true : false,
						"All" => (isset($_POST["ser"]["All"]) && $_POST["ser"]["All"] == "true") ? true : false
						);
						$enq = new enquiry_su();
						$enq->LoadSearchHTML($para);
						break;
					}
					case "search_enq_list": {
						$para = array(
						"enquiry" => true,
						"cust_email" => isset($_POST['spara']['cust_email']) ? $_POST['spara']['cust_email'] : false,
						"cust_name" => isset($_POST['spara']['cust_name']) ? $_POST['spara']['cust_name'] : false,
						"cust_no" => isset($_POST['spara']['cust_no']) ? $_POST['spara']['cust_no'] : false,
						"enq_day" => isset($_POST['spara']['enq_day']) ? $_POST['spara']['enq_day'] : false,
						"followup_date" => isset($_POST['spara']['follow_up']) ? $_POST['spara']['follow_up'] : false,
						"list_type" => "all",
						);
						$searchQuery = array(
						"searchQueryA" => ' ',
						"searchQueryB" => ' ',
						"searchQueryC" => ' ',
						"ListQuery" => ' '
						);
						$enq = new enquiry_su();
						$enq->returnSearchQuery($searchQuery, $para);
						$_SESSION['listofenquiries'] = $enq->listEnquiries($searchQuery);
						if (isset($_SESSION['listofenquiries']) && sizeof($_SESSION['listofenquiries']) > 0) {
							$_SESSION["initial"] = 1;
							$_SESSION["final"] = 20;
							$enq->displayEnquiresList($_SESSION["initial"], $_SESSION["final"]);
							} else {
							echo $enq->displayEnquiresList(0, 0);
						}
						break;
					}
					//super admin
					case "clientAdd": {
						if (!isset($_POST["email"])) {
							echo "email";
							} else {
							if ($_POST["user_name"] != "" && $_POST["doc_type"] != "" && preg_match('%^[A-Z_a-z\."\-]{3,100}%', $_POST["user_name"])) {
								$ct_add = array(
								"name" => isset($_POST["user_name"]) ? $_POST["user_name"] : false,
								"dob" => isset($_POST["user_dob"]) ? $_POST["user_dob"] : false,
								"gender" => isset($_POST["user_gender"]) ? $_POST["user_gender"] : false,
								"addusertype" => isset($_POST["addusertype"]) ? $_POST["addusertype"] : false,
								"email" => isset($_POST["email"]) ? (array) $_POST["email"] : false,
								"cellnumbers" => isset($_POST["cellnumbers"]) ? (array) $_POST["cellnumbers"] : false,
								"dtype" => isset($_POST["doc_type"]) ? $_POST["doc_type"] : false,
								"dnum" => isset($_POST["doc_number"]) ? $_POST["doc_number"] : false,
								"acsid" => generateRandomString(),
								"pass" => generateRandomString(),
								"auth" => md5(generateRandomString()),
								);
								$obj = new clientadd($ct_add);
								print_r($obj->addClientProfile($_FILES));
							} else
							echo false;
						}
						break;
					}
					case "autoCompleteClient": {
						$obj = new clientadd();
						echo json_encode($obj->userAutocomplete());
						break;
					}
					case "fetchOwnerRequest": {
						$obj = new clientadd();
						echo json_encode($obj->fetchOwnerRequest());
						break;
					}
					case "OwnerRequest": {
						$obj = new clientadd($_POST);
						echo json_encode($obj->OwnerRequest());
						break;
					}
                                        case "fetchGYMRequest": {
						$obj = new clientadd();
						echo json_encode($obj->fetchGYMRequest());
						break;
					}
                                        case "GYMRequest": {
						$obj = new clientadd($_POST);
						echo json_encode($obj->GYMRequest());
						break;
					}
					case "gymAdd": {
						$obj = new clientadd($parameters['gymAdd']);
						print_r($obj->addGYMProfile());
						break;
					}
					case "mmuser_list": {
						$mmlist = new clientadd();
						echo $mmlist->mmtable_list();
						break;
					}
					// list client
					case "mmuser_list1": {
						$mmlist = new clientadd();
						echo json_encode($mmlist->DisplayClietList());
						break;
					}
					//list gym
					case "mmgymlist_data1": {
						$gymid = $_POST["id"];
						$usergym = new clientadd();
						echo json_encode($usergym->displayUsrGymData($gymid));
						break;
					}
					//edit client case
					case "editClient": {
						$usrid = array(
						"usrid" => isset($_POST["usrid"]) ? $_POST["usrid"] : false
						);
						$obj = new clientadd($usrid);
						print_r($obj->editClient());
						break;
					}
					//edit client email
					case "loadClientEmailId": {
						$det = array(
						"num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
						"uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
						"index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
						"sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
						"form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
						"email" => isset($_POST["det"]["email"]) ? $_POST["det"]["email"] : false,
						"msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
						"plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
						"minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
						"saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
						"closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
						);
						$obj = new clientadd($det);
						echo(json_encode($obj->loadClientEmailId()));
						break;
					}
					case "editClientEmailId": {
						$emailids = array(
						"emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
						);
						$obj = new clientadd($emailids);
						echo(json_encode($obj->editClientEmailId()));
						break;
					}
					case "deleteClientEmailId": {
						$emailid = array(
						"eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
						);
						$obj = new clientadd($emailid);
						echo $obj->deleteClientEmailId();
						break;
					}
					case "listClientEmailIds": {
						$para = array(
						"uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
						"index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
						"sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
						);
						$obj = new clientadd($para);
						echo $obj->listClientEmailIds();
						break;
					}
					//edit Cell Number
					case "loadClientCellNumForm": {
						$det = array(
						"num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
						"uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
						"index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
						"sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
						"form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
						"cnumber" => isset($_POST["det"]["cnumber"]) ? $_POST["det"]["cnumber"] : false,
						"msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
						"plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
						"minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
						"saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
						"closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
						);
						$obj = new clientadd($det);
						echo(json_encode($obj->loadClientCellNumForm()));
						break;
					}
					case "editClientCellNum": {
						$cnums = array(
						"CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
						);
						$obj = new clientadd($cnums);
						echo(json_encode($obj->editClientCellNum()));
						break;
					}
					case "deleteClientCellNum": {
						$cnums = array(
						"eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
						);
						$obj = new clientadd($cnums);
						echo $obj->deleteClientCellNum();
						break;
					}
					case "listClientCellNums": {
						$para = array(
						"uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
						"index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
						"sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
						);
						$obj = new clientadd($para);
						echo $obj->listClientCellNums();
						break;
					}
					//change pic
					case "picChange": {
						if (isset($_FILES)) {
							$para = array(
							"usrid" => isset($_POST["uid"]) ? $_POST["uid"] : false,
							);
							$obj = new clientadd($para);
							print_r($obj->changeClientPic($_FILES));
						} else
						echo false;
						break;
					}
					//delete client
					case "deleteClient": {
						$delete = array(
						"usrid" => isset($_POST["uid"]) ? $_POST["uid"] : false,
						);
						$obj = new clientadd($delete);
						echo $obj->deleteClient();
						break;
					}
					//flag unflag client
					case "flagClient": {
						$flag_user = array(
						"uid" => isset($_POST["fuser"]) ? $_POST["fuser"] : false,
						);
						$obj = new clientadd($flag_user);
						echo $obj->flagClient();
						break;
					}
					case "sendcredential": {
						$flag_user = array(
						"uid" => isset($_POST["fuser"]) ? $_POST["fuser"] : false,
						);
						$obj = new clientadd($flag_user);
						echo $obj->sendCredential();
						break;
					}
                                        case "sentCredentials": {
						$obj = new enquiry_su();
						echo json_encode($obj->sentCredentials());
						break;
					}
                                        case "sendCredentialEnq": {
						$obj = new enquiry_su($_POST);
						echo json_encode($obj->sendCredential());
						break;
					}
					case "unflagClient": {
						$unflag_user = array(
						"uid" => isset($_POST["ufuser"]) ? $_POST["ufuser"] : false,
						);
						$obj = new clientadd($unflag_user);
						echo $obj->unflagClient();
						break;
					}
					//gym Email Id edit
					//edit GYM email
					case "loadGYMEmailId1": {
						$det = array(
						"num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
						"uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
						"index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
						"sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
						"form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
						"email" => isset($_POST["det"]["email"]) ? $_POST["det"]["email"] : false,
						"msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
						"plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
						"minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
						"saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
						"closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
						);
						$obj = new clientadd($det);
						echo(json_encode($obj->loadGYMEmailId()));
						break;
					}
					case "editGYMEmailId": {
						$emailids = array(
						"emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
						);
						$obj = new clientadd($emailids);
						echo(json_encode($obj->editGYMEmailId()));
						break;
					}
					case "deleteGYMEmailId": {
						$emailid = array(
						"eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
						);
						$obj = new clientadd($emailid);
						echo $obj->deleteGYMEmailId();
						break;
					}
					case "listGYMEmailIds": {
						$para = array(
						"uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
						"index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
						"sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
						);
						$obj = new clientadd($para);
						echo $obj->listGYMEmailIds();
						break;
					}
					//gym Cell Number edit
					case "loadGYMCellNumForm": {
						$det = array(
						"num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
						"uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
						"index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
						"sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
						"form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
						"cnumber" => isset($_POST["det"]["cnumber"]) ? $_POST["det"]["cnumber"] : false,
						"msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
						"plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
						"minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
						"saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
						"closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
						);
						$obj = new clientadd($det);
						echo(json_encode($obj->loadGYMCellNumForm()));
						break;
					}
					case "editGYMCellNum": {
						$cnums = array(
						"CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
						);
						$obj = new clientadd($cnums);
						echo(json_encode($obj->editGYMCellNum()));
						break;
					}
					case "deleteGYMCellNum": {
						$cnums = array(
						"eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
						);
						$obj = new clientadd($cnums);
						echo $obj->deleteGYMCellNum();
						break;
					}
					case "listGYMCellNums": {
						$para = array(
						"uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
						"index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
						"sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
						);
						$obj = new clientadd($para);
						echo $obj->listGYMCellNums();
						break;
					}
					//gym address edit
					case "gymaddressedit": {
						$data = $_POST["attr"];
						$addrset = new clientadd();
						echo json_encode($addrset->gymAddrsEdit($data));
						break;
					}
					//gym data doc edit
					case "gymdataDoc": {
						$data = $_POST["attr"];
						$addrset = new clientadd();
						echo json_encode($addrset->gymdatadocEdit($data));
						break;
					}
					//gym delete
					case "gymDeleTe": {
						$gymid = $_POST["id"];
						$deleteset = new clientadd();
						echo $deleteset->gymDELETE($gymid);
						break;
					}
					//gym flag btn
					case "flagGYM": {
						$flag_user = array(
						"uid" => isset($_POST["fuser"]) ? $_POST["fuser"] : false,
						);
						$obj = new clientadd($flag_user);
						echo $obj->flagGYM();
						break;
					}
					case "unflagGYM": {
						$unflag_user = array(
						"uid" => isset($_POST["ufuser"]) ? $_POST["ufuser"] : false,
						);
						$obj = new clientadd($unflag_user);
						echo $obj->unflagGYM();
						break;
					}
					// Assig user to GYM
					case "fetchusersngyms": {
						$obj = new clientadd();
						echo json_encode($obj->fetchUsersnGyms());
						break;
					}
					case "displayallgymsofowner": {
						$obj = new clientadd($_POST);
						echo json_encode($obj->displayAllGymsOfOwner());
						break;
					}
					case "addusertogym": {
						$obj = new clientadd($_POST);
						echo json_encode($obj->addUserToGym());
						break;
					}
					case "addCollection": {
						$colls = array(
						"cindex" => isset($_POST["colls"]["coltrind"]) ? $_POST["colls"]["coltrind"] : false,
						"collector" => isset($_POST["colls"]["coltrid"]) ? $_POST["colls"]["coltrid"] : false,
						"uindex" => isset($_POST["colls"]["uindex"]) ? $_POST["colls"]["uindex"] : false,
						"distributor" => isset($_POST["colls"]["user"]) ? $_POST["colls"]["user"] : false,
						"date" => isset($_POST["colls"]["pdate"]) ? $_POST["colls"]["pdate"] : false,
						"pay_ac" => isset($_POST["colls"]["pay_ac"]) ? $_POST["colls"]["pay_ac"] : false,
						"mop" => isset($_POST["colls"]["mop"]) ? $_POST["colls"]["mop"] : false,
						"ac_id" => isset($_POST["colls"]["ac_id"]) ? $_POST["colls"]["ac_id"] : false,
						"account" => isset($_POST["colls"]["account"]) ? $_POST["colls"]["account"] : false,
						"amount" => isset($_POST["colls"]["pamt"]) ? $_POST["colls"]["pamt"] : false,
						"amountpaid" => isset($_POST["colls"]["amtpaid"]) ? $_POST["colls"]["amtpaid"] : false,
						"amountdue" => isset($_POST["colls"]["amtdue"]) ? $_POST["colls"]["amtdue"] : false,
						"duedate" => isset($_POST["colls"]["duedate"]) ? $_POST["colls"]["duedate"] : false,
						"rmk" => isset($_POST["colls"]["rmk"]) ? $_POST["colls"]["rmk"] : false,
						"clientid" => isset($_POST["colls"]["clientid"]) ? $_POST["colls"]["clientid"] : false,
						"subdate" => isset($_POST["colls"]["subsdate"]) ? $_POST["colls"]["subsdate"] : false,
						"type" => isset($_POST["colls"]["type"]) ? $_POST["colls"]["type"] : false,
						"followupdates" => isset($_POST["colls"]["folldates"]) ? $_POST["colls"]["folldates"] : false
						);
						$obj = new admincollection($colls);
						echo $obj->addIncommingAmt();
						break;
					}
					case "DisplayCollsList": {
						$colls = new admincollection();
						echo json_encode($colls->listColls());
						break;
					}
					case "orderfollowupsAdd": {
						$client_add = array(
						"name" => isset($_POST["clientadd"]["name"]) ? $_POST["clientadd"]["name"] : false,
						"email" => isset($_POST["clientadd"]["email"]) ? $_POST["clientadd"]["email"] : false,
						"cellnumbers" => isset($_POST["clientadd"]["cellnumber"]) ? $_POST["clientadd"]["cellnumber"] : false,
						"handeledBy" => isset($_POST["clientadd"]["handledby"]) ? $_POST["clientadd"]["handledby"] : false,
						"ReferedBy" => isset($_POST["clientadd"]["refby"]) ? $_POST["clientadd"]["refby"] : false,
						"handelpk" => isset($_POST["clientadd"]["handelpk"]) ? $_POST["clientadd"]["handelpk"] : false,
						"referpk" => isset($_POST["clientadd"]["referpk"]) ? $_POST["clientadd"]["referpk"] : false,
						"OrderProbability" => isset($_POST["clientadd"]["ord_prb"]) ? $_POST["clientadd"]["ord_prb"] : false,
						"date" => isset($_POST["clientadd"]["cdate"]) ? $_POST["clientadd"]["cdate"] : false,
						"comment" => isset($_POST["clientadd"]["comment"]) ? $_POST["clientadd"]["comment"] : false
						);
						$order = new order($client_add);
						echo $order->addClient();
						break;
					}
					case "DisplayorderClientList": {
						$orders = new order();
						echo json_encode($orders->listorders());
						break;
					}
					case "deleteordfoll": {
						$ofid = isset($_POST['ofid']) ? $_POST['ofid'] : false;
						$orders = new order();
						echo json_encode($orders->deleteOrderFollowup($ofid));
						break;
					}
					case "fetchMOPTypes": {
						echo(json_encode(getSAMOPTypes()));
						break;
					}
					/* Order Fallow Up Starts */
					case "DisplayOrderFallowUpAll": {
						$para = array(
						"enquiry" => true,
						"list_type" => isset($_POST["list_type"]) ? $_POST["list_type"] : false,
						);
						$searchQuery = array(
						"searchQueryA" => ' ',
						"searchQueryB" => ' ',
						"searchQueryC" => ' ',
						"ListQuery" => ' '
						);
						$enq = new orderFallowUp();
						// $enq->returnSearchQuery($searchQuery, $para);
						$_SESSION['listoffollowupds'] = $enq->listEnquiries();
						if (isset($_SESSION['listoffollowupds']) && sizeof($_SESSION['listoffollowupds']) > 0) {
							$_SESSION["initial"] = 1;
							$_SESSION["final"] = 10;
							$para["initial"] = $_SESSION["initial"];
							$para["final"] = $_SESSION["final"];
							echo $enq->displayEnquiresList($para["initial"], $para["final"]);
							} else {
							$para["initial"] = 0;
							$para["final"] = 0;
							echo $enq->displayEnquiresList($para["initial"], $para["final"]);
						}
						break;
					}
					case "UpdateListFollowup": {
						$enq = new orderFallowUp($parameters);
						if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
							if (isset($_SESSION['listoffollowupds']) && sizeof($_SESSION['listoffollowupds']) > 0) {
								if ($_SESSION["final"] >= sizeof($_SESSION['listoffollowupds'])) {
									unset($_SESSION["initial"]);
									unset($_SESSION["final"]);
									echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
									} else {
									$_SESSION["initial"] = $_SESSION["final"] + 1;
									$_SESSION["final"] += 10;
									$enq->displayEnquiresList($_SESSION["initial"], $_SESSION["final"]);
								}
							}
						}
						break;
					}
					case "deleteEnquiry": {
						$del_enq = array(
						"id" => isset($_POST["id"]) ? $_POST["id"] : false,
						);
						$enq = new orderFallowUp($del_enq);
						$delSucc = $enq->deleteEnquiry();
						if ($delSucc)
						echo "Deleted successfully";
						else
						echo "Failed to delete";
						break;
					}
					case "UpdateFollowUp": {
						$follow_cmt = array(
						"id" => isset($_POST["follow"]["id"]) ? $_POST["follow"]["id"] : false,
						"cmt" => isset($_POST["follow"]["com"]) ? $_POST["follow"]["com"] : false,
						);
						$enq = new orderFallowUp($follow_cmt);
						$enq->updateFollowUp();
						break;
					}
					case "UpdateFinalStatus": {
						$stats_cmt = array(
						"id" => isset($_POST["stats"]["id"]) ? $_POST["stats"]["id"] : false,
						"cmt" => isset($_POST["stats"]["com"]) ? $_POST["stats"]["com"] : false,
						);
						$enq = new orderFallowUp($stats_cmt);
						$enq->UpdateFinalStatus();
						break;
					}
					case "LoadSearchHTML": {
						$para = array(
						"Enquiry" => (isset($_POST["ser"]["Enquiry"]) && $_POST["ser"]["Enquiry"] == "true") ? true : false,
						"Group" => (isset($_POST["ser"]["Group"]) && $_POST["ser"]["Group"] == "true") ? true : false,
						"Personal" => (isset($_POST["ser"]["Personal"]) && $_POST["ser"]["Personal"] == "true") ? true : false,
						"Offer" => (isset($_POST["ser"]["Offer"]) && $_POST["ser"]["Offer"] == "true") ? true : false,
						"Package" => (isset($_POST["ser"]["Package"]) && $_POST["ser"]["Package"] == "true") ? true : false,
						"Date" => (isset($_POST["ser"]["Date"]) && $_POST["ser"]["Date"] == "true") ? true : false,
						"All" => (isset($_POST["ser"]["All"]) && $_POST["ser"]["All"] == "true") ? true : false
						);
						$enq = new orderFallowUp();
						$enq->LoadSearchHTML($para);
						break;
					}
					case "search_enq_list": {
						$para = array(
						"enquiry" => true,
						"cust_email" => isset($_POST['spara']['cust_email']) ? $_POST['spara']['cust_email'] : false,
						"cust_name" => isset($_POST['spara']['cust_name']) ? $_POST['spara']['cust_name'] : false,
						"cust_no" => isset($_POST['spara']['cust_no']) ? $_POST['spara']['cust_no'] : false,
						"enq_day" => isset($_POST['spara']['enq_day']) ? $_POST['spara']['enq_day'] : false,
						"followup_date" => isset($_POST['spara']['follow_up']) ? $_POST['spara']['follow_up'] : false,
						"list_type" => "all",
						);
						$searchQuery = array(
						"searchQueryA" => ' ',
						"searchQueryB" => ' ',
						"searchQueryC" => ' ',
						"ListQuery" => ' '
						);
						$enq = new orderFallowUp();
						$enq->returnSearchQuery($searchQuery, $para);
						$_SESSION['listofenquiries'] = $enq->listEnquiries($searchQuery);
						if (isset($_SESSION['listofenquiries']) && sizeof($_SESSION['listofenquiries']) > 0) {
							$_SESSION["initial"] = 1;
							$_SESSION["final"] = 20;
							$enq->displayEnquiresList($_SESSION["initial"], $_SESSION["final"]);
							} else {
							echo $enq->displayEnquiresList(0, 0);
						}
						break;
					}
					/* Order Fallow Ends */
					case "DisplayNotificationList": {
						$notify = new order();
						$_SESSION['listofnotifications'] = $notify->listnotification();
						//print_r($_SESSION['listofnotifications']);
						if (isset($_SESSION['listofnotifications']) && sizeof($_SESSION['listofnotifications']) > 0) {
							$_SESSION["initial"] = 0;
							$_SESSION["final"] = 6;
							$para["initial"] = $_SESSION["initial"];
							$para["final"] = $_SESSION["final"];
							echo json_encode($notify->displayNotificationList($para));
							} else {
							$para["initial"] = 0;
							$para["final"] = 0;
							echo json_encode($notify->displayNotificationList($para));
						}
						break;
					}
					case "changepassword": {
						$obj = new userprofile();
						$newpass = isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : false;
						echo json_encode($obj->changePassword($newpass));
						break;
					}
					case "fetchclientprofile": {
						$obj = new userprofile();
						echo json_encode($obj->fetchClientProfile());
						break;
					}
					case "fetchadmindues": {
						$obj = new dueadmin();
						echo json_encode($obj->fetchAdminDues());
						break;
					}
					case "payadmindues": {
						$details = array(
						"userpk" => isset($_POST['details']['userpk']) ? $_POST['details']['userpk'] : false,
						"amt" => isset($_POST['details']['amt']) ? $_POST['details']['amt'] : false,
						"mop" => isset($_POST['details']['mop']) ? $_POST['details']['mop'] : false,
						);
						$obj = new dueadmin($details);
						echo json_encode($obj->payAdminDue());
						break;
					}
					/* Follow-ups */
					case "fetchcurrfollowup": {
						$obj = new adminfollowup();
						echo json_encode($obj->FetchCurrentFollowUp());
						break;
					}
					case "fetchpendingfollowup": {
						$obj = new adminfollowup();
						echo json_encode($obj->FetchPendingFollowUp());
						break;
					}
					case "fetchexpiredfollowup": {
						$obj = new adminfollowup();
						echo json_encode($obj->FetchExpiredFollowUp());
						break;
					}
				}
			}
		}
		if (get_resource_type($link) == 'mysql link')
			mysql_close($link);
	}
	function main() {
		global $parameters;
		$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
		if (get_resource_type($link) == 'mysql link') {
			if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
				switch ($parameters["action"]) {
					case "load_dashboard": {
						$loadgym = new PageLoad();
						echo json_encode($loadgym->LoadGymNames());
						break;
					}
					case "fetchuserrequest": {
						$loadgym = new PageLoad();
						print_r($loadgym->fetchUserRequest());
						break;
					}
					case "fetchuserrequestdet": {
						$loadgym = new PageLoad($_POST);
						echo json_encode($loadgym->fetchUserRequestDetails());
						break;
					}
					case "userreqres": {
						$loadgym = new PageLoad($_POST);
						echo json_encode($loadgym->AcceptnReject());
						break;
					}
                                        //*  Owner User *
                                        case "clientAdminRequest": {
						$loadgym = new owneruser($_POST);
						echo json_encode($loadgym->clientAdminRequest());
						break;
					}
                                        case 'checkemail': {
                                            $loadgym = new owneruser($_POST);
						echo json_encode($loadgym->checkEmail());
                                            break;
                                        }
                                        case "displayallgymsofowner": {
						$obj = new owneruser($_POST);
						echo json_encode($obj->displayAllGymsOfOwner());
						break;
					}
                                        case "displayalladminsofowner": {
						$obj = new owneruser($_POST);
						echo json_encode($obj->displayAllAdminsOfOwner());
						break;
					}
                                        case "addusertogym": {
						$obj = new owneruser($_POST);
						echo json_encode($obj->addUserToGym());
						break;
					}
					case "fetchowneruser": {
						$loadgym = new PageLoad($_POST);
						echo json_encode($loadgym->fetchOwnerUser());
						break;
					}
					case "makeflagnunflag": {
						$loadgym = new PageLoad($_POST);
						echo json_encode($loadgym->makeFlagnUnflag());
						break;
					}
					case "changeuserpass": {
						$loadgym = new PageLoad($_POST);
						echo json_encode($loadgym->changeUserPassword());
						break;
					}
					case "userdeletegym": {
						$loadgym = new PageLoad($_POST);
						echo json_encode($loadgym->userDeleteGym());
						break;
					}
					case "fetchcustrequest": {
						$loadgym = new PageLoad();
						print_r($loadgym->fetchCustRequest());
						break;
					}
					case "fetchcustrequestdet": {
						$loadgym = new PageLoad($_POST);
						echo json_encode($loadgym->fetchCustRequestDetails());
						break;
					}
					case "custreqres": {
						$loadgym = new PageLoad($_POST);
						echo json_encode($loadgym->custAcceptnReject());
						break;
					}
					case "picChangeGYM": {
						if (isset($_FILES)) {
							$para = array(
							"usrid" => isset($_POST["uid"]) ? $_POST["uid"] : false,
							);
							$obj = new profile($para);
							print_r($obj->changeGYMPic($_FILES));
						} else
						echo false;
						break;
					}
					case "setGYM": {
						$id = $_POST["id"];
						$obj = new PageLoad();
						$obj->setGYM($id);
						break;
					}
					case "load_admin_details": {
						$obj = new profile();
						$obj->LoadAdminDetails();
						break;
					}
					case "profileEmailIdForm": {
						$det = array(
						"num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
						"uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
						"index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
						"sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
						"form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
						"email" => isset($_POST["det"]["email"]) ? $_POST["det"]["email"] : false,
						"msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
						"plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
						"minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
						"saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
						"closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
						);
						$prof = new profile($det);
						echo(json_encode($prof->profileEmailIdForm()));
						break;
					}
					case "editProfileEmailId": {
						$emailids = array(
						"emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
						);
						$prof = new profile($emailids);
						echo(json_encode($prof->editProfileEmailId()));
						break;
					}
					/* Fetching Validity Type */
					case "fetchValidityTypes": {
						echo(json_encode(fetchValidityTypes()));
						break;
					}
					case "deleteProfileEmailId": {
						// $emailid = array(
						// "eid"	=> isset($_POST["eid"]) 	? $_POST["eid"]	: false
						// );
						// $prof = new profile($emailid);
						// echo $prof->deleteProfileEmailId();
						break;
					}
					case "listProfileEmailIds": {
						$para = array(
						"uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
						"index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
						"sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
						);
						$prof = new profile($para);
						echo $prof->listProfileEmailIds();
						break;
					}
					case "loadProfileCellNumForm": {
						$det = array(
						"num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
						"uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
						"index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
						"sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
						"form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
						"cnumber" => isset($_POST["det"]["cnumber"]) ? $_POST["det"]["cnumber"] : false,
						"msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
						"plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
						"minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
						"saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
						"closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
						);
						$prof = new profile($det);
						echo(json_encode($prof->loadProfileCellNumForm()));
						break;
					}
					case "editProfileCellNum": {
						$cnums = array(
						"CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
						);
						$prof = new profile($cnums);
						echo(json_encode($prof->editProfileCellNum()));
						break;
					}
					case "deleteProfileCellNum": {
						$cnums = array(
						"eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
						);
						$prof = new profile($cnums);
						echo $prof->deleteProfileCellNum();
						break;
					}
					case "listProfileCellNums": {
						$para = array(
						"uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
						"index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
						"sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
						);
						$prof = new profile($para);
						echo $prof->listProfileCellNums();
						break;
					}
					case "editChangePwd": {
						$det = array(
						"oldpwd" => isset($_POST["det"]["oldpwd"]) ? $_POST["det"]["oldpwd"] : false,
						"newpwd" => isset($_POST["det"]["newpwd"]) ? $_POST["det"]["newpwd"] : false,
						"confirmpwd" => isset($_POST["det"]["confirmpwd"]) ? $_POST["det"]["confirmpwd"] : false,
						"msgdiv" => isset($_POST["det"]["msgdiv"]) ? $_POST["det"]["msgdiv"] : false,
						);
						$prof = new profile($det);
						echo $prof->editChangePwd();
						break;
					}
					case "editProfileAddress": {
						$address = array(
						"index" => isset($_POST["address"]["index"]) ? $_POST["address"]["index"] : false,
						"sindex" => isset($_POST["address"]["listindex"]) ? $_POST["address"]["listindex"] : false,
						"uid" => isset($_POST["address"]["uid"]) ? $_POST["address"]["uid"] : false,
						"gymid" => isset($_POST["address"]["gymid"]) ? $_POST["address"]["gymid"] : false,
						"country" => isset($_POST["address"]["country"]) ? $_POST["address"]["country"] : false,
						"countryCode" => isset($_POST["address"]["countryCode"]) ? $_POST["address"]["countryCode"] : false,
						"province" => isset($_POST["address"]["province"]) ? $_POST["address"]["province"] : false,
						"provinceCode" => isset($_POST["address"]["provinceCode"]) ? $_POST["address"]["provinceCode"] : false,
						"district" => isset($_POST["address"]["district"]) ? $_POST["address"]["district"] : false,
						"city_town" => isset($_POST["address"]["city_town"]) ? $_POST["address"]["city_town"] : false,
						"st_loc" => isset($_POST["address"]["st_loc"]) ? $_POST["address"]["st_loc"] : false,
						"addrsline" => isset($_POST["address"]["addrsline"]) ? $_POST["address"]["addrsline"] : false,
						"zipcode" => isset($_POST["address"]["zipcode"]) ? $_POST["address"]["zipcode"] : false,
						"website" => isset($_POST["address"]["website"]) ? $_POST["address"]["website"] : false,
						"gmaphtml" => isset($_POST["address"]["gmaphtml"]) ? $_POST["address"]["gmaphtml"] : false,
						"timezone" => isset($_POST["address"]["timezone"]) ? $_POST["address"]["timezone"] : false,
						"lat" => isset($_POST["address"]["lat"]) ? $_POST["address"]["lat"] : false,
						"lon" => isset($_POST["address"]["lon"]) ? $_POST["address"]["lon"] : false
						);
						$prof = new profile($address);
						echo $prof->editProfileAddress();
						break;
					}
					case "listProfileAddress": {
						$para = array(
						"uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
						"index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
						"sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false,
						"gymid" => isset($_POST["para"]["gymid"]) ? $_POST["para"]["gymid"] : false
						);
						$prof = new profile($para);
						echo $prof->listProfileAddress();
						break;
					}
					case "load_gym_details": {
						if (isset($_POST["id"])) {
							$id = $_POST["id"];
							unset($_POST);
						}
						$obj = new profile();
						echo $obj->LoadGymDetails($id);
						break;
					}
					case "cust_sex": {
						$sex = new addcustomer();
						$sex->customer_sex();
						break;
					}
					case "addlistuser": {
						$all = new addcustomer();
						$all->returnListofPeoples();
						break;
					}

                                        /* -------------  Add Gym to Data base -------------- */
                                        case "gymAdd": {
						$obj = new clientadd($parameters['gymAdd']);
						print_r($obj->addGYMProfile());
						break;
					}

					/* -----------trainer module-------- */
					case "AddDummyEmail": {
						$para = array(
						"GYM_NAME" => isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"] : GYMNAME,
						);
						$obj = new trainer($para);
						echo $obj->AddDummyEmail();
						break;
					}
					case "fetchTrainerType": {
						$obj = new trainer();
						echo(json_encode($obj->fetchTrainerType()));
						break;
					}
					case "uploadFile": {
						//~ if(!isset($_POST["import_facility"]) || $_POST["import_facility"]!=NULL || !isset($_POST["import_gym"]) || $_POST["import_gym"]!=NULL ){
						//~ echo false;
						//~ }
						//~ else{
						if (isset($_FILES['xls_users_file']) && ($_FILES['xls_users_file']['error'] == UPLOAD_ERR_OK)) {
							$import = array(
							"facility_type" => isset($_POST["import_facility"]) ? $_POST["import_facility"] : false,
							"trainer_type" => isset($_POST["import_gym"]) ? $_POST["import_gym"] : false,
							"GYM_ID" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gym_id"]]["GYM_ID"],
							"GYM_HOST" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gym_id"]]["GYM_HOST"],
							"GYM_USERNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gym_id"]]["GYM_USERNAME"],
							"GYM_DB_PASSWORD" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gym_id"]]["GYM_DB_PASSWORD"],
							"GYM_DB_NAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gym_id"]]["GYM_DB_NAME"],
							);
							//~ print_r($import);
							$obj = new trainer($import);
							$obj->ImportUsers();
							unset($_FILE);
						}
						//~ }
						break;
					}
					// customer module
					case "AddCDummyEmail": {
						$para = array(
						"GYM_NAME" => isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"] : GYMNAME,
						);
						$obj = new addcustomer($para);
						echo $obj->AddDummyEmail();
						break;
					}
					case "uploadFile2": {
						if (isset($_FILES['xls_cust_file']) && ($_FILES['xls_cust_file']['error'] == UPLOAD_ERR_OK)) {
							$import = array(
							"facility_type" => isset($_POST["of_facility"]) ? $_POST["of_facility"] : false,
							"GYM_ID" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_ID"],
							"GYM_HOST" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_HOST"],
							"GYM_USERNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_USERNAME"],
							"GYM_DB_PASSWORD" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_DB_PASSWORD"],
							"GYM_DB_NAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][0]["GYM_DB_NAME"],
							);
							$obj = new addcustomer($import);
							$obj->ImportCustomer();
							unset($_FILE);
						}
						break;
					}
					case "checkEmailEmp": {
						$user = array(
						"email" => isset($_POST["email"]) ? $_POST["email"] : false,
						"empid" => isset($_POST["empid"]) ? $_POST["empid"] : false,
						);
						$obj = new trainer($user);
						echo json_encode($obj->emailExistEmp());
						break;
					}
				}
			}
		}
		if (get_resource_type($link) == 'mysql link')
			mysql_close($link);
	}
	function slave() {
		global $parameters;
		$GYM_HOST = $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_HOST"];
		$GYM_USERNAME = $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_USERNAME"];
		$GYM_DB_PASSWORD = $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_DB_PASSWORD"];
		$GYM_DB_NAME = $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_DB_NAME"];
		$link = MySQLconnect($GYM_HOST, $GYM_USERNAME, $GYM_DB_PASSWORD);
		if (get_resource_type($link) == 'mysql link') {
			if (($db_select = selectDB($GYM_DB_NAME, $link)) == 1) {
				switch ($parameters["action"]) {
					case "fetchKnowAboutUS": {
						$obj = new enquiry();
						echo(json_encode($obj->fetchKnowAboutUS()));
						break;
					}
					case "fetchInterestedIn": {
						$obj = new enquiry();
						echo(json_encode($obj->fetchInterestedIn()));
						break;
					}
					case "autoCompleteEnq": {
						$obj = new enquiry();
						echo(json_encode($obj->autoCompleteEnq()));
						break;
					}
					case "enqAdd": {
						$obj = new enquiry($parameters['enqparams']);
						echo(json_encode($obj->addEnquiry()));
						break;
					}
					case "checkuserinenq": {
						$obj = new enquiry();
						echo(json_encode($obj->checkUserInEnquiry(isset($_POST['cellnum']) ? $_POST['cellnum'] : false)));
						break;
					}
					case "DisplayEnquiryAll": {
						$para = array(
						"enquiry" => true,
						"list_type" => isset($_POST["list_type"]) ? $_POST["list_type"] : false,
						);
						$searchQuery = array(
						"searchQueryA" => ' ',
						"searchQueryB" => ' ',
						"searchQueryC" => ' ',
						"ListQuery" => ' '
						);
						$enq = new enquiry();
						$enq->returnSearchQuery($searchQuery, $para);
						$_SESSION['listofenquiries'] = $enq->listEnquiries($searchQuery);
						if (isset($_SESSION['listofenquiries']) && sizeof($_SESSION['listofenquiries']) > 0) {
							$_SESSION["initial"] = 1;
							$_SESSION["final"] = 10;
							$para["initial"] = $_SESSION["initial"];
							$para["final"] = $_SESSION["final"];
							echo $enq->displayEnquiresList($para["initial"], $para["final"]);
							} else {
							$para["initial"] = 0;
							$para["final"] = 0;
							echo $enq->displayEnquiresList($para["initial"], $para["final"]);
						}
						break;
					}
					case "UpdateListEnquiry": {
						$enq = new enquiry($parameters);
						if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
							if (isset($_SESSION['listofenquiries']) && sizeof($_SESSION['listofenquiries']) > 0) {
								if ($_SESSION["final"] >= sizeof($_SESSION['listofenquiries'])) {
									unset($_SESSION["initial"]);
									unset($_SESSION["final"]);
									echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
									} else {
									$_SESSION["initial"] = $_SESSION["final"] + 1;
									$_SESSION["final"] += 10;
									$enq->displayEnquiresList($_SESSION["initial"], $_SESSION["final"]);
								}
							}
						}
						break;
					}
					case "deleteEnquiry": {
						$del_enq = array(
						"id" => isset($_POST["id"]) ? $_POST["id"] : false,
						);
						$enq = new enquiry($del_enq);
						$delSucc = $enq->deleteEnquiry();
						if ($delSucc)
						echo "Deleted successfully";
						else
						echo "Failed to delete";
						break;
					}
					case "UpdateFollowUp": {
						$follow_cmt = array(
						"id" => isset($_POST["follow"]["id"]) ? $_POST["follow"]["id"] : false,
						"cmt" => isset($_POST["follow"]["com"]) ? $_POST["follow"]["com"] : false,
						);
						$enq = new enquiry($follow_cmt);
						$enq->updateFollowUp();
						break;
					}
					case "UpdateFinalStatus": {
						$stats_cmt = array(
						"id" => isset($_POST["stats"]["id"]) ? $_POST["stats"]["id"] : false,
						"cmt" => isset($_POST["stats"]["com"]) ? $_POST["stats"]["com"] : false,
						);
						$enq = new enquiry($stats_cmt);
						$enq->UpdateFinalStatus();
						break;
					}
					case "LoadSearchHTML": {
						$para = array(
						"Enquiry" => (isset($_POST["ser"]["Enquiry"]) && $_POST["ser"]["Enquiry"] == "true") ? true : false,
						"Group" => (isset($_POST["ser"]["Group"]) && $_POST["ser"]["Group"] == "true") ? true : false,
						"Personal" => (isset($_POST["ser"]["Personal"]) && $_POST["ser"]["Personal"] == "true") ? true : false,
						"Offer" => (isset($_POST["ser"]["Offer"]) && $_POST["ser"]["Offer"] == "true") ? true : false,
						"Package" => (isset($_POST["ser"]["Package"]) && $_POST["ser"]["Package"] == "true") ? true : false,
						"Date" => (isset($_POST["ser"]["Date"]) && $_POST["ser"]["Date"] == "true") ? true : false,
						"All" => (isset($_POST["ser"]["All"]) && $_POST["ser"]["All"] == "true") ? true : false
						);
						$enq = new enquiry();
						$enq->LoadSearchHTML($para);
						break;
					}
					case "search_enq_list": {
						$para = array(
						"enquiry" => true,
						"cust_email" => isset($_POST['spara']['cust_email']) ? $_POST['spara']['cust_email'] : false,
						"cust_name" => isset($_POST['spara']['cust_name']) ? $_POST['spara']['cust_name'] : false,
						"cust_no" => isset($_POST['spara']['cust_no']) ? $_POST['spara']['cust_no'] : false,
						"enq_day" => isset($_POST['spara']['enq_day']) ? $_POST['spara']['enq_day'] : false,
						"followup_date" => isset($_POST['spara']['follow_up']) ? $_POST['spara']['follow_up'] : false,
						"list_type" => "all",
						);
						$searchQuery = array(
						"searchQueryA" => ' ',
						"searchQueryB" => ' ',
						"searchQueryC" => ' ',
						"ListQuery" => ' '
						);
						$enq = new enquiry();
						$enq->returnSearchQuery($searchQuery, $para);
						$_SESSION['listofenquiries'] = $enq->listEnquiries($searchQuery);
						if (isset($_SESSION['listofenquiries']) && sizeof($_SESSION['listofenquiries']) > 0) {
							$_SESSION["initial"] = 1;
							$_SESSION["final"] = 20;
							$enq->displayEnquiresList($_SESSION["initial"], $_SESSION["final"]);
							} else {
							echo $enq->displayEnquiresList(0, 0);
						}
						break;
					}
					case "modeofPayment": {
						$mode = new payment();
						$mode->LoadModeOfPayment();
						break;
					}
					case "addfact": {
						$factNm = $_POST["factNm"];
						$factSt = $_POST["factST"];
						$adfact = new PageLoad();
						$adfact->addfacility($factNm, $factSt);
						break;
					}
					case "showfact": {
						$id = $_REQUEST["id"];
						$showgym = new PageLoad();
						$showgym->getfacility($id);
						break;
					}
					case "showhidestatus": {
						$obj = new showstatus();
						$obj->showhidestatus();
						break;
					}
					case "showhidefact": {
						$showhidefact = new PageLoad();
						$showhidefact->showhidefacility();
						break;
					}
					case "showhide": {
						$factid = $_POST["chid"];
						$active = new PageLoad();
						echo $active->showhideft($factid);
						break;
					}
					case "getallduration1": {
						$dura = $_POST["dura"];
						$dur = new PageLoad();
						$dur->getallduration1($dura);
						break;
					}
					case "getallduration": {
						$dura = isset($_POST["dura"]) ? $_POST["dura"] : false;
						$dur = new PageLoad();
						$dur->getallduration1($dura);
						break;
					}
					case "getallfact": {
						$offerFact = new PageLoad();
						$offerFact->getallfacility();
						break;
					}
					case "getallfact1": {
						$id = $_POST["fid"];
						$offerFact = new PageLoad();
						$offerFact->getallfacility1($id);
						break;
					}
					case "deactiveFact": {
						$id = $_POST["chid"];
						$deactive = new PageLoad();
						$deactive->deactivefacility($id);
						break;
					}
					// generate access id
					case "ascid": {
						$acs = new addcustomer();
						$acs->generateasc_id();
						break;
					}
					// customer add case
					case "customerAdd": {
						$customer_add = array(
							"max_mop" => isset($_POST["eadd"]["max_mop"]) ? $_POST["eadd"]["max_mop"] : false,
							"amount" => isset($_POST["eadd"]["amount"]) ? $_POST["eadd"]["amount"] : false,
							"sum_amount" => isset($_POST["eadd"]["sum_amount"]) ? $_POST["eadd"]["sum_amount"] : false,
							"mod_pay" => isset($_POST["eadd"]["mod_pay"]) ? $_POST["eadd"]["mod_pay"] : false,
							"transaction_number" => isset($_POST["eadd"]["transaction_number"]) ? $_POST["eadd"]["transaction_number"] : false,
							"name" => isset($_POST["eadd"]["name"]) ? $_POST["eadd"]["name"] : false,
							"email" => isset($_POST["eadd"]["email"]) ? $_POST["eadd"]["email"] : false,
							"acsid" => generateRandomString(),
							"cellcode" => isset($_POST["eadd"]["cellcode"]) ? $_POST["eadd"]["cellcode"] : false,
							"cellnum" => isset($_POST["eadd"]["cellnum"]) ? $_POST["eadd"]["cellnum"] : false,
							"occupation" => isset($_POST["eadd"]["occu"]) ? $_POST["eadd"]["occu"] : false,
							"dob" => isset($_POST["eadd"]["dob"]) ? $_POST["eadd"]["dob"] : false,
							"sex_type" => isset($_POST["eadd"]["sex_type"]) ? $_POST["eadd"]["sex_type"] : false,
							"doj" => isset($_POST["eadd"]["doj"]) ? $_POST["eadd"]["doj"] : false,
							"emnm" => isset($_POST["eadd"]["emnm"]) ? $_POST["eadd"]["emnm"] : false,
							"emnum" => isset($_POST["eadd"]["emnum"]) ? $_POST["eadd"]["emnum"] : false,
							"addressline" => isset($_POST["eadd"]["addr"]) ? $_POST["eadd"]["addr"] : false,
							"town" => isset($_POST["eadd"]["town"]) ? $_POST["eadd"]["town"] : false,
							"city" => isset($_POST["eadd"]["city"]) ? $_POST["eadd"]["city"] : false,
							"district" => isset($_POST["eadd"]["district"]) ? $_POST["eadd"]["district"] : false,
							"province" => isset($_POST["eadd"]["province"]) ? $_POST["eadd"]["province"] : false,
							"country" => isset($_POST["eadd"]["country"]) ? $_POST["eadd"]["country"] : false,
							"company" => isset($_POST["eadd"]["company"]) ? $_POST["eadd"]["company"] : false,
							"auth" => md5(generateRandomString()),
							"pass" => generateRandomString(),
							"GYM_ID" => isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_ID"]) ? $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_ID"] : false,
							"GYM_HOST" => $GYM_HOST,
							"GYM_USERNAME" => $GYM_USERNAME,
							"GYM_DB_PASSWORD" => $GYM_DB_PASSWORD,
							"GYM_DB_NAME" => $GYM_DB_NAME,
							"link" => $link
						);
						$obj = new addcustomer($customer_add);
						$data = $obj->addMasterCustomer();
						echo json_encode($obj->addSlaveCustomer($data));
						break;
					}
					case "list_cust": {
						$data = $_POST["fid"];
						$tabid = $_POST["tabid"];
						$lct = new addcustomer();
						$lct->list_cust($data, $tabid);
						break;
					}
					case "listRegCust": {
						$tabid = $_POST["tabid"];
						$lct = new addcustomer();
						$lct->ListOutCust($lct->listRegCust($tabid), null, $tabid);
						break;
					}
					case "custdel": {
						$id = $_POST["cid"]["cid"];
						$mtid = $_POST["cid"]["master_pk"];
						$del = new addcustomer();
						$del->listDel($id);
						break;
					}
					case "Listflag": {
						$id = $_POST["cid"]["cid"];
						$sid = $_POST["cid"]["stId"];
						$mtid = $_POST["cid"]["master_pk"];
						$flag = new addcustomer();
						$flag->listFlag($id, $sid);
						break;
					}
					case "ListUnflag": {
						$id = $_POST["cid"]["cid"];
						$sid = $_POST["cid"]["stId"];
						$mtid = $_POST["cid"]["master_pk"];
						$unflag = new addcustomer();
						$unflag->listunFlag($id, $sid);
						break;
					}
					case "editcust": {
						$cid = $_POST["cid"]["cid"];
						$fid = $_POST["cid"]["fid"];
						$tabid = $_POST["cid"]["tabId"];
						$ecust = new addcustomer();
						echo $ecust->editCustomerList($fid, $cid, $tabid);
						break;
					}
					case "editlistcustdata": {
						$data = $_POST["attr"];
						$addrset = new addcustomer();
						echo json_encode($addrset->editslaveListCust($data));
						break;
					}
					case "custGRPdel": {
						$id = $_POST["cid"];
						$del = new groups();
						$del->listGRPDel($id);
						break;
					}
					case "ListGRPflag": {
						$id = $_POST["cid"];
						$flag = new groups();
						$flag->listGRPFlag($id);
						break;
					}
					case "ListGRPUnflag": {
						$id = $_POST["cid"];
						$unflag = new groups();
						$unflag->listGRPunFlag($id);
						break;
					}
					case "GRPdel": {
						$id = $_POST["gid"];
						$del = new groups();
						$del->gRPDel($id);
						break;
					}
					case "GRPflag": {
						$id = $_POST["gid"];
						$flag = new groups();
						$flag->gRPFlag($id);
						break;
					}
					case "GRPUnflag": {
						$id = $_POST["gid"];
						$unflag = new groups();
						$unflag->gRPunFlag($id);
						break;
					}
					case "editcustlistgrp": {
						$cid = $_POST["cid"];
						$fid = $_POST["fid"];
						$tabid = $_POST["tabId"];
						$i = $_POST["index1"];
						$j = $_POST["index2"];
						$mtid = $_POST["master_pk"];
						$ecust = new groups();
						echo $ecust->editCustomerlistgrp($fid, $cid, $tabid, $i, $j, $mtid);
						break;
					}
					case "editlistcustgrpdata": {
						//$data=$_POST["attr"];
						//$addrset = new groups();
						//echo json_encode($addrset->editListCustGrp($data));
						break;
					}
					case "groupAdd": {
						$import = array(
							"gpdata" => isset($_POST["gadd"]) ? $_POST["gadd"] : false,
							"GYM_ID" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gymid"]]["GYM_ID"],
							"GYM_HOST" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gymid"]]["GYM_HOST"],
							"GYM_USERNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gymid"]]["GYM_USERNAME"],
							"GYM_DB_PASSWORD" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gymid"]]["GYM_DB_PASSWORD"],
							"GYM_DB_NAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$_POST["gymid"]]["GYM_DB_NAME"]
						);
						$obj = new groups($import);
						echo json_encode($obj->addGroup());
						break;
					}
					case "list_group": {
						$data = $_POST["fid"];
						$tabid = $_POST["tid"];
						$lgp = new groups();
						$lgp->list_group($data, $tabid);
						break;
					}
					case "list_groupmem": {
						$gid = $_POST["gid"];
						$tid = $_POST["tid"];
						$fid = $_POST["fid"];
						$lgpm = new groups();
						$lgpm->list_groupmem($gid, $tid, $fid);
						break;
					}
					case "ModeOfPaymentselect": {
						$mop = new addcustomer();
						echo json_encode($mop->ModeOfPaymentselect());
						break;
					}
					case "listGroupMembers": {
						$obj = new groups();
						echo json_encode($obj->listGroupMembers());
						break;
					}
					// Add new offers
					case "addnewoffer": {
						$data = $_POST["ofdata"];
						$inoff = new PageLoad();
						$inoff->addnewoffer($data);
						break;
					}
					case "list_offer": {
						$data = $_POST["fid"];
						$tid = $_POST["tid"];
						$off = new Manage();
						$off->list_offer($data, $tid);
						break;
					}
					case "offerdel": {
						$id = $_POST["of_id"];
						$del = new Manage();
						$del->offerDel($id);
						break;
					}
					case "offerflag": {
						$id = $_POST["of_id"];
						$flag = new Manage();
						$flag->offerFlag($id);
						break;
					}
					case "offerUnflag": {
						$id = $_POST["of_id"];
						$unflag = new Manage();
						$unflag->offerunFlag($id);
						break;
					}
					case "offereditdata": {
						$id = $_POST["of_id"];
						$tid = $_POST["tId"];
						$edit = new Manage();
						$edit->offerEditData($id, $tid);
						break;
					}
					case "deletelistpackage": {
						$pid = $_POST["ppid"]["pid"];
						$tid = $_POST["ppid"]["tabid"];
						$edit = new Manage();
						$edit->deleteLTPackage($pid, $tid);
						break;
					}
					case "list_att": {
						$parameters = array(
						"name" => false,
						"mobile" => false,
						"email" => false,
						"offer" => false,
						"fct_opt" => false,
						"duration" => false,
						"offer_min_mem" => false,
						"package" => false,
						"pack_ses_opt" => false,
						"jnd" => false,
						"exp_date" => false,
						"fct_type" => "*",
						"group" => false,
						"list_type" => "view",
						"fid" => $_POST["att"]["fid"],
						"action" => $_POST["att"]["action"],
						"user" => $_POST["att"]["user"]
						);
						$att = new Attendance($parameters);
						$att->customer_att();
						break;
					}
					case "update_atd": {
						$para = array(
						"pid" => isset($_POST['attdata']['id']) ? $_POST['attdata']['id'] : false,
						"ftype" => isset($_POST['attdata']['facility']) ? $_POST['attdata']['facility'] : false,
						"aid" => (isset($_POST['attdata']['attid'])) && ($_POST['attdata']['attid'] != "NULL") ? $_POST['attdata']['attid'] : "NULL",
						"index" => isset($_POST['attdata']['index']) ? $_POST['attdata']['index'] : false,
						"user" => isset($_POST['attdata']['user']) ? $_POST['attdata']['user'] : false
						);
						$att = new Attendance($para);
						$att->UpdateAtd();
						break;
					}
					case "panelallfacility": {
						$panelall = new PageLoad();
						echo json_encode($panelall->panelfacility());
						break;
					}
					case "showpack_type": {
						$pack = new Manage();
						$pack->listpack_type();
						break;
					}
					case "addPackage": {
						$ptype = $_POST["pack_type"];
						$num = $_POST["numof"];
						$prize = $_POST["prize"];
						$addpack = new Manage();
						$addpack->addPackage($ptype, $num, $prize);
						break;
					}
					case "packname_wise": {
						$ptype = new Manage();
						echo json_encode($ptype->packname_wise());
						break;
					}
					case "packagesdata": {
						$id = $_POST["fid"];
						$tabid = $_POST["tabId"];
						$data = new Manage();
						$data->packagesdata($id, $tabid);
						break;
					}
					case "packname_updates": {
						$para = array(
						"id" => isset($_POST['updata']['uppcidpk']) ? $_POST['updata']['uppcidpk'] : false,
						"pmid" => isset($_POST['updata']['pkid']) ? $_POST['updata']['pkid'] : false,
						"nums" => isset($_POST['updata']['nums']) ? $_POST['updata']['nums'] : false,
						"prz" => isset($_POST['updata']['priz']) ? $_POST['updata']['priz'] : false,
						);
						$data = new Manage($para);
						$data->packageUpdates();
						break;
					}
					case "updatelistdataoffer": {
						$data = array(
						"name" => isset($_POST['attdata']['name']) ? $_POST['attdata']['name'] : false,
						"duration" => isset($_POST['attdata']['duration']) ? $_POST['attdata']['duration'] : false,
						"nod" => isset($_POST['attdata']['numofday']) ? $_POST['attdata']['numofday'] : false,
						"facility" => isset($_POST['attdata']['facility']) ? $_POST['attdata']['facility'] : false,
						"prize" => isset($_POST['attdata']['prize']) ? $_POST['attdata']['prize'] : false,
						"mem" => isset($_POST['attdata']['mem']) ? $_POST['attdata']['mem'] : false,
						"descr" => isset($_POST['attdata']['descr']) ? $_POST['attdata']['descr'] : false,
						"offerId" => isset($_POST['ofId']) ? $_POST['ofId'] : false,
						);
						$data1 = new Manage();
						$data1->updateLtDataOffer($data);
						break;
					}
					/* ----------------- Account module ------------------ */
					case "feeUserList": {
						$para = array(
						"name" => false,
						"mobile" => false,
						"email" => false,
						"offer" => false,
						"fct_opt" => false,
						"duration" => false,
						"offer_min_mem" => false,
						"package" => false,
						"pack_ses_opt" => false,
						"jnd" => false,
						"exp_date" => false,
						"group" => false,
						"list_type" => isset($_POST['fee']['list_type']) ? $_POST['fee']['list_type'] : false,
						"fct_type" => '',
						"fname" => '',
						"sindex" => '',
						"ac" => isset($_POST['fee']['ac']) ? $_POST['fee']['ac'] : false,
						"foption" => isset($_POST['fee']['foption']) ? $_POST['fee']['foption'] : false,
						);
						//~ if($para["list_type"] == "package" || $para["list_type"] == "due"){
						//~ $para["fct_type"] ="";$para["fname"]="";
						//~ }
						$obj = new account();
						$obj->listFeeUser($para);
						$para1 = array(
						"initial" => 0,
						"final" => 0,
						"fct_type" => '',
						"list_type" => $para['list_type'],
						"fname" => '',
						"foption" => $para['foption'],
						"ac" => $para['ac'],
						);
						echo json_encode($obj->displayFeeList($para1));
						/*
							$_SESSION['listfeeusers'] = $obj->listFeeUser($para);
							if (isset($_SESSION['listfeeusers']) && sizeof($_SESSION['listfeeusers']) > 0) {
							$_SESSION['initial'] = 1;
							$_SESSION['final'] = 20;
							$para1 = array(
							"initial" => $_SESSION['initial'],
							"final" => $_SESSION['final'],
							"fct_type" => '',
							"list_type" => $para['list_type'],
							"fname" => '',
							"foption" => $para['foption'],
							"ac" => $para['ac'],
							);
							$obj->displayFeeList($para1);
							} else {
							$para1 = array(
							"initial" => 0,
							"final" => 0,
							"fct_type" => $para['fct_type'],
							"list_type" => $para['list_type'],
							"fname" => $para['fname'],
							"foption" => $para['foption'],
							"ac" => $para['ac'],
							);
							$obj->displayFeeList($para1);
							echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
							}
						*/
						break;
					}
					case "feeUpdateUserList": {
						$obj = new account();
						if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
							if (isset($_SESSION['listfeeusers']) && sizeof($_SESSION['listfeeusers']) > 0) {
								if ($_SESSION["final"] >= sizeof($_SESSION['listfeeusers'])) {
									unset($_SESSION["initial"]);
									unset($_SESSION["final"]);
									echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
									} else {
									$_SESSION["initial"] = $_SESSION["final"] + 1;
									$_SESSION["final"] += 20;
									$para1 = array(
									"initial" => $_SESSION["initial"],
									"final" => $_SESSION["final"],
									"list_type" => isset($_POST['fee']['list_type']) ? $_POST['fee']['list_type'] : false,
									"fct_type" => isset($_POST['fee']['fid']) ? $_POST['fee']['fid'] : false,
									"fname" => isset($_POST['fee']['fname']) ? $_POST['fee']['fname'] : false,
									"ac" => isset($_POST['fee']['ac']) ? $_POST['fee']['ac'] : false,
									"foption" => isset($_POST['fee']['foption']) ? $_POST['fee']['foption'] : false,
									);
									//~ if($para1["list_type"] == "package" || $para1["list_type"] == "due"){
									//~ $para1["fct_type"] ="";$para["fname"]="";
									//~ }
									$para1["fct_type"] = "";
									$para["fname"] = "";
									$obj->displayFeeList($para1);
								}
							}
						}
						break;
					}
					case "AddIndividualFee": {
						unset($_SESSION['invoice_url']);
						$para = array(
						"id" => isset($_POST['indfee']['id']) ? $_POST['indfee']['id'] : false,
						"email" => isset($_POST['indfee']['email']) ? $_POST['indfee']['email'] : false,
						"offer" => isset($_POST['indfee']['offer']) ? $_POST['indfee']['offer'] : false,
						"total" => isset($_POST['indfee']['total']) ? $_POST['indfee']['total'] : false,
						"joining_date" => isset($_POST['indfee']['joining_date']) ? $_POST['indfee']['joining_date'] : false,
						"amount" => isset($_POST['indfee']['amount']) ? (array) ($_POST['indfee']['amount']) : false,
						"transaction_number" => isset($_POST['indfee']['transaction_number']) ? (array) ($_POST['indfee']['transaction_number']) : false,
						"mod_pay" => isset($_POST['indfee']['mod_pay']) ? (array) ($_POST['indfee']['mod_pay']) : false,
						"transaction_type" => isset($_POST['indfee']['transaction_type']) ? $_POST['indfee']['transaction_type'] : false,
						"due_amt" => isset($_POST['indfee']['due_amt']) ? $_POST['indfee']['due_amt'] : false,
						"due_date" => isset($_POST['indfee']['due_date']) ? $_POST['indfee']['due_date'] : NULL,
						"list_type" => isset($_POST['indfee']['list_type']) ? $_POST['indfee']['list_type'] : false,
						"fct_type" => isset($_POST['indfee']['fct_type']) ? $_POST['indfee']['fct_type'] : false,
						"fname" => isset($_POST['indfee']['fname']) ? $_POST['indfee']['fname'] : false,
						"newfacility" => isset($_POST['indfee']['newfacility']) ? $_POST['indfee']['newfacility'] : false,
						"ac" => isset($_POST['indfee']['ac']) ? $_POST['indfee']['ac'] : false,
						"GYMNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"],
						"GYMID" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_ID"],
						);
						if ($para["list_type"] == "package" || $para["list_type"] == "due") {
							$para["fct_type"] = "";
							$para["fname"] = "";
						}
						$obj = new account();
						echo json_encode($obj->AddIndividualFee($para));
						break;
					}
					case "PayIndividualUserForm": {
						$para = array(
						"uid" => isset($_POST['payform']['uid']) ? $_POST['payform']['uid'] : false,
						"index" => isset($_POST['payform']['num']) ? $_POST['payform']['num'] : false,
						"list_type" => isset($_POST['payform']['list_type']) ? $_POST['payform']['list_type'] : false,
						"fct_type" => isset($_POST['payform']['fct_type']) ? $_POST['payform']['fct_type'] : false,
						"fname" => isset($_POST['payform']['fname']) ? $_POST['payform']['fname'] : false,
						"ac" => isset($_POST['payform']['ac']) ? $_POST['payform']['ac'] : false,
						);
						if ($para["list_type"] == "package" || $para["list_type"] == "due") {
							$para["fct_type"] = "";
							$para["fname"] = "";
						}
						$obj = new account();
						$obj->PayIndividualUserForm($para);
						break;
					}
					/* list group */
					case "DisplayListGroups": {
						$parameters = array(
						"gname" => false,
						"owner" => false,
						"min_mem" => false,
						"name" => false,
						"mobile" => false,
						"email" => false,
						"offer" => false,
						"fct_opt" => false,
						"duration" => false,
						"offer_min_mem" => false,
						"package" => false,
						"pack_ses_opt" => false,
						"jnd" => false,
						"exp_date" => false,
						"fct_type" => '',
						"group" => true,
						"list_type" => isset($_POST['fee']['list_type']) ? $_POST['fee']['list_type'] : false,
						"ac" => isset($_POST['fee']['ac']) ? $_POST['fee']['ac'] : false,
						"foption" => isset($_POST['fee']['foption']) ? $_POST['fee']['foption'] : false,
						);
						$obj = new account();
						$obj->ListGroups($parameters);
						$parameters = array(
						"gname" => false,
						"owner" => false,
						"min_mem" => false,
						"name" => false,
						"mobile" => false,
						"email" => false,
						"offer" => false,
						"fct_opt" => false,
						"duration" => false,
						"offer_min_mem" => false,
						"package" => false,
						"pack_ses_opt" => false,
						"jnd" => false,
						"exp_date" => false,
						"fct_type" => '',
						"group" => true,
						"list_type" => isset($_POST['fee']['list_type']) ? $_POST['fee']['list_type'] : false,
						"ac" => isset($_POST['fee']['ac']) ? $_POST['fee']['ac'] : false,
						"foption" => isset($_POST['fee']['foption']) ? $_POST['fee']['foption'] : false,
						"initial" => 0,
						"final" => 0
						);
						echo json_encode($obj->displayListGroups($parameters));
						/*
							if (isset($_SESSION['listofgroups']) && sizeof($_SESSION['listofgroups']) > 0) {
							$_SESSION["initial"] = 1;
							$_SESSION["final"] = 20;
							$parameters = array(
							"gname" => false,
							"owner" => false,
							"min_mem" => false,
							"name" => false,
							"mobile" => false,
							"email" => false,
							"offer" => false,
							"fct_opt" => false,
							"duration" => false,
							"offer_min_mem" => false,
							"package" => false,
							"pack_ses_opt" => false,
							"jnd" => false,
							"exp_date" => false,
							"fct_type" => '',
							"group" => true,
							"list_type" => "offer",
							"ac" => isset($_POST['fee']['ac']) ? $_POST['fee']['ac'] : false,
							"foption" => isset($_POST['fee']['foption']) ? $_POST['fee']['foption'] : false,
							"initial" => $_SESSION["initial"],
							"final" => $_SESSION["final"],
							);
							$obj->displayListGroups($parameters);
							} else {
							$parameters["initial"] = 0;
							$parameters["final"] = 0;
							$obj->displayListGroups($parameters);
							echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
							}
						*/
						break;
					}
					case 'AddGroupFee': {
						unset($_SESSION['invoice_url']);
						unset($_SESSION['invoice']);
						$parameters = array(
						"id" => isset($_POST['grpfee']['id']) ? $_POST['grpfee']['id'] : false,
						"num" => isset($_POST['grpfee']['num']) ? $_POST['grpfee']['num'] : false,
						"email" => isset($_POST['grpfee']['email']) ? $_POST['grpfee']['email'] : false,
						"name" => isset($_POST['grpfee']['name']) ? $_POST['grpfee']['name'] : false,
						"offer" => isset($_POST['grpfee']['offer']) ? $_POST['grpfee']['offer'] : false,
						"total" => isset($_POST['grpfee']['total']) ? $_POST['grpfee']['total'] : false,
						"joining_date" => isset($_POST['grpfee']['joining_date']) ? $_POST['grpfee']['joining_date'] : false,
						"amount" => isset($_POST['grpfee']['amount']) ? (array) ($_POST['grpfee']['amount']) : false,
						"transaction_number" => isset($_POST['grpfee']['transaction_number']) ? (array) ($_POST['grpfee']['transaction_number']) : false,
						"transaction_type" => isset($_POST['grpfee']['transaction_type']) ? $_POST['grpfee']['transaction_type'] : false,
						"mod_pay" => isset($_POST['grpfee']['mod_pay']) ? (array) ($_POST['grpfee']['mod_pay']) : false,
						"due_amt" => isset($_POST['grpfee']['due_amt']) ? $_POST['grpfee']['due_amt'] : false,
						"due_date" => isset($_POST['grpfee']['due_date']) ? $_POST['grpfee']['due_date'] : NULL,
						"payee" => isset($_POST['grpfee']['payee']) ? (array) ($_POST['grpfee']['payee']) : false,
						"ac" => isset($_POST['grpfee']['ac']) ? $_POST['grpfee']['ac'] : false,
						"newfacility" => isset($_POST['grpfee']['newfacility']) ? $_POST['grpfee']['newfacility'] : false,
						"own_pk" => isset($_POST['grpfee']['own_pk']) ? $_POST['grpfee']['own_pk'] : false,
						"list_type" => "offer",
						"fct_type" => isset($_POST['grpfee']['fct_type']) ? $_POST['grpfee']['fct_type'] : false,
						"fname" => isset($_POST['grpfee']['fname']) ? $_POST['grpfee']['fname'] : false,
						"GYMNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"],
						"GYMID" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_ID"],
						);
						$obj = new account();
						echo json_encode($obj->addGroupFee($parameters));
						unset($_POST);
						break;
					}
					/* ------------ pay ------------------------ */
					case "autoCompletePay": {
						$obj = new account();
						echo(json_encode($obj->autoCompletePay()));
						break;
					}
					case "AddPayments": {
						$para = array(
						"name" => isset($_POST['stfpay']['name']) ? $_POST['stfpay']['name'] : false,
						"usr_id" => isset($_POST['stfpay']['usr_id']) ? $_POST['stfpay']['usr_id'] : false,
						"pay_date" => isset($_POST['stfpay']['pay_date']) ? $_POST['stfpay']['pay_date'] : date("Y-m-d"),
						"amount" => isset($_POST['stfpay']['amount']) ? $_POST['stfpay']['amount'] : false,
						"description" => isset($_POST['stfpay']['description']) ? $_POST['stfpay']['description'] : false,
						);
						$obj = new account($para);
						echo(json_encode($obj->AddPayments()));
						break;
					}
					case "AddExpenses": {
						$para = array(
						"name" => isset($_POST['exp']['name']) ? $_POST['exp']['name'] : false,
						"receiptno" => isset($_POST['exp']['receiptno']) ? $_POST['exp']['receiptno'] : false,
						"amount" => isset($_POST['exp']['amount']) ? $_POST['exp']['amount'] : false,
						"pay_date" => isset($_POST['exp']['pay_date']) ? $_POST['exp']['pay_date'] : date("Y-m-d"),
						"description" => isset($_POST['exp']['description']) ? $_POST['exp']['description'] : false,
						);
						$obj = new account($para);
						echo(json_encode($obj->addExpenses()));
						break;
					}
					case "loadSingleDash": {
						$obj = new PageLoad();
						echo(json_encode($obj->loadSingleDash()));
						break;
					}
					/* ----------------- Stats module ------------------ */
					case "listAccountStats": {
						$obj = new statsModule();
						print_r($obj->accountStats());
						break;
					}
					case "listRegistrationStats": {
						$obj = new statsModule();
						print_r($obj->listRegistrationsStats());
						break;
					}
					case "listCustomerStats": {
						$obj = new statsModule();
						echo json_encode($obj->customersStats());
						break;
					}
					case "sendMsg": {
						$para = array(
						"GYMNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"],
						);
						$obj = new statsModule($para);
						print_r($obj->sendAllMsg());
						break;
					}
					case "listEmpStats": {
						$obj = new statsModule();
						print_r($obj->listEmpState());
						break;
					}
					/* -----trainer Module-------- */
					case "trainerAdd": {
						$trainer_add = array(
						"name" => isset($_POST["eadd"]["name"]) ? $_POST["eadd"]["name"] : false,
						"sex_type" => isset($_POST["eadd"]["sex_type"]) ? $_POST["eadd"]["sex_type"] : false,
						"facility_type" => isset($_POST["eadd"]["facility_type"]) ? $_POST["eadd"]["facility_type"] : false,
						"trainer_type" => isset($_POST["eadd"]["trainer_type"]) ? $_POST["eadd"]["trainer_type"] : false,
						"email" => isset($_POST["eadd"]["email"]) ? $_POST["eadd"]["email"] : false,
						"cellcode" => isset($_POST["eadd"]["cellcode"]) ? $_POST["eadd"]["cellcode"] : false,
						"cellnum" => isset($_POST["eadd"]["cellnum"]) ? $_POST["eadd"]["cellnum"] : false,
						"dob" => isset($_POST["eadd"]["dob"]) ? $_POST["eadd"]["dob"] : false,
						"doj" => isset($_POST["eadd"]["doj"]) ? $_POST["eadd"]["doj"] : false,
						"GYM_ID" => isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_ID"]) ? $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_ID"] : false,
						"acsid" => generateRandomString(),
						"pass" => generateRandomString(),
						"auth" => md5(generateRandomString()),
						"GYM_HOST" => $GYM_HOST,
						"GYM_USERNAME" => $GYM_USERNAME,
						"GYM_DB_PASSWORD" => $GYM_DB_PASSWORD,
						"GYM_DB_NAME" => $GYM_DB_NAME,
						);
						$obj = new trainer($trainer_add);
						$data = $obj->addMasterTrainer();
						echo json_encode($obj->addSlaveTrainer($data));
						break;
					}
					case "Changephoto": {
						if (isset($_FILES)) {
							$para = array(
							"photo_id" => isset($_POST["photo_id"]) ? $_POST["photo_id"] : false,
							"user_id" => isset($_POST["user_id"]) ? $_POST["user_id"] : false,
							);
							$obj = new trainer($para);
							print_r($obj->trainerPhotoUpload($_FILES));
						} else
						echo false;
						break;
					}
					case "displayListTrainer": {
						$obj = new trainer();
						echo json_encode($obj->displayListTrainer());
						break;
					}
					case "deleteTrainer": {
						$delete = array(
						"entry" => isset($_POST["traDEL"]) ? $_POST["traDEL"] : false
						);
						$obj = new trainer($delete);
						echo $obj->deleteTrainer();
						break;
					};
					case "flagTrainer": {
						$flag = array(
						"fuid" => isset($_POST["fuser"]) ? $_POST["fuser"] : false,
						);
						$obj = new trainer($flag);
						echo $obj->flagTrainer();
						break;
					}
					case "unflagTrainer": {
						$unflag = array(
						"ufuid" => isset($_POST["ufuser"]) ? $_POST["ufuser"] : false,
						);
						$obj = new trainer($unflag);
						echo $obj->unflagTrainer();
						break;
					}
					case "edittrainer": {
						$user = array(
						"trainerid" => isset($_POST["usrid"]) ? $_POST["usrid"] : false
						);
						$obj = new trainer($user);
						$obj->edittrainer();
						break;
					}
					case "trainerUpdate": {
						$trainer_update = array(
						"upuid" => isset($_POST["uid"]) ? $_POST["uid"] : false,
						"name" => isset($_POST["eadd"]["name"]) ? $_POST["eadd"]["name"] : false,
						"email" => isset($_POST["eadd"]["email"]) ? $_POST["eadd"]["email"] : false,
						"cellcode" => isset($_POST["eadd"]["cellcode"]) ? $_POST["eadd"]["cellcode"] : false,
						"cellnum" => isset($_POST["eadd"]["cellnum"]) ? $_POST["eadd"]["cellnum"] : false,
						"dob" => isset($_POST["eadd"]["dob"]) ? $_POST["eadd"]["dob"] : false,
						"doj" => isset($_POST["eadd"]["doj"]) ? $_POST["eadd"]["doj"] : false,
						"GYM_ID" => isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_ID"]) ? $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_ID"] : false,
						"GYM_HOST" => $GYM_HOST,
						"GYM_USERNAME" => $GYM_USERNAME,
						"GYM_DB_PASSWORD" => $GYM_DB_PASSWORD,
						"GYM_DB_NAME" => $GYM_DB_NAME,
						);
						$obj = new trainer($trainer_update);
						$obj->updateMasterTrainer();
						$obj1 = new trainer($trainer_update);
						$obj1->updateSlaveTrainer();
						break;
					}
					case "picUpdate": {
						if (isset($_FILES)) {
							$para = array(
							"photo_id" => isset($_POST["photo_id"]) ? $_POST["photo_id"] : false,
							"user_id" => isset($_POST["user_id"]) ? $_POST["user_id"] : false,
							);
							$obj = new trainer($para);
							print_r($obj->trainerPhotoUpload($_FILES));
						} else
						echo false;
						break;
					}
					case "custpicUpdate": {
						if (isset($_FILES)) {
							$para = array(
							"photo_id" => isset($_POST["photo_id"]) ? $_POST["photo_id"] : false,
							"user_id" => isset($_POST["user_id"]) ? $_POST["user_id"] : false,
							);
							$obj = new addcustomer($para);
							print_r($obj->customerEditPhotoUpload($_FILES));
						} else
						echo false;
						break;
					}
					/* ----------------- CRM ------------------ */
					case "loadAllMsg": {
						$para = array(
						"ap" => isset($_POST["ap"]) ? (array) $_POST["ap"] : false
						);
						$obj = new crmModule($para);
						$_SESSION['msg_list'] = $obj->loadAllMsg();
						$obj->listCustomer();
						break;
					}
					case "displayMsg": {
						$para = array(
						"ap" => isset($_POST["ap"]) ? (array) $_POST["ap"] : false,
						"index" => isset($_POST['index']) ? $_POST['index'] : false,
						"GYMNAME" => ((isset($parameters["current_gym_id"])) && (isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]))) ? $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"] : "Gym Name"
						);
						$obj = new crmModule($para);
						$obj->displayMsg();
						break;
					}
					case "createMessage": {
						$para = array(
						"ap" => isset($_POST["ap"]) ? $_POST["ap"] : false,
						"id" => isset($_POST['id']) ? $_POST['id'] : false,
						"GYMNAME" => ((isset($parameters["current_gym_id"])) && (isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]))) ? $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"] : "Gym Name"
						);
						$obj = new crmModule($para);
						$obj->createMessage();
						break;
					}
					case "statistics": {
						$para = array(
						"ap" => isset($_POST["ap"]) ? $_POST["ap"] : false,
						"id" => isset($_POST['id']) ? $_POST['id'] : false,
						"GYMNAME" => ((isset($parameters["current_gym_id"])) && (isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]))) ? $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"] : "Gym Name"
						);
						$obj = new crmModule($para);
						$obj->statistics();
						break;
					}
					case "send_app_msg": {
						$para = array(
						"ap" => isset($_POST["ap"]) ? $_POST["ap"] : false,
						"msg_to" => isset($_POST['msg_to']) ? (array) $_POST['msg_to'] : false,
						"msg_content" => isset($_POST['msg_content']) ? nl2br($_POST['msg_content']) : false,
						"arr_type" => isset($_POST['arr_type']) ? $_POST['arr_type'] : false,
						"msg_sub" => isset($_POST['msg_sub']) ? $_POST['msg_sub'] : false,
						"GYMNAME" => ((isset($parameters["current_gym_id"])) && (isset($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"]))) ? $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"] : "Gym Name"
						);
						$obj = new crmModule($para);
						$obj->SendMsg();
						break;
					}
					//feedback
					case "loadAllFeedback": {
						$para = array(
						"fb" => isset($_POST["fb"]) ? $_POST["fb"] : false
						);
						$obj = new crmModule($para);
						$_SESSION['msg_list'] = $obj->loadAllFeedback();
						if ($_SESSION['msg_list'] != NULL) {
							$_SESSION['initial'] = 1;
							$_SESSION['final'] = 20;
							$obj->ListUsersFeedback($_SESSION['initial'], $_SESSION['final']);
						} else
						$obj->ListUsersFeedback(0, 0);
						break;
					}
					case "LoadFeedbackForm": {
						$obj = new crmModule();
						$obj->LoadFeedbackForm();
						break;
					}
					case "save_feedback": {
						$para = array(
						"name" => isset($_POST["fb"]["name"]) ? $_POST["fb"]["name"] : false,
						"complent" => isset($_POST["fb"]["complent"]) ? $_POST["fb"]["complent"] : false,
						"msg_to" => isset($_POST["fb"]["msg_to"]) ? $_POST["fb"]["msg_to"] : false,
						"equipment" => isset($_POST["temp"]["0"]) ? $_POST["temp"]["0"] : false,
						"trainer" => isset($_POST["temp"]["1"]) ? $_POST["temp"]["1"] : false,
						"atmosphere" => isset($_POST["temp"]["2"]) ? $_POST["temp"]["2"] : false,
						"gym_clean" => isset($_POST["temp"]["3"]) ? $_POST["temp"]["3"] : false,
						"price" => isset($_POST["temp"]["4"]) ? $_POST["temp"]["4"] : false,
						"gym_facility" => isset($_POST["temp"]["5"]) ? $_POST["temp"]["5"] : false,
						"music" => isset($_POST["temp"]["6"]) ? $_POST["temp"]["6"] : false,
						"lightings" => isset($_POST["temp"]["7"]) ? $_POST["temp"]["7"] : false,
						);
						$obj = new crmModule($para);
						echo $obj->SaveFeedback();
						break;
					}
					case "displayFeedBack": {
						$para = array(
						"fb" => isset($_POST["fb"]) ? $_POST["fb"] : false,
						"index" => isset($_POST['index']) ? $_POST['index'] : false,
						"GYMNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"],
						);
						$obj = new crmModule($para);
						$obj->displayFeedBack();
						break;
					}
					case "load_total_feedback": {
						$obj = new crmModule();
						echo $obj->LoadTotalMsg();
						break;
					}
					/* ------------------------------- report-Club -------------------- */
					case "reportClub": {
						$attrValue = $_POST['attrValue'] ? $_POST['attrValue'] : NULL;
						$from = $_POST['date1'] ? $_POST['date1'] : NULL;
						$to = $_POST['date2'] ? $_POST['date2'] : NULL;
						$fromdate = 0;
						$todate = 0;
						$fname = $_POST['fname'] ? $_POST['fname'] : NULL;
						$fct_id = $_POST['fid'] ? $_POST['fid'] : NULL;
						/* Parameter verification */
						if ($from != NULL && $to != NULL) {
							$temp0 = explode("-", $from);
							$y0 = (int) $temp0[0];
							$m0 = (int) $temp0[1];
							$d0 = (int) $temp0[2];
							$fromdate = (int) strtotime($d0 .
							'-' . $m0 .
							'-' . $y0);
							$temp1 = explode("-", $to);
							$y = (int) $temp1[0];
							$m = (int) $temp1[1];
							$d = (int) $temp1[2];
							$todate = (int) strtotime($d .
							'-' . $m .
							'-' . $y);
							} else if ($from != NULL && $to == NULL) {
							$temp0 = explode("-", $from);
							$y0 = (int) $temp0[0];
							$m0 = (int) $temp0[1];
							$d0 = (int) $temp0[2];
							$fromdate = (int) strtotime($d0 .
							'-' . $m0 .
							'-' . $y0);
							$todate = 0;
							} else if ($from == NULL && $to != NULL) {
							$fromdate = 0;
							$temp1 = explode("-", $to);
							$y = (int) $temp1[0];
							$m = (int) $temp1[1];
							$d = (int) $temp1[2];
							$todate = (int) strtotime($d .
							'-' . $m .
							'-' . $y);
							$fromdate = 0;
						}
						$report_add = array(
						"from" => $from,
						"to" => $to,
						"fromdate" => $fromdate,
						"todate" => $todate,
						"list_type" => $attrValue,
						"fname" => $fname,
						"fct_id" => $fct_id,
						);
						$obj = new gymreport($report_add);
						echo $obj->GymFeeReport();
						break;
					}
					/* ------------------------------- Registration Report -------------------- */
					case "reportRegistration": {
						$attrName = $_POST['attrName'] ? $_POST['attrName'] : NULL;
						$from = $_POST['date1'] ? $_POST['date1'] : NULL;
						$to = $_POST['date2'] ? $_POST['date2'] : NULL;
						$fromdate = 0;
						$todate = 0;
						/* Parameter verification */
						if ($from != NULL && $to != NULL) {
							$temp0 = explode("-", $from);
							$y0 = (int) $temp0[0];
							$m0 = (int) $temp0[1];
							$d0 = (int) $temp0[2];
							$fromdate = (int) strtotime($d0 .
							'-' . $m0 .
							'-' . $y0);
							$temp1 = explode("-", $to);
							$y = (int) $temp1[0];
							$m = (int) $temp1[1];
							$d = (int) $temp1[2];
							$todate = (int) strtotime($d .
							'-' . $m .
							'-' . $y);
							} else if ($from != NULL && $to == NULL) {
							$temp0 = explode("-", $from);
							$y0 = (int) $temp0[0];
							$m0 = (int) $temp0[1];
							$d0 = (int) $temp0[2];
							$fromdate = (int) strtotime($d0 .
							'-' . $m0 .
							'-' . $y0);
							$todate = 0;
							} else if ($from == NULL && $to != NULL) {
							$fromdate = 0;
							$temp1 = explode("-", $to);
							$y = (int) $temp1[0];
							$m = (int) $temp1[1];
							$d = (int) $temp1[2];
							$todate = (int) strtotime($d .
							'-' . $m .
							'-' . $y);
							$fromdate = 0;
						}
						$attrValue = $_POST['attrValue'] ? $_POST['attrValue'] : NULL;
						$report_registration = array(
						"attrName" => $attrName,
						"from" => $from,
						"to" => $to,
						"fromdate" => $fromdate,
						"todate" => $todate,
						"fname" => $attrValue,
						"GYMNAME" => $_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$parameters["current_gym_id"]]["GYM_NAME"],
						);
						$obj = new registrationreport($report_registration);
						if ($report_registration['attrName'] == "RegistrationReport")
						$obj->RegistrationReport();
						else if ($report_registration['attrName'] == "PaymentsReport")
						$obj->PaymentsReport();
						else if ($report_registration['attrName'] == "ExpensesReport")
						$obj->ExpensesReport();
						else if ($report_registration['attrName'] == "BalanceSheet")
						print_r($obj->BalanceSheet());
						else if ($report_registration['attrName'] == "PackageReport")
						print_r($obj->PackageReport());
						else if ($report_registration['attrName'] == "CustomerAttendanceReport")
						print_r($obj->CustomerAttendanceReport());
						else if ($report_registration['attrName'] == "TrainerAttendanceReport")
						print_r($obj->TrainerAttendanceReport());
						break;
					}
					/* -----------Receipt Report---------- */
					case "DisplayReceipt": {
						$disreceipt = array(
						"receipt	" => true,
						);
						$obj = new receipts($disreceipt);
						$_SESSION['rec'] = $obj->loadReceipts($disreceipt);
						if (isset($_SESSION['rec']) && sizeof($_SESSION['rec']) > 0) {
							//~ $_SESSION["initial"] = 1;
							//~ $_SESSION["final"] = 20;
							//~ $para["initial"] = $_SESSION["initial"];
							//~ $para["final"] = $_SESSION["final"];
							// print_r($obj->DisplayMsg($_SESSION['rec'],$_SESSION['initial'],$_SESSION['final']));
							print_r($obj->DisplayMsgTable($_SESSION['rec']));
							} else {
							$para["initial"] = 0;
							$para["final"] = 0;
							print_r($obj->DisplayMsg($_SESSION['rec'], $para["initial"], $para["final"]));
						}
						break;
					}
					/* -----------Search Receipt Report---------- */
					case "search_rec_list": {
						$name_o_email = $_POST['by_name_o_email'] ? $_POST['by_name_o_email'] : NULL;
						$date = $_POST['by_date'] ? $_POST['by_date'] : NULL;
						$pararec = array(
						"nameemail" => isset($_POST['by_name_o_email']) ? $_POST['by_name_o_email'] : false,
						"bydate" => isset($_POST['by_date']) ? $_POST['by_date'] : false,
						"receipt" => true,
						);
						$obj = new receipts($pararec);
						$_SESSION['rec'] = $obj->loadReceipts();
						if (isset($_SESSION['rec']) && sizeof($_SESSION['rec']) > 0) {
							$_SESSION["initial"] = 1;
							$_SESSION["final"] = 20;
							$para["initial"] = $_SESSION["initial"];
							$para["final"] = $_SESSION["final"];
							print_r($obj->DisplayMsg($_SESSION['rec'], $_SESSION['initial'], $_SESSION['final']));
							} else {
							echo "<h1 class='text-danger'>No Receipts to display. </h1>";
							$para["initial"] = 0;
							$para["final"] = 0;
							print_r($obj->DisplayMsg($_SESSION['rec'], $_SESSION['initial'], $_SESSION['final']));
						}
						break;
					}
					case 'printOffer': {
						$para = array(
						"id" => isset($_POST['id']) ? $_POST['id'] : false,
						"index" => isset($_POST['fid']) ? $_POST['fid'] : "",
						"jsfunction" => 'SetIndivisualAmt',
						);
						$obj = new account();
						$listofoffersHtml = $obj->returnListedOffers($para);
						break;
					}
					case 'fetchExpAndDue': {
						$para = array(
						"id" => isset($_POST['id']) ? $_POST['id'] : false,
						"fid" => isset($_POST['fid']) ? $_POST['fid'] : false,
						);
						$obj = new account($para);
						echo json_encode($obj->returnDueAndExp());
						break;
					}
				}
			}
		}
		if (get_resource_type($link) == 'mysql link')
			mysql_close($link);
	}
	function madmecmanage() {
		global $parameters;
		$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
		if (get_resource_type($link) == 'mysql link') {
			if (($db_select = selectDB(MADMEC_MANAGE, $link)) == 1) {
				switch ($parameters["action"]) {
					case "autoCompleteEnq": {
						$obj = new madmec_manage();
						echo(json_encode($obj->autoCompleteEnq()));
						break;
					}
				}
			}
		}
		if (get_resource_type($link) == 'mysql link')
			mysql_close($link);
	}
	function madmecjddata() {
		global $parameters;
		$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
		if (get_resource_type($link) == 'mysql link') {
			if (($db_select = selectDB(MADMEC_JDDATA, $link)) == 1) {
				switch ($parameters["action"]) {
					case "fetchlistofcity": {
						$obj = new sms();
						echo(json_encode($obj->fetchListOfCity()));
						break;
					}
					case "listofgyms": {
						$obj = new sms($_POST);
						echo(json_encode($obj->listOfGyms()));
						break;
					}
					case "sendsms": {
						$obj = new sms($_POST);
						echo(json_encode($obj->sendSMS()));
						break;
					}
				}
			}
		}
		if (get_resource_type($link) == 'mysql link')
			mysql_close($link);
	}
	// Customer Controller
	function customer() {
		global $parameters;
		$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
		if (get_resource_type($link) == 'mysql link') {
			if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
				$request =  explode('/', $parameters["action"]);
				if(sizeof($request) == 2){
					$obj=new $request[0]($_POST);
					echo json_encode($obj->$request[1]());
				}
				/*
				case "customerPhotoUpload": {
					$photo = array(
					"photo_id" => isset($_POST["id"]["id"]) ? $_POST["id"]["id"] : false,
					);
					$obj = new addcustomer($photo);
					echo $obj->customerPhotoUpload();
					break;
				}
				case "ChangeCphoto": {
					if (isset($_FILES)) {
						$para = array(
						"photo_id" => isset($_POST["photo_id"]) ? $_POST["photo_id"] : false,
						);
						$obj = new addcustomer($para);
						print_r($obj->customerPhotoUpload($_FILES));
					} else
					echo false;
					break;
				}
				case "custdel": {
					$id = $_POST["cid"]["cid"];
					$mtid = $_POST["cid"]["master_pk"];
					$del = new addcustomer();
					$del->listDel($id);
					$del->masterlistDel($mtid);
					break;
				}
				case "Listflag": {
					$id = $_POST["cid"]["cid"];
					$sid = $_POST["cid"]["stId"];
					$mtid = $_POST["cid"]["master_pk"];
					$flag = new addcustomer();
					$flag->listFlag($id, $sid);
					$flag->masterlistFlag($mtid);
					break;
				}
				case "ListUnflag": {
					$id = $_POST["cid"]["cid"];
					$sid = $_POST["cid"]["stId"];
					$mtid = $_POST["cid"]["master_pk"];
					$unflag = new addcustomer();
					$unflag->listunFlag($id, $sid);
					$unflag->masterlistunFlag($mtid);
					break;
				}
				case "editcust": {
					$cid = $_POST["cid"]["cid"];
					$fid = $_POST["cid"]["fid"];
					$tabid = $_POST["cid"]["tabId"];
					$ecust = new addcustomer();
					echo $ecust->editCustomerList($fid, $cid, $tabid);
					break;
				}
				case "editlistcustdata": {
					$data = $_POST["attr"];
					$addrset = new addcustomer();
					echo json_encode($addrset->editslaveListCust($data));
					break;
				}
				case "editcustlistgrp": {
					$cid = $_POST["cid"];
					$fid = $_POST["fid"];
					$tabid = $_POST["tabId"];
					$i = $_POST["index1"];
					$j = $_POST["index2"];
					$mtid = $_POST["master_pk"];
					$ecust = new addcustomer();
					echo $ecust->editCustomerlistgrp($fid, $cid, $tabid, $i, $j, $mtid);
					break;
				}
				case "editlistcustgrpdata": {
					//$data=$_POST["attr"];
					//$addrset = new addcustomer();
					//echo json_encode($addrset->editListCustGrp($data));
					break;
				}
				*/
			}
		}
		if (get_resource_type($link) == 'mysql link')
			mysql_close($link);
	}
	function firstExecuteMe(){
		$flag = false;
		$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
		if (get_resource_type($link) == 'mysql link') {
			if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
				if (!ValidateAdmin()) {
					session_destroy();
					echo "logout";
					$flag = true;
				}
			}
		}
		if (get_resource_type($link) == 'mysql link')
			mysql_close($link);
		if($flag){
			exit(0);
		}
	}
	if(isset($parameters['autoloader']) && isset($parameters['master_slave_db']) && $parameters['autoloader'] == 'true'){
		firstExecuteMe();
		switch($parameters['master_slave_db']){
			case 'master':{
				if ((isset($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"]))) {
					switch($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"]){
						case 'Admin':{
							main();
							break;
						}
						case 'Owner':{
							main();
							break;
						}
						case 'MMAdmin':{
							superMain();
							break;
						}
					}
				}
				break;
			}
			case 'slave':{
				slave();
				break;
			}
			case 'madmecmanage':{
				madmecmanage();
				break;
			}
			case 'jddata':{
				madmecjddata();
				break;
			}
			case 'customer':{
				customer();
				break;
			}
		}
		unset($_POST);
		exit(0);
	}
	if(!isset($_SESSION["USER_LOGIN_DATA"]['USER_ID'])):
		echo '<script langauge="javascript">window.location.href="'.URL.'";</script>';
	endif;
	if ((isset($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"]))) {
		require_once(DOC_ROOT . INC . $_SESSION["USER_LOGIN_DATA"]["USER_TYPE"].'.php');
	}
	require_once(DOC_ROOT . INC . 'res-footer.php');
?>