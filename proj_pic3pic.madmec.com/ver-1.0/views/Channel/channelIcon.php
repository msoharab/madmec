<div class="modal fade" id="<?php echo $chicon["parentDiv"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form class="" 
              id="<?php echo $chicon["form"]; ?>" 
              name="<?php echo $chicon["form"]; ?>" 
              action="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>UploadPic/channel" 
              method="post" 
              enctype="multipart/form-data">
            <fieldset>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
                                &times;</span>
                        </button>
                        <h3 class="modal-title" id="myModalLabel">Channel Icon</h3>
                    </div>
                    <div class="modal-body">
                        <input 
                            type="file" 
                            name="<?php echo $chicon["proIMGName"]; ?>" 
                            id="<?php echo $chicon["postImg"]; ?>" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" 
                                class="btn btn-default" 
                                data-dismiss="modal" 
                                name="<?php echo $chicon["close"]; ?>" 
                                id="<?php echo $chicon["close"]; ?>">Close</button>
                        <button type="submit" 
                                class="btn btn-primary" 
                                name="<?php echo $chicon["create"]; ?>" 
                                id="<?php echo $chicon["create"]; ?>">Update</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
