<?php ?>
<footer class="main-footer fixed">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2016-2017 <a href="#">MadMec</a>.</strong> All rights reserved.
</footer>
<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<script data-autoloader="false" type="text/javascript" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_BST"];
?>js/bootstrap.min.js"></script>

<script data-autoloader="false" type="text/javascript" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET"];
?>dist/js/app.min.js"></script>

<script data-autoloader="false" type="text/javascript" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PLG"] .
 $this->config["PLG_18"];
?>jquery-ui.min.js"></script>

<script data-autoloader="false" type="text/javascript" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PLG"] .
 $this->config["PLG_25"];
?>jquery.slimscroll.min.js"></script>

<script data-autoloader="false" type="text/javascript" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PLG"] .
 $this->config["PLG_16"];
?>jquery.validate.min.js"></script>

<script data-autoloader="false" type="text/javascript" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PLG"] .
 $this->config["PLG_16"];
?>jquery.form.js"></script>

<script data-autoloader="false" type="text/javascript" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_REG"] .
 $this->config["CONTROLLERS"];
?>Login.js"></script>

<link href="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET"] .
 $this->config["FONT_0"];
?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<link href="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET"] .
 $this->config["FONT_1"];
?>css/ionicons.min.css" rel="stylesheet" type="text/css" />

<link href="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_BST"];
?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<link href="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET"];
?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

<link href="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET"];
?>dist/css/skins/_all-skins.css" rel="stylesheet" type="text/css" />

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
onload="alert('after user login to thier account will view this layout');"
-->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script data-autoloader="false" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

    <script data-autoloader="false" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

<![endif]-->

<?php
echo '<script data-autoloader="true" type="text/javascript" src="' .
 $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_REG"] .
 $this->config["CONTROLLERS"] . $this->controller . '.js" ></script>';
?>

<div class="toTopNav">^</div>

<script language="javascript" charset="UTF-8">
    $(document).ready(function () {
        /* Create button to scroll to top of page */
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        $('.toTopNav').css({
            cursor: 'pointer',
            position: 'fixed',
            width: '35px',
            height: '35px',
            zIndex: '1400',
            backgroundColor: '#C0C0C0',
            textAlign: 'center',
            fontSize: '28px',
            color: '#FFFFFF',
            top: $(document).height() - Number(50),
            left: $(document).width() - Number(70)
        });
        /* Scroll to the top of page */
        $('.toTopNav').click(function () {
            $('html, body').animate({
                scrollTop: 0
            }, 'fast');
            return false;
        });
        /* Scroll to the top of page */
        $('.toTopNav').bind('mouseover', function () {
            $(this).css({
                opacity: '0.8'
            });
        });
        $('.toTopNav').bind('mouseout', function () {
            $(this).css({
                opacity: '1'
            });
        });
        $(window).load(function () {
            $('#preloader').fadeOut('slow', function () {
                $(this).remove();
            });
        });
        $('body').css("overflow-x", "hidden");
    });
</script>
</body>
</html>