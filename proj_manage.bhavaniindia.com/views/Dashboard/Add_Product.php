<?php
$Prod = isset($this->idHolders["ricepark"]["dashboard"]["AddProduct"]) ? (array) $this->idHolders["ricepark"]["dashboard"]["AddProduct"] : false;
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
                              id="<?php echo $Prod["form"]; ?>"
                              name="<?php echo $Prod["form"]; ?>"
                              method="post">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td>                                            <!--  start step-holder -->
                                        <div id="step-holder">
                                            <div class="step-no"></div>
                                            <div class="step-dark-left"><a href="">Add Product Details</a></div>
                                            <div class="step-dark-right">&nbsp;</div>
                                            <div class="step-no-off"></div>
                                        </div>
                                        <!--  end step-holder -->
                                        <!-- start id-form -->
                                        <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                                            <tr>
                                                <th valign="top">Product name:</th>
                                                <td>
                                                    <select class="styledselect_form_1"
                                                            id="<?php echo $Prod["fields"][0]; ?>"
                                                            name="<?php echo $Prod["fields"][0]; ?>"
                                                            data-rules='{}'
                                                            data-messages='{}' placeholder="Select" >
                                                        <option>Select</option>
                                                        <option>Sona Masoori</option>
                                                        <option>Non Basmati</option>
                                                        <option>Lachkari</option>
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Brand:</th>
                                                <td><input type="text"
                                                           class="inp-form"
                                                           id="<?php echo $Prod["fields"][1]; ?>"
                                                           name="<?php echo $Prod["fields"][1]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter the Brand"}'
                                                           placeholder="Brand" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Category:</th>
                                                <td><input type="text"
                                                           class="inp-form"
                                                           id="<?php echo $Prod["fields"][2]; ?>"
                                                           name="<?php echo $Prod["fields"][2]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter the Category"}'
                                                           placeholder="Category" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Price:</th>
                                                <td><input type="number"
                                                           class="inp-form"
                                                           id="<?php echo $Prod["fields"][3]; ?>"
                                                           name="<?php echo $Prod["fields"][3]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter the Price"}'
                                                           placeholder="Price" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Quantity:</th>
                                                <td class="noheight">
                                                    <input type="number"
                                                           class="inp-form"
                                                           id="<?php echo $Prod["fields"][4]; ?>"
                                                           name="<?php echo $Prod["fields"][4]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter a quantity"}'
                                                           placeholder="Quantity" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th valign="top">Description:</th>
                                                <td><textarea rows="" cols="" class="form-textarea"
                                                              id="<?php echo $Prod["fields"][5]; ?>"
                                                              name="<?php echo $Prod["fields"][5]; ?>"
                                                              data-rules='{"required": true}'
                                                              data-messages='{"required": "Enter Description"}'
                                                              placeholder="Description"></textarea></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Upload Image:</th>
                                                <td><input id="<?php echo $Prod["fields"][6]; ?>"
                                                           name="<?php echo $Prod["fields"][6]; ?>"
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
                                                                         id="<?php echo $Prod["fields"][7]; ?>"
                                                                         name="<?php echo $Prod["fields"][7]; ?>"
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
            obj.__AddProduct(para);
        }
        else {
            LogMessages('I am Out Dashboard');
        }
    }
});
</script>
