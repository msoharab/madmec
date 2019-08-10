<?php
$gymList = isset($this->idHolders["tamboola"]["gym"]["ListGym"]) ? (array) $this->idHolders["tamboola"]["gym"]["ListGym"] : false;
?>
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
    <body class="skin-blue layout-top-nav">
        <div id="preloader"></div>
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="<?php echo $this->config["URL"]; ?>"><b>TAMBOOLA</b></a>
                            <button data-target="#navbar-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button" aria-expanded="false">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <div id="navbar-collapse" class="navbar-collapse pull-left collapse" aria-expanded="false" style="height: 1px;">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_35"]; ?>">See all Gyms</a></li>
                                <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_35"].'addGym'; ?>">Add a Gym</a></li>
                            </ul>
                        </div>
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
                            </ul>
                        </div><!-- /.navbar-custom-menu -->
                    </div><!-- /.container-fluid -->
                </nav>
            </header>
