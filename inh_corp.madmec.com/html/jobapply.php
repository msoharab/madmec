<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
require_once DOC_ROOT . INC . 'header.php';
$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $getselect = executeQuery("SELECT * FROM jobs WHERE id='$id'");
        while ($profile = mysql_fetch_array($getselect)) {
            $jobtitle = $profile['title'];
        }
    }
}
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
<section id="jobreply" style="background-color: #c8e5bc">
    <div class="container">
        <div class="row col-xs-12">
            <div class="center">
                <h2>Job Reply</h2>
            </div>
            <form name="jobreplyform" id="jobreplyform" method="post">
                <div class="row col-sm-12">
                    <div class="form-group">
                            <input type="hidden" name="id" id="id" class="form-control" value="<?php echo $id; ?>">
                        </div>
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required="required">
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email"  required="required" data-validation-required-message="Please enter your email.">
                        </div>
                        <div class="form-group">
                            <label>Phone *</label>
                            <input type="number" name="phone" id="phone" class="form-control" required="required" data-validation-required-message="Please enter your number.">
                        </div>
                        <div class="form-group">
                            <label>Job Title *</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Job Title" required="required" value="<?php echo $jobtitle; ?>">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Picture </label>
                            <input  type="file" id="picture" name="picture" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Resume </label>
                            <input  type="file" id="resume" name="resume" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Message </label>
                            <textarea name="message" id="message" class="form-control" rows="5" cols="25" required="required"
                                      placeholder="Message"></textarea>
                        </div>
                        <div class="col-sm-4 col-sm-offset-2">
                            <div class="form-group">
                                <button type="submit" id="jobreply" name="jobreply" class="btn btn-primary btn-lg">Submit Reply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!--/.row-->
    </div><!--/.container-->
</section>
<?php
require_once DOC_ROOT . INC . 'footer.php';
?>
<link href="<?php echo URL . ASSET_CSS; ?>careers.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
    $(document).ready(function () {
        window.setTimeout(function () {
            jobReply();
        }, 400);
    });
</script>