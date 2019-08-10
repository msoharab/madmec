<?php
$ListGymPanelView = isset($this->idHolders["tamboola"]["home"]["ListGymPanelView"]) ? (array) $this->idHolders["tamboola"]["home"]["ListGymPanelView"] : false;
?>
<div class="box-body">
    <div class="row">
        <?php
        if (isset($this->gymPanelView["data"])):
            for ($i = 0; $i < count($this->gymPanelView["data"]); $i++) {
                ?>
                <div class="col-md-3 col-sm-6 col-xs-12" 
                     id="<?php echo $ListGymPanelView["fields"][0] . '_' . $this->gymPanelView["data"][$i]["gymid"]; ?>" 
                     onclick="window.location.href='<?php echo $this->config["URL"] .$this->config["CTRL_35"] . 'SetGym/'.$this->gymPanelView["data"][$i]["gymid"]; ?>'"
                     style="cursor:pointer;">
                    <div class= "info-box panel panel-default">
                        <span class="info-box-icon bg-aqua">
                            <img src="<?php echo $this->gymPanelView["data"][$i]["short_logo"]; ?>" class="img-circle img-responsive" />
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                <?php echo $this->gymPanelView["data"][$i]["gymname"]; ?> ,- ,
                                <?php echo $this->gymPanelView["data"][$i]["gymemail"]; ?> , - , 
                                <?php echo $this->gymPanelView["data"][$i]["gymcell"]; ?>
                            </span>
                            <span class="info-box-number">
                                Registration Fee
                                <small><?php echo $this->gymPanelView["data"][$i]["gymregfee"]; ?>&nbsp;Rs</small>
                            </span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="clearfix visible-sm-block"></div>
                <?php
            }
        else:
            ?>
            <div class="col-lg-12" >
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_35"] . 'addGym'; ?>" class="btn btn-block btn-success">Add a Gym</a>
            </div>
        <?php
        endif;
        ?>
    </div>
</div>
