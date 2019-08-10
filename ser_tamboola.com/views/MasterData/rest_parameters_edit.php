<?php
$AddPara = isset($this->idHolders["recharge"]["masterdata"]["EditRestParameter"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditRestParameter"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Rest Parameters
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Edit Rest Parameters</li>
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
                          id="<?php echo $AddPara["form"]; ?>"
                          name="<?php echo $AddPara["form"]; ?>"
                          method="post">
                        <div class="content">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <input type="hidden"
                                                       name="<?php echo $AddPara["fields"][4]; ?>"
                                                       id="<?php echo $AddPara["fields"][4]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->getuserDet["data"]["portal_rest_parameters_id"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusiness" class="col-sm-2 control-label">Parameter Field</label>
                                                        <div class="col-sm-9">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddPara["fields"][0]; ?>"
                                                                   name="<?php echo $AddPara["fields"][0]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_rest_parameters_field"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Parameter Field","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="Parameter Field" type="text" pattern="^[A-Za-z 0-9\-\.=:;]{3,100}$">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Meaning</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddPara["fields"][1]; ?>"
                                                                   name="<?php echo $AddPara["fields"][1]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_rest_parameters_meaning"]); ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter Parameter Meaning"}'
                                                                   placeholder="Meaning" type="text">
                                                        </div>
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Description</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddPara["fields"][2]; ?>"
                                                                   name="<?php echo $AddPara["fields"][2]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_rest_parameters_description"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Parameter Description","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="Description" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-5 col-sm-10">
                                                            <button type="submit"
                                                                    class="btn btn-danger"
                                                                    id="<?php echo $AddPara["fields"][3]; ?>"
                                                                    name="<?php echo $AddPara["fields"][3]; ?>"
                                                                    data-rules='{}'
                                                                    data-messages='{}'>Submit Details</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div><!-- /.tab-pane -->
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
        obj.__RestParamEdit();
    });
</script>