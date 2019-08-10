<?php
$pic = (array) $this->idHolders["pic3pic"]["profile"]["pic"];
$profilepic = $_SESSION["USERDATA"]["logindata"]["profic"];
?>
<div class="list-group">
    <div class="panel">
        <div class="panel-body">
            <img src="<?php echo $profilepic; ?>" alt="" class="img-responsive img-circle"
                 style="margin-left: auto; margin-right: auto;"
                 />
        </div>
        <div class="footer">
            <button type="button"
                    class="btn btn-deafult btn-block"
                    id="<?php echo $pic["parentBut"]; ?>" name="<?php echo $pic["parentBut"]; ?>"
                    data-toggle="modal"
                    data-target="#<?php echo $pic["parentDiv"]; ?>"
                    data-whatever="@mdo">Change</button>
        </div>
    </div>
</div>
<div class="modal fade" id="<?php echo $pic["parentDiv"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form class=""
              id="<?php echo $pic["form"]; ?>"
              name="<?php echo $pic["form"]; ?>"
              action="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>UploadPic/profile"
              method="post"
              enctype="multipart/form-data">
            <fieldset>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
                                &times;</span>
                        </button>
                        <h3 class="modal-title" id="myModalLabel">Profile Picture</h3>
                    </div>
                    <div class="modal-body">
                        <input
                            type="file"
                            name="<?php echo $pic["proIMGName"]; ?>"
                            id="<?php echo $pic["postImg"]; ?>" />
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-default"
                                data-dismiss="modal"
                                name="<?php echo $pic["close"]; ?>"
                                id="<?php echo $pic["close"]; ?>">Close</button>
                        <button type="submit"
                                class="btn btn-primary"
                                name="<?php echo $pic["create"]; ?>"
                                id="<?php echo $pic["create"]; ?>">Update</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
