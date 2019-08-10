<?php
$listCommentReply = $this->idHolders["pic3pic"]["post"]["list"]["comment"]["list"]["reply"]["list"];
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
            <div class="col-lg-12">
                <div class="col-lg-2">
                    <img class="img-responsive timeline-badge danger" 
                         src="<?php echo $newRes[$i]["posts"]["comments"]["replys"]["replyerpic"][$lpcr][$lpcri]; ?>"  
                         width="50" />
                </div>
                <div class="col-lg-10">
                    <span class="username">
                        <a href="javascript:void(0);" >
                            <?php echo $newRes[$i]["posts"]["comments"]["replys"]["replyername"][$lpcr][$lpcri]; ?>
                        </a>
                    </span>
                    <?php if ($newRes[$i]["posts"]["comments"]["replys"]["pcr_pic_flag"][$lpcr][$lpcri]): ?>
                        <div class="<?php echo $listCommentReply["content"]; ?> panel">
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
                        <div class="<?php echo $listCommentReply["content"]; ?> panel">
                            <?php echo $newRes[$i]["posts"]["comments"]["replys"]["reply"][$lpcr][$lpcri]; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12 pull-right"> 
                <ul class="list-inline">
                    <li>
                        <a href="javascript:void(0);" 
                           id="<?php echo $listCommentReply["like"]["id"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                           title="Like"
                           name="<?php echo $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                           class="<?php echo $listCommentReply["like"]["class"]; ?>">
                               <?php echo $listCommentReply["like"]["text"]; ?>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" 
                           id="<?php echo $listCommentReply["dislike"]["id"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                           title="Dislike"
                           name="<?php echo $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>" 
                           class="<?php echo $listCommentReply["dislike"]["class"]; ?>">
                               <?php echo $listCommentReply["dislike"]["text"]; ?>
                        </a>
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);" 
                           class="link-black text-sm">
                            Likes (<span id="<?php echo $listCommentReply["like"]["counter"] . $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"][$lpcr][$lpcri]; ?>"><?php echo $commentReplyNoLikes; ?></span>)
                        </a> 
                    </li>
                </ul>
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
