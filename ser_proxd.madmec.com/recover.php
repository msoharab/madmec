<?php
	define("MODULE_1","config.php");
	define("MODULE_2","database.php");
	require_once(MODULE_1);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		if( isset($_POST['action']) &&  $_POST['action'] == 'reset_pass'){
			ResetPass();
			unset($_POST);
			exit(0);
		}
		if( isset($_GET['r']) && isset($_GET['e']) ){
			unset($_SESSION['login_error']);
			$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
			if(get_resource_type($link) == 'mysql link'){
				if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					$res0 =  mysql_fetch_assoc( executeQuery("SELECT EXISTS(SELECT * FROM `admin` WHERE `reset_link` = '".mysql_real_escape_string($_GET['r'])."' ) AS test;") );
					if( $res0['test'] == 1){
						$_SESSION['r'] = $_GET['r'];
						$_SESSION['e'] = $_GET['e'];
					}
					else{
						unset($_SESSION);
						$_SESSION['login_error'] = '<h3 style="color:RED;">ERROR!!!</h3> Looks like your url validity has expried,Please try again.';
					}
					
				}
			}
			if(get_resource_type($link) == 'mysql link')
				mysql_close($link);
		}
		else{
			$_SESSION['login_error'] = '<h3 style="color:RED;">ERROR!!!</h3> Looks like your url validity has expried,Please try again..';
		}
	}
	function ResetPass(){
		$email = base64_decode($_SESSION['e']);
		$reset_link = $_SESSION['r'];
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "UPDATE `admin` SET 
				`reset_link` = NULL,
				`authentication` = NULL,
				`password` = '".mysql_real_escape_string(hash('sha256', $pass1, false))."'
				WHERE 
				`reset_link` = '".mysql_real_escape_string($reset_link)."'
				AND		
				`user_name` = '".mysql_real_escape_string($email)."'
				AND 
				`authentication` = '".mysql_real_escape_string('pending')."'
				";
				$res = executeQuery($query);
				if($res){
					echo '
					<div id="reform" align="center" style="display:none; top:0px;left:0px;position:absolute; height:100%; width:100%; background:rgba(0,0,0,0.7);z-index:10;">
							<div   style="height:auto; width:400px;position:relative; top:100px; padding:50px; background:#FFF;">
								<div id="reset_sc">
										<h3 style="color:GREEN;" class="form-signin-heading">successfully changed your password</h3>
										<a style="text-decoration:none;" href="'.URL.'">
										 <button class="btn btn-lg btn-danger btn-block load_box"> Login Now</button>
											
										</a> 
								</div>
							</div>
					</div>';
					/*<h3 style="color:GREEN;">	successfully changed your password </h3><br />
						<a href="'.URL.'">Login Now</a>'; */
				}
				
				else{
					echo 'Error!! please try again later';
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
	
	}
	main();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="MadMec-one" >
    <link rel="icon" href="../../favicon.ico">

    <title>Integrated accounts Software.</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo URL.ASSET_CSS; ?>bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo URL.ASSET_CSS; ?>signin.css" rel="stylesheet">
    <!-- CUSTOM STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>custom.css" rel="stylesheet" />
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="<?php echo URL.ASSET_JS; ?>ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo URL.ASSET_JS; ?>ie-emulation-modes-warning.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

    <script src="<?php echo URL.ASSET_JS; ?>ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo URL.PHP; ?>index.php">proX</a>
			</div>
			<div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;"> <?php echo date('d/m/Y');?></div>
        </nav>   
	</div>
    <div class="container">
		
		<div id="reset_scr">
			<?php
				if(isset($_SESSION['login_error'])){
					echo $_SESSION['login_error'];
				}
				else{
					echo '<form class="form-signin" >
						<h1 class="form-signin-heading">Enter Your New Password:</h1>
						<input value="'.base64_decode($_SESSION['e']).'" name="re_email" id="re_email" type="email" class="form-control" placeholder="Email address" readonly>
						<input id="pass1" name="password1" type="password" class="form-control" placeholder="Password" value="" >
						<input id="pass2"name="password2" type="password" onchange="javascript:pass_match();" class="form-control" placeholder="Confirm Password" value="">
						<span id="match" style="color:RED;display:none;">Paswword Mismatch</span>
						<br/>
						<br/>
						<button class="btn btn-lg btn-danger btn-block" type="button" onclick="javascript:reset_pass();">Done</button>
					</form>';
				}
			 ?>
		</div>
    </div> <!-- /container -->
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<!-- JQUERY SCRIPTS -->
    <script src="<?php echo URL.ASSET_JS; ?>jquery-1.10.2.js"></script>
	<script>
	function pass_match(){
		var pass1 = $("#pass1").val();
		var pass2 = $("#pass2").val();
		if(pass1 != pass2)
			$("#match").show();
		else
			$("#match").hide();
	}
	function reset_pass(){
		var pass1 = $("#pass1").val();
		var pass2 = $("#pass2").val();
		if(pass1 == pass2){
			var email = $("#re_email").val();
			var pass1 = $("#pass1").val();
			var pass2 = $("#pass2").val();
			$.ajax({
				url:window.location.href,
				type:'POST',
				data:{
					action:'reset_pass',
					'email':email,
					'pass1':pass1,
					'pass2':pass2
				},
				success:function(data){
					//alert(data);
					$('#reset_scr').html(data);
					$('#reform').show();
				},
				error:function(data){
					alert('ERROR.');
				}
			});
		}
		else{
			alert("password mismatch");
		}
	}
	</script>
  </body>
</html>
