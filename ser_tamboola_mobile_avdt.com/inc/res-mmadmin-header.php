<!DOCTYPE html>
<html lang="en">
<div id="page-loader">
<h1>Find My Gym App, Powered By MadMec &copy;</h1>
</div>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="madmec-three" >
    <title>Find My Gym Powered by MadMec</title>
    <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo URL.ASSET_JSF.ASSET_JQF; ?>jquery-1.11.0.js"></script>
    <script src="<?php echo URL.ASSET_JSF; ?>config.js"></script>
	<link rel="shortcut icon" href="<?php echo URL.ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
	<link rel="icon" href="<?php echo URL.ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
</head>
<body style="display:none;">
<div id="wrapper">
	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="margin-bottom: 0" id="nav-top">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo URL; ?>">Find My Gym</a>
		</div>
		<div class="navbar-default" role="navigation" id="sidebar">
			<div class="sidebar-nav navbar-collapse sidebar gray-skin">
				<ul class="nav" id="side-menu">
					<li class="bt-side">
						<a href="javascript:void(0);" id="menu1" class="atleftmenu"></a>
					</li>
					<li class="bt-side">
						<a href="javascript:void(0);" id="menu2" class="atleftmenu"></a>
					</li>
					<li class="bt-side">
						<a href="javascript:void(0);" id="menu3" class="atleftmenu"></a>
					</li>
					<li class="bt-side">
						<a href="javascript:void(0);" id="menu4" class="atleftmenu"></a>
					</li>
					<li class="bt-side">
						<a href="javascript:void(0);" id="menu5"  class="atleftmenu"></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div id="page-wrapper">
		<div class="row"><div class="col-lg-12">&nbsp;</div><div class="col-lg-12">&nbsp;</div></div>
		<div class="row">
			<div class="col-lg-12" id="output"><div class="col-lg-12">&nbsp;</div><div class="col-lg-12">&nbsp;</div><center><h1><strong> Welcome To Find My Gym App, <br />Powered By MadMec.</strong><h1></center></div>
		</div>
		<div class="col-lg-12" id="client_message" style="position:fixed;top:50%;left:35%;opacity:0.5;z-index:99;color:black;"></div>
	</div>
</div>
<?php
   require_once(DOC_ROOT.INC.'res-footer.php');
?>