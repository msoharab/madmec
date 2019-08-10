<?php
$userVarComm = isset($this->idHolders["tamboola"]["user"]["Commission"]["ViariableCommission"]) ? (array) $this->idHolders["tamboola"]["user"]["Commission"]["ViariableCommission"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Commission
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Edit Commission</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" id="variableCommDetailsForm" name="">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Service Type</label>
                        <div class="col-sm-10">
                            <select class="form-control"
                                    id="<?php echo $userVarComm["fields"][0]; ?>"
                                    name="<?php echo $userVarComm["fields"][0]; ?>"
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
                                    id="<?php echo $userVarComm["fields"][1]; ?>"
                                    name="<?php echo $userVarComm["fields"][1]; ?>"
                                    data-rules='{"required": true}'
                                    data-messages='{"required": "Select Gateway"}'>
                                <option>Select </option>
                                <option>Local Talent</option>
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
                                    id="<?php echo $userVarComm["fields"][2]; ?>"
                                    name="<?php echo $userVarComm["fields"][2]; ?>"
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
                                   id="<?php echo $userVarComm["fields"][3]; ?>"
                                   name="<?php echo $userVarComm["fields"][3]; ?>"
                                   data-rules='{"required": true}'
                                   data-messages='{"required": "Enter Commission"}'
                                   placeholder="Commission">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Service Charge</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control"
                                   id="<?php echo $userVarComm["fields"][4]; ?>"
                                   name="<?php echo $userVarComm["fields"][4]; ?>"
                                   data-rules='{"required": true}'
                                   data-messages='{"required": "Enter Service Charge"}'
                                   placeholder="Service Charge">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit"
                                    id="<?php echo $userVarComm["fields"][5]; ?>"
                                    name="<?php echo $userVarComm["fields"][5]; ?>"
                                    data-rules='{}'
                                    data-messages='{}'
                                    class="btn btn-danger">Set Commission</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /. box -->
        </div>
    </section>
</div>
