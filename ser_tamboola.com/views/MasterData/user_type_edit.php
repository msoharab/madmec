<?php
$UsrPrEdit = isset($this->idHolders["recharge"]["masterdata"]["EditUserType"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditUserType"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit User Type
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit User Type</li>
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
                          id="<?php echo $UsrPrEdit["form"]; ?>"
                          name="<?php echo $UsrPrEdit["form"]; ?>"
                          method="post">
                        <div class="content">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <input type="hidden"
                                                       name="<?php echo $UsrPrEdit["fields"][3]; ?>"
                                                       id="<?php echo $UsrPrEdit["fields"][3]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->getuserDet["data"]["users_type_id"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusiness" class="col-sm-1 control-label">User Type</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $UsrPrEdit["fields"][0]; ?>"
                                                                   name="<?php echo $UsrPrEdit["fields"][0]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["users_type_type"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter User Type","minlength": "Length Should be minimum 3 numbers"}'
                                                                   readonly="readonly"
                                                                   placeholder="User Type" type="text">
                                                        </div>
                                                        <label for="inputbusinessdate" class="col-sm-1 control-label">Minimum Balance</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $UsrPrEdit["fields"][1]; ?>"
                                                                   name="<?php echo $UsrPrEdit["fields"][1]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["users_type_minimum_balance"]); ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter Minimum Balance"}'
                                                                   placeholder="Minimum Balance" type="text" pattern="^[0-9]{0,5}$">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-5 col-sm-10">
                                                <button type="submit"
                                                        class="btn btn-danger"
                                                        id="<?php echo $UsrPrEdit["fields"][2]; ?>"
                                                        name="<?php echo $UsrPrEdit["fields"][2]; ?>"
                                                        data-rules='{}'
                                                        data-messages='{}'>Update Details</button>
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
        obj.__UserTypeEdit();
    });
</script>