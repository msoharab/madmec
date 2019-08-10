<?php
	define("MODULE_1","config.php");
	define("MODULE_2","database.php");
	require_once(MODULE_1);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		if(!ValidateAdmin()){
			session_destroy();
			header('Location:'.URL);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'send_sms'){
			$_SESSION['success'] = 0;
			$_SESSION['fails'] = 0;
			$flag = SendSms();
			if($flag){
				if($_SESSION['success'] > 0){
					echo "Your msg will be delivered in a short time \n 
					successfully sent = ".$_SESSION['success']."Messages \n
					Failed to send = ".$_SESSION['fails']."Messages
					";
				}
				else{
					echo "ERROR:Message not sent and record not saved in database.";
				}
			}
			else{
				echo "ERROR:Message not sent and record not saved in database.";
			}
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'msg_sent'){
			MsgSent();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'sms_sent'){
			SmsSent();
			unset($_POST);
			exit(0);
		}
	/*	elseif(isset($_POST['file']) ){
			upload_file();
			echo "am here";
			unset($_POST);
			exit(0);
		} */
	}
	function MsgSent(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT count(`sms`) as msg_sent FROM `sms_record` WHERE `status` = 'sent';";
				$res = executeQuery($query);
				if($res){
					$row = mysql_fetch_assoc($res);
					echo $row['msg_sent'];
				}
					
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function SmsSent(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT SUM(`sms`) as sms_sent FROM `sms_record` WHERE `status` = 'sent' AND `paid` = '0';";
				$res = executeQuery($query);
				if($res){
					$row = mysql_fetch_assoc($res);
					echo $row['sms_sent'];
				}
				
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	/*
	function upload_file(){
		$uploaddir = DOC_ROOT."uploads/";
		$uploadfile = $uploaddir . basename($_FILES['file']['name']);
		echo '<pre>';
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			echo "File is valid, and was successfully uploaded.\n";
		} else {
			echo "Possible file upload attack!\n";
		}

		echo 'Here is some more debugging info:';
		print_r($_FILES);

		print "</pre>";

	}
	*/
	function SendSms(){
		$flag = false;
		$sender_id = trim($_POST['sender_id']);
		$number = explode(',',preg_replace("/\r|\n/","",trim($_POST['number'])));
		$msg = preg_replace("/\r|\n/","",trim($_POST['msg']));
		if(strlen($msg) >> 0 && strlen($msg) <= 160)
			$msg_length = 1;
		elseif(strlen($msg) > 160 && strlen($msg) <= 320)
			$msg_length = 2;
		elseif(strlen($msg) > 320 && strlen($msg) <= 480)
			$msg_length = 3;
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				for($i=0; $i<sizeof($number) && !empty($number[$i]) && strlen($number[$i]) == 10;$i++){
					$restPara = array(
							"user" 					=> 'madmec',
							"password" 				=> 'madmec',
							"mobiles" 				=> $number[$i],
							"sms" 					=> $msg,
							"senderid" 				=> $sender_id,
							"version" 				=> 3,
							"accountusagetypeid"	=> 1
						);
                                        	$url = 'http://trans.profuseservices.com/sendsms.jsp?'.http_build_query($restPara);
					//	$response = file_get_contents($url);
					$ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL, $url);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        $response = curl_exec($ch);
                                        curl_close($ch);
                                        //return $output;
                                       // print_r($response);
                                        //exit(0);
						if( !preg_match('/error/',$response) ){
									$_SESSION['success']++;
									$query = "INSERT INTO `sms_record`
									( `number`,  `msg`,`sms`, `status`,`paid`,`date`) 
									VALUES 
									(
									'".mysql_real_escape_string($number[$i])."',
									'".mysql_real_escape_string($msg)."',
									'".mysql_real_escape_string($msg_length)."',
									'".mysql_real_escape_string('sent')."',
									'".mysql_real_escape_string('0')."',
									NOW()
									);";
									$res = executeQuery($query);
									if($res){
										$flag = true;
									}
						}
						else{
							$_SESSION['fails']++;
						}
					}//forloop
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		return $flag;	
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
    <meta name="author" content="">

    <title>SMS at once</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo URL.ASSET_CSS; ?>bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo URL.ASSET_CSS; ?>agency.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		#load_box{display:none;position:fixed;top: 50%;
			left: 50%;
			margin-top: -100px;
			margin-left: -200px;    width:400px;
			height:auto;
			background-color:#FFF;
			padding:10px;
			border:5px solid #CCC;
			z-index:200;
		}
	</style>
</head>

<body id="page-top" class="index">
	
 
  
    <section id="contact">
        <div class="container">
			<div align="right">
				 <a href="javascript:void(0);" onclick="window.location.href='<?php echo URL; ?>logout.php';" class="btn btn-danger square-btn-adjust">Logout</a>
			</div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">SMS at once</h2>
                    <h3 class="section-subheading text-muted">Welcome to easy SMS.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                      <div class="row">
                            <div class="col-md-5">
								<div class="form-group input-group">
									<span class="input-group-addon">
									<input type="radio" name="ph" id="ph" value="single">
									</span>
									<input type="tel" class="form-control" placeholder="Phone No*" id="phone" required data-validation-required-message="Please enter your phone number.">
                                    <p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="col-md-2" align="center">
								<h1>
								OR
								</h1>
							</div>
							<div class="col-md-5">
								<form action="file_upload.php" id="file_upload" method="POST"  enctype="multipart/form-data">
									<div class="btn-group btn-group-justified">
									  <div class="btn-group">
											<input name="file" id="file" type="file" class="btn btn-default btn-lg" placeholder=""  >
									</div>
									  <div class="btn-group">
										<button type="submit" class="btn btn-info btn-lg" >Upload File</button>
									  </div>
									</div>
								</form>
							</div>
							<div class="clearfix"></div>
                            <hr />
							
							<div class="col-md-4">
								&nbsp;
							</div>
							<div class="col-md-4">
								<select id="sender_id" class="form-control">
									<option value="MANDLI">MANDLI</option>
									<option value="WORACO">WORACO</option>
								</select>
							</div>
							<div class="col-md-4">
								&nbsp;
							</div>
							<div class="col-md-6">
								<div class="form-group">
                                   <label>Existing Files:</label>
								   <div class="form-group input-group">
										<span class="input-group-addon">
										<input type="radio" name="ph" id="ph" value="multiple">
										</span>
										<textarea id="mul_phone" class="form-control" readonly><?php echo file_get_contents(DOC_ROOT.'uploads/contacts.txt')?></textarea>
										<p class="help-block text-danger"></p>
									</div>
								</div>
							</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Message contents:</label>
									<textarea maxlength="480" onkeyup="count_length();" class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                   <strong class="help-block text-danger" id="count" style="background: none repeat scroll 0% 0% #FED136;float:right;"></strong>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button type="button" class="btn btn-xl" onclick="javascript:send_sms();">Send Message</button>
                            </div>
							<div class="clearfix"></div>
                            <hr />
							<div class="col-lg-12">
                                <strong class="help-block text-danger" id="count" style="color:#FED136; padding:0px 15px;">TOTAL MESSAGES SENT : <span id="msg_sent" style="color:#FFF;"></span></strong>
								<strong class="help-block text-danger" id="count" style="color:#FED136; padding:0px 15px;">TOTAL SMS COUNT : <span id="sms_sent" style="color:#FFF;"></span></strong>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
	<!-- load box -->
	<div id="load_box" >
		<center>
			<img class="img-circle" src="<?php echo URL.ASSET_IMG;?>loader.gif" border="0"/>
			<hr /> 
			<h2>Please wait...</h2>
			<h6 style="color:#D43F3A;">
				Warning: Do not close the browser till al the messages are sent.  
			</h6>
		</center>
	</div>
	<!-- jQuery -->
    <script src="<?php echo URL.ASSET_JS; ?>jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo URL.ASSET_JS; ?>bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <!--<script src="<?php echo URL.ASSET_JS; ?>classie.js"></script>-->
    <!--<script src="<?php echo URL.ASSET_JS; ?>cbpAnimatedHeader.js"></script>-->

    <!-- Contact Form JavaScript -->
 
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo URL.ASSET_JS; ?>agency.js"></script>
	<script>
	function count_length(){
		var file = $("#file").val();
		//alert(file);
		var msg = $("#message").val().length;
		$("#count").html(msg+'/480 max');
	}
		//to send sms
		function send_sms(){
			var number = ($("input[name='ph']:checked").val() == 'single' ) ? $("#phone").val() : $("#mul_phone").val();
			var msg = $("#message").val();
			var flag = confirm("are you sure you want to send sms?");
			var sender_id =  $("#sender_id").val();
			if(flag){
				$('#load_box').show();
				$.ajax({
					url:window.location.href,
					type:'POST',
					data:{action:'send_sms','sender_id':sender_id,'number':number,'msg':msg},
					success:function(data){
						alert(data);
						$('#load_box').hide();
					}
				});
			}
			else{
				//donothing for now
			}
		}
		//loading the total number of msges sent
		function msg_sent(){
			$.ajax({
				url:window.location.href,
				type:'POST',
				data:{action:'msg_sent'},
				success:function(data){
					//alert(data);
					$('#msg_sent').html(data);
				}
			});
		}
		//loading the total number of sms sent
		function sms_sent(){
			$.ajax({
				url:window.location.href,
				type:'POST',
				data:{action:'sms_sent'},
				success:function(data){
					//alert(data);
					$('#sms_sent').html(data);
				}
			});
		}
		$( document ).ready(function(){
			msg_sent();
			sms_sent();
		});
	</script>
</body>

</html>
