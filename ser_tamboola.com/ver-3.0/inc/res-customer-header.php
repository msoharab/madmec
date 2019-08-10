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
        <script src="<?php echo URL . ASSET_JSF; ?>customercontrol.js"></script>
        <link rel="shortcut icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <link rel="icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
    </head>
    <body>
		<div id="page-loader" style="margin:auto;position:relative;width:98%;height:98%;padding:20% 20% 20% 20%;">
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

                </ul>
                <div class="navbar-default" role="navigation" id="sidebar">
                    <div class="sidebar-nav navbar-collapse sidebar gray-skin">
                        <ul class="nav" id="side-menu">
                            <li class="bt-side text-center">
                                <img src="<?php echo USER_ANON_IMAGE ?>" class="img-circle" width="150"/>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="custsearch" class="atleftmenu">Search GYM</a>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="client_collection" class="atleftmenu">Menu2</a>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="admin_dues" class="atleftmenu">Menu3</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . 'logout.php'; ?>';">Logout</a>
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
        </div>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12" id="allOutput">
                </div>
            </div>
        </div>
