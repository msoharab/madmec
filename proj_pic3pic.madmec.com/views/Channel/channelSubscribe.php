<div class="modal fade" 
     id="<?php echo $chsubscribe["parentDiv"]; ?>" 
     tabindex="-1" 
     role="dialog" 
     aria-labelledby="<?php echo $chsubscribe["moodalId"]; ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="<?php echo $chsubscribe["form"]; ?>" 
                  name="<?php echo $chsubscribe["form"]; ?>" 
                  method="post" 
                  action="<?php echo $chsubscribe["url"]; ?>" 
                  enctype="multipart/form-data">
                <fieldset>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title" 
                            id="<?php echo $chsubscribe["moodalId"]; ?>">Do you want to subscribe this channel ? Yes Or No.</h3>
                    </div>
                    <div class="modal-body">
                        <div class="conatiner">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" class="form-control" 
                                           id="<?php echo $chsubscribe["text"]; ?>" 
                                           name="<?php echo $chsubscribe["text"]; ?>"
                                           value="<?php echo $this->ChannelId; ?>"
                                           class="from-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" 
                                class="btn btn-default" 
                                data-dismiss="modal" 
                                name="<?php echo $chsubscribe["close"]; ?>" 
                                id="<?php echo $chsubscribe["close"]; ?>">No</button>
                        <button type="button" 
                                class="btn btn-primary" 
                                data-dismiss="modal" 
                                name="<?php echo $chsubscribe["create"]; ?>" 
                                id="<?php echo $chsubscribe["create"]; ?>">Yes</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
