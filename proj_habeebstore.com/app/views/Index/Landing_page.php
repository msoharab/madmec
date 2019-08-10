<div>
    <section id="barr">
        <ul class="portfolio-filter">
            <li class="active" ><a href="#Latest" data-toggle="tab">Latest Gyms</a></li>
<!--            <li><a href="#Offers" data-toggle="tab">Offers</a></li>
            <li><a href="#Packages" data-toggle="tab">Packages</a></li>-->
        </ul><!--/#portfolio-filter-->
    </section>
    <section class="content-wrapper">
        <div class="content">
            <div class="box-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="Latest">
                        <?php
                        require_once 'latest.php';
                        ?>
                    </div>
                    <div class="tab-pane" id="Offers">
                        <?php
                        require_once 'offers.php';
                        ?>
                    </div>
                    <div class="tab-pane" id="Packages">
                        <?php
                        require_once 'packages.php';
                        ?>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div>
        </div>
    </section><!-- /.content -->
</div>
