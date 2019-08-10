<?php
$Addrest = isset($this->idHolders["onlinefood"]["gateway"]["AddRest"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["AddRest"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Protocol Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Edit Protocol Details </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $Addrest["form"]; ?>"
                      name="<?php echo $Addrest["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content-header">
                            <h1>
                                Add REST
                                <small></small>
                            </h1>
                        </section>
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>REST Details</strong></h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body" id="userbox">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputgender" class="col-sm-1 control-label">URL</label>
                                                        <div class="col-sm-5">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   id="<?php echo $Addrest["fields"][0]; ?>"
                                                                   name="<?php echo $Addrest["fields"][0]; ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter URL","minlength": "Length Should be minimum 4 Characters"}'
                                                                   placeholder="URL">
                                                        </div>
                                                        <label for="inputgender" class="col-sm-1 control-label">Redirect URL</label>
                                                        <div class="col-sm-5">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   id="<?php echo $Addrest["fields"][0]; ?>"
                                                                   name="<?php echo $Addrest["fields"][0]; ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Redirect URL","minlength": "Length Should be minimum 4 Characters"}'
                                                                   placeholder="Redirect URL">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputmobile" class="col-sm-1 control-label">PORT</label>
                                                        <div class="col-sm-5">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   id="<?php echo $Addrest["fields"][1]; ?>"
                                                                   name="<?php echo $Addrest["fields"][1]; ?>"
                                                                   data-rules='{"required": true,"minlength": "2"}'
                                                                   data-messages='{"required": "Enter port number","minlength": "Length Should be 2 numbers"}'
                                                                   placeholder="Port">
                                                        </div>
                                                        <label for="inputusertype" class="col-sm-1 control-label">Protocol Type</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $Addrest["fields"][2]; ?>"
                                                                    name="<?php echo $Addrest["fields"][2]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select protocol type"}'>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputusertype" class="col-sm-1 control-label">REST Method</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $Addrest["fields"][3]; ?>"
                                                                    name="<?php echo $Addrest["fields"][3]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select REST method"}'>
                                                            </select>
                                                        </div>
                                                        <label for="inpu" class="col-sm-1 control-label">REST Types</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $Addrest["fields"][4]; ?>"
                                                                    name="<?php echo $Addrest["fields"][4]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select REST type"}'>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <h4 class="box-title"><strong>Request Parameters</strong></h4>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputusertype" class="col-sm-1 control-label">Parameter</label>
                                                    <div class="col-sm-4">
                                                        <input type="text"
                                                               class="form-control"
                                                               id="<?php echo $Addrest["fields"][5]; ?>"
                                                               name="<?php echo $Addrest["fields"][5]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Parameter","minlength": "Length Should be 4 characters"}'
                                                               placeholder="Parameter 1">
                                                    </div>
                                                    <label for="inputusertype" class="col-sm-1 control-label">Value</label>
                                                    <div class="col-sm-4">
                                                        <input type="text"
                                                               class="form-control"
                                                               id="<?php echo $Addrest["fields"][6]; ?>"
                                                               name="<?php echo $Addrest["fields"][6]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter value","minlength": "Length Should be 4 numbers"}'
                                                               placeholder="Value 1">
                                                    </div>
                                                    <div class="box-tools pull-right">
                                                        <button class="btn btn-box-tool" id="id" name="" data-widget="add"><i class="fa fa-plus"></i></button>
                                                    </div><!-- /.box-tools -->
                                                </div><!-- /.box-header -->
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <h4 class="box-title"><strong>Response Parameters</strong></h4>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputusertype" class="col-sm-1 control-label">Parameter</label>
                                                    <div class="col-sm-4">
                                                        <input type="text"
                                                               class="form-control"
                                                               id="<?php echo $Addrest["fields"][7]; ?>"
                                                               name="<?php echo $Addrest["fields"][7]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Parameter","minlength": "Length Should be 4 characters"}'
                                                               placeholder="Parameter 1">
                                                    </div>
                                                    <label for="inputusertype" class="col-sm-1 control-label">Value</label>
                                                    <div class="col-sm-4">
                                                        <input type="text"
                                                               class="form-control"
                                                               id="<?php echo $Addrest["fields"][8]; ?>"
                                                               name="<?php echo $Addrest["fields"][8]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter value","minlength": "Length Should be 4 numbers"}'
                                                               placeholder="Value 1">
                                                    </div>
                                                    <div class="box-tools pull-right">
                                                        <button class="btn btn-box-tool" id="id" name="" data-widget="add"><i class="fa fa-plus"></i></button>
                                                    </div><!-- /.box-tools -->
                                                </div><!-- /.box-header -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-10">
                            <button type="submit"
                                    class="btn btn-danger"
                                    id="<?php echo $Addrest["fields"][9]; ?>"
                                    name="<?php echo $Addrest["fields"][9]; ?>"
                                    data-rules='{}'
                                    data-messages='{}'>Submit Details</button>
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
            url: URL + 'MasterData/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).onlinefood.masterdata;
        var obj = new masterdataController();
        obj.__constructor(para);
        obj.__User();
    });
</script>