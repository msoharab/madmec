<?php
$chHome = $this->idHolders["pic3pic"]["channel"]["home"];
$chAbout = $this->idHolders["pic3pic"]["channel"]["about"];
$chSetting = $this->idHolders["pic3pic"]["channel"]["setting"];
$chMessage = $this->idHolders["pic3pic"]["channel"]["message"];
?>
<div id="exTab1" class="panel"> 
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#<?php echo $chHome["thisDiv"]; ?>" 
               data-toggle="tab" 
               id="<?php echo $chHome["targetDiv"]; ?>">Home</a>
        </li>
        <li>
            <a href="#<?php echo $chAbout["thisDiv"]; ?>" 
               data-toggle="tab" 
               id="<?php echo $chAbout["targetDiv"]; ?>">About</a>
        </li>
        <?php if ($this->UserId == $this->ChannelDetails["channel"]["chuid"]): ?>
            <li>
                <a href="#<?php echo $chSetting["thisDiv"]; ?>" 
                   data-toggle="tab" 
                   id="<?php echo $chSetting["targetDiv"]; ?>">Setting</a>
            </li>
            <li>
                <a href="#<?php echo $chMessage["thisDiv"]; ?>" 
                   data-toggle="tab" 
                   id="<?php echo $chMessage["targetDiv"]; ?>">Message</a>
            </li>
        <?php endif; ?>
    </ul>
    <div class="tab-content clearfix" style="min-height: 300px;" id="channelForm">
        <!-- tab1 HOME Start-->
        <div class="tab-pane active" id="<?php echo $chHome["thisDiv"]; ?>">
            <?php
            require_once ('channelHome.php');
            ?>
        </div>
        <div class="tab-pane" id="<?php echo $chAbout["thisDiv"]; ?>"><br />
            <?php
            require_once ('channelAbout.php');
            ?>
        </div>
        <!-- Home Tab1 ENDS -->
        <?php if ($this->UserId == $this->ChannelDetails["channel"]["chuid"]): ?>
            <!-- About Tab2 ENDS -->
            <!-- SETTING Tab3 Start -->
            <div class="tab-pane" id="<?php echo $chSetting["thisDiv"]; ?>"><br />
                <?php
                require_once ('channelSetting.php');
                require_once ('channelBackground.php');
                require_once ('channelIcon.php');
                ?>
            </div>
            <!-- SETTING Tab3 END -->
            <!-- MESSAGE Tab4 Start -->
            <div class="tab-pane" id="<?php echo $chMessage["thisDiv"]; ?>"><br />
                <?php
                //require_once ('channelMessage.php');
                ?>
            </div>
        <?php endif; ?>
        <!-- MESSAGE Tab4 END -->
    </div>
</div>
