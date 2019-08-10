
<?php
class Manage{
	protected $parameters = array();
	function __construct($para	=	false){
		$this->parameters=$para;	
	}	 
	function customer_att($parameters){
	  // $name = false,$mobile = false,$email = false,$offer = false,$duration = false,$package = false,$jnd = false,$exp_date = false
		$listusers = NULL;
		$query1 = "SELECT
						a.`id` ,
						a.`name` ,
						a.`email_id`,
						b.`valid_from` ,
						b.`valid_till`,
						c.`name` AS offer,
						c.`facility_type`,
						CASE
							WHEN ph.`ver2` IS NOT NULL
							THEN CONCAT('".URL.ASSET_DIR."', ph.`ver2`)
							ELSE '".USER_ANON_IMAGE."'
						END AS uphoto
						FROM  `users` AS a
						LEFT  JOIN  `group_members` AS gm ON a.`email_id` =  gm.`user_id` AND gm.`status` != 'left'
						LEFT  JOIN  `groups` AS gr ON gr.`id` =  gm.`group_id` AND gr.`status` != 'delete'
						INNER JOIN  `fee` AS b ON a.`email_id` = b.`user_id` OR gr.`owner` = b.`user_id`
						INNER JOIN  `offers` AS c ON b.`offer_id` = c.`id` AND (c.`facility_type` = 'Gym' OR c.`facility_type` = 'Aerobics' OR c.`facility_type` = 'Dance' OR c.`facility_type` = 'Yoga' OR c.`facility_type` = 'Zumba')
						LEFT  JOIN  `photo` AS ph ON ph.`picture_id` = a.`photo_id`
						WHERE (a.`email_id` =  b.`user_id` OR gr.`owner` =  b.`user_id`)
						ORDER BY c.`facility_type`;";
		$query="SELECT
					GROUP_CONCAT(g.`id`,'☻☻♥♥☻☻') AS cust_id,
					GROUP_CONCAT(g.`cust_name`,'☻☻♥♥☻☻') AS cust_name,
					GROUP_CONCAT(g.`cust_email`,'☻☻♥♥☻☻') AS cust_email,
					GROUP_CONCAT(g.`occupation`,'☻☻♥♥☻☻') AS occupation,
					g.`facility_id`,
					GROUP_CONCAT(g.`uphoto`,'☻☻♥♥☻☻') AS cphoto
					FROM(
					SELECT
		            cft.`facility_id` AS facility_id,
		            cust.`id` AS id,
					cust.`name` AS cust_name,
					cust.`email` AS cust_email,
					cust.`occupation` AS occupation,
					CASE
						WHEN ph.`ver2` IS NOT NULL
						THEN CONCAT('".URL.ASSET_DIR."', ph.`ver2`)
						ELSE '".USER_ANON_IMAGE."'
					END AS uphoto    
					FROM `customer` As cust
					LEFT  JOIN  `group_members` AS gm ON cust.`id` =  gm.`customer_pk` AND gm.`status` = (SELECT id FROM `status` WHERE statu_name = 'Joined' and status=1)
					LEFT  JOIN  `groups` AS gr ON gr.`id` =  gm.`group_id` AND gr.`status` = (SELECT id FROM `status` WHERE statu_name = 'Show' and status=1)
					LEFT  JOIN  `photo` AS ph ON ph.`id` = cust.`photo_id`
					LEFT  JOIN  `customer_facility` AS cft ON cft.`customer_pk` = cust.`id` AND cft.`status` =(SELECT id FROM `status` WHERE statu_name = 'Show' and status=1)					
					WHERE cft.`customer_pk` = cust.`id`
					) as g
					WHERE g.`facility_id` = '".$parameters["fid"]."'
					";
							
				$res = executeQuery($query);
				if(mysql_num_rows($res)){
					$i = 0;
					while( $row = mysql_fetch_assoc($res)){
						$listusers[$i]['id'] = $row['cust_id'];
						$listusers[$i]['name'] = $row['cust_name'];
						$listusers[$i]['email_id'] = $row['cust_email'];
						$listusers[$i]['occupation'] = $row['occupation'];
						//$listusers[$i]['offer'] = $row['offer'];
						$listusers[$i]['facility_type'] = $row['facility_id'];
						//$listusers[$i]['valid_from'] = $row['valid_from'];
						//$listusers[$i]['valid_till'] = $row['valid_till'];
						$listusers[$i]['uphoto'] = $row['cphoto'];
						$listusers[$i]['facility_id'] = $row['facility_id'];
						$i++;
						}
					}
		//DisplayList($listusers);
		$att = new manage();
		$att->DisplayList($listusers);
	}
	function AttendanceToday($id,$facility_type){
		$flag = NULL;
		$query = "SELECT
					a.`id` AS cust_pk,
					d.`id` AS att_id,
					d.`in_time`,
					d.`out_time`,
					d.`status`
					FROM  `customer` AS a
					INNER JOIN  `customer_attendence` AS d
					ON d.`customer_pk` =  a.`id`
					WHERE a.`id` =  '".$id."'
					AND d.`customer_pk` =  '".$id."'
					AND d.`facility_id` = '".$facility_type."'
					AND d.in_time LIKE '".date('Y-m-d')."%'
					ORDER BY d.`id` DESC
					LIMIT 1;";
		$res = executeQuery($query);
		if(mysql_num_rows($res)){
			$flag = mysql_fetch_assoc($res);
		}
		 return $flag;
	}
	function DisplayList($listusers) {
		$users = array();
		$total = sizeof($listusers);
		$users[0]["facility_id"] = $listusers[0]['facility_id'];
			if($total){
				for($i=0;$i<$total;$i++){
					$users[$i]["uphoto"] = explode("☻☻♥♥☻☻",$listusers[$i]["uphoto"]);
					$users[$i]["cust_id"] = explode("☻☻♥♥☻☻",$listusers[$i]["id"]);
					$users[$i]["name"] = explode("☻☻♥♥☻☻",$listusers[$i]["name"]);
					$users[$i]["email_id"] = explode("☻☻♥♥☻☻",$listusers[$i]["email_id"]);
					$users[$i]["facility_type"] = explode("☻☻♥♥☻☻",$listusers[$i]["facility_type"]);
					$users[$i]["occupation"] = explode("☻☻♥♥☻☻",$listusers[$i]["occupation"]);
				}
			}
			else{
				$users = NULL;
			}
	   
	   $num_posts=sizeof($users);
	   
	  	echo '<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" id="atttable">
	  	       <thead>
	  	       <tr>
	  	        <th>No</th>
	  	        <th>Customer</th>
	  	        <th>Deatails</th>
	  	        <th>In time</th>
	  	        <th>Out time</th>
	  	        <th>Status</th>
	  	      </tr></thead>';
	  	      $name='';$email='';
	  	      $totalname=0;$totalemail=0;
	  	for($i=0;$i<$num_posts;$i++){
		
		  for($k=1;$k<sizeof($users[$i]["name"]);$k++)
		   {	
			 $name=ltrim($users[$i]["name"][$k-1] ,',');
			 $id=ltrim($users[$i]["cust_id"][$k-1] ,',');
			 if(!isset($name))
			  {
				  $name = '<strong>Not Provided</strong>';
			  }
			 $photo=ltrim($users[$i]["uphoto"][$k-1] ,',');
			 if((!isset($photo)) || (!file_exists($photo)))
			  {
				  $photo = USER_ANON_IMAGE;
			  }
			 $email=ltrim($users[$i]["email_id"][$k-1] ,',');
			 if(!isset($email))
			  {
				  $email = '<strong>Not Provided</strong>';
			  }
			 $occupation=ltrim($users[$i]["occupation"][$k-1] ,',');
			 if(!isset($occupation))
			  {
				  $occupation = '<strong>Not Provided</strong>';
			  }
			 		$att1 = new manage();
					$row =$att1->AttendanceToday($users[$i]["cust_id"][$k-1],$users[0]["facility_id"]);
								$mark =  '' ;
								$in_time = '---';
								$out_time = '---';
								$color='<span class="text-danger"><i class="fa  fa-circle fa-3x fa-fw"></i></span>';
								$aid = NULL;
								if(isset($row["att_id"])){
								if($row != NULL && $row['status'] == 11){
									$in_time = date('g:i a', strtotime($row['in_time']));
									
									if($row['status'] == 12)
										$out_time =  date('g:i a', strtotime($row['out_time']));
									else{
										$out_time = '---';
										$mark = 'checked';
										$color='<span class="text-success"><i class="fa  fa-check-circle fa-3x fa-fw"></i></span>';
									}
									 $aid = $row['att_id'];

								}
								if($row != NULL && $row['status'] == 12){
									
									$in_time = date('g:i a', strtotime($row['in_time']));
									if($row['status'] == 12)
										$out_time =  date('g:i a', strtotime($row['out_time']));
									else{
										$out_time = '---';
										//$mark = 'checked';
										$color='<span class="text-danger"><i class="fa  fa-circle fa-3x fa-fw"></i></span>';
									}
									$aid = $row['att_id'];
								}
							}
							else{
								   $aid = "NULL";
								}	
		  echo '<tr>
	  	       <td>'.$k.'</td>
	  	       <td>
	  	         <div style="float:left; width:100px; height:100px; overflow:hidden;" id="uimgs">
					<img src='.$photo.' width="100" height="100" />
				</div>
			   </td>
	  	       <td>
				<div style="float:left;" id="details">
					'.$name.' <br />
					'.$email.' <br />
					'.$occupation.' <br />
				</div>
			  </td>
			  <td id="'.$users[0]["facility_id"].'"_"'.$k.'"_intime" widht="25%">'.$in_time.'</td>
			  <td id="'.$users[0]["facility_id"].'"_"'.$k.'"_outtime" widht="25%">'.$out_time.'</td>
			  <td style="cursor:pointer;" id="mark_'.$k.'" align="center" valign="center" widht="20%">
				'.$color.'
			  </td>
	  	      </tr>';
	  	    echo '<script>
					$(document).ready(function(){
					var att = {
						photo	:	"#uimgs",
						att_id	:	"'.$aid.'",
						btn		:	"#mark_'.$k.'",
						cust_pk	:	"'.$id.'",
						index	:	'.$k.',
						in_time	:	"#'.$users[0]["facility_id"].'_'.$k.'_intime",
						out_time:	"#'.$users[0]["facility_id"].'_'.$k.'_outtime",
						facility:	"'.$users[0]["facility_id"].'",
					};
					var obj = new controlManage();
					obj.attadancetable(att);
				});	
			  </script>';
	  	      
		 }
		} 	
	  	echo "</table>";
	  	echo '<script>
					$(document).ready(function(){
					var att = {
						tableid	:	"#atttable",
					};
					var obj = new controlManage();
					obj.attadancetable(att);
				});	
			  </script>';
	  	
	}
	function UpdateAtd($id,$aid,$ftype){
		$flag = false;
		  if($aid != "NULL"){ 
		   $res = executeQuery("UPDATE `customer_attendence`
							SET `out_time` = NOW(), `status` = 12
							WHERE `id` = '".mysql_real_escape_string($aid)."'
							AND STR_TO_DATE(NOW(),'%Y-%m-%d %H:%i:%s') >= STR_TO_DATE(`in_time`,'%Y-%m-%d %H:%i:%s')
							AND `status` = 11;");
			if($res)
				echo '0';
			else
				echo '-1';
					
			}
		else{
			$res = executeQuery("INSERT INTO `customer_attendence` (`id`,`in_time`, `out_time`, `facility_id`,`status`,`customer_pk` )
									VALUES (NULL,NOW() ,NOW()+ INTERVAL 2 HOUR ,".$ftype.", default,".$id.");");
			if($res)
				echo '1';
			else
				echo '-2';
			
			}
		}		
}	
	
 
?>
