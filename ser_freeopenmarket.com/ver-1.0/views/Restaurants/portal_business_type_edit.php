<?php
$UsrBuEdit = isset($this->idHolders["recharge"]["masterdata"]["EditBusinessType"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditBusinessType"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Business Type
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Business Type</li>
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
                          id="<?php echo $UsrBuEdit["form"]; ?>"
                          name="<?php echo $UsrBuEdit["form"]; ?>"
                          method="post">
                        <div class="content">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <input type="hidden"
                                                       name="<?php echo $UsrBuEdit["fields"][3]; ?>"
                                                       id="<?php echo $UsrBuEdit["fields"][3]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->getuserDet["data"]["portal_business_type_id"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Country</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $UsrBuEdit["fields"][0]; ?>"
                                                                    name="<?php echo $UsrBuEdit["fields"][0]; ?>"
                                                                    value="<?php echo trim($this->getuserDet["data"]["portal_countries_Country"]); ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Country"}'>
                                                            </select>
                                                        </div>
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Business Type</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $UsrBuEdit["fields"][1]; ?>"
                                                                   name="<?php echo $UsrBuEdit["fields"][1]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_business_type_name"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Business Type","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="Business Type" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-5 col-sm-10">
                                                <button type="submit"
                                                        class="btn btn-danger"
                                                        id="<?php echo $UsrBuEdit["fields"][2]; ?>"
                                                        name="<?php echo $UsrBuEdit["fields"][2]; ?>"
                                                        data-rules='{}'
                                                        data-messages='{}'>Update Details</button>
                                            </div>
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
        obj.__BusinessTypesEdit();
    });
</script>
