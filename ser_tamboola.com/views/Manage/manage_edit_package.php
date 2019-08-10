<?php
$AddPackages = isset($this->idHolders["tamboola"]["manage"]["EditPackages"]) ? (array) $this->idHolders["tamboola"]["manage"]["EditPackages"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Packages
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Packages </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#add" data-toggle="tab">Edit Package</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="add">
                            <div class="content">
                                <form class="form-horizontal"
                                      action=""
                                      id="<?php echo $AddPackages["form"]; ?>"
                                      name="<?php echo $AddPackages["form"]; ?>"
                                      method="post">
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title"><strong>Edit Package</strong></h3>
                                                    </div>
                                                    <div class="box-body" id="userbox">
                                                        <input type="hidden"
                                                               name="<?php echo $AddPackages["fields"][8]; ?>"
                                                               id="<?php echo $AddPackages["fields"][8]; ?>"
                                                               data-rules='{}'
                                                               data-messages='{}'
                                                               value="<?php echo ($this->ManageDets["data"]["offid"]); ?>" />
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputgymtype" class="col-sm-1 control-label">Package Type</label>
                                                                    <div class="col-sm-5">
                                                                        <select class="form-control"
                                                                                id="<?php echo $AddPackages["fields"][0]; ?>"
                                                                                name="<?php echo $AddPackages["fields"][0]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Status"}' 
                                                                                value="<?php echo ($this->ManageDets["data"]["ptype"]); ?>">
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputphone" class="col-sm-1 control-label">Facility</label>
                                                                    <div class="col-sm-5">
                                                                        <select class="form-control"
                                                                                id="<?php echo $AddPackages["fields"][1]; ?>"
                                                                                name="<?php echo $AddPackages["fields"][1]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Status"}' 
                                                                                value="<?php echo ($this->ManageDets["data"]["offfaci"]); ?>">
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputphone" class="col-sm-1 control-label">Package Name</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $AddPackages["fields"][2]; ?>"
                                                                               name="<?php echo $AddPackages["fields"][2]; ?>"
                                                                               data-rules='{"required": true}'
                                                                               data-messages='{"required": "Enter Offer Name"}'
                                                                               value="<?php echo ($this->ManageDets["data"]["offname"]); ?>" />
                                                                    </div>
                                                                    <label for="inputgymtype" class="col-sm-1 control-label">Minimum Members</label>
                                                                    <div class="col-sm-5">
                                                                        <select class="form-control"
                                                                                id="<?php echo $AddPackages["fields"][3]; ?>"
                                                                                name="<?php echo $AddPackages["fields"][3]; ?>"
                                                                                value="<?php echo trim($this->ManageDets["data"]["min_members_id"]); ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Duration"}' 
                                                                                value="<?php echo ($this->ManageDets["data"]["offmem"]); ?>">
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputgymName" class="col-sm-1 control-label">Number Of Session</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $AddPackages["fields"][4]; ?>"
                                                                               name="<?php echo $AddPackages["fields"][4]; ?>"
                                                                               data-rules='{"required": true}'
                                                                               data-messages='{"required": "Enter number of Sessions"}'
                                                                               placeholder="Number Of Session" 
                                                                               value="<?php echo ($this->ManageDets["data"]["facsess"]); ?>" />
                                                                    </div>
                                                                    <label for="inputgymName" class="col-sm-1 control-label">Price</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $AddPackages["fields"][5]; ?>"
                                                                               name="<?php echo $AddPackages["fields"][5]; ?>"
                                                                               data-rules='{"required": true}'
                                                                               data-messages='{"required": "Enter The Price"}'
                                                                               placeholder="Amount" 
                                                                               value="<?php echo ($this->ManageDets["data"]["offcost"]); ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputgymName" class="col-sm-2 control-label">Description</label>
                                                                    <div class="col-sm-5">
                                                                        <textarea
                                                                               class="form-control"
                                                                               id="<?php echo $AddPackages["fields"][6]; ?>"
                                                                               name="<?php echo $AddPackages["fields"][6]; ?>"
                                                                               data-rules='{"required": true}'
                                                                               data-messages='{"required": "Enter number of Sessions"}'
                                                                               placeholder="Description"><?php echo ($this->ManageDets["data"]["offdesc"]); ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-11">
                                            <button type="submit"
                                                    id="<?php echo $AddPackages["fields"][7]; ?>"
                                                    name="<?php echo $AddPackages["fields"][7]; ?>"
                                                    data-rules='{}'
                                                    data-messages='{}'
                                                    class="btn btn-primary">Save Details</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div><!-- /.tab-content -->
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </section>
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
                obj.__EditPackageEvents();
            }
            else {
                LogMessages('I am Out Manage');
            }
        }
    });

</script>
<!-- Main content -->












