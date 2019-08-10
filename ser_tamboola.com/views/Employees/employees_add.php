<?php
$empAdd = isset($this->idHolders["tamboola"]["employees"]["AddEmployees"]) ? (array) $this->idHolders["tamboola"]["employees"]["AddEmployees"] : false;
?>
<div class="content-wrapper">
    <div class="content">
        <section class="content-header">
            <h1>
                Employees
                <small></small>
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
            <div class="row">
                <div class="col-xs-12">
                    <div class="tab-content">
                        <form class="form-horizontal"
                              action=""
                              id="<?php echo $empAdd["form"]; ?>"
                              name="<?php echo $empAdd["form"]; ?>"
                              method="post">
                            <div class="content">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Add Employee</strong></h3>
                                    </div>
                                    <div class="box-body" id="userbox">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputphone" class="col-sm-1 control-label">Name</label>
                                                <div class="col-sm-5 col-sm-offset-0">
                                                    <input type="text"
                                                           class="form-control"
                                                           id="<?php echo $empAdd["fields"][0]; ?>"
                                                           name="<?php echo $empAdd["fields"][0]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter Name"}'
                                                           placeholder="Name" />
                                                </div>
                                                <label for="inputregfee" class="col-sm-1 control-label">Date Of Birth</label>
                                                <div class="col-sm-5">
                                                    <input name="<?php echo $empAdd["fields"][1]; ?>"
                                                           id="<?php echo $empAdd["fields"][1]; ?>"
                                                           type="text"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter Date Of Birth"}'
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputgymtype" class="col-sm-1 control-label">Gender</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control"
                                                            id="<?php echo $empAdd["fields"][2]; ?>"
                                                            name="<?php echo $empAdd["fields"][2]; ?>"
                                                            data-rules='{"required": true}'
                                                            data-messages='{"required": "Select Gender"}'>
                                                    </select>
                                                </div>
                                                <label for="inputphone" class="col-sm-1 control-label">Email Id</label>
                                                <div class="col-sm-5">
                                                    <input type="text"
                                                           class="form-control"
                                                           id="<?php echo $empAdd["fields"][1]; ?>"
                                                           name="<?php echo $empAdd["fields"][1]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter Email Id"}'
                                                           placeholder="Email Id" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputgymName" class="col-sm-1 control-label">Cell Code</label>
                                                <div class="col-sm-5">
                                                    <input type="text"
                                                           class="form-control"
                                                           id="<?php echo $empAdd["fields"][5]; ?>"
                                                           name="<?php echo $empAdd["fields"][5]; ?>"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter Cell Code"}'
                                                           placeholder="+91">
                                                </div>
                                                <label for="inputgymName" class="col-sm-1 control-label">Cell Number</label>
                                                <div class="col-sm-5">
                                                    <input type="text"
                                                           class="form-control"
                                                           id="<?php echo $empAdd["fields"][6]; ?>"
                                                           name="<?php echo $empAdd["fields"][6]; ?>"
                                                           data-rules='{"required": true,"maxlength": "15"}'
                                                           data-messages='{"required": "Enter Cell Number","maxlength": "Length Should be maximum 15 numbers"}'
                                                           placeholder="Cell Number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box collapsed-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Facility</strong></h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div><!-- /.box-tools -->
                                    </div><!-- /.box-header -->
                                    <div class="box-body" id="addbox">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputsertax" class="col-sm-1 control-label">Date Of Join</label>
                                                <div class="col-sm-11">
                                                    <input name="<?php echo $empAdd["fields"][8]; ?>"
                                                           id="<?php echo $empAdd["fields"][8]; ?>"
                                                           type="text"
                                                           data-rules='{"required": true}'
                                                           data-messages='{"required": "Enter Date Of Join"}'
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputgymtype" class="col-sm-1 control-label">Facility Type</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control"
                                                            id="<?php echo $empAdd["fields"][3]; ?>"
                                                            name="<?php echo $empAdd["fields"][3]; ?>"
                                                            data-rules='{"required": true}'
                                                            data-messages='{"required": "Select Facility Type"}'>
                                                    </select>
                                                </div>
                                                <label for="inputgymtype" class="col-sm-1 control-label">Employee Type</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control"
                                                            id="<?php echo $empAdd["fields"][4]; ?>"
                                                            name="<?php echo $empAdd["fields"][4]; ?>"
                                                            data-rules='{"required": true}'
                                                            data-messages='{"required": "Select Employee Type"}'>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-6 col-sm-11">
                                        <button type="submit"
                                                class="btn btn-primary"
                                                id="<?php echo $empAdd["fields"][9]; ?>"
                                                name="<?php echo $empAdd["fields"][9]; ?>"
                                                data-rules='{}'
                                                data-messages='{}'>Save Details</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
