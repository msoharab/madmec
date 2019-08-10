<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
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
<div class="login-box">
    <div class="login-logo">
        <a href="javascript:void(0);"><b>Pic3Pic</b>&nbsp;Ver 1.0</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <div class="panel panel-warning" id="SignIn">
            <div class="panel-heading"><h4><strong><i class="fa fa-lock  fa-fw"></i>&nbsp;SignIn</strong></h4></div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <fieldset id="signinform">
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon text-warning" id="user_name_msg"><i class="fa fa-envelope fa-fw"></i></span>
                                <input class="form-control" name="user_name" type="email" id="user_name" maxlength="100" required placeholder="Email Id"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon text-warning" id="pass_msg"><i class="fa fa-key fa-fw"></i></span>
                                <input class="form-control" name="password" type="password" id="password" value="" maxlength="100" placeholder="Password"/>
                            </div>
                        </div>
                        <button class="btn btn-warning btn-block" href="javascript:void(0);" id="sigininbut"><i class="fa fa-sign-in fa-fw "></i> &nbsp;SignIn</button>
                    </fieldset>
                </div>
            </div>
            <div class="panel-footer" id="SignInOutput">Sign In status.</div>
        </div>
    </div>
</div>
<script src="<?php echo URL . ASSET_JSF; ?>index.js" type="text/javascript"></script>
<?php
require_once(DOC_ROOT . INC . 'res-footer.php');
?>