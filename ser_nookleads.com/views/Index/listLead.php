<?php
$listlead = $this->idHolders["nookleads"]["index"]["list"];
?>
<div class="col-lg-12"><div class="business-heading align-center"></div></div>
<div class="col-lg-12 text-center" id="<?php echo $listlead["loader"]; ?>"></div>
<?php
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
            <div class="row panel">
                <h3><?php echo ucfirst($newRes[$i]["leads"]["title"]); ?></h3>
                <div class="col-lg-12 leadIMGBACK" style="background-image:url('<?php echo $image; ?>');">
                    <img src="<?php echo $image; ?>" alt="" class="img-responsive"/>
                </div>
                <div class="col-lg-12">
                    <div class="col-md-8">
                        <a href="javascript:void(0);" 
                           id="<?php echo $listlead["sections"]["id"] . $newRes[$i]["leads"]["id"]; ?>" 
                           name="<?php echo $newRes[$i]["leads"]["sections"]["ps_secid"]; ?>" 
                           class="<?php echo $listlead["sections"]["class"]; ?>">
                            <h4> <?php echo ucfirst($newRes[$i]["leads"]["sections"]["pr_secname"]); ?></h4>
                        </a>
                    </div>
                    <?php
                    if (isset($newRes[$i]["leads"]["chwaid"]) &&
                            $newRes[$i]["leads"]["chwaid"] !== 0 &&
                            isset($newRes[$i]["leads"]["chsubid"]) &&
                            $newRes[$i]["leads"]["chsubid"] !== 0):
                        ?>
                        <div class="col-md-4" name="<?php echo $newRes[$i]["leads"]["chwacid"]; ?>">
                            <?php echo $newRes[$i]["leads"]["business_name"]; ?>
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
                               id="<?php echo $listlead["quotation"]["expand"] . $newRes[$i]["leads"]["id"]; ?>"
                               class="<?php echo $listlead["quotation"]["expandClass"]; ?>" 
                               name="<?php echo $newRes[$i]["leads"]["id"]; ?>" >
                                <i class="fa fa-ellipsis-h fa-lg"></i> 
                                <i class="fa fa-ellipsis-h fa-lg"></i>
                            </a>
                        </li>
                        <li class="pull-right">
                            <a href="javascript:void(0);" id="<?php echo $listlead["quotation"]["counter"] . $newRes[$i]["leads"]["id"]; ?>"> 
                                Quotations (<?php echo $this->quotationNo; ?>)
                            </a>
                        </li>
                        <!--<li class="pull-right">
                            <a href="javascript:void(0);" id="<?php echo $listlead["approval"]["counter"] . $newRes[$i]["leads"]["id"]; ?>">
                                Approvals (<?php echo $newRes[$i]["leads"]["lk_p_ct"]; ?>)
                            </a>
                        </li>!-->
                        <!--<li class="pull-right">
                            <a href="javascript:void(0);">
                                Shares (0)
                            </a>
                        </li>!-->
                    </ul>
                </div>
                <div class="col-lg-12 pull-right" 
                     id="<?php echo $listlead["quotation"]["list"]["parentDiv"] . $newRes[$i]["leads"]["id"]; ?>" 
                     style="display:none;">
                    <span id="<?php echo $listlead["quotation"]["list"]["outputDiv"] . $newRes[$i]["leads"]["id"]; ?>">       
                        <?php
                        //require 'listQuotation.php';
                        ?>
                    </span>
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
<?php elseif (!isset($_SESSION["ListNewLead"])) :
    ?>
    <div class="col-lg-12">
        <h3>No leads to view folks!!! <span class="<?php echo $listlead["smiley"]; ?>">:-O</span></h3>
    </div>
    <?php
endif;
?>
