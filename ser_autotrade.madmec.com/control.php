<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once (MODULE_USER);
require_once (MODULE_PRODUCT);
require_once (MODULE_SALE);
require_once (MODULE_PURCHASE);
require_once (MODULE_COLLECTION);
require_once (MODULE_PAYMENT);
require_once (MODULE_CRM);
require_once (MODULE_PROFILE);
require_once (MODULE_ORDER);
require_once (MODULE_CLIENT);
require_once (MODULE_ADMINCOLLECTION);
require_once (MODULE_ADMINDUE);
require_once (MODULE_ADMINFOLLOWUP);
require_once (MODULE_ALERT);
require_once (MODULE_SETTING);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
    "soruce" => isset($_POST["soruce"]) ? $_POST["soruce"] : false,
    "master_slave_db" => isset($_POST["type"]) ? $_POST["type"] : false,
);
if (isset($_POST["action1"]))
    $parameters["action"] = $_POST["action1"];
function main($parameters) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            if (!ValidateAdmin()) {
                session_destroy();
                echo "logout";
            } else {
                switch ($parameters["action"]) {
                    case "clientAdd":
                        if ($_POST["distributer_name"] != "" && $_POST["owners_name"] != "" && preg_match('%^[A-Z_a-z\."\-]{3,100}%', $_POST["distributer_name"]) && preg_match('%^[A-Z_a-z\."\-]{3,100}%', $_POST["owners_name"])) {
                            $client_add = array(
                                "name" => isset($_POST["distributer_name"]) ? $_POST["distributer_name"] : false,
                                "username" => isset($_POST["usernameclient"]) ? $_POST["usernameclient"] : false,
                                "owner" => isset($_POST["owners_name"]) ? $_POST["owners_name"] : false,
                                "type" => isset($_POST["validity_type"]) ? $_POST["validity_type"] : false,
                                "paydate" => isset($_POST["payment_date"]) ? $_POST["payment_date"] : false,
                                "subdate" => isset($_POST["subscribe_date"]) ? $_POST["subscribe_date"] : false,
                                "email" => isset($_POST["email"]) ? (array) $_POST["email"] : false,
                                "cellnumbers" => isset($_POST["cellnumbers"]) ? (array) $_POST["cellnumbers"] : false,
                                "doctype" => isset($_POST["doc_type"]) ? $_POST["doc_type"] : false,
                                "docno" => isset($_POST["doc_number"]) ? $_POST["doc_number"] : false,
                                "pcode" => isset($_POST["pcode"]) ? $_POST["pcode"] : false,
                                "tphone" => isset($_POST["telephone"]) ? $_POST["telephone"] : false,
                                "sms" => isset($_POST["sms_cost"]) ? $_POST["sms_cost"] : false,
                                "country" => isset($_POST["country"]) ? $_POST["country"] : false,
                                "countryCode" => isset($_POST["countryCode"]) ? $_POST["countryCode"] : false,
                                "province" => isset($_POST["province"]) ? $_POST["province"] : false,
                                "provinceCode" => isset($_POST["provinceCode"]) ? $_POST["provinceCode"] : false,
                                "district" => isset($_POST["district"]) ? $_POST["district"] : false,
                                "city_town" => isset($_POST["city_town"]) ? $_POST["city_town"] : false,
                                "st_loc" => isset($_POST["st_loc"]) ? $_POST["st_loc"] : false,
                                "addrsline" => isset($_POST["addrs"]) ? $_POST["addrs"] : false,
                                "zipcode" => isset($_POST["zipcode"]) ? $_POST["zipcode"] : false,
                                "website" => isset($_POST["website"]) ? $_POST["website"] : false,
                                "gmaphtml" => isset($_POST["gmaphtml"]) ? $_POST["gmaphtml"] : false,
                                "timezone" => isset($_POST["timezone"]) ? $_POST["timezone"] : false,
                                "lat" => isset($_POST["lat"]) ? $_POST["lat"] : false,
                                "lon" => isset($_POST["lon"]) ? $_POST["lon"] : false,
                                "db_host" => 'localhost',
                                "db_username" => 'root',
                                "db_name" => 'auto_slave' . generateRandomString() . time(),
                                "db_password" => DBPASS,
                                "password" => generateRandomString(),
                                "acs" => generateRandomString(),
                            );
                            $obj = new client($client_add);
                            echo json_encode($obj->clientadd($_FILES));
                        } else
                            echo false;
                        exit(0);
                        break;
                    case "fetchValidityTypes":
                        $obj = new client();
                        echo (json_encode($obj->fetchValidityTypes()));
                        break;
                    case "checkclientusername":
                        $obj = new client();
                        $chkusername = isset($_POST['chkusername']) ? $_POST['chkusername'] : false;
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
                    case "fetchadminnotify":
                        $obj = new order();
                        echo json_encode($obj->fetchAdminNotify());
                        break;
                    case "DisplayUserList":
                        $obj = new client();
                        $_SESSION["listofclients"] = $obj->clientProfile();
                        if (isset($_SESSION["listofclients"]) && sizeof($_SESSION["listofclients"]) > 0) {
                            $_SESSION["initial"] = 0;
                            $_SESSION["final"] = 10;
                            $para["initial"] = $_SESSION["initial"];
                            $para["final"] = $_SESSION["final"];
                            echo json_encode($obj->displayUserList($para));
                        } else {
                            $para["initial"] = 0;
                            $para["final"] = 0;
                            echo json_encode($obj->displayUserList($para));
                        }
                        break;
                    case "DisplayUpdatedUserList":
                        $obj = new client();
                        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
                            if (isset($_SESSION["listofclients"]) && sizeof($_SESSION["listofclients"]) > 0) {
                                if ($_SESSION["final"] >= sizeof($_SESSION["listofclients"])) {
                                    unset($_SESSION["initial"]);
                                    unset($_SESSION["final"]);
                                    $temp[] = array(
                                        "html" => '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>',
                                        "uid" => 0,
                                        "sr" => '',
                                    );
                                    echo json_encode($temp);
                                } else {
                                    $_SESSION["initial"] = $_SESSION["final"] + 1;
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
                        $obj = new client($det);
                        echo (json_encode($obj->loadEmailIdForm()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "editEmailId":
                        $emailids = array(
                            "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                        );
                        $obj = new client($emailids);
                        echo (json_encode($obj->editEmailId()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "deleteEmailId":
                        $emailid = array(
                            "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                        );
                        $obj = new client($emailid);
                        echo $obj->deleteEmailId();
                        break;
                    case "listEmailIds":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $obj = new client($para);
                        echo $obj->listEmailIds();
                        break;
                    case "LoadAlerts":
                        $obj = new alerts();
                        echo $obj->LoadAlerts();
                        break;
                    case "loadCellNumForm":
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
                        $obj = new client($det);
                        echo (json_encode($obj->loadCellNumForm()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "editCellNum":
                        $cnums = array(
                            "CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
                        );
                        $obj = new client($cnums);
                        echo (json_encode($obj->editCellNum()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "deleteCellNum":
                        $cnums = array(
                            "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                        );
                        $obj = new client($cnums);
                        echo $obj->deleteCellNum();
                        break;
                    case "listCellNums":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $obj = new client($para);
                        echo $obj->listCellNums();
                        break;
                    case "editAddress":
                        $address = array(
                            "index" => isset($_POST["address"]["index"]) ? $_POST["address"]["index"] : false,
                            "sindex" => isset($_POST["address"]["listindex"]) ? $_POST["address"]["listindex"] : false,
                            "uid" => isset($_POST["address"]["uid"]) ? $_POST["address"]["uid"] : false,
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
                        $obj = new client($address);
                        echo $obj->editAddress();
                        break;
                    case "listAddress":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $obj = new client($para);
                        echo $obj->listAddress();
                        break;
                    case "deleteUser":
                        $delete = array(
                            "entry" => isset($_POST["ptydeletesale"]) ? $_POST["ptydeletesale"] : false
                        );
                        $obj = new client($delete);
                        echo $obj->deleteUser();
                        break;
                    case "deletentfyUser":
                        $delete_ntfy = array(
                            "entry" => isset($_POST["ptydeletesale"]["entid"]) ? $_POST["ptydeletesale"]["entid"] : false
                        );
                        $obj = new order($delete_ntfy);
                        echo $obj->deletentfyUser();
                        break;
                    case "edituser":
                        $user = array(
                            "usrid" => isset($_POST["usrid"]) ? $_POST["usrid"] : false
                        );
                        $obj = new client($user);
                        $obj->editUser();
                        break;
                    case "flagUser":
                        $flag_user = array(
                            "uid" => isset($_POST["fuser"]) ? $_POST["fuser"] : false,
                        );
                        $obj = new client($flag_user);
                        echo $obj->flagUser();
                        break;
                    case "unflagUser":
                        $unflag_user = array(
                            "uid" => isset($_POST["ufuser"]) ? $_POST["ufuser"] : false,
                        );
                        $obj = new client($unflag_user);
                        echo $obj->unflagUser();
                        break;
                    case "addCollection":
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
                    case "DisplayCollsList":
                        //echo print_r($_SESSION['listofcolls']);
                        $colls = new admincollection();
                        echo json_encode($colls->listColls());


                        break;
                    case "orderfollowupsAdd":
                        $client_add = array(
                            "name" => isset($_POST["clientadd"]["name"]) ? $_POST["clientadd"]["name"] : false,
                            "email" => isset($_POST["clientadd"]["email"]) ? $_POST["clientadd"]["email"] : false,
                            "cellnumbers" => isset($_POST["clientadd"]["cellnumber"]) ? $_POST["clientadd"]["cellnumber"] : false,
                            "handeledBy" => isset($_POST["clientadd"]["handledby"]) ? $_POST["clientadd"]["handledby"] : false,
                            "ReferedBy" => isset($_POST["clientadd"]["refby"]) ? $_POST["clientadd"]["refby"] : false,
                            "OrderProbability" => isset($_POST["clientadd"]["ord_prb"]) ? $_POST["clientadd"]["ord_prb"] : false,
                            "date" => isset($_POST["clientadd"]["cdate"]) ? $_POST["clientadd"]["cdate"] : false,
                            "comment" => isset($_POST["clientadd"]["comment"]) ? $_POST["clientadd"]["comment"] : false
                        );
                        $order = new order($client_add);
                        echo $order->addClient();
                        break;
                    case "DisplayorderClientList":
                        $orders = new order();
                        echo json_encode($orders->listorders());
                        break;
                    case "deleteordfoll":
                        $ofid = isset($_POST['ofid']) ? $_POST['ofid'] : false;
                        $orders = new order();
                        echo json_encode($orders->deleteOrderFollowup($ofid));
                        break;
                    case "DisplayNotificationList":
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
                    case "changepassword" : {
                            $obj = new userprofile();
                            $newpass = isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : false;
                            echo json_encode($obj->changePassword($newpass));
                        }
                        break;
                    case "fetchclientprofile" : {
                            $obj = new userprofile();
                            echo json_encode($obj->fetchClientProfile());
                        }
                        break;
                    case "fetchadmindues" : {
                            $obj = new dueadmin();
                            echo json_encode($obj->fetchAdminDues());
                        }
                        break;
                    case "payadmindues" : {
                            $details = array(
                                "userpk" => isset($_POST['details']['userpk']) ? $_POST['details']['userpk'] : false,
                                "amt" => isset($_POST['details']['amt']) ? $_POST['details']['amt'] : false,
                                "mop" => isset($_POST['details']['mop']) ? $_POST['details']['mop'] : false,
                            );
                            $obj = new dueadmin($details);
                            echo json_encode($obj->payAdminDue());
                        }
                        break;
                    /* Follow Ups */
                    case "fetchcurrfollowup" : {
                            $obj = new adminfollowup();
                            echo json_encode($obj->FetchCurrentFollowUp());
                        }
                        break;
                    case "fetchpendingfollowup" : {
                            $obj = new adminfollowup();
                            echo json_encode($obj->FetchPendingFollowUp());
                        }
                        break;
                    case "fetchexpiredfollowup" : {
                            $obj = new adminfollowup();
                            echo json_encode($obj->FetchExpiredFollowUp());
                        }
                        break;
                    case "deleteOrder":
                        $delete = array(
                            "entry" => isset($_POST["ptydeletesale"]) ? $_POST["ptydeletesale"] : false
                        );
                        $obj = new order($delete);
                        echo $obj->deleteOrder();
                        break;
                    case "picChange":
                        if (isset($_FILES)) {
                            $para = array(
                                "usrid" => isset($_POST["uid"]) ? $_POST["uid"] : false,
                            );
                            $obj = new client($para);
                            print_r($obj->changeClientPic($_FILES));
                        } else
                            echo false;
                        exit(0);
                        break;
                    /* admin profile */
                    case "load_ViewProfile":
                        $obj = new profile();
                        $obj->LoadProfile();
                        break;
                    case "editChangePwd":
                        $det = array(
                            "oldpwd" => isset($_POST["det"]["oldpwd"]) ? $_POST["det"]["oldpwd"] : false,
                            "newpwd" => isset($_POST["det"]["newpwd"]) ? $_POST["det"]["newpwd"] : false,
                            "confirmpwd" => isset($_POST["det"]["confirmpwd"]) ? $_POST["det"]["confirmpwd"] : false,
                            "msgdiv" => isset($_POST["det"]["msgdiv"]) ? $_POST["det"]["msgdiv"] : false,
                        );
                        $prof = new profile($det);
                        echo $prof->editChangePwd();
                        break;
                    /* expiry date */
                    case "expiryLicence":
                        $prof = new profile();
                        echo $prof->expiryLicence();
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
function slave($parameters) {
    $DB_HOST = $_SESSION["USER_LOGIN_DATA"]["DB_HOST"];
    $DB_USERNAME = $_SESSION["USER_LOGIN_DATA"]["DB_USERNAME"];
    $DB_PASSWORD = $_SESSION["USER_LOGIN_DATA"]["DB_PASSWORD"];
    $DB_NAME = $_SESSION["USER_LOGIN_DATA"]["DB_NAME"];
    $link = MySQLconnect($DB_HOST, $DB_USERNAME, $DB_PASSWORD);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB($DB_NAME, $link)) == 1) {
            if (!ValidateAdmin()) {
                session_destroy();
                echo "logout";
            } else {
                switch ($parameters["action"]) {
                    case "fetchUserTypes":
                        echo (json_encode(getUserTypes()));
                        break;
                    case "fetchPackTypes":
                        echo (json_encode(getPackTypes()));
                        break;
                    case "fetchProducts":
                        echo (json_encode(getProducts()));
                        break;
                    case "fetchUserProduct":
                        if(isset($_POST["uid"]) && is_numeric($_POST["uid"])){
                            $uid = $_POST["uid"];
                            echo (json_encode(fetchUserProduct($uid)));
                        }
                        else
                            echo (json_encode(array()));
                        break;
                    case "fetchPatty":
                        echo (json_encode(getPatty()));
                        break;
                    case "fetchMOPTypes":
                        echo (json_encode(getMOPTypes()));
                        break;
                    case "fetchBankAccount":
                        echo (json_encode(getBankAccounts($parameters)));
                        break;
                    case "fetchCommisions":
                        echo (json_encode(getCommisions()));
                        break;
                    case "fetchSingleSaleEntry":
                        $patty_edit_sale = array(
                            "patty" => isset($_POST["pid"]) ? $_POST["pid"] : false
                        );
                        $sale = new sale($patty_edit_sale);
                        echo (json_encode($sale->saleEntryIndividual()));
                        break;
                    case "logout":
                        session_destroy();
                        echo "logout";
                        break;
                    case "populateSalesList":
                        $patty_add_sale = array(
                            "patty" => isset($_POST["pid"]) ? $_POST["pid"] : false,
                            "todo" => isset($_POST["todo"]) ? $_POST["todo"] : false
                        );
                        $sale = new sale($patty_add_sale);
                        echo (json_encode($sale->fetchSalesList()));
                        break;
                    case "DisplayPurchasetList":
                        $purc = new purchase();
                        $_SESSION['listofpurchase'] = $purc->listpurchase();
                        if (isset($_SESSION['listofpurchase']) && sizeof($_SESSION['listofpurchase']) > 0) {
                            $_SESSION["initial"] = 0;
                            $_SESSION["final"] = 19;
                            $para["initial"] = $_SESSION["initial"];
                            $para["final"] = $_SESSION["final"];
                            $purc->DisplayPurchasetList($para);
                        } else {
                            $para["initial"] = 0;
                            $para["final"] = 0;
                            $purc->DisplayPurchasetList($para);
                            echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
                        }
                    case "pattyAdd":
                        $patty_add = array(
                            "pack_type" => isset($_POST["ptyadd"]["pack_type"]) ? $_POST["ptyadd"]["pack_type"] : false,
                            "packs" => isset($_POST["ptyadd"]["packs"]) ? $_POST["ptyadd"]["packs"] : false,
                            "name" => isset($_POST["ptyadd"]["name"]) ? $_POST["ptyadd"]["name"] : false,
                            "sid" => isset($_POST["ptyadd"]["sid"]) ? $_POST["ptyadd"]["sid"] : false,
                            "sind" => isset($_POST["ptyadd"]["sind"]) ? $_POST["ptyadd"]["sind"] : false,
                            "product" => isset($_POST["ptyadd"]["product"]) ? $_POST["ptyadd"]["product"] : false,
                            "pid" => isset($_POST["ptyadd"]["pid"]) ? $_POST["ptyadd"]["pid"] : false,
                            "pind" => isset($_POST["ptyadd"]["pind"]) ? $_POST["ptyadd"]["pind"] : false,
                            "vehicle" => isset($_POST["ptyadd"]["vehicle"]) ? $_POST["ptyadd"]["vehicle"] : false,
                            "date" => isset($_POST["ptyadd"]["date"]) ? $_POST["ptyadd"]["date"] : false
                        );
                        //print_r($patty_add);
                        $purc = new purchase($patty_add);
                        echo $purc->startConsignment();
                        break;
                    case "generateBill":
                        $bill = array(
                            "sales_id" => isset($_POST["ptybill"]["sales_id"]) ? $_POST["ptybill"]["sales_id"] : false,
                            "bdate" => isset($_POST["ptybill"]["bdate"]) ? $_POST["ptybill"]["bdate"] : false,
                            "prtlr" => isset($_POST["ptybill"]["prtlr"]) ? $_POST["ptybill"]["prtlr"] : false,
                            "tot_packs" => isset($_POST["ptybill"]["tot_packs"]) ? $_POST["ptybill"]["tot_packs"] : false,
                            "tot_wt" => isset($_POST["ptybill"]["tot_wt"]) ? $_POST["ptybill"]["tot_wt"] : false,
                            "avgrt" => isset($_POST["ptybill"]["avgrt"]) ? $_POST["ptybill"]["avgrt"] : false,
                            "totsal" => isset($_POST["ptybill"]["totsal"]) ? $_POST["ptybill"]["totsal"] : false,
                            "hire" => isset($_POST["ptybill"]["hire"]) ? $_POST["ptybill"]["hire"] : false,
                            "comm" => isset($_POST["ptybill"]["comm"]) ? $_POST["ptybill"]["comm"] : false,
                            "cash" => isset($_POST["ptybill"]["cash"]) ? $_POST["ptybill"]["cash"] : false,
                            "labour" => isset($_POST["ptybill"]["labour"]) ? $_POST["ptybill"]["labour"] : false,
                            "assnfee" => isset($_POST["ptybill"]["assnfee"]) ? $_POST["ptybill"]["assnfee"] : false,
                            "telefee" => isset($_POST["ptybill"]["telefee"]) ? $_POST["ptybill"]["telefee"] : false,
                            "rmc" => isset($_POST["ptybill"]["rmc"]) ? $_POST["ptybill"]["rmc"] : false,
                            "rot" => isset($_POST["ptybill"]["rot"]) ? $_POST["ptybill"]["rot"] : false,
                            "rotqt" => isset($_POST["ptybill"]["rotqt"]) ? $_POST["ptybill"]["rotqt"] : false,
                            "rotwt" => isset($_POST["ptybill"]["rotwt"]) ? $_POST["ptybill"]["rotwt"] : false,
                            "rotamt" => isset($_POST["ptybill"]["rotamt"]) ? $_POST["ptybill"]["rotamt"] : false,
                            "hun" => isset($_POST["ptybill"]["hun"]) ? $_POST["ptybill"]["hun"] : false,
                            "hunqt" => isset($_POST["ptybill"]["hunqt"]) ? $_POST["ptybill"]["hunqt"] : false,
                            "hunwt" => isset($_POST["ptybill"]["hunwt"]) ? $_POST["ptybill"]["hunwt"] : false,
                            "hunamt" => isset($_POST["ptybill"]["hunamt"]) ? $_POST["ptybill"]["hunamt"] : false,
                            "totexp" => isset($_POST["ptybill"]["totexp"]) ? $_POST["ptybill"]["totexp"] : false,
                            "nsales" => isset($_POST["ptybill"]["nsales"]) ? $_POST["ptybill"]["nsales"] : false
                        );
                        $sale = new sale($bill);
                        echo $sale->stopConsignment();
                        break;
                    case "addPattySaleEntry":
                        $patty_add_sale = array(
                            "patty" => isset($_POST["ptyaddsale"]["pid"]) ? $_POST["ptyaddsale"]["pid"] : false,
                            "retailer" => isset($_POST["ptyaddsale"]["rid"]) ? $_POST["ptyaddsale"]["rid"] : false,
                            "date" => isset($_POST["ptyaddsale"]["pds"]) ? $_POST["ptyaddsale"]["pds"] : false,
                            "num_packs" => isset($_POST["ptyaddsale"]["num_packs"]) ? $_POST["ptyaddsale"]["num_packs"] : false,
                            "kg" => isset($_POST["ptyaddsale"]["kg_packs"]) ? $_POST["ptyaddsale"]["kg_packs"] : false,
                            "rate_kg" => isset($_POST["ptyaddsale"]["rp"]) ? $_POST["ptyaddsale"]["rp"] : false,
                            "amount" => isset($_POST["ptyaddsale"]["rpa"]) ? $_POST["ptyaddsale"]["rpa"] : false,
                            "amountpaid" => isset($_POST["ptyaddsale"]["amtpd"]) ? $_POST["ptyaddsale"]["amtpd"] : false,
                            "due_amt" => isset($_POST["ptyaddsale"]["damtpd"]) ? $_POST["ptyaddsale"]["damtpd"] : false,
                            "due_date" => isset($_POST["ptyaddsale"]["dd"]) ? $_POST["ptyaddsale"]["dd"] : false,
                            "prdname" => isset($_POST["ptyaddsale"]["pname"]) ? $_POST["ptyaddsale"]["pname"] : false,
                            "prdphoto" => isset($_POST["ptyaddsale"]["prdphoto"]) ? $_POST["ptyaddsale"]["prdphoto"] : false,
                            "packtype" => isset($_POST["ptyaddsale"]["packtype"]) ? $_POST["ptyaddsale"]["packtype"] : false
                        );
                        $sale = new sale($patty_add_sale);
                        echo $sale->addPattyEntry();
                        break;
                    case "editPattySaleEntry":
                        $patty_edit_sale = array(
                            "entry" => isset($_POST["ptyeditsale"]["entid"]) ? $_POST["ptyeditsale"]["entid"] : false,
                            "patty" => isset($_POST["ptyeditsale"]["pid"]) ? $_POST["ptyeditsale"]["pid"] : false,
                            "retailer" => isset($_POST["ptyeditsale"]["rid"]) ? $_POST["ptyeditsale"]["rid"] : false,
                            "date" => isset($_POST["ptyeditsale"]["pds"]) ? $_POST["ptyeditsale"]["pds"] : false,
                            "num_packs" => isset($_POST["ptyeditsale"]["num_packs"]) ? $_POST["ptyeditsale"]["num_packs"] : false,
                            "kg" => isset($_POST["ptyeditsale"]["kg_packs"]) ? $_POST["ptyeditsale"]["kg_packs"] : false,
                            "rate_kg" => isset($_POST["ptyeditsale"]["rp"]) ? $_POST["ptyeditsale"]["rp"] : false,
                            "amount" => isset($_POST["ptyeditsale"]["rpa"]) ? $_POST["ptyeditsale"]["rpa"] : false,
                            "amountpaid" => isset($_POST["ptyeditsale"]["amtpd"]) ? $_POST["ptyeditsale"]["amtpd"] : false,
                            "due_id" => isset($_POST["ptyeditsale"]["due_id"]) ? $_POST["ptyeditsale"]["due_id"] : false,
                            "dueid" => isset($_POST["ptyeditsale"]["dueid"]) ? $_POST["ptyeditsale"]["dueid"] : false,
                            "due_amt" => isset($_POST["ptyeditsale"]["damtpd"]) ? $_POST["ptyeditsale"]["damtpd"] : false,
                            "due_date" => isset($_POST["ptyeditsale"]["dd"]) ? $_POST["ptyeditsale"]["dd"] : false,
                            "prdname" => isset($_POST["ptyeditsale"]["pname"]) ? $_POST["ptyeditsale"]["pname"] : false,
                            "prdphoto" => isset($_POST["ptyeditsale"]["prdphoto"]) ? $_POST["ptyeditsale"]["prdphoto"] : false,
                            "packtype" => isset($_POST["ptyeditsale"]["packtype"]) ? $_POST["ptyeditsale"]["packtype"] : false
                        );
                        $sale = new sale($patty_edit_sale);
                        echo $sale->updatePattyEntry();
                        break;
                    case "addPattyPay":
                        $patty_add_pay = array(
                            "patty" => isset($_POST["ptyaddpay"]["pid"]) ? $_POST["ptyaddpay"]["pid"] : false,
                            "supplier" => isset($_POST["ptyaddpay"]["sid"]) ? $_POST["ptyaddpay"]["sid"] : false,
                            "date" => isset($_POST["ptyaddpay"]["pdate"]) ? $_POST["ptyaddpay"]["pdate"] : false,
                            "pay_ac" => isset($_POST["ptyaddpay"]["pay_ac"]) ? $_POST["ptyaddpay"]["pay_ac"] : false,
                            "mop" => isset($_POST["ptyaddpay"]["mop"]) ? $_POST["ptyaddpay"]["mop"] : false,
                            "ac_id" => isset($_POST["ptyaddpay"]["ac_id"]) ? $_POST["ptyaddpay"]["ac_id"] : false,
                            "account" => isset($_POST["ptyaddpay"]["account"]) ? $_POST["ptyaddpay"]["account"] : false,
                            "amount" => isset($_POST["ptyaddpay"]["pamt"]) ? $_POST["ptyaddpay"]["pamt"] : false,
                            "rmk" => isset($_POST["ptyaddpay"]["rmk"]) ? $_POST["ptyaddpay"]["rmk"] : false
                        );
                        $sale = new sale($patty_add_pay);
                        echo $sale->addOutgoingAmt();
                        break;
                    case "addCollection":
                        $colls = array(
                            "cindex" => isset($_POST["colls"]["coltrind"]) ? $_POST["colls"]["coltrind"] : false,
                            "collector" => isset($_POST["colls"]["coltrid"]) ? $_POST["colls"]["coltrid"] : false,
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
                        $sale = new collection($colls);
                        echo $sale->addIncommingAmt();
                        break;
                    case "addPayment":
                        $payms = array(
                            "uindex" => isset($_POST["payms"]["uindex"]) ? $_POST["payms"]["uindex"] : false,
                            "supplier" => isset($_POST["payms"]["uid"]) ? $_POST["payms"]["uid"] : false,
                            "date" => isset($_POST["payms"]["pdate"]) ? $_POST["payms"]["pdate"] : false,
                            "pay_ac" => isset($_POST["payms"]["pay_ac"]) ? $_POST["payms"]["pay_ac"] : false,
                            "mop" => isset($_POST["payms"]["mop"]) ? $_POST["payms"]["mop"] : false,
                            "ac_id" => isset($_POST["payms"]["ac_id"]) ? $_POST["payms"]["ac_id"] : false,
                            "account" => isset($_POST["payms"]["account"]) ? $_POST["payms"]["account"] : false,
                            "amount" => isset($_POST["payms"]["pamt"]) ? $_POST["payms"]["pamt"] : false,
                            "rmk" => isset($_POST["payms"]["rmk"]) ? $_POST["payms"]["rmk"] : false
                        );
                        $sale = new payment($payms);
                        echo $sale->addOutgoingAmt();
                        break;
                    case "deleteSaleEntry":
                        $patty_delete_sale = array(
                            "entry" => isset($_POST["ptydeletesale"]["entid"]) ? $_POST["ptydeletesale"]["entid"] : false
                        );
                        $sale = new sale($patty_delete_sale);
                        echo $sale->deletePattyEntry();
                        break;
                    case "fetchUsers":
                        $utype = array(
                            "utype" => isset($_POST["utype"]) ? $_POST["utype"] : false,
                            "uid" => isset($_POST["uid"]) ? $_POST["uid"] : false
                        );
                        $jsonutype = getUsers($utype);
                        echo (json_encode($jsonutype));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                     //edit Email ids
                    case "loadClientEmailIdEditForm": {
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
                            $obj = new user($det);
                            // print_r($obj->loadClientEmailIdEditForm());
                            echo (json_encode($obj->loadClientEmailIdEditForm()));
                            break;
                        }
                    case "loadClientEmailIdDeltForm": {
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
                            $obj = new user($det);
                            echo (json_encode($obj->loadClientEmailIdDeltForm()));
                            break;
                        }
                    case "adddClientEmailId": {
                            $emailids = array(
                                "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                            );
                            $obj = new user($emailids);
                            echo (json_encode($obj->adddClientEmailId()));
                            break;
                        }
                    case "editClientEmailId": {
                            $emailids = array(
                                "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                            );
                            $obj = new user($emailids);
                            echo (json_encode($obj->editClientEmailId()));
                            break;
                        }
                    case "deleteClientEmailId": {
                            $emailid = array(
                                "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                            );
                            $obj = new user($emailid);
                            echo $obj->deleteClientEmailId();
                            break;
                        }
                    case "listClientEmailIds": {
                            $para = array(
                                "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                                "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                                "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                            );
                            $obj = new user($para);
                            echo $obj->listClientEmailIds();
                            break;
                        }
                    //edit cell number
                    case "loadClientCellNumEditForm": {
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
                            $obj = new user($det);
                            echo (json_encode($obj->loadClientCellNumEditForm()));
                            break;
                        }
                    case "loadClientCellNumDeltForm": {
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
                            $obj = new user($det);
                            echo (json_encode($obj->loadClientCellNumDeltForm()));
                            break;
                        }
                    case "adddClientCellNum": {
                            $cnums = array(
                                "CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
                            );
                            $obj = new user($cnums);
                            echo (json_encode($obj->adddClientCellNum()));
                            break;
                        }
                    case "editClientCellNum": {
                            $cnums = array(
                                "CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
                            );
                            $obj = new user($cnums);
                            echo (json_encode($obj->editClientCellNum()));
                            break;
                        }
                    case "deleteClientCellNum": {
                            $cnums = array(
                                "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                            );
                            $obj = new user($cnums);
                            echo $obj->deleteClientCellNum();
                            break;
                        }
                    case "listClientCellNums": {
                            $para = array(
                                "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                                "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                                "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                            );
                            $obj = new user($para);
                            echo $obj->listClientCellNums();
                            break;
                        }
                    //edit products
                    case "loadClientProductEditForm": {
                            $det = array(
                                "num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
                                "uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
                                "index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
                                "sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
                                "form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
                                "email" => isset($_POST["det"]["prdname"]) ? $_POST["det"]["prdname"] : false,
                                "msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
                                "plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
                                "minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
                                "saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
                                "closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
                            );
                            $obj = new user($det);
                            // print_r($obj->loadClientProductEditForm());
                            echo (json_encode($obj->loadClientProductEditForm()));
                            break;
                        }
                    case "loadClientProductDeltForm": {
                            $det = array(
                                "num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
                                "uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
                                "index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
                                "sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
                                "form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
                                "email" => isset($_POST["det"]["prdname"]) ? $_POST["det"]["prdname"] : false,
                                "msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
                                "plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
                                "minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
                                "saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
                                "closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
                            );
                            $obj = new user($det);
                            echo (json_encode($obj->loadClientProductDeltForm()));
                            break;
                        }
                    case "adddClientProduct": {
                            $emailids = array(
                                "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                            );
                            $obj = new user($emailids);
                            echo (json_encode($obj->adddClientProduct()));
                            break;
                        }
                    case "editClientProduct": {
                            $emailids = array(
                                "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                            );
                            $obj = new user($emailids);
                            echo (json_encode($obj->editClientProduct()));
                            break;
                        }
                    case "deleteClientProduct": {
                            $emailid = array(
                                "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                            );
                            $obj = new user($emailid);
                            echo $obj->deleteClientProduct();
                            break;
                        }
                    case "listClientProducts": {
                            $para = array(
                                "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                                "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                                "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                            );
                            $obj = new user($para);
                            echo $obj->listClientProducts();
                            break;
                        }
                    case "loadPrdNameForm":
                        $det = array(
                            "num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
                            "uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
                            "index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
                            "sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
                            "form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
                            "prdname" => isset($_POST["det"]["prdname"]) ? $_POST["det"]["prdname"] : false,
                            "msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
                            "plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
                            "minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
                            "saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
                            "closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
                        );
                        $user = new user($det);
                        echo (json_encode($user->loadPrdNameForm()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "editPrdName":
                        $prdnames = array(
                            "PrdNames" => isset($_POST["PrdNames"]) ? $_POST["PrdNames"] : false
                        );
                        $user = new user($prdnames);
                        echo (json_encode($user->editPrdName()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "deletePrdName":
                        $prdnames = array(
                            "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                        );
                        $user = new user($prdnames);
                        echo $user->deletePrdName();
                        break;
                    case "listPrdNames":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $user = new user($para);
                        echo $user->listPrdNames();
                        break;
                    
                    case "loadBankAcForm":
                        $det = array(
                            "num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
                            "uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
                            "index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
                            "sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
                            "form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
                            "bankname" => isset($_POST["det"]["bankname"]) ? $_POST["det"]["bankname"] : false,
                            "nmsg" => isset($_POST["det"]["nmsg"]) ? $_POST["det"]["nmsg"] : false,
                            "accno" => isset($_POST["det"]["accno"]) ? $_POST["det"]["accno"] : false,
                            "nomsg" => isset($_POST["det"]["nomsg"]) ? $_POST["det"]["nomsg"] : false,
                            "braname" => isset($_POST["det"]["braname"]) ? $_POST["det"]["braname"] : false,
                            "bnmsg" => isset($_POST["det"]["bnmsg"]) ? $_POST["det"]["bnmsg"] : false,
                            "bracode" => isset($_POST["det"]["bracode"]) ? $_POST["det"]["bracode"] : false,
                            "bcmsg" => isset($_POST["det"]["bcmsg"]) ? $_POST["det"]["bcmsg"] : false,
                            "IFSC" => isset($_POST["det"]["IFSC"]) ? $_POST["det"]["IFSC"] : false,
                            "IFSCmsg" => isset($_POST["det"]["IFSCmsg"]) ? $_POST["det"]["IFSCmsg"] : false,
                            "plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
                            "minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
                            "saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
                            "closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
                        );
                        $user = new user($det);
                        echo (json_encode($user->loadBankAcForm()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "editBankAc":
                        $bankacs = array(
                            "BankAcs" => isset($_POST["BankAcs"]) ? $_POST["BankAcs"] : false
                        );
                        $user = new user($bankacs);
                        echo (json_encode($user->editBankAc()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "deleteBankAc":
                        $bankacs = array(
                            "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                        );
                        $user = new user($bankacs);
                        echo $user->deleteBankAc();
                        break;
                    case "listBankAcs":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $user = new user($para);
                        echo $user->listBankAcs();
                        break;
                    case "editAddress":
                        $address = array(
                            "index" => isset($_POST["address"]["index"]) ? $_POST["address"]["index"] : false,
                            "sindex" => isset($_POST["address"]["listindex"]) ? $_POST["address"]["listindex"] : false,
                            "uid" => isset($_POST["address"]["uid"]) ? $_POST["address"]["uid"] : false,
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
                        $user = new user($address);
                        echo $user->editAddress();
                        break;
                    case "listAddress":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $user = new user($para);
                        echo $user->listAddress();
                        break;
                    case "editBasicInfo":
                        $para = array(
                            "uid" => isset($_POST["binfo"]["uid"]) ? $_POST["binfo"]["uid"] : false,
                            "index" => isset($_POST["binfo"]["index"]) ? $_POST["binfo"]["index"] : false,
                            "sindex" => isset($_POST["binfo"]["listindex"]) ? $_POST["binfo"]["listindex"] : false,
                            "user_type" => isset($_POST["binfo"]["user_type"]) ? $_POST["binfo"]["user_type"] : false,
                            "name" => isset($_POST["binfo"]["name"]) ? $_POST["binfo"]["name"] : false,
                            "otamt" => isset($_POST["binfo"]["otamt"]) ? $_POST["binfo"]["otamt"] : false,
                            "acs" => generateRandomString(),
                            "pcode" => isset($_POST["binfo"]["pcode"]) ? $_POST["binfo"]["pcode"] : false,
                            "tphone" => isset($_POST["binfo"]["tphone"]) ? $_POST["binfo"]["tphone"] : false
                        );
                        $user = new user($para);
                        echo $user->editBasicInfo();
                        break;
                    case "smsSaleEntry":
                        $para = array(
                            "num" => isset($_POST["sms"]["num"]) ? $_POST["sms"]["num"] : false,
                            "pid" => isset($_POST["sms"]["pid"]) ? $_POST["sms"]["pid"] : false,
                            "msgType" => isset($_POST["sms"]["msgType"]) ? $_POST["sms"]["msgType"] : false
                        );
                        $crm = new crm($para);
                        echo $crm->smsSaleEntry();
                        break;
                    case "userAdd":
                        $user_add = array(
                            "user_type" => isset($_POST["usradd"]["user_type"]) ? $_POST["usradd"]["user_type"] : false,
                            "name" => isset($_POST["usradd"]["name"]) ? $_POST["usradd"]["name"] : false,
                            "otamt" => isset($_POST["usradd"]["otamt"]) ? $_POST["usradd"]["otamt"] : false,
                            "acs" => generateRandomString(),
                            "email" => isset($_POST["usradd"]["email"]) ? (array) $_POST["usradd"]["email"] : false,
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
                            "pcode" => isset($_POST["usradd"]["pcode"]) ? $_POST["usradd"]["pcode"] : false,
                            "tphone" => isset($_POST["usradd"]["tphone"]) ? $_POST["usradd"]["tphone"] : false,
                            "zipcode" => isset($_POST["usradd"]["zipcode"]) ? $_POST["usradd"]["zipcode"] : false,
                            "website" => isset($_POST["usradd"]["website"]) ? $_POST["usradd"]["website"] : false,
                            "gmaphtml" => isset($_POST["usradd"]["gmaphtml"]) ? $_POST["usradd"]["gmaphtml"] : false,
                            "timezone" => isset($_POST["usradd"]["timezone"]) ? $_POST["usradd"]["timezone"] : false,
                            "lat" => isset($_POST["usradd"]["lat"]) ? $_POST["usradd"]["lat"] : false,
                            "lon" => isset($_POST["usradd"]["lon"]) ? $_POST["usradd"]["lon"] : false,
                            "password" => generateRandomString()
                        );
                        //print_r($user_add);
                        $user = new user($user_add);
                        echo $user->addUser();
                        break;
                    case "DisplayUserList":
                        $user = new user($_POST);
                        $_SESSION['listofusers'] = $user->listUser();
                        $para["initial"] = isset($_POST["start"]) ? (integer) $_POST["start"] : 0;
                        $para["final"] = isset($_POST["length"]) ? (integer) ($_POST["length"] + $para["initial"]) : (10 + $para["initial"]);
                        $para["draw"] = isset($_POST["draw"]) ? (integer) $_POST["draw"] : 1;
                        echo json_encode($user->displayUserList($para));
                        break;
                    case "DisplayUpdatedUserList":
                        $user = new user();
                        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
                            if (isset($_SESSION['listofusers']) && sizeof($_SESSION['listofusers']) > 0) {
                                if ($_SESSION["final"] >= sizeof($_SESSION['listofusers'])) {
                                    unset($_SESSION["initial"]);
                                    unset($_SESSION["final"]);
                                    $temp[] = array(
                                        "html" => '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>',
                                        "uid" => 0,
                                        "sr" => '',
                                        "alertUSRDEL" => '',
                                        "usrdelOk" => '',
                                        "usrdelCancel" => ''
                                    );
                                    echo json_encode($temp);
                                } else {
                                    $_SESSION["initial"] = $_SESSION["final"] + 1;
                                    $_SESSION["final"] += 4;
                                    $para["initial"] = $_SESSION["initial"];
                                    $para["final"] = $_SESSION["final"];
                                    echo json_encode($user->displayUserList($para));
                                }
                            }
                        }
                        break;
                    case "deleteUser":
                        $patty_delete_sale = array(
                            "entry" => isset($_POST["ptydeletesale"]["entid"]) ? $_POST["ptydeletesale"]["entid"] : false
                        );
                        $user = new user($patty_delete_sale);
                        echo $user->deleteUser();
                        break;
                    case "DisplayCollsList":
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
                        break;
                    case "DisplayUpdatedCollsList":
                        $colls = new collection();
                        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
                            if (isset($_SESSION['listofcolls']) && sizeof($_SESSION['listofcolls']) > 0) {
                                if ($_SESSION["final"] >= sizeof($_SESSION['listofcolls'])) {
                                    unset($_SESSION["initial"]);
                                    unset($_SESSION["final"]);
                                    echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
                                } else {
                                    $_SESSION["initial"] = $_SESSION["final"] + 1;
                                    $_SESSION["final"] += 20;
                                    $para["initial"] = $_SESSION["initial"];
                                    $para["final"] = $_SESSION["final"];
                                    $colls->DisplayCollsList($para);
                                }
                            }
                        }
                        break;
                    /* Billing Details  */
                    case "compnaydetails" : {
                            if (sizeof($_FILES)) {
                                $temp_name = isset($_FILES["file"]['tmp_name']) ? $_FILES["file"]['tmp_name'] : false;
                                $ext = GetImageExtension(isset($_FILES["file"]['type']) ? $_FILES["file"]['type'] : 'jpg');
                                $imagename = time() . '.jpg';
                                //                $target_path = DOC_ROOT."assets/img/".$imagename;
//                                                        echo print_r($_SESSION["USER_LOGIN_DATA"]);
                                if ($_SESSION["USER_LOGIN_DATA"]["DIR_PATH"] != '') {
                                    $target_path = ASSET_DIR . $_SESSION["USER_LOGIN_DATA"]['DIR_PATH'] . '/profile/' . $imagename;
                                    if (move_uploaded_file($temp_name, $target_path)) {
                                        if (file_exists($target_path)) {
                                            $companydetails = array(
                                                "companyname" => isset($_POST["companyname"]) ? $_POST["companyname"] : false,
                                                "companyaddress" => isset($_POST["companyaddress"]) ? $_POST["companyaddress"] : false,
                                                "companyemail" => isset($_POST["companyemail"]) ? $_POST["companyemail"] : false,
                                                "companymobile1" => isset($_POST["companymobile1"]) ? $_POST["companymobile1"] : false,
                                                "companymobile2" => isset($_POST["companymobile2"]) ? $_POST["companymobile2"] : false,
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
                                    } else {
                                        exit("Error While uploading image on the server");
                                    }
                                } else {
                                    echo 'Directory not found';
                                }
                            }
                            $companydetails = array(
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
                    case "fetchbillingdetails": {
                            $stn = new setting();
                            echo json_encode($stn->fetchBillingDetails());
                        }
                        break;
                    case "DisplayPaymsList":
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
                        break;
                    case "DisplayUpdatedCollsList":
                        $payms = new payment();
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
                        break;
                    case "DisplayPattyList":
                        $sales = new sale();
                        $_SESSION['listofpattys'] = $sales->listPattys();
                        if (isset($_SESSION['listofpattys']) && sizeof($_SESSION['listofpattys']) > 0) {
                            $_SESSION["initial"] = 0;
                            $_SESSION["final"] = 19;
                            $para["initial"] = $_SESSION["initial"];
                            $para["final"] = $_SESSION["final"];
                            $sales->DisplayPattyList($para);
                        } else {
                            $para["initial"] = 0;
                            $para["final"] = 0;
                            $sales->DisplayPattyList($para);
                            echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
                        }
                        break;
                    case "DisplayUpdatedPattyList":
                        $sales = new sale();
                        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
                            if (isset($_SESSION['listofpattys']) && sizeof($_SESSION['listofpattys']) > 0) {
                                if ($_SESSION["final"] >= sizeof($_SESSION['listofpattys'])) {
                                    unset($_SESSION["initial"]);
                                    unset($_SESSION["final"]);
                                    echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
                                } else {
                                    $_SESSION["initial"] = $_SESSION["final"] + 1;
                                    $_SESSION["final"] += 20;
                                    $para["initial"] = $_SESSION["initial"];
                                    $para["final"] = $_SESSION["final"];
                                    $sales->DisplayPattyList($para);
                                }
                            }
                        }
                        break;
                    case "flagUser":
                        $flag_user = array(
                            "uid" => isset($_POST["fuser"]) ? $_POST["fuser"] : false,
                        );
                        $user = new user($flag_user);
                        $user->flagUser();
                        break;
                    case "unflagUser":
                        $unflag_user = array(
                            "uid" => isset($_POST["ufuser"]) ? $_POST["ufuser"] : false,
                        );
                        $user = new user($unflag_user);
                        echo $user->unflagUser();
                        break;
                    case "edituser":
                        $user = array(
                            "usrid" => isset($_POST["usrid"]) ? $_POST["usrid"] : false
                        );
                        $obj = new user($user);
                        echo json_encode($obj->editUser());
                        break;
                    case "searchUser":
                        $search = array(
                            "uname" => isset($_POST["uname"]) ? $_POST["uname"] : false,
                            "ucell" => isset($_POST["ucell"]) ? $_POST["ucell"] : false,
                            "utype" => isset($_POST["utype"]) ? $_POST["utype"] : false,
                            "pname" => isset($_POST["pname"]) ? $_POST["pname"] : false,
                            "damt1" => isset($_POST["damt1"]) ? $_POST["damt1"] : false,
                            "damt2" => isset($_POST["damt2"]) ? $_POST["damt2"] : false,
                            "ddate" => isset($_POST["ddate"]) ? $_POST["ddate"] : false,
                            /* all list */
                            "auname" => isset($_POST["auname"]) ? $_POST["auname"] : false,
                            "aucell" => isset($_POST["aucell"]) ? $_POST["aucell"] : false,
                            "autype" => isset($_POST["autype"]) ? $_POST["autype"] : false,
                            "apname" => isset($_POST["apname"]) ? $_POST["apname"] : false,
                            "adamt1" => isset($_POST["adamt1"]) ? $_POST["adamt1"] : false,
                            "adamt2" => isset($_POST["adamt2"]) ? $_POST["adamt2"] : false,
                            "addate" => isset($_POST["addate"]) ? $_POST["addate"] : false,
                        );
                        $user = new user($search);
                        $user->searchUser();
                        if (isset($_SESSION['listofusers'])) {
                            $_SESSION["initial"] = 0;
                            $_SESSION["final"] = 6;
                            $para["initial"] = $_SESSION["initial"];
                            $para["final"] = $_SESSION["final"];
                            echo json_encode($user->displayUserList($para));
                        } else {
                            $para["initial"] = 0;
                            $para["final"] = 0;
                            echo json_encode($user->displayUserList($para));
                            echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
                        }
                        break;
                    case "load_distProfile":
                        $obj = new profile();
                        $obj->distProfile();
                        break;
                    case "distributorEmailIdForm":
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
                        echo (json_encode($prof->distributorEmailIdForm()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "diseditEmailId":
                        $emailids = array(
                            "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                        );
                        $profile = new profile($emailids);
                        echo (json_encode($profile->editEmailId()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "disdeleteEmailId":
                        $emailid = array(
                            "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                        );
                        $profile = new profile($emailid);
                        echo $profile->disdeleteEmailId();
                        break;
                    case "dislistEmailIds":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $profile = new profile($para);
                        echo $profile->dislistEmailIds();
                        break;
                    case "distloadCellNumForm":
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
                        echo (json_encode($prof->distributorcnumberForm()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "diseditCellNum":
                        $cnums = array(
                            "CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
                        );
                        $profile = new profile($cnums);
                        echo (json_encode($profile->editCellNum()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "distdeleteCellNum":
                        $cnums = array(
                            "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                        );
                        $profile = new profile($cnums);
                        echo $profile->distdeleteCellNum();
                        break;
                    case "dislistCellNums":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $profile = new profile($para);
                        echo $profile->dislistCellNums();
                        break;
                    case "disloadPrdNameForm":
                        $det = array(
                            "num" => isset($_POST["det"]["num"]) ? $_POST["det"]["num"] : false,
                            "uid" => isset($_POST["det"]["uid"]) ? $_POST["det"]["uid"] : false,
                            "index" => isset($_POST["det"]["index"]) ? $_POST["det"]["index"] : false,
                            "sindex" => isset($_POST["det"]["listindex"]) ? $_POST["det"]["listindex"] : false,
                            "form" => isset($_POST["det"]["form"]) ? $_POST["det"]["form"] : false,
                            "prdname" => isset($_POST["det"]["prdname"]) ? $_POST["det"]["prdname"] : false,
                            "msgDiv" => isset($_POST["det"]["msgDiv"]) ? $_POST["det"]["msgDiv"] : false,
                            "plus" => isset($_POST["det"]["plus"]) ? $_POST["det"]["plus"] : false,
                            "minus" => isset($_POST["det"]["minus"]) ? $_POST["det"]["minus"] : false,
                            "saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
                            "closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false
                        );
                        $profile = new profile($det);
                        echo (json_encode($profile->loadPrdNameForm()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "diseditPrdName":
                        $prdnames = array(
                            "PrdNames" => isset($_POST["PrdNames"]) ? $_POST["PrdNames"] : false
                        );
                        $profile = new profile($prdnames);
                        echo (json_encode($profile->editPrdName()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "deletePrdName":
                        $prdnames = array(
                            "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                        );
                        $user = new user($prdnames);
                        echo $user->deletePrdName();
                        break;
                    case "dislistPrdNames":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $profile = new profile($para);
                        echo $profile->listPrdNames();
                        break;
                    case "diseditChangePwd":
                        $det = array(
                            "oldpwd" => isset($_POST["det"]["oldpwd"]) ? $_POST["det"]["oldpwd"] : false,
                            "newpwd" => isset($_POST["det"]["newpwd"]) ? $_POST["det"]["newpwd"] : false,
                            "confirmpwd" => isset($_POST["det"]["confirmpwd"]) ? $_POST["det"]["confirmpwd"] : false,
                            "msgdiv" => isset($_POST["det"]["msgdiv"]) ? $_POST["det"]["msgdiv"] : false,
                        );
                        $prof = new profile($det);
                        echo $prof->diseditChangePwd();
                        break;
                    case "diseditAddress":
                        $address = array(
                            "index" => isset($_POST["address"]["index"]) ? $_POST["address"]["index"] : false,
                            "sindex" => isset($_POST["address"]["listindex"]) ? $_POST["address"]["listindex"] : false,
                            "uid" => isset($_POST["address"]["uid"]) ? $_POST["address"]["uid"] : false,
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
                        $profile = new profile($address);
                        echo $profile->diseditAddress();
                        break;
                    case "dislistAddress":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $profile = new profile($para);
                        echo $profile->dislistAddress();
                        break;

                    case "profileEmailIdForm":
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
                        echo (json_encode($prof->profileEmailIdForm()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "editProfileEmailId":
                        $emailids = array(
                            "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                        );
                        $prof = new profile($emailids);
                        echo (json_encode($prof->editProfileEmailId()));
                        // echo print_r($_SESSION["list_of_users"]);
                        break;
                    case "deleteProfileEmailId":
                        $emailid = array(
                            "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                        );
                        $prof = new profile($emailid);
                        echo $prof->deleteProfileEmailId();
                        break;
                    case "listProfileEmailIds":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $prof = new profile($para);
                        echo $prof->listProfileEmailIds();
                        break;
                    case "loadChangePwdForm":
                        $det = array(
                            "oldpwd" => isset($_POST["det"]["oldpwd"]) ? $_POST["det"]["oldpwd"] : false,
                            "newpwd" => isset($_POST["det"]["newpwd"]) ? $_POST["det"]["newpwd"] : false,
                            "confirmpwd" => isset($_POST["det"]["confirmpwd"]) ? $_POST["det"]["confirmpwd"] : false,
                            "saveBut" => isset($_POST["det"]["saveBut"]) ? $_POST["det"]["saveBut"] : false,
                            "closeBut" => isset($_POST["det"]["closeBut"]) ? $_POST["det"]["closeBut"] : false,
                            "msgdiv" => isset($_POST["det"]["msgdiv"]) ? $_POST["det"]["msgdiv"] : false,
                            "oldmsg" => isset($_POST["det"]["oldmsg"]) ? $_POST["det"]["oldmsg"] : false,
                            "newmsg" => isset($_POST["det"]["newmsg"]) ? $_POST["det"]["newmsg"] : false,
                            "confirmmsg" => isset($_POST["det"]["confirmmsg"]) ? $_POST["det"]["confirmmsg"] : false,
                        );
                        $prof = new profile($det);
                        echo (json_encode($prof->loadChangePwdForm()));
                        break;
                    case "loadProfileCellNumForm":
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
                        echo (json_encode($prof->loadProfileCellNumForm()));
                        break;
                    case "editProfileCellNum":
                        $cnums = array(
                            "CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
                        );
                        $prof = new profile($cnums);
                        echo (json_encode($prof->editProfileCellNum()));
                        break;
                    case "deleteProfileCellNum":
                        $cnums = array(
                            "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                        );
                        $prof = new profile($cnums);
                        echo $prof->deleteProfileCellNum();
                        break;
                    case "listProfileCellNums":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $prof = new profile($para);
                        echo $prof->listProfileCellNums();
                        break;
                    case "editProfileAddress":
                        $address = array(
                            "index" => isset($_POST["address"]["index"]) ? $_POST["address"]["index"] : false,
                            "sindex" => isset($_POST["address"]["listindex"]) ? $_POST["address"]["listindex"] : false,
                            "uid" => isset($_POST["address"]["uid"]) ? $_POST["address"]["uid"] : false,
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
                    case "listProfileAddress":
                        $para = array(
                            "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                            "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                            "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                        );
                        $prof = new profile($para);
                        echo $prof->listProfileAddress();
                        break;
                    case "changeProfilePhoto":
                        $obj = new profile();
                        $obj->changeProfilePhoto();
                        break;
                    case "DisplaySaleList":
                        $sales = new sale();
                        $_SESSION['listofpattys'] = $sales->listPattys();
                        if (isset($_SESSION['listofpattys']) && sizeof($_SESSION['listofpattys']) > 0) {
                            echo $sales->DisplaySaleList();
                        } else {
                            echo '<script language="javascript" >$(window).unbind();BindScrollEvents();</script>';
                        }
                        break;
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    exit(0);
}
if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true' && $parameters["master_slave_db"] == 'master') {
    global $parameters;
    main($parameters);
    unset($_POST);
    exit(0);
} else if ((isset($parameters["autoloader"])) && ($parameters["autoloader"] == 'true')) {
    global $parameters;
    slave($parameters);
    unset($_POST);
    exit(0);
}
require_once(DOC_ROOT . INC . 'header.php');
require_once(DOC_ROOT . INC . $_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] . '.php');
require_once(DOC_ROOT . INC . 'interface.php');
require_once(DOC_ROOT . INC . 'footer.php');
?>
