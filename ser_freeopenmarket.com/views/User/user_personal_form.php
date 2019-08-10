<?php
$userPro = isset($this->idHolders["onlinefood"]["user"]["Personal"]["AddUser"]) ? (array) $this->idHolders["onlinefood"]["user"]["Personal"]["AddUser"] : false;
?>
<form class="form-horizontal"
      action=""
      id="<?php echo $userPro["form"]; ?>"
      name="<?php echo $userPro["form"]; ?>"
      method="post">
    <div class="content">
        <section class="content-header">
            <h1>
                Add Users
                <small></small>
            </h1>

        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>User Details</strong></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body" id="userbox">
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputusertype" class="col-sm-1 control-label">User Type</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $userPro["fields"][0]; ?>"
                                                    name="<?php echo $userPro["fields"][0]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select User type"}'>
                                            </select>
                                        </div>
                                        <label for="inputName" class="col-sm-1 control-label">Name</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $userPro["fields"][1]; ?>"
                                                   name="<?php echo $userPro["fields"][1]; ?>"
                                                   data-rules='{"required": true,"minlength": "3"}'
                                                   data-messages='{"required": "Enter Name","minlength": "Length Should be minimum 4 Characters"}'
                                                   placeholder="Full name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputgender" class="col-sm-1 control-label">Gender</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $userPro["fields"][2]; ?>"
                                                    name="<?php echo $userPro["fields"][2]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Gender"}'>
                                            </select>
                                        </div>
                                        <label for="inputdob" class="col-sm-1 control-label">Date of Birth</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $userPro["fields"][3]; ?>"
                                                   name="<?php echo $userPro["fields"][3]; ?>"
                                                   readonly="readonly"
                                                   data-rules='{"required": true}'
                                                   data-messages='{"required": "Enter Date of Birth"}'
                                                   placeholder="DOB">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Email IDs,Cell Numbers</strong></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div>
            <div class="box-body" id="addbox">
                <div class="box-tools pull-left col-sm-offset-4">
                    <button type="button" class="btn btn-box-tool" id="<?php echo $userPro["cloneplusbut"][0]; ?>" name="<?php echo $userPro["cloneplusbut"][0]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
                <div class="box-tools pull-left col-sm-offset-0">
                    <button type="button" class="btn btn-box-tool" id="<?php echo $userPro["cloneminusbut"][0]; ?>" name="<?php echo $userPro["cloneminusbut"][0]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                </div><!-- /.box-tools -->
                <div class="col-sm-12" id="<?php echo $userPro["clone"][0]; ?>0">
                    <div class="form-group">
                        <label for="inputemail" class="col-sm-1 control-label">Email IDs</label>
                        <div class="col-sm-5">
                            <input type="email"
                                   class="form-control <?php echo $userPro["reqparam"][0]; ?>"
                                   id="<?php echo $userPro["reqparam"][0]; ?>"
                                   name="<?php echo $userPro["reqparam"][0]; ?>"
                                   data-rules='{"required": true,"minlength": "6"}'
                                   data-messages='{"required": "Enter Email IDs","minlength": "Length Should be 6 characters"}'
                                   placeholder="Email ID"
                                   maxlength="100"/>
                        </div>
                    </div>
                    <div class="divider">&nbsp;</div>
                </div>
                <div class="box-tools pull-left col-sm-offset-5">
                    <button type="button" class="btn btn-box-tool" id="<?php echo $userPro["cloneplusbut"][1]; ?>" name="<?php echo $userPro["cloneplusbut"][1]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
                <div class="box-tools pull-left col-sm-offset-0">
                    <button type="button" class="btn btn-box-tool" id="<?php echo $userPro["cloneminusbut"][1]; ?>" name="<?php echo $userPro["cloneminusbut"][1]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                </div><!-- /.box-tools -->
                <div class="col-sm-12" id="<?php echo $userPro["clone"][1]; ?>">
                    <div class="form-group">
                        <label for="inputcellno" class="col-sm-1 control-label">Cell Numbers</label>
                        <div class="col-sm-2">
                            <input type="number"
                                   class="form-control <?php echo $userPro["resparam"][0]; ?>"
                                   id="<?php echo $userPro["resparam"][0]; ?>"
                                   name="<?php echo $userPro["resparam"][0]; ?>"
                                   data-rules='{"required": true,"maxlength":"2"}'
                                   data-messages='{"required": "Enter Cell Code","maxlength":"Maximum 2 numbers allowed"}'
                                   value="91"
                                   maxlength="2"/>
                        </div>
                        <div class="col-sm-3">
                            <input type="number"
                                   class="form-control <?php echo $userPro["resparam"][1]; ?>"
                                   id="<?php echo $userPro["resparam"][1]; ?>"
                                   name="<?php echo $userPro["resparam"][1]; ?>"
                                   data-rules='{"required": true,"minlength":"10"}'
                                   data-messages='{"required": "Enter Cell Numbers","minlength":"Maximum 10 numbers allowed"}'
                                   placeholder="Cell Number" 
                                   maxlength="12" />
                        </div>
                    </div>
                    <div class="divider">&nbsp;</div>
                </div>
            </div>
        </div>
        <div class="box collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Address</strong></h3>
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
                                      id="<?php echo $userPro["fields"][4]; ?>"
                                      name="<?php echo $userPro["fields"][4]; ?>"
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
                                   id="<?php echo $userPro["fields"][5]; ?>"
                                   name="<?php echo $userPro["fields"][5]; ?>"
                                   data-rules='{"required": true}'
                                   data-messages='{"required": "Enter Country Name"}'
                                   placeholder="Country" type="text">
                        </div>
                        <label for="inputstate" class="col-sm-1 control-label">State</label>
                        <div class="col-sm-5">
                            <input class="form-control"
                                   id="<?php echo $userPro["fields"][6]; ?>"
                                   name="<?php echo $userPro["fields"][6]; ?>"
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
                                   id="<?php echo $userPro["fields"][7]; ?>"
                                   name="<?php echo $userPro["fields"][7]; ?>"
                                   data-rules='{"required": true}'
                                   data-messages='{"required": "Enter District"}'
                                   placeholder="District" type="text">
                        </div>
                        <label for="inputcity" class="col-sm-1 control-label">City/Town</label>
                        <div class="col-sm-5">
                            <input class="form-control"
                                   id="<?php echo $userPro["fields"][8]; ?>"
                                   name="<?php echo $userPro["fields"][8]; ?>"
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
                                   id="<?php echo $userPro["fields"][9]; ?>"
                                   name="<?php echo $userPro["fields"][9]; ?>"
                                   data-rules='{"required": true}'
                                   data-messages='{"required": "Enter Street or Locality"}'
                                   placeholder="Street/Locality" type="text">
                        </div>
                        <label for="inputzipcode" class="col-sm-1 control-label">Zipcode</label>
                        <div class="col-sm-5">
                            <input class="form-control"
                                   id="<?php echo $userPro["fields"][10]; ?>"
                                   name="<?php echo $userPro["fields"][10]; ?>"
                                   data-rules='{"required": true,"minlength": "3"}'
                                   data-messages='{"required": "Enter Zipcode","minlength": "Length Should be minimum 3 numbers"}'
                                   placeholder="Zipcode" type="text">
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-10">
                <button type="submit"
                        class="btn btn-danger"
                        id="<?php echo $userPro["fields"][11]; ?>"
                        name="<?php echo $userPro["fields"][11]; ?>"
                        data-rules='{}'
                        data-messages='{}'>Submit Details</button>
            </div>
        </div>
    </div><!-- /.tab-pane -->
</form>
