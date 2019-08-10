<?php
$listQuotationWo = $this->idHolders["nookleads"]["deal"]["list"]["quotation"]["list"]["wo"]["list"];
if ($this->quotationNoWo > 0) :
    if (is_numeric($this->ploop) && is_numeric($this->pcloop) && is_array($this->listLead)) {
        $i = $this->ploop;
        $lpcr = $this->pcloop;
        $newRes = (array) $this->listLead;
    } else if (is_numeric($this->lead_quotation_id) && is_array($this->listLead)) {
        $flag = false;
        $newRes = (array) $this->listLead;
        for ($j = 0; $j < count($this->listLead); $j++) {
            for ($k = 0; $k < count($this->listLead[$j]["leads"]["quotations"]["pc_id"]); $k++) {
                if ($this->lead_quotation_id === (integer) $this->listLead[$j]["leads"]["quotations"]["pc_id"][$k]) {
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
    for ($lpcri = 0; isset($newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr]) &&
            is_array($newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr]) &&
            $lpcri < count($newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr]) &&
            isset($newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]) &&
            $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri] != ''; $lpcri++) {
        $leadQuotationWoTime = '';
        if (isset($newRes[$i]["leads"]["quotations"]["wos"]["pcr_time"][$lpcr][$lpcri]) && $newRes[$i]["leads"]["quotations"]["wos"]["pcr_time"][$lpcr][$lpcri])
            $leadQuotationWoTime = date("M d, Y - h:i:s", strtotime($newRes[$i]["leads"]["quotations"]["wos"]["pcr_time"][$lpcr][$lpcri]));
        $crimage = false;
        $tmpImg = array();
        if ($newRes[$i]["leads"]["quotations"]["wos"]["pcr_pic_flag"][$lpcr][$lpcri] && isset($newRes[$i]["leads"]["quotations"]["wos"]["pcr_ph"][$lpcr][$lpcri]) && !empty($newRes[$i]["leads"]["quotations"]["wos"]["pcr_ph"][$lpcr][$lpcri])
        ) {
            array_push($tmpImg, $newRes[$i]["leads"]["quotations"]["wos"]["pcr_ph"][$lpcr][$lpcri], $newRes[$i]["leads"]["quotations"]["wos"]["pcr_pv1"][$lpcr][$lpcri], $newRes[$i]["leads"]["quotations"]["wos"]["pcr_pv2"][$lpcr][$lpcri], $newRes[$i]["leads"]["quotations"]["wos"]["pcr_pv3"][$lpcr][$lpcri], $newRes[$i]["leads"]["quotations"]["wos"]["pcr_pv4"][$lpcr][$lpcri], $newRes[$i]["leads"]["quotations"]["wos"]["pcr_pv5"][$lpcr][$lpcri]
            );
        }
        if (count($tmpImg) > 0 && $newRes[$i]["leads"]["quotations"]["wos"]["pcr_pic_flag"][$lpcr][$lpcri]) {
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
        if (!$crimage && $newRes[$i]["leads"]["quotations"]["wos"]["pcr_pic_flag"][$lpcr][$lpcri]) {
            $crimage = $this->config["DEFAULT_COMENT_IMG"];
        }
        $quotationWoNoApprovals = 0;
        if (isset($newRes[$i]["leads"]["quotations"]["wos"]["lk_rep_ct"]) &&
                count($newRes[$i]["leads"]["quotations"]["wos"]["lk_rep_ct"][$lpcr]) > 0 && isset($newRes[$i]["leads"]["quotations"]["wos"]["lk_rep_ct"][$lpcr][$lpcri]) && $newRes[$i]["leads"]["quotations"]["wos"]["lk_rep_ct"][$lpcr][$lpcri] != '')
            $quotationWoNoApprovals = $newRes[$i]["leads"]["quotations"]["wos"]["lk_rep_ct"][$lpcr][$lpcri];
        ?>
        <article class="row"
                 id="<?php echo $listQuotationWo["leadDiv"] . $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>"
                 name="<?php echo $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>">
            <div class="col-md-2 col-sm-2 col-md-offset-1 col-sm-offset-0 hidden-xs">
                <figure class="thumbnail">
                    <a href="javascript:void(0);">
                        <img class="img-responsive img-circle timeline-badge danger"
                             src="<?php echo $newRes[$i]["leads"]["quotations"]["wos"]["woerpic"][$lpcr][$lpcri]; ?>"  width="35" />
                    </a>
                </figure>
            </div>
            <div class="col-md-9 col-sm-9" style="background: #F0F0F0;">
                <div class="panel panel-default arrow left">
                    <div class="panel-heading right">
                        <div class="btn-group pull-right"
                             id="<?php echo $listQuotationWo["pref"]["parentDiv"] . $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>">
                            <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
                                <small><?php echo $listQuotationWo["pref"]["text"]; ?></small>
                            </button>
                            <ul class="dropdown-menu slidedown"
                                id="<?php echo $listQuotationWo["pref"]["outputDiv"] . $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>">
                                    <?php
                                    for ($lop = 0; $lop < count($listQuotationWo["pref"]) && isset($listQuotationWo["pref"][$lop]); $lop++) {
                                        if ($listQuotationWo["pref"][$lop]["status_id"] === 4):
                                            ?>
                                        <li name="<?php echo $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>" id="<?php echo $listQuotationWo["pref"][$lop]["action"]; ?>">
                                            <a href="javascript:void(0);" 
                                               id="<?php echo $listQuotationWo["pref"][$lop]["id"] . $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>"
                                               name="<?php echo $listQuotationWo["pref"][$lop]["acid"]; ?>"
                                               class="<?php echo $listQuotationWo["pref"][$lop]["class"]; ?>">
                                                <small><?php echo $listQuotationWo["pref"][$lop]["text"]; ?></small>
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
                    <div class="panel-body">
                        <header class="text-left">
                            <div class="quotation-user">
                                <i class="fa fa-user"></i>
                                <a href="javascript:void(0);"
                                   id="<?php echo $listQuotationWo["woer"] . $newRes[$i]["leads"]["quotations"]["wos"]["woererid"][$lpcr][$lpcri]; ?>"
                                   name="<?php echo $newRes[$i]["leads"]["quotations"]["wos"]["woererid"][$lpcr][$lpcri]; ?>">
                                       <?php echo $newRes[$i]["leads"]["quotations"]["wos"]["woername"][$lpcr][$lpcri]; ?>
                                </a>
                            </div>
                            <!--<time class="quotation-date" datetime="<?php echo $leadQuotationWoTime; ?>">
                                <small><i class="fa fa-clock-o"></i> <?php echo $leadQuotationWoTime; ?></small>
                            </time>-->
                        </header>
                        <div class="<?php echo $listQuotationWo["content"]; ?>">
                            <p>
                                <?php if ($newRes[$i]["leads"]["quotations"]["wos"]["pcr_pic_flag"][$lpcr][$lpcri]): ?>
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="col-lg-12 leadIMGBACK" style="background-image:url('<?php echo $crimage; ?>');">
                                            <img src="<?php echo $crimage; ?>" alt="" class="img-responsive"/>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <?php echo $newRes[$i]["leads"]["quotations"]["wos"]["wo"][$lpcr][$lpcri]; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <?php echo $newRes[$i]["leads"]["quotations"]["wos"]["wo"][$lpcr][$lpcri]; ?>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);"
                                       id="<?php echo $listQuotationWo["approval"]["id"] . $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>"
                                       name="<?php echo $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>"
                                       class="<?php echo $listQuotationWo["approval"]["class"]; ?>">
                                           <?php echo $listQuotationWo["approval"]["text"]; ?>
                                    </a>
                                    <span style="padding-right:20px;"></span>
                                    <a href="javascript:void(0);"
                                       id="<?php echo $listQuotationWo["disapproval"]["id"] . $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>"
                                       name="<?php echo $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>"
                                       class="<?php echo $listQuotationWo["disapproval"]["class"]; ?>">
                                           <?php echo $listQuotationWo["disapproval"]["text"]; ?>
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <i class="fa fa-thumbs-o-up thumbs-up"></i>&nbsp;
                                    <a href="javascript:void(0);" id="<?php echo $listQuotationWo["approval"]["counter"] . $newRes[$i]["leads"]["quotations"]["wos"]["pcr_id"][$lpcr][$lpcri]; ?>">
                                        <?php echo $quotationWoNoApprovals; ?>
                                    </a> approvals
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <?php
    }
else:
    ?>
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">0 wo...</div>
            <div class="panel-body">
                <h3>No Work Orders to view folks!!! <span class="<?php echo $listQuotationWo["content"]; ?>">:-O</span></h3>
            </div>
        </div>
    </div>
<?php
endif;
?>
