<?php
$ops = isset($this->idHolders["onlinefood"]["gateway"]["EditOperator"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["EditOperator"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Operator
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Edit Operator </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $ops["form"]; ?>"
                      name="<?php echo $ops["form"]; ?>"
                      method="post">
                    <div class="box">
                        <div class="box-header with-border">
                            <section class="content-header">
                                <h1>
                                    Gateway Operator
                                </h1>
                            </section>
                        </div>
                        <div class="box-body">
                            <input type="hidden"
                                   name="<?php echo $ops["fields"][7]; ?>"
                                   id="<?php echo $ops["fields"][7]; ?>"
                                   data-rules='{}'
                                   data-messages='{}'
                                   value="<?php echo base64_encode($this->getuserDet["data"]["gateway_operator_id"]); ?>" />
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputservicee" class="col-sm-1 control-label">Gateway</label>
                                    <div class="col-sm-5">
                                        <select class="form-control"
                                                id="<?php echo $ops["fields"][0]; ?>"
                                                name="<?php echo $ops["fields"][0]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select Gateway"}'>
                                        </select>
                                    </div>
                                    <label for="inputType" class="col-sm-1 control-label">Operator name</label>
                                    <div class="col-sm-5">
                                        <input  type="text"
                                                class="form-control"
                                                id="<?php echo $ops["fields"][1]; ?>"
                                                name="<?php echo $ops["fields"][1]; ?>"
                                                value="<?php echo trim($this->getuserDet["data"]["gateway_operator_name"]); ?>"
                                                data-rules='{"required": true,"minlength": "4"}'
                                                data-messages='{"required": "Enter Operator name","minlength": "Length Should be minimum 4 Characters"}'
                                                placeholder="Operator name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputservicee" class="col-sm-1 control-label">Operator Code</label>
                                    <div class="col-sm-5">
                                        <input  type="text"
                                                class="form-control"
                                                id="<?php echo $ops["fields"][2]; ?>"
                                                name="<?php echo $ops["fields"][2]; ?>"
                                                value="<?php echo trim($this->getuserDet["data"]["gateway_operator_lt_code"]); ?>"
                                                data-rules='{"required": true,"minlength": "2"}'
                                                data-messages='{"required": "Enter Operator Code","minlength": "Length Should be minimum 2 Characters"}'
                                                placeholder="Operator Code">
                                    </div>
                                    <label for="inputType" class="col-sm-1 control-label">Operator Alias</label>
                                    <div class="col-sm-5">
                                        <input  type="text"
                                                class="form-control"
                                                id="<?php echo $ops["fields"][3]; ?>"
                                                name="<?php echo $ops["fields"][3]; ?>"
                                                value="<?php echo trim($this->getuserDet["data"]["gateway_operator_alias"]); ?>"
                                                data-rules='{"required": true,"minlength": "3"}'
                                                data-messages='{"required": "Enter Operator Alias","minlength": "Length Should be minimum 3 Characters"}'
                                                placeholder="Operator Alias">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-1 control-label">Flat Commission</label>
                                    <div class="col-sm-5">
                                        <input type="text"
                                               class="form-control"
                                               id="<?php echo $ops["fields"][4]; ?>"
                                               name="<?php echo $ops["fields"][4]; ?>"
                                               value="<?php echo trim($this->getuserDet["data"]["gateway_operator_commission_fixed"]); ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Flat Commission"}'
                                               placeholder="Flat Commission">
                                    </div>
                                    <label for="inputType" class="col-sm-1 control-label">Variable Commission</label>
                                    <div class="col-sm-5">
                                        <input  type="text"
                                                class="form-control"
                                                id="<?php echo $ops["fields"][5]; ?>"
                                                name="<?php echo $ops["fields"][5]; ?>"
                                                value="<?php echo trim($this->getuserDet["data"]["gateway_operator_commission_variable"]); ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Enter Variable Commission"}'
                                                placeholder="Variable Commission">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 form-group">
                                <div class="text-center">
                                    <button type="submit"
                                            id="<?php echo $ops["fields"][6]; ?>"
                                            name="<?php echo $ops["fields"][6]; ?>"
                                            data-rules='{}'
                                            data-messages='{}'
                                            class="btn btn-danger">Update Operator</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.row -->
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'Gateway/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).onlinefood.gateway;
        var obj = new gatewayController();
        obj.__constructor(para);
        obj.__OperatorEdit();
    });
</script>