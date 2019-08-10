<?php
$gym_name = 'Club / Gym Has Not Yet Assigned To You.';
$gym_id = (int) NULL;
if (isset($_SESSION["SETGYM"]["GYM_NAME"]) && isset($_SESSION["SETGYM"]["GYM_IND"])) {
    $gym_name = ucwords($_SESSION["SETGYM"]["GYM_NAME"]);
    $gym_id = $_SESSION["SETGYM"]["GYM_IND"];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8 BOM">
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
            <h1>Tamboola ver 3.0 ..<img class="img-circle" src="<?php echo URL . ASSET_IMG; ?>loader2.gif" border="0" width="25" height="25" /></h1>
        </div>
        <div id="showMe" style="display:none;">
            <div id="wrapper">
			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="javascript:void(0);">Tamboola</a>
				</div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown">
                                <a href="#"  class="dropdown-toggle" data-toggle="dropdown" id="Dash">
                                    <img src="<?php echo LOGO_1; ?>" width="25" /> 
                                    <strong id="printrs" class="text-muted" name="<?php echo $gym_id; ?>">
                                        <?php echo $gym_name; ?>
                                    </strong>
                                    &nbsp;<i class="fa fa-caret-down text-muted"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <div id="list-gyms"></div>
                                    <li>
                                        <a href="javascript:void(0);"  id="AddGym">
                                            <i class="fa fa-upload fa-fw">&nbsp;</i>&nbsp;Add Club / Gym
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php if ($gym_name != 'Club / Gym Has Not Yet Assigned To You.') : ?>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_user.png" border="0" width="25" height="25" />
                                        <span id="request_count" class="text-muted">(0)</span> 
                                        <i class="fa fa-caret-down text-muted" ></i>
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
                                </li>
                            <?php endif; ?>
                            <li class="dropdown" style="display:none;">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>stats.png" border="0" width="25" height="25"/>  <span id="alert_count">(0)</span> <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div>
                                                Enquiry Follow-ups
                                                <span class="pull-right text-muted small"><span id="fol_count">(0)</span></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div>
                                                Expired Customers
                                                <span class="pull-right text-muted small"><span id="exp_count">(0)</span></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div>
                                                No Show Customers
                                                <span class="pull-right text-muted small"><span id="track_count">(0)</span></span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle text-muted" data-toggle="dropdown" href="#">
                                    <i class="fa fa-gears "></i><i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li>
                                        <a href="javascript:void(0);" id="profile">
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
                                        <a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . 'logout.php'; ?>';"><i class="fa fa-sign-out fa-fw"></i>Logout</a>                                
									</li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                            <!-- /.dropdown -->
                        </ul>
					<div class="navbar-default sidebar" role="navigation" id="sidebar" style="top:5px;">
					<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<?php if ($gym_name != 'Club / Gym Has Not Yet Assigned To You.') : ?>
                                <li id="admins" class="bt-side">
                                    <a href="#" id="owneruser" class="menuAL toggle">
                                        <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>administrator.png" border="0" width="24" height="24"/>
                                        &nbsp;<span class="text-muted">Admins</span><span class="fa arrow"></span>
                                    </a>
                                </li>
                                <li id="enquiry" class="bt-side">
                                    <a href="#">
                                        <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>enquiry.png" border="0" width="24" height="24"/>
                                        &nbsp;<span class="text-muted">Enquiry</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" id="EnquiryAdd" class="menuAL toggle">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>enquiry.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Add Enquiry</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" id="EnquiryFollow" class="menuAL toggle">
                                                <i class="fa fa-th-list fa-fw"></i>
                                                &nbsp;<span class="text-muted">Follow-ups</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" id="EnquiryListAll" class="menuAL toggle">
                                                <i class="fa fa-th-list fa-fw"></i>
                                                &nbsp;<span class="text-muted">List All</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-Customer -->
                                </li>
                                <li id="customers" class="bt-side">
                                    <a href="#">
                                        <i class="fa fa-user fa-fw "></i>
                                        &nbsp;<span class="text-muted">Customers</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="CustomerAdd">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_user.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Add Customer</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="CustomerList">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_users.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">List Customers</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="CustomerImport">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>import.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Import Customers</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li id="groups" class="bt-side">
                                    <a href="#">
                                        <i class="fa fa-users fa-fw "></i>
                                        &nbsp;<span class="text-muted">Groups</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="CGroupAdd">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_group.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Create</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="CGList">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_groups.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">List Groups</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li id="trainers" class="bt-side">
                                    <a href="#">
                                        <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>trainer.png" border="0" width="24" height="24"/>
                                        &nbsp;<span class="text-muted">Employee</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="TrainerAdd">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_trainer.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Add Employee</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="TrainerList">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_trainer.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">List Employee</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="TrainerImport">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>import.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Import Employee</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li id="accounts" class="bt-side">
                                    <a href="javascript:void(0);">
                                        <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_facility.png" border="0" width="24" height="24"/>
                                        &nbsp;<span class="text-muted">Accounts</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle"  id="Fee">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>fee-icon.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Offer Payment</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="PackageFee">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>packages.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Package Payment</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="StaffPay">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>pay_trainer.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Staff Payments</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="ClubExpenses">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>expenses.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Club Expenses</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="DueBalance">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>due.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Due / Balance</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li id="manage" class="bt-side">
                                    <a href="#">
                                        <i class="fa fa-dashboard  fa-fw"></i>
                                        &nbsp;<span class="text-muted">Manage</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="AddFacility">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_facility2.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Facilities</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="AddOffer">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_offers.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Offers</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="ListOffer">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_offers.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">List Offers</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="AddPackage">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_packages.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Packages</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="ListPackage">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>list_packages.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">List Packages</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li id="attendance" class="bt-side">
                                    <a href="#">
                                        <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>attendance.png" border="0" width="24" height="24"/>
                                        &nbsp;<span class="text-muted">Attendance</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="MarkCustAtt">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>customer_attendance.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Customers</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="MarkTrinAtt">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>trainer_attendance.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Employees</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li id="stats" class="bt-side">
                                    <a href="#">
                                        <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>add_facility3.png" border="0" width="24" height="24"/>
                                        &nbsp;<span class="text-muted">Stats</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="StAccount">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>accounts.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Transactions</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="StRegistrations">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>registration.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Registrations</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="StCustomers">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>stats.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Customers</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="StEmployee">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>trainer.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Employee</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li id="reports" class="bt-side">
                                    <a href="#">
                                        <i class="fa fa-bars fa-fw "></i>
                                        &nbsp;<span class="text-muted">Reports</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="RClub">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>gym_collection.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Offers</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="RPackage">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>package_collection.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Package</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="RRegistrations">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>registration.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Registrations</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="RPayments">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>pay_trainer.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Payments</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="RExpenses">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>expenses.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Expenses</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="RBalanceSheet">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>profit_loss.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Balance Sheet</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="RCustomers">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>customer_attendance.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Customers Attendance</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="REmployee" style="display:none;">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>trainer_attendance.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Employee</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="RReceipts">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>receipts.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Receipts</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li id="crm" class="bt-side" style="display:none;">
                                    <a href="#">
                                        <i class="fa fa-mobile-phone fa-fw "></i>
                                        &nbsp;<span class="text-muted">CRM</span><span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="CRMAPP">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>mobile_app.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Mobile App</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="toggle" id="CRMEmail" style="display:none;">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>email.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Email Manager</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="toggle" id="CRMsms" style="display:none;">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>sms.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">SMS manage</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="CRMFeedback">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>feedback.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Feedbacks</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="menuAL toggle" id="CRMExpiry">
                                                <img class="img-circle" src="<?php echo URL . ASSET_IMG . ICON_THEME; ?>demon.png" border="0" width="24" height="24"/>
                                                &nbsp;<span class="text-muted">Expiry Intimation</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-second-level -->
                                </li>
                            <?php endif; ?>
                            <li id="dummy" class="bt-side"><a href="javascript:void(0);"><span class="text-muted">Version 3.2</span><span class="fa arrow"></span></a></li>
                        </ul>
                    </div>
                    </div>
                </nav>
            <div id="page-wrapper">
                <noscript>
                <META HTTP-EQUIV="Refresh" CONTENT="0;URL=scriptdisable.html">
                </noscript>
                <div class="row">
                    <div class="col-lg-12" id="allOutput"></div>
                </div>
            </div>
