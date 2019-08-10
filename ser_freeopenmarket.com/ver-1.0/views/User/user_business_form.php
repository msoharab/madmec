<?php
$userBusi = isset($this->idHolders["onlinefood"]["user"]["Business"]["AddBusiness"]) ? (array) $this->idHolders["onlinefood"]["user"]["Business"]["AddBusiness"] : false;
?>
<form class="form-horizontal"
      action=""
      id="<?php echo $userBusi["form"]; ?>"
      name="<?php echo $userBusi["form"]; ?>"
      method="post">
    <div class="content">
        <section class="content-header">
            <h1>
                Add Details
                <small></small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Business Details</strong></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputbusinessdate" class="col-sm-3 control-label">User</label>
                                    <div class="col-sm-9">
                                        <select class="form-control"
                                                id="<?php echo $userBusi["fields"][25]; ?>"
                                                name="<?php echo $userBusi["fields"][25]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select User"}'></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputbusiness" class="col-sm-1 control-label">Business Name</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][0]; ?>"
                                               name="<?php echo $userBusi["fields"][0]; ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter Business Name","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="Business Name" type="text">
                                    </div>
                                    <label for="inputbusinessdate" class="col-sm-1 control-label">Business Established</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][24]; ?>"
                                               name="<?php echo $userBusi["fields"][24]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Business Established Date"}'
                                               readonly="readonly"
                                               placeholder="Business Established" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputowner" class="col-sm-1 control-label">Owner Name</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][1]; ?>"
                                               name="<?php echo $userBusi["fields"][1]; ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter Owner Name","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="Owner Name" type="text">
                                    </div>
                                    <label class="col-sm-1 control-label">Website</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][2]; ?>"
                                               name="<?php echo $userBusi["fields"][2]; ?>"
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
                            <h3 class="box-title"><strong>Bank Details</strong></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div><!-- /.box-tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-3 control-label">Account Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][3]; ?>"
                                               name="<?php echo $userBusi["fields"][3]; ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter Account Name","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="Account Name" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputaccount" class="col-sm-1 control-label">Account Number</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][4]; ?>"
                                               name="<?php echo $userBusi["fields"][4]; ?>"
                                               data-rules='{"required": true,"minlength": "8"}'
                                               data-messages='{"required": "Enter Account number","minlength": "Length Should be minimum 8 numbers"}'
                                               placeholder="Account Number" type="text">
                                    </div>
                                    <label for="inputifsc" class="col-sm-1 control-label">IFSC</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][5]; ?>"
                                               name="<?php echo $userBusi["fields"][5]; ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter IFSC Code","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="IFSC" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputbank" class="col-sm-1 control-label">Bank Name</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][6]; ?>"
                                               name="<?php echo $userBusi["fields"][6]; ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter Bank Name","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="Bank Name" type="text">
                                    </div>
                                    <label for="inputcode" class="col-sm-1 control-label">Bank Code</label>
                                    <div class="col-sm-5">
                                        <input class="form-control" 
                                               id="<?php echo $userBusi["fields"][7]; ?>"
                                               name="<?php echo $userBusi["fields"][7]; ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter Bank Code","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="Bank Code" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputbranch" class="col-sm-1 control-label">Branch Name</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][8]; ?>"
                                               name="<?php echo $userBusi["fields"][8]; ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter Branch Name","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="Branch Name" type="text">
                                    </div>
                                    <label for="inputbranch" class="col-sm-1 control-label">Branch Code</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][9]; ?>"
                                               name="<?php echo $userBusi["fields"][9]; ?>"
                                               data-rules='{"required": true,"minlength": "2"}'
                                               data-messages='{"required": "Enter Branch Code","minlength": "Length Should be minimum 2 numbers"}'
                                               placeholder="Branch Code" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Office Address</strong></h3>
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
                                                  id="<?php echo $userBusi["fields"][10]; ?>"
                                                  name="<?php echo $userBusi["fields"][10]; ?>"
                                                  data-rules='{"required": true}'
                                                  data-messages='{"required": "Enter valid address line"}'
                                                  placeholder="Address Line"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputcountry" class="col-sm-1 control-label">Country</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][11]; ?>"
                                               name="<?php echo $userBusi["fields"][11]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Country Name"}'
                                               placeholder="Country" type="text">
                                    </div>
                                    <label for="inputstate" class="col-sm-1 control-label">State</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][12]; ?>"
                                               name="<?php echo $userBusi["fields"][12]; ?>"
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
                                               id="<?php echo $userBusi["fields"][13]; ?>"
                                               name="<?php echo $userBusi["fields"][13]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter District"}'
                                               placeholder="District" type="text">
                                    </div>
                                    <label for="inputcity" class="col-sm-1 control-label">City/Town</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][14]; ?>"
                                               name="<?php echo $userBusi["fields"][14]; ?>"
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
                                               id="<?php echo $userBusi["fields"][15]; ?>"
                                               name="<?php echo $userBusi["fields"][15]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Street or Locality"}'
                                               placeholder="Street/Locality" type="text">
                                    </div>
                                    <label for="inputzipcode" class="col-sm-1 control-label">Zipcode</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][16]; ?>"
                                               name="<?php echo $userBusi["fields"][16]; ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter Zipcode","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="Zipcode" type="text">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                    <div class="box collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Business Proof Details</strong></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div><!-- /.box-tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputidproof" class="col-sm-2 control-label">ID Number</label>
                                    <div class="col-sm-9">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][17]; ?>"
                                               name="<?php echo $userBusi["fields"][17]; ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter Id number","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="ID number" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputidtype" class="col-sm-1 control-label">Document type</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][18]; ?>"
                                               name="<?php echo $userBusi["fields"][18]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter document type"}'
                                               placeholder="Document type" type="text">
                                    </div>
                                    <label for="inputid" class="col-sm-1 control-label">ID Upload </label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][19]; ?>"
                                               name="<?php echo $userBusi["fields"][19]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Upload valid document"}'
                                               type="file">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Address Proof Details</strong></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div><!-- /.box-tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputaddid" class="col-sm-2 control-label">Document Number</label>
                                    <div class="col-sm-9">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][20]; ?>"
                                               name="<?php echo $userBusi["fields"][20]; ?>"
                                               data-rules='{"required": true,"minlength": "6"}'
                                               data-messages='{"required": "Enter document number","minlength": "Length Should be minimum 6 numbers"}'
                                               placeholder="Document Number" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputdoctype" class="col-sm-1 control-label">Document type</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][21]; ?>"
                                               name="<?php echo $userBusi["fields"][21]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter document type"}'
                                               placeholder="Document type" type="text">
                                    </div>
                                    <label for="inputdoccopy" class="col-sm-1 control-label">Document Upload </label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $userBusi["fields"][22]; ?>"
                                               name="<?php echo $userBusi["fields"][22]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Upload valid document"}'
                                               type="file">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-10">
                            <button type="submit"
                                    class="btn btn-primary"
                                    id="<?php echo $userBusi["fields"][23]; ?>"
                                    name="<?php echo $userBusi["fields"][23]; ?>"
                                    data-rules='{}'
                                    data-messages='{}'><strong>Submit Details</strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</form>
