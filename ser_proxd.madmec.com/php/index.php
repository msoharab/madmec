<?php
require_once("config.php");
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);

function main() {
    if (!ValidateAdmin()) {
        session_destroy();
        header('Location:' . URL);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'load_settings') {
        LoadSettings();
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'save_settings') {
        echo "yes im in";
        savesettings();
        unset($_POST);
        exit(0);
    }
}

function LoadSettings() {
    $id = array();
    $clinic_name = array();
    $clinic_address = array();
    $sms = array();
    $old_pwd = array();
    $pass_status = array();
    $abc = array();
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $query = "SELECT * FROM `settings` ";
            $res = executeQuery($query);
            if (mysql_num_rows($res)) {
                while ($row = mysql_fetch_assoc($res)) {
                    $data[] = $row;
                }
                for ($i = 0; $i < sizeof($data); $i++) {
                    $id[$i] = explode(",", $data[$i]['id']);
                    $clinic_name[$i] = explode(",", $data[$i]['clinic_name']);
                    $doctor_name[$i] = explode(",", $data[$i]['doctor_name']);
                    $clinic_address[$i] = explode(",", $data[$i]['clinic_address']);
                    $sms[$i] = explode(",", $data[$i]['sms_status']);
                    $pass_status[$i] = explode(",", $data[$i]['password_status']);
                    $old_pwd[$i] = explode(",", $data[$i]['ac_password']);
                }

                $abc = array(
                    "id" => $id,
                    "pass_status" => $pass_status,
                    "clinic_name" => $clinic_name,
                    "clinic_add" => $clinic_address,
                    "doctor_name" => $doctor_name,
                    "sms_change" => $sms,
                    "old_pwd" => $old_pwd,
                );

                echo(json_encode($abc));
            } else {
                echo "please enter new settings";
                echo(json_encode($abc));
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
}

function savesettings() {
    $sms = $_POST['sms_change'];
    $newpassword = $_POST['new_pwd'];
    $clinic_name = $_POST['clinic_name'];
    $clinic_address = $_POST['clinic_address'];
    $doctor_name = $_POST['doctor_name'];
    $pwd_change = $_POST['pwd_change'];
    $pwd_status = $_POST['pwd_status'];
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $query = "SELECT * FROM `settings` ";
            $res = executeQuery($query);
            echo $res;
            if (mysql_num_rows($res) == 0) {
                $query1 = "INSERT INTO `settings`(`admin_id`,`ac_user_name`, `ac_password`,`doctor_name`,`clinic_name`, `clinic_address`, `sms_status`, `reset_link`, `authentication`, `status_id`) VALUES ('" . $_SESSION['ADMIN_ID'] . "','" . $_SESSION['ADMIN_NAME'] . "','NULL','NULL','NULL','NULL','NULL','NULL','NULL','NULL')";
            } elseif (mysql_num_rows($res) > 0) {
                $query1 = "UPDATE `settings` SET `admin_id`='" . $_SESSION['ADMIN_ID'] . "',`ac_user_name`='" . $_SESSION['ADMIN_NAME'] . "' WHERE `settings`.`id` = 1; ";
            }
            $res1 = executeQuery($query1);
            if ($_POST['pwd_status'] || $_POST['new_pwd'] || $_POST['sms_change'] || ($_POST['clinic_name'] || $_POST['clinic_address'] || $_POST['doctor_name'])) {
                if ($_POST['pwd_status']) {
                    if ($pwd_status == 'off') {
                        $query2 = "UPDATE `settings` SET `password_status`='29' WHERE (SELECT `id` FROM `status` WHERE `statu_name`= 'off' AND `status`='1')";
                    } else {
                        $query2 = "UPDATE `settings` SET `password_status`='28' WHERE (SELECT `id` FROM `status` WHERE `statu_name`= 'on' AND `status`='1')";
                    }
                    $res2 = executeQuery($query2);
                }
                if ($_POST['new_pwd']) {
                    $query3 = "UPDATE `settings` SET `ac_password`='" . hash('sha256', $newpassword, false) . "' WHERE  `admin_id`='" . $_SESSION['ADMIN_ID'] . "'";
                    $res3 = executeQuery($query3);
                }
                if ($_POST['sms_change']) {
                    if ($sms == 'off') {
                        $query4 = "UPDATE `settings` SET `sms_status`='29' WHERE (SELECT `id` FROM `status` WHERE `statu_name`= 'off' AND `status`='1')";
                    } else {
                        $query4 = "UPDATE `settings` SET `sms_status`='28' WHERE (SELECT `id` FROM `status` WHERE `statu_name`= 'on' AND `status`='1')";
                    }
                    $res4 = executeQuery($query4);
                }
                if (($_POST['clinic_name']) || ( $_POST['clinic_address']) || ($_POST['doctor_name']) != '') {
                    $query5 = "UPDATE `settings` SET `doctor_name`='" . mysql_real_escape_string($doctor_name) . "',`clinic_name`='" . mysql_real_escape_string($clinic_name) . "',`clinic_address`='" . mysql_real_escape_string($clinic_address) . "' WHERE `settings`.`id` = 1; ";
                    $res5 = executeQuery($query5);
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
}

main();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- BOOTSTRAP STYLES-->
        <link href="<?php echo URL . ASSET_CSS; ?>bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="<?php echo URL . ASSET_CSS; ?>font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" />
        <!-- MORRIS CHART STYLES-->
        <link href="<?php echo URL . ASSET_CSS; ?>morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="<?php echo URL . ASSET_CSS; ?>custom.css" rel="stylesheet" />
        <!-- jquery ui -->
        <link href="<?php echo URL . ASSET_CSS; ?>jquery-ui.min.css" rel="stylesheet" />
        <link href="<?php echo URL . ASSET_CSS; ?>web.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

        <title><?php echo $_SESSION['CLINIC']; ?>(PROX DENTAL)</title>
        <script src="<?php echo URL . ASSET_JS; ?>config.js"></script>
        <style>
            html,
            body { height: 100%; font-size:14px;font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;}

            body {
                margin: 0;
                background: linear-gradient(#eeeeee, #cccccc);
                overflow: hidden;
                background: url("../assets/img/bg2.jpg") center center no-repeat;
                background-size:cover;
            }

            li a{color:#FFF; font-size:150%; font-weight:bold; text-decoration:none;}
            .footer {
                background-image: url("../assets/img/footer_bg.png");
                background-repeat: repeat-x;
                bottom: 0px;
                width: 100%;
                position: fixed;
                height: 40px;
            }
            #icons tr td{padding:20px; }
            #icons tr td:hover{background-color: rgba(0,0,0,0.6); }
            #icons tr td a{ text-decoration: none;}
            .clinic_name{color:#FFF; text-shadow: 2px 2px 7px  #000;}
            .links{ font-weight: bold;  color:#FFF; text-shadow: 2px 2px 7px  #000; alignment-adjust: central;}
            #video_list{background-color: #F8F8F8; border: solid 3px #eeeeee; border-radius: 4px; box-shadow: 0px 0px 12px 2px #cccccc;}
            .thumb{ width: 150px; height: 150px;
                    text-align: center;
                    padding: 25px; float: left}
            #cs_form{background-color: #F8F8F8; border: solid 3px #eeeeee; width: 50%; position: absolute;top:75px;padding:5px;
                     margin: auto; box-shadow: 1px 1px 17px #000;}
            i{color:#4F8DB3;}
            /*#settings_form{background-color: #F8F8F8; border: solid 3px #eeeeee; width: 75%; position: absolute;top:75px;padding:5px;
            margin: auto; box-shadow: 1px 1px 17px #000;}*/
            i{color:#4F8DB3;}
            h3{padding:0px;border:0px;margin:0px}
            #close{padding:0px;border:0px;margin:0px}
            #open{cursor: pointer;}
            #close_box{cursor: pointer;}
        </style>
    </head>

    <body>
        <div>
            <h1 align="center" class="clinic_name"><?php echo $_SESSION['CLINIC']; ?></h1>
            <div class="row">
                <div class="col-md-4">
                    <table id="icons" border="0">
                        <tr>

                            <td align="center">
                                <a href="<?php echo URL . PHP . DENTAL; ?>patient.php">
                                    <img src="<?php echo URL . ASSET_IMG . 'icon_group.png'; ?>" height="60" width="60"/>
                                    <br/>
                                    <span class="links">patients</span>
                                </a>
                            </td>
                            <td align="center">
                                <a href="<?php echo URL . PHP; ?>source.php">
                                    <img src="<?php echo URL . ASSET_IMG . 'source.png'; ?>" height="60" width="60"/>
                                    <br/>
                                    <span class="links">Source Accounts</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <a href="<?php echo URL . PHP . DENTAL; ?>appointment.php">
                                    <img src="<?php echo URL . ASSET_IMG . 'appointment.png'; ?>" height="60" width="60"/>
                                    <br/>
                                    <span class="links">Appoinments</span>
                                </a>
                            </td>
                            <td align="center">
                                <a href="<?php echo URL . PHP; ?>target.php">
                                    <img src="<?php echo URL . ASSET_IMG . 'target.png'; ?>" height="60" width="60"/>
                                    <br/>
                                    <span class="links">Target Accounts</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <a href="<?php echo URL . PHP; ?>receipts.php">
                                    <img src="<?php echo URL . ASSET_IMG . 'receipt.png'; ?>" height="60" width="60"/>
                                    <br/>
                                    <span class="links">Receipts/Income</span>
                                </a>
                            </td>
                            <td align="center">
                                <a href="<?php echo URL . PHP; ?>reports.php">
                                    <img src="<?php echo URL . ASSET_IMG . 'report.png'; ?>" height="60" width="60"/>
                                    <br/>
                                    <span class="links">Reports</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <a href="<?php echo URL . PHP; ?>vouchers.php">
                                    <img src="<?php echo URL . ASSET_IMG . 'voucher.png'; ?>" height="60" width="60"/>
                                    <br/>
                                    <span class="links">Vouchers/Outgoing</span>
                                </a>
                            </td>
                        </tr>
                    </table>

                </div>
                <div class="col-md-8" align="right" style="padding-right:100px;">
                    <div id="video_icon">
                        <table cellpadding="10" cellspacing="10" >
                            <tr>
                                <td align="center">
                                    <a href="javascript:void();" onclick="show_vedio_list();">
                                        <img src="<?php echo URL . ASSET_IMG . 'videos.png'; ?>" height="100" width="100"/>
                                        <br/>
                                        <span class="links">Patient Education videos </span>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <a href="javascript:void();" onclick="show_cs();">
                                        <img src="<?php echo URL . ASSET_IMG . 'cs.png'; ?>" height="100" width="100"/>
                                        <br/>
                                        <span class="links">Contact Us</span>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <a id="open" onclick="javascript:show_settings();">
                                        <img src="<?php echo URL . ASSET_IMG . 'setting.png'; ?>" height="100" width="100"/>
                                        <br/>
                                        <span class="links">Settings</span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <center id="cs_form" style="display:none;" >

                        <table class="table" width="100%">
                            <tr>
                                <td align="right" colspan="3">
                                    <a  onclick="javascript:close_cs();" ><strong>Close</strong></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <h1 align="center">Customer Support</h1>
                                    <h4 align="center">MadMeC®</h4>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>
                                        <i class="fa fa-phone-square fa-2x"></i> 080 2658-1108<br>
                                            <i class="fa fa-mobile fa-2x"></i> +91 8892268380<br/>
                                            <i class="fa fa-mobile fa-2x"></i> +91 99162826282<br>
                                                <i class="fa fa-envelope fa-2x"></i> <a href="mailto:info@madmec.com">info@madmec.com</a>
                                                </p>
                                                </td>
                                                <td width="5%"></td>
                                                <td align="right">

                                                    <p>
                                                        <i class="fa fa-map-marker fa-2x"></i>
                                                        <strong>
                                                            #42, 5<sup>th</sup> cross, 22<sup>nd</sup> main,<br>
                                                                near Mahaveer wilton apartment,<br>
                                                                    J P Nagar 5th phase <br>
                                                                        Bangalore: 560078, India.
                                                                        </strong>
                                                                        </p>
                                                                        </td>
                                                                        </tr>
                                                                        </table>

                                                                        </center>

                                                                        <center id="settings_form" style="display:none;" >
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">

                                                                                    <table class="table" width="100%" id="close">

                                                                                        <tr>
                                                                                            <td style="padding-left:250px;padding-top:20px;"><h3>Settings</h3></td>
                                                                                            <td align="right" colspan="3" style="padding-right:7px">
                                                                                                <a id="close_box" onclick="javascript:close_settings();" ><strong><acronym title="Close"><i class="fa fa-times fa-2x"></i></acronym></strong></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <hr style="height:5px;color:#eee;margin:7px;">
                                                                                        <div class="container-fluid">
                                                                                            <div class="panel-body" id="settings_saved" style="text-align: left;padding-top:0px">
                                                                                                <center><button type="button"  class="btn btn-info" id="pre_settings" onclick="javascript:load_settings()">Show Previous Settings</button></center>
                                                                                                <form role="form" id="form_add">
                                                                                                    <label >Clinic Details:</label><br />
                                                                                                    <div class="row" id="present_details" style="text-align: left;"></div>
                                                                                                    <button type="button" class="btn btn-success" id="change_add" onclick="javascript:change_address()">Edit</button><hr style="height:5px;color:#eee;margin:7px;">
                                                                                                        <div class="row" id="clinic_details">
                                                                                                            <div class="form-group" style="text-align: left;">
                                                                                                                Name of Clinic:<input type="text" placeholder="Clinic Name" id="clinic_name" class="form-control"/>
                                                                                                                Address:<textarea id="clinic_address" class="form-control" rows="2"  placeholder="100 character description"></textarea>
                                                                                                                Doctor Name:<textarea id="doctor_name" class="form-control" rows="2"  placeholder="100 character description"></textarea>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="form-group" style="text-align: left;">
                                                                                                                <div class="col-md-8">
                                                                                                                    <i class="fa fa-envelope fa-2x"></i><label>Enable/Disable SMS:</label><br />
                                                                                                                </div>
                                                                                                                <div class="col-md-4">
                                                                                                                    <select id="sms_change" class="form-control" >
                                                                                                                        <option value="" selected>--Select--</option>
                                                                                                                        <option value="on" >On</option>
                                                                                                                        <option value="off" >Off</option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div><hr style="height:5px;color:#eee;margin:7px;">
                                                                                                            <div class="row">
                                                                                                                <div class="form-group" style="text-align: left;">
                                                                                                                    <div class="col-md-8">
                                                                                                                        <i class="fa fa-key fa-2x"></i><label>Turn On Accounts Password:</label><br />
                                                                                                                    </div>
                                                                                                                    <div class="col-md-4">
                                                                                                                        <select id="pwd_status" class="form-control" >
                                                                                                                            <option value="" selected>--Select--</option>
                                                                                                                            <option value="off" >Off</option>
                                                                                                                            <option value="on" >On</option>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>	<hr style="height:5px;color:#eee;margin:7px;">
                                                                                                                <div class="row">
                                                                                                                    <div class="form-group" style="text-align: left;">
                                                                                                                        <div class="col-md-8">
                                                                                                                            <i class="fa fa-key fa-2x"></i><label>Change Password:</label><br />
                                                                                                                        </div>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <select id="pwd_change" class="form-control" onchange="javascript:check_pass(this);">
                                                                                                                                <option value="" selected>--Select--</option>
                                                                                                                                <option value="off" >No</option>
                                                                                                                                <option value="on" >Yes</option>
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>	<hr style="height:5px;color:#eee;margin:7px;">

                                                                                                                    <div class="form-group" style="text-align: left;">
                                                                                                                        <div id="pwd_div">
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <label>Enter New Password:</label>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <label>Confirm New Password:</label>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <input class="form-control" type="password" placeholder="New Password" id="new_pwd" required >
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <input class="form-control" type="password" placeholder="Confirm Password" id="conf_pwd"  required >
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div id="divmsg"></div>
                                                                                                                    </div>

                                                                                                                    <div class="form-group" >
                                                                                                                        <div class="col-md-6">
                                                                                                                            <button type="button" class="btn btn-danger" id="set" onclick="javascript:save_settings()">Save Changes</button>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="form-group" >
                                                                                                                        <div class="col-md-6">
                                                                                                                            <button type="button" class="btn btn-danger" id="cancel" onclick="javascript:cancel_settings()">Cancel</button>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    </form>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    </center>


                                                                                                                    <div id="video_list" style="display:none;">
                                                                                                                        <a href="javascript:void();" onclick="close_vedio_list();" ><strong>Close</strong></a>
                                                                                                                        <center><h3>Patient Education videos </h3></center>
                                                                                                                        <div class="row">
                                                                                                                            <div class="col-md-5" style="height:400px; overflow: auto;">

                                                                                                                                <div class="thumb">
                                                                                                                                    <img src="//i.ytimg.com/vi/j0Ig2Z2CxXM/mqdefault.jpg" aria-hidden="true" alt="" height="90" width="120" onclick="show_vedio(1);">
                                                                                                                                        <strong>Root Canal Treatment</strong>
                                                                                                                                </div>
                                                                                                                                <div class="thumb">
                                                                                                                                    <img src="//i.ytimg.com/vi/pGKmW_I6rGE/mqdefault.jpg" aria-hidden="true" alt="" height="90" width="120" onclick="show_vedio(2);">
                                                                                                                                        <strong>Orthodontic Treatment</strong>
                                                                                                                                </div>
                                                                                                                                <div class="thumb">
                                                                                                                                    <img src="//i.ytimg.com/vi/99IYKKRMj7s/default.jpg" aria-hidden="true" alt="" height="90" width="120" onclick="show_vedio(3);">
                                                                                                                                        <strong>Impaction Surgery</strong>
                                                                                                                                </div>
                                                                                                                                <div class="thumb">
                                                                                                                                    <img src="//i.ytimg.com/vi/j0Ig2Z2CxXM/mqdefault.jpg" aria-hidden="true" alt="" height="90" width="120" onclick="show_vedio(4);">
                                                                                                                                        <strong>Implants</strong>
                                                                                                                                </div>
                                                                                                                                <div class="thumb">
                                                                                                                                    <img src="//i.ytimg.com/vi/L2kLdYR58iA/mqdefault.jpg" aria-hidden="true" alt="" height="90" width="120" onclick="show_vedio(5);">
                                                                                                                                        <strong>Pediatric dental care</strong>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="col-md-7">
                                                                                                                                <div class="bs-example" data-example-id="responsive-embed-16by9-iframe-youtube">
                                                                                                                                    <div class="embed-responsive embed-responsive-16by9" id="vedio">

                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <script>
                                                                                                                                function show_vedio(val) {
                                                                                                                                    var src = '';
                                                                                                                                    switch (val) {
                                                                                                                                        case 1:
                                                                                                                                            src = 'https://www.youtube.com/embed/j0Ig2Z2CxXM';
                                                                                                                                            break;
                                                                                                                                        case 2:
                                                                                                                                            src = "https://www.youtube.com/embed/pGKmW_I6rGE";
                                                                                                                                            break;
                                                                                                                                        case 3:
                                                                                                                                            src = "https://www.youtube.com/embed/99IYKKRMj7s";
                                                                                                                                            break;
                                                                                                                                        case 4:
                                                                                                                                            src = "https://www.youtube.com/embed/vSnwe_9Ezgw";
                                                                                                                                            break;
                                                                                                                                        case 5:
                                                                                                                                            src = "https://www.youtube.com/embed/L2kLdYR58iA";
                                                                                                                                            break;
                                                                                                                                        default:
                                                                                                                                            break;

                                                                                                                                    }
                                                                                                                                    $("#vedio").html('<iframe class="embed-responsive-item" src="' + src + '" allowfullscreen    height="450" width="100%" frameborder="0"></iframe>');
                                                                                                                                }
                                                                                                                            </script>

                                                                                                                        </div>



                                                                                                                        <script>
                                                                                                                        </script>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    </div>




                                                                                                                    <div class="footer">
                                                                                                                        <table width="100%" border="0">
                                                                                                                            <tr>
                                                                                                                                <td width="60">
                                                                                                                                    <a href="<?php echo URL . PHP; ?>logout.php">
                                                                                                                                        <img src="<?php echo URL . ASSET_IMG . 'exit.png'; ?>" height="60" width="60" style="position:absolute; top:-20px;"/>

                                                                                                                                    </a>
                                                                                                                                </td>
                                                                                                                                <td>

                                                                                                                                </td>
                                                                                                                                <td align="center" width="100">
                                                                                                                                    <strong style="color:#FFF;">
                                                                                                                                        <span id="txt"></span>
                                                                                                                                        <br />
                                                                                                                                        <?php echo date('d-M-Y'); ?>
                                                                                                                                    </strong>
                                                                                                                                </td>
                                                                                                                                <td width="45" align="center">
                                                                                                                                    <img src="<?php echo URL . ASSET_IMG; ?>F11.png" onclick="javascript:fullscreen();" id="full_screen"class="regular">
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </div>
                                                                                                                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                                                                                                                    <script type="text/javascript">
                                                                                                                                        function fullscreen() {
                                                                                                                                            var docElement, request;
                                                                                                                                            if ($("#full_screen").hasClass('regular')) {
                                                                                                                                                docElement = document.documentElement;
                                                                                                                                                request = docElement.requestFullScreen || docElement.webkitRequestFullScreen || docElement.mozRequestFullScreen || docElement.msRequestFullScreen;

                                                                                                                                                if (typeof request != "undefined" && request) {
                                                                                                                                                    request.call(docElement);
                                                                                                                                                }
                                                                                                                                                $("#full_screen").removeClass('regular');
                                                                                                                                            }
                                                                                                                                            else {
                                                                                                                                                docElement = document;
                                                                                                                                                request = docElement.cancelFullScreen || docElement.webkitCancelFullScreen || docElement.mozCancelFullScreen || docElement.msCancelFullScreen || docElement.exitFullscreen;
                                                                                                                                                if (typeof request != "undefined" && request) {
                                                                                                                                                    request.call(docElement);
                                                                                                                                                }
                                                                                                                                                $("#full_screen").addClass('regular');
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                        function show_vedio_list() {
                                                                                                                                            $("#video_list").fadeIn(1000);
                                                                                                                                            $("#video_icon").hide();
                                                                                                                                        }
                                                                                                                                        function close_vedio_list() {
                                                                                                                                            $("#video_list").fadeOut(1000);
                                                                                                                                            $("#video_icon").show();
                                                                                                                                        }
                                                                                                                                        function show_cs() {

                                                                                                                                            $("#cs_form").fadeIn(2000);
                                                                                                                                            $("#video_icon").fadeOut(1000);
                                                                                                                                        }
                                                                                                                                        function close_cs() {
                                                                                                                                            $("#video_icon").fadeIn(2000);
                                                                                                                                            $("#cs_form").fadeOut(1000);
                                                                                                                                        }
                                                                                                                                        function show_settings() {
                                                                                                                                            $("#settings_form").fadeIn();
                                                                                                                                            $("#form_add").hide();
                                                                                                                                            $("#pre_settings").show();
                                                                                                                                            $("#video_icon").hide();
                                                                                                                                        }
                                                                                                                                        function close_settings() {
                                                                                                                                            $("#settings_form").fadeOut();
                                                                                                                                            $("#form_add")[0].reset();
                                                                                                                                            $("#video_icon").show();
                                                                                                                                        }
                                                                                                                                        function check_pass(elm) {
                                                                                                                                            if (elm.value == 'on') {
                                                                                                                                                $("#pwd_div").show();
                                                                                                                                                return true;
                                                                                                                                            }
                                                                                                                                            else {
                                                                                                                                                $("#pwd_div").hide();
                                                                                                                                                return false;
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                        function change_address() {
                                                                                                                                            $("#change_add").hide();
                                                                                                                                            $("#clinic_details").show();
                                                                                                                                            $("#present_details").slideUp();
                                                                                                                                            return false;
                                                                                                                                        }
                                                                                                                                        function cancel_settings() {
                                                                                                                                            $('#load_box').show();
                                                                                                                                            load_settings();
                                                                                                                                            $('#load_box').hide();
                                                                                                                                        }
                                                                                                                                        function load_settings() {
                                                                                                                                            $("#pre_settings").hide();
                                                                                                                                            $("#form_add").show();
                                                                                                                                            $("#change_add").show();
                                                                                                                                            $("#present_details").show();
                                                                                                                                            $("#clinic_details").hide();
                                                                                                                                            $("#pwd_div").hide();
                                                                                                                                            $.ajax({
                                                                                                                                                url: window.location.href,
                                                                                                                                                type: 'POST',
                                                                                                                                                data: {
                                                                                                                                                    action: 'load_settings'
                                                                                                                                                },
                                                                                                                                                success: function (data, textStatus, xhr) {
                                                                                                                                                    data = $.trim(data);
                                                                                                                                                    var load_set = JSON.parse(data);
                                                                                                                                                    $("#clinic_name").val(load_set.clinic_name);
                                                                                                                                                    $("#doctor_name").val(load_set.doctor_name);
                                                                                                                                                    $("#clinic_address").val(load_set.clinic_add);
                                                                                                                                                    $("#present_details").html('<div class="col-md-9"><div class="panel panel-danger" style="margin:5px"><div class="panel-body"><b>Clinic Name:</b>' + load_set.clinic_name + '<br><b>Address:</b><address>' + load_set.clinic_add + '</address><br><b>Doctor Name:</b>' + load_set.doctor_name + '</div></div></div>');
                                                                                                                                                    $("#old_pwd").val(load_set.old_pwd);
                                                                                                                                                    if (load_set.sms_change == "28") {
                                                                                                                                                        $("#sms_change").val('on');
                                                                                                                                                    }
                                                                                                                                                    else
                                                                                                                                                    {
                                                                                                                                                        $("#sms_change").val('off');
                                                                                                                                                    }
                                                                                                                                                    if (load_set.pass_status == "28") {
                                                                                                                                                        $("#pwd_status").val('on');
                                                                                                                                                    }
                                                                                                                                                    else
                                                                                                                                                    {
                                                                                                                                                        $("#pwd_status").val('off');
                                                                                                                                                    }
                                                                                                                                                },
                                                                                                                                            });
                                                                                                                                        }
                                                                                                                                        function save_settings() {
                                                                                                                                            var sms = $("#sms_change").val();
                                                                                                                                            var new_pwd = $("#new_pwd").val();
                                                                                                                                            var conf_pwd = $("#conf_pwd").val();
                                                                                                                                            var clinic_name = $("#clinic_name").val();
                                                                                                                                            var clinic_add = $("#clinic_address").val();
                                                                                                                                            var pwd_change = $("#pwd_change").val();
                                                                                                                                            var pwd_status = $("#pwd_status").val();
                                                                                                                                            var doc_name = $("#doctor_name").val();
                                                                                                                                            var flag = true;
                                                                                                                                            if (sms != '' || pwd_change != '' || clinic_name != '' || clinic_add != '') {
                                                                                                                                                if (pwd_change == 'on') {
                                                                                                                                                    if ((new_pwd == conf_pwd) && (new_pwd != '')) {
                                                                                                                                                        $('#divmsg').html('<strong >Passwords Match.</strong>');
                                                                                                                                                    }
                                                                                                                                                    else {
                                                                                                                                                        $('#divmsg').html('<strong >Passwords do not Match.</strong>');
                                                                                                                                                        flag = false;
                                                                                                                                                    }
                                                                                                                                                }

                                                                                                                                            }
                                                                                                                                            else {
                                                                                                                                                flag = false;
                                                                                                                                                alert('empty form');
                                                                                                                                            }
                                                                                                                                            console.log(flag);
                                                                                                                                            if (flag) {
                                                                                                                                                $("#form_add").hide();
                                                                                                                                                var data = {
                                                                                                                                                    action: 'save_settings',
                                                                                                                                                    'sms_change': sms,
                                                                                                                                                    'pwd_change': pwd_change,
                                                                                                                                                    'pwd_status': pwd_status,
                                                                                                                                                    'new_pwd': new_pwd,
                                                                                                                                                    'clinic_name': clinic_name,
                                                                                                                                                    'clinic_address': clinic_add,
                                                                                                                                                    'doctor_name': doc_name
                                                                                                                                                };
                                                                                                                                                $.ajax({
                                                                                                                                                    url: window.location.href,
                                                                                                                                                    type: 'POST',
                                                                                                                                                    data: data,
                                                                                                                                                    success: function (data) {
                                                                                                                                                        if (data == 0) {
                                                                                                                                                            alert('empty form');
                                                                                                                                                            return false;
                                                                                                                                                        }
                                                                                                                                                        else {
                                                                                                                                                            alert('Your Settings Have Been Configured,close the window and reopen again');
                                                                                                                                                        }

                                                                                                                                                    },
                                                                                                                                                });
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                        /*for digital clock at bottom*/
                                                                                                                                        function startTime() {
                                                                                                                                            var today = new Date();
                                                                                                                                            var h = today.getHours();
                                                                                                                                            var m = today.getMinutes();
                                                                                                                                            var s = today.getSeconds();
                                                                                                                                            if (h >= 12) {
                                                                                                                                                h = h - 12;
                                                                                                                                                A = 'PM';
                                                                                                                                            }
                                                                                                                                            else {
                                                                                                                                                A = 'AM';
                                                                                                                                            }
                                                                                                                                            m = checkTime(m);
                                                                                                                                            s = checkTime(s);
                                                                                                                                            document.getElementById('txt').innerHTML = h + ":" + m + ":" + s + " " + A;
                                                                                                                                            var t = setTimeout(function () {
                                                                                                                                                startTime()
                                                                                                                                            }, 500);
                                                                                                                                        }

                                                                                                                                        function checkTime(i) {
                                                                                                                                            if (i < 10) {
                                                                                                                                                i = "0" + i
                                                                                                                                            }
                                                                                                                                            ;  // add zero in front of numbers < 10
                                                                                                                                            return i;
                                                                                                                                        }
                                                                                                                                        $(document).ready(function () {
                                                                                                                                            startTime();
                                                                                                                                        });
                                                                                                                    </script>
                                                                                                                    </body>
                                                                                                                    </html>
