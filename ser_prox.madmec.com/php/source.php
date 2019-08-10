<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	function main(){
		if(!ValidateAdmin()){
			session_destroy();
			header('Location:'.URL);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'display_src_ac'){
			DisplaySrcAc();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'src_ac_details'){
			SrcAcDetails($_POST['id'],$_POST['ac_name']);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'edit_src_ac'){
			EditSrcAc($_POST['id']);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'update_src_ac'){
			UpdateSrcAc($_POST['id']);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'deactivate_src_ac'){
			DeactivateSrcAc($_POST['id']);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'add_form_src_ac'){
			AddFormSrcAc();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'add_src_ac'){
			AddSrcAc();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'add_balance_entry_form'){
			AddBalanceEntryForm($_POST['id'],$_POST['type']);
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'add_balance_entry'){
			AddBalanceEntry();
			unset($_POST);
			exit(0);
		}
	}
	function AddBalanceEntry(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "INSERT INTO `source_balance`
				( `source_id`, `amount`, `des`, `date`, `action`, `status`) 
				VALUES 
				('".mysql_real_escape_string($_POST['id'])."',
				'".mysql_real_escape_string($_POST['bal_amt'])."',
				'".mysql_real_escape_string($_POST['bal_des'])."',
				NOW(),
				'".mysql_real_escape_string($_POST['type'])."',
				default
				);";
				$res = executeQuery($query);
				if($res){
					echo "succesfully updated.";
				}
				else{
					echo "Error!!! please try again later.";
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);	
	}
	function AddBalanceEntryForm($id,$type){
		echo '<form role="form">
				<div class="form-group">
					<span class="manditory">*</span>
					<label>Amount</label>
					<input id="bal_src_id" class="form-control" type="hidden" value="'.$id.'">
					<input id="bal_action" class="form-control" type="hidden" value="'.$type.'"> 
					<input id="bal_amt" class="form-control" placeholder="9999.99">
					<span class="text-danger" id="err_bal_amt">Invalid</span>
				</div>
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea id="bal_des" class="form-control" rows="3"  placeholder="100 character description"></textarea>
				</div>
				<button  onclick="javasript:add_balance_entry();" type="button" class="btn btn-danger form-control">Save Changes</button>
			</form>';
	}		
	function SrcAcDetails($id,$ac_name){
		$total_pay = '';
		$total_inc = '';
		echo '<h3><a href="javascript:void(0);" onclick="javscript:show_screen1();"><i class="fa fa-arrow-circle-left"></i>Back</a></h3>
				<h2>'.$ac_name.'\'s Account</h2><div class="row"><hr />';
		echo '<div class="col-md-6">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Date</th>
							<th>Towards</th>
							<th><i class="fa fa-plus-square fa-2x" style="color:GREEN;"></i>Income</th>
						</tr>
					</thead>
					<tbody>';
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT a.*,
				b.`source_id`,
				b.`don_type`,
				b.`for`,
				b.`amount`,
				b.`date`
				FROM 
				`receipt` AS a JOIN `income` AS b ON a.`income_id` = b.`id`
				JOIN `target`AS c on b.`target_id` = c.`id`
                                WHERE b.`source_id` = '".$id."'
                                AND 
                                b.`status` = 'show'
                                ORDER BY `id` DESC";
				$res =  executeQuery($query);
				if(mysql_num_rows($res)){
					while( $row = mysql_fetch_assoc($res) ){
						$total_inc += $row['amount'];
						$temp0 = explode(" ",$row['date']);
						$temp = explode("-",$temp0[0]);
						$d_m_y = $temp[2].'-'.$temp[1].'-'.$temp[0];
						$details = '';
						$details .= "<br />By ".$row['don_type']." :";
						$details .= ' (<a href="'.URL.'php/edit/edit_receipts.php?id='.base64_encode($row['id']).'" target="_blank">REC NO. '.$row['rec_no'].' Receipt</a>)';
						echo '<tr>
							<td>
								'.$d_m_y.'
							</td>
							<td>
								'.$row['for'].$details.'
							</td>
							<td align="right">
								'.moneyFormatIndia($row['amount']).'
							</td>
						</tr>';
					}
					echo '<tr><td colspan="2" align="right"><strong>Total</strong></td><td align="right">'.moneyFormatIndia($total_inc).'</td></tr>
							<tr><td colspan="3"><span class="caps">'.no_to_words($total_inc).' Rupees Only.</span></td></tr>';
				}
				else{
					
				}
				echo '</tbody></table></div><!-- col-md-6 -->';
				echo '<div class="col-md-6">
					<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
                                                    <th>Date</th>
                                                    <th>Towards</th>
                                                    <th><i class="fa fa-minus-square fa-2x" style="color:RED;"></i>Payments</th>
						</tr>
					</thead>
					<tbody>';
				$query = "SELECT a.*,
				b.`pay_type`,
				b.`source_id`,
				b.`cheque_no`,
				b.`amount`,
				b.`towards`,
				b.`date`
				FROM 
				`voucher` AS a JOIN `payments` AS b ON a.`payment_id` = b.`id`
				JOIN `target`AS c on b.`target_id` = c.`id`
                                WHERE b.`source_id` = '".$id."'
                                AND 
                                b.`status` = 'show'
                                ORDER BY `id` DESC";
				$res =  executeQuery($query);
				if(mysql_num_rows($res)){
					while( $row = mysql_fetch_assoc($res) ){
						$total_pay += $row['amount'];
						$temp0 = explode(" ",$row['date']);
						$temp = explode("-",$temp0[0]);
						$d_m_y = $temp[2].'-'.$temp[1].'-'.$temp[0];
						$details = '';
						$details .= ($row['pay_type'] == 'cheque') ? "<br />By Cheque :".$row['cheque_no'] : "<br />By Cash";
						$details .= ' (<a href="'.URL.'php/edit/edit_vouchers.php?id='.base64_encode($row['id']).'" target="_blank">SL NO. '.$row['sl_no'].' Voucher</a>)';
						echo '<tr>
							<td>
								'.$d_m_y.'
							</td>
							<td>
								'.$row['towards'].$details.'
							</td>
							<td align="right">
								'.moneyFormatIndia($row['amount']).'
							</td>
						</tr>';
					}
					echo '<tr><td colspan="2" align="right"><strong>Total</strong></td><td align="right">'.moneyFormatIndia($total_pay).'</td></tr>
					<tr><td colspan="3"><span class="caps">'.no_to_words($total_pay).' Rupees Only.</span></td></tr>';
				}
				else{
					
				}
				echo '</tbody></table></div><!-- col-md-6 -->';
				echo '</div><hr /><!-- .row -->';
	
			}
		}
		echo '<div class="row">';
		if($id > 0){
			FecthSrcBal($id,"increment");
			FecthSrcBal($id,"decrement");
		}echo '</div><!-- .row -->';
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		
	}
	function FecthSrcBal($id,$type){
		if($type=="increment"){
			$icon = '<i class="fa fa-plus-square fa-2x" style="color:GREEN;"></i>Income';
		}
		else{
			$icon = '<i class="fa fa-minus-square fa-2x" style="color:RED;"></i>Payments';
		}
		$total = 0;
		echo '<div class="col-md-6">
			<h3>'.$icon.' By Bank</h3>
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Date</th>
							<th>Towards</th>
							<th>'.$icon.'</th>
						</tr>
					</thead>
					<tbody>';
		$query = "SELECT * FROM `source_balance` 
		WHERE `source_id` = '".$id."' 
		AND 
		`action` = '".$type."'";
		$res = executeQuery($query);
				if(mysql_num_rows($res)){
					while( $row = mysql_fetch_assoc($res) ){
						$total += $row['amount'];
						$temp = explode("-",$row['date']);
						$d_m_y = $temp[2].'-'.$temp[1].'-'.$temp[0];
						echo '<tr>
							<td>
								'.$d_m_y.'
							</td>
							<td>
								'.$row['des'].'
							</td>
							<td align="right">
								'.moneyFormatIndia($row['amount']).'
							</td>
						</tr>';
					}
					echo  '<tr><td colspan="2" align="right"><strong>Total</strong></td><td align="right">'.moneyFormatIndia($total).'</td></tr>
							<tr><td colspan="3"><span class="caps">'.no_to_words($total).' Rupees Only.</span></td></tr>';
				}
				else{
					echo '<tr>
							<td colspan="7">No Details to be displayed.</td>
						</tr>';
				}
				echo  '<tr>
						<td colspan="3" align="center">
							<button class="btn btn-danger" onclick="javscript:add_balance_entry_form(\''.$id.'\',\''.$type.'\');">Add Entry</button>
						</td>
					</tr>
				</tbody></table></div>';
	}
	function AddSrcAc(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "INSERT INTO `source`
				(`src_ac_name`, `src_ac_no`, `src_bank`, `src_branch`, `src_ac_type`, `src_pan`, `des`) 
				VALUES 
				('".mysql_real_escape_string($_POST['src_ac_name'])."',
				'".mysql_real_escape_string($_POST['src_ac_no'])."',
				'".mysql_real_escape_string($_POST['src_bank'])."',
				'".mysql_real_escape_string($_POST['src_branch'])."',
				'".mysql_real_escape_string($_POST['src_ac_type'])."',
				'".mysql_real_escape_string($_POST['src_pan'])."',
				'".mysql_real_escape_string($_POST['des'])."' );";
				$res = executeQuery($query);
				echo 1;
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);	
	}
	function AddFormSrcAc(){
		echo '<form role="form">
				<div class="form-group">
					<span class="manditory">*</span>
					<label>Account Number</label>
					<input id="src_ac_no" class="form-control" placeholder="Account Number">
					<span class="text-danger" id="err_src_ac_no">Invalid</span>
				</div>
				<div class="form-group">
					<span class="manditory">*</span>
					<label>Account Name</label>
					<input id="src_ac_name" class="form-control"  placeholder="Account Name">
					<span class="text-danger" id="err_src_ac_name">Invalid</span>
				</div>
				
				<div class="form-group">	
					<span class="manditory">*</span>
					<label class="manditory">Bank</label>
                                        <input id="src_bank" class="form-control" >
				</div>
				
				
				
				
				
				<div class="form-group">
					<span class="manditory">*</span>
					<label>Brance</label>
					<input id="src_branch" class="form-control"  placeholder="Brance">
					<span class="text-danger" id="err_src_branch">Invalid</span>
				</div>
				<div class="form-group">
					<label>PAN</label>
					<input id="src_pan" class="form-control" placeholder="PAN">
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea id="des" class="form-control" rows="3"  placeholder="100 character description"></textarea>
				</div>
				
				<div class="form-group">
					<label>Account Type</label>
					<select id="src_ac_type" class="form-control">
						<option value="saving account" selected>saving account</option>
                        <option value="current account">current account</option>
					</select>
				</div>
				<button  onclick="javasript:add_src_ac();" type="button" class="btn btn-danger form-control">Save Changes</button>
			</form>';
	}	
	function DisplaySrcAc(){
		echo '<table class="table table-striped table-bordered table-hover" style="cursor:pointer;" >
			<thead>
				<tr>
					<th>Account Name</th>
					<th>Account Deatials</th>
					<th>Balance</th>
					<th>Critical Actions</th>
				</tr>
			</thead>
			<tbody>';
			FetchSrcAc();
			echo '<tr>
					<td colspan="7" align="center">
						<a class="btn btn-danger btn-lg" onclick="javascript:add_form_src_ac();" href="javascript:void(0);">
							Add New Account
						</a>
					</td>
				</tr>
			</tbody>
		</table>';
	}
	function FetchSrcAc(){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT * FROM `source` 
				WHERE `status` = 'active'
				ORDER BY `id` DESC; ";
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					while( $row = mysql_fetch_assoc($res))
					echo '<tr>
						<td>'.$row['src_ac_name'].'</td>
						<td>a/c No. : '.$row['src_ac_no'].'<br />
						Bank : '.$row['src_bank'].'<br />
						Brance : '.$row['src_branch'].'<br />
						Account Type : '.$row['src_ac_type'].'<br />
						PAN : '.$row['src_pan'].'</td>
						<td align="right">
							'.FetchBalance($row['id']).'
						</td>
						<td>
							<button class="btn btn-warning"   onclick="javascript:src_ac_details('.$row['id'].',\''.$row['src_ac_name'].'\');">
								<i class="fa fa-bullseye"></i>
								 View
							</button>
							<button class="btn btn-primary"  onclick="javasript:edit_src_ac('.$row['id'].');">
								<i class="fa fa-edit"></i>
								 Edit
							</button>
							<button style="display:none;"class="btn btn-danger" onclick="javasript:deactivate_src_ac('.$row['id'].');">
								<i class="fa fa-pencil"></i>
								 Delete
							</button>
						</td>
					</tr>';
				}
				else{
					echo '<tr>
							<td colspan="7">No Accouts to be displayed,Please add new account.</td>
						</tr>';
				}
				// fecthing cash transactions //
				echo '<tr onclick="javascript:src_ac_details(0,\'Cash\');"r>
						<td>Cash Transactions</td>
						<td>Cash -----</td>
						<td align="right">
							'.FetchBalance(0).'
						</td>
						<td>
							No actions available--
						</td>
					</tr>';
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	function FetchBalance($id){
		/*$query = "SELECT (SELECT SUM(amt) FROM (
		(SELECT SUM(`amount`)AS amt FROM `income` WHERE `source_id` = '".$id."')
		UNION ALL 
		(SELECT SUM(`amount`) AS amt FROM `source_balance` WHERE `source_id` = '".$id."' AND `action` = 'increment') 
		) a )
        -
		(SELECT SUM(amt) FROM (
		(SELECT SUM(`amount`)AS amt FROM `payments` WHERE `source_id` = '".$id."')
		UNION ALL 
		(SELECT SUM(`amount`) AS amt FROM `source_balance` WHERE `source_id` = '".$id."' AND `action` = 'decrement') 
		) s )";*/
		$income = "SELECT SUM(amt) FROM(
		(SELECT SUM(`amount`) AS amt FROM `income` WHERE `source_id` = '".$id."' AND `status` = 'show')
		UNION ALL 
		(SELECT SUM(`amount`) AS amt FROM `source_balance` WHERE `source_id` = '".$id."' AND `action` = 'increment')
		)a ";
		$payments = "SELECT SUM(amt) FROM (
		(SELECT SUM(`amount`)AS amt FROM `payments` WHERE `source_id` = '".$id."' AND `status` = 'show')
		UNION ALL 
		(SELECT SUM(`amount`) AS amt FROM `source_balance` WHERE `source_id` = '".$id."' AND `action` = 'decrement')
		)s ";
		$inc = mysql_result(executeQuery($income),0);
		$pay = mysql_result(executeQuery($payments),0);
		$bal = $inc - $pay;
		return moneyFormatIndia($bal);
	}	
	function EditSrcAc($id){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT * FROM `source` WHERE `status` = 'active' AND `id` = '".mysql_real_escape_string($id)."'; ";
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					$row = mysql_fetch_assoc($res);
					   if($row['src_ac_type'] == "saving account") 
							$account_type = '<option value="saving account" selected>saving account</option>
                                        <option value="current account">current account</option>';
                        else
							$account_type = '<option value="saving account">saving account</option>
                                        <option value="current account" selected>current account</option>';

					echo '<form role="form">
                                        <div class="form-group">
											<span class="manditory">*</span>
                                            <label>Account Number</label>
                                            <input id="up_src_ac_no" class="form-control" value="'.$row['src_ac_no'].'"placeholder="PLease Enter Keyword">
                                        	<span id="err_src_ac_no"></span>
										</div>
                                        <div class="form-group">
											<span class="manditory">*</span>
                                            <label>Account Name</label>
                                            <input id="up_src_ac_name" class="form-control" value="'.$row['src_ac_name'].'" placeholder="PLease Enter Keyword">
                                        	<span id="err_src_ac_name"></span>
										</div>
                                        <div class="form-group">
											<span class="manditory">*</span>
                                            <label>Bank Name</label>
                                            <input id="up_src_bank" type="text" class="form-control" value="'.$row['src_bank'].'" placeholder="PLease Enter Keyword">
											<span id="err_src_bank"></span>
										</div>
                                        <div class="form-group">
											<span class="manditory">*</span>
                                            <label>Brance</label>
                                            <input id="up_src_branch" class="form-control" value="'.$row['src_branch'].'" placeholder="PLease Enter Keyword">
											<span id="err_src_branch"></span>
										</div>
                                        <div class="form-group">
                                            <label>PAN</label>
                                            <input id="up_src_pan" class="form-control" value="'.$row['src_pan'].'" placeholder="PLease Enter Keyword">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea id="up_des" class="form-control" rows="3">'.$row['des'].'</textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Account Type</label>
                                            <select id="up_src_ac_type" class="form-control">
                                            '.$account_type.'
											</select>
                                        </div>
                                        <button  onclick="update_src_ac('.$row['id'].');" type="button" class="btn btn-danger form-control">Save Changes</button>
									</form>';
				}
				else{
					echo 0;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);	
	}
	
	function UpdateSrcAc($id){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "UPDATE `source` SET 
						`src_ac_name`='".mysql_real_escape_string($_POST['up_src_ac_name'])."',
						`src_ac_no`='".mysql_real_escape_string($_POST['up_src_ac_no'])."',
						`src_bank`='".mysql_real_escape_string($_POST['up_src_bank'])."',
						`src_branch`='".mysql_real_escape_string($_POST['up_src_branch'])."',
						`src_ac_type`='".mysql_real_escape_string($_POST['up_src_ac_type'])."',
						`src_pan`='".mysql_real_escape_string($_POST['up_src_pan'])."',
						`des`='".mysql_real_escape_string($_POST['up_des'])."' 
						WHERE `id` = '".mysql_real_escape_string($id)."';";
				$res = executeQuery($query);
				echo 1;
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);	
	}
	
	function DeactivateSrcAc($id){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "UPDATE `source` SET 
						`status`='".mysql_real_escape_string('deactive')."' 
						WHERE `id` = '".mysql_real_escape_string($id)."';";
				$res = executeQuery($query);
				echo 1;
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
	}
	main();
?>

<?php include_once(DOC_ROOT.PHP.INC."header.php"); ?>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row"> 
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Source Account Summary
					</div>
					<div class="panel-body">
						<div id="src_ac_screen" class="table-responsive">
							<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/></center>
						</div>
						<div id="src_ac_screen2" class="table-responsive" style="display:none;">
							<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/></center>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
            </div>	
		</div>
		<!-- /. ROW  -->
    </div>
	<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php include_once(DOC_ROOT.PHP.INC."footer.php"); ?>
<script src="<?php echo URL.ASSET_JS; ?>source.js"></script>
<script>
		$("#src_nav").addClass("active-menu");
</script>
