<?php
$channelId = isset($this->ChannelId) ? (integer) $this->ChannelId : 0;
$ChannelSize = isset($this->ChannelSize) ? $this->ChannelSize : 0;
$chDiv = $this->idHolders["pic3pic"]["channel"];
if ($this->ChannelId !== 0):
    ?>
    <div class="container-fluid">
        <?php require_once ('channelHeader.php'); ?>
    </div>
    <!--<div class="col-md-5 pull-right text-right">
    <?php require_once ('channelActions.php'); ?>
    </div>-->
    <div class="clearfix-break">&nbsp;</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 col-md-offset-3 col-xs-offset-0"
                 style="border-right:solid 1px #E4D0D0; border-top:solid 1px #E4D0D0;">
                     <?php require_once ('channelForm.php'); ?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 colxs-2"
                 style="border-right:solid 1px #E4D0D0; border-top:solid 1px #E4D0D0;">
                <?php require_once ('channelAdvertisements.php'); ?>
            </div>
        </div>
    </div>
    <!-- End Of Body Container-->
    <?php
    require_once ('individualPost.php');
    require_once ('channelBlock.php');
    require_once ('channelSubscribe.php');
    require_once ('channelReport.php');
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
    /* Load Post Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'Post.js" ></script>';
    /* Load NewPost Controller */
    echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
    $this->config["VIEWS"] .
    $this->config["ASSSET_PIC"] .
    $this->config["CONTROLLERS"] .
    'NewPost.js" ></script>';
else:
    ?>
    <script type="text/javascript"> window.location.href = URL;</script>
<?php
endif;
?>

