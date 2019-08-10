<?php ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Company Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Company</li>
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
                                <a href="#info" data-toggle="tab">
                                    <i class="fa fa-info"></i>
                                    Business Info
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#bank" data-toggle="tab">
                                    <i class="fa fa-bank"></i>
                                    Bank Details
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#currency" data-toggle="tab">
                                    <i class="fa fa-money"></i>
                                    Set Currency
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#services" data-toggle="tab">
                                    <i class="fa fa-table">
                                    </i>Services<span class="label label-primary pull-right">&nbsp;</span></a>
                            </li>
                            <li>
                                <a href="#operatorsM" data-toggle="tab">
                                    <i class="fa fa-tablet">
                                    </i>Manage Operators<span class="label label-primary pull-right">&nbsp;</span></a>
                            </li>
                            <li>
                                <a href="#operatorsL" data-toggle="tab">
                                    <i class="fa fa-tablet">
                                    </i>List Operators<span class="label label-primary pull-right">&nbsp;</span></a>
                            </li>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /. box -->
            </div><!-- /.col -->
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="active tab-pane" id="info">
                        <h3>
                            Business Info
                        </h3>
                        <?php
                        require_once 'business_info.php';
                        ?>
                    </div>
                    <!-- /.tab-content -->
                    <div class="tab-pane" id="bank">
                        <h3>
                            Bank Details
                        </h3>
                        <?php
                        require_once 'bank_details.php';
                        ?>
                    </div>
                    <!-- currency -->
                    <div class="tab-pane" id="currency">
                        <h3>
                            Set Currency
                        </h3>
                        <?php
                        require_once 'set_currency.php';
                        ?>
                    </div>
                    <!-- /. Services -->
                    <div class="tab-pane" id="services">
                        <h3>
                            Services
                        </h3>
                        <?php
                        require_once 'manage_services.php';
                        ?>
                    </div>
                    <!-- /. Manage Operators -->
                    <div class="tab-pane" id="operatorsM">
                        <h3>
                            Manage Operators
                        </h3>
                        <?php
                        require_once 'manage_operator.php';
                        ?>
                    </div>
                    <!-- /. List Operators -->
                    <div class="tab-pane" id="operatorsL">
                        <h3>
                            List Operators
                        </h3>
                        <?php
                        require_once 'list_operator.php';
                        ?>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
<!--<script type="text/javascript">
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
        obj.__Company();
    });
</script>-->