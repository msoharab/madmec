<?php
$SetCur = isset($this->idHolders["recharge"]["masterdata"]["SetCurrency"]) ? (array) $this->idHolders["recharge"]["masterdata"]["SetCurrency"] : false;
$SetCurList = isset($this->idHolders["recharge"]["masterdata"]["ListSetCurrency"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListSetCurrency"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listSetCur" data-toggle="tab">List</a></li>
        <li><a href="#addSetCur" data-toggle="tab">Add</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addSetCur">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $SetCur["form"]; ?>"
                      name="<?php echo $SetCur["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Set Currency</strong></h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Company</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-control"
                                                                id="<?php echo $SetCur["fields"][0]; ?>"
                                                                name="<?php echo $SetCur["fields"][0]; ?>"
                                                                data-rules='{"required": true}'
                                                                data-messages='{"required": "Select Company"}'>
                                                        </select>
                                                    </div>
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Currency</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-control"
                                                                id="<?php echo $SetCur["fields"][1]; ?>"
                                                                name="<?php echo $SetCur["fields"][1]; ?>"
                                                                data-rules='{"required": true}'
                                                                data-messages='{"required": "Select Currency"}'>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-10">
                                            <button type="submit"
                                                    class="btn btn-danger"
                                                    id="<?php echo $SetCur["fields"][2]; ?>"
                                                    name="<?php echo $SetCur["fields"][2]; ?>"
                                                    data-rules='{}'
                                                    data-messages='{}'>Set Currency</button>
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
        <div class="active tab-pane" id="listSetCur">
            <div class="content">
                <!-- Content Header (Page header) -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>List Company Currency</strong></h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $SetCurList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Company</th>
                                                <th>Currency</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $SetCurList["fields"][1]; ?>">
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
