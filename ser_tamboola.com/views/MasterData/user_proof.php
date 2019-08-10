<?php
$UsrProf = isset($this->idHolders["recharge"]["masterdata"]["AddProof"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddProof"] : false;
$UsrProfList = isset($this->idHolders["recharge"]["masterdata"]["ListUserProof"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListUserProof"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listuprof" data-toggle="tab">List</a></li>
        <li><a href="#adduprof" data-toggle="tab">Add</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="adduprof">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $UsrProf["form"]; ?>"
                      name="<?php echo $UsrProf["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Add User Proof</strong></h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Country</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-control"
                                                                id="<?php echo $UsrProf["fields"][0]; ?>"
                                                                name="<?php echo $UsrProf["fields"][0]; ?>"
                                                                data-rules='{"required": true}'
                                                                data-messages='{"required": "Select Country"}'>
                                                        </select>
                                                    </div>
                                                    <label for="inputbusiness" class="col-sm-1 control-label">User Proof</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $UsrProf["fields"][1]; ?>"
                                                               name="<?php echo $UsrProf["fields"][1]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter User Proof","minlength": "Length Should be minimum 2 numbers"}'
                                                               placeholder="User Proof" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-10">
                                            <button type="submit"
                                                    class="btn btn-danger"
                                                    id="<?php echo $UsrProf["fields"][2]; ?>"
                                                    name="<?php echo $UsrProf["fields"][2]; ?>"
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
        <div class="active tab-pane" id="listuprof">
            <div class="content">
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>List User Proof</strong></h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $UsrProfList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID Proof Type</th>
                                                <th>Date</th>
                                                <th>Country</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $UsrProfList["fields"][1]; ?>">
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
