<?php
$empimprt = isset($this->idHolders["tamboola"]["employees"]["ImportEmployees"]) ? (array) $this->idHolders["tamboola"]["employees"]["ImportEmployees"] : false;
?>
<!-- Enquiry add -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employees
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Employees</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form class="form-horizontal"
              action="control.php"
              method="post"
              name="<?php echo $empimprt["form"]; ?>"
              id="<?php echo $empimprt["form"]; ?>"
              enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Import Employees</strong></h3>
                        </div>
                        <div class="box-body" id="userbox">
                            <!-- light box Start -->
                            <div id="center_loader" style="display:none;"></div>
                            <div id="fadebody" class="black_overlay_body"></div>
                            <div id="lbchangeimg" class="white_content_body" align="center"></div><!-- light box End -->
                            <!-- BS integration starts here -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div id="output">
                                                <div id="user_import">
                                                    <input type="hidden" name="action1" value="uploadFile"> <input type="hidden" name="autoloader" value="true"> <input type="hidden" name="type" value="master"> <input type="hidden" name="gym_id" id="gym_id">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="inputgymtype" class="col-sm-1 control-label">Facility Type</label>
                                                                    <div class="col-sm-10">
                                                                        <select class="form-control"
                                                                                id="<?php echo $empimprt["fields"][0]; ?>"
                                                                                name="<?php echo $empimprt["fields"][0]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Facility Type"}'>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="inputgymtype" class="col-sm-1 control-label">Trainer Type</label>
                                                                    <div class="col-sm-10">
                                                                        <select class="form-control"
                                                                                id="<?php echo $empimprt["fields"][1]; ?>"
                                                                                name="<?php echo $empimprt["fields"][1]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Trainer Type"}'>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="inputgymtype" class="col-sm-1 control-label">Select file</label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file"
                                                                               name="<?php echo $empimprt["fields"][2]; ?>"
                                                                               id="<?php echo $empimprt["fields"][2]; ?>"
                                                                               data-rules='{"required": true}'
                                                                               data-messages='{"required": "Select file"}'>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-12 col-sm-offset-5">
                                                                <div class="form-group">
                                                                    <span>&nbsp;<label>Example File</label></span>
                                                                </div>
                                                                <div id="dissamplefileformat"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-5 col-sm-11">
                                                        <button type="submit"
                                                                class="btn btn-primary"
                                                                id="<?php echo $empimprt["fields"][3]; ?>"
                                                                name="<?php echo $empimprt["fields"][3]; ?>"
                                                                data-rules='{}'
                                                                data-messages='{}'>Upload File to Server</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12" align="center">
                                                        <div class="progress">
                                                            <div class="bar"></div>
                                                            <div class="percent">
                                                                0%
                                                            </div>
                                                        </div>
                                                        <div id="status"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.col-lg-12 -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
