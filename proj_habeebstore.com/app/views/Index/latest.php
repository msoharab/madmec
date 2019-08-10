<div class="row">
    <div class="panel panel-body">
        <div class="col-xs-12">
            <?php
            if (isset($this->gymPanelView["data"])):
                for ($i = 0; $i < count($this->gymPanelView["data"]); $i++) {
                    ?>

                    <div class="col-md-3 col-sm-6 ">
                        <h3><span><?php echo $this->gymPanelView["data"][$i]["gymname"]; ?><span></h3>
                                    <div>
                                                <!--<img src="<?php echo $this->gymPanelView["data"][$i]["short_logo"]; ?>" class="img-responsive" />-->
                                        <img src="../views/assets/images/04.jpg" class="img-responsive" alt=""/>

                                        <span class="pull-left"><a a onclick="window.location.href = '<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_1"] . 'ViewOffer/' . $this->gymPanelView["data"][$i]["gymid"]; ?>'"
                                                                    style="cursor:pointer;">Offers</a></span>
                                        <span class="pull-right"><a onclick="window.location.href = '<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_1"] . 'ViewOffer/' . $this->gymPanelView["data"][$i]["gymid"]; ?>'"
                                                                    style="cursor:pointer;">Packages</a></span><br>
                                        <span><?php echo $this->gymPanelView["data"][$i]["gymtown"]; ?></span>
                                        <span class="pull-right"><a href=""><?php echo $this->gymPanelView["data"][$i]["gymemail"]; ?></a></span><br>
                                        <span><?php echo $this->gymPanelView["data"][$i]["gymcell"]; ?></span>

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
