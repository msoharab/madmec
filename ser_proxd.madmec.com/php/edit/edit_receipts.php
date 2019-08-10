<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		if(isset($_POST['action']) && $_POST['action'] == 'show_edit_receipt'){
			show_edit_receipt();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'update_receipt'){
			UpdateReceipt();
			unset($_POST);
			exit(0);
		}
	}
	function UpdateReceipt(){
		$target_id = $_POST['target_id'];
		$income_id = $_POST['income_id'];
		$rec_no = $_POST['rec_no'];
		$rec_loc= $_POST['rec_loc'];
		$alt_date= $_POST['alt_date'];
		$pre_name= $_POST['pre_name'];
		$tar_name= $_POST['tar_name'];
		$loc= $_POST['loc'];
		$email= $_POST['email'];
		$mobile= $_POST['mobile'];
		$don_type= $_POST['mop_by'];
		$mode= $_POST['mode'];
		$number= $_POST['number'];
		$amount= $_POST['amount'];
		$bank = $_POST['bank'];
		$branch_of= $_POST['branch_of'];
		$towards= $_POST['des'];
		$org_date = $_POST['date'];
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				executeQuery("SET AUTOCOMMIT=0;");
				executeQuery("START TRANSACTION;");
					$set_query="SELECT * FROM `settings` WHERE `admin_id`='1' LIMIT 1";
				$result=executeQuery($set_query);
				if(mysql_num_rows($result)){
					while($row=mysql_fetch_assoc($result))
						 $data[]=$row;

					  $doctor_name=$data['doctor_name'];
					  $clinic_name=$data['clinic_name'];
					  $clinic_address=$data['clinic_address'];
			}
					$query = "UPDATE `target` SET
					`address`='".mysql_real_escape_string($loc)."',
					`email`='".mysql_real_escape_string($email)."',
					`phone`='".mysql_real_escape_string($mobile)."'
					WHERE `id` = '".$target_id."'
					; ";
					$res = executeQuery($query);

				if($res){
					$query1 = "UPDATE `income` SET
					`amount` = '".mysql_real_escape_string($amount)."',
					`for` = '".mysql_real_escape_string($towards)."'
					WHERE `id` = '".$income_id."'
					; ";
					$res1 = executeQuery($query1);
						if($res1){
							if( $don_type == 'cheque' ){
								$query3 = "UPDATE `cheuqe` SET
								`cq_no` = '".mysql_real_escape_string($number)."',
								`branch` = '".mysql_real_escape_string($branch_of)."',
								`bank` = '".mysql_real_escape_string($bank)."'
								WHERE `id` = '".$income_id."';
								";
								$res3 = executeQuery($query3);
							}
							else if( $don_type == 'dd' ){
								$query3 = "UPDATE `dd` SET
								`cq_no` = '".mysql_real_escape_string($number)."',
								`branch` = '".mysql_real_escape_string($branch_of)."',
								`bank` = '".mysql_real_escape_string($bank)."'
								WHERE `id` = '".$income_id."';
								";
								$res3 = executeQuery($query3);
							}
							else if( $don_type == 'transfer' ){
								$query3 = "UPDATE `transfer` SET
								`cq_no` = '".mysql_real_escape_string($number)."',
								`branch` = '".mysql_real_escape_string($branch_of)."',
								`bank` = '".mysql_real_escape_string($bank)."',
								`mode` = '".mysql_real_escape_string($mode)."'
								WHERE `id` = '".$income_id."';
								";
								$res3 = executeQuery($query3);
							}

							executeQuery("COMMIT");
							$receipt = array(
											"css" 		=> "<link href='".URL.ASSET_DIR."font-awesome-4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css' />",
											"img_url" 	=> URL.ASSET_IMG."receipt_bg.png",
											"doctor_name" => $doctor_name,
											"clinic_name" =>$clinic_name,
											"clinic_address" => $clinic_address,
											"rec_no" 	=> $rec_no,
											"date" 		=> $org_date,
											"pre_name" 	=> $pre_name,
											"tar_name" 	=> $tar_name,
											"loc" 		=> $loc,
											"for" 		=> $towards,
											"don_type" 		=> $don_type,
											"number" 	=> $number,
											"branch_of" 	=> $branch_of,
											"bank_name" 	=> $bank,
											"tran_mode" 	=> $mode,
											"amount" 	=> moneyFormatIndia($amount),
											"amount_words" 	=> no_to_words($amount)
										);
							$recp = generateReciept($receipt);
								$file = explode("/",$rec_loc);
								$file_name = DOC_ROOT.ASSET_REC.$file[sizeof($file)-1] ;
								$file_link = $rec_loc;
							$fh = fopen($file_name, 'w');
							fwrite($fh, $recp);
							fclose($fh);
							echo '<a href="'.$file_link.'" class="btn btn-danger square-btn-adjust" target="_blank">Print Reciept</a><br /><br />'.$recp.'';

							//Alert($mailParameters);
							if(SEND_EMAIL == 'on')
								Alert($email,$tar_name,$towards, $recp);
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
	function show_edit_receipt(){
		$receipts = ARRAY();
		$index = base64_decode($_GET['id']);
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT a.*,
				b.`target_id`,
				b.`source_id`,
				b.`don_type`,
				b.`for`,
				b.`amount`,
				b.`date`,
				c.`pre_name`,
				c.`tar_name`,
				c.`address`,
				c.`email`,
				c.`phone`
				FROM
				`receipt` AS a JOIN `income` AS b ON a.`income_id` = b.`id`
				JOIN `target`AS c on b.`target_id` = c.`id`
				WHERE a.`id` = '".$index."'; ";
				$res =  executeQuery($query);

				if(mysql_num_rows($res)){
					$receipts = mysql_fetch_assoc($res);
					if($receipts['don_type'] == 'dd'){
						$query2 = "SELECT `dd_no` AS NUM,`branch`,`bank`,NULL as mode FROM `dd` WHERE `income_id` = '".$receipts['income_id']."' ";
						$row2 = mysql_fetch_assoc(executeQuery($query2));
						$receipts = array_merge($receipts,$row2);
					}
					elseif($receipts['don_type'] == 'cheque'){
						$query2 = "SELECT `cq_no` AS NUM,`branch`,`bank`,NULL as mode  FROM `cheuqe` WHERE `income_id` = '".$receipts['income_id']."' ";
						$row2 = mysql_fetch_assoc(executeQuery($query2));
						$receipts = array_merge($receipts,$row2);
					}
					elseif($receipts['don_type'] == 'transfer'){
						$query2 = "SELECT `tran_no` AS NUM,`branch`,`bank`, `mode`  FROM `transfer` WHERE `income_id` = '".$receipts['income_id']."' ";
						$row2 = mysql_fetch_assoc(executeQuery($query2));
						$receipts = array_merge($receipts,$row2);
					}
					else{
						$row2 = NULL;
					}
				}
				else{
					$receipts = NULL;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		$temp1 = explode(" ",$receipts['date']);
		$temp = explode("-",$temp1[0]);
		$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
		echo '<div class="col-md-12">
			<div class="panel panel-info">
			   <div class="panel-body">
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-body">
								<form role="form">
									<div class="form-group">
										<label>serial Number : </label>
										<input type="hidden" id="target_id" class="form-control" value="'.$receipts['target_id'].'" readonly>
										<input type="hidden" id="income_id" class="form-control" value="'.$receipts['income_id'].'" readonly>
										<input type="text" id="rec_no" class="form-control" value="'.$receipts['rec_no'].'" readonly>
										<input type="hidden" id="rec_loc" class="form-control" value="'.$receipts['rec_location'].'" readonly>
									</div>

									<div class="form-group">
										<label>Date of Receipt: </label>
										<input type="text" id="date" class="form-control" value="'.$date.'" >
										<input type="hidden" id="alt-date" class="form-control" value="'.$receipts['date'].'" >
										<script type="text/javascript">
											$("#date").datepicker({
												dateFormat: "dd-mm-yy",
												altField: "#alt-date",
												altFormat : "yy-mm-dd",
                                                                                                changeMonth : true,
                                                                                                changeYear : true,
											});
										</script>
									</div>

									<div class="form-group">
										<span class="manditory">*</span>
										<label>Received from</label>
										<div class="row">
											<div class="col-lg-6">
												<input id="pre" type="text" class="form-control" placeholder="Name" value="'.$receipts['pre_name'].'" readonly>
											</div><!-- /.col-lg-6 -->
											<div class="col-lg-6">
												<input id="name" type="text" class="form-control" placeholder="Name" value="'.$receipts['tar_name'].'" readonly>
												<span class="text-danger" id="err_name">Invalid</span>
											</div><!-- /.col-lg-6 -->
										</div><!-- /.row -->
									</div>

									<div class="form-group">
										<label>Residing at/Head-quartered at</label>
										<input id="loc" type="text" class="form-control"  placeholder="type Location" value="'.$receipts['address'].'">
										<span class="text-danger" id="err_email">Invalid</span>
									</div>

									<div class="form-group">
										<label>Email Id</label>
										<input id="email" type="text" class="form-control" value="'.$receipts['email'].'"  placeholder="abc@email.com" pattern="^.+@.+$">
										<span class="text-danger" id="err_email">Invalid</span>
									</div>

									<div class="form-group">
										<label>Mobile Number</label>
										<input id="mobile" type="number" value="'.$receipts['phone'].'" class="form-control" placeholder="9900000000">
										<span class="text-danger" id="err_mobile">Invalid</span>
									</div>


									<div class="form-group">
										<span class="manditory">*</span>
										<label>Sum of Rupees</label>
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-inr"></i>
											</span>
											<input id="amount" type="text" class="form-control"  placeholder="9999.99" value="'.$receipts['amount'].'">
										</div>
										<span class="text-danger" id="err_amount">Invalid</span>
									</div>
										<div calss="row" id="mop_opt"  style="display:none;">
											<div class="form-group" id="trans_mode_div" style="display:none;">
												<label>Transfer MODE</label>
												<div class="radio">
													<label>
														<input type="radio" name="tran_mode" id="tran_mode1" value="NEFT" checked=""> NEFT
													</label>
												</div>
												<div class="radio">
													<label>
														<input type="radio" name="tran_mode" id="tran_mode2" value="RTGS" '.(( isset($receipts['mode']) &&  $receipts['mode'] == 'RTGS')? 'checked=""' : '').' > RTGS
													</label>
												</div>
											</div>

											<div class="row form-group" >
												<div class="col-md-4 col-sm-4">
													<span class="manditory">*</span>
													<label id="cheque_div" style="display:none;">Cheque No</label>
													<label id="dd_div" style="display:none;">Demand Draft No</label>
													<label id="transer_div" style="display:none;">Transaction No</label>
													<input id="don_type" type="hidden"  class="form-control"  placeholder="999999" value="'.$receipts['don_type'].'">

													<div class="form-group input-group">
														<span class="input-group-addon">
															<strong>#</strong>
														</span>
														<input id="number" type="number"  class="form-control"  placeholder="999999" value="'.( (isset($receipts['NUM'])) ? $receipts['NUM'] :'').'">
														<span class="text-danger" id="err_number">Invalid</span>
													</div>
												</div>
												<div class="col-md-4 col-sm-4">
													<label>Branch of</label>
													<input type="text" id="branch_of" class="form-control" placeholder="Branch Name" value="'.( (isset($receipts['branch'])) ? $receipts['branch'] :'').'">
												</div>
												<div class="col-md-4 col-sm-4">
													<label>Bank</label>
													<input type="text" id="bank" class="form-control" placeholder="Bank Name" value="'.( (isset($receipts['bank'])) ? $receipts['bank'] :'').'">
												</div>
											</div>
										</div>
									<div class="form-group">
										<label>For :</label>
										<textarea id="for" class="form-control" rows="3"  placeholder="100 character description">'.$receipts['for'].'</textarea>
									</div>

									<button id="make_receipt_btn" onclick="update_receipt();" type="button" class="btn btn-danger form-control">Save Changes</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';
        if($receipts['don_type'] == 'dd'){
			echo '<script>
					$("#mop_opt").show();
					$("#dd_div").show();
			</script>';
		}
		else if($receipts['don_type'] == 'cheque'){
			echo '<script>
					$("#mop_opt").show();
					$("#cheque_div").show();
			</script>';
		}
		else if($receipts['don_type'] == 'transfer'){
			echo '<script>
					$("#mop_opt").show();
					$("#transer_div").show();
					$("#trans_mode_div").show();
			</script>';
		}
	}
	main();
?>
<?php include_once(DOC_ROOT.PHP.INC."header.php"); ?>
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
	<div id="page-inner">
		<h1>
			Edit Receipt
		</h1>
		<div id="show_edit_receipt">
			Loading...

		</div>
	</div>
	 <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php include_once(DOC_ROOT.PHP.INC."footer.php"); ?>
<script src="<?php echo URL.ASSET_JS; ?>edit_receipts.js"></script>
