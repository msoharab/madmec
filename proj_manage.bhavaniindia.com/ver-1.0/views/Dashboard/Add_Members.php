<?php
$Mem = isset($this->idHolders["ricepark"]["dashboard"]["AddMembers"]) ? (array) $this->idHolders["ricepark"]["dashboard"]["AddMembers"] : false;
?>
<!-- start content-outer -->
<div id="content-outer">
    <!-- start content -->
    <div id="content">


        <!--<div id="page-heading"><h1>Add product</h1></div>-->


        <table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<!--            <tr>
                <th rowspan="3" class="sized"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"]; ?>shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
                <th class="topleft"></th>
                <td id="tbl-border-top">&nbsp;</td>
                <th class="topright"></th>
                <th rowspan="3" class="sized"><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"]; ?>shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
            </tr>-->
            <tr>
                <!--<td id="tbl-border-left"></td>-->
                <td class="col-md-6">
                    <!--  start content-table-inner -->
                    <div id="content-table-inner">
                        <form class="form-horizontal"
                              action=""
                              id="<?php echo $Mem["form"]; ?>"
                              name="<?php echo $Mem["form"]; ?>"
                              method="post">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td>                                            <!--  start step-holder -->
                                        <div id="step-holder">
                                            <div class="step-no"></div>
                                            <div class="step-dark-left"><a href="">Add Members Details</a></div>
                                            <div class="step-dark-right">&nbsp;</div>
                                            <div class="step-no-off"></div>
                                        </div>
                                        <!--  end step-holder -->

                                        <!-- start id-form -->
                                        <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                                            <tr>
                                                <th valign="top">Member Name:</th>
                                                <td><input type="text"
                                                           class="inp-form"
                                                           id="<?php echo $Mem["fields"][0]; ?>"
                                                           name="<?php echo $Mem["fields"][0]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter the Name"}'
                                                           placeholder="Name" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Designation</th>
                                                <td><input type="text"
                                                           class="inp-form"
                                                           id="<?php echo $Mem["fields"][1]; ?>"
                                                           name="<?php echo $Mem["fields"][1]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter the Designation"}'
                                                           placeholder="Designation" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Email</th>
                                                <td><input type="email"
                                                           class="inp-form"
                                                           id="<?php echo $Mem["fields"][2]; ?>"
                                                           name="<?php echo $Mem["fields"][2]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter the Email"}'
                                                           placeholder="Email" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Mobile1</th>
                                                <td><input type="number"
                                                           class="inp-form"
                                                           id="<?php echo $Mem["fields"][3]; ?>"
                                                           name="<?php echo $Mem["fields"][3]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter the Mobile no"}'
                                                           placeholder="Mobile No" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Mobile2</th>
                                                <td><input type="number"
                                                           class="inp-form"
                                                           id="<?php echo $Mem["fields"][4]; ?>"
                                                           name="<?php echo $Mem["fields"][4]; ?>"
                                                           data-rules='{}'
                                                           data-messages='{}'
                                                           placeholder="Mobile No " /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Facebook</th>
                                                <td class="noheight">
                                                    <input type="url"
                                                           class="inp-form"
                                                           id="<?php echo $Mem["fields"][5]; ?>"
                                                           name="<?php echo $Mem["fields"][5]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter a Facebook Link"}'
                                                           placeholder="Facebook Link" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Twitter</th>
                                                <td class="noheight">
                                                    <input type="url"
                                                           class="inp-form"
                                                           id="<?php echo $Mem["fields"][6]; ?>"
                                                           name="<?php echo $Mem["fields"][6]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter a Twitter Link"}'
                                                           placeholder="Twitter Link" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Google+</th>
                                                <td class="noheight">
                                                    <input type="url"
                                                           class="inp-form"
                                                           id="<?php echo $Mem["fields"][7]; ?>"
                                                           name="<?php echo $Mem["fields"][7]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter a Google+ Link"}'
                                                           placeholder="Google+ Link" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Address:</th>
                                                <td><textarea rows="" cols="" class="form-textarea"
                                                              id="<?php echo $Mem["fields"][8]; ?>"
                                                              name="<?php echo $Mem["fields"][8]; ?>"
                                                              data-rules='{"required": true}'
                                                              data-messages='{"required": "Enter Description"}'
                                                              placeholder="Address"></textarea></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Upload Image:</th>
                                                <td><input id="<?php echo $Mem["fields"][9]; ?>"
                                                           name="<?php echo $Mem["fields"][9]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Upload valid document"}'
                                                           type="file"/></td>
                                                <td>
                                                    <div class="bubble-left"></div>
                                                    <div class="bubble-inner">JPEG, GIF 5MB max per image</div>
                                                    <div class="bubble-right"></div>
                                                </td>
                                            </tr>
                                            <tr><th>&nbsp;</th></tr>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <td valign="top"><input  type="submit"
                                                                         id="<?php echo $Mem["fields"][10]; ?>"
                                                                         name="<?php echo $Mem["fields"][10]; ?>"
                                                                         data-rules='{}'
                                                                         data-messages='{}' class="form-submit" />
                                                </td>
                                                <td></td>
                                            </tr>
                                        </table>
                                        <!-- end id-form  -->
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <div class="clear"></div>
                    </div>
                </td>
                <td  class="col-md-6">
                    <div>
                        <img src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"]; ?>q22.jpg" alt="" />
                    </div>
                </td>
                <!--<td id="tbl-border-right"></td>-->
            </tr>
            <tr>
<!--                <th class="sized bottomleft"></th>
                <td id="tbl-border-bottom">&nbsp;</td>
                <th class="sized bottomright"></th>-->
            </tr>
        </table>
        <div class="clear">&nbsp;</div>

    </div>
    <!--  end content -->
    <div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>
<script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_PLG"] . $this->config["PLG_23"]; ?>js/picedit.edit.js"></script>
<link href="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_PLG"] . $this->config["PLG_23"]; ?>css/picedit.min.css" rel="stylesheet" type="text/css" />
<script>$(document).ready(function () {
    var this_js_script = $("script[src$='Dashboard.js']");
    if (this_js_script) {
        var flag = this_js_script.attr('data-autoloader');
        if (flag === 'true') {
            LogMessages('I am In Dashboard');
            var para = getJSONIds({
                autoloader: true,
                action: 'getIdHolders',
                url: URL + 'Dashboard/getIdHolders',
                type: 'POST',
                dataType: 'JSON'
            }).ricepark.dashboard;
            var obj = new dashboardController();
            obj.__constructor(para);
            obj.__AddMembers(para);
        }
        else {
            LogMessages('I am Out Dashboard');
        }
    }
});
</script>
