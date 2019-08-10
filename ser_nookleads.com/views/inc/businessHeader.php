<?php
$header = isset($this->idHolders["nookleads"]["business"]["header"]) ? (array) $this->idHolders["nookleads"]["business"]["header"] : false;
$chSearch = isset($this->idHolders["nookleads"]["business"]["header"]["businessSearch"]) ? (array) $this->idHolders["nookleads"]["business"]["header"]["businessSearch"] : false;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
              name='viewport'>
        <script src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PLG"] .
 $this->config["PLG_16"];
?>jQuery-2.1.4.min.js"
        type="text/javascript"></script>
        <script src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"];
?>config.js"
        type="text/javascript"></script>
        <script data-autoloader="false" type="text/javascript" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"];
?>businessHeader.js"></script>
    </head>
    <body class="wysihtml5-supported skin-red-light sidebar-collapse fixed">
        <div class="wrapper">
            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="<?php echo $this->config["URL"] . $this->config["CTRL_7"]; ?>" class="navbar-brand"><b>nOOk</b>Leads</a>
                            <button aria-expanded="false" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <div style="height: 1px;" aria-expanded="false" class="navbar-collapse pull-left collapse" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php echo $rules["url"] ?>" >B2B</a></li>
                                <li><a href="<?php echo $guidelines["url"] ?>" >B2C</a></li>
                                <li><a href="<?php echo $guidelines["url"] ?>" >B2G</a></li>
                                <li><a href="<?php echo $guidelines["url"] ?>" >C2C</a></li>
                            </ul>
                            <form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <input class="form-control" id="navbar-search-input" placeholder="Search" type="text">
                                </div>
                            </form>
                        </div>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!-- Messages: style can be found in dropdown.less-->
                                <li class="dropdown messages-menu">
                                    <!-- Menu toggle button -->
                                    <a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-envelope-o"></i>
                                        <span class="label label-success">4</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 4 messages</li>
                                        <li>
                                            <!-- inner menu: contains the messages -->
                                            <div style="position: relative; overflow: hidden; width: auto; height: 200px;" class="slimScrollDiv"><ul style="overflow: hidden; width: 100%; height: 200px;" class="menu">
                                                    <li><!-- start message -->
                                                        <a href="#">
                                                            <div class="pull-left">
                                                                <!-- User Image -->
                                                                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                            </div>
                                                            <!-- Message title and timestamp -->
                                                            <h4>
                                                                Support Team
                                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                            </h4>
                                                            <!-- The message -->
                                                            <p>Why not buy a new awesome theme?</p>
                                                        </a>
                                                    </li><!-- end message -->
                                                </ul><div style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;" class="slimScrollBar"></div><div style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;" class="slimScrollRail"></div></div><!-- /.menu -->
                                        </li>
                                        <li class="footer"><a href="#">See All Messages</a></li>
                                    </ul>
                                </li><!-- /.messages-menu -->

                                <!-- Notifications Menu -->
                                <li class="dropdown notifications-menu">
                                    <!-- Menu toggle button -->
                                    <a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bell-o"></i>
                                        <span class="label label-warning">10</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 10 notifications</li>
                                        <li>
                                            <!-- Inner Menu: contains the notifications -->
                                            <div style="position: relative; overflow: hidden; width: auto; height: 200px;" class="slimScrollDiv"><ul style="overflow: hidden; width: 100%; height: 200px;" class="menu">
                                                    <li><!-- start notification -->
                                                        <a href="#">
                                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                        </a>
                                                    </li><!-- end notification -->
                                                </ul><div style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;" class="slimScrollBar"></div><div style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;" class="slimScrollRail"></div></div>
                                        </li>
                                        <li class="footer"><a href="#">View all</a></li>
                                    </ul>
                                </li>
                                <!-- Tasks Menu -->
                                <li class="dropdown tasks-menu">
                                    <!-- Menu Toggle Button -->
                                    <a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-flag-o"></i>
                                        <span class="label label-danger">9</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 9 tasks</li>
                                        <li>
                                            <!-- Inner menu: contains the tasks -->
                                            <div style="position: relative; overflow: hidden; width: auto; height: 200px;" class="slimScrollDiv"><ul style="overflow: hidden; width: 100%; height: 200px;" class="menu">
                                                    <li><!-- Task item -->
                                                        <a href="#">
                                                            <!-- Task title and progress text -->
                                                            <h3>
                                                                Design some buttons
                                                                <small class="pull-right">20%</small>
                                                            </h3>
                                                            <!-- The progress bar -->
                                                            <div class="progress xs">
                                                                <!-- Change the css width attribute to simulate progress -->
                                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                    <span class="sr-only">20% Complete</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li><!-- end task item -->
                                                </ul><div style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;" class="slimScrollBar"></div><div style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;" class="slimScrollRail"></div></div>
                                        </li>
                                        <li class="footer">
                                            <a href="#">View all tasks</a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- User Account Menu -->
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
                                                <?php echo ucfirst($this->UserDets["user_name"]); ?>
                                                <small>Member since <?php echo date("M. Y", strtotime($this->UserDets["date_of_join"])); ?></small>
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
                    </div>
                </nav>
            </header>
            <?php
            //require_once 'leadFilterBusiness.php';
            ?>
            <!--<div class="row"><div class="col-lg-12">&nbsp;</div></div>-->