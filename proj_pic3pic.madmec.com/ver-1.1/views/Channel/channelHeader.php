<?php
$chbackground = $this->idHolders["pic3pic"]["channel"]["backgroud"];
$chicon = $this->idHolders["pic3pic"]["channel"]["icon"];
$chbg = $this->idHolders["pic3pic"]["channel"]["backgroud"];
$channelSubscribers = (integer) $this->ChannelDetails["channel"]["chsub_ct"];
$channelLikes = (integer) $this->ChannelDetails["channel"]["lk_ch_ct"];
$channelName = $this->ChannelDetails["channel"]["channel_name"];
$channelBack = $this->ChannelDetails["channel"]["channel_background"];
$channelIcon = $this->ChannelDetails["channel"]["channel_icon"];
//$this->ChannelId
//$this->ChannelDetails
?>
<strong>
    <?php echo $channelName; ?>,&nbsp;
    <a class="">
        <!--<i class="fa fa-thumbs-o-up thumbs-up fa-lg"></i>-->
        <span id="<?php echo $chDiv["like"]["counter"]; ?>"><?php echo $channelLikes; ?></span> Likes
    </a>
    <a class="">
        <!--<i class="fa fa-eye fa-lg"> </i>-->
        <span id="<?php echo $chDiv["subscribe"]["counter"]; ?>"><?php echo $channelSubscribers; ?></span> Subscribers
    </a>
</strong><h6>&nbsp;</h6>
<div class="channel-cover">
    <img src="<?php echo $channelBack; ?>" class="img-responsive">
    <div class="col-lg-4 pull-right">
        <?php require_once ('channelActions.php'); ?>
    </div>
</div>
<div class="col-md-2 col-sm-7 col-xs-7">
    <img src="<?php echo $channelIcon; ?>" class="img-responsive img-thumbnail channel-profile img-circle">
</div>

<!--<div class="col-md-1">
    <a class="" href="javascript:void();" onclick="$('#share-list-channel').slideToggle('slow');">
        <i class="fa fa-share-alt"></i> Share
    </a>
</div>
<div id="share-list-channel" style="display:none;">
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-facebook-square"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-twitter-square"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-instagram"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-dribbble"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-flickr"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-pinterest-square"></i></a></div>
    <div class="col-md-1 min-wid"><a class="" href="#"><i class="fa fa-google-plus-square"></i></a></div>
</div>-->
