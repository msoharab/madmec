<script type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/jQuery/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/jQuery/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/dist/js/app.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/dist/css/skins/_all-skins.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/css/pic3pic-colors.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/css/pic3pic-style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/css/comments.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
onload="alert('after user login to thier account will view this layout');"-->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox({
            padding: 0
        });
        $('input').iCheck({
            checkboxClass: 'icheckbox_futurico',
            radioClass: 'iradio_futurico',
            increaseArea: '10%' // optional
        });
    });
    function OpenFileDialogForCommentSection() {
        $("#CommentfileLoader").click();
    }
    function OpenFileDialogForReplySection() {
        $("#ReplyfileLoader").click();
    }
</script>
<?php
    echo '<script src="'. 
            $this->config["URL"] .  
            $this->config["VIEWS"].  
            $this->config["ASSSET_PIC"].  
            $this->config["CONTROLLERS"]. $this->controller.'.js" type="text/javascript"></script>';
?>
</body>
</html>