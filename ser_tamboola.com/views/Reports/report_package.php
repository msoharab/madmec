<?php
$PackRepo = isset($this->idHolders["tamboola"]["reports"]["PackageRepo"]) ? (array) $this->idHolders["tamboola"]["reports"]["PackageRepo"] : false;
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
                        <h3 class="box-header">Package Report</h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box-body" id="ff">
                                    <form class="form-horizontal"
                                          action=""
                                          id="<?php echo $PackRepo["form"]; ?>"
                                          name="<?php echo $PackRepo["form"]; ?>"
                                          method="post">
                                        <!-- form id-->
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label">From:</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control"
                                                           id="<?php echo $PackRepo["fields"][0]; ?>"
                                                           name="<?php echo $PackRepo["fields"][0]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter Date"}'
                                                           placeholder="Enter Date" type="text" style="cursor:pointer">
                                                    <span class="text-success"><!--
                                                   <input type="text" id="alternate1" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
                                                        --></span>
                                                </div>
                                                <label class="col-sm-1 control-label">To :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control"
                                                           id="<?php echo $PackRepo["fields"][1]; ?>"
                                                           name="<?php echo $PackRepo["fields"][1]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter Date"}'
                                                           placeholder="Enter Date" type="text" style="cursor:pointer">
                                                    <span class="text-success"><!--
                                                   <input type="text" id="alternate2" size="30" readonly="readonly" class="form-control" style="border:hidden;"/>
                                                        --></span>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="submit"
                                                                class="btn btn-primary"
                                                                id="<?php echo $PackRepo["fields"][2]; ?>"
                                                                name="<?php echo $PackRepo["fields"][2]; ?>"
                                                                data-rules='{}'
                                                                data-messages='{}'><strong>Generate</strong></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-12" id="pacOutput"></div><!--output id-->
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
