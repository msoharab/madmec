<?php
$chHome = $this->idHolders["nookleads"]["business"]["home"];
$chAbout = $this->idHolders["nookleads"]["business"]["about"];
$chSetting = $this->idHolders["nookleads"]["business"]["setting"];
$chMessage = $this->idHolders["nookleads"]["business"]["message"];
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
        <?php if ($this->UserId == $this->BusinessDetails["business"]["chuid"]): ?>
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
    <div class="tab-content clearfix col-lg-12" style="min-height: 300px;" id="businessForm">
        <!-- tab1 HOME Start-->
        <div class="tab-pane active col-lg-12" id="<?php echo $chHome["thisDiv"]; ?>">
            <?php
            require_once ('businessHome.php');
            ?>
        </div>
        <div class="tab-pane col-lg-12" id="<?php echo $chAbout["thisDiv"]; ?>"><br />
            <?php
            require_once ('businessAbout.php');
            ?>
        </div>
        <!-- Home Tab1 ENDS -->
        <?php if ($this->UserId == $this->BusinessDetails["business"]["chuid"]): ?>
            <!-- About Tab2 ENDS -->
            <!-- SETTING Tab3 Start -->
            <div class="tab-pane col-lg-12" id="<?php echo $chSetting["thisDiv"]; ?>"><br />
                <?php
                require_once ('businessSetting.php');
                require_once ('businessBackground.php');
                require_once ('businessIcon.php');
                ?>
            </div>
            <!-- SETTING Tab3 END -->
            <!-- MESSAGE Tab4 Start -->
            <div class="tab-pane col-lg-12" id="<?php echo $chMessage["thisDiv"]; ?>"><br />
                <?php
                require_once ('businessMessage.php');
                ?>
            </div>
        <?php endif; ?>
        <!-- MESSAGE Tab4 END -->
    </div>
</div>
