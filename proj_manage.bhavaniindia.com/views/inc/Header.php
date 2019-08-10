<?php
$header = isset($this->idHolders["ricepark"]["index"]["header"]) ? (array) $this->idHolders["ricepark"]["index"]["header"] : false;
$login = isset($this->idHolders["ricepark"]["index"]["login"]) ? (array) $this->idHolders["ricepark"]["index"]["login"] : false;
$register = isset($this->idHolders["ricepark"]["index"]["register"]) ? (array) $this->idHolders["ricepark"]["index"]["register"] : false;
$about = isset($this->idHolders["ricepark"]["index"]["about"]) ? (array) $this->idHolders["ricepark"]["index"]["about"] : false;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_REG"]; ?>config.js"></script>
        <script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_PLG"] . $this->config["PLG_16"]; ?>jquery-1.7.1.min.js"></script>
        <script>
            $(document).ready(function () {
                $(window).load(function () {
                    $('#loader').fadeOut('slow', function () {
                        $(this).remove();
                    });
                });

                $('html, body').css('overflow-x', 'hidden');
            });
        </script>
    </head>
    <body>
        <div id="loader"></div>
        <!-- Start: page-top-outer -->
        <div id="page-top-outer">
            <!-- Start: page-top -->
            <div id="page-top">
                <!-- start logo -->
                <div id="logo">
                    <a href=""><h1 style="color:white;">Bhavani Traders</h1></a>
                </div>
                <!-- end logo -->
                <div class="clear"></div>
            </div>
            <!-- End: page-top -->
        </div>
        <!-- End: page-top-outer -->
        <div class="clear">&nbsp;</div>
        <!--  start nav-outer-repeat................................................................................................. START -->
        <div class="nav-outer-repeat">
            <!--  start nav-outer -->
            <div class="nav-outer">
                <!-- start nav-right -->
                <div id="nav-right">
                    <div class="nav-divider">&nbsp;</div>
                    <a class="showhide-account" id="logout" href="<?php echo $this->config["URL"] . $this->config["CTRL_5"]; ?>"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"]; ?>shared/nav/nav_myaccount.gif" width="93" height="14" alt="" /></a>
                    <div class="nav-divider">&nbsp;</div>
                    <a id="logout" href="<?php echo $this->config["URL"] . $this->config["CTRL_4"]; ?>"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"]; ?>shared/nav/nav_logout.gif" width="64" height="14" alt="" /></a>
                    <div class="clear">&nbsp;</div>
                    <!--  start account-content -->
                    <!--  end account-content -->
                </div>
                <!-- end nav-right -->
                <!--  start nav -->
                <div class="nav">
                    <div class="table">
                        <ul class="select">
                            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"] . 'Dashboard'; ?>"><b>Dashboard</b><!--[if IE 7]><!--></a><!--<![endif]-->
                            </li>
                        </ul>
                        <div class="nav-divider">&nbsp;</div>
                        <ul class="select">
                            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"] . 'Product'; ?>"><b>Products</b><!--[if IE 7]><!--></a><!--<![endif]-->
                            </li>
                        </ul>
                        <div class="nav-divider">&nbsp;</div>
                        <ul class="select"><li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"] . 'ListProduct'; ?>"><b>Products List</b><!--[if IE 7]><!--></a><!--<![endif]-->
                            </li>
                        </ul>
                        <div class="nav-divider">&nbsp;</div>
                        <ul class="select"><li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"] . 'Members'; ?>"><b>Members</b><!--[if IE 7]><!--></a><!--<![endif]-->
                            </li>
                        </ul>
                        <div class="nav-divider">&nbsp;</div>
                        <ul class="select"><li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"] . 'ListMembers'; ?>"><b>Members List</b><!--[if IE 7]><!--></a><!--<![endif]-->
                            </li>
                        </ul>
                        <div class="nav-divider">&nbsp;</div>
                        <ul class="select"><li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"] . 'ListEnquiry'; ?>"><b>Enquiry</b><!--[if IE 7]><!--></a><!--<![endif]-->
                            </li>
                        </ul>
                        <div class="nav-divider">&nbsp;</div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!--  start nav -->
            </div>
            <div class="clear"></div>
            <!--  start nav-outer -->
        </div>
        <!--  start nav-outer-repeat................................................... END -->