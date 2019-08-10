<?php
define("MODULE_1", "config.php");
define("MODULE_2", "database.php");
require_once(MODULE_1);
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
);

function main($parameters) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
//				if(!ValidateAdmin()){
//					session_destroy();
//					echo "logout";
//				}else{
            switch ($parameters["action"]) {


                case "checkuser": {
                        $params = array(
                            "username" => isset($_POST['details']['username']) ? $_POST['details']['username'] : false,
                            "password" => isset($_POST['details']['password']) ? $_POST['details']['password'] : false,
                        );
                        if (checkuser($params)) {
                            $_SESSION['ADMIN_NAME']=$params["username"];
                            $_SESSION['ADMIN_PASS']=$params["password"];
                            echo "success";
                        } else {
                            echo "denied";
                            unset($_SESSION);
                        }
                    }
                    break;
            }
//				}
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    unset($_POST);
    exit(0);
}

function checkuser($params = false) {
    $query = "SELECT * FROM `user_profile`
						WHERE `user_name` = '" . mysql_real_escape_string($params['username']) . "'
						AND `password` = '" . mysql_real_escape_string($params['password']) . "'; ";
    $res = executeQuery($query);
    return mysql_num_rows($res);
}

if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') {
    global $parameters;
    main($parameters);
    unset($_POST);
    exit(0);
}
?>
<html>
    <head>
        <title>AIMIM Bangalore Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Modern Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
              Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo URL . ASSET_CSS; ?>bootstrap.min.css" rel='stylesheet' type='text/css' />
        <!-- Custom CSS -->
        <link href="<?php echo URL . ASSET_CSS; ?>style.css" rel='stylesheet' type='text/css' />
        <!-- Graph CSS -->
        <link href="<?php echo URL . ASSET_CSS; ?>lines.css" rel='stylesheet' type='text/css' />
        <link href="<?php echo URL . ASSET_CSS; ?>font-awesome.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="<?php echo URL . ASSET_JS; ?>jquery.min.js"></script>
        <!----webfonts--->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
        <!---//webfonts--->
        <!-- Nav CSS -->
        <link href="<?php echo URL . ASSET_CSS; ?>custom.css" rel="stylesheet">
        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo URL . ASSET_JS; ?>jquery-min-2.0.2.js"></script>
        <script src="<?php echo URL . ASSET_JS; ?>metisMenu.min.js"></script>
        <script src="<?php echo URL . ASSET_JS; ?>custom.js"></script>
        <!-- Graph JavaScript -->
        <script src="<?php echo URL . ASSET_JS; ?>d3.v3.js"></script>
        <script src="<?php echo URL . ASSET_JS; ?>rickshaw.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-inverse navbar-static-top" role="navigation" id="nav-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo URL; ?>"><?php echo "AIMIM BANGALORE"; ?></a>
                </div>
            </nav>
            <div class="row" id="signin">
                <div class="col-lg-8 col-md-offset-2">
                    <h1 class="page-header text-default"><i class="fa fa-lock fa-x2 fa-fw"></i>&nbsp;SignIn</h1>
                </div>
                <div class="col-lg-8 col-md-offset-2">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please enter the credentials to SignIn</h3>
                        </div>
                        <div class="panel-body" id="signinform">
                            <form id="signform" autocomplete="off">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="User name" name="user_name" type="text" id="user_name" maxlength="100" required="" autofocus="" >
                                        <p class="help-block"  id="user_name_msg">Enter/ Select.</p>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" required=""  id="password" value="" maxlength="100" />
                                        <p class="help-block" id="pass_msg">Press enter or go button to SignIn.</p>
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-primary btn-block" href="javascript:void();"  id="sigininbut"><i class="fa fa-sign-in fa-fw fa-2x"></i> &nbsp;SignIn</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Welcome to <?php echo "AIMIM BANGALORE"; ?>
                        </div>
                        <div class="panel-body" id="output">
                        </div>
                    </div>
                </div>
            </div>

<?php include_once(DOC_ROOT . INC . "footer1.php"); ?>
