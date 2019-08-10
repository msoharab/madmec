</div>
<script src="<?php echo URL . ASSET_JSF . JSF_JQUERY; ?>jquery-ui.min.js" 				language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . JSF_JQUERY; ?>jquery.form.js" 				language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . JSF_JQUERY; ?>jquery.metadata.v2.js" 			language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . JSF_JQUERY; ?>jquery-migrate-1.1.0.js" 		language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . JSF_JQUERY; ?>jquery.RotateCompressed.2.2.js" language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . JSF_JQUERY; ?>jquery.purl.js" 				language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . JSF_JQUERY; ?>jquery.Jcrop.js" 				language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . JSF_JQUERY; ?>jquery.calendar-widget.js" 		language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . PLUGINS . METISMENU; ?>metisMenu.min.js" 		language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF; ?>var_config.js" 							language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF; ?>config.js" 								language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . JSF_JPEGCAM; ?>webcam.js" 					language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . DATATABLES ?>jquery.dataTables.js" 			language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . DATATABLES ?>dataTables.bootstrap.js"         language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . JSF_JQUERY; ?>picedit.js"         language="javascript" charset="UTF-8" ></script>
<!--<script src="<?php // echo URL.ASSET_JSF.JSF_JQUERY;  ?>main.js"         language="javascript" charset="UTF-8" ></script>-->

<!--
<script src="<?php echo URL . ASSET_JSF . PLUGINS . MORRIS; ?>morris.min.js" 				language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . PLUGINS . MORRIS; ?>raphael.min.js" 			language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JSF . PLUGINS . MORRIS; ?>morris-data.js" 			language="javascript" charset="UTF-8" ></script>
-->
<!-- Bootstrap ver 3.1.0
<script src="<?php echo URL . ASSET_JS_1; ?>bootstrap.min.js" 						language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JS_1; ?>sb-admin-1.js" 							language="javascript" charset="UTF-8" ></script>
-->
<!-- Bootstrap ver 3.2.0 -->
<script src="<?php echo URL . ASSET_JS_2; ?>bootstrap.min.js" 						language="javascript" charset="UTF-8" ></script>
<script src="<?php echo URL . ASSET_JS_2; ?>sb-admin-2.js" 							language="javascript" charset="UTF-8" ></script>

<!-- CSS -->
<!-- Bootstrap ver 3.1.0
<link href="<?php echo URL . ASSET_CSS_1; ?>bootstrap.min.css" 						rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_CSS_1; ?>sb-admin-1.css" 							rel="stylesheet"  type="text/css" />
-->
<!-- Bootstrap ver 3.2.0 -->
<link href="<?php echo URL . ASSET_CSS_2; ?>bootstrap.min.css" 						rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_CSS_2; ?>sb-admin-2.css" 							rel="stylesheet"  type="text/css" />

<link href="<?php echo URL . ASSET_CSS . PLUGINS . METISMENU; ?>metisMenu.min.css" 		rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_CSS . PLUGINS; ?>timeline.css" 						rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_CSS . PLUGINS; ?>social-buttons.css" 				rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_DIR . FONT; ?>font-awesome.min.css" 					rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_CSS; ?>jquery-ui.1.10.4.css" 						rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_CSS; ?>jquery.Jcrop.css" 							rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_CSS; ?>style.css" rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_CSS; ?>font.css" rel="stylesheet"  type="text/css" />
<link href="<?php echo URL . ASSET_CSS; ?>picedit.css" rel="stylesheet"  type="text/css" />
<!--
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
-->

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!--Button to scroll to top of screen-->
<div class="toTopNav">^</div>
<div id="keycodes_temp" style="display:none"></div>
<script language="javascript" charset="UTF-8">
    $(document).ready(function () {
        //Create button to scroll to top of page
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
        //Scroll to the top of page
        $('.toTopNav').click(function () {
            $('html, body').animate({scrollTop: 0}, 'fast');
            return false;
        });
        //Scroll to the top of page
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
    });
    function BindScrollEvents() {
        //Make button appear only when scrolled below 100px
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.toTopNav').show(300);
            }
            if ($(this).scrollTop() < 100) {
                $('.toTopNav').hide(400);
            }
            var scrollbartop = $(window).scrollTop();
            // var sidebartop = $('#sidebar').css('top');
            if (scrollbartop == 0) {
                $('#sidebar').css('top', '0px');
            }
            else if (scrollbartop > 52) {
                $('#sidebar').css('top', Number(scrollbartop * 0.010) + 'px')
            }
        });
    }
</script>
</body>
</html>
