<?php
define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
require_once DOC_ROOT . INC . 'header.php';
//$link = MySQLconnect(DBHOST, DBUSER, DBPASS);
//if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
//    if (isset($_GET['id'])) {
//        $id = $_GET['id'];
//        $query="SELECT bg.* from product AS bg LEFT JOIN photo AS ph ON bg.image=ph.id WHERE bg.id='$id'";
//        $result = executeQuery($query);
//        if (mysql_num_rows($result)) {
//        while ($row = mysql_fetch_assoc($result)) {
//            $fetchdata[] = $row;
//        }
//    }
//}
//}
?>
<!-- products-breadcrumb -->
<div class="products-breadcrumb">
    <div class="container">
        <ul>
            <li>Details Of Product</li>
        </ul>
    </div>
</div>
<!-- //products-breadcrumb -->
<!-- banner -->
<div class="banner">
    <div class="w3l_banner">
        <div class="w3l_banner_nav_right_banner3">
            <h3>Best Deals For New Products<span class="blink_me"></span></h3>
        </div>
        <div class="agileinfo_single">
            <h5>charminar pulao basmati rice 5 kg</h5>
            <div class="col-md-4 agileinfo_single_left">
                <img id="example" src="<?php echo URL . ASSET_IMG; ?>76.png" alt=" " class="img-responsive" />
            </div>
            <div class="col-md-8 agileinfo_single_right">
                <div class="rating1">
                    <span class="starRating">
                        <input id="rating5" type="radio" name="rating" value="5">
                        <label for="rating5">5</label>
                        <input id="rating4" type="radio" name="rating" value="4">
                        <label for="rating4">4</label>
                        <input id="rating3" type="radio" name="rating" value="3" checked>
                        <label for="rating3">3</label>
                        <input id="rating2" type="radio" name="rating" value="2">
                        <label for="rating2">2</label>
                        <input id="rating1" type="radio" name="rating" value="1">
                        <label for="rating1">1</label>
                    </span>
                </div>
                <div class="w3agile_description">
                    <h4>Description :</h4>
                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                        officia deserunt mollit anim id est laborum.Duis aute irure dolor in
                        reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                        pariatur.</p>
                </div>
                <div class="snipcart-item block">
                    <div class="snipcart-thumb agileinfo_single_right_snipcart">
                        <h4>Rs:450.00 <span>Rs:520.00</span></h4>
                    </div>
                    <div class="snipcart-details agileinfo_single_right_details">
                        <form action="#" method="post">
                            <fieldset>
                                <input type="hidden" name="cmd" value="_cart" />
                                <input type="hidden" name="add" value="1" />
                                <input type="hidden" name="business" value=" " />
                                <input type="hidden" name="item_name" value="Non Basmati rice" />
                                <input type="hidden" name="amount" value="450.00" />
                                <input type="hidden" name="discount_amount" value="20.00" />
                                <input type="hidden" name="currency_code" value="INR" />
                                <input type="hidden" name="return" value=" " />
                                <input type="hidden" name="cancel_return" value=" " />
                                <input type="submit" name="submit" value="Order Now" class="button" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- //banner -->
<!-- brands -->
<div class="w3ls_w3l_banner_nav_right_grid w3ls_w3l_banner_nav_right_grid_popular">
    <div class="container">
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
<!-- //brands -->
<?php
require_once DOC_ROOT . INC . 'footer.php';
?>
