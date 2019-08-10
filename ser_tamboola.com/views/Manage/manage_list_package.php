<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3 col-xs-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h2 class="box-title">List of Package</h2>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active">
                            <a href="#info" data-toggle="tab" id="<?php echo $PersPackages["btnDiv"];  ?>">
                                <i class="fa fa-arrow-right"></i>
                                Edit / Deactivate Packages
                                <span class="label label-primary pull-right">&nbsp;</span>
                            </a>
                        </li>
                        <li>
                            <a href="#bank" data-toggle="tab" id="<?php echo $NutriPackages["btnDiv"];  ?>">
                                <i class="fa fa-arrow-right"></i>
                                Edit / Activate Packages
                                <span class="label label-primary pull-right">&nbsp;</span>
                            </a>
                        </li>
                        <li class="hidden">
                            <a href="#currency" data-toggle="tab" id="<?php echo $FitPackages["btnDiv"];  ?>">
                                <i class="fa fa-arrow-right"></i>
                                Fitness assessment
                                <span class="label label-primary pull-right">&nbsp;</span>
                            </a>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->
        </div><!-- /.col -->
        <div class="col-md-9 col-xs-12">
            <div class="tab-content">
                <div class="active tab-pane" id="info">
                    <section class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Edit / Deactivate Packages</strong></h3>
                                    </div>
                                    <div class="box-body table-responsive">
                                        <table id="<?php echo $PersPackages["fields"][0]; ?>"
                                               class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Package name</th>
                                                    <th>Package type</th>
                                                    <th>Facility</th>
                                                    <th>Min Members</th>
                                                    <th>Number of Sessions</th>
                                                    <th>Cost</th>
                                                    <th>Description</th>
                                                    <th>View</th>
                                                    <th>Edit</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="<?php echo $PersPackages["fields"][1]; ?>">
                                            </tbody>
                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </section><!-- /.content -->
                </div>
                <!-- /.tab-content -->
                <div class="tab-pane" id="bank">
                    <section class="content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Edit / Activate Packages</strong></h3>
                                    </div>
                                    <div class="box-body table-responsive">
                                        <table id="<?php echo $NutriPackages["fields"][0]; ?>"
                                               class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Package name</th>
                                                    <th>Package type</th>
                                                    <th>Facility</th>
                                                    <th>Min Members</th>
                                                    <th>Number of Sessions</th>
                                                    <th>Cost</th>
                                                    <th>Description</th>
                                                    <th>View</th>
                                                    <th>Edit</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="<?php echo $NutriPackages["fields"][1]; ?>">
                                            </tbody>
                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </section><!-- /.content -->
                </div>
                <!-- currency -->
                <div class="tab-pane" id="currency">
                    <section class="content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Fitness assessment</strong></h3>
                                    </div>
                                    <div class="box-body table-responsive">
                                        <table id="<?php echo $FitPackages["fields"][0]; ?>"
                                               class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Package type</th>
                                                    <th>Number of Sessions</th>
                                                    <th>Cost</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody id="<?php echo $FitPackages["fields"][1]; ?>">
                                            </tbody>
                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </section><!-- /.content -->
                </div>
            </div>
        </div><!-- /.col -->
    </div>
</section>
