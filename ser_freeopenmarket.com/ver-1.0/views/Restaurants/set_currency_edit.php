<?php
$SetCurEdit = isset($this->idHolders["recharge"]["masterdata"]["EditSetCurrency"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditSetCurrency"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Company currency
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Company Currency</li>
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
                          id="<?php echo $SetCurEdit["form"]; ?>"
                          name="<?php echo $SetCurEdit["form"]; ?>"
                          method="post">
                        <div class="content">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <input type="hidden"
                                                       name="<?php echo $SetCurEdit["fields"][3]; ?>"
                                                       id="<?php echo $SetCurEdit["fields"][3]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->getuserDet["data"]["company_currency_id"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Company</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $SetCurEdit["fields"][0]; ?>"
                                                                    name="<?php echo $SetCurEdit["fields"][0]; ?>"
                                                                    value="<?php echo trim($this->getuserDet["data"]["company_name"]); ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Company"}'
                                                                    placeholder="Company">
                                                            </select>
                                                        </div>
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Currency</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $SetCurEdit["fields"][1]; ?>"
                                                                    name="<?php echo $SetCurEdit["fields"][1]; ?>"
                                                                    value="<?php echo trim($this->getuserDet["data"]["portal_currencies_CurrencyName"]); ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Currency"}'
                                                                    placeholder="Currency">
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
                                                        id="<?php echo $SetCurEdit["fields"][2]; ?>"
                                                        name="<?php echo $SetCurEdit["fields"][2]; ?>"
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
        obj.__SetCurrencyEdit();
    });
</script>
