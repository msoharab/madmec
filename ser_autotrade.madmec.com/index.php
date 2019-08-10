<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
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
                returnRandomSourceEmail();
                switch ($parameters["action"]) {
                    case "updateTraffic":
                        updateTraffic();
                        break;
                    // case "checkExistence":
                    // echo checkExistence($parameters);
                    // break;
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    exit(0);
}

function updateTraffic() {
    setIPInfo();
    if(!isset($_SESSION["IP_INFO"]["status"]) && $_SESSION["IP_INFO"]["status"] != 'fail') {
	    $query = 'INSERT INTO `traffic` (`id`,
			`ip`,
			`host`,
			`city`,
			`zipcode`,
			`province`,
			`province_code`,
			`country`,
			`country_code`,
			`latitude`,
			`longitude`,
			`timezone`,
			`organization`,
			`isp`)  VALUES(
		NULL,
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["query"]) . '\',
		\'' . mysql_real_escape_string($_SERVER['SERVER_ADDR']) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["city"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["zip"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["regionName"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["region"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["country"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["countryCode"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["lat"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["lon"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["timezone"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["org"] . '♥♥♥' . $_SESSION["IP_INFO"]["as"] . '♥♥♥' . $_SESSION["IP_INFO"]["isp"]) . '\',
		\'' . mysql_real_escape_string($_SESSION["IP_INFO"]["isp"]) . '\');';
	    executeQuery($query);
    }
}

if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') {
    global $parameters;
    main($parameters);
}
require_once(DOC_ROOT . INC . 'header.php');
?>
<nav class="navbar navbar-inverse navbar-static-top" role="navigation" id="nav-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo URL; ?>"><?php echo SOFT_NAME; ?></a>
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
                <fieldset>
                    <div class="form-group">
                        <input class="form-control" placeholder="User name" name="user_name" type="text" id="user_name" maxlength="100" autofocus="" >
                        <p class="help-block"  id="user_name_msg">Enter/ Select.</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Password" name="password" type="password" id="password" value="" maxlength="100" />
                        <p class="help-block" id="pass_msg">Press enter or go button to SignIn.</p>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" href="javascript:void();"  id="sigininbut"><i class="fa fa-sign-in fa-fw fa-2x"></i> &nbsp;SignIn</button>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                Welcome to <?php echo SOFT_NAME; ?>
            </div>
            <div class="panel-body" id="output">
            </div>
        </div>
    </div>
</div>
<script src="<?php echo URL . ASSET_JSF; ?>index.js"></script>
<?php
require_once(DOC_ROOT . INC . 'footer.php');
?>