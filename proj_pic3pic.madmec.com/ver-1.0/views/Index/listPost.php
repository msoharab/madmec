<?php
$listpost = $this->idHolders["pic3pic"]["index"]["list"];
?>
<div class="col-lg-12"><div class="channel-heading align-center"></div></div>
<div class="col-lg-12 text-center" id="<?php echo $listpost["loader"]; ?>"></div>
<?php
if (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) > 0 && isset($_SESSION["initial"]) && isset($_SESSION["final"])) :
    $newRes = (array) $_SESSION["ListNewPost"];
    for ($i = $_SESSION["initial"]; $i < $_SESSION["final"] && $i < count($newRes); $i++) {
        if (isset($this->post_id) && is_numeric($this->post_id) && $this->post_id > 0) {
            for ($j = 0; $j < count($newRes); $j++) {
                if ($newRes[$j]["posts"]["id"] === (integer) $this->post_id) {
                    $i = $j;
                    $j = count($newRes);
                    break;
                }
            }
        }
        $image = false;
        if ($newRes[$i]["posts"]["p_pic_flag"]) {
            $tmpImg = array_values($newRes[$i]["posts"]["photo"]);
            array_shift($tmpImg);
            $minKB = 1024 * 60;
            $maxKB = 1024 * 140;
            for ($lp = 0; $lp < count($tmpImg); $lp++) {
                $df = $this->config["DOC_ROOT"] . $tmpImg[$lp];
                if (file_exists($df)) {
                    $actKB = filesize($df);
                    if ($actKB >= $minKB && $actKB <= $maxKB) {
                        $image = $this->config["URL"] . $tmpImg[$lp];
                        break;
                    }
                }
            }
            if (!$image) {
                $image = $this->config["URL"] . $newRes[$i]["posts"]["photo"]["p_ph"];
            }
        } else {
            $image = $this->config["DEFAULT_POST_IMG"];
        }
        $postTime = '';
        if (isset($newRes[$i]["posts"]["created_at"]) && $newRes[$i]["posts"]["created_at"])
            $postTime = date("M d, Y - h:i:s", strtotime($newRes[$i]["posts"]["created_at"]));
        $this->commentNo = 0;
        if (isset($newRes[$i]["posts"]["pc_ct"]) && $newRes[$i]["posts"]["pc_ct"] != '') {
            $this->commentNo = $newRes[$i]["posts"]["pc_ct"];
        }
        ?>
        <div class="col-lg-12" 
             id="<?php echo $listpost["postDiv"] . $newRes[$i]["posts"]["id"]; ?>" 
             name="<?php echo $newRes[$i]["posts"]["id"]; ?>">
            <div class="row panel">
                <h3><?php echo ucfirst($newRes[$i]["posts"]["title"]); ?></h3>
                <div class="col-lg-12 postIMGBACK" style="background-image:url('<?php echo $image; ?>');">
                    <img src="<?php echo $image; ?>" alt="" class="img-responsive"/>
                </div>
                <div class="col-lg-12">
                    <div class="col-md-8">
                        <a href="javascript:void(0);" 
                           id="<?php echo $listpost["sections"]["id"] . $newRes[$i]["posts"]["id"]; ?>" 
                           name="<?php echo $newRes[$i]["posts"]["sections"]["ps_secid"]; ?>" 
                           class="<?php echo $listpost["sections"]["class"]; ?>">
                            <h4> <?php echo ucfirst($newRes[$i]["posts"]["sections"]["pr_secname"]); ?></h4>
                        </a>
                    </div>
                    <?php
                    if (isset($newRes[$i]["posts"]["chwaid"]) &&
                            $newRes[$i]["posts"]["chwaid"] !== 0 &&
                            isset($newRes[$i]["posts"]["chsubid"]) &&
                            $newRes[$i]["posts"]["chsubid"] !== 0):
                        ?>
                        <div class="col-md-4" name="<?php echo $newRes[$i]["posts"]["chwacid"]; ?>">
                            <?php echo $newRes[$i]["posts"]["channel_name"]; ?>
                        </div>
                    <?php else:
                        ?>
                        <div class="col-md-4">&nbsp;</div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-12">
                    <ul class="list-inline">
                        <li class="pull-right" data-bind="<?php echo $i; ?>">
                            <a href="#" 
                               data-bind="<?php echo $i; ?>"
                               id="<?php echo $listpost["comment"]["expand"] . $newRes[$i]["posts"]["id"]; ?>"
                               class="<?php echo $listpost["comment"]["expandClass"]; ?>" 
                               name="<?php echo $newRes[$i]["posts"]["id"]; ?>" >
                                <i class="fa fa-ellipsis-h fa-lg"></i> 
                                <i class="fa fa-ellipsis-h fa-lg"></i>
                            </a>
                        </li>
                        <li class="pull-right">
                            <a href="javascript:void(0);" id="<?php echo $listpost["comment"]["counter"] . $newRes[$i]["posts"]["id"]; ?>"> 
                                Comments (<?php echo $this->commentNo; ?>)
                            </a>
                        </li>
                        <li class="pull-right">
                            <a href="javascript:void(0);" id="<?php echo $listpost["like"]["counter"] . $newRes[$i]["posts"]["id"]; ?>">
                                Likes (<?php echo $newRes[$i]["posts"]["lk_p_ct"]; ?>)
                            </a>
                        </li>
                        <li class="pull-right">
                            <a href="javascript:void(0);">
                                Shares (0)
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12 pull-right" 
                     id="<?php echo $listpost["comment"]["list"]["parentDiv"] . $newRes[$i]["posts"]["id"]; ?>" 
                     style="display:none;">
                    <span id="<?php echo $listpost["comment"]["list"]["outputDiv"] . $newRes[$i]["posts"]["id"]; ?>">       
                        <?php
                        //require 'listComment.php';
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <?php
        if (isset($this->post_id) && is_numeric($this->post_id) && $this->post_id > 0) {
            for ($j = 0; $j < count($newRes); $j++) {
                if ($newRes[$j]["posts"]["id"] === (integer) $this->post_id) {
                    $i = count($newRes);
                    break;
                }
            }
        }
    }
    ?>
<?php elseif (!isset($_SESSION["ListNewPost"])) :
    ?>
    <div class="col-lg-12">
        <h3>No posts to view folks!!! <span class="<?php echo $listpost["smiley"]; ?>">:-O</span></h3>
    </div>
    <?php
endif;
?>

