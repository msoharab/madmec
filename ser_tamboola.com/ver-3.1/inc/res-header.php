<?php
// if(!isset($_SESSION["USER_LOGIN_DATA"]['USER_ID'])):
// header("Location : ".URL);
// endif;
?>
<script type="text/javascript">
    // window.location.href='';
</script>
<?
// endif;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="madmec-three" >
        <title>Welcome to Tamboola powered by MADMEC</title>
        <!-- jQuery Version 1.11.0 -->
        <script src="<?php echo URL . ASSET_JSF . ASSET_JQF; ?>jquery-1.11.0.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>index.js"></script>
        <link rel="shortcut icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <link rel="icon" href="<?php echo URL . ASSET_IMG; ?>MadMec.ico" type="image/x-icon" />
        <style class="text/css">
            .socialmediaa{
                position: fixed;
                top : 120px;
                right: 20px;
            }
        </style>
    </head>
    <body>
        <div id="page-loader" style="position:relative;width:58%;height:58%;padding:20% 20% 20% 20%;">
            <h1>Tamboola ver 3.0 ..<img class="img-circle" src="<?php echo URL . ASSET_IMG; ?>loader2.gif" border="0" width="25" height="25" /></h1>
        </div>
        <div id="showMe" style="display:none;">
            <div id="center_loader" style="display:none;"></div>
            <div id="wrapper">
                <!-- Navigation -->
                <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0" id="nav-top">
                    <div class="navbar-header">
                        <a class="navbar-brand">Tamboola</a>
                    </div>
                </nav>
                <div class="socialmediaa">
                    <a href="https://www.facebook.com/Tamboola-865601826858636/timeline" target="_blank"><button type="button" class="btn btn-primary btn-circle btn-block"><i class="fa fa-facebook fa-fw"></i></button></a>
                    <div class="gap"></div>
                    <a href="https://plus.google.com/b/101721284041584339754/101721284041584339754/posts?hl=en" target="_blank"><button type="button" class="btn btn-danger btn-circle  btn-block"><i class="fa fa-google-plus fa-fw"></i></button></a><div class="gap"></div>
                    <a href="http://in.linkedin.com/in/onlinegymsoftware" target="_blank"><button type="button" class="btn btn-warning btn-circle  btn-block"><i class="fa fa-linkedin fa-fw"></i></button></a><div class="gap"></div>
                    <a href="https://twitter.com/onlinegymsoftwa" target="_blank"><button type="button" class="btn btn-info btn-circle  btn-block"><i class="fa fa-twitter fa-fw"></i></button></a><div class="gap"></div>
                    <a href="http://onlinegymsoftware.blogspot.in/" target="_blank"><button type="button" class="btn btn-warning btn-circle  btn-block"><i class="fa fa-rss fa-fw"></i></button></a><div class="gap"></div>
                </div>
                <!--
                        <nav class="menu" id="theMenu">
                    <div class="menu-wrap">
                        <h1 class="logo"><a href="index.php">Tamboola</a></h1>
                        <i class="fa fa-arrow-right menu-close"></i>
                        <a href="javascript:void(0);" class="index-menu">Features</a>
                        <a href="javascript:void(0);" class="index-menu">SignIn</a>
                         <a href="javascript:void(0);" class="index-menu" id="custreg">Register</a>
                        <a href="javascript:void(0);" class="index-menu">About</a>
                    </div>
                    <div id="menuToggle" class=""><i class="fa fa-bars"></i></div>
                </nav>
                -->
