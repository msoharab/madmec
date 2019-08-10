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
            elseif(isset($_POST['action']) && $_POST['action'] == 'treatment'){
                Treatment($_POST['val']);
                unset($_POST);
                exit(0);
            }
            elseif(isset($_POST['action']) && $_POST['action'] == 'add_treatment'){
                Add_Treatment();
                unset($_POST);
                exit(0);
            }
            elseif(isset($_POST['action']) && $_POST['action'] == 'upload_image'){
                UploadImageDetails($_POST['val'],$_POST['tre_id']);
                unset($_POST);
                exit(0);
            }
            elseif(isset($_POST['action']) && $_POST['action'] == 'view_history'){
                $history = ViewHistory($_POST['id']);
                if(!empty($history)){
                    DisplayHistory($history);
                }
                else{
                    echo "<h3>No history to display</h3>";
                }
                unset($_POST);
                exit(0);
            }
            elseif(isset($_POST['action']) && $_POST['action'] == 'view_img'){
                ViewImg($_POST['id']);
                unset($_POST);
                exit(0);
            }
            elseif(isset($_POST['action']) && $_POST['action'] == 'view_treatment'){
                ViewTreatment($_POST['id'],$_POST['bal_amount']);
                unset($_POST);
                exit(0);
            }
            elseif(isset($_POST['action']) && $_POST['action'] == 'show_visit_form'){
                //ShowVisitForm($_POST['id']);
                Treatment($_POST['val'],$_POST['id'],$_POST['index'],$_POST['balance_rem']);
                unset($_POST);
                exit(0);
            }
            elseif(isset($_POST['action']) && $_POST['action'] == 'add_visit'){
                AddVisit($_POST['id']);
                unset($_POST);
                exit(0);
            }
            elseif(isset($_POST['action']) && $_POST['action'] == 'load_user_details'){
                LoadUserDetails();
                unset($_POST);
                exit(0);
            }

    }
    function LoadUserDetails(){
        $user_details = $_SESSION['user_details'];

        echo '<div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <tr>
                        <td width="200">
                            <img src="'.$user_details['thumb_url'].'" alt="'.$user_details['thumb_url'].'" height="150">
                        </td>
                        <td>
                            Name: <strong style="color:#D9534F;">'.$user_details['pre_name'].$user_details['tar_name'].'</strong><br />
                            Mobile: <strong style="color:#D9534F;">'.$user_details['phone'].'</strong><br />
                            Email: <strong style="color:#D9534F;">'.$user_details['email'].'</strong><br />
                            <strong style="color:#D9534F;">Balance Amount : '.$user_details['balance_amount'].'</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
            ';
    }
    function AddVisit($id){
        $id= $_POST['id'];
        $tre_id = $_POST['tre_id'];
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $amount_paid = $_POST['amount_paid'];
        $comp = $_POST['comp'];
        $diag = $_POST['diag'];
        $cas = $_POST['cas'];
        $app_date = $_POST['app_date'];
        $app_time =$_POST['app_time'];
        $tre_name =  $_POST['tre_name'];
        $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
        if(get_resource_type($link) == 'mysql link'){
            if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
                executeQuery("SET AUTOCOMMIT=0;");
                executeQuery("START TRANSACTION;");
                    $query1 = "INSERT INTO `treatment_visits`
                    (`treatment_id`, `date`, `complian`, `diagnostics`, `case`, `status_id`)
                    VALUES
                    (
                        '".mysql_real_escape_string($tre_id)."',
                        NOW(),
                        '".mysql_real_escape_string($comp)."',
                        '".mysql_real_escape_string($diag)."',
                        '".mysql_real_escape_string($cas)."',
                        '".mysql_real_escape_string('4')."'
                    );";
                     $res1 = executeQuery($query1);
                     $visit_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
                     if($app_date != 0 || $app_time != 0){
                        $query2 = "INSERT INTO `appointment`
                        (`patientid`, `date`, `from`, `des`, `status_id`)
                        VALUES
                        ('".mysql_real_escape_string($id)."',
                        '".mysql_real_escape_string($app_date)."',
                        '".mysql_real_escape_string($app_time)."',
                        '".mysql_real_escape_string($tre_name.'(Next Treatment Appointment)')."',
                        '".mysql_real_escape_string('4')."'
                         ); ";
                        $res2 = executeQuery($query2);
                        $query3=" SELECT settings.sms_status, status.statu_name FROM settings LEFT JOIN status ON settings.sms_status=status.id ;";
							$res3=executeQuery($query3);
							while($row=mysql_fetch_object($res3))
								$sms_status = $row->statu_name;
								        if($sms_status == 'on' ){
                            $msg = 'Hi '.$name.', your appointment is succesfully scheduled on '.date('d-m-Y',strtotime($app_date)).'('.ORGNAME.')';

                            $sms_para = array(
                                                    "tar_id"    => $id,
                                                    "msg"       => $msg,
                                                    "number"	=> $mobile
                                            );
                            SendSms($sms_para);
                        }

                    }
                                if($res1){
                                    MakeReceipt($visit_id);

                                    echo '
										   <div class="row" align="center">
											<h1 align="center"> Succesfully Added Treatment Visit</h1>
											</div>';


				}

				else{
					echo 0;
					executeQuery("ROLLBACK");
				}

                            executeQuery("COMMIT");


            }
        }
        if(get_resource_type($link) == 'mysql link')
        mysql_close($link);

    }
    function ShowVisitForm($tre_id){
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
                           Add Treatment
                        </div>
                        <div class="panel-body">
							<form role="form">
								<div id="first_visit">
                                                                    <div class="form-group">
                                                                        <h3>First Visit</h3>
                                                                        <hr />
                                                                        <div class="row">
                                                                            <div class="col-lg-4">
                                                                                <input type="hidden" value="'.$_GET['id'].'" id="tar_id">
                                                                                <input type="hidden" value="'.$tre_id.'" id="tre_id">
                                                                                <label>Amount Paid: </label>
                                                                                <input type="text" id="amount_paid" name="amount_paid" placeholder="999.99" class="form-control" onkeyup="javascript:cal_balance();" >
                                                                            </div><!--col-lg-4 -->
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-4">
                                                                                <label>Complain: </label>
                                                                                <textarea id="comp" class="form-control"></textarea>
                                                                            </div><!--col-lg-4 -->
                                                                            <div class="col-lg-4">
                                                                                <label>Diagnostics: </label>
                                                                                <textarea id="diag" class="form-control"></textarea>
                                                                            </div><!--col-lg-4 -->
                                                                            <div class="col-lg-4">
                                                                                <label>Case: </label>
                                                                                <textarea id="case" class="form-control"></textarea>
                                                                            </div><!--col-lg-4 -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="gap">&nbsp;</div>
                                                            <div id="next_appointment">
                                                               <h3> Next Appointment  <input type="checkbox" id="next_app_check" onchange="toggle_app_form();"></h3>
                                                                <hr />
                                                                <div class="form-group">
                                                                    <div class="row" id="next_app_form" style="display:none">
                                                                        <div class="col-lg-6">
                                                                            <label>Date of appointment: </label><br/>
                                                                            <i class="fa fa-calendar fa-2x"></i>
                                                                            <input type="hidden" id="app_con" value="0" readonly>
                                                                            <input type="text" id="app_date" value="'.date("d-m-Y").'" readonly>
                                                                            <input  type="hidden" id="alt_app_date" value="'.date("Y-m-d").'"  readonly>
                                                                            <script type="text/javascript">
                                                                                   $("#app_date").datepicker({
                                                                                       dateFormat: "dd-mm-yy",
                                                                                       altField: "#alt_app_date",
                                                                                       altFormat: "yy-mm-dd",
                                                                                       changeMonth : true,
                                                                                       changeYear : true,
                                                                                   });
                                                                            </script>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <label>Select Time: </label><br/>
                                                                             <i class="fa fa-clock-o fa-2x"></i>
                                                                              '.$timing.'
                                                                              <input type="hidden" id="from" class="form-control" readonly>
                                                                              <span class="text-danger" id="err_from">Invalid</span>
                                                                       </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="class">&nbsp;</div>
                                                            <div class="form-group">
                                                                <button id="make_receipt_btn" onclick="javasript:add_visit();" type="button" class="btn btn-danger form-control">Save Changes</button>
                                                            </div>
							</form>
                        </div>
                    </div>
                </div>';
    }
    function ViewTreatment($id,$bal_amount){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
        if(get_resource_type($link) == 'mysql link'){
            if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
                $query = "SELECT tar.`name` AS tre_name,tar.`amount` AS tre_amount,
                    a.*,
                    b.amount,
                    c.`rec_no`, c.`rec_location`
                    FROM `treatment` AS tar
                    LEFT JOIN `treatment_visits` AS a ON a.`treatment_id` = tar.`id`
                    LEFT JOIN `income` AS b ON a.`id` = b.`visit_id`
                    LEFT JOIN `receipt` AS c on c.`income_id` = b.`id`
                    WHERE a.`treatment_id` = '".mysql_real_escape_string($id)."'
                    ORDER BY `id` ASC
                    ";
                $res = executeQuery($query);
                if(mysql_num_rows($res) > 0){
                                $i = 0;
                                echo '<table class="table table-striped table-bordered table-hover ">
                                    <tr>

										<th>
											Visit
										</th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            complain
                                        </th>
                                        <th>
                                            Diagnostic
                                        </th>
                                        <th>
                                            Case
                                        </th>
                                        <th>
                                            Amount paid
                                        </th>
                                     </tr>';

                                while( $row = mysql_fetch_assoc($res)){
                                    $tre_name = $row['tre_name'];
                                    $tre_amount =  $row['tre_amount'];
                                    echo '<tr>

											<td> '.($i+1). ' </td>
                                            <td>'.date('d-m-Y', strtotime($row['date']) ).'</td>
                                            <td>'.$row['complian'].'</td>
                                            <td>'.$row['diagnostics'].'</td>
                                            <td>'.$row['case'].'</td>
                                            <td>'.$row['amount'].'</td>

                                        </tr>';

                                    $i++;
				}

                                echo '<tr>
                                            <td colspan="5" align="center">
                                                <button class="btn btn-danger" onclick="show_visit_form(\''.$id.'\',\''.$tre_name.'\',\''.$tre_amount.'\',\''.($i+1).'\',\''.$bal_amount.'\');">Add visit</button>
                                            </td>
                                        </tr></table>';
                }
                else{
                    echo "NO Records found";
                }
            }
        }
        if(get_resource_type($link) == 'mysql link')
        mysql_close($link);
    }
    function ViewHistory($id){
        $history = array();
        $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
        if(get_resource_type($link) == 'mysql link'){
            if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
                $query = "SELECT  a.*,SUM(c.`amount`) as amount_paid
                FROM `target` as tar
                LEFT JOIN `treatment` as a ON a.`patientid` = tar.`id`
                LEFT JOIN `treatment_visits` as b ON b.`treatment_id` = a.`id`
                LEFT JOIN `income` as c ON c.`visit_id` = b.`id`
                WHERE
                  a.`patientid` = '".mysql_real_escape_string($id)."'
                 GROUP BY a.`id`
                    ";
                $res = executeQuery($query);
                if(mysql_num_rows($res) > 0){

					$i = 0;
					while( $row = mysql_fetch_assoc($res)){
						$history[$i]['id'] = $row['id'];
						$history[$i]['date'] = $row['date'];
						$history[$i]['name'] = $row['name'];
						$history[$i]['amount'] = $row['amount'];
						$history[$i]['amount_paid'] = $row['amount_paid'];
						$history[$i]['balance'] = $history[$i]['amount'] - $history[$i]['amount_paid'];
						$i++;
					}
				}
				else{
					$history = NULL;
				}
            }
        }
        if(get_resource_type($link) == 'mysql link')
        mysql_close($link);
        return $history;
    }
    function DisplayHistory($history){
        $end = sizeof($history);
        echo '<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            List patient
                        </div>
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>
										Date
									</th>
									<th>
										Treatment Name
									</th>
									<th>
										Total Amount
									</th>
									<th>
										Amount paid
									</th>
									<th>
										<strong class="danger">Balance</strong>
									</th>
									<th>
										Action
									</th>
								</tr>
							</thead>
							<tbody>';
        for($i = 0;$i<$end;$i++){
            echo '<tr>
                <td><strong style="color:#D9534F;">'.date('d-m-Y',strtotime($history[$i]['date'])).'</td>
                <td>'.$history[$i]['name'].'</td>
                <td>'.$history[$i]['amount'].'</td>
                <td>'.$history[$i]['amount_paid'].'</td>
                <td>'.$history[$i]['balance'].'</td>
                <td>
                    <button onclick="javascript:view_img('.$history[$i]['id'].');">View Treatment Image</button>
                    <button onclick="javascript:view_treatment('.$history[$i]['id'].','.$history[$i]['balance'].');">View All Treatment</button>
                </td>
            </tr>';
        }
       echo '               </tbody>
                        </table>
                    </div>
                </div>
            </div>';
    }
    function ViewImg($id){
         $pre_imgs = '';
         $pre_img = array();
        $mid_img = array();
        $mid_imgs = '';
        $post_imgs = '';
        $post_img = array();
        $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
        if(get_resource_type($link) == 'mysql link'){
            if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
                $query = "SELECT * FROM `treatment_image`
                    WHERE `treatment_id` = '".mysql_real_escape_string($id)."'
                    AND `status_id` = '4'
                    ORDER BY `id` ASC
                    ";
                $res = executeQuery($query);
                if(mysql_num_rows($res) > 0){
                                $i = 0;
                                while( $row = mysql_fetch_assoc($res)){
                                    if($row['type'] == 'pre_img'){
                                        $pre_imgs .= '<img src="'.$row['img_url'].'" height= "150" />';
                                        $pre_img[] = $row['img_url'];
                                    }
                                    else if($row['type'] == 'mid_img'){
                                        $mid_imgs .= '<img src="'.$row['img_url'].'" height= "150" />';
                                        $mid_img[] = $row['img_url'];
                                    }
                                    else if($row['type'] == 'post_img'){
                                        $post_imgs .= '<img src="'.$row['img_url'].'" height= "150" />';
                                        $post_img[] = $row['img_url'];
                                    }
                                    $i++;
				}
                }
                else{
                        $pre_img = "<h4 style='color:#D9534F;'>No Treatment Image were uploaded</h4>";
                        $mid_img = "<h4 style='color:#D9534F;'>No Treatment Image were uploaded</h4>";
                        $post_img = "<h4 style='color:#D9534F;'>No Treatment Image were uploaded</h4>";
                }
            }
        }
        if(get_resource_type($link) == 'mysql link')
        mysql_close($link);
        $dataPrint = '<table class="table table-striped table-bordered table-hover">
				<tr>
                    <td align="center" valign="middle">
                        <h3>Pre Treatment</h3>
                    </td>
                    <td id="fix_img_pre">
                        '.$pre_imgs.'
                    </td>
                    <td id="plug-in-pre" style="display:none">
                         <div class="col-lg-6">
							<input type="file" id="ex3pre" name="ex1[]" multiple="multiple" />
						</div>
                    </td>
                    <td>
							<button type="button" class="btn btn-danger"  onClick="$(\'#fix_img_pre\').hide();$(\'#plug-in-pre\').show();$(this).hide();$(\'#upLoadPlugPre\').show();" id="editPlugPre">Edit</button>
						<div class="col-lg-6" id="pre_img">
							<button type="button" class="btn btn-danger"  style="display:none" onClick="upload(\'pre_img\',\''.$id.'\',\'ex1[]\');" id="upLoadPlugPre">Upload</button>
						</div>
					</td>
                </tr>

                <tr>
                    <td align="center" valign="middle">
                        <h3>Mid Treatment</h3>
                    </td>
                    <td id="fix_img">
                        '.$mid_imgs.'
                    </td>
                    <td id="plug-in" style="display:none">
                         <div class="col-lg-6">
							<input type="file" id="ex1mid" name="ex2[]" multiple="multiple" />
						</div>
                    </td>
                    <td>
							<button type="button" class="btn btn-danger"  onClick="$(\'#fix_img\').hide();$(\'#plug-in\').show();$(this).hide();$(\'#upLoadPlug\').show();" id="editPlug">Edit</button>
						<div class="col-lg-6" id="mid_img">
							<button type="button" class="btn btn-danger"  style="display:none" onClick="upload(\'mid_img\',\''.$id.'\',\'ex2[]\');" id="upLoadPlug">Upload</button>
						</div>
					</td>
                </tr>

                <tr>
                    <td align="center" valign="middle">
                        <h3>Post Treatment</h3>
                    </td>
                    <td id="fix_img_post">
                        '.$post_imgs.'
                    </td>
                    <td id="plug-in_post" style="display:none">
                         <div class="col-lg-6">
							<input type="file" id="ex2post" name="ex3[]" multiple="multiple" />
						</div>
                    </td>
                    <td>
							<button type="button" class="btn btn-danger"  onClick="$(\'#fix_img_post\').hide();$(\'#plug-in_post\').show();$(this).hide();$(\'#upLoadPlug_post\').show();" id="editPlug_post">Edit</button>
						<div class="col-lg-6" id="post_img">
							<button type="button" class="btn btn-danger"  style="display:none" onClick="$(this).hide();upload(\'post_img\',\''.$id.'\',\'ex3[]\');" id="upLoadPlug_post">Upload</button>
						</div>
					</td>
                </tr>
                 </table>
                <div class="row" align="center">
						<a href="javascript:void(0);" class="btn btn-success" onclick="view_history('.$_GET['id'].');">Skip image upload</a>
				</div>';
			$imgdata=array(
				"imgdata"	=>	$dataPrint,
				"pre_img"	=>	$pre_img,
				"mid_img"	=>	$mid_img,
				"post_img"	=>	$post_img,
         );
        print_r(json_encode($imgdata));
    }
    function UploadImageDetails($val,$tre_id){
       $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
        if(get_resource_type($link) == 'mysql link'){
            if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
                $query = "INSERT INTO `treatment_image`
                    (`treatment_id`, `img_url`, `thumb_url`, `type`, `status_id`)
                    VALUES
                    (
                        '".mysql_real_escape_string($tre_id)."',
                        '".mysql_real_escape_string($_SESSION['img_details']['img_url'])."',
                        '".mysql_real_escape_string($_SESSION['img_details']['thumb_url'])."',
                        '".mysql_real_escape_string($val)."',
                        '".mysql_real_escape_string('4')."'
                    )";
                $res = executeQuery($query);
                unset($_SESSION['img_details']);
            }
        }
        if(get_resource_type($link) == 'mysql link')
        mysql_close($link);
    }
    function DisTreatment($id){
        $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
        if(get_resource_type($link) == 'mysql link'){
            if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){

            }
        }
        if(get_resource_type($link) == 'mysql link')
        mysql_close($link);
    }
    function Treatment($val,$id=false,$tindex = false,$balance_rem=false){
        $targets = array();
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$query = "SELECT a.*,b.`thumb_url`
                                FROM `target` AS a
                                LEFT JOIN `profile_image` AS b ON b.`tar_id` = a.`id`
                                WHERE
                                a.`status` = 'active'
                                AND
                                a.`id` = '".$_GET['id']."' ;";
				$res = executeQuery($query);
				if(mysql_num_rows($res) > 0){

                                    $row = mysql_fetch_assoc($res);
                                    $targets['id'] = $row['id'];
                                    $targets['pre_name'] = $row['pre_name'];
                                    $targets['tar_name'] = $row['tar_name'];
                                    $targets['address'] = $row['address'];
                                    $targets['email'] = $row['email'];
                                    $targets['phone'] = $row['phone'];
                                    $targets['thumb_url'] = $row['thumb_url'];
                                    $targets['balance_amount'] = load_balance($row['id']);
                                    $_SESSION['user_details'] = $targets;
				}
				else{
                                    $targets = NULL;
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
		mysql_close($link);
        if(get_resource_type($link) == 'mysql link')
        mysql_close($link);
        if($val == 'create'){
            if($_POST['action'] == 'show_visit_form'){
                $heading = 'Add Visit';
                $treatment_id = '<input type="hidden" value="'.$_POST['id'].'" id="tre_id">';
                $tre_name = $_POST['tre_name'];
                $tre_amount = $_POST['tre_amount'];
                $function = 'add_visit(id)';
               // $bal = 'style="display:none;"';
				$bal = '';
                $read_status = 'readonly';

            }

            else{
                $heading = 'Add Treatment';
                $treatment_id = '';
                $tre_name = '';
                $tre_amount ='';
                $function = 'add_treatment()';
                $bal = '';
                $read_status = '';
				// $balance_rem = "style='display:none;'";
            }
            $j=0;
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
                           '.$heading.'
                        </div>
                        <div class="panel-body">
							<form role="form">
								<div class="form-group" style="display:none;">
									<div class="row">
										<div class="col-lg-6">
											<span class="manditory">*</span>
											<label>Name</label>
											<input id="id" value="'.$_GET['id'].'" type="hidden" readonly >
												'.$treatment_id.'
											<input id="name" name="name" type="text" class="form-control" value="'.$targets['tar_name'].'" readonly>
										</div><!-- /.col-lg-6 -->
										<div class="col-lg-6">
										 <label>Mobile</label>
											<input id="phone" name="name" type="text" class="form-control" value="'.$targets['phone'].'" readonly>
										</div><!--col-lg-6 -->
									</div><!-- /.row -->
									<span class="text-danger" id="err_phone">Invalid</span>
								</div>
                                   <hr />


								<div class="form-group">
									<div class="row">
										<div class="col-lg-4">
											<label>Date of Treatment: </label>
											<input type="text" id="dot" class="form-control" value="'.date("d-m-Y").'" readonly >
											<input id="alt_dot"  type="hidden" value="'.date("Y-m-d").'" readonly>
											<script type="text/javascript">
													$("#dot").datepicker({
														dateFormat: "dd-mm-yy",
														altField: "#alt_dot",
														altFormat: "yy-mm-dd",
                                                                                                                changeYear : true,
                                                                                                                changeMonth : true,
													});
											</script>
										</div><!--col-lg-4 -->
										<div class="col-lg-4">
											<label>Treatment Name: </label>
											<input type="text" id="tre_name" name="tre_name" placeholder="Root cannel" class="form-control" value="'.$tre_name.'" '.$read_status.'>
										</div><!--col-lg-4 -->
										<div class="col-lg-4">
											<label>Proposed Amount: </label>
											<input type="text" id="amount" name="amount" placeholder="999.99" class="form-control" onkeyup="javascript:cal_balance();" value="'.$tre_amount.'" '.$read_status.'>
										</div><!--col-lg-4 -->










									</div>
								</div>


						<div id="first_visit">
							<div class="form-group">
								<h3> Visit - '.$tindex. '</h3>
								<hr />
								<div class="row">
									<div class="col-lg-4">
										<label>Amount Paid: </label>
										<input type="text" id="amount_paid" name="amount_paid" placeholder="999.99" class="form-control" onkeyup="javascript:cal_balance();" >
									</div><!--col-lg-4 -->
									<div class="col-lg-4">
										<label>Balance Amount: </label>
										<input type="text" id="bal_amount" name="bal_amount" placeholder="999.99" class="form-control" readonly '.$bal.'>
										<span class="text-danger" id="err_bal_amount">Invalid</span>
									</div><!--col-lg-4 -->


									<div class="col-lg-4">
										<label>Balance Remaining : </label>
										<input type="text" id="bal_amount" name="bal_amount" placeholder="999.99" class="form-control" value= "'.$balance_rem.'" '.$read_status.' readonly>
										<span class="text-danger" id="err_bal_amount">Invalid</span>
									</div><!--col-lg-4 -->







								</div>
								<div class="row">
									<div class="col-lg-4">
										<label>Complain: </label>
										<textarea id="comp" class="form-control"></textarea>
									</div><!--col-lg-4 -->
									<div class="col-lg-4">
										<label>Diagnostics: </label>
										<textarea id="diag" class="form-control"></textarea>
									</div><!--col-lg-4 -->
									<div class="col-lg-4">
										<label>Case: </label>
										<textarea id="case" class="form-control"></textarea>
									</div><!--col-lg-4 -->
								</div>
							</div>
						</div>
						<div class="gap">&nbsp;</div>
						<div id="next_appointment">
						   <h3> Next Appointment  <input type="checkbox" id="next_app_check" onchange="toggle_app_form();"></h3>
							<hr />
							<div class="form-group">
								<div class="row" id="next_app_form" style="display:none">
									<div class="col-lg-6">
										<label>Date of appointment: </label><br/>
										<i class="fa fa-calendar fa-2x"></i>
										<input type="hidden" id="app_con" value="0" readonly>
										<input type="text" id="app_date" value="'.date("d-m-Y").'" readonly>
										<input  type="hidden" id="alt_app_date" value="'.date("Y-m-d").'"  readonly>
										<script type="text/javascript">
											   $("#app_date").datepicker({
												   dateFormat: "dd-mm-yy",
												   altField: "#alt_app_date",
												   altFormat: "yy-mm-dd",
                                                                                                   changeYear : true,
                                                                                                   changeMonth : true,
											   });
										</script>
									</div>
									<div class="col-lg-6">
										<label>Select Time: </label><br/>
										 <i class="fa fa-clock-o fa-2x"></i>
										  '.$timing.'
										  <input type="hidden" id="from" class="form-control" readonly>
										  <span class="text-danger" id="err_from">Invalid</span>
								   </div>
								</div>
							</div>
						</div>
					<div id="class">&nbsp;</div>
					<div class="form-group">
						<button id="make_receipt_btn" onclick="javasript:'.$function.'" type="button" class="btn btn-danger form-control">Save Changes</button>
					</div>
							</form>
                        </div>
                    </div>
                </div>';
        }
        else{
            echo "view";
        }

    }
    function load_balance($id){
              /*  $query1 = "SELECT  a.`amount` as amount
                FROM `target` as tar
                LEFT JOIN `treatment` as a ON a.`patientid` = tar.`id`
                LEFT JOIN `treatment_visits` as b ON b.`treatment_id` = a.`id`
                LEFT JOIN `income` as c ON c.`visit_id` = b.`id`
                WHERE
                  a.`patientid` = '".mysql_real_escape_string($id)."'
                    "; */

                $query = "SELECT  sum(a.`amount`) as amount,amt.`amount_paid`
                FROM `target` as tar
                LEFT JOIN `treatment` as a ON a.`patientid` = tar.`id`
                LEFT JOIN
					(
						SELECT SUM(c.`amount`) as amount_paid, b.`treatment_id`
						FROM `income` as c
						RIGHT JOIN `treatment_visits` as b
						ON c.`visit_id` = b.`id`
						WHERE
						c.`target_id` = '".mysql_real_escape_string($id)."'


					) AS amt  ON amt.`treatment_id` = a.`id`
				WHERE
                  a.`patientid` = '".mysql_real_escape_string($id)."'
                  ";




                $res = executeQuery($query);
                if(mysql_num_rows($res) > 0){
                    $row = mysql_fetch_assoc($res);
                    $balance = $row['amount'] - $row['amount_paid'];
                }
                else{
                         $balance = '0';
                }
                return $balance;

    }
    function Add_Treatment(){
        $id= $_POST['id'];
        $name= $_POST['name'];
        $mobile= $_POST['mobile'];
        $dot= $_POST['dot'];
        $tre_name= $_POST['tre_name'];
        $amount= $_POST['amount'];
        $comp= $_POST['comp'];
        $diag= $_POST['diag'];
        $cas= $_POST['cas'];
        $app_date= $_POST['app_date'];
        $app_time= $_POST['app_time'];
        $amount_paid = $_POST['amount_paid'];
        $link = MySQLconnect(DBHOST,DBUSER,DBPASS);
        if(get_resource_type($link) == 'mysql link'){
            if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
                executeQuery("SET AUTOCOMMIT=0;");
                executeQuery("START TRANSACTION;");
                /*inserting treatment detail into database*/
                $query = "INSERT INTO `treatment`
                (`patientid`, `date`, `name`, `amount`, `status_id`)
                VALUES
                ('".mysql_real_escape_string($id)."',
                '".mysql_real_escape_string($dot)."',
                '".mysql_real_escape_string($tre_name)."',
                '".mysql_real_escape_string($amount)."',
                '".mysql_real_escape_string('4')."');";
                $res = executeQuery($query);
                $tre_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
                if($res ){
                    $query1 = "INSERT INTO `treatment_visits`
                    (`treatment_id`, `date`, `complian`, `diagnostics`, `case`, `status_id`)
                    VALUES
                    (
                        '".mysql_real_escape_string($tre_id)."',
                        '".mysql_real_escape_string($dot)."',
                        '".mysql_real_escape_string($comp)."',
                        '".mysql_real_escape_string($diag)."',
                        '".mysql_real_escape_string($cas)."',
                        '".mysql_real_escape_string('4')."'
                    );";
                    $res1 = executeQuery($query1);
                    $visit_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
                    if($app_date != 0 || $app_time != 0){
                        $query2 = "INSERT INTO `appointment`
                        (`patientid`, `date`, `from`, `des`, `status_id`)
                        VALUES
                        ('".mysql_real_escape_string($id)."',
                        '".mysql_real_escape_string($app_date)."',
                        '".mysql_real_escape_string($app_time)."',
                        '".mysql_real_escape_string($tre_name.' (Next Treatment Appointment)')."',
                        '".mysql_real_escape_string('4')."'
                         ); ";
                        $res2 = executeQuery($query2);
                        $query3=" SELECT settings.sms_status, status.statu_name FROM settings LEFT JOIN status ON settings.sms_status=status.id ;";
							$res3=executeQuery($query3);
							while($row=mysql_fetch_object($res3))
								$sms_status = $row->statu_name;
								        if($sms_status == 'on' ){
                            $msg = 'Hi '.$name.', your appointment is succesfully scheduled on '.date('d-m-Y',strtotime($app_date)).' at '.$app_time.'('.ORGNAME.')';

                            $sms_para = array(
                                                    "tar_id"    => $id,
                                                    "msg"       => $msg,
                                                    "number"	=> $mobile
                                            );
                            SendSms($sms_para);
                        }
                    }
                                if($res){
                                    MakeReceipt($visit_id);
				}
				else{
					echo 0;
					executeQuery("ROLLBACK");
				}

                            executeQuery("COMMIT");
                            echo '<h1 align="center" style="color:#C90000;">Appointment Fixed Successfully</h1>';
                            echo '<form>
                                    <div id="treatment_img" >
                                        <div class="form-group">
                                            <h3> Treatment Photos</</h3>
                                            <hr />
                                            <label>Pre-Treatment: </label><br/>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input type="file" id="ex1" name="ex1[]" multiple="multiple" />
                                                </div>
                                                <div class="col-lg-4" id="pre_img">
                                                    <button type="button" onclick="upload(\'pre_img\',\''.$tre_id.'\',\'ex1[]\');" class="btn btn-danger">Upload Images</button>
                                                </div>
                                            </div>
                                            <hr />
                                            <label>Mid-Treatment: </label><br/>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input type="file" id="ex2" name="ex2[]" multiple="multiple" />
                                                </div>
                                                <div class="col-lg-4" id="mid_img">
                                                    <button type="button" onclick="upload(\'mid_img\',\''.$tre_id.'\',\'ex2[]\');" class="btn btn-danger">Upload Images</button>
                                                </div>
                                            </div>
                                            <hr />
                                            <label>Post-Treatment: </label><br/>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <input type="file" id="ex3" name="ex3[]" multiple="multiple" />
                                                </div>
                                                <div class="col-lg-4" id="post_img">
                                                    <button type="button" onclick="upload(\'post_img\',\''.$tre_id.'\',\'ex3[]\');" class="btn btn-danger">Upload Images</button>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row" align="center">
                                                 <a href="javascript:void(0);" class="btn btn-success" onclick="view_history('.$_GET['id'].');">Skip image upload</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gap">&nbsp;</div>
                                </form>';

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
    function MakeReceipt($visit_id){
        $tar_id = $_POST['id'];
        $name = $_POST['name'];
        //$mobile= $_POST['mobile'];
        $tre_name = $_POST['tre_name'];
        $amount = $_POST['amount'];
        $rec_no =  FecthRecNo();
        $don_type = 'cash';
        $src_ac = '0';
        $amount_paid = $_POST['amount_paid'];
        $balance = $amount - $amount_paid;
        $towards = $_POST['tre_name'];
        $date = $_POST['dot'];
                                        $query1 = "INSERT INTO `income`
					(`target_id`, `visit_id` ,  `don_type`, `source_id`, `amount`, `for`, `date`, `status`)
					VALUES
					(
                                            '".mysql_real_escape_string($tar_id)."',
                                            '".mysql_real_escape_string($visit_id)."',
                                            '".mysql_real_escape_string($don_type)."',
                                            '".mysql_real_escape_string($src_ac)."',
                                            '".mysql_real_escape_string($amount_paid)."',
                                            '".mysql_real_escape_string($towards)."',
                                            '".mysql_real_escape_string($date)."',
                                            default
                                        ); ";
					$res1 = executeQuery($query1);
					if($res1){
						$location = URL.ASSET_REC.$rec_no.'_'.$name.'_'.date('j-M-Y').'.html';
						$income_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
						$query2 = "INSERT INTO `receipt`
						(`income_id`, `rec_no`, `rec_location`)
						VALUES
						('".$income_id."',
						'".mysql_real_escape_string($rec_no)."',
						'".mysql_real_escape_string($location)."'
						); ";
						$res2 = executeQuery($query2);
						if($res2){
                                                        $val = 'cash';
                                                        $bank_name = '';
                                                        $cheque_no = '';
                                                        $img_url = URL.ASSET_IMG."receipt_bg.png";
                                                        $don_type = 'cash';
							$receipt = array(
                                                                        "css" 		=> "<link href='".URL.ASSET_DIR."font-awesome-4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css' />",
                                                                        "val" 		=> $val,
                                                                        "img_url" 	=> $img_url,
                                                                        "rec_no" 	=> $rec_no,
                                                                        "date" 		=> $date,
                                                                        "pre_name" 	=> '',
                                                                        "tar_name" 	=> $name,
                                                                        "loc" 		=> '',
                                                                        "src_ac" 	=> $src_ac,
                                                                        "for" 		=> $towards,
                                                                        "don_type" 		=> $don_type,
                                                                        "number" 	=> '',
                                                                        "branch_of" 	=> '',
                                                                        "bank_name" 	=> '',
                                                                        "tran_mode" 	=> '',
                                                                        "amount" 	=> moneyFormatIndia($amount_paid),
                                                                        "amount_words" 	=> no_to_words($amount_paid)
                                                                        );
							$recp = generateReciept($receipt);
                                                            $file_name = DOC_ROOT.ASSET_REC.$rec_no.'_'.$name.'_'.date('j-M-Y').'.html';
                                                            $file_link = URL.ASSET_REC.$rec_no.'_'.$name.'_'.date('j-M-Y').'.html';
							$fh = fopen($file_name, 'w');
							fwrite($fh, $recp);
							fclose($fh);
							//echo '<a href="'.$file_link.'" class="btn btn-danger square-btn-adjust" target="_blank">Print Reciept</a><br /><br />'.$recp.'';

							//Alert($mailParameters);
							if(SEND_EMAIL == 'on')
								Alert($email,$name,$towards, $recp);
                                                        $flag =true;
						}
						else{
							//echo 0;
							//executeQuery("ROLLBACK");
                                                        $flag = false;
						}
					}
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

    main();
?>
<?php include_once(DOC_ROOT.PHP.INC."header.php"); ?>

<!-- /. NAV SIDE  -->
<div id="page-wrapper" >

	<div id="page-inner">

		<div class="btn-group btn-group-justified">
		  <div class="btn-group">
			<button type="button" class="btn btn-warning btn-lg" onclick="javascript:treatment('create')">Add Treatment</button>
		  </div>
		  <div class="btn-group">
			<button type="button" class="btn btn-info btn-lg" onclick="javascript:view_history(<?php echo $_GET['id'] ;?>)">Dental History</button>
		  </div>
		</div>
		<hr/>
                <!-- display screen -->
		<div id="rec_screen_user_details">
		</div>
                <!-- display screen -->
		<div id="rec_screen">
		</div>
		<!--Display the append data -->
		<div id="rec_screen_app">
		</div>
	</div>
	 <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php include_once(DOC_ROOT.PHP.INC."footer.php"); ?>
<script src="<?php echo URL.ASSET_JS; ?>config.js"></script>
<script src="<?php echo URL.ASSET_JS.DENTAL; ?>treatment.js"></script>
 <!-- DataTables JavaScript -->
<script>
    /*script to highlight present page on right panel*/
    $("#pat_nav").addClass("active-menu");
</script>
