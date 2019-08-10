<?php
$userRejReq = isset($this->idHolders["tamboola"]["user"]["Request"]["ListRejectRequest"]) ? (array) $this->idHolders["tamboola"]["user"]["Request"]["ListRejectRequest"] : false;
?>
<!-- Post -->
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Rejected Request
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" id="id">
                    <div class="box-body table-responsive">
                        <table id="<?php echo $userRejReq["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Cell</th>
                                    <th>Registered Date</th>
                                    <th>User Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $userRejReq["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
