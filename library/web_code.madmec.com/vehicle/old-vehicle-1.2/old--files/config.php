<?php
	session_start();
	//error_reporting(0);
	date_default_timezone_set('Asia/Kolkata');
	/* Database constraints */
	define("DBHOST","localhost");
	define("DBUSER","root");
	//define("DBPASS","9743967575");
	define("DBPASS","madmec@418133");
	//define("DBNAME_ZERO","shifteazy");
	
	/* App constraints */
	$temp = explode("/",rtrim($_SERVER['DOCUMENT_ROOT'],"/"));
	$doc_path = $_SERVER['DOCUMENT_ROOT']."/";
	$libroot = str_replace($temp[count($temp)-1],"library",$_SERVER['DOCUMENT_ROOT'])."/";
	define("DOC_ROOT",$doc_path);
	define("LIB_ROOT",$libroot);
	define("MAILHOST","208.91.199.224");
	define("MAILPORT",587);
	define("IMG_CONST",400);
	define("MAILUSER","gift10@madmec.com");
	define("MAILPASS","splasher777@");
	define("MODULE_ZEND_1","Zend/Mail.php");
	define("MODULE_ZEND_2","Zend/Mail/Transport/Smtp.php");
	define("URL","http://code.localmm.com/");
	// define("URL","http://code.madmec.com/");
	define("INC","inc/");
	define("DOWNLOADS","downloads/");
	define("ASSET_DIR","assets/");
	define("ASSET_JSF","assets/js/");
	define("ASSET_MN","main/");
	define("ASSET_JS_USER","a.user/");
	define("ASSET_JS_TRAINER","a.trainer/");
	define("ASSET_JS_MANAGE","a.manage/");
	define("ASSET_JS_REPORT","a.reports/");
	define("ASSET_JS_STATS","a.stats/");
	define("ASSET_JS_ACCOUNTS","a.accounts/");
	define("ASSET_CSS","assets/css/");
	define("ASSET_IMG","assets/images/");
	define("ICON_THEME","set1/");
	define("ICON_THEME2","set2/");
	define("ADMIN","Admin/");
	define("USER","User/");
	define("TRAINER","Trainer/");
	define("GYMNAME","The_Fitness_Studioo");
	/* XLS FILE CONSTANT */
	define('EXCEL_NAME',		"NAME");
	define('EXCEL_GENDER',    	"GENDER");
	define('EXCEL_DOB',    		"DOB");
	define('EXCEL_MOBILE',     	"MOBILE");
	define('EXCEL_EMAIL',     	"EMAIL");
	define('EXCEL_OCCUPATION', 	"OCCUPATION");
	define('EXCEL_ACCESS_ID', 	"ACS ID");
	define('EXCEL_TRAINERGYM', 	"GYM");
	define('EXCEL_TRAINERAER', 	"AEROBICS");
	define('EXCEL_TRAINERDAN', 	"DANCE");
	define('EXCEL_TRAINERYOG', 	"YOGA");
	define('EXCEL_TRAINERZUM', 	"ZUMBA");
	/* Customer constraints */
	define("USER_ANON_IMAGE",URL.ASSET_IMG.ICON_THEME."anonymous.png");
	/* Admin constraints */
	define("ADMIN_ANON_IMAGE",URL.ASSET_IMG.ICON_THEME."administrator.png");
	/* Trainer constraints */
	define("TRAIN_ANON_IMAGE",URL.ASSET_IMG.ICON_THEME."trainer.png");
	/* specific to shifteazy.com */
	function Alert($email,$name,$reloc_serial=false){
		$flag = false;
		$mail = '';
		set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
		require_once(LIB_ROOT.MODULE_ZEND_1);
		require_once(LIB_ROOT.MODULE_ZEND_2);
		$config = array('auth' => 'login',
					'port' => MAILPORT,
					'username' => MAILUSER,
					'password' => MAILPASS);
	
			$message = "Hi ".$name.",".
									"<br />Thank you for Requesting a quote with us. <br /><br />".
									"Your Quote reference:<strong>".$reloc_serial."</strong><br/>
					We will contact you as soon as possible with your quote!
					<br /><br />Regards, <br /> Team MadMec";
				$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
				if($transport){
					$mail = new Zend_Mail();
					if($mail){
						$mail->setBodyHtml($message);
						$mail->setFrom(MAILUSER, "ShiftEazy");
						$mail->addTo($email, $name);
						$mail->setSubject( "ShiftEazy Quotes request confirmation");
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
	function Admin_Alert($email=false,$name,$reloc_serial=false,$mobile=false){
		$flag = false;
		$mail = '';
		set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
		require_once(LIB_ROOT.MODULE_ZEND_1);
		require_once(LIB_ROOT.MODULE_ZEND_2);
		$config = array('auth' => 'login',
					'port' => MAILPORT,
					'username' => MAILUSER,
					'password' => MAILPASS);
			$toemail = 'shifteazyinfo@gmail.com';
			//$toemail = 'nass0069@gmail.com';
			if($email){
				$message = "Hi Admin,".
										"<br />".$name." has Requested a quote with us. <br /><br />".
										"with Quote reference:<strong>".$reloc_serial."</strong><br/>
										email of customer:".$email."<br />
										Mobile number : ".$mobile."<br /><br />
						Regards, <br /> Team MadMec";
			}
			else{
			$message = "Hi Admin,".
										"<br />".$name." has Requested a <span style='color:#c00;'>CALL BACK</span>. <br /><br />
										Mobile number : <strong>".$mobile."</strong><br /><br />
						Regards, <br /> Team MadMec";
			
			}
				$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
				if($transport){
					$mail = new Zend_Mail();
					if($mail){
						$mail->setBodyHtml($message);
						$mail->setFrom(MAILUSER, "ShiftEazy");
						$mail->addTo($toemail, $name);
						$mail->setSubject("ShiftEazy Quotes request confirmation");
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
	function escape_data($data){
		$link = mysql_connect(DBHOST,DBUSER,DBPASS);
		if($link){
			if(function_exists('mysql_real_escape_string')){
				$data = mysql_real_escape_string(trim($data));
				$data = strip_tags($data);
			}
			else{
				$data = mysql_escape_string(trim($data));
				$data = strip_tags($data);
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		return $data;
	}
	
?>
