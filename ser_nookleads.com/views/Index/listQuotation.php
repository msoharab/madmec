<?php
$listQuotation = $this->idHolders["nookleads"]["index"]["list"]["quotation"]["list"];
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
            array_push($tmpImg, $newRes[$i]["leads"]["quotations"]["pc_ph"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv1"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv2"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv3"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv4"][$lp], $newRes[$i]["leads"]["quotations"]["pc_pv5"][$lp]);
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
                 name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>" >
            <div class="col-lg-12">
                <div class="col-lg-2">
                    <img class="img-responsive timeline-badge danger" 
                         src="<?php echo $newRes[$i]["leads"]["quotations"]["quotationerpic"][$lp]; ?>"  width="50" />
                </div>
                <div class="col-lg-10">
                    <span class="username">
                        <a href="javascript:void(0);" >
                            <?php echo $newRes[$i]["leads"]["quotations"]["quotationername"][$lp]; ?>
                        </a>
                    </span>
                    <?php if ($newRes[$i]["leads"]["quotations"]["pc_pic_flag"][$lp]): ?>
                        <div class="panel">
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
            <div class="col-xs-12 col-sm-12 col-lg-11 pull-right"> 
                <ul class="list-inline">
                    <li class="pull-right" data-bind="<?php echo $i; ?>">
                        <a href="javascript:void(0);"
                           data-bind="<?php echo $lp; ?>"
                           id="<?php echo $listQuotation["wo"]["expand"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"
                           class="<?php echo $listQuotation["wo"]["expandClass"]; ?> link-black text-sm" 
                           name="<?php echo $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>" >
                            <i class="fa fa-ellipsis-h fa-lg"></i>
                        </a>
                    </li>
                    <li class="pull-right">
                        <a href="javascript:void(0);" class="link-black text-sm"
                           id="<?php echo $listQuotation["wo"]["counter"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"> 
                            Wo (<?php echo $this->quotationNoWo; ?>)
                        </a> 
                    </li>
                    <!--<li class="pull-right">
                        <a href="javascript:void(0);" 
                           class="link-black text-sm"
                           id="<?php echo $listQuotation["approval"]["counter"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>">
                            Approvals (<?php echo $quotationNoApprovals; ?>)
                        </a> 
                    </li>!-->
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-11 pull-right" 
                 id="<?php echo $listQuotation["wo"]["list"]["parentDiv"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>" 
                 style="display:none;">
                <span id="<?php echo $listQuotation["wo"]["list"]["outputDiv"] . $newRes[$i]["leads"]["quotations"]["pc_id"][$lp]; ?>"> 
                    <?php
                    //require 'listWo.php';
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
        <h4>No quotations to view folks!!! <span class="<?php echo $listQuotation["content"]; ?>">:-O</span></h4>
    </div>
<?php
endif;
?>
