<?php
$AppTraf = isset($this->idHolders["recharge"]["masterdata"]["ListTraffic"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListTraffic"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listtraf" data-toggle="tab">List</a></li>
    </ul>
    <div class="tab-content">
        <div class="active tab-pane" id="listtraf">
            <div class="content">
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong> Traffic List</strong></h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $AppTraf["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Traffic Ip</th>
                                                <th>Traffic Host</th>
                                                <th>Organisation</th>
                                                <th>Traffic Isp</th>
                                                <th>Traffic Hit Time</th>
                                                <th>City</th>
                                                <th>Country</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $AppTraf["fields"][1]; ?>">
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
            </div>
        </div>
    </div><!-- /.nav-tabs-custom -->
</div>