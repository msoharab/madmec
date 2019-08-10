<?php
$listlead = $this->idHolders["nookleads"]["deal"]["list"];
if (isset($_SESSION["ListNewLead"]) && count($_SESSION["ListNewLead"]) > 0 && isset($_SESSION["initial"]) && isset($_SESSION["final"])) :
    $newRes = (array) $_SESSION["ListNewLead"];
    for ($i = $_SESSION["initial"]; $i < $_SESSION["final"] && $i < count($newRes); $i++) {
        if (isset($this->lead_id) && is_numeric($this->lead_id) && $this->lead_id > 0) {
            for ($j = 0; $j < count($newRes); $j++) {
                if ($newRes[$j]["leads"]["id"] === (integer) $this->lead_id) {
                    $i = $j;
                    $j = count($newRes);
                    break;
                }
            }
        }
        $image = false;
        if ($newRes[$i]["leads"]["p_pic_flag"]) {
            $tmpImg = array_values($newRes[$i]["leads"]["photo"]);
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
                $image = $this->config["URL"] . $newRes[$i]["leads"]["photo"]["p_ph"];
            }
        } else {
            $image = $this->config["DEFAULT_POST_IMG"];
        }
        $leadTime = '';
        if (isset($newRes[$i]["leads"]["created_at"]) && $newRes[$i]["leads"]["created_at"])
            $leadTime = date("M d, Y - h:i:s", strtotime($newRes[$i]["leads"]["created_at"]));
        $this->quotationNo = 0;
        if (isset($newRes[$i]["leads"]["pc_ct"]) && $newRes[$i]["leads"]["pc_ct"] != '') {
            $this->quotationNo = $newRes[$i]["leads"]["pc_ct"];
        }
        ?>
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
                            <?php if (isset($_SESSION["USERDATA"]["logindata"]["id"]) && $_SESSION["USERDATA"]["logindata"]["id"] != $newRes[$i]["leads"]["user_id"]): ?>
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
                            <?php endif; ?>
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
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 leadIMGBACK" style="background-image:url('<?php echo $image; ?>');">
                            <img src="<?php echo $image; ?>" alt="" class="img-responsive"/>
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
                            <?php
                            if (isset($newRes[$i]["leads"]["chwaid"]) &&
                                    $newRes[$i]["leads"]["chwaid"] !== 0 &&
                                    isset($newRes[$i]["leads"]["chsubid"]) &&
                                    $newRes[$i]["leads"]["chsubid"] !== 0):
                                ?>
                                <div class="col-md-3" name="<?php echo $newRes[$i]["leads"]["chwacid"]; ?>">
                                    <button type="button" class="btn btn-danger pull-right"
                                            id="<?php echo $listlead["subscription"]["id"] . $newRes[$i]["leads"]["id"]; ?>"
                                            class="<?php echo $listlead["subscription"]["class"]; ?>"
                                            name="<?php echo $newRes[$i]["leads"]["user_id"]; ?>">
                                                <?php echo $listlead["subscription"]["text"]; ?>
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
                                <a href="javascript:void(0);" class="ellipsis" onclick="$('#comtarget<?php echo $i; ?>').slideToggle('slow');">
                                    <i class="fa fa-ellipsis-h fa-lg"></i>
                                    <i class="fa fa-ellipsis-h fa-lg"></i>
                                </a>
                                <!--<time class="quotation-date" datetime="<?php echo $leadTime; ?>">
                                    <i class="fa fa-clock-o"></i> <?php echo $leadTime; ?>
                                </time>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer" id="comtarget<?php echo $i; ?>" style="display:none;">
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
                                       <?php echo $listlead["quotation"]["camera"]["icon"]; ?>
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
                    <div class="col-lg-12" id="<?php echo $listlead["quotation"]["list"]["parentDiv"] . $newRes[$i]["leads"]["id"]; ?>" style="display:none;">
                        <section class="quotation-list" id="<?php echo $listlead["quotation"]["list"]["outputDiv"] . $newRes[$i]["leads"]["id"]; ?>">
                            <?php
                            //require 'listQuotation.php';
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($this->lead_id) && is_numeric($this->lead_id) && $this->lead_id > 0) {
            for ($j = 0; $j < count($newRes); $j++) {
                if ($newRes[$j]["leads"]["id"] === (integer) $this->lead_id) {
                    $i = count($newRes);
                    break;
                }
            }
        }
    }
    ?>
    <div class="col-lg-12 text-center" id="<?php echo $listlead["loader"]; ?>"></div>
    <!-- Modal for lead quotation photo -->
    <div class="modal fade"
         id="<?php echo $listlead["quotation"]["camera"]["parentDiv"]; ?>"
         tabindex="-1"
         role="dialog"
         aria-labelledby="<?php echo $listlead["quotation"]["camera"]["moodalId"]; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title"
                        id="<?php echo $listlead["quotation"]["camera"]["moodalId"]; ?>">Quotation on lead.</h3>
                </div>
                <form id="<?php echo $listlead["quotation"]["camera"]["form"]; ?>"
                      name="<?php echo $listlead["quotation"]["camera"]["form"]; ?>"
                      method="lead"
                      action="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>UploadPic/quotations"
                      enctype="multipart/form-data">
                    <fieldset>
                        <div class="modal-body">
                            <div class="conatiner">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <textarea type="text" class="form-control" placeholder="Quotation On Picutre...."
                                                  id="<?php echo $listlead["quotation"]["camera"]["text"]; ?>"
                                                  name="<?php echo $listlead["quotation"]["camera"]["text"]; ?>"
                                                  class="from-control"></textarea>
                                    </div>
                                    <div class="col-lg-12"><h4>Select picture.</h4></div>
                                    <div class="col-lg-12">
                                        <input type="file"
                                               name="<?php echo $listlead["quotation"]["camera"]["name"]; ?>"
                                               id="<?php echo $listlead["quotation"]["camera"]["img"]; ?>"
                                               class="<?php echo $listlead["quotation"]["camera"]["class"]; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-default"
                                    data-dismiss="modal"
                                    name="<?php echo $listlead["quotation"]["camera"]["close"]; ?>"
                                    id="<?php echo $listlead["quotation"]["camera"]["close"]; ?>">Close</button>
                            <button type="submit"
                                    class="btn btn-primary"
                                    name="<?php echo $listlead["quotation"]["camera"]["create"]; ?>"
                                    id="<?php echo $listlead["quotation"]["camera"]["create"]; ?>">Create</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!--End of lead quotation photo modal-->
<?php else :
    ?>
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">0 Leads to load...</div>
            <div class="panel-body">
                <h3>No leads to view folks!!! <span class="<?php echo $listlead["smiley"]; ?>">:-O</span></h3>
            </div>
        </div>
    </div>
    <?php
endif;
?>
