<?php
$Regis = isset($this->idHolders["tamboola"]["stats"]["Registration"]) ? (array) $this->idHolders["tamboola"]["stats"]["Registration"] : false;
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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Today's Registration</strong></h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="<?php echo $Regis["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email Id</th>
                                    <th>Registration Type</th>
                                    <th>Receipt</th>
                                    <th>Today</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $Regis["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
