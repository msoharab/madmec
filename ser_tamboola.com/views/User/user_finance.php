<?php
$userFinSuc = isset($this->idHolders["tamboola"]["user"]["Transaction"]["Financial"]["ListSuccessTran"]) ? (array) $this->idHolders["tamboola"]["user"]["Transaction"]["Financial"]["ListSuccessTran"] : false;
$userFinUnsuc = isset($this->idHolders["tamboola"]["user"]["Transaction"]["Financial"]["ListUnsuccessTran"]) ? (array) $this->idHolders["tamboola"]["user"]["Transaction"]["Financial"]["ListUnsuccessTran"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Financial Transaction
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Financial Transaction </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#success" data-toggle="tab">Successful</a></li>
                        <li><a href="#unsuccess" data-toggle="tab">Unsuccessful</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="success">
                            <!-- Post -->
                            <div class="content">
                                <!-- Content Header (Page header) -->
                                <section class="content-header">
                                    <h1>
                                        Successful Transaction
                                    </h1>
                                </section>
                                <!-- Main content -->
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-body table-responsive"
                                                     id="<?php echo $userFinSuc["fields"][0]; ?>">
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>User ID</th>
                                                                <th>User Name</th>
                                                                <th>User Type</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>02-02-2016</th>
                                                                <th>5</th>
                                                                <td>Trident</td>
                                                                <td>Retailer</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="unsuccess">
                            <!-- Post -->
                            <div class="content">
                                <!-- Content Header (Page header) -->
                                <section class="content-header">
                                    <h1>
                                        Unsuccessful Transaction
                                    </h1>
                                </section>
                                <!-- Main content -->
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-body table-responsive"
                                                     id="<?php echo $userFinUnsuc["fields"][0]; ?>">
                                                    <table id="example2" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>User ID</th>
                                                                <th>User Name</th>
                                                                <th>User Type</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>02-02-2016</th>
                                                                <th>5</th>
                                                                <td>Trident</td>
                                                                <td>Retailer</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </section><!-- /.content -->
                            </div>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
        </div>
    </section>
</div>
