<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
require_once DOC_ROOT . INC . 'header.php';
$res = NULL;
$stm = NULL;
$db = new dataBase(array(
    "dbtype" => 'mysql',
    "host" => DBHOST,
    "dbname" => DBNAME_ZERO,
    "user" => DBUSER,
    "password" => DBPASS,
        ));
$db->query('SET SESSION group_concat_max_len=18446744073709551615');
if ($db) {
    $query = 'SELECT
            ad.`id` AS id,
            ad.`name` AS name,
            ad.`designation` AS desig,
            ad.`cell_1` AS cell,
            ad.`email` AS email,
            REPLACE(ad.`address`,"\r\n","<br />") AS addr,
            ad.`doc` AS doc,
            CASE WHEN ad.`photo_id` IS NULL OR ad.`photo_id`  = "" OR ph.`ver1` IS NULL OR ph.`ver1` = ""
            THEN "' . DEFAULT_IMG . '"
            ELSE CONCAT("' . IMAGEURL . '",ph.`ver1`)
            END AS pic,
            ad.`facebook_link` AS faceb1,
            ad.`twitter_link` AS faceb2,
            ad.`googleP_link` AS faceb3
            FROM `team_members` AS ad
        LEFT JOIN `photo` AS ph ON ph.`id` = ad.`photo_id`
        WHERE (ad.`id` != NULL
        OR ad.`id` IS NOT NULL)
        AND ad.`status` = 4
        AND ph.`status` = 4;';
    $stm = $db->prepare($query);
    $res = $stm->execute();
    $res = $stm->fetchAll();
}
?>
<!-- products-breadcrumb -->
<div class="products-breadcrumb">
    <div class="container">
        <ul>
            <li>Our Team</li>
        </ul>
    </div>
</div>
<!-- //products-breadcrumb -->
<!-- banner -->
<div class="banner">
    <div class="w3l_banner">
        <div class="w3l_banner_nav_right_banner8 animated flipInX">
            <h3 class="animated flipInY" style="color: black;margin-left: 22em;"><strong>Our People Care about Our Customers</strong></h3>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- //banner -->
    <!-- team -->
    <div class="team">
        <div class="container">
            <h3>Meet Our Amazing Team</h3>
            <div class="agileits_team_grids">
                <?php
                if ($stm->rowCount()) {
                    for ($i = 0, $k = 1, $j = 4; $i < $stm->rowCount(); $i++, $k++) {
                        $id = $res[$i]['id'];
                        $name = ucwords($res[$i]['name']);
                        $desig = ucwords($res[$i]['desig']);
                        $cell = ucwords($res[$i]['cell']);
                        $email = ucwords($res[$i]['email']);
                        $addr = ucwords($res[$i]['addr']);
                        $pic = $res[$i]['pic'];
                        $faceb1 = ucwords($res[$i]['faceb1']);
                        $faceb2 = ucwords($res[$i]['faceb2']);
                        $faceb3 = ucwords($res[$i]['faceb3']);
                        ?>
                        <div class="col-md-3 agileits_team_grid">
                            <img src="<?php echo $pic; ?>" alt="<?php echo $name; ?>" width="200" height="200"/>
                            <h4><?php echo $name; ?></h4>
                            <p><?php echo $desig; ?></p>
                            <ul class="agileits_social_icons agileits_social_icons_team">
                                <li><a href="<?php echo $faceb1; ?>" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="<?php echo $faceb2; ?>" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="<?php echo $faceb3; ?>" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            </ul>
                            <div class="panel-header">
                                <h3></h3>
                                <p>
                                    <a href="#" data-toggle="modal" data-target="#myModal<?php echo $i; ?>" class="button">
                                        More details
                                    </a>
                                </p>
                            </div>
                            <!-- Modal start-->
                            <div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content modal-info">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>						
                                        </div>
                                        <div class="modal-body modal-spa">
                                            <div class="col-md-5 span-2">
                                                <div class="item">
                                                    <img src="<?php echo $pic; ?>" alt="<?php echo $name; ?>" width="220" height="280"/>
                                                </div>
                                            </div>
                                            <div class="col-md-7 span-1 ">
                                                <h3><?php echo $name; ?>&nbsp;[<?php echo $desig; ?>]</h3>
                                                <p class="in-para"> <?php echo $cell; ?>,&nbsp;<?php echo $email; ?></p>
                                                <div class="price_single">
                                                    <span class="reducedfrom ">
                                                        <ul class="agileits_social_icons agileits_social_icons_team">
                                                            <li><a href="<?php echo $faceb1; ?>" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                                            <li><a href="<?php echo $faceb2; ?>" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                                            <li><a href="<?php echo $faceb3; ?>" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </span>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <h4 class="quick">Address:</h4>
                                                <p class="quick_desc"><?php echo $addr; ?></p>
                                                <div class="add-to">
                                                </div>
                                            </div>
                                            <div class="clearfix"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal End-->
                        </div>
                        <?php
                        if ($k == $j):
                            ?>
                            <div class="clearfix panel-footer col-lg-12"> </div>
                            <?php
                            $j += 4;
                        endif;
                    }
                } else {
                    ?>
                    <div class="col-md-12 agileits_team_grid">
                        <h2>No members to list.</h2>
                        <div class="clearfix"> </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- //team -->
    <?php
    require_once DOC_ROOT . INC . 'footer.php';
    ?>
