<?php
$EnqCur = isset($this->idHolders["tamboola"]["enquiry"]["EnquiryFollows"]["CurrentFollow"]) ? (array) $this->idHolders["tamboola"]["enquiry"]["EnquiryFollows"]["CurrentFollow"] : false;
$EnqPend = isset($this->idHolders["tamboola"]["enquiry"]["EnquiryFollows"]["PendingFollow"]) ? (array) $this->idHolders["tamboola"]["enquiry"]["EnquiryFollows"]["PendingFollow"] : false;
$EnqExp = isset($this->idHolders["tamboola"]["enquiry"]["EnquiryFollows"]["ExpiredFollow"]) ? (array) $this->idHolders["tamboola"]["enquiry"]["EnquiryFollows"]["ExpiredFollow"] : false;
?>
<!-- Enquiry follow -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Follow-ups
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Follow-ups</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Follow Up's</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active">
                                <a href="#info" data-toggle="tab">
                                    <i class="fa fa-arrow-right"></i>
                                    Current
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#bank" data-toggle="tab">
                                    <i class="fa fa-arrow-right"></i>
                                    Pending
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#currency" data-toggle="tab">
                                    <i class="fa fa-arrow-right"></i>
                                    Expired
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /. box -->
            </div><!-- /.col -->
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="active tab-pane" id="info">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Current</strong></h3>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <table id="<?php echo $EnqCur["fields"][0]; ?>"
                                                   class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User Type</th>
                                                        <th>Minimum Balance</th>
                                                        <th>Date</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="<?php echo $EnqCur["fields"][1]; ?>">
                                                </tbody>
                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </section><!-- /.content -->
                    </div>
                    <!-- /.tab-content -->
                    <div class="tab-pane" id="bank">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Pending</strong></h3>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <table id="<?php echo $EnqPend["fields"][0]; ?>" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User Type</th>
                                                        <th>Minimum Balance</th>
                                                        <th>Date</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="<?php echo $EnqPend["fields"][1]; ?>">
                                                </tbody>
                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </section><!-- /.content -->
                    </div>
                    <!-- currency -->
                    <div class="tab-pane" id="currency">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><strong>Expired </strong></h3>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <table id="<?php echo $EnqExp["fields"][0]; ?>" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User Type</th>
                                                        <th>Minimum Balance</th>
                                                        <th>Date</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="<?php echo $EnqExp["fields"][1]; ?>">
                                                </tbody>
                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </section><!-- /.content -->
                    </div>
                </div>
            </div><!-- /.col -->
        </div>
    </section>
</div>
