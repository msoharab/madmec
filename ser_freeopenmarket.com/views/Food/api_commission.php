<?php
$apiFixComm = isset($this->idHolders["onlinefood"]["api"]["ApiCommission"]["FixedCommission"]) ? (array) $this->idHolders["onlinefood"]["api"]["ApiCommission"]["FixedCommission"] : false;
$apiVarComm = isset($this->idHolders["onlinefood"]["api"]["ApiCommission"]["ViariableCommission"]) ? (array) $this->idHolders["onlinefood"]["api"]["ApiCommission"]["ViariableCommission"] : false;
$apiCommList = isset($this->idHolders["onlinefood"]["api"]["ApiCommission"]["ListCommission"]) ? (array) $this->idHolders["onlinefood"]["api"]["ApiCommission"]["ListCommission"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            API User Commission
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Api User Commission </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#setfixed" data-toggle="tab">Fixed Commission</a></li>
                        <li><a href="#setvariable" data-toggle="tab">Variable Commission</a></li>
                        <li><a href="#list" data-toggle="tab">Commission Details</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="setfixed">
                            <!-- The timeline -->
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $apiFixComm["form"]; ?>"
                                  name="<?php echo $apiFixComm["form"]; ?>"
                                  method="post">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Service</label>
                                    <div class="col-sm-10">
                                        <select class="form-control"
                                                id="<?php echo $apiFixComm["fields"][0]; ?>"
                                                name="<?php echo $apiFixComm["fields"][0]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select Service"}'>
                                            <option>Select</option>
                                            <option>Online Recharge</option>
                                            <option>PostPaid</option>
                                            <option>Bulk Sms</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Gateway</label>
                                    <div class="col-sm-10">
                                        <select class="form-control"
                                                id="<?php echo $apiFixComm["fields"][1]; ?>"
                                                name="<?php echo $apiFixComm["fields"][1]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select Gateway"}'>
                                            <option>Select </option>
                                            <option>Online Food Order</option>
                                            <option>Specific Step</option>
                                            <option>Ghar Ka Bill</option>
                                            <option>Dummy </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Commission</label>
                                    <div class="col-sm-10">
                                        <input type="number"
                                               class="form-control"
                                               id="<?php echo $apiFixComm["fields"][2]; ?>"
                                               name="<?php echo $apiFixComm["fields"][2]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Commission"'
                                               placeholder="commission">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Service Charge</label>
                                    <div class="col-sm-10">
                                        <input type="number"
                                               class="form-control"
                                               id="<?php echo $apiFixComm["fields"][3]; ?>"
                                               name="<?php echo $apiFixComm["fields"][3]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Service Charge"}'
                                               placeholder="Service Charge">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit"
                                                id="<?php echo $apiFixComm["fields"][4]; ?>"
                                                name="<?php echo $apiFixComm["fields"][4]; ?>"
                                                data-rules='{}'
                                                data-messages='{}'
                                                class="btn btn-danger">Set Commission</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="setvariable">
                            <!-- The timeline -->
                            <form class="form-horizontal" id="variableCommDetailsForm" name="">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Service Type</label>
                                    <div class="col-sm-10">
                                        <select class="form-control"
                                                id="<?php echo $apiVarComm["fields"][0]; ?>"
                                                name="<?php echo $apiVarComm["fields"][0]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select Service type"}'>
                                            <option>Select</option>
                                            <option>Online Recharge</option>
                                            <option>PostPaid</option>
                                            <option>Bulk Sms</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Gateway</label>
                                    <div class="col-sm-10">
                                        <select class="form-control"
                                                id="<?php echo $apiVarComm["fields"][1]; ?>"
                                                name="<?php echo $apiVarComm["fields"][1]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select Gateway"}'>
                                            <option>Select </option>
                                            <option>Online Food Order</option>
                                            <option>Specific Step</option>
                                            <option>Ghar Ka Bill</option>
                                            <option>Dummy </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Operator Type</label>
                                    <div class="col-sm-10">
                                        <select class="form-control"
                                                id="<?php echo $apiVarComm["fields"][2]; ?>"
                                                name="<?php echo $apiVarComm["fields"][2]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select Operator type"}'>
                                            <option>All</option>
                                            <option>Airtel</option>
                                            <option>Idea</option>
                                            <option>Airtel data card</option>
                                            <option>Dish Tv</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Commission</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control"
                                               id="<?php echo $apiVarComm["fields"][3]; ?>"
                                               name="<?php echo $apiVarComm["fields"][3]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Commission"}'
                                               placeholder="Commission">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Service Charge</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control"
                                               id="<?php echo $apiVarComm["fields"][4]; ?>"
                                               name="<?php echo $apiVarComm["fields"][4]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Service Charge"}'
                                               placeholder="Service Charge">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit"
                                                id="<?php echo $apiVarComm["fields"][5]; ?>"
                                                name="<?php echo $apiVarComm["fields"][5]; ?>"
                                                data-rules='{}'
                                                data-messages='{}'
                                                class="btn btn-danger">Set Commission</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="list">
                            <form class="form-horizontal">
                                <div class="content">
                                    <!-- Content Header (Page header) -->
                                    <section class="content-header">
                                        <h1>
                                            Commission Details
                                        </h1>
                                        <ol class="breadcrumb">
                                            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                                            <li><a href="#">Tables</a></li>
                                            <li class="active">Details</li>
                                        </ol>
                                    </section>
                                    <!-- Main content -->

                                    <section class="content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h3 class="box-title"></h3>
                                                    </div><!-- /.box-header -->
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-1 control-label">Gateway</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control"
                                                                    id="<?php echo $apiCommList["fields"][0]; ?>"
                                                                    name="<?php echo $apiCommList["fields"][0]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Gateway"}'>
                                                                <option>ALL </option>
                                                                <option>Online Food Order</option>
                                                                <option>Specific Step</option>
                                                                <option>Ghar Ka Bill</option>
                                                                <option>Dummy </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-1 col-sm-10">
                                                            <button type="submit"
                                                                    id="<?php echo $apiCommList["fields"][1]; ?>"
                                                                    name="<?php echo $apiCommList["fields"][1]; ?>"
                                                                    data-rules='{}'
                                                                    data-messages='{}'
                                                                    class="btn btn-primary">List Details</button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body table-responsive"
                                                         id="<?php echo $apiCommList["fields"][2]; ?>">
                                                        <table id="example1" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Service</th>
                                                                    <th>Gateway</th>
                                                                    <th>Service Type</th>
                                                                    <th>Operator</th>
                                                                    <th>RC Code</th>
                                                                    <th>Commission</th>
                                                                    <th>Service Charge</th>
                                                                    <th>Modify</th>
                                                                </tr>
                                                            </thead>
                                                             <tbody id="<?php echo $apiCommList["fields"][3]; ?>">
                                                            </tbody>
                                                        </table>
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </section><!-- /.content -->
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section>
</div>
