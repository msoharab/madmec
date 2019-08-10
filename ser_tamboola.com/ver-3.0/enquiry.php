<?php
	class enquiry {
		protected $parameters = array();
		private $order = array("\r\n", "\n", "\r", "\t");
		private $replace = '';
		function __construct($para = false) {
			$this->parameters = $para;
		}
		public function checkUserInEnquiry($cellnum) {
			$query="SELECT * FROM `enquiry` WHERE `cell_number`='".  mysql_real_escape_string($cellnum)."' AND `status`=14";
			$result=  executeQuery($query);
			if(mysql_num_rows($result))
			{
				$row=  mysql_fetch_assoc($result);
				$jsondata=array(
                "status" => "success",
                "name" => $row['customer_name'],
                "email" => $row['email_id'],
				);
				return $jsondata;
			}
			else
			{
				$jsondata=array(
                "status" => "failure",
                "name" => NULL,
                "email" => NULL,
				);
				return $jsondata;
			}
		}
		public static function listEnquiries($para = false) {
			$listofenquiries = array();
			$searchQuery = $para;
			$query = 'SELECT
			group_concat(group_con.`enq_id`,\'☻☻☻☻☻\') 		AS enq_id,
			group_concat(group_con.`cust_name`,\'☻☻☻☻☻\') 	AS cust_name,
			group_concat(group_con.`cust_no`,\'☻☻☻☻☻\') 	AS cust_no,
			group_concat(group_con.`cust_email`,\'☻☻☻☻☻\') 	AS cust_email,
			group_concat(group_con.`handled_by`,\'☻☻☻☻☻\')	AS handled_by,
			group_concat(group_con.`referred_by`,\'☻☻☻☻☻\')	AS referred_by,
			group_concat(group_con.`jop`,\'☻☻☻☻☻\')			AS jop,
			group_concat(group_con.`goal`,\'☻☻☻☻☻\') 		AS goal,
			group_concat(group_con.`final_status`,\'☻☻☻☻☻\')AS final_status,
			group_con.`enq_day`	 							AS enq_day,
			group_concat(group_con.followup_id,\'☻☻☻☻☻\')	AS followup_id,
			group_concat(group_con.followup_date,\'☻☻☻☻☻\')	AS followup_date,
			group_concat(group_con.comments,\'☻☻☻☻☻\')		AS comments,
			group_concat(group_con.interested_in,\'☻☻☻☻☻\')	AS interested_in,
			group_concat(group_con.`ads_type`,\'☻☻☻☻☻\')	AS ads_type
			FROM(
			SELECT
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
			e.`ads_type`
			FROM `enquiry` AS a
			INNER JOIN `enquiry_followups` AS b ON b.`enq_id` = a.`id` ' . $searchQuery["searchQueryB"] . ' ' . $searchQuery["ListQuery"] . '
			LEFT JOIN `enquiry_on`        AS c ON c.`enq_id` = a.`id`
			LEFT JOIN `enquiry_reach`     AS d ON d.`enq_id` = a.`id`
			LEFT JOIN `medium_ads`        AS e ON e.`id` = d.`medium_ads_id` AND e.`status` = (SELECT `id` FROM `status` WHERE `statu_name`=\'Show\' AND `status`=1 ) ' . $searchQuery["searchQueryC"] . '
			WHERE a.`status` !=  (SELECT `id` FROM `status` WHERE `statu_name`=\'Delete\' AND `status`=1 ) ' . $searchQuery["searchQueryA"] . '
			AND a.`email_id` NOT IN (SELECT `email` AS email FROM `customer` UNION SELECT `user_pk` FROM `email_ids` )
			GROUP BY (a.`id`)
			ORDER BY (a.`id`) DESC
			) AS group_con
			GROUP BY (group_con.`enq_day`);';
			$res = executeQuery($query);
			if (mysql_num_rows($res)) {
				$i = 1;
				while ($row = mysql_fetch_assoc($res)) {
					$id = explode("☻☻☻☻☻", $row['enq_id']);
					$cust_name = explode("☻☻☻☻☻", $row['cust_name']);
					$cust_no = explode("☻☻☻☻☻", $row['cust_no']);
					$cust_email = explode("☻☻☻☻☻", $row['cust_email']);
					$handled_by = explode("☻☻☻☻☻", $row['handled_by']);
					$referred_by = explode("☻☻☻☻☻", $row['referred_by']);
					$jop = explode("☻☻☻☻☻", $row['jop']);
					$goal = explode("☻☻☻☻☻", $row['goal']);
					$final_status = explode("☻☻☻☻☻", $row['final_status']);
					$enq_day = $row['enq_day'];
					$followup_id = explode("☻☻☻☻☻", $row['followup_id']);
					$followup_date = explode("☻☻☻☻☻", $row['followup_date']);
					$comments = explode("☻☻☻☻☻", $row['comments']);
					$interested_in = explode("☻☻☻☻☻", $row['interested_in']);
					$ads_type = explode("☻☻☻☻☻", $row['ads_type']);
					(is_array($id)) ? array_pop($id) : $id;
					(is_array($cust_name)) ? array_pop($cust_name) : $cust_name;
					(is_array($cust_no)) ? array_pop($cust_no) : $cust_no;
					(is_array($cust_email)) ? array_pop($cust_email) : $cust_email;
					(is_array($handled_by)) ? array_pop($handled_by) : $handled_by;
					(is_array($referred_by)) ? array_pop($referred_by) : $referred_by;
					(is_array($jop)) ? array_pop($jop) : $jop;
					(is_array($goal)) ? array_pop($goal) : $goal;
					(is_array($enq_day)) ? array_pop($enq_day) : $enq_day;
					(is_array($followup_id)) ? array_pop($followup_id) : $followup_id;
					(is_array($followup_date)) ? array_pop($followup_date) : $followup_date;
					(is_array($comments)) ? array_pop($comments) : $comments;
					(is_array($interested_in)) ? array_pop($interested_in) : $interested_in;
					(is_array($ads_type)) ? array_pop($ads_type) : $ads_type;
					if (sizeof($id)) {
						$listofenquiries[$i]['enq_day'] = date('d-M-Y', strtotime(ltrim($enq_day, ",")));
						for ($j = 0; $j < sizeof($id); $j++) {
							$listofenquiries[$i]['id'][$j] = ltrim($id[$j], ",");
							$listofenquiries[$i]['cust_name'][$j] = ltrim($cust_name[$j], ",");
							$listofenquiries[$i]['cust_no'][$j] = ltrim($cust_no[$j], ",");
							$listofenquiries[$i]['cust_email'][$j] = ltrim($cust_email[$j], ",");
							$listofenquiries[$i]['handled_by'][$j] = (($handled_by[$j] != ",") && ($handled_by[$j] != "")) ? ltrim($handled_by[$j], ",") : "Not Provided";
							$listofenquiries[$i]['referred_by'][$j] = (($referred_by[$j] != ",") && ($referred_by[$j] != "")) ? ltrim($referred_by[$j], ",") : "Not Provided";
							$listofenquiries[$i]['jop'][$j] = ltrim($jop[$j], ",") . " Days";
							$listofenquiries[$i]['goal'][$j] = ltrim($goal[$j], ",");
							$listofenquiries[$i]['final_status'][$j] = str_replace("<br />", "\r\n", ltrim($final_status[$j], ","));
							if (isset($followup_id[$j])) {
								$listofenquiries[$i]['followup_id'][$j] = ltrim($followup_id[$j], ",");
								$temp = explode("♥♥♥♥♥", $listofenquiries[$i]['followup_id'][$j]);
								(is_array($temp)) ? array_pop($temp) : $temp;
								if (sizeof($temp)) {
									$listofenquiries[$i]['followup_id'][$j] = array();
									for ($k = 0; $k < sizeof($temp); $k++) {
										$listofenquiries[$i]['followup_id'][$j][$k] = ltrim($temp[$k], ",");
									}
								}
							} else
                            $listofenquiries[$i]['followup_id'][$j] = NULL;
							if (isset($followup_date[$j])) {
								$listofenquiries[$i]['followup_date'][$j] = ltrim($followup_date[$j], ",");
								$temp = explode("♥♥♥♥♥", $listofenquiries[$i]['followup_date'][$j]);
								(is_array($temp)) ? array_pop($temp) : $temp;
								if (sizeof($temp)) {
									$listofenquiries[$i]['followup_date'][$j] = array();
									for ($k = 0; $k < sizeof($temp); $k++) {
										$listofenquiries[$i]['followup_date'][$j][$k] = ltrim($temp[$k], ",");
									}
								}
							} else
                            $listofenquiries[$i]['followup_date'][$j] = NULL;
							if (isset($comments[$j])) {
								$listofenquiries[$i]['comments'][$j] = ltrim($comments[$j], ",");
								$temp = explode("♥♥♥♥♥", $listofenquiries[$i]['comments'][$j]);
								(is_array($temp)) ? array_pop($temp) : $temp;
								if (sizeof($temp)) {
									$listofenquiries[$i]['comments'][$j] = array();
									for ($k = 0; $k < sizeof($temp); $k++) {
										$listofenquiries[$i]['comments'][$j][$k] = ltrim($temp[$k], ",");
									}
								}
							} else
                            $listofenquiries[$i]['comments'][$j] = NULL;
							$listofenquiries[$i]['interested_in'][$j] = ((isset($interested_in[$j])) && ($interested_in[$j] != ",") && ($interested_in[$j] != "")) ? str_replace("♥♥♥♥♥", "&nbsp;&nbsp;", ltrim($interested_in[$j], ",")) : "Not Provided";
							$listofenquiries[$i]['ads_type'][$j] = ((isset($ads_type[$j])) && ($ads_type[$j] != ",") && ($ads_type[$j] != "")) ? ltrim($ads_type[$j], ",") : "Not Provided";
						}
					}
					$i++;
				}
			} else
            $listofenquiries = NULL;
			return $listofenquiries;
		}
		public function displayEnquiresList($initial, $final) {
			$listenquiry = array(
            "html" => '<strong class="text-danger">There are no users available !!!!</strong>',
            "eid" => 0,
            "sr" => '',
            "usrdelOk" => '',
            "usrdelCancel" => '',
            "fUpdate" => '',
            "usrflgOk" => '',
            "usrflgCancel" => '',
            "butuflg" => '',
            "alertUSRUFLG" => '',
            "usruflgOk" => '',
            "usruflgCancel" => '',
            "usredit" => ''
			);
			$htm = '';
			$script = '';
			$post_ids = array();
			$num_posts = 0;
			//$theme = array('default','success','danger','warning','cyan');
			$theme = array('warning','success','info');
			if (isset($_SESSION['listofenquiries']) && $_SESSION['listofenquiries'] != NULL)
            $post_ids = $_SESSION['listofenquiries'];
			else
            $post_ids = NULL;
			if ($post_ids != NULL) {
				$num_posts = sizeof($post_ids)-1;
			}
			if ($num_posts > 0) {
				$i = $initial;
				// $acs_id = AddAcsId()-1;
				$htm .= '<div class="row">
				<div class="col-lg-12">
				<div class="panel-group" id="accordion_enq">';
				for ($i = $initial; $i <= $final && $i <= $num_posts && isset($post_ids[$i]); $i++) {
					$enq_today = sizeof($post_ids[$i]['id']);
					$htm .= '<div class="panel panel-' . $theme[mt_rand(0, 2)] . '" id="enq_row_' . $i . '">
					<div class="panel-heading">
					<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion_enq" href="#collapse_' . $i . '" id="scroll_to_' . $i . '">Day of enquiry :&nbsp;' . $post_ids[$i]['enq_day'] . ', Number of enquires :&nbsp;<span id="num_enq_' . $i . '">' . $enq_today . '</span></a>
					</h4>
					</div>
					<div id="collapse_' . $i . '" class="panel-body panel-collapse collapse" ><ul class="timeline">';
					for ($j = 0; $j < $enq_today && isset($post_ids[$i]['id']) && $post_ids[$i]['id'] != ''; $j++) {
						$inverted = ($j > 0 && $j % 2 ) ? 'timeline-inverted' : '';
						$htm .= '<li class="' . $inverted . '">
						<div class="timeline-badge warning">' . ($j + 1) . '</div>
						<div class="timeline-panel" id="enquiry_' . $post_ids[$i]['id'][$j] . '">
						<h4 class="timeline-title">' . $post_ids[$i]['cust_name'][$j] . ' - ' . $post_ids[$i]['cust_no'][$j] . '</h4>
						<div class="timeline-body">
						<ul class="nav nav-tabs">
						<li class="active"><a href="#home_' . $post_ids[$i]['id'][$j] . '" data-toggle="tab">Basic</a></li>
						<li><a href="#profile_' . $post_ids[$i]['id'][$j] . '" data-toggle="tab">Info</a></li>
						<li><a href="#messages_' . $post_ids[$i]['id'][$j] . '" data-toggle="tab">Follow-ups</a></li>
						<li><a href="#settings_' . $post_ids[$i]['id'][$j] . '" data-toggle="tab">Status</a></li>
						<li style="display:none"><a href="add_user.php?enq_id=' . $post_ids[$i]['id'][$j] . '" >Add</a></li>
						<li>
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#delete_enq_' . $post_ids[$i]['id'][$j] . '" id="delete_enq__but' . $post_ids[$i]['id'][$j] . '" style="display: none;"></button>
						<div class="modal fade" id="delete_enq_' . $post_ids[$i]['id'][$j] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_' . $post_ids[$i]['id'][$j] . '" aria-hidden="true" style="display: none;">
						<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel_' . $post_ids[$i]['id'][$j] . '"><i class="fa fa-bell fa-fw fa-x2"></i> Alert</h4>
						</div>
						<div class="modal-body" id="delete_enq' . $post_ids[$i]['id'][$j] . '">
						<strong> Do you really want to delete the enquiry</strong>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal" id="trigger_del_' . $post_ids[$i]['id'][$j] . '" name=".modal-backdrop">Yes</button>
						<button type="button" class="btn btn-success" data-dismiss="modal" >No</button>
						</div>
						</div>
						</div>
						</div>
						<a href="javascript:void(0);" onClick="javascript:$(\'#delete_enq__but' . $post_ids[$i]['id'][$j] . '\').trigger(\'click\');">Delete</a>
						</li>
						</ul>
						<div class="tab-content">
						<div class="tab-pane fade in active" id="home_' . $post_ids[$i]['id'][$j] . '">
						<h4>Basic</h4>
						<p>
						<dl  class="dl-horizontal">
						<dt>Visitor Name :</dt>
						<dd>' . $post_ids[$i]['cust_name'][$j] . '</dd>
						<dt>Visitor Mobile :</dt>
						<dd>' . $post_ids[$i]['cust_no'][$j] . '</dd>
						<dt>Visitor Email :</dt>
						<dd>' . $post_ids[$i]['cust_email'][$j] . '</dd>
						<dt>Interested In :</dt>
						<dd>' . $post_ids[$i]['interested_in'][$j] . '</dd>
						</dl>
						</p>
						</div>
						<div class="tab-pane fade" id="profile_' . $post_ids[$i]['id'][$j] . '">
						<h4>Info</h4>
						<p>
						<dl  class="dl-horizontal">
						<dt>Medium Of Ads :</dt>
						<dd>' . $post_ids[$i]['ads_type'][$j] . '</dd>
						<dt>Referred By :</dt>
						<dd>' . $post_ids[$i]['referred_by'][$j] . '</dd>
						<dt>Handled By :</dt>
						<dd>' . $post_ids[$i]['handled_by'][$j] . '</dd>
						<dt>Joining Probability :</dt>
						<dd>' . $post_ids[$i]['jop'][$j] . '</dd>
						</dl>
						</p>
						</div>
						<div class="tab-pane fade" id="messages_' . $post_ids[$i]['id'][$j] . '">
						<p>';
						$script .= '$("#trigger_del_'.$post_ids[$i]['id'][$j].'").on("click",function(){
													$($(this).attr("name")).remove();
													var del = {
														id : '.$post_ids[$i]['id'][$j].',
														index : '.$i.',
														delenq : "#enquiry_'.$post_ids[$i]['id'][$j].'",
														numenq : "#num_enq_'.$i.'",
														enqrow : "enq_row_'.$post_ids[$i]['id'][$j].'"
													}
													window.setTimeout(function () {
														var obj = new controlEnquiryListAll();
														obj.delete_enqiry(del);
													}, 200);
							});
						';
						$follow_ups = sizeof($post_ids[$i]['followup_date'][$j]);
						$textarea = '';
						$options = '';
						for ($k = 0; $k < $follow_ups; $k++) {
							$options .= '<option value="#textarea_' . $post_ids[$i]['followup_id'][$j][$k] . '">Follow-up on : ' . date("j-M-Y", strtotime($post_ids[$i]['followup_date'][$j][$k])) . '</option>';
							$textarea .= '<div class="col-lg-12 textarea-col" style="display:none;" id="textarea_' . $post_ids[$i]['followup_id'][$j][$k] . '">
							<h4><span id="followup_date_' . $post_ids[$i]['followup_id'][$j][$k] . '" style="display:none;"><img class="img-circle" src="' . URL . ASSET_IMG . 'spinner_grey_120.gif" border="0" width="30" height="30" /></span>Follow-up on : ' . date("j-M-Y", strtotime($post_ids[$i]['followup_date'][$j][$k])) . '</h4>
							<textarea rows="4" cols="100" class="form-control" id="comments_' . $post_ids[$i]['followup_id'][$j][$k] . '">';
							if (!empty($post_ids[$i]['comments'][$j][$k]))
                            $textarea .= $post_ids[$i]['comments'][$j][$k];
							$textarea .= '</textarea><hr /><button href="javascript:void(0);" id="follow_up_' . $post_ids[$i]['followup_id'][$j][$k] . '" class="btn btn-lg btn-success btn-block"><i class="fa fa-upload fa-fw"></i> Update</button>
							<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_follow_up_stat_' . $post_ids[$i]['followup_id'][$j][$k] . '" id="myModal_button_follow_up_stat_' . $post_ids[$i]['followup_id'][$j][$k] . '" style="display: none;"></button>
							<div class="modal fade" id="myModal_follow_up_stat_' . $post_ids[$i]['followup_id'][$j][$k] . '" tabindex="-1" role="dialog" aria-labelledby="myModalFollowUp_' . $post_ids[$i]['followup_id'][$j][$k] . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
							<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title" id="myModalFollowUp_' . $post_ids[$i]['followup_id'][$j][$k] . '"><i class="fa fa-bell fa-fw fa-x2"></i> Alert</h4>
							</div>
							<div class="modal-body" id="modal_body_follow_up_stat_' . $post_ids[$i]['followup_id'][$j][$k] . '"></div>
							<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
							</div>
							</div>
							</div>
							</div>
							</div>';
							$script .='$("#follow_up_' . $post_ids[$i]['followup_id'][$j][$k] . '").on("click",function(){
							console.log();
							var followstatus = {
							id		:"' . $post_ids[$i]['followup_id'][$j][$k] . '",
							cmt		:"#comments_' . $post_ids[$i]['followup_id'][$j][$k] . '",
							bfollow 	:"#modal_body_follow_up_stat_' . $post_ids[$i]['followup_id'][$j][$k] . '",
							btn		:"#myModal_button_follow_up_stat_' . $post_ids[$i]['followup_id'][$j][$k] . '",
							dt		:"#followup_date_' . $post_ids[$i]['followup_id'][$j][$k] . '"
							}
							window.setTimeout(function(){
							var obj = new controlEnquiryListAll();
							obj.update_follow_up(followstatus);
							},200);
							});';
						}
						$htm .= '<div class="row">
						<div class="col-lg-12">
						<h4>Follow-ups</h4>
						<select class="form-control" id="follow_update_' . $post_ids[$i]['id'][$j] . '">
						<option value="NULL" selected="selected">Select Follow-up Date</option>
						' . $options . '
						</select>
						</div>
						<div class="col-lg-12">&nbsp;</div>
						' . $textarea . '
						</div>
						</p>
						</div>
						<div class="tab-pane fade" id="settings_' . $post_ids[$i]['id'][$j] . '">
						<h4><span id="final_loader_' . $post_ids[$i]['id'][$j] . '" style="display:none;"><img class="img-circle" src="' . URL . ASSET_IMG . 'spinner_grey_120.gif" border="0" width="30" height="30" /></span>Final Status :</h4>
						<p>
						<form role="form" id="final_stat_' . $post_ids[$i]['id'][$j] . '">
						<fieldset>
						<div class="form-group">
						<textarea rows="4" cols="100" class="form-control" id="final_status_' . $post_ids[$i]['id'][$j] . '" >' . $post_ids[$i]['final_status'][$j] . '</textarea>
						<a href="javascript:void(0);" id="stat_but_' . $post_ids[$i]['id'][$j] . '" class="btn btn-lg btn-success btn-block"><i class="fa fa-upload fa-fw"></i> Update</a>
						</div>
						</fieldset>
						</form>
						</p>
						</div>
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_final_stat_' . $post_ids[$i]['id'][$j] . '" id="myModal_button_final_stat_' . $post_ids[$i]['id'][$j] . '" style="display: none;"></button>
						<div class="modal fade" id="myModal_final_stat_' . $post_ids[$i]['id'][$j] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
						<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-bell fa-fw fa-x2"></i> Alert</h4>
						</div>
						<div class="modal-body" id="modal_body_final_stat_' . $post_ids[$i]['id'][$j] . '"></div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div></li>';
						$script .='$("#follow_update_' . $post_ids[$i]['id'][$j] . '").on("change",function(){
						$(".textarea-col").each(function(){
						$(this).hide();
						});
						$($(this).val()).show();
						});
						/*
						$("#scroll_to_' . $i . '").on("click",function(){
						window.setTimeout(function(){
						var scr_top = $("#enquiry_' . $post_ids[$i]['id'][$j] . '").offset().top - Number(50);
						$("html, body").animate({scrollTop: scr_top}, "slow");
						},800);
						});
						*/
						$("#stat_but_' . $post_ids[$i]['id'][$j] . '").on("click",function(){
						var status = {
						id	: "' . $post_ids[$i]['id'][$j] . '",
						cmt	: "#final_status_' . $post_ids[$i]['id'][$j] . '",
						body	: "#modal_body_final_stat_' . $post_ids[$i]['id'][$j] . '",
						sbtn	: "#myModal_button_final_stat_' . $post_ids[$i]['id'][$j] . '",
						floader	: "#final_loader_' . $post_ids[$i]['id'][$j] . '"
						}
						var obj = new controlEnquiryListAll();
						obj.update_final_status(status);
						});';
					}
					$htm .= '</ul></div></div>';
				}
				$htm .= '</div></div></div>';
			}
			else {
				$htm .= '<div class="row"><div class="col-lg-12"><strong class="text-danger">There are no enquires available !!!!</strong></div></div>';
			}
			$htm = str_replace($this->order, $this->replace, $htm);
			$listenquiry = array(
				"htm" => $htm. '<script language="javascript" type="text/javascript">' . $script . '</script>'
			);
			echo json_encode($listenquiry);
		}
		public function fetchKnowAboutUS() {
			$moptype = NULL;
			$jsonmoptype = NULL;
			$num = 0;
			$query = 'SELECT `id`, `ads_type` AS vtype FROM `medium_ads` WHERE `status` = 4;';
			$res = executeQuery($query);
			if (mysql_num_rows($res) > 0) {
				while ($row = mysql_fetch_assoc($res)) {
					$moptype[] = $row;
				}
			}
			if (is_array($moptype))
            $num = sizeof($moptype);
			if ($num) {
				for ($i = 0; $i < $num; $i++) {
					$jsonmoptype[] = array(
                    "html" => '<option  value="' . $moptype[$i]["id"] . '" >' . $moptype[$i]["vtype"] . '</option>',
                    "moptype" => $moptype[$i]["vtype"],
                    "id" => $moptype[$i]["id"]
					);
				}
			}
			return $jsonmoptype;
		}
		public function fetchInterestedIn() {
			$moptype = NULL;
			$jsonmoptype = NULL;
			$num = 0;
			$query = 'SELECT `id`, `name` AS vtype FROM `facility` WHERE `status` = (SELECT `id` FROM `status` WHERE `statu_name`="Show") ;';
			$res = executeQuery($query);
			if (mysql_num_rows($res) > 0) {
				while ($row = mysql_fetch_assoc($res)) {
					$moptype[] = $row;
				}
			}
			if (is_array($moptype))
            $num = sizeof($moptype);
			if ($num) {
				for ($i = 0; $i < $num; $i++) {
					$jsonmoptype[] = array(
                    "html" => $moptype[$i]["vtype"],
                    "name" => $moptype[$i]["vtype"],
                    "id" => $moptype[$i]["id"]
					);
				}
			}
			return $jsonmoptype;
		}
		public function autoCompleteEnq() {
			$query = 'SELECT
			tr.`id` AS pk,
			tr.`user_name` AS name,
			tr.`email` AS email,
			tr.`cell_number` AS cell,
			CASE WHEN tr.`photo_id` IS NULL
			THEN \'' . TRAIN_ANON_IMAGE . '\'
			ELSE CONCAT(\'' . URL . ASSET_DIR . '\',ph2.`ver3`)
			END AS photo
			FROM `employee` AS tr
			LEFT JOIN `photo` AS ph2 ON tr.`photo_id` = ph2.`id`
			WHERE tr.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Joined" AND `status` = 1)
			UNION
			SELECT
			ur.`id` AS pk,
			ur.`name` AS name,
			ur.`email` AS email,
			ur.`cell_number` AS cell,
			CASE WHEN ur.`photo_id` IS NULL
			THEN \'' . USER_ANON_IMAGE . '\'
			ELSE CONCAT(\'' . URL . ASSET_DIR . '\',ph3.`ver3`)
			END AS photo
			FROM `customer` AS ur
			LEFT JOIN `photo` AS ph3 ON ur.`photo_id` = ph3.`id`
			WHERE ur.`status` != (SELECT `id` FROM `status` WHERE `statu_name` = "Left" AND `status` = 1) AND ur.`status` !=(SELECT `id` FROM `status` WHERE `statu_name` = "Delete" AND `status` = 1)
			;';
			$res = executeQuery($query);
			if (mysql_num_rows($res) > 0) {
				$i = 0;
				while ($row = mysql_fetch_assoc($res)) {
					$name[$i]["label"] = $row["name"] . "-" . $row["email"] . "-" . $row["cell"];
					$name[$i]["value"] = $i;
					$name[$i]["icon"] = $row["photo"];
					$name[$i]["id"] = $row["pk"];
					$i++;
				}
				} else {
				$name = '';
			}
			$query = 'SELECT
			tr.`id` AS pk,
			tr.`user_name` AS name,
			tr.`email` AS email,
			tr.`cell_number` AS cell,
			CASE WHEN tr.`photo_id` IS NULL
			THEN \'' . TRAIN_ANON_IMAGE . '\'
			ELSE CONCAT(\'' . URL . ASSET_DIR . '\',ph2.`ver3`)
			END AS photo
			FROM `employee` AS tr
			LEFT JOIN `photo` AS ph2 ON tr.`photo_id` = ph2.`id`
			WHERE tr.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Joined" AND `status` = 1)
			;';
			$res = executeQuery($query);
			if (mysql_num_rows($res) > 0) {
				$i = 0;
				while ($row = mysql_fetch_assoc($res)) {
					$emp[$i]["label"] = $row["name"] . "-" . $row["email"] . "-" . $row["cell"];
					$emp[$i]["value"] = $i;
					$emp[$i]["icon"] = $row["photo"];
					$emp[$i]["id"] = $row["pk"];
					$i++;
				}
			} else
            $emp = '';
			$clients = array(
            "listofPeoples" => $name,
            "listofEmp" => $emp,
			);
			return $clients;
		}
		public function addEnquiry() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$query = "INSERT INTO `enquiry` (`id`,
			`customer_name`,
			`cell_number`,
			`email_id`,
			`handled_by`,
			`referred_by`,
			`jop`,
			`ft_goal`,
			`comments`,
			`date`,
			`status`)VALUES(
			NULL,
			'" . mysql_real_escape_string($this->parameters["vname"]) . "',
			'" . mysql_real_escape_string($this->parameters["cellnum"]) . "',
			'" . mysql_real_escape_string($this->parameters["email"]) . "',
			'" . mysql_real_escape_string($this->parameters["handelpk"]) . "',
			'" . mysql_real_escape_string($this->parameters["referpk"]) . "',
			'" . mysql_real_escape_string($this->parameters["jop"]) . "',
			'" . mysql_real_escape_string($this->parameters["ft_goal"]) . "',
			'" . mysql_real_escape_string($this->parameters["comments"]) . "',
			NOW(),
			14);";
			$res1 = executeQuery($query);
			$enq_id = mysql_result(executeQuery("SELECT LAST_INSERT_ID();"), 0);
			$query = "INSERT INTO `enquiry_followups` (`id`,`enq_id`,`followup_date`,`comments`,`status`)VALUES
			(NULL,'" . $enq_id . "','" . mysql_real_escape_string($this->parameters["f1"]) . "',NULL,24),
			(NULL,'" . $enq_id . "','" . mysql_real_escape_string($this->parameters["f2"]) . "',NULL,24),
			(NULL,'" . $enq_id . "','" . mysql_real_escape_string($this->parameters["f3"]) . "',NULL,24);";
			$res2 = executeQuery($query);
			$query = "INSERT INTO `enquiry_on` (`id`,`enq_id`,`facility_id`)VALUES";
			for ($i = 0; $i < sizeof($this->parameters["enquiry_on"]);) {
				if ($this->parameters["enquiry_on"][$i]) {
					if ($i == sizeof($this->parameters["enquiry_on"]) - 1)
                    $query .= "(NULL,'" . $enq_id . "','" . mysql_real_escape_string($this->parameters["enquiry_on"][$i]) . "');";
					else
                    $query .= "(NULL,'" . $enq_id . "','" . mysql_real_escape_string($this->parameters["enquiry_on"][$i]) . "'),";
					$i++;
				}
			}
			$res3 = executeQuery($query);
			$query = "INSERT INTO `enquiry_reach` (`id`,`enq_id`,`medium_ads_id`)VALUES
			(NULL,'" . $enq_id . "','" . mysql_real_escape_string($this->parameters["med_ad"]) . "');";
			$res4 = executeQuery($query);
			if ($res1 && $res2 && $res3 && $res4) {
				$flag = true;
				executeQuery("COMMIT");
				} else {
				executeQuery("ROLLBACK");
			}
			return $flag;
		}
		public function deleteEnquiry() {
			$flag = false;
			$del = getStatusId("delete");
			$query = "UPDATE `enquiry` SET `status` = '" . $del . "' WHERE `id` = '" . mysql_real_escape_string($this->parameters["id"]) . "'";
			$res = executeQuery($query);
			if ($res) {
				$flag = 'success';
			}
			return $flag;
		}
		public function updateFollowUp() {
			$flag = false;
			$read = getStatusId("read");
			$query = "UPDATE `enquiry_followups` SET `comments` = '" . mysql_real_escape_string($this->parameters["cmt"]) . "',`status` = '" . mysql_real_escape_string($read) . "' WHERE `id` = '" . mysql_real_escape_string($this->parameters["id"]) . "'";
			$res = executeQuery($query);
			if ($res) {
				$flag = true;
			}
			return $flag;
		}
		public function UpdateFinalStatus() {
			$query = "UPDATE `enquiry` SET `comments` = '" . mysql_real_escape_string($this->parameters["cmt"]) . "' WHERE `id` = '" . mysql_real_escape_string($this->parameters["id"]) . "'";
			$res = executeQuery($query);
			if ($res) {
				echo '1';
				} else {
				echo '0';
			}
		}
		public function LoadSearchHTML($parameters) {
			$searchJson = array(
            "menuDiv" => '',
            "htmlDiv" => ''
			);
			$offeroptions = array(
            "offer_name_html" => '',
            "offer_duration_html" => '',
            "offer_fct_type_html" => '',
            "offer_min_mem_html" => ''
			);
			$packageoptions = array(
            "pack_type_html" => '',
            "pack_sessions_html" => ''
			);
			$menuDiv = '';
			$htmlDiv = '';
			/* Offer */
			$query1 = 'SELECT
			(SELECT GROUP_CONCAT(DISTINCT(`name`),\'☻☻☻\') FROM `offers` ORDER BY `name` ASC) AS  `offer_name`,
			(SELECT GROUP_CONCAT(DISTINCT(`duration_id`),\'☻☻☻\') FROM `offers` ORDER BY `duration_id` ASC) AS `offer_duration`,
			(SELECT GROUP_CONCAT(DISTINCT(`facility_id`),\'☻☻☻\') FROM `offers` ORDER BY `facility_id` ASC) AS `offer_fct_type`,
			(SELECT GROUP_CONCAT(DISTINCT(`min_members`),\'☻☻☻\') FROM `offers` ORDER BY `min_members` ASC) AS `offer_min_mem`';
			/* Packages */
			$query2 = 'SELECT
			(SELECT GROUP_CONCAT(DISTINCT(`package_type_id`),\'☻☻☻\') FROM `packages` ORDER BY `package_type_id` ASC) AS  `pack_type`,
			(SELECT GROUP_CONCAT(DISTINCT(`number_of_sessions`),\'☻☻☻\') FROM `packages` ORDER BY `number_of_sessions` ASC) AS `pack_sessions`';
			$res1 = executeQuery($query1);
			if (mysql_num_rows($res1)) {
				$row = mysql_fetch_assoc($res1);
				$offeroptions["offer_name"] = explode("☻☻☻", $row['offer_name']);
				$offeroptions["offer_duration"] = explode("☻☻☻", $row['offer_duration']);
				$offeroptions["offer_fct_type"] = explode("☻☻☻", $row['offer_fct_type']);
				$offeroptions["offer_min_mem"] = explode("☻☻☻", $row['offer_min_mem']);
			}
			$res2 = executeQuery($query2);
			if (mysql_num_rows($res2)) {
				$row = mysql_fetch_assoc($res2);
				$packageoptions["pack_type"] = explode("☻☻☻", $row['pack_type']);
				$packageoptions["pack_sessions"] = explode("☻☻☻", $row['pack_sessions']);
			}
			if ($parameters["Enquiry"]) {
				$menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">Enquiry</a></li>';
				$htmlDiv .= '<div id="Enquiry_ser" class="row ser_crit text-primary">
				<div class="col-lg-12"><strong>Enquiry</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<input type="text" class="form-control" id="cust_email" placeholder="Visitor Email"/>
				</div>
				<div class="col-md-3">
				<input type="text" class="form-control" id="cust_name" placeholder="Visitor Name"/>
				</div>
				<div class="col-md-3">
				<input type="text" class="form-control" id="cust_no" placeholder="Visitor cell" />
				</div>
				</div>
				<div class="col-lg-12">&nbsp;</div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<input type="text" class="form-control" id="follow_up" placeholder="Follow-up date" readonly="readonly"/>
				</div>
				<div class="col-md-3">
				<input type="text" class="form-control" id="enq_day" placeholder="Enquiry date" readonly="readonly"/>
				</div>
				<div class="col-xs-2">
				<button id="Enquiry_ser_but" class="btn btn-primary" type="button"">
				<i class="fa fa-search"></i>
				</button>
				</div>
				</div>
				</div>';
			}
			if ($parameters["Group"]) {
				$menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">Group</a></li>';
				$htmlDiv .= '<div id="Group_ser" class="row ser_crit text-primary">
				<div class="col-lg-12"><strong>Group</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Group Name" id="group_name"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Owner" id="owner"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Minimum members" id="min_mem"/>
				</div>
				<div class="col-xs-2">
				<button class="btn btn-primary" type="button" id="Group_ser_but">
				<i class="fa fa-search"></i>
				</button>
				</div>
				</div>
				</div>';
			}
			if ($parameters["Personal"]) {
				$menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">Personal</a></li>';
				$htmlDiv .= '<div id="Personal_ser" class="row ser_crit text-primary">
				<div class="col-lg-12"><strong>Personal</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Name" id="user_name"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Mobile" id="user_mobile"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Email" id="user_email"/>
				</div>
				<div class="col-xs-2">
				<button class="btn btn-primary" type="button" id="Personal_ser_but">
				<i class="fa fa-search"></i>
				</button>
				</div>
				</div>
				</div>';
			}
			if ($parameters["Offer"]) {
				returnOfferOptions($offeroptions);
				$menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">Offer</a></li>';
				$htmlDiv .= '<div id="Offer_ser" class="row ser_crit text-primary">
				<div class="col-lg-12"><strong>Offer</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<select id="offer_opt" class="form-control">
				' . $offeroptions["offer_name_html"] . '
				</select>
				</div>
				<div class="col-md-3">
				<select id="fct_opt" class="form-control">
				' . $offeroptions["offer_fct_type_html"] . '
				</select>
				</div>
				<div class="col-md-3">
				<select id="offer_dur" class="form-control">
				' . $offeroptions["offer_duration_html"] . '
				</select>
				</div>
				<div class="col-md-3">
				<select id="offer_min_mem" class="form-control">
				' . $offeroptions["offer_min_mem_html"] . '
				</select>
				</div>
				<div class="col-xs-2">
				<button class="btn btn-primary" type="button" id="Offer_ser_but">
				<i class="fa fa-search"></i>
				</button>
				</div>
				</div>
				</div>';
			}
			if ($parameters["Package"]) {
				returnPackageOptions($packageoptions);
				$menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">Package</a></li>';
				$htmlDiv .= '<div id="Package_ser" class="row ser_crit">
				<div class="col-lg-12"><strong>Package</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<select id="pack_opt" class="form-control">
				' . $packageoptions["pack_type_html"] . '
				</select>
				</div>
				<div class="col-md-3">
				<select id="pack_ses_opt" class="form-control">
				' . $packageoptions["pack_sessions_html"] . '
				</select>
				</div>
				<div class="col-xs-2">
				<button class="btn btn-primary" type="button" id="package_ser_but">
				<i class="fa fa-search"></i>
				</button>
				</div>
				</div>
				</div>';
			}
			if ($parameters["Date"]) {
				$menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">Date</a></li>';
				$htmlDiv .= '<div id="Date_ser" class="row ser_crit">
				<div class="col-lg-12"><strong>Date</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Joining Date" id="jnd" readonly="readonly"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Expiry date"  id="exd" readonly="readonly"/>
				</div>
				<div class="col-xs-2">
				<button class="btn btn-primary" type="button" id="Date_ser_but">
				<i class="fa fa-search"></i>
				</button>
				</div>
				</div>
				</div>';
			}
			if ($parameters["All"]) {
				returnOfferOptions($offeroptions);
				returnPackageOptions($packageoptions);
				$menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">All</a></li>';
				$htmlDiv .= '<div id="All_ser" class="row ser_crit text-primary">
				<div class="row" id="Enquiry_ser_all">
				<div class="col-lg-12"><strong>Enquiry</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<input type="text" class="form-control" id="cust_email_all" placeholder="Visitor Email"/>
				</div>
				<div class="col-md-3">
				<input type="text" class="form-control" id="cust_name_all" placeholder="Visitor Name"/>
				</div>
				<div class="col-md-3">
				<input type="text" class="form-control" id="cust_no_all" placeholder="Visitor cell" />
				</div>
				</div>
				<div class="col-lg-12">&nbsp;</div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<input type="text" class="form-control" id="follow_up_all" placeholder="Follow-up date" readonly="readonly"/>
				</div>
				<div class="col-md-3">
				<input type="text" class="form-control" id="enq_day_all" placeholder="Enquiry date" readonly="readonly"/>
				</div>
				</div>
				</div>
				<div class="row" id="Group_ser_all">
				<div class="col-lg-12"><strong>Group</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Group Name" id="group_name_all"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Owner" id="owner_all"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Minimum members" id="min_mem_all"/>
				</div>
				</div>
				</div>
				<div class="row" id="Personal_ser_all">
				<div class="col-lg-12"><strong>Personal</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Name" id="user_name_all"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Mobile" id="user_mobile_all"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Email" id="user_email_all"/>
				</div>
				</div>
				</div>
				<div class="row" id="Offer_ser_all">
				<div class="col-lg-12"><strong>Offer</strong></div>
				<div class="col-lg-12">
				<div class="col-md-3">
				<select id="offer_opt_all" class="form-control">
				' . $offeroptions["offer_name_html"] . '
				</select>
				</div>
				<div class="col-md-3">
				<select id="fct_opt_all" class="form-control">
				' . $offeroptions["offer_fct_type_html"] . '
				</select>
				</div>
				<div class="col-md-3">
				<select id="offer_dur_all" class="form-control">
				' . $offeroptions["offer_duration_html"] . '
				</select>
				</div>
				<div class="col-md-3">
				<select id="offer_min_mem_all" class="form-control">
				' . $offeroptions["offer_min_mem_html"] . '
				</select>
				</div>
				</div>
				</div>
				<div class="row" id="Enquiry_ser_all">
				<div class="col-lg-12"><strong>Package</strong></div>
				<div class="col-lg-12" id="Package_ser_all">
				<div class="col-md-3">
				<select id="pack_opt_all" class="form-control">
				' . $packageoptions["pack_type_html"] . '
				</select>
				</div>
				<div class="col-md-3">
				<select id="pack_ses_opt_all" class="form-control">
				' . $packageoptions["pack_sessions_html"] . '
				</select>
				</div>
				</div>
				</div>
				<div class="row" id="Date_ser_all">
				<div class="col-lg-12"><strong>Date</strong></div>
				<div class="col-lg-12" >
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Joining Date" id="jnd_all" readonly="readonly"/>
				</div>
				<div class="col-md-3">
				<input class="form-control" type="text"  placeholder="Expiry date"  id="exd_all" readonly="readonly"/>
				</div>
				</div>
				</div>
				<div class="row">
				<div class="col-lg-12">&nbsp;</div>
				<div class="col-lg-12">
				<div class="col-xs-2">
				<button class="btn btn-primary" type="button" id="All_ser_but">
				<i class="fa fa-search"></i>
				</button>
				</div>
				</div>
				</div>
				</div>';
			}
			$searchJson["menuDiv"] = '<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			SEARCH <i class="fa fa-search"></i>&nbsp;<i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu" id="search_type">
			' . $menuDiv . '
			<li><a href="javascript:void(0);" class="srch_type">Hide</a></li>
			</ul>
			</li>
			</ul>';
			$searchJson["htmlDiv"] = $htmlDiv;
			echo json_encode($searchJson);
		}
		public function returnOfferOptions(& $offeroptions) {
			$i = sizeof($offeroptions["offer_name"]) - 1;
			$offeroptions["offer_name_html"] = '<option value="NULL" selected="selected">Select Offer</option>';
			if ($i) {
				$offer_name = $offeroptions["offer_name"];
				for ($i = 0; $i < sizeof($offer_name) && isset($offer_name[$i]) && $offer_name[$i] != ''; $i++) {
					$offer_name[$i] = trim($offer_name[$i], ",");
					$offeroptions["offer_name_html"] .= (string) '<option value="' . $offer_name[$i] . '">' . $offer_name[$i] . '</option>';
				}
			}
			$i = sizeof($offeroptions["offer_duration"]) - 1;
			$offeroptions["offer_duration_html"] = '<option value="NULL" selected="selected">Select duration</option>';
			if ($i) {
				$offer_duration = $offeroptions["offer_duration"];
				for ($i = 0; $i < sizeof($offer_duration) && isset($offer_duration[$i]) && $offer_duration[$i] != ''; $i++) {
					$offer_duration[$i] = trim($offer_duration[$i], ",");
					$offeroptions["offer_duration_html"] .= '<option value="' . $offer_duration[$i] . '">' . $offer_duration[$i] . '</option>';
				}
			}
			$i = sizeof($offeroptions["offer_fct_type"]) - 1;
			$offeroptions["offer_fct_type_html"] = '<option value="NULL" selected="selected">Select facility type</option>';
			if ($i) {
				$offer_fct_type = $offeroptions["offer_fct_type"];
				for ($i = 0; $i < sizeof($offer_fct_type) && isset($offer_fct_type[$i]) && $offer_fct_type[$i] != ''; $i++) {
					$offer_fct_type[$i] = trim($offer_fct_type[$i], ",");
					$offeroptions["offer_fct_type_html"] .= '<option value="' . $offer_fct_type[$i] . '">' . $offer_fct_type[$i] . '</option>';
				}
			}
			$i = sizeof($offeroptions["offer_min_mem"]) - 1;
			$offeroptions["offer_min_mem_html"] = '<option value="NULL" selected="selected">Select minimum members</option>';
			if ($i) {
				$offer_min_mem = $offeroptions["offer_min_mem"];
				for ($i = 0; $i < sizeof($offer_min_mem) && isset($offer_min_mem[$i]) && $offer_min_mem[$i] != ''; $i++) {
					$offer_min_mem[$i] = trim($offer_min_mem[$i], ",");
					$offeroptions["offer_min_mem_html"] .= '<option value="' . $offer_min_mem[$i] . '">' . $offer_min_mem[$i] . '</option>';
				}
			}
		}
		public function returnPackageOptions(& $packageoptions) {
			$i = sizeof($packageoptions["pack_type"]) - 1;
			$packageoptions["pack_type_html"] = '<option value="NULL" selected="selected">Select Package</option>';
			if ($i) {
				$pack_type = $packageoptions["pack_type"];
				for ($i = 0; $i < sizeof($pack_type) && isset($pack_type[$i]) && $pack_type[$i] != ''; $i++) {
					$pack_type[$i] = trim($pack_type[$i], ",");
					$packageoptions["pack_type_html"] .= '<option value="' . $pack_type[$i] . '">' . $pack_type[$i] . '</option>';
				}
			}
			$i = sizeof($packageoptions["pack_sessions"]) - 1;
			$packageoptions["pack_sessions_html"] = '<option value="NULL" selected="selected">Select Number of Sessions</option>';
			if ($i) {
				$pack_sessions = $packageoptions["pack_sessions"];
				for ($i = 0; $i < sizeof($pack_sessions) && isset($pack_sessions[$i]) && $pack_sessions[$i] != ''; $i++) {
					$pack_sessions[$i] = trim($pack_sessions[$i], ",");
					$packageoptions["pack_sessions_html"] .= '<option value="' . $pack_sessions[$i] . '">' . $pack_sessions[$i] . '</option>';
				}
			}
		}
		public static function returnSearchQuery(&$searchQuery, $para) {
			$parameters = array(
            "enquiry" => isset($para['enquiry']) ? $para['enquiry'] : false,
            "list_type" => isset($para['list_type']) ? $para['list_type'] : false,
            "id" => isset($para['id']) ? $para['id'] : false,
            "comment" => isset($para['comment']) ? $para['comment'] : false,
            "name" => isset($para["user_name"]) ? $para["user_name"] : false,
            "mobile" => isset($para["user_mobile"]) ? $para["user_mobile"] : false,
            "email" => isset($para["user_email"]) ? $para["user_email"] : false,
            "offer" => isset($para["offer_opt"]) ? $para["offer_opt"] : false,
            "fct_opt" => isset($para["fct_opt"]) ? $para["fct_opt"] : false,
            "duration" => isset($para["offer_dur"]) ? $para["offer_dur"] : false,
            "offer_min_mem" => isset($para["offer_min_mem"]) ? $para["offer_min_mem"] : false,
            "package" => isset($para["pack_opt"]) ? $para["pack_opt"] : false,
            "pack_ses_opt" => isset($para["pack_ses_opt"]) ? $para["pack_ses_opt"] : false,
            "jnd" => isset($para["jnd"]) ? $para["jnd"] : false,
            "exp_date" => isset($para["exd"]) ? $para["exd"] : false,
            "fct_type" => isset($para["fct_type"]) ? $para["fct_type"] : "?",
            "cust_email" => isset($para['cust_email']) ? $para['cust_email'] : false,
            "cust_name" => isset($para['cust_name']) ? $para['cust_name'] : false,
            "cust_no" => isset($para['cust_no']) ? $para['cust_no'] : false,
            "enq_day" => isset($para['enq_day']) ? $para['enq_day'] : false,
            "followup_date" => isset($para['follow_up']) ? $para['follow_up'] : false,
            "group" => isset($para['group']) ? $para['group'] : false,
            "handled_by" => false,
            "referred_by" => false,
            "ads_type" => false
			);
			// echo '<br />'.print_r($parameters);
			if ($parameters["name"] || $parameters["mobile"] || $parameters["email"]) {
				if ($parameters["name"])
                $searchQuery["searchQueryA"] .= ' AND u.`customer_name` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["name"]) . '%\') ';
				if ($parameters["mobile"])
                $searchQuery["searchQueryA"] .= ' AND  u.`cell_number` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["mobile"]) . '%\') ';
				if ($parameters["email"])
                $searchQuery["searchQueryA"] .= ' AND  u.`email_id` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["email"]) . '%\') ';
			}
			if ($parameters["offer"] || $parameters["fct_opt"] || $parameters["duration"] || $parameters["offer_min_mem"] || $parameters["fct_type"]) {
				if ($parameters["offer"])
                $searchQuery["searchQueryB"] .= ' AND b.`offer_name` LIKE CONCAT(\'%,' . mysql_real_escape_string($parameters["offer"]) . '%\') ';
				if ($parameters["duration"])
                $searchQuery["searchQueryB"] .= ' AND b.`duration_id` LIKE CONCAT(\'%,' . mysql_real_escape_string($parameters["duration"]) . '%\') ';
				if ($parameters["fct_opt"])
                $searchQuery["searchQueryB"] .= ' AND cf.`facility_id` LIKE CONCAT(\'%,' . mysql_real_escape_string($parameters["fct_opt"]) . '%\') ';
				if ($parameters["offer_min_mem"])
                $searchQuery["searchQueryB"] .= ' AND b.`min_members` LIKE CONCAT(\'%,' . mysql_real_escape_string($parameters["offer_min_mem"]) . '%\') ';
				if ($parameters["fct_type"])
                $searchQuery["searchQueryD"] = ' AND cf.`facility_id` = \'' . mysql_real_escape_string($parameters["fct_type"]) . '\'';
			}
			if ($parameters["package"] || $parameters["pack_ses_opt"]) {
				if ($parameters["package"])
                $searchQuery["searchQueryC"] .= ' AND c.`package_type_id` = CONCAT(\'%' . mysql_real_escape_string($parameters["package"]) . '%\') ';
				if ($parameters["pack_ses_opt"])
                $searchQuery["searchQueryC"] .= ' AND c.`number_of_sessions` = CONCAT(\'%' . mysql_real_escape_string($parameters["pack_ses_opt"]) . '%\') ';
			}
			if ($parameters["jnd"] || $parameters["exp_date"]) {
				if ($parameters["jnd"])
                $searchQuery["searchQueryA"] .= ' AND  u.`date_of_join` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["jnd"]) . '%\') ';
				if ($parameters["exp_date"]) {
					$searchQuery["searchQueryB"] .= ' AND  b.`valid_till` LIKE CONCAT(\'%,' . mysql_real_escape_string($parameters["exp_date"]) . '%\') ';
				}
			}
			if (isset($parameters["gname"]) && isset($parameters["owner"]) && isset($parameters["min_mem"])) {
				if ($parameters["gname"])
                $searchQuery["searchQueryE"] .= ' AND grp.`name` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["gname"]) . '%\') ';
				if ($parameters["owner"])
                $searchQuery["searchQueryE"] .= ' AND  grp.`owner` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["owner"]) . '%\') ';
				if ($parameters["min_mem"])
                $searchQuery["searchQueryE"] .= ' AND  grp.`no_of_members` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["min_mem"]) . '%\') ';
			}
			switch ($parameters["list_type"]) {
				case "offer":
                $obj = new account();
                $num = isset($parameters["group"]) && $parameters["group"] ? 2 : 1;
				$arrpara = array(
				"min_mem" => $num,
				"offer_id" => false,
				"fct_type" => $parameters["fct_type"]
				);
                $offers = $obj->getOffers($arrpara);
                if ($offers != NULL) {
                    $_SESSION['listofoffers'] = $offers;
					} else {
                    $_SESSION['listofoffers'] = NULL;
				}
                break;
				case "package":
                $obj = new account();
                $pacakages = $obj->getPackages();
                if ($pacakages != NULL) {
                    $_SESSION['pacakages'] = $pacakages;
					} else {
                    $_SESSION['pacakages'] = NULL;
				}
                break;
				case "due":
                $obj = new account();
                $searchQuery["ListQuery"] = ' AND a.`id` IN (SELECT `user_pk` FROM `money_trans_due` WHERE `status` = \'due\')';
                $num = ($parameters["group"]) ? 2 : 1;
				$arrpara = array(
				"min_mem" => $num,
				"offer_id" => false,
				"fct_type" => $parameters["fct_type"]
				);
                $offers = $obj->getOffers($arrpara);                
				if ($offers != NULL) {
                    $_SESSION['listofoffers'] = $offers;
					} else {
                    $_SESSION['listofoffers'] = NULL;
				}
                break;
			}
			if (isset($parameters["enquiry"])) {
				$searchQuery["searchQueryA"] = ' ';
				$searchQuery["searchQueryB"] = ' ';
				$searchQuery["searchQueryC"] = ' ';
				$searchQuery["ListQuery"] = '';
				if ($parameters["cust_name"] || $parameters["cust_no"] || $parameters["cust_email"] || $parameters["enq_day"] || $parameters["handled_by"] || $parameters["referred_by"]) {
					if ($parameters["cust_name"])
                    $searchQuery["searchQueryA"] .= 'AND a.`customer_name` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["cust_name"]) . '%\') ';
					if ($parameters["cust_no"])
                    $searchQuery["searchQueryA"] .= 'AND  a.`cell_number` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["cust_no"]) . '%\') ';
					if ($parameters["cust_email"])
                    $searchQuery["searchQueryA"] .= 'AND  a.`email_id` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["cust_email"]) . '%\') ';
					if ($parameters["enq_day"])
                    $searchQuery["searchQueryA"] .= 'AND  a.`date` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["enq_day"]) . '%\') ';
					if ($parameters["handled_by"])
                    $searchQuery["searchQueryA"] .= 'AND  a.`date` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["handled_by"]) . '%\') ';
					if ($parameters["referred_by"])
                    $searchQuery["searchQueryA"] .= 'AND  a.`date` LIKE CONCAT(\'%' . mysql_real_escape_string($parameters["referred_by"]) . '%\') ';
				}
				if ($parameters["followup_date"]) {
					$searchQuery["searchQueryB"] = ' AND b.`followup_date` = \'' . mysql_real_escape_string($parameters["followup_date"]) . '\'';
				}
				switch ($parameters["list_type"]) {
					case "today":
                    $searchQuery["ListQuery"] .= 'AND STR_TO_DATE(NOW(),\'%Y-%m-%d\') = STR_TO_DATE( b.`followup_date`,\'%Y-%m-%d\') ';
                    break;
					case "pending":
                    $searchQuery["ListQuery"] .= 'AND a.`id` IN (SELECT `enq_id` FROM `enquiry_followups` WHERE `enq_id` = a.`id` AND STR_TO_DATE(NOW(),\'%Y-%m-%d\') < STR_TO_DATE(`followup_date`,\'%Y-%m-%d\') GROUP BY (`enq_id`))';
                    break;
					case "expired":
                    $searchQuery["ListQuery"] .= 'AND a.`id` IN (SELECT `enq_id` FROM `enquiry_followups` WHERE `enq_id` = a.`id` AND STR_TO_DATE(NOW(),\'%Y-%m-%d\') > STR_TO_DATE(`followup_date`,\'%Y-%m-%d\') GROUP BY (`enq_id`) HAVING COUNT(`enq_id`) = 3) ';
                    break;
					case "all":
                    $searchQuery["ListQuery"] = ' ';
                    break;
				}
			}
		}
	}
?>