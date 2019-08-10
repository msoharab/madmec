<?php
$CompBank = isset($this->idHolders["recharge"]["masterdata"]["AddBank"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddBank"] : false;
$CompBankList = isset($this->idHolders["recharge"]["masterdata"]["ListBankDetails"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListBankDetails"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#list" data-toggle="tab">List</a></li>
        <li><a href="#add" data-toggle="tab">Add</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="add">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $CompBank["form"]; ?>"
                      name="<?php echo $CompBank["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong> Add Bank Details</strong></h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputservicee" class="col-sm-1 control-label">Company</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-control"
                                                                id="<?php echo $CompBank["fields"][0]; ?>"
                                                                name="<?php echo $CompBank["fields"][0]; ?>"
                                                                data-rules='{"required": true}'
                                                                data-messages='{"required": "Select Company"}'>
                                                        </select>
                                                    </div>
                                                    <label for="inputName" class="col-sm-1 control-label">Account Name</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompBank["fields"][1]; ?>"
                                                               name="<?php echo $CompBank["fields"][1]; ?>"
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
                                                               id="<?php echo $CompBank["fields"][2]; ?>"
                                                               name="<?php echo $CompBank["fields"][2]; ?>"
                                                               data-rules='{"required": true,"minlength": "8"}'
                                                               data-messages='{"required": "Enter Account number","minlength": "Length Should be minimum 8 numbers"}'
                                                               placeholder="Account Number" type="text">
                                                    </div>
                                                    <label for="inputifsc" class="col-sm-1 control-label">IFSC</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompBank["fields"][3]; ?>"
                                                               name="<?php echo $CompBank["fields"][3]; ?>"
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
                                                               id="<?php echo $CompBank["fields"][4]; ?>"
                                                               name="<?php echo $CompBank["fields"][4]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Bank Name","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Bank Name" type="text">
                                                    </div>
                                                    <label for="inputcode" class="col-sm-1 control-label">Bank Code</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompBank["fields"][5]; ?>"
                                                               name="<?php echo $CompBank["fields"][5]; ?>"
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
                                                               id="<?php echo $CompBank["fields"][6]; ?>"
                                                               name="<?php echo $CompBank["fields"][6]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Branch Name","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Branch Name" type="text">
                                                    </div>
                                                    <label for="inputbranch" class="col-sm-1 control-label">Branch Code</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $CompBank["fields"][7]; ?>"
                                                               name="<?php echo $CompBank["fields"][7]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter Branch Code","minlength": "Length Should be minimum 2 numbers"}'
                                                               placeholder="Branch Code" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </section>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-10">
                                <button type="submit"
                                        class="btn btn-danger"
                                        id="<?php echo $CompBank["fields"][8]; ?>"
                                        name="<?php echo $CompBank["fields"][8]; ?>"
                                        data-rules='{}'
                                        data-messages='{}'>Submit Details</button>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                </form>
            </div>
            <!-- /. box -->
        </div>
        <div class="active tab-pane" id="list">
            <div class="content">
                <!-- Content Header (Page header) -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong> List Bank Details</strong></h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $CompBankList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Company</th>
                                                <th>Account Name</th>
                                                <th>Account Number</th>
                                                <th>Bank Name</th>
                                                <th>Branch</th>
                                                <th>Branch Code</th>
                                                <th>IFSC</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $CompBankList["fields"][1]; ?>">
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
