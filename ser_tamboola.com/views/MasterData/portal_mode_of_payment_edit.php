<?php
$UsrPrEdit = isset($this->idHolders["recharge"]["masterdata"]["EditMOP"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditMOP"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit MOP
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit MOP</li>
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
                                                       name="<?php echo $UsrPrEdit["fields"][2]; ?>"
                                                       id="<?php echo $UsrPrEdit["fields"][2]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->getuserDet["data"]["portal_mode_of_payment_id"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Mode Of Payment</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $UsrPrEdit["fields"][0]; ?>"
                                                                   name="<?php echo $UsrPrEdit["fields"][0]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_mode_of_payment_mop"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Mode Of Payment","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="MOP" type="text" pattern="^[A-Za-z ]{3,100}$">
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <button type="submit"
                                                                    class="btn btn-danger"
                                                                    id="<?php echo $UsrPrEdit["fields"][1]; ?>"
                                                                    name="<?php echo $UsrPrEdit["fields"][1]; ?>"
                                                                    data-rules='{}'
                                                                    data-messages='{}'>Update Details</button>
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
        obj.__MOPEdit();
    });
</script>