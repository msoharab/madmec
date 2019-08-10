<?php
$UsrType = isset($this->idHolders["recharge"]["masterdata"]["AddUserType"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddUserType"] : false;
$UsrTypeList = isset($this->idHolders["recharge"]["masterdata"]["ListUserTypes"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListUserTypes"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listutype" data-toggle="tab">List</a></li>
        <!--<li><a href="#addutype" data-toggle="tab">Add</a></li>-->
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addutype">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Add User Type</h3>
                </div><!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $UsrType["form"]; ?>"
                      name="<?php echo $UsrType["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">User Type</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $UsrType["fields"][0]; ?>"
                                                               name="<?php echo $UsrType["fields"][0]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter User Type","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="User Type" type="text">
                                                    </div>
                                                    <label for="inputbusinessdate" class="col-sm-1 control-label">Minimum Balance</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $UsrType["fields"][1]; ?>"
                                                               name="<?php echo $UsrType["fields"][1]; ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter Minimum Balance"}'
                                                               placeholder="Minimum Balance" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-10">
                                            <button type="submit"
                                                    class="btn btn-danger"
                                                    id="<?php echo $UsrType["fields"][2]; ?>"
                                                    name="<?php echo $UsrType["fields"][2]; ?>"
                                                    data-rules='{}'
                                                    data-messages='{}'>Submit Details</button>
                                        </div>
                                    </div>
                                </div>
                        </section>
                    </div><!-- /.tab-pane -->
                </form>
            </div>
            <!-- /. box -->
        </div>
        <div class="active tab-pane" id="listutype">
            <div class="content">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        List User Types
                    </h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $UsrTypeList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User Type</th>
                                                <th>Minimum Balance</th>
                                                <th>Date</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $UsrTypeList["fields"][1]; ?>">
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
