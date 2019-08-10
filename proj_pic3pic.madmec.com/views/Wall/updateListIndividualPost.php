<?php
/* Post */
//        $newRes[$i]["posts"]["id"]
//        $newRes[$i]["posts"]["title"]
//        $newRes[$i]["posts"]["photo_id"]
//        $newRes[$i]["posts"]["section_id"]
//        $newRes[$i]["posts"]["user_id"]
//        $newRes[$i]["posts"]["created_at"]
//        $newRes[$i]["posts"]["postername"]
/* Post Photo */
//        $newRes[$i]["posts"]["photo"]["p_phid"]
//        $newRes[$i]["posts"]["photo"]["p_ph"]
//        $newRes[$i]["posts"]["photo"]["p_pv1"]
//        $newRes[$i]["posts"]["photo"]["p_pv2"]
//        $newRes[$i]["posts"]["photo"]["p_pv3"]
//        $newRes[$i]["posts"]["photo"]["p_pv5"]
/* Post Languages */
//        $newRes[$i]["posts"]["languages"]["plng_id"]
//        $newRes[$i]["posts"]["languages"]["plng_time"]
//        $newRes[$i]["posts"]["languages"]["plng_lngid"]
//        $newRes[$i]["posts"]["languages"]["plng_lngname"]
/* Post Sections */
//        $newRes[$i]["posts"]["sections"]["ps_id"]
//        $newRes[$i]["posts"]["sections"]["ps_time"]
//        $newRes[$i]["posts"]["sections"]["ps_secid"]
//        $newRes[$i]["posts"]["sections"]["pr_secname"]
/* Post Likes */
//        $newRes[$i]["posts"]["likes"]["lk_p_uname"]
//        $newRes[$i]["posts"]["likes"]["lk_p_id"]
//        $newRes[$i]["posts"]["likes"]["lk_p_uid"]
//        $newRes[$i]["posts"]["likes"]["lk_p_time"]
/* Post Preferences */
//        $newRes[$i]["posts"]["preference"]["pp_uname"]
//        $newRes[$i]["posts"]["preference"]["pp_id"]
//        $newRes[$i]["posts"]["preference"]["pp_uid"]
//        $newRes[$i]["posts"]["preference"]["pp_time"]
//        $newRes[$i]["posts"]["preference"]["pp_preid"]
//        $newRes[$i]["posts"]["preference"]["pp_pref"]
/* Post Report */
//        $newRes[$i]["posts"]["report"]["pr_uname"]
//        $newRes[$i]["posts"]["report"]["pr_id"]
//        $newRes[$i]["posts"]["report"]["pr_uid"]
//        $newRes[$i]["posts"]["report"]["pr_time"]
//        $newRes[$i]["posts"]["report"]["pr_repid"]
//        $newRes[$i]["posts"]["report"]["pr_repname"]
/* Post Location */
//        $newRes[$i]["posts"]["post_location"]["post_location"]
//        $newRes[$i]["posts"]["post_location"]["pcont_id"]
//        $newRes[$i]["posts"]["post_location"]["pcont_time"]
//        $newRes[$i]["posts"]["post_location"]["pcont_contid"]
//        $newRes[$i]["posts"]["post_location"]["pcont_contname"]
/* Post Channel */
//        $newRes[$i]["posts"]["post_location"]["chwaid"]
//        $newRes[$i]["posts"]["post_location"]["chwauid"]
//        $newRes[$i]["posts"]["post_location"]["chwacid"]
//        $newRes[$i]["posts"]["post_location"]["chwapost_id"]
//        $newRes[$i]["posts"]["post_location"]["chwatime"]

$listpost = $this->idHolders["pic3pic"]["wall"]["list"];
$newRes = (array) $_SESSION["ListNewPost"];
if (isset($this->post_id) && is_numeric($this->post_id) && $this->post_id > 0) {
    for ($i = 0; $i < count($newRes); $i++) {
        if ($newRes[$i]["posts"]["id"] === (integer) $this->post_id) {
            $image = false;
            $tmpImg = array_values($newRes[$i]["posts"]["photo"]);
            array_shift($tmpImg);
            $minKB = 1024 * 60;
            $maxKB = 1024 * 140;
            for ($lp = 0; $lp < count($tmpImg); $lp++) {
                $df = $this->config["DOC_ROOT"] . $tmpImg[$lp];
                if (file_exists($df)) {
                    $actKB = filesize($df);
                    if ($actKB >= $minKB && $actKB <= $maxKB) {
                        $image = $tmpImg[$lp];
                        break;
                    }
                }
            }
            if (!$image)
                $image = $newRes[$i]["posts"]["photo"]["p_ph"];
            $postTime = '';
            if (isset($newRes[$i]["posts"]["created_at"]) && $newRes[$i]["posts"]["created_at"])
                $postTime = date("M d, Y - h:i:s", strtotime($newRes[$i]["posts"]["created_at"]));
            $this->commentNo = 0;
            if (isset($newRes[$i]["posts"]["pc_ct"]) && $newRes[$i]["posts"]["pc_ct"] != '') {
                $this->commentNo = $newRes[$i]["posts"]["pc_ct"];
            }
            ?>
            <div class="col-lg-12"><div class="channel-heading align-center"></div></div>
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
                                <!--
                                <div class="btn-group pull-right"
                                     id="<?php echo $listpost["sections"]["parentDiv"] . $newRes[$i]["posts"]["id"]; ?>">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <?php echo $listpost["sections"]["text"]; ?>
                                    </button>
                                    <ul class="dropdown-menu slidedown"
                                        id="<?php echo $listpost["sections"]["outputDiv"] . $newRes[$i]["posts"]["id"]; ?>">
                                <?php
                                for ($lp = 0; $lp < count($newRes[$i]["posts"]["sections"]["pr_secname"]) && isset($newRes[$i]["posts"]["sections"]["pr_secname"][$lp]); $lp++) {
                                    ?>
                                                                        <li name="<?php echo $newRes[$i]["posts"]["id"]; ?>">
                                                                            <a href="javascript:void(0);"
                                                                               id="<?php echo $listpost["sections"]["id"] . $newRes[$i]["posts"]["id"]; ?>"
                                                                               name="<?php echo $listpost["sections"][$lp]["acid"]; ?>"
                                                                               class="<?php echo $listpost["sections"]["class"]; ?>">
                                    <?php echo ucfirst($newRes[$i]["posts"]["sections"]["pr_secname"][$lp]); ?>
                                                                            </a>
                                                                        </li>
                                                                        <li><div class="divider"></div></li>
                                    <?php
                                }
                                ?>
                                        <li><div class="clearfix"></div></li>
                                    </ul>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12 postIMGBACK" style="background-image:url('<?php echo $this->config["URL"] . $image; ?>');">
                                <img src="<?php echo $this->config["URL"] . $image; ?>" alt="" class="img-responsive"/>
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
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-danger pull-right"
                                            id="<?php echo $listpost["subscription"]["id"] . $newRes[$i]["posts"]["id"]; ?>"
                                            class="<?php echo $listpost["subscription"]["class"]; ?>"
                                            name="<?php echo $newRes[$i]["posts"]["user_id"]; ?>">
                                                <?php echo $listpost["subscription"]["text"]; ?>
                                    </button>
                                </div>
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
                        <div class="col-lg-12" id="<?php echo $listpost["comment"]["wall"]["parentDiv"] . $newRes[$i]["posts"]["id"]; ?>" style="display:none;">
                            <section class="comment-list" id="<?php echo $listpost["comment"]["wall"]["outputDiv"] . $newRes[$i]["posts"]["id"]; ?>">
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
                                           <?php echo $listpost["comment"]["camera"]["text"]; ?>
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
            </div>            <?php
            break;
        }
    }
}
?>
