<?php
$List = isset($this->idHolders["onlinefood"]["gateway"]["ListGateway"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["ListGateway"] : false;
?>
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List Users
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table id="<?php echo $List["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Gateway Name</th>
                                    <th>Business Type</th>
                                    <th>Service</th>
                                    <th>Gateway API version</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Date</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
