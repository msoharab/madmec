<?php 
$gymList = isset($this->idHolders["onlinefood"]["restaurant"]["ListRestaurant"]) ? (array) $this->idHolders["onlinefood"]["restaurant"]["ListRestaurant"] : false;
?>
<div class="content">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>List Restaurant</strong></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="<?php echo $gymList["fields"][0]; ?>" class="table table-bordered
                               table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Restaurant Name</th>
                                    <th>Restaurant Type</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Cell Number</th>
                                    <th>Registration Fee</th>
                                    <th>Address</th>
                                    <th>View</th>
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
