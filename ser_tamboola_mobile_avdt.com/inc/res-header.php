<!DOCTYPE html>
<html lang="en">
<div id="page-loader">
<h1>Find My Gym 1.0, Powered by MadMec</h1>
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
<div id="center_loader" style="display:none;"></div>
<div id="wrapper">
<!-- Navigation -->
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
                    <a class="navbar-brand" href="index.php">Find My Gym</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="javascript:void(0);" class="navlink" id="a_List">List</a></li>
				<li class="divider"></li>
				<li><a href="javascript:void(0);" class="navlink" id="a_SignIn">SignIn</a></li>
				<li class="divider"></li>
				<li><a href="javascript:void(0);" class="navlink" id="a_SignUp">SignUp</a></li>
				<li class="divider"></li>
				<!--
				<li><a href="javascript:void(0);" class="navlink" id="a_Facebook">Facebook</a></li>
				-->
			</ul>
		</div>
	</div>
</div>