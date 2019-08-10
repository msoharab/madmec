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
    <title><?php echo $_SESSION['CLINIC']; ?>(PROX DENTAL)</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="<?php echo URL.ASSET_CSS; ?>custom.css" rel="stylesheet" />
	<!-- jquery ui -->
    <link href="<?php echo URL.ASSET_CSS; ?>jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo URL.ASSET_CSS; ?>jquery-ui.1.10.4.css" rel="stylesheet" />
    <link href="<?php echo URL.ASSET_CSS; ?>web.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <!-- image uploader plugin css-->
   <link href="<?php echo URL.ASSET_CSS; ?>simpleFilePreview.css" rel="stylesheet" type="text/css"/>

   <link href="<?php echo URL.ASSET_JS; ?>dataTables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>

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
                <a class="navbar-brand" href="<?php echo URL.PHP; ?>index.php" style="font-size:25px;">proX Dental</a>
			</div>
			<span align="center" class="clinic_name"><?php echo $_SESSION['CLINIC']; ?></span>
                        <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;"> <?php echo date('d/m/Y');?> <a href="javascript:void(0);" onclick="window.location.href='<?php echo URL.PHP; ?>logout.php';" class="btn btn-danger square-btn-adjust"><i class="fa fa-sign-out"></i>&nbsp;Logout</a> </div>;
        </nav>
           <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div id="nav_div" class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <?php require_once("dental_menu.php");?>
                    <li>
                        <a id="rec_nav" href="<?php echo URL.PHP; ?>receipts.php">
                            <img src="<?php echo URL.ASSET_IMG.'receipt.png';?>" height="50" width="50"/> Receipts/Income
                        </a>
                    </li>
                    <li>
                        <a id="voc_nav" href="<?php echo URL.PHP; ?>vouchers.php">
                            <img src="<?php echo URL.ASSET_IMG.'voucher.png';?>" height="50" width="50"/>  Vouchers/Outgoing Pay
                        </a>
                    </li>
                    <li>
                        <a  id="src_nav" href="<?php echo URL.PHP; ?>source.php">
                            <img src="<?php echo URL.ASSET_IMG.'source.png';?>" height="50" width="50"/>  Source Accounts
                        </a>
                    </li>
                    <li>
                        <a id="tar_nav" href="<?php echo URL.PHP; ?>target.php">
                            <img src="<?php echo URL.ASSET_IMG.'target.png';?>" height="50" width="50"/>  Target Accounts
                        </a>
                    </li>
                    <li>
                        <a id="rep_nav" href="<?php echo URL.PHP; ?>reports.php">
                            <img src="<?php echo URL.ASSET_IMG.'report.png';?>" height="50" width="50"/>  Reports
                        </a>
                    </li>
					<!--<li>
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
