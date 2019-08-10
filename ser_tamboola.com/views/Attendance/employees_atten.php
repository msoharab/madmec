<?php
$EmpAll = isset($this->idHolders["tamboola"]["attendance"]["All"]) ? (array) $this->idHolders["tamboola"]["attendance"]["All"] : false;
$EmpMark = isset($this->idHolders["tamboola"]["attendance"]["Marked"]) ? (array) $this->idHolders["tamboola"]["attendance"]["Marked"] : false;
$EmpUnMark = isset($this->idHolders["tamboola"]["attendance"]["Unmarked"]) ? (array) $this->idHolders["tamboola"]["attendance"]["Unmarked"] : false;
?>
<!-- Enquiry add -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Attendance
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Attendance</li>
        </ol>
    </section>
    <section class="content">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Employees Attendance</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active">
                            <a href="#info" data-toggle="tab">
                                <i class="fa fa-arrow-right"></i>
                                All
                                <span class="label label-primary pull-right">&nbsp;</span>
                            </a>
                        </li>
                        <li>
                            <a href="#bank" data-toggle="tab">
                                <i class="fa fa-arrow-right"></i>
                                Marked
                                <span class="label label-primary pull-right">&nbsp;</span>
                            </a>
                        </li>
                        <li>
                            <a href="#currency" data-toggle="tab">
                                <i class="fa fa-arrow-right"></i>
                                UnMarked
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
                                        <h3 class="box-title"><strong>All</strong></h3>
                                    </div>
                                    <div class="box-body table-responsive">
                                        <table id="<?php echo $EmpAll["fields"][0]; ?>" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employees Name</th>
                                                    <th>Facility</th>
                                                    <th>In Time</th>
                                                    <th>out Time</th>
                                                </tr>
                                            </thead>
                                            <tbody id="<?php echo $EmpAll["fields"][1]; ?>">
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
                                        <h3 class="box-title"><strong>Marked</strong></h3>
                                    </div>
                                    <div class="box-body table-responsive">
                                        <table id="<?php echo $EmpMark["fields"][0]; ?>" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employees Name</th>
                                                    <th>Facility</th>
                                                    <th>In Time</th>
                                                    <th>out Time</th>
                                                </tr>
                                            </thead>
                                            <tbody id="<?php echo $EmpMark["fields"][1]; ?>">
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
                                        <h3 class="box-title"><strong>Un Marked</strong></h3>
                                    </div>
                                    <div class="box-body table-responsive">
                                        <table id="<?php echo $EmpUnMark["fields"][0]; ?>" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employees Name</th>
                                                    <th>Facility</th>
                                                    <th>In Time</th>
                                                    <th>out Time</th>
                                                </tr>
                                            </thead>
                                            <tbody id="<?php echo $EmpUnMark["fields"][1]; ?>">
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
