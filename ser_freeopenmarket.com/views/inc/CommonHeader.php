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
    <!--sidebar-mini wysihtml5-supported skin-yellow-light-->
    <body class="hold-transition skin-yellow-light layout-top-nav fixed">
        <div id="preloader"></div>
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo $this->config["URL"]; ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>OFO</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Online Food Order</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="<?php echo $this->config["URL"] . $this->config["CTRL_5"]; ?>">
                                Home
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo $this->config["URL"] . $this->config["CTRL_6"]; ?>">
                                Login
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo $this->config["URL"] . $this->config["CTRL_2"]; ?>">
                                Facebook
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo $this->config["URL"] . $this->config["CTRL_4"]; ?>">
                                Google+
                            </a>
                        </li>
                    </ul>
                </nav>
            </header>
