<?php
$serviceEdit = isset($this->idHolders["recharge"]["masterdata"]["EditService"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditService"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Service
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Service</li>
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
                          id="<?php echo $serviceEdit["form"]; ?>"
                          name="<?php echo $serviceEdit["form"]; ?>"
                          method="post">
                        <div class="box">
                            <div class="box-header with-border">
                                <strong></strong>
                            </div>
                            <div class="box-body">
                                <input type="hidden"
                                       name="<?php echo $serviceEdit["fields"][6]; ?>"
                                       id="<?php echo $serviceEdit["fields"][6]; ?>"
                                       data-rules='{}'
                                       data-messages='{}'
                                       value="<?php echo base64_encode($this->getuserDet["data"]["services_id"]); ?>" />
                                <div class="col-sm-12 ">
                                    <div class="form-group">
                                        <label for="inputcomp" class="col-sm-2 control-label">Company</label>
                                        <div class="col-sm-8">
                                            <select class="form-control"
                                                    id="<?php echo $serviceEdit["fields"][0]; ?>"
                                                    name="<?php echo $serviceEdit["fields"][0]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Company"}'>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-1 control-label">Service Name</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $serviceEdit["fields"][1]; ?>"
                                                   name="<?php echo $serviceEdit["fields"][1]; ?>"
                                                   value="<?php echo trim($this->getuserDet["data"]["services_name"]); ?>"
                                                   data-rules='{"required": true}'
                                                   data-messages='{"required": "Enter Service Name"}'
                                                   placeholder="Service Name">
                                        </div>
                                        <label for="inputType" class="col-sm-1 control-label">Service LT code</label>
                                        <div class="col-sm-5">
                                            <input  type="text"
                                                    class="form-control"
                                                    id="<?php echo $serviceEdit["fields"][2]; ?>"
                                                    name="<?php echo $serviceEdit["fields"][2]; ?>"
                                                    value="<?php echo trim($this->getuserDet["data"]["services_lt_code"]); ?>"
                                                    data-rules='{"required": true,"minlength":"2"}'
                                                    data-messages='{"required": "Enter Service LT code","minlength":"Length Should be minimum 2 Characters"}'
                                                    placeholder="Service LT code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-1 control-label">Flat Commission</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $serviceEdit["fields"][3]; ?>"
                                                   name="<?php echo $serviceEdit["fields"][3]; ?>"
                                                   value="<?php echo trim($this->getuserDet["data"]["services_commission_fixed"]); ?>"
                                                   data-rules='{"required": true}'
                                                   data-messages='{"required": "Enter Flat Commission"}'
                                                   placeholder="Flat Commission">
                                        </div>
                                        <label for="inputType" class="col-sm-1 control-label">Variable Commission</label>
                                        <div class="col-sm-5">
                                            <input  type="text"
                                                    class="form-control"
                                                    id="<?php echo $serviceEdit["fields"][4]; ?>"
                                                    name="<?php echo $serviceEdit["fields"][4]; ?>"
                                                    value="<?php echo trim($this->getuserDet["data"]["services_commission_variable"]); ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Enter Variable Commission"}'
                                                    placeholder="Variable Commission">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="text-center">
                                        <button type="submit"
                                                id="<?php echo $serviceEdit["fields"][5]; ?>"
                                                name="<?php echo $serviceEdit["fields"][5]; ?>"
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
        obj.__ServiceEdit();
    });
</script>