<?php
$listComment = $this->idHolders["pic3pic"]["channel"]["home"]["list"]["comment"]["list"];
if ($this->commentNo > 0) :
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
                 name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" >
            <div class="col-lg-12">
                <div class="col-md-2 col-sm-2 hidden-xs">
                    <figure class="thumbnail">
                        <a href="javascript:void(0);">
                            <img class="img-responsive img-circle timeline-badge danger" 
                                 src="<?php echo $newRes[$i]["posts"]["comments"]["commenterpic"][$lp]; ?>"  width="50" />
                        </a>
                    </figure>
                </div>
                <div class="col-md-10 col-sm-10" style="border-top: solid 1px #00517e;">
                    <div class="panel arrow left">
                        <div class="panel-heading right">
                            <div class="btn-group pull-right" 
                                 id="<?php echo $listComment["pref"]["parentDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>">
                                <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
                                    <?php echo $listComment["pref"]["text"]; ?>
                                </button>
                                <ul class="dropdown-menu slidedown" 
                                    id="<?php echo $listComment["pref"]["outputDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>">
                                        <?php
                                        for ($lop = 0; $lop < count($listComment["pref"]) && isset($listComment["pref"][$lop]); $lop++) {
                                            if ($listComment["pref"][$lop]["status_id"] === 4):
                                                ?>
                                            <li name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" id="<?php echo $listComment["pref"][$lop]["action"]; ?>">
                                                <a href="javascript:void(0);" 
                                                   id="<?php echo $listComment["pref"][$lop]["id"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" 
                                                   name="<?php echo $listComment["pref"][$lop]["acid"]; ?>" 
                                                   class="<?php echo $listComment["pref"][$lop]["class"]; ?>">
                                                    <small><?php echo $listComment["pref"][$lop]["text"]; ?></small>
                                                </a>
                                            </li>
                                            <li><div class="divider"></div></li>
                                            <?php
                                        endif;
                                    }
                                    ?>
                                    <li><div class="clearfix"></div></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <header class="text-left">
                                <div class="comment-user">
                                    <i class="fa fa-user"></i>
                                    <a href="javascript:void(0);" 
                                       id="<?php echo $listComment["commenter"] . $newRes[$i]["posts"]["comments"]["commentererid"][$lp]; ?>" 
                                       name="<?php echo $newRes[$i]["posts"]["comments"]["commentererid"][$lp]; ?>">
                                           <?php echo $newRes[$i]["posts"]["comments"]["commentername"][$lp]; ?>
                                    </a>
                                </div>
                                <time class="comment-date" datetime="<?php echo $postCommentTime; ?>">
                                    <small><i class="fa fa-clock-o"></i> <?php echo $postCommentTime; ?></small>
                                </time>
                            </header>
                            <div>
                                <p>
                                    <?php if ($newRes[$i]["posts"]["comments"]["pc_pic_flag"][$lp]): ?>
                                    <div class="panel">
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
                                    <div class="<?php echo $listComment["content"]; ?>">
                                        <?php echo $newRes[$i]["posts"]["comments"]["comments"][$lp]; ?>
                                    </div>
                                <?php endif; ?>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <a href="javascript:void(0);" 
                                       id="<?php echo $listComment["like"]["id"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" 
                                       name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" 
                                       class="<?php echo $listComment["like"]["class"]; ?>">
                                           <?php echo $listComment["like"]["text"]; ?>
                                    </a>
                                    <span style="padding-right:20px;"></span>
                                    <a href="javascript:void(0);" 
                                       id="<?php echo $listComment["dislike"]["id"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" 
                                       name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" 
                                       class="<?php echo $listComment["dislike"]["class"]; ?>">
                                           <?php echo $listComment["dislike"]["text"]; ?>
                                    </a>
                                </div>
                                <div class="col-lg-8">
                                    <div class="col-lg-6">
                                        <i class="fa fa-thumbs-o-up thumbs-up"></i>&nbsp;
                                        <a href="javascript:void(0);" id="<?php echo $listComment["like"]["counter"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>">
                                            <?php echo $commentNoLikes; ?>
                                        </a> likes
                                    </div>
                                    <div class="col-lg-6">                
                                        <i class="fa fa-envelope-square thumbs-up"></i> 
                                        <a href="javascript:void(0);" id="<?php echo $listComment["reply"]["counter"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"> 
                                            <?php echo $this->commentNoReplies; ?>
                                        </a> replies
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" id="<?php echo $listComment["reply"]["list"]["parentDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" 
                 style="display:none;">
                <section class="comment-list" id="<?php echo $listComment["reply"]["list"]["outputDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"> 
                    <?php
                    //require 'listReply.php';
                    ?>
                </section>
            </div>
        </article>
        <?php
    }
    ?>
    <div class="col-lg-12 text-center" id="<?php echo $listComment["loader"]; ?>"></div>
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
                      action="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>UploadPic/posts" 
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