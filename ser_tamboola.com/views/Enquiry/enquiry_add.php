<?php
$AddEnq = isset($this->idHolders["tamboola"]["enquiry"]["AddEnquiry"]) ? (array) $this->idHolders["tamboola"]["enquiry"]["AddEnquiry"] : false;
?>
<!-- Enquiry add -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Enquiry
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Enquiry</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content">
                    <!-- Add Enquiry start -->
                    <form class="form-horizontal"
                          action=""
                          id="<?php echo $AddEnq["form"]; ?>"
                          name="<?php echo $AddEnq["form"]; ?>"
                          method="post">
                        <div class="content">
                            <section class="content-header">
                                <h1>
                                    Add Enquiry
                                    <small></small>
                                </h1>
                            </section>
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><strong>Enquiry Details</strong></h3>
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusinessdate" class="col-sm-1 control-label">Referrer</label>
                                                        <div class="col-sm-11">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddEnq["fields"][0]; ?>"
                                                                   name="<?php echo $AddEnq["fields"][0]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter Name"}'
                                                                   placeholder="Referrer" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbusiness" class="col-sm-1 control-label">Attender</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddEnq["fields"][1]; ?>"
                                                                   name="<?php echo $AddEnq["fields"][1]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter Name"}'
                                                                   placeholder="Attender" type="text">
                                                        </div>
                                                        <label for="inputbusinessdate" class="col-sm-1 control-label">Visitor</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddEnq["fields"][2]; ?>"
                                                                   name="<?php echo $AddEnq["fields"][2]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter visitor"}'
                                                                   placeholder="Visitor Name" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputowner" class="col-sm-1 control-label">Email Id</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddEnq["fields"][3]; ?>"
                                                                   name="<?php echo $AddEnq["fields"][3]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter valid email"}'
                                                                   placeholder="Email Id" type="email">
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
                                            </div><!-- /.box-body -->
                                        </div>
                                        <div class="box collapsed-box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><strong>Follow-up</strong></h3>
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div><!-- /.box-tools -->
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-1 control-label2">First Follow-up</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddEnq["fields"][5]; ?>"
                                                                   name="<?php echo $AddEnq["fields"][5]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter follow up Date"}'
                                                                   placeholder="Enter Date" type="text">
                                                        </div>
                                                        <label for="inputaccount" class="col-sm-1 control-label1">Second Follow-up</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddEnq["fields"][6]; ?>"
                                                                   name="<?php echo $AddEnq["fields"][6]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter follow up Date"}'
                                                                   placeholder="Enter Date" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputbank" class="col-sm-1 control-labe2">Third Follow-up</label>
                                                        <div class="col-sm-11">
                                                            <input class="form-control"
                                                                   id="<?php echo $AddEnq["fields"][7]; ?>"
                                                                   name="<?php echo $AddEnq["fields"][7]; ?>"
                                                                   data-rules='{"required": true}'
                                                                   data-messages='{"required": "Enter follow up Date"}'
                                                                   placeholder="Enter Date" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box collapsed-box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><strong>How Do You Know About Us</strong></h3>
                                                <div class="box-tools pull-right">
                                                    <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div><!-- /.box-tools -->
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputabout" class="col-sm-1 control-label">About</label>
                                                        <div class="col-sm-11">
                                                            <select class="form-control"
                                                                    id="<?php echo $AddEnq["fields"][8]; ?>"
                                                                    name="<?php echo $AddEnq["fields"][8]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Option"}'></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputinterestedin" class="col-sm-1 control-label">Interested In</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $AddEnq["fields"][9]; ?>"
                                                                    name="<?php echo $AddEnq["fields"][9]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select Option"}'></select>
                                                        </div>
                                                        <label for="inputdoctype" class="col-sm-1 control-label1">Joining Probability</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control"
                                                                    id="<?php echo $AddEnq["fields"][10]; ?>"
                                                                    name="<?php echo $AddEnq["fields"][10]; ?>"
                                                                    data-rules='{"required": true}'
                                                                    data-messages='{"required": "Select joining"}'>
                                                                <option value="selectVal" selected>Select joining</option>
                                                                <option value="Today">Today</option>
                                                                <option value="2">After 2 days</option>
                                                                <option value="4">After 4 days</option>
                                                                <option value="7">After a week</option>
                                                                <option value="30">After a month</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputsertax" class="col-sm-1 control-label">Fitness Goal </label>
                                                        <div class="col-sm-11">
                                                            <textarea class="form-control"
                                                                      id="<?php echo $AddEnq["fields"][11]; ?>"
                                                                      name="<?php echo $AddEnq["fields"][11]; ?>"
                                                                      rows="5"
                                                                      placeholder="Fitness Goal"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputsertax" class="col-sm-1 control-label">Comments</label>
                                                        <div class="col-sm-11">
                                                            <textarea class="form-control"
                                                                      id="<?php echo $AddEnq["fields"][12]; ?>"
                                                                      name="<?php echo $AddEnq["fields"][12]; ?>"
                                                                      rows="5"
                                                                      placeholder="Comments"></textarea>
                                                        </div>
                                                    </div>
                                                </div><!-- /.box-body -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-5 col-sm-10">
                                                <button type="submit"
                                                        class="btn btn-primary"
                                                        id="<?php echo $AddEnq["fields"][13]; ?>"
                                                        name="<?php echo $AddEnq["fields"][13]; ?>"
                                                        data-rules='{}'
                                                        data-messages='{}'><strong>Submit Details</strong></button>
                                            </div>
                                        </div>
                                        </section>
                                    </div>
                                    </form>
                                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_open" id="myModal_enqaddbtn" style="display: none;"></button>
                                    <div class="modal fade" id="myModal_open" tabindex="-1" role="dialog" aria-labelledby="myModal_open" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModal_title">Alert</h4>
                                                </div>
                                                <div class="modal-body" id="myModal_enqaddbody">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- modal over -->
                                    </div><!-- Add Enquiry End -->
                                </div>
                        </div>
                </div>
                </section>
            </div>
            <script type="text/javascript">
                $(document).ready(function () {
                    var this_js_script = $("script[src$='Enquiry.js']");
                    if (this_js_script) {
                        var flag = this_js_script.attr('data-autoloader');
                        if (flag === 'true') {
                            LogMessages('I am In Enquiry');
                            var para = getJSONIds({
                                autoloader: true,
                                action: 'getIdHolders',
                                url: URL + 'User/getIdHolders',
                                type: 'POST',
                                dataType: 'JSON'
                            }).tamboola.enquiry;
                            var obj = new enquiryController();
                            obj.__constructor(para);
                            obj.__AddEnquiry();
                        }
                        else {
                            LogMessages('I am Out Enquiry');
                        }
                    }
                });
            </script>
