<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	function main(){
		returnRandomSourceEmail();
		if(isset($_POST['action']) &&  $_POST['action'] == 'sendEmail'){
			$mailParameters = array(
				"server" => 1,
				"to" => $_POST['tagetemails'],
				"name" => "MadMec",
				"message" => $_POST['message'],
				"subject" => $_POST['subject'],
				"target_host" => ""
			);
			Alert($mailParameters);
			unset($_POST);
			exit(0);
		}
	}
	function SendMsg($msg_to,$msg_sub,$msg_content){
		$query = "";
		$email = '';
		$password = '';
		$config = array();
		$transport = '';
		$mail = '';
		$qut = 0;
		$rem = 0;
		$name = 'User';
		$to = '';
		$total = sizeof($msg_to);
		$m = 0;
		// echo '<p>'.print_r($msg_to).'</p>';
		if($total > 0){
			$i=1;
			set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
			require_once(LIB_ROOT.MODULE_ZEND_1);
			require_once(LIB_ROOT.MODULE_ZEND_2);
			if($total > 30){
				$qut = floor($total / 30);
				$rem = $total % 30;
				for(;$i<=$qut;$i++){
					$mailParameters = array(
						"server" => 1,
						"to" => $msg_to[$i],
						"name" => "MadMec",
						"message" => $msg_content,
						"subject" => $msg_sub,
						"target_host" => ""
					);
					Alert($mailParameters);
					// if(isset($_SESSION['BIGROCKMAILS'])){
						// $index = mt_rand(1,sizeof($_SESSION['BIGROCKMAILS']));
						// $email = $_SESSION['BIGROCKMAILS'][$index]['email'];
						// $password = $_SESSION['BIGROCKMAILS'][$index]['password'];
					// }
					// else{
						// $email = MAILUSER;
						// $password = MAILPASS;
					// }
					// echo "<p>Selected source email :- $email</p>";
					// echo "<p>Selected source pass  :- $password</p>";
					// $config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
					// $transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
					// $mail = new Zend_Mail();
					// $mail->setBodyHtml($msg_content);
					// $mail->setFrom($email, "MadMec");
					// $mail->setSubject($msg_sub);
					// for($j=1;$j<=30 && $m <= $total;$j++){
						// if(isset($msg_to[$m]) && $msg_to[$m] != '' && validateEmail($msg_to[$m])){
							// $mail->addTo($msg_to[$m], $name);
							// $to .= '<br /> '.$m.' - '.$msg_to[$m];
						// }
						// $m++;
					// }
					// try{
						// $mail->send($transport);
						// echo $to." -- ".date("d/m/Y, G:i:s")." => Email has been sent.<br />";
					// }
					// catch(exceptoin $e){
						// echo $to." -- ".date("d/m/Y, G:i:s")." => Email could not be sent.<br />";;
					// }
					// unset($mail);
					// unset($transport);
					sleep(360);
				}
				if($rem > 0){
					// $to = '';
					// $remaining = $total - ($qut * 30);
					// if(isset($_SESSION['BIGROCKMAILS'])){
						// $index = mt_rand(1,sizeof($_SESSION['BIGROCKMAILS']));
						// $email = $_SESSION['BIGROCKMAILS'][$index]['email'];
						// $password = $_SESSION['BIGROCKMAILS'][$index]['password'];
					// }
					// else{
						// $email = MAILUSER;
						// $password = MAILPASS;
					// }
					// $config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
					// $transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
					// $mail = new Zend_Mail();
					// $mail->setBodyHtml($msg_content);
					// $mail->setFrom($email, "MadMec");
					// $mail->setSubject($msg_sub);
					// for($j=1;$j<=$remaining && $m <= $total;$j++){
					for($j=1;$j<=$remaining;$j++){
						$mailParameters = array(
							"server" => 1,
							"to" => $msg_to[$j],
							"name" => "MadMec",
							"message" => $msg_content,
							"subject" => $msg_sub,
							"target_host" => ""
						);
						Alert($mailParameters);
						sleep(360);
						// if(isset($msg_to[$m]) && $msg_to[$m] != '' && validateEmail($msg_to[$m])){
							// $mail->addTo($msg_to[$m], $name);
							// $to .= '<br /> '.$m.' - '.$msg_to[$m];
						// }
						// $m++;
					}
					// try{
						// $mail->send($transport);
						// echo $to." -- ".date("d/m/Y, G:i:s")." => Email has been sent.<br />";
					// }
					// catch(exceptoin $e){
						// echo $to." -- ".date("d/m/Y, G:i:s")." => Email could not be sent.<br />";;
					// }
					// unset($mail);
					// unset($transport);
				}
			}
			else if($total < 31 && $total > 0){
				// $to = '';
				// if(isset($_SESSION['BIGROCKMAILS'])){
					// $index = mt_rand(1,sizeof($_SESSION['BIGROCKMAILS']));
					// $email = $_SESSION['BIGROCKMAILS'][$index]['email'];
					// $password = $_SESSION['BIGROCKMAILS'][$index]['password'];
				// }
				// else{
					// $email = MAILUSER;
					// $password = MAILPASS;
				// }
				// $config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
				// $transport = new Zend_Mail_Transport_Smtp(MAILH	OST, $config);
				// $mail = new Zend_Mail();
				// $mail->setBodyHtml($msg_content);
				// $mail->setFrom($email, "MadMec");
				// $mail->setSubject($msg_sub);
				// for($j=1;$j<=$total && $m < $total;$j++){
				for($j=1;$j<=$total;$j++){
					$mailParameters = array(
						"server" => 1,
						"to" => $msg_to[$j],
						"name" => "MadMec",
						"message" => $msg_content,
						"subject" => $msg_sub,
						"target_host" => ""
					);
					Alert($mailParameters);
					sleep(360);
					// if(isset($msg_to[$m]) && $msg_to[$m] != '' && validateEmail($msg_to[$m])){
						// $mail->addTo($msg_to[$m], $name);
						// $to .= '<br /> '.$m.' - '.$msg_to[$m];
					// }
					// $m++;
				}
				// try{
					// $mail->send($transport);
					// echo $to." -- ".date("d/m/Y, G:i:s")." => Email has been sent.<br />";
				// }
				// catch(exceptoin $e){
					// echo $to." -- ".date("d/m/Y, G:i:s")." => Email could not be sent.<br />";;
				// }
				// unset($mail);
				// unset($transport);
			}
		}
		else{
			echo 'No recipient is selected.';
		}
	}
	if(isset($_POST['autoloader']) && $_POST['autoloader'] == 'true')
		main();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Bulk Eamil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="js/jquery.js"  language="javascript" type="text/javascript"></script>
<script  src="js/institute.js" language="javascript" type="text/javascript"></script>
</head>
<body bgcolor="#999999">
<form name="form1">
<table border="1" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>
      <h3>Institute Marketing</h3></strong></td>
    </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><a href="index.php">Home</a></td>
    </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>To</strong></td>
    <td bgcolor="#CCCCCC"><textarea name="tagetemails" cols="100" rows="10" id="tagetemails"></textarea></td>
    </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>Subject</strong></td>
    <td bgcolor="#CCCCCC"><input name="subject" type="text" id="subject" size="100"></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>Message</strong></td>
    <td bgcolor="#CCCCCC"><textarea name="message" id="message" cols="100" rows="10"></textarea></td>
    </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><input type="button" name="submit" id="submit" value="Submit"></td>
  </tr>
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC">
		<div id="Televeision">
		</div>
	</td>
  </tr>
</table>
</form>
<div id="script">
</div>
</body>
</html>
</html>