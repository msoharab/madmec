<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
    "city" => isset($_POST["city"]) ? $_POST["city"] : false
);

function main($parameters = false) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $flag = ValidateAdmin();
            if ($flag) {
                echo 'login';
            } else {
                switch ($parameters["action"]) {
                    case 'listofgyms': {
                            if (($db_select = selectDB(MADMEC_JDDATA, $link)) == 1) {
                                $listofgyms = array();
                                $query = 'SELECT `id`,`fname`,`lname`,`contact1`,`established`,`address`,`city` FROM `data_unique` WHERE `city`="' . $parameters["city"] . '";';
                                $res = executeQuery($query);
                                if (mysql_num_rows($res)) {
                                    while ($row = mysql_fetch_assoc($res)) {
                                        $listofgyms[] = array(
                                            "id" => $row["id"],
                                            "fname" => $row["fname"],
                                            "lname" => $row["lname"],
                                            "contact1" => $row["contact1"],
                                            "established" => $row["established"],
                                            "address" => $row["address"],
                                            "city" => $row["city"]
                                        );
                                    }
                                }
                                $len = sizeof($listofgyms);
                                if ($len) {
                                    $htm = '';
                                    for ($i = 0; $i < $len; $i++) {
                                        $htm .= '<tr><td>' . ($i + 1) . '</td><td>' . $listofgyms[$i]["lname"] . '</td><td>' . $listofgyms[$i]["contact1"] . '</td><td>' . $listofgyms[$i]["established"] . '</td><td>' . $listofgyms[$i]["address"] . '</td><td>' . $listofgyms[$i]["city"] . '</td></tr>';
                                    }
                                    echo $htm;
                                } else {
                                    echo '<tr><td></td><td></td><td></td><td>Found 0 fitness centres</td><td><td></td></tr>';
                                }
                            }
                            break;
                        }
                    case 'fetchlistofcity': {
                            if (($db_select = selectDB(MADMEC_JDDATA, $link)) == 1) {
                                $listofcitys = array();
                                $data = array();
                                $query = 'SELECT * FROM `city`;';
                                $res = executeQuery($query);
                                if (mysql_num_rows($res)) {
                                    while ($row = mysql_fetch_assoc($res)) {
                                        $listofgyms[] = $row;
                                    }
                                }
                                $len = sizeof($listofgyms);
                                if ($len) {
                                    $htm = '';
                                    for ($i = 0; $i < $len; $i++) {
                                        $data[$i] = $listofgyms[$i]['city'];
                                    }
                                    $jsondata = array(
                                        "status" => "success",
                                        "data" => $data,
                                    );
                                    echo json_encode($jsondata);
                                } else {
                                    $jsondata = array(
                                        "status" => "failure",
                                        "data" => NULL,
                                    );
                                    echo json_encode($jsondata);
                                }
                            }
                            break;
                        }
                    case 'checkemail': {
                            if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
                                $query = "SELECT `email_id` FROM `user_profile` WHERE `email_id`='" . mysql_real_escape_string($_POST['email']) . "';";
                                $result = executeQuery($query);
                                echo mysql_num_rows($result);
                            }
                            break;
                        }
                    case 'custreg': {
                            $jsondata = array(
                                "USER_NAME" => $_POST['details']['name'],
                                "USER_EMAIL" => $_POST['details']['email'],
                                "USER_PASS" => $_POST['details']['pass'],
                                "USER_MOBL" => $_POST['details']['mobile'],
                                "USER_GEND" => $_POST['details']['gender'],
                                "STATUS" => 'error'
                            );
                            if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
                                $query = "SELECT `email_id` FROM `user_profile` WHERE `email_id`='" . mysql_real_escape_string($_POST['details']['email']) . "';";
                                $result = executeQuery($query);
                                if (mysql_num_rows($result)) {
                                    $jsondata["STATUS"] = "alreadyexist";
                                } else {
                                    executeQuery("SET AUTOCOMMIT=0;");
                                    executeQuery("START TRANSACTION;");
                                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES('
                                            . 'NULL,NULL,NULL,NULL,NULL,NULL);';
                                    $status1 = executeQuery($query1);
                                    $picid = mysql_insert_id();
                                    $query2 = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`photo_id`,`password`,`apassword`,`cell_number`,`gender`,`status`)Values(null,'
                                            . '"' . mysql_real_escape_string($_POST['details']['name']) . '",'
                                            . '"' . mysql_real_escape_string($_POST['details']['email']) . '",'
                                            . '"' . mysql_real_escape_string($picid) . '",'
                                            . '"' . mysql_real_escape_string($_POST['details']['pass']) . '",'
                                            . '"' . mysql_real_escape_string(md5($_POST['details']['pass'])) . '",'
                                            . '"' . mysql_real_escape_string($_POST['details']['mobile']) . '",'
                                            . '"' . mysql_real_escape_string($_POST['details']['gender']) . '",'
                                            . '11'
                                            . ')';
                                    $status2 = executeQuery($query2);
                                    $user_pk = mysql_insert_id();
                                    $query3 = 'INSERT INTO `userprofile_type`
							 (`id`,
							  `user_pk`,
							  `usertype_id`,
							  `status`) VALUES
							  (NULL,
							  \'' . mysql_real_escape_string($user_pk) . '\',
							  9,4)';
                                    $status3 = executeQuery($query3);
                                    $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_customer_' . $user_pk);
                                    executeQuery('UPDATE `user_profile` SET `directory` = \'' . $directory_customer . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
                                    if ($status1 && $status2 && $status3) {
                                        executeQuery("COMMIT");
                                        $jsondata["STATUS"] = "success";
                                    } else {
                                        executeQuery("ROLLBACK");
                                    }
                                }
                            }
                            echo $jsondata["STATUS"];
                            break;
                        }
                    case 'ownerreg': {
                            $jsondata = array(
                                "USER_NAME" => $_POST['details']['name'],
                                "USER_EMAIL" => $_POST['details']['email'],
                                "USER_PASS" => $_POST['details']['pass'],
                                "USER_MOBL" => $_POST['details']['mobile'],
                                "USER_GEND" => $_POST['details']['gender'],
                                "STATUS" => 'error'
                            );
                            if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
                                $query = "SELECT `email_id` FROM `user_profile` WHERE `email_id`='" . mysql_real_escape_string($_POST['details']['email']) . "';";
                                $result = executeQuery($query);
                                if (mysql_num_rows($result)) {
                                    $jsondata["STATUS"] = "alreadyexist";
                                } else {
                                    executeQuery("SET AUTOCOMMIT=0;");
                                    executeQuery("START TRANSACTION;");
                                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES('
                                            . 'NULL,NULL,NULL,NULL,NULL,NULL);';
                                    $status1 = executeQuery($query1);
                                    $picid = mysql_insert_id();
                                    $query2 = 'INSERT INTO `user_profile`(`id`,`user_name`,`email_id`,`photo_id`,`password`,`apassword`,`cell_number`,`gender`,`status`)Values(null,'
                                            . '"' . mysql_real_escape_string($_POST['details']['name']) . '",'
                                            . '"' . mysql_real_escape_string($_POST['details']['email']) . '",'
                                            . '"' . mysql_real_escape_string($picid) . '",'
                                            . '"' . mysql_real_escape_string($_POST['details']['pass']) . '",'
                                            . '"' . mysql_real_escape_string(md5($_POST['details']['pass'])) . '",'
                                            . '"' . mysql_real_escape_string($_POST['details']['mobile']) . '",'
                                            . '"' . mysql_real_escape_string($_POST['details']['gender']) . '",'
                                            . '14'
                                            . ')';
                                    $status2 = executeQuery($query2);
                                    $user_pk = mysql_insert_id();
                                    $query3 = 'INSERT INTO `userprofile_type`
							 (`id`,
							  `user_pk`,
							  `usertype_id`,
							  `status`) VALUES
							  (NULL,
							  \'' . mysql_real_escape_string($user_pk) . '\',
							  1,14)';
                                    $status3 = executeQuery($query3);
                                    $query4 = 'INSERT INTO `email_ids`
							 (`id`,
							  `user_pk`,
							  `email`,
							  `status`) VALUES
							  (NULL,
							  \'' . mysql_real_escape_string($user_pk) . '\',
                                                           \'' . mysql_real_escape_string($_POST['details']['email']) . '\',
							  17)';
                                    $status4 = executeQuery($query4);
                                    $query5 = 'INSERT INTO `cell_numbers`
							 (`id`,
							  `user_pk`,
                                                          `cell_code`,
							  `cell_number`,
							  `status`) VALUES
							  (NULL,
							  \'' . mysql_real_escape_string($user_pk) . '\',+91,
                                                           \'' . mysql_real_escape_string($_POST['details']['mobile']) . '\',
							  17)';
                                    $status5 = executeQuery($query5);
                                    $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_customer_' . $user_pk);
                                    executeQuery('UPDATE `user_profile` SET `directory` = \'' . $directory_customer . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
                                    if ($status1 && $status2 && $status3 && $status4 && $status5) {
                                        executeQuery("COMMIT");
                                        $jsondata["STATUS"] = "success";
                                    } else {
                                        executeQuery("ROLLBACK");
                                    }
                                }
                            }
                            echo $jsondata["STATUS"];
                            break;
                        }
                    case 'updateTraffic': {
                            if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
                                updateTraffic();
                            }
                            break;
                        }
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link') {
        mysql_close($link);
        exit(0);
    }
}

if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') {
    global $parameters;
    main($parameters);
    unset($_POST);
    exit(0);
}
require_once(DOC_ROOT . INC . 'res-header.php');
?>
<noscript>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=scriptdisable.html">
</noscript>
<div class="row">
    <div class="col-lg-12">
        &nbsp;
    </div>
</div>
<div style="margin-left:5%; margin-right:5%;">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-8">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#Home" data-toggle="tab" id="HomeBut">Home</a></li>
                    <li><a href="#Features" data-toggle="tab" id="FeaturesBut">Features</a></li>
                    <li><a href="#Find" data-toggle="tab" id="FindBut">Find</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active panel panel-info" id="Home">
                        <img src="<?php echo URL . ASSET_IMG; ?>tamboola/Banner-1200-627.png" class="img-responsive"/>
                    </div>
                    <div class="tab-pane fade" id="Features">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <i class="fa fa-clock-o fa-fw"></i> Tamboola features
                            </div>
                            <div class="panel-body">
                                <ul class="timeline">
                                    <li>
                                        <div class="timeline-badge primary"><i class="fa fa-cloud"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Enquiry</h4></div>
                                            <div class="timeline-body text-justify">
                                                <p>Records the enquiry made by the customers. And follow that enquiry with 3 different dates, makes the appropriate update of the Follow-ups. Once the customer is willing to join he can be added directorly.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge info"><i class="fa fa-user"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Customers</h4>
                                            </div>
                                            <div class="timeline-body text-justify">
                                                <p>Add the new customer to the club under which facility he is willing to join. View all customer, perform operation like Delete, Flag, Unflag and Edit. A group of customer can be added under a group. Import Excel file with bluk customer records.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="timeline-badge primary"><i class="fa fa-money"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Accounts</h4>
                                            </div>
                                            <div class="timeline-body text-justify">
                                                <p>Managing accounts was never so easy, we provide you a software which can mange your club/gym account with ease.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge info"><i class="fa fa-pencil-square-o"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Manage</h4>
                                            </div>
                                            <div class="timeline-body text-justify">
                                                <p>With this software you can keep track of your customer payment and attendance.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="timeline-badge primary"><i class="fa fa-money"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Stats</h4>
                                            </div>
                                            <div class="timeline-body text-justify">
                                                <p>Check daily statistic of your gym. Daily statistic of accounts, customers, and trainer on the go. any-time with your mobile or your PC.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge info"><i class="fa fa-mobile"></i></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">CRM</h4>
                                            </div>
                                            <div class="timeline-body text-justify">
                                                <p>We provide Mobile application for your gym customer. so that they can manage there workout and lot more with ther mobile. mobile app are meant to improve your business.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade panel panel-info" id="Find">
                        <div class="panel-heading"><h4><strong><i class="fa fa-search fa-x2 fa-fw"></i>&nbsp;Find My Club / Gym</strong></h4></div>
                        <div class="panel-body">
                            <fieldset id="gym_searchhform">
                                <div class="form-group">
                                    <div class="input-group input-group-md">
                                        <span class="input-group-addon text-info">City Name</span>
                                        <input class="form-control" name="gym_searchh" type="text" id="gym_searchh" maxlength="100"/>
                                        <p class="help-block" id="gym_searchh_msg"></p>
                                    </div>
                                </div>
                                <button type="button" name="gymsearch" id="gymsearch" class="btn btn-info btn-block"><i class="fa fa-search fa-x2 fa-fw"></i>&nbsp;Search</button>
                            </fieldset>
                        </div>
                        <div class="panel-footer table-responsive" id="listofgyms">Here you will find list of club / gym based on cities in India. </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" >
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#SignIn" data-toggle="tab" id="SignInBut">SignIn</a></li>
					<li><a href="#Owner" data-toggle="tab" id="RegisterBut">Owner</a></li>
                    <li><a href="#Register" data-toggle="tab" id="RegisterBut">Customer</a></li>
                   
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active panel panel-info" id="SignIn">
                        <div class="panel-heading"><h4><strong><i class="fa fa-lock fa-x2 fa-fw"></i>&nbsp;SignIn</strong></h4></div>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <fieldset id="signinform">
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon text-info" id="user_name_msg"><i class="fa fa-envelope fa-fw"></i></span>
                                            <input class="form-control" name="user_name" type="email" id="user_name" maxlength="100" required placeholder="Email Id"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon text-info" id="pass_msg"><i class="fa fa-key fa-fw"></i></span>
                                            <input class="form-control" name="password" type="password" id="password" value="" maxlength="100" placeholder="Password"/>
                                        </div>
                                    </div>
                                    <button class="btn btn-info btn-block" href="javascript:void(0);" id="sigininbut"><i class="fa fa-sign-in fa-fw fa-2x"></i> &nbsp;SignIn</button>
                                </fieldset>
                            </div>
                        </div>
                        <div class="panel-footer" id="SignInOutput">Sign In status.</div>
                    </div>
                    <div class="tab-pane fade panel panel-info" id="Register">
                        <div class="panel-heading"><h4><strong><i class="fa fa-user"></i> Fitness Customer Registration</strong></h4></div>
                        <div class="panel-body">
                            <fieldset id="custregform">
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon text-info" id="cust_nmmsg"><i class="fa fa-user fa-fw"></i></span>
                                        <input class="form-control"  name="cust_name" required type="text" id="cust_name" required="" placeholder="Full Name"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon" id="emmsg"><i class="fa fa-envelope fa-fw"></i></span>
                                        <input name="email" type="email" class="form-control" id="email" required   required="" placeholder="Email Id"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon" id="cellmsg">+91</span>
                                        <input name="cell_number" type="text"  class="form-control" pattern="[0-9]{10}" maxlength="10" id="cell_numbeb" required="" placeholder="Cell Number"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon" id="engmsg"><i class="fa fa-users fa-fw"></i></span>
                                        <select class="form-control" id="gender" required="">
                                            <option value="">Select Gender</option>
                                            <option value="1"><i class="fa fa-male fa-fw"></i> Male</option>
                                            <option value="2"><i class="fa fa-female fa-fw"></i> Female</option>
                                            <option value="3"><i class="fa fa-genderless fa-fw"></i> Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon" id="passmsgmsg"><i class="fa fa-key fa-fw"></i></span>
                                        <input name="regpassword" type="password"  class="form-control" pattern=".{6,20}" id="regpassword" maxlength="20" required="" placeholder="Password"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon" id="cpassmsgmsg"><i class="fa fa-key fa-fw"></i></span>
                                        <input name="cpassword" type="password" class="form-control" pattern=".{6,20}" id="cpassword" maxlength="20" required="" placeholder="Confirm Password"/>
                                    </div>
                                </div>
                                <button type="button" id="custregformBut" class="btn btn-info btn-block"><i class="fa fa-upload fa-x2 fa-fw"></i>&nbsp;Register</button>
                            </fieldset>
                        </div>
                        <div class="panel-footer" id="RegisterOutput">Registration status.</div>
                    </div>
                    <div class="tab-pane fade panel panel-info" id="Owner">
                        <div class="panel-heading"><h4><strong><i class="fa fa-user"></i> Fitness Owner Registration</strong></h4></div>
                        <div class="panel-body">
                            <form id="OwnerForm">
                                <fieldset id="custregform">
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon text-info" id="ocust_nmmsg"><i class="fa fa-user fa-fw"></i></span>
                                            <input class="form-control"  name="ocust_name" required type="text" id="ocust_name" required="" placeholder="Full Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" id="oemmsg"><i class="fa fa-envelope fa-fw"></i></span>
                                            <input name="email" type="email" class="form-control" id="oemail"    required="" placeholder="Email Id"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" id="ocellmsg">+91</span>
                                            <input name="ocell_number" type="text"  class="form-control" pattern="[0-9]{10}" maxlength="10" id="ocell_numbeb" required="" placeholder="Cell Number"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" id="oengmsg"><i class="fa fa-users fa-fw"></i></span>
                                            <select class="form-control" id="ogender" required="">
                                                <option value="">Select Gender</option>
                                                <option value="1"><i class="fa fa-male fa-fw"></i> Male</option>
                                                <option value="2"><i class="fa fa-female fa-fw"></i> Female</option>
                                                <option value="3"><i class="fa fa-genderless fa-fw"></i> Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" id="opassmsgmsg"><i class="fa fa-key fa-fw"></i></span>
                                            <input name="oregpassword" type="password"  class="form-control" pattern=".{6,20}" id="oregpassword" maxlength="20" required="" placeholder="Password"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" id="ocpassmsgmsg"><i class="fa fa-key fa-fw"></i></span>
                                            <input name="ocpassword" type="password" class="form-control" pattern=".{6,20}" id="ocpassword" maxlength="20" required="" placeholder="Confirm Password"/>
                                        </div>
                                    </div>
                                    <button type="button" id="ownerFormBut" class="btn btn-info btn-block"><i class="fa fa-upload fa-x2 fa-fw"></i>&nbsp;Register</button>
                                </fieldset>
                            </form>
                        </div>
                        <div class="panel-footer" id="OwnerRegisterOutput">Registration status.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="display:none;">
            <div id="About">
                <div class="panel panel-info">
                    <div class="panel-heading"><i class="fa fa-bell fa-fw"></i> Alert</div>
                    <div class="panel-body" ></div>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_open" id="myModal_custreg" style="display: none;"></button>
    <div class="modal fade" id="myModal_open" tabindex="-1" role="dialog" aria-labelledby="myModal_open" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModal_title">
                        <i class="fa fa-bell fa-fw fa-x2"></i> Register</h4>
                </div>
                <div class="modal-body" id="myModal_enqaddbody">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
require_once(DOC_ROOT . INC . 'res-footer.php');
?>