<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-xs-4">
                <div class="top-number"><p><i class="fa fa-phone-square"></i> 080-26581108</p></div>
            </div>
            <div class="col-sm-6 col-xs-8">
                <div class="social">
                    <ul class="social-share">
                        <li><a href="https://www.facebook.com/madmec2013"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/madmec"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="https://plus.google.com/+Madmec2013"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="https://twitter.com/ITCompanyMadmec"><i class="fa fa-twitter"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!--/.container-->
</div><!--/.top-bar-->
<footer id="footer" class="midnight-blue">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                &copy; 2013 <a target="_blank" href="http://madmec.com/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">Madmec</a>. All Rights Reserved.
            </div>
            <div class="col-sm-6">
                <ul class="pull-right">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="<?php echo URL . MOD; ?>about_us.php">About Us</a></li>
                    <li><a href="<?php echo URL . MOD; ?>faq.php">Faq</a></li>
                    <li><a href="<?php echo URL . MOD; ?>contact_us.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer><!--/#footer-->
<!-- core CSS -->
<link href="<?php echo URL . ASSET_CSS; ?>bootstrap.min.css" rel="stylesheet" type="text/css">
<!--<link href="<?php echo URL . ASSET_CSS; ?>bootstrap.css" rel="stylesheet" type="text/css">-->
<link href="<?php echo URL . ASSET_CSS; ?>font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL . ASSET_CSS; ?>prettyPhoto.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL . ASSET_CSS; ?>animate.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL . ASSET_CSS; ?>responsive.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL . ASSET_CSS; ?>main.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL . ASSET_CSS; ?>owl.theme.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL . ASSET_CSS; ?>owl.carousel.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL . ASSET_CSS; ?>style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo URL . ASSET_CSS; ?>flexslider.css" rel="stylesheet" type="text/css" media="screen" />
<!--  <link rel="stylesheet" href="<?php echo URL . ASSET_CSS; ?>jelly_reset.css">-->
<!--  <link rel="stylesheet" href="<?php echo URL . ASSET_CSS; ?>jelly.css" media="screen" type="text/css" />-->
<script src="<?php echo URL . ASSET_JSF; ?>plugins/owl.carousel.min.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/jquery.flexslider.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/jssor.slider.min.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/bootstrap.min.js"></script>
<!--<script src="<?php echo URL . ASSET_JSF; ?>plugins/bootstrap.js"></script>-->
<script src="<?php echo URL . ASSET_JSF; ?>plugins/jquery.prettyPhoto.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/jquery.isotope.min.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/jquery.validate.min.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/main.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>plugins/wow.min.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>config.js"></script>
<script src="<?php echo URL . ASSET_JSF; ?>index.js"></script>
<!--<script src="<?php echo URL . ASSET_JSF; ?>jelly_index.js"></script>-->
<script>
    $(document).ready(function () {
        $("#sponsor-list").owlCarousel({
            items: 4,
            lazyLoad: true,
            navigation: true
        });
        $('.flexslider').flexslider({
            //animation: "slide",
            animation: "fade",
            //direction:"vertical",
            slideshow:true,
            randomize:true,
            pauseOnAction:true,
            pauseOnHover:true,
            touch:true,
            video:false,
            controlNav:false,
            mousewheel:false,
            start: function (slider) {
                $('body').removeClass('loading');
            }
        });
    });
</script>
</body>
</html>