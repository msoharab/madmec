<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 col-xs-offset-0 col-md-offset-1">
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
            <div class="col-xs-12 col-sm-12 col-md-5" 
                 id="<?php echo $this->idHolders["pic3pic"]["post"]["list"]["parentDiv"]; ?>" 
                 style="border-right:solid 1px #E4D0D0;">
                <div class="channel-heading"><strong>Wall</strong></div>
                <div class="row" id="<?php echo $this->idHolders["pic3pic"]["post"]["list"]["outputDiv"] ?>">           
                    <?php
                    require_once 'listPost.php';
                    ?>
                </div>
            </div>
            <aside class="col-xs-12 col-md-3 border-left-lightgrey takemetop">
                <div class="list-group">
                    <button type="button" 
                            id="<?php echo $this->idHolders["pic3pic"]["post"]["create"]["parentBut"]; ?>" 
                            name="<?php echo $this->idHolders["pic3pic"]["post"]["create"]["parentBut"]; ?>" 
                            data-toggle="modal" 
                            data-target="#<?php echo $this->idHolders["pic3pic"]["post"]["create"]["parentDiv"]; ?>" 
                            data-whatever="@mdo" 
                            class="list-group-item btn btn-block btn-success">
                        Individual Post
                    </button>
                </div>
                <div class="channel-heading align-center">Subscription</div>
                <?php
                require_once 'listSubscription.php';
                ?>
            </aside>
        </div>
    </div>
</div>
<!-- Start modals -->
<?php
require_once 'createChannel.php';
require_once 'report.php';
require_once 'individualPost.php';

/* Load Channel Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'Channel.js" ></script>';
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
/* Load Profile Pic Controller */
echo '<script data-autoloader="false" type="text/javascript" src="' . $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"] .
 'ProfilePic.js" ></script>';
?>