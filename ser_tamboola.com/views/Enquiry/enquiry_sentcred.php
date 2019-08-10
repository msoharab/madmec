<?php
$enqSentCre = isset($this->idHolders["tamboola"]["customers"]["ListCustomers"]) ? (array) $this->idHolders["tamboola"]["customers"]["ListCustomers"] : false;
?>
<!-- Enquiry add -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Enquiry
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Enquiry</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>List of Sent Credentials</strong></h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="<?php echo $enqSentCre["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>List of Sent Credentials
                                </tr>
                            </thead>
                            <tbody id="<?php echo $enqSentCre["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
