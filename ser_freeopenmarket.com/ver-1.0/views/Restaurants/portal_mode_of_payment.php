<?php
$AppMopList = isset($this->idHolders["recharge"]["masterdata"]["ListModeOfPay"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListModeOfPay"] : false;
$AddMop = isset($this->idHolders["recharge"]["masterdata"]["AddMOP"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddMOP"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listmop" data-toggle="tab">List</a></li>
        <li><a href="#addmop" data-toggle="tab">Add</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addmop">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $AddMop["form"]; ?>"
                      name="<?php echo $AddMop["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong> Add Mop</strong></h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Mode Of Payment</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddMop["fields"][0]; ?>"
                                                               name="<?php echo $AddMop["fields"][0]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Mode Of Payment","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="MOP" type="text" pattern="^[A-Za-z ]{3,100}$">
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <button type="submit"
                                                                class="btn btn-danger"
                                                                id="<?php echo $AddMop["fields"][1]; ?>"
                                                                name="<?php echo $AddMop["fields"][1]; ?>"
                                                                data-rules='{}'
                                                                data-messages='{}'>Submit Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div><!-- /.tab-pane -->
                </form>
            </div>
            <!-- /. box -->
        </div>
        <div class="active tab-pane" id="listmop">
            <div class="content">
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong> Add Mop</strong></h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $AppMopList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Mode Of Payment</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $AppMopList["fields"][1]; ?>">
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
