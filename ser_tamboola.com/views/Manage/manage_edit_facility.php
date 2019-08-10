<?php
$AddFac = isset($this->idHolders["tamboola"]["manage"]["EditFacilities"]) ? (array) $this->idHolders["tamboola"]["manage"]["EditFacilities"] : false;
?>
<!-- Enquiry add -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Facilities
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Facilities
            </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content">
                    <div class="box">
                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Facilities</h3>
                                    <div class="box-tools">
                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class="active">
                                            <a href="#Add" data-toggle="tab">
                                                <i class="fa fa-arrow-right"></i>
                                                Edit
                                                <span class="label label-primary pull-right">&nbsp;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div><!-- /.box-body -->
                            </div><!-- /. box -->
                        </div>
                        <div class="tab-content">
                            <div class="active tab-pane" id="Add">
                                <!-- The timeline -->
                                <form class="form-horizontal"
                                      action=""
                                      id="<?php echo $AddFac["form"]; ?>"
                                      name="<?php echo $AddFac["form"]; ?>"
                                      method="post">
                                    <div class="content">
                                        <!-- Main content -->
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-9">
                                                    <div class="box">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title"><strong>Add Facility</strong></h3>
                                                        </div>
                                                        <div class="box-body" id="userbox">
                                                            <input type="hidden"
                                                                   name="<?php echo $AddFac["fields"][3]; ?>"
                                                                   id="<?php echo $AddFac["fields"][3]; ?>"
                                                                   data-rules='{}'
                                                                   data-messages='{}'
                                                                   value="<?php echo base64_encode($this->ManageDets["data"]["id"]); ?>" />
                                                            <div class="col-sm-11">
                                                                <div class="form-group">
                                                                    <div class="col-sm-14">
                                                                        <label for="inputregfee" class="col-sm-2 control-label">Facility Name </label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="<?php echo $AddFac["fields"][0]; ?>"
                                                                                   name="<?php echo $AddFac["fields"][0]; ?>"
                                                                                   value="<?php echo trim($this->ManageDets["data"]["name"]); ?>"
                                                                                   data-rules='{"required": true}'
                                                                                   data-messages='{"required": "Enter Facility Name"}'
                                                                                   placeholder="Facility Name " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-11">
                                                                <div class="form-group">
                                                                    <label for="inputgymtype" class="col-sm-2 control-label">Status</label>
                                                                    <div class="col-sm-10">
                                                                        <select class="form-control"
                                                                                id="<?php echo $AddFac["fields"][1]; ?>"
                                                                                name="<?php echo $AddFac["fields"][1]; ?>"
                                                                                value="<?php echo trim($this->ManageDets["data"]["status"]); ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Status"}'>
                                                                            <option>show</option>
                                                                            <option>hide</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-offset-5 col-sm-10">
                                                                    <button type="submit"
                                                                            id="<?php echo $AddFac["fields"][2]; ?>"
                                                                            name="<?php echo $AddFac["fields"][2]; ?>"
                                                                            data-rules='{}'
                                                                            data-messages='{}'
                                                                            class="btn btn-primary">Save Details</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.box -->
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->
                                        </section><!-- /.content -->
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.tab-content -->
                        <!-- /.nav-tabs-custom -->
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var this_js_script = $("script[src$='Manage.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In Manage');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'Manage/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).tamboola.manage;
                var obj = new manageController();
                obj.__constructor(para);
                obj.__EditFacilityEvents();
            }
            else {
                LogMessages('I am Out Manage');
            }
        }
    });

</script>











