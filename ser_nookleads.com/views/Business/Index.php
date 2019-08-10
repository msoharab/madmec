<?php
$businessId = isset($this->BusinessId) ? (integer) $this->BusinessId : 0;
$BusinessSize = isset($this->BusinessSize) ? $this->BusinessSize : 0;
$chDiv = $this->idHolders["nookleads"]["business"];
if ($this->BusinessId !== 0):
    ?>
    <div class="container-fluid">
        <?php require_once ('businessHeader.php'); ?>
    </div>
    <!--<div class="col-md-5 pull-right text-right">
    <?php require_once ('businessActions.php'); ?>
    </div>-->
    <div class="clearfix-break">&nbsp;</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 col-md-offset-3 col-xs-offset-0"
                 style="border-right:solid 1px #E4D0D0; border-top:solid 1px #E4D0D0;">
                     <?php require_once ('businessForm.php'); ?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 colxs-2"
                 style="border-right:solid 1px #E4D0D0; border-top:solid 1px #E4D0D0;">
                <?php require_once ('businessAdvertisements.php'); ?>
            </div>
        </div>
    </div>
    <!-- End Of Body Container-->
    <?php
    require_once ('individualLead.php');
    require_once ('businessBlock.php');
    require_once ('businessSubscribe.php');
    require_once ('businessReport.php');
    /* Load Geography Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'Geography.js" ></script>';
    /* Load Languages Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'Languages.js" ></script>';
    /* Load Report Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'Report.js" ></script>';
    /* Load Sections Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'Sections.js" ></script>';
    /* Load Subscribe Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'Subscribe.js" ></script>';
    /* Load Popular Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'Popular.js" ></script>';
    /* Load Lead Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'Lead.js" ></script>';
    /* Load NewLead Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'NewLead.js" ></script>';
else:
    ?>
    <script type="text/javascript"> window.location.href = URL;</script>
<?php
endif;
?>
