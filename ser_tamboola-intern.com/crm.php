<?php
class crmModule{
	protected $parameters = array();
	private $order   = array("\r\n", "\n", "\r", "\t");
	private $replace = '';
	function __construct($para	=	false){
		$this->parameters=$para;	
	}
	//load and store all the messages in sessions//
	public function loadAllMsg(){
		$obj = new crmModule($this->parameters);
		$tblDb = $this->parameters["ap"]["tbl"];
		$data = array();
		switch($tblDb){
			case 'crm_messages':
				$data = $obj -> crmMessagesTbl();
			break;
			case 'crm_email':
				$data = $obj -> crmEmailTbl();
			break;
			case 'crm_sms':
				$data = $obj -> crmSMSTbl();
			break;
		}
		return $data;
	}
	public function crmMessagesTbl(){
		$result = array();
		$msg_list = array();
		executeQuery("SET SESSION group_concat_max_len = 1000000000;");
		$query = 'SELECT
					b.`name`,
					b.`email_id`,
					b.`user_email`,
					b.`cell_number`,
					b.`photo`,
					COUNT(a.`em_id`) AS counter,
					GROUP_CONCAT(a.`em_id`)AS em_id,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_text`,\'☻♥♥♥♥☻\')
					ELSE
						a.`em_text`
					END AS em_text,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_type`)
					ELSE
						a.`em_type`
					END AS em_type,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_date`)
					ELSE
						a.`em_date`
					END AS em_date,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_status`)
					ELSE
						a.`em_status`
					END AS em_status,
					
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_st_name`)
					ELSE
						a.`em_st_name`
					END AS em_st_name
				FROM (
						SELECT
							temp1.`id` AS em_id,
							temp1.`customer_pk` AS cpk,
							temp1.`to_email` AS em_to,
							REPLACE(REPLACE(temp1.`text`,"\t",""),"\n","")  AS em_text,
							temp2.`msg_type` AS em_type,
							temp1.`date`  AS em_date,
							temp1.`status`  AS em_status,
							st.`statu_name` AS em_st_name
						FROM `crm_messages` AS temp1
						INNER JOIN `crm_message_type` AS temp2 ON temp2.`id` = temp1.`msg_type_id` AND temp2.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1 )
						LEFT JOIN `status` as st ON st.`id` = temp1.`status`
						ORDER BY temp1.`id` DESC
				) AS a
				INNER JOIN(
						SELECT
							temp1.`name`,
							temp1.`id` AS email_id,
							temp1.`email` AS user_email ,
							CASE WHEN temp1.`cell_number` IS NULL
								THEN \'Not Provided\'
								ELSE
									CASE WHEN LENGTH(temp1.`cell_number`) = 0
										THEN \'Not Provided\'
										ELSE CONCAT(\'+91 \',temp1.`cell_number`)
									END
							END AS cell_number,
							CASE WHEN temp1.`photo_id` IS NULL
								THEN \''.USER_ANON_IMAGE.'\'
								ELSE CONCAT(\''.URL.ASSET_DIR.'\',temp2.`ver3`)
							END AS photo
						FROM `customer` AS temp1
						LEFT JOIN `photo` AS temp2 ON temp2.`id` = temp1.`photo_id`
						AND  (temp1.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Registered\' AND `status`=1 )  OR temp1.`status` =(SELECT `id` FROM `status` WHERE `statu_name`= \'Joined\' AND `status`=1 ) OR temp1.`status` = (SELECT `id` FROM `status` WHERE `statu_name`= \'Left\' AND `status`=1 ))
				) AS b ON b.`email_id` = a.`cpk`
				GROUP BY (a.`em_to`);';
		$res = executeQuery($query);
		if(get_resource_type($res) == 'mysql result'){
			if(mysql_num_rows($res) > 0){
				$i = 1;
				while($row = mysql_fetch_assoc($res)){
					$msg_list[$i]['pk'] = $row['email_id'];
					$msg_list[$i]['email'] = $row['user_email'];
					$msg_list[$i]['user_name'] = $row['name'];
					$msg_list[$i]['cell_number'] = $row['cell_number'];
					$msg_list[$i]['photo'] = $row['photo'];
					$msg_list[$i]['counter'] = $row['counter'];
					if($msg_list[$i]['counter'] > 1){
						$msg_list[$i]['id'] = explode($row['em_id'],",");
						$msg_list[$i]['text'] = explode(urlencode("☻♥♥♥♥☻"),urlencode($row['em_text']));
						$msg_list[$i]['msg_type'] = explode(",",$row['em_type']);
						$msg_list[$i]['date'] = explode(",",$row['em_date']);
						$msg_list[$i]['status'] = explode(",",$row['em_status']);
						$msg_list[$i]['status_name'] = explode(",",$row['em_st_name']);
					}
					else{
						$msg_list[$i]['id'] = $row['em_id'];
						$msg_list[$i]['text'] = $row['em_text'];
						$msg_list[$i]['msg_type'] = $row['em_type'];
						$msg_list[$i]['date'] = $row['em_date'];
						$msg_list[$i]['status'] = $row['em_status'];
						$msg_list[$i]['status_name'] = explode(",",$row['em_st_name']);
					}
					$i++;
				}
			}
			else{
				$msg_list = NULL;
			}
		}
		executeQuery("SET SESSION group_concat_max_len = 10000;");
		return $msg_list;
	}	
	public function crmEmailTbl(){
		$result = array();
		$msg_list = array();
		executeQuery("SET SESSION group_concat_max_len = 1000000000;");
		$query = 'SELECT 
					b.`name`,
					b.`email_id`,
					b.`cell_number`,
					b.`photo`,
					a.`usr_id`,
					COUNT(a.`em_id`) AS counter,
					GROUP_CONCAT(a.`em_id`)AS em_id,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_from`)
					ELSE 
						a.`em_from`
					END AS em_from,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_sub`,\'☻♥♥♥♥☻\')
					ELSE 
						a.`em_sub`
					END AS em_sub,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_text`,\'☻♥♥♥♥☻\')
					ELSE 
						a.`em_text`
					END AS em_text,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_type`)
					ELSE 
						a.`em_type`
					END AS em_type,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_date`)
					ELSE 
						a.`em_date`
					END AS em_date,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_status`)
					ELSE 
						a.`em_status`
					END AS em_status,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_st_name`)
					ELSE
						a.`em_st_name`
					END AS em_st_name
				FROM (
						SELECT  
							temp1.`id` AS em_id,
							temp1.`from_email` AS em_from,
							temp1.`to_email` AS em_to,
							temp1.`subject`  AS em_sub,
							REPLACE(REPLACE(temp1.`text`,"\t",""),"\n","")  AS em_text,
							temp2.`msg_type` AS em_type,
							temp1.`date`  AS em_date,
							temp1.`status`  AS em_status,
							temp1.`customer_pk` AS usr_id,
							st.`statu_name` AS em_st_name
						FROM `crm_email` AS temp1 
						INNER JOIN `crm_message_type` AS temp2 ON temp2.`id` = temp1.`msg_type_id` AND temp2.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1 )
						LEFT JOIN `status` as st ON st.`id` = temp1.`status`
						ORDER BY temp1.`id` DESC
				) AS a
		INNER JOIN(
				SELECT
					temp1.`id` AS userpk,
					temp1.`name`,
					temp1.`email` AS `email_id`,
					CASE WHEN temp1.`cell_number` IS NULL
						THEN \'Not Provided\'
						ELSE
							CASE WHEN LENGTH(temp1.`cell_number`) = 0
								THEN \'Not Provided\'
								ELSE CONCAT(\'+91 \',temp1.`cell_number`)
							END
					END AS cell_number,
					CASE WHEN temp1.`photo_id` IS NULL
						THEN \''.USER_ANON_IMAGE.'\'
						ELSE CONCAT(\''.URL.ASSET_DIR.'\',temp2.`ver3`)
					END AS photo
				FROM `customer` AS temp1
				LEFT JOIN `photo` AS temp2 ON temp2.`id` = temp1.`photo_id`
		) AS b ON b.`userpk` = a.`usr_id`
		GROUP BY (a.`em_to`);';
		$res = executeQuery($query);
		if(get_resource_type($res) == 'mysql result'){
			if(mysql_num_rows($res) > 0){
				$i = 1;
				while($row = mysql_fetch_assoc($res)){
					$msg_list[$i]['pk'] = $row['usr_id'];
					$msg_list[$i]['email'] = $row['email_id'];
					$msg_list[$i]['user_name'] = $row['name'];
					$msg_list[$i]['cell_number'] = $row['cell_number'];
					$msg_list[$i]['photo'] = $row['photo'];
					$msg_list[$i]['counter'] = $row['counter'];
					if($msg_list[$i]['counter'] > 1){
						$msg_list[$i]['id'] = explode($row['em_id'],",");
						$msg_list[$i]['from'] = explode($row['em_from'],",");
						$msg_list[$i]['subject'] = explode("☻♥♥♥♥☻",$row['em_sub']);
						$msg_list[$i]['text'] = explode(urlencode("☻♥♥♥♥☻"),urlencode($row['em_text']));
						// echo print_r($msg_list[$i]['text']).'<br />';
						$msg_list[$i]['msg_type'] = explode(",",$row['em_type']);
						$msg_list[$i]['date'] = explode(",",$row['em_date']);
						$msg_list[$i]['status'] = explode(",",$row['em_status']);
						$msg_list[$i]['status_name'] = explode(",",$row['em_st_name']);
					}
					else{
						$msg_list[$i]['id'] = $row['em_id'];
						$msg_list[$i]['from'] = $row['em_from'];
						$msg_list[$i]['subject'] = $row['em_sub'];
						$msg_list[$i]['text'] = $row['em_text'];
						$msg_list[$i]['msg_type'] = $row['em_type'];
						$msg_list[$i]['date'] = $row['em_date'];
						$msg_list[$i]['status'] = $row['em_status'];
						$msg_list[$i]['status_name'] = $row['em_st_name'];
					}
					$i++;
				}
			}
			else{
				$msg_list = NULL;
			}
		}
		return $msg_list;
	}
	public function crmSMSTbl(){
		$result = array();
		$msg_list = array();
		executeQuery("SET SESSION group_concat_max_len = 1000000000;");
		$query = 'SELECT 
					b.`name`,
					b.`email_id`,
					b.`cell_number`,
					b.`photo`,
					a.`usr_id`,
					COUNT(a.`em_id`) AS counter,
					GROUP_CONCAT(a.`em_id`)AS em_id,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_text`,\'☻♥♥♥♥☻\')
					ELSE 
						a.`em_text`
					END AS em_text,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_type`)
					ELSE 
						a.`em_type`
					END AS em_type,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_date`)
					ELSE 
						a.`em_date`
					END AS em_date,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_status`)
					ELSE 
						a.`em_status`
					END AS em_status,
					CASE WHEN COUNT(a.`em_id`) > 1
					THEN
						GROUP_CONCAT(a.`em_st_name`)
					ELSE
						a.`em_st_name`
					END AS em_st_name
				FROM (
						SELECT  
							temp1.`id` AS em_id,
							temp1.`to_email` AS em_to,
							temp1.`to_mobile` AS mob_to,
							REPLACE(REPLACE(temp1.`text`,"\t",""),"\n","")  AS em_text,
							temp2.`msg_type` AS em_type,
							temp1.`date`  AS em_date,
							temp1.`status`  AS em_status,
							temp1.`customer_pk` AS usr_id,
							st.`statu_name` AS em_st_name
						FROM `crm_sms` AS temp1 
						INNER JOIN `crm_message_type` AS temp2 ON temp2.`id` = temp1.`msg_type_id` AND temp2.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'show\' AND `status`=1 )
						LEFT JOIN `status` as st ON st.`id` = temp1.`status`
						ORDER BY temp1.`id` DESC
				) AS a
				INNER JOIN(
				SELECT
					temp1.`id` AS userpk,
					temp1.`name`,
					temp1.`email` AS `email_id`,
					CASE WHEN temp1.`cell_number` IS NULL
						THEN \'Not Provided\'
						ELSE
							CASE WHEN LENGTH(temp1.`cell_number`) = 0
								THEN \'Not Provided\'
								ELSE CONCAT(\'+91 \',temp1.`cell_number`)
							END
					END AS cell_number,
					CASE WHEN temp1.`photo_id` IS NULL
						THEN \''.USER_ANON_IMAGE.'\'
						ELSE CONCAT(\''.URL.ASSET_DIR.'\',temp2.`ver3`)
					END AS photo
				FROM `customer` AS temp1
				LEFT JOIN `photo` AS temp2 ON temp2.`id` = temp1.`photo_id`
				) AS b ON b.`userpk` = a.`usr_id`
				GROUP BY (a.`em_to`);';
		$res = executeQuery($query);
		if(get_resource_type($res) == 'mysql result'){
			if(mysql_num_rows($res) > 0){
				$i = 1;
				while($row = mysql_fetch_assoc($res)){
					$msg_list[$i]['pk'] = $row['usr_id'];
					$msg_list[$i]['email'] = $row['email_id'];
					$msg_list[$i]['user_name'] = $row['name'];
					$msg_list[$i]['cell_number'] = $row['cell_number'];
					$msg_list[$i]['photo'] = $row['photo'];
					$msg_list[$i]['counter'] = $row['counter'];
					if($msg_list[$i]['counter'] > 1){
						$msg_list[$i]['id'] = explode($row['em_id'],",");
						$msg_list[$i]['text'] = explode(urlencode("☻♥♥♥♥☻"),urlencode($row['em_text']));
						$msg_list[$i]['msg_type'] = explode(",",$row['em_type']);
						$msg_list[$i]['date'] = explode(",",$row['em_date']);
						$msg_list[$i]['status'] = explode(",",$row['em_status']);
						$msg_list[$i]['status_name'] = explode(",",$row['em_st_name']);
					}
					else{
						$msg_list[$i]['id'] = $row['em_id'];
						$msg_list[$i]['text'] = $row['em_text'];
						$msg_list[$i]['msg_type'] = $row['em_type'];
						$msg_list[$i]['date'] = $row['em_date'];
						$msg_list[$i]['status'] = $row['em_status'];
						$msg_list[$i]['status_name'] = $row['em_st_name'];
					}
					$i++;
				}
			}
			else{
				$msg_list = NULL;
			}
		}
		return $msg_list;
	}
	public function listCustomer($begin,$end){
		$theme = array('default','success','info','danger','warning');
		$num_posts = 0;
		if(isset($_SESSION['msg_list']) && $_SESSION['msg_list'] != NULL)
			$msg_list = $_SESSION['msg_list'];
		else
			$msg_list = NULL;
		if($msg_list != NULL)
			$num_posts = sizeof($msg_list);
		//$color = array('#008299','#2672EC','#8C0095','#5133AB','#AC193D','#D24726','#008A00','#094AB2','#4E0000','#691BB8','#180052','#C1004F','#16499A','#2D652B','#9E1716');
		$color = array('#008299');
		if($num_posts > 0){
			for($i=$begin;$i<=$end && $i <= $num_posts && isset($msg_list[$i]['email']);$i++){
				if($msg_list[$i]['photo'] != USER_ANON_IMAGE){
					if(!file_exists($msg_list[$i]['photo'])) {
						$msg_list[$i]['photo'] = USER_ANON_IMAGE;
						$_SESSION['msg_list'][$i]['photo'] = USER_ANON_IMAGE;
					} 
				}
				$stauts = ( $msg_list[$i]['status_name'] == 'Sent' ) ? '<font style="color:#090;">Sent</font>' : '<font style="color:#090;">Pending</font>';
					echo  '<div class="col-lg-3 col-md-4">
							 <div class="panel panel-primary" id="user_list_'.$i.'" >
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-4">
											<img width="58" height="58" src="'.$msg_list[$i]['photo'].'" />
											<span id="user_email_'.$i.'">
												'.$msg_list[$i]['email'].'
											</span>
										</div>
										<div class="col-xs-8 text-left">
											<span id="user_name_'.$i.'">
												'.$msg_list[$i]['user_name'].'
											</span><br />
											
											<span id="user_cell_'.$i.'">
												'.$msg_list[$i]['cell_number'].'
											</span><br />
										</div>
									</div>
								</div>
								<a href="javascript:void(0)" class="gymLink" id="'.$i.'">
                            <div class="panel-footer" id="click_'.$i.'">
                                <span class="pull-left"><span id="user_num_'.$i.'">
								 <strong>'.$msg_list[$i]['counter'].' messages.</strong>
							</span></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
							</div>
						</div>
						<script language="javascript">
						$("#click_'.$i.'").on("click",function(){
							var obj = new controlCRMApp();
							obj.displayMsg('.json_encode($this->parameters["ap"]).','.$i.');
						});
						</script>';			
				}
		echo  '</div>';
		}
		else{
			echo 'No messages to list.';
		}
	}
	public function displayMsg(){
		$index = $this->parameters["index"];
		$ap = $this->parameters["ap"];
		$col = "#008299";
		$num_posts = 0;
		if(isset($_SESSION['msg_list']) && $_SESSION['msg_list'] != NULL)
			$msg_list = $_SESSION['msg_list'];
		else
			$msg_list = NULL;
		if($msg_list != NULL)
			$num_posts = sizeof($msg_list);
		if($num_posts > 0){
				echo '<div id="ind_det">
							<div id="ind_det_left"><img src='.$msg_list[$index]['photo'].' width="70" height="70" /></div>
							<div id="ind_det_right">
							'.$msg_list[$index]['user_name'].'<br />
							'.$msg_list[$index]['email'].'<br />
							'.$msg_list[$index]['cell_number'].'<br />
							</div>
					 </div>
					 <div class="col-lg-12">
						 <div class="col-lg-6">
							<table border="0" cellpadding="3"  class="table table-striped table-bordered ">
								<tr>
									<td align="center">
										<input type="hidden" id="prod_promoter" value="'.$index.'" />
									</td>
								</tr>
								<tr>
									<td align="center">
										<input id="msg_sub" value="Message from '.$this->parameters["GYMNAME"].'"  type="text" class="form-control"/>
									</td>
								</tr>
								<tr>
									<td align="center">
										<textarea id="msg_content" placeholder="Enter your message" class="form-control" ></textarea>
									</td>
								</tr>
								<tr>
									<td align="center">
										<button class="btn btn-lg btn-info col-lg-4 col-md-offset-1" type="button" id="outsend"  > Send </button>
										<button class="btn btn-lg btn-info col-lg-4 col-md-offset-2" type="button" style="align:right" id="close_but"> Close </button>
									</td>
								</tr>
							</table>
						</div>
						<div id ="msg_list" class="col-lg-6">
					<table class="table" cellpadding="8">';
				if($msg_list[$index]['counter'] < 2){
					$msg_list[$index]['text'] = urldecode($msg_list[$index]['text']);
					echo '<tr>
							<td style="position:relative;">
								<div class="msg_det">
									<label>
										'.$msg_list[$index]['status_name'].' @ '.date('F j, Y, g:i a', strtotime($msg_list[$index]['date'])).'
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="bubble">
									'.ltrim($msg_list[$index]['text'],",").'
								</div>
							</td>
						</tr>';
				}
				else{
					for($j=0;$j<=($msg_list[$index]['counter']-1);$j++){
						$msg_list[$index]['text'][$j] = urldecode($msg_list[$index]['text'][$j]);
						echo '<tr>
								<td>
									<div style="position:relative;">
										<div class="msg_det">
											<label>
												'.$msg_list[$index]['status_name'][$j].' @ '.date('F j, Y, g:i a', strtotime($msg_list[$index]['date'][$j])).'
											</label>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="bubble">
										'.ltrim($msg_list[$index]['text'][$j],",").'
									</div>
								</td>
							</tr>';
					}
				}
				echo '</table>
				</div>
						<script language="javascript" type="text/javascript">
					$("#outsend").bind("click",function(){
							var obj = new controlCRMApp();
							obj.send_app_msg('.json_encode($this->parameters["ap"]).',true,\'msg_list\');
						});
							</script>';
		}
		else{
			echo 'No messages to list.';
		}
	}
	public function createMessage(){
		$id = $this->parameters["id"];
		$ap = $this->parameters["ap"];
		$objcrm = new crmModule();
		$listofPeoples = NULL;
		$colleagueshtml = 'var listofPeoples = [];';
		$colleaguesimghtml = 'var listofimages = [];';
		if($id == 'createMessage'){
			$header = '<center><h4>Compose message to your Customers</h4><center>';
			$listofPeoples = $objcrm -> returnListofPeoples("users");
			$colleagueshtml = $listofPeoples["colleagueshtml"];
			$colleaguesimghtml = $listofPeoples["colleaguesimghtml"];
		}
		else if($id == 'exp_cust'){
			$header = '<center><h4>Compose message to your Expired Customers</h4><center>';
			$objcrm = new crmModule();
			$listofPeoples = $objcrm -> customersExpiringToday();
			$colleagueshtml = 'var listofPeoples = [';
			$colleaguesimghtml = 'var listofimages = [';
			for($i=1;$i<=sizeof($listofPeoples);$i++){
				if($i != sizeof($listofPeoples)){
					$colleagueshtml .= '{\'label\' : \''.$listofPeoples[$i]['name'].' - '.$listofPeoples[$i]['email'].' - '.$listofPeoples[$i]['cell'].' - '.$listofPeoples[$i]['days'].' - '.$listofPeoples[$i]['offer'].'\', \'value\' : \''.$i.'\', \'category\' : \''.$listofPeoples[$i]['tbl_name'].'\'},';
					$colleaguesimghtml .= '{"label" : "<img src=\''.$listofPeoples[$i]['photo'].'\' height=\'30\' width=\'30\'/>", "value" : "'.$i.'"},';
				}
				else{
					$colleagueshtml .= '{\'label\' : \''.$listofPeoples[$i]['name'].' - '.$listofPeoples[$i]['email'].' - '.$listofPeoples[$i]['cell'].' - '.$listofPeoples[$i]['days'].' - '.$listofPeoples[$i]['offer'].'\', \'value\' : \''.$i.'\',\'category\' : \''.$listofPeoples[$i]['tbl_name'].'\'}];';
					$colleaguesimghtml .= '{"label" : "<img src=\''.$listofPeoples[$i]['photo'].'\' height=\'30\' width=\'30\' />", "value" : "'.$i.'"}];';
				}
			}
		}
		else if($id == 'follow_cust'){
			$header = '<center><h4>Compose message for today\'s follow-ups</h4><center>';
			$listofPeoples = $objcrm -> listPendingEnquiry();
			$colleagueshtml = 'var listofPeoples = [';
			$colleaguesimghtml = 'var listofimages = [';
			for($i=1;$i<=sizeof($listofPeoples);$i++){
				if($i != sizeof($listofPeoples)){
					$colleagueshtml .= '{\'label\' : \''.$listofPeoples[$i]['name'].' - '.$listofPeoples[$i]['email'].' - '.$listofPeoples[$i]['cell'].'\', \'value\' : \''.$i.'\', \'category\' : \''.$listofPeoples[$i]['tbl_name'].'\'},';
					$colleaguesimghtml .= '{"label" : "<img src=\''.$listofPeoples[$i]['photo'].'\' height=\'30\' width=\'30\'/>", "value" : "'.$i.'"},';
				}
				else{
					$colleagueshtml .= '{\'label\' : \''.$listofPeoples[$i]['name'].' - '.$listofPeoples[$i]['email'].' - '.$listofPeoples[$i]['cell'].'\', \'value\' : \''.$i.'\',\'category\' : \''.$listofPeoples[$i]['tbl_name'].'\'}];';
					$colleaguesimghtml .= '{"label" : "<img src=\''.$listofPeoples[$i]['photo'].'\' height=\'30\' width=\'30\' />", "value" : "'.$i.'"}];';
				}
			}
		}
		else if($id == 'tracker_cust'){
			$header = '<center><h4>Compose message for active customers who are long absentees</h4><center>';
			$listofPeoples = $objcrm -> returnActiveCustomersTracker();
			$colleagueshtml = 'var listofPeoples = [';
			$colleaguesimghtml = 'var listofimages = [';
			for($i=1;$i<=sizeof($listofPeoples);$i++){
				if($i != sizeof($listofPeoples)){
					$colleagueshtml .= '{\'label\' : \''.$listofPeoples[$i]['name'].' - '.$listofPeoples[$i]['email'].' - '.$listofPeoples[$i]['cell'].' - '.$listofPeoples[$i]['days'].' - '.$listofPeoples[$i]['offer'].'\', \'value\' : \''.$i.'\', \'category\' : \''.$listofPeoples[$i]['tbl_name'].'\'},';
					$colleaguesimghtml .= '{"label" : "<img src=\''.$listofPeoples[$i]['photo'].'\' height=\'30\' width=\'30\'/>", "value" : "'.$i.'"},';
				}
				else{
					$colleagueshtml .= '{\'label\' : \''.$listofPeoples[$i]['name'].' - '.$listofPeoples[$i]['email'].' - '.$listofPeoples[$i]['cell'].' - '.$listofPeoples[$i]['days'].' - '.$listofPeoples[$i]['offer'].'\', \'value\' : \''.$i.'\',\'category\' : \''.$listofPeoples[$i]['tbl_name'].'\'}];';
					$colleaguesimghtml .= '{"label" : "<img src=\''.$listofPeoples[$i]['photo'].'\' height=\'30\' width=\'30\' />", "value" : "'.$i.'"}];';
				}
			}
		}
		if(sizeof($listofPeoples) > 0){
			echo '<div class="panel panel-default">
					<div class="panel-heading">
						<h4>'.$header.'</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div style="float:right;display:inline;">
									Selected : (<div id="mem_counter" style="display:inline;">0</div>)&nbsp;
									Remaining : (<div id="mem_remaining" style="display:inline;">'.sizeof($listofPeoples).'</div>)&nbsp;
									Sent : (<div id="mem_sent" style="display:inline;">0</div>)&nbsp;
								</div>&nbsp;
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div id="selectedusers_prod"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<span>
										<input class="form-control" id="msg_to" name="msg_to" type="text"/>
									</span>
									<p class="help-block"></p>
								</div><hr />
							</div>
						<div class="col-lg-6">
								<button id="_reset" class="btn btn-primary"> RESET </button>
								&nbsp;
								<button id="_clear" class="btn btn-primary"> CLEAR </button>
						</div>
						<div class="row"><div class="col-lg-12">&nbsp;</div></div>
						<div class="row">
							<div class="col-lg-6">
								<span>
									<input id="msg_sub" Placeholder="Message from '.$this->parameters["GYMNAME"].'"  type="text" class="form-control" />
								</span>
							</div>
						</div>
						<div class="row"><div class="col-lg-12">&nbsp;</div></div>
						<div class="row">
							<div class="col-lg-6">
								<textarea id="msg_content" class="form-control" placeholder="Enter your message"></textarea>
							</div>
						</div>
						<div class="row"><div class="col-lg-12">&nbsp;</div></div>
						<div class="row">
							<div class="col-lg-6">
								<button type="button" id="compsend" class="btn btn-primary btn-success"> Send </button>
								<script language="javascript" type="text/javascript">
									'.$colleagueshtml.'
									$("#msg_to").autocomplete({
										 source: listofPeoples,
										 minLength: 1,
										 autoFocus: true,
										 delay: 0,
										 select: function (event, ui) {
											'.$colleaguesimghtml.'
											$("#mem_counter").html(Number($("#mem_counter").html()) + 1 );
											$("#msg_to").val("");
											var i = 1;
											for (var key in listofimages)
											{
												if(ui.item.value == listofimages[key].value && listofimages[key].value == i)
												{
													$("#selectedusers_prod").append("<p id=\"p_"+i+"\">"+listofimages[key].label +
																					"&nbsp;" +
																					ui.item.label+
																					"&nbsp;<a href=\"javascript:void(0);\" onClick=\"$(\'#mem_counter\').html(Number($(\'#mem_counter\').html()) - 1 );$(this).parent().remove();listofPeoples.push({label:\'"+ui.item.label+"\',value:\'"+ui.item.value+"\'});$(\'#msg_to\').autocomplete(\'option\',\'source\',listofPeoples);\" style=\"color:#FF0000;\">Delete</a>"+
																					"&nbsp;<input type=\"hidden\" id=\"prod_promoter\" value=\""+ui.item.value+"\" />"+
																					"</p>");
													$("#selectedusers_prod").css({height:"150px", overflow:"auto", overflowX:"hidden"});
													$("#selectedusers_prod").animate({ scrollTop: $("#selectedusers_prod")[0].scrollHeight}, 500);
													break;
												}
												i++;
											}
											listofPeoples = listofPeoples.filter(function(el){ return el.label != ui.item.label; });
											$(this).autocomplete("option","source",listofPeoples);
											$(this).val("");
											return false;
										}
									}).focus(function() { 
										$(this).find("input").select(); 
										$(this).select(); 
									}).data("ui-autocomplete")._renderItem = function (ul, item) {
										'.$colleaguesimghtml.'
										var i = 1;
										for (var key in listofimages)
										{
											if(item.value == listofimages[key].value && listofimages[key].value == i)
											{
												 return $("<li></li>")
													 .data("item.autocomplete", item)
													 .append( "<a>" + listofimages[key].label + "&nbsp;" + item.label + "</a>")
													 .appendTo(ul);
											}
											i++;
										}
									};
									$("#_clear").bind("click",function(){
										$("#msg_to").val("");
										$("#selectedusers_prod").html("");
									});
									$("#_reset").bind("click",function(){
										$("#msg_to").val("");
										$("#mem_counter").html("0");
										$("#selectedusers_prod").html("");
										'.$colleagueshtml.'
										$("#msg_to").autocomplete("option","source",listofPeoples);
									});
									$("#compsend").bind("click",function(){
										var obj = new controlCRMApp();
										obj.send_app_msg('.json_encode($this->parameters["ap"]).',false,\'listofPeoples\');
									});
								</script>
							</div>
						</div>
					</div>
				</div>';
		}
		else{
			echo '<center>Systems has found no one that matches the criteria</center>';
		}
	}
	public function customersExpiringToday(){
		$_SESSION['expiry_list'] = NULL;
		$listofPeoples = NULL;
		$objenq = new enquiry();
		$fac = $objenq -> fetchInterestedIn();
		$faclen = sizeof($fac);
		for($i=0;$i<$faclen;$i++)
			$facility_type[] = $fac[$i]["name"];
		$query = 'SELECT 
					par.`upk` AS id,
					par.`uname` AS name,
					par.`ucell` AS cell_number,
					par.`uemail` AS email_id, 
					par.`use_me`, 
					par.`photo`, 
					par.`counter`, 
					par.`gr_fee_id`, 
					par.`gr_offer_id`, 
					par.`gr_no_of_days`, 
					par.`gr_payment_date`, 
					par.`vfrom`,
					par.`vto` AS exp_date,
					par.`since_when`,
					par.`offerss` AS offer,
					par.`gr_fac_typ`,
					par.`facility_id` AS facility_type,
					par.`status`
				FROM(
					SELECT
						a.`upk`, 
						a.`uname`, 
						a.`ucell`, 
						a.`uemail`, 
						a.`use_me`, 
						a.`photo`, 
						b.`counter`, 
						b.`gr_fee_id`, 
						b.`gr_offer_id`, 
						b.`gr_no_of_days`, 
						b.`gr_payment_date`, 
						b.`vfrom`,
						b.`vto`,
						b.`since_when`,
						b.`offerss`,
						b.`gr_fac_typ`,
						b.`facility_id`,
						b.`status`
					FROM(
						SELECT 
						temp.`id` AS upk,
						temp.`name` AS uname,
						temp.`cell_number` AS ucell,
						temp.`email` AS uemail, 
						CASE
							WHEN (SELECT TRUE FROM `group_members` WHERE `customer_pk` = temp.`id`)
							THEN (SELECT `owner` FROM `groups` WHERE `id` = (SELECT `group_id` FROM `group_members` WHERE `customer_pk` = temp.`id`))
							ELSE temp.`id`
						END AS use_me,
						CASE
							WHEN (SELECT TRUE FROM `group_members` WHERE `customer_pk` = temp.`id`)
							THEN (SELECT `customer_pk` FROM `groups` WHERE `id` = (SELECT `group_id` FROM `group_members` WHERE `customer_pk` = temp.`id`))
							ELSE temp.`id`
						END AS usepk_me,
						CASE WHEN temp.`photo_id` IS NULL
							 THEN \''.USER_ANON_IMAGE.'\'
							 ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph3.`ver3`)
						END AS photo
						FROM `customer` AS temp
						LEFT JOIN `photo` AS ph3 ON temp.`photo_id` = ph3.`id`
						WHERE  (temp.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Registered\' AND `status`=1 )  OR temp.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Joined\' AND `status`=1 ))
					) AS a
					INNER JOIN(
						SELECT 
							COUNT(fe.`id`) AS counter,
							fe.`customer_pk` AS fee_user_id,
							GROUP_CONCAT(fe.`id` ORDER BY fe.`id`) AS gr_fee_id,
							GROUP_CONCAT(fe.`offer_id` ORDER BY fe.`id`) AS gr_offer_id,
							GROUP_CONCAT(fe.`no_of_days` ORDER BY fe.`id`)AS gr_no_of_days,
							GROUP_CONCAT(fe.`payment_date` ORDER BY fe.`id`)AS gr_payment_date,
							GROUP_CONCAT(fe.`valid_from`  ORDER BY fe.`id`) AS vfrom,
							GROUP_CONCAT(fe.`valid_till` ORDER BY fe.`id`) AS vto,
							GROUP_CONCAT(DATEDIFF(NOW(),fe.`valid_till`) ORDER BY fe.`id`) AS since_when,
							GROUP_CONCAT(fe.`customer_pk`),
							GROUP_CONCAT(CONCAT(ofs.`facility_id`,\' - \',ofs.`name`,\' - \',ofs.`duration_id`,\' - \',ofs.`cost`)) AS offerss,
							GROUP_CONCAT(ofs.`facility_id`) AS gr_fac_typ,
							ofs.`facility_id`,
							GROUP_CONCAT(
							(CASE WHEN (STR_TO_DATE(fe.`valid_till`,\'%Y-%m-%d\') < STR_TO_DATE(NOW(),\'%Y-%m-%d\'))
								THEN \'Expired\'
								ELSE \'Valid\' 
							END)) AS status
						FROM `fee` AS fe
						INNER JOIN `offers` AS ofs ON ofs.`id` = fe.`offer_id`
						WHERE STR_TO_DATE(fe.`valid_till`,\'%Y-%m-%d\') < STR_TO_DATE(NOW(),\'%Y-%m-%d\')
						AND fe.`customer_pk` NOT IN (SELECT `customer_pk` FROM `fee` 
									WHERE STR_TO_DATE(`valid_till`,\'%Y-%m-%d\') >= STR_TO_DATE(NOW(),\'%Y-%m-%d\') 
									AND STR_TO_DATE(`valid_from`,\'%Y-%m-%d\') <= STR_TO_DATE(NOW(),\'%Y-%m-%d\')) 
						GROUP BY fe.`customer_pk` 
					) AS b ON (b.`fee_user_id` = a.`use_me`)
				)AS par
				ORDER BY (par.`facility_id`);';
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					$i=1;
					$listofPeoples = array();
					while($row = mysql_fetch_assoc($res)){
						$listofPeoples[$i]['pk'] = $row['id'];
						$listofPeoples[$i]['name'] = $row['name'];
						$listofPeoples[$i]['email'] = $row['email_id'];
						$listofPeoples[$i]['cell'] = $row['cell_number'];
						$listofPeoples[$i]['photo'] = $row['photo'];
						$listofPeoples[$i]['tbl_name'] = $row['facility_type'];
						$listofPeoples[$i]['days'] = $row['since_when'];
						if($row['counter'] > 1){
							$days = (int) explode(",",$row['since_when'])[sizeof(explode(",",$row['since_when']))-1];
							$days = ($days > 1 ? $days .' days' : $days .' day');
							$listofPeoples[$i]['offer'] = explode(",",$row['offer'])[sizeof(explode(",",$row['offer']))-1];
							$listofPeoples[$i]['days'] = $days;
						}
						else{
							$days = $row['since_when'];
							$days = ($days > 1 ? $days .' days' : $days .' day');
							$listofPeoples[$i]['offer'] = $row['offer'];
							$listofPeoples[$i]['days'] = $days;
						}						
						$i++;
					}
				}
		$_SESSION['listofPeoples'] = $listofPeoples;
		return $listofPeoples;
	}
	public function returnListofPeoples($tbl_name = false){
		$listofPeoples = NULL;
		$query = 'SELECT
					ur.`id` AS pk,
					ur.`name` AS name,
					ur.`email` AS email,
					ur.`cell_number` AS cell,
					CASE WHEN ur.`photo_id` IS NULL
						 THEN \''.USER_ANON_IMAGE.'\'
						 ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph3.`ver3`)
					END AS photo,
					\'customer\' AS tbl_name
				FROM `customer` AS ur
				LEFT JOIN `photo` AS ph3 ON ur.`photo_id` = ph3.`id`
				WHERE ur.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Left\' AND `status`=1 ) AND ur.`status` != (SELECT `id` FROM `status` WHERE `statu_name`=\'Delete\' AND `status`=1 );';
		$res = executeQuery($query);
		if(mysql_num_rows($res)){
			$i=1;
			$listofPeoples = array();
			switch($tbl_name){
				case "users":
					while($row = mysql_fetch_assoc($res)){
							$listofPeoples[$i]['pk'] = $row['pk'];
							$listofPeoples[$i]['name'] = $row['name'];
							$listofPeoples[$i]['email'] = $row['email'];
							$listofPeoples[$i]['cell'] = $row['cell'];
							$listofPeoples[$i]['photo'] = $row['photo'];
							$listofPeoples[$i]['tbl_name'] = $row['tbl_name'];
							$i++;
					}
				break;
				default:
					while($row = mysql_fetch_assoc($res)){
						$listofPeoples[$i]['pk'] = $row['pk'];
						$listofPeoples[$i]['name'] = $row['name'];
						$listofPeoples[$i]['email'] = $row['email'];
						$listofPeoples[$i]['cell'] = $row['cell'];
						$listofPeoples[$i]['photo'] = $row['photo'];
						$listofPeoples[$i]['tbl_name'] = $row['tbl_name'];
						$i++;
					}
				break;
			}
		}
		$_SESSION["listofPeoples"] = $listofPeoples;
		if(is_array($listofPeoples)){
			$colleagueshtml = 'var listofPeoples = [';
			$colleaguesimghtml = 'var listofimages = [';
			for($i=1;$i<=sizeof($listofPeoples);$i++){
				if($i != sizeof($listofPeoples)){
					$colleagueshtml .= '{"label" : "'.$listofPeoples[$i]["name"].' - '.$listofPeoples[$i]["email"].' - '.$listofPeoples[$i]["cell"].'", "value" : "'.$i.'"},';
					$colleaguesimghtml .= '{"label" : "<img src=\''.$listofPeoples[$i]["photo"].'\' height=\'30\' width=\'30\'/>", "value" : "'.$i.'"},';
				}
				else{
					$colleagueshtml .= '{"label" : "'.$listofPeoples[$i]["name"].' - '.$listofPeoples[$i]["email"].' - '.$listofPeoples[$i]["cell"].'", "value" : "'.$i.'"}];';
					$colleaguesimghtml .= '{"label" : "<img src=\''.$listofPeoples[$i]["photo"].'\' height=\'30\' width=\'30\' />", "value" : "'.$i.'"}];';
				}
			}
		}
		else{
			$colleagueshtml = 'var listofPeoples = [];';
			$colleaguesimghtml = 'var listofimages = [];';
		}
		$listofPeoples = array(
			"colleagueshtml" => $colleagueshtml,
			"colleaguesimghtml" =>	$colleaguesimghtml
		);
		return $listofPeoples;
	}
	public function statistics(){
		$id = $this->parameters["id"];
		$syear = 2014;
		$eyear = date('Y');
		$cmont = date('m');
		$months = array('','01','02','03','04','05','06','07','08','09','10','11','12');
		$result = NULL;
		$total_count = 0;
		$query = 'SELECT 
					COUNT(`id`) AS total,
					STR_TO_DATE(`date`,\'%Y-%m-%d\') AS date,
					DATE_FORMAT(`date`,\'%Y\') AS year,
					DATE_FORMAT(`date`,\'%m\') AS month,
					DATE_FORMAT(`date`,\'%b\') AS month_name,
					DATE_FORMAT(`date`,\'%d\') AS day,
					DATE_FORMAT(`date`,\'%a %d %M %Y\') AS read_date
				FROM `'.mysql_real_escape_string($id).'`
				GROUP BY (STR_TO_DATE(`date`,\'%Y-%m-%d\'))
				ORDER BY (STR_TO_DATE(`date`,\'%Y-%m-%d\')) DESC;'; 
		$res = executeQuery($query);
		if(mysql_num_rows($res)){
			$result=array();
			$i=1;
			while($row = mysql_fetch_assoc($res)){
				$result[$i]['total'] = $row['total'];
				$result[$i]['date'] = $row['date'];
				$result[$i]['year'] = $row['year'];
				$result[$i]['month'] = $row['month'];
				$result[$i]['month_name'] = $row['month_name'];
				$result[$i]['read_date'] = $row['read_date'];
				$total_count += $row['total'];
				$i++;
			}
		}
		if(is_array($result)){
		echo '<div class="col-lg-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <strong>Total Messages sent till now :- </strong>'.$total_count.'='.$id.'
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    for($k=1;$k<=sizeof($result);$k++){
                                    echo '<tr class="info">
                                            <td>'.$result[$k]['read_date'].'</td>
                                            <td align="right">'.$result[$k]['total'].'</td>
                                        </tr>';
                                      }  
                                     }
                                     else{
										echo '<tr><td><center><h3>No Messages has sent.</h3></center></td></tr>';
								     }
                                    echo '</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>';
    }
	public function SendMsg(){
		$obj = new crmModule($this->parameters);
		$tblDb = $this->parameters["ap"]["tbl"];
		$data = array();
		switch($tblDb){
			case 'crm_messages':
				$data = $obj -> sendMsgTbl();
			break;
			case 'crm_email':
				$data = $obj -> sendEmailTbl();
			break;
			case 'crm_sms':
				$data = $obj -> sendSMSTbl();
			break;
		}
		return $data;
	}
	public function sendMsgTbl(){
		$msg_to = $this->parameters["msg_to"];
		$msg_content = $this->parameters["msg_content"];
		$arr_type = $this->parameters["arr_type"];
		$query = "";
		$total = sizeof($msg_to)-1;
		if($total > 0){
			$query = "INSERT INTO `crm_messages`(`id`,`to_email`, `text`, `msg_type_id`, `date`, `to_status`, `status`,`customer_pk`)VALUES";
			for($i=1;$i<=$total;$i++){
				if($i == $total)
					$query .= "(NULL,'".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['email'])."','".mysql_real_escape_string($msg_content)."',3,NOW(),default,'13','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['pk'])."');";
				else
					$query .= "(NULL,'".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['email'])."','".mysql_real_escape_string($msg_content)."',3,NOW(),default,'13','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['pk'])."'),";
				echo " -- ".$_SESSION[$arr_type][$msg_to[$i]]['email']." -- ".date("d/m/Y, G:i:s") ." => APP Msg has been sent.<br />";
			}
			executeQuery($query);
		}
	}
	public function sendEmailTbl(){
		$msg_sub = $this->parameters["msg_sub"];
		$msg_to = $this->parameters["msg_to"];
		$msg_content = $this->parameters["msg_content"];
		$arr_type = $this->parameters["arr_type"];
		$query = "";
		$email = '';
		$password = '';
		$config = array();
		$transport = '';
		$mail = '';
		$recipients = array();
		$qut = 0;
		$rem = 0;
		$name = 'Customer';
		$m = 0;
		$to = '';
		$total = sizeof($msg_to)-1;
		if($total > 0){
			/* Build  recipients array one source thirty recipients */
			$i=1;
			$m=1;
			set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
			require_once(LIB_ROOT.MODULE_ZEND_1);
			require_once(LIB_ROOT.MODULE_ZEND_2);
			if($total > 30){
				$qut = floor($total / 30);
				$rem = $total % 30;
				for(;$i<=$qut;$i++){
					if(isset($_SESSION['SourceEmailIds'])){
						$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
						$email = $_SESSION['SourceEmailIds'][$index]['email'];
						$password = $_SESSION['SourceEmailIds'][$index]['password'];
					}
					else{
						$email = MAILUSER;
						$password = MAILPASS;
					}
					$config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
					$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
					$mail = new Zend_Mail();
					$mail->setBodyHtml($msg_content);
					$mail->setFrom($email, $this->parameters["GYMNAME"]);
					$mail->setSubject($msg_sub);
					$query = "INSERT INTO `crm_email`(`id`,`from_email`, `to_email`, `subject`, `text`, `msg_type_id`, `date`, `status`,`customer_pk`)VALUES";
					for($j=1;$j<=30 && $m <= $total;$j++){
						if($j ==  30)
							$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['pk'])."');";
						else
							$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['pk'])."'),";
						$mail->addTo($_SESSION[$arr_type][$msg_to[$m]]['email'], $name);
						$to .= $_SESSION[$arr_type][$msg_to[$m]]['email'] .', <br />';
						$m++;
					}
					try{
						// $mail->send($transport);
						echo " -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email has been sent.<br />";
						executeQuery($query);
					}
					catch(exceptoin $e){
						echo " -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email could not be sent.<br />";;
					}
					unset($mail);
					unset($transport);
				}
				if($rem > 0){
					$to = '';
					$remaining = $total - ($qut * 30);
					if(isset($_SESSION['SourceEmailIds'])){
						$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
						$email = $_SESSION['SourceEmailIds'][$index]['email'];
						$password = $_SESSION['SourceEmailIds'][$index]['password'];
					}
					else{
						$email = MAILUSER;
						$password = MAILPASS;
					}
					$config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
					$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
					$mail = new Zend_Mail();
					$mail->setBodyHtml($msg_content);
					$mail->setFrom($email, $this->parameters["GYMNAME"]);
					$mail->setSubject($msg_sub);
					$query = "INSERT INTO `crm_email`(`id`,`from_email`, `to_email`, `subject`, `text`, `msg_type_id`, `date`, `status`,`customer_pk`)VALUES";
					for($j=1;$j<=$remaining && $m <= $total;$j++){
						if($j ==  $remaining)
							$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['pk'])."');";
						else
							$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['pk'])."'),";
						$mail->addTo($_SESSION[$arr_type][$msg_to[$m]]['email'], $name);
						$to .= $_SESSION[$arr_type][$msg_to[$m]]['email'] .', <br />';
						$m++;
					}
					try{
						// $mail->send($transport);
						echo " -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email has been sent.<br />";
						executeQuery($query);
					}
					catch(exceptoin $e){
						echo " -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email could not be sent.<br />";;
					}
					unset($mail);
					unset($transport);
				}
			}
			else if($total < 31 && $total > 0){
				$to = '';
				if(isset($_SESSION['SourceEmailIds'])){
					$index = mt_rand(1,sizeof($_SESSION['SourceEmailIds']));
					$email = $_SESSION['SourceEmailIds'][$index]['email'];
					$password = $_SESSION['SourceEmailIds'][$index]['password'];
				}
				else{
					$email = MAILUSER;
					$password = MAILPASS;
				}
				$config = array('auth' => 'login','port' => MAILPORT,'username' => $email,'password' => $password);
				$transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
				$mail = new Zend_Mail();
				$mail->setBodyHtml($msg_content);
				$mail->setFrom($email, $this->parameters["GYMNAME"]);
				$mail->setSubject($msg_sub);
				$query = "INSERT INTO `crm_email`(`id`,`from_email`, `to_email`, `subject`, `text`, `msg_type_id`, `date`, `status`,`customer_pk`)VALUES";
				for($j=1;$j<=$total && $m <= $total;$j++){
					if($j ==  $total)
						$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['pk'])."');";
					else
						$query .= "(NULL,'".mysql_real_escape_string($email)."','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['email'])."','".mysql_real_escape_string($msg_sub)."','".mysql_real_escape_string($msg_content)."',3,NOW(),'13','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$m]]['pk'])."'),";
					$mail->addTo($_SESSION[$arr_type][$msg_to[$m]]['email'], $name);
					$to .= $_SESSION[$arr_type][$msg_to[$m]]['email'] .', <br />';
					$m++;
				}
				try{
					// $mail->send($transport);
					echo " -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email has been sent.<br />";
					executeQuery($query);
				}
				catch(exceptoin $e){
					echo " -- ".$to." -- ".date("d/m/Y, G:i:s")." => Email could not be sent.<br />";;
				}
				unset($mail);
				unset($transport);
			}
		}
		else{
			echo 'No recipient is selected.';
		}
	}
	public function sendSMSTbl(){
		$flag = false;
		$msg_to = $this->parameters["msg_to"];
		$msg_content = $this->parameters["msg_content"];
		$arr_type = $this->parameters["arr_type"];
		$total = sizeof($msg_to)-1;
		if($total > 0){
			$query = "INSERT INTO `crm_sms` ( `id`,`to_email`,`to_mobile`, `text`, `msg_type_id`, `date`, `status`,`customer_pk`) VALUES";
			for($i=1;$i<=$total;$i++){
				if($i == $total)
					$query .= "(NULL,'".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['email'])."','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['cell_number'])."','".mysql_real_escape_string($msg_content)."','".mysql_real_escape_string('4')."',NOW(),'14','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['pk'])."');";
				else
					$query .= "(NULL,'".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['email'])."','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['cell_number'])."','".mysql_real_escape_string($msg_content)."','".mysql_real_escape_string('4')."',NOW(),'14','".mysql_real_escape_string($_SESSION[$arr_type][$msg_to[$i]]['pk'])."'),";
				echo " -- ".$_SESSION[$arr_type][$msg_to[$i]]['email']." -- ".date("d/m/Y, G:i:s") ." => APP Msg has been sent.<br />";
			}
			executeQuery($query);
		}
		return $flag;
	}
	public function listPendingEnquiry(){
		$listofPeoples = NULL;
		$query = 'SELECT 
					a.`id` AS enq_id,
					a.`customer_name` AS cust_name,
					a.`cell_number` AS cust_no,
					a.`email_id` AS cust_email,
					a.`handled_by`,
					a.`referred_by`,
					a.`jop`,
					a.`ft_goal` AS goal,
					a.`comments` AS final_status,
					a.`date` AS enq_day,
					(SELECT group_concat(`id`,\'♥♥♥♥♥\') FROM `enquiry_followups` WHERE `enq_id` = a.`id`) AS  followup_id,
					(SELECT group_concat(`followup_date`,\'♥♥♥♥♥\') FROM `enquiry_followups` WHERE `enq_id` = a.`id`) AS  followup_date,
					(SELECT group_concat(`comments`,\'♥♥♥♥♥\') FROM `enquiry_followups` WHERE `enq_id` = a.`id`) AS  comments,
					(SELECT group_concat(f.`name`,\'♥♥♥♥♥\') FROM `enquiry_on` AS eon LEFT JOIN `facility` AS f ON f.`id`= eon.`facility_id` WHERE eon.`enq_id`= a.`id`) AS  interested_in,
					e.`ads_type`,
					\''.ADMIN_ANON_IMAGE.'\' AS photo
				FROM `enquiry` AS a
				INNER JOIN `enquiry_followups` AS b ON b.`enq_id` = a.`id`
				LEFT JOIN `enquiry_on`        AS c ON c.`enq_id` = a.`id`
				LEFT JOIN `enquiry_reach`     AS d ON d.`enq_id` = a.`id`
				LEFT JOIN `medium_ads`        AS e ON e.`id` = d.`medium_ads_id` AND e.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 )
				WHERE a.`status` !=  (SELECT `id` FROM `status` WHERE `statu_name`=\'Delete\' AND `status`=1 ) 
				AND STR_TO_DATE(NOW(),\'%Y-%m-%d\') = STR_TO_DATE( b.`followup_date`,\'%Y-%m-%d\')
				AND a.`email_id` NOT IN (SELECT `email` AS email FROM `customer` UNION SELECT `user_pk` FROM `email_ids` )
				GROUP BY (a.`id`)
				ORDER BY (a.`id`) DESC';
		$res = executeQuery($query);
		if(mysql_num_rows($res)){
			$i = 1;
			$listofPeoples = array();
			while($row = mysql_fetch_assoc($res)){
				$listofPeoples[$i]['pk'] = $row['enq_id'];
				$listofPeoples[$i]['name'] = $row['cust_name'];
				$listofPeoples[$i]['email'] = $row['cust_email'];
				$listofPeoples[$i]['cell'] = $row['cust_no'];
				$listofPeoples[$i]['photo'] = $row['photo'];
				$listofPeoples[$i]['tbl_name'] = "";
				/* 
				$listofPeoples[$i]['id'] = $row['enq_id'];
				$listofPeoples[$i]['cust_name'] = $row['cust_name'];
				$listofPeoples[$i]['cust_no'] = $row['cust_no'];
				$listofPeoples[$i]['cust_email'] = $row['cust_email'];
				$listofPeoples[$i]['handled_by'] = $row['handled_by']; 
				$listofPeoples[$i]['referred_by'] = $row['referred_by'];
				$listofPeoples[$i]['jop'] = $row['jop'];
				$listofPeoples[$i]['goal'] = $row['goal'];
				$listofPeoples[$i]['final_status'] = str_replace("<br />","\r\n",$row['final_status']);
				$listofPeoples[$i]['enq_day'] = date('d-M-Y',strtotime($row['enq_day'])); 
				$listofPeoples[$i]['followup_id'] = $row['followup_id']; 
				$temp = explode(",",$row['followup_id']);
				if(sizeof($temp)){
					$listofPeoples[$i]['followup_id'] = array();
					for($j=0;$j<sizeof($temp);$j++){
						$listofPeoples[$i]['followup_id'][$j] = $temp[$j];
					}
				}
				else
					$listofPeoples[$i]['followup_id'] = NULL;
				$temp = explode(",",$row['followup_date']);
				if(sizeof($temp)){
					$listofPeoples[$i]['followup_date'] = array();
					for($j=0;$j<sizeof($temp);$j++){
						$listofPeoples[$i]['followup_date'][$j] = date('d-M-Y',strtotime($temp[$j]));
					}
				}
				else
					$listofPeoples[$i]['followup_date'] = NULL;
				$temp = explode("☻♥♥♥☻",$row['comments']);
				if(sizeof($temp)){
					$listofPeoples[$i]['comments'] = array();
					for($j=0;$j<sizeof($temp);$j++){
						$listofPeoples[$i]['comments'][$j] = str_replace("<br />","\r\n",ltrim($temp[$j] , ","));
					}
				}
				else
					$listofPeoples[$i]['comments'] = NULL;
				$listofPeoples[$i]['interested_in'] = str_replace("☻♥♥♥☻","&nbsp;&nbsp;",$row['interested_in']);
				$listofPeoples[$i]['ads_type'] = $row['ads_type'];
				*/
				$i++;
			}
		}
		$_SESSION['listofPeoples'] = $listofPeoples;
		return $listofPeoples;
	}
	public function returnActiveCustomersTracker(){
		$listofPeoples = NULL;
		$query = 'SELECT 
					whole.`pk`,
					whole.`name`,
					whole.`email`,
					whole.`cell`,
					whole.`photo`,
					whole.`tbl_name`,
					CASE WHEN whole.`days` IS NULL
						 THEN \'NA\'
						 ELSE CONCAT(whole.`days`,\' days\')
					END AS days,
					CASE WHEN whole.`offer` IS NULL
						 THEN \'NA\'
						 ELSE whole.`offer`
					END AS offer,
					CASE WHEN whole.`fc_type` IS NULL
						 THEN \'NA\'
						 ELSE whole.`fc_type`
					END AS fc_type
				  FROM (
						SELECT
							tr.`id` AS pk,
							tr.`user_name` AS name,
							tr.`email` AS email,
							tr.`cell_number` AS cell,
							CASE WHEN tr.`photo_id` IS NULL
								 THEN \''.TRAIN_ANON_IMAGE.'\'
								 ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph2.`ver3`)
							END AS photo,
							\'employee\' AS tbl_name,
							\'3\' AS days,
							NULL AS offer,
							NULL AS fc_type
						FROM `employee` AS tr
						LEFT JOIN `photo` AS ph2 ON tr.`photo_id` = ph2.`id`
						LEFT JOIN (SELECT `employee_id`,`in_time` FROM `employee_attendence`
						) AS temp ON temp.`employee_id` = tr.`id`
						WHERE tr.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Joined\' AND `status`=1 )
						AND STR_TO_DATE(temp.`in_time`,\'%Y-%m-%d\') NOT IN (SELECT `in_time` FROM `employee_attendence` WHERE( STR_TO_DATE(`in_time`,\'%Y-%m-%d\') > STR_TO_DATE( DATE_ADD(CURDATE(), INTERVAL \'-3\' DAY),\'%Y-%m-%d\') AND STR_TO_DATE(`in_time`,\'%Y-%m-%d\') < STR_TO_DATE( DATE_ADD(CURDATE(), INTERVAL \'1\' DAY),\'%Y-%m-%d\')))
						UNION
						SELECT
							ur.`id` AS pk,
							ur.`name` AS name,
							ur.`email` AS email,
							ur.`cell_number` AS cell,
							CASE WHEN ur.`photo_id` IS NULL
								 THEN \''.USER_ANON_IMAGE.'\'
								 ELSE CONCAT(\''.URL.ASSET_DIR.'\',ph3.`ver3`)
							END AS photo,
							\'customer\' AS tbl_name,
							temp.`since_when` AS days,
							temp.`offerss` AS offer,
							temp.`facility_type` AS fc_type
						FROM `customer` AS ur
						LEFT JOIN `photo` AS ph3 ON ur.`id` = ph3.`id`
						LEFT JOIN (
							SELECT 
							at. `customer_pk` AS `user_id`,
							at.`in_time`,
							fees.`since_when`,
							fees.`offerss`,
							fees.`facility_type`
							FROM `customer_attendence` AS at
							LEFT JOIN(
								SELECT 
									fe.`id`,
									fe.`customer_pk` AS fee_user_id,
									fe.`offer_id`,
									fe.`no_of_days`,
									fe.`payment_date`,
									fe.`valid_from`,
									fe.`valid_till`,
									DATEDIFF(NOW(),fe.`valid_from`) AS since_when,
									CONCAT(fct.`name`,\' - \',ofs.`name`,\' - \',ofdr.`duration`,\' - \',ofs.`cost`) AS offerss,
									fct.`name` AS `facility_type`
								FROM `fee` AS fe
								INNER JOIN `offers` AS ofs ON ofs.`id` = fe.`offer_id`
								LEFT JOIN `facility` AS fct ON fct.`id` = ofs.`facility_id`
								LEFT JOIN `offerduration` AS ofdr ON ofdr.`id` = ofs.`duration_id`
								WHERE STR_TO_DATE(fe.`valid_till`,\'%Y-%m-%d\') >= STR_TO_DATE(NOW(),\'%Y-%m-%d\') AND STR_TO_DATE(fe.`valid_from`,\'%Y-%m-%d\') <= STR_TO_DATE(NOW(),\'%Y-%m-%d\')
								ORDER BY (ofs.`facility_id`)
							) AS fees ON fees.`fee_user_id` = at.`customer_pk`
						) AS temp ON temp.`user_id` = ur.`id`
						WHERE ur.`status` != \'Left\' AND ur.`status` != \'Delete\'
						AND STR_TO_DATE(temp.`in_time`,\'%Y-%m-%d\') NOT IN (SELECT `in_time` FROM `customer_attendence` WHERE( STR_TO_DATE(`in_time`,\'%Y-%m-%d\') > STR_TO_DATE( DATE_ADD(CURDATE(), INTERVAL \'-15\' DAY),\'%Y-%m-%d\') AND STR_TO_DATE(`in_time`,\'%Y-%m-%d\') < STR_TO_DATE( DATE_ADD(CURDATE(), INTERVAL \'1\' DAY),\'%Y-%m-%d\')))
						OR ur.`id` NOT IN (SELECT `customer_pk` FROM `fee`)
				  ) AS whole;';
		$res = executeQuery($query);
		if(mysql_num_rows($res)){
			$i=1;
			$listofPeoples = array();
			while($row = mysql_fetch_assoc($res)){
					$listofPeoples[$i]['pk'] = $row['pk'];
					$listofPeoples[$i]['name'] = $row['name'];
					$listofPeoples[$i]['email'] = $row['email'];
					$listofPeoples[$i]['cell'] = $row['cell'];
					$listofPeoples[$i]['photo'] = $row['photo'];
					$listofPeoples[$i]['tbl_name'] = $row['tbl_name'];
					$listofPeoples[$i]['days'] = $row['days'];
					$listofPeoples[$i]['offer'] = $row['offer'];
					$listofPeoples[$i]['fc_type'] = $row['fc_type'];
					$i++;
			}
		}
		$_SESSION['listofPeoples'] = $listofPeoples;
		return $listofPeoples;
	}
	//Feedback
	public function loadAllFeedback(){
		$msg_list = array();
		$query = 'SELECT 
					b.`userpk`,
					b.`name`,
					b.`email_id`,
					b.`cell_number`,
					b.`photo`,
					a.`id`,
					a.`customer_pk`,
					a.`equipment`,
					a.`trainers`,
					a.`atmosphere`,
					a.`clean`,
					a.`price`,
					a.`locker`,
					a.`music`,
					a.`lights`,
					a.`remarks`,
					a.`date`,
					a.`status`
				FROM (
					SELECT fd.*  FROM `feedback` AS fd
					WHERE `status` =(SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
				) AS a
				INNER JOIN(
						SELECT 
							temp1.`name`,
							temp1.`email` AS email_id,
							CASE WHEN temp1.`cell_number` IS NULL
								THEN \'Not Provided\'
								ELSE
									CASE WHEN LENGTH(temp1.`cell_number`) = 0
										THEN \'Not Provided\'
										ELSE CONCAT(\'+91 \',temp1.`cell_number`)
									END
							END AS cell_number,
							CASE WHEN temp1.`photo_id` IS NULL
								THEN \''.USER_ANON_IMAGE.'\'
								ELSE CONCAT(\''.URL.ASSET_DIR.'\',temp2.`ver3`)
							END AS photo,
							temp1.`id` AS userpk
						FROM `customer` AS temp1
						LEFT JOIN `photo` AS temp2 ON temp2.`id` = temp1.`photo_id`
				) AS b ON b.`userpk` = a.`customer_pk`
				ORDER BY (a.`customer_pk`);';
		$res = executeQuery($query);
		if(get_resource_type($res) == 'mysql result'){
			if(mysql_num_rows($res) > 0){
				$i = 1;
				while($row = mysql_fetch_assoc($res)){
					$msg_list[$i]['userpk'] = $row['userpk'];
					$msg_list[$i]['id'] = $row['id'];
					$msg_list[$i]['user_name'] = $row['name'];
					$msg_list[$i]['email'] = $row['email_id'];
					$msg_list[$i]['cell_number'] = $row['cell_number'];
					$msg_list[$i]['photo'] = $row['photo'];
					$msg_list[$i]['equp'] = $row['equipment'];
					$msg_list[$i]['trainer'] = $row['trainers'];
					$msg_list[$i]['atm'] = $row['atmosphere'];
					$msg_list[$i]['gym_cln'] = $row['clean'];
					$msg_list[$i]['price'] = $row['price'];
					$msg_list[$i]['locker'] = $row['locker'];
					$msg_list[$i]['music'] = $row['music'];
					$msg_list[$i]['lights'] = $row['lights'];
					$msg_list[$i]['remarks'] = $row['remarks'];
					$msg_list[$i]['date'] = $row['date'];
					$msg_list[$i]['status'] = $row['status'];
					$i++;
				}
			}
		}
		return $msg_list;
	}
	public function ListUsersFeedback($begin,$end){
		$num_posts = 0;
		if(isset($_SESSION['msg_list']) && $_SESSION['msg_list'] != NULL)
			$msg_list = $_SESSION['msg_list'];
		else
			$msg_list = NULL;
		if($msg_list != NULL)
			$num_posts = sizeof($msg_list);
		$color = array('#008299','#2672EC','#8C0095','#5133AB','#AC193D','#D24726','#008A00','#094AB2','#4E0000','#691BB8','#180052','#C1004F','#16499A','#2D652B','#9E1716');
		if($num_posts > 0){
			for($i=$begin;$i<=$end && $i <= $num_posts && isset($msg_list[$i]['email']);$i++){
				$col = $color[mt_rand(0,sizeof($color)-1)];
				$stauts = ( $msg_list[$i]['status'] == 'sent' ) ? '<font style="color:#090;">Sent</font>' : '<font style="color:#090;">Pending</font>';
				echo  '<div class="col-lg-3 col-md-4">
							 <div class="panel panel-primary" id="user_list_'.$i.'" >
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<img width="58" height="58" src="'.$msg_list[$i]['photo'].'" border="0"/>
										</div>
										<div class="col-xs-9 text-left">
											<span id="user_name_'.$i.'">
												'.$msg_list[$i]['user_name'].'
											</span><br />
											<span id="user_email_'.$i.'">
												'.$msg_list[$i]['email'].'
											</span><br />
											<span id="user_cell_'.$i.'">
												'.$msg_list[$i]['cell_number'].'
											</span><br />
										</div>
									</div>
								</div>
								<a href="javascript:void(0)" class="gymLink" id="'.$i.'">
									<div class="panel-footer" id="click_'.$i.'">
										<span class="pull-left"><span id="user_num_'.$i.'">
										 <strong>FeedBack Details</strong>
									</span></span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						<script language="javascript">
							$("#click_'.$i.'").on("click",function(){
								var obj = new controlCRMFeedBack();
								obj.displayFeedBack('.json_encode($this->parameters["fb"]).','.$i.');
							});
						
					</script>';	
			}
		}
			
		else{
			echo 'No messages to list.';
		}
	}
	public function LoadFeedbackForm(){
		$obj = new crmModule($this->parameters);
		$listofPeoples = '';
		$colleagueshtml = 'var listofPeoples = [];';
		$colleaguesimghtml = 'var listofimages = [];';
			$listofPeoples = $obj->returnListofPeoples("users");
				$colleagueshtml = $listofPeoples["colleagueshtml"];
				$colleaguesimghtml = $listofPeoples["colleaguesimghtml"];
				for($i=0;$i<=7;$i++){
				$option[$i] = ' <label class="radio-inline">
								<input type="radio" name="feedback_'.$i.'"  value="Poor" >Poor
							</label>
							<label class="radio-inline">
								<input type="radio" name="feedback_'.$i.'" value="Fair">Fair
							</label>
							<label class="radio-inline">
								<input type="radio" name="feedback_'.$i.'"  value="Good">Good
							</label>
							<label class="radio-inline">
								<input type="radio" name="feedback_'.$i.'"  value="Very Good">Very Good
							</label>
							<label class="radio-inline">
								<input type="radio" name="feedback_'.$i.'"  value="Excellent" checked>Excellent
							</label>';
					}	
				echo '<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Please fill the feedback form</h4>
						</div>
						<div class="panel-body">
							<form role="form" id="enquiry_form">
								<fieldset>
									<div class="row">
									<div class="col-lg-12">
									<div class="form-group">
										<label>User(Email ID/name):</label>
										<span>
											<div id="list_ref1"></div>
											<div class="form-group">
												<input  id="ref_usr" name="msg_to" type="text" class="form-control" placeholder="Name - Email id - Cell number" />
												<script language="javascript" type="text/javascript">
														'.$colleagueshtml.'
														 $("#ref_usr").autocomplete({
															 source: listofPeoples,
															 select: function (event, ui) {
																'.$colleaguesimghtml.'
																var i = 1;
																for (var key in listofimages)
																{
																	if(ui.item.value == listofimages[key].value && listofimages[key].value == i)
																	{
																		
																		$("#list_ref1").append("<p>"+listofimages[key].label +
																										"&nbsp;" +
																										ui.item.label+
																										"&nbsp;" +
																										"<a href=\"javascript:void(0);\" onClick=\"$(\'#ref_usr\').show();$(this).parent().remove();listofPeoples.push({label:\'"+ui.item.label+"\',value:\'"+ui.item.value+"\'});$(\'#ref_usr\').autocomplete(\'option\',\'source\',listofPeoples);\" style=\"color:#FF0000;\">Delete</a>"+
																										"<input type=\"hidden\" id=\"msg_to\" value=\""+ui.item.label+"\" />"+
																										"</p>");
																		break;
																	}
																	i++;
																}
																// listofPeoples = listofPeoples.filter(function(el){ return el.label != ui.item.label; });
																// $(this).autocomplete("option","source",listofPeoples);
																$(this).hide();
																$(this).val("");
															}
														 }).data("ui-autocomplete")._renderItem = function (ul, item) {
															'.$colleaguesimghtml.'
															var i = 1;
															for (var key in listofimages)
															{
																if(item.value == listofimages[key].value && listofimages[key].value == i)
																{
																	 return $("<li></li>")
																		 .data("item.autocomplete", item)
																		 .append( "<a>" + listofimages[key].label + "&nbsp;" + item.label + "</a>")
																		 .appendTo(ul);
																}
																i++;
															}
														 };
												</script>
											</div>
										</span>
										<p class="help-block"></p>
									</div>
									</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<label>Equipment :</label><br/>
													<span>
														<label id="equp">
															'.$option[0].'
														</label>
													</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label>Trainers :</label><br/>
													<span>
														<label id="trainer">
															'.$option[1].'
														</label>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<label>Atmosphere :</label><br/>
													<span>
														<label id="atm">
															'.$option[2].'
														</label>
													</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label>Gym Cleanliness:</label><br/>
													<span>
														<label id="gym_cln">
															'.$option[3].'
														</label>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<label>Price :</label></br>
													<span>
														<label id="price">
															'.$option[4].'
														</label>
													</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label>GYM facilities :</label><br/>
													<span>
														<label id="locker">
															'.$option[5].'
														</label>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<label>Music :</label><br/>
													<span>
														<label id="music">
															'.$option[6].'
														</label>
													</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label>Lightings:</label><br/>
													<span>
														<label id="lights">
															'.$option[7].'
														</label>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label>Complains / Suggestions :</label><br/>
												<span>
													<textarea id="msg_content" class="form-control" placeholder="Enter your message"></textarea>
												</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<button type="button" class="btn btn-lg btn-success btn-block" id="save"> SAVE </button>
											</div>
										</div>
										<div id="msgdiv"></div>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
			<script>
				$(document).ready(function(){
					var entryfeedback = {
						autoloader 		: true,
						action 	   		: "entryfeedback",
						form			: "#enquiry_form",
						name			: "#ref_usr",
						msg_to			: "#msg_to",
						equ				: "#equp",
						tra				: "#trainer",
						atm				: "#atm",
						gym_cln			: "#gym_cln",
						price			: "#price",
						gym_fac			: "#locker",
						music			: "#music",
						light			: "#lights",
						comp_sugg		: "#msg_content",
						save			: "#save",
						feedout			: "#msgdiv",
						url				: window.location.href
					};
					var obj = new controlCRMFeedBack();
					obj.entryfeedback(entryfeedback);
				});
			</script>
			';
			
	}
	public function SaveFeedback(){
		$flag = false;
				$temp = explode("-",$this->parameters["msg_to"]);
				$email = trim($temp[1]);
				$query = "SELECT *
						FROM `customer`
						WHERE  
						`email` = '".mysql_real_escape_string($email)."'
						";
				$res = executeQuery($query);
				if(get_resource_type($res) == 'mysql result'){
					if(mysql_num_rows($res) > 0){
						$row = mysql_fetch_assoc($res);
						$pk_id = $row['id'];
						$query = "INSERT INTO `feedback`
								(`id`, `customer_pk`, `equipment`, `trainers`, `atmosphere`, `clean`, `price`, `locker`, `music`, `lights`, `remarks`, `date`, `status`) 
								VALUES 
								(NULL,
								'".mysql_real_escape_string($pk_id)."',
								'".mysql_real_escape_string($this->parameters["equipment"])."',
								'".mysql_real_escape_string($this->parameters["trainer"])."',
								'".mysql_real_escape_string($this->parameters["atmosphere"])."',
								'".mysql_real_escape_string($this->parameters["gym_clean"])."',
								'".mysql_real_escape_string($this->parameters["price"])."',
								'".mysql_real_escape_string($this->parameters["gym_facility"])."',
								'".mysql_real_escape_string($this->parameters["music"])."',
								'".mysql_real_escape_string($this->parameters["lightings"])."',
								'".mysql_real_escape_string($this->parameters["complent"])."',
								NOW(),
								4);
								";
						$res = executeQuery($query);
						if($res)
						$flag = true;
					}
				}
		
		return $flag;
	}
	public function displayFeedBack(){
		$msg_list = $_SESSION['msg_list'];
		$i = $this->parameters["index"];
		echo '<a href="javascript:void(0);" id="back_link"><h4><-Back</h4></a>
			<div class="">
				<table border="1" class="table table-striped table-bordered">
					<tr >
						<td colspan="2">
							<div id="ind_det_left"><img src='.$msg_list[$i]['photo'].' width="70" height="70" /></div>
							<div id="ind_det_right">
								<strong>'.$msg_list[$i]['user_name'].'<br />
								'.$msg_list[$i]['email'].'<br />
								'.$msg_list[$i]['cell_number'].'<br />
								'.$msg_list[$i]['date'].'</strong>
							</div>
						</td>
					</tr>
					<tr >
						<td width="25%">Equipment :</td>
						<td>'.$msg_list[$i]['equp'].'*</td>
					</tr>
					<tr>
						<td>Trainers :</td>
						<td>'.$msg_list[$i]['trainer'].'*</td>
					</tr>
					<tr>
						<td>Atmosphere</td>
						<td>'.$msg_list[$i]['atm'].'*</td>
					</tr>
					<tr>
						<td>Cleanliness :</td>
						<td>'.$msg_list[$i]['gym_cln'].'*</td>
					</tr>
					<tr>
						<td>Price :</td>
						<td>'.$msg_list[$i]['price'].'*</td>
					</tr>
					<tr>
						<td>Facilities :</td>
						<td>'.$msg_list[$i]['locker'].'*</td>
					</tr>
					<tr>
						<td>Music :</td>
						<td>'.$msg_list[$i]['music'].'*</td>
					</tr>
					<tr>
						<td>Lights :</td>
						<td>'.$msg_list[$i]['lights'].'*</td>
					</tr>
					<tr>
						<td>
							<h3>Remarks :</h3>
						</td>
						<td>'.$msg_list[$i]['remarks'].'
						</td>
					</tr>
				</table>	
			</div>';
	}
	public function LoadTotalMsg(){
		$total_month = '0';
		$total_feeds = '0';
		$flag = 0;
		$query1 = "SELECT * FROM `feedback`";
		$query2 = "SELECT * FROM `feedback` WHERE date LIKE '%".mysql_real_escape_string(date('Y-m-'))."%';";
		$res1 = executeQuery($query1);
		$res2 = executeQuery($query2);
		if(get_resource_type($res1) == 'mysql result' && get_resource_type($res2) == 'mysql result'){
			if(mysql_num_rows($res1) > 0 && mysql_num_rows($res2) > 0){
					$total_month = mysql_num_rows($res2);
					$total_feeds = mysql_num_rows($res1);	
					$flag = 1;
				}
			}
		echo '
			<div class="col-lg-3 col-md-6">
				 <div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-bar-chart fa-5x"></i>
				</div>
							<div class="col-xs-9 text-right">
								<div class="huge">'.$total_month.'</div>
								<div> FEEDBACK this month </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				 <div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-bar-chart fa-5x"></i>
				</div>
							<div class="col-xs-9 text-right">
								<div class="huge">'.$total_feeds.'</div>
								<div> Total FEEDBACK</div>
							</div>
						</div>
					</div>
				</div>
			</div>';
	}
}
?>
