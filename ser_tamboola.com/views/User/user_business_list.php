<?php
$userBusiList = isset($this->idHolders["tamboola"]["user"]["Business"]["ListBusiness"]) ? (array) $this->idHolders["tamboola"]["user"]["Business"]["ListBusiness"] : false;
?>
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List Details
            <small></small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table id="<?php echo $userBusiList["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Established</th>
                                    <th>STC</th>
                                    <th>TIN</th>
                                    <th>Website</th>
                                    <th>Proof ID</th>
                                    <th>Proof Type</th>
                                    <th>Proof Picture</th>
                                    <th>User Type</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $userBusiList["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
