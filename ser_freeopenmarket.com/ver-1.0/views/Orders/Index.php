<?php ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CRM Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">CRM</li>
        </ol>
    </section>
    <!-- Main content -->
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
                                <a href="#mail" data-toggle="tab">
                                    <i class="fa fa-mail-forward"></i>
                                    Mail
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#sms" data-toggle="tab">
                                    <i class="fa fa-envelope"></i>
                                    SMS
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /. box -->
            </div><!-- /.col -->
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="active tab-pane" id="mail">
                        <h3>
                            Email Manager
                        </h3>
                        <?php
                        require_once 'email.php';
                        ?>
                    </div>
                    <!-- /.tab-content -->
                    <div class="tab-pane" id="sms">
                        <h3>
                            SMS Manager
                        </h3>
                        <?php
                        require_once 'sms.php';
                        ?>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>