<?php
	require_once("config.php");
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Integrated accounts Software.</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>custom.css" rel="stylesheet" />
	<!-- jquery ui -->
    <link href="<?php echo URL.ASSET_CSS; ?>jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo URL.ASSET_CSS; ?>web.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
	<div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo URL.PHP; ?>index.php">proX ver 1.2</a>
			</div>
			<img height="60" src="<?php echo URL.ASSET_IMG."logo.png"; ?>"/>
			<div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;"> <?php echo date('d/m/Y');?> <a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.PHP; ?>logout.php';" class="btn btn-danger square-btn-adjust">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div id="nav_div" class="sidebar-collapse">
                <ul class="nav" id="main-menu">
					<li>
                        <a id="rec_nav" href="<?php echo URL.PHP; ?>receipts.php"><i class="fa fa-rocket fa-3x"></i> Receipts </a>
                    </li>
                    <li>
                        <a id="voc_nav" href="<?php echo URL.PHP; ?>vouchers.php"><i class="fa fa-file-text fa-3x"></i> Vouchers </a>
					</li>
					<li>
                        <a  id="src_nav" href="<?php echo URL.PHP; ?>source.php"><i class="fa fa-star fa-3x"></i> Source Accounts </a>
                    </li>	
                      <li  >
                        <a id="tar_nav" href="<?php echo URL.PHP; ?>target.php"><i class="fa fa-crosshairs fa-3x"></i> Target Accounts</a>
                    </li>
                    <li  >
                        <a id="rep_nav" href="<?php echo URL.PHP; ?>reports.php"><i class="fa fa-bar-chart-o fa-3x"></i> Reports </a>
                    </li>				
					<li>
                        <a id="gen_nav" href="<?php echo URL.PHP; ?>gen_appeal.php"><i class="fa fa-envelope fa-3x"></i> Generate Appeals</a>
                    </li>				
					<!--<li>
                        <a id="das_nav" href="<?php echo URL.PHP; ?>dashboard.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
					                   
<!--
					<li>
                        <a href="#"><i class="fa fa-sitemap fa-3x"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>

                                </ul>
                               
                            </li>
                        </ul>
                      </li>  
                  <li  >
                        <a  href="blank.html"><i class="fa fa-square-o fa-3x"></i> Blank Page</a>
                    </li>	
-->
                </ul>
               
            </div>
            
        </nav>  