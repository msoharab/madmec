<?php
	define("MODULE_0","config.php");
	define("MODULE_1","database.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	$parameters = array(
		"autoloader" 	=> isset($_POST["autoloader"]) 		? $_POST["autoloader"] 		: false,
		"action" 	 	=> isset($_POST["action"]) 			? $_POST["action"]			: false
	);
	unset($_POST);
	function main($parameters){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$flag = ValidateAdmin();
				if($flag){
					echo 'login';
				}
			}
		}
		if(get_resource_type($link) == 'mysql link'){
			mysql_close($link);
			exit(0);
		}
	}
	if(isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true'){
		global $parameters;
		main($parameters);
	}
	require_once(DOC_ROOT.INC.'res-header.php');
?>

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
						<input class="form-control" placeholder="User name" name="user_name" type="email" id="user_name" maxlength="100" required />
						<p class="help-block"  id="user_name_msg">Press enter or go button to move to next field.</p>
					</div>
					<div class="form-group">
						<input class="form-control" placeholder="Password" name="password" type="password" id="password" value="" maxlength="100" />
						<p class="help-block" id="pass_msg">Press enter or go button to SignIn.</p>
					</div>
					<button class="btn btn-lg btn-primary btn-block" href="javascript:void(0);" id="sigininbut"><i class="fa fa-sign-in fa-fw fa-2x"></i> &nbsp;SignIn</button>
				</fieldset>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-8 col-md-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				Welcome to <?php echo GYMNAME; ?>
			</div>
			<div class="panel-body" id="output">
			</div>
		</div>
	</div>
</div>
<script src="<?php echo URL.ASSET_JSF; ?>index.js"></script>
</div>
<?php
   require_once(DOC_ROOT.INC.'res-footer.php');
?>
