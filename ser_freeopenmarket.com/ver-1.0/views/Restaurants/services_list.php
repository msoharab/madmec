<?php
$serviceList = isset($this->idHolders["recharge"]["masterdata"]["ListService"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListService"] : false;
?>
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>List Services</strong></h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="<?php echo $serviceList["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company</th>
                                    <th>Service Name</th>
                                    <th>Service LT Code</th>
                                    <th>Flat Commission</th>
                                    <th>Variable Commission</th>
                                    <th>Started At</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $serviceList["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
