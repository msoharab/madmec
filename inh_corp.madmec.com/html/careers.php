<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once DOC_ROOT . INC . 'header.php';
?>
<div class="aboutus  wow flipInY" >
    <div class="carousel-caption">
        <p class="wow flipInX" style="color:white;">
            MadMec provide the opportunities, challenges and support <br> to live the future of your work now
        </p>
    </div>
</div>
<div class="center">
    <h2>Your personality is the key to finding a career that's right for you.</h2>
    <p class="lead">At MadMec, we provide the opportunities, challenges and support to live the future of your work now. Explore where we work, how we work and the opportunities that await you.</p>
</div>
<section id="contact-info" style="background-color: lavender">
    <div class="center">
        <h2>Jobs Posted</h2></div>
    <div  class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive" id="joblist">
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</section><!-- /.content -->
<?php
require_once DOC_ROOT . INC . 'footer.php';
?>
<link href="<?php echo URL . ASSET_CSS; ?>careers.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
    $(document).ready(function () {
        window.setTimeout(function () {
            listJob();
        }, 400);
    });
</script>