<?php
        /* Post */
//        $newRes[$i]["posts"]["id"]
//        $newRes[$i]["posts"]["title"]
//        $newRes[$i]["posts"]["photo_id"]
//        $newRes[$i]["posts"]["section_id"]
//        $newRes[$i]["posts"]["user_id"]
//        $newRes[$i]["posts"]["created_at"]
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
    $newRes = $_SESSION["ListNewPost"];
    for ($i = $_SESSION["initial"]; $i < $_SESSION["final"]; $i++) {
        ?>
        <div class="dropdown close-post" id="<?php echo $listpost["preferences"]["parentDiv"]; ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-close"></i>
            </a>
            <div class="dropdown-menu close-post-dd" id="<?php echo $listpost["preferences"]["outputDiv"]; ?>">
                <div class="close-post-dd-item"><a href="javascript:void(0);" id="">opt 1</a></div>
                <div class="close-post-dd-item"><a href="javascript:void(0);" id="">opt 2</a></div>
                <div class="close-post-dd-item"><a href="javascript:void(0);" id="">Loading....</a></div>
            </div>
        </div>
        <div class="" id="<?php echo $listpost["post"]["allphotos"]["parentDiv"]; ?>">
            <a class="fancybox" rel="gallery2" title="Gallery 1 - 1" href="<?php echo $this->config["URL"] . $newRes[$i]["posts"]["photo"]["p_pv2"]; ?>">
                <img src="<?php echo $this->config["URL"] . $newRes[$i]["posts"]["photo"]["p_pv2"]; ?>" alt="" />
            </a>
            <div class="hidden" id="<?php echo $listpost["post"]["allphotos"]["outputDiv"]; ?>">
                <a class="fancybox" rel="gallery2" title="Gallery 1 - 2" href="<?php echo $this->config["URL"] . $newRes[$i]["posts"]["photo"]["p_pv2"]; ?>">
                    <img src="<?php echo $this->config["URL"] . $newRes[$i]["posts"]["photo"]["p_pv2"]; ?>" alt="" />
                </a>
                <a class="fancybox" rel="gallery2" title="Gallery 1 - 3" href="<?php echo $this->config["URL"] . $newRes[$i]["posts"]["photo"]["p_pv2"]; ?>">
                    <img src="<?php echo $this->config["URL"] . $newRes[$i]["posts"]["photo"]["p_pv2"]; ?>" alt="" />
                </a>
                <a class="fancybox" rel="gallery2" title="Gallery 1 - 4" href="javascript:void(0);">
                    Loading.........
                </a>
            </div>
        </div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <?php
    }
else: ?>
<h3>No posts to view folks!!!</h3>
<?php
endif;
?>

