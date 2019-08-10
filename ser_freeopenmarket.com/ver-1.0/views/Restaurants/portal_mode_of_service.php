<?php
$AddMos = isset($this->idHolders["recharge"]["masterdata"]["AddMOS"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddMOS"] : false;
$AddMosList = isset($this->idHolders["recharge"]["masterdata"]["ListModeOfServ"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListModeOfServ"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listmos" data-toggle="tab">List</a></li>
        <li><a href="#addmos" data-toggle="tab">Add</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addmos">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $AddMos["form"]; ?>"
                      name="<?php echo $AddMos["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong> Add Mos</strong></h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Mode Of Service</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddMos["fields"][0]; ?>"
                                                               name="<?php echo $AddMos["fields"][0]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Mode Of Service","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="MOS" type="text" pattern="^[A-Za-z ]{3,100}$">
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <button type="submit"
                                                                class="btn btn-danger"
                                                                id="<?php echo $AddMos["fields"][1]; ?>"
                                                                name="<?php echo $AddMos["fields"][1]; ?>"
                                                                data-rules='{}'
                                                                data-messages='{}'>Submit Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                        </section>
                    </div><!-- /.tab-pane -->
                </form>
            </div>
            <!-- /. box -->
        </div>
        <div class="active tab-pane" id="listmos">
            <div class="content">
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong> Add Mos</strong></h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $AddMosList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Mode Of Service</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $AddMosList["fields"][1]; ?>">
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
