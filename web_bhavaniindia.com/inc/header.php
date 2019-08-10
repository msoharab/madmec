<?php
$title = basename($_SERVER['SCRIPT_FILENAME'], '.php');
$title = str_replace('_', ' ', $title);
if (strtolower($title) == 'index') {
    $title = 'Bhavani | Home Page';
}
$title = ucwords($title);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        echo '<title>' . 'Sree Bhavani | ' . $title . '</title>';
        ?>
        <!-- for-mobile-apps -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Grocery Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
              Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- //for-mobile-apps -->
        <script src="<?php echo URL . ASSET_JSF; ?>var_config.js"></script>
        <script src="<?php echo URL . ASSET_PLG; ?>jquery-1.11.1.min.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>config.js"></script>
        <script src="<?php echo URL . ASSET_JSF; ?>index.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".scroll").click(function (event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: 0}, 1000);
                });
            });
        </script>
        <!-- start-smoth-scrolling -->
    </head>

    <body>
        <div id="loader"></div>
        <!-- header -->
        <div class="agileits_header">
            <div class="w3l_offers">
                <!-- <a href="products.html">we provide our client with frienly business environment</a> -->
            </div>
            <div class="w3l_header_right">
                <ul class="agileits_social_icons">
                    <li><a href="https://www.facebook.com/sree.bhavani.79" class="facebook" target="blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="https://twitter.com/bhavani_info" class="twitter" target="blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="https://plus.google.com/107513702901367422764" class="google" target="blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="w3l_header_right1">
                <h2><a href="<?php echo URL . MOD; ?>mail.php">Enquiry</a></h2>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!-- script-for sticky-nav -->
        <script>
            $(document).ready(function () {
                var navoffeset = $(".agileits_header").offset().top;
                $(window).scroll(function () {
                    var scrollpos = $(window).scrollTop();
                    if (scrollpos >= navoffeset) {
                        $(".agileits_header").addClass("fixed");
                    } else {
                        $(".agileits_header").removeClass("fixed");
                    }
                });

            });
        </script>
        <!-- //script-for sticky-nav -->
        <div class="logo_products">
            <div class="container">
                <div class="w3ls_logo_products_left">

                    <h1><a href="<?php echo URL; ?>index.php"><img src="<?php echo URL . ASSET_IMG; ?>Final.png" alt=" " class="img-responsive" /></a></h1>
                </div>
                <div class="w3ls_logo_products_left1">
                    <ul class="special_items">
                        <li><a href="<?php echo URL; ?>index.php">Home</a><i>/</i></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products<span class="caret"></span></a><i>/</i>
                            <div class="w3ls_vegetables">
                                <ul class="dropdown-menu drp-mnu1">
                                    <li><a href="<?php echo URL . MOD; ?>non_basmati.php">Non Basmati</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>sona_masoori.php">Sona Masuri</a></li>
                                    <li><a href="<?php echo URL . MOD; ?>lachkari.php">   Lachkari   </a></li>
                                    <li><a href="<?php echo URL . MOD; ?>products.php">All</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="<?php echo URL . MOD; ?>why_bhavani.php">Why Bhavani</a><i>/</i></li>
                        <li><a href="<?php echo URL . MOD; ?>about_us.php">About Us</a><i>/</i></li>
                        <li><a href="<?php echo URL . MOD; ?>team.php">Team</a><i>/</i></li>
                        <li><a href="<?php echo URL . MOD; ?>contact_us.php">Contact Us</a><i></i></li>
                    </ul>
                </div>
                <div class="w3ls_logo_products_left1">
                    <ul class="phone_email">
                        <li><i class="fa fa-phone" aria-hidden="true"></i>(080) 28063600</li>
                        <li><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="mailto:bhavanienterprise.info@gmail.com">bhavanienterprise.info@gmail.com</a></li>
                    </ul>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <!-- //header -->