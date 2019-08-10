<?php
$CompBankEd = isset($this->idHolders["recharge"]["masterdata"]["EditBank"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditBank"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Bank Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Bank Details</li>
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
                          id="<?php echo $CompBankEd["form"]; ?>"
                          name="<?php echo $CompBankEd["form"]; ?>"
                          method="post">
                        <div class="content">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <input type="hidden"
                                                       name="<?php echo $CompBankEd["fields"][9]; ?>"
                                                       id="<?php echo $CompBankEd["fields"][9]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->getuserDet["data"]["company_bank_accounts_id"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputservicee" class="col-sm-1 control-label">Company</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $CompBankEd["fields"][0]; ?>"
                                                                    name="<?php echo $CompBankEd["fields"][0]; ?>"
                                                                    readonly="readonly"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Company"}'>
                                                            </select>
                                                        </div>
                                                        <label for="inputName" class="col-sm-1 control-label">Account Name</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompBankEd["fields"][1]; ?>"
                                                                   name="<?php echo $CompBankEd["fields"][1]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_bank_accounts_ac_name"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Account Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="Account Name" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputaccount" class="col-sm-1 control-label">Account Number</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompBankEd["fields"][2]; ?>"
                                                                   name="<?php echo $CompBankEd["fields"][2]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_bank_accounts_ac_no"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "8"}'
                                                                   data-messages='{"required": "Enter Account number","minlength": "Length Should be minimum 8 numbers"}'
                                                                   placeholder="Account Number" type="text">
                                                        </div>
                                                        <label for="inputifsc" class="col-sm-1 control-label">IFSC</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompBankEd["fields"][3]; ?>"
                                                                   name="<?php echo $CompBankEd["fields"][3]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_bank_accounts_IFSC"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter IFSC Code","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="IFSC" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbank" class="col-sm-1 control-label">Bank Name</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompBankEd["fields"][4]; ?>"
                                                                   name="<?php echo $CompBankEd["fields"][4]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_bank_accounts_name"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Bank Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="Bank Name" type="text">
                                                        </div>
                                                        <label for="inputcode" class="col-sm-1 control-label">Bank Code</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompBankEd["fields"][5]; ?>"
                                                                   name="<?php echo $CompBankEd["fields"][5]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_bank_accounts_code"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Bank Code","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="Bank Code" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbranch" class="col-sm-1 control-label">Branch Name</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompBankEd["fields"][6]; ?>"
                                                                   name="<?php echo $CompBankEd["fields"][6]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_bank_accounts_branch"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Branch Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="Branch Name" type="text">
                                                        </div>
                                                        <label for="inputbranch" class="col-sm-1 control-label">Branch Code</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $CompBankEd["fields"][7]; ?>"
                                                                   name="<?php echo $CompBankEd["fields"][7]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["company_bank_accounts_branch_code"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "2"}'
                                                                   data-messages='{"required": "Enter Branch Code","minlength": "Length Should be minimum 2 numbers"}'
                                                                   placeholder="Branch Code" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-10">
                                    <button type="submit"
                                            class="btn btn-danger"
                                            id="<?php echo $CompBankEd["fields"][8]; ?>"
                                            name="<?php echo $CompBankEd["fields"][8]; ?>"
                                            data-rules='{}'
                                            data-messages='{}'>Update Details</button>
                                </div>
                            </div>
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
        obj.__BankEdit();
    });
</script>