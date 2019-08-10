<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] : "Wipro" ) ?></title>
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_BSF; ?>css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . FONT_3; ?>css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . FONT_4; ?>css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DST; ?>css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DST; ?>css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>morris/morris.css">
        <!--Datatable Table-->
        <link href="<?php echo URL . ASSET_DIR. ASSET_PLG; ?>dataTables/dataTables.bootstrap.css" rel="stylesheet" />
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>daterangepicker/daterangepicker-bs3.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>jQuery/datepicker.css">
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>jQuery/jquery-ui-timepicker-addon.css">
        <link rel="stylesheet" href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>jQuery/themes-jquery-ui.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery 2.1.4 -->
        <script src="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>jQuery/jQuery-2.1.4.min.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>var_config.js" language="javascript" charset="UTF-8" ></script>
        <script src="<?php echo URL . ASSET_JSF; ?>config.js" language="javascript" charset="UTF-8" ></script>
        <script src="<?php echo URL . ASSET_JSF; ?>admincontrol.js"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
            <div id="page-loader" style="margin:auto;position:relative;width:98%;height:98%;padding:20% 20% 20% 20%;">
                <h1>Chaser Ver 1.0</h1>
            </div>
            <div id="showme" style="display:none;">
                <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="control.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>C</b>SR</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Chaser</b>Ver 1.0</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <span><?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] : "Wipro" ); ?> <i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo USER_ANON_IMAGE ?>" class="img-circle" alt="User Image">
                                        <p>
                                            Admin - Reporting Manager.
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="col-xs-4 text-center">
                                            <a href="javascript:void(0);" class="extra-menu1" id="#dahboard">Dashboard</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="javascript:void(0);" class="extra-menu2" id="#projects">Projects</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="javascript:void(0);" class="extra-menu3"id="#employees">Employees</a>
                                        </div>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="javascript:void(0)" class="btn btn-default btn-flat" id="profile">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="javascript:void(0)" onclick="window.location.href = '<?php echo URL . 'logout.php'; ?>';" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo USER_ANON_IMAGE ?>" class="img-circle"/>
                        </div>
                        <div class="pull-left info">
                            <p><?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] : "Wipro" ); ?></p>
                            <a href="javascript:void(0)"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="javascript:void(0)" id="dahboard" class="extra-menu1">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="employees" class="extra-menu2">
                                <i class="fa fa-users"></i> <span>Employees</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="projects" class="extra-menu3">
                                <i class="fa fa-gears"></i> <span>Projects</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="import">
                                <i class="fa fa-upload"></i> <span>Import</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="reports">
                                <i class="fa fa-line-chart"></i> <span>Reports</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" id="allOutput">
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.0
                </div>
                <strong>Copyright &copy; 2014-2015 <a href="<?php echo URL . ASSET_DIR . ASSET_PLG; ?>">Chaser Ver 1.0</a>.</strong> All rights reserved.
            </footer>
            <div class="control-sidebar-bg"></div>