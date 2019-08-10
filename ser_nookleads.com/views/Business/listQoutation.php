<?php
$listQuotation = $this->idHolders["nookleads"]["business"]["home"]["list"]["quotation"]["list"];
if (isset($this->ploop) && is_numeric($this->ploop) && is_array($this->listLead)) {
    $i = $this->ploop;
    $newRes = (array) $this->listLead;
} else if (isset($this->lead_id) && is_numeric($this->lead_id) && is_array($this->listLead) && $this->lead_id > 0) {
    for ($j = 0; $j < count($this->listLead); $j++) {
        if ($this->lead_id === $this->listLead[$j]["leads"]["id"]) {
            $i = $j;
            $newRes = (array) $this->listLead;
            break;
        }
    }
}
$this->quotationNo = 0;
if (isset($newRes[$i]["leads"]["pc_ct"]) && $newRes[$i]["leads"]["pc_ct"] != '') {
    $this->quotationNo = $newRes[$i]["leads"]["pc_ct"];
}
if ($this->quotationNo > 0) :
    for ($lp = 0; is_array($newRes[$i]["leads"]["quotations"]["pc_id"]) &&
            $lp < count($newRes[$i]["leads"]["quotations"]["pc_id"]) &&
            isset($newRes[$i]["leads"]["quotations"]["pc_id"][$lp]) &&
            $newRes[$i]["leads"]["quotations"]["pc_id"][$lp] != ''; $lp++) {
        $cimage = false;
        $tmpImg = array();
        if ($newRes[$i]["leads"]["quotations"]["pc_pic_flag"][$lp] && isset($newRes[$i]["leads"]["quotations"]["pc_ph"][$lp]) && !empty($newRes[$i]["leads"]["quotations"]["pc_ph"][$lp])
        ) {
            array_push($tmpImg, $newRes[$i]["leads"]["quotations"]["pc_ph"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv1"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv2"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv3"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv4"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv5"][$lp]
            );
        }
        if (count($tmpImg) > 0 && $newRes[$i]["leads"]["quotations"]["pc_pic_flag"][$lp]) {
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
        if (!$cimage && $newRes[$i]["leads"]["quotations"]["pc_pic_flag"][$lp]) {
            $cimage = $this->config["DEFAULT_COMENT_IMG"];
        }
        $leadQuotationTime = '';
        if (isset($newRes[$i]["leads"]["quotations"]["pc_time"][$lp]) && $newRes[$i]["leads"]["quotations"]["pc_time"][$lp])
            $leadQuotationTime = date("M d, Y - h:i:s", strtotime($newRes[$i]["leads"]["quotations"]["pc_time"][$lp]));
        $quotationNoApprovals = 0;
        if (isset($newRes[$i]["leads"]["quotations"]["lk_pc_ct"]) && isset($newRes[$i]["leads"]["quotations"]["lk_pc_ct"][$lp]) && $newRes[$i]["leads"]["quotations"]["lk_pc_ct"][$lp] != '') {
            $quotationNoApprovals = $newRes[$i]["leads"]["quotations"]["lk_pc_ct"][$lp];
        }
        $this->quotationNoWo = 0;
        if (isset($newRes[$i]["leads"]["quotations"]["wos"]["pcr_ct"]) && isset($newRes[$i]["leads"]["quotations"]["wos"]["pcr_ct"][$lp]) && $newRes[$i]["leads"]["quotations"]["wos"]["pcr_ct"][$lp] != '')
            $this->quotationNoWo = $newRes[$i]["leads"]["quotations"]["wos"]["pcr_ct"][$lp];
        ?>
        <article class="row"
                 id="<?php echo $listQuotation["leadDiv"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                 name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>">
            <div class="col-lg-12">
                <div class="col-lg-2">
                    <img class="img-responsive timeline-badge danger"
                         src="<?php echo $newRes[$i]["leads"]["quotations"]["quotationerpic"][$lp]; ?>"  width="50" />
                </div>
                <div class="col-lg-10">
                    <a href="javascript:void(0);"
                       id="<?php echo $listQuotation["quotationer"] . $newRes[$i]["leads"]["quotations"]["quotationererid"][$lp]; ?>"
                       name="<?php echo $newRes[$i]["leads"]["quotations"]["quotationererid"][$lp]; ?>">
                           <?php echo $newRes[$i]["leads"]["quotations"]["quotationername"][$lp]; ?>
                    </a>
                    <?php if ($newRes[$i]["leads"]["quotations"]["pc_pic_flag"][$lp]): ?>
                        <div class="<?php echo $listQuotation["content"]; ?> panel">
                            <div class="panel-body">
                                <div class="col-lg-12 leadIMGBACK" style="background-image:url('<?php echo $cimage; ?>');">
                                    <img src="<?php echo $cimage; ?>" alt="" class="img-responsive"/>
                                </div>
                            </div>
                            <div class="panel-footer <?php echo $listQuotation["content"]; ?>">
                                <?php echo $newRes[$i]["leads"]["quotations"]["quotations"][$lp]; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="<?php echo $listQuotation["content"]; ?> panel">
                            <?php echo $newRes[$i]["leads"]["quotations"]["quotations"][$lp]; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12 pull-right">
                <ul class="list-inline">
                    <li>
                        <a href="javascript:void(0);"
                           id="<?php echo $listQuotation["approval"]["id"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                           name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                           title="Approval"
                           class="<?php echo $listQuotation["approval"]["class"]; ?>">
                               <?php echo $listQuotation["approval"]["text"]; ?>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"
                           id="<?php echo $listQuotation["disapproval"]["id"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                           name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                           title="Disapproval"
                           class="<?php echo $listQuotation["disapproval"]["class"]; ?>">
                               <?php echo $listQuotation["disapproval"]["text"]; ?>
                        </a>
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);"
                           class="ellipsis"
                           onclick="$('#comrtarget<?php echo $i . '_' . $lp; ?>').slideToggle('slow');">
                            <i class="fa fa-ellipsis-h fa-lg"></i>
                        </a>
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);"
                           class="link-black text-sm">
                            Wo (<span id="<?php echo $listQuotation["wo"]["counter"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"><?php echo $this->quotationNoWo; ?></span>)
                        </a>
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);"
                           class="link-black text-sm">
                            Approvals (<span id="<?php echo $listQuotation["approval"]["counter"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"><?php echo $quotationNoApprovals; ?></span>)
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-xs-11 col-sm-11 col-lg-11 col-xs-offset-0 col-sm-offset-0 col-md-offset-1"
                 id="comrtarget<?php echo $i . '_' . $lp; ?>" style="display:none;">
                <div class="col-lg-12">
                    <div class="form-group input-group">
                        <input class="form-control" placeholder="Wo On Quotation...."
                               id="<?php echo $listQuotation["wo"]["woBOX"]["id"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                               name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>" />
                        <span class="input-group-addon">
                            <a href="#"
                               id="<?php echo $listQuotation["wo"]["woBOX"]["but"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                               name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                               class="<?php echo $listQuotation["wo"]["woBOX"]["class"]; ?>">
                                   <?php echo $listQuotation["wo"]["woBOX"]["text"]; ?>
                            </a>
                        </span>
                        <span class="input-group-addon">
                            <div class="btn-group pull-right"
                                 id="<?php echo $listQuotation["wo"]["smiley"]["parentDiv"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>">
                                <a href="javascript:void(0);" data-toggle="dropdown" >
                                    <?php echo $listQuotation["wo"]["smiley"]["text"]; ?>
                                </a>
                                <ul class="dropdown-menu slidedown"
                                    id="<?php echo $listQuotation["wo"]["smiley"]["outputDiv"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>">
                                    <?php
                                    for ($lop = 0; $lop < count($listQuotation["wo"]["smiley"]["emoticons"]) && isset($listQuotation["wo"]["smiley"]["emoticons"][$lop]); $lop++) {
                                        ?>
                                        <li name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>">
                                            <a name="<?php echo $listQuotation["wo"]["woBOX"]["id"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>" style="font-size:28px;" href="javascript:void(0);">
                                                <?php echo $listQuotation["wo"]["smiley"]["emoticons"][$lop]; ?>
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
                               id="<?php echo $listQuotation["wo"]["camera"]["moodalBut"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                               name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                               class="<?php echo $listQuotation["wo"]["camera"]["moodalClass"]; ?>"
                               data-toggle="modal"
                               data-target="#<?php echo $listQuotation["wo"]["camera"]["parentDiv"]; ?>"
                               data-whatever="@mdo">
                                   <?php echo $listQuotation["wo"]["camera"]["icon"]; ?>
                            </a>
                        </span>
                        <span class="input-group-addon" data-bind="<?php echo $i; ?>">
                            <a href="#"
                               data-bind="<?php echo $lp; ?>"
                               id="<?php echo $listQuotation["wo"]["expand"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                               class="<?php echo $listQuotation["wo"]["expandClass"]; ?>"
                               name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>" >
                                   <?php echo $listQuotation["wo"]["text"]; ?>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 pull-right"
                     id="<?php echo $listQuotation["wo"]["list"]["parentDiv"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                     style="display:none;">
                    <section class="quotation-list" id="<?php echo $listQuotation["wo"]["list"]["outputDiv"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>">
                        <?php
                        //require 'listWo.php';
                        ?>
                    </section>
                </div>
            </div>
        </article>
        <?php
    }
    ?>
    <!-- Modal for lead quotation photo -->
    <div class="modal fade"
         id="<?php echo $listQuotation["wo"]["camera"]["parentDiv"]; ?>"
         tabindex="-1"
         role="dialog"
         aria-labelledby="<?php echo $listQuotation["wo"]["camera"]["moodalId"]; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title"
                        id="<?php echo $listQuotation["wo"]["camera"]["moodalId"]; ?>">Wo on quotation.</h3>
                </div>
                <form class=""
                      id="<?php echo $listQuotation["wo"]["camera"]["form"]; ?>"
                      name="<?php echo $listQuotation["wo"]["camera"]["form"]; ?>"
                      method="lead"
                      action="<?php echo $this->config["URL"] . $this->config["CTRL_18"]; ?>UploadPic/wos"
                      enctype="multipart/form-data">
                    <fieldset>
                        <div class="modal-body">
                            <div class="conatiner">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Wo on quotation...."
                                               id="<?php echo $listQuotation["wo"]["camera"]["text"]; ?>"
                                               name="<?php echo $listQuotation["wo"]["camera"]["text"]; ?>"
                                               class="from-control" />
                                    </div>
                                    <div class="col-lg-12"><h4>Select picture.</h4></div>
                                    <div class="col-lg-12">
                                        <input type="file"
                                               name="<?php echo $listQuotation["wo"]["camera"]["name"]; ?>"
                                               id="<?php echo $listQuotation["wo"]["camera"]["img"]; ?>"
                                               class="<?php echo $listQuotation["wo"]["camera"]["class"]; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-default"
                                    data-dismiss="modal"
                                    name="<?php echo $listQuotation["wo"]["camera"]["close"]; ?>"
                                    id="<?php echo $listQuotation["wo"]["camera"]["close"]; ?>">Close</button>
                            <button type="submit"
                                    class="btn btn-primary"
                                    name="<?php echo $listQuotation["wo"]["camera"]["create"]; ?>"
                                    id="<?php echo $listQuotation["wo"]["camera"]["create"]; ?>">Create</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!--End of lead quotation photo modal-->
    <?php
else:
    ?>
    <div class="col-lg-12"><div class="business-heading align-center"></div></div>
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">0 quotations...</div>
            <div class="panel-body">
                <h3>No quotations to view folks!!! <span class="<?php echo $listQuotation["content"]; ?>">:-O</span></h3>
            </div>
        </div>
    </div>
<?php
endif;
?>