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
    $stm = $db->prepare('SELECT
                    GROUP_CONCAT(ad.`id` SEPARATOR "☻♥☻") AS id,
                    ad.`name`,
                    GROUP_CONCAT(ad.`brand` SEPARATOR "☻♥☻")  AS brand,
                    GROUP_CONCAT(ad.`category` SEPARATOR "☻♥☻")  AS category,
                    GROUP_CONCAT(ad.`quantity` SEPARATOR "☻♥☻")  AS quantity,
                    GROUP_CONCAT(ad.`price` SEPARATOR "☻♥☻")  AS price,
                    GROUP_CONCAT(ad.`description` SEPARATOR "☻♥☻")  AS description,
                    GROUP_CONCAT(CASE
                      WHEN ad.`photo_id` IS NULL
                      OR ad.`photo_id` = ""
                      OR ph.`ver2` IS NULL
                      OR ph.`ver2` = ""
                      THEN "' . DEFAULT_PRD_IMG . '"
                      ELSE CONCAT(
                        "' . IMAGEURL . '",
                        ph.`ver2`
                      )
                            END SEPARATOR "☻♥☻"
                    ) AS photo
            FROM `product` AS ad
            LEFT JOIN `photo` AS ph ON ph.`id` = ad.`photo_id`
            WHERE ad.`status` = 4
            AND ad.`name` LIKE  "%Non Basmati%"
            GROUP BY (ad.`name`)
            ORDER BY (ad.`name`) DESC;');
    $res = $stm->execute();
    $res = $stm->fetchAll();
}
?>
<!-- products-breadcrumb -->
<div class="products-breadcrumb">
    <div class="container">
        <ul>
            <li><strong>Non Basmati Rice</strong></li>
        </ul>
    </div>
</div>
<!-- //products-breadcrumb -->
<!-- banner -->
<div class="banner">
    <div class="w3l_banner">
        <div class="w3l_banner_nav_right_banner5  wow flipInX animated" style="visibility: visible; animation-name: flipInX;">
            <!--<h3>Best Deals For New Products<span class="blink_me"></span></h3>-->
        </div>

        <div class="banner">
            <div class="w3l_banner">
                <!-- services -->
                <div class="services">
                    <!--<h3>Non-Basmathi</h3>-->
                    <div class="w3ls_service_grids">
                        <div class="col-md-6  wow zoomInLeft animated w3l_banner_nav_right_1_banner3_btml" style="animation-name: zoomInLeft;">
                            <img src="<?php echo URL . ASSET_IMG; ?>rice/q11.jpg" alt=" " class="img-responsive" />
                        </div>
                        <div class="col-md-5 col-sm-offset-1 wow fadeInLeftBig text-primary text-justify animated w3ls_service_grid_left" style="animation-name: fadeInLeftBig;">
                            <h4>Non-Basmathi</h4>
                            <p>Non Basmati Rice is gaining high popularity due to its long grain size and tempting aroma.
                                We are named among the top Manufacturers, Suppliers and Exporters of Parmal White Non Basmati Rice from Kurukshetra, Haryana.
                                In order to provide stone and husk free Parmal White Non Basmati Rice, we stringently check it before the final supply.</p>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                    <div class="fresh-vegetables">
                        <div class="container">
                            <!--<h3>Top Products</h3>-->
                            <div class="container">
                                <div class="w3l_banner_nav_right_banner3_btm text-justify">
                                    <div class="col-md-4 w3l_banner_nav_right_banner3_btml">
                                        
                                        <div class="view view-tenth">
                                            <img src="<?php echo URL . ASSET_IMG; ?>50.jpg" alt=" " class="img-responsive" />
                                            <div class="mask">
                                                <h4>Raw Rice</h4>
                                                <p> Raw Rice is good source of energy and rich in protein .  It can be grinded to make different types of dishes and snacks, beverages, etc</p>
                                            </div>
                                        </div>
                                        <h2><center>Raw Rice</center></h2>
                                    </div>
                                    <div class="col-md-4 w3l_banner_nav_right_banner3_btml">
                                        
                                        <div class="view view-tenth">
                                            <img src="<?php echo URL . ASSET_IMG; ?>54.jpg" alt=" " class="img-responsive" />
                                            <div class="mask">
                                                <h4>Steamed rice</h4>
                                                <p>The Steam Rice is demanded widely by the clients for the finest quality and availability at the reasonable price.</p>
                                            </div>
                                        </div>
                                        <h2><center>Steamed rice</center></h2>
                                    </div>
                                    <div class="col-md-4 w3l_banner_nav_right_banner3_btml">
                                        
                                        <div class="view view-tenth">
                                            <img src="<?php echo URL . ASSET_IMG; ?>rice/18.jpg" alt=" " class="img-responsive" />
                                            <div class="mask">
                                                <h4>Boiled Rice</h4>
                                                <p>It is a long grain rice with thin characteristics as compare to other types of rice and is rich in nutrition values.</p>
                                            </div>
                                        </div>
                                        <h2><center>Boiled Rice</center></h2>
                                    </div>
                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                        </div>

                        <!-- Db products -->
                        <div class="container">
                            <div class="w3ls_w3l_banner_nav_right_grid">
                                <h3>Popular Non Basmati Brand</h3>
                                <?php
                                if ($stm->rowCount()) {
                                    for ($i = 0; $i < $stm->rowCount(); $i++) {
                                        $id = explode("☻♥☻", $res[$i]['id']);
                                        $brand = explode("☻♥☻", $res[$i]['brand']);
                                        $category = explode("☻♥☻", $res[$i]['category']);
                                        $quantity = explode("☻♥☻", $res[$i]['quantity']);
                                        $price = explode("☻♥☻", $res[$i]['price']);
                                        $description = explode("☻♥☻", $res[$i]['description']);
                                        $photo = explode("☻♥☻", $res[$i]['photo']);
                                        $name = ucwords($res[$i]['name']);
                                        ?>

                                        <div class="w3ls_w3l_banner_nav_right_grid1">
                                            <h6><?php echo ($name); ?></h6>
                                            <?php
                                            for ($j = 0, $k = 1, $l = 4; $j < count($id); $j++, $k++) {
                                                ?>
                                                <div class="col-md-3 w3ls_w3l_banner_left">
                                                    <div class="hover14 column">
                                                        <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                                            <div class="agile_top_brand_left_grid1">
                                                                <figure>
                                                                    <div class="snipcart-item block">
                                                                        <div class="snipcart-thumb">
                                                                            <a href="<?php echo URL . MOD; ?>mail.php">
                                                                                <img src="<?php echo $photo[$j]; ?>" alt="<?php echo $brand[$j]; ?>" width="140" height="140"/>
                                                                            </a>
                                                                            <p><?php echo $brand[$j]; ?></p>
                                                                            <h4><?php echo $price[$j]; ?>/- Rs,<span>Qty : <?php echo $quantity[$j]; ?></span> Kg</h4>
                                                                        </div>
                                                                        <div class="snipcart-details">
                                                                            <form action="#" method="post">
                                                                                <fieldset>
                                                                                    <input type="button" name="submit" data-toggle="modal" data-target="#myModal<?php echo $i; ?>_<?php echo $j; ?>" value="More details" class="button" />
                                                                                </fieldset>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </figure>
                                                                <!-- Modal start-->
                                                                <div class="modal fade" id="myModal<?php echo $i; ?>_<?php echo $j; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content modal-info">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                            </div>
                                                                            <div class="modal-body modal-spa">
                                                                                <div class="col-md-5 span-2">
                                                                                    <div class="item">
                                                                                        <img src="<?php echo $photo[$j]; ?>" alt="<?php echo $brand[$j]; ?>" width="240" height="240"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-7 span-1 ">
                                                                                    <h3><?php echo $brand[$j]; ?>(<?php echo $quantity[$j]; ?> kg)</h3>
                                                                                    <p class="in-para"> <?php echo $brand[$j]; ?>,&nbsp; <?php echo ($name); ?></p>
                                                                                    <div class="price_single">
                                                                                        <span class="reducedfrom "><?php echo $price[$j]; ?>/- Rs</span>
                                                                                        <div class="clearfix"></div>
                                                                                    </div>
                                                                                    <h4 class="quick">Quick Overview:</h4>
                                                                                    <p class="quick_desc"><?php echo $description[$j]; ?></p>
                                                                                    <div class="add-to">
                                                                                        <!--<button class="btn btn-danger my-cart-btn my-cart-btn1 " data-id="1" data-name="Moong" data-summary="summary 1" data-price="1.50" data-quantity="1" data-image="images/of.png">Add to Cart</button>-->
                                                                                    </div>
                                                                                </div>
                                                                                <div class="clearfix"> </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal End-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($k == $l) {
                                                    $l += 4;
                                                    ?>
                                                    <div class="clearfix col-md-12 panel"> </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <div class="clearfix"> </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="col-md-3 w3ls_w3l_banner_left">
                                        <h2>No products to list.</h2>
                                        <div class="clearfix"> </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //fresh-vegetables -->
                <?php
                require_once DOC_ROOT . INC . 'footer.php';
                ?>
