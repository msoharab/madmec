<?php
class account{
	protected $parameters = array();
	private $order   = array("\r\n", "\n", "\r", "\t");
	private $replace = '';
	function __construct($para	=	false){
		$this->parameters=$para;
		
		
	}
	function listFeeUser($para){
		$flag = false;
		$listusers = array();
		$searchQuery = array(
			"searchQueryA" 	=> ' ',
			"searchQueryB" 	=> ' ',
			"searchQueryC" 	=> ' ',
			"searchQueryD" 	=> ' ',
			"searchQueryE" 	=> ' ',
			"ListQuery" 	=> ' '
		);
		$exclusion = '';
		$obj = new enquiry();
		$obj -> returnSearchQuery($searchQuery,$para);
		switch($para["list_type"]){
			case "due":
				$exclusion = '';
			break;
			default:
				//$exclusion = 'AND u.`id` NOT IN (SELECT `customer_pk` FROM `group_members` WHERE `group_id` IN (SELECT `id` FROM `groups` WHERE `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 ) AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Joined\' AND `status`=1 ))';
				$exclusion = '';
			break;
		}
		$query = 'SELECT
				a.`id`,
				a.`name`,
				a.`email`,
				a.`cell_number`,
				a.`dob`,
				a.`sex`,
				a.`acs_id`,
				a.`occupation`,
				a.`date_of_join` AS jnd,
				a.`fee` AS reg_fee,
				a.`receipt_no` AS reg_rpt_no,
				a.`mode_of_payment` AS reg_mop,
				a.`photo`,
				a.`status`,
				
				b.`fee_pk`,
				b.`facility_type`,
				b.`offer_name`,
				b.`duration`,
				b.`fee_payment_date`,
				b.`valid_from`,
				b.`valid_till`,
				
				c.`pack_pk`,
				c.`package_type`,
				c.`number_of_sessions`,
				c.`pck_pay_date`,
				d.`attn_id`,
				d.`in_time`,
				d.`out_time`,
				
				e.`mt_pk`,
				e.`mt_uid`,
				e.`inv_tt`,
				e.`inv_tid`,
				e.`mt_pod`,
				e.`mt_rpt`,
				e.`tot_amt`,
				e.`mop`,
				e.`inv_urls`,
				e.`money_trans_id`,
				e.`due_id`,
				e.`due_amount`,
				e.`due_date`,
				e.`due_status`
			FROM (
				SELECT u.*,
					CASE WHEN u.`photo_id` IS NULL
						 THEN \''.USER_ANON_IMAGE.'\'
						 ELSE CONCAT(\''.URL.ASSET_DIR.'\',p.`ver3`)
					END AS photo
				FROM `customer` AS u
				LEFT  JOIN  `photo` AS p ON p.`id` = u.`photo_id`
				WHERE (u.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Registered\' AND `status`=1 )  OR u.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Joined\' AND `status`=1 ))
				'.$exclusion.'
				'.$searchQuery["searchQueryA"].'
			)AS a
			LEFT  JOIN (
				SELECT 	GROUP_CONCAT(DISTINCT (fe.`id`)) 	AS fee_pk,
						fe.`customer_pk` 						AS user_id,
						GROUP_CONCAT(fep.`facility_id`) 	AS facility_type,
						GROUP_CONCAT(fep.`name`)  			AS offer_name,
						GROUP_CONCAT(od.`duration`)		  	AS duration,
						GROUP_CONCAT(fep.`min_members`) 	AS min_members,
						GROUP_CONCAT(fe.`payment_date`) 	AS fee_payment_date,
						GROUP_CONCAT(fe.`valid_from`) 		AS valid_from,
						GROUP_CONCAT(fe.`valid_till`) 		AS valid_till
				FROM `fee` AS fe
				INNER  JOIN  `offers` AS fep ON fep.`id` = fe.`offer_id`
				LEFT JOIN `offerduration` as od ON fep.`duration_id` = od.`id` 
				WHERE fep.`id` = fe.`offer_id`  AND  fep.`facility_id` LIKE CONCAT(\'%'.mysql_real_escape_string($para["fct_type"]).'%\')
				GROUP BY (fe.`customer_pk`)
				ORDER BY (fe.`id`) DESC
			)AS b ON b.`user_id` = a.`id`
			LEFT  JOIN (
				SELECT 	GROUP_CONCAT(DISTINCT (fepack.`id`)) AS pack_pk,
							pacnm.`package_name` AS package_type,
							pac.`number_of_sessions`,
							GROUP_CONCAT(fepack.`payment_date`) AS pck_pay_date,
							fepack.`customer_pk` AS user_id
				FROM 	`fee_packages` AS fepack
				INNER  	JOIN  `packages` AS pac ON pac.`id` = fepack.`package_id`
				LEFT JOIN `package_name` as pacnm ON pacnm.`id` = pac.`package_type_id`
				WHERE 	pac.`id` = fepack.`package_id`
				GROUP BY(fepack.`customer_pk`)
				ORDER BY (fepack.`id`) DESC
			) AS c ON c.`user_id` = a.`id`
			LEFT  JOIN (
				SELECT 	GROUP_CONCAT(DISTINCT (attn.`id`)) AS attn_id,
							GROUP_CONCAT(attn.`in_time`) AS in_time,
							GROUP_CONCAT(attn.`out_time`) AS out_time,
							GROUP_CONCAT(fclty.`name`) AS facility_type,
							attn.`customer_pk` AS user_id
				FROM `customer_attendence` AS attn
				LEFT JOIN `facility` as fclty ON fclty.`id` = attn.`facility_id`
				GROUP BY(attn.`customer_pk`)
			) AS d ON d.`user_id` = a.`email`
			LEFT  JOIN (
				SELECT
					GROUP_CONCAT(mtr.`id`)  			AS mt_pk,
					mtr.`customer_pk`					AS mt_uid,
					GROUP_CONCAT(inv.`name`) 			AS inv_tt,
					GROUP_CONCAT(inv.`transaction_id`) 	AS inv_tid,
					GROUP_CONCAT((SELECT `pay_date` FROM `money_transactions` WHERE `id` = inv.`transaction_id`))	AS mt_pod,
					GROUP_CONCAT(DISTINCT(mtr.`receipt_no`))AS mt_rpt,
					GROUP_CONCAT(temp1.`total`)			AS tot_amt,
					GROUP_CONCAT(temp2.`gmop`)			AS mop,
					GROUP_CONCAT(inv.`inv_urls`) 		AS inv_urls,
					due.`duser` 						AS due_user,
					GROUP_CONCAT(due.`money_trans_id`) 	AS money_trans_id,
					GROUP_CONCAT(due.`due_id`) 			AS due_id,
					GROUP_CONCAT(due.`damt`) 			AS due_amount,
					GROUP_CONCAT(due.`ddate`) 			AS due_date,
					GROUP_CONCAT(due.`dstatus`) 		AS due_status
				FROM `money_transactions` AS mtr
				LEFT JOIN (
					SELECT
						IF(temp3.`due_id` IS NULL, \'NA\', temp3.`due_id`) AS due_id,
						IF(temp3.`due_amt` IS NULL, \'NA\', temp3.`due_amt`) AS damt,
						IF(temp3.`due_date` IS NULL, \'NA\', temp3.`due_date`) AS ddate,
						IF(temp3.`due_status` IS NULL, \'NA\', temp3.`due_status`) AS dstatus,
						temp3.`duser` AS duser,
						IF(temp3.`money_trans_id` IS NULL, \'NA\', temp3.`money_trans_id`) AS money_trans_id,
						temp3.`rrr`
					FROM (
						SELECT
							tmtr.`receipt_no` 		AS rrr,
							tinv.`id` 			AS due_id,
							tinv.`money_trans_id` 		AS money_trans_id,
							tinv.`due_amount`		AS due_amt,
							tinv.`due_date` 		AS due_date,
							tmtr.`customer_pk` 			AS duser,
							tinv.`status` 			AS due_status
						FROM `money_transactions` AS tmtr
						LEFT JOIN (
							SELECT `id`,
									`money_trans_id`,
									`due_amount`,
									`due_date`,
									`customer_pk`,
									`status`
							FROM `money_trans_due`
						) AS tinv ON tmtr.`id` = tinv.`money_trans_id`
						GROUP BY (tmtr.`id`)
					) AS temp3
					GROUP BY (temp3.`rrr`)
				) AS due ON due.`rrr` = mtr.`receipt_no` AND mtr.`customer_pk` = due.`duser`
				LEFT JOIN (
					SELECT
						`customer_pk`	AS inv_users,
						`location` 	AS inv_urls,
						`transaction_id`,
						`name`
					FROM `invoice`
					GROUP BY(`transaction_id`)
				) AS inv ON inv.`transaction_id` = mtr.`id`
				LEFT JOIN(
					SELECT
						`id`,
						`receipt_no`,
						SUM(`total_amount`) AS total
					FROM `money_transactions`
					GROUP BY (`receipt_no`)
				) AS temp1 ON temp1.`id` = mtr.`id`
				LEFT JOIN(
					SELECT
						`id`,
						`receipt_no`,
						CONCAT(\'(\',GROUP_CONCAT(CONCAT(`total_amount` ,\' through \', (SELECT CASE WHEN `name` = \'Cash\' THEN \'Cash\' ELSE CASE WHEN `transaction_number` IS NULL THEN  `name` ELSE CASE WHEN LENGTH(`transaction_number`) = 0 THEN CONCAT (`name`, \' and \', `name`, \' No = Not provided\')  ELSE CONCAT (`name`, \' and \', `name`, \' No = \',`transaction_number`) END END END  FROM `mode_of_payment`  WHERE `id` = `mop_id`  AND `status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 ))  )),\')\') AS gmop
					FROM `money_transactions`
					GROUP BY (`receipt_no`)
				) AS temp2 ON temp2.`id` = mtr.`id`
				GROUP BY (mtr.`customer_pk`)
			) AS e ON e.`mt_uid` = a.`id` 
			RIGHT JOIN `customer_facility` AS cf ON cf.`customer_pk` = a.`id`
			WHERE a.`id` != 0 
			'.$searchQuery["searchQueryD"].' 
			'.$searchQuery["searchQueryB"].'
			'.$searchQuery["searchQueryC"].'
			'.$searchQuery["ListQuery"].';';
		$res = executeQuery($query);
		if(mysql_num_rows($res)){
			$i = 1;
			while($row1 = mysql_fetch_assoc($res)){
				$listusers[$i]['id'] = $row1['id'];
				$listusers[$i]['name'] = $row1['name'];
				$listusers[$i]['email_id'] = $row1['email'];
				$listusers[$i]['cell_number'] = $row1['cell_number'];
				$listusers[$i]['acs_id'] = $row1['acs_id'];
				$listusers[$i]['occupation'] = $row1['occupation'];
				$listusers[$i]['dob'] = $row1['dob'];
				$listusers[$i]['sex'] = $row1['sex'];
				$listusers[$i]['date_of_join'] = date('F j, Y, g:i a', strtotime($row1['jnd']));
				/* Photo */
				$listusers[$i]['photo'] = $row1['photo'];
				/* Fee history */
				$listusers[$i]['avg_amt'] = 0;
				if($row1['fee_pk']){
					$listusers[$i]['fee']=array();
					$listusers[$i]['fee']['id'] = explode(",",$row1['fee_pk']);
					$listusers[$i]['fee']['facility_type'] = explode(",",$row1['facility_type']);
					$listusers[$i]['fee']['offer_name'] = explode(",",$row1['offer_name']);
					$listusers[$i]['fee']['duration'] = explode(",",$row1['duration']);
					$listusers[$i]['fee']['payment_date'] = explode(",",$row1['fee_payment_date']);
					$listusers[$i]['fee']['valid_from'] = explode(",",$row1['valid_from']);
					$listusers[$i]['fee']['valid_till'] = explode(",",$row1['valid_till']);
				}
				else{
					$listusers[$i]['fee'] = NULL;
				}
				/* Fee package history */
				if($row1['pack_pk']){
					$listusers[$i]['fee_package'] = array();
					$listusers[$i]['fee_package']['id'] = explode(",",$row1['pack_pk']);
					$listusers[$i]['fee_package']['package_type'] = explode(",",$row1['package_type']);
					$listusers[$i]['fee_package']['num_sessions'] = explode(",",$row1['number_of_sessions']);
					$listusers[$i]['fee_package']['payment_date'] = explode(",",$row1['pck_pay_date']);
				}
				else{
					$listusers[$i]['fee_package']= NULL;
				}
				/* Attendance history */
				if($row1['attn_id']){
					$listusers[$i]['attendance'] = array();
					$listusers[$i]['attendance']['id'] = explode(",",$row1['attn_id']);
					$listusers[$i]['attendance']['in_time'] = explode(",",$row1['in_time']);
					$listusers[$i]['attendance']['out_time'] = explode(",",$row1['out_time']);
					$listusers[$i]['attendance']['facility_type'] = explode(",",$row1['facility_type']);
				}
				else{
					$listusers[$i]['attendance']=NULL;
				}
				/* Account stats */
				if($row1['mt_uid']){
					$listusers[$i]['accounts'] = array();
					$listusers[$i]['accounts']['mt_uid'] = $row1['mt_uid'];
					$listusers[$i]['accounts']['inv_tt'] = explode(",",$row1['inv_tt']);
					$listusers[$i]['accounts']['mt_pod'] = explode(",",$row1['mt_pod']);
					$listusers[$i]['accounts']['mt_rpt'] = explode(",",$row1['mt_rpt']);
					$listusers[$i]['accounts']['tot_amt'] = explode(",",$row1['tot_amt']);
					$listusers[$i]['accounts']['mop'] = explode("),",$row1['mop']);
					$listusers[$i]['accounts']['inv_urls'] = explode(",",$row1['inv_urls']);
					$listusers[$i]['accounts']['due_amount'] = explode(",",$row1['due_amount']);
					$listusers[$i]['accounts']['due_id'] = explode(",",$row1['due_id']);
					$listusers[$i]['accounts']['money_trans_id'] = explode(",",$row1['money_trans_id']);
					$listusers[$i]['accounts']['due_date'] = explode(",",$row1['due_date']);
					$listusers[$i]['accounts']['due_status'] = explode(",",$row1['due_status']);
				}
				else{
					$listusers[$i]['accounts']=NULL;
				}
				if($row1['valid_till'])
					$listusers[$i]['exp_date'] = date('j-M-Y', strtotime($listusers[$i]['fee']['valid_till'][sizeof($listusers[$i]['fee']['valid_till'])-1]));
				else
					$listusers[$i]['exp_date'] = NULL;
				$i++;
			}
		}
		else{
			$listusers = NULL;
		}
		return $listusers;
	}
	/* <Individual fee> */
	function displayFeeList($para){
		$post_ids = array();
		$num_posts = 0;
		$panelTitle = '';
		$feeDueSaveHtml = '';
		$offerHtml = '';
		$startyear = date('Y');
		$endyear = date('Y')+2;
		$mop = new account();
		$mopname1= $mop -> returnModOfPayment();
		$mopname = array(
			"htm" => '',
			"textbox" => '',
			"id"	=>	'',
			"ac"	=> $para["ac"],
		);
		for($p=0;$p<sizeof($mopname1);$p++){
				$mopname["htm"] .= $mopname1[$p]["html"];
				$mopname["textbox"][$p] = $mopname1[$p]["mopname"];
				$mopname["id"][$p] = $mopname1[$p]["id"];
		}
		
		//$theme = array('default','success','info','danger','warning');
		$theme = array('info');
		$obj = new account();
		if(isset($_SESSION['listfeeusers']) && $_SESSION['listfeeusers'] != NULL)
			$post_ids = $_SESSION['listfeeusers'];
		else
			$post_ids = NULL;
		if($post_ids != NULL)
			$num_posts = sizeof($post_ids);
		if($num_posts > 0){
	
					echo '<div class="row">
						  <div class="col-lg-12">
						  <div class="panel panel-default">
						  <div class="panel-heading">Individual '.$para["fname"].' panel from '.$para["initial"].' to '.$para["final"].'</div>
						  <div class="panel-body">
						  <div class="panel-group" id="accordion">';
					for($i=$para["initial"];$i<=$para["final"] && $i <= $num_posts && isset($post_ids[$i]['id']);$i++){
						if (!file_exists($post_ids[$i]['photo']))
							$post_ids[$i]['photo'] = USER_ANON_IMAGE;
						$the = $theme[mt_rand(0,sizeof($theme)-1)];
						$_SESSION['listfeeusers'][$i]['theme'] = $the;
						switch($para["list_type"]){
							case "offer":
							{
								$feeDueSaveHtml = $obj -> returnFeeSaveHtml($the,$i,$post_ids[$i]['id'],'AddIndividualFee',$mopname);
								$joining_date = $obj ->  returnLastExpDate($post_ids[$i]['id'],$para["fct_type"]);
								if($joining_date == NULL){
									$joining_date = date('Y-m-d');
								}
								$jndparameters = array(
									"id" 			=> 	$post_ids[$i]['id'],
									"joining_date" 	=> 	$joining_date,
									"startyear" 	=> 	$startyear,
									"endyear"		=> 	$endyear,
									"list_type"		=> 	$para["list_type"]
								);
								$jdatehtml = $obj -> returnJndHtml($jndparameters);
								$listofoffersHtml = $obj -> returnListedOffers($post_ids[$i]['id'],$i,'SetIndivisualAmt');
								$panelTitle = $i.' » ['.$post_ids[$i]['name'].'] - ['.$post_ids[$i]['cell_number'].'] - <span id="exp_date_'.$post_ids[$i]['id'].'">['.$post_ids[$i]['exp_date'].']</span>';
								$offerHtml = '<div class="panel-body">
												<fieldset id="userdetails_'.$post_ids[$i]['id'].'">
													<div class="row text-'.$the.'">
														<div class="col-lg-12">
															<div class="row">
																<div class="col-lg-12"><strong><span id="eml_msg_'.$post_ids[$i]['id'].'" style="display:none; color:#FF0000; font-size:25px;"	>*</span>Email id <i class="fa fa-caret-down"></i></strong></div>
																<div class="col-lg-12"><input  name="email" id="email_'.$post_ids[$i]['id'].'" type="text" class="form-control" value="'.$post_ids[$i]['email_id'].'" readonly="readonly" /></div>
																<div class="col-lg-12">&nbsp;</div>
															</div>
															'.$listofoffersHtml.'
															'.$jdatehtml.'
														</div>
													</div>
													'.$feeDueSaveHtml.'
												</fieldset>
												<div id="keycodes_'.$post_ids[$i]['id'].'" style="display:none;">1</div>
											</div>';
							}
							break;
							case "package":
							{
								$feeDueSaveHtml = $obj -> returnFeeSaveHtml($the,$i,$post_ids[$i]['id'],'AddIndividualFee',$mopname);
								$joining_date = date('Y-m-d');
								$jndparameters = array(
									"id" 			=> 	$post_ids[$i]['id'],
									"joining_date" 	=> 	$joining_date,
									"startyear" 	=> 	$startyear,
									"endyear"		=> 	$endyear,
									"list_type"		=> 	$para["list_type"]
								);
								$jdatehtml = $obj -> returnJndHtml($jndparameters);
								$listofoffersHtml = $obj -> returnListedPackages($post_ids[$i]['id'],$i);
								$panelTitle = $i.' » ['.$post_ids[$i]['name'].'] - ['.$post_ids[$i]['cell_number'].']';
								$offerHtml = '<div class="panel-body">
												<fieldset id="userdetails_'.$post_ids[$i]['id'].'">
													<div class="row text-'.$the.'">
														<div class="col-lg-12">
															<div class="row">
																<div class="col-lg-12"><strong><span id="eml_msg_'.$post_ids[$i]['id'].'" style="display:none; color:#FF0000; font-size:25px;"	>*</span>Email id <i class="fa fa-caret-down"></i></strong></div>
																<div class="col-lg-12"><input  name="email" id="email_'.$post_ids[$i]['id'].'" type="text" class="form-control" value="'.$post_ids[$i]['email_id'].'" readonly="readonly" /></div>
																<div class="col-lg-12">&nbsp;</div>
															</div>
															'.$listofoffersHtml.'
															'.$jdatehtml.'
														</div>
													</div>
													'.$feeDueSaveHtml.'
												</fieldset>
												<div id="keycodes_'.$post_ids[$i]['id'].'" style="display:none;">1</div>
											</div>';
							}
							break;
							case "due":
							{
								$panelTitle = $i.' » ['.$post_ids[$i]['name'].'] - ['.$post_ids[$i]['cell_number'].']';
								$texbox = '';
								$offerHtml = '';
								if($post_ids[$i]['accounts'] != NULL){
									$accounts_html = '';
									$offerHtml = '<div class="panel-body">
												<div class="panel-group" id="accord_'.$i.'">';
									for($j=0;$j<sizeof($post_ids[$i]['accounts']['mt_rpt']);$j++){
										if( $post_ids[$i]['accounts']['due_id'][$j] != 'NA' &&
											$post_ids[$i]['accounts']['due_date'][$j] != 'NA' &&
											$post_ids[$i]['accounts']['due_status'][$j] != 'NA' &&
											$post_ids[$i]['accounts']['due_amount'][$j] != 'NA' &&
											$post_ids[$i]['accounts']['due_status'][$j] != 0
											)
										{
											$due_date = date('F j, Y', strtotime($post_ids[$i]['accounts']['due_date'][$j]));
											
											for($p=0;$p<sizeof($mopname);$p++){
												$texbox .= '<input name="mod_number_'.$post_ids[$i]['accounts']['due_id'][$j].'_1" type="text" placeholder="'.$mopname["textbox"][$p].' Number"    id="pdc_no_'.$post_ids[$i]['accounts']['due_id'][$j].'_1"    class="form-control" style="display:none;"/>';
											}
											$offerHtml .= '<div class="panel panel-default" id="userdetails_'.$post_ids[$i]['accounts']['due_id'][$j].'">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a class="collapsed" data-toggle="collapse" data-parent="#accord_'.$i.'" href="#collaps_'.$post_ids[$i]['accounts']['due_id'][$j].'" id="col_'.$post_ids[$i]['accounts']['due_id'][$j].'">
																['.$post_ids[$i]['accounts']['due_amount'][$j].' <i class="fa fa-rupee fa-fw"></i>] - <span id="exp_date_'.$post_ids[$i]['accounts']['due_id'][$j].'">['.$due_date.']</span>
															</a>
														</h4>
													</div>
													<div id="collaps_'.$post_ids[$i]['accounts']['due_id'][$j].'" class="panel-collapse collapse in">
														<div class="row">
															<div class="col-lg-12">
																<div class="row">
																	<div class="col-lg-12"><strong><span id="eml_msg_'.$post_ids[$i]['accounts']['due_id'][$j].'" style="display:none; color:#FF0000; font-size:25px;"	>*</span>Email id <i class="fa fa-caret-down"></i></strong></div>
																	<div class="col-lg-12"><input  name="email" id="email_'.$post_ids[$i]['accounts']['due_id'][$j].'" type="text" class="form-control" value="'.$post_ids[$i]['email_id'].'" readonly="readonly" /></div>
																	<div class="col-lg-12">&nbsp;</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-12">
																<div id="add_mop_'.$post_ids[$i]['accounts']['due_id'][$j].'">
																	<div class="row" id="usr_fee_row_'.$post_ids[$i]['accounts']['due_id'][$j].'_1">
																		<div class="col-lg-12">
																			<strong><span id="user_fee_msg_'.$post_ids[$i]['accounts']['due_id'][$j].'_1" style="display:none; color:#FF0000; font-size:25px;">*</span>Fee <i class="fa fa-caret-down"></i></strong>
																		</div>
																		<div class="col-lg-12">
																			<div class="form-group">
																				<div class="col-md-4">
																					<select name="mod_pay" id="mod_pay_'.$post_ids[$i]['accounts']['due_id'][$j].'_1" class="form-control">
																						<option value="NULL" selected>Select</option>
																							'.$mopname["htm"].'
																					</select>
																				</div>
																				<div class="col-md-4">
																					<input name="user_fee" type="text" id="user_fee_'.$post_ids[$i]['accounts']['due_id'][$j].'_1" value="'.$post_ids[$i]['accounts']['due_amount'][$j].'" class="form-control"/>'.$texbox.'
																				</div>
																				<div class="col-md-4">
																					<a id="addmop_'.$post_ids[$i]['accounts']['due_id'][$j].'_1" class="btn btn-primary  btn-xs" href="javascript:void(0);"  onClick="$(this).hide();">Add</a>
																					<script language="javascript" type="text/javascript" >
																						$("#addmop_'.$post_ids[$i]['accounts']['due_id'][$j].'_1").on("click",function(){
																								var obj = new controlAccountFee();
																								obj.__construct('.json_encode($mopname).');
																								obj.addModeOfPayment('.$post_ids[$i]['accounts']['due_id'][$j].',1,'.json_encode($mopname).');
																						});
																						$("#mod_pay_'.$post_ids[$i]['accounts']['due_id'][$j].'_1").on("change",function(){
																							var obj = new controlAccountFee();
																							obj.ShowTextBox(1,'.$post_ids[$i]['accounts']['due_id'][$j].');
																						});
																					</script>
																				</div>
																			</div>
																		</div>
																		<div class="col-lg-12">&nbsp;</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-12">
																<strong><span id="amt_msg_'.$post_ids[$i]['accounts']['due_id'][$j].'" style="display:none; color:#FF0000; font-size:25px;">*</span>Total amount <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<input name="bal_amount_'.$post_ids[$i]['accounts']['due_id'][$j].'" type="text" readonly="readonly" class="form-control" value="'.$post_ids[$i]['accounts']['due_amount'][$j].'" id="bal_amount_'.$post_ids[$i]['accounts']['due_id'][$j].'"/>
																<input name="amount" type="hidden" class="form-control" value="'.$post_ids[$i]['accounts']['due_amount'][$j].'" id="amount_'.$post_ids[$i]['accounts']['due_id'][$j].'" readonly="readonly"/>
															</div>
															<div class="col-lg-12">&nbsp;</div>
														</div>
														<div class="row">
															<div class="col-lg-12">
																<input type="button" class="btn btn-large btn-default btn-block" id="save_'.$post_ids[$i]['accounts']['due_id'][$j].'" value="Save"/>
															</div>
														</div>
														<div id="keycodes_'.$post_ids[$i]['accounts']['due_id'][$j].'" style="display:none;">1</div>
														<script language="javascript" type="text/javascript" >
															
															$("#save_'.$post_ids[$i]['accounts']['due_id'][$j].'").on("click",function(){
																var obj = new controlAccountFee();
																obj.__construct('.json_encode($mopname).');
																obj.AddIndividualFeeDue('.$post_ids[$i]['accounts']['due_id'][$j].','.$i.');
															});
														</script>
													</div>
												</div>';
										}
									}
									$offerHtml .= '</div></div>';
								}
								else
								$offerHtml = '<h3>No Due</h3>';
							}
							break;
						}
						echo '<div class="panel panel-'.$the.'" id="list_user_'.$post_ids[$i]['id'].'">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_'.$post_ids[$i]['id'].'_'.$para["list_type"].'" id="coll_'.$post_ids[$i]['id'].'">
											<img class="img-circle" rel="tooltip" src="'.$post_ids[$i]['photo'].'" width="35" height="35" />&nbsp;'.$panelTitle.'
										</a>
									</h4>
								</div>
								<div id="collapse_'.$post_ids[$i]['id'].'_'.$para["list_type"].'" class="panel-collapse collapse">
								'.$offerHtml.'
								</div>
							</div>';
					}
					echo '</div></div></div></div></div>';
			
		}
		else{
			echo '<div class="row"><div class="col-lg-12">There are no customers available !!!!</div></div>';
		}
	}
	public function returnFeeSaveHtml($the,$index,$id,$jsfunction,$mopname = false){
		$startyear = date('Y');
		$endyear = date('Y')+2;
		$texbox = '';
		$ac = $mopname["ac"];
		for($p=0;$p<sizeof($mopname);$p++){
			if((strtolower($mopname["textbox"][$p]))!="cash")
				$texbox .= '<input name="mod_number_'.$id.'_1" type="text" placeholder="'.$mopname["textbox"][$p].' Number"    id="mop'.$mopname["id"][$p].'_'.$id.'_1"    class="form-control" style="display:none;"/>';
			
		}
		return '<div class="row text-'.$the.'">
					<div class="col-lg-12">
						<div id="add_mop_'.$id.'">
							<div class="row" id="usr_fee_row_'.$id.'_1">
								<div class="col-lg-12">
									<strong><span id="user_fee_msg_'.$id.'_1" style="display:none; color:#FF0000; font-size:25px;">*</span>Fee <i class="fa fa-caret-down"></i></strong>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<div class="col-md-4">
											<select name="mod_pay" id="mod_pay_'.$id.'_1" class="form-control">
											<option value="NULL">Select mode of payment</option>
											'.$mopname["htm"].'
											</select>
										</div>
										<div class="col-md-4">
											<input name="user_fee"   type="text" value="0"     id="user_fee_'.$id.'_1" class="form-control"/>
											'.$texbox.'
										</div>
										<div class="col-md-4">
											<a id="addmop_'.$id.'_1" class="btn btn-primary  btn-xs" href="javascript:void(0);"  onClick="$(this).hide();">Add</a>
											<script language="javascript" type="text/javascript" >
												$("#addmop_'.$id.'_1").on("click",function(){
														var obj = new controlAccountFee();
														obj.__construct('.json_encode($mopname).');
														obj.addModeOfPayment('.$id.',1,'.json_encode($mopname).');
												});
												$("#mod_pay_'.$id.'_1").on("change",function(){
													var obj = new controlAccountFee();
													obj.ShowTextBox(1,'.$id.');
												});
											</script>
										</div>
									</div>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row text-'.$the.'">
					<div class="col-lg-12">
						<strong><span id="amt_msg_'.$id.'" style="display:none; color:#FF0000; font-size:25px;">*</span>Total amount <i class="fa fa-caret-down"></i></strong>
					</div>
					<div class="col-lg-12">
						<input name="amount" type="text" class="form-control" placeholder="0.00" id="amount_'.$id.'" readonly="readonly"/>
					</div>
					<div class="col-lg-12">&nbsp;</div>
				</div>
				<div class="row text-'.$the.'">
					<div class="col-lg-12">
						<strong>Balance due amount <i class="fa fa-caret-down"></i></strong>
					</div>
					<div class="col-lg-12">
						<input name="bal_amount_'.$id.'" type="text" class="form-control" value="0" id="bal_amount_'.$id.'"/>
					</div>
					<div class="col-lg-12">&nbsp;</div>
				</div>
				<div class="row text-'.$the.'">
					<div class="col-lg-12">
						<strong><span id="duedate_msg_'.$id.'" style="display:none; color:#FF0000; font-size:25px;">*</span>Due date <i class="fa fa-caret-down"></i></strong>
					</div>
					<div class="col-lg-12">
						<input name="duedate" type="text" class="form-control" id="duedate_'.$id.'" readonly="readonly"/>
						
					</div>
					<div class="col-lg-12">&nbsp;</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<input type="button" id="save'.$id.'" class="btn btn-large btn-'.$the.' btn-block" value="Save"/>
					</div>
				</div>
				<script language="javascript" type="text/javascript" >
					$( "#duedate_'.$id.'" ).datepicker({
						dateFormat: "yy-mm-dd",
						changeMonth: true,
						changeYear: true,
						minDate: 0,
						yearRange:\''.$startyear.':'. $endyear.'\'
					});
					$("#coll_'.$id.'").on("click",function(){
						window.setTimeout(function(){
							var scr_top = $("#list_user_'.$id.'").offset().top - Number(50);
							$("html, body").animate({scrollTop: scr_top}, "slow");
						},800);
					});
					$("#save'.$id.'").on("click",function(){
						var obj = new controlAccountFee();
						obj.__construct('.json_encode($mopname).');
						obj.'.$jsfunction.'('.$id.','.$index.');
					});
				</script>';
	}
	public function returnLastExpDate($uid,$fact_type = false){
		$date = NULL;
		if($fact_type != false)
			$query = 'SELECT STR_TO_DATE(`valid_till`,\'%Y-%m-%d\') AS exp_date
					  FROM `fee`
					  WHERE `customer_pk` IN (SELECT `id` FROM `customer` WHERE `id` = \''.mysql_real_escape_string($uid).'\')
					  AND `offer_id` IN (SELECT `id` FROM `offers` WHERE `facility_id` = \''.$fact_type.'\')
					  ORDER BY `id` DESC
					  LIMIT 1;';
		else
			$query = 'SELECT STR_TO_DATE(`valid_till`,\'%Y-%m-%d\') AS exp_date
					  FROM `fee`
					  WHERE `customer_pk` IN (SELECT `id` FROM `customer` WHERE `id` = \''.mysql_real_escape_string($uid).'\')
					  ORDER BY `id` DESC
					  LIMIT 1;';
		$res = executeQuery($query);
		if(mysql_num_rows($res) > 0){
			$date = mysql_result($res,0);
		}
		return $date;
	}
	public function returnJndHtml($parameters){
		$jndHtml = 'NONE';
		$maxDate = 0;
		switch($parameters["list_type"]){
			case "offer":
				$curr_day = (int)date('d');
				$curr_month = (int)date('m');
				$curr_year = (int)date('Y');
				$curr_sum = (int) strtotime($curr_day.'-'.$curr_month.'-'.$curr_year);
				$temp1 = explode("-",$parameters["joining_date"]);
				$y = (int)$temp1[0];
				$m = (int)$temp1[1];
				$d = (int)$temp1[2];
				$validt = (int)strtotime($d.'-'.$m.'-'.$y);
				if($curr_sum < $validt){
					$obj1 = new DATECALC($d,$m,$y); //previous valid till date
					$obj2 = new DATECALC($curr_day,$curr_month,$curr_year); //joining date
					$maxDate += $obj1->SubtractTwoDates($obj2);
					$maxDate *= 1;
				}
				else if($curr_sum > $validt){
					$obj1 = new DATECALC($d,$m,$y); //previous valid till date
					$obj2 = new DATECALC($curr_day,$curr_month,$curr_year); //joining date
					$maxDate += $obj2->SubtractTwoDates($obj1);
					$maxDate *= -1;
				}
				else if($curr_sum == $validt){
					$maxDate = 'null';
				}
			break;
			case "package":
				$maxDate = 0;
			break;
			default:
				$jndHtml = '';
			break;
		}
		if($jndHtml == 'NONE')
			$jndHtml = '<span>
							<input name="joindate" type="text" class="form-control" id="joindate_'.$parameters["id"].'" readonly="readonly"/>
						</span>
						<span>
							<input type="text" id="alternate_'.$parameters["id"].'" size="30" readonly="readonly" class="form-control" />
						</span>
						<script language="javascript" type="text/javascript" >
							$("#joindate_'.$parameters["id"].'").datepicker({
								dateFormat: \'yy-mm-dd\',
								changeYear: true,
								changeMonth: true,
								altField: \'#alternate_'.$parameters["id"].'\',
								altFormat: \'DD, d MM, yy\',
								minDate:'.$maxDate.',
								setDate: \''.$parameters["joining_date"].'\',
								yearRange:\''.$parameters["startyear"].':'.$parameters["endyear"].'\'
							});
							$("#joindate_'.$parameters["id"].'").datepicker("setDate",\''.$parameters["joining_date"].'\');
						</script>';
		return '<div class="row">
					<div class="col-lg-12">
						<strong>
							<span id="joindate_msg_'.$parameters["id"].'" style="display:none; color:#FF0000; font-size:25px;">*</span>Joining date <i class="fa fa-caret-down"></i>
						</strong>
					</div>
					<div class="col-lg-12">
						'.$jndHtml.'
					</div>
					<div class="col-lg-12">&nbsp;</div>
				</div>';
	}
	public function returnListedOffers($id,$i,$jsfunction){
		$listofoffers = '';
		if($_SESSION['listofoffers'] != NULL && isset($_SESSION['listofoffers'])){
			for($k=1;$k<=sizeof($_SESSION['listofoffers']);$k++){
				$listofoffers .= '<option value="'.$_SESSION['listofoffers'][$k]['id'].'">'.$_SESSION['listofoffers'][$k]['facility_name'].' - '.$_SESSION['listofoffers'][$k]['name'].' - '.$_SESSION['listofoffers'][$k]['duration'].' - '.$_SESSION['listofoffers'][$k]['cost'].'</option>';
			}
		}
		else
			$listofoffers = '<option value="NULL">No offers available</option>';
		return '<div class="row">
					<div class="col-lg-12">
						<strong>
							<span id="offer_msg_'.$id.'" style="display:none; color:#FF0000; font-size:25px;">*</span>Select offer <i class="fa fa-caret-down"></i>
						</strong>
					</div>
				<div class="col-lg-12">
					<select name="offer" class="form-control" id="offer_'.$id.'">
						<option value="NULL">Select a offer</option>
						'.$listofoffers.'
					</select>
				</div>
				<div class="col-lg-12">&nbsp;</div>
				</div>
				<script language="javascript" type="text/javascript" >
				$("#offer_'.$id.'").on("change",function(){
						var obj = new controlAccountFee();
						obj.'.$jsfunction.'(this,'.$id.','.$i.');
					});
				</script>
				';
	}
	public function returnListedPackages($id,$i){
	$listofpacakages = '';
	if(isset($_SESSION['pacakages']) && $_SESSION['pacakages'] != NULL){
		$pacakages = $_SESSION['pacakages'];
		for($i=1;$i<=sizeof($pacakages);$i++){
			$listofpacakages .= '<option value="'.$pacakages[$i]['id'].'">'.$pacakages[$i]['package_name'].' - '.$pacakages[$i]['number_of_sessions'].' - '.$pacakages[$i]['cost'].'</option>';
		}
	}
	else
		$listofpacakages = '<option value="NULL">No packages available</option>';
	return '<div class="row">
			<div class="col-lg-12">
				<strong><span id="offer_msg_'.$id.'" style="display:none; color:#FF0000; font-size:25px;">*</span>Select package <i class="fa fa-caret-down"></i></strong>
			</div>
			<div class="col-lg-12">
				<select name="offer" class="form-control" id="offer_'.$id.'">
					<option value="NULL">Select a package</option>
					'.$listofpacakages.'
				</select>
			</div>
			<div class="col-lg-12">&nbsp;</div>
		</div>
		<script language="javascript" type="text/javascript" >
		$("#offer_'.$id.'").on("change",function(){
				var obj = new controlAccountFee();
				obj.SetIndivisualAmt(this,'.$id.','.$i.');
			});
		</script>
		';
	}
	public function returnModOfPayment(){
		$moptype = NULL;
		$jsonmoptype = NULL;
		$num = 0;
		$query = 'SELECT `id`, `name` AS vtype FROM `mode_of_payment` WHERE `status` = (SELECT `id` FROM `status` WHERE `statu_name`="Show");';
		$res = executeQuery($query);
		if(mysql_num_rows($res) > 0){
			while($row = mysql_fetch_assoc($res)){
				$moptype[] = $row;
			}
		}
		if(is_array($moptype))
			$num = sizeof($moptype);
		if($num){
			for($i=0;$i<$num;$i++){
				$jsonmoptype[] = array(
					"html" => '<option  value="'.$moptype[$i]["id"].'" >'.$moptype[$i]["vtype"].'</option>',
					"mopname" => $moptype[$i]["vtype"],
					"id" => $moptype[$i]["id"],
				);
			}
		}
		return $jsonmoptype;
	}
	public function getOffers($min_mem=false,$offer_id = false,$fct_type = false){
		$offers = false;
		if($offer_id){
			$query = 'SELECT ofr.*,ofd.`duration`,fnm.`name` AS fname FROM `offers` as ofr
				LEFT JOIN `offerduration` AS ofd ON ofd.`id` = ofr.`duration_id`
				LEFT JOIN `facility` AS fnm ON fnm.`id` = ofr.`facility_id`
				WHERE ofr.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 )
				AND ofr.`id` = \''.mysql_real_escape_string($offer_id).'\'
				AND ofr.`facility_id`=\''.$fct_type.'\';';
			$res = executeQuery($query);
			if(mysql_num_rows($res)){
				$offers = mysql_fetch_assoc($res);
			}
			else
				$offers = NULL;
		}
		else{
			if($min_mem == 1){
				$min_mem = '`min_members` = \''.mysql_real_escape_string($min_mem).'\'';
			}
			else if($min_mem == 2){
				$min_mem = '`min_members` >= \''.mysql_real_escape_string($min_mem).'\'';
			}
			$query = 'SELECT ofr.*,ofd.`duration`,fnm.`name` AS fname FROM `offers` as ofr
				LEFT JOIN `offerduration` AS ofd ON ofd.`id` = ofr.`duration_id`
				LEFT JOIN `facility` AS fnm ON fnm.`id` = ofr.`facility_id`
				WHERE ofr.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 )
				AND ofr.'.$min_mem.'
				AND ofr.`facility_id`=\''.$fct_type.'\';';
			$res = executeQuery($query);
			if(mysql_num_rows($res)){
				$i = 1;
				while($row = mysql_fetch_assoc($res)){
					$offers[$i]['id'] = $row['id'];
					$offers[$i]['name'] = $row['name'];
					$offers[$i]['duration'] = $row['duration'];
					$offers[$i]['num_of_days'] = $row['num_of_days'];
					$offers[$i]['facility_type'] = $row['facility_id'];
					$offers[$i]['facility_name'] = $row['fname'];
					$offers[$i]['description'] = $row['description'];
					$offers[$i]['cost'] = $row['cost'];
					$offers[$i]['status'] = $row['status'];
					$offers[$i]['min_members'] = $row['min_members'];
					$i++;
				}
			}
			else
				$offers = NULL;
		}
		return $offers;
	}
	public function AddIndividualFee($parameters){
		require_once(DOC_ROOT.INC.'FirePHPCore/FirePHP.class.php');
$console_php = FirePHP::getInstance(true);

		$obj = new account();
		$flag = false;
		$num = 0;
		$receiptno = '';
		$feehtml = '';
		$invoice = '';
		$query = '';
		$pk_id = 0;
		$res = 0;
		$dirparameters = array(
			"filename" => "",
			"directory" => "",
			"filedirectory" => "",
			"urlpath" => "",
			"url" => "",
			
		);
		$futureExpDate = array(
			"email" 		=> $parameters["id"],
			"fct_type" 		=> $parameters["fct_type"],
			"offer" 		=> $parameters["offer"],
			"num_of_days" 	=> 0,
			"joining_date" 	=> $parameters["joining_date"],
			"offerrow" 		=> ($_SESSION['listofoffers'] != NULL && isset($_SESSION['listofoffers'])) ? $_SESSION['listofoffers'] : NULL,
			"valid_till" 	=> array()
		);
		$feercpt = array(
			"msg"	=> '<span class="text-danger">Failure !!! Critical error occured!!!</span>',
			"rcpturl" => '',
			"flag"	=> '',
		);
		$cleared=getStatusId("cleared");
		$default=getStatusId("default");
		$curr_time = mysql_result(executeQuery("SELECT NOW();"),0);
		$receiptno = sprintf("%010s",mysql_result(executeQuery('SELECT COUNT(DISTINCT(`receipt_no`)) FROM `money_transactions`;'),0)+1);
		executeQuery("SET AUTOCOMMIT=0;");
		executeQuery("START TRANSACTION;");
		switch($parameters["list_type"]){
			case "offer":
				$obj -> returnFutureExpDate($futureExpDate);
				$query = 'INSERT INTO `fee`(`id`,
						`offer_id`,
						`no_of_days`,
						`payment_date`,
						`valid_from`,
						`valid_till`,
						`amount`,
						`mode_of_payment_id`,
						`receipt_no`,
						`customer_pk`
						)VALUES(
						NULL,
						\''.mysql_real_escape_string($parameters["offer"]).'\',
						\''.mysql_real_escape_string($futureExpDate["num_of_days"]).'\',
						\''.mysql_real_escape_string($curr_time).'\',
						\''.mysql_real_escape_string($parameters["joining_date"]).'\',
						\''.mysql_real_escape_string($futureExpDate["valid_till"]).'\',
						0,
						NULL,
						\''.mysql_real_escape_string($receiptno).'\',
						\''.mysql_real_escape_string($parameters["id"]).'\');';
				$res = executeQuery($query);
				$pk_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
			break;
			case "package":
				$query = 'INSERT INTO`fee_packages`(`id`,
						`customer_pk`,
						`package_id`,
						`payment_date`,
						`num_sessions`,
						`amount`,
						`mode_of_payment_id`,
						`receipt_no`
						)VALUES(
						NULL,
						\''.mysql_real_escape_string($parameters["id"]).'\',
						\''.mysql_real_escape_string($parameters["offer"]).'\',
						\''.mysql_real_escape_string($curr_time).'\',
						0,
						0,
						NULL,
						\''.mysql_real_escape_string($receiptno).'\');';						
				$res = executeQuery($query);
				$pk_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
			break;
			default:
				$query = "UPDATE `money_trans_due`
							SET `status`= '".mysql_real_escape_string($cleared)."'
							WHERE `id`= '".mysql_real_escape_string($parameters["id"])."';";
				$res = executeQuery($query);
				$pk_id = $parameters["id"];
				$console_php->log("pk = ".$pk_id . " - Res - " . $res);
			break;
		}
		if($res && $pk_id){
			$console_php->log("Enter1");
			$query = 'INSERT INTO  `money_transactions` (`id`,`mop_id`,`customer_pk`,`pay_date`,`transaction_type`,`receipt_no`,`transaction_id`,`transaction_number`,`total_amount`)  VALUES';
			for($i=0;$i<sizeof($parameters["amount"]) && isset($parameters["amount"][$i]) && $parameters["amount"][$i] != '' && isset($parameters["mod_pay"][$i]) && $parameters["mod_pay"][$i] != '';$i++){
				if($i == sizeof($parameters["mod_pay"])-1)
					$query .= '(NULL,
					\''.mysql_result(executeQuery('SELECT `id` FROM `mode_of_payment` WHERE `id`= \''.mysql_real_escape_string($parameters["mod_pay"][$i]).'\';'),0).'\',
					\''.mysql_real_escape_string($parameters["id"]).'\',
					STR_TO_DATE(\''.$curr_time.'\',\'%Y-%m-%d\'),
					\''.mysql_real_escape_string($parameters["transaction_type"]).'\',
					\''.mysql_real_escape_string($receiptno).'\',
					'.$pk_id.',
					\''.mysql_real_escape_string($parameters["transaction_number"][$i]).'\',
					\''.mysql_real_escape_string($parameters["amount"][$i]).'\');';
				else
					$query .= '(NULL,
						\''.mysql_result(executeQuery('SELECT `id` FROM `mode_of_payment` WHERE `id`= \''.mysql_real_escape_string($parameters["mod_pay"][$i]).'\';'),0).'\',
						\''.mysql_real_escape_string($parameters["id"]).'\',
						STR_TO_DATE(\''.$curr_time.'\',\'%Y-%m-%d\'),
						\''.mysql_real_escape_string($parameters["transaction_type"]).'\',
						\''.mysql_real_escape_string($receiptno).'\',
						'.$pk_id.',
						\''.mysql_real_escape_string($parameters["transaction_number"][$i]).'\',
						\''.mysql_real_escape_string($parameters["amount"][$i]).'\'),';
				 $parameters["total"] += $parameters["amount"][$i];
				if($parameters["transaction_number"][$i] == '')
					$parameters["transaction_number"][$i] = 'Cash';
				$feehtml .= '<tr>
							<td align="right" style="border-bottom: solid 1px;">'.$parameters["mod_pay"][$i].' :</td>
							<td width="139" align="right" style="border-bottom: solid 1px;">'.$parameters["transaction_number"][$i].'</td>
							<td width="84" align="right" style="border-bottom: solid 1px;">'.$parameters["amount"][$i].' '.CURRENCY_SYM_1X .'</td>
							</tr>';
			}
			$res = executeQuery($query);
			$console_php->log(" - Res - " . $res);
			if($res){
				$console_php->log("Enter 2");
				$transc_id = mysql_result(executeQuery("SELECT LAST_INSERT_ID();"),0);	
				if($parameters["due_amt"] > 0 && $parameters["due_date"]){
					$query = 'INSERT INTO  `money_trans_due` (`id`,`money_trans_id`,`customer_pk`,`due_date`,`due_amount`,`status`)  VALUES(
							NULL,
							\''.mysql_real_escape_string($transc_id).'\',
							\''.mysql_real_escape_string($parameters["id"]).'\',
							\''.mysql_real_escape_string($parameters["due_date"]).'\',
							\''.mysql_real_escape_string($parameters["due_amt"]).'\',
							\''.mysql_real_escape_string($default).'\');';
					$res = executeQuery($query);
					$parameters["due_date"] = date('j-M-Y', strtotime($parameters["due_date"]));
				}
				else{
					$res = 1;
					$parameters["due_amt"] = sprintf("%4s",0);
					$parameters["due_date"] = '--------';
				}
				if($res){
					$obj -> returnDirectoryReceipt($dirparameters,$parameters,$pk_id);
					if($dirparameters["directory"]){
						$query = 'INSERT INTO  `invoice` (`id`,`customer_pk`,`transaction_id`,`name`,`location`)  VALUES(
								NULL,
								\''.mysql_real_escape_string($parameters["id"]).'\',
								\''.mysql_real_escape_string($transc_id).'\',
								\''.mysql_real_escape_string($parameters["transaction_type"]).'\',
								\''.mysql_real_escape_string($dirparameters["url"]).'\');';
						$res = executeQuery($query);
						if($res){
								executeQuery("COMMIT");
								$gymDetail = array();
								$row = $obj -> returnUserDetails($parameters);
								$numToWord = $obj -> convert_number_to_words($parameters["total"])." ".CURRENCY_SYM_1X;
								$gymDetail = fetchAddress($parameters["GYMID"]);
								$offertype = str_replace($parameters["fct_type"],$parameters["fname"],$parameters["transaction_type"]);
							if($row != NULL){
								if (!file_exists($row['photo']))
									$row['photo'] = USER_ANON_IMAGE;
								if (!file_exists($gymDetail["gympic"]))									
									$gymDetail["gympic"] = GYM_ANON_IMAGE;
								$receipt = array(
									"css" 			=> "<link href='".URL.ASSET_DIR."font-awesome-4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css' />",
									"title" 		=> $offertype. "-Invoice",
									"invoiceno" 	=> $receiptno,
									"invoicedate" 	=> date('j-M-Y', strtotime($curr_time)),
									"gym_logo" 		=> $gymDetail["gympic"],
									"gym_address"	=> $gymDetail["add"],
									"user_name" 	=> $row['name'],
									"user_email" 	=> $row['email'],
									"user_photo" 	=> $row['photo'],
									"user_cell" 	=> $row['cell_number'],
									"user_dob" 		=> $row['dob'],
									"user_reg_date" => date('j-M-Y', strtotime($row['date_of_join'])),
									"user_jn_date" 	=> date('j-M-Y', strtotime($parameters["joining_date"])),
									"user_exp_date" => date('j-M-Y', strtotime(is_array($futureExpDate["valid_till"])?"":$futureExpDate["valid_till"])),
									"user_address" 	=> $row['address'],
									"user_emr_name" => $row['emergency_name'],
									"user_emr_cell" => $row['emergency_num'],
									"user_company" 	=> $row['company'],
									"offer_package" => $offertype,
									"fee" 			=> ($parameters["total"] - floor(ST_PER * $parameters["total"]))." ".CURRENCY_SYM_1X,
									"service_tax" 	=> floor(ST_PER * $parameters["total"])." ".CURRENCY_SYM_1X,
									"fee_total" 	=> $parameters["total"]." ".CURRENCY_SYM_1X,
									"fee_in_words" 	=> $numToWord,
									"due_amt" 		=> $parameters["due_amt"]." ".CURRENCY_SYM_1X,
									"due_date" 		=> date('j-M-Y', strtotime($parameters["due_date"])),
									"feehtml"		=> $feehtml
								);
								$invoice = $obj -> generateReciept($receipt);
								$fh = fopen($dirparameters["filedirectory"], 'w');
								fwrite($fh, $invoice);
								fclose($fh);
								if(isset($_SESSION['SourceEmailIds'])){
									$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
									$from = $_SESSION['SourceEmailIds'][$index]['email'];
									// $fpass = $_SESSION['SourceEmailIds'][$index]['password'];
								}
								else{
									$from = MAILUSER;
									// $fpass = MAILPASS;
								}
								$flag = true;
							}
						}
					}
				}
			}
		}
		if($flag){
			$_SESSION['invoice_url'] = $dirparameters["urlpath"];
			$_SESSION['invoice'] = $invoice;
			$message = $invoice.'<p>&nbsp;</p>
							<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td colspan="2">
									<span style="font-weight:900; font-size:24px;  color:#999;">'.$parameters["GYMNAME"].' payment details.</span>
								</td>
							</tr>
							<tr>
								<td colspan="2">Advertise</td>
							</tr>
							<tr>
								<td colspan="2">Regards,<br>The MadMec team</td>
							</tr>
							<tr>
								<td colspan="2"><p><a href="https://www.facebook.com/madmec2013"><img src="http://code.madmec.com/images/f_logo.jpg" alt="" width="40" height="40" /></a> <a href="http://www.linkedin.com/company/madmec"><img src="http://code.madmec.com/images/li.jpg" alt="" width="40" height="40" /></a> <a href="http://madmecteam.blogspot.in/2013_12_01_archive.html"><img src="http://code.madmec.com/images/bs.jpg" alt="" width="40" height="40" /></a> <a href="https://plus.google.com/103775735801000838114/posts"><img src="http://code.madmec.com/images/gp.jpg" alt="" width="40" height="40" /></a> <a href="https://www.google.co.in/maps/place/MadMec/@12.898059,77.588587,17z/data=!3m1!4b1!4m2!3m1!1s0x3bae153e3a2818d3:0x90da24ba7189f291"><img src="http://code.madmec.com/images/map.jpg" alt="" width="40" height="40" /></a></p></td>
							</tr>
							<tr>
								<td colspan="2"><p><h4>Do not reply to this mail.</h4></p></td>
							</tr>
						</table>
						';
			$msg_sub = $parameters["GYMNAME"]." : Your ".$parameters["fct_type"]." fee payment ".$offertype." invoice.";
			$mailParameters = array(
				"server" 		=> mt_rand(0,2),
				"name" 			=> $receipt["user_name"],
				"target_host" 	=> explode("@",$parameters["email"])[1],
				"to" 			=> $parameters["email"],
				"title" 		=> $parameters["GYMNAME"],
				"subject" 		=> $msg_sub,
				"message" 		=> $message,
				"message_type" 	=> "Approval"
			);
			//~ $MailConfig = $obj -> Alert($mailParameters);
			//~ if(is_array($MailConfig)){
				//~ $from = $MailConfig["username"];
				//~ $query0 = "INSERT INTO `crm_email`(`id`,`from`,`from_email`, `to_email`, `subject`, `text`, `msg_type`, `date`, `status`)VALUES (NULL,'automatic','".mysql_real_escape_string($from)."','".mysql_real_escape_string($parameters["email"])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($dirparameters["url"])."',3,NOW(),'sent');";
				//~ executeQuery($query0);
			//~ }
			$feercpt["msg"] = '<center><h2><a id="print_invoice_'.$_POST['indfee']['id'].'" href="javascript:void(0);">Print the receipt</a></h2></center>';
		}
		else{
			$_SESSION['invoice_url'] = NULL;
			$_SESSION['invoice'] = NULL;
		}
			//~ if(get_resource_type($link) == 'mysql link')
				//~ mysql_close($link);
			//~ /* Call the procedure to change user_pk in fee and fee related table */
			//~ $dbnam = DBNAME_ZERO;
			//~ $dsn = 'mysql:dbname='.DBNAME_ZERO.';host='.DBHOST;
			//~ $dbh = '';
			//~ try {
				//~ $dbh = new PDO($dsn, DBUSER, DBPASS);
			//~ }
			//~ catch (PDOException $e) {
				//~ exit(0);
			//~ }
			//~ $stmt = $dbh->prepare("CALL ModifyUserTablesCMS(?);");
			//~ $stmt->bindParam(1, $dbnam, PDO::PARAM_STR);
			//~ $stmt->execute();
		$feercpt["rcpturl"] = $dirparameters["urlpath"];
		$feercpt["flag"] = $flag;
		return $feercpt;
	}
	public function returnFutureExpDate(& $futureExpDate){
		$temp = explode("-",$futureExpDate["joining_date"]);
		$year = (int)$temp[0];
		$month = (int)$temp[1];
		$day = (int)$temp[2];
		$curr_day = (int)date('d');
		$curr_month = (int)date('m');
		$curr_year = (int)date('Y');
		$join_date = new DATECALC($day,$month,$year);
		$query = 'SELECT * FROM `fee`
					WHERE `customer_pk` = \''.mysql_real_escape_string($futureExpDate["email"]).'\'
					AND `offer_id` IN (
										SELECT `id` FROM `offers`
										WHERE `facility_id`=\''.mysql_real_escape_string($futureExpDate["fct_type"]).'\'
									  );';
		$res = executeQuery($query);
		$num = mysql_num_rows($res);
		if($num){
			$valid_till = array();
			$i = 1;
			while($row = mysql_fetch_assoc($res)){
				$valid_till['valid_till'][$i] = date('Y-m-d', strtotime($row['valid_till']));
				$valid_till['valid_from'][$i] = date('Y-m-d', strtotime($row['valid_from']));
				$valid_till['no_of_days'][$i] = (int)$row['no_of_days'];
				$i++;
			}
			if(sizeof($valid_till) > 0){
				$curr_sum = (int) strtotime($curr_day.'-'.$curr_month.'-'.$curr_year);
				for($i=1; $i<=$num;$i++){
					$temp0 = explode("-",$valid_till['valid_from'][$i]);
					$y0 = (int)$temp0[0];
					$m0 = (int)$temp0[1];
					$d0 = (int)$temp0[2];
					$validf = (int)strtotime($d0.'-'.$m0.'-'.$y0);
					$temp1 = explode("-",$valid_till['valid_till'][$i]);
					$y = (int)$temp1[0];
					$m = (int)$temp1[1];
					$d = (int)$temp1[2];
					$validt = (int)strtotime($d.'-'.$m.'-'.$y);
					if($curr_sum <= $validf && $curr_sum < $validt){
						if($validf < $validt){
							$obj1 = new DATECALC($d,$m,$y); //valid till
							$obj2 = new DATECALC($d0,$m0,$y0); //valid from date
							$futureExpDate["num_of_days"] += $obj1->SubtractTwoDates($obj2);
							if($futureExpDate["num_of_days"] == 28 || $futureExpDate["num_of_days"] == 29)
								$futureExpDate["num_of_days"] += 30;
						}
						else if($validf == $validt)
							$futureExpDate["num_of_days"] += 1;
						else
							$futureExpDate["num_of_days"] += 0;
					}
					else if($curr_sum > $validf && $curr_sum <= $validt){
						if($curr_sum < $validt){
							$obj1 = new DATECALC($d,$m,$y); //previous valid till date
							$obj2 = new DATECALC($curr_day,$curr_month,$curr_year); //joining date
							$futureExpDate["num_of_days"] += $obj1->SubtractTwoDates($obj2);
							if($futureExpDate["num_of_days"] == 28 || $futureExpDate["num_of_days"] == 29)
								$futureExpDate["num_of_days"] += 30;
						}
						else if($curr_sum == $validt)
							$futureExpDate["num_of_days"] += 1;
						else
							$futureExpDate["num_of_days"] += 0;
					}
					else if($curr_sum > $validf && $curr_sum > $validt){
						$futureExpDate["num_of_days"] += 0;
					}
				}
			}
		}
		for($loop=1;$loop<=sizeof($futureExpDate["offerrow"]) && isset($futureExpDate["offerrow"]);$loop++){
			if($futureExpDate["offerrow"][$loop]['id'] == $futureExpDate["offer"]){
				if($futureExpDate["offerrow"][$loop]['duration'] == 'Quarterly'){
					$futureExpDate["num_of_days"] += 90;
					$futureExpDate["valid_till"] = $join_date->MysqlDateReturn($join_date->AddDays(90));
				}
				else if($futureExpDate["offerrow"][$loop]['duration'] == 'Half yearly'){
					$futureExpDate["num_of_days"] += 180;
					$futureExpDate["valid_till"] = $join_date->MysqlDateReturn($join_date->AddDays(180));
				}
				else if($futureExpDate["offerrow"][$loop]['duration'] == 'Annually'){
					if($join_date->LeapYear($year)){
						$futureExpDate["num_of_days"] += 366;
						$futureExpDate["valid_till"] = $join_date->MysqlDateReturn($join_date->AddDays(366));
					}
					else{
						$futureExpDate["num_of_days"] += 365;
						$futureExpDate["valid_till"] = $join_date->MysqlDateReturn($join_date->AddDays(365));
					}
				}
				else{
					// $futureExpDate["num_of_days"] = DATECALC::$months[$month];
					$futureExpDate["num_of_days"] += 30;
					$futureExpDate["valid_till"] = $join_date->MysqlDateReturn($join_date->AddDays(30));
				}
				break;
			}
		}
	}
	public function returnDirectoryReceipt(& $dirparameters,$parameters,$pk_id){
		$dirparameters["filename"] = md5(rand(999,999999).microtime()).'_'.str_replace(" ","_",$parameters["transaction_type"]).'_'.$pk_id.'.html';
		$query = 'SELECT `directory` FROM `customer` WHERE `id`=\''.mysql_real_escape_string($parameters["email"]).'\';';
		$res = executeQuery($query);
		if(mysql_num_rows($res)){
			$dirparameters["directory"] = mysql_result($res,0);
		}
		if($dirparameters["directory"]){
			$dirparameters["filedirectory"] = DOC_ROOT.ASSET_DIR.$dirparameters["directory"].'/profile/'.$dirparameters["filename"];
			$dirparameters["urlpath"] = URL.ASSET_DIR.$dirparameters["directory"].'/profile/'.$dirparameters["filename"];
			$dirparameters["url"] = ASSET_DIR.$dirparameters["directory"].'/profile/'.$dirparameters["filename"];
		}
		else{
			/* Create directory if does not exist */
			$dirparameters["directory"] = md5(date('h-i-s,_j-m-y,_it_is_w_Day_u').rand(999,999999).microtime()).'_'.$pk_id;
			$dirparameters["directory"] = createdirectories($dirparameters["directory"]);
			$dirparameters["filedirectory"] = DOC_ROOT.ASSET_DIR.$dirparameters["directory"].'/profile/'.$dirparameters["filename"];
			$dirparameters["urlpath"] = URL.ASSET_DIR.$dirparameters["directory"].'/profile/'.$dirparameters["filename"];
			$dirparameters["url"] = ASSET_DIR.$dirparameters["directory"].'/profile/'.$dirparameters["filename"];
			/* Update the directory in users table */
			$query = 'UPDATE `customer` SET `directory` = \''.$dirparameters["directory"].'\' WHERE `id`=\''.mysql_real_escape_string($parameters["email"]).'\';';
			executeQuery($query);
		}
	}
	public function returnUserDetails($parameters){
		$query = 'SELECT
					ur.`name`,
					ur.`email`,
					CASE WHEN ur.`photo_id` IS NULL
						 THEN \''.USER_ANON_IMAGE.'\'
						 ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph3.`ver3`)
					END AS photo,
					CASE
						WHEN ur.`cell_number` IS NULL
							THEN \'Not Provided\'
						ELSE
							CASE WHEN LENGTH(ur.`cell_number`) = 0
								THEN \'Not Provided\'
								ELSE CONCAT(\'+91 \',ur.`cell_number`)
							END
					END AS cell_number,
					CASE
						WHEN ur.`occupation` IS NULL
						THEN \'Not Provided\'
						ELSE
							CASE  WHEN LENGTH(ur.`occupation`) = 0
								THEN \'Not Provided\'
								ELSE  ur.`occupation`
							END
					END AS occupation,
					CASE
						WHEN ur.`company` IS NULL
						THEN \'Not Provided\'
						ELSE
							CASE
								WHEN LENGTH(ur.`company`) = 0
								THEN \'Not Provided\'
								ELSE ur.`company`
							END
					END AS company,
					CASE
						WHEN ur.`dob` IS NULL
						THEN \'Not Provided\'
						ELSE
							CASE
								WHEN LENGTH(ur.`dob`) = 0
								THEN \'Not Provided\'
								ELSE DATE_FORMAT(ur.`dob`, \'%d-%b-%Y\')
							END
					END AS dob,
					DATE_FORMAT(ur.`date_of_join`, \'%d-%b-%Y\') AS date_of_join,
					CASE
						WHEN ur.`emergency_name` IS NULL
						THEN \'Not Provided\'
						ELSE
							CASE
								WHEN LENGTH(ur.`emergency_name`) = 0
								THEN \'Not Provided\'
								ELSE ur.`emergency_name`
							END
					END AS emergency_name,
					CASE
						WHEN ur.`emergency_num` IS NULL
						THEN \'Not Provided\'
						ELSE
							CASE
								WHEN LENGTH(ur.`emergency_num`) = 0
								THEN \'Not Provided\'
								ELSE CONCAT(\'+91 \',ur.`emergency_num`)
							END
					END AS emergency_num,
					CASE
						WHEN ur.`address` IS NULL THEN \'Not Provided\'
						ELSE
							CASE
								WHEN LENGTH(ur.`address`) = 0
								THEN \'Not Provided\'
								ELSE REPLACE(ur.`address` , \'\n\',\', \')
							END
					END AS address
				FROM `customer` AS ur
				LEFT JOIN `photo` AS ph3 ON ur.`photo_id` = ph3.`id`
				WHERE (ur.`status`= (SELECT `id` FROM `status` WHERE `statu_name` = \'Registered\') OR ur.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = \'Joined\'))
				AND ur.`id`=\''.mysql_real_escape_string($parameters["id"]).'\';';
		$res = executeQuery($query);
		if(mysql_num_rows($res))
			return mysql_fetch_assoc($res);
		else
			return NULL;
	}
	public function generateReciept($receipt){
		return "<html>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		".$receipt["css"]."
		<title>".$receipt["title"]."</title>
		</head>
		<body>
		<table width='800' border='0' align='center' cellpadding='5' cellspacing='2' style='border: solid 1px; font-size:18px;'>
		<tr>
		<th colspan='2' align='center'>Invoice</th>
		</tr>
		<tr>
		<td width='430'>
		<div align='left' id='comp_logo'>
		<img height='100' width='100' src='".$receipt["user_photo"]."'></img>
		</div>
		Invoice no : <span style='color:red;'>".$receipt["invoiceno"]."</span><br />
		Invoice Date :&nbsp;<span><u>".$receipt["invoicedate"]."</u></span>
		</td>
		<td width='354'>
		<div align='right' id='comp_logo'>
		<img height='100' width='100' src='".$receipt["gym_logo"]."'></img>
		</div>
		<div id='comp_add' align='left'>
		".$receipt["gym_address"]."
		</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td>Reg Date :&nbsp;<span><u>".$receipt["user_reg_date"]."</u></span></td>
		<td>Start / Joining Date :&nbsp;<span><u>".$receipt["user_jn_date"]."</u></span></td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2'>Expiry Date :&nbsp;<span><u>".$receipt["user_exp_date"]."</u></span></td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Name of the member :&nbsp;</div>
		<div style='width:615px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>".$receipt["user_name"]."</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Address :&nbsp;</div>
		<div style='width:710px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>".$receipt["user_address"]."</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Cell number :&nbsp;</div>
		<div style='width:680px; float:right;border-bottom: dashed 1px;'>".$receipt["user_cell"]."</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Email id :&nbsp;</div>
		<div style='width:705px; float:right;border-bottom: dashed 1px;'>".$receipt["user_email"]."</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>DOB :&nbsp;</div>
		<div style='width:730px; float:right;border-bottom: dashed 1px;'>".$receipt["user_dob"]."</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Emergency name and number :&nbsp;</div>
		<div style='width:550px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>".$receipt["user_emr_name"].",  ".$receipt["user_emr_cell"]."</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Company :&nbsp;</div>
		<div style='width:700px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>".$receipt["user_company"]."</div>
		</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Offer / Package :&nbsp;</div>
		<div style='width:655px; float:right;border-bottom: dashed 1px;'>".$receipt["offer_package"]."</div>
		</td>
		</tr>
		<tr>
		<td colspan='2' align='center'>
		<table cellpadding='0' cellspacing='0' style='border: solid 1px; font-size:24px;' width='600'>
		<tr>
		<td style='border-bottom: solid 1px;' align='right'>".$receipt["offer_package"]." fee :</td>
		<td style='border-bottom: solid 1px;' align='right'>".$receipt["fee"]."</td>
		</tr>
		<tr>
		<td style='border-bottom: solid 1px;' align='right'>Service tax :</td>
		<td style='border-bottom: solid 1px;' align='right'>".$receipt["service_tax"]."</td>
		</tr>
		<tr>
		<td style='border-bottom: solid 1px;' align='right'>Total :</td>
		<td style='border-bottom: solid 1px;' align='right'>".$receipt["fee_total"]."</td>
		</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='float:left;'>Total amount (in words) :&nbsp;</div>
		<div style='width:590px; float:right;border-bottom: dashed 1px; text-transform:capitalize;'>".$receipt["fee_in_words"]."</div>
		</td>
		</tr>
		<tr>
		<td>
		<div style='float:left;'>Balance amt due :&nbsp;</div>
		<div style='width:285px; float:right;border-bottom: dashed 1px;'>".$receipt["due_amt"]."</div>
		</td>
		<td>
		<div style='float:left;'>Due date :&nbsp;</div>
		<div style='width:270px; float:right;border-bottom: dashed 1px;'>".$receipt["due_date"]."</div>
		</td>
		</tr>
		<tr>
		<td colspan='2' align='center'>
		<table cellpadding='0' cellspacing='0' style='border: solid 1px; font-size:24px;' width='400'>
		".$receipt["feehtml"]."
		</table>
		</td>
		</tr>
		<tr>
		<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2'>
		<div style='width:800px; float:right;border-bottom: dashed 1px;'>&nbsp;</div>
		</td>
		</tr>
		<tr>
		<td>
		Member signature
		</td>
		<td align='right'>
		Authorized signature
		</td>
		</tr>
		<tr>
		<td align='right'>
		Non-Transferable
		</td>
		<td>
		Non-Refundable
		</td>
		</tr>
		</table>
		</body>
		</html>";
	}
	public function convert_number_to_words($number) {
		$obj = new account();
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
			return $negative . $obj -> convert_number_to_words(abs($number));
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
					$string .= $conjunction . $obj -> convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $obj -> convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= $obj -> convert_number_to_words($remainder);
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
	public function Alert($mailParameters){
		$flag = false;
		$MailConfig = array();
		$mail = '';
		$transport = '';
		set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
		require_once(LIB_ROOT.MODULE_ZEND_1);
		require_once(LIB_ROOT.MODULE_ZEND_2);
		$mailParameters["server"] = 2;
		switch($mailParameters["server"]){
			case 0:
				$index = mt_rand(0,sizeof($_SESSION["GMAIL"])-1);
				$MailConfig = array(
					"host" 		=> GMAIL,
					"port" 		=> GMAIL_PORT,
					"ssl" 		=> "tls",
					"auth" 		=> "login",
					"username" 	=> $_SESSION["GMAIL"][$index]["email"],
					"password" 	=> $_SESSION["GMAIL"][$index]["password"]
				);
			break;
			case 1:
				$index = mt_rand(0,sizeof($_SESSION["BIGROCKMAILS"])-1);
				$MailConfig = array(
					"host" 		=> BIGROCK,
					"port" 		=> BIGROCK_PORT,
					"auth" 		=> "login",
					"username" 	=> $_SESSION["BIGROCKMAILS"][$index]["email"],
					"password" 	=> $_SESSION["BIGROCKMAILS"][$index]["password"]
				);
			break;
			case 2:
				$index = mt_rand(0,sizeof($_SESSION["GMAIL"])-1);
				$MailConfig = array(
					"host" 		=> GMAIL,
					"port" 		=> GMAIL_PORT,
					"ssl" 		=> "tls",
					"auth" 		=> "login",
					"username" 	=> $_SESSION["GMAIL"][$index]["email"],
					"password" 	=> $_SESSION["GMAIL"][$index]["password"]
				);
				// $index = mt_rand(0,sizeof($_SESSION["MADMECMAILS"])-1);
				// $MailConfig = array(
					// "host" 		=> MADMEC,
					// "port" 		=> MADMEC_PORT,
					// "auth" 		=> "login",
					// "username" 	=> $_SESSION["MADMECMAILS"][$index]["email"],
					// "password" 	=> $_SESSION["MADMECMAILS"][$index]["password"]
				// );
			break;
		}
		if($is_valid = filter_var($mailParameters["to"],FILTER_VALIDATE_EMAIL)){
			if($has_dns_mx_record = checkdnsrr($mailParameters["target_host"],"MX")){
				$transport = new Zend_Mail_Transport_Smtp($MailConfig["host"],$MailConfig);
				$mail = new Zend_Mail();
				$mail->setBodyHtml($mailParameters["message"]);
				$mail->setFrom($MailConfig["host"], $mailParameters["title"]);
				$mail->addTo($mailParameters["to"], $mailParameters["name"]);
				$mail->setSubject($mailParameters["subject"]);
				try{
					$mail->send($transport);
					unset($mail);
					unset($transport);
					$flag = true;
				}
				catch(exceptoin $e){
					echo "Error sending Email : ";
					$logger = Zend_Registry::get('Logger');
					$logger->err($e->getMessage());
					echo $e->getMessage() . "\n\n\n";
				}
			}
		}
		if($flag)
			return $MailConfig;
		else
			return $flag;
	}
	public function PayIndividualUserForm($parameters){
		$mop = new account();
		$mopname1= $mop -> returnModOfPayment();
		$mopname = array(
			"htm" => '',
			"textbox" => '',
			"id"	=>	'',
			"ac"	=> $parameters["ac"],
		);
		for($p=0;$p<sizeof($mopname1);$p++){
				$mopname["htm"] .= $mopname1[$p]["html"];
				$mopname["textbox"][$p] = $mopname1[$p]["mopname"];
				$mopname["id"][$p] = $mopname1[$p]["id"];
		}
		$obj = new account();		
		$post_ids = array();
		$startyear = date('Y');
		$endyear = date('Y')+2;
		$joining_date = date('Y-m-d');
		if(isset($_SESSION['listfeeusers']) && $_SESSION['listfeeusers'] != NULL)
			$post_ids = $_SESSION['listfeeusers'];
		else
			$post_ids = NULL;
		$the = $post_ids[$parameters["index"]]['theme'];
		$feeDueSaveHtml = $obj -> returnFeeSaveHtml($the,$parameters["index"],$post_ids[$parameters["index"]]['id'],'AddIndividualFee',$mopname);
		switch($parameters["list_type"]){
			case "offer":
				$joining_date = $obj -> returnLastExpDate($post_ids[$parameters["index"]]['id'],$parameters["fct_type"]);
				if($joining_date == NULL){
					$joining_date = date('Y-m-d');
				}
				$jndparameters = array(
					"id" 			=> 	$post_ids[$parameters["index"]]['id'],
					"joining_date" 	=> 	$joining_date,
					"startyear" 	=> 	$startyear,
					"endyear"		=> 	$endyear,
					"list_type"		=> 	$parameters["list_type"]
				);
				$jdatehtml = $obj -> returnJndHtml($jndparameters);
				$listofoffersHtml = $obj -> returnListedOffers($post_ids[$parameters["index"]]['id'],$parameters["index"],'SetIndivisualAmt');
				$offerHtml = '<div class="panel-body">
								<fieldset id="userdetails_'.$post_ids[$parameters["index"]]['id'].'">
									<div class="row text-'.$the.'">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-lg-12"><strong><span id="eml_msg_'.$post_ids[$parameters["index"]]['id'].'" style="display:none; color:#FF0000; font-size:25px;"	>*</span>Email id <i class="fa fa-caret-down"></i></strong></div>
												<div class="col-lg-12"><input  name="email" id="email_'.$post_ids[$parameters["index"]]['id'].'" type="text" class="form-control" value="'.$post_ids[$parameters["index"]]['email_id'].'" readonly="readonly" /></div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											'.$listofoffersHtml.'
											'.$jdatehtml.'
										</div>
									</div>
									'.$feeDueSaveHtml.'
								</fieldset>
								<div id="keycodes_'.$post_ids[$parameters["index"]]['id'].'" style="display:none;">1</div>
							</div>';
			break;
			case "package":
				$jndparameters = array(
					"id" 			=> 	$post_ids[$parameters["index"]]['id'],
					"joining_date" 	=> 	$joining_date,
					"startyear" 	=> 	$startyear,
					"endyear"		=> 	$endyear,
					"list_type"		=> 	$parameters["list_type"]
				);
				$jdatehtml = $obj -> returnJndHtml($jndparameters);
				$listofoffersHtml = $obj -> returnListedPackages($post_ids[$parameters["index"]]['id'],$parameters["index"]);
				$offerHtml = '<div class="panel-body">
								<fieldset id="userdetails_'.$post_ids[$parameters["index"]]['id'].'">
									<div class="row text-'.$the.'">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-lg-12"><strong><span id="eml_msg_'.$post_ids[$parameters["index"]]['id'].'" style="display:none; color:#FF0000; font-size:25px;"	>*</span>Email id <i class="fa fa-caret-down"></i></strong></div>
												<div class="col-lg-12"><input  name="email" id="email_'.$post_ids[$parameters["index"]]['id'].'" type="text" class="form-control" value="'.$post_ids[$parameters["index"]]['email_id'].'" readonly="readonly" /></div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											'.$listofoffersHtml.'
											'.$jdatehtml.'
										</div>
									</div>
									'.$feeDueSaveHtml.'
								</fieldset>
								<div id="keycodes_'.$post_ids[$parameters["index"]]['id'].'" style="display:none;">1</div>
							</div>';
			break;
			default:
				$offerHtml = '<strong>Due amount is cleared.</strong>';
			break;
		}
		echo $offerHtml.'<script language="javascript" type="text/javascript" >$("#exp_date_'.$post_ids[$parameters["index"]]['id'].'").text("['.date('j-M-Y', strtotime($joining_date)).']");</script>';
	}
	public function getPackages(){
		$packages = false;
		$query = 'SELECT pc.*,pnm.`package_name` FROM `packages` AS pc
					RIGHT JOIN `package_name` AS pnm ON pnm.`id` = pc.`package_type_id`
				WHERE pc.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = \'show\');';
		$res = executeQuery($query);
		if(mysql_num_rows($res)){
			$i = 1;
			$packages = array();
			while($row = mysql_fetch_assoc($res)){
				$packages[$i]['id'] = $row['id'];
				$packages[$i]['package_type'] = $row['package_type_id'];
				$packages[$i]['package_name'] = $row['package_name'];
				$packages[$i]['number_of_sessions'] = $row['number_of_sessions'];
				$packages[$i]['cost'] = $row['cost'];
				$packages[$i]['status'] = $row['status'];
				$i++;
			}
		}
		return $packages;
	}
	public function autoCompletePay(){
		$query = 'SELECT
					tr.`id` AS pk,
					tr.`user_name` AS name,
					tr.`email` AS email,
					tr.`cell_number` AS cell,
					CASE WHEN tr.`photo_id` IS NULL
						 THEN \''.TRAIN_ANON_IMAGE.'\'
						 ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph2.`ver3`)
					END AS photo
				FROM `employee` AS tr
				LEFT JOIN `photo` AS ph2 ON tr.`photo_id` = ph2.`id`
				WHERE tr.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Joined" AND `status` = 1)
				;';
			$res = executeQuery($query);
			if(mysql_num_rows($res) > 0){
				$i=0;
				while($row = mysql_fetch_assoc($res)){
					 $name[$i]["label"]=$row["name"]."-".$row["email"]."-".$row["cell"];
					 $name[$i]["value"]=$i;
					 $name[$i]["icon"]=$row["photo"];
					 $name[$i]["id"]=$row["pk"];
					 $i++;
				}
			}
			else
					$name='';
			$emp = array(
				"listofPeoples" => $name,
			);
			return $emp;
		}
	public function AddPayments(){
		$stfpay = array(
			"msg"	=> '<h2 style="colro:#FFFFFF;">Failure !!!</h2>Critical error occured!!!',
			"flag"	=> false,
		);
		$query = 'INSERT INTO `payments`(`id`,
										`name`,
										`customer_pk`,
										`amount`,
										`pay_date`,
										`description`,
										`receipt_no`) VALUE(
										NULL,
										\''.mysql_real_escape_string($this->parameters["name"]).'\',
										\''.mysql_real_escape_string($this->parameters["usr_id"]).'\',
										\''.mysql_real_escape_string($this->parameters["amount"]).'\',
										\''.mysql_real_escape_string($this->parameters["pay_date"]).'\',
										\''.mysql_real_escape_string($this->parameters["description"]).'\',NULL);';
		$res = executeQuery($query);
		if($res){
			$stfpay["flag"] = true;
			$stfpay["msg"]	= '<h3 style="colro:#FFFFFF;">Congrats !!!</h3>Today\'s payments has been updated !!!';
		}
		
		return $stfpay;
	}
	public function addExpenses(){
		$exp = array(
			"msg"	=> '<h2 style="colro:#FFFFFF;">Failure !!!</h2>Critical error occured!!!',
			"flag"	=> false,
		);
		$query = 'INSERT INTO `expenses`(`id`,
										`name`,
										`amount`,
										`pay_date`,
										`description`,
										`receipt_no`) VALUE(
										NULL,
										\''.mysql_real_escape_string($this->parameters["name"]).'\',
										\''.mysql_real_escape_string($this->parameters["amount"]).'\',
										\''.mysql_real_escape_string($this->parameters["pay_date"]).'\',
										\''.mysql_real_escape_string($this->parameters["description"]).'\',
										\''.mysql_real_escape_string($this->parameters["receiptno"]).'\');';
		$res = executeQuery($query);
		if($res){
			$exp["flag"] = true;
			$exp["msg"]	= '<h3 style="colro:#FFFFFF;">Congrats !!!</h3>Today\'s expenses has been updated !!!';
		}

		return $exp;
	}
}
?>
