<?php
$AdmiAdd = isset($this->idHolders["tamboola"]["managers"]["AddManager"]) ? (array) $this->idHolders["tamboola"]["managers"]["AddManager"] : false;
$AdmiList = isset($this->idHolders["tamboola"]["managers"]["ListManager"]) ? (array) $this->idHolders["tamboola"]["managers"]["ListManager"] : false;
$AdmiAssign = isset($this->idHolders["tamboola"]["managers"]["AssignManager"]) ? (array) $this->idHolders["tamboola"]["managers"]["AssignManager"] : false;
?>
<div class="content-wrapper">
    <div class="content">
        <section class="content-header">
            <h1>
                Managers
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="active">Managers</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#add" data-toggle="tab">Add Admin</a></li>
                            <li><a href="#list" data-toggle="tab">List Admins</a></li>
                            <li><a href="#assign" data-toggle="tab">Assign Admin</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="add">
                                <form class="form-horizontal"
                                      action=""
                                      id="<?php echo $AdmiAdd["form"]; ?>"
                                      name="<?php echo $AdmiAdd["form"]; ?>"
                                      method="post">
                                    <div class="content">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title"><strong>Add New Admin</strong></h3>
                                                        </div>
                                                        <div class="box-body" id="userbox">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="inputregfee" class="col-sm-1 control-label">Name </label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="<?php echo $AdmiAdd["fields"][0]; ?>"
                                                                               name="<?php echo $AdmiAdd["fields"][0]; ?>"
                                                                               data-rules='{"required": true}'
                                                                               data-messages='{"required": "Enter Name"}'
                                                                               placeholder="Name" />
                                                                    </div>
                                                                    <label for="inputgymtype" class="col-sm-1 control-label">Gender</label>
                                                                    <div class="col-sm-5">
                                                                        <select class="form-control"
                                                                                id="<?php echo $AdmiAdd["fields"][1]; ?>"
                                                                                name="<?php echo $AdmiAdd["fields"][1]; ?>"
                                                                                data-rules='{"required": true}'
                                                                                data-messages='{"required": "Select Gender"}'>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputregfee" class="col-sm-1 control-label">Date of birth </label>
                                                                <div class="col-sm-5">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="<?php echo $AdmiAdd["fields"][2]; ?>"
                                                                           name="<?php echo $AdmiAdd["fields"][2]; ?>"
                                                                           data-rules='{"required": true}'
                                                                           data-messages='{"required": "Enter Date of brith"}'
                                                                           placeholder="Date of birth" />
                                                                </div>
                                                                <label for="inputgymtype" class="col-sm-1 control-label">Admin type</label>
                                                                <div class="col-sm-5">
                                                                    <select class="form-control"
                                                                            id="<?php echo $AdmiAdd["fields"][3]; ?>"
                                                                            name="<?php echo $AdmiAdd["fields"][3]; ?>"
                                                                            data-rules='{"required": true}'
                                                                            data-messages='{"required": "Select Admin type"}'>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputregfee" class="col-sm-1 control-label">Email </label>
                                                                <div class="col-sm-5">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="<?php echo $AdmiAdd["fields"][4]; ?>"
                                                                           name="<?php echo $AdmiAdd["fields"][4]; ?>"
                                                                           data-rules='{"required": true}'
                                                                           data-messages='{"required": "Enter Email"}'
                                                                           placeholder="Email" />
                                                                </div>
                                                                <label for="inputgymtype" class="col-sm-1 control-label">Cell Number</label>
                                                                <div class="col-sm-5">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="<?php echo $AdmiAdd["fields"][5]; ?>"
                                                                           name="<?php echo $AdmiAdd["fields"][5]; ?>"
                                                                           maxlength="10"
                                                                           data-rules='{"required": true}'
                                                                           data-messages='{"required": "Enter Cell Number"}'
                                                                           placeholder="Cell Number" />
                                                                </div>
                                                            </div>
                                                            <div class="box collapsed-box">
                                                                <div class="box-header with-border">
                                                                    <h3 class="box-title"><strong>Address</strong></h3>
                                                                    <div class="box-tools pull-right">
                                                                        <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                                    </div><!-- /.box-tools -->
                                                                </div><!-- /.box-header -->
                                                                <div class="box-body" id="addbox">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="inputcountry" class="col-sm-1 control-label">Country</label>
                                                                            <div class="col-sm-5">
                                                                                <input class="form-control"
                                                                                       id="<?php echo $AdmiAdd["fields"][6]; ?>"
                                                                                       name="<?php echo $AdmiAdd["fields"][6]; ?>"
                                                                                       data-rules='{"required": true}'
                                                                                       data-messages='{"required": "Enter Country Name"}'
                                                                                       placeholder="Country" type="text">
                                                                            </div>
                                                                            <label for="inputstate" class="col-sm-1 control-label">State / Province</label>
                                                                            <div class="col-sm-5">
                                                                                <input class="form-control"
                                                                                       name="<?php echo $AdmiAdd["fields"][7]; ?>"
                                                                                       id="<?php echo $AdmiAdd["fields"][7]; ?>"
                                                                                       data-rules='{"required": true}'
                                                                                       data-messages='{"required": "Enter State Name"}'
                                                                                       type="text" placeholder="State/Province">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="inputdistrict" class="col-sm-1 control-label">District / Department</label>
                                                                            <div class="col-sm-5">
                                                                                <input class="form-control"
                                                                                       name="<?php echo $AdmiAdd["fields"][8]; ?>"
                                                                                       id="<?php echo $AdmiAdd["fields"][8]; ?>"
                                                                                       data-rules='{"required": true}'
                                                                                       data-messages='{"required": "Enter District"}'
                                                                                       placeholder="District/Department"  type="text">
                                                                            </div>
                                                                            <label for="inputcity" class="col-sm-1 control-label">City/Town</label>
                                                                            <div class="col-sm-5">
                                                                                <input class="form-control"
                                                                                       name="<?php echo $AdmiAdd["fields"][9]; ?>"
                                                                                       id="<?php echo $AdmiAdd["fields"][9]; ?>"
                                                                                       data-rules='{"required": true}'
                                                                                       data-messages='{"required": "Enter City"}'
                                                                                       type="text" placeholder="City/Town" >
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="inputStree" class="col-sm-1 control-label">Street/Locality</label>
                                                                            <div class="col-sm-5">
                                                                                <input class="form-control"
                                                                                       name="<?php echo $AdmiAdd["fields"][10]; ?>"
                                                                                       id="<?php echo $AdmiAdd["fields"][10]; ?>"
                                                                                       data-rules='{"required": true}'
                                                                                       data-messages='{"required": "Enter street"}'
                                                                                       placeholder="Street/Locality" type="text">
                                                                            </div>
                                                                            <label for="inputaddressline" class="col-sm-1 control-label">Address Line</label>
                                                                            <div class="col-sm-5">
                                                                                <input class="form-control"
                                                                                       name="<?php echo $AdmiAdd["fields"][11]; ?>"
                                                                                       id="<?php echo $AdmiAdd["fields"][11]; ?>"
                                                                                       data-rules='{"required": true}'
                                                                                       data-messages='{"required": "Enter Address Line"}'
                                                                                       placeholder="Address Line" type="text">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="inputZipcode" class="col-sm-1 control-label">Zip code</label>
                                                                            <div class="col-sm-11">
                                                                                <input class="form-control"
                                                                                       name="<?php echo $AdmiAdd["fields"][12]; ?>"
                                                                                       id="<?php echo $AdmiAdd["fields"][12]; ?>"
                                                                                       data-rules='{"required": true,"minlength": "6"}'
                                                                                       data-messages='{"required": "Enter Zipcode","minlength": "Length Should be minimum 6 numbers"}'
                                                                                       placeholder="Zip code" type="text">
                                                                            </div>
                                                                            <label for="inputwebsite" class="col-sm-1 control-label">Website</label>
                                                                            <div class="col-sm-5">
                                                                                <input class="form-control"
                                                                                       name="<?php echo $AdmiAdd["fields"][13]; ?>"
                                                                                       id="<?php echo $AdmiAdd["fields"][13]; ?>"
                                                                                       data-rules='{"required": true,"minlength": "3"}'
                                                                                       data-messages='{"required": "Enter Owner Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                                       placeholder="Website"   type="text">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- dob -->
                                                            <div class="box collapsed-box">
                                                                <div class="box-header with-border">
                                                                    <h3 class="box-title"><strong>Documents</strong></h3>
                                                                    <div class="box-tools pull-right">
                                                                        <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                                    </div><!-- /.box-tools -->
                                                                </div><!-- /.box-header -->
                                                                <div class="box-body">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="inputaddid" class="col-sm-1 control-label">Document Number</label>
                                                                            <div class="col-sm-11">
                                                                                <input class="form-control"
                                                                                       id="<?php echo $AdmiAdd["fields"][13]; ?>"
                                                                                       name="<?php echo $AdmiAdd["fields"][13]; ?>"
                                                                                       data-rules='{"required": true,"minlength": "6"}'
                                                                                       data-messages='{"required": "Enter document number","minlength": "Length Should be minimum 6 numbers"}'
                                                                                       placeholder="Document Number" type="text">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="inputdoctype" class="col-sm-1 control-label">Document type</label>
                                                                            <div class="col-sm-5">
                                                                                <select class="form-control"
                                                                                        id="<?php echo $AdmiAdd["fields"][14]; ?>"
                                                                                        name="<?php echo $AdmiAdd["fields"][14]; ?>"
                                                                                        data-rules='{"required": true}'
                                                                                        data-messages='{"required": "Select Document type"}'>
                                                                                    <option>Licence</option>
                                                                                </select>
                                                                            </div>
                                                                            <label for="inputdoccopy" class="col-sm-1 control-label">Document Upload </label>
                                                                            <div class="col-sm-5">
                                                                                <input class="form-control"
                                                                                       id="<?php echo $AdmiAdd["fields"][15]; ?>"
                                                                                       name="<?php echo $AdmiAdd["fields"][15]; ?>"
                                                                                       data-rules='{"required": true}'
                                                                                       data-messages='{"required": "Upload valid document"}'
                                                                                       type="file">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- /.box-body -->
                                                            <div class="form-group">
                                                                <div class="col-sm-offset-5 col-sm-10">
                                                                    <button type="submit"
                                                                            class="btn btn-primary"
                                                                            id="<?php echo $AdmiAdd["fields"][16]; ?>"
                                                                            name="<?php echo $AdmiAdd["fields"][16]; ?>"
                                                                            style="padding:8px 39px"
                                                                            data-rules='{}'
                                                                            data-messages='{}'>Save</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="assign">
                                <!-- The timeline -->
                                <div class="content">
                                    <section class="content">
                                        <div class="row">
                                            <div class="box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title"><strong>Assign Club / Gym to Admin </strong></h3>
                                                </div>
                                                <div class="box-body">
                                                    <form class="form-horizontal"
                                                          action=""
                                                          id="<?php echo $AdmiAssign["form"]; ?>"
                                                          name="<?php echo $AdmiAssign["form"]; ?>"
                                                          method="post">
                                                        <div class="form-group">
                                                            <label for="inputregfee" class="col-sm-1 control-label">Select Admin </label>
                                                            <div class="col-sm-5">
                                                                <select class="form-control"
                                                                        id="<?php echo $AdmiAssign["fields"][0]; ?>"
                                                                        name="<?php echo $AdmiAssign["fields"][0]; ?>"
                                                                        data-rules='{"required": true}'
                                                                        data-messages='{"required": "Select Option"}'></select>
                                                            </div>
                                                            <label for="inputregfee" class="col-sm-1 control-label">Select Gym</label>
                                                            <div class="col-sm-5">
                                                                <select class="form-control"
                                                                        id="<?php echo $AdmiAssign["fields"][1]; ?>"
                                                                        name="<?php echo $AdmiAssign["fields"][1]; ?>"
                                                                        data-rules='{"required": true}'
                                                                        data-messages='{"required": "Select Option"}'></select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-offset-5 col-sm-12">
                                                                <button type="submit"
                                                                        class="btn btn-primary"
                                                                        id="<?php echo $AdmiAssign["fields"][2]; ?>"
                                                                        name="<?php echo $AdmiAssign["fields"][2]; ?>"
                                                                        style="padding:8px 39px"
                                                                        data-rules='{}'
                                                                        data-messages='{}'>Assign</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="list">
                                <div class="content">
                                    <!-- Main content -->
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title"><strong>List Admins</strong></h3>
                                                    </div><!-- /.box-header -->
                                                    <div class="box-body table-responsive">
                                                        <table id="<?php echo $AdmiList["fields"][0]; ?>" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Owner Name</th>
                                                                    <th>Admin/Manager</th>
                                                                    <th>Gym</th>
                                                                    <th>Edit</th>
                                                                    <th>Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="<?php echo $AdmiList["fields"][0]; ?>">
                                                            </tbody>
                                                        </table>
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </section><!-- /.content -->
                                </div>
                            </div><!-- /.tab-pane -->
                        </div>
                    </div>
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </section>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var this_js_script = $("script[src$='Managers.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In Managers');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'User/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).tamboola.managers;
                var obj = new managersController();
                obj.__constructor(para);
                obj.__AddManagers();
            }
            else {
                LogMessages('I am Out Managers');
            }
        }
    });
</script>
