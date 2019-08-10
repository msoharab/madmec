<?php
	define("MODULE_1","config.php");
	define("MODULE_2","database.php");
	require_once(MODULE_1);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		if(ValidateAdmin()){
                        $usertype=  isset($_SESSION['USERTYPE']) ? $_SESSION['USERTYPE'] : false;
                        if($usertype=="admin")
			header('Location:'.URL.PHP.'index.php');
                        else if($usertype=="master")
                         header('Location:'.URL.MASTER_MODULE.'control.php');
			exit(0);
		}
		elseif(isset($_POST['email']) && isset($_POST['pass']) ){
			if(AdminLogin($_POST['email'],$_POST['pass']) == 'success'){
                            $usertype=  isset($_SESSION['USERTYPE']) ? $_SESSION['USERTYPE'] : false;
				if($usertype=="admin")
                                    header('Location:'.URL.PHP.'index.php');
                                    else if($usertype=="master")
                                   header('Location:'.URL.MASTER_MODULE.'control.php');
				exit(0);
			}
                        else if(AdminLogin(isset($_POST['email']) ? $_POST['email'] : false,isset($_POST['pass']) ? $_POST['pass'] : false) == 'expired'){

				$_SESSION['login_expired'] = '<div class="col-md-4 col-sm-4">&nbsp;</div>
					<div class="col-md-4 col-sm-4">
						<div class="panel panel-warning">
							<div class="panel-heading">
								Error!!!
							</div>
							<div class="panel-body">
								<p class="text-info"><strong>Your Validity has been Expired Kindly Activate your Service or Conact to your Service Provider</strong></p>
							</div>
						</div>
					</div>
					<div class="col-md-8 col-sm-4">&nbsp;</div><div class="col-md-12">&nbsp;</div>';
                        }
			else{
				$_SESSION['login_error'] = '<div class="col-md-4 col-sm-4">&nbsp;</div>
					<div class="col-md-4 col-sm-4">
						<div class="panel panel-danger">
							<div class="panel-heading">
								Error!!!
							</div>
							<div class="panel-body">
								<p>please enter correct login id and password!!!</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">&nbsp;</div>';
			}
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'reset_now' ){
			ResetNow($_POST['email']);
			unset($_POST);
			exit(0);
		}
	}
	function AdminLogin($u=false,$p=false){
//		$p = hash('sha256', $p, false);
		$flag = false;
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_MASTER,$link)) == 1){
				$query = 'SELECT up.*,
                                            CASE WHEN  up.`user_type_id`=10
                                            THEN 10
                                            ELSE
                                            DATEDIFF(v.expiry_date,CURRENT_DATE)  END AS expiry_date
                                            FROM `user_profile` up
                                            LEFT JOIN `validity` v
                                            ON v.`user_pk`=up.`id`
                                            WHERE
                                            up.`user_name`=\''.mysql_real_escape_string($u).'\'
                                            AND
                                            up.`password`=\''.mysql_real_escape_string($p).'\' ;';
                            $res = executeQuery($query);
				if(get_resource_type($res) == 'mysql result'){
					if(mysql_num_rows($res) > 0){
						$row = mysql_fetch_assoc($res);
						if( $row['user_name'] == $u && $row['password'] == $p ){
                                                    if($row['expiry_date'] < 0)
                                                        {
                                                            $flag="expired";
                                                            return $flag;
                                                            exit(0);
                                                        }
							$_SESSION['ADMIN_NAME'] = $u;
							$_SESSION['ADMIN_PASS'] = $p;
							$_SESSION['ADMIN_ID'] = $row['id'];
							$_SESSION['CLINIC'] =  ($row['business_name'])? $row['business_name']: "Administrator";
                                                        if($row['user_type_id']=="9")
                                                        {
                                                            $_SESSION['USERTYPE']="admin";
                                                            $_SESSION['SLAVEBD']=$row['db_name'];
                                                        }
                                                        else if($row['user_type_id']=="10")
                                                        {
                                                           $_SESSION['USERTYPE']="master" ;
                                                           $_SESSION['SLAVEBD']=NULL;
                                                        }
							$flag = 'success';
//                                                        update_admin_log();
						}
						else if($row['user_name']== $u && $row['password'] != $p){
							$_SESSION['ADMIN_NAME'] = $u;
							$_SESSION['ADMIN_PASS'] = NULL;
                                                        $_SESSION['SLAVEBD']=NULL;
							$flag = 'password';
						}
						else{
							$_SESSION['ADMIN_NAME'] = NULL;
							$_SESSION['ADMIN_NAME'] = NULL;
                                                        $_SESSION['SLAVEBD']=NULL;
							$flag = false;
						}
					}
					else{
						$_SESSION['ADMIN_NAME'] = NULL;
						$_SESSION['ADMIN_PASS'] = NULL;
						$flag = false;
					}
				}
			}
		}
		unset($_POST);
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		return $flag;
	}
	/* locate.php code */
	function update_admin_log(){
		$browser = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']);
		$ip = get_client_ip();
		if($ip == '')
			$ip = '127.0.0.1';
		$ip_data = get_ip_info($ip);
		if(!$ip_data){
                    	$ip_data['host'] = 'localhost';
			$ip_data['country'] = '';
			$ip_data['country_code'] = '';
			$ip_data['continent'] = '';
			$ip_data['region'] = '';
			$ip_data['latitude'] = '';
			$ip_data['longitude'] = '';
			$ip_data['organization'] = '';
			$ip_data['isp'] = '';
		}
		if($ip_data)
		{
			//Database flags
			executeQuery("INSERT INTO `admin_logs`(
			`id`,
			`ip`,
			`host`,
			`country`,
			`country_code`,
			`continent`,
			`region`,
			`latitude`,
			`longitude`,
			`organization`,
			`isp`,
			`browser`,
			`admin_id`,
			`in_time`,
			`out_time`)
			 VALUES (NULL,
			'".$ip."',
			'".$ip_data['host']."',
			'".$ip_data['country']."',
			'".$ip_data['country_code']."',
			'".$ip_data['continent']."',
			'".$ip_data['region']."',
			'".$ip_data['latitude']."',
			'".$ip_data['longitude']."',
			'".$ip_data['organization']."',
			'".$ip_data['isp']."',
			'".$browser."',
			'".$_SESSION['ADMIN_ID']."',
			NOW(),
			NULL);");
		}
	}
	function get_client_ip(){
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else if(isset($_SERVER['REMOTE_HOST']))
			$ipaddress = $_SERVER['REMOTE_HOST'];
		else
			$ipaddress = NULL;
		return $ipaddress;
	}
	function get_ip_info($ip = NULL){
		if(empty($ip) && $ip != '127.0.0.1')
			return false;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.ipaddresslocation.org/ip-address-locator.php?lookup='.$ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('ip' => $ip));
		$data = curl_exec($ch);
		curl_close($ch);
		preg_match_all('/<i>([a-z\s]+)\:<\/i>\s+<b>(.*)<\/b>/im', $data, $matches, PREG_SET_ORDER);
		if(count($matches) == 0)
			return false;
		$return = array();
		$format_labels = array(
			'Hostname'          => 'host',
			'IP Country'        => 'country',
			'IP Country Code'   => 'country_code',
			'IP Continent'      => 'continent',
			'IP Region'         => 'region',
			'IP Latitude'       => 'latitude',
			'IP Longitude'      => 'longitude',
			'Organization'      => 'organization',
			'ISP Provider'      => 'isp'
		);
		foreach($matches as $info)
		{
			if(isset($info[2]) && !is_null($format_labels[$info[1]]))
			{
				$return[$format_labels[$info[1]]] = $info[2];
			}
		}
       return (count($return)) ? $return : false;
    }
	/* locate.php code ends*/
	function ResetNow($email){

		$reset_link = ResetLink($email);
		if( $reset_link )
		{
			$reset_url = URL.'recover.php?r='.$reset_link.'&e='.base64_encode($email);
			SendEmail($reset_url,$email);
			echo '<h3 style="color:GREEN;">Please Check your email Id to Reset Password</h3>';
		}
		else{
			echo '<h3 style="color:RED;">The email Id you have entered is not a user please try with different Email ID</h3>';
		}
	}
	function SendEmail($reset_link,$email){
		$flag = false;
		$mail = '';
		set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
		require_once(LIB_ROOT.MODULE_ZEND_1);
		require_once(LIB_ROOT.MODULE_ZEND_2);
		$config = array('auth' => 'login',
					'port' => MAILPORT,
					'username' => MAILUSER,
					'password' => MAILPASS);
			$message = 'Hi, <br />
						To reset your password please click the link below
						<br />
						<br />
						<a href="'.$reset_link.'">Reset Link</a>';
				$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
				if($transport){
					$mail = new Zend_Mail();
					if($mail){
						$mail->setBodyHtml($message);
						$mail->setFrom(MAILUSER, ALTEMAIL);
						$mail->addTo($email, 'Dear User');
						$mail->setSubject(ORGNAME.' password reset link.');
						$flag = true;
					}
				}
				if($flag){
					try{
						$mail->send($transport);
						unset($mail);
						unset($transport);
						$flag = true;
					}
					catch(exceptoin $e){
						echo 'Invalid email id :- '.$email.'<br />';
						$flag = false;
					}
				}
				return $flag;
	}
	function ResetLink($email){
		$reset_link = false;
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$res0 =  mysql_fetch_assoc( executeQuery("SELECT EXISTS(SELECT * FROM `admin` WHERE `user_name` = '".mysql_real_escape_string($email)."' ) AS test;") );
				if( $res0['test'] == 1){
					$reset_link = base64_encode($email.rand(0,9999));
					$query = "UPDATE `admin` SET
							`reset_link` = '".mysql_real_escape_string($reset_link)."',
							`authentication` = '".mysql_real_escape_string('pending')."'
							WHERE
							`user_name` = '".mysql_real_escape_string($email)."'
							;";
					$res = executeQuery($query);
				}
				else{
					//since the row does not exist returning false//
					$reset_link = false;
				}
			}
		}
		unset($_POST);
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		return $reset_link;
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
    <link href="<?php echo URL.ASSET_CSS; ?>font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo URL.ASSET_CSS; ?>signin.css" rel="stylesheet">
    <!-- CUSTOM STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>custom.css" rel="stylesheet" />
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="<?php echo URL.ASSET_JS; ?>ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo URL.ASSET_JS; ?>ie-emulation-modes-warning.js"></script>
	<script src="<?php echo URL.ASSET_JS; ?>config.js"></script>


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

		<div>
			<?php if(isset($_SESSION['login_error'])){echo $_SESSION['login_error'];unset($_SESSION['login_error']);} ?>
                    <?php if(isset($_SESSION['login_expired'])){echo $_SESSION['login_expired'];unset($_SESSION['login_expired']);} ?>
		</div>
		<form class="form-signin" role="form" method="POST">
			<h1 class="form-signin-heading">Please sign in</h1>
                        <input name="email" type="text" class="form-control" placeholder="Email address" required autofocus>
			<input name="pass" type="password" class="form-control" placeholder="Password" required>
			<label class="checkbox">
			  <input type="checkbox" value="remember-me"> Remember me
			</label>
                        <button class="btn btn-lg btn-danger  btn-block" type="submit"><i class="fa fa-sign-in"></i>&nbsp;Sign in</button>
			<br />
			<a href="javascript:void(0);" onclick="javascript:show_reset_form();">Reset Password/Forgot Password</a>
		</form>

    </div> <!-- /container -->
	<div id="reset_form" align="center" style="display:none; top:0px;left:0px;position:absolute; height:100%; width:100%; background:rgba(0,0,0,0.7);z-index:10;">
		<div   style="height:auto; width:400px;position:relative; top:100px; padding:50px; background:#FFF;">
			<div align="right">
				<a href="javascript:void(0);" onclick="javascript:close_reset_form();">Close</a>
			</div>
			<div id="reset_src">
				<form>
					<h3 class="form-signin-heading">Please enter the email to reset the password:</h1>
					<input name="re_email" id="re_email" type="email" class="form-control" placeholder="Email address" required>
					<br />
					<button class="btn btn-lg btn-danger btn-block " id="reset" type="button" onclick="javascript:reset_now();">Reset Now</button>
				</form>
				<div id="set"></div>
			</div>
		</div>
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<!-- JQUERY SCRIPTS -->
   <script src="<?php echo URL.ASSET_JS; ?>jquery-1.10.2.js"></script>
	<script>
		function close_reset_form(){
			$("#reset_form").hide();
			$('#reset_src').html('<form>'+
					'<h3 class="form-signin-heading">Please enter the email to reset the password:</h1>'+
					'<input name="re_email" id="re_email" type="email" class="form-control" placeholder="Email address" required>'+
					'<br />'+
					'<button class="btn btn-lg btn-danger btn-block" id="reset" type="button" onclick="javascript:reset_now();">Reset Now</button>'+
				'</form>'+
				'<div id="set"></div>');

		}
		function show_reset_form(){

			$("#reset_form").show();

		}




 function reset_now(){
		//$(document).ajaxStart(function() {
			$('#set').html(IMG_LOADER2);

			//	})
				$('#reset').attr('disabled','disabled');
				var email = $("#re_email").val();
				$.ajax({
					url:window.location.href,
					type:'POST',
					data:{action:'reset_now','email':email},
					success:function(data){
						$('#set').html(IMG_LOADER2).hide();
					$('#reset_src').html(data);

						/*$('#reset_src').html('<div style="height:auto; width:400px;position:relative; top:100px; padding:50px; background:#FFF;"><div align="right"><a href="javascript:void(0);" onclick="javascript:close_reset_form();">Close</a>'+
												'</div>'+
												'<div id="reset_src">'+
												'<form>'+
												'<h3 class="form-signin-heading">Please enter the email to reset the password:</h1>'+
												'<input name="re_email" id="re_email" type="email" class="form-control" placeholder="Email address" required>'+
													'<br />'+
												'<button class="btn btn-lg btn-danger btn-block " id="reset" type="button" onclick="javascript:reset_now();">Reset Now</button>'+
												'</form>'+
												'<div id="set"></div>'+
												'</div>'+
												'</div>'); */
					//$('#set').html(IMG_LOADER2).hide();

				},
					error:function(data){
					alert("ERROR!!!");
				}
			});
			/*$(document).ajaxComplete(function() {
				$('#set').html(IMG_LOADER2).hide();

				}); */
				return false;
		}

	</script>
  </body>
</html>
