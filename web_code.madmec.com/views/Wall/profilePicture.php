<?php $pic = (array) $this->idHolders["wall"]["profile"]["pic"]; ?>
<div class="list-group">
    <div class="panel">
        <div class="panel-body">
            <img src="<?php echo $this->config["DEFAULT_USER_ICON_IMG"]; ?>" alt="" class="img-responsive" id="" name="" style="margin-left: auto; margin-right: auto;"/>
        </div>
        <div class="footer">
            <button type="button" class="btn btn-deafult btn-block" type="button" id="<?php echo $list["moodalBut"]; ?>" name="<?php echo $list["moodalBut"]; ?>" data-toggle="modal" data-target="#<?php echo $list["parentDiv"]; ?>" data-whatever="@mdo">Change</button>
        </div>
    </div>
</div>
<div class="modal fade" id="<?php echo $list["parentDiv"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Post</h3>
            </div>
            <form class="" id="<?php echo $pic["form"]; ?>" name="<?php echo $pic["form"]; ?>" action="<?php echo $this->config["URL"].$this->config["CTRL_18"]; ?>UploadPic/profile" method="post" action="" enctype="multipart/form-data">
                <input type="file" name="profilepic" id="profilepic" />
            </form>
        </div>
    </div>
</div>
