<?php
$PackAll = isset($this->idHolders["tamboola"]["attendance"]["All"]) ? (array) $this->idHolders["tamboola"]["attendance"]["All"] : false;
$PackMark = isset($this->idHolders["tamboola"]["attendance"]["Marked"]) ? (array) $this->idHolders["tamboola"]["attendance"]["Marked"] : false;
$PackUnMark = isset($this->idHolders["tamboola"]["attendance"]["Unmarked"]) ? (array) $this->idHolders["tamboola"]["attendance"]["Unmarked"] : false;
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
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content">
                    <div class="panel panel-body">
                        <div class="panel-heading"><h4>Package Attendance</h4></div>
                        <ul class="nav nav-tabs" id="followupmenu">
                            <li class="active">
                                <a href="#current_follow" data-toggle="tab" id="current_followmenubut">All</a>
                            </li>
                            <li>
                                <a href="#pending_follow" data-toggle="tab" id="pending_followmenubut">UnMarked</a>
                            </li>
                            <li>
                                <a href="#expired_follow" data-toggle="tab" id="expired_followmenubut">Marked</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="current_follow">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-body table-responsive">
                                                    <table id="<?php echo $PackAll["fields"][0]; ?>" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Customer Name</th>
                                                                <th>Package Name</th>
                                                                <th>Facility</th>
                                                                <th>In Time</th>
                                                                <th>Out Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="<?php echo $PackAll["fields"][1]; ?>">
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>
                            <div class="tab-pane fade" id="pending_follow">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-body table-responsive">
                                                    <table id="<?php echo $PackUnMark["fields"][0]; ?>" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Customer Name</th>
                                                                <th>Package Name</th>
                                                                <th>Facility</th>
                                                                <th>In Time</th>
                                                                <th>Out Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="<?php echo $PackUnMark["fields"][1]; ?>">
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>
                            <div class="tab-pane fade" id="expired_follow">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-body table-responsive">
                                                    <table id="<?php echo $PackMark["fields"][0]; ?>" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Customer Name</th>
                                                                <th>Package Name</th>
                                                                <th>Facility</th>
                                                                <th>In Time</th>
                                                                <th>Out Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="<?php echo $PackMark["fields"][1]; ?>">
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
