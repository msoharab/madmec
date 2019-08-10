<?php
$chDes = !empty($this->BusinessDetails["business"]["business_description"]) ? $this->BusinessDetails["business"]["business_description"] : 'Add description to business.';
$chCapitan = $this->BusinessDetails["business"]["chownname"];
$chWeb = !empty($this->BusinessDetails["business"]["business_website"]) ?
        'href="' . $this->BusinessDetails["business"]["business_website"] . '" target="_blank"' :
        'href="javascript:void(0);"';
$chFB = !empty($this->BusinessDetails["business"]["business_facebook"]) ?
        'href="' . $this->BusinessDetails["business"]["business_facebook"] . '"  target="_blank"' :
        'href="javascript:void(0);"';
$chGP = !empty($this->BusinessDetails["business"]["business_googleplus"]) ?
        'href="' . $this->BusinessDetails["business"]["business_googleplus"] . '" target="_blank"' :
        'href="javascript:void(0);"';
$chTT = !empty($this->BusinessDetails["business"]["business_twitter"]) ?
        'href="' . $this->BusinessDetails["business"]["business_twitter"] . '" target="_blank"' :
        'href="javascript:void(0);"';
$message = $chAbout["msgAJAX"];
?>
<div class="panel">
    <div class="panel-heading">
        <h3 id="<?php echo $chAbout["name"]; ?>">About, <?php echo $businessName; ?></h3>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-striped" id="<?php echo $chAbout["outputDiv"]; ?>">
            <tbody>
                <tr id="<?php echo $chAbout["description"]; ?>">
                    <td class="text-right col-md-2 about-heading">Description :</td>
                    <td class="about-body col-md-4 text-justify"><strong><?php echo $chDes; ?></strong><div class="clearfix"></div><hr /></td>
                </tr>
                <tr id="<?php echo $chAbout["admins"]; ?>">
                    <td class="text-right col-md-2 about-heading">Admin's :</td>
                    <td class="about-body col-md-4">
                        <?php
                        if (count($this->BusinessDetails["chadm"]["chadmid"]) > 0) {
                            for ($i = 0; $i < count($this->BusinessDetails["chadm"]["chadmid"]); $i++) {
                                if (isset($this->BusinessDetails["chadm"]["chadmid"][$i]) &&
                                        $this->BusinessDetails["chadm"]["chadmid"][$i] != "") {
                                    ?>
                                    <div class="">
                                        <span class="pull-left">
                                            <label class="admin-label"><?php echo ucfirst($this->BusinessDetails["chadm"]["adminname"][$i]); ?></label>
                                        </span>
                                        <span class="pull-right" name="<?php echo $this->BusinessId; ?>">
                                            <a href="javascript:void(0);"
                                               class="input-group-addon btn btn-sm btn-danger <?php echo $chAbout["removeAdm"]; ?>"
                                               data-uid="<?php echo $this->BusinessDetails["chadm"]["chadmuid"][$i]; ?>"
                                               name="<?php echo $this->BusinessDetails["chadm"]["adminname"][$i]; ?>">
                                                <i class="fa fa-close"></i>Remove
                                            </a>
                                        </span>
                                    </div>
                                    <div class="clearfix"></div><hr />
                                    <?php
                                } else {
                                    ?>
                                    <div class="">
                                        <span class="pull-left">
                                            <strong>Heir Admin's to your business.</strong>
                                        </span>
                                    </div>
                                    <div class="clearfix"></div><hr />
                                    <?php
                                    break;
                                }
                            }
                        } else {
                            ?>
                            <div class="">
                                <span class="pull-left">
                                    <strong>Add Admins to your business.</strong>
                                </span>
                            </div>
                            <div class="clearfix"></div><hr />
                        <?php } ?>
                    </td>
                </tr>
                <tr id="<?php echo $chAbout["msgAJAX"]; ?>">
                    <td class="text-right col-md-2 about-heading">Captain :</td>
                    <td class="about-body col-md-4"><?php echo $chCapitan; ?><div class="clearfix"></div><hr /></td>
                </tr>
                <tr>
                    <td class="text-right col-md-2 about-heading">Social Info :</td>
                    <td class="about-body col-md-4">
                        <a <?php echo $chFB; ?>  class="" id="<?php echo $chAbout["facebook"]; ?>"><i class="fa fa-facebook-square fa-2x fa-color"></i></a>
                        <a <?php echo $chGP; ?>  class="" id="<?php echo $chAbout["googleplus"]; ?>"><i class="fa fa-google-plus-square fa-2x fa-color"></i></a>
                        <a <?php echo $chTT; ?>  class="" id="<?php echo $chAbout["twitter"]; ?>"><i class="fa fa-twitter-square fa-2x fa-color"></i></a>
                        <div class="clearfix"></div><hr />
                    </td>
                </tr>
                <tr id="<?php echo $chAbout["website"]; ?>">
                    <td class="text-right col-md-2 about-heading">Website :</td>
                    <td class="about-body col-md-4"><a <?php echo $chWeb; ?> class=""><?php echo $businessName; ?></a><div class="clearfix"></div><hr /></td>
                </tr>
                <tr id="<?php echo $message; ?>">
                    <td class="text-right col-md-2 about-heading">Say "Hi" to Admin :</td>
                    <td class="about-body col-md-4">
                        <input type="text"
                               id="<?php echo $message["msg"]; ?>"
                               name="<?php echo $message["msg"]; ?>"
                               class="admin-msg" placeholder="Maximum 250 words...." maxlength="250"/>
                        <button type="submit"
                                id="<?php echo $message["submit"]; ?>"
                                name="<?php echo $message["submit"]; ?>"
                                class="btn btn-primary btn-small">
                            <i class="fa fa-envelope"></i> Send Message
                        </button>
                        <div class="clearfix"></div><hr />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
