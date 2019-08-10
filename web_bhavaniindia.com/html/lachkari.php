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
            AND ad.`name` LIKE  "%Lachkari%"
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
            <li>Lachkari Rice</li>
        </ul>
    </div>
</div>
<!-- //products-breadcrumb -->
<!-- banner -->
<div class="banner">
    <div class="w3l_banner">
        <div class="w3l_banner_nav_right_banner6  wow flipInY animated" style="animation-name: flipInY;">
            <!--<h3>Best Deals For New Products<span class="blink_me"></span></h3>-->
        </div>
        <div class="banner">
            <div class="w3l_banner">
                <div class="services">
                    <h3>Lachkari</h3>
                    <div class="w3l_fresh_vegetables_grids">
                        <div class="w3ls_service_grids col-lg-12">
                            <div class="col-md-6  w3ls_service_grid_left text-justify">
                                <h4>Lachkari</h4>
                                <p> We are engaged in manufacturing and supplying high quality as well as delicious Lachkari Kolam Rice that is popular for its high nutritious value.</p>
                                   <p> Easy to cook  Perfect taste Long and unbroken</p>
				<p>It is a long grain rice with thin characteristics as compare to other types of rice and is rich in nutrition values.
				Our rice is basically used in preparing steamed rice, pulao, birayani, kheer, upma, etc.</p>
                            </div>
                            <div class="col-md-6 wow rotateInDownRight animated w3l_banner_nav_right_banner3_btml" style="animation-name: rotateInDownRight;">
                                <img src="<?php echo URL . ASSET_IMG; ?>2.jpg" alt=" " class="img-responsive" />
                            </div>
                        </div>
                        <div class="w3ls_service_grids col-lg-12">
                            <div class="col-md-6 wow rotateInDownLeft animated w3ls_service_grids1_left" style="animation-name: rotateInDownLeft;">
                                <img src="<?php echo URL . ASSET_IMG; ?>59.jpg" alt=" " class="img-responsive" />
                            </div>
                            <div class="col-md-6 w3ls_service_grid_left1 text-justify">
                                <p>We process the Raw Lachkari Kolam Rice in our advanced unit using latest rice processing machineries that help us meet the demands of our valuable customers.</p>
                                    <p>Our finest quality Steam Lachkari Kolam Rice is highly appreciated by our valuable clients all over and thus, we have been recognized as a major manufacturer, exporter and wholesale supplier.</p>
                                    <p>The Lachkari Kolam Rice is excellent in taste and thus highly demanded in our indian  clients.</p>
                                <p> We offer Lachkari Kolam Rice in desired quantity and packaging, as per buyer’s discretion.</p>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="w3ls_service_grids col-lg-12">
                            <div class="col-md-6 w3ls_service_grid_left text-justify">
                                <!--<h4>Lachkari</h4>-->
                                <p> Lachkari Kolam Rice is famous world-over, courtesy its delectable taste & aroma, longer shelf life and easy boiling & cooking.</p>
                                   <p> Cultivated & processed under visionary guidance of expert quality controllers, our Lachkari Kolam Rice qualifies to international quality standards.</p>
                                   <p> We offer Lachkari Kolam Rice in desired quantity and packaging, as per buyers discretion.</p>
                                   <p>Lachkari Kolam Rice that is popular for its high nutritious value</p>
                            </div>
                            <div class="col-md-6 w3l_banner_nav_right_banner3_btml">
                                <img src="<?php echo URL . ASSET_IMG; ?>60.jpg" alt=" " class="img-responsive" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="top-brands">
                <div class="container">
                    <div class="w3ls_w3l_banner_nav_right_grid">
                        <h3>Top Lachkari Brand</h3>
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
        <!--<div class="clearfix"> </div>-->
    </div>
</div>
<!-- //fresh-vegetables -->
<?php
require_once DOC_ROOT . INC . 'footer.php';
?>
