<?php
$Atten = isset($this->idHolders["tamboola"]["stats"]["Attendance"]) ? (array) $this->idHolders["tamboola"]["stats"]["Attendance"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Stats
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Stats</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customers</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active">
                                <a href="#info" data-toggle="tab">
                                    <i class="fa fa-arrow-right"></i>
                                    Attend
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#bank" data-toggle="tab">
                                    <i class="fa fa-arrow-right"></i>
                                    Expired
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /. box -->
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="active tab-pane" id="info">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Attend</strong></h3>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <table id="<?php echo $Atten["fields"][0]; ?>" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Customer Name</th>
                                                        <th>Email Id</th>
                                                        <th>Cell No</th>
                                                        <th>Offer</th>
                                                        <th>Facility</th>
                                                        <th>When</th>
                                                        <th>Expiry</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="<?php echo $Atten["fields"][1]; ?>">
                                                </tbody>
                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </section><!-- /.content -->
                    </div>
                    <div class="tab-pane" id="bank">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Expired</strong></h3>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <table id="<?php echo $Atten["fields"][2]; ?>" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Customer Name</th>
                                                        <th>Email Id</th>
                                                        <th>Cell No</th>
                                                        <th>Offer</th>
                                                        <th>Since When</th>
                                                        <th>Expiry</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="<?php echo $Atten["fields"][3]; ?>">
                                                </tbody>
                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </section><!-- /.content -->
                    </div>
                </div><!-- /.col -->
            </div>
        </div>
    </section>
</div>
