<?php
define("MODULE_1", "config.php");
define("MODULE_2", "database.php");
require_once(MODULE_1);
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false
);
unset($_POST);
function main($parameters) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $flag = ValidateAdmin();
            if ($flag) {
                echo 'login';
            } else if (!$flag) {
                switch ($parameters["action"]) {
                    case "updateTraffic":
                        updateTraffic();
                        break;
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    exit(0);
}
if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') {
    global $parameters;
    main($parameters);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="assets/img/favicon.ico">
        <title>Driver / Rider Tracker</title>
        <script src="assets/js/var_config.js"></script>
        <script src="assets/js/config.js"></script>
        <script src="assets/js/jquery-min-2.0.2.js"></script>
        <script src="assets/js/index.js"></script>
        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="assets/css//signin.css" rel="stylesheet">
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!--<script src="assets/js/ie-emulation-modes-warning.js"></script>-->
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!--<script src="assets/js/ie10-viewport-bug-workaround.js"></script>-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="reset_form" style="display:none;top: 0px; left: 0px; position: absolute; height: 100%; width: 100%; background: none repeat scroll 0% 0% rgba(0, 0, 0, 0.7); z-index: 10;" align="center">
            <div style="height:auto; width:400px;position:relative; top:100px; padding:50px; background:#FFF;">
                <div align="right">
                    <a href="javascript:void(0);" id="close_form">Close</a>
                </div>
                <div id="reset_src">
                    <form>
                        <h3 class="form-signin-heading">Please enter the email to reset the password:</h3>
                        <input name="re_email" id="re_email" class="form-control" placeholder="Email address" required="" type="email">
                        <br>
                        <button class="btn btn-lg btn-danger btn-block" type="button" id="send_email">Reset Now</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Driver / Rider Tracker</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div id="lmcarelogin">
                <form class="form-signin" autocomplete="off">
                    <h2 class="form-signin-heading">Please sign in</h2>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username" required=""/>
                    <p class="help-block"  id="user_name_msg">Press enter or go button to move to next field.</p>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required=""/>
                    <p class="help-block" id="pass_msg">Press enter or go button to SignIn.</p>
                    <label class="checkbox">
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                    <button class="btn btn-lg btn-primary btn-block" id="sigininbut"  type="button">Sign in</button>
                    <a href="javascript:void(0);" id="reset_from_a"><h4>Change Password/forgot password</h4></a>	
                    <br />

                </form>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-body" id="output">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
