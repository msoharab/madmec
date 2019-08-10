<?php ?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#Compose1" data-toggle="tab">Compose</a></li>
        <li><a href="#Outbox1" data-toggle="tab">Outbox</a></li>
    </ul>
    <div class="tab-content">
        <div class="active tab-pane" id="Compose1">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Compose New Message</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <input class="form-control" id="id" name="" placeholder="To:">
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="id" name="" placeholder="Subject:">
                    </div>
                    <div class="form-group">
                        <textarea id="compose-textarea" class="form-control" style="height: 300px"></textarea>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" id="id" name="" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                </div><!-- /.box-footer -->
            </div>
            <!-- /. box -->
        </div>
        <div class="tab-pane" id="Outbox1">
            <div class="content">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Outbox
                    </h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive"
                                     id="">
                                    <table id="example1" class="table table-bordered table-striped">
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
                                            </tr>
                                        </thead>
                                        <tbody id="">
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
