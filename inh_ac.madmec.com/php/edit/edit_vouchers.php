<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		if(isset($_POST['action']) && $_POST['action'] == 'show_edit_voucher'){
			show_edit_voucher();
			unset($_POST);
			exit(0);
		}	
		elseif(isset($_POST['action']) && $_POST['action'] == 'update_payment'){
			UpdatePayment();
			unset($_POST);
			exit(0);
		}
	}
	function UpdatePayment(){
		$val = $_POST['val'];
		$src_ac = $_POST['src_ac'];
		$target_id = $_POST['target_id'];
		$payment_id = $_POST['payment_id'];
		$ser_no = $_POST['ser_no'];
		$voc_loc= $_POST['voc_loc'];
		$date= $_POST['alt_date'];
		$pre_name= $_POST['pre_name'];
		$tar_name= $_POST['name'];
		$loc= $_POST['loc'];
		$email= $_POST['email'];
		$mobile= $_POST['mobile'];
		$cheque_no= $_POST['cheque_no'];
		$amount= $_POST['amount'];
		$towards= $_POST['towards'];
		$org_date = $_POST['date'];
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				executeQuery("SET AUTOCOMMIT=0;");
				executeQuery("START TRANSACTION;");
					$query = "UPDATE `target` SET 
					`address`='".mysql_real_escape_string($loc)."',
					`email`='".mysql_real_escape_string($email)."',
					`phone`='".mysql_real_escape_string($mobile)."' 
					WHERE `id` = '".$target_id."'
					; ";
					$res = executeQuery($query);
				if($res){
					$query1 = "UPDATE `payments` SET
					`cheque_no` = '".mysql_real_escape_string($cheque_no)."',
					`amount` = '".mysql_real_escape_string($amount)."',
					`towards` = '".mysql_real_escape_string($towards)."',
					`date` = '".mysql_real_escape_string($date)."' ,
                                        `source_id` ='".mysql_real_escape_string($src_ac)."' 
					WHERE `id` = '".$payment_id."'; ";
					$res1 = executeQuery($query1);
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
											"tar_name" 	=> $tar_name,
											"cheque_no" => $cheque_no,
											"towards" 	=> $towards,
											"bank_name" => $bank_name,
											"amount" 	=> moneyFormatIndia($amount),
											"amount_words" 	=> no_to_words($amount)
										);
							$voucher = generateVoucher($receipt);
							$file = explode("/",$voc_loc);
								$file_name = DOC_ROOT.ASSET_VOU.$file[sizeof($file)-1] ;
								$file_link = $voc_loc;
							$fh = fopen($file_name, 'w');
							fwrite($fh, $voucher);
							fclose($fh);
							echo '<a href="'.$file_link.'" class="btn btn-danger square-btn-adjust" target="_blank">Print Vocuher</a><br /><br />'.$voucher.'';
							
						
					
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
	function show_edit_voucher(){
		$voucher = ARRAY();
		$index = base64_decode($_GET['id']);
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT a.*,
				b.`pay_type`,
				b.`source_id`,
				b.`cheque_no`,
				b.`amount`,
				b.`date`,
				b.`towards`,
				b.`target_id`,
				c.`pre_name`,
				c.`tar_name`,
				c.`address`,
				c.`email`,
				c.`phone`
				FROM 
				`voucher` AS a JOIN `payments` AS b ON a.`payment_id` = b.`id`
				JOIN `target`AS c on b.`target_id` = c.`id` 
                WHERE a.`id` = '".$index."'; 
                ";
				$res =  executeQuery($query);
				if(mysql_num_rows($res)){
					$voucher = mysql_fetch_assoc($res);
				}
				else{
					$voucher = NULL;
				}
			}
		}
		$src_ac_opt = GetSrcAccount();
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		$temp1 = explode(" ",$voucher['date']);
		$temp = explode("-",$temp1[0]);
		$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
		if($voucher['pay_type'] == 'cheque'){
			$color = 'danger';
			$voc_type = 'Cheque Voucher';
			$src_ac = '';
			$cheque_no = '';
		}
		else{
			$color = 'success';
			$voc_type = 'Cash Voucher';
			$src_ac = 'style="display:none;"';
			$cheque_no = 'style="display:none;"';
		}
		echo '<div class="col-md-12">
                    <div class="panel panel-'.$color.'">
                        <div class="panel-body">
							<form role="form">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                            <label>serial Number : </label>
                                                                            <input type="hidden" id="val" class="form-control" value="'.$voucher['pay_type'].'" readonly>
                                                                            <input type="hidden" id="target_id" class="form-control" value="'.$voucher['target_id'].'" readonly>
                                                                            <input type="hidden" id="payment_id" class="form-control" value="'.$voucher['payment_id'].'" readonly>
                                                                            <input type="text" id="ser_no" class="form-control" value="'.$voucher['sl_no'].'" readonly>
                                                                            <input type="hidden" id="voc_loc" class="form-control" value="'.$voucher['location'].'" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
									<label>Date of Receipt: </label>
										<input type="text" id="date" class="form-control" value="'.$date.'" >
										<input type="hidden" id="alt-date" class="form-control" value="'.date('Y-m-d',  strtotime($voucher['date']) ).'" >
										<script type="text/javascript">           
											$("#date").datepicker({ 
												dateFormat: "dd-mm-yy",
												altField: "#alt-date",
												altFormat : "yy-mm-dd"
											});        
										</script>    
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
								    <div class="form-group" >
                                                                            <label>Source Account :</label>
                                                                                    <select id="src_ac" class="form-control" onchange="javascript:show_mop_opt(this);">
                                                                                            '.$src_ac_opt.'
                                                                                    </select>
                                                                                    <script>
                                                                                        $("#src_ac").val("'.$voucher['source_id'].'");
                                                                                    </script>
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
                                                                                <input id="cheque_no" type="text" class="form-control"  placeholder="999999" value="'.$voucher['cheque_no'].'">
                                                                            </div>
                                                                            <span class="text-danger" id="err_cheque_no">Invalid</span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- row -->
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <span class="manditory">*</span>
                                                                    <label>Received from</label>
                                                                    <input id="pre" type="text" class="form-control" placeholder="Name" value="'.$voucher['pre_name'].'" readonly>
											
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <span class="manditory">*</span>
                                                                    <label>Name</label>
                                                                    <input id="name" type="text" class="form-control" placeholder="Name" value="'.$voucher['tar_name'].'" readonly>
                                                                    <span class="text-danger" id="err_name">Invalid</span>
											
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
									<span class="manditory">*</span>
									<label>Sum of Rupees</label>
									<div class="form-group input-group">
										<span class="input-group-addon">
											<i class="fa fa-inr"></i>
										</span>
										<input id="amount" type="text" class="form-control"  placeholder="9999.99" value="'.$voucher['amount'].'">
									</div>
									<span class="text-danger" id="err_amount">Invalid</span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- row -->
                                                               
								
								<div class="form-group" style="display:none;">
									<label>Email Id</label>
									<input id="email" type="text" class="form-control"  value="'.$voucher['email'].'" placeholder="abc@email.com" pattern="^.+@.+$">
									<span class="text-danger" id="err_email">Invalid</span>
								</div>
								
								<div class="form-group"  style="display:none;">
									<label>Mobile Number</label>
									<input id="mobile" type="text" maxlength="10" onkeyDown="javascript:number_allow();" class="form-control" value="'.$voucher['phone'].'" placeholder="9900000000">
									<span class="text-danger" id="err_mobile">Invalid</span>
								</div>
								
								<div class="form-group" style="display:none;">
									<span class="manditory">*</span>
									<label id="res_at">Residing at</label>
									<label id="hq_at">Head-quartered at</label>
										<input id="loc" type="text" class="form-control"  placeholder="type Location"  value="'.$voucher['address'].'">
									<span class="text-danger" id="err_loc">Invalid</span>
								</div>

								
								
								
								<div class="form-group">
									<label>Towards :</label>
									<textarea id="towards" class="form-control" rows="3"  placeholder="100 character description">'.$voucher['towards'].'</textarea>
								</div>
								
								<button id="make_payment_btn" onclick="javasript:update_payment();" type="button" class="btn btn-danger form-control">Save Changes</button>
							</form>
                        </div>
                    </div>
                </div>';
        
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
	main();
?>
<?php include_once(DOC_ROOT.PHP.INC."header.php"); ?>
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
	<div id="page-inner">
		<h1>
			Edit Voucher 
		</h1>
		<div id="show_edit_voucher">
			Loading...
										
		</div>
	</div>
	 <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php include_once(DOC_ROOT.PHP.INC."footer.php"); ?>      
<script src="<?php echo URL.ASSET_JS; ?>edit_vouchers.js"></script> 
