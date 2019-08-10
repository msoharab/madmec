<?php
	session_start();
	error_reporting(0);
	date_default_timezone_set('Asia/Kolkata');
	//include_once('mysql2i.class.php');
	/* Database constraints */
	define("DBHOST","localhost");
	define("DBUSER","root");
	//define("DBPASS","9743967575");
	define("DBPASS","madmec@418133");
		/* fields to be changed before updatin on server */

		//define("URL","http://local.proj_manage_aimim.com/");
		define("URL","http://aimim-members.in/");
		define("ORGNAME","AIMIM");
        define("DBNAME_ZERO","manage_aimim");


		//sending emails
		define("MAILHOST","smtp.madmec.com");
		define("MAILPORT",587);
		define("MAILUSER","prox@madmec.com");
		define("MAILPASS","nopassword777@");
		define("ALTEMAIL","MadMec");
		//define("SEND_EMAIL","on");
		define("SEND_EMAIL","off");
		//    define("SMS","on");
		define("SMS","off");


	$temp = explode("/",rtrim($_SERVER['DOCUMENT_ROOT'],"/"));
	$doc_path = $_SERVER['DOCUMENT_ROOT']."/";
	$libroot = str_replace($temp[count($temp)-1],"library",$_SERVER['DOCUMENT_ROOT'])."/";
	define("DOC_ROOT",$doc_path);
	define("LIB_ROOT",$libroot);
	define("PHP","php/");
	define("IMG_CONST",400);
	define("MODULE_ZEND_1","Zend/Mail.php");
	define("MODULE_ZEND_2","Zend/Mail/Transport/Smtp.php");
	define("INC","inc/");
	define("ADMIN","admin/");
	define("USER","user/");
        define("PLUGINS","plugins/");
        define("DATATABLES","dataTables/");

	define("TRAINER","trainer/");
	define("DOWNLOADS","downloads/");
	//define("PHP","php/");
	define("UPLOADS","uploads/");
	define("ASSET_DIR","assets/");
	define("ASSET_JS","assets/js/");
	define("MAIN_JS","main/js/");
	define("TREATMENT_IMAGE","main/res/treatment_image/");
	define("PROFILE_IMAGE","main/res/profile/");
	define("ASSET_JS_USER","a.user/");
	define("ASSET_JS_TRAINER","a.trainer/");
	define("ASSET_JS_MANAGE","a.manage/");
	define("ASSET_JS_REPORT","a.reports/");
	define("ASSET_JS_STATS","a.stats/");
	define("ASSET_JS_ACCOUNTS","a.accounts/");
	define("ASSET_CSS","assets/css/");
	define("ASSET_IMG","assets/img/");
	define("PROFILE_IMG",URL.ASSET_IMG."find_user.png");
	define("IMG_LOADER","assets/img/loading-bar.gif");
	define("ASSET_VOU","main/res/vouchers/");
	define("ASSET_REC","main/res/receipts/");
	define("REG_FEE","500");
	define("START_DATE","2014-02-03");
	define("ST_PER",0.1236);
	define("CELL_CODE","+91");
	define("CURRENCY_SYM_1X","<i class='fa fa-inr'></i>");
	define("CURRENCY_SYM_2X","<i class='fa fa-inr fa-2x'></i>");
	define("CURRENCY_SYM_3X","<i class='fa fa-inr fa-3x'></i>");
	define("CURRENCY_SYM_4X","<i class='fa fa-inr fa-4x'></i>");
	define("CURRENCY_SYM_5X","<i class='fa fa-inr fa-5x'></i>");
	define("GYM_LOGO",URL.ASSET_IMG."short-logo.jpg");
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
	/* Specific to dental */
	define('DENTAL','dental/');
	define('DATATABLE','dataTables/');
	$bootstrapProperties = array(
		"pageheader_color" => "text-primary",
		"panel_color" => ""
	);
	function generateRandomString($length = 6){
		// $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$randomString = '';
		for ($i = 0; $i < $length; $i++){
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		if(strlen($randomString) > 5)
			return $randomString;
		else
			generateRandomString();
	}
	function Alert($email,$name,$subject,$recp=false){
		$flag = false;
		$mail = '';
		set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
		require_once(LIB_ROOT.MODULE_ZEND_1);
		require_once(LIB_ROOT.MODULE_ZEND_2);
		$config = array('auth' => 'login',
					'port' => MAILPORT,
					'username' => MAILUSER,
					'password' => MAILPASS);
			$message = 'Hi '.$name.','.
						'<br />Below is a Recipet. <br /><br />
							<div id="mydiv" style="box-shadow:0px 0px 2px 2px #999;color:#4169E1 !important">
								'.$recp.'
							</div>

					<br /><br />Regards, <br /> Sree Ramaseva Mandali';
				$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
				if($transport){
					$mail = new Zend_Mail();
					if($mail){
						$mail->setBodyHtml($message);
						$mail->setFrom(MAILUSER, ALTEMAIL);
						$mail->addTo($email, $name);
						$mail->setSubject($subject);
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
	function linear_search($key,$listtypes){
		for($i=0;$i<sizeof($listtypes);$i++)
			if($key == $listtypes[$i])
				return true;
		return false;
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
	function createDirectory($path1){
		if(PHP_OS == 'WINNT' || PHP_OS == 'WIN32'){
			if(!file_exists($path1)){
				mkdir($path1, 0, true);
			}
		}
		if(PHP_OS == 'Linux'){
			if(!file_exists($path1)){
				mkdir($path1, 0755, true);
			}
		}
		file_put_contents($path1."/index.php","<?php header('Location:".URL."'); ?>");
	}
	function ValidateAdmin(){
		if(!isset($_SESSION['ADMIN_NAME']) || !isset($_SESSION['ADMIN_PASS'])){
			return false;
		}
		else if( isset($_SESSION['ADMIN_NAME']) && isset($_SESSION['ADMIN_PASS']) ){
			$u = $_SESSION['ADMIN_NAME'];
			$p = $_SESSION['ADMIN_PASS'];
			$flag = CheckAdminValidation($u,$p);
			if($flag != 'success' ){
				return false;
			}
			else{
				return true;
			}
		}
	}
	function CheckAdminValidation($u,$p){
		$flag = false;
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT * FROM `user_profile`
						WHERE `user_name` = '".mysql_real_escape_string($u)."'
						AND `password` = '".mysql_real_escape_string($p)."'; ";
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					$flag = 'success';
				}
				else{
					$flag = false;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		return $flag;
	}
	function convert_number_to_words($number) {
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'fourty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion',
			1000000000000000000 => 'quintillion'
		);
		if (!is_numeric($number)) {
			return false;
		}
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
		if ($number < 0) {
			return $negative . convert_number_to_words(abs($number));
		}
		$string = $fraction = null;
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= convert_number_to_words($remainder);
				}
				break;
		}
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
		return $string;
	}
	function no_to_words($no){
		$words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred &','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
		if($no == 0)
			return ' ';
		else{
		$novalue='';
		$highno=$no;
		$remainno=0;
		$value=100;
		$value1=1000;
				while($no>=100)    {
					if(($value <= $no) &&($no  < $value1))    {
					$novalue=$words["$value"];
					$highno = (int)($no/$value);
					$remainno = $no % $value;
					break;
					}
					$value= $value1;
					$value1 = $value * 100;
				}
			  if(array_key_exists("$highno",$words))
				  return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
			  else {
				 $unit=$highno%10;
				 $ten =(int)($highno/10)*10;
				 return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
			   }
		}
	}
	function moneyFormatIndia($num){
		$nums = explode(".",$num);
        if(count($nums)>2){
            return "0";
        }else{
        if(count($nums)==1){
            $nums[1]="00";
        }
        $num = $nums[0];
        $explrestunits = "" ;
        if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3);
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits;
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){

                if($i==0)
                {
                    $explrestunits .= (int)$expunit[$i].",";
                }else{
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash.".".$nums[1];
        }
	}
	function returnRandomSourceEmail(){
		require_once(LIB_ROOT."PHPExcel_1.7.9/Classes/PHPExcel.php");
		$thefile1 = LIB_ROOT."CMS-EmailIds-madmec-Export.xlsx";
		$thefile2 = LIB_ROOT."CMS-EmailIds-bigrock-Export.xlsx";
		$thefile3 = LIB_ROOT."CMS-EmailIds-gmail-Export.xlsx";
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($thefile1);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		if ($highestRow > 0){
			$_SESSION['MADMECMAILS'] = array();
			for ($row = 1,$j = 0; $row <= $highestRow; ++$row,$j++) {
				$_SESSION['MADMECMAILS'][$j]['email'] = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
				$_SESSION['MADMECMAILS'][$j]['password'] = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
			}
		}
		$objPHPExcel = $objReader->load($thefile2);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		if ($highestRow > 0){
			$_SESSION['BIGROCKMAILS'] = array();
			for ($row = 1,$j = 0; $row <= $highestRow; ++$row,$j++) {
				$_SESSION['BIGROCKMAILS'][$j]['email'] = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
				$_SESSION['BIGROCKMAILS'][$j]['password'] = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
			}
		}
		$objPHPExcel = $objReader->load($thefile3);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		if ($highestRow > 0){
			$_SESSION['GMAIL'] = array();
			for ($row = 1,$j = 0; $row <= $highestRow; ++$row,$j++) {
				$_SESSION['GMAIL'][$j]['email'] = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
				$_SESSION['GMAIL'][$j]['password'] = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
			}
		}
		$objPHPExcel->disconnectWorksheets();
		unset($objPHPExcel);
		unset($objReader);
	}
	function generateVoucher($receipt){
		return '<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>
			span{text-transform:capitalize;color:#4169E1 !important; font-weight:bold !important;}
		</style>
		</head>
		<body><div style=" font-family: Arial, Helvetica, sans-serif !important;font-size : 16px;height:512px; width:744px; background-size: 744px 512px ;background:url(\''.$receipt["img_url"].'\');background-repeat: no-repeat;   background-size:contain;">
		<table width="744" cellpadding="0" cellspacing="0" align="center" >
		<tbody>
		  <tr>
          <td width="219">
          </td>
		<td colspan="2" width="381" align="left" height="68">
			<span>'.$receipt["sl_no"].'</span>
		</td>
		<td width="144" colspan="2">
			<span >'.$receipt["date"].'</span>
		</td>
		</tr>
        </tbody>
        </table>
        <table width="744"  cellpadding="0" cellspacing="0" align="center" >
		<tbody>
		<tr>
        <td width="271">
        </td>
		<td width="470" height="79" colspan="4">
			<span > '.$receipt["pre_name"]." ".$receipt["tar_name"].'</span>
		</td>
		</tr>
        </tbody>
        </table>
        <table width="744"  cellpadding="0" cellspacing="0" align="center" >
		<tbody>
		<tr>
        <td width="185" height="101"></td>
		<td width="556" colspan="4" valign="top" style="padding-top:40px;">
			<span > '.$receipt["amount_words"].' only.</span>
		</td>
		</tr>
        </tbody>
        </table>
        <table width="744"  cellpadding="0" cellspacing="0" align="center" >
		<tbody>
		<tr>
        <td width="111" height="133"></td>
		<td width="603" colspan="4" valign="top" style="padding-top:12px;">
			<span > '.$receipt["towards"].' </span>
		</td>
		</tr>
        </tbody>
        </table>
        <table width="744"  cellpadding="0" cellspacing="0" align="center" >
		<tbody>
		<tr>
        <td valign="top" width="75">
        </td>
		<td valign="top" width="225" height="62">
			<span>  '.$receipt["amount"].'</span>
		</td>
		<td valign="top" width="179">
			<span >'.$receipt["cheque_no"].'</span>
		</td>
		<td valign="top"  width="262">
			<span > '.$receipt["bank_name"].'</span>
		</td>
		</tr>
		</tbody></table>
        </div>
		</body>
		</html>';
	}
	function generateReciept($receipt){
		if($receipt["pre_name"] == 'The')
			$loc = 'headquartered at: <br />'.$receipt["loc"];
		else
			$loc = 'Residing at: <br />'.$receipt["loc"];
		if($receipt["don_type"] == 'cash')
			$mop_des = 'Amount received by the mode of: CASH.';
		else if($receipt["don_type"] == 'dd')
			$mop_des = 'Amount received by the mode of: Demand Draft,<br /> numbered '.$receipt["number"].' drawn on '.$receipt["branch_of"].' Branch of '.$receipt["bank_name"].' Bank.';
		else if($receipt["don_type"] == 'cheque')
			$mop_des = 'Amount received by the mode of: CHEQUE,<br /> numbered '.$receipt["number"].' drawn on '.$receipt["branch_of"].' Branch of '.$receipt["bank_name"].' Bank.';
		else if($receipt["don_type"] == 'transfer')
			$mop_des = 'Amount received by the mode of: '.$receipt["tran_mode"].'<br />'.$receipt["number"].', Transaction number '.$receipt["number"].' draw
			n on '.$receipt["branch_of"].' Branch of '.$receipt["bank_name"].' Bank.';

		return '<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>
			.span1{text-transform:capitalize;color:#4169E1 !important;font-weight:bold !important; padding-bottom:5px;font-size: 18px !important;}
			.span2{color:#4169E1 !important;font-weight:bold !important;padding-bottom:5px;font-size: 18px !important;}
			.span3{color:#CC0000 !important;font-weight:bold !important;padding-bottom:5px;font-size: 16px !important;}
			hr{border-bottom:2px #000 solid;}
		</style>
		</head>
		<body><div id="content_div" style="background-size: 100% 160px !important;font-weight:bold !important; font-size : 18px !important;padding:20px 50px;font-family: Arial, Helvetica, sans-serif !important;font-size : 20px;height:auto; width:800px; background:url(\''.URL.'assets/img/receipt_bg.png\') no-repeat  scroll 0% 0% / 100% 160px transparent;">
		<div style="height:155px; position:relative;">
		&nbsp;
		</div>
		<table width="700" cellpadding="0" cellspacing="0" align="center" >
		<tbody>
		 <tr>
		<td colspan="2" height="30">
			<center ><span class="span1" style="text-decoration:underline; padding-bottom:15px;font-weight:bold !important;"></span></center>
		</td>
		</tr>
        <tr>
		<td valign="top" height="60">
			<span class="span1"> Receipt No. '.$receipt["rec_no"].'</span>
		</td>
		<td valign="top" width="200" align="right">
			<span class="span1">Date: '.$receipt["date"].'</span>
		</td>
		</tr>
        <tr>
		<td valign="top" colspan="2" height="60">
			<span class="span1"> Received with thanks from: <br />'.$receipt["pre_name"]." ".$receipt["tar_name"].'</span>
		</td>
		</tr>
        <tr>
		<td valign="top" colspan="2" height="60">
			<span class="span1">'.$loc.'</span>
		</td>
		</tr>

        <tr>
        <td valign="top" colspan="2">
			<span class="span1" style="text-transform: uppercase;" >A SUM OF RUPEES : '.$receipt["amount_words"].' only.</span>
		</td>
		</tr>
		<tr>
		<td colspan="2" align="right" height="50">
			<div class="span1" style="width:220px; padding:10px; border:1px solid #CC0000; font-size:22px !important; "><span>  Rs. '.$receipt["amount"].'</span>
		</td>
		</tr>
        <tr>
        <td colspan="2"  height="50">
			<span class="span1">FOR : '.$receipt["for"].'</span>
		</td>
		</tr>
		<tr>
        <td colspan="2">
			<div class="span2">
				<hr />
				<p>'.$mop_des.'</p>
			</div >
			<div class="span2">
				With warm Regards,<br />
				For, '.ORGNAME.'
				<p>&nbsp;<br/></p>
				<br />
				Signature.
				<hr />
			</div>
		</td>
		</tr>
        <tr>
        <td valign="top" colspan="2">

			<center style="color:#3f3f3f;font-size:12px;font-weight:500 !important;">
				Note:this is a computer generated receipt.
			</center>
		</td>
		</tr>
		</tbody></table>
        </div>
		</body>
		</html>';
	}
        /*function to send SMS*/
        function SendSms($sms_para){
            $flag = false;
            $tar_id = $sms_para['tar_id'];
            $number = $sms_para['number'];
            $msg = $sms_para['msg'];
            if(strlen($msg) >> 0 && strlen($msg) <= 160)
                    $msg_length = 1;
            elseif(strlen($msg) > 160 && strlen($msg) <= 320)
                    $msg_length = 2;
            elseif(strlen($msg) > 320 && strlen($msg) <= 480)
                    $msg_length = 3;
                                    $restPara = array(
                                                    "user"                              => 'madmec',
                                                    "password" 				=> 'madmec',
                                                    "mobiles" 				=> $number,
                                                    "sms" 				=> $msg,
                                                    "senderid" 				=> 'MADMEC',
                                                    "version" 				=> 3,
                                                    "accountusagetypeid"                => 1
                                            );
                                            $url = 'http://trans.profuseservices.com/sendsms.jsp?'.http_build_query($restPara);
                                            $response = file_get_contents($url);
                                            if( !preg_match('/error/',$response) ){
                                                $_SESSION['success']++;
                                                $query = "INSERT INTO `sms_record`
                                                (`tar_id`,`msg`,`sms_count`, `status`,`paid`,`date`)
                                                VALUES
                                                (
                                                '".mysql_real_escape_string($tar_id)."',
                                                '".mysql_real_escape_string($msg)."',
                                                '".mysql_real_escape_string($msg_length)."',
                                                DEFAULT,
                                                '".mysql_real_escape_string('0')."',
                                                NOW()
                                                );";
                                                $res = executeQuery($query);
                                                if($res){
                                                        $flag = true;
                                                }
                                            }
                                            else{
                                                    $flag = false;
                                            }


            return $flag;
	}
?>
