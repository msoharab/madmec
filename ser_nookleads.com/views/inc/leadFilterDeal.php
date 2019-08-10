<?php
$filterLead = (array) $this->idHolders["nookleads"]["deal"]["header"]["filter"]["list"];
?>
<!-- Modal for individual lead-->
<div class="modal fade" id="<?php echo $filterLead["parentDiv"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form class="" 
              id="<?php echo $filterLead["form"]; ?>" 
              name="<?php echo $filterLead["form"]; ?>" 
              action="" 
              method="lead" 
              enctype="multipart/form-data">
            <fieldset>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Filter lead list.</h3>
                    </div>
                    <div class="modal-body">
                        <div class='conatiner'>
                            <div class="row">
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12"><h4>Select Section.</h4></div>
                                <div class="col-lg-12" id="<?php echo $this->idHolders["nookleads"]["deal"]["header"]["filter"]["sections"]["outputDiv"]; ?>"></div>
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12"><h4>Select target.</h4></div>
                                <div class="col-lg-12">
                                    <select class="form-control" id="<?php echo $filterLead["target"]; ?>" name="<?php echo $filterLead["target"]; ?>">
                                        <option value="0" selected="selected">World</option>
                                        <option value="Country">Country</option>
                                    </select>
                                </div>
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12">
                                    <div class="row" id="<?php echo $filterLead["parentFild"]; ?>"></div>
                                </div>
                                <div class="col-lg-12">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" 
                                class="btn btn-default" 
                                data-dismiss="modal" 
                                name="<?php echo $filterLead["close"]; ?>" 
                                id="<?php echo $filterLead["close"]; ?>">Close</button>
                        <button type="button" 
                                data-dismiss="modal"
                                class="btn btn-primary" 
                                name="<?php echo $filterLead["create"]; ?>" 
                                id="<?php echo $filterLead["create"]; ?>">Filter</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
