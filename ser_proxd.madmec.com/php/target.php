<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
        if($_SESSION['USERTYPE'] != "admin")
                header("Location:".URL);
	function main(){
		if(!ValidateAdmin()){
			session_destroy();
			header('Location:'.URL);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'load_target_ac'){
			$_SESSION['payment_summary'] = LoadSummary('payments');
			$_SESSION['income_summary'] = LoadSummary('income');
			DisplayTarget();
			exit(0);
		}
			elseif(isset($_POST['action']) && $_POST['action'] == 'load_target_ac_income'){
			$_SESSION['income_summary'] = LoadSummary('income');
			DisplayTarget();
			exit(0);
		}
			elseif(isset($_POST['action']) && $_POST['action'] == 'load_target_ac_payment'){
			$_SESSION['payment_summary'] = LoadSummary('payments');
			DisplayTarget();
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'show_target_ac'){
			//$_SESSION['payment_summary'] = LoadSummary('payments');
			//$_SESSION['income_summary'] = LoadSummary('income');
			DisplayTarget();
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'target_ac_detail'){
			$id = $_POST['id'];
			$name = $_POST['name'];
			$tp = $_POST['tp'];
			TargetAcDetail($id,$name,$tp);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'check_name_exist'){
			$result = CheckNameExist(strtolower($_POST['name']));
			echo $result;
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'autocomplete__search'){
          		
			$id = $_POST['id'];
			$name = $_POST['name'];
			//DisplaySummary_1($id);			
			//TargetAcDetail_1($id,$name);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'checkBalanceSheet'){
			checkBalanceSheet();
			unset($_POST);
			exit(0);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == 'function_login_report_sheet'){
				if($_POST['email']=="" && $_POST['pass']=="")
					echo "not valid";
				else{	
					$email=$_POST['email'];	
					$pass=$_POST['pass'];		
					checkUserSheet($email,$pass);
				}
				
				unset($_POST);
				exit(0);
				
			}
		
	}
		
		function checkBalanceSheet()
			{
				
				$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
				if(get_resource_type($link) == 'mysql link'){
				if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					$query='SELECT * FROM settings 
							WHERE `password_status` = (SELECT `id` FROM `status` WHERE `statu_name` = "on" AND `status` = 1)';	
						$res=executeQuery($query);
						if(mysql_num_rows($res))
							echo "allow";
						else
							echo "Not allow";
					}
					
				}
		
		unset($_POST);
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		
		}
	
	function checkUserSheet($email,$pass)
	{
		$eml=$email;
		$pas = hash('sha256', $pass, false);
		
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
				if(get_resource_type($link) == 'mysql link'){
				if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
					$query='SELECT * FROM settings WHERE ac_user_name="'.$eml.'" AND ac_password = "'.$pas.'" AND password_status = (SELECT `id` FROM `status` WHERE `statu_name` = "on" AND `status` = 1) ';
						$res=executeQuery($query);
						if(mysql_num_rows($res))
							echo "valid";
						else
							echo "Not valid";
					}
					
				}
		
		unset($_POST);
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		
		
	}
	
		
		//target account for income and payments details 
		function TargetAcDetail($id,$name,$tp){
		$total_pay = '';
		$total_inc = '';
		echo '<h3><a href="javascript:void(0);" onclick="javscript:show_target_ac();"><i class="fa fa-arrow-circle-left"></i>Back</a></h3> 
			<h2>'.$name.'\'s Account for payment </h3><hr />
			
		
				<div class="row">';
			if($tp=="income"){
		echo '<div class="col-md-8">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Date</th>
							<th>Towards</th>
							<th><i class="fa fa-plus-square fa-2x" style="color:GREEN;"></i>Income---</th>
						</tr>
					</thead>
					<tbody>';
			}	
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
			if($tp=="income"){	
				$income_summary = $_SESSION['income_summary'];//LoadSummary('income');
				$query = "SELECT a.*,
				b.`source_id`,
				b.`don_type`,
				b.`for`,
				b.`amount`,
				b.`date`
				FROM 
				`receipt` AS a JOIN `income` AS b ON a.`income_id` = b.`id`
				JOIN `target`AS c on b.`target_id` = c.`id`
                WHERE b.`target_id` = '".$id."'
                ORDER BY `id` DESC";
								
				$res =  executeQuery($query);
				if(mysql_num_rows($res)){
					while( $row = mysql_fetch_assoc($res) ){
						$total_inc += $row['amount'];
						$temp0 = explode(" ",$row['date']);
						$temp = explode("-",$temp0[0]);
						$d_m_y = $temp[2].'-'.$temp[1].'-'.$temp[0];
						$details = '';
						$details .= "<br />By Cheque :".$row['don_type'];
						$details .= ' (<a href="'.$row['rec_location'].'" target="_blank">REC NO. '.$row['rec_no'].' Receipt</a>)';
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
				
		
			
			echo '</tbody></table></div><!-- col-md-8 -->';
		}
	}if($tp=="payment"){	
				echo '<div class="col-md-8">
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
                WHERE b.`target_id` = '".$id."'
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
						$details .= ' (<a href="'.$row['location'].'" target="_blank">SL NO. '.$row['sl_no'].' Voucher</a>)';
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
				echo '</tbody></table></div><!-- col-md-8 -->';
			}
	         
			}
		
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		echo '</div><!-- .row -->';
	} 
	
	function DisplayTarget(){
		$income_summary = $_SESSION['income_summary'];//LoadSummary('income');
		$payment_summary = $_SESSION['payment_summary'];//LoadSummary('payment');
			
		$total_inc='';
		$total_pay='';
		$i=0;
		$j=0;
		while($i < sizeof($income_summary)){
							
			if($i == 0)
				$total_inc = '"'.$income_summary[$i]['tar_name'].'"';
			else
				$total_inc .= ',"'.$income_summary[$i]['tar_name'].'"';
			$i++;
		}
			while($j < sizeof($payment_summary)){
							
			if($j == 0)
				$total_pay = '"'.$payment_summary[$j]['tar_name'].'"';
			else
				$total_pay .= ',"'.$payment_summary[$j]['tar_name'].'"';
			$j++;
		}
		

		//Accrodian Panel for payment and income details
		echo '<div id="accordion" class="panel-group">
				 	<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" id="incomecoll" onClick="$(\'#collapseOne\').toggle(300);">1. INCOME SUMMARY</a>&nbsp;								
					   		</h4>
							</div>';
		
		if(isset($_POST["action"]) && $_POST["action"]=="load_target_ac_income")	
			echo '<div class="panel-body" id="collapseOne">';
		else 
			echo '<div class="panel-body" id="collapseOne" style="display:none;">';
		
		echo '
										<table class="table table-striped table-bordered table-hover" style="cursor:pointer;">
											<thead>
													<tr>
														<div class="form-group"><!--/.form grup-->
															<span class="manditory"></span>
																	<label> Search :</label>
																		<div class="row"><!--/.row-->
									  										<div class="col-lg-6"><!--/.col-lg-6-->
									  										   <input id="name1" type="text" class="form-control" onKeyDown="javascript:if (event.keyCode==13 || event.keyCode==9)load_target_ac_search_income(this.value);"  placeholder="Type your text here ">
																						<script>
																							$(function() {
																								var availableTags = ['.$total_inc.'];
																								$( "#name1" ).autocomplete({
																								source: availableTags
																								});
																							 });
																	  					</script>
																	  					</div>
																	  					<div class="col-lg-6">
																	  							<button class="btn btn-danger" name="iname" onclick="javasript:load_target_ac_search_income(this.value);">
																										<i class="fa fa-refresh "></i>																				 
																										 Refresh
																								</button>
																	  		</div><!--/.col-lg-6-->
									  									</div><!--/.row-->
																				<span class="text-danger" id="err_name">Invalid</span>
														</div><!--/.form grup-->	
													</tr>
													<tr>
															<th>Target Name</th>
															<th><i class="fa fa-plus-square fa-2x" style="color:GREEN;"></i>Income</th>
													</tr>
							  				</thead>
										<tbody>';
						DisplaySummary();
			   	echo '</table>
            				</div>
            					
										</div>
											
									<div class="panel panel-default">
        									<div class="panel-heading">
        							    			<h4 class="panel-title">
        							    			
        							    			<a data-toggle="collapse" data-parent="#accordion" id="paymentcoll" href="#collapseTwo" onClick="$(\'#collapseTwo\').toggle(300);">2. PAYMENTS SUMMARY</a>&nbsp;
                										
            									</h4>
        									</div>';
		
		if(isset($_POST["action"]) && $_POST["action"]=="load_target_ac_payment")		
			echo '<div class="panel-body" id="collapseTwo">';
		else 
			echo '<div class="panel-body" id="collapseTwo" style="display:none;">';
		
		echo '	
        									
            							
					   								<table class="table table-striped table-bordered table-hover" style="cursor:pointer;">
															<thead>
											  						<tr>
																			<div class="form-group"><!--/.form grup-->
																					<span class="manditory"></span>
																					<label>Search :</label>
																						<div class="row"><!--/.row-->
									  													<div class="col-lg-6"><!--/.col-lg-6-->
									  								    						<input id="name" type="text" class="form-control" onKeyDown="javascript:if (event.keyCode==13 || event.keyCode==9)load_target_ac_search_payment(this.value);"  placeholder="Type your text here">
																									<script>
																										$(function() {
																												var availableTags = ['.$total_pay.'];
																												$( "#name" ).autocomplete({
																												source: availableTags
																												});
																										});
																	  								</script>
																							</div>
																							<div class="col-lg-6">																						  								
																	  								<button class="btn btn-danger" onclick="javasript:load_target_ac_search_payment(this.value);">
																													<i class="fa fa-refresh "></i>																				 
																		 											Refresh
																									</button>
									  														</div><!--/.col-lg-6-->
												</div><!--/.row-->
											<span class="text-danger" id="err_name">Invalid</span>
									</div><!--/.form grup-->	
								</tr>
												<tr>
													<th>Target Name</th>
													<th><i class="fa fa-minus-square fa-2x" style="color:RED;"></i>Payments</th>
												</tr>
											</thead>
										<tbody>';
						DisplaySummary_payment();
						
					echo '</tbody>
								</table>     
               				</div>
 				 						
    										</div>
							
						</div>'; 
	}
	
	
	//Display the Income Summary details
	function DisplaySummary(){
		$income_summary = $_SESSION['income_summary'];//LoadSummary('income');
		$total_inc = 0;
		$type="income";
		for($i = 0;$i < sizeof($income_summary); $i++){
			echo '<div id="d1"><tr onclick="target_ac_detail('.$income_summary[$i]['target_id'].',\''.$income_summary[$i]['pre_name'].''.$income_summary[$i]['tar_name'].'\',\'income\');">
					<td>
						<strong><font face="verdana" color="#700000">'.$income_summary[$i]['pre_name'].$income_summary[$i]['tar_name'].'</font></strong>
					</td>
					<td align="right">
						<strong>'.moneyFormatIndia($income_summary[$i]['total_amt']).'</strong>
					</td>
					
				</tr></div>';
			$total_inc += $income_summary[$i]['total_amt'];
		}
		
		echo '<tr style="font-size:16px;">
					<td align="right">
						<strong><font face="verdana" color="#700000">Total</font></strong>
					</td>
					<td align="right">
						<strong>'.moneyFormatIndia($total_inc).'</strong>
					</td>
					
				</tr>';
				//<tr><td colspan="3">In Words: '.no_to_words($total_pay).'</td></tr>';
	}
	
		//Display the Payment summary	Details
		function DisplaySummary_payment(){
			$payment_summary =  $_SESSION['payment_summary'];//LoadSummary('payments');
			$total_pay = 0;
			$total_inc = 0;
			$type="payment";
			for($j = 0;$j < sizeof($payment_summary); $j++){
				echo '<tr onclick="target_ac_detail('.$payment_summary[$j]['target_id'].',\''.$payment_summary[$j]['pre_name'].$payment_summary[$j]['tar_name'].'\',\'payment\');">
						<td>
							<strong><font face="verdana" color="#700000">'.$payment_summary[$j]['pre_name'].$payment_summary[$j]['tar_name'].'</font></strong>
						</td>
						<td align="right">
							<strong>'.moneyFormatIndia($payment_summary[$j]['total_amt']).'</strong>
						</td>
						</tr>';
			$total_pay += $payment_summary[$j]['total_amt'];	
		}
		
		echo '<tr style="font-size:16px;">
					<td align="right">
						<strong><font face="verdana" color="#700000">Total</font></strong>
					</td>
					
					<td align="right">
						<strong>'.moneyFormatIndia($total_pay).'</strong>
					</td>
				</tr>';
		}	
	
	
	
	
	
	function LoadSummary($type){
		$summary = array();
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if(isset($_POST["name"])) {
					$name=$_POST["name"];
					$query = "SELECT a.`target_id`, SUM(a.`amount`) AS total_amt,
					b.`pre_name`, b.`tar_name`
					FROM `".$type."` AS a JOIN `target` As b ON a.`target_id` = b.`id`
					WHERE b.`tar_name` LIKE '%".$name."%'
					GROUP by `target_id` ;";
				}
				else if(isset($_POST["iname"])){
					$query = "SELECT a.`target_id`, SUM(a.`amount`) AS total_amt,
					b.`pre_name`, b.`tar_name`
					FROM `".$type."` AS a JOIN `target` As b ON a.`target_id` = b.`id`
					GROUP by `target_id` ;";
				}
				else {
						$query = "SELECT a.`target_id`, SUM(a.`amount`) AS total_amt,
					b.`pre_name`, b.`tar_name`
					FROM `".$type."` AS a JOIN `target` As b ON a.`target_id` = b.`id`
					GROUP by `target_id` ;";
					}
				$res =  executeQuery($query);
				
				if(mysql_num_rows($res)){
					$index = 0;
					while( $row = mysql_fetch_assoc($res) ){
						$summary[$index]['target_id'] = $row['target_id'];
						$summary[$index]['total_amt'] = $row['total_amt'];
						$summary[$index]['pre_name'] = $row['pre_name'];
						$summary[$index]['tar_name'] = $row['tar_name'];
						$index++;
					}
				}
				else{
					$summary = NULL;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
		return $summary;
	}
	main();
?>
<?php include_once(DOC_ROOT.PHP.INC."header.php"); ?>
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row" id="report"  style="display:none"> 
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Target Account Summary
					</div>
					<div class="panel-body">
						<div id="target_screen" class="table-responsive">
							<center><img class="img-circle" src="<?php echo URL.ASSET_IMG; ?>loader.gif" border="0"/></center>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
            </div>	
		</div>
			<div id="formclass" style="display:none">	
						<form class="form-signin" role="form" id="form_sign" method="POST">
								<h1 class="form-signin-heading">Please sign in</h1>
								<input type="email" id="email_report" class="form-control" placeholder="Email address" required autofocus>
								<input type="password" id="password_report" class="form-control" placeholder="Password" required>
								<label class="btn btn-lg btn-danger btn-block" onclick="javascript: report_status();" >Processed</label>
								<br />
							<div id="passauth"></div>
						</form>
						
					</div>
	</div>
	 <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->



<html lang="en">
  <head>
   <!-- Bootstrap core CSS -->
    <link href="<?php echo URL.ASSET_CSS; ?>bootstrap.css" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="<?php echo URL.ASSET_CSS; ?>signin.css" rel="stylesheet">
    <!-- CUSTOM STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>custom.css" rel="stylesheet" />
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="<?php echo URL.ASSET_JS; ?>ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo URL.ASSET_JS; ?>ie-emulation-modes-warning.js"></script>
  	<script src="<?php echo URL.ASSET_JS; ?>config.js"></script>
    <script src="<?php echo URL.ASSET_JS; ?>ie10-viewport-bug-workaround.js"></script>
     </head>

</html>
<?php include_once(DOC_ROOT.PHP.INC."footer.php"); ?>  
<script src="<?php echo URL.ASSET_JS; ?>target.js"></script>    
<script>
	$("#tar_nav").addClass("active-menu");
</script>
