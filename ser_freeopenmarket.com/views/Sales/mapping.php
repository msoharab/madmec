<?php
$Mapp = isset($this->idHolders["onlinefood"]["gateway"]["Mapping"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["Mapping"] : false;
$MappList = isset($this->idHolders["onlinefood"]["gateway"]["AddOperator"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["AddOperator"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Mapping
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Mapping</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#map" data-toggle="tab">Mapping</a></li>
                        <li><a href="#maplist" data-toggle="tab">List</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="map">
                            <div class="tab-pane" id="assign">
                                <!-- The timeline -->
                                <form class="form-horizontal"
                                      action=""
                                      id="<?php echo $Mapp["form"]; ?>"
                                      name="<?php echo $Mapp["form"]; ?>"
                                      method="post">
                                    <div class="content">
                                        <!-- Content Header (Page header) -->
                                        <section class="content-header">
                                            <h1>
                                                Mapping Operator
                                            </h1>
                                        </section>
                                        <!-- Main content -->
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box">
                                                        <div class="box-header">
                                                            <h3 class="box-title">Portal Operator</h3>
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputusertype" class="col-sm-1 control-label">Service</label>
                                                                    <div class="col-sm-3">
                                                                        <select class="form-control"
                                                                                id="<?php echo $Mapp["fields"][0]; ?>"
                                                                                name="<?php echo $Mapp["fields"][0]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Service"}'>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputusertype" class="col-sm-1 control-label">Portal Operator</label>
                                                                    <div class="col-sm-3">
                                                                        <select class="form-control"
                                                                                id="<?php echo $Mapp["fields"][1]; ?>"
                                                                                name="<?php echo $Mapp["fields"][1]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Portal Operator"}'>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputusertype" class="col-sm-1 control-label">Portal Operator Type</label>
                                                                    <div class="col-sm-3">
                                                                        <select class="form-control"
                                                                                id="<?php echo $Mapp["fields"][2]; ?>"
                                                                                name="<?php echo $Mapp["fields"][2]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Portal Operator Type"}'>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box">
                                                        <div class="box-header">
                                                            <h3 class="box-title">Gateway Operator</h3>
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputusertype" class="col-sm-1 control-label">Gateway</label>
                                                                    <div class="col-sm-3">
                                                                        <select class="form-control cke_dark_background"
                                                                                id="<?php echo $Mapp["fields"][3]; ?>"
                                                                                name="<?php echo $Mapp["fields"][3]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Gateway"}'>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputusertype" class="col-sm-1 control-label">Operator</label>
                                                                    <div class="col-sm-3">
                                                                        <select class="form-control select2-container--focus"
                                                                                id="<?php echo $Mapp["fields"][4]; ?>"
                                                                                name="<?php echo $Mapp["fields"][4]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Operator"}'>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputusertype" class="col-sm-1 control-label skin-green">Operator Type</label>
                                                                    <div class="col-sm-3">
                                                                        <select class="form-control skin-green"
                                                                                id="<?php echo $Mapp["fields"][5]; ?>"
                                                                                name="<?php echo $Mapp["fields"][5]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Operator Type"}'>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 form-group">
                                                            <div class="text-center">
                                                                <button type="submit"
                                                                        id="<?php echo $Mapp["fields"][6]; ?>"
                                                                        name="<?php echo $Mapp["fields"][6]; ?>"
                                                                        data-rules='{}'
                                                                        data-messages='{}'
                                                                        class="btn btn-primary">Set Mapping</button>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.box -->
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->
                                        </section><!-- /.content -->
                                    </div>
                                </form>
                            </div><!-- /.tab-pane -->
                        </div>
                        <div class="tab-pane" id="maplist">
                            <div class="content">
                                <!-- Content Header (Page header) -->
                                <section class="content-header">
                                    <h1>
                                        List Mapping
                                        <small></small>
                                    </h1>
                                </section>
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-body table-responsive">
                                                    <table id="<?php echo $MappList["fields"][0]; ?>" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Service</th>
                                                                <th>Portal Operator Type</th>
                                                                <th>Portal Operator</th>
                                                                <th>Gateway</th>
                                                                <th>Operator Type</th>
                                                                <th>Operator</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="<?php echo $MappList["fields"][1]; ?>">
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
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
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
        obj.__SetMapp();
    });
</script>
