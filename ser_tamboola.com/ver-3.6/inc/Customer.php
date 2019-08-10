<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8 BOM">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="madmec-three" >
        <title><?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] : "MADMEC" ) ?></title>
        <!-- jQuery Version 1.11.0 -->
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery-1.11.0.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>customercontrol.js"></script>
        <link rel="shortcut icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <link rel="icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
    </head>
    <body>
        <div id="page-loader" style="position:relative;width:58%;height:58%;padding:20% 20% 20% 20%;">
            <h1>Tamboola ver 3.0 ..<img class="img-circle" src="<?php echo URL . ASSET_IMG; ?>loader2.gif" border="0" width="25" height="25" /></h1>
        </div>
        <div id="showMe" style="display:none;">
            <div id="wrapper">
			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="javascript:void(0);">Tamboola</a>
				</div>
					<div class="navbar-default sidebar" role="navigation" id="sidebar" style="top:5px;">
					<div class="sidebar-nav navbar-collapse">
						<ul class="nav" id="side-menu">
							<li class="bt-side text-center">
								<img src="<?php echo USER_ANON_IMAGE ?>" class="img-circle" width="150"/>
							</li>
							<li class="bt-side">
								<a href="javascript:void(0);" id="custsearch" class="atleftmenu"><i class="fa fa-search fa-fw"></i>Search GYM</a>
							</li>
							<li class="bt-side">
								<a href="javascript:void(0);" id="client_collection" class="atleftmenu">Menu2</a>
							</li>
							<li class="bt-side">
								<a href="javascript:void(0);" id="admin_dues" class="atleftmenu">Menu3</a>
							</li>
							<li>
								<a href="javascript:void(0);" onclick="window.location.href = '<?php echo URL . 'logout.php'; ?>';"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
							</li>
							<li id="dummy" class="bt-side text-center">
								<h4 class="text-danger">
									Version 3.2
								</h4>
							</li>
						</ul>
					</div>
					</div>
			</nav>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12" id="allOutput">
                    </div>
                </div>
            </div>
