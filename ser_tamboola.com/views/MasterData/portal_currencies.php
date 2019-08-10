<?php
$AddCurr = isset($this->idHolders["recharge"]["masterdata"]["AddCurrencies"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddCurrencies"] : false;
$AddCurrList = isset($this->idHolders["recharge"]["masterdata"]["ListCurrencies"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListCurrencies"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listcurr" data-toggle="tab">List</a></li>
        <!--<li><a href="#addcurr" data-toggle="tab">Add</a></li>-->
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addcurr">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Add Currency</h3>
                </div><!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $AddCurr["form"]; ?>"
                      name="<?php echo $AddCurr["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-2 control-label">Country</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control"
                                                                id="<?php echo $AddCurr["fields"][0]; ?>"
                                                                name="<?php echo $AddCurr["fields"][0]; ?>"
                                                                data-rules='{"required": true}'
                                                                data-messages='{"required": "Select Country"}'>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Currency Name</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCurr["fields"][1]; ?>"
                                                               name="<?php echo $AddCurr["fields"][1]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Currency Name","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Currency Name" type="text" pattern="^[A-Za-z ]{3,100}$">
                                                    </div>
                                                    <label for="inputbusinessdate" class="col-sm-1 control-label">Currency Code</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCurr["fields"][2]; ?>"
                                                               name="<?php echo $AddCurr["fields"][2]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Currency Code","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Currency Code" type="text" pattern="^[A-Za-z ]{3,100}$">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-10">
                                            <button type="submit"
                                                    class="btn btn-danger"
                                                    id="<?php echo $AddCurr["fields"][3]; ?>"
                                                    name="<?php echo $AddCurr["fields"][3]; ?>"
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
        <div class="active tab-pane" id="listcurr">
            <div class="content">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        List Currencies
                    </h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive"
                                     id="">
                                    <table id="<?php echo $AddCurrList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Currency Name</th>
                                                <th>Currency Code</th>
                                                <th>Created At</th>
                                                <th>Country</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $AddCurrList["fields"][1]; ?>">
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
