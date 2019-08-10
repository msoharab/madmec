<?php
$title = basename($_SERVER['SCRIPT_FILENAME'], '.php');
$title = str_replace('_', ' ', $title);
if (strtolower($title) == 'index') {
    $title = 'MadMec | Home Page';
}
$title = ucwords($title);
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?php
        echo  '<title>' . $title . '</title>';
        ?>
        <!--
        <link href="master.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="images/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/images/ico/apple-touch-icon-57-precomposed.png">
        -->
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL; ?>favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo URL; ?>favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL; ?>favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL; ?>favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL; ?>favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo URL; ?>favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo URL; ?>favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo URL; ?>favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo URL; ?>favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo URL; ?>favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo URL; ?>favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo URL; ?>favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo URL; ?>favicon/favicon-16x16.png">
		<link rel="manifest" href="<?php echo URL; ?>favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo URL; ?>favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
        <script src="<?php echo URL . ASSET_JSF; ?>var_config.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>plugins/jquery-1.12.3.min.js"></script>
    </head><!--/head-->
    <body>
        <div id="loader"></div>
        <header id="header">
            <nav class="navbar navbar-inverse">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php"><strong>MadMec</strong></a>
                    </div>
                    <div class="collapse navbar-collapse control-sidebar control-sidebar-dark">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Solutions <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo URL . MOD; ?>digital_marketing.php">Digital marketing solutions</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>employee_engage.php">Employee engagement solutions</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>mobile_solution.php">Mobile Solutions</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>web_solution.php">Web Solutions</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>cloud_computing.php">Cloud Computing Solutions</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>api_solution.php">API Solutions</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>compliance.php">Compliance Solutions</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>business_solution.php">Business Solutions</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo URL . MOD; ?>e-commerce.php">e-Commerce Service</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>security.php">Security Services</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>training.php">Consultancy & Training</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>gateway.php">Gateway Integration</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>server_setup.php">Server Setup</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>web_development.php">Web Development</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>mobile_application.php">Mobile Application</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>migration.php">Migration Services</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>cluster_service.php">Cluster Services</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>website_maintenance.php">Website Maintenance & Support</a></li>
                                </ul>
                            </li>
                            <li><a href="<?php echo URL . MOD; ?>about_us.php">About Us</a></li>
                            <li><a href="<?php echo URL . MOD; ?>our_work.php">Our work</a></li>
                            <li><a href="<?php echo URL . MOD; ?>blog.php">Blogs</a></li>
                            <li><a href="<?php echo URL . MOD; ?>careers.php">Careers</a></li>
                            <li><a href="<?php echo URL . MOD; ?>why_madmec.php">Why MadMec</a></li>
                            <li><a href="<?php echo URL . MOD; ?>contact_us.php">Contact</a></li>
                        </ul>
                    </div>
                </div><!--/.container-->
            </nav><!--/nav-->
        </header><!--/header-->