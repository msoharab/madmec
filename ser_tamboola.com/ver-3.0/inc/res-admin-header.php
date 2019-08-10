<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="madmec-two" >
        <title><?php echo ucwords(isset($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]) ? $_SESSION["USER_LOGIN_DATA"]["USER_NAME"] : "MADMEC") ?></title>
        <!-- jQuery Version 1.11.0 -->
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery-1.11.0.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>control.js" language="javascript" charset="UTF-8" ></script>
        <link rel="shortcut icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <link rel="icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <style>
            .panel-custom1 {
                border-color: #999966;
            }
            .panel-custom1 > .panel-heading {
                color: #fff;
                background-color: #999966;
                border-color: #999966;
            }
            .panel-custom1 > .panel-heading + .panel-collapse > .panel-body {
                border-top-color: #999966;
            }
            .panel-custom1 > .panel-heading .badge {
                color: #999966;
                background-color: #fff;
            }
            .panel-custom1 > .panel-footer + .panel-collapse > .panel-body {
                border-bottom-color: #999966;
            }
        </style>
    </head>
    <body>
		<div id="page-loader" style="margin:auto;position:relative;width:98%;height:98%;padding:20% 20% 20% 20%;">
			 <h1>Tamboola ver 3.0 ..<img class="img-circle" src="<?php echo  URL.ASSET_IMG; ?>loader2.gif" border="0" width="25" height="25" /></h1>
		</div>
		<div id="showMe" style="display:none;">
        <div id="wrapper">
            <?php require_once(DOC_ROOT . INC . 'admin-menu.php'); ?>
        </div>
        <div id="page-wrapper">
            <noscript>
            <META HTTP-EQUIV="Refresh" CONTENT="0;URL=scriptdisable.html">
          </noscript>
            <div class="row">
                <div class="col-lg-12" id="allOutput"></div>
            </div>
        </div>
