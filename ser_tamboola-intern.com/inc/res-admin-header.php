<!DOCTYPE html>
<html lang="en">
<div id="page-loader" style="margin:auto;position:relative;width:98%;height:98%;padding:20% 20% 20% 20%;">
<h1>Thambola ver 3.0</h1>
</div>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="madmec-two" >
    <title><?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"])	?	$_SESSION["USER_LOGIN_DATA"]["USER_NAME"]	:	"MADMEC"	)?></title>
    <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery-1.11.0.js"></script>
	<link rel="shortcut icon" href="<?php echo URL.ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
	<link rel="icon" href="<?php echo URL.ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
	
	
	<style>
	.panel-custom1 {
	  border-color: #999966;
	}
	.panel-custom1 > .panel-heading {
	  color: #fff;
	  background-color: #999966;
	  border-color: #999966;
	}
	.panel-custom1 > .panel-heading + .panel-collapse > .panel-body {
	  border-top-color: #999966;
	}
	.panel-custom1 > .panel-heading .badge {
	  color: #999966;
	  background-color: #fff;
	}
	.panel-custom1 > .panel-footer + .panel-collapse > .panel-body {
	  border-bottom-color: #999966;
	}
	</style>
</head>
<body style="display:none;">
<div id="wrapper">
<?php require_once(DOC_ROOT.INC.'admin-menu.php'); ?>
<div id="page-wrapper">
	<div class="col-lg-12" id="loader"></div>
	<div class="row">
		<div class="col-lg-12" id="output">
			<!-- first Load page -->
			<div class="row output-panels" id="ctrlDash">
				<h1 class="page-header text-primary"><i class="fa fa-dashboard fa-fw"></i><label>Dashboard</label> </h1>
				<div class="col-lg-12" id="dashboardcontent"></div>
			</div>
			<!-- Single Dashboard -->
			<div class="row output-panels" id="ctrlSingleDash">
				<h1 class="page-header text-primary"><i class="fa fa-dashboard fa-fw"></i><label id="dashname"></label><label>&nbsp;Dashboard</label> </h1>
				<div class="col-lg-12" id="singledashOutput"></div>
			</div>
			<!-- Profile data -->
			<div class="row output-panels" id="ctrlprofile">
				<h1 class="page-header text-primary"><i class="fa ftest183 fa-fw"></i><label>Profiles</label> </h1>
				<div class="row">
					<div class="col-lg-12">
						<div id="profiles"></div>
					</div>
				<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Manage profiles</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs">
									<li class="active"><a href="#admin_profile" data-toggle="tab">Admin Profile</a></li>
									<li><a href="#gym_profile" data-toggle="tab">Club Profile</a></li>
									<li style="display:none;"><a href="#add_profile" data-toggle="tab">Add Branch</a></li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane fade in active" id="admin_profile">
									</div>
									<div class="tab-pane fade" id="gym_profile">
									</div>
									<div class="tab-pane fade" id="add_profile" style="display:none;">
									<!-- add gym tab disabled --->
									<div class="col-lg-12">&nbsp;</div>
										<div class="tab-content">
											<div class="tab-pane fade in active" id="add_gym">
												<div class="row">
													<div class="col-lg-12">
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4>Add New Branch</h4>
															</div>
															<div class="panel-body" id="acrdaddgym">
																<form id="addgymForm">
																	<!-- gym Name -->
																	<div class="row">
																		<div class="col-lg-4">
																			<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Branch Name <i class="fa fa-caret-down fa-fw"></i></strong>
																			<input class="form-control" placeholder="Branch Name" name="gym_name" type="text" id="gym_name" maxlength="100"/>
																			<p class="help-block" id="gym_name_msg">Press enter or go button to move to next field.</p>
																		</div>
																		<div class="col-lg-4">
																			<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Registrtion Fee <i class="fa fa-caret-down fa-fw"></i></strong>
																			<input class="form-control" placeholder="Registrtion Fee" name="gym_fee" type="text" id="gym_fee" maxlength="100"/>
																			<p class="help-block" id="gym_fee_msg">Press enter or go button to move to next field.</p>
																		</div>
																		<div class="col-lg-4">
																			<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Service Tax <i class="fa fa-caret-down fa-fw"></i></strong>
																			<input class="form-control" placeholder="Service Tax" name="gym_tax" type="text" id="gym_tax" maxlength="100"/>
																			<p class="help-block" id="gym_tax_msg">Press enter or go button to move to next field.</p>
																		</div>
																		<div class="col-lg-12">&nbsp;</div>
																	</div>
																	<div class="row">
																		<div class="col-lg-12">&nbsp;</div>
																		<div class="col-lg-12">
																			<div class="panel panel-primary">
																				<div class="panel-heading">
																					<h4>Email IDs, Cell Numbers</h4>
																				</div>
																				<div class="panel-body">
																					<ul class="nav nav-pills">
																						<li class="active"><a href="#pfemails-pills" data-toggle="tab">Email IDs</a>
																						</li>
																						<li><a href="#pfcnums-pills" data-toggle="tab">Cell Numbers</a>
																						</li>
																					</ul>
																					<div class="tab-content">
																					
																						<div class="tab-pane fade in active" id="pfemails-pills">
																							<!-- Email ID -->
																							<div class="row">
																								<div class="col-lg-12">
																									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Email ID <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
																									<button  type="button" class="text-primary btn btn-success  btn-md" id="pfplus_email_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
																								</div>
																								<div class="col-lg-12" id="pfmultiple_email">
																								</div>
																								<div class="col-lg-12">&nbsp;</div>
																							</div>
																						</div>
																						<div class="tab-pane fade" id="pfcnums-pills">
																							<!-- Cell Number -->
																							<div class="row">
																								<div class="col-lg-12">
																									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Cell Number <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
																									<button  type="button" class="text-primary btn btn-success  btn-md" id="pfplus_cnumber_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
																								</div>
																								<div class="col-lg-12" id="pfmultiple_cnumber">
																								</div>
																								<div class="col-lg-12">&nbsp;</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-lg-12">&nbsp;</div>
																	</div>
																	<!-- Telephone Number -->
																	<div class="row">
																		<div class="col-lg-12">
																			<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Telephone Number <i class="fa fa-caret-down fa-fw"></i></strong>
																		</div>
																		<div class="col-lg-12">
																			<div class="col-lg-4">
																				<input class="form-control" placeholder="080" name="gym_pcode" type="text" id="gym_pcode" maxlength="15" />
																			</div>
																			<div class="col-lg-8">
																				<input class="form-control" placeholder="Telephone Number" name="gym_telephone" type="text" id="gym_telephone" maxlength="20" />
																			</div>
																			<p class="help-block" id="gym_tp_msg">Press enter or go button to move to next field.</p>
																		</div>
																		<div class="col-lg-12">&nbsp;</div>
																	</div>
																	<!-- ADDRESS -->
																	<div class="panel panel-info">
																		<div class="panel-heading">
																			<strong>Address</strong>&nbsp;
																			<button type="button" class="text-info btn btn-info  btn-md" id="addr_show_but" onClick="$('#address_body').show(300);"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
																			<button type="button" class="text-info btn btn-danger  btn-md" id="addr_hide_but" onClick="$('#address_body').hide(300);"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;
																		</div>
																		<div class="panel-body" id="address_body" style="display:none;">
																			<!-- Country -->
																			<div class="row">
																				<div class="col-lg-12">
																					<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Country <i class="fa fa-caret-down fa-fw"></i></strong>
																				</div>
																				<div class="col-lg-12">
																					<input class="form-control" placeholder="Country" name="gym_country" type="text" id="gym_country" maxlength="100"/>
																					<p class="help-block" id="gym_comsg">Press enter or go button to move to next field.</p>
																				</div>
																				<div class="col-lg-12">&nbsp;</div>
																			</div>
																			<!-- State / Province -->
																			<div class="row">
																				<div class="col-lg-12">
																					<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> State / Province <i class="fa fa-caret-down fa-fw"></i></strong>
																				</div>
																				<div class="col-lg-12">
																					<input class="form-control" placeholder="State / Province" name="gym_province" type="text" id="gym_province" maxlength="150" />
																					<p class="help-block" id="gym_prmsg">Press enter or go button to move to next field.</p>
																				</div>
																				<div class="col-lg-12">&nbsp;</div>
																			</div>
																			<!-- District / Department -->
																			<div class="row">
																				<div class="col-lg-12">
																					<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> District / Department <i class="fa fa-caret-down fa-fw"></i></strong>
																				</div>
																				<div class="col-lg-12">
																					<input class="form-control" placeholder="District / Department" name="gym_district" type="text" id="gym_district" maxlength="100"/>
																					<p class="help-block" id="gym_dimsg">Press enter or go button to move to next field.</p>
																				</div>
																				<div class="col-lg-12">&nbsp;</div>
																			</div>
																			<!-- City / Town -->
																			<div class="row">
																				<div class="col-lg-12">
																					<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> City / Town <i class="fa fa-caret-down fa-fw"></i></strong>
																				</div>
																				<div class="col-lg-12">
																					<input class="form-control" placeholder="City / Town" name="gym_city_town" type="text" id="gym_city_town" maxlength="100"/>
																					<p class="help-block" id="gym_citmsg">Press enter or go button to move to next field.</p>
																				</div>
																				<div class="col-lg-12">&nbsp;</div>
																			</div>
																			<!-- Street / Locality -->
																			<div class="row">
																				<div class="col-lg-12">
																					<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Street / Locality <i class="fa fa-caret-down fa-fw"></i></strong>
																				</div>
																				<div class="col-lg-12">
																					<input class="form-control" placeholder="Street / Locality" name="gym_st_loc" type="text" id="gym_st_loc" maxlength="100"/>
																					<p class="help-block" id="gym_stlmsg">Press enter or go button to move to next feild.</p>
																				</div>
																				<div class="col-lg-12">&nbsp;</div>
																			</div>
																			<!-- Address Line -->
																			<div class="row">
																				<div class="col-lg-12">
																					<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Address Line <i class="fa fa-caret-down fa-fw"></i></strong>
																				</div>
																				<div class="col-lg-12">
																					<input class="form-control" placeholder="Address Line" name="gym_addrs" type="text" id="gym_addrs" maxlength="200"/>
																					<p class="help-block" id="gym_admsg">Press enter or go button to move to next field.</p>
																				</div>
																				<div class="col-lg-12">&nbsp;</div>
																			</div>
																			<!-- Zipcode -->
																			<div class="row">
																				<div class="col-lg-12">
																					<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Zipcode <i class="fa fa-caret-down fa-fw"></i></strong>
																				</div>
																				<div class="col-lg-12">
																					<input class="form-control" placeholder="Zipcode" name="gym_zipcode" type="text" id="gym_zipcode" maxlength="25" />
																					<p class="help-block" id="gym_zimsg">Press enter or go button to move to next field.</p>
																				</div>
																				<div class="col-lg-12">&nbsp;</div>
																			</div>
																			<!-- Personal Website -->
																			<div class="row">
																				<div class="col-lg-12">
																					<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Website <i class="fa fa-caret-down fa-fw"></i></strong>
																				</div>
																				<div class="col-lg-12">
																					<input class="form-control" placeholder="Personal Website" name="gym_website" type="text" id="gym_website" maxlength="250" value="http://"/>
																					<p class="help-block" id="gym_wemsg">Press enter or go button to move to next field.</p>
																				</div>
																				<div class="col-lg-12">&nbsp;</div>
																			</div>
																			<!-- Google Map URL -->
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-lg-12">
																			<button type="button" class="btn btn-lg btn-primary btn-block" href="javascript:void(0);" id="addgymBut"><i class="fa fa-upload fa-fw fa-2x"></i> &nbsp;Add</button>
																		</div>
																		<div class="col-lg-12">&nbsp;</div>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-12" id="user_message"></div>
									</div>
									<!-- add gym tab disbaled ---->
								</div>
								<!-- END ADD PROFILE -->
							</div>
							</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<!-- /.col-lg-6 -->
			</div>
			<!--------------------------------------------- Enquiry module-------------------------------------------------------- -->
			<!-- Enquiry add -->
			<div class="row output-panels" id="ctrlEnquiryAdd">
				<h1 class="page-header text-primary">
					<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>enquiry.png" border="0" width="30" height="30"/><label>Add Enquiry</label> </h1>
				<div class="col-lg-12" id="ctEnquiryAdd">
					<!-- Add enquiry start 	-->
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<strong>Please fill the details of the visitor</strong>
								</div>
								<div class="panel-body">
							<form role="form" id="enquiry_form">
								<fieldset>
									<div class="row">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong>Person who referred visitor : </strong>
													</div>
													<div class="col-lg-12">
														<input  id="ref_box" type="text" class="form-control" placeholder="Name - Email id - Cell number" />
														<p class="help-block">This field is not mandatory.</p>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong>Person who handled visitor : </strong>
													</div>
													<div class="col-lg-12">
														<div id="list_handel"></div>
														<input  id="handel_box" type="text" class="form-control" placeholder="Name - Email id - Cell number"/>
														<p class="help-block">This field is not mandatory.</p>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Visitor name : </strong>
													</div>
													<div class="col-lg-12">
														<input name="eq_name" id="eq_name" type="text" class="form-control"/>
														<p class="help-block" id="eq_name_msg">Press tab to move to next field.</p>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Email: </strong>
													</div>
													<div class="col-lg-12">
														<input class="form-control" placeholder="Email ID" name="enq_email" type="text" id="enq_email" maxlength="100"/>
														<p class="help-block" id="enq_em_msgDiv">Press tab to move to next field.</p>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Cell Number: </strong>
													</div>
													<div class="col-lg-12">
														<input class="form-control" placeholder="Cell Number" name="enq_cnumber" type="text" id="enq_cnumber" maxlength="20" />
														<p class="help-block" id="cmsg">Press tab to move to next field.</p>													
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> First follow up : </strong>
													</div>
													<div class="col-lg-12">
														<input name="followup1" type="text" class="form-control"id="followup1" readonly="readonly" />
														<p class="help-block">Press tab to move to next field.</p>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong>Second follow up : </strong>
													</div>
													<div class="col-lg-12">
														<input name="followup2" type="text" class="form-control" id="followup2" readonly="readonly"/>
														<p class="help-block">Press tab to move to next field.</p>
													</div>
												</div>
													<div class="col-lg-4">
													<div class="col-lg-12">
														<strong>Third follow up : </strong>
													</div>
													<div class="col-lg-12">
														<input name="followup3" type="text" class="form-control" id="followup3" readonly="readonly"/>
														<p class="help-block">Press tab to move to next field.</p>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong>How do you know about us : </strong>
													</div>
													<div class="col-lg-12">
														<select name="knowabout" id="knowabout" class="form-control"></select>
														<p class="help-block">This field is not mandatory.</p>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span><label>Interested in :</label></strong>
													</div>
													<div class="col-lg-12">
														<select name="interested" id="interested" class="form-control" multiple rows=1> </select>
														<p class="help-block" id="intval">Press ctrl+click to select multiple.</p>
													</div>
												</div>
													<div class="col-lg-4">
													<div class="col-lg-12">
														<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span><label>Joining probability :</label></strong>
													</div>
													<div class="col-lg-12">
														<select name="jop" id="jop" class="form-control">
															<option value="NULL" selected>Select joining</option>
															<option value="Today"> Today </option>
															<option value="2">After 2 days</option>
															<option value="4">After 4 days</option>
															<option value="7">After a week</option>
															<option value="30">After a month</option>
														</select>
														<p class="help-block">Press tab to move to next field.</p>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong><label>Fitness goal :</label></strong>
													</div>
													<div class="col-lg-12">
														<textarea rows="4" cols="100" id="ft_goal" class="form-control"></textarea>
														<p class="help-block">This field is not mandatory.</p>
													</div>
													<div class="col-lg-12">&nbsp;</div>
												</div>
												<div class="col-lg-4">
													<div class="col-lg-12">
														<strong><label>Comments :</label></strong>
													</div>
													<div class="col-lg-12">
														<textarea rows="4" cols="100" id="comments" class="form-control"></textarea>
														<p class="help-block">This field is not mandatory.</p>
													</div>
													<div class="col-lg-12">&nbsp;</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div id="enq_add_msg"></div>
											<div class="form-group">
												<input type="button" id="enquiry_save" class="btn btn-lg btn-primary btn-block" name="action" value="Save"/>
											</div>
										</div>
									</div>
								</fieldset>
							</form>
						</div>
							</div>
						<!-- Add Profile End 	-->
						</div>
					</div>
				</div>
			</div>
			<!-- Enquiry follow -->
			<div class="row output-panels" id="ctrlEnquiryFollow">
				<h1 class="page-header text-primary"><i class="fa fa-th-list fa-fw fa-x2"></i><label>Manage Follow-ups</label> </h1>
				<div class="row">
					<div class="col-lg-12">
						<div id="profiles"></div>
					</div>
				<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
								<!-- /.panel-heading -->
								<div class="panel-body">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs">
									<li class="active"><a href="#followOutput" id="tFollowTab" data-toggle="tab">Today's follow-ups</a></li>
									<li><a href="#followOutput" id="pFollowTab" data-toggle="tab">Pending follow-ups</a></li>
									<li><a href="#followOutput" id="exFollowTab" data-toggle="tab">Expired follow-ups</a></li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="col-lg-12">&nbsp;</div>
									<div class="tab-pane fade in active" id="followOutput">
										Today
									</div>
								</div>
							</div>
							</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
			</div>
			<!-- Enquiry listall -->
			<div class="row output-panels" id="ctrlEnquiryListAll">
				<h1 class="page-header text-primary"><i class="fa fa-th-list fa-fw"></i><label>List All</label> </h1>
				<div class="col-lg-12" id="ctEnquiryAll">
					<div id="center_loader" style="display:none;"></div>
					<div id="fadebody" class="black_overlay_body"></div>
					<div id="lbchangeimg" class="white_content_body" align="center"></div>
					<!-- search menu -->
					<div class="row">
						<div class="col-lg-12" id="menuHtml"></div>
					</div>
					<!-- /search menu -->
					<!-- search form -->
					<div class="row">
						<div class="col-lg-12" id="searhHtml"></div>
						<div class="col-lg-12">&nbsp;</div>
					</div>
					<!-- /search form -->
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-info">
								<div class="panel-heading">Enquiry view panel</div>
								<div id="ctEnquiryAllOutput" class="panel-body panel-group"></div>
							</div>
						</div>
					</div>
					<!-- /.row -->
					<div class="row">
						<div class="col-lg-12">
							<div id="output_load"></div>
						</div>
					</div>
				</div>
			</div>
			<!--------------------------------------------- customer module-------------------------------------------------------- -->
			<!-- customer add -->
			<div class="row output-panels" id="ctrlCustomerAdd">
			 <h1 class="page-header text-primary"><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_user.png" border="0" width="30" height="30"/><label>Add Customer</label> </h1>
			  <div class="col-lg-12" id="ctCustomerAdd">
			   <form role="form" method="POST" name="userdetails" id="userdetails">
				<fieldset>
					<div class="row">
						<div class="col-lg-12">
							<div id="add_mop_temp">
								<div class="row" id="usr_fee_row_temp_1">
									<div class="col-lg-12">
										<strong><span id="user_fee_msg_temp_1" style="display:none; color:#FF0000; font-size:25px;">*</span>Fee <i class="fa fa-caret-down"></i></strong>
									</div>
									<div class="col-lg-12">
										<div class="form-group">
											<div class="col-md-4" id="mod_pay_temp_01">
												
											</div>
											<div class="col-md-4" id="add_numerbox1">
												<input name="user_fee" type="text" id="user_fee_temp_01" class="form-control"/>											
                                   	<div class="col-md-12" id="add_numerbox_" ></div>									
											</div>
											
											<div class="col-md-4">
												 <button class="btn btn-success  btn-md" id="addfee_plus_"><i class="fa fa-plus fa-fw fa-x2"></i></button>											
											</div>
										</div>
									</div>									
								</div>
								<div class="col-lg-12">&nbsp;</div>
								<div class="row" id="usr_fee_row_temp_">
								   
								</div> 
								<div class="col-lg-12">&nbsp;</div>  
							</div>
						</div>
					</div>
					<div class="row">
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Name <i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<input class="form-control" placeholder="Name" name="cust_name" required type="text" id="cust_name" maxlength="100"/>
									<p class="help-block" id="cust_nmmsg">Press enter or go button to move to next field.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
							<!-- sex -->
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Sex <i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12" id="cust_sexParent">
									
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
							<!-- DOB -->
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Date Of Birth <i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<input name="dob" type="text" class="form-control" id="dateofbirth" placeholder="DOB" readonly="readonly" />
									<p class="help-block" id="gym_dimsg">Press enter or go button to move to next field.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h4>Email IDs, Cell Numbers</h4>
								</div>
								<div class="panel-body">
									<ul class="nav nav-pills">
										<li class="active"><a href="#cademails-pills" data-toggle="tab">Email IDs</a>
										</li>
										<li><a href="#cadcnums-pills" data-toggle="tab">Cell Numbers</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane fade in active" id="cademails-pills">
											<!-- Email ID -->
											<div class="row">
												<div class="col-lg-12">
													<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Email ID <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
													<button class="text-primary btn btn-success  btn-md" id="cadplus_email_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
												</div>
												<div class="col-lg-12" id="cadmultiple_email">
												</div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
										</div>
										<div class="tab-pane fade" id="cadcnums-pills">
											<!-- Cell Number -->
											<div class="row">
												<div class="col-lg-12">
													<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Cell Number <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
													<button class="text-primary btn btn-success  btn-md" id="cadplus_cnumber_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
												
												</div>
												<div class="col-lg-12" id="cadmultiple_cnumber">
												</div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-7">
						<!-- ADDRESS -->
						<div class="panel panel-info">
							<div class="panel-heading">
								<strong>Address</strong>&nbsp;
								<button  type="button" class="text-info btn btn-info  btn-md" type="button" id="addr_show_but" onClick="$('#gym_address_body').show(300);"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
								<button  type="button" class="text-info btn btn-danger  btn-md" type="button" id="addr_hide_but" onClick="$('#gym_address_body').hide(300);"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;
							</div>
							<div class="panel-body" id="gym_address_body" style="display:none;">
								<!-- Country -->
								<div class="row">
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Country <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input class="form-control" placeholder="Country" name="gym_country" required type="text" id="gym_country" maxlength="100"/>
											<p class="help-block" id="gym_comsg">Press enter or go button to move to next field.</p>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
									<!-- State / Province -->
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> State / Province <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input class="form-control" placeholder="State / Province" name="gym_province" required="required" type="text" id="gym_province" maxlength="150" />
											<p class="help-block" id="gym_prmsg">Press enter or go button to move to next field.</p>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
									<!-- District / Department -->
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> District / Department <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input class="form-control" placeholder="District / Department" name="gym_district" required="required" type="text" id="gym_district" maxlength="100"/>
											<p class="help-block" id="gym_dimsg">Press enter or go button to move to next field.</p>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
								</div>
								<div class="row">
									<!-- City / Town -->
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> City / Town <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input class="form-control" placeholder="City / Town" name="gym_city_town" required="required" type="text" id="gym_city_town" maxlength="100"/>
											<p class="help-block" id="gym_citmsg">Press enter or go button to move to next field.</p>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
									<!-- Street / Locality -->
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Street / Locality <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input class="form-control" placeholder="Street / Locality" name="gym_st_loc" type="text" id="gym_st_loc" maxlength="100"/>
											<p class="help-block" id="gym_stlmsg">Press enter or go button to move to next feild.</p>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
									
									<!-- Address Line -->
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Address Line <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input class="form-control" placeholder="Address Line" name="gym_addrs" type="text" id="gym_addrs" maxlength="200"/>
											<p class="help-block" id="gym_admsg">Press enter or go button to move to next field.</p>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
									</div>
								<div class="row">
									<!-- Zipcode -->
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Zipcode <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input class="form-control" placeholder="Zipcode" name="gym_zipcode" required type="text" id="gym_zipcode" maxlength="25" />
											<p class="help-block" id="gym_zimsg">Press enter or go button to move to next field.</p>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
									<!-- Personal Website -->
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Website <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input class="form-control" placeholder="Personal Website" name="gym_website" type="text" id="gym_website" maxlength="250" value="http://"/>
											<p class="help-block" id="gym_wemsg">Press enter or go button to move to next field.</p>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
								<!-- Google Map URL -->
								</div>
							</div>
						</div>
					  </div>
					</div>
					
					<div class="row">
						      <div class="col-lg-4">
								<div class="col-lg-12" id="refergynname">
								</div>
								<div class="col-lg-12">
									<div id="list_ref"></div>
										<input  id="ref_boxadd" type="text" class="form-control" placeholder="11111Name - Email id - Cell number" />
										<p class="help-block" id="cust_rfmsg">Press enter or go button to move to next field.</p>
									    <div class="col-lg-4" id="temp_serach">
									    </div>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
							
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Access ID <i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<input name="user_acs" type="text" class="form-control" value="'.AddAcsId().'" id="user_acs"/>
									<p class="help-block" id="cust_acmsg">Press enter or go button to move to next field.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
							<!-- sex -->
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Company <i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<input name="comp_name" type="text" class="form-control" placeholder="MadMec" id="comp_name"/>
									<p class="help-block" id="customer_cpmsg">Press enter or go button to move to next field.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
							
					</div>
					
					<div class="row">
						<!-- Occupation -->
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Occupation <i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<select  name="user_occ" id="cust_occ" type="text" class="form-control" >
										<option value="student">student</option>
										<option value="professional">professional</option>
										<option value="other">other</option>
								   </select>
									<p class="help-block" id="cust_ocmsg">Press enter or go button to move to next field.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
							
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Emergency name <i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<input name="emer_name" type="text" class="form-control" placeholder="Your family member" id="emer_name"/>
									<p class="help-block" id="cust_acmsg">Press enter or go button to move to next field.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
							<!-- sex -->
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Emergency number <i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<input name="emer_num" type="text" class="form-control"  placeholder="9999999999" maxlength="10" id="emer_num"/>
									<p class="help-block" id="customer_cpmsg">Press enter or go button to move to next field.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<input type="button" class="btn btn-lg btn-success btn-block" value="Save" onClick="javascript:validateUserDetails();"/>
							</div>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
			</div>
			<!-- customer list -->
			<div class="row output-panels" id="ctrlCustomerList">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;List customers
				</h1>
				<div class="col-lg-12" id="ctCustomerList"></div>
			</div>
			<!-- group add add -->
			<div class="row output-panels" id="ctrlCGroupAdd">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_group.png" border="0" width="30" height="30"/>&nbsp;Add Group
				</h1>
				<div class="col-lg-12" id="ctCGroupAdd">
					<div class="row">
		       <div id="loader" class="col-lg-12">
			      <div class="panel panel-primary">
				   <div class="panel-heading">
				      	<h4>Number of members in a group</h4>
				     </div>
                 <div class="row">
					<div class="col-lg-12">&nbsp;</div>                  
                    <div class="col-lg-12">
							<dt>
								<label>&nbsp;&nbsp;&nbsp;Group Type :</label>
							</dt>
							<div class="form-group">
                       								
								<span>
									&nbsp;&nbsp;&nbsp;<input id="group_type_1" type="radio" value="couple" name="group_type1"/>: Couple
								   <br>
								   &nbsp;&nbsp;&nbsp;<input id="group_type_2" type="radio" value="group"  name="group_type1">: Group
								   <br>
								</span>
								<hr>
							</div>
					</div>
                  </div>
                  <div class="row">
					<div class="col-lg-12">&nbsp;</div>                  
                    <div class="col-lg-12">
							<dt>
								<label>&nbsp;&nbsp;&nbsp;Group Owner :</label>
							</dt>
							<div class="form-group">
								<span>
										&nbsp;&nbsp;&nbsp;<input id="group_type_1" checked="" type="radio" value="couple" name="group_type"/>: Customer 1
									<br>
									&nbsp;&nbsp;&nbsp;<input id="group_type_2" type="radio" value="group"  name="group_type">: Customer 2
									<br>
									<div class="form-group" id="group_membership"></div>
								</span>
							</div>
                    </div>
                  </div> 				     
				     <div class="row">
                  <div class="col-lg-12">&nbsp;</div>
						<div class="col-lg-12" id="refergymname"></div>
						<div class="col-lg-12">
							<div id="list_ref"></div>
							<span>
								<input  id="ref_box" type="text" class="form-control" placeholder="Name - Email id - Cell number" />
							</span>
							
						</div>
					</div>
				  <div class="panel-body">
					<form role="form" id="addgroupform" name="addgroupform" method="POST">
						<fieldset>
							<div class="row">
								<div class="col-lg-12">
									<label>Number of members :</label>
								</div>
								<div class="col-lg-12">
								  <div class="bs-example" id="cadmulti_groupmember1" >
								    <div class="panel-group" id="accordion">
									   <div class="panel panel-info">
														<div class="panel-heading">
															<h4 class="panel-title">
																<a data-toggle="collapse" data-parent="#accordion" href="#cadplus_member_1"><label>Customer 1:</label></a>
													</h4>
														</div>
													   <div id="cadplus_member_1" class="panel-collapse collapse">
															<div class="panel-body" id="addgpmem_panel_1">
															 <div class="col-lg-12" id="addgpmem_cols_1">
													   <form role="form" method="POST" name="addgp_memfm_1" id="addgp_memfm_1">
															 <fieldset>
																				<div class="row">
										<div class="col-lg-12">
											<div id="add_mop_temp">
												<div class="row" id="usr_fee_row_temp_1">
													<div class="col-lg-12">
														<strong><span id="user_fee_msg_temp_1" style="display:none; color:#FF0000; font-size:25px;">*</span>Fee <i class="fa fa-caret-down"></i></strong>
													</div>
													<div class="col-lg-12">
														<div class="form-group">
															<div class="col-md-4">
																<select name="mod_pay" id="mod_pay_temp_1" onChange="javascript:ShowTextBox(1,\'temp\');" class="form-control">
																<option value="NULL">Select mode of payment</option>
																<option value="Cash" selected>Cash</option>
																<option value="Card">Card</option>
																<option value="Cheque">Cheque</option>
																<option value="PDC">PDC</option>
																</select>
															</div>
															<div class="col-md-4">
																<input name="user_fee"   type="text" value="'.REG_FEE.'"     id="user_fee_temp_1" class="form-control"/>
																<input name="mod_number_temp_1" type="text" placeholder="PDC number"    id="pdc_no_temp_1"    class="form-control" style="display:none;"/>
																<input name="mod_number_temp_1" type="text" placeholder="Cheque number" id="cheque_no_temp_1" class="form-control" style="display:none;"/>
																<input name="mod_number_temp_1" type="text" placeholder="Card number"   id="card_no_temp_1"   class="form-control" style="display:none;"/>
															</div>
															<div class="col-md-4">
																<a id="addmop_temp_1" class="btn btn-primary  btn-xs" href="javascript:void(0);"  onClick="javascript:AddModeOfPayment(\'temp\',1);$(this).hide();">Add</a>
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
											<strong><span id="un_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Name <i class="fa fa-caret-down"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
												'.$cust_name.'
											</span>
											<p class="help-block">Press enter or go button to move to next field.</p>
										</div>
									</div>
																				<div class="row">
										<div class="col-lg-12">
											<strong>Sex <i class="fa fa-caret-down"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
												<select name="sex" class="form-control" id="user_sex_1">
													<option value="male">male</option>
													<option value="female">female</option>
												</select>
											</span>
											<p class="help-block">Press enter or go button to move to next field.</p>
										</div>
									</div>
																				<div class="row">
										<div class="col-lg-12">
											<strong><span id="dob_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Date of birth <i class="fa fa-caret-down"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
												<input name="dob" type="text" class="form-control" id="dateofbirth_1" placeholder="DOB" readonly="readonly" />
									
											</span>
											<p class="help-block">Press enter or go button to move to next field.</p>
										</div>
									</div>
																				<div class="row">
										<div class="col-lg-12">&nbsp;</div>
										<div class="col-lg-12">
											<div class="panel panel-primary">
												<div class="panel-heading">
													<h4>Email IDs, Cell Numbers</h4>
												</div>
												<div class="panel-body">
													<ul class="nav nav-pills">
														<li class="active"><a href="#cademails-pills" data-toggle="tab">Email IDs</a>
														</li>
														<li><a href="#cadcnums-pills" data-toggle="tab">Cell Numbers</a>
														</li>
													</ul>
													<div class="tab-content">
														<div class="tab-pane fade in active" id="cademails-pills">
															<!-- Email ID -->
															<div class="row">
																<div class="col-lg-12">
																	<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Email ID <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
																	<button class="text-primary btn btn-success  btn-md" id="cadplus_email_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
																</div>
																<div class="col-lg-12" id="cadgpmultiple_email_1">
																</div>
																<div class="col-lg-12">&nbsp;</div>
															</div>
														</div>
														<div class="tab-pane fade" id="cadcnums-pills">
															<!-- Cell Number -->
															<div class="row">
																<div class="col-lg-12">
																	<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Cell Number <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
																	<button class="text-primary btn btn-success  btn-md" id="cadplus_cnumber_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
																
																</div>
																<div class="col-lg-12" id="cadgpmultiple_cnumber_1">
																</div>
																<div class="col-lg-12">&nbsp;</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
																				<div class="row">
										<div class="col-lg-12">
											<strong><span id="user_acs_msg" style="display:none; color:#FF0000; font-size:25px;" >*</span> Access ID <i class="fa fa-caret-down"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
												<input name="user_acs" type="text" class="form-control" value="'.AddAcsId().'" id="group_acs_1"/>
												<span id="acsgp_id_exist_msg"></span>
												<input id="acsgp_id_check_1" type="checkbox" checked="checked" style="display:none;"/>
											</span>
											<p class="help-block">Press enter or go button to move to next field.</p>
										</div>
									</div>
																				<div class="row">
										<div class="col-lg-12">
											<strong>Company <i class="fa fa-caret-down"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
												<input name="comp_name" type="text" class="form-control" placeholder="MadMec" id="compgp_name_1"/>
											</span>
											<p class="help-block">Press enter or go button to move to next field.</p>
										</div>
									</div>
																				<div class="row">
										<div class="col-lg-12">
											<strong>Occupation <i class="fa fa-caret-down"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
											<select  name="group_occ" id="group_occ_1" type="text" class="form-control" >
												<option value="student">student</option>
												<option value="professional">professional</option>
												<option value="other">other</option>
											</select>
											</span>
											<p class="help-block">Press enter or go button to move to next field.</p>
										</div>
									</div>
																				<div class="row">
										<div class="col-lg-12">
											<strong>Emergency name <i class="fa fa-caret-down"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
												<input name="emer_name" type="text" class="form-control" placeholder="Your family member" id="emergp_name_1"/>
											</span>
											<p class="help-block">Press enter or go button to move to next field.</p>
										</div>
									</div>
																				<div class="row">
										<div class="col-lg-12">
											<strong><span id="emr_mob_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Emergency number <i class="fa fa-caret-down"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
												<input name="emer_num" type="text" class="form-control"  placeholder="9999999999" maxlength="10" id="emergp_num_1"/>
											</span>
											<p class="help-block">Press enter or go button to move to next field.</p>
										</div>
									</div>
																				<div class="row">
										<div class="col-lg-12">
											<strong>Address <i class="fa fa-caret-down"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
												profile_address_block
											</span>
											<p class="help-block">Press enter or go button to move to next field.</p>
										</div>
									</div>
									
																		</fieldset>
																	</form>   
																</div>  
														   </div>
													   </div>
				</div>         
										<div class="panel panel-info">
											<div class="panel-heading">
											  <h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#cadplus_member_2"><label>Customer 2:</label></a>
												<button type="button" class="text-primary btn btn-success  btn-md" id="cadplus_groupmember_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;               							
											  </h4>
										   </div>
										   <div id="cadplus_member_2" class="panel-collapse collapse">
											 <div class="panel-body" id="addgpmem_panel_2">
																				 <div class="col-lg-12" id="addgpmem_cols_2">
																		   <form role="form" method="POST" name="addgp_memfm_2" id="addgp_memfm_2">
																				 <fieldset>
																									<div class="row">
															<div class="col-lg-12">
																<div id="add_mop_temp">
																	<div class="row" id="usr_fee_row_temp_1">
																		<div class="col-lg-12">
																			<strong><span id="user_fee_msg_temp_1" style="display:none; color:#FF0000; font-size:25px;">*</span>Fee <i class="fa fa-caret-down"></i></strong>
																		</div>
																		<div class="col-lg-12">
																			<div class="form-group">
																				<div class="col-md-4">
																					<select name="mod_pay" id="mod_pay_temp_1" onChange="javascript:ShowTextBox(1,\'temp\');" class="form-control">
																					<option value="NULL">Select mode of payment</option>
																					<option value="Cash" selected>Cash</option>
																					<option value="Card">Card</option>
																					<option value="Cheque">Cheque</option>
																					<option value="PDC">PDC</option>
																					</select>
																				</div>
																				<div class="col-md-4">
																					<input name="user_fee"   type="text" value="'.REG_FEE.'"     id="user_fee_temp_1" class="form-control"/>
																					<input name="mod_number_temp_1" type="text" placeholder="PDC number"    id="pdc_no_temp_1"    class="form-control" style="display:none;"/>
																					<input name="mod_number_temp_1" type="text" placeholder="Cheque number" id="cheque_no_temp_1" class="form-control" style="display:none;"/>
																					<input name="mod_number_temp_1" type="text" placeholder="Card number"   id="card_no_temp_1"   class="form-control" style="display:none;"/>
																				</div>
																				<div class="col-md-4">
																					<a id="addmop_temp_1" class="btn btn-primary  btn-xs" href="javascript:void(0);"  onClick="javascript:AddModeOfPayment(\'temp\',1);$(this).hide();">Add</a>
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
																<strong><span id="un_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Name <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<span>
																	'.$cust_name.'
																</span>
																<p class="help-block">Press enter or go button to move to next field.</p>
															</div>
														</div>
																									<div class="row">
															<div class="col-lg-12">
																<strong>Sex <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<span>
																	<select name="sex" class="form-control" id="user_sex_2">
																		<option value="male">male</option>
																		<option value="female">female</option>
																	</select>
																</span>
																<p class="help-block">Press enter or go button to move to next field.</p>
															</div>
														</div>
																									<div class="row">
															<div class="col-lg-12">
																<strong><span id="dob_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Date of birth <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<span>
																	<input name="dob" type="text" class="form-control" id="dateofbirth_2" placeholder="DOB" readonly="readonly" />
														
																</span>
																<p class="help-block">Press enter or go button to move to next field.</p>
															</div>
														</div>
																									<div class="row">
															<div class="col-lg-12">&nbsp;</div>
															<div class="col-lg-12">
																<div class="panel panel-primary">
																	<div class="panel-heading">
																		<h4>Email IDs, Cell Numbers</h4>
																	</div>
																	<div class="panel-body">
																		<ul class="nav nav-pills">
																			<li class="active"><a href="#cademails-pills" data-toggle="tab">Email IDs</a>
																			</li>
																			<li><a href="#cadcnums-pills" data-toggle="tab">Cell Numbers</a>
																			</li>
																		</ul>
																		<div class="tab-content">
																			<div class="tab-pane fade in active" id="cademails-pills">
																				<!-- Email ID -->
																				<div class="row">
																					<div class="col-lg-12">
																						<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Email ID <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
																						<button class="text-primary btn btn-success  btn-md" id="cadplus_email_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
																					</div>
																					<div class="col-lg-12" id="cadgpmultiple_email_2">
																					</div>
																					<div class="col-lg-12">&nbsp;</div>
																				</div>
																			</div>
																			<div class="tab-pane fade" id="cadcnums-pills">
																				<!-- Cell Number -->
																				<div class="row">
																					<div class="col-lg-12">
																						<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Cell Number <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
																						<button class="text-primary btn btn-success  btn-md" id="cadplus_cnumber_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
																					
																					</div>
																					<div class="col-lg-12" id="cadgpmultiple_cnumber_2">
																					</div>
																					<div class="col-lg-12">&nbsp;</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-lg-12">&nbsp;</div>
														</div>
																									<div class="row">
															<div class="col-lg-12">
																<strong><span id="user_acs_msg" style="display:none; color:#FF0000; font-size:25px;" >*</span> Access ID <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<span>
																	<input name="user_acs" type="text" class="form-control" value="'.AddAcsId().'" id="group_acs_2"/>
																	<span id="acsgp_id_exist_msg"></span>
																	<input id="acsgp_id_check_2" type="checkbox" checked="checked" style="display:none;"/>
																</span>
																<p class="help-block">Press enter or go button to move to next field.</p>
															</div>
														</div>
																									<div class="row">
															<div class="col-lg-12">
																<strong>Company <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<span>
																	<input name="comp_name" type="text" class="form-control" placeholder="MadMec" id="compgp_name_2"/>
																</span>
																<p class="help-block">Press enter or go button to move to next field.</p>
															</div>
														</div>
																									<div class="row">
															<div class="col-lg-12">
																<strong>Occupation <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<span>
																<select  name="group_occ" id="group_occ_2" type="text" class="form-control" >
																	<option value="student">student</option>
																	<option value="professional">professional</option>
																	<option value="other">other</option>
																</select>
																</span>
																<p class="help-block">Press enter or go button to move to next field.</p>
															</div>
														</div>
																									<div class="row">
															<div class="col-lg-12">
																<strong>Emergency name <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<span>
																	<input name="emer_name" type="text" class="form-control" placeholder="Your family member" id="emergp_name_2"/>
																</span>
																<p class="help-block">Press enter or go button to move to next field.</p>
															</div>
														</div>
																									<div class="row">
															<div class="col-lg-12">
																<strong><span id="emr_mob_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Emergency number <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<span>
																	<input name="emer_num" type="text" class="form-control"  placeholder="9999999999" maxlength="10" id="emergp_num_2"/>
																</span>
																<p class="help-block">Press enter or go button to move to next field.</p>
															</div>
														</div>
																									<div class="row">
															<div class="col-lg-12">
																<strong>Address <i class="fa fa-caret-down"></i></strong>
															</div>
															<div class="col-lg-12">
																<span>
																	profile_address_block
																</span>
																<p class="help-block">Press enter or go button to move to next field.</p>
															</div>
														</div>
													
																							</fieldset>
																						</form>   
																					</div>  
																			   </div>
																		   </div>
									</div>
									   <div id="accordion1"></div>
                           
									</div>
								 </div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
		      </div>
			
		</div>
		
		
					</div>
				</div>
			</div>
			<!-- group list -->
			<div class="row output-panels" id="ctrlCGList">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;List customers
				</h1>
				<div class="col-lg-12" id="ctCGList"></div>
			</div>
			<!-- import customer -->
			<div class="row output-panels" id="ctrlCustomerImport">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;Import customers
				</h1>
				<div class="col-lg-12" id="ctCustomerImport"></div>
			</div>
			<!--------------------------------------------- employee/trainers module-------------------------------------------------------- -->
			<!-- employee/trainers add -->
			<div class="row output-panels" id="ctrlTrainerAdd">
			 <h1 class="page-header text-primary"><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_user.png" border="0" width="30" height="30"/><label>Add Employee</label> </h1>
				<div class="col-lg-12" id="ctTrainerAdd">
					<div class="panel panel-primary">
							<div class="panel-heading">
								<strong>Please fill the details of the Employee</strong>
							</div>
						<div class="panel-body">
							<form role="form" method="POST" name="trainerdetails" id="trainerdetails">
								<fieldset>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<span id="un_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>Name :</label>
													<span>
														<input  name="trainer_name" type="text" class="form-control"  id="trainer_name"/>
														<p class="help-block" id="name_msg">Press tab to move to next field.</p>
													</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label>Sex :</label>
											 		<span>
														<select name="trainer_sex" class="form-control" id="trainer_sex"></select>
														<p class="help-block" id="sex_msg">Press tab to move to next field.</p>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<span id="trainer_facility_msg" style="display:none; color:#FF0000; font-size:25px;"	>*</span>
													<label>Facility Type:</label>
													<span>
														<select name="trainer_facility" id="trainer_facility" class="form-control"> </select>
														<p class="help-block" id="ftype_msg">Press tab to move to next field.</p>
													</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<span id="trn_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>Trainer Type :</label>
													<select name="trainer_gym" id="trainer_gym" class="form-control"> </select>
													<p class="help-block" id="ttype_msg">Press tab to move to next field.</p>
												</div>
											</div>
										</div>	
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<span id="eml_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>E-mail :</label>
													<span>
														<input name="email" type="text" class="form-control" placeholder="ex@example.com" id="trainer_email"/>
														<p class="help-block" id="email_msg">Press tab to move to next field.</p>
													</span>
												</div>
											</div>
											<div class="col-lg-2">
												<div class="form-group">
													<span id="mob_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>Cell code:</label>
													<span>
														<input name="cellcode" type="text" class="form-control"  placeholder="91" maxlength="4" id="cell_code"/>
														<p class="help-block" id="cell_msg"></p>
													</span>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<span id="mob_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>Cell Number :</label>
													<span>
														<input name="mobile" type="text" class="form-control"  placeholder="9999999999" maxlength="10" id="trainer_mobile"/>
														<p class="help-block" id="mobile_msg">Press tab to move to next field.</p>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<strong>Date Of Birth : </strong>
													<input name="dob" type="text" class="form-control" id="dob" readonly="readonly"/>
													<p class="help-block">Press tab to move to next field.</p>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<strong>Date Of Join : </strong>
													<input name="doj" type="text" class="form-control" id="doj" readonly="readonly"/>
													<p class="help-block">Press tab to move to next field.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div id="trainer_add_msg"></div>
											<div class="form-group">
												<input type="button" class="btn btn-lg btn-primary btn-block" value="Save" id="trainerAdd" />
											</div>
										</div>
									</div>
								</fieldset>
							</form>
							<button class="btn btn-primary btn-md" id="photo_but_edit"  data-toggle="modal" data-target="#myModal_Photo" style="display:none;"></button>
							<form action="control.php" name="changePic" id="changePic" method="post" enctype="multipart/form-data">
								 <fieldset>
								 <input type="hidden" name="formid" value="changePic" />
								   	 <input type="hidden" name="action1" value="Changephoto" />
									 <input type="hidden" name="autoloader" value="true" />
									 <input type="hidden" name="type" value="slave" />
									 <input type="hidden" name="photo_id" id="photo_id" value="" />
									 <div class="modal" id="myModal_Photo" tabindex="-1" role="dialog" aria-labelledby="myModal_Photo_Label" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content" style="color:#000;">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title" id="myModal_Photo_Label">Trainer Photo Upload</h4>
											</div>
											<div class="modal-body">
													<!-- begin_picedit_box -->
													<div class="picedit_box">
													    <!-- Placeholder for messaging -->
													    <div class="picedit_message">
													    	 <span class="picedit_control ico-picedit-close" data-action="hide_messagebox"></span>
													        <div></div>
													    </div>
													    <!-- Picedit navigation -->
													    <div class="picedit_nav_box picedit_gray_gradient">
													    	<div class="picedit_pos_elements"></div>
													       <div class="picedit_nav_elements">
																<!-- Picedit button element begin -->
																<div class="picedit_element">
													           	 <span class="picedit_control picedit_action ico-picedit-pencil" title="Pen Tool"></span>
													             	 <div class="picedit_control_menu">
													               	<div class="picedit_control_menu_container picedit_tooltip picedit_elm_3">
													                    <label class="picedit_colors">
													                      <span title="Black" class="picedit_control picedit_action picedit_black active" data-action="toggle_button" data-variable="pen_color" data-value="black"></span>
													                      <span title="Red" class="picedit_control picedit_action picedit_red" data-action="toggle_button" data-variable="pen_color" data-value="red"></span>
													                      <span title="Green" class="picedit_control picedit_action picedit_green" data-action="toggle_button" data-variable="pen_color" data-value="green"></span>
													                    </label>
													                    <label>
													                    	<span class="picedit_separator"></span>
													                    </label>
													                    <label class="picedit_sizes">
													                      <span title="Large" class="picedit_control picedit_action picedit_large" data-action="toggle_button" data-variable="pen_size" data-value="16"></span>
													                      <span title="Medium" class="picedit_control picedit_action picedit_medium" data-action="toggle_button" data-variable="pen_size" data-value="8"></span>
													                      <span title="Small" class="picedit_control picedit_action picedit_small" data-action="toggle_button" data-variable="pen_size" data-value="3"></span>
													                    </label>
													                  </div>
													               </div>
													           </div>
													           <!-- Picedit button element end -->
																<!-- Picedit button element begin -->
																<div class="picedit_element">
																	<span class="picedit_control picedit_action ico-picedit-insertpicture" title="Crop" data-action="crop_open"></span>
													           </div>
													           <!-- Picedit button element end -->
																<!-- Picedit button element begin -->
																<div class="picedit_element">
													           	 <span class="picedit_control picedit_action ico-picedit-redo" title="Rotate"></span>
													             	 <div class="picedit_control_menu">
													               	<div class="picedit_control_menu_container picedit_tooltip picedit_elm_1">
													                    <label>
													                      <span>90° CW</span>
													                      <span class="picedit_control picedit_action ico-picedit-redo" data-action="rotate_cw"></span>
													                    </label>
													                    <label>
													                      <span>90° CCW</span>
													                      <span class="picedit_control picedit_action ico-picedit-undo" data-action="rotate_ccw"></span>
													                    </label>
													                  </div>
													               </div>
													           </div>
													           <!-- Picedit button element end -->
													           <!-- Picedit button element begin -->
													            <div class="picedit_element">
													           	 <span class="picedit_control picedit_action ico-picedit-arrow-maximise" title="Resize"></span>
													             	 <div class="picedit_control_menu">
													               	<div class="picedit_control_menu_container picedit_tooltip picedit_elm_2">
													                    <label>
																			<span class="picedit_control picedit_action ico-picedit-checkmark" data-action="resize_image"></span>
																			<span class="picedit_control picedit_action ico-picedit-close" data-action=""></span>
													                    </label>
													                    <label>
													                      <span>Width (px)</span>
													                      <input type="text" class="picedit_input" data-variable="resize_width" value="0">
													                    </label>
													                    <label class="picedit_nomargin">
													                    	<span class="picedit_control ico-picedit-link" data-action="toggle_button" data-variable="resize_proportions"></span>
													                    </label>
													                    <label>
													                      <span>Height (px)</span>
													                      <input type="text" class="picedit_input" data-variable="resize_height" value="0">
													                    </label>
													                  </div>
													               </div>
													           </div>
													           <!-- Picedit button element end -->
													       </div>
														</div>
														<!-- Picedit canvas element -->
														<div class="picedit_canvas_box">
															<div class="picedit_painter">
																<canvas></canvas>
															</div>
															<div class="picedit_canvas">
																<canvas></canvas>
															</div>
															<div class="picedit_action_btns active">
													          <div class="picedit_control ico-picedit-picture" data-action="load_image"></div>
													          <div class="picedit_control ico-picedit-camera" data-action="camera_open"></div>
													          <div class="center">or copy/paste image here</div>
															</div>
														</div>
														<!-- Picedit Video Box -->
														<div class="picedit_video">
													    	<video autoplay></video>
															<div class="picedit_video_controls">
																<span class="picedit_control picedit_action ico-picedit-checkmark" data-action="take_photo"></span>
																<span class="picedit_control picedit_action ico-picedit-close" data-action="camera_close"></span>
															</div>
													    </div>	
																																<!-- Picedit draggable and resizeable div to outline cropping boundaries -->
													    <div class="picedit_drag_resize">
													    	<div class="picedit_drag_resize_canvas"></div>
															<div class="picedit_drag_resize_box">
																<div class="picedit_drag_resize_box_corner_wrap">
													           	<div class="picedit_drag_resize_box_corner"></div>
																</div>
																<div class="picedit_drag_resize_box_elements">
																	<span class="picedit_control picedit_action ico-picedit-checkmark" data-action="crop_image"></span>
																	<span class="picedit_control picedit_action ico-picedit-close" data-action="crop_close"></span>
																</div>
													       </div>
													    </div>
													</div>
													<!-- end_picedit_box -->
											</div>
											<div class="modal-footer">
												<button type="submit" name="submit" class="btn btn-success" id="addusrBut">Upload Photo</button>
												<button type="button" class="btn btn-success" data-dismiss="modal" id="photoCancel">Cancel</button>
											</div>
										</div>
									</div>
								</div>
								 </fieldset>
							  </form>
						</div>
					</div>
				</div>
				</div>
			</div>
			<!-- employee/trainers list -->
			<div class="row output-panels" id="ctrlTrainerList">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;List Employee
				</h1>
				<div class="col-lg-12" id="ctTrainerList">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<strong>List Employee</strong>
						</div>
						<div class="panel-body">
							<div id="listTrainer"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- employee/trainers Pay-->
			<div class="row output-panels" id="ctrlTrainerPay" style="display:none">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;Pay Employee
				</h1>
				<div class="col-lg-12" id="ctTrainerPay">
					<div class="panel-body text-primary" id="trainerPayoutput">
						<form id="trainer_payform">
						<fieldset name="payments" id="payments">
							<div class="row">
								<div class="col-lg-4">
									<div class="col-lg-12">
										<strong><span id="names_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Name - Email id - Cell number of the staff <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<div id="list_ref"></div>
										<input name="name" type="text" class="form-control" id="trainer_payname" placeholder="Name - Email id - Cell number"/>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<div class="col-lg-4">
									<div class="col-lg-12">
										<strong><span id="amts_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>Amount <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input type="text" name="amount" class="form-control" id="trainer_amount" placeholder="0.00" />
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<div class="col-lg-4">
									<div class="col-lg-12">
										<strong>Date <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<span>
											<input name="pays_date" type="text" class="form-control" id="tra_pay_date" readonly="readonly"/>
										</span>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<strong>Description <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<textarea rows="6" cols="30" id="trainer_description"  class="form-control" placeholder="January salary paid to syed on so and so details..."></textarea>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<input type="button" class="btn-primary btn-lg btn-block" id="trainer_paySave" value="Save"/>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
						</fieldset>
						</form>
						<!-- modal -->
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_pay" id="myModal_btn" style="display: none;"></button>
						<div class="modal fade" id="myModal_pay" tabindex="-1" role="dialog" aria-labelledby="myModal_payfollow" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModal_payfollow"><i class="fa fa-bell fa-fw fa-x2"></i> Alert</h4>
									</div>
									<div class="modal-body" id="myModal_paybody"></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						<!-- modal over -->
					</div>
				</div>
			</div>
			<!-- employee/trainers Import-->
			<div class="row output-panels" id="ctrlTrainerImport">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;Import Employee
				</h1>
				<div class="col-lg-12" id="ctTrainerImport">
					<!-- light box Start -->
<div id="center_loader" style="display:none;"></div>
<div id="fadebody" class="black_overlay_body"></div>
<div id="lbchangeimg" class="white_content_body" align="center"></div>
<!-- light box End -->
<!-- BS integration starts here -->
	
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div id="output">
							<div id="user_import">
								<form role="form" action="control.php" method="post" name="trainerdetailsxls" id="trainerdetailsxls" enctype="multipart/form-data">
									 <input type="hidden" name="action1" value="uploadFile" />
									 <input type="hidden" name="autoloader" value="true" />
									 <input type="hidden" name="type" value="master" />
									<fieldset>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-6">
												<div class="form-group">
													<span id="import_facility_msg" style="display:none; color:#FF0000; font-size:25px;"	>*</span>
													<label>Facility Type:</label>
													<span>
														<select name="import_facility" id="import_facility" class="form-control"> </select>
														<p class="help-block" id="ftype_import_msg">Press tab to move to next field.</p>
													</span>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<span id="import_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>
													<label>Trainer Type :</label>
													<select name="import_gym" id="import_gym" class="form-control"> </select>
													<p class="help-block" id="ttype_import_msg">Press tab to move to next field.</p>
												</div>
											</div>
										</div>	
									</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<span>
														&nbsp;<label>Select a xls file:</label>
														<input type="file" name="xls_users_file">
													</span>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<p>&nbsp;</p><input class="btn btn-lg btn-success btn-block" type="submit" value="Upload File to Server"><p>&nbsp;</p>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12" align="center">
												<div class="progress">
													<div class="bar"></div >
													<div class="percent">0%</div >
												</div>
												<div id="status"></div>
											</div>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.col-lg-12 -->
		</div>
	</div>
				</div>
			</div>
			<!-- --------------------- ctrlManageMK ------------------------------------>
			<div class="row output-panels" id="ctrlMarkAtt">
				<h1 class="page-header text-primary">
					<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>attendance.png" border="0" width="30" height="30"/>Mark Attendance
				</h1>
				  <div class="row">
				     <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <center><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>clock3.gif" border="0" width="40" height="40"/><label><h3>Today's Attendance</label></h3></center>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">
                                <li class="active" style="left:20%"><a href="#customer-pills" data-toggle="tab"><h4>Customer Attendance</h4></a>
                                </li>
                                <li style="left:40%"><a href="#employee-pills" data-toggle="tab"><h4>Employee Attendance</h4></a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="customer-pills">
                                    <div class="col-lg-12">&nbsp;</div>
                                    <div id="AttendCMain">
										<!-- search menu -->
										<div class="row">
											<div class="col-lg-12" id="menuHtml"></div>
										</div>
										<!-- /search menu -->
										<!-- search form -->
										<div class="row">
											<div class="col-lg-12" id="searhHtml"></div>
											<div class="col-lg-12">&nbsp;</div>
										</div>
										<!-- /search form -->
                                       <div class="row">
											<div class="col-lg-12">
												<div id="customer_att" class="table-responsive">
												   	<div class="row">
														<div class="col-lg-12">
															<div class="panel panel-default">
																<div class="panel-heading" id="panelheading">
																	
																</div>
																<!-- /.panel-heading -->
																<div class="panel-body" id="dympanel">
																	<!-- Nav tabs -->
																</div>
																<div class="tab-content" id="panel_div" style="display:none">
																																			
																</div>
																<!-- /.panel-body -->
															</div>
															<!-- /.panel -->
														</div>
														<!-- /.col-lg-6 -->
													  </div>            
												</div>
											</div>
									  </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="employee-pills">
                                   <div class="col-lg-12">&nbsp;</div>
                                    <h4>Employee Attendance</h4>
                                    <div id="AttendEMain">
                                       <div id="employee_att">
                                       
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				  </div>
			</div>
			
			<div class="row output-panels" id="ctrlAddFacility">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_facility2.png" border="0" width="30" height="30"/>Add Facility
				</h1>
				<div class="col-lg-12" id="ctAddFacility">
                <div class="col-lg-12" >
                 <div class="row">
							<div class="col-lg-12">
								<div class="panel panel-danger">
									<div class="panel-heading"><h4><?php echo ucwords($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]).'\'s Club:-';?>&nbsp;<button class="btn btn-success btn-md" id="addfactPLUS"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
									     <button class="btn btn-danger btn-md" id="addfactMINUS"><i class="fa fa-minus fa-fw fa-x2"></i></button>
		                           <button class="btn btn-outline btn-danger" id="hiddenfact" type="button">show Deactive Facility</button>
		                           <button class="btn btn-outline btn-success" id="showallfact" type="button">show Active Facility</button>
									     </h4>
		   						 </div>
					              <div class="panel-body" id="ctctShowFacility">
                             
                             </div>
                          </div>
                         </div>
                        </div>
                </div>           
               <div class="col-lg-12" id="addnewfacility" style="display:none">
                  <div class="panel panel-danger">
                    <div class="panel-heading"><h4>Add New Facility</h4></div>  
		   			<div>
 							<div class="col-lg-12">&nbsp;</div>	
 							<div class="row">
                       <div class="col-lg-4">&nbsp;<label>Facility Name:</label>&nbsp;<input type="text" class="form-control" id="factname"/></div>
                       <div class="col-lg-4" id="showstatus"></div>
                       <div class="col-lg-4"><button id="facilitysave" class="form-control btn btn-success">SAVE</button></div> 							
 							 <div class="col-lg-12">&nbsp;</div>	  
 							</div>
 							   			
		   			</div>                
               </div>				
				</div>
			</div>
			</div>
			
			<div class="row output-panels" id="ctrlAddOffer">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_offers.png" border="0" width="30" height="30"/>Add Offer
				</h1>
				<div class="col-lg-12" id="ctAddOffer">
 		 <div class="row">
			<div class="col-lg-12">
				<div id="output">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a href="javascript:void(0);"><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_offers.png" border="0" width="30" height="30">&nbsp;Add offers</a>
							</h4>
						</div>
						<div class="panel-body">
							<fieldset>
					 <div class="row text-primary">
						<div class="col-lg-12">
							<div id="offer_add">
								<div class="row" id="offer_add">
								      <div class="col-md-6">
							            <label><span id="of_name_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Name :</label>
	 				        	      </div>
	 				        	      <div class="col-md-6">
							            <label><span id="of_duration_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Duration :</label>
	 				        	      </div>
	 					    </div>
	 					  </div>
	 					</div>	 						
	               <div class="form-group">
							<div class="col-md-6">
                        <span><input type="text" name="of_name" id="of_name" class="form-control" placeholder="individual" /><label id="valid_nm"></label></span>
							    <p class="help-block">Press<b> Tab </b>or go button to move to next field.</p>
							</div>
							<div class="col-md-6">
                       <span>
												<select class="form-control" name="of_duration" id="of_duration">
													
												</select>
												<label id="valid_duration"></label>
								</span>
							  <p class="help-block">Press<b> Tab </b>or go button to move to next field.</p>
							</div>
						</div>
					</div>

					<div class="row text-primary">
						<div class="col-lg-12">
							<div id="offer_add">
								<div class="row" id="offer_add">
								      <div class="col-md-6">
							            <label><span id="no_days_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Number of days :</label>
	 				        	      </div>
	 				        	      <div class="col-md-6">
							            <label><span id="of_facility_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Facility type :</label>
											
	 				        	      </div>
	 					    </div>
	 					  </div>
	 					</div>	 						
	               <div class="form-group">
							<div class="col-md-6">
								<span><input type="text" name="of_no_days" id="of_no_days" class="form-control" placeholder="30" /><label id="valid_num"></label></span>
								
                        <p class="help-block">Press<b> Tab </b>or go button to move to next field.</p>							
							</div>
							<div class="col-md-6" id="of_facility_parent">
								<span>
												<select class="form-control" name="of_facility" id="of_facility">
													
												</select>
												<label id="valid_fact"></label>
								</span>
								<p class="help-block">Press<b> Tab </b>or go button to move to next field.</p>
							</div>
						</div>
					</div>
					<div class="row text-primary">
						<div class="col-lg-12">
							<div id="offer_add">
								<div class="row" id="offer_add">
								      <div class="col-md-6">
							            <label><span id="of_prize_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Prizing :</label>
										</div>
	 				        	      <div class="col-md-6">
							           <label><span id="of_member_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Minimum members :</label>
										</div>
	 					    </div>
	 					  </div>
	 					</div>	 						
	               <div class="form-group">
							<div class="col-md-6">
								<span><input type="text" name="of_prize" id="of_prize" class="form-control" placeholder="1000" /><label id="valid_price"></label></span>
								<p class="help-block">Press<b> Tab </b>or go button to move to next field.</p>
							</div>
							<div class="col-md-6">
								<span>
									<select name="of_member" id="of_member" class="form-control">
										<option selected value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
									</select>
									<label id="valid_member"></label>
							   </span>
							   <p class="help-block">Press<b> Tab </b>or go button to move to next field.</p>
							</div>
						</div>
					</div>
					<div class="row text-primary">
						<div class="col-lg-12">
							<div id="offer_add">
								<div class="row" id="offer_add">
								      <div class="col-md-12">
							            <label><span id="no_days_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Description :</label>
											
	 				        	      </div>
	 				        	</div>
	 					  </div>
	 					</div>	 						
	               <div class="form-group">
							<div class="col-md-12">
								<span><textarea placeholder="Details about the offer" name="of_des" id="of_des" rows='5' class="form-control" ></textarea></span>
								<p class="help-block">Press<b> Tab </b>or go button to move to next field.</p>
							</div>
						</div>
						<div class="row show-grid">
                       <div class="col-md-5 col-md-offset-4"><button class="btn btn-success col-md-12" id="offersave"><label><h5>Save</h5></label></button></div>
                  </div>
					</div> 
							</fieldset>
						</div>
					</div>
				</div>
			</div>
					</div>
				</div>
			</div>
			
			<div class="row output-panels" id="ctrlListOffer">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_offers.png" border="0" width="30" height="30"/>List Offer
				</h1>
				<div class="col-lg-12" id="ctListOffer"></div>
			</div>
			
			<div class="row output-panels" id="ctrlAddPackage">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_packages.png" border="0" width="30" height="30"/>Add Package
				</h1>
				<div class="col-lg-12" id="ctAddPackage"></div>
			</div>
		
			<div class="row output-panels" id="ctrlListPackage">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_packages.png" border="0" width="30" height="30"/>List Package
				</h1>
				<div class="col-lg-12" id="ctListPackage"></div>
			</div>
			<!--------------------------------------------- Account Module -------------------------------------------------------- -->
			<!-- Package Fee -->
			<div class="row output-panels" id="ctrlPackageFee">
				<h1 class="page-header text-primary"><i class="fa fa-th-list fa-fw fa-x2"></i><label  id="packageName">Package Payment</label> </h1>
				<div class="row">
					<div class="col-lg-12">
						<div id="profiles"></div>
					</div>
				<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
								<!-- /.panel-heading -->
								<div class="panel-body">
								<!-- Nav tabs -->
								<div  id="dynamicPackage"></div>
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="col-lg-12">&nbsp;</div>
									<div class="tab-pane fade in active" id="tabPackageOutput">
										<!-- light box Start -->
										<div id="pcenter_loader" style="display:none;"></div>
										<div id="pfadebody" class="black_overlay_body"></div>
										<div id="plbchangeimg" class="white_content_body" align="center"></div>
										<!-- light box End -->
										<!-- BS integration starts here -->
											<div class="row">
												<div class="col-lg-12" id="btnListPackage">
													
												</div>
											</div>
											<!-- search menu -->
											<div class="row">
												<div class="col-lg-12" id="pmenuHtml"></div>
											</div>
											<!-- /search menu -->
											<!-- search form -->
											<div class="row">
												<div class="col-lg-12" id="psearhHtml"></div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											<!-- /search form -->
											<div class="row">
												<div class="col-lg-12">
													<div id="listUserPackage"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
			</div>
			<!-- Facility Fee -->
			<div class="row output-panels" id="ctrlFee">
				<h1 class="page-header text-primary"><i class="fa fa-th-list fa-fw fa-x2"></i><label  id="feeName">Manage</label><label>&nbsp;Fee</label> </h1>
				<div class="row">
					<div class="col-lg-12">
						<div id="profiles"></div>
					</div>
				<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
								<!-- /.panel-heading -->
								<div class="panel-body">
								<!-- Nav tabs -->
								<div  id="dynamicFee"></div>
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="col-lg-12">&nbsp;</div>
									<div class="tab-pane fade in active" id="tabFeeOutput">
										<!-- light box Start -->
										<div id="center_loader" style="display:none;"></div>
										<div id="fadebody" class="black_overlay_body"></div>
										<div id="lbchangeimg" class="white_content_body" align="center"></div>
										<!-- light box End -->
										<!-- BS integration starts here -->
											<div class="row">
												<div class="col-lg-12" id="feeSubMenu">
													
												</div>
											</div>
											<!-- search menu -->
											<div class="row">
												<div class="col-lg-12" id="menuHtml"></div>
											</div>
											<!-- /search menu -->
											<!-- search form -->
											<div class="row">
												<div class="col-lg-12" id="searhHtml"></div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											<!-- /search form -->
											<div class="row">
												<div class="col-lg-12">
													<div id="outputfee"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
			</div>
			<!-- due balance -->
			<div class="row output-panels" id="ctrlDueBalance">
				<h1 class="page-header text-primary"><i class="fa fa-th-list fa-fw fa-x2"></i><label>&nbsp;Due/Balance</label> </h1>
				<div class="row">
					<div class="col-lg-12">
						<div id="profiles"></div>
					</div>
				<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
								<!-- /.panel-heading -->
								<div class="panel-body">
								<div class="tab-content">
									<div class="col-lg-12">&nbsp;</div>
									<div class="tab-pane fade in active" id="tabDueBalanceOutput">
										<!-- light box Start -->
										<div id="center_loader" style="display:none;"></div>
										<div id="fadebody" class="black_overlay_body"></div>
										<div id="lbchangeimg" class="white_content_body" align="center"></div>
										<!-- light box End -->
										<!-- BS integration starts here -->
											<div class="row">
												<div class="col-lg-12" id="DueBalanceSubMenu">
													
												</div>
											</div>
											<!-- search menu -->
											<div class="row">
												<div class="col-lg-12" id="menuHtml"></div>
											</div>
											<!-- /search menu -->
											<!-- search form -->
											<div class="row">
												<div class="col-lg-12" id="searhHtml"></div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											<!-- /search form -->
											<div class="row">
												<div class="col-lg-12">
													<div id="outputDueBalance"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
			</div>
			<!-- staff payment -->
			<div class="row output-panels" id="ctrlStaffPay">
				<h1 class="page-header text-primary"><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>pay_trainer.png" border="0" width="30" height="30"/><label>&nbsp;Payments panel</label> </h1>
				<div class="col-lg-12" id="ctStaffPay">
					<div class="panel-body text-primary" id="StaffPayoutput">
						<form id="payform">
						<fieldset name="payments" id="payments">
							<div class="row">
								<div class="col-lg-4">
									<div class="col-lg-12">
										<strong><span id="name_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Name - Email id - Cell number of the staff <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<div id="list_ref"></div>
										<input name="name" type="text" class="form-control" id="payname" placeholder="Name - Email id - Cell number"/>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<div class="col-lg-4">
									<div class="col-lg-12">
										<strong><span id="amt_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>Amount <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<input type="text" name="amount" class="form-control" id="amount" placeholder="0.00" />
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
								<div class="col-lg-4">
									<div class="col-lg-12">
										<strong>Date <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<span>
											<input name="pay_date" type="text" class="form-control" id="st_pay_date" readonly="readonly"/>
										</span>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-12">
										<strong>Description <i class="fa fa-caret-down fa-fw"></i></strong>
									</div>
									<div class="col-lg-12">
										<textarea rows="6" cols="30" id="description"  class="form-control" placeholder="January salary paid to syed on so and so details..."></textarea>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<input type="button" class="btn-primary btn-lg btn-block" id="paySave" value="Save"/>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
						</fieldset>
						</form>
						<!-- modal -->
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_pay" id="myModal_paybtn" style="display: none;"></button>
						<div class="modal fade" id="myModal_pay" tabindex="-1" role="dialog" aria-labelledby="myModal_payfollow" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModal_payfollow"><i class="fa fa-bell fa-fw fa-x2"></i> Alert</h4>
									</div>
									<div class="modal-body" id="myModal_paybody"></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						<!-- modal over -->
					</div>
				</div>
			</div>
			<!-- expenses -->
			<div class="row output-panels" id="ctrlClubExpenses">
			 <h1 class="page-header text-primary"><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_user.png" border="0" width="30" height="30"/><label>Club Expenses</label> </h1>
				<div class="col-lg-12" id="ctClubExpenses">
					<div class="panel-body text-primary">
						<form id="frmexp">
							<fieldset name="expenses" id="expenses">
								<div class="row">
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span id="expnm_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>Name of the receiver <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input name="name" type="text" class="form-control" placeholder="Water supply" id="expname" />
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span id="expamt_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>Amount <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input type="text" name="expamount" class="form-control" id="expamount" placeholder="0.00" />
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong><span id="exprpt_msg" style="display:none; color:#FF0000; font-size:25px;">*</span>Receipt No <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<input type="text" class="form-control" name="exprpt_no" id="exprpt_no" placeholder="00000" />
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong>Date <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<span>
												<input name="exppay_date" type="text" class="form-control" id="exppay_date" readonly="readonly"/>
											</span>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
									<div class="col-lg-4">
										<div class="col-lg-12">
											<strong>Description <i class="fa fa-caret-down fa-fw"></i></strong>
										</div>
										<div class="col-lg-12">
											<textarea rows="6" cols="30" id="expdescription"  class="form-control" placeholder="Two months advance paid to water supply.."></textarea>
										</div>
										<div class="col-lg-12">&nbsp;</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<input type="button" class="btn-primary btn-lg btn-block" id="expsave" value="Save"/>
									</div>
									<div class="col-lg-12">&nbsp;</div>
								</div>
							</fieldset>
						</form>
						<!-- modal -->
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_exp" id="myModal_expbtn" style="display: none;"></button>
						<div class="modal fade" id="myModal_exp" tabindex="-1" role="dialog" aria-labelledby="myModal_expfollow" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModal_expfollow"><i class="fa fa-bell fa-fw fa-x2"></i> Alert</h4>
									</div>
									<div class="modal-body" id="myModal_expbody"></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						<!-- modal over -->
					</div>
				</div>
			</div>
			<!--------------------------------------------- stats module-------------------------------------------------------- -->
			<!-- Accounts -->
			<div class="row output-panels" id="ctrlStAccount">
			 <h1 class="page-header text-primary"><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_user.png" border="0" width="30" height="30"/><label>Accounts</label> </h1>
				<h4 class="page-header"><?php echo date('l jS \of F Y '); ?> Transactions</h4>
				<div class="col-lg-12 table-responsive" id="ctStAccount">
				</div>
			</div>
			<!-- Registrations -->
			<div class="row output-panels" id="ctrlStRegistrations">
				<h1 class="page-header text-primary">
					<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;Registrations
					<h4 class="page-header"><?php echo date('l jS \of F Y '); ?> Customer registrations</h4>
				</h1>
				<div class="col-lg-12" id="ctStRegistrations"></div>
			</div>
			<!-- Customers -->
			<div class="row output-panels" id="ctrlStCustomers">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;Customers
						<h4 class="page-header"><?php echo date('l jS \of F Y '); ?> Customers attendance & Epired customers</h4>
				</h1>
				<div class="col-lg-12" id="ctStCustomers">
					<div class="row">
						
							<div id="StCustomersoutput">
							</div>
						
					</div>
				</div>
				<!-- modal -->
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_cust" id="myModal_custbtn" style="display: none;"></button>
						<div class="modal fade" id="myModal_cust" tabindex="-1" role="dialog" aria-labelledby="myModal_custfollow" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModal_custfollow"><i class="fa fa-bell fa-fw fa-x2"></i> Alert</h4>
									</div>
									<div class="modal-body" id="myModal_custbody"></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						<!-- modal over -->
			</div>
			<!-- employee/trainers -->
			<div class="row output-panels" id="ctrlStEmployee">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;Employee
						<h4 class="page-header"><?php echo date('l jS \of F Y '); ?> Trainers attendance</h4>
				</h1>
				<div class="col-lg-12" id="ctStEmployee">
					<div class="row">
						<div class="col-lg-12">
							<div id="stEmpoutput"></div>
						</div>
					</div>
				</div>
			</div>
			<!--------------------------------------------- Reports module-------------------------------------------------------- -->
			<!-- Club -->
			<div class="row output-panels" id="ctrlRClub">
			 <h1 class="page-header text-primary"><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_user.png" border="0" width="30" height="30"/><label  id="ClubName">Club</label> </h1>
				<div class="col-lg-12" id="ctRClub">
					<div class="panel panel-default">
								<!-- /.panel-heading -->
								<div class="panel-body">
								<!-- Nav tabs -->
								<div  id="dynamicFees"></div>
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="col-lg-12">&nbsp;</div>
									<div class="tab-pane fade in active" id="tabFeeOutputClub">
										<!-- light box Start -->
										<div id="center_loader" style="display:none;"></div>
										<div id="fadebody" class="black_overlay_body"></div>
										<div id="lbchangeimg" class="white_content_body" align="center"></div>
										<!-- light box End -->
										<!-- BS integration starts here -->
											<div class="row">
												<div class="col-lg-12" id="ClubSubMenu">
													
												</div>
											</div>
											<!-- search menu -->
											<div class="row">
												<div class="col-lg-12" id="menuHtml"></div>
											</div>
											<!-- /search menu -->
											<!-- search form -->
											<div class="row">
												<div class="col-lg-12" id="searhHtml"></div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											<!-- /search form -->
											<div class="row">
												<div class="col-lg-12">
													<div id="outputreport">
														<div class="panel-body" id="ff">
															<form id="reportform">
															<div class="form-group">
																<label>From :</label>
																<input name="rptdatefrom" type="text" class="form-control" id="rptdatefrom" placeholder="Date"/>
																<span class="text-success" >
																	<input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
																</span>
															</div>
															<div class="form-group">
																<label>To :</label><input name="rptdateto" type="text" class="form-control" id="rptdateto" placeholder="Date" />
																<span class="text-success">
																	<input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
																</span>
															</div>
															<div class="form-group">
																<input type="button" class="btn btn-lg btn-success btn-block" name="genrep" id="genrep" value="Generate" />
															</div>
															</form>
														</div>
													</div>
												</div>
												<div class="col-lg-12" id="fromToTitle"><h2>Select Facility to generate report</h2></div>
												<div class="col-lg-12" id="Television"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
				</div>
			</div>
			<!-- Package -->
			<div class="row output-panels" id="ctrlRPackage">
				<h1 class="page-header text-primary"><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>package_collection.png" border="0" width="30" height="30"/><label  id="PackageName">&nbsp;Package</label>
				</h1>
				<div class="col-lg-12" id="ctRPackage">
					<!-- package form start -->
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div>
										<div class="panel-body" id="ff">
											<form id="pacform"> <!-- form id-->
												<div class="form-group">
													<label>From :</label>
													<input name="pacdate1" type="text" class="form-control" id="pacdate1" placeholder="Date"/><!-- date1 id-->
													<span class="text-success" >
														<input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<label>To :</label>
													<input name="pacdate2" type="text" class="form-control" id="pacdate2" placeholder="Date" /><!-- date2 id-->
													<span class="text-success">
														<input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<input type="button" class="btn btn-lg btn-success btn-block" name="genrep" id="pacbutton" value="Generate" /><!--form btn id-->
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-lg-12" id="pacOutput"></div><!--output id-->
							</div>
						</div>
					</div>
					<!-- reg form over -->
				
				
				</div>
			</div>
			<!-- Registrations -->
			<div class="row output-panels" id="ctrlRRegistrations">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>registration.png" border="0" width="30" height="30"/>
						<label>Registrations</label></h1>
				<div class="col-lg-12" id="ctRRegistrations">
					<!-- reg form start -->
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div>
										<div class="panel-body" id="ff">
											<form id="regform"> <!-- form id-->
												<div class="form-group">
													<label>From :</label>
													<input name="regdate1" type="text" class="form-control" id="regdate1" placeholder="Date"/><!-- date1 id-->
													<span class="text-success" >
														<input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<label>To :</label>
													<input name="regdate2" type="text" class="form-control" id="regdate2" placeholder="Date" /><!-- date2 id-->
													<span class="text-success">
														<input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<input type="button" class="btn btn-lg btn-success btn-block" name="genrep" id="regbutton" value="Generate" /><!--form btn id-->
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-lg-12" id="regOutput"></div><!--output id-->
							</div>
						</div>
					</div>
					<!-- reg form over -->
				</div>
			</div>
			<!-- Payments -->
			<div class="row output-panels" id="ctrlRPayments">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>pay_trainer.png" border="0" width="30" height="30"/>
						<label>Payments</label></h1>
				<div class="col-lg-12" id="ctRPayments">
					<!-- payments form start -->
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div>
										<div class="panel-body" id="ff">
											<form id="payform"> <!-- form id-->
												<div class="form-group">
													<label>From :</label>
													<input name="paydate1" type="text" class="form-control" id="paydate1" placeholder="Date"/><!-- date1 id-->
													<span class="text-success" >
														<input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<label>To :</label>
													<input name="paydate2" type="text" class="form-control" id="paydate2" placeholder="Date" /><!-- date2 id-->
													<span class="text-success">
														<input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<input type="button" class="btn btn-lg btn-success btn-block" name="genrep" id="paybutton" value="Generate" /><!--form btn id-->
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-lg-12" id="payOutput"></div><!--output id-->
							</div>
						</div>
					</div>
					<!-- pay form over -->
				</div>
			</div>
			<!-- Expenses -->
			<div class="row output-panels" id="ctrlRExpenses">
			 <h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>expenses.png" border="0" width="30" height="30"/>
						<label>Expenses</label> </h1>
				<div class="col-lg-12" id="ctRExpenses">
						<!-- Expences form start -->
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div>
										<div class="panel-body" id="ff">
											<form id="expform"> <!-- form id-->
												<div class="form-group">
													<label>From :</label>
													<input name="expdate1" type="text" class="form-control" id="expdate1" placeholder="Date"/><!-- date1 id-->
													<span class="text-success" >
														<input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<label>To :</label>
													<input name="expdate2" type="text" class="form-control" id="expdate2" placeholder="Date" /><!-- date2 id-->
													<span class="text-success">
														<input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<input type="button" class="btn btn-lg btn-success btn-block" name="genrep" id="expbutton" value="Generate" /><!--form btn id-->
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-lg-12" id="expOutput"></div><!--output id-->
							</div>
						</div>
					</div>
					<!-- pay form over -->
				</div>
			</div>
			<!-- Balance Sheet -->
			<div class="row output-panels" id="ctrlRBalanceSheet">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>profit_loss.png" border="0" width="30" height="30"/>&nbsp;Balance Sheet
				</h1>
				<div class="col-lg-12" id="ctRBalanceSheet">
							<!-- Balance form start -->
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div>
										<div class="panel-body" id="ff">
											<form id="balform"> <!-- form id-->
												<div class="form-group">
													<label>From :</label>
													<input name="baldate1" type="text" class="form-control" id="baldate1" placeholder="Date"/><!-- date1 id-->
													<span class="text-success" >
														<input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<label>To :</label>
													<input name="baldate2" type="text" class="form-control" id="baldate2" placeholder="Date" /><!-- date2 id-->
													<span class="text-success">
														<input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<input type="button" class="btn btn-lg btn-success btn-block" name="genrep" id="balbutton" value="Generate" /><!--form btn id-->
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-lg-12" id="balOutput"></div><!--output id-->
							</div>
						</div>
					</div>
					<!-- pay form over -->
				</div>
			</div>
			<!-- Customers -->
			<div class="row output-panels" id="ctrlRCustomers">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>customer_attendance.png" border="0" width="30" height="30"/>&nbsp;Customers
				</h1>
				<div class="col-lg-12" id="ctRCustomers">
					<!-- customer form start -->
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div>
										<div class="panel-body" id="ff">
											<form id="custform"> <!-- form id-->
												<div class="form-group">
													<label>From :</label>
													<input name="custdate1" type="text" class="form-control" id="custdate1" placeholder="Date"/><!-- date1 id-->
													<span class="text-success" >
														<input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<label>To :</label>
													<input name="custdate2" type="text" class="form-control" id="custdate2" placeholder="Date" /><!-- date2 id-->
													<span class="text-success">
														<input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<input type="button" class="btn btn-lg btn-success btn-block" name="custrep" id="custbutton" value="Generate" /><!--form btn id-->
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-lg-12" id="custOutput"></div><!--output id-->
							</div>
						</div>
					</div>
					<!-- reg form over -->
				
				</div>
			</div>
			<!-- Employee -->
			<div class="row output-panels" id="ctrlREmployee">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>trainer_attendance.png" border="0" width="30" height="30"/>&nbsp;Employee
				</h1>
				<div class="col-lg-12" id="ctREmployee">
					<!-- Employee form start -->
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div>
										<div class="panel-body" id="ff">
											<form id="empform"> <!-- form id-->
												<div class="form-group">
													<label>From :</label>
													<input name="empdate1" type="text" class="form-control" id="empdate1" placeholder="Date"/><!-- date1 id-->
													<span class="text-success" >
														<input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<label>To :</label>
													<input name="empdate2" type="text" class="form-control" id="empdate2" placeholder="Date" /><!-- date2 id-->
													<span class="text-success">
														<input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
													</span>
												</div>
												<div class="form-group">
													<input type="button" class="btn btn-lg btn-success btn-block" name="emprep" id="empbutton" value="Generate" /><!--form btn id-->
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-lg-12" id="empOutput"></div><!--output id-->
							</div>
						</div>
					</div>
					<!-- reg form over -->
				</div>
			</div>
			<!--Receipts -->
			<div class="row output-panels" id="ctrlRReceipts">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>receipts.png" border="0" width="30" height="30"/>&nbsp;Receipts
				</h1>
				<div class="col-lg-12" id="ctRReceipts">
							<!--start-->
							
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h1>Receipts</h1>
										</div>
										<div class="panel-body">
											<div class="form-group">
												<input id="by_name_o_email" name="by_name_o_email" type="text" class="form-control" placeholder="Name Or Email" />
												<input id="by_date" name="by_date"  type="text" class="form-control" placeholder="Date" /><br />
												<button type ="button" class="btn btn-lg btn-success btn-block" id="receiptButton" /><i class="fa fa-search fa-fw"></i>Search</button>
											</div>
										</div>
									</div>
								</div>
							
								<div class="col-lg-12" id="rec_output_load"></div>
								<div class="col-lg-12" id="rec_output"></div><!--receipt display-->
								<div class="col-lg-12" id="rec_output_display"></div>
							<!--End-->
				</div>
			</div>
			<!--------------------------------------------- CRM module-------------------------------------------------------- -->
			<!-- Mobile App -->
			<div class="row output-panels" id="ctrlCRMAPP">
				<div  class="page-header text-primary">
					<h1 class="col-lg-4"><img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>add_user.png" border="0" width="30" height="30"/>
					&nbsp;<label id="crmtitle"></label> </h1>
				</div>
				<div class="col-lg-12" id="ctCRMAPP">
					<div class="row">
			<div class="col-lg-12">
				<ul class="nav navbar-top-links navbar-right">
					<!-- /.dropdown -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							 SEARCH <i class="fa fa-search"></i>&nbsp;
							 <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-messages" id="search_type">
							<li>
								<a href="javascript:void(0);" class="srch_type">Personal</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="srch_type">Offer</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="srch_type">package</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="srch_type">Date</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="srch_type">All</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="srch_type">Hide</a>
							</li>
						</ul>
						<!-- /.dropdown-messages -->
					</li>
					<!-- /.dropdown -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							MESSAGES <i class="fa fa-envelope"></i>&nbsp;
							 <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user" id="MSGmenu">
							
						</ul>
						<!-- /.dropdown-user -->
					</li>
					<!-- /.dropdown -->
				</ul>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<div class="row">
			<div class="col-lg-12">
				<table class="table table-striped table-bordered table-hover" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
					<tr id="Personal_ser" class="ser_crit">
						<td>
							Search according to :
							<input class="stext" type="text"  placeholder="Name" id="user_name"/>&nbsp;
							<input class="stext" type="text"  placeholder="Mobile" id="user_mobile"/>&nbsp;
							<input class="stext" type="text"  placeholder="Email" id="user_email"/>&nbsp;
							<input id="Personal_ser_but" type="button" class="sbuttons btn btn-success" value="Search"/>
						</td>
					</tr>
					<tr id="Offer_ser" class="ser_crit">
						<td>
							Search according to :
							<select id="offer_opt" class="stext" style="width:250px;">
								<option value="NULL" selected="selected"> Select facility </option>
								<option value="Gym">Gym</option>
								<option value="Aerobics">Aerobics</option>
								<option value="Dance">Dance</option>
								<option value="Zumba">Zumba</option>
								<option value="Yoga">Yoga</option>
							</select>
							<select id="offer_dur" class="stext" style="width:250px;">
								<option value="NULL" selected="selected"> Select duration </option>
								<option value="monthly">Monthly</option>
								<option value="quarterly">Quarterly</option>
								<option value="half yearly">Half yearly</option>
								<option value="Annually">Annually</option>
							</select>
							<input id="Offer_ser_but" type="button" class="sbuttons btn btn-success" value="Search"/>
						</td>
					</tr>
					<tr id="package_ser" class="ser_crit">
						<td>
							Search according to :
							<select id="pack_opt" class="stext" style="width:250px;">
								<option value="NULL" selected="selected"> Select package </option>
								<option value="Personal training">Personal training</option>
								<option value="Nutrition counselling">Nutrition counselling</option>
								<option value="Fitness assessment">Fitness assessment</option>
							</select>
							<input id="package_ser_but" type="button" class="sbuttons btn btn-success" value="Search"/>
						</td>
					</tr>
					<tr id="Date_ser" class="ser_crit">
						<td>
							Search according to :
							<input class="stext" type="text"  placeholder="Joining date" id="jnd"/>
							<input class="stext" type="text"  placeholder="Expiry date"  id="exp_date"/> :
							<input id="Date_ser_but" type="button" class="sbuttons btn btn-success" value="Search"/>
						</td>
					</tr>
					<tr id="All_ser" class="ser_crit">
						<td>
							<p>Search according to :</p>
							<p>
							<input class="stext" type="text"  placeholder="Name" id="user_name_all"/>&nbsp;
							<input class="stext" type="text"  placeholder="Mobile" id="user_mobile_all"/>&nbsp;
							<input class="stext" type="text"  placeholder="Email" id="user_email_all"/>&nbsp;
							</p>
							<p>
							<select id="offer_opt_all" class="stext" style="width:250px;">
								<option value="NULL" selected="selected"> Select facility </option>
								<option value="Gym">Gym</option>
								<option value="Aerobics">Aerobics</option>
								<option value="Dance">Dance</option>
								<option value="Zumba">Zumba</option>
								<option value="Yoga">Yoga</option>
							</select>
							<select id="offer_dur_all" class="stext" style="width:250px;">
								<option value="NULL" selected="selected"> Select duration </option>
								<option value="monthly">Monthly</option>
								<option value="quarterly">Quarterly</option>
								<option value="half yearly">Half yearly</option>
								<option value="Annually">Annually</option>
							</select>
							</p>
							<p>
							<select id="pack_opt_all" class="stext" style="width:250px;">
								<option value="NULL" selected="selected"> Select package </option>
								<option value="Personal training">Personal training</option>
								<option value="Nutrition counselling">Nutrition counselling</option>
								<option value="Fitness assessment">Fitness assessment</option>
							</select>
							</p>
							<p>
							<input class="stext" type="text"  placeholder="Joining date" id="jnd_all"/>
							<input class="stext" type="text"  placeholder="Expiry date"  id="exp_date_all"/>
							</p>
							<input id="All_ser_but" type="button" class="sbuttons btn btn-success" value="Search"/>
						</td>
					</tr>
				</table>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<div class="row">
			<div class="col-lg-12" id="app_msg_panel">
				<!-- Generate a compose form for all the customer -->
				<div id="createMessage" class="crm_butt" style="display:none;"></div>
				<!-- Generate a compose form for the expired customer -->
				<div id="exp_cust" class="crm_butt" style="display:none;"></div>
				<!-- Generate a compose form for the follow-ups customers -->
				<div id="follow_cust" class="crm_butt" style="display:none;"></div>
				<!-- Display the crm statistics -->
				<div id="crm_statistics" class="crm_butt" style="display:none;"></div>
				<!-- Generate the compose form for the active customer tracker -->
				<div id="tracker_cust" class="crm_butt" style="display:none;"></div>
				<!-- Display the result of the actions -->
				<div id="message_reslut" class="crm_butt" style="display:none;"></div>
				<!-- List all the customer who have received the message  -->
				<div id="listMessage" class="crm_butt" style="display:none;"></div>
				<!-- Display the individual message -->
				<div id="show_messages" class="crm_butt" style="display:none;"></div>
				<div id="output_load" style="padding:5px 5px 5px 5px;" ></div>
				<div id="output_new_load"></div>
				<!-- <div id="list_msg_users"></div> -->
			</div>
			<!-- /.col-lg-12 -->
		</div>
	
				</div>
			</div>
			<!-- Feedbacks -->
			<div class="row output-panels" id="ctrlCRMFeedback">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;Feedbacks
				</h1>
				<div class="col-lg-12" id="ctCRMFeedback">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">Feedback panel</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
									<!-- Nav tabs -->
									<ul class="nav nav-tabs">
										<li class="active"><a href="#list_feedbacks" data-toggle="tab">List</a></li>
										<li><a href="#formload"  id ="feedback_form" data-toggle="tab">Feedback</a></li>
										<li><a href="#messages"  id ="total_msg"data-toggle="tab">Stats</a></li>
									</ul>
									<!-- Tab panes -->
									<div class="tab-content">
										<div class="tab-pane fade in active" id="list_feedbacks">
											<p>
												<div id="output_load1">
												</div>
												<div id="app_msg_history" style="padding:10px;">
													<table border="0" width="100%">
													</table>
												</div>
												<div id="app_msg_history_ind" style="padding:10px;">
													<table border="0" width="100%">
													</table>
												</div>
												<div id="app_msg_view">
													<div id="app_msg_view_head">
													</div>
													<div id="app_msg_view_body">
														Loading....
													</div>
												</div>
											</p>
										</div>
											<div class="tab-pane fade" id="formload">
												<div id="output_load2"></div>
												<div id="LoadFeedbackForm">&nbsp;</div>
												<div id="msgdiv"></div>
										</div>
										<div class="tab-pane fade" id="messages">
											&nbsp; &nbsp;<div id="output_total"></div>
										</div>
									</div>
								</div>
								<!-- /.panel-body -->
							</div>
							<!-- /.panel -->
						</div>
						<!-- /.col-lg-6 -->
					</div>
				</div>
			</div>
			<!-- Expiry Intimation -->
			<div class="row output-panels" id="ctrlCRMExpiry">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="<?php echo URL.ASSET_IMG.ICON_THEME;?>list_users.png" border="0" width="30" height="30"/>&nbsp;Expiry Intimation
				</h1>
				<div class="col-lg-12" id="ctCRMExpiry"></div>
			</div>
			<!--  all menu print divs output div over -->
		</div>
	</div>
</div>
<script src="<?php echo URL.ASSET_JSF; ?>control.js" language="javascript" charset="UTF-8" ></script>
