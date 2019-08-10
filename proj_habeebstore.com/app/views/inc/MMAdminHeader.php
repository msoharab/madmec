<?php ?>
<!DOCTYPE html>
<html>
    <head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_19"]; ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>Shop</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Dashboard</b></span>
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
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo $this->config["DEFAULT_USER_IMG"]; ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo ucfirst($this->UserDets["user_name"]); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo $this->config["DEFAULT_USER_IMG"]; ?>" class="img-circle" alt="User Image">
                                        <p>
                                            <?php echo ucfirst($this->UserDets["user_name"]); ?>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_5"]; ?>" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_4"]; ?>" class="btn btn-default btn-flat">Logout</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
