<?php
$ParaList = isset($this->idHolders["recharge"]["masterdata"]["ListRestParam"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListRestParam"] : false;
$AddPara = isset($this->idHolders["recharge"]["masterdata"]["AddRestParameter"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddRestParameter"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listpara" data-toggle="tab">List</a></li>
        <li><a href="#addpara" data-toggle="tab">Add</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addpara">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $AddPara["form"]; ?>"
                      name="<?php echo $AddPara["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Add Parameters</strong></h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-2 control-label">Parameter Field</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control"
                                                               id="<?php echo $AddPara["fields"][0]; ?>"
                                                               name="<?php echo $AddPara["fields"][0]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Parameter Field","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Parameter Field" type="text" pattern="^[A-Za-z 0-9\-\.=:;]{3,100}$">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Meaning</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddPara["fields"][1]; ?>"
                                                               name="<?php echo $AddPara["fields"][1]; ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter Parameter Meaning"}'
                                                               placeholder="Meaning" type="text">
                                                    </div>
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Description</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddPara["fields"][2]; ?>"
                                                               name="<?php echo $AddPara["fields"][2]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Parameter Description","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Description" type="text">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-5 col-sm-10">
                                                        <button type="submit"
                                                                class="btn btn-danger"
                                                                id="<?php echo $AddPara["fields"][3]; ?>"
                                                                name="<?php echo $AddPara["fields"][3]; ?>"
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
        <div class="active tab-pane" id="listpara">
            <div class="content">
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>List Parameters</strong></h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $ParaList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Parameter Field</th>
                                                <th>Parameter Meaning</th>
                                                <th>Parameter Description</th>
                                                <th>Date</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $ParaList["fields"][1]; ?>">
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
