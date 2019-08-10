<?php
$Addrest = isset($this->idHolders["onlinefood"]["gateway"]["AddRest"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["AddRest"] : false;
$AddrestList = isset($this->idHolders["onlinefood"]["gateway"]["ListUserTypes"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["ListUserTypes"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            REST Protocol
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> REST Protocol </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#add" data-toggle="tab">Add Protocol</a></li>
                        <li><a href="#list" data-toggle="tab">List Protocol</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="add">
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
                                                                    <label for="inputgender" class="col-sm-3 control-label">Select Gateway</label>
                                                                    <div class="col-sm-9">
                                                                        <select
                                                                               class="form-control"
                                                                               id="<?php echo $Addrest["fields"][0]; ?>"
                                                                               name="<?php echo $Addrest["fields"][0]; ?>"
                                                                               data-rules='{"required": true}'
                                                                               data-messages='{"required": "Select Gateway"}'></select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputgender" class="col-sm-1 control-label">URL</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $Addrest["fields"][1]; ?>"
                                                                               name="<?php echo $Addrest["fields"][1]; ?>"
                                                                               data-rules='{"required": true,"minlength": "3"}'
                                                                               data-messages='{"required": "Enter URL","minlength": "Length Should be minimum 4 Characters"}'
                                                                               placeholder="URL">
                                                                    </div>
                                                                     <label for="inputgender" class="col-sm-1 control-label">URL Types</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $Addrest["fields"][2]; ?>"
                                                                               name="<?php echo $Addrest["fields"][2]; ?>"
                                                                               data-rules='{}'
                                                                               data-messages='{}'
                                                                               placeholder="Redirect URL">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputmobile" class="col-sm-1 control-label">PORT</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="number"
                                                                               class="form-control"
                                                                               id="<?php echo $Addrest["fields"][3]; ?>"
                                                                               name="<?php echo $Addrest["fields"][3]; ?>"
                                                                               data-rules='{"required": true,"minlength": "2"}'
                                                                               data-messages='{"required": "Enter the port number","minlength": "Length Should be 2 numbers"}'
                                                                               value="80">
                                                                    </div>
                                                                    <label for="inputusertype" class="col-sm-1 control-label">Protocol Type</label>
                                                                    <div class="col-sm-5">
                                                                        <select class="form-control"
                                                                                id="<?php echo $Addrest["fields"][4]; ?>"
                                                                                name="<?php echo $Addrest["fields"][4]; ?>"
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
                                                                                id="<?php echo $Addrest["fields"][5]; ?>"
                                                                                name="<?php echo $Addrest["fields"][5]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select REST method"}'>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inpu" class="col-sm-1 control-label">REST Types</label>
                                                                    <div class="col-sm-5">
                                                                        <select class="form-control"
                                                                                id="<?php echo $Addrest["fields"][6]; ?>"
                                                                                name="<?php echo $Addrest["fields"][6]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select REST type"}'>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <h4 class="box-title">
                                                            <strong>Request Parameters</strong>
                                                                <div class="box-tools pull-right">
                                                                    <button type="button" class="btn btn-box-tool" id="<?php echo $Addrest["cloneplusbut"][0]; ?>" name="<?php echo $Addrest["cloneplusbut"][0]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                                                                </div><!-- /.box-tools -->
                                                                <div class="box-tools pull-right">
                                                                    <button type="button" class="btn btn-box-tool" id="<?php echo $Addrest["cloneminusbut"][0]; ?>" name="<?php echo $Addrest["cloneminusbut"][0]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                                                                </div><!-- /.box-tools -->
                                                        </h4>
                                                        <div class="col-sm-12" id="<?php echo $Addrest["clone"][0]; ?>0">
                                                            <div class="form-group">
                                                                <label for="inputusertype" class="col-sm-1 control-label">Parameter</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text"
                                                                           class="form-control <?php echo $Addrest["reqparam"][0]; ?>"
                                                                           id="<?php echo $Addrest["reqparam"][0]; ?>"
                                                                           name="<?php echo $Addrest["reqparam"][0]; ?>"
                                                                           data-rules='{"required": true,"minlength": "2"}'
                                                                           data-messages='{"required": "Enter Parameter","minlength": "Length Should be 2 characters"}'
                                                                           placeholder="Parameter">
                                                                </div>
                                                                <label for="inputusertype" class="col-sm-1 control-label">Value</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text"
                                                                           class="form-control <?php echo $Addrest["reqparam"][1]; ?>"
                                                                           id="<?php echo $Addrest["reqparam"][1]; ?>"
                                                                           name="<?php echo $Addrest["reqparam"][1]; ?>"
                                                                           data-rules='{}'
                                                                           data-messages='{}'
                                                                           placeholder="Value">
                                                                </div>
                                                                <label for="inputusertype" class="col-sm-1 control-label">Map</label>
                                                                <div class="col-sm-3">
                                                                    <select class="form-control <?php echo $Addrest["reqparam"][2]; ?>"
                                                                           id="<?php echo $Addrest["reqparam"][2]; ?>"
                                                                           name="<?php echo $Addrest["reqparam"][2]; ?>"
                                                                           data-rules='{"required": true}'
                                                                           data-messages='{"required": "Select mapping parameter"}'></select>
                                                                </div>
                                                            </div>
                                                            <div class="divider">&nbsp;</div>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <h4 class="box-title">
                                                            <strong>Response Parameters</strong>
                                                                <div class="box-tools pull-right">
                                                                    <button type="button" class="btn btn-box-tool" id="<?php echo $Addrest["cloneplusbut"][1]; ?>" name="<?php echo $Addrest["cloneplusbut"][1]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                                                                </div><!-- /.box-tools -->
                                                                <div class="box-tools pull-right">
                                                                    <button type="button" class="btn btn-box-tool" id="<?php echo $Addrest["cloneminusbut"][1]; ?>" name="<?php echo $Addrest["cloneminusbut"][1]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                                                                </div><!-- /.box-tools -->
                                                        </h4>
                                                        <div class="col-sm-12" id="<?php echo $Addrest["clone"][1]; ?>0">
                                                            <div class="form-group">
                                                                <label for="inputusertype" class="col-sm-1 control-label">Code</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text"
                                                                           class="form-control <?php echo $Addrest["resparam"][0]; ?>"
                                                                           data-rules='{"required": true,"minlength": "2"}'
                                                                           data-messages='{"required": "Enter Parameter","minlength": "Length Should be 2 characters"}'
                                                                           id="<?php echo $Addrest["resparam"][0]; ?>"
                                                                           name="<?php echo $Addrest["resparam"][0]; ?>"
                                                                           placeholder="Code">
                                                                </div>
                                                                <label for="inputusertype" class="col-sm-1 control-label">Value</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text"
                                                                           class="form-control <?php echo $Addrest["resparam"][1]; ?>"
                                                                           id="<?php echo $Addrest["resparam"][1]; ?>"
                                                                           name="<?php echo $Addrest["resparam"][1]; ?>"
                                                                           data-rules='{}'
                                                                           data-messages='{}'
                                                                           placeholder="Value">
                                                                </div>
                                                                <label for="inputusertype" class="col-sm-1 control-label">Map</label>
                                                                <div class="col-sm-3">
                                                                    <select class="form-control <?php echo $Addrest["resparam"][2]; ?>"
                                                                           id="<?php echo $Addrest["resparam"][2]; ?>"
                                                                           name="<?php echo $Addrest["resparam"][2]; ?>"
                                                                           data-rules='{"required": true}'
                                                                           data-messages='{"required": "Select mapping parameter"}'></select>
                                                                </div>
                                                            </div><!-- /.box-header -->
                                                            <div class="divider">&nbsp;</div>
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
                                                id="<?php echo $Addrest["fields"][7]; ?>"
                                                name="<?php echo $Addrest["fields"][7]; ?>"
                                                data-rules='{}'
                                                data-messages='{}'>Submit Details</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.tab-content -->
                        <div class="tab-pane" id="list">
                            <div class="content">
                                <!-- Content Header (Page header) -->
                                <section class="content-header">
                                    <h1>
                                        List Rest
                                    </h1>
                                </section>
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-body table-responsive">
                                                    <table id="<?php echo $AddrestList["fields"][0]; ?>" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>URL</th>
                                                                <th>PORT</th>
                                                                <th>Protocol Type</th>
                                                                <th>Rest Method</th>
                                                                <th>Rest Type</th>
                                                                <th>Parameter</th>
                                                                <th>Value</th>
                                                                <th>Edit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="<?php echo $AddrestList["fields"][1]; ?>">
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>

                        </div>
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
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
        obj.__AddProtocol();
    });
</script>
