<?php
$chad = $this->idHolders["nookleads"]["business"]["advertisement"];
$businessAdv = isset($this->BusinessDetails["chadd"]["chadd_img"][0]) && !empty($this->BusinessDetails["chadd"]["chadd_img"][0]) 
        ? $this->BusinessDetails["chadd"]["chadd_img"][0] : $this->config["DEFAULT_CHANEL_ADV_IMG"];
?>
<div class="panel">
    <div class="panel-heading">
        <h3>Advertisements</h3>
    </div>
    <div class="panel-body">
        <img src="<?php echo $businessAdv; ?>" class="img-responsive">
    </div>
    <div class="modal fade" id="<?php echo $chad["parentDiv"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class=""
                  id="<?php echo $chad["form"]; ?>"
                  name="<?php echo $chad["form"]; ?>"
                  action="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>UploadPic/business"
                  method="lead"
                  enctype="multipart/form-data">
                <fieldset>
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
                                    &times;</span>
                            </button>
                            <h3 class="modal-title" id="myModalLabel">Business Advertisement</h3>
                        </div>
                        <div class="modal-body">
                            <input
                                type="file"
                                name="<?php echo $chad["proIMGName"]; ?>"
                                id="<?php echo $chad["leadImg"]; ?>" />
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-default"
                                    data-dismiss="modal"
                                    name="<?php echo $chad["close"]; ?>"
                                    id="<?php echo $chad["close"]; ?>">Close</button>
                            <button type="submit"
                                    class="btn btn-primary"
                                    name="<?php echo $chad["create"]; ?>"
                                    id="<?php echo $chad["create"]; ?>">Update</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
