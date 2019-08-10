<?php 
$gymReq = isset($this->idHolders["tamboola"]["gym"]["Request"]) ? (array) $this->idHolders["tamboola"]["gym"]["Request"] : false;
?>
<div class="content">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Request</strong></h3>
                    </div>
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="<?php echo $gymReq["fields"][0]; ?>" class="table table-bordered
                               table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Gym Name</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Cell Number</th>
                                    <th>Gym Type</th>
                                    <th>Address</th>
                                    <th>Accept</th>
                                    <th>Reject</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $gymReq["fields"][0]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
