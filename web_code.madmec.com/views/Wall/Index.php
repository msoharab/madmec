<div class="container">
    <div class="row">
        <aside class="col-xs-12 col-md-3 border-right-lightgrey takemetop">
            <div class="channel-heading align-center">
                <strong>
                    <?php echo ucfirst($_SESSION["USERDATA"]["logindata"]["user_name"]); ?>
                </strong>
            </div>
            <?php
            require_once 'profilePicture.php';
            ?>
            <div class="channel-heading align-center">My Channels</div>
            <?php
            require_once 'listChannels.php';
            ?>
            <div class="clearfix"></div>
            <div class="channel-heading align-center">Admin Channels</div>
            <?php
            require_once 'listAdminChannels.php';
            ?>
        </aside>
        <div class="col-xs-12 col-sm-12 col-md-7" id="show-post" style="display:none;"></div>
        <div class="col-xs-12 col-sm-12 col-md-7" id="<?php echo $this->idHolders["wall"]["post"]["list"]["parentDiv"]; ?>" style="border-right:solid 1px #E4D0D0;">
            <h3>Wall</h3>
            <div class="row" id="<?php echo $this->idHolders["wall"]["post"]["list"]["outputDiv"] ?>">           
                <?php
                    require_once 'listPost.php';
                ?>
            </div>
        </div>
        <aside class="col-xs-12 col-md-2 border-left-lightgrey takemetop">
            <div class="list-group">
                <button type="button" id="<?php echo $this->idHolders["wall"]["post"]["moodalBut"]; ?>" name="<?php echo $this->idHolders["wall"]["post"]["moodalBut"]; ?>" data-toggle="modal" data-target="#<?php echo $this->idHolders["wall"]["post"]["create"]["parentDiv"]; ?>" data-whatever="@mdo" class="list-group-item btn btn-block btn-success">Individual Post</button>
            </div>
            <div class="channel-heading align-center">Subscription</div>
            <?php
            require_once 'listSubscription.php';
            ?>
        </aside>
    </div>
</div>
<!-- Start modals -->
<?php
require_once 'createChannel.php';
require_once 'report.php';
require_once 'individualPost.php';

/* Load Channel Controller */
echo '<script src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Channel.js" type="text/javascript"></script>';
/* Load Geography Controller */
echo '<script src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Geography.js" type="text/javascript"></script>';
/* Load Languages Controller */
echo '<script src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Languages.js" type="text/javascript"></script>';
/* Load Report Controller */
echo '<script src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Report.js" type="text/javascript"></script>';
/* Load Sections Controller */
echo '<script src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Sections.js" type="text/javascript"></script>';
/* Load Subscribe Controller */
echo '<script src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Subscribe.js" type="text/javascript"></script>';
/* Load Popular Controller */
echo '<script src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Popular.js" type="text/javascript"></script>';
/* Load Post Controller */
echo '<script src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Post.js" type="text/javascript"></script>';
/* Load NewPost Controller */
echo '<script src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'NewPost.js" type="text/javascript"></script>';
?>
<!-- End modals -->

