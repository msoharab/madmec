<?php
$rechBusiAdd = isset($this->idHolders["onlinefood"]["gateway"]["RechargeBusiness"]["AddGateway"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["RechargeBusiness"]["AddGateway"] : false;
$rechBusiAss = isset($this->idHolders["onlinefood"]["gateway"]["RechargeBusiness"]["AssignGateway"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["RechargeBusiness"]["AssignGateway"] : false;
$rechBusiSubs = isset($this->idHolders["onlinefood"]["gateway"]["RechargeBusiness"]["SubscirbeGateway"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["RechargeBusiness"]["SubscirbeGateway"] : false;
$rechBusiList = isset($this->idHolders["onlinefood"]["gateway"]["RechargeBusiness"]["ListGateway"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["RechargeBusiness"]["ListGateway"] : false;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Recharge Gateway
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Recharge</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#add" data-toggle="tab">Add Gateway</a></li>
                        <li><a href="#assign" data-toggle="tab">Assign Gateway</a></li>
                        <li><a href="#subs" data-toggle="tab">Subscription</a></li>
                        <li><a href="#list" data-toggle="tab">List Gateway</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="add">
                            <!-- Post -->
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $rechBusiAdd["form"]; ?>"
                                  name="<?php echo $rechBusiAdd["form"]; ?>"
                                  method="post">
                                <div class="content">
                                    <!-- Content Header (Page header) -->
                                    <section class="content-header">
                                        <h1>
                                            Add Gateway
                                        </h1>
                                    </section>
                                    <!-- Main content -->
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h3 class="box-title"></h3>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-2 control-label">Service</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control"
                                                                    id="<?php echo $rechBusiAdd["fields"][0]; ?>"
                                                                    name="<?php echo $rechBusiAdd["fields"][0]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Service"}'>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-2 control-label">Gateway Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                   id="<?php echo $rechBusiAdd["fields"][1]; ?>"
                                                                   name="<?php echo $rechBusiAdd["fields"][1]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter Gateway Name","name": "Enter Gateway name"}'"
                                                                   placeholder="Gateway Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-2 control-label">Company Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                   id="<?php echo $rechBusiAdd["fields"][2]; ?>"
                                                                   name="<?php echo $rechBusiAdd["fields"][2]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter Company Name","name": "Enter Company name"}'"
                                                                   placeholder="Company Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox"
                                                                           data-rules='{"required": true}'
                                                                           data-messages='{"required": "Please agree Terms & Conditions"}'
                                                                           id="<?php echo $rechBusiAdd["fields"][3]; ?>"
                                                                           name="<?php echo $rechBusiAdd["fields"][3]; ?>"> I agree to the <a href="#">terms and conditions</a>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit"
                                                                    id="<?php echo $rechBusiAdd["fields"][4]; ?>"
                                                                    name="<?php echo $rechBusiAdd["fields"][4]; ?>"
                                                                    data-rules='{}'
                                                                    data-messages='{}'
                                                                    class="btn btn-danger">Add Gateway</button>
                                                        </div>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </section><!-- /.content -->
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="assign">
                            <!-- The timeline -->
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $rechBusiAss["form"]; ?>"
                                  name="<?php echo $rechBusiAss["form"]; ?>"
                                  method="post">
                                <div class="content">
                                    <!-- Content Header (Page header) -->
                                    <section class="content-header">
                                        <h1>
                                            Assign Gateway
                                        </h1>
                                    </section>
                                    <!-- Main content -->
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h3 class="box-title"></h3>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-2 control-label">User Type</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control"
                                                                    id="<?php echo $rechBusiAss["fields"][0]; ?>"
                                                                    name="<?php echo $rechBusiAss["fields"][0]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select User Type"}'>
                                                                <option>Sub Admin</option>
                                                                <option> API </option>
                                                                <option>Super Distributor </option>
                                                                <option>Distributor</option>
                                                                <option>Sub Distributor</option>
                                                                <option>Retailer</option>
                                                                <option>Sub Retailer</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-2 control-label">Gateway</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control"
                                                                    id="<?php echo $rechBusiAss["fields"][1]; ?>"
                                                                    name="<?php echo $rechBusiAss["fields"][1]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Gateway"}'>
                                                                <option>Online Food Order</option>
                                                                <option>Specific Step</option>
                                                                <option>Ghar Ka Bill</option>
                                                                <option>Dummy </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit"
                                                                    id="<?php echo $rechBusiAss["fields"][2]; ?>"
                                                                    name="<?php echo $rechBusiAss["fields"][2]; ?>"
                                                                    data-rules='{}'
                                                                    data-messages='{}'
                                                                    class="btn btn-primary">Activate</button>
                                                            <button type="submit"
                                                                    id="<?php echo $rechBusiAss["fields"][3]; ?>"
                                                                    name="<?php echo $rechBusiAss["fields"][3]; ?>"
                                                                    data-rules='{}'
                                                                    data-messages='{}'
                                                                    class="btn btn-danger">Deactivate</button>
                                                        </div>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </section><!-- /.content -->
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="subs">
                            <!-- The timeline -->
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $rechBusiSubs["form"]; ?>"
                                  name="<?php echo $rechBusiSubs["form"]; ?>"
                                  method="post">
                                <div class="content">
                                    <!-- Content Header (Page header) -->
                                    <section class="content-header">
                                        <h1>
                                            Subscribe
                                        </h1>
                                    </section>
                                    <!-- Main content -->
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h3 class="box-title"></h3>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-2 control-label">Service</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control"
                                                                    id="<?php echo $rechBusiSubs["fields"][0]; ?>"
                                                                    name="<?php echo $rechBusiSubs["fields"][0]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Service"}'>
                                                                <option>Select</option>
                                                                <option>Recharge</option>
                                                                <option>Postpaid Recharge</option>
                                                                <option>Bulk SMS</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputsubs" class="col-sm-2 control-label">Subscription</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control"
                                                                    id="<?php echo $rechBusiSubs["fields"][1]; ?>"
                                                                    name="<?php echo $rechBusiSubs["fields"][1]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Subscription"}'>
                                                                <option>Select</option>
                                                                <option>Weekly</option>
                                                                <option>Monthly</option>
                                                                <option>Annual</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputamount" class="col-sm-2 control-label">Amount Paid</label>
                                                        <div class="col-sm-10">
                                                            <input type="number"
                                                                   class="form-control dropdown"
                                                                   id="<?php echo $rechBusiSubs["fields"][2]; ?>"
                                                                   name="<?php echo $rechBusiSubs["fields"][2]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter the Amount"}'
                                                                   placeholder="Amount">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit"
                                                                    id="<?php echo $rechBusiSubs["fields"][3]; ?>"
                                                                    name="<?php echo $rechBusiSubs["fields"][3]; ?>"
                                                                    data-rules='{}'
                                                                    data-messages='{}'
                                                                    class="btn btn-danger">Subscribe</button>
                                                        </div>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </section><!-- /.content -->
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="list">
                            <div class="content">
                                <!-- Content Header (Page header) -->
                                <section class="content-header">
                                    <h1>
                                        List Gateways
                                    </h1>
                                </section>
                                <!-- Main content -->
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-header">
                                                    <h3 class="box-title"></h3>
                                                </div><!-- /.box-header -->
                                                <div class="box-body table-responsive" id="<?php echo $rechBusiList["fields"][0]; ?>">
                                                    <table id="example1" class="table table-bordered
                                                           table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Gateway</th>
                                                                <th>Minimum Balance</th>
                                                                <th>Priority</th>
                                                                <th>Enable</th>
                                                                <th>Disable</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Online Food Order</td>
                                                                <td>10000</td>
                                                                <td>A</td>
                                                                <td><button type="submit" id="id" name="" class="btn btn-primary btn-block"><b>Enable</b></button></td>
                                                                <td><button type="submit" id="id" name="" class="btn btn-danger btn-block"><b>Disable</b></button></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Specific Step</td>
                                                                <td>5000</td>
                                                                <td>B</td>
                                                                <td><button type="submit" id="id" name="" class="btn btn-primary btn-block"><b>Enable</b></button></td>
                                                                <td><button type="submit" id="id" name="" class="btn btn-danger btn-block"><b>Disable</b></button></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ghar Ka Bill</td>
                                                                <td>5000</td>
                                                                <td>C</td>
                                                                <td><button type="submit" id="id" class="btn btn-primary btn-block"><b>Enable</b></button></td>
                                                                <td><button type="submit" id="id" class="btn btn-danger btn-block"><b>Disable</b></button></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Dummy</td>
                                                                <td>0</td>
                                                                <td>D</td>
                                                                <td><button type="submit" id="id" name="" class="btn btn-primary btn-block"><b>Enable</b></button></td>
                                                                <td><button type="submit" id="id" name="" class="btn btn-danger btn-block"><b>Disable</b></button></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        var this_js_script = $("script[src$='Recharge.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In RechargeGate');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'Recharge/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).onlinefood.rechargeGate;
                var obj = new rechargeController();
                obj.__constructor(para);
                obj.__AddGate();
            }
            else {
                LogMessages('I am Out RechargeGate');
            }
        }
    });