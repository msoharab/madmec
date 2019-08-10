<?php
	$request = '';
	$users = '';
	if (isset($_SESSION["USER_LOGIN_DATA"]["USER_TYPE"]) && $_SESSION["USER_LOGIN_DATA"]["USER_TYPE"] == "Owner") {
		$request = '<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-reorder fa-fw" ></i>  <span id="alert_count"></span> <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu">
					<li>
					<a href="javascript:void(0);" id="userrequestfrmmmadmin" title="user\'s Request">
					<div id="displayreqts">
					fetch User Request From Database
					</div>
					</a>
					</li>
					</ul>
					</li>';
		$users = '<li id="home" class="bt-side">
				<a href="javascript:void(0);" id="owneruser" class="menuAL toggle"><i class="fa fa-users fa-x2"></i> Users</a>
				</li>';
	}
	$gym_name = 'Club / gym has not yet assigned to you.';
	if(isset($_SESSION["SETGYM"]["GYM_NAME"])){
		 $gym_name = ucwords($_SESSION["SETGYM"]["GYM_NAME"]);
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="madmec-two" >
        <title><?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] : "MADMEC") ?></title>
        <!-- jQuery Version 1.11.0 -->
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery-1.11.0.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>control.js" language="javascript" charset="UTF-8" ></script>
        <link rel="shortcut icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <link rel="icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
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
    <body>
		<div id="page-loader" style="position:relative;width:58%;height:58%;padding:20% 20% 20% 20%;">
			 <h1>Tamboola ver 3.0 ..<img class="img-circle" src="<?php echo  URL.ASSET_IMG; ?>loader2.gif" border="0" width="25" height="25" /></h1>
		</div>
		<div id="showMe" style="display:none;">
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
					<a class="navbar-brand">Tamboola</a>
				</div>
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="fa fa-bell fa-fw" ></i>  <span id="alert_count" ></span> <i class="fa fa-caret-down" ></i>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="javascript:void(0);" id="custrequestt" title="Customer's Request">
										<div id="custrequest">
											fetch Customer Request From Database
										</div>
									</a>
								</li>
							</ul>
							<!-- /.dropdown-alerts -->
						</li>
					<?php
						echo $request;
					?>
					<li class="dropdown" style="display : none;">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-bell fa-fw"></i>  <span id="alert_count">( 0 )</span> <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . ADMIN . 'enquiry/list_today_enquiries.php'; ?>';">
									<div>
										Enquiry Follow-ups
										<span class="pull-right text-muted small"><span id="fol_count">( 0 )</span></span>
									</div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . ADMIN . 'stats/customer_stats.php'; ?>';">
									<div>
										Expired customers
										<span class="pull-right text-muted small"><span id="exp_count">( 0 )</span></span>
									</div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . ADMIN . 'stats/no_show.php'; ?>';">
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
								<a href="javascript:void(0);"   onclick='window.open("<?php echo URL . "helpdesk/"; ?>");' >
									<i class="fa fa-info-circle"></i> Help
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . 'logout.php'; ?>';">
									<i class="fa fa-sign-out fa-fw fa-x2"></i> Logout
								</a>
							</li>
						</ul>
						<!-- /.dropdown-user -->
					</li>
					<!-- /.dropdown -->
				</ul>
				<!-- /.navbar-top-links -->
				<div class="navbar-default" role="navigation" id="sidebar">
					<div class="sidebar-nav navbar-collapse sidebar">
						<ul class="nav" id="side-menu">
							<?php if($gym_name != 'Club / gym has not yet assigned to you.') { ?>
							<li id="gymname" class="bt-side">
								<a href="javascript:void(0);" id="SingleDash" class="menuAL toggle"><img src="<?php echo LOGO_1; ?>" class="img-circle" width="50" /></i>
									<label id="printrs" name="0"><?php echo $gym_name; ?></label></a>
							</li>
							<li id="home" class="bt-side">
								<a href="javascript:void(0);" id="Dash" class="menuAL toggle"><i class="fa fa-home fa-x2"></i> Home</a>
							</li>

                                                        <li id="dummy" class="bt-side"><a href="javascript:void(0);"  id="AddGym">
								<!--<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>attendance.png" border="0" width="30" height="30"/>-->
                                                                <i class="fa fa-upload fa-fw fa-x2">&nbsp;</i>&nbsp;ADD GYM
								</a></li>
							<?php echo $users; ?>
							<!-- /.nav-enquiry -->
							<li id="enquiry" class="bt-side">
								<a href="#">Enquiry<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" id="EnquiryAdd" class="menuAL toggle">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>enquiry.png" border="0" width="30" height="30"/>&nbsp;Add Enquiry</a>
									</li>
									<li>
										<a href="javascript:void(0);" id="EnquiryFollow" class="menuAL toggle"><i class="fa fa-th-list fa-fw fa-x2"></i>&nbsp;Follow-ups</a>
									</li>
									<li>
										<a href="javascript:void(0);"id="EnquiryListAll" class="menuAL toggle"><i class="fa fa-th-list fa-fw fa-x2"></i>&nbsp;List All</a>
									</li>
								</ul>
								<!-- /.nav-Customer -->
							</li>
							<li id="customers" class="bt-side">
								<a href="#">Customers<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="CustomerAdd">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_user.png" border="0" width="30" height="30"/>
											&nbsp;Add Customer
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="CustomerList">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_users.png" border="0" width="30" height="30"/>
											&nbsp;List Customers
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="CustomerImport">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>import.png" border="0" width="30" height="30"/>
											&nbsp;Import Customers
										</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li id="groups" class="bt-side">
								<a href="#">Groups<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="CGroupAdd">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_group.png" border="0" width="30" height="30"/>
											&nbsp;Create
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="CGList">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_groups.png" border="0" width="30" height="30"/>
											&nbsp;List Groups
										</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li id="trainers" class="bt-side">
								<a href="#">Employee<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="TrainerAdd">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_trainer.png" border="0" width="30" height="30"/>
											&nbsp;Add Employee
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="TrainerList">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_trainer.png" border="0" width="30" height="30"/>
											&nbsp;List Employee
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="TrainerImport">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>import.png" border="0" width="30" height="30"/>
											&nbsp;Import Employee
										</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li id="accounts" class="bt-side">
								<a href="javascript:void(0);">Accounts<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" class="menuAL toggle"  id="Fee">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>fee-icon-2.gif" border="0" width="30" height="30"/>
											&nbsp;Offer Payment
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="PackageFee">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>packages.png" border="0" width="30" height="30"/>
											&nbsp;Package Payment
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="StaffPay">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>pay_trainer.png" border="0" width="30" height="30"/>
											&nbsp;Staff Payments
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="ClubExpenses">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>expenses.png" border="0" width="30" height="30"/>
											&nbsp;Club Expenses
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="DueBalance">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>due.png" border="0" width="30" height="30"/>
											&nbsp;Due / Balance
										</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li id="manage" class="bt-side">
								<a href="#">Manage<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="AddFacility">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_facility2.png" border="0" width="30" height="30"/>
											&nbsp;Facilities
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="AddOffer">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_offers.png" border="0" width="30" height="30"/>
											&nbsp;Offers
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="ListOffer">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_offers.png" border="0" width="30" height="30"/>
											&nbsp;List Offers
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="AddPackage">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_packages.png" border="0" width="30" height="30"/>
											&nbsp;Packages
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="ListPackage">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_packages.png" border="0" width="30" height="30"/>
											&nbsp;List Packages
										</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li id="attendance" class="bt-side">
								<a href="#">Attendance<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="MarkCustAtt">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>attendance.png" border="0" width="30" height="30"/>
											&nbsp;Customers
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="MarkTrinAtt">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>attendance.png" border="0" width="30" height="30"/>
											&nbsp;Employees
										</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li id="stats" class="bt-side">
								<a href="#">Stats<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="StAccount">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>accounts.png" border="0" width="30" height="30"/>
											&nbsp;Transactions
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="StRegistrations">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>registration.png" border="0" width="30" height="30"/>
											&nbsp;Registrations
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="StCustomers">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>stats.png" border="0" width="30" height="30"/>
											&nbsp;Customers
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="StEmployee">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>trainer.png" border="0" width="30" height="30"/>
											&nbsp;Employee
										</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li id="reports" class="bt-side">
								<a href="#">Reports<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="RClub">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>gym_collection.png" border="0" width="30" height="30"/>
											&nbsp;Offers
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="RPackage">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>package_collection.png" border="0" width="30" height="30"/>
											&nbsp;Package
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="RRegistrations">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>registration.png" border="0" width="30" height="30"/>
											&nbsp;Registrations
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="RPayments">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>pay_trainer.png" border="0" width="30" height="30"/>
											&nbsp;Payments
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="RExpenses">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>expenses.png" border="0" width="30" height="30"/>
											&nbsp;Expenses
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="RBalanceSheet">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>profit_loss.png" border="0" width="30" height="30"/>
											&nbsp;Balance Sheet
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="RCustomers">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>customer_attendance.png" border="0" width="30" height="30"/>
											&nbsp;Customers Attendance
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="REmployee" style="display:none;">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>trainer_attendance.png" border="0" width="30" height="30"/>
											&nbsp;Employee
											</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="RReceipts">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>receipts.png" border="0" width="30" height="30"/>
											&nbsp;Receipts
										</a>
									</li>
								</ul>
							</li>
							<li id="crm" class="bt-side">
								<a href="#">CRM<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="CRMAPP">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>mobile_app.png" border="0" width="30" height="30"/>
											&nbsp;Mobile App
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="toggle" id="CRMEmail" style="display:none;">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>email.png" border="0" width="30" height="30"/>
											&nbsp;Email Manager
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="toggle" id="CRMsms" style="display:none;">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>sms.png" border="0" width="30" height="30"/>
											&nbsp;SMS manage
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="CRMFeedback">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>feedback.png" border="0" width="30" height="30"/>
											&nbsp;Feedbacks
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="menuAL toggle" id="CRMExpiry">
											<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>demon.png" border="0" width="30" height="30"/>
											&nbsp;Expiry Intimation
										</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li id="dummy" class="bt-side"><a href="javascript:void(0);">Version 3.2<span class="fa arrow"></span></a></li>
							<?php } else {?>
							<label id="printrs" name="0"><?php echo $gym_name; ?></label>
                                                <li id="dummy" class="bt-side"><a href="javascript:void(0);"  id="AddGym">
								<!--<img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>attendance.png" border="0" width="30" height="30"/>-->
                                                                <i class="fa fa-upload fa-2x">&nbsp;</i>&nbsp;ADD GYM
								<span class="fa arrow"></span></a></li>
							<li id="dummy" class="bt-side"><a href="javascript:void(0);">Version 3.2<span class="fa arrow"></span></a></li>
							<?php }?>
						</ul>
					</div>
					<div class="overlay"></div>
				</div>
			</nav>
		</div>
        <div id="page-wrapper">
            <noscript>
            <META HTTP-EQUIV="Refresh" CONTENT="0;URL=scriptdisable.html">
          </noscript>
            <div class="row">
                <div class="col-lg-12" id="allOutput"></div>
            </div>
        </div>
