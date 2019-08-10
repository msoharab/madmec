<?php
$addOrderFol = isset($this->idHolders["tamboola"]["orders"]["AddOrderFol"]) ? (array) $this->idHolders["tamboola"]["orders"]["AddOrderFol"] : false;
$listOrderFol = isset($this->idHolders["tamboola"]["orders"]["ListOrderFol"]) ? (array) $this->idHolders["tamboola"]["orders"]["ListOrderFol"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Orders
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Orders</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="colls_menu">
                        <li class="active"><a href="#add_order_follow_ups" data-toggle="tab" id="addcollection">Add Follow Ups</a></li>
                        <li><a href="#list_order_follow_ups" data-toggle="tab" id="listcollsbut">List Follow Ups</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="add_order_follow_ups">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><strong>Add Order Follow-up</strong></h3>
                                            </div>
                                            <div class="box-body" id="userbox">
                                                <form class="form-horizontal"
                                                      action=""
                                                      id="<?php echo $addOrderFol["form"]; ?>"
                                                      name="<?php echo $addOrderFol["form"]; ?>"
                                                      method="post">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputphone" class="col-sm-1 control-label">Client Name</label>
                                                            <div class="col-sm-5">
                                                                <input class="form-control"
                                                                       id="<?php echo $addOrderFol["fields"][0]; ?>"
                                                                       name="<?php echo $addOrderFol["fields"][0]; ?>"
                                                                       data-rules='{"required": true}'
                                                                       data-messages='{"required": "Enter Name"}'
                                                                       placeholder="Client Name" type="text">
                                                            </div>
                                                            <label for="inputowner" class="col-sm-1 control-label">Cell Number</label>
                                                            <div class="col-sm-5">
                                                                <input class="form-control"
                                                                       id="<?php echo $AddEnq["fields"][4]; ?>"
                                                                       name="<?php echo $AddEnq["fields"][4]; ?>"
                                                                       maxlength="10"
                                                                       data-rules='{"required": true}'
                                                                       data-messages='{"required": "Cell Number"}'
                                                                       placeholder="Cell Number" type="Cell Number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputphone" class="col-sm-1 control-label">Email</label>
                                                            <div class="col-sm-5">
                                                                <input class="form-control"
                                                                       id="<?php echo $addOrderFol["fields"][2]; ?>"
                                                                       name="<?php echo $addOrderFol["fields"][2]; ?>"
                                                                       data-rules='{"required": true}'
                                                                       data-messages='{"required": "Enter Email Id"}'
                                                                       placeholder="Email" type="email">
                                                            </div>
                                                            <label for="inputphone" class="col-sm-1 control-label">Handled By</label>
                                                            <div class="col-sm-5">
                                                                <input class="form-control"
                                                                       id="<?php echo $addOrderFol["fields"][3]; ?>"
                                                                       name="<?php echo $addOrderFol["fields"][3]; ?>"
                                                                       data-rules='{"required": true}'
                                                                       data-messages='{"required": "Enter Name"}'
                                                                       placeholder="Handeled By" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputphone" class="col-sm-1 control-label">Referenced By</label>
                                                            <div class="col-sm-5">
                                                                <input class="form-control"
                                                                       id="<?php echo $addOrderFol["fields"][4]; ?>"
                                                                       name="<?php echo $addOrderFol["fields"][4]; ?>"
                                                                       data-rules='{"required": true}'
                                                                       data-messages='{"required": "Enter Name"}'
                                                                       placeholder="Referenced By" type="text">
                                                            </div>
                                                            <label for="inputphone" class="col-sm-1 control-label">Order Probability</label>
                                                            <div class="col-sm-5">
                                                                <input class="form-control"
                                                                       id="<?php echo $addOrderFol["fields"][5]; ?>"
                                                                       name="<?php echo $addOrderFol["fields"][5]; ?>"
                                                                       data-rules='{"required": true}'
                                                                       data-messages='{"required": "Enter Probability"}'
                                                                       placeholder="Order Probability" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-5 col-sm-11">
                                                            <button type="submit"
                                                                    class="btn btn-primary"
                                                                    id="<?php echo $addOrderFol["fields"][6]; ?>"
                                                                    name="<?php echo $addOrderFol["fields"][6]; ?>"
                                                                    data-rules='{}'
                                                                    data-messages='{}'><strong>Save Details</strong></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="tab-pane fade" id="list_order_follow_ups">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><strong> follow ups list</strong></h3>
                                            </div>
                                            <div class="box-body table-responsive">
                                                <table id="<?php echo $listOrderFol["fields"][0]; ?>" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Client Name</th>
                                                            <th>Cell Number</th>
                                                            <th>Email</th>
                                                            <th>Handled By</th>
                                                            <th>Referenced By</th>
                                                            <th>Order Probability</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="<?php echo $listOrderFol["fields"][1]; ?>">
                                                    </tbody>
                                                </table>
                                            </div><!-- /.box-body -->
                                        </div><!-- /.box -->
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </section><!-- /.content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
