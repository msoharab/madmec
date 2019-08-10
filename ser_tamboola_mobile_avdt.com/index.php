<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false
);
unset($_POST);

function main($parameters) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
	    returnRandomSourceEmail();
            $flag = ValidateAdmin();
            if ($flag) {
                echo 'login';
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
}
require_once(DOC_ROOT . INC . 'res-header.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-default">Gym Hunt</h1>
    </div>
</div>
<div class="row" id="listgym">
    <div class="col-lg-8 col-md-offset-2">
        <h1 class="page-header text-default"><i class="fa fa-list fa-x2 fa-fw"></i>&nbsp;List of gyms</h1>
    </div>
    <div class="col-lg-8 col-md-offset-2">
        <div class="panel panel-red">
            <div class="panel-heading">
                <h3 class="panel-title">View details of gyms you like.</h3>
            </div>
            <div class="panel-body">
                
                <div id="displaylistofgyms"></div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="signin">
    <div class="col-lg-8 col-md-offset-2">
        <h1 class="page-header text-default"><i class="fa fa-lock fa-x2 fa-fw"></i>&nbsp;SignIn Club / Gym owners</h1>
    </div>
    <div class="col-lg-8 col-md-offset-2">
        <div class="panel panel-red">
            <div class="panel-heading">
                <h3 class="panel-title">Please enter the credentials to SignIn</h3>
            </div>
            <div class="panel-body" id="signinform">
                <fieldset>
                    <div class="form-group">
                        <input class="form-control" placeholder="E-mail" name="email" type="email" id="email" maxlength="100"/>
                        <p class="help-block"  id="email_msg">Press enter or go button to move to next field.</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Password" name="password" type="password" id="password" value="" maxlength="100" />
                        <p class="help-block" id="pass_msg">Press enter or go button to SignIn.</p>
                    </div>
                    <button class="btn btn-lg btn-danger btn-block" href="javascript:void(0);" id="sigininbut"><i class="fa fa-sign-in fa-fw fa-2x"></i> &nbsp;SignIn</button>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="row" id="signup">
    <div class="col-lg-8 col-md-offset-2">
        <h1 class="page-header text-default"><i class="fa fa-lock fa-x2 fa-fw"></i>&nbsp;SignUp Club / Gym owners</h1>
    </div>
    <div class="col-lg-8 col-md-offset-2" >
        <div class="panel panel-red">
            <div class="panel-heading">
                <h3 class="panel-title">Fill the blanks to SignUp</h3>
            </div>
            <div class="panel-body text-primary" id="signupform">
                <div class="row">
                    <div class="col-lg-12">
                        <strong class="text-danger"><span><i class="fa fa-star fa-fw"></i></span> User Name <i class="fa fa-caret-down fa-fw"></i></strong>
                    </div>
                    <div class="col-lg-12">
                        <input class="form-control" placeholder="User Name" name="user_name" type="text" id="user_name" maxlength="100"/>
                        <p class="help-block" id="name_msg">Press enter or go button to move to next field.</p>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <strong class="text-danger"><span><i class="fa fa-star fa-fw"></i></span> Email-id <i class="fa fa-caret-down fa-fw"></i></strong>
                    </div>
                    <div class="col-lg-12">
                        <input class="form-control" placeholder="E-mail" name="email" type="email" id="email_id" maxlength="100"/>
                        <p class="help-block" id="email_id_msg">Press enter or go button to move to next field.</p>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <strong class="text-danger"><span><i class="fa fa-star fa-fw"></i></span> Password <i class="fa fa-caret-down fa-fw"></i></strong>
                    </div>
                    <div class="col-lg-12">
                        <input class="form-control" placeholder="Password" name="password1" type="password" id="password1" maxlength="100"/>
                        <p class="help-block" id="pass1_msg">Press enter or go button to move to next field.</p>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <strong class="text-danger"><span><i class="fa fa-star fa-fw"></i></span> Retype Password <i class="fa fa-caret-down fa-fw"></i></strong>
                    </div>
                    <div class="col-lg-12">
                        <input class="form-control" placeholder="Password" name="password2" type="password" id="password2" maxlength="100"/>
                        <p class="help-block" id="pass2_msg">Press enter or go button SignUp.</p>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-lg btn-danger btn-block" href="javascript:void(0);" id="siginupbut"><i class="fa fa-sign-in fa-fw fa-2x"></i> &nbsp;SignUp</button>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-offset-2">
        <div class="panel panel-danger">
            <div class="panel-heading">
                Welcome to Tamboola
            </div>
            <div class="panel-body" id="output">
            </div>
        </div>
    </div>
</div>
<script src="<?php echo URL . ASSET_JSF; ?>index.js"></script>
</div>
<?php
require_once(DOC_ROOT . INC . 'res-footer.php');
?>
