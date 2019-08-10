<?php
$rechFinSuc = isset($this->idHolders["onlinefood"]["gateway"]["RechargeTransaction"]["Financial"]["ListSuccessTran"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["RechargeTransaction"]["Financial"]["ListSuccessTran"] : false;
$rechFinUnsuc = isset($this->idHolders["onlinefood"]["gateway"]["RechargeTransaction"]["Financial"]["ListUnsuccessTran"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["RechargeTransaction"]["Financial"]["ListUnsuccessTran"] : false;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Financial Transaction
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Recharge Gateway</a></li>
            <li class="active">Transaction</li>
            <li class="active">Financial</li>
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
                                                <div class="box-body table-responsive" id="<?php echo $rechBusiList["fields"][0]; ?>">
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>User Name</th>
                                                                <th>User ID</th>
                                                                <th>Gateway</th>
                                                                <th>Payment</th>
                                                                <th>Amount</th>
                                                                <th>Date</th>
                                                                <th>Due Amount</th>
                                                                <th>Due Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>3</td>
                                                                <td>Online Food Order</td>
                                                                <td>cash</td>
                                                                <td>5000</td>
                                                                <td>29-02-2016</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>3</td>
                                                                <td>Online Food Order</td>
                                                                <td>cash</td>
                                                                <td>5000</td>
                                                                <td>29-02-2016</td>
                                                                <td>3000</td>
                                                                <td>10-03-2016</td>
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
                                                <div class="box-body table-responsive" id="<?php echo $rechBusiList["fields"][0]; ?>">
                                                    <table id="example2" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>User Name</th>
                                                                <th>User ID</th>
                                                                <th>Gateway</th>
                                                                <th>Payment</th>
                                                                <th>Amount</th>
                                                                <th>Date</th>
                                                                <th>Due Amount</th>
                                                                <th>Due Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>3</td>
                                                                <td>Online Food Order</td>
                                                                <td>cash</td>
                                                                <td>5000</td>
                                                                <td>28-02-2016</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Misc</td>
                                                                <td>3</td>
                                                                <td>Online Food Order</td>
                                                                <td>cash</td>
                                                                <td>5000</td>
                                                                <td>29-02-2016</td>
                                                                <td>3000</td>
                                                                <td>15-03-2016</td>
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
        </div><!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


