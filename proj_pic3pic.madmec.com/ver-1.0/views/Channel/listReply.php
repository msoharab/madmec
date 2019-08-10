<?php
$listCommentReply = $this->idHolders["pic3pic"]["channel"]["home"]["list"]["comment"]["list"]["reply"]["list"];
if ($this->commentNoReplies > 0) :
    if (is_numeric($this->ploop) && is_numeric($this->pcloop) && is_array($this->listPost)) {
        $i = $this->ploop;
        $lpcr = $this->pcloop;
        $newRes = (array) $this->listPost;
    } else if (is_numeric($this->post_comment_id) && is_array($this->listPost)) {
        $flag = false;
        $newRes = (array) $this->listPost;
        for ($j = 0; $j < count($this->listPost); $j++) {
            for ($k = 0; $k < count($this->listPost[$j]["posts"]["comments"]["pc_id"]); $k++) {
                if ($this->post_comment_id === (integer) $this->listPost[$j]["posts"]["comments"]["pc_id"][$k]) {
                    $lpcr = $k;
                    $flag = true;
                    break;
                }
            }
            if ($flag) {
                $i = $j;
                break;
            }
        }
    }
    for ($lpcri = 0; isset($newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr]) &&
            is_array($newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr]) &&
            $lpcri < count($newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr]) &&
            isset($newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]) &&
            $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri] != ''; $lpcri++) {
        $postCommentReplyTime = '';
        if (isset($newRes[$i]["posts"]["comments"]["replys"]["pcr_time"][$lpcr][$lpcri]) && $newRes[$i]["posts"]["comments"]["replys"]["pcr_time"][$lpcr][$lpcri])
            $postCommentReplyTime = date("M d, Y - h:i:s", strtotime($newRes[$i]["posts"]["comments"]["replys"]["pcr_time"][$lpcr][$lpcri]));
        $crimage = false;
        $tmpImg = array();
        if ($newRes[$i]["posts"]["comments"]["replys"]["pcr_pic_flag"][$lpcr][$lpcri] && isset($newRes[$i]["posts"]["comments"]["replys"]["pcr_ph"][$lpcr][$lpcri]) && !empty($newRes[$i]["posts"]["comments"]["replys"]["pcr_ph"][$lpcr][$lpcri])
        ) {
            array_push($tmpImg, $newRes[$i]["posts"]["comments"]["replys"]["pcr_ph"][$lpcr][$lpcri], $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv1"][$lpcr][$lpcri], $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv2"][$lpcr][$lpcri], $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv3"][$lpcr][$lpcri], $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv4"][$lpcr][$lpcri], $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv5"][$lpcr][$lpcri]
            );
        }
        if (count($tmpImg) > 0 && $newRes[$i]["posts"]["comments"]["replys"]["pcr_pic_flag"][$lpcr][$lpcri]) {
            $minKB = 1024 * 5;
            $maxKB = 1024 * 50;
            for ($lpp = 0; $lpp < count($tmpImg); $lpp++) {
                $df = $this->config["DOC_ROOT"] . $tmpImg[$lpp];
                if (file_exists($df)) {
                    $actKB = filesize($df);
                    if ($actKB >= $minKB && $actKB <= $maxKB) {
                        $crimage = $this->config["URL"] . $tmpImg[$lpp];
                        break;
                    }
                }
            }
            if (!$crimage)
                $crimage = $this->config["URL"] . $tmpImg[0];
        }
        if (!$crimage && $newRes[$i]["posts"]["comments"]["replys"]["pcr_pic_flag"][$lpcr][$lpcri]) {
            $crimage = $this->config["DEFAULT_COMENT_IMG"];
        }
        $commentReplyNoLikes = 0;
        if (isset($newRes[$i]["posts"]["comments"]["replys"]["lk_rep_ct"]) &&
                count($newRes[$i]["posts"]["comments"]["replys"]["lk_rep_ct"][$lpcr]) > 0 && isset($newRes[$i]["posts"]["comments"]["replys"]["lk_rep_ct"][$lpcr][$lpcri]) && $newRes[$i]["posts"]["comments"]["replys"]["lk_rep_ct"][$lpcr][$lpcri] != '')
            $commentReplyNoLikes = $newRes[$i]["posts"]["comments"]["replys"]["lk_rep_ct"][$lpcr][$lpcri];
        ?>
        <article class="row" 
                 id="<?php echo $listCommentReply["postDiv"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                 name="<?php echo $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>">
            <div class="col-md-2 col-sm-2 col-md-offset-1 col-sm-offset-0 hidden-xs">
                <figure class="thumbnail">
                    <a href="javascript:void(0);">
                        <img class="img-responsive img-circle timeline-badge danger" 
                             src="<?php echo $newRes[$i]["posts"]["comments"]["replys"]["replyerpic"][$lpcr][$lpcri]; ?>"  width="35" />
                    </a>
                </figure>
            </div>
            <div class="col-md-9 col-sm-9" style="background: #F0F0F0;">
                <div class="panel panel-default arrow left">
                    <div class="panel-heading right">
                        <div class="btn-group pull-right" 
                             id="<?php echo $listCommentReply["pref"]["parentDiv"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>">
                            <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
                                <small><?php echo $listCommentReply["pref"]["text"]; ?></small>
                            </button>
                            <ul class="dropdown-menu slidedown" 
                                id="<?php echo $listCommentReply["pref"]["outputDiv"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>">
                                    <?php
                                    for ($lop = 0; $lop < count($listCommentReply["pref"]) && isset($listCommentReply["pref"][$lop]); $lop++) {
                                        if ($listCommentReply["pref"][$lop]["status_id"] === 4):
                                            ?>
                                        <li name="<?php echo $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" id="<?php echo $listCommentReply["pref"][$lop]["action"]; ?>">
                                            <a href="javascript:void(0);" 
                                               id="<?php echo $listCommentReply["pref"][$lop]["id"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                                               name="<?php echo $listCommentReply["pref"][$lop]["acid"]; ?>" 
                                               class="<?php echo $listCommentReply["pref"][$lop]["class"]; ?>">
                                                <small><?php echo $listCommentReply["pref"][$lop]["text"]; ?></small>
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
                                   id="<?php echo $listCommentReply["replyer"] . $newRes[$i]["posts"]["comments"]["replys"]["replyererid"][$lpcr][$lpcri]; ?>" 
                                   name="<?php echo $newRes[$i]["posts"]["comments"]["replys"]["replyererid"][$lpcr][$lpcri]; ?>">
                                       <?php echo $newRes[$i]["posts"]["comments"]["replys"]["replyername"][$lpcr][$lpcri]; ?>
                                </a>
                            </div>
                            <time class="comment-date" datetime="<?php echo $postCommentReplyTime; ?>">
                                <small><i class="fa fa-clock-o"></i> <?php echo $postCommentReplyTime; ?></small>
                            </time>
                        </header>
                        <div class="<?php echo $listCommentReply["content"]; ?>">
                            <p>
                                <?php if ($newRes[$i]["posts"]["comments"]["replys"]["pcr_pic_flag"][$lpcr][$lpcri]): ?>
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="col-lg-12 postIMGBACK" style="background-image:url('<?php echo $crimage; ?>');">
                                            <img src="<?php echo $crimage; ?>" alt="" class="img-responsive"/>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <?php echo $newRes[$i]["posts"]["comments"]["replys"]["reply"][$lpcr][$lpcri]; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <?php echo $newRes[$i]["posts"]["comments"]["replys"]["reply"][$lpcr][$lpcri]; ?>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" 
                                       id="<?php echo $listCommentReply["like"]["id"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                                       name="<?php echo $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                                       class="<?php echo $listCommentReply["like"]["class"]; ?>">
                                           <?php echo $listCommentReply["like"]["text"]; ?>
                                    </a>
                                    <span style="padding-right:20px;"></span>
                                    <a href="javascript:void(0);" 
                                       id="<?php echo $listCommentReply["dislike"]["id"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                                       name="<?php echo $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                                       class="<?php echo $listCommentReply["dislike"]["class"]; ?>">
                                           <?php echo $listCommentReply["dislike"]["text"]; ?>
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <i class="fa fa-thumbs-o-up thumbs-up"></i>&nbsp;
                                    <a href="javascript:void(0);" id="<?php echo $listCommentReply["like"]["counter"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>">
                                        <?php echo $commentReplyNoLikes; ?>
                                    </a> likes
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <?php
    }
else:
    ?>
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">0 replies...</div>
            <div class="panel-body">
                <h3>No replies to view folks!!! <span class="<?php echo $listCommentReply["content"]; ?>">:-O</span></h3>
            </div>
        </div>
    </div>
<?php
endif;
?>
