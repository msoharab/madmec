<?php
$Packa = isset($this->idHolders["tamboola"]["accounts"]["sellOffer"]) ? (array) $this->idHolders["tamboola"]["accounts"]["sellOffer"] : false;
?>
<!-- Enquiry add -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Accounts
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Accounts</li>
        </ol>
    </section>
    <div class="content">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Sell Package</strong></h3>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="<?php echo $Packa["fields"][0]; ?>" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Package Name</th>
                                        <th>Customer Name</th>
                                        <th>Payment Date</th>
                                        <th>Number of Sessions</th>
                                        <th>Amount</th>
                                        <th>Mode Of Payment</th>
                                        <th>Receipt No </th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="<?php echo $Packa["fields"][1]; ?>">
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>
</div>
