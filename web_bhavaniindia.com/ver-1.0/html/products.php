<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
require_once DOC_ROOT . INC . 'header.php';
//$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
//if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
//if (isset($_GET['id'])) {
//$id = $_GET['id'];
//$query = "SELECT bg.* from product AS bg LEFT JOIN photo AS ph ON bg.image=ph.id WHERE bg.id='$id'";
//$result = executeQuery($query);
?>
<!-- products-breadcrumb -->
<div class="products-breadcrumb">
    <div class="container">
        <ul>
            <li>Branded Rice</li>
        </ul>
    </div>
</div>
<!-- //products-breadcrumb -->
<!-- banner -->
<div class="banner">
    <div class="w3l_banner">
        <div class="w3l_banner_nav_right_banner3 animated fadeInLeftBig">
            <h3  class="animated rotateInDownLeft">We ensure the best quality rice to our buyer</h3>
        </div>
        <div class="container">
            <!-- fresh-vegetables -->
            <div class="w3l_banner_nav_right_banner3_btm">
                <div class="col-md-4 w3l_banner_nav_right_banner3_btml">
                    <div class="view view-tenth">
                        <img src="<?php echo URL . ASSET_IMG; ?>product/sp3.png" alt=" " class="animated fadeInLeft img-responsive" />
                    </div>
                    <h4 class="text-center">Non Basmati Rice</h4>
                </div>
                <div class="col-md-4 w3l_banner_nav_right_banner3_btml">
                    <div class="view view-tenth">
                        <img src="<?php echo URL . ASSET_IMG; ?>product/sp2.jpg" alt=" " class="animated fadeInRight img-responsive" />
                    </div>
                    <h4 class="text-center">Sona Masoori Rice</h4>
                </div>
                <div class="col-md-4 w3l_banner_nav_right_banner3_btml">
                    <div class="view view-tenth">
                        <img src="<?php echo URL . ASSET_IMG; ?>product/sp1.jpg" alt=" " class="animated fadeInRight img-responsive" />
                    </div>
                    <h4 class="text-center">Lachkari Rice</h4>
                </div>
                <div class="clearfix"> </div>
            </div>
            <!-- //fresh-vegetables -->
            <div class="w3ls_w3l_banner_nav_right_grid">
                <h3>Popular Brands</h3>
                <div class="w3ls_w3l_banner_nav_right_grid1">
                    <h6>Sona Masoori</h6>
                    <!--                    <div class="col-md-3 w3ls_w3l_banner_left">
                                            <div class="hover14 column">
                                                <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                    <?php
//                                if (mysql_num_rows($result)) {
//                                while ($row = mysql_fetch_array($result)) {
//                                $fetchdata[] = $row;
                    ?>
                                                    <div class="agile_top_brand_left_grid1">

                                                        <figure>
                                                            <div class="snipcart-item block">
                                                                <div class="snipcart-thumb">
                                                                    <a href="<?php echo URL . MOD; ?>view.php?id=<?php echo $id; ?>"><img src="../<?php echo $fetchdata[0]['ver2']; ?>" alt=" " class="img-responsive" /></a>
                                                                    <p><?php echo $fetchdata[0]['product_name']; ?></p>
                                                                    <h4><?php echo $fetchdata[0]['price']; ?><span>$8.00</span></h4>
                                                                </div>
                                                                <div class="snipcart-details">
                                                                    <form action="#" method="post">
                                                                        <fieldset>
                                                                            <input type="submit" name="submit" value="Order Now" class="button" />
                                                                        </fieldset>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </figure>
                                                    </div>
                    <?php
//                                }
//                                }
                    ?>
                                                </div>
                                            </div>
                                        </div>-->
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p13.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p14.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p15.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p4.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="w3ls_w3l_banner_nav_right_grid1">
                    <h6>Lachkari</h6>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p25.png" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p6.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p7.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p8.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="w3ls_w3l_banner_nav_right_grid1">
                    <h6>Non Basmati</h6>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p9.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p10.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p11.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 w3ls_w3l_banner_left">
                        <div class="hover14 column">
                            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                <div class="agile_top_brand_left_grid1">
                                    <figure>
                                        <div class="snipcart-item block">
                                            <div class="snipcart-thumb">
                                                <a href="<?php echo URL . MOD; ?>view.php"><img src="<?php echo URL . ASSET_IMG; ?>product/p12.jpg" alt=" " class="img-responsive" /></a>
                                                <p>Brand Name</p>
                                                <h4>Rs. 1500<span>Rs. 1600</span></h4>
                                            </div>
                                            <div class="snipcart-details">
                                                <form action="#" method="post">
                                                    <fieldset>
                                                        <input type="submit" name="submit" value="Order Now" class="button" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>
    <?php
//    }
//    }
    ?>
    <div class="clearfix"></div>
</div>
<!-- //banner -->
<?php
require_once DOC_ROOT . INC . 'footer.php';
?>
