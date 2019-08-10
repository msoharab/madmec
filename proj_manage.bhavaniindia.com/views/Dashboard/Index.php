<?php
$Prod = isset($this->idHolders["ricepark"]["dashboard"]["AddProduct"]) ? (array) $this->idHolders["ricepark"]["dashboard"]["AddProduct"] : false;
?>
<div class="clear"></div>
<!-- start content-outer -->
<div id="content-outer">
    <!-- start content -->
    <div id="content">
        <div id="page-heading"><h1>Add product</h1></div>
        <table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
            <tr>
                <th rowspan="3" class="sized"><img src="<?php echo URL . ASSET_IMG; ?>shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
                <th class="topleft"></th>
                <td id="tbl-border-top">&nbsp;</td>
                <th class="topright"></th>
                <th rowspan="3" class="sized"><img src="<?php echo URL . ASSET_IMG; ?>shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
            </tr>
            <tr>
                <td id="tbl-border-left"></td>
                <td>
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
                                            <div class="step-dark-left"><a href="">Add product details</a></div>
                                            <div class="step-dark-right">&nbsp;</div>
                                            <div class="step-no-off"></div>
                                        </div>
                                        <!--  end step-holder -->
                                        <!-- start id-form -->
                                        <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                                            <tr>
                                                <th valign="top">Product name:</th>
                                                <td>
                                                    <select type="hidden" class="form-control"
                                                            id="<?php echo $Prod["fields"][0]; ?>"
                                                            name="<?php echo $Prod["fields"][0]; ?>"
                                                            data-rules='{"required": true}'
                                                            data-messages='{"required": "Select Product"}'></select>
                                                    <select  class="styledselect_form_1">
                                                        <option value="">Sona Masoori</option>
                                                        <option value="">Non Basmati</option>
                                                        <option value="">Lachkari</option>
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
                                                <td><input type="text"
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
                                                    <input type="text"
                                                           class="inp-form"
                                                           id="<?php echo $Prod["fields"][4]; ?>"
                                                           name="<?php echo $Prod["fields"][4]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Select a quantity"}'
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
                                                <th>Image:</th>
                                                <td><input id="<?php echo $Prod["fields"][6]; ?>"
                                                           name="<?php echo $Prod["fields"][6]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Upload valid document"}'
                                                           type="file" class="file_1" /></td>
                                                <td>
                                                    <div class="bubble-left"></div>
                                                    <div class="bubble-inner">JPEG, GIF 5MB max per image</div>
                                                    <div class="bubble-right"></div>
                                                </td>
                                            </tr>
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
<!--                                <tr>
                                    <td><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"]; ?>images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
                                    <td></td>
                                </tr>-->
                            </table>
                        </form>
                        <div class="clear"></div>
                    </div>
                    <!--  end content-table-inner  -->
                    <!--<div><img src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"]; ?>shared/side_shadowright.jpg"> </div>-->
                </td>
                <td id="tbl-border-right"></td>
            </tr>
            <tr>
                <th class="sized bottomleft"></th>
                <td id="tbl-border-bottom">&nbsp;</td>
                <th class="sized bottomright"></th>
            </tr>
        </table>
        <div class="clear">&nbsp;</div>
    </div>
    <!--  end content -->
    <div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>
 <script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_REG"] . $this->config["CONTROLLERS"]; ?>Dashboard.js"></script>
