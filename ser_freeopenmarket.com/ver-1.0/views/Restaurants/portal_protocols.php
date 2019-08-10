<?php
$AddProt = isset($this->idHolders["recharge"]["masterdata"]["AddProtocol"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddProtocol"] : false;
$AddProtList = isset($this->idHolders["recharge"]["masterdata"]["ListProtocols"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListProtocols"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listproto" data-toggle="tab">List</a></li>
        <!--<li><a href="#addproto" data-toggle="tab">Add</a></li>-->
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addproto">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Add Protocol</h3>
                </div><!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $AddProt["form"]; ?>"
                      name="<?php echo $AddProt["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Protocol Name</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-control"
                                                                id="<?php echo $AddProt["fields"][0]; ?>"
                                                                name="<?php echo $AddProt["fields"][0]; ?>"
                                                                data-rules='{"required": true}'
                                                                data-messages='{"required": "Select Protocol Name"}'>
                                                            <option>REST</option>
                                                            <option>XML-RPC</option>
                                                            <option>SOAP</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputbusinessdate" class="col-sm-1 control-label">Base Protocol Name</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-control"
                                                                id="<?php echo $AddProt["fields"][1]; ?>"
                                                                name="<?php echo $AddProt["fields"][1]; ?>"
                                                                data-rules='{"required": true}'
                                                                data-messages='{"required": "Enter Base Protocol Name"}'>
                                                            <option>HTTP</option>
                                                            <option>HTTPS</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-10">
                                            <button type="submit"
                                                    class="btn btn-danger"
                                                    id="<?php echo $AddProt["fields"][2]; ?>"
                                                    name="<?php echo $AddProt["fields"][2]; ?>"
                                                    data-rules='{}'
                                                    data-messages='{}'>Submit Details</button>
                                        </div>
                                    </div>
                                </div>
                        </section>
                    </div><!-- /.tab-pane -->
                </form>
            </div>
            <!-- /. box -->
        </div>
        <div class="active tab-pane" id="listproto">
            <div class="content">
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong> List Protocols</strong></h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $AddProtList["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Protocol Name</th>
                                                <th>Base Name</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $AddProtList["fields"][1]; ?>">
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
</div>
