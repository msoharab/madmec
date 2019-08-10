<?php
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
            GROUP BY (ad.`name`)
            ORDER BY (ad.`id`) DESC;');
    $res = $stm->execute();
    $res = $stm->fetchAll();
}
?><!-- banner -->
<div class="banner">
    <div class="w3l_banner">
        <section class="slider">
            <div class="flexslider">
                <ul class="slides">
                    <li>
                        <div class="w3l_banner_nav_right_banner">
                            <h1 class="animated fadeInLeft" style="margin-right: -34px; color:white; font-weight:bold">Quality is our  priority.</h1>
                            <!--                            <div class="more">
                                                            <a href="<?php echo URL . MOD; ?>contact_us.php" class="button--saqui button--round-l button--text-thick" data-text="Engage with us now">Engage with us now</a>
                                                        </div>-->
                        </div>
                    </li>
                    <li>
                        <div class="w3l_banner_nav_right_banner1">
                            <h3 class="animated fadeInLeft" style="color: #262626; font-weight:bold;">we provide superior quality..</h3>
                            <!--                            <div class="more">
                                                            <a href="<?php echo URL . MOD; ?>contact_us.php" class="button--saqui button--round-l button--text-thick" data-text="Engage with us now">Engage with us now</a>
                                                        </div>-->
                        </div>
                    </li>
                    <li>
                        <div class="w3l_banner_nav_right_banner2">
                            <h3 class="animated fadeInLeftBig" style="font-weight:bold">Provide quality rice with commitment</h3>
                            <!--                            <div class="more">
                                                            <a href="<?php echo URL . MOD; ?>contact_us.php" class="button--saqui button--round-l button--text-thick" data-text="Engage with us now">Engage with us now</a>
                                                        </div>-->
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </div>
    <div class="clearfix"></div>
</div>
<!-- banner -->
<!-- about -->
<div class="privacy about text-justify">
    <h3><span> &nbsp  Welcome to Sree Bhavani Enterprises</span> </h3>
    <div class="agile_about_grids">
        <div class="col-md-6 agile_about_grid_left">
            <div class="animi wow animated fadeInLeftBig blog-content " >
                <p class="animi">Rice is the ancient and venerable grain which has been cultivated since 2000 BC,
                    and today, rice is a staple food for almost half the world`s population. The 7,000-plus varieties of rice are grown all
                    over the world. Aquatic rice (paddy-grown) is cultivated in flooded fields, which occupies a major portion in the Indian cuisine
                    and India is home for many varieties of this paddy-grown rice.</p>
                <p class="animi">Sree Bhavani Enterprises  is one of the prime rice trader/rice broker based in Bangalore,India due to its direct tie-ups with rice mills and rice suppliers ensuring best quality rice.All our suppliers are primarily dependent on us because of large network of our buyer  </p>
                <p class="animi">We reckoned as one of the prime exporters and suppliers of rice based in Bangalore,India.We specialize in all South Indian rice varieties (non-Basmati short grain rice) and distribute  all over india</p>
                <p class="animi">Sree Bhavani Enterprises is commited to meet buyer requirements and exceeding buyer expectations, while producing healthy, safe and hygienic products.</p>
            </div>
        </div>
        <div class="col-md-5 col-lg-offset- agile_about_grid">
            <img src="<?php echo URL . ASSET_IMG; ?>rice/q14.png" alt=" " class="img-responsive2" />
        </div>
        <div class="clearfix"> </div>
    </div>
</div>
<!-- //about -->
<!-- top-brands -->
<div class="container">
<div class="w3ls_w3l_banner_nav_right_grid">
    <h3>Recently Added Brands</h3>
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
                <h6><?php echo ucfirst($name);?></h6>
                <?php
                for ($j = 0; $j < count($id) && $j < 4 && isset($id[$j]); $j++) {
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
                                                    <div class="col-md-5 span-2 ">
                                                        <div class="item">
                                                            <img src="<?php echo $photo[$j]; ?>" alt="<?php echo $brand[$j]; ?>" width="240" height="240"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 span-1">
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
<!-- //top-brands -->
<!-- fresh-vegetables -->
<div class="fresh-vegetables">
    <div class="container">
        <h3>Top Products</h3>
        <div class="container">
            <div class="w3l_banner_nav_right_banner3_btm text-justify">
                <div class="col-md-4 w3l_banner_nav_right_banner3_btml">
                    <div class="view view-tenth">
                        <img src="<?php echo URL . ASSET_IMG; ?>product/sp3.png" alt=" " class="img-responsive" />
                        <div class="mask">
                            <h4>Non Basmati</h4>
                            <p>Non Basmati Rice is gained high popularity due to its long grain size and tempting aroma..</p>
                        </div>
                    </div>
                    <h4 style="text-align: center">Non Basmati Rice</h4>
                    <ol style="list-style-type:none">
                        <li><i class="fa fa-minus"></i> We have been offering our Non Basmati Broken Rice at competitive market rates.</li>
                        <li><i aria-hidden="true" class="fa fa-minus"></i> We are known as the provider of pure quality rice.</li>
                        <li><i aria-hidden="true" class="fa fa-minus"></i> We offer premium quality Non Basmati Broken Rice that is rich carbohydrates and starch. </li>
                        <li><i aria-hidden="true" class="fa fa-minus"></i> Our Non Basmati Rice is free from all kinds of alien materials, and thus it ideal for human consumption</li>
                    </ol>
                </div>
                <div class="col-md-4 w3l_banner_nav_right_banner3_btml">
                    <div class="view view-tenth">
                        <img src="<?php echo URL . ASSET_IMG; ?>product/sp1.jpg" alt=" " class="img-responsive" />
                        <div class="mask">
                            <h4>Lachkari</h4>
                            <p>The Lachkari Kolam Rice is excellent in taste and thus highly demanded in our indian clients.</p>
                        </div>
                    </div>
                    <h4 style="text-align: center">Lachkari Rice</h4>
                    <ol style="list-style-type: none">
                        <li><i aria-hidden="true" class="fa fa-minus"></i> Long and unbroken</li>
                        <li><i aria-hidden="true" class="fa fa-minus"></i> We offer Lachkari Kolam Rice in desired quantity and packaging, as per buyer’s discretion.</li>
                        <li><i aria-hidden="true" class="fa fa-minus"></i> It is a long grain rice with thin characteristics as compare to other types of rice</li>
                        <li><i aria-hidden="true" class="fa fa-minus"></i> Lachkari Kolam Rice that is popular for its high nutritious value</li>
                    </ol>
                </div>
                <div class="col-md-4 w3l_banner_nav_right_banner3_btml">
                    <div class="view view-tenth">
                        <img src="<?php echo URL . ASSET_IMG; ?>product/sp2.jpg" alt=" " class="img-responsive" />
                        <div class="mask">
                            <h4>Sona Masoori</h4>
                            <p>Sona Masoori Rice, we process, is highly appreciated for the taste and aroma..</p>
                        </div>
                    </div>
                    <h4 style="text-align: center">Sona Masoori Rice</h4>
                    <ol style="list-style-type: none">
                        <li><i aria-hidden="true" class="fa fa-minus"></i> Our Sona Masoori Rice is easily cooked and develops rich flavor once cooked.</li>
                        <li><i aria-hidden="true" class="fa fa-minus"></i> We process Sona Masoori Raw Rice,</li>
                        <li><i aria-hidden="true" class="fa fa-minus"></i> This rice is softer and has got a unique taste and flavour</li>
                        <li><i aria-hidden="true" class="fa fa-minus"></i> We provide our Sona Masoori Rice at market leading prices. </li>
                    </ol>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
</div>
<!-- //fresh-vegetables -->
