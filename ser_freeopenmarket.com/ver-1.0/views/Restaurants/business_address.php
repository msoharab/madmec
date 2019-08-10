<?php
$CompAddress = isset($this->idHolders["recharge"]["masterdata"]["AddBusinessAddr"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddBusinessAddr"] : false;
$CompAddr = isset($this->idHolders["recharge"]["masterdata"]["ListBusinessAddr"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListBusinessAddr"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listbank" data-toggle="tab">List</a></li>
        <li><a href="#addbank" data-toggle="tab">Add</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addbank">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Add Business Address</h3>
                </div><!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $CompAddress["form"]; ?>"
                      name="<?php echo $CompAddress["form"]; ?>"
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
                                                                  id="<?php echo $CompAddress["fields"][0]; ?>"
                                                                  name="<?php echo $CompAddress["fields"][0]; ?>"
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
                                                               id="<?php echo $CompAddress["fields"][1]; ?>"
                                                               name="<?php echo $CompAddress["fields"][1]; ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter Country Name"}'
                                                               placeholder="Country" type="text">
                                                    </div>
                                                    <label for="inputstate" class="col-sm-1 control-label">State</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompAddress["fields"][2]; ?>"
                                                               name="<?php echo $CompAddress["fields"][2]; ?>"
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
                                                               id="<?php echo $CompAddress["fields"][3]; ?>"
                                                               name="<?php echo $CompAddress["fields"][3]; ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter District"}'
                                                               placeholder="District" type="text">
                                                    </div>
                                                    <label for="inputcity" class="col-sm-1 control-label">City/Town</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompAddress["fields"][4]; ?>"
                                                               name="<?php echo $CompAddress["fields"][4]; ?>"
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
                                                               id="<?php echo $CompAddress["fields"][5]; ?>"
                                                               name="<?php echo $CompAddress["fields"][5]; ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter Street or Locality"}'
                                                               placeholder="Street/Locality" type="text">
                                                    </div>
                                                    <label for="inputzipcode" class="col-sm-1 control-label">Zipcode</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompAddress["fields"][6]; ?>"
                                                               name="<?php echo $CompAddress["fields"][6]; ?>"
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
                                        id="<?php echo $CompAddress["fields"][7]; ?>"
                                        name="<?php echo $CompAddress["fields"][7]; ?>"
                                        data-rules='{}'
                                        data-messages='{}'>Submit Details</button>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                </form>
            </div>
            <!-- /. box -->
        </div>
        <div class="active tab-pane" id="listbank">
            <div class="content">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        List Business Address
                    </h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive"
                                     id="">
                                    <table id="<?php echo $CompAddr["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Business Name</th>
                                                <th>Address line</th>
                                                <th>Country</th>
                                                <th>City</th>
                                                <th>Mobile</th>
                                                <th>Proof ID</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $CompAddr["fields"][1]; ?>">
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
            </div>
        </div>
    </div><!-- /.nav-tabs-custom -->
</div>
