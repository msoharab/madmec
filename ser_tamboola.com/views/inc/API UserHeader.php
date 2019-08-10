<?php ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <script data-autoloader="false" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_REG"];
?>config.js"
        type="text/javascript"></script>
        <script data-autoloader="false" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PLG"] .
 $this->config["PLG_16"];
?>jQuery-2.1.4.min.js"
        type="text/javascript"></script>
        <link href="<?php
        echo $this->config["URL"] .
        $this->config["VIEWS"] .
        $this->config["ASSSET"];
        ?>css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed sidebar-collapse">
        <div id="preloader"></div>
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo $this->config["URL"]; ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>LT</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Local Talent</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-red"></i> 5 new members joined
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-user text-red"></i> You changed your username
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo $this->UserDets["profic"]; ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo ucfirst($this->UserDets["user_name"]); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo $this->UserDets["profic"]; ?>" class="img-circle" alt="User Image">
                                        <p>
                                            <?php echo ucfirst($this->UserDets["user_name"]); ?> - <?php echo $this->UserDets["type"]; ?>
                                            <small>Member since <?php echo date("M. Y", strtotime($this->UserDets["user_doj"])); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo $this->config["URL"] . $this->config["CTRL_5"]; ?>" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo $this->config["URL"] . $this->config["CTRL_4"]; ?>" class="btn btn-default btn-flat">Logout</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#control-sidebar-theme-demo-options-tab" aria-expanded="true">
                            <i class="fa fa-wrench">
                            </i>
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#control-sidebar-home-tab" aria-expanded="false">
                            <i class="fa fa-home">
                            </i>
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#control-sidebar-settings-tab" aria-expanded="false">
                            <i class="fa fa-gears">
                            </i>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div id="control-sidebar-theme-demo-options-tab" class="tab-pane active">
                        <div>
                            <h4 class="control-sidebar-heading">Company Details</h4>
                            <ul class="list-unstyled clearfix">
                                <li>
                                    Name
                                </li>
                                <li>
                                    Email
                                </li>
                                <li>
                                    Address
                                </li>
                            </ul>
                            <h4 class="control-sidebar-heading">Company Settings</h4>
                            <ul class="list-unstyled clearfix">
                                <li>
                                    Name
                                </li>
                                <li>
                                    Email
                                </li>
                                <li>
                                    Address
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="control-sidebar-home-tab" class="tab-pane">
                        <h3 class="control-sidebar-heading">App settings</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript::;">
                                    Setting one
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    Setting two
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    Setting three
                                </a>
                            </li>
                        </ul>
                        <h3 class="control-sidebar-heading">Mailing list</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript::;">
                                    Email one
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    Email two
                                </a>
                            </li>
                            <li>
                                <a href="javascript::;">
                                    Email three
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->
                    </div>
                    <!-- /.tab-pane -->
                    <!-- Settings tab content -->
                    <div id="control-sidebar-settings-tab" class="tab-pane">
                        <form method="post">
                            <h3 class="control-sidebar-heading">Automated tasks</h3>
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Task 1
                                    <input type="checkbox" checked="" class="pull-right">
                                </label>
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Task 2
                                    <input type="checkbox" class="pull-right">
                                </label>
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Delete logs
                                    <a class="text-red pull-right" href="javascript::;">
                                        <i class="fa fa-trash-o">
                                        </i>
                                    </a>
                                </label>
                            </div>
                            <!-- /.form-group -->
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
