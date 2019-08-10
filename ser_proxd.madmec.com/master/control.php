<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);

        /* SUPER ADMIN FILES INCLUDEING */
        require_once (SA_ADMIN_COLLECTION);
        require_once (SA_CLIENT);
        require_once (SA_ORDER);
        require_once (SA_DUE);
        require_once (SA_FALLOWUP);



        /* Change Password */
        $channgepass=array(
            "newpassword" => isset($_POST["details"]["newpassword"]) ?  $_POST["details"]["newpassword"] : false,
            "confirmpassword" => isset($_POST["details"]["confirmpassword"]) ?  $_POST["details"]["confirmpassword"] : false,
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


        function  mastermain($parameters)
        {
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
//			if(($db_select = selectDB(MASTER_DBNAME_ZERO,$link)) == 1){

                            if(($db_select = selectDB(DBNAME_MASTER,$link)) == 1){
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
								"db_name"		=> 'prox_slave'.generateRandomString().time(),
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
                                            case "fetchmops":
							$obj = new client();
							echo (json_encode($obj->fetchMops()));
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
						case "fetchmotypes":
                                                        $obj = new admincollection();
							echo (json_encode($obj->getSAMOPTypes()));

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
                                                case "deletentfyUser":
							$delete_ntfy = array(
								"entry" 	=> isset($_POST["ptydeletesale"]["entid"]) 		? $_POST["ptydeletesale"]["entid"]	: false
							);
							$obj = new order($delete_ntfy);
							echo $obj->deletentfyUser();
                                                        break;
						break;
                                                case "fetchadminnotify":
							$obj = new order();
							echo json_encode($obj->fetchAdminNotify());
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
                                                            $due=new dueadmin();
                                                            echo json_encode($due->fetchAdminDues());
                                                            }
                                                            break;
                                                case "payadmindues" :
                                                            {
                                                            $details=array(
                                                                "userpk" => isset($_POST['details']['userpk']) ? $_POST['details']['userpk'] : false,
                                                                "amt" => isset($_POST['details']['amt']) ? $_POST['details']['amt'] : false,
                                                               "mop" => isset($_POST['details']['mop']) ? $_POST['details']['mop'] : false,
                                                            );
                                                            $due=new dueadmin($details);
                                                            echo json_encode($due->payAdminDue());
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
        if((isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') )
        {
          global $parameters;
          mastermain($parameters);
          unset($_POST);
          exit(0);
        }
	require_once(DOC_ROOT.MASTER.INC.'header.php');
        require_once(DOC_ROOT.MASTER.INC.'menuadmin.php');
	require_once(DOC_ROOT.MASTER.INC.'interface.php');
	require_once(DOC_ROOT.MASTER.INC.'footer.php');
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