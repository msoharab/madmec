<?php ?>
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>List Operators</strong></h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="<?php echo $opslist["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operator Name</th>
                                    <th>Service Name</th>
                                    <th>Operator LT Code</th>
                                    <th>Operator Alias</th>
                                    <th>Flat Commission</th>
                                    <th>Variable Commission</th>
                                    <th>Started At</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $opslist["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
