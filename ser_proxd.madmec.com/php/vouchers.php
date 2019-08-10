<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
        if($_SESSION['USERTYPE'] != "admin")
                header("Location:".URL);
	$parameters = array();
	function main(){
		if(!ValidateAdmin()){
			session_destroy();
			header('Location:'.URL);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'dis_voc'){
			$val = $_POST['val'];
			if($val == 'cheque' || $val == 'cash'){
				DisVoc($val);
			}elseif($val == 'view'){
 				DisAllVoc($val);
			}
			unset($_POST);
			exit(0);
		}
				elseif(isset($_POST['action']) && $_POST['action'] == 'dis_voc_scroll'){

				if(isset($_SESSION['vouchers']) && sizeof($_SESSION['vouchers']) > 0){
								$_SESSION["initial"] = 0;
								$_SESSION["final"] = 10;
								$para["initial"] = $_SESSION["initial"];
								$para["final"] = $_SESSION["final"];
								DisAllVoc($para);
				}
				else{
								$para["initial"] = 0;
								$para["final"] = 0;
								DisAllVoc($para);
								echo '<script language="javascript" >$(window).unbind();</script>';
				}


			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'dis_voc_scroll_append'&&$_POST['val']!='cheque'){

				if(isset($_SESSION["initial"]) && isset($_SESSION["final"])){
								if(isset($_SESSION['vouchers']) && sizeof($_SESSION['vouchers']) > 0){
									if($_SESSION["final"] >= sizeof($_SESSION['vouchers'])){
										unset($_SESSION["initial"]);
										unset($_SESSION["final"]);
										echo '<script language="javascript" >$(window).unbind();</script>';
									}
									else{
										$_SESSION["initial"] = $_SESSION["final"]+1;
										$_SESSION["final"] += 10;
										$para["initial"] = $_SESSION["initial"];
										$para["final"] = $_SESSION["final"];
										DisAllVocAppend($para);
									}
								}
							}


			unset($_POST);
			exit(0);
		}

		elseif(isset($_POST['action']) && $_POST['action'] == 'make_payment'){
			$val = $_POST['val'];
			MakePayment($val);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'load_tar_session'){
			$_SESSION['targets'] = LoadTarSession();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'load_all_vouchers'){
			$_SESSION['vouchers'] = LoadAllVouchers();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'check_name_exist'){
			$result = CheckNameExist(strtolower($_POST['name']));
			echo $result;
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'auto_fill'){
			AutoFill($_POST['name']);
			unset($_POST);
			exit(0);
		}
	}
	function AutoFill($name){
		$result = $_SESSION['targets'];
		foreach ($result as $key => $val) {
                   if ($val['tar_name'].' - '.$val['phone'].' - '.$val['email'] === $name) {
			   echo json_encode($val);
		   }
		}
		exit(0);
	}
	function LoadTarSession(){
		$targets = array();
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT * FROM `target` WHERE `status` = 'active' ;";
				$res = executeQuery($query);
				if(mysql_num_rows($res) > 0){
					$i = 0;
					while( $row = mysql_fetch_assoc($res)){
						$targets[$i]['id'] = $row['id'];
						$targets[$i]['pre_name'] = $row['pre_name'];
						$targets[$i]['tar_name'] = $row['tar_name'];
						$targets[$i]['address'] = $row['address'];
						$targets[$i]['email'] = $row['email'];
						$targets[$i]['phone'] = $row['phone'];
						$i++;
					}
				}
				else{
					$targets = NULL;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		return $targets;
	}
	function CheckNameExist($name){
		$targets = $_SESSION['targets'];
		$i = 0;
		$tar_names_arr = '';
		while($i < sizeof($targets)){
				$tar_names_arr .= $targets[$i]['tar_name']."-";
			$i++;
		}
		$test = explode("-",$tar_names_arr);
		if(in_array($name, $test)){
			$key = array_search($name, $test);
			$flag = $targets[$key]['id'];
		}
		else
			$flag = -1;
		return $flag;
	}
	function MakePayment($val){
		$ser_no = $_POST['ser_no'];
		$pre_name= $_POST['pre_name'];
		$name= strtolower($_POST['name']);
		$user_type= $_POST['user_type'];
		$loc= $_POST['loc'];
		$email= $_POST['email'];
		$mobile= $_POST['mobile'];
		$amount= $_POST['amount'];
		$towards= $_POST['towards'];
		$org_date = $_POST['date'];
		$date_temp = explode("-",$_POST['date']);
		$date = $date_temp[2].'-'.$date_temp[1].'-'.$date_temp[0];

		/* user_detail fields*/
		$bloodgroup = ( isset($_POST['bloodgroup']) ) ? $_POST['bloodgroup'] : '';
		$dob = ( isset($_POST['dob']) ) ? $_POST['dob'] : '';
		$sex = ( isset($_POST['sex']) ) ? $_POST['sex'] : '';
		$allergies = ( isset($_POST['allergies']) ) ? $_POST['allergies'] : '';


		if($val == 'cheque'){
			$cheque_no = $_POST['cheque_no'];
			$src_ac = $_POST['src_ac'];
		}
		elseif($val == 'cash'){
			$cheque_no = 'NULL';
			$src_ac = 0;
		}
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				executeQuery("SET AUTOCOMMIT=0;");
				executeQuery("START TRANSACTION;");
				if( isset($_POST['target_id']) ){
					$tar_id = $_POST['target_id'];
					$res = true;
				}
				else{
					$query = "INSERT INTO `target`
					(`pre_name`, `tar_name`,`address`,`email`,`phone`,`user_type`, `date` )
					VALUES
					( '".mysql_real_escape_string($pre_name)."',
					'".mysql_real_escape_string($name)."',
					'".mysql_real_escape_string($loc)."',
					'".mysql_real_escape_string($email)."',
					'".mysql_real_escape_string($mobile)."',
					'".mysql_real_escape_string($user_type)."',
					NOW() ); ";
					$res = executeQuery($query);
					$tar_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
					$query1 = "INSERT INTO `user_details`
					(`user_pk`, `bloodgroup`, `dob`, `sex`, `allergies`)
					VALUES
					('".mysql_real_escape_string($tar_id)."',
					'".mysql_real_escape_string($bloodgroup)."',
					'".mysql_real_escape_string($dob)."',
					'".mysql_real_escape_string($sex)."',
					'".mysql_real_escape_string($allergies)."'
					 ); ";
					$res1 = executeQuery($query1);
				}
				if($res){
					$query1 = "INSERT INTO `payments`
					( `target_id`, `pay_type`, `source_id`, `cheque_no`, `amount`, `towards`, `date`, `status`)
					VALUES
					('".$tar_id."',
					'".mysql_real_escape_string($val)."',
					'".mysql_real_escape_string($src_ac)."',
					'".mysql_real_escape_string($cheque_no)."',
					'".mysql_real_escape_string($amount)."',
					'".mysql_real_escape_string($towards)."',
					'".mysql_real_escape_string($date)."',
					default ); ";
					$res1 = executeQuery($query1);

					if($res1){
						$location = URL.ASSET_VOU.$ser_no.'_'.$name.'_'.date('j-M-Y').'.html';
						$payment_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
						$query2 = "INSERT INTO `voucher`
						(`payment_id`, `sl_no`, `location`)
						VALUES
						('".$payment_id."',
						'".mysql_real_escape_string($ser_no)."',
						'".mysql_real_escape_string($location)."'
						); ";
						$res2 = executeQuery($query2);
						if($res2){
							executeQuery("COMMIT");
							if($val == 'cheque'){
								$bank_name = mysql_result(executeQuery("SELECT `src_bank` FROM `source` WHERE `id` = '".mysql_real_escape_string($src_ac)."';"),0);
								$img_url = URL.ASSET_IMG."cheque_vou.png";
							}
							else{
								$bank_name = '';
								$cheque_no = '';
								$img_url = URL.ASSET_IMG."cash_vou.png";
							}
							$receipt = array(
											"css" 		=> "<link href='".URL.ASSET_DIR."font-awesome-4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css' />",
											"val" 		=> $val,
											"img_url" 	=> $img_url,
											"sl_no" 	=> $ser_no,
											"date" 		=> $org_date,
											"pre_name" 	=> $pre_name,
											"tar_name" 	=> $name,
											"cheque_no" => $cheque_no,
											"src_ac" 	=> $src_ac,
											"towards" 	=> $towards,
											"bank_name" 	=> $bank_name,
											"amount" 	=> moneyFormatIndia($amount),
											"amount_words" 	=> no_to_words($amount)
										);
							$voucher = generateVoucher($receipt);
								$file_name = DOC_ROOT.ASSET_VOU.$ser_no.'_'.$name.'_'.date('j-M-Y').'.html';
								$file_link = URL.ASSET_VOU.$ser_no.'_'.$name.'_'.date('j-M-Y').'.html';
							$fh = fopen($file_name, 'w');
							fwrite($fh, $voucher);
							fclose($fh);
							echo '<a href="'.$file_link.'" class="btn btn-danger square-btn-adjust" target="_blank"><i class="fa fa-Print"></i>&nbsp;Print Vocuher</a><br /><br />'.$voucher.'';
						}
						else{

							echo 0;
							executeQuery("ROLLBACK");
						}
					}
				}
				else{
					echo 0;
					executeQuery("ROLLBACK");
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function LoadAllVouchers(){
		$vouchers = array();
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if(isset($_POST["name"])){
                                    $name=explode("-",$_POST["name"]);
                                    $sub_query = ' AND 	(
                                        c.`tar_name` LIKE "%'.trim($name[0]).'%"
                                        OR
                                        c.`phone` LIKE "%'.trim($name[0]).'%"
                                        OR
                                        c.`email` LIKE "%'.trim($name[0]).'%"
                                        )';
				}

				else {
                                    $sub_query = "";
                                }
				$query = "SELECT a.*,
				b.`pay_type`,
				b.`source_id`,
				b.`cheque_no`,
				b.`amount`,
				b.`date`,
				c.`pre_name`,
				c.`tar_name`,
				c.`phone`,
				c.`email`
				FROM
				`voucher` AS a JOIN `payments` AS b ON a.`payment_id` = b.`id`
				JOIN `target`AS c on b.`target_id` = c.`id`
				".$sub_query."
				ORDER BY `id` DESC";








				/*

				if(isset($_POST["name"])) {
				$name=$_POST["name"];
				$query = "SELECT a.*,
				b.`pay_type`,
				b.`source_id`,
				b.`cheque_no`,
				b.`amount`,
				b.`date`,
				c.`pre_name`,
				c.`tar_name`
				FROM
				`voucher` AS a JOIN `payments` AS b ON a.`payment_id` = b.`id`
				JOIN `target`AS c on b.`target_id` = c.`id`
				WHERE c.`tar_name` LIKE '%".$name."%'
				ORDER BY `id` DESC";

				}else {
				$query = "SELECT a.*,
				b.`pay_type`,
				b.`source_id`,
				b.`cheque_no`,
				b.`amount`,
				b.`date`,
				c.`pre_name`,
				c.`tar_name`
				FROM
				`voucher` AS a JOIN `payments` AS b ON a.`payment_id` = b.`id`
				JOIN `target`AS c on b.`target_id` = c.`id` ORDER BY `id` DESC";
				}*/
				$res =  executeQuery($query);
				if(mysql_num_rows($res)){
					$index = 0;
					while( $row = mysql_fetch_assoc($res) ){
						$vouchers[$index]['id'] = $row['id'];
						$vouchers[$index]['payment_id'] = $row['payment_id'];
						$vouchers[$index]['sl_no'] = $row['sl_no'];
						$vouchers[$index]['location'] = $row['location'];
						$vouchers[$index]['pay_type'] = $row['pay_type'];
						$vouchers[$index]['source_id'] = $row['source_id'];
						$vouchers[$index]['cheque_no'] = $row['cheque_no'];
						$vouchers[$index]['amount'] = $row['amount'];
						$vouchers[$index]['date'] = $row['date'];
						$vouchers[$index]['pre_name'] = $row['pre_name'];
						$vouchers[$index]['tar_name'] = $row['tar_name'];
						$index++;
					}
				}
				else{
					$vouchers = NULL;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		return $vouchers;
	}

	//Diplay the voucher view
	function DisAllVoc($val){
		$parameters = $val;
		$num_posts = 0;
		if(isset($_SESSION['vouchers']) && $_SESSION['vouchers']!= NULL)
			$vouchers = $_SESSION['vouchers'];
		else
			$vouchers = NULL;
		if($vouchers != NULL)
				$num_posts = sizeof($vouchers);
				//echo $num_posts;
		$vouchers=$_SESSION['vouchers'];
		$total_vou='';
		$a=0;
		$targets = $_SESSION['targets'];
		while($a < sizeof($targets)){

			if($a == 0)
				$total_vou = '"'.$targets[$a]['tar_name'].' - '.$targets[$a]['phone'].' - '.$targets[$a]['email'].'"';
			else
				$total_vou .= ',"'.$targets[$a]['tar_name'].' - '.$targets[$a]['phone'].' - '.$targets[$a]['email'].'"';
			$a++;
		}
				echo '
					<div class="row">
                                                <div class="col-md-4">
							<input id="name1" type="text" class="form-control" onKeyDown="javascript:if (event.keyCode==13 || event.keyCode==9)search_voucher(this.value);"  placeholder="Search Name/Email/Mobile ">
						</div>
						<div class="col-md-4">
								<button class="btn btn-danger" onclick="javascript:view_all_voucher();">
								<i class="fa fa-refresh "></i>
				 				Refresh
								</button><br/>
						</div>
				 </div>

					<script>
						$(function() {
						var availableTags = ['.$total_vou.'];
						$( "#name1" ).autocomplete({
						source: availableTags

						});
					});
				</script>

				<br/>	';
		//
		echo '<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
							List Vouchers
                        </div>
                        <div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" >
							<thead>
								<tr>
									<th >
										Receipt No.
									</th>
									<th>
										Name
									</th>
									<th>
										Date of Receipt
									</th>
									<th>
										Critical Action
									</th>
								</tr>
							</thead>';
		if($num_posts > 0){

		for($i=$parameters["initial"];$i<$parameters["final"] && $i < $num_posts;$i++){
		//for($i=0;$i< $end;$i++){
			$temp_name = explode("/",$vouchers[$i]['location']);
			$name_string = explode(".",$temp_name[sizeof($temp_name)-1]);
			$name_string = $name_string[0];
			$string = explode("_",$name_string);
			echo '
					<tbody>
                                    <tr>
										<td>
											 '.$string[0].'
										</td>
										<td>
											 '.$string[1].'
										</td>
										<td>
											 '.$string[2].'
										</td>
										<td>
											 <a  href="'.$vouchers[$i]['location'].'" target="_blank" class="btn btn-danger"><i class="fa fa-print"> &nbsp;Print</i></a>
											 <a  href="'.URL.'php/edit/edit_vouchers.php?id='.base64_encode($vouchers[$i]['id']).'" target="_blank" class="btn btn-warning"><i class="fa fa-edit"> &nbsp;Edit</i></a>
											 <a data-toggle="collapse" data-parent="#accordion" href="#collapse_'.$vouchers[$i]['id'].'" target="_blank" class="btn btn-info"><i class="fa fa-bullseye"> &nbsp;View</i></a>
										</td>
									</tr>
								<tr>
									<td colspan="4">
										<div id="collapse_'.$vouchers[$i]['id'].'" class="panel-collapse collapse" style="height: 0px;">
											<div class="panel-body">
												<iframe style="border:0px;" height="1050" width="760" src="'.$vouchers[$i]['location'].'">
												</iframe>
											</div>
										</div>
									</td>
                                </tr>
                        <!--<div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_'.$vouchers[$i]['id'].'" >
												Voucher NO. : '.$string[0].'<br />
												Name : '.$string[1].'<br />
												Date of Voucher : '.$string[2].'<br />
											</a>
											<a  href="'.$vouchers[$i]['location'].'" target="_blank" class="btn btn-danger"><i class="fa fa-print"> &nbsp;Print</i></a>
											<a href="'.URL.'php/edit/edit_vouchers.php?id='.base64_encode($vouchers[$i]['id']).'" target="_blank" class="btn btn-warning"><i class="fa fa-edit"> &nbsp;Edit</i></a>

                                    </div>
                                    <div id="collapse_'.$vouchers[$i]['id'].'" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
											<iframe style="border:0px;" height="540" width="760" src="'.$vouchers[$i]['location'].'">
											</iframe>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>-->
                        ';

		}
	}
		echo '			</tbody>
						</table>
					</div>
				</div>
                </div>
            </div>';
	}

	//Display the function of append the data
	function DisAllVocAppend($val){
		$parameters = $val;
		$num_posts = 0;
		if(isset($_SESSION['vouchers']) && $_SESSION['vouchers']!= NULL)
			$vouchers = $_SESSION['vouchers'];
		else
			$vouchers = NULL;
		if($vouchers != NULL)
				$num_posts = sizeof($vouchers);

		//$vouchers = $_SESSION['vouchers'];
		//$end = sizeof($vouchers);
		echo '<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                    <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="rec_table">
								<thead>
										<tr>
											<th >
												Receipt No.
											</th>
											<th>
												Name
											</th>
											<th>
												Date of Receipt
											</th>
											<th>
												Critical Action
											</th>
										</tr>
								</thead> ';

		if($num_posts > 0){

		for($i=$parameters["initial"];$i<$parameters["final"] && $i < $num_posts;$i++){
		//for($i=0;$i< $end;$i++){
			$temp_name = explode("/",$vouchers[$i]['location']);
			$name_string = explode(".",$temp_name[sizeof($temp_name)-1]);
			$name_string = $name_string[0];
			$string = explode("_",$name_string);
			echo '<tr>
					  <td>
						 '.$string[0].'
					  </td>
					  <td>
						 '.$string[1].'
					  </td>
					  <td>
						 '.$string[2].'
					  </td>
					  <td>
							 <a  href="'.$vouchers[$i]['location'].'" target="_blank" class="btn btn-danger"><i class="fa fa-print"> &nbsp;Print</i></a>
							 <a  href="'.URL.'php/edit/edit_vouchers.php?id='.base64_encode($vouchers[$i]['id']).'" target="_blank" class="btn btn-warning"><i class="fa fa-edit"> &nbsp;Edit</i></a>
							 <a data-toggle="collapse" data-parent="#accordion" href="#collapse_'.$vouchers[$i]['id'].'" target="_blank" class="btn btn-warning"><i class="fa fa-bullseye"> &nbsp;View</i></a>
					  </td>
				  </tr>
				  <tr>
						<td colspan="4">
							<div id="collapse_'.$vouchers[$i]['id'].'" class="panel-collapse collapse" style="height: 0px;">
								<div class="panel-body">
									<iframe style="border:0px;" height="1050" width="760" src="'.$vouchers[$i]['location'].'">
									</iframe>
								</div>
							</div>
						</td>
                  </tr>
                        <!--<div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_'.$vouchers[$i]['id'].'" >
												Voucher NO. : '.$string[0].'<br />
												Name : '.$string[1].'<br />
												Date of Voucher : '.$string[2].'<br />
											</a>
											<a  href="'.$vouchers[$i]['location'].'" target="_blank" class="btn btn-danger">Print</a>
											<a href="'.URL.'php/edit/edit_vouchers.php?id='.base64_encode($vouchers[$i]['id']).'" target="_blank" class="btn btn-warning">Edit</a>

                                    </div>
                                    <div id="collapse_'.$vouchers[$i]['id'].'" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
											<iframe style="border:0px;" height="540" width="760" src="'.$vouchers[$i]['location'].'">
											</iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>-->';
        }
	}
		echo '					</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>';
	}
	function DisVoc($val){
	$targets = $_SESSION['targets'];
		$i = 0;
		$tar_names_arr = '';
		while($i < sizeof($targets)){
			if($i == 0)
				$tar_names_arr = '"'.$targets[$i]['tar_name'].' - '.$targets[$i]['phone'].' - '.$targets[$i]['email'].'"';
			else
				$tar_names_arr .= ',"'.$targets[$i]['tar_name'].' - '.$targets[$i]['phone'].' - '.$targets[$i]['email'].'"';
			$i++;
		}
		if($val == 'cheque'){
			$color = 'danger';
			$voc_type = 'Cheque Voucher';
			$src_ac = '';
			$cheque_no = '';
		}
		elseif($val == 'cash'){
			$color = 'success';
			$voc_type = 'Cash Voucher';
			$src_ac = 'style="display:none;"';
			$cheque_no = 'style="display:none;"';
		}
			$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
			if(get_resource_type($link) == 'mysql link'){
				if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					$src_ac_opt = GetSrcAccount();
					$sl_no = FecthSlNo();
				}
			}
			if(get_resource_type($link) == 'mysql link')
			mysql_close($link);

		echo '<div class="col-md-12">
                    <div class="panel panel-'.$color.'">
                        <div class="panel-heading">
                            '.$voc_type.'
                        </div>
                        <div class="panel-body">
							<form role="form">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>serial Number : </label>
											<input type="text" id="ser_no" class="form-control" value="'.$sl_no.'" readonly>
										</div>
								 	</div>

								 	<div class="col-md-3">
										<div class="form-group">
											<label>Date of Receipt: </label><br/>
											<i class="fa fa-calendar fa-2x"></i>
											<input type="text" id="date"  value="'.date("d-m-Y").'" readonly>
											<script type="text/javascript">
												$("#date").datepicker({ dateFormat: "dd-mm-yy",changeMonth : true,changeYear : true,   });
											</script>
										</div>
									</div>
                                                                        <div class="col-md-3">
                                                                        <div class="form-group" '.$src_ac.'>
                                                                                <label>Source Account :</label>
                                                                                        <select id="src_ac" class="form-control">
                                                                                                '.$src_ac_opt.'
                                                                                        </select>
                                                                                <span class="text-danger"id="err_src_ac">Invalid</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group" '.$cheque_no.'>
                                                                                <span class="manditory">*</span>
                                                                                <label>Cheque No</label>
                                                                                        <div class="form-group input-group">
                                                                                                <span class="input-group-addon">
                                                                                                        <strong>#</strong>
                                                                                                </span>
                                                                                                <input id="cheque_no" type="number"  onkeyDown="javascript:number_allow_chequeno();" class="form-control"  placeholder="999999">
                                                                                        </div>
                                                                                <span class="text-danger" id="err_cheque_no">Invalid</span>
                                                                        </div>
                                                                    </div>
								</div>
                                                                <div class="row">

                                                                </div>

								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<span class="manditory">*</span>
											<label class="manditory">Paid to</label>
									  			<select id="pre_name" class="form-control">
													<option value="Mr." selected>Mr</option>
													<option value="Mrs.">Mrs</option>
													<option value="Miss.">Miss</option>
													<option value="Dr.">Dr</option>
													<option value="The ">The</option>
												</select>
									 	</div>
								 	</div>

							  		<div class="col-md-4">
										<div class="form-group">
											<span class="manditory">*</span>
											<label class="manditory">Name</label>
												<input id="name" type="text" class="form-control" onblur="javascript:auto_fill(this.value);" placeholder="Name">
												<script>
													$(function() {
															var availableTags = ['.$tar_names_arr.'];
															$( "#name" ).autocomplete({
															source: availableTags
														});
													});
												</script>
									  </div>
									  	<span class="text-danger" id="err_name">Invalid</span>
									</div>



							<div class="col-md-6">
								<div class="form-group">
                                                                                <span class="manditory">*</span>
                                                                                <label class="manditory">User Type</label>
										<select id="user_type" class="form-control">
											<option value="1" >Doctor</option>
											<option value="2" selected>Patient</option>
											<option value="3">Others</option>
										</select>
								</div>
							</div>
						</div>
								<!-- user details -->
								<div id="user_details" style="display:none;">

								<div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">

                                                                                    <span class="manditory">*</span>
                                                                                    <label class="manditory">Sum of Rupees</label>
                                                                                    <div class="form-group input-group">
                                                                                            <span class="input-group-addon">
                                                                                                    <i class="fa fa-inr"></i>
                                                                                            </span>
                                                                                            <input id="amount" type="text" onkeyDown="javascript:number_allow_sumofruppes();" class="form-control"  placeholder="9999.99">
                                                                                    </div>
                                                                                    <span class="text-danger" id="err_amount">Invalid</span>
                                                                            </div>
                                                                        </div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Email Id</label>
												<input id="email" type="text"  class="form-control"  placeholder="abc@email.com" pattern="^.+@.+$">
												<span class="text-danger" id="err_email">Invalid</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Mobile Number</label>
											<input id="mobile" type="text" maxlength="10" onkeyDown="javascript:number_allow();" class="form-control" placeholder="9900000000" >
											<span class="text-danger" id="err_mobile">Invalid</span>
										</div>
									</div>
								</div>

								<div class="row">

								 </div>

								 <div class="row">
                                                                    <div class="col-md-12">
									<div class="form-group">

										<label id="res_at">Residing at/</label>
										<label id="hq_at">Head-quartered at</label>
											<textarea id="loc" type="text" class="form-control"  placeholder="type Location"></textarea>
										<span class="text-danger" id="err_loc">Invalid</span>
									</div>
                                                                    </div>
								</div>

									<div class="form-group">
										<label>Towards :</label>
										<textarea id="towards" class="form-control" rows="3"  placeholder="100 character description"></textarea>
									</div>

									<button id="make_payment_btn" onclick="javasript:make_payment(\''.$val.'\');" type="button" class="btn btn-danger form-control">Save Changes</button>
								</div><!--user details-->
							</form>
                        </div>
                    </div>
                </div>';
	}
	function FecthSlNo(){
		$yy = date("Y");
		$mm = date("m");
		$sl_no = ($mm < 4) ? "FY".($yy -1)."V" : "FY".($yy)."V";
				$query = "SELECT * FROM `voucher` ORDER BY `id` DESC LIMIT 1; ";
				$res = executeQuery($query);
				if(mysql_num_rows($res) > 0){
					while( $row = mysql_fetch_assoc($res)){
						$temp = explode("-",$row['sl_no']);
						if($temp[0] != $sl_no){
							$sl_no .= '-00001';
						}
						else{
							$sl_no .=  "-".sprintf("%05s",++$temp[1] );
						}
					}
				}
				else{
					$sl_no .= '-00001';
				}
		return $sl_no;
	}
	function GetSrcAccount(){
		$result = '';
				$query = "SELECT * FROM `source` WHERE `status` = 'active' ORDER BY `id` DESC; ";
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					while( $row = mysql_fetch_assoc($res)){
						$result .=  '<option value="'.$row['id'].'">'.$row['src_ac_name'].' - '.$row['src_ac_no'].' - '.$row['src_branch'].' - '.$row['src_ac_type'].'</option>';
					}
				}
				else{
					echo 'No Accouts to be displayed,Please add new account.';
				}
		return $result;
	}
	main();
?>
<?php include_once(DOC_ROOT.PHP.INC."header.php"); ?>
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="btn-group btn-group-justified">
		  <div class="btn-group">
			<button type="button" class="btn btn-success btn-lg" onclick="javascript:dis_voc('cash')">Cash voucher</button>
		  </div>
		  <div class="btn-group">
			<button type="button" class="btn btn-danger btn-lg" onclick="javascript:dis_voc('cheque')">Cheque voucher</button>
		  </div>
		  <div class="btn-group">
			<button type="button" class="btn btn-info btn-lg" onclick="javascript:dis_voc_scroll('view')">view voucher</button>
		  </div>
		</div>
		<hr />
		<div id="voc_screen">

		</div>
		<!--Display for the append-->
		<div id="voc_screen_app">

		</div>
	</div>
	 <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php include_once(DOC_ROOT.PHP.INC."footer.php"); ?>
<script src="<?php echo URL.ASSET_JS; ?>vouchers.js"></script>
<script>
		$("#voc_nav").addClass("active-menu");
</script>
