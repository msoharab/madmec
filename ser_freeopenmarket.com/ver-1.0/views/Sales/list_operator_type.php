<?php
$optypelist = isset($this->idHolders["onlinefood"]["gateway"]["ListOperatorType"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["ListOperatorType"] : false;
?>
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List Operator Types
            <small></small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table id="<?php echo $optypelist["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operator Name</th>
                                    <th>Gateway Name</th>
                                    <th>Operator Type</th>
                                    <th>Operator Type LT Code</th>
                                    <th>Flat Commission</th>
                                    <th>Variable Commission</th>
                                    <th>Started At</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $optypelist["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
