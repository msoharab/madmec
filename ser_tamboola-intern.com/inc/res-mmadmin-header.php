<!DOCTYPE html>
<html lang="en">
<div id="page-loader" style="margin:auto;position:relative;width:98%;height:98%;padding:20% 20% 20% 20%;">
<!--
<img class="img-circle" src="<?php echo URL.ASSET_IMG?>/spinner_grey_120.gif" border="0" width="150" height="150" />
-->
<h1>Thambola ver 3.0</h1>
</div>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="madmec-three" >
    <title><?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"])	?	$_SESSION["USER_LOGIN_DATA"]["USER_NAME"]	:	"MADMEC"	)?></title>
    <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery-1.11.0.js"></script>
	<link rel="shortcut icon" href="<?php echo URL.ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
	<link rel="icon" href="<?php echo URL.ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
</head>
<body style="display:none;">
<div id="wrapper">
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<!-- <a href="#" class="navbar-brand"><i class="menubtn fa fa-bars fa-2x"></i></a>  -->
		<a class="navbar-brand" href="<?php echo URL; ?>">Thambola</a>
	</div>
	<!-- /.navbar-header -->
	<ul class="nav navbar-top-links navbar-right">

		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-bell fa-fw"></i>  <span id="alert_count">( 0 )</span> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.ADMIN.'enquiry/list_today_enquiries.php'; ?>';">
						<div>
							Enquiry follow-ups
							<span class="pull-right text-muted small"><span id="fol_count">( 0 )</span></span>
						</div>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.ADMIN.'stats/customer_stats.php'; ?>';">
						<div>
							Expired customers
							<span class="pull-right text-muted small"><span id="exp_count">( 0 )</span></span>
						</div>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.ADMIN.'stats/no_show.php'; ?>';">
						<div>
							No show customers
							<span class="pull-right text-muted small"><span id="track_count">( 0 )</span></span>
						</div>
					</a>
				</li>
			</ul>
			<!-- /.dropdown-alerts -->
		</li>
		<!-- /.dropdown -->
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user"></i><i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a href="javascript:void(0);" id="profile" class="toggletop menuAL">
						<i class="fa fa-user"></i> Profile
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" onclick="window.open('http://cms.madmec.com/help.php');">
						<i class="fa fa-info-circle"></i> Help
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.'logout.php'; ?>';">
						<i class="fa fa-sign-out fa-fw fa-x2"></i> Logout
					</a>
				</li>
			</ul>
			<!-- /.dropdown-user -->
		</li>
		<!-- /.dropdown -->
	</ul>
	<div class="navbar-default" role="navigation" id="sidebar">
		<div class="sidebar-nav navbar-collapse sidebar gray-skin">
			<ul class="nav" id="side-menu">
				<li class="bt-side text-center">
					<img src="<?php echo USER_ANON_IMAGE ?>" class="img-circle" width="150"/>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="gym" class="atleftmenu">Gym</a>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="link1" class="atleftmenu">Link1</a>
				</li>
				<li class="bt-side">
					<a href="javascript:void(0);" id="link2" class="atleftmenu">Link2</a>
				</li>
				<li id="dummy" class="bt-side text-center">
					<h4 class="text-danger">
						Version 3.0
					</h4>
				</li>
			</ul>
		</div>
	</div>
</nav>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12" id="output">
			<div class="col-lg-12" id="centerLoad" style="position:fixed;top:50%;left:50%;opacity:0.5;z-index:99;color:black;"></div>
			<div class="row output-panels" id="pgym">
				<div class="col-lg-12">&nbsp;</div>
				<ul class="nav nav-tabs" id="user_menu">
					<li class="active"><a href="#add_new_usr" data-toggle="tab" id="addusrbut">Add User</a></li>
					<li><a href="#add_new_gym" data-toggle="tab" id="addgymtab">Add Gym</a></li>
					<li><a href="#list_gym" data-toggle="tab" id="listgymsbut">List Client</a></li>
				</ul>
				<div class="col-lg-12">&nbsp;</div>
				<div class="tab-content">
					<div class="tab-pane fade in active" id="add_new_usr">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4>Add New User</h4>
									</div>
										<div class="panel-body" id="acrdaddgym">
<!--
										<form id="addusrForm" enctype='multipart/form-data'>
-->
										<form action="Tamboola" name="addusrForm" id="addusrForm" method="post" onSubmit="return false" enctype="multipart/form-data">
											<fieldset>
												<input type="hidden" name="formid" value="addusrForm" />
												<input type="hidden" name="action1" value="clientAdd" />
												<input type="hidden" name="autoloader" value="true" />
												<input type="hidden" name="type" value="master" />
											<div class="row">
													<div class="col-lg-4">
														<div class="col-lg-12">
															<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Name <i class="fa fa-caret-down fa-fw"></i></strong>
														</div>
														<div class="col-lg-12">
															<input class="form-control" placeholder="Name" required="required" pattern='^[-a-zA-Z ]+$' name="user_name" type="text" id="u_user_name" maxlength="100"/>
															<p class="help-block" id="user_comsg">Press enter or go button to move to next field.</p>
														</div>
														<div class="col-lg-12">&nbsp;</div>
													</div>
													<!-- dob -->
													<div class="col-lg-4">
														<div class="col-lg-12">
															<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Date of birth <i class="fa fa-caret-down fa-fw"></i></strong>
														</div>
														<div class="col-lg-12">
															<input class="form-control" placeholder="YY-MM-DD" name="user_dob" type="text" id="user_dob" required="required" maxlength="100" readonly/>
															<p class="help-block" id="user_dob_msg">Press enter or go button to move to next field.</p>
														</div>
														<div class="col-lg-12">&nbsp;</div>
													</div>
													<!-- gender -->
													<div class="col-lg-4">
														<div class="col-lg-12">
															<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Gender <i class="fa fa-caret-down fa-fw"></i></strong>
														</div>
														<div class="col-lg-12">
															<select id="u_user_gender" name="user_gender" class="form-control">
																<option value="1">Male</option>
																<option value="2">Female</option>
																<option value="3">Other</option>
															</select>
															<p class="help-block" id="usr_dimsg">Press enter or go button to move to next field.</p>
														</div>
														<div class="col-lg-12">&nbsp;</div>
													</div>
												</div>
											<div class="row">
												<div class="col-lg-12">&nbsp;</div>
												<div class="col-lg-12">
													<div class="panel panel-primary">
														<div class="panel-heading">
															<h4>Email IDs, Cell Numbers, Documents</h4>
														</div>
														<div class="panel-body">
															<ul class="nav nav-pills">
																<li class="active"><a href="#usremails-pills" data-toggle="tab">Email IDs</a></li>
																<li><a href="#usrcnums-pills" data-toggle="tab">Cell Numbers</a></li>
																<li><a href="#usrdocs-pills" data-toggle="tab">Documents</a></li>
															</ul>
															<div class="tab-content">
																<div class="tab-pane fade in active" id="usremails-pills">
																	<!-- Email ID -->
																	<div class="row">
																		<div class="col-lg-12">
																			<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Email ID <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
																			<button type="button" class="text-primary btn btn-success  btn-md" id="usrplus_email_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
																		</div>
																		<div class="col-lg-12" id="usrmultiple_email">
																		</div>
																		<div class="col-lg-12">&nbsp;</div>
																	</div>
																</div>
																<div class="tab-pane fade" id="usrcnums-pills">
																	<!-- Cell Number -->
																	<div class="row">
																		<div class="col-lg-12">
																			<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Cell Number <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;
																			<button  type="button" class="text-primary btn btn-success  btn-md" id="usrplus_cnumber_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;
																		</div>
																		<div class="col-lg-12" id="usrmultiple_cnumber">
																		</div>
																		<div class="col-lg-12">&nbsp;</div>
																	</div>
																</div>
																<div class="tab-pane fade" id="usrdocs-pills">
																	<!-- Documents -->
																	<div class="col-lg-3">
																		<div class="col-lg-12">
																			<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Documents Type <i class="fa fa-caret-down fa-fw"></i></strong>
																		</div>
																		<div class="col-lg-12">
																			<select id="u_doc_type" name="doc_type" class="form-control">
																				<option>Driver's license</option>
																				<option>Passport</option>
																				<option>Rations Cards</option>
																				<option>Gas Connection Bill</option>
																				<option>Electricity bill</option>
																				<option>Voter ID card</option>
																				<option>National Identification Number. </option>
																			</select>
																			<p class="help-block" id="user_comsg">Press enter or go button to move to next field.</p>
																		</div>
																		<div class="col-lg-12">&nbsp;</div>
																	</div>
																	<!-- document number -->
																	<div class="col-lg-3">
																		<div class="col-lg-12">
																			<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Document Number <i class="fa fa-caret-down fa-fw"></i></strong>
																		</div>
																		<div class="col-lg-12">
																			<input class="form-control" placeholder="Document Number" required name="doc_number" type="text" id="u_doc_number" maxlength="100"/>
																			<p class="help-block" id="doc_num_msg">Press enter or go button to move to next field.</p>
																		</div>
																		<div class="col-lg-12">&nbsp;</div>
																	</div>
																	
																	<div class="col-lg-6">
																		<div class="col-lg-12">
																			<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Upload Document <i class="fa fa-caret-down fa-fw"></i></strong>
																		</div>
																		<div class="col-lg-12">
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
																			
																			<p class="help-block" id="doc_num_msg">Press enter or go button to move to next field.</p>
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
<!--
													<button class="btn btn-lg btn-primary btn-block" href="javascript:void(0);" id="addusrBut"><i class="fa fa-upload fa-fw fa-2x"></i> &nbsp;Add</button>
-->
						           <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block" id="addusrBut"><i class="fa fa-upload fa-fw fa-2x"></i> &nbsp; Save</button>
												</div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											</fieldset>
										</form>
									</div>
								</div>
							</div>
						</div>
						
					</div> 
					<!-- add gym --->
					<div class="tab-pane fade in" id="add_new_gym">
						
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4>Add New GYM</h4>
									</div>
									<div class="panel-body" id="acrdaddgym">
										<form id="addgymForm">
											<fieldset>
											<div class="row">
												<div class="col-lg-4">
													<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Gym Type <i class="fa fa-caret-down fa-fw"></i></strong>
													<span>
														<select  name="gym_type" id="gym_type" type="text" class="form-control">
															<option value="main">Main</option>
															<option value="branch">Branch</option>
														</select>
													</span>
													<p class="help-block" id="gym_type_msg">Press enter or go button to move to next field.</p>
												</div>
												<div class="col-lg-8" id="maingym">
													<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span>Select GYM<i class="fa fa-caret-down fa-fw"></i></strong>
													<input class="form-control"  placeholder="Username - Email - Cell Number" name="usr_gym_name" required="required" type="text" id="usr_gym_name" maxlength="100"/>
													<p class="help-block" id="usr_gym_msg">Press enter or go button to move to next field.</p>
												</div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											
											<!-- gym Name -->
											<div class="row">
												<div class="col-lg-4">
													<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> GYM Name <i class="fa fa-caret-down fa-fw"></i></strong>
													<input class="form-control" placeholder="GYM Name" name="gym_name" type="text" id="gym_name" required="required" maxlength="100"/>
													<p class="help-block" id="gym_name_msg">Press enter or go button to move to next field.</p>
												</div>
												<div class="col-lg-4">
													<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Registrtion Fee <i class="fa fa-caret-down fa-fw"></i></strong>
													<input class="form-control" placeholder="Registrtion Fee" name="gym_fee" type="text" id="gym_fee" required="required" maxlength="100"/>
													<p class="help-block" id="gym_fee_msg">Press enter or go button to move to next field.</p>
												</div>
												<div class="col-lg-4">
													<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Service Tax <i class="fa fa-caret-down fa-fw"></i></strong>
													<input class="form-control" placeholder="Service Tax" name="gym_tax" type="text" required="required" id="gym_tax" maxlength="100"/>
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
											<div class="row">
												<div class="col-lg-12">
													<button  type="button" class="btn btn-lg btn-primary btn-block" href="javascript:void(0);" id="addgymBut"><i class="fa fa-upload fa-fw fa-2x"></i> &nbsp;Add</button>
												</div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											</fieldset>										
										</form>
									</div>
								
								</div>
							</div>
						</div>
					</div>
					<!-- list client with dataTable format -->
						<div class="tab-pane fade" id="list_gym">
										<div class="row">
									<div class="col-lg-12">
										<div class="panel panel-primary">
											<div class="panel-heading">
												List Client
											</div>
											
											<div class="panel-body" id="generate_mmlist">
											</div>
											<div class="panel-body" id="generate_mmgymlist">
											
											</div>
											<div class="panel-body" id="edit_mmgymlist">
											  
											</div>
													</div>
												</div>
											</div>
											<div class="col-lg-12" id="lstgymloader"></div>
										 </div>
									</div>
								</div>		
					</div>
				</div>
				<div class="col-lg-12" id="client_message" style="position:fixed;top:50%;left:35%;opacity:0.5;z-index:99;color:black;"></div>
				<!-- Data paste over ---->
			</div>
		</div>
	</div>
</div>
<script src="<?php echo URL.ASSET_JSF; ?>mmcontrol.js" language="javascript" charset="UTF-8" ></script>

