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
        <script src="<?php echo URL . ASSET_JSF; ?>var_config.js" language="javascript" charset="UTF-8" ></script>
        <script src="<?php echo URL . ASSET_JSF; ?>config.js" language="javascript" charset="UTF-8" ></script>
        <script src="<?php echo URL . ASSET_JSF; ?>control.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>address.js"></script>
        <link rel="shortcut icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <link rel="icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <style type="text/css">
            label.error {
                /* remove the next line when you have trouble in IE6 with labels in list */
                color: red;

            }
        </style>
    </head>
    <body>
            <div id="page-loader" style="margin:auto;position:relative;width:98%;height:98%;padding:20% 20% 20% 20%;">
                <h1>Vehicle ver 1.0</h1>
            </div>
            <div id="showme" style="display:none;">
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="FundMandali">Vehicle</a>
                </div>
                <!-- /.navbar-header -->
                <ul class="nav navbar-top-links navbar-right">


        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user"></i>&nbsp;
                <?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] : "MADMEC" ) ?>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="javascript:void(0);" id="profile" class="toggletop menuAL">
                        <i class="fa fa-user"></i> Profile
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
                <div class="navbar-inverse" role="navigation" id="sidebar">
                    <div class="sidebar-nav navbar-collapse sidebar gray-skin">
                        <ul class="nav" id="side-menu">
                            <li class="bt-side text-center">
                                <img src="<?php echo USER_ANON_IMAGE ?>" class="img-circle" width="150"/>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="Donation" class="atleftmenu"><i class="fa fa-rupee fa-fw fa-x2"></i>&nbsp;Vehicle</a>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="Referral" class="atleftmenu"><i class="fa fa-users fa-fw fa-x2"></i>&nbsp;Appointments</a>
                            </li>
                            <li class="bt-side">
                                <a href="javascript:void(0);" id="Report" class="atleftmenu"><i class="fa fa-bar-chart-o fa-fw fa-x2"></i>&nbsp;History</a>
                            </li>
                            <li id="dummy" class="bt-side text-center">
                                <h4 class="text-danger">
                                    Version 1.0
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
