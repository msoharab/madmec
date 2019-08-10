<!-- modal for Channel report start-->
<div class="modal fade bs-example-modal-sm"  id="<?php echo $chreport["parentDiv"]; ?>" 
     tabindex="-1" 
     role="dialog" 
     aria-labelledby="<?php echo $chreport["moodalId"]; ?>">
    <div class="modal-dialog modal-sm">
        <div class="modal-content col-lg-12">
            <form id="<?php echo $chreport["form"]; ?>" 
                  name="<?php echo $chreport["form"]; ?>" 
                  method="post" 
                  action="<?php echo $chreport["url"]; ?>" 
                  enctype="multipart/form-data">
                <fieldset>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="<?php echo $chreport["moodalId"]; ?>"><strong>Report This Channel</strong></h4>
                    </div>
                    <div class="modal-body">
                        <h4>What is the Issue .. ?</h4>
                        <div class="row"            
                             id="<?php echo $chreport["outputDiv"] . $channelId; ?>">
                            <div class="col-lg-12">
                                <input type="hidden" class="form-control" 
                                       id="<?php echo $chreport["text"]; ?>" 
                                       name="<?php echo $chreport["text"]; ?>"
                                       value="<?php $channelId; ?>"
                                       class="from-control" />
                            </div>
                            <div class="col-lg-12">
                                <?php
                                for ($lp = 0; $lp < count($chreport) && isset($chreport[$lp]); $lp++) {
                                    if ($chreport[$lp]["status_id"] === 4):
                                        ?>
                                        <div class="input-group" name="<?php echo $channelId; ?>" data-bind="<?php echo $chreport[$lp]["acid"]; ?>">
                                            <span class="input-group-addon woborder">
                                                <input type="radio" aria-label="..." id="<?php echo $chreport[$lp]["id"] . $channelId; ?>" 
                                                       name="<?php echo $chreport[$lp]["name"]; ?>" 
                                                       class="<?php echo $chreport[$lp]["class"]; ?>"/>
                                            </span>
                                            <p class="wop"><?php echo $chreport[$lp]["text"]; ?></p>
                                        </div>
                                        <?php
                                    endif;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" 
                                class="btn btn-default" 
                                data-dismiss="modal" 
                                name="<?php echo $chreport["close"]; ?>" 
                                id="<?php echo $chreport["close"]; ?>">Close</button>
                        <button type="submit" 
                                class="btn btn-primary" 
                                name="<?php echo $chreport["create"]; ?>" 
                                id="<?php echo $chreport["create"]; ?>">Report</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>    
<!-- modal for Channel report end-->
