<div class="modal fade" 
     id="<?php echo $chblock["parentDiv"]; ?>" 
     tabindex="-1" 
     role="dialog" 
     aria-labelledby="<?php echo $chblock["moodalId"]; ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="<?php echo $chblock["form"]; ?>" 
                  name="<?php echo $chblock["form"]; ?>" 
                  method="lead" 
                  action="<?php echo $chblock["url"]; ?>" 
                  enctype="multipart/form-data">
                <fieldset>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title" 
                            id="<?php echo $chblock["moodalId"]; ?>">Do you want to block this business ? Yes Or No..</h3>
                    </div>
                    <div class="modal-body">
                        <div class="conatiner">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" class="form-control" 
                                           id="<?php echo $chblock["text"]; ?>" 
                                           name="<?php echo $chblock["text"]; ?>"
                                           value="<?php echo $this->BusinessId; ?>"
                                           class="from-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" 
                                class="btn btn-default" 
                                data-dismiss="modal" 
                                name="<?php echo $chblock["close"]; ?>" 
                                id="<?php echo $chblock["close"]; ?>">No</button>
                        <button type="button" 
                                class="btn btn-primary" 
                                data-dismiss="modal" 
                                name="<?php echo $chblock["create"]; ?>" 
                                id="<?php echo $chblock["create"]; ?>">Yes</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
