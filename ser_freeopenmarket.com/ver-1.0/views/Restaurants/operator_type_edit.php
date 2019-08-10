<?php
$optype = isset($this->idHolders["recharge"]["masterdata"]["EditOperatorType"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditOperatorType"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Operator Type
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Operator Type</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit</h3>
                    </div><!-- /.box-header -->
                    <form class="form-horizontal"
                          action=""
                          id="<?php echo $optype["form"]; ?>"
                          name="<?php echo $optype["form"]; ?>"
                          method="post">
                        <div class="box">
                            <div class="box-header with-border">
                                <section class="content-header">
                                    <h1>
                                        Operator Type
                                    </h1>
                                </section>
                            </div>
                            <div class="box-body">
                                <input type="hidden"
                                       name="<?php echo $optype["fields"][6]; ?>"
                                       id="<?php echo $optype["fields"][6]; ?>"
                                       data-rules='{}'
                                       data-messages='{}'
                                       value="<?php echo base64_encode($this->getuserDet["data"]["operator_type_id"]); ?>" />
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputservicee" class="col-sm-3 control-label">Operator</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $optype["fields"][0]; ?>"
                                                    name="<?php echo $optype["fields"][0]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Operator"}'>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputType" class="col-sm-1 control-label">Operator type</label>
                                        <div class="col-sm-5">
                                            <input  type="text"
                                                    class="form-control"
                                                    id="<?php echo $optype["fields"][1]; ?>"
                                                    name="<?php echo $optype["fields"][1]; ?>"
                                                    value="<?php echo trim($this->getuserDet["data"]["operator_type_type"]); ?>"
                                                    data-rules='{"required": true,"minlength":"3"}'
                                                    data-messages='{"required": "Enter Operator type","minlength":"Length Should be minimum 3 Characters"}'
                                                    placeholder="Operator type">
                                        </div>
                                        <label for="inputservicee" class="col-sm-1 control-label">Operator LT Code</label>
                                        <div class="col-sm-5">
                                            <input  type="text"
                                                    class="form-control"
                                                    id="<?php echo $optype["fields"][2]; ?>"
                                                    name="<?php echo $optype["fields"][2]; ?>"
                                                    value="<?php echo trim($this->getuserDet["data"]["operator_type_lt_code"]); ?>"
                                                    data-rules='{"required": true,"minlength":"2"}'
                                                    data-messages='{"required": "Enter Operator LT Code","minlength":"Length Should be minimum 2 Characters"}'
                                                    placeholder="Operator LT Code">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-1 control-label">Flat Commission</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $optype["fields"][3]; ?>"
                                                   name="<?php echo $optype["fields"][3]; ?>"
                                                   value="<?php echo trim($this->getuserDet["data"]["operator_type_commission_fixed"]); ?>"
                                                   data-rules='{"required": true}'
                                                   data-messages='{"required": "Enter Flat Commission"}'
                                                   placeholder="Flat Commission">
                                        </div>
                                        <label for="inputType" class="col-sm-1 control-label">Variable Commission</label>
                                        <div class="col-sm-5">
                                            <input  type="text"
                                                    class="form-control"
                                                    id="<?php echo $optype["fields"][4]; ?>"
                                                    name="<?php echo $optype["fields"][4]; ?>"
                                                    value="<?php echo trim($this->getuserDet["data"]["operator_type_commission_variable"]); ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Enter Variable Commission"}'
                                                    placeholder="Variable Commission">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="text-center">
                                        <button type="submit"
                                                id="<?php echo $optype["fields"][5]; ?>"
                                                name="<?php echo $optype["fields"][5]; ?>"
                                                data-rules='{}'
                                                data-messages='{}'
                                                class="btn btn-danger">Update Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /. box -->
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'MasterData/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).tamboola.masterdata;
        var obj = new masterdataController();
        obj.__constructor(para);
        obj.__OperatorTypeEdit();
    });
</script>
