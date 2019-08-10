<?php
require_once("config.php");
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);
if ($_SESSION['USERTYPE'] != "admin")
    header("Location:" . URL);
$parameters = array();

function main() {
    if (!ValidateAdmin()) {
        session_destroy();
        header('Location:' . URL);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'dis_receipts') {
        $val = $_POST['val'];
        if ($val == 'create') {
            DisReceipts();
        }
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'dis_receipts_scroll') {

        if (isset($_SESSION['receipts']) && sizeof($_SESSION['receipts']) > 0) {
            $_SESSION["initial"] = 0;
            $_SESSION["final"] = 10;
            $para["initial"] = $_SESSION["initial"];
            $para["final"] = $_SESSION["final"];
            DisAllReceipts($para);
        } else {
            $para["initial"] = 0;
            $para["final"] = 0;
            DisAllReceipts($para);
            echo '<script language="javascript" >$(window).unbind();</script>';
        }


        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'dis_receipts_scroll_append' && $_POST['val'] != 'create') {

        if (isset($_SESSION["initial"]) && isset($_SESSION["final"])) {
            if (isset($_SESSION['receipts']) && sizeof($_SESSION['receipts']) > 0) {
                if ($_SESSION["final"] >= sizeof($_SESSION['receipts'])) {
                    unset($_SESSION["initial"]);
                    unset($_SESSION["final"]);
                    echo '<script language="javascript" >$(window).unbind();</script>';
                } else {
                    $_SESSION["initial"] = $_SESSION["final"] + 1;
                    $_SESSION["final"] += 10;
                    $para["initial"] = $_SESSION["initial"];
                    $para["final"] = $_SESSION["final"];
                    DisAllReceiptsAppend($para);
                }
            }
        }


        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'load_tar_session') {
        $_SESSION['targets'] = LoadTarSession();
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'make_receipt') {
        MakeReceipt();
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'check_name_exist') {
        $result = CheckNameExist(strtolower($_POST['name']));
        echo $result;
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'load_all_receipts') {
        $_SESSION['receipts'] = LoadAllReceipts();
        unset($_POST);
        exit(0);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'auto_fill') {
        AutoFill($_POST['name']);
        unset($_POST);
        exit(0);
    }
}

function AutoFill($name) {
    $result = $_SESSION['targets'];
    foreach ($result as $key => $val) {
        if ($val['tar_name'] . ' - ' . $val['phone'] . ' - ' . $val['email'] === $name) {
            echo json_encode($val);
        }
    }
    exit(0);
}

function MakeReceipt() {
    $val = $_POST['val'];
    $rec_no = $_POST['rec_no'];
    $src_ac = $_POST['src_ac'];
    $pre_name = $_POST['pre_name'];
    $name = strtolower($_POST['name']);
    $user_type = $_POST['user_type'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $loc = $_POST['loc'];
    $amount = $_POST['amount'];
    $towards = $_POST['towards'];
    $org_date = $_POST['date'];
    $date_temp = explode("-", $_POST['date']);
    $date = $date_temp[2] . '-' . $date_temp[1] . '-' . $date_temp[0];
    //$doctor_name=array();
    //$clinic_name=array();
    //$clinic_address=array();
    /* user_detail fields */
    $bloodgroup = ( isset($_POST['bloodgroup']) ) ? $_POST['bloodgroup'] : '';
    $dob = ( isset($_POST['dob']) ) ? $_POST['dob'] : '';
    $sex = ( isset($_POST['sex']) ) ? $_POST['sex'] : '';
    $allergies = ( isset($_POST['allergies']) ) ? $_POST['allergies'] : '';

    if ($val == 'bank') {
        $src_ac = $_POST['src_ac'];
        $don_type = $_POST['mop_by'];
        $tran_mode = $_POST['tran_mode'];
        $branch_of = $_POST['branch_of'];
        $bank = $_POST['bank'];
        $number = $_POST['number'];
    } elseif ($val == 'cash') {
        $src_ac = 0;
        $don_type = 'cash';
        $tran_mode = NULL;
        $branch_of = NULL;
        $bank = NULL;
        $number = NULL;
    }
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            executeQuery("SET AUTOCOMMIT=0;");
            executeQuery("START TRANSACTION;");
            $set_query = "SELECT * FROM `settings` WHERE `admin_id`=".$_SESSION['ADMIN_ID']." LIMIT 1";
            $result = executeQuery($set_query);
            if (mysql_num_rows($result)) {
                $row = mysql_fetch_assoc($result);
                $doctor_name = $row['doctor_name'];
                $clinic_name = $row['clinic_name'];
                $clinic_address = $row['clinic_address'];
            }
            if (isset($_POST['target_id'])) {
                $tar_id = $_POST['target_id'];
                $res = true;
            } else {
                $query = "INSERT INTO `target`
					(`pre_name`, `tar_name`,`address`,`email`,`phone`,`user_type`, `date` )
					VALUES
					( '" . mysql_real_escape_string($pre_name) . "',
					'" . mysql_real_escape_string($name) . "',
					'" . mysql_real_escape_string($loc) . "',
					'" . mysql_real_escape_string($email) . "',
					'" . mysql_real_escape_string($mobile) . "',
					'" . mysql_real_escape_string($user_type) . "',
					NOW() ); ";
                $res = executeQuery($query);
                $tar_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                $query1 = "INSERT INTO `user_details`
					(`user_pk`, `bloodgroup`, `dob`, `sex`, `allergies`)
					VALUES
					('" . mysql_real_escape_string($tar_id) . "',
					'" . mysql_real_escape_string($bloodgroup) . "',
					'" . mysql_real_escape_string($dob) . "',
					'" . mysql_real_escape_string($sex) . "',
					'" . mysql_real_escape_string($allergies) . "'
					 ); ";
                $res1 = executeQuery($query1);
            }
            if ($res) {
                $query1 = "INSERT INTO `income`
					(`target_id`, `don_type`, `source_id`, `amount`, `for`, `date`, `status`)
					VALUES
					('" . $tar_id . "',
					'" . mysql_real_escape_string($don_type) . "',
					'" . mysql_real_escape_string($src_ac) . "',
					'" . mysql_real_escape_string($amount) . "',
					'" . mysql_real_escape_string($towards) . "',
					'" . mysql_real_escape_string($date) . "',
					default ); ";
                $res1 = executeQuery($query1);
                if ($res1) {
                    $location = URL . ASSET_REC . $rec_no . '_' . $name . '_' . date('j-M-Y') . '.html';
                    $income_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                    $query2 = "INSERT INTO `receipt`
						(`income_id`, `rec_no`, `rec_location`)
						VALUES
						('" . $income_id . "',
						'" . mysql_real_escape_string($rec_no) . "',
						'" . mysql_real_escape_string($location) . "'
						); ";
                    $res2 = executeQuery($query2);
                    if ($res2) {
                        if ($src_ac > 0) {
                            if ($don_type == 'cheque') {
                                $query3 = "INSERT INTO `cheuqe`
										(`income_id`, `cq_no`, `branch`, `bank`)
										VALUES
										('" . $income_id . "',
								'" . mysql_real_escape_string($number) . "',
								'" . mysql_real_escape_string($branch_of) . "',
								'" . mysql_real_escape_string($bank) . "'
								);";
                            } else if ($don_type == 'dd') {
                                $query3 = "INSERT INTO `dd`
									(`income_id`, `dd_no`, `branch`, `bank`)
									VALUES
									('" . $income_id . "',
									'" . mysql_real_escape_string($number) . "',
									'" . mysql_real_escape_string($branch_of) . "',
									'" . mysql_real_escape_string($bank) . "'
									);";
                            } else if ($don_type == 'transfer') {
                                $query3 = "INSERT INTO `transfer`
									(`income_id`, `tran_no`, `branch`, `bank`, `mode`)
									VALUES
									('" . $income_id . "',
									'" . mysql_real_escape_string($number) . "',
									'" . mysql_real_escape_string($branch_of) . "',
									'" . mysql_real_escape_string($bank) . "',
									'" . mysql_real_escape_string($tran_mode) . "'
									);";
                            }
                            $res3 = executeQuery($query3);
                        }
                        executeQuery("COMMIT");
                        if ($val == 'bank') {
                            $bank_name = mysql_result(executeQuery("SELECT `src_bank` FROM `source` WHERE `id` = '" . mysql_real_escape_string($src_ac) . "';"), 0);
                            $img_url = URL . ASSET_IMG . "receipt_bg.png";
                        } else {
                            $bank_name = '';
                            $cheque_no = '';
                            $img_url = URL . ASSET_IMG . "receipt_bg.png";
                            $don_type = 'cash';
                        }
                        $receipt = array(
                            "css" => "<link href='" . URL . ASSET_DIR . "font-awesome-4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css' />",
                            "doctor_name" => $doctor_name,
                            "clinic_name" => $clinic_name,
                            "clinic_address" => $clinic_address,
                            "val" => $val,
                            "img_url" => $img_url,
                            "rec_no" => $rec_no,
                            "date" => $org_date,
                            "pre_name" => $pre_name,
                            "tar_name" => $name,
                            "loc" => $loc,
                            "src_ac" => $src_ac,
                            "for" => $towards,
                            "don_type" => $don_type,
                            "number" => $number,
                            "branch_of" => $branch_of,
                            "bank_name" => $bank,
                            "tran_mode" => $tran_mode,
                            "amount" => moneyFormatIndia($amount),
                            "amount_words" => no_to_words($amount)
                        );
                        $recp = generateReciept($receipt);
                        $file_name = DOC_ROOT . ASSET_REC . $rec_no . '_' . $name . '_' . date('j-M-Y') . '.html';
                        $file_link = URL . ASSET_REC . $rec_no . '_' . $name . '_' . date('j-M-Y') . '.html';
                        $fh = fopen($file_name, 'w');
                        fwrite($fh, $recp);
                        fclose($fh);
                        echo '<a href="' . $file_link . '" class="btn btn-danger square-btn-adjust" target="_blank">Print Reciept</a><br /><br />' . $recp . '';

                        //Alert($mailParameters);
                        if (SEND_EMAIL == 'on')
                            Alert($email, $name, $towards, $recp);
                    }
                    else {
                        echo 0;
                        executeQuery("ROLLBACK");
                    }
                }
            } else {
                echo 0;
                executeQuery("ROLLBACK");
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
}

function DisReceipts() {
    $targets = $_SESSION['targets'];
    $i = 0;
    $tar_names_arr = '';
    while ($i < sizeof($targets)) {
        if ($i == 0)
            $tar_names_arr = '"' . $targets[$i]['tar_name'] . ' - ' . $targets[$i]['phone'] . ' - ' . $targets[$i]['email'] . '"';
        else
            $tar_names_arr .= ',"' . $targets[$i]['tar_name'] . ' - ' . $targets[$i]['phone'] . ' - ' . $targets[$i]['email'] . '"';
        $i++;
    }
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $src_ac_opt = GetSrcAccount();
            $rec_no = FecthRecNo();
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);

    echo '<div class="col-lg-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                           The Receipt
                        </div>
                    <div class="panel-body">
							<form role="form">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>serial Number : </label>
											<input type="text" id="rec_no" class="form-control" value="' . $rec_no . '" readonly>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label>Date of Receipt: </label><br>
												<i class="fa fa-calendar fa-2x"></i>
												<input type="text" id="date"  value="' . date("d-m-Y") . '" readonly>
													<script type="text/javascript">
														$("#date").datepicker({ dateFormat: "dd-mm-yy" ,changeMonth : true,changeYear : true });
													</script>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<span class="manditory">*</span>
                                                                                    <label class="manditory">Received from</label>
												<select id="pre_name" class="form-control" onchange="javascript:show_pre_div(this);">
													<option value="Mr." selected>Mr</option>
													<option value="Mrs.">Mrs</option>
													<option value="Miss.">Miss</option>
													<option value="Dr.">Dr</option>
													<option value="The ">The</option>
												</select>
								    	</div>
								  	</div>

								   <div class="col-md-4">
										<div class="form-group">
										<span class="manditory">*</span>
                                                                                    <label class="manditory">Name</label>
												<input id="name" name="name" type="text" onkeyDown="javascript:allow_Receivedfrom();" class="form-control" onblur="javascript:auto_fill(this.value);" placeholder="Name">
													<script>
												$(function(){
													var availableTags = [' . $tar_names_arr . '];
													$( "#name" ).autocomplete({
														source: availableTags
													});
												});
											</script>
										</div>
									</div>
								   <div class="col-md-6">
									<div class="form-group">
										<span class="manditory">*</span>
                                                                                    <label class="manditory">User Type</label>
											<select id="user_type" class="form-control">
												<option value="1" >Doctor</option>
												<option value="2" selected>Patient</option>
												<option value="3">Others</option>
											</select>

								    </div>
								  </div>
								 </div>
							<!--
							   <div class="col-lg-12">
									<div class="form-group">
										<span class="manditory">*</span>
                                                                                    <label class="manditory">User Type</label>
											<select id="user_type" class="form-control">
												<option value="1" >Doctor</option>
												<option value="2" selected>Patient</option>
												<option value="3">Others</option>
											</select>
									</div>
								</div> -->

							<div class="row">


							</div>



								<div id="user_details" style="display:none;">
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                            <div class="form-group">
                                                                                    <span class="manditory">*</span>
                                                                                    <label class="manditory">Sum of Rupees</label>
                                                                                            <div class="form-group input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                    <i class="fa fa-inr"></i>
                                                                                                    </span>
                                                                                                    <input id="amount" type="text" onkeyDown="javascript:number_allow_sumofruppes();" class="form-control"  placeholder="9999.99">
                                                                                            </div>
                                                                                                    <span class="text-danger" id="err_amount">Invalid</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                                <div class="form-group" >
                                                                                        <label>Source Account :</label>
                                                                                                <select id="src_ac" class="form-control" onchange="javascript:show_mop_opt(this);">
                                                                                                ' . $src_ac_opt . '
                                                                                                </select>
                                                                                        <span class="text-danger"id="err_src_ac">Invalid</span>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                                <div class="form-group">
                                                                                                        <label>Email Id</label>
                                                                                                        <input id="email" type="text" class="form-control"  placeholder="abc@email.com" pattern="^.+@.+$" >
                                                                                                        <span class="text-danger" id="err_email">Invalid</span>
                                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                        <label>Mobile Number</label>
                                                                                        <input id="mobile" type="text" maxlength="10" onkeyDown="javascript:number_allow();" class="form-control" placeholder="9900000000" >
                                                                                        <span class="text-danger" id="err_mobile">Invalid</span>
                                                                                </div>
                                                                        </div>
							   	</div>

								  	<div class="row">
                                                                            <div class="col-md-12">
                                                                        	<div class="form-group">
											<label id="res_at">Residing at</label>
											<label id="hq_at">Head-quartered at</label>
											<textarea id="loc" type="text" class="form-control"  placeholder="type Location"></textarea>
											<span class="text-danger" id="err_loc">Invalid</span>
										</div>
                                                                            </div>
									</div>

									<div calss="row" id="mop_opt"  style="display:none;">
										<div class="form-group">
											<label>Mode of payment:</label>
												<select id="mop_by" class="form-control" onchange="javascript:show_mop_div(this);">
													<option value="cheque" selected>Cheque</option>
													<option value="dd" >DD</option>
													<option value="transfer">Transfer</option>
												</select>
											<span class="text-danger">Invalid</span>
										</div>

										<div class="form-group" id="trans_mode_div" style="display:none;">
											<label>Transfer MODE</label>
											<div class="radio">
												<label>
													<input type="radio" name="tran_mode" id="tran_mode1" value="NEFT" checked=""> NEFT
												</label>
											</div>
											<div class="radio">
												<label>
													<input type="radio" name="tran_mode" id="tran_mode2" value="RTGS"> RTGS
												</label>
											</div>
										</div>

										<div class="row form-group" >
											<div class="col-md-4 col-sm-4">
												<span class="manditory">*</span>
												<label id="cheque_div">Cheque No</label>
												<label id="dd_div" style="display:none;">Demand Draft No</label>
												<label id="transer_div" style="display:none;">Transaction No</label>
												<div class="form-group input-group">
													<span class="input-group-addon">
														<strong>#</strong>
													</span>
													<input id="number" type="number" class="form-control"  placeholder="999999">
													<span class="text-danger" id="err_number">Invalid</span>
												</div>
											</div>

											<div class="col-md-4 col-sm-4">
												<label>Branch of</label>
												<input type="text" id="branch_of" class="form-control" placeholder="Branch Name">
											</div>
											<div class="col-md-4 col-sm-4">
												<label>Bank</label>
												<input type="text" id="bank" class="form-control" placeholder="Bank Name">
											</div>
										</div>
									</div>


									<div class="form-group">
										<label>For :</label>
										<textarea id="for" class="form-control" rows="3"  placeholder="100 character description"></textarea>
									</div>

									<button id="make_receipt_btn" onclick="javasript:make_receipt();" type="button" class="btn btn-danger form-control">Save Changes</button>
								</div>
							</form>
                        </div>
                    </div>
                </div>';
}

function FecthRecNo() {
    $yy = date("Y");
    $mm = date("m");
    $sl_no = ($mm < 4) ? "FY" . ($yy - 1) . "R" : "FY" . ($yy) . "R";
    $query = "SELECT * FROM `receipt` ORDER BY `id` DESC LIMIT 1; ";
    $res = executeQuery($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $temp = explode("-", $row['rec_no']);
            if ($temp[0] != $sl_no) {
                $sl_no .= '-00001';
            } else {
                $sl_no .= "-" . sprintf("%05s",  ++$temp[1]);
            }
        }
    } else {
        $sl_no .= '-00001';
    }
    return $sl_no;
}

function GetSrcAccount() {
    $result = '<option value="0">Cash</option>';
    $query = "SELECT * FROM `source` WHERE `status` = 'active' ORDER BY `id` DESC; ";
    $res = executeQuery($query);
    if (mysql_num_rows($res)) {
        while ($row = mysql_fetch_assoc($res)) {
            $result .= '<option value="' . $row['id'] . '">' . $row['src_ac_name'] . ' - ' . $row['src_ac_no'] . ' - ' . $row['src_branch'] . ' - ' . $row['src_ac_type'] . '</option>';
        }
    } else {
        echo 'No Accouts to be displayed,Please add new account.';
    }
    return $result;
}

function DisAllReceipts($val) {
    $parameters = $val;
    $num_posts = 0;
    if (isset($_SESSION['receipts']) && $_SESSION['receipts'] != NULL)
        $receipts = $_SESSION['receipts'];
    else
        $receipts = NULL;
    if ($receipts != NULL)
        $num_posts = sizeof($receipts);


    //Search receipts
    $receipts = $_SESSION['receipts'];
    $total_rec = '';
    $a = 0;
    $targets = $_SESSION['targets'];
    while ($a < sizeof($targets)) {

        if ($a == 0)
            $total_rec = '"' . $targets[$a]['tar_name'] . ' - ' . $targets[$a]['phone'] . ' - ' . $targets[$a]['email'] . '"';
        else
            $total_rec .= ',"' . $targets[$a]['tar_name'] . ' - ' . $targets[$a]['phone'] . ' - ' . $targets[$a]['email'] . '"';
        $a++;
    }
    //End search receipts
    echo '<div class="row">
						<div class="col-md-4">
							<input id="name1" type="text" class="form-control" onKeyDown="javascript:if (event.keyCode==13 || event.keyCode==9)search_receipt(this.value);"  placeholder="Search Name/Email/Mobile ">
						</div>
						<div class="col-md-6">
							<button class="btn btn-danger" onclick="javascript:view_all_receipts();">
				 			<i class="fa fa-refresh "></i>
				 			Refresh
							</button><br/>
						</div>
					</div>

					<script>
						$(function() {
						var availableTags = [' . $total_rec . '];
						$( "#name1" ).autocomplete({
						source: availableTags

						});
					});
				</script>

				<br/>	';
    echo '<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info scroll-pane">
                        <div class="panel-heading">
							List receipts
                        </div>
                        <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="rec_table">
								<thead>
										<tr>
											<th >
												Receipt No.
											</th>
											<th>
												Name
											</th>
											<th>
												Date of Receipt
											</th>
											<th>
												Critical Action
											</th>
										</tr>
								</thead>';

    if ($num_posts > 0) {

        // && isset([$receipts]['usrid']
        for ($i = $parameters["initial"]; $i <= $parameters["final"] && $i < $num_posts; $i++) {
            //for($i=0;$i< $end;$i++){
            $temp_name = explode("/", $receipts[$i]['rec_location']);
            $name_string = explode(".", $temp_name[sizeof($temp_name) - 1]);
            $name_string = $name_string[0];
            $string = explode("_", $name_string);
            echo '<tbody>
							<tr>
								<td>
									 ' . $string[0] . '
								</td>
								<td>
									 ' . $string[1] . '
								</td>
								<td>
									 ' . $string[2] . '
								</td>
								<td>
									 <a  href="' . $receipts[$i]['rec_location'] . '" target="_blank" class="btn btn-danger"><i class="fa fa-print"></i>&nbsp;Print</a>
									 <a  href="' . URL . 'php/edit/edit_receipts.php?id=' . base64_encode($receipts[$i]['id']) . '" target="_blank" class="btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Edit</a>
									 <a data-toggle="collapse" data-parent="#accordion" href="#collapse_' . $receipts[$i]['id'] . '" target="_blank" class="btn btn-info"><i class="fa fa-bullseye"></i>&nbsp;View</a>
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<div id="collapse_' . $receipts[$i]['id'] . '" class="panel-collapse collapse" style="height: 0px;">
										<div class="panel-body">
											<iframe style="border:0px;" height="1050" width="760" src="' . $receipts[$i]['rec_location'] . '">
											</iframe>
										</div>
									</div>
								</td>
							</tr>
						<!--<div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default itemDiv">
                                    <div class="panel-heading">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_' . $receipts[$i]['id'] . '" >
												Receipt NO. : ' . $string[0] . '<br />
												Name : ' . $string[1] . '<br />
												Date of Receipt : ' . $string[2] . '<br />
											</a>
											<a  href="' . $receipts[$i]['rec_location'] . '" target="_blank" class="btn btn-danger"><i class="fa fa-print"></i>&nbsp;Print</a>
											<a  href="' . URL . 'php/edit/edit_receipts.php?id=' . base64_encode($receipts[$i]['id']) . '" target="_blank" class="btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                    </div>
                                    <div id="collapse_' . $receipts[$i]['id'] . '" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
											<iframe style="border:0px;" height="1050" width="760" src="' . $receipts[$i]['rec_location'] . '">
											</iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->';
        }
    }
    echo ' </tbody>
			</table>
			</div></div>
                </div>
            </div>';
}

function DisAllReceiptsAppend($val) {
    $parameters = $val;
    $num_posts = 0;

    if (isset($_SESSION['receipts']) && $_SESSION['receipts'] != NULL)
        $receipts = $_SESSION['receipts'];
    else
        $receipts = NULL;
    if ($receipts != NULL)
        $num_posts = sizeof($receipts);
    echo '<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info scroll-pane">
                    <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="rec_table">
								<thead>
										<tr>
											<th >
												Receipt No.
											</th>
											<th>
												Name
											</th>
											<th>
												Date of Receipt
											</th>
											<th>
												Critical Action
											</th>
										</tr>
								</thead>';
    if ($num_posts > 0) {

        for ($i = $parameters["initial"]; $i <= $parameters["final"] && $i < $num_posts; $i++) {

            //for($i=0;$i< $end;$i++){
            $temp_name = explode("/", $receipts[$i]['rec_location']);
            $name_string = explode(".", $temp_name[sizeof($temp_name) - 1]);
            $name_string = $name_string[0];
            $string = explode("_", $name_string);
            echo '

						<tbody>
						<tr>
							<td>
								 ' . $string[0] . '
							</td>
							<td>
								 ' . $string[1] . '
							</td>
							<td>
								 ' . $string[2] . '
							</td>
							<td>
								 <a  href="' . $receipts[$i]['rec_location'] . '" target="_blank" class="btn btn-danger"><i class="fa fa-print"></i>&nbsp;Print</a>
								 <a  href="' . URL . 'php/edit/edit_receipts.php?id=' . base64_encode($receipts[$i]['id']) . '" target="_blank" class="btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Edit</a>
								 <a data-toggle="collapse" data-parent="#accordion" href="#collapse_' . $receipts[$i]['id'] . '" target="_blank" class="btn btn-info"><i class="fa fa-bullseye"></i>&nbsp;View</a>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<div id="collapse_' . $receipts[$i]['id'] . '" class="panel-collapse collapse" style="height: 0px;">
									<div class="panel-body">
										<iframe style="border:0px;" height="1050" width="760" src="' . $receipts[$i]['rec_location'] . '">
										</iframe>
									</div>
								</div>
							</td>
						</tr>
                        <!--<div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default itemDiv">
                                    <div class="panel-heading">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_' . $receipts[$i]['id'] . '" >
												Receipt NO. : ' . $string[0] . '<br />
												Name : ' . $string[1] . '<br />
												Date of Receipt : ' . $string[2] . '<br />
											</a>
											<a  href="' . $receipts[$i]['rec_location'] . '" target="_blank" class="btn btn-danger">Print</a>
											<a  href="' . URL . 'php/edit/edit_receipts.php?id=' . base64_encode($receipts[$i]['id']) . '" target="_blank" class="btn btn-warning">Edit</a>
                                    </div>
                                    <div id="collapse_' . $receipts[$i]['id'] . '" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
											<iframe style="border:0px;" height="1050" width="760" src="' . $receipts[$i]['rec_location'] . '">
											</iframe>
                                        </div>
                                    </div>
                                </div>
                             </div>
							</div>-->';
        }
    }
    echo '
			 </tbody>
			</table>
			</div>
			</div>
                </div>
            </div>';
}

function LoadTarSession() {
    $targets = array();
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            $query = "SELECT * FROM `target` WHERE `status` = 'active' ;";
            $res = executeQuery($query);

            if (mysql_num_rows($res) > 0) {
                $i = 0;
                while ($row = mysql_fetch_assoc($res)) {
                    $targets[$i]['id'] = $row['id'];
                    $targets[$i]['pre_name'] = $row['pre_name'];
                    $targets[$i]['tar_name'] = $row['tar_name'];
                    $targets[$i]['address'] = $row['address'];
                    $targets[$i]['email'] = $row['email'];
                    $targets[$i]['phone'] = $row['phone'];
                    $i++;
                }
            } else {
                $targets = NULL;
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    return $targets;
}

function CheckNameExist($name) {
    $targets = $_SESSION['targets'];
    $i = 0;
    $tar_names_arr = '';
    while ($i < sizeof($targets)) {
        $tar_names_arr .= $targets[$i]['tar_name'] . "-";
        $i++;
    }
    $test = explode("-", $tar_names_arr);
    if (in_array($name, $test)) {
        $key = array_search($name, $test);
        $flag = $targets[$key]['id'];
    } else
        $flag = -1;
    return $flag;
}

function LoadAllReceipts() {
    $receipts = array();
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            if (isset($_POST["name"])) {
                $name = explode("-", $_POST["name"]);
                $sub_query = ' AND 	(
                                        c.`tar_name` LIKE "%' . trim($name[0]) . '%"
                                        OR
                                        c.`phone` LIKE "%' . trim($name[0]) . '%"
                                        OR
                                        c.`email` LIKE "%' . trim($name[0]) . '%"
                                        )';
            } else {
                $sub_query = "";
            }
            $query = "SELECT a.*,
								b.`source_id`,
								b.`don_type`,
								b.`for`,
								b.`amount`,
								b.`date`,
								c.`pre_name`,
								c.`tar_name`,
								c.`email`,
								c.`phone`
								FROM
									`receipt` AS a JOIN `income` AS b ON a.`income_id` = b.`id`
									JOIN `target`AS c on b.`target_id` = c.`id`

									" . $sub_query . "
									ORDER BY `id` DESC";

            /* 	if(isset($_POST["name"])) {
              $name=$_POST["name"];
              $query = "SELECT a.*,
              b.`source_id`,
              b.`don_type`,
              b.`for`,
              b.`amount`,
              b.`date`,
              c.`pre_name`,
              c.`tar_name`
              FROM
              `receipt` AS a JOIN `income` AS b ON a.`income_id` = b.`id`
              JOIN `target`AS c on b.`target_id` = c.`id`
              WHERE c.`tar_name` LIKE '%".$name."%'
              ORDER BY `id` DESC";


              }else {
              $query = "SELECT a.*,
              b.`source_id`,
              b.`don_type`,
              b.`for`,
              b.`amount`,
              b.`date`,
              c.`pre_name`,
              c.`tar_name`
              FROM
              `receipt` AS a JOIN `income` AS b ON a.`income_id` = b.`id`
              JOIN `target`AS c on b.`target_id` = c.`id`
              ORDER BY `id` DESC";
              } */
            $res = executeQuery($query);
            if (mysql_num_rows($res)) {
                $index = 0;
                while ($row = mysql_fetch_assoc($res)) {
                    $receipts[$index]['id'] = $row['id'];
                    $receipts[$index]['income_id'] = $row['income_id'];
                    $receipts[$index]['rec_no'] = $row['rec_no'];
                    $receipts[$index]['rec_location'] = $row['rec_location'];
                    $receipts[$index]['don_type'] = $row['don_type'];
                    $receipts[$index]['source_id'] = $row['source_id'];
                    $receipts[$index]['for'] = $row['for'];
                    $receipts[$index]['amount'] = $row['amount'];
                    $receipts[$index]['date'] = $row['date'];
                    $receipts[$index]['pre_name'] = $row['pre_name'];
                    $receipts[$index]['tar_name'] = $row['tar_name'];
                    $index++;
                }
            } else {
                $receipts = NULL;
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    return $receipts;
}

main();
?>
<?php include_once(DOC_ROOT . PHP . INC . "header.php"); ?>

<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <button type="button" class="btn btn-warning btn-lg" onclick="javascript:dis_receipts('create')">Create Receipt</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-info btn-lg" onclick="javascript:dis_receipts_scroll('view')">view Receipt</button>
            </div>
        </div>
        <hr />


        <div id="rec_screen">

        </div>
        <!--Display the dis_rec_scroll_append  -->
        <div id="rec_screen_app">

        </div>
    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php include_once(DOC_ROOT . PHP . INC . "footer.php"); ?>
<script src="<?php echo URL . ASSET_JS; ?>receipts.js"></script>
<script>
                            $("#rec_nav").addClass("active-menu");

</script>
