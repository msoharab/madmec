<?php
$AddBty = isset($this->idHolders["recharge"]["masterdata"]["AddBusinessType"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddBusinessType"] : false;
$AddBtyList = isset($this->idHolders["recharge"]["masterdata"]["ListBusinessType"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListBusinessType"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listBusiTY" data-toggle="tab">List</a></li>
        <li><a href="#addBusiTY" data-toggle="tab">Add</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addBusiTY">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <div class="box-header with-border">
                </div><!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $AddBty["form"]; ?>"
                      name="<?php echo $AddBty["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Add Business Type</strong></h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Country</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-control"
                                                                id="<?php echo $AddBty["fields"][0]; ?>"
                                                                name="<?php echo $AddBty["fields"][0]; ?>"
                                                                data-rules='{"required": true}'
                                                                data-messages='{"required": "Select Country"}'>
                                                        </select>
                                                    </div>
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Business Type</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddBty["fields"][1]; ?>"
                                                               name="<?php echo $AddBty["fields"][1]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Business Type","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Business Type" type="text" pattern="^[A-Za-z ]{3,100}$">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-10">
                                            <button type="submit"
                                                    class="btn btn-danger"
                                                    id="<?php echo $AddBty["fields"][2]; ?>"
                                                    name="<?php echo $AddBty["fields"][2]; ?>"
                                                    data-rules='{}'
                                                    data-messages='{}'>Submit Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div><!-- /.tab-pane -->
                </form>
            </div>
            <!-- /. box -->
        </div>
        <div class="active tab-pane" id="listBusiTY">
            <div class="content">
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>List Business Type</strong></h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $AddBtyList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Business Type</th>
                                                <th>Country</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $AddBtyList["fields"][1]; ?>">
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
