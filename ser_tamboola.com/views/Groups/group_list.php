<?php
$ListGroup = isset($this->idHolders["tamboola"]["groups"]["ListGroups"]) ? (array) $this->idHolders["tamboola"]["groups"]["ListGroups"] : false;
?>
<!-- Enquiry add -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Groups
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Groups List</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Groups List</strong></h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="<?php echo $ListGroup["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Name</th>
                                    <th>Owner Name</th>
                                    <th>Number of Members</th>
                                    <th>Group Type</th>
                                    <th>Group Fees</th>
                                    <th>Receipt No</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $ListGroup["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
