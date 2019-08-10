<?php
$AccStaff = isset($this->idHolders["tamboola"]["accounts"]["StaffPay"]) ? (array) $this->idHolders["tamboola"]["accounts"]["StaffPay"] : false;
$AccStaffList = isset($this->idHolders["tamboola"]["accounts"]["StaffPay"]) ? (array) $this->idHolders["tamboola"]["accounts"]["StaffPay"] : false;
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
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tab-content">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title"><strong>Staff Payments</strong></h3>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#Add" data-toggle="tab" id="Addfacility">Add Payments</a>
                                </li>
                                <li>
                                    <a href="#Show" data-toggle="tab" id="Showfacility">List Payments</a>
                                </li>
                            </ul><!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="Add">
                                    <form class="form-horizontal" action=""
                                          id="<?php echo $AccStaff["form"]; ?>"
                                          name="<?php echo $AccStaff["form"]; ?>"
                                          method="post">
                                        <section class="content">
                                            <div class="box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title with-border"><strong>Add Payments</strong></h3>
                                                </div>
                                                <div class="box-body" id="userbox">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputgymName" class="col-sm-3 control-label">Name</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text" 
                                                                           class="form-control" 
                                                                           id="<?php echo $AccStaff["fields"][0]; ?>" 
                                                                           name="<?php echo $AccStaff["fields"][0]; ?>" 
                                                                           data-rules='{"required": true,"maxlength":"100"}'
                                                                           data-messages='{"required": "Enter Name/Email ID/Cell number","maxlength":"maximum 100 characters allowed"}'
                                                                           placeholder="Name - Email Id - Cell Number of the staff">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputgymName" class="col-sm-3 control-label">Amount</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="<?php echo $AccStaff["fields"][1]; ?>"
                                                                           name="<?php echo $AccStaff["fields"][1]; ?>"
                                                                           data-rules='{"required": true,"maxlength":"100"}'
                                                                           data-messages='{"required": "Enter Amount","maxlength":"maximum 100 characters allowed"}'
                                                                           placeholder="Amount">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputregfee" class="col-sm-3 control-label">Date</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           name="<?php echo $AccStaff["fields"][2]; ?>"
                                                                           id="<?php echo $AccStaff["fields"][2]; ?>"
                                                                           data-rules='{"required": true}'
                                                                           data-messages='{"required": "Enter Date"}'
                                                                           readonly="readonly">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputsertax" class="col-sm-3 control-label">Description</label>
                                                                <div class="col-sm-6">
                                                                    <textarea class="form-control"
                                                                              id="<?php echo $AccStaff["fields"][3]; ?>"
                                                                              name="<?php echo $AccStaff["fields"][3]; ?>"
                                                                              rows="8"
                                                                              data-rules='{"required": true}'
                                                                              data-messages='{"required": "Enter Description"}'
                                                                              placeholder="Description"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-5 col-sm-11">
                                                            <button type="submit"
                                                                    class="btn btn-primary"
                                                                    id="<?php echo $AccStaff["fields"][4]; ?>"
                                                                    name="<?php echo $AccStaff["fields"][4]; ?>"
                                                                    data-rules='{}'
                                                                    data-messages='{}'>Save Details</button>
                                                        </div>
                                                    </div>
                                                    </section>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="Show">
                                                    <section class="content">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="box">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title"><strong>Paymentst List</strong></h3>
                                                                    </div>
                                                                    <div class="box-body table-responsive">
                                                                        <table id="<?php echo $AccStaffList["fields"][0]; ?>" class="table table-bordered table-striped">
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
                                                                            <tbody id="<?php echo $AccStaffList["fields"][1]; ?>">
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
                                            </div>
                                        </section>
                                </div>
                                <<<<<<< .mine
                                =======
                                <div class="tab-pane fade" id="Show">
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title with-border"><strong>Paymentst List</strong></h3>
                                                    </div>
                                                    <div class="box-body table-responsive">
                                                        <table id="<?php echo $AccStaffList["fields"][0]; ?>" class="table table-bordered table-striped">
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
                                                            <tbody id="<?php echo $AccStaffList["fields"][1]; ?>">
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
                        >>>>>>> .r99
                    </div>
