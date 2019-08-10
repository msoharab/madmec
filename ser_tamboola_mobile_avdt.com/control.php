<?php
define("MODULE_0", "config.php");
require_once(MODULE_0);
require_once(MODULE_MENU1);
require_once(MODULE_MENU2);
require_once(MODULE_MENU3);
require_once(MODULE_MENU4);
/*require_once(MODULE_GYMLIST);*/
/*require_once(MODULE_MANAGE);*/
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
    "master_slave_db" => isset($_POST["type"]) ? $_POST["type"] : false
);
if (isset($_POST["action1"])) {
    $parameters["action"] = $_POST["action1"];
}
function main() {
    global $parameters;
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            if (!ValidateAdmin()) {
                session_destroy();
                echo "logout";
            } else {
                switch ($parameters["action"]) {
                    /*Load Gyms*/
                    case "fetctlistofgyms": {
                            $obj = new menu1();
                            $obj->fetchGyms();
                            break;
                        }
                    /*menu1*/
                    /*edit client case*/
                    case "editClient": {
                            $usrid = array(
                                "usrid" => isset($_SESSION["USER_LOGIN_DATA"]['USER_ID']) ? $_SESSION["USER_LOGIN_DATA"]['USER_ID'] : false
                            );
                            $obj = new menu1($usrid);
                            $obj->editClient();
                            break;
                        }
                    /*edit client email*/
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
                            $obj = new menu1($det);
                            echo (json_encode($obj->loadClientEmailIdEditForm()));
                            break;
                        }
                    /*edit client email*/
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
                            $obj = new menu1($det);
                            echo (json_encode($obj->loadClientEmailIdDeltForm()));
                            break;
                        }
                    case "adddClientEmailId": {
                            $emailids = array(
                                "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                            );
                            $obj = new menu1($emailids);
                            echo (json_encode($obj->adddClientEmailId()));
                            break;
                        }
                    case "editClientEmailId": {
                            $emailids = array(
                                "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                            );
                            $obj = new menu1($emailids);
                            echo (json_encode($obj->editClientEmailId()));
                            break;
                        }
                    case "deleteClientEmailId": {
                            $emailid = array(
                                "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                            );
                            $obj = new menu1($emailid);
                            echo $obj->deleteClientEmailId();
                            break;
                        }
                    case "listClientEmailIds": {
                            $para = array(
                                "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                                "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                                "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                            );
                            $obj = new menu1($para);
                            echo $obj->listClientEmailIds();
                            break;
                        }
                    /*edit cell number*/
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
                            $obj = new menu1($det);
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
                            $obj = new menu1($det);
                            echo (json_encode($obj->loadClientCellNumDeltForm()));
                            break;
                        }
                    case "adddClientCellNum": {
                            $cnums = array(
                                "CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
                            );
                            $obj = new menu1($cnums);
                            echo (json_encode($obj->adddClientCellNum()));
                            break;
                        }
                    case "editClientCellNum": {
                            $cnums = array(
                                "CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
                            );
                            $obj = new menu1($cnums);
                            echo (json_encode($obj->editClientCellNum()));
                            break;
                        }
                    case "deleteClientCellNum": {
                            $cnums = array(
                                "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                            );
                            $obj = new menu1($cnums);
                            echo $obj->deleteClientCellNum();
                            break;
                        }
                    case "listClientCellNums": {
                            $para = array(
                                "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                                "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                                "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                            );
                            $obj = new menu1($para);
                            echo $obj->listClientCellNums();
                            break;
                        }
                    /*change pic*/
                    case "picChange": {
                            if (isset($_FILES)) {
                                $para = array(
                                    "usrid" => isset($_POST["uid"]) ? $_POST["uid"] : false,
                                );
                                $obj = new menu1($para);
                                print_r($obj->changeClientPic($_FILES));
                            } else
                                echo false;
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
                    case "cust_sex": {
                            $sex = new addcustomer();
                            $sex->customer_sex();
                            exit(0);
                            break;
                        }
                    /*menu2*/
                    /* Add a gym*/
                    case "gymAdd": {
                            $gym_add = array(
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
                                "db_pass" => '9743967575',
                            );
                            $obj = new menu2($gym_add);
                            print_r($obj->addGYMProfile());
                            break;
                        }
                    case "fetchlistgyms" : {
                            $obj = new menu2();
                            echo json_encode($obj->fetchListOfGyms());
                            break;
                        }
                    /*gym email id edit*/
                    /*edit GYM email*/
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
                            $obj = new menu2($det);
                            echo (json_encode($obj->loadGYMEmailId()));
                            break;
                        }
                    case "editGYMEmailId": {
                            $emailids = array(
                                "emailids" => isset($_POST["emailids"]) ? $_POST["emailids"] : false
                            );
                            $obj = new menu2($emailids);
                            echo (json_encode($obj->editGYMEmailId()));
                            break;
                        }
                    case "deleteGYMEmailId": {
                            $emailid = array(
                                "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                            );
                            $obj = new menu2($emailid);
                            echo $obj->deleteGYMEmailId();
                            break;
                        }
                    case "listGYMEmailIds": {
                            $para = array(
                                "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                                "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                                "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                            );
                            $obj = new menu2($para);
                            echo $obj->listGYMEmailIds();
                            break;
                        }
                    /* gym cell number edit*/
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
                            $obj = new menu2($det);
                            echo (json_encode($obj->loadGYMCellNumForm()));
                            break;
                        }
                    case "editGYMCellNum": {
                            $cnums = array(
                                "CellNums" => isset($_POST["CellNums"]) ? $_POST["CellNums"] : false
                            );
                            $obj = new menu2($cnums);
                            echo (json_encode($obj->editGYMCellNum()));
                            break;
                        }
                    case "deleteGYMCellNum": {
                            $cnums = array(
                                "eid" => isset($_POST["eid"]) ? $_POST["eid"] : false
                            );
                            $obj = new menu2($cnums);
                            echo $obj->deleteGYMCellNum();
                            break;
                        }
                    case "listGYMCellNums": {
                            $para = array(
                                "uid" => isset($_POST["para"]["uid"]) ? $_POST["para"]["uid"] : false,
                                "index" => isset($_POST["para"]["index"]) ? $_POST["para"]["index"] : false,
                                "sindex" => isset($_POST["para"]["listindex"]) ? $_POST["para"]["listindex"] : false
                            );
                            $obj = new menu2($para);
                            echo $obj->listGYMCellNums();
                            break;
                        }
                    /* gym address edit*/
                    case "gymaddressedit": {
                            $data = $_POST["attr"];
                            $addrset = new menu2();
                            echo json_encode($addrset->gymAddrsEdit($data));
                            break;
                        }
                    /* gym data doc edit*/
                    case "gymdataDoc": {
                            $data = $_POST["attr"];
                            $addrset = new menu2();
                            echo json_encode($addrset->gymdatadocEdit($data));
                            break;
                        }
                    /*gym delete*/
                    case "gymDeleTe": {
                            $gymid = $_POST["id"];
                            $deleteset = new menu2();
                            echo $deleteset->gymDELETE($gymid);
                            break;
                        }
                    /*gym flag btn*/
                    case "flagGYM": {
                            $flag_user = array(
                                "uid" => isset($_POST["fuser"]) ? $_POST["fuser"] : false,
                            );
                            $obj = new menu2($flag_user);
                            echo $obj->flagGYM();
                            break;
                        }
                    /*gym unflag btn*/
                    case "unflagGYM": {
                            $unflag_user = array(
                                "uid" => isset($_POST["ufuser"]) ? $_POST["ufuser"] : false,
                            );
                            $obj = new menu2($unflag_user);
                            echo $obj->unflagGYM();
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
                    /*menu3*/
                    case "fetchgyms" : {
                            $ojb = new menu3();
                            echo json_encode($ojb->fetchGyms());
                            break;
                        }
                    case "fetchdurations" : {
                            $ojb = new menu3();
                            echo json_encode($ojb->fetchDuration());
                            break;
                        }
                    case "fetchfactys" : {
                            $ojb = new menu3();
                            echo json_encode($ojb->fetchFacilities());
                            break;
                        }
                    case "addoffers" : {
                            $params = array(
                                "name" => isset($_POST['details']['name']) ? $_POST['details']['name'] : false,
                                "duration" => isset($_POST['details']['duration']) ? $_POST['details']['duration'] : false,
                                "days" => isset($_POST['details']['days']) ? $_POST['details']['days'] : false,
                                "faciltiy" => isset($_POST['details']['faciltiy']) ? $_POST['details']['faciltiy'] : false,
                                "prize" => isset($_POST['details']['prize']) ? $_POST['details']['prize'] : false,
                                "member" => isset($_POST['details']['member']) ? $_POST['details']['member'] : false,
                                "gymname" => isset($_POST['details']['gymname']) ? $_POST['details']['gymname'] : false,
                                "descb" => isset($_POST['details']['descb']) ? $_POST['details']['descb'] : false,
                            );
                            $ojb = new menu3($params);
                            echo json_encode($ojb->addOffers());
                            break;
                        }
                    case "fetchoffers" : {
                            $ojb = new menu3();
                            echo json_encode($ojb->fetchOffers());
                            break;
                        }
                    /* Packages*/
                    /*menu4*/
                    case "fetchpcktypes" : {
                            $ojb = new menu4();
                            echo json_encode($ojb->fetchPackagesTypes());
                            break;
                        }
                    case "addpacks" : {
                            $params = array(
                                "packagename" => isset($_POST['details']['packagename']) ? $_POST['details']['packagename'] : false,
                                "sessions" => isset($_POST['details']['sessions']) ? $_POST['details']['sessions'] : false,
                                "packtype" => isset($_POST['details']['packtype']) ? $_POST['details']['packtype'] : false,
                                "amount" => isset($_POST['details']['amount']) ? $_POST['details']['amount'] : false,
                                "gymname" => isset($_POST['details']['gymname']) ? $_POST['details']['gymname'] : false,
                            );
                            $ojb = new menu4($params);
                            echo json_encode($ojb->addPackage());
                            break;
                        }
                    case "fetchexistingpacks" : {
                            $ojb = new menu4();
                            echo json_encode($ojb->fetchExistingPackages());
                            break;
                        }
                    case "logout" : {
                            session_destroy();
                            echo "logout";
                            break;
                        }
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    exit(0);
}
if (isset($parameters['autoloader']) && $parameters['autoloader'] == 'true' && $parameters['master_slave_db'] == 'master') {
    main();
    unset($_POST);
    exit(0);
}
if ((isset($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"])) && ($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "Admin")) {
    require_once(DOC_ROOT . INC . 'res-admin-header.php');
} else if ((isset($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"])) && ($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "MMAdmin")) {
    require_once(DOC_ROOT . INC . 'res-mmadmin-header.php');
} else {
    session_destroy();
    header("location:" . URL);
}
require_once(DOC_ROOT . INC . 'res-footer.php');
?>