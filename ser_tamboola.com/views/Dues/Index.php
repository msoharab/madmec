<?php
$dueCur = isset($this->idHolders["tamboola"]["dues"]["ListCurrent"]) ? (array) $this->idHolders["tamboola"]["dues"]["ListCurrent"] : false;
$duePend = isset($this->idHolders["tamboola"]["dues"]["ListPending"]) ? (array) $this->idHolders["tamboola"]["dues"]["ListPending"] : false;
$dueExp = isset($this->idHolders["tamboola"]["dues"]["ListExpired"]) ? (array) $this->idHolders["tamboola"]["dues"]["ListExpired"] : false;
?>
<!-- Enquiry add -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dues
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Dues</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content">
                    <div class="panel panel-body">
                        <ul class="nav nav-tabs" id="followupmenu">
                            <li class="active">
                                <a href="#current_follow" data-toggle="tab" id="current_followmenubut">Current</a>
                            </li>
                            <li>
                                <a href="#pending_follow" data-toggle="tab" id="pending_followmenubut">Pending</a>
                            </li>
                            <li>
                                <a href="#expired_follow" data-toggle="tab" id="expired_followmenubut">Expired</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="current_follow">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-body table-responsive">
                                                    <table id="<?php echo $dueCur["fields"][0]; ?>" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>Current dues
                                                            </tr>
                                                        </thead>
                                                        <tbody id="<?php echo $dueCur["fields"][1]; ?>">
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
                                                    <table id="<?php echo $duePend["fields"][0]; ?>" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>Pending dues
                                                            </tr>
                                                        </thead>
                                                        <tbody id="<?php echo $duePend["fields"][1]; ?>">
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
                                                    <table id="<?php echo $dueExp["fields"][0]; ?>" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>Expired dues
                                                            </tr>
                                                        </thead>
                                                        <tbody id="<?php echo $dueExp["fields"][1]; ?>">
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
