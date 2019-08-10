<!-- Main content -->
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
                            <h3 class="box-title"><strong>Add Package</strong></h3>
                        </div>
                        <div class="box-body" id="userbox">
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputgymtype" class="col-sm-1 control-label">Package Type</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $AddPackages["fields"][0]; ?>"
                                                    name="<?php echo $AddPackages["fields"][0]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Status"}'>
                                            </select>
                                        </div>
                                        <label for="inputphone" class="col-sm-1 control-label">Facility</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $AddPackages["fields"][1]; ?>"
                                                    name="<?php echo $AddPackages["fields"][1]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Status"}'>
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
                                                   name="<?php echo $AddPackages["fields"][3]; ?>"
                                                   data-rules='{"required": true}'
                                                   data-messages='{"required": "Enter Offer Name"}'
                                                   placeholder="Individual" />
                                        </div>
                                        <label for="inputgymtype" class="col-sm-1 control-label">Minimum Members</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $AddPackages["fields"][3]; ?>"
                                                    name="<?php echo $AddPackages["fields"][3]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Duration"}'>
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
                                                   placeholder="Number Of Session" />
                                        </div>
                                        <label for="inputgymName" class="col-sm-1 control-label">Price</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $AddPackages["fields"][5]; ?>"
                                                   name="<?php echo $AddPackages["fields"][5]; ?>"
                                                   data-rules='{"required": true}'
                                                   data-messages='{"required": "Enter The Price"}'
                                                   placeholder="Amount" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputgymName" class="col-sm-2 control-label">Description</label>
                                        <div class="col-sm-5">
                                            <textarea class="form-control"
                                                   id="<?php echo $AddPackages["fields"][7]; ?>"
                                                   name="<?php echo $AddPackages["fields"][7]; ?>"
                                                   data-rules='{}'
                                                   data-messages='{}'
                                                   placeholder="Description" ></textarea>
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
                        id="<?php echo $AddPackages["fields"][6]; ?>"
                        name="<?php echo $AddPackages["fields"][6]; ?>"
                        data-rules='{}'
                        data-messages='{}'
                        class="btn btn-primary">Save Details</button>
            </div>
        </div>
    </form>
</div>
