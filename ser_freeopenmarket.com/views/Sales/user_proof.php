<?php
$UsrProf = isset($this->idHolders["onlinefood"]["masterdata"]["ListUserProof"]) ? (array) $this->idHolders["onlinefood"]["masterdata"]["ListUserProof"] : false;
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
                <div class="box-header with-border">
                    <h3 class="box-title"> Add User Proof</h3>
                </div><!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $UsrProf["form"]; ?>"
                      name="<?php echo $userPro["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-2 control-label">User Proof</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control"
                                                               id="<?php echo $UsrPro["fields"][0]; ?>"
                                                               name="<?php echo $UsrPro["fields"][0]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter User Proof","minlength": "Length Should be minimum 3 numbers"}'
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
                                                    id="<?php echo $UsrPro["fields"][1]; ?>"
                                                    name="<?php echo $UsrPro["fields"][1]; ?>"
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
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        List User Proof
                    </h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $UsrProf["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID Proof Type</th>
                                                <th>Date</th>
                                                <th>Country</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $UsrProf["fields"][1]; ?>">
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
