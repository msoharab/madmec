<?php
$addCol = isset($this->idHolders["tamboola"]["collection"]["AddClient"]) ? (array) $this->idHolders["tamboola"]["collection"]["AddClient"] : false;
$listCol = isset($this->idHolders["tamboola"]["collection"]["ListClient"]) ? (array) $this->idHolders["tamboola"]["collection"]["ListClient"] : false;
$curDue = isset($this->idHolders["tamboola"]["collection"]["Dues"]["CurrentDue"]) ? (array) $this->idHolders["tamboola"]["collection"]["Dues"]["CurrentDue"] : false;
$pendDue = isset($this->idHolders["tamboola"]["collection"]["Dues"]["PendingDue"]) ? (array) $this->idHolders["tamboola"]["collection"]["Dues"]["PendingDue"] : false;
$expDue = isset($this->idHolders["tamboola"]["collection"]["Dues"]["ExpiredDue"]) ? (array) $this->idHolders["tamboola"]["collection"]["Dues"]["ExpiredDue"] : false;
$curFol = isset($this->idHolders["tamboola"]["collection"]["FollowUp"]["CurrentFollow"]) ? (array) $this->idHolders["tamboola"]["collection"]["FollowUp"]["CurrentFollow"] : false;
$pendFol = isset($this->idHolders["tamboola"]["collection"]["FollowUp"]["PendingFollow"]) ? (array) $this->idHolders["tamboola"]["collection"]["FollowUp"]["PendingFollow"] : false;
$expFol = isset($this->idHolders["tamboola"]["collection"]["FollowUp"]["ExpiredFollow"]) ? (array) $this->idHolders["tamboola"]["collection"]["FollowUp"]["ExpiredFollow"] : false;
?>
<!-- Enquiry add -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Collection
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Collection</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content">
                    <div class="row output-panels" id="pCollection">
                        <ul class="nav nav-tabs" id="colls_menu">
                            <li class="active"><a href="#add_colls" data-toggle="tab" id="addcollection">Add Collection</a></li>
                            <li><a href="#list_colls" data-toggle="tab" id="listcollsbut">List Collections</a></li>
                            <li><a href="#list_dues" data-toggle="tab" id="listdues">Dues</a></li>
                            <li><a href="#list_follow" data-toggle="tab" id="listfollowup">Follow Up</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="add_colls">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title"><strong>Add Collections</strong></h3>
                                                </div>
                                                <div class="box-body" id="userbox">
                                                    <form class="form-horizontal"
                                                          action=""
                                                          id="<?php echo $addCol["form"]; ?>"
                                                          name="<?php echo $addCol["form"]; ?>"
                                                          method="post">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputphone" class="col-sm-1 control-label">Payer</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $addCol["fields"][0]; ?>"
                                                                               name="<?php echo $addCol["fields"][0]; ?>"
                                                                               maxlength="15"
                                                                               placeholder="Payer" />
                                                                    </div>
                                                                    <label for="inputphone" class="col-sm-1 control-label">Validity</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $addCol["fields"][1]; ?>"
                                                                               name="<?php echo $addCol["fields"][1]; ?>"
                                                                               maxlength="15"
                                                                               placeholder="Validity" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputregfee" class="col-sm-1 control-label">Total Amount</label>
                                                                    <div class="col-sm-5">
                                                                        <input name="<?php echo $addCol["fields"][6]; ?>"
                                                                               type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $addCol["fields"][6]; ?>"
                                                                               placeholder="0">
                                                                    </div>
                                                                    <label for="inputsertax" class="col-sm-1 control-label">Amount Paid</label>
                                                                    <div class="col-sm-5">
                                                                        <input name="<?php echo $addCol["fields"][7]; ?>"
                                                                               type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $addCol["fields"][7]; ?>"
                                                                               placeholder="0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputregfee" class="col-sm-1 control-label">Amount Due</label>
                                                                    <div class="col-sm-11">
                                                                        <input name="<?php echo $addCol["fields"][8]; ?>"
                                                                               type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $addCol["fields"][8]; ?>"
                                                                               placeholder="0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Payments</strong></h3>
                                            <div class="box-tools pull-right">
                                                <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                            </div><!-- /.box-tools -->
                                        </div>
                                        <div class="box-body" id="addbox">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputgymtype" class="col-sm-1 control-label">Mode Of Payment</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-control"
                                                                id="<?php echo $addCol["fields"][2]; ?>"
                                                                name="<?php echo $addCol["fields"][2]; ?>">
                                                            <option value="selectVal" selected>Mode Of Payment</option>
                                                            <option value="By Debit card">By Debit card</option>
                                                            <option value="check">Checks</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputregfee" class="col-sm-1 control-label">Payment Date</label>
                                                    <div class="col-sm-5">
                                                        <input name="<?php echo $addCol["fields"][3]; ?>"
                                                               type="text"
                                                               class="form-control"
                                                               id="<?php echo $addCol["fields"][3]; ?>"
                                                               placeholder="Payment Date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputregfee" class="col-sm-1 control-label">Subscribe Date</label>
                                                    <div class="col-sm-5">
                                                        <input name="<?php echo $addCol["fields"][4]; ?>"
                                                               type="text"
                                                               class="form-control"
                                                               id="<?php echo $addCol["fields"][4]; ?>"
                                                               placeholder="Subscribe Date">
                                                    </div>
                                                    <label for="inputregfee" class="col-sm-1 control-label">Due Date</label>
                                                    <div class="col-sm-5">
                                                        <input name="<?php echo $addCol["fields"][5]; ?>"
                                                               type="text"
                                                               class="form-control"
                                                               id="<?php echo $addCol["fields"][5]; ?>"
                                                               placeholder="Due Date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputsertax" class="col-sm-1 control-label">Remarks</label>
                                                    <div class="col-sm-11">
                                                        <textarea class="form-control"
                                                                  id="<?php echo $addCol["fields"][9]; ?>"
                                                                  name="<?php echo $addCol["fields"][9]; ?>"
                                                                  rows="5"
                                                                  placeholder="Remarks"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-6 col-sm-11">
                                            <button type="submit"
                                                    class="btn btn-primary col-sm-1"
                                                    id="<?php echo $addCol["fields"][10]; ?>"
                                                    name="<?php echo $addCol["fields"][10]; ?>"
                                                    data-rules='{}'
                                                    data-messages='{}'>Pay</button>
                                        </div>
                                    </div>
                                    </form>
                            </div>
                            <div class="tab-pane fade" id="list_colls">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title"><strong>Collections List</strong></h3>
                                                </div>
                                                <div class="box-body table-responsive">
                                                    <table id="<?php echo $listCol["fields"][0]; ?>" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Date</th>
                                                                <th>Owner Name</th>
                                                                <th>Amount</th>
                                                                <th>Remark</th>
                                                                <th>Mode of Payment</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="<?php echo $listCol["fields"][1]; ?>">
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>
                            <div class="tab-pane fade" id="list_dues">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="box box-solid">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Dues</h3>
                                                    <div class="box-tools">
                                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body no-padding">
                                                    <ul class="nav nav-pills nav-stacked">
                                                        <li class="active">
                                                            <a href="#curr" data-toggle="tab">
                                                                <i class="fa fa-arrow-right"></i>
                                                                Current
                                                                <span class="label label-primary pull-right">&nbsp;</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#pend" data-toggle="tab">
                                                                <i class="fa fa-arrow-right"></i>
                                                                Pending
                                                                <span class="label label-primary pull-right">&nbsp;</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#expi" data-toggle="tab">
                                                                <i class="fa fa-arrow-right"></i>
                                                                Expired
                                                                <span class="label label-primary pull-right">&nbsp;</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div><!-- /.box-body -->
                                            </div><!-- /. box -->
                                        </div><!-- /.col -->
                                        <div class="col-md-9">
                                            <div class="tab-content">
                                                <div class="active tab-pane" id="curr">
                                                    <section class="content">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="box">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title"><strong>Current Dues</strong></h3>
                                                                    </div>
                                                                    <div class="box-body table-responsive">
                                                                        <table id="<?php echo $curDue["fields"][0]; ?>" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>User Type</th>
                                                                                    <th>Minimum Balance</th>
                                                                                    <th>Date</th>
                                                                                    <th>Edit</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="<?php echo $curDue["fields"][1]; ?>">
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- /.box-body -->
                                                                </div><!-- /.box -->
                                                            </div><!-- /.col -->
                                                        </div><!-- /.row -->
                                                    </section><!-- /.content -->
                                                </div>
                                                <!-- /.tab-content -->
                                                <div class="tab-pane" id="pend">
                                                    <section class="content">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="box">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title"><strong>Pending Dues</strong></h3>
                                                                    </div>
                                                                    <div class="box-body table-responsive">
                                                                        <table id="<?php echo $pendDue["fields"][0]; ?>" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>User Type</th>
                                                                                    <th>Minimum Balance</th>
                                                                                    <th>Date</th>
                                                                                    <th>Edit</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="<?php echo $pendDue["fields"][1]; ?>">
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- /.box-body -->
                                                                </div><!-- /.box -->
                                                            </div><!-- /.col -->
                                                        </div><!-- /.row -->
                                                    </section><!-- /.content -->
                                                </div>
                                                <!-- currency -->
                                                <div class="tab-pane" id="expi">
                                                    <section class="content">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="box">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title"><strong> Expired Dues</strong></h3>
                                                                    </div>
                                                                    <div class="box-body table-responsive">
                                                                        <table id="<?php echo $expDue["fields"][0]; ?>" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>User Type</th>
                                                                                    <th>Minimum Balance</th>
                                                                                    <th>Date</th>
                                                                                    <th>Edit</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="<?php echo $expDue["fields"][1]; ?>">
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- /.box-body -->
                                                                </div><!-- /.box -->
                                                            </div><!-- /.col -->
                                                        </div><!-- /.row -->
                                                    </section><!-- /.content -->
                                                </div>
                                            </div>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>
                            <div class="tab-pane fade" id="list_follow">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="box box-solid">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Follow Up's</h3>
                                                    <div class="box-tools">
                                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body no-padding">
                                                    <ul class="nav nav-pills nav-stacked">
                                                        <li class="active">
                                                            <a href="#info" data-toggle="tab">
                                                                <i class="fa fa-arrow-right"></i>
                                                                Current
                                                                <span class="label label-primary pull-right">&nbsp;</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#bank" data-toggle="tab">
                                                                <i class="fa fa-arrow-right"></i>
                                                                Pending
                                                                <span class="label label-primary pull-right">&nbsp;</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#currency" data-toggle="tab">
                                                                <i class="fa fa-arrow-right"></i>
                                                                Expired
                                                                <span class="label label-primary pull-right">&nbsp;</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div><!-- /.box-body -->
                                            </div><!-- /. box -->
                                        </div><!-- /.col -->
                                        <div class="col-md-9">
                                            <div class="tab-content">
                                                <div class="active tab-pane" id="info">
                                                    <section class="content">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="box">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title"><strong>Current Follow Up</strong></h3>
                                                                    </div>
                                                                    <div class="box-body table-responsive">
                                                                        <table id="<?php echo $curFol["fields"][0]; ?>" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>User Type</th>
                                                                                    <th>Minimum Balance</th>
                                                                                    <th>Date</th>
                                                                                    <th>Edit</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="<?php echo $curFol["fields"][1]; ?>">
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- /.box-body -->
                                                                </div><!-- /.box -->
                                                            </div><!-- /.col -->
                                                        </div><!-- /.row -->
                                                    </section><!-- /.content -->
                                                </div>
                                                <!-- /.tab-content -->
                                                <div class="tab-pane" id="bank">
                                                    <section class="content">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="box">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title"><strong>Pending Follow Up</strong></h3>
                                                                    </div>
                                                                    <div class="box-body table-responsive">
                                                                        <table id="<?php echo $pendFol["fields"][0]; ?>" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>User Type</th>
                                                                                    <th>Minimum Balance</th>
                                                                                    <th>Date</th>
                                                                                    <th>Edit</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="<?php echo $pendFol["fields"][1]; ?>">
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- /.box-body -->
                                                                </div><!-- /.box -->
                                                            </div><!-- /.col -->
                                                        </div><!-- /.row -->
                                                    </section><!-- /.content -->
                                                </div>
                                                <!-- currency -->
                                                <div class="tab-pane" id="currency">
                                                    <section class="content">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="box">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title"><strong>Expired Follow Up</strong></h3>
                                                                    </div>
                                                                    <div class="box-body table-responsive">
                                                                        <table id="<?php echo $expFol["fields"][0]; ?>" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>User Type</th>
                                                                                    <th>Minimum Balance</th>
                                                                                    <th>Date</th>
                                                                                    <th>Edit</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="<?php echo $expFol["fields"][1]; ?>">
                                                                            </tbody>
                                                                        </table>
                                                                    </div><!-- /.box-body -->
                                                                </div><!-- /.box -->
                                                            </div><!-- /.col -->
                                                        </div><!-- /.row -->
                                                    </section><!-- /.content -->
                                                </div>
                                            </div>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>
                            <div class="col-lg-12" id="colls_message"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
