<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Pay Rickshaw(Prepaid)</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="<?php echo URL.ASSET_CSS; ?>bootstrap.min.css" rel="stylesheet">
                <link href="<?php echo URL.ASSET_DIR.FONT; ?>font-awesome.min.css" 	rel="stylesheet"  type="text/css" />
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
                <link href="<?php echo URL.ASSET_CSS; ?>styles.css" rel="stylesheet">
		<link href="<?php echo URL.ASSET_CSS; ?>jquery-ui.1.10.4.css" rel="stylesheet">
                <link href="<?php echo URL.ASSET_CSS; ?>dataTables.bootstrap.css" rel="stylesheet">
                <script src="<?php echo URL.ASSET_JS; ?>jquery-min-2.0.2.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAilKnQBsuNCIP5xhy2rPba0fDeEeQKESU&sensor=false&libraries=places&v=3.exp" language="javascript" type="text/javascript"></script>
		<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAilKnQBsuNCIP5xhy2rPba0fDeEeQKESU&sensor=false&v=3.exp" language="javascript" type="text/javascript"></script>-->
		<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp" language="javascript" type="text/javascript"></script>-->
		<style>
		  #map-canvas {
			height: 100%;
                        width: 100%;
		  }
		  #content-pane {
			padding-left:10px;
		  }
                  .well{color:#555; }
		  #outputDiv {
			font-size: 11px;
		  }
		  #pac-input {
			background-color: #fff;
			font-family: Roboto;
			font-size: 15px;
			font-weight: 300;
			margin-left: 12px;
			padding: 0 11px 0 13px;
			text-overflow: ellipsis;
			width: 400px;
		  }

		  #pac-input:focus {
			border-color: #4d90fe;
		  }

		  .pac-container {
			font-family: Roboto;
		  }
		</style>		
	</head>
	<body>