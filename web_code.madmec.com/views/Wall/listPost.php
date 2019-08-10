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
/* Post Comments */
//        $newRes[$i]["posts"]["comments"]["pc_id"]
//        $newRes[$i]["posts"]["comments"]["pc_uid"]
//        $newRes[$i]["posts"]["comments"]["commenter"]
//        $newRes[$i]["posts"]["comments"]["comments"]
//        $newRes[$i]["posts"]["comments"]["pc_phid"]
//        $newRes[$i]["posts"]["comments"]["pc_ph"]
//        $newRes[$i]["posts"]["comments"]["pc_pv1"]
//        $newRes[$i]["posts"]["comments"]["pc_pv2"]
//        $newRes[$i]["posts"]["comments"]["pc_pv3"]
//        $newRes[$i]["posts"]["comments"]["pc_pv4"]
//        $newRes[$i]["posts"]["comments"]["pc_pv5"]
//        $newRes[$i]["posts"]["comments"]["pc_time"]
//        $newRes[$i]["posts"]["comments"]["pcp_id"]
//        $newRes[$i]["posts"]["comments"]["pcp_uid"]
//        $newRes[$i]["posts"]["comments"]["pcp_time"]
//        $newRes[$i]["posts"]["comments"]["pcp_preid"]
//        $newRes[$i]["posts"]["comments"]["pcp_pref"]
//        $newRes[$i]["posts"]["comments"]["pcp_uname"]
//        $newRes[$i]["posts"]["comments"]["lk_pc_id"]
//        $newRes[$i]["posts"]["comments"]["lk_pc_uid"]
//        $newRes[$i]["posts"]["comments"]["lk_pc_uname"]
/* Post Comment Reply */
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_id"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_uid"]
//        $newRes[$i]["posts"]["comments"]["replys"]["reply"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_time"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcrp_uid"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcrp_time"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcrp_preid"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcrp_pref"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcrp_uname"]
//        $newRes[$i]["posts"]["comments"]["replys"]["lk_rep_id"]
//        $newRes[$i]["posts"]["comments"]["replys"]["lk_replyer_id"]
//        $newRes[$i]["posts"]["comments"]["replys"]["lk_replytime"]
//        $newRes[$i]["posts"]["comments"]["replys"]["lk_replyer_name"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_phid"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_ph"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv1"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv2"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv3"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv4"]
//        $newRes[$i]["posts"]["comments"]["replys"]["pcr_pv5"]

$listpost = $this->idHolders["wall"]["post"]["list"];
if (isset($_SESSION["ListNewPost"]) && sizeof($_SESSION["ListNewPost"]) > 0) :
    $newRes = (array) $_SESSION["ListNewPost"];
    for ($i = $_SESSION["initial"]; $i < $_SESSION["final"] && $i < sizeof($newRes); $i++) {
        $image = false;
        $tmpImg = array_values($newRes[$i]["posts"]["photo"]);
        array_shift($tmpImg);
        $minKB = 1024*120;
        $maxKB = 1024*180;
        for ($lp = 0; $lp < sizeof($tmpImg); $lp++) {
            $df = $this->config["DOC_ROOT"] . $tmpImg[$lp];
            if (file_exists($df)) {
                $actKB = filesize($df);
                if($actKB >= $minKB && $actKB <= $maxKB){
                    $image = $tmpImg[$lp];
                    break;
                }
            }
        }
        if(!$image)
            $image = $newRes[$i]["posts"]["photo"]["p_ph"];
        ?>
        <div class="col-lg-12"><div class="channel-heading align-center"></div></div>
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading"><?php echo ucfirst($newRes[$i]["posts"]["title"]); ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 postIMGBACK" style="background-image:url('<?php echo $this->config["URL"] . $image; ?>');">
                            <img src="<?php echo $this->config["URL"] . $image; ?>" alt="" class="img-responsive"/>
                        </div>
                        <div class="col-lg-12"><div class="clearfix"><br /></div></div>
                        <div class="col-lg-12">
                            <div class="col-md-2">
                                <a class="" href="javascript:void(0);">
                                    <i class="fa fa-thumbs-o-up thumbs-up fa-lg"></i>
                                </a>
                                <span style="padding-right:20px;"></span>
                                <a class="" href="javascript:void(0);">
                                    <i class="fa fa-thumbs-o-down fa-lg "></i>
                                </a>
                                <div class="clearfix"><br /></div>
                                <a href="javascript:void();" class="ellipsis" onclick="$('#target1').slideToggle('slow');">
                                    <i class="fa fa-ellipsis-h fa-lg"></i> <i class="fa fa-ellipsis-h fa-lg"></i>
                                </a>
                            </div>
                            <div class="col-md-7">
                                <?php
                                $sectons = '';
                                for ($temp = 0; $temp < sizeof($newRes[$i]["posts"]["sections"]) && isset($newRes[$i]["posts"]["sections"]["pr_secname"][$temp]); $temp++) {
                                    $sectons .= '<i class="fa fa-tags"></i><a href="javascript:void(0);"> ' . $newRes[$i]["posts"]["sections"]["pr_secname"][$temp] . '</a>,<br />';
                                }
                                echo $sectons;
                                ?>
                                <i class="fa fa-user"></i><a class="" href="javascript:void(0);"> <?php echo $newRes[$i]["posts"]["postername"]; ?></a>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger pull-right" href="javascript:void(0);"><i class="fa fa-eye"></i> Subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-comments"></i></span>
                        <input class="form-control" name="comment" id="comment" placeholder="Comment On Picutre...."/>
                        <span class="input-group-addon"><button type="button"><i class="fa fa-smile-o"></i></button></span>
                        <span class="input-group-addon"><button type="button"><i class="fa fa-camera"></i></button></span>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <section class="comment-list">
                <!-- First Comment -->
                <article class="row">
                    <div class="col-md-2 col-sm-2 hidden-xs">
                        <figure class="thumbnail">
                            <img class="img-responsive img-circle timeline-badge danger" src="<?php echo $this->config["DEFAULT_USER_ICON_IMG"]; ?>"  width="50" />
                        </figure>
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <div class="panel arrow left">
                            <div class="panel-heading right">Comment</div>
                            <div class="panel-body">
                                <header class="text-left">
                                    <div class="comment-user"><i class="fa fa-user"></i> Commenter</div>
                                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> Dec 16, 2014</time>
                                </header>
                                <div class="comment-post">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                    </p>
                                </div>
                                <p class="text-right">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-thumbs-o-up fa-fw"></i></button>
                                </p>
                            </div>
                            <div class="footer">
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-reply"></i></span>
                                    <input class="form-control" name="reply" id="reply" placeholder="Reply On Comment...."/>
                                    <span class="input-group-addon"><button type="button"><i class="fa fa-smile-o"></i></button></span>
                                    <span class="input-group-addon"><button type="button"><i class="fa fa-camera"></i></button></span>
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12"><div class="divider"></div></div>
                </article>
                <!-- Second Comment Reply -->
                <article class="row">
                    <div class="col-md-2 col-sm-2 col-md-offset-1 col-sm-offset-0 hidden-xs">
                        <figure class="thumbnail">
                            <img class="img-responsive img-circle timeline-badge danger" src="<?php echo $this->config["DEFAULT_USER_ICON_IMG"]; ?>" width="40"/>
                        </figure>
                    </div>
                    <div class="col-md-9 col-sm-9">
                        <div class="panel arrow left">
                            <div class="panel-heading right">Reply</div>
                            <div class="panel-body">
                                <header class="text-left">
                                    <div class="comment-user"><i class="fa fa-user"></i> Replyer</div>
                                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> Dec 16, 2014</time>
                                </header>
                                <div class="comment-post">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                    </p>
                                </div>
                                <p class="text-right">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-thumbs-o-up fa-fw"></i></button>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-11"><div class="divider"></div></div>
                </article>
            </section>
        </div>

        <?php
    }
else:
    ?>
    <h3>No posts to view folks!!!</h3>
<?php
endif;
?>

