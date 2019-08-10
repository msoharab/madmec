<?php
$header = isset($this->idHolders["onlinefood"]["index"]["header"]) ? (array) $this->idHolders["onlinefood"]["index"]["header"] : false;
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
    <!--sidebar-mini wysihtml5-supported skin-yellow-light-->
    <body class="hold-transition skin-yellow-light sidebar-mini fixed sidebar-collapse">
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
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                </nav>
            </header>
