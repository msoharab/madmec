<?php
$chbackground = $this->idHolders["nookleads"]["business"]["backgroud"];
$chicon = $this->idHolders["nookleads"]["business"]["icon"];
$chbg = $this->idHolders["nookleads"]["business"]["backgroud"];
$businessSubscribers = (integer) $this->BusinessDetails["business"]["chsub_ct"];
$businessApprovals = (integer) $this->BusinessDetails["business"]["lk_ch_ct"];
$businessName = $this->BusinessDetails["business"]["business_name"];
$businessBack = $this->BusinessDetails["business"]["business_background"];
$businessIcon = $this->BusinessDetails["business"]["business_icon"];
//$this->BusinessId
//$this->BusinessDetails
?>
<strong>
    <?php echo $businessName; ?>,&nbsp;
    <a class="">
        <!--<i class="fa fa-thumbs-o-up thumbs-up fa-lg"></i>-->
        <span id="<?php echo $chDiv["approval"]["counter"]; ?>"><?php echo $businessApprovals; ?></span> Approvals
    </a>
    <a class="">
        <!--<i class="fa fa-eye fa-lg"> </i>-->
        <span id="<?php echo $chDiv["subscribe"]["counter"]; ?>"><?php echo $businessSubscribers; ?></span> Subscribers
    </a>
</strong><h6>&nbsp;</h6>
<div class="business-cover">
    <img src="<?php echo $businessBack; ?>" class="img-responsive">
    <div class="col-lg-4 pull-right">
        <?php require_once ('businessActions.php'); ?>
    </div>
</div>
<div class="col-md-2 col-sm-7 col-xs-7">
    <img src="<?php echo $businessIcon; ?>" class="img-responsive img-thumbnail business-profile img-circle">
</div>
<!--<div class="col-md-1">
    <a class="" href="javascript:void();" onclick="$('#share-list-business').slideToggle('slow');">
        <i class="fa fa-share-alt"></i> Share
    </a>
</div>
<div id="share-list-business" style="display:none;">
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-facebook-square"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-twitter-square"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-instagram"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-dribbble"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-flickr"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-pinterest-square"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-google-plus-square"></i></a></div>
</div>-->
