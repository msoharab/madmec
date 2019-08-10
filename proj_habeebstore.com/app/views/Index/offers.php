
<section class="content-wrapper">
    <div class="content">
        <div class="box-body">
            <div class="tab-content"><div class="row">
                    <div class="panel panel-body">
                         <h2 class="text-center">OFFERS</h2>
                        <div class="col-xs-12">
                            <?php
                            if (isset($this->gymPanelView["data"])):
                                for ($i = 0; $i < count($this->gymPanelView["data"]); $i++) {
                                    ?>

                                    <div class="col-md-2 col-sm-6">
                                        <div>
                                            <img src="../../views/assets/images/06.jpg" class="img-responsive" alt=""/>
                                            <h3><span><a href=""><?php echo $this->gymPanelView["data"][$i]["offname"]; ?></a><span></h3>
                                                        <span>Cost - <?php echo $this->gymPanelView["data"][$i]["offcost"]; ?></span>
                                                        <span class="pull-right">Facility - <?php echo $this->gymPanelView["data"][$i]["off_fac"]; ?></span><br>
                                                        <span>No of Members - <?php echo $this->gymPanelView["data"][$i]["offmem"]; ?></span>

                                                        </div>
                                                        </div>
                                                        <?php
                                                    }
                                                else:
                                                    ?>

                                                <?php
                                                endif;
                                                ?>
                                                </div>
                                                </div>
                                                </div>
                                                </div><!-- /.tab-content -->
                                                </div>
                                                </div>
                                                </section><!-- /.content -->
                                                <!--<div class="row">
                                                    <div class="panel panel-body">
                                                        <div class="col-xs-12">
                                                            <div class="col-md-3 col-sm-6">
                                                                <h3><span>Gym Name<span></h3>
                                                                            <div class="fix single_content_feature">
                                                                                <a href=""><img src="../views/assets/images/01.jpg" class="img img-responsive" alt=""/></a><br>
                                                                                <span><strong>August 4 2010,</strong> <a href="">8 Comments</a></span>
                                                                            </div>
                                                                            </div>
                                                                            <div class="col-md-3 col-sm-6 ">
                                                                                <h3><span>Gym Name<span></h3>
                                                                                            <div class="fix single_content_feature">
                                                                                                <a href=""><img src="../views/assets/images/04.jpg" class="img img-responsive" alt=""/></a><br>
                                                                                                <span><strong>August 4 2010,</strong> <a href="">8 Comments</a></span>
                                                                                            </div>
                                                                                            </div>
                                                                                            <div class="col-md-3 col-sm-6 ">
                                                                                                <h3><span>Gym Name<span></h3>
                                                                                                            <div class="fix single_content_feature">
                                                                                                                <a href=""><img src="../views/assets/images/05.jpg" class="img img-responsive" alt=""/></a><br>
                                                                                                                <span><strong>August 4 2010,</strong> <a href="">8 Comments</a></span>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3 col-sm-6 ">
                                                                                                                <h3><span>Gym Name<span></h3>
                                                                                                                            <div class="fix single_content_feature">
                                                                                                                                <a href=""><img src="../views/assets/images/06.jpg" class="img img-responsive" alt=""/></a><br>
                                                                                                                                <span><strong>August 4 2010,</strong> <a href="">8 Comments</a></span>
                                                                                                                            </div>
                                                                                                                            </div>
                                                                                                                            </div>
                                                                                                                            <div class="col-xs-12">
                                                                                                                                <div class="col-md-3 col-sm-6">
                                                                                                                                    <h3><span>Gym Name<span></h3>
                                                                                                                                                <div class="fix single_content_feature">
                                                                                                                                                    <a href=""><img src="../views/assets/images/07.jpg" class="img img-responsive" alt=""/></a><br>
                                                                                                                                                    <span><strong>August 4 2010,</strong> <a href="">8 Comments</a></span>
                                                                                                                                                </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="col-md-3 col-sm-6 ">
                                                                                                                                                    <h3><span>Gym Name<span></h3>
                                                                                                                                                                <div class="fix single_content_feature">
                                                                                                                                                                    <a href=""><img src="../views/assets/images/08.jpg" class="img img-responsive" alt=""/></a><br>
                                                                                                                                                                    <span><strong>August 4 2010,</strong> <a href="">8 Comments</a></span>
                                                                                                                                                                </div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="col-md-3 col-sm-6 ">
                                                                                                                                                                    <h3><span>Gym Name<span></h3>
                                                                                                                                                                                <div class="fix single_content_feature">
                                                                                                                                                                                    <a href=""><img src="../views/assets/images/01.jpg" class="img img-responsive" alt=""/></a><br>
                                                                                                                                                                                    <span><strong>August 4 2010,</strong> <a href="">8 Comments</a></span>
                                                                                                                                                                                </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                <div class="col-md-3 col-sm-6 ">
                                                                                                                                                                                    <h3><span>Gym Name<span></h3>
                                                                                                                                                                                                <div class="fix single_content_feature">
                                                                                                                                                                                                    <a href=""><img src="../views/assets/images/02.jpg" class="img img-responsive" alt=""/></a></br>
                                                                                                                                                                                                    <span><strong>August 4 2010,</strong> <a href="">8 Comments</a></span>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                </div>-->