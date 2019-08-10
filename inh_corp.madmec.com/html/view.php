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
            $industry = $profile['industry'];
            $employment_type = $profile['employment_type'];
            $experience = $profile['experience'];
            $resp = $profile['responsibilities'];
            $doj = $profile['doj'];
            $dop = $profile['dop'];
            $skills = $profile['skills'];
            $description = $profile['description'];
        }
    }
}
?>
<script>
    function scrollWin() {
        window.scrollTo(0, 900);
    }
</script>

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
        <div class="row" onload="scrollWin()">
            <div class="col-lg-10 col-lg-offset-1 center">
                <div class="text-left">
                    <h2 class="center" style="font-size: 28px;">Job Details</h2>
                </div>
                <div class="panel panel-body col-md-5 text-left">
                    <h3 style="font-size: 20px;"> Job Title : <?php echo $jobtitle ?></h3>
                    <h3 style="font-size: 20px;"> Industry : <?php echo $industry ?></h3>
                    <h3 style="font-size: 20px;"> Employment Type : <?php echo $employment_type ?></h3>
                    <h3 style="font-size: 20px;"> Experience : <?php echo $experience ?></h3>
                    <h3 style="font-size: 20px;"> Date of Joining: <?php echo $doj ?></h3>
                    <h3 style="font-size: 20px;"> Posted On : <?php echo $dop ?></h3>

                </div>
                <div class="panel panel-body col-md-5 col-md-offset-1 text-left">

                    <h3 style="font-size: 20px;"> Responsibilities : <?php echo $resp ?></h3>
                    <h3 style="font-size: 20px;"> Skills : <?php echo $skills ?></h3>
                </div>
                <div class="panel panel-body  col-lg-11 text-left">
                    <h3 style="font-size: 20px;"> Description : <?php echo $description ?></h3>
                </div>
            </div>
            <div class="col-md-12 center">
                <a href="jobapply.php?id=<?php echo $id ?>" id="blogreply" name="blogreply" class="btn btn-primary btn-lg ">Apply</a>
            </div>
        </div><!--/.row-->
    </div>
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