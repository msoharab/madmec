<?php
$listComment = $this->idHolders["pic3pic"]["channel"]["home"]["list"]["comment"]["list"];
if (isset($this->ploop) && is_numeric($this->ploop) && is_array($this->listPost)) {
    $i = $this->ploop;
    $newRes = (array) $this->listPost;
} else if (isset($this->post_id) && is_numeric($this->post_id) && is_array($this->listPost) && $this->post_id > 0) {
    for ($j = 0; $j < count($this->listPost); $j++) {
        if ($this->post_id === $this->listPost[$j]["posts"]["id"]) {
            $i = $j;
            $newRes = (array) $this->listPost;
            break;
        }
    }
}
$this->commentNo = 0;
if (isset($newRes[$i]["posts"]["pc_ct"]) && $newRes[$i]["posts"]["pc_ct"] != '') {
    $this->commentNo = $newRes[$i]["posts"]["pc_ct"];
}
if ($this->commentNo > 0) :
    for ($lp = 0; is_array($newRes[$i]["posts"]["comments"]["pc_id"]) &&
            $lp < count($newRes[$i]["posts"]["comments"]["pc_id"]) &&
            isset($newRes[$i]["posts"]["comments"]["pc_id"][$lp]) &&
            $newRes[$i]["posts"]["comments"]["pc_id"][$lp] != ''; $lp++) {
        $cimage = false;
        $tmpImg = array();
        if ($newRes[$i]["posts"]["comments"]["pc_pic_flag"][$lp] && isset($newRes[$i]["posts"]["comments"]["pc_ph"][$lp]) && !empty($newRes[$i]["posts"]["comments"]["pc_ph"][$lp])
        ) {
            array_push($tmpImg, $newRes[$i]["posts"]["comments"]["pc_ph"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv1"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv2"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv3"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv4"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv5"][$lp]
            );
        }
        if (count($tmpImg) > 0 && $newRes[$i]["posts"]["comments"]["pc_pic_flag"][$lp]) {
            $minKB = 1024 * 10;
            $maxKB = 1024 * 70;
            for ($lpp = 0; $lpp < count($tmpImg); $lpp++) {
                $df = $this->config["DOC_ROOT"] . $tmpImg[$lpp];
                if (file_exists($df)) {
                    $actKB = filesize($df);
                    if ($actKB >= $minKB && $actKB <= $maxKB) {
                        $cimage = $this->config["URL"] . $tmpImg[$lpp];
                        break;
                    }
                }
            }
            if (!$cimage)
                $cimage = $this->config["URL"] . $tmpImg[0];
        }
        if (!$cimage && $newRes[$i]["posts"]["comments"]["pc_pic_flag"][$lp]) {
            $cimage = $this->config["DEFAULT_COMENT_IMG"];
        }
        $postCommentTime = '';
        if (isset($newRes[$i]["posts"]["comments"]["pc_time"][$lp]) && $newRes[$i]["posts"]["comments"]["pc_time"][$lp])
            $postCommentTime = date("M d, Y - h:i:s", strtotime($newRes[$i]["posts"]["comments"]["pc_time"][$lp]));
        $commentNoLikes = 0;
        if (isset($newRes[$i]["posts"]["comments"]["lk_pc_ct"]) && isset($newRes[$i]["posts"]["comments"]["lk_pc_ct"][$lp]) && $newRes[$i]["posts"]["comments"]["lk_pc_ct"][$lp] != '') {
            $commentNoLikes = $newRes[$i]["posts"]["comments"]["lk_pc_ct"][$lp];
        }
        $this->commentNoReplies = 0;
        if (isset($newRes[$i]["posts"]["comments"]["replys"]["pcr_ct"]) && isset($newRes[$i]["posts"]["comments"]["replys"]["pcr_ct"][$lp]) && $newRes[$i]["posts"]["comments"]["replys"]["pcr_ct"][$lp] != '')
            $this->commentNoReplies = $newRes[$i]["posts"]["comments"]["replys"]["pcr_ct"][$lp];
        ?>
        <article class="row"
                 id="<?php echo $listComment["postDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                 name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>">
            <div class="col-lg-12">
                <div class="col-lg-2">
                    <img class="img-responsive timeline-badge danger"
                         src="<?php echo $newRes[$i]["posts"]["comments"]["commenterpic"][$lp]; ?>"  width="50" />
                </div>
                <div class="col-lg-10">
                    <a href="javascript:void(0);"
                       id="<?php echo $listComment["commenter"] . $newRes[$i]["posts"]["comments"]["commentererid"][$lp]; ?>"
                       name="<?php echo $newRes[$i]["posts"]["comments"]["commentererid"][$lp]; ?>">
                           <?php echo $newRes[$i]["posts"]["comments"]["commentername"][$lp]; ?>
                    </a>
                    <?php if ($newRes[$i]["posts"]["comments"]["pc_pic_flag"][$lp]): ?>
                        <div class="<?php echo $listComment["content"]; ?> panel">
                            <div class="panel-body">
                                <div class="col-lg-12 postIMGBACK" style="background-image:url('<?php echo $cimage; ?>');">
                                    <img src="<?php echo $cimage; ?>" alt="" class="img-responsive"/>
                                </div>
                            </div>
                            <div class="panel-footer <?php echo $listComment["content"]; ?>">
                                <?php echo $newRes[$i]["posts"]["comments"]["comments"][$lp]; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="<?php echo $listComment["content"]; ?> panel">
                            <?php echo $newRes[$i]["posts"]["comments"]["comments"][$lp]; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12 pull-right">
                <ul class="list-inline">
                    <li>
                        <a href="javascript:void(0);"
                           id="<?php echo $listComment["like"]["id"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                           name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                           title="Like"
                           class="<?php echo $listComment["like"]["class"]; ?>">
                               <?php echo $listComment["like"]["text"]; ?>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"
                           id="<?php echo $listComment["dislike"]["id"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                           name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                           title="Dislike"
                           class="<?php echo $listComment["dislike"]["class"]; ?>">
                               <?php echo $listComment["dislike"]["text"]; ?>
                        </a>
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);"
                           class="ellipsis"
                           onclick="$('#comrtarget<?php echo $i . '_' . $lp; ?>').slideToggle('slow');">
                            <i class="fa fa-ellipsis-h fa-lg"></i>
                        </a>
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);"
                           class="link-black text-sm">
                            Replies (<span id="<?php echo $listComment["reply"]["counter"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"><?php echo $this->commentNoReplies; ?></span>)
                        </a>
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);"
                           class="link-black text-sm">
                            Likes (<span id="<?php echo $listComment["like"]["counter"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"><?php echo $commentNoLikes; ?></span>)
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-xs-11 col-sm-11 col-lg-11 col-xs-offset-0 col-sm-offset-0 col-md-offset-1"
                 id="comrtarget<?php echo $i . '_' . $lp; ?>" style="display:none;">
                <div class="col-lg-12">
                    <div class="form-group input-group">
                        <input class="form-control" placeholder="Reply On Comment...."
                               id="<?php echo $listComment["reply"]["replyBOX"]["id"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                               name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" />
                        <span class="input-group-addon">
                            <a href="#"
                               id="<?php echo $listComment["reply"]["replyBOX"]["but"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                               name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                               class="<?php echo $listComment["reply"]["replyBOX"]["class"]; ?>">
                                   <?php echo $listComment["reply"]["replyBOX"]["text"]; ?>
                            </a>
                        </span>
                        <span class="input-group-addon">
                            <div class="btn-group pull-right"
                                 id="<?php echo $listComment["reply"]["smiley"]["parentDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>">
                                <a href="javascript:void(0);" data-toggle="dropdown" >
                                    <?php echo $listComment["reply"]["smiley"]["text"]; ?>
                                </a>
                                <ul class="dropdown-menu slidedown"
                                    id="<?php echo $listComment["reply"]["smiley"]["outputDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>">

                                    <?php
                                    for ($lop = 0; $lop < count($listComment["reply"]["smiley"]["emoticons"]) && isset($listComment["reply"]["smiley"]["emoticons"][$lop]); $lop++) {
                                        ?>
                                        <li name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>">
                                            <a name="<?php echo $listComment["reply"]["replyBOX"]["id"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" style="font-size:28px;" href="javascript:void(0);">
                                                <?php echo $listComment["reply"]["smiley"]["emoticons"][$lop]; ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </span>
                        <span class="input-group-addon">
                            <a href="#"
                               id="<?php echo $listComment["reply"]["camera"]["moodalBut"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                               name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                               class="<?php echo $listComment["reply"]["camera"]["moodalClass"]; ?>"
                               data-toggle="modal"
                               data-target="#<?php echo $listComment["reply"]["camera"]["parentDiv"]; ?>"
                               data-whatever="@mdo">
                                   <?php echo $listComment["reply"]["camera"]["icon"]; ?>
                            </a>
                        </span>
                        <span class="input-group-addon" data-bind="<?php echo $i; ?>">
                            <a href="#"
                               data-bind="<?php echo $lp; ?>"
                               id="<?php echo $listComment["reply"]["expand"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                               class="<?php echo $listComment["reply"]["expandClass"]; ?>"
                               name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" >
                                   <?php echo $listComment["reply"]["text"]; ?>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 pull-right"
                     id="<?php echo $listComment["reply"]["list"]["parentDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                     style="display:none;">
                    <section class="comment-list" id="<?php echo $listComment["reply"]["list"]["outputDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>">
                        <?php
                        //require 'listReply.php';
                        ?>
                    </section>
                </div>
            </div>
        </article>
        <?php
    }
    ?>
    <!-- Modal for post comment photo -->
    <div class="modal fade"
         id="<?php echo $listComment["reply"]["camera"]["parentDiv"]; ?>"
         tabindex="-1"
         role="dialog"
         aria-labelledby="<?php echo $listComment["reply"]["camera"]["moodalId"]; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title"
                        id="<?php echo $listComment["reply"]["camera"]["moodalId"]; ?>">Reply on comment.</h3>
                </div>
                <form class=""
                      id="<?php echo $listComment["reply"]["camera"]["form"]; ?>"
                      name="<?php echo $listComment["reply"]["camera"]["form"]; ?>"
                      method="post"
                      action="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>UploadPic/replys"
                      enctype="multipart/form-data">
                    <fieldset>
                        <div class="modal-body">
                            <div class="conatiner">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Reply on comment...."
                                               id="<?php echo $listComment["reply"]["camera"]["text"]; ?>"
                                               name="<?php echo $listComment["reply"]["camera"]["text"]; ?>"
                                               class="from-control" />
                                    </div>
                                    <div class="col-lg-12"><h4>Select picture.</h4></div>
                                    <div class="col-lg-12">
                                        <input type="file"
                                               name="<?php echo $listComment["reply"]["camera"]["name"]; ?>"
                                               id="<?php echo $listComment["reply"]["camera"]["img"]; ?>"
                                               class="<?php echo $listComment["reply"]["camera"]["class"]; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-default"
                                    data-dismiss="modal"
                                    name="<?php echo $listComment["reply"]["camera"]["close"]; ?>"
                                    id="<?php echo $listComment["reply"]["camera"]["close"]; ?>">Close</button>
                            <button type="submit"
                                    class="btn btn-primary"
                                    name="<?php echo $listComment["reply"]["camera"]["create"]; ?>"
                                    id="<?php echo $listComment["reply"]["camera"]["create"]; ?>">Create</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!--End of post comment photo modal-->
    <?php
else:
    ?>
    <div class="col-lg-12"><div class="channel-heading align-center"></div></div>
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">0 comments...</div>
            <div class="panel-body">
                <h3>No comments to view folks!!! <span class="<?php echo $listComment["content"]; ?>">:-O</span></h3>
            </div>
        </div>
    </div>
<?php
endif;
?>