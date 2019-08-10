<?php
$addClient = isset($this->idHolders["tamboola"]["clients"]["AddClient"]) ? (array) $this->idHolders["tamboola"]["clients"]["AddClient"] : false;
$listClient = isset($this->idHolders["tamboola"]["clients"]["ListClient"]) ? (array) $this->idHolders["tamboola"]["clients"]["ListClient"] : false;
$AssignClient = isset($this->idHolders["tamboola"]["clients"]["AssignClient"]) ? (array) $this->idHolders["tamboola"]["clients"]["AssignClient"] : false;
$listOwnReq = isset($this->idHolders["tamboola"]["clients"]["Request"]) ? (array) $this->idHolders["tamboola"]["clients"]["Request"] : false;
?>
<div class="content-wrapper">
    <div class="content">
        <section class="content-header">
            <h1>
                Clients
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="active">Clients</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#add" data-toggle="tab">Add Clients</a></li>
                            <li><a href="#list" data-toggle="tab">List Clients</a></li>
                            <li><a href="#assign" data-toggle="tab">Assign User</a></li>
                            <li><a href="#subs" data-toggle="tab">Owner Request</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="add">
                                <!-- Post -->
                                <form class="form-horizontal"
                                      action=""
                                      id="<?php echo $addClient["form"]; ?>"
                                      name="<?php echo $addClient["form"]; ?>"
                                      method="post">
                                    <div class="content">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title with-border"><strong>Add Clients</strong></h3>
                                                        </div>
                                                        <input type="hidden" name="action1" value="clientAdd" />
                                                        <input type="hidden" name="autoloader" value="true" />
                                                        <input type="hidden" name="type" value="master" />
                                                        <div class="box-body" id="userbox">
                                                            <div class="col-xs-12">
                                                                <div class="form-group">
                                                                    <label for="inputbusiness" class="col-sm-1 control-label">Business Name</label>
                                                                    <div class="col-sm-5">
                                                                        <input class="form-control"
                                                                               id="<?php echo $addClient["fields"][0]; ?>"
                                                                               name="<?php echo $addClient["fields"][0]; ?>"
                                                                               data-rules='{"required": true,"minlength": "3"}'
                                                                               data-messages='{"required": "Enter Business Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                               placeholder="Business Name" type="text">
                                                                    </div>
                                                                    <label for="inputbusinessdate" class="col-sm-1 control-label">Owners Name</label>
                                                                    <div class="col-sm-5">
                                                                        <input class="form-control"
                                                                               id="<?php echo $addClient["fields"][1]; ?>"
                                                                               name="<?php echo $addClient["fields"][1]; ?>"
                                                                               data-rules='{"required": true}'
                                                                               data-messages='{"required": "Enter Owners Name"}'
                                                                               placeholder="Owners Name" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputowner" class="col-sm-1 control-label">User Name</label>
                                                                <div class="col-sm-11">
                                                                    <input class="form-control"
                                                                           id="<?php echo $addClient["fields"][2]; ?>"
                                                                           name="<?php echo $addClient["fields"][2]; ?>"
                                                                           data-rules='{"required": true,"minlength": "3"}'
                                                                           data-messages='{"required": "Enter User Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                           placeholder="UserName" type="text" >
                                                                </div>
                                                            </div>
                                                            <div class="box collapsed-box">
                                                                <div class="box-header with-border">
                                                                    <h3 class="box-title"><strong>Email IDs,Cell Numbers</strong></h3>
                                                                    <div class="box-tools pull-right">
                                                                        <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                                    </div><!-- /.box-tools -->
                                                                </div>
                                                                <div class="box-body" id="addbox">
                                                                    <div class="box-tools pull-left col-sm-offset-4">
                                                                        <button type="button" class="btn btn-box-tool"
                                                                                id="<?php echo $addClient["cloneplusbut"][0]; ?>"
                                                                                name="<?php echo $addClient["cloneplusbut"][0]; ?>"
                                                                                data-widget="add"><i class="fa fa-plus"></i></button>
                                                                    </div><!-- /.box-tools -->
                                                                    <div class="box-tools pull-left col-sm-offset-0">
                                                                        <button type="button" class="btn btn-box-tool"
                                                                                id="<?php echo $addClient["cloneminusbut"][0]; ?>"
                                                                                name="<?php echo $addClient["cloneminusbut"][0]; ?>"
                                                                                data-widget="minus"><i class="fa fa-minus"></i></button>
                                                                    </div><!-- /.box-tools -->
                                                                    <div class="col-sm-12" id="<?php echo $addClient["clone"][0]; ?>0">
                                                                        <div class="form-group">
                                                                            <label for="inputemail" class="col-sm-1 control-label">Email IDs</label>
                                                                            <div class="col-sm-3">
                                                                                <input type="text"
                                                                                       class="form-control <?php echo $addClient["reqparam"][0]; ?>"
                                                                                       id="<?php echo $addClient["fields"][4]; ?>"
                                                                                       name="<?php echo $addClient["fields"][4]; ?>"
                                                                                       placeholder="Email ID">
                                                                            </div>
                                                                        </div>
                                                                        <div class="divider">&nbsp;</div>
                                                                    </div>
                                                                    <div class="box-tools pull-left col-sm-offset-5">
                                                                        <button type="button" class="btn btn-box-tool"
                                                                                id="<?php echo $addClient["cloneplusbut"][0]; ?>"
                                                                                name="<?php echo $addClient["cloneplusbut"][0]; ?>"
                                                                                data-widget="add"><i class="fa fa-plus"></i></button>
                                                                    </div><!-- /.box-tools -->
                                                                    <div class="box-tools pull-left col-sm-offset-0">
                                                                        <button type="button" class="btn btn-box-tool"
                                                                                id="<?php echo $addClient["cloneminusbut"][0]; ?>"
                                                                                name="<?php echo $addClient["cloneminusbut"][0]; ?>"
                                                                                data-widget="minus"><i class="fa fa-minus"></i></button>
                                                                    </div><!-- /.box-tools -->
                                                                    <div class="col-sm-12" id="<?php echo $addClient["clone"][0]; ?>"
                                                                         <div class="form-group">
                                                                            <label for="inputcellno" class="col-sm-1 control-label">Cell Numbers</label>
                                                                            <div class="col-sm-1">
                                                                                <input type="text"
                                                                                       class="form-control <?php echo $addClient["reqparam"][0]; ?>"
                                                                                       id="<?php echo $addClient["fields"][5]; ?>"
                                                                                       name="<?php echo $addClient["fields"][5]; ?>"
                                                                                       placeholder="+91">
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <input type="text"
                                                                                       class="form-control <?php echo $addClient["reqparam"][0]; ?>"
                                                                                       id="<?php echo $addClient["fields"][6]; ?>"
                                                                                       name="<?php echo $addClient["fields"][6]; ?>"
                                                                                       maxlength="10"
                                                                                       placeholder="Cell Number">
                                                                            </div>
                                                                        </div>
                                                                        <div class="divider">&nbsp;</div>
                                                                    </div>
                                                                </div>
                                                                <!-- Address -->
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
                                                                                           id="<?php echo $addClient["fields"][7]; ?>"
                                                                                           name="<?php echo $addClient["fields"][7]; ?>"
                                                                                           required="" maxlength="100"
                                                                                           placeholder="Country" type="text">
                                                                                </div>
                                                                                <label for="inputstate" class="col-sm-1 control-label">State/Province</label>
                                                                                <div class="col-sm-5">
                                                                                    <input class="form-control"
                                                                                           name="<?php echo $addClient["fields"][8]; ?>"
                                                                                           id="<?php echo $addClient["fields"][8]; ?>"
                                                                                           required="required" maxlength="150"
                                                                                           type="text" placeholder="State/Province">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="inputdistrict" class="col-sm-1 control-label">District/Department</label>
                                                                                <div class="col-sm-5">
                                                                                    <input class="form-control"
                                                                                           name="<?php echo $addClient["fields"][9]; ?>"
                                                                                           id="<?php echo $addClient["fields"][9]; ?>"
                                                                                           required="required" maxlength="100"
                                                                                           data-rules='{"required": true,"minlength": "3"}'
                                                                                           data-messages='{"required": "Enter Owner Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                                           placeholder="District/Department"  type="text">
                                                                                </div>
                                                                                <label for="inputcity" class="col-sm-1 control-label">City/Town</label>
                                                                                <div class="col-sm-5">
                                                                                    <input class="form-control"
                                                                                           name="<?php echo $addClient["fields"][10]; ?>"
                                                                                           id="<?php echo $addClient["fields"][10]; ?>"
                                                                                           data-rules='{"required": true}'
                                                                                           data-messages='{"required": "Enter Owner Name"}'
                                                                                           type="text" placeholder="City/Town" >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="inputstreet" class="col-sm-1 control-label">Street/Locality</label>
                                                                                <div class="col-sm-5">
                                                                                    <input class="form-control"
                                                                                           name="<?php echo $addClient["fields"][11]; ?>"
                                                                                           id="<?php echo $addClient["fields"][11]; ?>"
                                                                                           data-rules='{"required": true}'
                                                                                           data-messages='{"required": "Enter Street/Locality"}'
                                                                                           placeholder="Street/Locality" type="text" >
                                                                                </div>
                                                                                <label for="inputaddressline" class="col-sm-1 control-label">Address Line</label>
                                                                                <div class="col-sm-5">
                                                                                    <input class="form-control"
                                                                                           name="<?php echo $addClient["fields"][12]; ?>"
                                                                                           id="<?php echo $addClient["fields"][12]; ?>"
                                                                                           data-rules='{"required": true,"maxlength": "250"}'
                                                                                           data-messages='{"required": "Address Line","maxlength": "Length Should be minimum 250 characters"}'
                                                                                           placeholder="Personal Website" type="text" value="http://">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="inputzipcode" class="col-sm-1 control-label">Zip code</label>
                                                                                <div class="col-sm-5">
                                                                                    <input class="form-control"
                                                                                           name="<?php echo $addClient["fields"][13]; ?>"
                                                                                           id="<?php echo $addClient["fields"][13]; ?>"
                                                                                           data-rules='{"required": true,"minlength": "6"}'
                                                                                           data-messages='{"required": "Enter Owner Name","minlength": "Length Should be minimum 6 numbers"}'
                                                                                           placeholder="Zipcode" type="text">
                                                                                </div>
                                                                                <label for="inputwebsite" class="col-sm-1 control-label">Website</label>
                                                                                <div class="col-sm-5">
                                                                                    <input class="form-control"
                                                                                           name="<?php echo $addClient["fields"][14]; ?>"
                                                                                           id="<?php echo $addClient["fields"][14]; ?>"
                                                                                           data-rules='{"required": true,"minlength": "3"}'
                                                                                           data-messages='{"required": "Enter Owner Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                                           placeholder="Personal Website"  type="text" value="http://">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="inputgoogle" class="col-sm-1 control-label">Google Map URL</label>
                                                                                <div class="col-sm-11">
                                                                                    <input class="form-control"
                                                                                           data-rules='{"required": true}'
                                                                                           data-messages='{"required": "Enter Owner Name"}'
                                                                                           placeholder="Google Map URL "
                                                                                           value="http://"
                                                                                           name="<?php echo $addClient["fields"][15]; ?>"
                                                                                           type="text" id="<?php echo $addClient["fields"][15]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
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
                                                                                <label for="inputdocumentnumber" class="col-sm-1 control-label">Document Number</label>
                                                                                <div class="col-sm-11">
                                                                                    <input class="form-control"
                                                                                           id="<?php echo $addClient["fields"][16]; ?>"
                                                                                           name="<?php echo $addClient["fields"][16]; ?>"
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
                                                                                            id="<?php echo $AdmiAdd["fields"][3]; ?>"
                                                                                            name="<?php echo $AdmiAdd["fields"][3]; ?>"
                                                                                            data-rules='{"required": true}'
                                                                                            data-messages='{"required": "Select Document type"}'>
                                                                                        <option value="selectVal" selected>Select Document</option>
                                                                                        <option value="Today">Passport</option>
                                                                                        <option value="2">Gas Connection Bill</option>
                                                                                        <option value="4">Ration card</option>
                                                                                        <option value="7">Electricity bill</option>
                                                                                        <option value="30">Voter ID card</option>
                                                                                        <option value="30">National Identification Number</option>
                                                                                    </select>
                                                                                </div>
                                                                                <label for="inputdoccopy" class="col-sm-1 control-label">Document Upload </label>
                                                                                <div class="col-sm-5">
                                                                                    <input class="form-control"
                                                                                           id="<?php echo $addClient["fields"][18]; ?>"
                                                                                           name="<?php echo $addClient["fields"][18]; ?>"
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
                                                                                id="<?php echo $addClient["fields"][19]; ?>"
                                                                                name="<?php echo $addClient["fields"][19]; ?>"
                                                                                data-rules='{}'
                                                                                data-messages='{}'><strong>Submit Details</strong></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- /.box -->
                                                    </div><!-- /.col -->
                                                </div>
                                        </section>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="assign">
                                <!-- The timeline -->
                                <form class="form-horizontal"
                                      action=""
                                      id="<?php echo $AssignClient["form"]; ?>"
                                      name="<?php echo $AssignClient["form"]; ?>"
                                      method="post">
                                    <div class="content">
                                        <!-- Main content -->
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title with-border"><strong>Assign User</strong></h3>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputName" class="col-sm-3 control-label">Owner</label>
                                                            <div class="col-sm-5">
                                                                <select class="form-control"
                                                                        id="<?php echo $AssignClient["fields"][0]; ?>"
                                                                        name="<?php echo $AssignClient["fields"][0]; ?>"
                                                                        data-rules='{"required": true}'
                                                                        data-messages='{"required": "Select User Type"}'>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputowner" class="col-sm-3 control-label">User Name</label>
                                                            <div class="col-sm-5">
                                                                <input class="form-control"
                                                                       id="<?php echo $AssignClient["fields"][1]; ?>"
                                                                       name="<?php echo $AssignClient["fields"][1]; ?>"
                                                                       data-rules='{"required": true,"minlength": "3"}'
                                                                       data-messages='{"required": "Enter Owner Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                       placeholder="User Name" type="text" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputName" class="col-sm-3 control-label">Gym</label>
                                                            <div class="col-sm-5">
                                                                <select class="form-control"
                                                                        id="<?php echo $AssignClient["fields"][2]; ?>"
                                                                        name="<?php echo $AssignClient["fields"][2]; ?>"
                                                                        data-rules='{"required": true}'
                                                                        data-messages='{"required": "Select Gateway"}'>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-offset-4 col-sm-10">
                                                                <button type="submit"
                                                                        id="<?php echo $AssignClient["fields"][3]; ?>"
                                                                        name="<?php echo $AssignClient["fields"][3]; ?>"
                                                                        data-rules='{}'
                                                                        data-messages='{}'
                                                                        class="btn btn-primary">Activate</button>
                                                                <button type="submit"
                                                                        id="<?php echo $AssignClient["fields"][4]; ?>"
                                                                        name="<?php echo $AssignClient["fields"][4]; ?>"
                                                                        data-rules='{}'
                                                                        data-messages='{}'
                                                                        class="btn btn-danger">Deactivate</button>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.box -->
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->
                                        </section><!-- /.content -->
                                    </div>
                                </form>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="subs">
                                <!-- The timeline -->
                                <div class="content">
                                    <!-- Content Header (Page header) -->
                                    <!-- Main content -->
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title with-border"><strong>Owner Request</strong></h3>
                                                    </div>
                                                    <div class="box-body table-responsive">
                                                        <table id="<?php echo $listOwnReq["fields"][0]; ?>" class="table table-bordered
                                                               table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Owner</th>
                                                                    <th>Gym name</th>
                                                                    <th>Address</th>
                                                                    <th>Accept</th>
                                                                    <th>Reject</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="<?php echo $listOwnReq["fields"][1]; ?>">
                                                            </tbody>
                                                        </table>
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </section><!-- /.content -->
                                </div>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="list">
                                <div class="content">
                                    <!-- Content Header (Page header) -->
                                    <!-- Main content -->
                                    <section class="content">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title with-border"><strong>List Clients</strong></h3>
                                                    </div><!-- /.box-header -->
                                                    <div class="box-body table-responsive">
                                                        <table id="<?php echo $listClient["fields"][0]; ?>" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Owner</th>
                                                                    <th>Gym</th>
                                                                    <th>Address</th>
                                                                    <th>Edit</th>
                                                                    <th>Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="<?php echo $listClient["fields"][1]; ?>">
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
                </div>
            </div><!-- /.tab-content -->
    </div><!-- /.nav-tabs-custom -->
</section>
</div>
</div>
