<?php
$userList = isset($this->idHolders["onlinefood"]["user"]["Personal"]["ListUser"]) ? (array) $this->idHolders["onlinefood"]["user"]["Personal"]["ListUser"] : false;
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
                        <table id="<?php echo $userList["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Proof ID</th>
                                    <th>Proof Type</th>
                                    <th>Proof Picture</th>
                                    <th>User Type</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $userList["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
