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
        $query="SELECT bg.*,ph.ver2 from blog AS bg LEFT JOIN photo AS ph ON bg.image=ph.id WHERE bg.id='$id'";
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
        while ($row = mysql_fetch_assoc($result)) {
            $fetchdata[] = $row;
        }
    }
}
}
?>
<div class="aboutus  wow flipInY" >
    <div class="carousel-caption">
        <p class="wow flipInX" style="color:white;">
            Stay up to date with our most recent news and updates.
        </p>
    </div>
</div>
    <section id="blogreply">
        <div class="container">
            <div class="panel panel-default">
            <div class="row col-xs-12">
                <div class="text-left">
                    <h2 style="font-size: 20px">Blog Details</h2>
                </div>
                <div>
                    <h3 style="font-size: 20px;text-align: left">Blog Title: &nbsp;&nbsp;&nbsp;<?php echo $fetchdata[0]['title']; ?></h3>
                </div>
                 <div>
                    <h3 style="font-size: 20px;text-align: left"> Description: <?php echo $fetchdata[0]['description']; ?></h3>
                </div>
                 <div>
                     <h3 style="font-size: 20px;text-align: left">Image: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../<?php echo $fetchdata[0]['ver2']; ?>" alt=" No image available" height="200" width="200"/></h3>
                </div>
                
              
            </div>
            <div>
            <a href="blogreview.php?id=<?php echo $id; ?>" class="btn btn-success">Review</a>
        </div>
        </div>
        </div>
    </section>
    <?php
    require_once DOC_ROOT . INC . 'footer.php';
    ?>
    <link href="<?php echo URL . ASSET_CSS; ?>blogs.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript">
        $(document).ready(function () {
            window.setTimeout(function () {
                blogreply();
            }, 400);
        });
    </script>