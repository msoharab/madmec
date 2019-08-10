<?php
$create = (array) $this->idHolders["nookleads"]["business"]["create"];
?>
<!-- Modal for create business-->
<div class="modal fade" id="<?php echo $create["parentDiv"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Create Business</h3>
            </div>
            <form class="" id="<?php echo $create["form"]; ?>" name="<?php echo $create["form"]; ?>" method="lead" action="">
                <fieldset>
                    <div class="modal-body">
                        <div class="conatiner">
                            <div class="row">
                                <div class="col-lg-12"><h4>Name of the business.</h4></div>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" name="<?php echo $create["name"]; ?>" placeholder="Business name" aria-describedby="basic-addon1" id="<?php echo $create["name"]; ?>">
                                </div>
                                <div class="col-lg-12"><h4>Select target.</h4></div>
                                <div class="col-lg-12">
                                    <select class="form-control" id="<?php echo $create["target"]; ?>" name="<?php echo $create["target"]; ?>">
                                        <option value="0" selected="selected">World</option>
                                        <option value="Country">Country</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="<?php echo $create["parentFild"]; ?>"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" name="<?php echo $create["close"]; ?>" id="<?php echo $create["close"]; ?>">Close</button>
                        <button type="submit" class="btn btn-primary" name="<?php echo $create["botton"]; ?>" id="<?php echo $create["botton"]; ?>">Create</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<!--End of create business modal-->