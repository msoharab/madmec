<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="madmec-three" >
        <title><?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] : "MADMEC" ) ?></title>
        <!-- jQuery Version 1.11.0 -->
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery-1.11.0.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>superadmincontrol.js"></script>
        <link rel="shortcut icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <link rel="icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
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
                <!-- /.navbar-header -->
                <ul class="nav navbar-top-links navbar-right" style="display:none">
                    <li class="dropdown">
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
                    <li class="dropdown" style="display:none">
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
                                <a href="javascript:void(0);" onclick="window.open('<?php echo URL . 'helpdesk/'; ?>');">
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
                                <a href="javascript:void(0);" id="link1" class="atleftmenu" style="display:none">Link1</a>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="link2" class="atleftmenu" style="display:none">Link2</a>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="Order_follow-Ups" class="atleftmenu">Order Follow-Ups</a>
                            </li>
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
                                        <a href="javascript:void(0);" id="EnquiryListAll" class="menuAL toggle"><i class="fa fa-th-list fa-fw fa-x2"></i>&nbsp;List All</a>
                                    </li><li>
                                        <a href="javascript:void(0);" id="SentCredentials" class="menuAL toggle"><i class="fa fa-send-o fa-fw fa-x2"></i>&nbsp;Sent Credentials</a>
                                    </li>
                                </ul>
                                <!-- /.nav-Customer -->
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="client_collection" class="atleftmenu">Client Collection</a>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="admin_dues" class="atleftmenu">Dues</a>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="admin_duefollowup" class="atleftmenu">Collection Follow-up</a>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="admin_sms" class="atleftmenu">SMS</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . 'logout.php'; ?>';">Logout</a>
                            </li>
                            <li id="dummy" class="bt-side text-center">
                                <h4 class="text-danger">
                                    Version 3.2
                                </h4>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12" id="allOutput">
                </div>
            </div>
        </div>
