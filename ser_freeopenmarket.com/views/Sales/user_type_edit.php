<?php
$UsrPrEdit = isset($this->idHolders["onlinefood"]["masterdata"]["EditBusiness"]) ? (array) $this->idHolders["onlinefood"]["masterdata"]["EditBusiness"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Users
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Users</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Folders</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active">
                                <a href="#utype" data-toggle="tab">
                                    <i class="fa fa-users"></i>
                                    User Types
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /. box -->
            </div><!-- /.col -->
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="active tab-pane">
                        <h3>
                            Edit User Type
                        </h3>
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                <div class="active tab-pane">
                                    <!-- /.nav-tabs-custom -->
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
                                                                                       placeholder="Minimum Balance" type="text">
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
                                    <!-- /. box -->
                                </div>
                            </div><!-- /.nav-tabs-custom -->
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
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