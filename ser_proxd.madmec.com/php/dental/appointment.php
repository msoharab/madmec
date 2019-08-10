<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	$parameters = array();
	function main(){
		if(!ValidateAdmin()){
			session_destroy();
			header('Location:'.URL);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'dis_receipts'){
			$val = $_POST['val'];
			if($val == 'create'){
 				DisReceipts();
			}
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'dis_receipts_scroll'){
			if(isset($_SESSION['appointment']) && sizeof($_SESSION['appointment']) > 0){
				$_SESSION["initial"] = 0;
				$_SESSION["final"] = 10;
				$para["initial"] = $_SESSION["initial"];
				$para["final"] = $_SESSION["final"];
				DisAllReceipts($para);
			}
				else{
				$para["initial"] = 0;
				$para["final"] = 0;
				DisAllReceipts($para);
				echo '<script language="javascript" >$(window).unbind();</script>';
			}
				unset($_POST);
				exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'dis_receipts_scroll_append'&&$_POST['val']!='create'){
		    	if(isset($_SESSION["initial"]) && isset($_SESSION["final"])){
					if(isset($_SESSION['appointment']) && sizeof($_SESSION['appointment']) > 0){
						if($_SESSION["final"] >= sizeof($_SESSION['appointment'])){
							unset($_SESSION["initial"]);
							unset($_SESSION["final"]);
							echo '<script language="javascript" >$(window).unbind();</script>';
						}
						else{
							$_SESSION["initial"] = $_SESSION["final"]+1;
							$_SESSION["final"] += 10;
							$para["initial"] = $_SESSION["initial"];
							$para["final"] = $_SESSION["final"];
							DisAllReceiptsAppend($para);
						}
					 }
				  }
				  unset($_POST);
			      exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'load_tar_session'){
			$_SESSION['targets'] = LoadTarSession();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'make_receipt'){
			MakeReceipt();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'check_name_exist'){
			$result = CheckNameExist(strtolower($_POST['name']));
			echo $result;
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'load_all_receipts'){
			$_SESSION['appointment'] = LoadAllAppointment();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'auto_fill'){
			AutoFill($_POST['name']);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'critical_action'){
			$adt=isset($_POST['dt'])?$_POST['dt']:false;
			CriticalAction($_POST['id'],$_POST['val'],$adt);
			unset($_POST);
			exit(0);
		}elseif(isset($_POST['action']) && $_POST['action'] == 'update_appointment'){
			UpdateAppointment();
			unset($_POST);
			exit(0);
		}
	}
	function CriticalAction($id=false,$val=false,$dt=false){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if($val == 'edit'){
					$appointment = $_SESSION['appointment'];
					$end = sizeof($appointment);
					for($i=0;$i< $end;$i++){
						if($appointment[$i]['id'] == $id){
							$time = date( "g:i a",strtotime($appointment[$i]['from']) ) ;
							$timing = '<select id="hh" onchange="caltime();">';
							for($j=1;$j<13;$j++) $timing .= '<option value="'.$j.'" >'.$j.'</option>';
							$timing .= '</select>';
							$timing .= ' : <select id="mm"  onchange="caltime();">';
							$timing .= '<option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>';
							$timing .= '</select>';
							$timing .= '<select id="meridiem"  onchange="caltime();">';
							$timing .= '<option value="AM" >AM</option><option value="PM" >PM</option>';
							$timing .= '</select>';
							$pro_img = ($appointment[$i]['img_url'] == "NOT PROVIDED")? PROFILE_IMG : $appointment[$i]['img_url'];
							echo '<div class="col-md-12">
										<div class="panel panel-warning">
											<div class="panel-heading">
											  Edit Appointment
											</div>
											<div class="panel-body">
											<table class="table">
													<tr>
														<td width="200">
																<img src="'.$pro_img.'" alt="'.$pro_img.'" height="150">
														</td>
														<td>
															Name: <strong style="color:#D9534F;">'.$appointment[$i]['pre_name'].$appointment[$i]['tar_name'].'</strong><br />
															Mobile: <strong style="color:#D9534F;">'.$appointment[$i]['phone'].'</strong><br />
															Email: <strong style="color:#D9534F;">'.$appointment[$i]['email'].'</strong><br />

														</td>
													</tr>
											</table>
												<form role="form">
													<!--<div class="form-group">
														<span class="manditory">*</span>
														<label>Patient Name</label>
														<input id="id" name="name" type="hidden" class="form-control" placeholder="Name" readonly value="'.$appointment[$i]['id'].'">
														<input id="tar_id" name="name" type="hidden" class="form-control" placeholder="Name" readonly value="'.$appointment[$i]['patientid'].'">
														<input id="name" name="name" type="text" class="form-control" placeholder="Name" readonly value="'.$appointment[$i]['pre_name'].$appointment[$i]['tar_name'].'">
														<span class="text-danger" id="err_name">Invalid</span>
													</div>-->

													<div class="form-group">
														<label>Date of appointment: </label>
														<input type="text" id="date" class="form-control" value="'.date("d-m-Y",strtotime($appointment[$i]['appointment_date'])).'" >
														<script type="text/javascript">
															$("#date").datepicker({ dateFormat: "dd-mm-yy" ,changeYear : true,
                                                                                                   changeMonth : true,});
														</script>
													</div>

													<div class="form-group">
														<label>Select Time:  </label>
														<strong style="color:#D2322D;" >'.$time.'</strong>
														'.$timing.'
														<input type="hidden" id="from" class="form-control" value="'.$appointment[$i]['from'].'" readonly>
														<span class="text-danger" id="err_from">Invalid</span>
													</div>
													<div class="form-group">
														<label>Treatment Plan:</label>
														<textarea id="for" class="form-control" rows="3"  placeholder="100 character description">'.$appointment[$i]['des'].'</textarea>
													</div>

													<div class="form-group" style="display:none;">
															<label>User Type</label>
															<select id="user_type" class="form-control">
																<option value="1" >Doctor</option>
																<option value="2" selected>Patient</option>
																<option value="3">Others</option>
															</select>
													</div>

													<!--<div id="user_details" style="display:block;">
														<div class="form-group">
															<label>Email Id</label>
															<input id="email" type="text" class="form-control"  placeholder="abc@email.com" pattern="^.+@.+$" value="'.$appointment[$i]['email'].'" readonly>
															<span class="text-danger" id="err_email">Invalid</span>
														</div>-->

														<!--<div class="form-group">
															<label>Mobile Number</label>
															<input id="mobile" type="number" class="form-control" placeholder="9900000000" value="'.$appointment[$i]['phone'].'" readonly>
															<span class="text-danger" id="err_mobile">Invalid</span>
														</div>-->

														<div class="form-group" style="display:none;">
															<span class="manditory">*</span>
															<label id="res_at">Address</label>
															<textarea id="loc" type="text" class="form-control"  placeholder="type Location" >'.$appointment[$i]['address'].'</textarea>
															<span class="text-danger" id="err_loc">Invalid</span>
														</div>


														<button id="make_receipt_btn" onclick="javasript:update_appiontment();" type="button" class="btn btn-danger form-control">Save Changes</button>
													</div>
												</form>
											</div>
										</div>
									</div>';
						}
						else{
							//dont print anything//
						}
					}
				}
				elseif($val == 'delete'){
					$query = "UPDATE `appointment` SET
					`status_id`= '5'
					WHERE
					`id` =  '".mysql_real_escape_string($id)."';";
					$res = executeQuery($query);
					if($res){
						echo 'Patient Deleted Successfully';
					}
				}
				elseif($val == 'history'){
					$appointment = $_SESSION['appointment'];
					$end = sizeof($appointment);
					for($i=0;$i< $end;$i++){
						if($appointment[$i]['patientid'] == $id){
								echo '<div class="col-md-12">
										<div class="panel panel-warning">
											<div class="panel-heading">
											  Appointment History
											</div>';
											$src_img = ($appointment[$i]['img_url'] == "NOT PROVIDED")? PROFILE_IMG : $appointment[$i]['img_url'];
									echo '
									<div class="row">
										<div class="col-lg-12">
											<table class=" table">
												<tr>
													<td width="200">
														<img src="'.$src_img.'" height="110">
													</td>
													<td >
														<strong style="color:#D9534F;">Name   : '.$appointment[$i]['pre_name'].$appointment[$i]['tar_name'].'</strong><br />
														Mobile : '.$appointment[$i]['phone'].'<br />
														Email   : '.$appointment[$i]['email'].'
													</td>
												</tr>
											</table>
											</div>
										</div>	';


											echo '
														<!--Table Details of appointment history -->
															<div class="panel-body" >
																<table class="table table-bordered table-hover" style="cursor:pointer;">
																	<thead>
																			<tr>
																				<div class="form-group">
																					<span class="manditory"></span>
																						<div class="row">
																							<div class="col-lg-6">
																							</div>
																						</div>
																				</div><!--/.form grup-->
																			</tr>
																			<tr>
																				<th>App Date</th>
																				<th>Time</th>
																				<th>Treatment plan</th>
																			</tr>
							  									</thead>
															<tbody>
							';
					$query = "SELECT a.`id`,
					a.`patientid`,
					a.`date` AS appointment_date,
					a.`from`,
					a.`des`,
					b.`pre_name`,
					b.`tar_name`,
					b.`address`,
					b.`email`,
					b.`phone`,
                                        CASE WHEN (c.img_url IS NULL OR c.img_url ='')
                                            THEN 'NOT PROVIDED'
                                            ELSE
                                            c.img_url END AS img_url
                    			FROM `appointment` AS a
                                        LEFT JOIN `target` AS b ON a.`patientid` = b.`id`
                                        LEFT JOIN `profile_image` AS c ON c.`tar_id` = a.`patientid`
					WHERE
					a.`status_id` = '4' AND a.`patientid` = '".$id."' AND	a.`date` <= '".$dt."'
					ORDER BY a.`date`,a.`from` ASC";

				$res =  executeQuery($query);
				if(mysql_num_rows($res)){
					$index = 0;
					while( $row = mysql_fetch_assoc($res) ){

						$appointment[$index]['id'] = $row['id'];
						$appointment[$index]['patientid'] = $row['patientid'];
						$appointment[$index]['appointment_date'] = $row['appointment_date'];
						$appointment[$index]['from'] = $row['from'];
						$appointment[$index]['des'] = $row['des'];
						$appointment[$index]['address'] = $row['address'];
						$appointment[$index]['email'] = $row['email'];
						$appointment[$index]['phone'] = $row['phone'];
						$appointment[$index]['pre_name'] = $row['pre_name'];
						$appointment[$index]['tar_name'] = $row['tar_name'];
						$appointment[$index]['img_url'] = $row['img_url'];
						$index++;

						echo '<tr>
								<td>
									'.date('d-m-Y',strtotime($row['appointment_date'])).'

								</td>
								<td>
									<strong style="color:#D9534F;">'.date('g:i a',strtotime($row['from'])).'</strong>
								</td>
								<td >
									'.$row['des'].'
								</td>
							</tr>';

						}
						echo '		</table>
       							  </div>

						   </div>
						</div>';
				}
				else{
						$appointment = NULL;
					}
					exit(0);
				 }
			  }
			}
				//End of history

				else{
					echo 'Error!!!';
				}

			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
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
	function UpdateAppointment(){
		$appointment = $_SESSION['appointment'];
		$end = sizeof($appointment);
			for($i=0;$i< $end;$i++){
				$appointment_id=$appointment[$i]['id'];
				$mobile = $appointment[$i]['phone'];
				$id = $appointment[$i]['patientid'];
			}
		$towards= $_POST['towards'];
		$date = date( "Y-m-d",strtotime($_POST['date']) );
		$from = $_POST['from'];

		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "UPDATE `appointment` SET
				`date`='".mysql_real_escape_string($date)."',
				`from`='".mysql_real_escape_string($from)."',
				`des`='".mysql_real_escape_string($towards)."'
				WHERE
				`id`='".mysql_real_escape_string($appointment_id)."' ;
				";
				$res = executeQuery($query);
				if($res){
					echo 'Updated Appointment Successfully';
						$query1=" SELECT settings.sms_status, status.statu_name FROM settings LEFT JOIN status ON settings.sms_status=status.id ;";
							$res1=executeQuery($query1);
							while($row=mysql_fetch_object($res1))
								$sms_status = $row->statu_name;
								        if($sms_status == 'on' ){
                                            $msg = 'Hi '.$name.', your appointment is succesfully scheduled on '.date('d-m-Y',strtotime($date)).' at '.$from.'('.ORGNAME.')';

                                            $sms_para = array(
                                                                    "tar_id"    => $id,
                                                                    "msg"       => $msg,
                                                                    "number"	=> $mobile
                                                            );
                                            SendSms($sms_para);
                                        }
				}
				else{
					echo 0;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function MakeReceipt(){
		$pre_name= $_POST['pre_name'];
		$name= strtolower($_POST['name']);
		$user_type= $_POST['user_type'];
		$email= $_POST['email'];
		$mobile= $_POST['mobile'];
		$towards= $_POST['towards'];
		$org_date = $_POST['date'];
		$date_temp = explode("-",$_POST['date']);
		$date = $date_temp[2].'-'.$date_temp[1].'-'.$date_temp[0];
		$from = $_POST['from'];
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
					(`pre_name`, `tar_name`,`email`,`phone`,`user_type`, `date` )
					VALUES
					( '".mysql_real_escape_string($pre_name)."',
					'".mysql_real_escape_string($name)."',
					'".mysql_real_escape_string($email)."',
					'".mysql_real_escape_string($mobile)."',
					'".mysql_real_escape_string($user_type)."',
					NOW() ); ";
					$res = executeQuery($query);
					$tar_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
				}
				if($res){
					$query1 = "INSERT INTO `appointment`
					(`patientid`, `date`, `from`, `des`, `status_id`)
					VALUES
					('".$tar_id."',
					'".mysql_real_escape_string($date)."',
					'".mysql_real_escape_string($from)."',
					'".mysql_real_escape_string($towards)."',
					'".mysql_real_escape_string('4')."'
					 ); ";
					$res1 = executeQuery($query1);
					if($res1){
						echo '<h1 align="center">Appointment Fixed Successfully</h1>';
						executeQuery("COMMIT");
						$query1=" SELECT settings.sms_status, status.statu_name FROM settings LEFT JOIN status ON settings.sms_status=status.id ;";
							$res1=executeQuery($query1);
							while($row=mysql_fetch_object($res1))
								$sms_status = $row->statu_name;
						if($sms_status == 'on'){
                                                    $msg = 'Hi '.$name.', your appointment is succesfully scheduled on '.date('d-m-Y',strtotime($date)).' at '.$from.'('.ORGNAME.')';

                                                    $sms_para = array(
                                                                            "tar_id"    => $tar_id,
                                                                            "msg"       => $msg,
                                                                            "number"	=> $mobile
                                                                    );
                                                    SendSms($sms_para);
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
	function DisReceipts(){
		$targets = $_SESSION['targets'];
		$i = 0;
		$tar_names_arr = '';

		//Search by name,mobile and email information
		$tar_names_arr = '';
		while($i < sizeof($targets)){
			if($i == 0)
				$tar_names_arr = '"'.$targets[$i]['tar_name'].' - '.$targets[$i]['phone'].' - '.$targets[$i]['email'].'"';
			else
				$tar_names_arr .= ',"'.$targets[$i]['tar_name'].' - '.$targets[$i]['phone'].' - '.$targets[$i]['email'].'"';
			$i++;
		}





		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$src_ac_opt = GetSrcAccount();
				$rec_no = FecthRecNo();
				}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		$timing = '<select id="hh" onchange="caltime();">';
		for($i=1;$i<13;$i++) $timing .= '<option value="'.$i.'" >'.$i.'</option>';
		$timing .= '</select>';
		$timing .= ' : <select id="mm"  onchange="caltime();">';
		$timing .= '<option value="00" >00</option><option value="15" >15</option><option value="30" >30</option><option value="45" >45</option>';
		$timing .= '</select>';
		$timing .= '<select id="meridiem"  onchange="caltime();">';
		$timing .= '<option value="AM" >AM</option><option value="PM" >PM</option>';
		$timing .= '</select>';

		echo '<div class="col-md-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                           Create Appointment
                        </div>
                        <div class="panel-body">
							<form role="form">


									<div class="row">
											  <div class="col-lg-2">
												<div class="form-group">
													<span class="manditory">*</span>
													<label>Patient Name</label>
													<select id="pre_name" class="form-control" onchange="javascript:show_pre_div(this);">
														<option value="Mr." selected>Mr</option>
														<option value="Mrs.">Mrs</option>
														<option value="Miss.">Miss</option>
														<option value="Dr.">Dr</option>
														<option value="The ">The</option>
													</select>
												</div>
											  </div><!-- /.col-lg-6 -->
											  <div class="col-lg-4">
												<div class="form-group">
												<span class="manditory">*</span>
													<label class="manditory"> Name</label>
													<input id="name" name="name" type="text" class="form-control" onblur="javascript:auto_fill(this.value);" placeholder="Name">
													<script>
														$(function(){
															var availableTags = ['.$tar_names_arr.'];
															$( "#name" ).autocomplete({
																source: availableTags
															});
														});
													</script>
												</div>
											  </div><!-- /.col-lg-6 -->

										<span class="text-danger" id="err_name">Invalid</span>
										 <div class="col-lg-3">
											<div class="form-group">
											<span class="manditory">*</span>
												<label class="manditory">Date of appointment: </label><br/>
												<i class="fa fa-calendar fa-2x"></i>
													<input type="text" id="date" value="'.date("d-m-Y").'" readonly>
														<script type="text/javascript">
															$("#date").datepicker({ dateFormat: "dd-mm-yy",changeYear : true,
                                                                                                   changeMonth : true, });
														</script>
											</div>
										 </div>
											 <div class="col-lg-3">
											 <div class="form-group">
												<span class="manditory">*</span>
												<label class="manditory">Select Time: </label><br/>
													<i class="fa fa-clock-o fa-2x"></i>
														'.$timing.'
															<input type="hidden" id="from" class="form-control" readonly>
														<span class="text-danger" id="err_from">Invalid</span>
											  </div>
											</div>
									 </div>

											<div class="form-group" style="display:none;">
													<label>User Type</label>
													<select id="user_type" class="form-control">
														<option value="1" >Doctor</option>
														<option value="2" selected>Patient</option>
														<option value="3">Others</option>
													</select>
											</div>

								<div id="user_details" style="display:none;">
									<div class="row">
								 		<div class="col-lg-6">
											<div class="form-group">
												<label>Email Id</label>
												<input id="email" type="text" class="form-control"  placeholder="abc@email.com" pattern="^.+@.+$">
												<span class="text-danger" id="err_email">Invalid</span>
											</div>
										</div>
								 		<div class="col-lg-6">
											<div class="form-group">
												<label>Mobile Number</label>
												<input id="mobile" type="text" maxlength="10" onkeyDown="javascript:number_allow();" class="form-control" placeholder="9900000000">
												<span class="text-danger" id="err_mobile">Invalid</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Treatment Plan:</label>
										<textarea id="for" class="form-control" rows="3"  placeholder="100 character description"></textarea>
									</div>

									<button id="make_receipt_btn" onclick="javasript:make_receipt();" type="button" class="btn btn-danger form-control">Save Changes</button>
								</div>
							</form>
                        </div>
                    </div>
                </div>';
	}
	function FecthRecNo(){
		$yy = date("Y");
		$mm = date("m");
		$sl_no = ($mm < 4) ? "FY".($yy -1)."R" :  "FY".($yy)."R";
				$query = "SELECT * FROM `receipt` ORDER BY `id` DESC LIMIT 1; ";
				$res = executeQuery($query);
				if(mysql_num_rows($res) > 0){
					while( $row = mysql_fetch_assoc($res)){
						$temp = explode("-",$row['rec_no']);
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
		$result = '<option value="0">Cash</option>';
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
	function DisAllReceipts($val){
		$parameters = $val;
		$num_posts = 0;
		if(isset($_SESSION['appointment']) && $_SESSION['appointment']!= NULL)
			$appointment = $_SESSION['appointment'];
		else
			$appointment = NULL;
		if($appointment != NULL)
			$num_posts = sizeof($appointment);
		$appointment = $_SESSION['appointment'];
		$end = sizeof($appointment);

		//Serach the appointment by name,mobile and email
		$total_appointment='';
		$a=0;
		while($a < sizeof($appointment)){

			if($a == 0)
				$total_appointment = '"'.$appointment[$a]['tar_name'].' - '.$appointment[$a]['phone'].' - '.$appointment[$a]['email'].'"';
			else
				$total_appointment .= ',"'.$appointment[$a]['tar_name'].' - '.$appointment[$a]['phone'].' - '.$appointment[$a]['email'].'"';
			$a++;
		}

		$total_rec1='';
		$b=0;
		while($b < sizeof($appointment)){

			if($b == 0)
				$total_rec1 = '"'.$appointment[$b]['phone'].'"';
			else
				$total_rec1 .= ',"'.$appointment[$b]['phone'].'"';
			$b++;
		}

		$total_rec_email='';
		$b=0;
		while($b < sizeof($appointment)){

			if($b == 0)
				$total_rec_email = '"'.$appointment[$b]['email'].'"';
			else
				$total_rec_email .= ',"'.$appointment[$b]['email'].'"';
			$b++;
		}




		$end = sizeof($appointment);

			echo '
				<div class="row">
					<div class="col-md-12">
							<div class="col-md-4">
									<input id="name1" type="text" onKeyDown="javascript:if(event.keyCode==13 || event.keyCode==9)search_receipt_name(this.value);" class="form-control"   placeholder="Name/Mobile/Email">
							</div>

						<div class="col-md-4">
							<i class="fa fa-calendar fa-2x"></i>
						 <input type="text" id="date"  value="'.date("d-m-Y").'" onchange="javascript:date_rec(this.value);" readonly>

								<script type="text/javascript">
									var dateToday=new Date();
									$("#date").datepicker({ dateFormat: "yy-mm-dd",minDate:dateToday,changeYear : true,
                                                                                                   changeMonth : true, });
								</script>
						</div>



						<!-- <div class="col-md-3">
							<button class="btn btn-danger" onclick="javascript:date_rec();">
								date
							</button>
						</div> -->



					<div class="col-md-2">
						<button class="btn btn-danger" onclick="javascript:view_all_receipts();">
							<i class="fa fa-refresh"></i>
				 		Refresh
						</button>
					</div>

					</div>
				</div>


					<script>
						$(function() {
						var availableTags = ['.$total_appointment.'];
						$( "#name1" ).autocomplete({
						source: availableTags,

						});
						var availableTags1 = ['.$total_rec1.'];
						$( "#mobile" ).autocomplete({
						source: availableTags1,
						});
						var availableTags1 = ['.$total_rec_email.'];
						$( "#email" ).autocomplete({
						source: availableTags1,

						});
					});
				</script>

				<br/>	';

			//End

		$appointment[-1]['appointment_date'] = NULL;//initailize only to match with the previous dates.
		echo '<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
							List Appointment
                        </div>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>
												Profile
											</th>
											<th>
												Name/Details
											</th>
											<th>
												Date and Time
											</th>
											<th>
												Treatment Plan
											</th>
											<th>
												Critical Action
											</th>
										</tr>
									</thead>
									<tbody>';
			if($num_posts > 0){
				for($i=$parameters["initial"];$i<=$parameters["final"] && $i < $num_posts;$i++){

					if( $appointment[$i]['appointment_date'] != $appointment[($i)-1]['appointment_date']){
						echo '<tr>
								<td colspan="5">
									<h3>'.date('d-m-Y',strtotime($appointment[$i]['appointment_date'])).'</label></h3>
								</td>
							  </tr>';
					}
					else{
						}
					$src_img = ($appointment[$i]['img_url'] == "NOT PROVIDED")? PROFILE_IMG : $appointment[$i]['img_url'];

					echo '<tr>
								<td rowspan="2">
										<img src="'.$src_img.'" height="100">
                                </td>
								<td rowspan="2">
										<strong style="color:#D9534F;">Name   : '.$appointment[$i]['pre_name'].$appointment[$i]['tar_name'].'</strong><br />
										Mobile : '.$appointment[$i]['phone'].'<br />
										Email  : '.$appointment[$i]['email'].'
								</td>
								<td rowspan="2">
										<strong style="color:#D9534F;">'.date('g:i a',strtotime($appointment[$i]['from'])).'</strong>
								</td>
								<td rowspan="2">
										'.$appointment[$i]['des'].'
								</td>
								<td>
										<button class="btn btn-info" name="'.date('Y-m-d',strtotime($appointment[$i]['appointment_date'])).'" onclick="javasript:critical_action('.$appointment[$i]['patientid'].',\'history\',this.name);">
											<i class="fa fa-pencil"></i>
											Appointment History
										</button>
								</td>
						</tr>
						<tr>
								<td>
										<button class="btn btn-primary" onclick="javasript:critical_action('.$appointment[$i]['id'].',\'edit\');">
											<i class="fa fa-edit"></i>
											Edit
										</button>
										<button class="btn btn-danger" onclick="javasript:critical_action('.$appointment[$i]['id'].',\'delete\');">
											<i class="fa fa-trash"></i>
											Delete
										</button>
								</td>
						</tr>';
					}
				}
				else {
					echo '					</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>';
            echo '<strong><h3 style="color:red;">No Result Found!!!!!!!!!!!!!!</h3></strong>';

        }
	}

	function DisAllReceiptsAppend($val){
		$parameters = $val;
		$num_posts = 0;
		if(isset($_SESSION['appointment']) && $_SESSION['appointment']!= NULL)
			$appointment = $_SESSION['appointment'];
		else
			$appointment = NULL;
		if($appointment != NULL)
				$num_posts = sizeof($appointment);

		$appointment = $_SESSION['appointment'];
		$end = sizeof($appointment);
		$appointment[-1]['appointment_date'] = NULL;//initailize only to match with the previous dates.




			echo '<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
							List Appointment
                        </div>
                        <div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>
										Profile
									</th>
									<th>
										Name/Details
									</th>
									<th>
										Date and Time
									</th>
									<th>
										Treatment Plan
									</th>
									<th>
										Critical Action
									</th>
								</tr>
							</thead>
							<tbody>
								';


		//for($i=0;$i< $end;$i++){
			if($num_posts > 0){
				for($i=$parameters["initial"];$i<=$parameters["final"] && $i < $num_posts;$i++){

			if( $appointment[$i]['appointment_date'] != $appointment[($i)-1]['appointment_date']){
				echo '<tr>
					<td colspan="5">
						<h3>'.date('d-m-Y',strtotime($appointment[$i]['appointment_date'])).'</label></h3>
					</td>
				</tr>';
			}
			else{
			}


			$src_img = ($appointment[$i]['img_url'] == "NOT PROVIDED")? PROFILE_IMG : $appointment[$i]['img_url'];

			echo '			<tr>
                                    <td rowspan="2">
                                        <img src="'.$src_img.'" height="100">
                                    </td>
												<td rowspan="2">
														<strong style="color:#D9534F;">Name   : '.$appointment[$i]['pre_name'].$appointment[$i]['tar_name'].'</strong><br />
														Mobile : '.$appointment[$i]['phone'].'<br />
														Email  : '.$appointment[$i]['email'].'
												</td>
												<td rowspan="2">
														<strong style="color:#D9534F;">'.date('g:i a',strtotime($appointment[$i]['from'])).'</strong>
									</td>
									<td rowspan="2">
										'.$appointment[$i]['des'].'
									</td>
									<td>
											<button class="btn btn-info" name="'.date('Y-m-d',strtotime($appointment[$i]['appointment_date'])).'" onclick="javasript:critical_action('.$appointment[$i]['patientid'].',\'history\',this.name);">
												<i class="fa fa-pencil"></i>
												Appointment History
											</button>
									</td>
							</tr>
							<tr>
									<td>
											<button class="btn btn-primary" onclick="javasript:critical_action('.$appointment[$i]['id'].',\'edit\');">
												<i class="fa fa-edit"></i>
												 Edit
											</button>
											<button class="btn btn-danger" onclick="javasript:critical_action('.$appointment[$i]['id'].',\'delete\');">
												<i class="fa fa-pencil"></i>
												 Delete
											</button>
									</td>
							</tr>';
           }
		}
		else {
		echo '					</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>';
            echo '<strong><h3 style="color:red;">No Result Found!!!!!!!!!!!!!!</h3></strong>';

        }
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
	function LoadAllAppointment(){
		$appointment = array();
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					if(isset($_POST["name"])){
                                    $name=explode("-",$_POST["name"] );
                                    $sub_query = ' AND 	(
                                        b.`tar_name` LIKE "%'.trim($name[0]).'%"
                                        OR
                                        b.`phone` LIKE "%'.trim($name[0]).'%"
                                        OR
                                        b.`email` LIKE "%'.trim($name[0]).'%"
										)';
            	}
				else if(isset($_POST["date_app"])){
                                    $dt=$_POST["date_app"];
                                    $sub_query = ' AND 	(
                                        a.`date` LIKE "%'.trim($dt).'%"
                                        )';
                }
				else {
                                    $sub_query = "";
                                }
				$query = "SELECT a.`id`,
					a.`patientid`,
					a.`date` AS appointment_date,
					a.`from`,
					a.`des`,
					b.`pre_name`,
					b.`tar_name`,
					b.`address`,
					b.`email`,
					b.`phone`,
                                        CASE WHEN (c.img_url IS NULL OR c.img_url ='')
                                            THEN 'NOT PROVIDED'
                                            ELSE
                                            c.img_url END AS img_url
                    			FROM `appointment` AS a
										LEFT JOIN `profile_image` AS c ON c.`tar_id` = a.`patientid`
                                        LEFT JOIN `target` AS b ON a.`patientid` = b.`id`

					WHERE
					a.`status_id` = '4'
					AND (  a.`date` = CURDATE() OR a.`date` > CURDATE() ) ".$sub_query."
					ORDER BY a.`date` ASC";
				$res =  executeQuery($query);

				if(mysql_num_rows($res)){
					$index = 0;
					while( $row = mysql_fetch_assoc($res) ){
						$appointment[$index]['id'] = $row['id'];
						$appointment[$index]['patientid'] = $row['patientid'];
						$appointment[$index]['appointment_date'] = $row['appointment_date'];
						$appointment[$index]['from'] = $row['from'];
						$appointment[$index]['des'] = $row['des'];
						$appointment[$index]['address'] = $row['address'];
						$appointment[$index]['email'] = $row['email'];
						$appointment[$index]['phone'] = $row['phone'];
						$appointment[$index]['pre_name'] = $row['pre_name'];
						$appointment[$index]['tar_name'] = $row['tar_name'];
						$appointment[$index]['img_url'] = $row['img_url'];
						$index++;
					}
				}
				else{
					$appointment = NULL;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		return $appointment;
	}
	main();
?>
<?php include_once(DOC_ROOT.PHP.INC."header.php"); ?>

<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="btn-group btn-group-justified">
		  <div class="btn-group">
			<button type="button" class="btn btn-warning btn-lg" onclick="javascript:dis_receipts('create')">Create Appointment</button>
		  </div>
		  <div class="btn-group">
			<button type="button" class="btn btn-info btn-lg" onclick="javascript: dis_receipts_scroll('view')">view Appointment</button>
		  </div>
		</div>
		<hr />
		<div id="rec_screen">

			<!--Display the dis_rec_scroll_append  -->
		<div id="rec_screen_app">

		</div>
	</div>
	 <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php include_once(DOC_ROOT.PHP.INC."footer.php"); ?>
<script src="<?php echo URL.ASSET_JS.DENTAL; ?>appointment.js"></script>
<script>
		$("#app_nav").addClass("active-menu");

</script>
