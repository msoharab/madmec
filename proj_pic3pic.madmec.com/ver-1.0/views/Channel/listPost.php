<?php
$listpost = $this->idHolders["pic3pic"]["channel"]["home"]["list"];
?>
<div class="col-lg-12" id="<?php echo $listpost["loader"]; ?>"></div>
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
        <!--<div class="col-lg-12"><div class="channel-heading align-center"></div></div>-->
        <div class="col-lg-12" 
             id="<?php echo $listpost["postDiv"] . $newRes[$i]["posts"]["id"]; ?>" 
             name="<?php echo $newRes[$i]["posts"]["id"]; ?>">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-12">
                            <i class="fa fa-user fa-2x"></i>&nbsp;
                            <a href="javascript:void(0);"><?php echo $newRes[$i]["posts"]["postername"]; ?></a>,&nbsp;
                            <?php echo ucfirst($newRes[$i]["posts"]["title"]); ?>
                        </div>
                        <div class="col-lg-12">
                            <?php if (isset($_SESSION["USERDATA"]["logindata"]["id"]) && $_SESSION["USERDATA"]["logindata"]["id"] != $newRes[$i]["posts"]["user_id"]): ?>
                                <div class="btn-group pull-right" 
                                     id="<?php echo $listpost["report"]["parentDiv"] . $newRes[$i]["posts"]["id"]; ?>">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <?php echo $listpost["report"]["text"]; ?>
                                    </button>
                                    <ul class="dropdown-menu slidedown" 
                                        id="<?php echo $listpost["report"]["outputDiv"] . $newRes[$i]["posts"]["id"]; ?>">
                                            <?php
                                            for ($lp = 0; $lp < count($listpost["report"]) && isset($listpost["report"][$lp]); $lp++) {
                                                if ($listpost["report"][$lp]["status_id"] === 4):
                                                    ?>
                                                <li name="<?php echo $newRes[$i]["posts"]["id"]; ?>">
                                                    <a href="javascript:void(0);" 
                                                       id="<?php echo $listpost["report"][$lp]["id"] . $newRes[$i]["posts"]["id"]; ?>" 
                                                       name="<?php echo $listpost["report"][$lp]["acid"]; ?>" 
                                                       class="<?php echo $listpost["report"][$lp]["class"]; ?>">
                                                           <?php echo $listpost["report"][$lp]["text"]; ?>
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
                            <?php endif; ?>
                            <div class="btn-group pull-right" 
                                 id="<?php echo $listpost["pref"]["parentDiv"] . $newRes[$i]["posts"]["id"]; ?>">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <?php echo $listpost["pref"]["text"]; ?>
                                </button>
                                <ul class="dropdown-menu slidedown" 
                                    id="<?php echo $listpost["pref"]["outputDiv"] . $newRes[$i]["posts"]["id"]; ?>">
                                        <?php
                                        for ($lp = 0; $lp < count($listpost["pref"]) && isset($listpost["pref"][$lp]); $lp++) {
                                            if ($listpost["pref"][$lp]["status_id"] === 4):
                                                ?>
                                            <li name="<?php echo $newRes[$i]["posts"]["id"]; ?>" id="<?php echo $listpost["pref"][$lp]["action"]; ?>">
                                                <a href="javascript:void(0);" 
                                                   id="<?php echo $listpost["pref"][$lp]["id"] . $newRes[$i]["posts"]["id"]; ?>" 
                                                   name="<?php echo $listpost["pref"][$lp]["acid"]; ?>" 
                                                   class="<?php echo $listpost["pref"][$lp]["class"]; ?>">
                                                       <?php echo $listpost["pref"][$lp]["text"]; ?>
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
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 postIMGBACK" style="background-image:url('<?php echo $image; ?>');">
                            <img src="<?php echo $image; ?>" alt="" class="img-responsive"/>
                        </div>
                        <div class="col-lg-12"><div class="clearfix"><br /></div></div>
                        <div class="col-lg-12">
                            <div class="col-md-2">
                                <a href="javascript:void(0);" 
                                   id="<?php echo $listpost["like"]["id"] . $newRes[$i]["posts"]["id"]; ?>" 
                                   name="<?php echo $newRes[$i]["posts"]["id"]; ?>" 
                                   class="<?php echo $listpost["like"]["class"]; ?>">
                                       <?php echo $listpost["like"]["text"]; ?>
                                </a>
                                <span style="padding-right:20px;"></span>
                                <a href="javascript:void(0);" 
                                   id="<?php echo $listpost["dislike"]["id"] . $newRes[$i]["posts"]["id"]; ?>" 
                                   name="<?php echo $newRes[$i]["posts"]["id"]; ?>" 
                                   class="<?php echo $listpost["dislike"]["class"]; ?>">
                                       <?php echo $listpost["dislike"]["text"]; ?>
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="javascript:void(0);" 
                                   id="<?php echo $listpost["sections"]["id"] . $newRes[$i]["posts"]["id"]; ?>" 
                                   name="<?php echo $newRes[$i]["posts"]["sections"]["ps_secid"]; ?>" 
                                   class="<?php echo $listpost["sections"]["class"]; ?>">
                                       <?php echo ucfirst($newRes[$i]["posts"]["sections"]["pr_secname"]); ?>
                                </a>

                            </div>
                            <?php
                            if (isset($newRes[$i]["posts"]["chwaid"]) &&
                                    $newRes[$i]["posts"]["chwaid"] !== 0 &&
                                    isset($newRes[$i]["posts"]["chsubid"]) &&
                                    $newRes[$i]["posts"]["chsubid"] !== 0):
                                ?>
                                <div class="col-md-3" name="<?php echo $newRes[$i]["posts"]["chwacid"]; ?>">
                                    <button type="button" class="btn btn-danger pull-right"
                                            id="<?php echo $listpost["subscription"]["id"] . $newRes[$i]["posts"]["id"]; ?>" 
                                            class="<?php echo $listpost["subscription"]["class"]; ?>" 
                                            name="<?php echo $newRes[$i]["posts"]["user_id"]; ?>">
                                                <?php echo $listpost["subscription"]["text"]; ?>
                                    </button>
                                </div>
                            <?php else:
                                ?>
                                <div class="col-md-3">&nbsp;</div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-12"><div class="divider"></div></div>
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <i class="fa fa-thumbs-o-up thumbs-up"></i>&nbsp;
                                <a href="javascript:void(0);" id="<?php echo $listpost["like"]["counter"] . $newRes[$i]["posts"]["id"]; ?>">
                                    <?php echo $newRes[$i]["posts"]["lk_p_ct"]; ?>
                                </a> likes
                            </div>
                            <div class="col-lg-4">                
                                <a href="javascript:void(0);"> . </a>
                                <i class="fa fa-envelope-square thumbs-up"></i> 
                                <a href="javascript:void(0);" id="<?php echo $listpost["comment"]["counter"] . $newRes[$i]["posts"]["id"]; ?>"> 
                                    <?php echo $this->commentNo; ?>
                                </a> comments
                            </div>
                            <div class="col-lg-4 text-right">
                                <time class="comment-date" datetime="<?php echo $postTime; ?>">
                                    <i class="fa fa-clock-o"></i> <?php echo $postTime; ?>
                                </time>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div class="col-lg-12" id="<?php echo $listpost["comment"]["list"]["parentDiv"] . $newRes[$i]["posts"]["id"]; ?>" style="display:none;">
                        <section class="comment-list" id="<?php echo $listpost["comment"]["list"]["outputDiv"] . $newRes[$i]["posts"]["id"]; ?>">       
                            <?php
                            //require 'listComment.php';
                            ?>
                        </section>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group input-group">
                            <textarea class="form-control" placeholder="Comment On Picutre...."  
                                      id="<?php echo $listpost["comment"]["commentBOX"]["id"] . $newRes[$i]["posts"]["id"]; ?>" 
                                      name="<?php echo $newRes[$i]["posts"]["id"]; ?>"></textarea>
                            <span class="input-group-addon">
                                <a href="#" 
                                   id="<?php echo $listpost["comment"]["commentBOX"]["but"] . $newRes[$i]["posts"]["id"]; ?>" 
                                   name="<?php echo $newRes[$i]["posts"]["id"]; ?>" 
                                   class="<?php echo $listpost["comment"]["commentBOX"]["class"]; ?>">
                                       <?php echo $listpost["comment"]["commentBOX"]["text"]; ?>
                                </a>
                            </span>
                            <span class="input-group-addon">
                                <div class="btn-group pull-right" 
                                     id="<?php echo $listpost["comment"]["smiley"]["parentDiv"] . $newRes[$i]["posts"]["id"]; ?>">
                                    <a href="javascript:void(0);" data-toggle="dropdown" >
                                        <?php echo $listpost["comment"]["smiley"]["text"]; ?>
                                    </a>
                                    <ul class="dropdown-menu slidedown" 
                                        id="<?php echo $listpost["comment"]["smiley"]["outputDiv"] . $newRes[$i]["posts"]["id"]; ?>">

                                        <?php
                                        for ($lp = 0; $lp < count($listpost["comment"]["smiley"]["emoticons"]) && isset($listpost["comment"]["smiley"]["emoticons"][$lp]); $lp++) {
                                            ?>
                                            <li name="<?php echo $newRes[$i]["posts"]["id"]; ?>">
                                                <a name="<?php echo $listpost["comment"]["commentBOX"]["id"] . $newRes[$i]["posts"]["id"]; ?>" 
                                                   style="font-size:48px;" 
                                                   href="javascript:void(0);">
                                                       <?php echo $listpost["comment"]["smiley"]["emoticons"][$lp]; ?>
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
                                   id="<?php echo $listpost["comment"]["camera"]["moodalBut"] . $newRes[$i]["posts"]["id"]; ?>" 
                                   name="<?php echo $newRes[$i]["posts"]["id"]; ?>" 
                                   class="<?php echo $listpost["comment"]["camera"]["moodalClass"]; ?>" 
                                   data-toggle="modal" 
                                   data-target="#<?php echo $listpost["comment"]["camera"]["parentDiv"]; ?>" 
                                   data-whatever="@mdo">
                                       <?php echo $listpost["comment"]["camera"]["icon"]; ?>
                                </a>
                            </span>
                            <span class="input-group-addon">
                                <a href="#" 
                                   data-bind="<?php echo $i; ?>"
                                   id="<?php echo $listpost["comment"]["expand"] . $newRes[$i]["posts"]["id"]; ?>"
                                   class="<?php echo $listpost["comment"]["expandClass"]; ?>" 
                                   name="<?php echo $newRes[$i]["posts"]["id"]; ?>" >
                                       <?php echo $listpost["comment"]["text"]; ?>
                                </a>
                            </span>
                        </div>                    
                    </div>
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
    <!-- Modal for post comment photo -->
    <div class="modal fade" 
         id="<?php echo $listpost["comment"]["camera"]["parentDiv"]; ?>" 
         tabindex="-1" 
         role="dialog" 
         aria-labelledby="<?php echo $listpost["comment"]["camera"]["moodalId"]; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" 
                        id="<?php echo $listpost["comment"]["camera"]["moodalId"]; ?>">Comment on post.</h3>
                </div>
                <form id="<?php echo $listpost["comment"]["camera"]["form"]; ?>" 
                      name="<?php echo $listpost["comment"]["camera"]["form"]; ?>" 
                      method="post" 
                      action="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>UploadPic/posts" 
                      enctype="multipart/form-data">
                    <fieldset>
                        <div class="modal-body">
                            <div class="conatiner">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <textarea type="text" class="form-control" placeholder="Comment On Picutre...."  
                                                  id="<?php echo $listpost["comment"]["camera"]["text"]; ?>" 
                                                  name="<?php echo $listpost["comment"]["camera"]["text"]; ?>"
                                                  class="from-control"></textarea>
                                    </div>
                                    <div class="col-lg-12"><h4>Select picture.</h4></div>
                                    <div class="col-lg-12">
                                        <input type="file" 
                                               name="<?php echo $listpost["comment"]["camera"]["name"]; ?>"
                                               id="<?php echo $listpost["comment"]["camera"]["img"]; ?>" 
                                               class="<?php echo $listpost["comment"]["camera"]["class"]; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" 
                                    class="btn btn-default" 
                                    data-dismiss="modal" 
                                    name="<?php echo $listpost["comment"]["camera"]["close"]; ?>" 
                                    id="<?php echo $listpost["comment"]["camera"]["close"]; ?>">Close</button>
                            <button type="submit" 
                                    class="btn btn-primary" 
                                    name="<?php echo $listpost["comment"]["camera"]["create"]; ?>" 
                                    id="<?php echo $listpost["comment"]["camera"]["create"]; ?>">Create</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!--End of post comment photo modal-->        
<?php elseif (isset($_SESSION["ListNewPost"]) && count($_SESSION["ListNewPost"]) == 0) :
    ?>
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">0 Posts to load...</div>
            <div class="panel-body">
                <h3>No posts to view folks!!! <span class="<?php echo $listpost["smiley"]; ?>">:-O</span></h3>
            </div>
        </div>
    </div>
    <?php
endif;
?>

