<?php
$listComment = $this->idHolders["pic3pic"]["index"]["list"]["comment"]["list"];
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
            array_push($tmpImg, $newRes[$i]["posts"]["comments"]["pc_ph"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv1"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv2"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv3"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv4"][$lp], $newRes[$i]["posts"]["comments"]["pc_pv5"][$lp]);
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
                <div class="col-lg-2">
                    <img class="img-responsive timeline-badge danger" 
                         src="<?php echo $newRes[$i]["posts"]["comments"]["commenterpic"][$lp]; ?>"  width="50" />
                </div>
                <div class="col-lg-10">
                    <span class="username">
                        <a href="javascript:void(0);" >
                            <?php echo $newRes[$i]["posts"]["comments"]["commentername"][$lp]; ?>
                        </a>
                    </span>
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
                        <div class="<?php echo $listComment["content"]; ?> panel">
                            <?php echo $newRes[$i]["posts"]["comments"]["comments"][$lp]; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-11 pull-right"> 
                <ul class="list-inline">
                    <li class="pull-right" data-bind="<?php echo $i; ?>">
                        <a href="javascript:void(0);"
                           data-bind="<?php echo $lp; ?>"
                           id="<?php echo $listComment["reply"]["expand"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"
                           class="<?php echo $listComment["reply"]["expandClass"]; ?> link-black text-sm" 
                           name="<?php echo $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" >
                            <i class="fa fa-ellipsis-h fa-lg"></i>
                        </a>
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);" class="link-black text-sm"
                           id="<?php echo $listComment["reply"]["counter"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"> 
                            Replies (<?php echo $this->commentNoReplies; ?>)
                        </a> 
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);" 
                           class="link-black text-sm"
                           id="<?php echo $listComment["like"]["counter"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>">
                            Likes (<?php echo $commentNoLikes; ?>)
                        </a> 
                    </li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-11 pull-right" 
                 id="<?php echo $listComment["reply"]["list"]["parentDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>" 
                 style="display:none;">
                <span id="<?php echo $listComment["reply"]["list"]["outputDiv"] . $newRes[$i]["posts"]["comments"]["pc_id"][$lp]; ?>"> 
                    <?php
                    //require 'listReply.php';
                    ?>
                </span>
            </div>
        </article>
        <?php
    }
    ?>
    <?php
else:
    ?>
    <div class="col-lg-12">
        <h4>No comments to view folks!!! <span class="<?php echo $listComment["content"]; ?>">:-O</span></h4>
    </div>
<?php
endif;
?>
