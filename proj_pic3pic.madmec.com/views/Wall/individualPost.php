<?php
$create = (array) $this->idHolders["pic3pic"]["wall"]["create"];
?>
<!-- Modal for individual post-->
<div class="modal fade" id="<?php echo $create["parentDiv"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Post</h3>
            </div>
            <form class=""
                  id="<?php echo $create["form"]; ?>"
                  name="<?php echo $create["form"]; ?>"
                  action="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>UploadPic/posts"
                  method="post"
                  enctype="multipart/form-data">
                <fieldset>
                    <div class="modal-body">
                        <div class='conatiner'>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="file"
                                           name="<?php echo $create["postImg"]; ?>"
                                           id="<?php echo $create["postImg"]; ?>" />
                                </div>
                            </div>
                            <h4 class='text-center'>Upload / Post picture, we accept jpg, & png format. <br />(<strong>Max size:</strong>2.0 MB & <strong>Max Upload:</strong> 30 pics / day)</h4>
                            <div class="row">
                                <div class="col-lg-12"><h4>Title of the post.</h4></div>
                                <div class="col-lg-12">
                                    <input id="<?php echo $create["title"]; ?>" name="<?php echo $create["title"]; ?>" type="text" class="form-control" placeholder="Picture heading goes here..." aria-describedby="basic-addon1" required="required"/>
                                </div>
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12"><h4>Select Section.</h4></div>
                                <div class="col-lg-12" id="<?php echo $create["section"]; ?>"></div>
                                <div class="col-lg-12"><h4>Select target.</h4></div>
                                <div class="col-lg-12">
                                    <select class="form-control" id="<?php echo $create["target"]; ?>" name="<?php echo $create["target"]; ?>">
                                        <option value="0" selected="selected">World</option>
                                        <option value="Country">Country</option>
                                    </select>
                                </div>
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12">
                                    <div class="row" id="<?php echo $create["parentFild"]; ?>"></div>
                                </div>
                                <div class="col-lg-12">&nbsp;</div>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-addon woborder">
                                            <input type="checkbox" name="<?php echo $create["iagree"]; ?>" id="<?php echo $create["iagree"]; ?>" aria-label="..." required=""/>
                                        </span>
                                        <p class="wop"> I Agree to the <a href="#">Community Rules. </a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" name="<?php echo $create["close"]; ?>" id="<?php echo $create["close"]; ?>">Close</button>
                        <button type="submit" class="btn btn-primary" name="<?php echo $create["create"]; ?>" id="<?php echo $create["create"]; ?>">Post</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
