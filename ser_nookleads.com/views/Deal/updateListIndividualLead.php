<?php
/* Lead */
//        $newRes[$i]["leads"]["id"]
//        $newRes[$i]["leads"]["title"]
//        $newRes[$i]["leads"]["photo_id"]
//        $newRes[$i]["leads"]["section_id"]
//        $newRes[$i]["leads"]["user_id"]
//        $newRes[$i]["leads"]["created_at"]
//        $newRes[$i]["leads"]["leadername"]
/* Lead Photo */
//        $newRes[$i]["leads"]["photo"]["p_phid"]
//        $newRes[$i]["leads"]["photo"]["p_ph"]
//        $newRes[$i]["leads"]["photo"]["p_pv1"]
//        $newRes[$i]["leads"]["photo"]["p_pv2"]
//        $newRes[$i]["leads"]["photo"]["p_pv3"]
//        $newRes[$i]["leads"]["photo"]["p_pv5"]
/* Lead Languages */
//        $newRes[$i]["leads"]["languages"]["plng_id"]
//        $newRes[$i]["leads"]["languages"]["plng_time"]
//        $newRes[$i]["leads"]["languages"]["plng_lngid"]
//        $newRes[$i]["leads"]["languages"]["plng_lngname"]
/* Lead Sections */
//        $newRes[$i]["leads"]["sections"]["ps_id"]
//        $newRes[$i]["leads"]["sections"]["ps_time"]
//        $newRes[$i]["leads"]["sections"]["ps_secid"]
//        $newRes[$i]["leads"]["sections"]["pr_secname"]
/* Lead Approvals */
//        $newRes[$i]["leads"]["approvals"]["lk_p_uname"]
//        $newRes[$i]["leads"]["approvals"]["lk_p_id"]
//        $newRes[$i]["leads"]["approvals"]["lk_p_uid"]
//        $newRes[$i]["leads"]["approvals"]["lk_p_time"]
/* Lead Preferences */
//        $newRes[$i]["leads"]["preference"]["pp_uname"]
//        $newRes[$i]["leads"]["preference"]["pp_id"]
//        $newRes[$i]["leads"]["preference"]["pp_uid"]
//        $newRes[$i]["leads"]["preference"]["pp_time"]
//        $newRes[$i]["leads"]["preference"]["pp_preid"]
//        $newRes[$i]["leads"]["preference"]["pp_pref"]
/* Lead Report */
//        $newRes[$i]["leads"]["report"]["pr_uname"]
//        $newRes[$i]["leads"]["report"]["pr_id"]
//        $newRes[$i]["leads"]["report"]["pr_uid"]
//        $newRes[$i]["leads"]["report"]["pr_time"]
//        $newRes[$i]["leads"]["report"]["pr_repid"]
//        $newRes[$i]["leads"]["report"]["pr_repname"]
/* Lead Location */
//        $newRes[$i]["leads"]["lead_location"]["lead_location"]
//        $newRes[$i]["leads"]["lead_location"]["pcont_id"]
//        $newRes[$i]["leads"]["lead_location"]["pcont_time"]
//        $newRes[$i]["leads"]["lead_location"]["pcont_contid"]
//        $newRes[$i]["leads"]["lead_location"]["pcont_contname"]
/* Lead Business */
//        $newRes[$i]["leads"]["lead_location"]["chwaid"]
//        $newRes[$i]["leads"]["lead_location"]["chwauid"]
//        $newRes[$i]["leads"]["lead_location"]["chwacid"]
//        $newRes[$i]["leads"]["lead_location"]["chwalead_id"]
//        $newRes[$i]["leads"]["lead_location"]["chwatime"]
$listlead = $this->idHolders["nookleads"]["deal"]["list"];
$newRes = (array) $_SESSION["ListNewLead"];
if (isset($this->lead_id) && is_numeric($this->lead_id) && $this->lead_id > 0) {
    for ($i = 0; $i < count($newRes); $i++) {
        if ($newRes[$i]["leads"]["id"] === (integer) $this->lead_id) {
            $image = false;
            $tmpImg = array_values($newRes[$i]["leads"]["photo"]);
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
                $image = $newRes[$i]["leads"]["photo"]["p_ph"];
            $leadTime = '';
            if (isset($newRes[$i]["leads"]["created_at"]) && $newRes[$i]["leads"]["created_at"])
                $leadTime = date("M d, Y - h:i:s", strtotime($newRes[$i]["leads"]["created_at"]));
            $this->quotationNo = 0;
            if (isset($newRes[$i]["leads"]["pc_ct"]) && $newRes[$i]["leads"]["pc_ct"] != '') {
                $this->quotationNo = $newRes[$i]["leads"]["pc_ct"];
            }
            ?>
            <div class="col-lg-12"><div class="business-heading align-center"></div></div>
            <div class="col-lg-12"
                 id="<?php echo $listlead["leadDiv"] . $newRes[$i]["leads"]["id"]; ?>"
                 name="<?php echo $newRes[$i]["leads"]["id"]; ?>">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-12">
                                <i class="fa fa-user fa-2x"></i>&nbsp;
                                <a href="javascript:void(0);"><?php echo $newRes[$i]["leads"]["leadername"]; ?></a>,&nbsp;
                                <?php echo ucfirst($newRes[$i]["leads"]["title"]); ?>
                            </div>
                            <div class="col-lg-12">
                                <div class="btn-group pull-right"
                                     id="<?php echo $listlead["report"]["parentDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <?php echo $listlead["report"]["text"]; ?>
                                    </button>
                                    <ul class="dropdown-menu slidedown"
                                        id="<?php echo $listlead["report"]["outputDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                                            <?php
                                            for ($lp = 0; $lp < count($listlead["report"]) && isset($listlead["report"][$lp]); $lp++) {
                                                if ($listlead["report"][$lp]["status_id"] === 4):
                                                    ?>
                                                <li name="<?php echo $newRes[$i]["leads"]["id"]; ?>">
                                                    <a href="javascript:void(0);"
                                                       id="<?php echo $listlead["report"][$lp]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                                       name="<?php echo $listlead["report"][$lp]["acid"]; ?>"
                                                       class="<?php echo $listlead["report"][$lp]["class"]; ?>">
                                                           <?php echo $listlead["report"][$lp]["text"]; ?>
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
                                     id="<?php echo $listlead["pref"]["parentDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <?php echo $listlead["pref"]["text"]; ?>
                                    </button>
                                    <ul class="dropdown-menu slidedown"
                                        id="<?php echo $listlead["pref"]["outputDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                                            <?php
                                            for ($lp = 0; $lp < count($listlead["pref"]) && isset($listlead["pref"][$lp]); $lp++) {
                                                if ($listlead["pref"][$lp]["status_id"] === 4):
                                                    ?>
                                                <li name="<?php echo $newRes[$i]["leads"]["id"]; ?>" id="<?php echo $listlead["pref"][$lp]["action"]; ?>">
                                                    <a href="javascript:void(0);"
                                                       id="<?php echo $listlead["pref"][$lp]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                                       name="<?php echo $listlead["pref"][$lp]["acid"]; ?>"
                                                       class="<?php echo $listlead["pref"][$lp]["class"]; ?>">
                                                           <?php echo $listlead["pref"][$lp]["text"]; ?>
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
                                     id="<?php echo $listlead["sections"]["parentDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <?php echo $listlead["sections"]["text"]; ?>
                                    </button>
                                    <ul class="dropdown-menu slidedown"
                                        id="<?php echo $listlead["sections"]["outputDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                                <?php
                                for ($lp = 0; $lp < count($newRes[$i]["leads"]["sections"]["pr_secname"]) && isset($newRes[$i]["leads"]["sections"]["pr_secname"][$lp]); $lp++) {
                                    ?>
                                                                        <li name="<?php echo $newRes[$i]["leads"]["id"]; ?>">
                                                                            <a href="javascript:void(0);"
                                                                               id="<?php echo $listlead["sections"]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                                                               name="<?php echo $listlead["sections"][$lp]["acid"]; ?>"
                                                                               class="<?php echo $listlead["sections"]["class"]; ?>">
                                    <?php echo ucfirst($newRes[$i]["leads"]["sections"]["pr_secname"][$lp]); ?>
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
                            <div class="col-lg-12 leadIMGBACK" style="background-image:url('<?php echo $this->config["URL"] . $image; ?>');">
                                <img src="<?php echo $this->config["URL"] . $image; ?>" alt="" class="img-responsive"/>
                            </div>
                            <div class="col-lg-12"><div class="clearfix"><br /></div></div>
                            <div class="col-lg-12">
                                <div class="col-md-2">
                                    <a href="javascript:void(0);"
                                       id="<?php echo $listlead["approval"]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                       name="<?php echo $newRes[$i]["leads"]["id"]; ?>"
                                       class="<?php echo $listlead["approval"]["class"]; ?>">
                                           <?php echo $listlead["approval"]["text"]; ?>
                                    </a>
                                    <span style="padding-right:20px;"></span>
                                    <a href="javascript:void(0);"
                                       id="<?php echo $listlead["disapproval"]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                       name="<?php echo $newRes[$i]["leads"]["id"]; ?>"
                                       class="<?php echo $listlead["disapproval"]["class"]; ?>">
                                           <?php echo $listlead["disapproval"]["text"]; ?>
                                    </a>
                                </div>
                                <div class="col-md-7">
                                    <a href="javascript:void(0);"
                                       id="<?php echo $listlead["sections"]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                       name="<?php echo $newRes[$i]["leads"]["sections"]["ps_secid"]; ?>"
                                       class="<?php echo $listlead["sections"]["class"]; ?>">
                                           <?php echo ucfirst($newRes[$i]["leads"]["sections"]["pr_secname"]); ?>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-danger pull-right"
                                            id="<?php echo $listlead["subscription"]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                            class="<?php echo $listlead["subscription"]["class"]; ?>"
                                            name="<?php echo $newRes[$i]["leads"]["user_id"]; ?>">
                                                <?php echo $listlead["subscription"]["text"]; ?>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12"><div class="divider"></div></div>
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <i class="fa fa-thumbs-o-up thumbs-up"></i>&nbsp;
                                    <a href="javascript:void(0);" id="<?php echo $listlead["approval"]["counter"] . $newRes[$i]["leads"]["id"]; ?>">
                                        <?php echo $newRes[$i]["leads"]["lk_p_ct"]; ?>
                                    </a> approvals
                                </div>
                                <div class="col-lg-4">
                                    <a href="javascript:void(0);"> . </a>
                                    <i class="fa fa-envelope-square thumbs-up"></i>
                                    <a href="javascript:void(0);" id="<?php echo $listlead["quotation"]["counter"] . $newRes[$i]["leads"]["id"]; ?>">
                                        <?php echo $this->quotationNo; ?>
                                    </a> quotations
                                </div>
                                <div class="col-lg-4 text-right">
                                    <time class="quotation-date" datetime="<?php echo $leadTime; ?>">
                                        <i class="fa fa-clock-o"></i> <?php echo $leadTime; ?>
                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="col-lg-12" id="<?php echo $listlead["quotation"]["deal"]["parentDiv"] . $newRes[$i]["leads"]["id"]; ?>" style="display:none;">
                            <section class="quotation-list" id="<?php echo $listlead["quotation"]["deal"]["outputDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                                <?php
                                //require 'listQuotation.php';
                                ?>
                            </section>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group input-group">
                                <textarea class="form-control" placeholder="Quotation On Picutre...."
                                          id="<?php echo $listlead["quotation"]["quotationBOX"]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                          name="<?php echo $newRes[$i]["leads"]["id"]; ?>"></textarea>
                                <span class="input-group-addon">
                                    <a href="#"
                                       id="<?php echo $listlead["quotation"]["quotationBOX"]["but"] . $newRes[$i]["leads"]["id"]; ?>"
                                       name="<?php echo $newRes[$i]["leads"]["id"]; ?>"
                                       class="<?php echo $listlead["quotation"]["quotationBOX"]["class"]; ?>">
                                           <?php echo $listlead["quotation"]["quotationBOX"]["text"]; ?>
                                    </a>
                                </span>
                                <span class="input-group-addon">
                                    <div class="btn-group pull-right"
                                         id="<?php echo $listlead["quotation"]["smiley"]["parentDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                                        <a href="javascript:void(0);" data-toggle="dropdown" >
                                            <?php echo $listlead["quotation"]["smiley"]["text"]; ?>
                                        </a>
                                        <ul class="dropdown-menu slidedown"
                                            id="<?php echo $listlead["quotation"]["smiley"]["outputDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                                            <?php
                                            for ($lp = 0; $lp < count($listlead["quotation"]["smiley"]["emoticons"]) && isset($listlead["quotation"]["smiley"]["emoticons"][$lp]); $lp++) {
                                                ?>
                                                <li name="<?php echo $newRes[$i]["leads"]["id"]; ?>">
                                                    <a name="<?php echo $listlead["quotation"]["quotationBOX"]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                                       style="font-size:48px;"
                                                       href="javascript:void(0);">
                                                           <?php echo $listlead["quotation"]["smiley"]["emoticons"][$lp]; ?>
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
                                       id="<?php echo $listlead["quotation"]["camera"]["moodalBut"] . $newRes[$i]["leads"]["id"]; ?>"
                                       name="<?php echo $newRes[$i]["leads"]["id"]; ?>"
                                       class="<?php echo $listlead["quotation"]["camera"]["moodalClass"]; ?>"
                                       data-toggle="modal"
                                       data-target="#<?php echo $listlead["quotation"]["camera"]["parentDiv"]; ?>"
                                       data-whatever="@mdo">
                                           <?php echo $listlead["quotation"]["camera"]["text"]; ?>
                                    </a>
                                </span>
                                <span class="input-group-addon">
                                    <a href="#"
                                       data-bind="<?php echo $i; ?>"
                                       id="<?php echo $listlead["quotation"]["expand"] . $newRes[$i]["leads"]["id"]; ?>"
                                       class="<?php echo $listlead["quotation"]["expandClass"]; ?>"
                                       name="<?php echo $newRes[$i]["leads"]["id"]; ?>" >
                                           <?php echo $listlead["quotation"]["text"]; ?>
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
