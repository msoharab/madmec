<?php
$userPro = isset($this->idHolders["onlinefood"]["gateway"]["AddGateway"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["AddGateway"] : false;
?>
<form class="form-horizontal"
      action=""
      id="<?php echo $userPro["form"]; ?>"
      name="<?php echo $userPro["form"]; ?>"
      method="post">
    <div class="content">
        <section class="content-header">
            <h1>
                Add Gateway
                <small></small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Gateway Details</strong></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body" id="userbox">
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputmobile1" class="col-sm-3 control-label">Service</label>
                                        <div class="col-sm-9">
                                            <select type="number"
                                                    class="form-control"
                                                    id="<?php echo $userPro["fields"][0]; ?>"
                                                    name="<?php echo $userPro["fields"][0]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required":"Select Service","minlength": "Length Should be 10 numbers"}'></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputusertype" class="col-sm-1 control-label">Gateway Business Type</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $userPro["fields"][1]; ?>"
                                                    name="<?php echo $userPro["fields"][1]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Gateway Business type"}'>
                                            </select>
                                        </div>
                                        <label for="inputName" class="col-sm-1 control-label">Gateway Name</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $userPro["fields"][2]; ?>"
                                                   name="<?php echo $userPro["fields"][2]; ?>"
                                                   data-rules='{"required": true,"minlength": "3"}'
                                                   data-messages='{"required": "Enter Gateway Name","minlength": "Length Should be minimum 4 Characters"}'
                                                   placeholder="Gateway Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-1 control-label">Email</label>
                                        <div class="col-sm-5">
                                            <input type="email"
                                                   class="form-control"
                                                   id="<?php echo $userPro["fields"][3]; ?>"
                                                   name="<?php echo $userPro["fields"][3]; ?>"
                                                   data-rules='{"required": true,"email": true,"minlength": "8"}'
                                                   data-messages='{"email": "Enter Email id","minlength": "Length Should be minimum 8 Characters"}'
                                                   placeholder="Email" />
                                        </div>
                                        <label for="inputdob" class="col-sm-1 control-label">Date of Establishment</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $userPro["fields"][4]; ?>"
                                                   name="<?php echo $userPro["fields"][4]; ?>"
                                                   readonly="readonly"
                                                   data-rules='{"required": true}'
                                                   data-messages='{"required": "Enter Date of Establishment"}'
                                                   placeholder="Date of Establishment">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputgender" class="col-sm-1 control-label">Gateway Version</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $userPro["fields"][5]; ?>"
                                                   name="<?php echo $userPro["fields"][5]; ?>"
                                                   data-rules='{"required": true,"minlength": "3"}'
                                                   data-messages='{"required": "Enter Gateway Version","minlength": "Length Should be minimum 4 Characters"}'
                                                   placeholder="Gateway Version">
                                        </div>
                                        <label for="inputmobile" class="col-sm-1 control-label">Mobile</label>
                                        <div class="col-sm-5">
                                            <input type="number"
                                                   class="form-control"
                                                   id="<?php echo $userPro["fields"][6]; ?>"
                                                   name="<?php echo $userPro["fields"][6]; ?>"
                                                   data-rules='{"required": true,"minlength": "10","maxlength":"10"}'
                                                   data-messages='{"required": "Enter Mobile number","minlength": "Length Should be 10 numbers","maxlength": "Length Should be 10 numbers"}'
                                                   placeholder="Mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                                      id="<?php echo $userPro["fields"][7]; ?>"
                                      name="<?php echo $userPro["fields"][7]; ?>"
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
                                   id="<?php echo $userPro["fields"][8]; ?>"
                                   name="<?php echo $userPro["fields"][8]; ?>"
                                   data-rules='{"required": true}'
                                   data-messages='{"required": "Enter Country Name"}'
                                   placeholder="Country" type="text">
                        </div>
                        <label for="inputstate" class="col-sm-1 control-label">State</label>
                        <div class="col-sm-5">
                            <input class="form-control"
                                   id="<?php echo $userPro["fields"][9]; ?>"
                                   name="<?php echo $userPro["fields"][9]; ?>"
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
                                   id="<?php echo $userPro["fields"][10]; ?>"
                                   name="<?php echo $userPro["fields"][10]; ?>"
                                   data-rules='{"required": true}'
                                   data-messages='{"required": "Enter District"}'
                                   placeholder="District" type="text">
                        </div>
                        <label for="inputcity" class="col-sm-1 control-label">City/Town</label>
                        <div class="col-sm-5">
                            <input class="form-control"
                                   id="<?php echo $userPro["fields"][11]; ?>"
                                   name="<?php echo $userPro["fields"][11]; ?>"
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
                                   id="<?php echo $userPro["fields"][12]; ?>"
                                   name="<?php echo $userPro["fields"][12]; ?>"
                                   data-rules='{"required": true}'
                                   data-messages='{"required": "Enter Street or Locality"}'
                                   placeholder="Street/Locality" type="text">
                        </div>
                        <label for="inputzipcode" class="col-sm-1 control-label">Zipcode</label>
                        <div class="col-sm-5">
                            <input class="form-control"
                                   id="<?php echo $userPro["fields"][13]; ?>"
                                   name="<?php echo $userPro["fields"][13]; ?>"
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
                <h3 class="box-title"><strong>ID Proof Details</strong></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <label for="inputidproof" class="col-sm-2 control-label">ID Number</label>
                    <div class="col-sm-8">
                        <input class="form-control"
                               id="<?php echo $userPro["fields"][14]; ?>"
                               name="<?php echo $userPro["fields"][14]; ?>"
                               data-rules='{"required": true,"minlength": "6"}'
                               data-messages='{"required": "Enter Id number","minlength": "Length Should be minimum 6 numbers"}'
                               placeholder="ID number" type="text">
                    </div>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="inputidtype" class="col-sm-2 control-label">Document type</label>
                    <div class="col-sm-10">
                        <select class="form-control"
                                id="<?php echo $userPro["fields"][15]; ?>"
                                name="<?php echo $userPro["fields"][15]; ?>"
                                data-rules='{"required": true}'
                                data-messages='{"required": "Select Document type"}'>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="inputid" class="col-sm-2 control-label">ID Upload </label>
                    <div class="col-sm-10">
                        <input class="form-control"
                               id="<?php echo $userPro["fields"][16]; ?>"
                               name="<?php echo $userPro["fields"][16]; ?>"
                               data-rules='{"required": true,"extension": "gif|jpeg|png"}'
                               data-messages='{"required": "Upload valid scanned document","extension": "Valid extensions png|jpe?g|gif"}'
                               type="file">
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-10">
                <button type="submit"
                        class="btn btn-danger"
                        id="<?php echo $userPro["fields"][17]; ?>"
                        name="<?php echo $userPro["fields"][17]; ?>"
                        data-rules='{}'
                        data-messages='{}'>Submit Details</button>
            </div>
        </div>
    </div><!-- /.tab-pane -->
</form>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'Gateway/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).onlinefood.gateway;
        var obj = new gatewayController();
        obj.__constructor(para);
        obj.__AddGate();
    });
</script>