<?php
$ReceiptRepo = isset($this->idHolders["tamboola"]["reports"]["ReceiptRepo"]) ? (array) $this->idHolders["tamboola"]["reports"]["ReceiptRepo"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reports
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Reports</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <h3 class="box-header">Receipts Report</h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box-body" id="userbox">
                                    <form class="form-horizontal"
                                          action=""
                                          id="<?php echo $ReceiptRepo["form"]; ?>"
                                          name="<?php echo $ReceiptRepo["form"]; ?>"
                                          method="post">
                                        <!-- form id-->
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Name / Email</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control"
                                                           id="<?php echo $ReceiptRepo["fields"][0]; ?>"
                                                           name="<?php echo $ReceiptRepo["fields"][0]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter Date"}'
                                                           placeholder="Name or Email" type="text" style="cursor:pointer">
                                                    <span class="text-success"><!--
                                                   <input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
                                                        --></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Date</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control"
                                                               id="<?php echo $ReceiptRepo["fields"][1]; ?>"
                                                               name="<?php echo $ReceiptRepo["fields"][1]; ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter Date"}'
                                                               placeholder="Enter Date" type="text" style="cursor:pointer">
                                                        <span class="text-success"><!--
                                                       <input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
                                                            --></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Amount</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control"
                                                           id="<?php echo $ReceiptRepo["fields"][2]; ?>"
                                                           name="<?php echo $ReceiptRepo["fields"][2]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter Date"}'
                                                           placeholder="Enter Amount" type="text" style="cursor:pointer">
                                                    <span class="text-success"><!--
                                                   <input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
                                                        --></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Receipt Number</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control"
                                                               id="<?php echo $ReceiptRepo["fields"][3]; ?>"
                                                               name="<?php echo $ReceiptRepo["fields"][3]; ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter Date"}'
                                                               placeholder="Receipt Number" type="text" style="cursor:pointer">
                                                        <span class="text-success"><!--
                                                       <input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
                                                            --></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-5 col-sm-11">
                                                <button type="submit"
                                                        class="btn btn-primary"
                                                        id="<?php echo $ReceiptRepo["fields"][4]; ?>"
                                                        name="<?php echo $ReceiptRepo["fields"][4]; ?>"
                                                        style="margin-top: 21px"
                                                        data-rules='{}'
                                                        data-messages='{}'><strong>Search</strong></button>
                                            </div>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-12" id="rec_output_load"></div>
                        <div class="col-lg-12" id="rec_output"></div><!--receipt display-->
                        <div class="col-lg-12" id="rec_output_display"></div><!--End-->
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div>