<?php
$CompAddrEd = isset($this->idHolders["recharge"]["masterdata"]["EditBusinessAdd"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditBusinessAdd"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Business Address
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Edit Business Address</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $CompAddrEd["form"]; ?>"
                      name="<?php echo $CompAddrEd["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputaddline" class="col-sm-2 control-label">Address Line</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control"
                                                                  id="<?php echo $CompAddrEd["fields"][0]; ?>"
                                                                  name="<?php echo $CompAddrEd["fields"][0]; ?>"
                                                                  data-rules='{"required": true}'
                                                                  data-messages='{"required": "Enter valid address line"}'
                                                                  placeholder="Address Line"><?php echo trim($this->getuserDet["data"]["company_address_addressline"]); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputcountry" class="col-sm-1 control-label">Country</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompAddrEd["fields"][1]; ?>"
                                                               name="<?php echo $CompAddrEd["fields"][1]; ?>"
                                                               value="<?php echo trim($this->getuserDet["data"]["company_address_country"]); ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter Country Name"}'
                                                               placeholder="Country" type="text">
                                                    </div>
                                                    <label for="inputstate" class="col-sm-1 control-label">State</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompAddrEd["fields"][2]; ?>"
                                                               name="<?php echo $CompAddrEd["fields"][2]; ?>"
                                                               value="<?php echo trim($this->getuserDet["data"]["company_address_province"]); ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter State"}'
                                                               placeholder="State" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputdistrict" class="col-sm-1 control-label">District</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompAddrEd["fields"][3]; ?>"
                                                               name="<?php echo $CompAddrEd["fields"][3]; ?>"
                                                               value="<?php echo trim($this->getuserDet["data"]["company_address_district"]); ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter District"}'
                                                               placeholder="District" type="text">
                                                    </div>
                                                    <label for="inputcity" class="col-sm-1 control-label">City/Town</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompAddrEd["fields"][4]; ?>"
                                                               name="<?php echo $CompAddrEd["fields"][4]; ?>"
                                                               value="<?php echo trim($this->getuserDet["data"]["company_address_city"]); ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter City or Town"}'
                                                               placeholder="City/Town" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputstreet" class="col-sm-1 control-label">Street/Locality</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompAddrEd["fields"][5]; ?>"
                                                               name="<?php echo $CompAddrEd["fields"][5]; ?>"
                                                               value="<?php echo trim($this->getuserDet["data"]["company_address_addressline"]); ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter Street or Locality"}'
                                                               placeholder="Street/Locality" type="text">
                                                    </div>
                                                    <label for="inputzipcode" class="col-sm-1 control-label">Zipcode</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompAddrEd["fields"][6]; ?>"
                                                               name="<?php echo $CompAddrEd["fields"][6]; ?>"
                                                               value="<?php echo trim($this->getuserDet["data"]["company_address_zipcode"]); ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Zipcode","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Zipcode" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                        </section>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-10">
                                <button type="submit"
                                        class="btn btn-danger"
                                        id="<?php echo $CompAddrEd["fields"][7]; ?>"
                                        name="<?php echo $CompAddrEd["fields"][7]; ?>"
                                        data-rules='{}'
                                        data-messages='{}'>Update Details</button>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                </form>
            </div>
            <!-- /. box -->
        </div>
    </section>
</div>