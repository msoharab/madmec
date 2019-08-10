<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>List Offer</strong></h3>
                </div>
                <div class="box-body table-responsive">
                    <table id="<?php echo $ListOffers["fields"][0]; ?>" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Offer Name</th>
                                <th>Duration</th>
                                <th>Facility</th>
                                <th>Cost</th>
                                <th>Min Members</th>
                                <th >Description</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="<?php echo $ListOffers["fields"][1]; ?>">
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
