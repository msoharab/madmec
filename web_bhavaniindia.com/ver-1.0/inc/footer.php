<div class="newsletter">
    <div class="container">
        <div class="clearfix"> </div>
    </div>
</div>
<!-- //newsletter -->
<!-- footer -->
<div class="footer">
    <div class="container">
        <div class="col-md-3 w3_footer_grid">
            <h3>information</h3>
            <ul class="w3_footer_grid_list">
                <li><a href="<?php echo URL . MOD; ?>about.php">About Us</a></li>
                <li><a href="<?php echo URL . MOD; ?>why_bhavani.php">Why Bhavani</a></li>
                <li><a href="<?php echo URL . MOD; ?>short-codes.html">Contact Us</a></li>
            </ul>
        </div>
        <div class="col-md-3 w3_footer_grid">
            <h3>policy info</h3>
            <ul class="w3_footer_grid_list">
                <li><a href="<?php echo URL . MOD; ?>mail.php">Enquiry</a></li>
                <li><a href="<?php echo URL . MOD; ?>privacy.php">privacy policy</a></li>
                <li><a href="<?php echo URL . MOD; ?>privacy.php">terms of use</a></li>
            </ul>
        </div>
        <div class="col-md-3 w3_footer_grid">
            <h3>what in stores</h3>
            <ul class="w3_footer_grid_list">
                <li><a href="<?php echo URL . MOD; ?>products.php">Products</a></li>
                <li><a href="<?php echo URL . MOD; ?>products.php">Branded Rice</a></li>
            </ul>
        </div>
        <div class="col-md-3 w3_footer_grid">
            <h3>connect with us</h3>
            <ul class="agileits_social_icons">
                <li><a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <div class="clearfix"> </div>
        <div class="wthree_footer_copy">
            <p>© 2016 Bhavani Store. All rights reserved | Design by <a href="http://madmec.com/">MadMec</a></p>
        </div>
    </div>
</div>
<!-- //footer -->
<link href="<?php echo URL . ASSET_CSS; ?>animate.min.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo URL . ASSET_CSS; ?>bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo URL . ASSET_CSS; ?>animate.css" rel="stylesheet" type="text/css" media="all" />

<link href="<?php echo URL . ASSET_CSS; ?>style.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo URL . ASSET_CSS; ?>font-awesome.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo URL . ASSET_CSS; ?>flexslider.css" type="text/css" media="screen" property="" />
<script defer src="<?php echo URL . ASSET_PLG; ?>jquery.flexslider.js"></script>
<script src="<?php echo URL . ASSET_PLG; ?>jquery-1.11.1.min.js"></script>
<script src="<?php echo URL . ASSET_PLG; ?>move-top.js" type="text/javascript" ></script>
<script src="<?php echo URL . ASSET_PLG; ?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo URL . ASSET_PLG; ?>jquery.validate.min.js" type="text/javascript" ></script>
<script src="<?php echo URL . ASSET_PLG; ?>easing.js" type="text/javascript"></script>
<script src="<?php echo URL . ASSET_PLG; ?>bootstrap.min.js"></script>
<script src="<?php echo URL . ASSET_PLG; ?>minicart.min.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>config.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>index.js"></script>
<!-- flexSlider -->

<script type="text/javascript">
    $(window).load(function () {
        $('.flexslider').flexslider({
            animation: "slide",
            start: function (slider) {
                $('body').removeClass('loading');
            }
        });
    });
</script>
<!-- //flexSlider -->
<script>
    $(document).ready(function () {
        $(".dropdown").hover(
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                    $(this).toggleClass('open');
                },
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                    $(this).toggleClass('open');
                }
        );
    });
</script>
<!-- here stars scrolling icon -->
<script type="text/javascript">
    $(document).ready(function () {
        /*
         var defaults = {
         containerID: 'toTop', // fading element id
         containerHoverID: 'toTopHover', // fading element hover id
         scrollSpeed: 1200,
         easingType: 'linear'
         };
         */

        $().UItoTop({easingType: 'easeOutQuart'});

    });
</script>
<!-- //here ends scrolling icon -->
<script>
    // Mini Cart
    paypal.minicart.render({
        action: '#'
    });

    if (~window.location.search.indexOf('reset=true')) {
        paypal.minicart.reset();
    }
</script>
</body>
</html>
