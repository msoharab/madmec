<?php
$CompInfo = isset($this->idHolders["recharge"]["masterdata"]["EditBusinessInfo"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditBusinessInfo"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Business Info
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">   Edit Business Info</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit</h3>
                    </div><!-- /.box-header -->
                    <form class="form-horizontal"
                          action=""
                          id="<?php echo $CompInfo["form"]; ?>"
                          name="<?php echo $CompInfo["form"]; ?>"
                          method="post">
                        <div class="content">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <input type="hidden"
                                                       name="<?php echo $CompInfo["fields"][12]; ?>"
                                                       id="<?php echo $CompInfo["fields"][12]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->getuserDet["data"]["company_id"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusinessdate" class="col-sm-1 control-label">Business Type</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $CompInfo["fields"][0]; ?>"
                                                                    name="<?php echo $CompInfo["fields"][0]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Business Type"}'></select>
                                                        </div>
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Company Name</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompInfo["fields"][1]; ?>"
                                                                   name="<?php echo $CompInfo["fields"][1]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_name"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Company Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="Company Name" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusinessdate" class="col-sm-1 control-label">Business Established</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompInfo["fields"][2]; ?>"
                                                                   name="<?php echo $CompInfo["fields"][2]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_doc"]); ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter Business Established Date"}'
                                                                   placeholder="Business Established" type="text">
                                                        </div>
                                                        <label for="inputwebsite" class="col-sm-1 control-label">Website</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompInfo["fields"][3]; ?>"
                                                                   name="<?php echo $CompInfo["fields"][3]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_website"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "10"}'
                                                                   data-messages='{"required": "Enter Website URL","minlength": "Length Should be minimum 10 Characters"}'
                                                                   placeholder="Website" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>
                                        <div class="box collapsed-box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><strong>Business Address</strong></h3>
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div><!-- /.box-tools -->
                                            </div><!-- /.box-header -->
                                            <div class="box-body" id="addbox">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputaddline" class="col-sm-2 control-label">Address Line</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="form-control"
                                                                      id="<?php echo $CompInfo["fields"][4]; ?>"
                                                                      name="<?php echo $CompInfo["fields"][4]; ?>"
                                                                      data-rules='{"required": true}'
                                                                      data-messages='{"required": "Enter valid address line"}'
                                                                      placeholder="Address Line"><?php echo trim($this->getuserDet["data"]["company_addressline"]); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputcountry" class="col-sm-1 control-label">Country</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompInfo["fields"][5]; ?>"
                                                                   name="<?php echo $CompInfo["fields"][5]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_country"]); ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter Country Name"}'
                                                                   placeholder="Country" type="text">
                                                        </div>
                                                        <label for="inputstate" class="col-sm-1 control-label">State</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompInfo["fields"][6]; ?>"
                                                                   name="<?php echo $CompInfo["fields"][6]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_province"]); ?>"
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
                                                                   id="<?php echo $CompInfo["fields"][7]; ?>"
                                                                   name="<?php echo $CompInfo["fields"][7]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_district"]); ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter District"}'
                                                                   placeholder="District" type="text">
                                                        </div>
                                                        <label for="inputcity" class="col-sm-1 control-label">City</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompInfo["fields"][8]; ?>"
                                                                   name="<?php echo $CompInfo["fields"][8]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_city"]); ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter City or Town"}'
                                                                   placeholder="City/Town" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputstreet" class="col-sm-1 control-label">Street</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompInfo["fields"][9]; ?>"
                                                                   name="<?php echo $CompInfo["fields"][9]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_street_loc"]); ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter Street or Locality"}'
                                                                   placeholder="Street/Locality" type="text">
                                                        </div>
                                                        <label for="inputzipcode" class="col-sm-1 control-label">Zipcode</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompInfo["fields"][10]; ?>"
                                                                   name="<?php echo $CompInfo["fields"][10]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_zipcode"]); ?>"
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
                                            id="<?php echo $CompInfo["fields"][11]; ?>"
                                            name="<?php echo $CompInfo["fields"][11]; ?>"
                                            data-rules='{}'
                                            data-messages='{}'>Submit Details</button>
                                </div>
                            </div>
                        </div><!-- /.tab-pane -->
                    </form>
                </div>
            </div>
            <!-- /. box -->
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'MasterData/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).recharge.masterdata;
        var obj = new masterdataController();
        obj.__constructor(para);
        obj.__BusinessInfoEdit();
    });
</script>