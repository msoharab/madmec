<?php
$filterPost = (array) $this->idHolders["pic3pic"]["channel"]["header"]["filter"]["list"];
?>
<!-- Modal for individual post-->
<div class="modal fade" id="<?php echo $filterPost["parentDiv"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form class="" 
              id="<?php echo $filterPost["form"]; ?>" 
              name="<?php echo $filterPost["form"]; ?>" 
              action="" 
              method="post" 
              enctype="multipart/form-data">
            <fieldset>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Filter post list.</h3>
                    </div>
                    <div class="modal-body">
                        <div class='conatiner'>
                            <div class="row">
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12"><h4>Select Section.</h4></div>
                                <div class="col-lg-12" id="<?php echo $this->idHolders["pic3pic"]["channel"]["header"]["filter"]["sections"]["outputDiv"]; ?>"></div>
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12"><h4>Select target.</h4></div>
                                <div class="col-lg-12">
                                    <select class="form-control" id="<?php echo $filterPost["target"]; ?>" name="<?php echo $filterPost["target"]; ?>">
                                        <option value="0" selected="selected">World</option>
                                        <option value="Country">Country</option>
                                    </select>
                                </div>
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12">
                                    <div class="row" id="<?php echo $filterPost["parentFild"]; ?>"></div>
                                </div>
                                <div class="col-lg-12">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" 
                                class="btn btn-default" 
                                data-dismiss="modal" 
                                name="<?php echo $filterPost["close"]; ?>" 
                                id="<?php echo $filterPost["close"]; ?>">Close</button>
                        <button type="button" 
                                data-dismiss="modal"
                                class="btn btn-primary" 
                                name="<?php echo $filterPost["create"]; ?>" 
                                id="<?php echo $filterPost["create"]; ?>">Filter</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
