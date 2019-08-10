<?php
$AccExpen = isset($this->idHolders["tamboola"]["accounts"]["Expenses"]) ? (array) $this->idHolders["tamboola"]["accounts"]["Expenses"] : false;
$AccExpenList = isset($this->idHolders["tamboola"]["accounts"]["Expenses"]) ? (array) $this->idHolders["tamboola"]["accounts"]["Expenses"] : false;
?>
<div class="content-wrapper">
    <div class="content">
        <section class="content-header">
            <h1>
                Accounts
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="active">Accounts</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tab-content">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title"><strong>Club Expenses</strong></h3>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#Add" data-toggle="tab" id="Addfacility">Add Expenses</a>
                                </li>
                                <li>
                                    <a href="#Show" data-toggle="tab" id="Showfacility">List Expenses</a>
                                </li>
                            </ul><!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="Add">
                                    <form class="form-horizontal" action="" id="<?php echo $AccExpen["form"]; ?>" name="<?php echo $AccExpen["form"]; ?>" method="post">
                                        <section class="content">
                                            <div class="box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title with-border"><strong>Add Expenses</strong></h3>
                                                </div>
                                                <div class="box-body" id="userbox">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputgymName" class="col-sm-3 control-label">Name Of The Payee</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" 
                                                                       id="<?php echo $AccExpen["fields"][0]; ?>" 
                                                                       name="<?php echo $AccExpen["fields"][0]; ?>" 
                                                                       data-rules='{"required": true,"maxlength": "100"}'
                                                                       data-messages='{"required": "Enter Name Of The Payee","maxlength": "Length Should be maximum 100 characters"}'
                                                                       placeholder="Water Supply">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputgymName" class="col-sm-3 control-label">Amount</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="<?php echo $AccExpen["fields"][1]; ?>"
                                                                           name="<?php echo $AccExpen["fields"][1]; ?>"
                                                                           data-rules='{"required": true,"maxlength": "100"}'
                                                                           data-messages='{"required": "Enter Name Of The Payee","maxlength": "Length Should be maximum 100 characters"}'
                                                                           placeholder="0.00">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputregfee" class="col-sm-3 control-label">Receipt No</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="<?php echo $AccExpen["fields"][2]; ?>"
                                                                           name="<?php echo $AccExpen["fields"][2]; ?>"
                                                                           data-rules='{"required": true,"maxlength": "100"}'
                                                                           data-messages='{"required": "Enter Amount","maxlength": "Length Should be maximum 100 characters"}'
                                                                           placeholder="00000" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputregfee" class="col-sm-3 control-label">Date</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text"
                                                                           name="<?php echo $AccExpen["fields"][3]; ?>"
                                                                           class="form-control"
                                                                           id="<?php echo $AccExpen["fields"][3]; ?>"
                                                                           data-rules='{"required": true}'
                                                                           data-messages='{"required": "Enter date"}'
                                                                           readonly="readonly">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputsertax" class="col-sm-3 control-label">Description</label>
                                                                <div class="col-sm-6">
                                                                    <textarea class="form-control"
                                                                              id="<?php echo $AccExpen["fields"][4]; ?>"
                                                                              name="<?php echo $AccExpen["fields"][4]; ?>"
                                                                              rows="8"
                                                                              data-rules='{"required": true}'
                                                                              data-messages='{"required": "Enter Description"}'
                                                                              placeholder="Two months advance paid to water supply.."></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-offset-5 col-sm-11">
                                                                <button type="submit"
                                                                        class="btn btn-primary"
                                                                        id="<?php echo $AccExpen["fields"][5]; ?>"
                                                                        name="<?php echo $AccExpen["fields"][5]; ?>"
                                                                        data-rules='{}'
                                                                        data-messages='{}'>Save Details</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                        </section>
                                                    </div>
                                                    <div class="tab-pane fade" id="Show">
                                                        <div class="content">
                                                            <section class="content">
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <div class="box">
                                                                            <div class="box-header with-border">
                                                                                <h3 class="box-title"><strong>Expenses List</strong></h3>
                                                                            </div>
                                                                            <div class="box-body table-responsive">
                                                                                <table id="<?php echo $AccExpenList["fields"][0]; ?>" class="table table-bordered table-striped">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>#</th>
                                                                                            <th>Name</th>
                                                                                            <th>Amount</th>
                                                                                            <th>Pay Date</th>
                                                                                            <th>Description</th>
                                                                                            <th>Edit</th>
                                                                                            <th>Delete</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="<?php echo $AccExpenList["fields"][1]; ?>">
                                                                                    </tbody>
                                                                                </table>
                                                                            </div><!-- /.box-body -->
                                                                        </div><!-- /.box -->
                                                                    </div><!-- /.col -->
                                                                </div><!-- /.row -->
                                                            </section><!-- /.content -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                        </section>
                                </div>
                                <div class="tab-pane fade" id="Show">
                                    <div class="content">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title with-border"><strong>Expenses List</strong></h3>
                                                        </div>
                                                        <div class="box-body table-responsive">
                                                            <table id="<?php echo $AccExpenList["fields"][0]; ?>" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Name</th>
                                                                        <th>Amount</th>
                                                                        <th>Pay Date</th>
                                                                        <th>Description</th>
                                                                        <th>Edit</th>
                                                                        <th>Delete</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="<?php echo $AccExpenList["fields"][1]; ?>">
                                                                </tbody>
                                                            </table>
                                                        </div><!-- /.box-body -->
                                                    </div><!-- /.box -->
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->
                                        </section><!-- /.content -->
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>
