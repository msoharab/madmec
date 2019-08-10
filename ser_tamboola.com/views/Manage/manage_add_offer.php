<!-- Main content -->
<div class="content">
    <form class="form-horizontal"
          action=""
          id="<?php echo $AddOffers["form"]; ?>"
          name="<?php echo $AddOffers["form"]; ?>"
          method="post">
        <div class="content">
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title with-border"><strong>Add Offer</strong></h3>
                            </div>
                            <div class="box-body" id="userbox">
                                <div class="col-sm-12">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputphone" class="col-sm-1 control-label">Name Of The Offer</label>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                       class="form-control"
                                                       id="<?php echo $AddOffers["fields"][0]; ?>"
                                                       name="<?php echo $AddOffers["fields"][0]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Offer Name"}'
                                                       placeholder="Individual" />
                                            </div>
                                            <label for="inputgymtype" class="col-sm-1 control-label">Duration</label>
                                            <div class="col-sm-5">
                                                <select class="form-control"
                                                        id="<?php echo $AddOffers["fields"][1]; ?>"
                                                        name="<?php echo $AddOffers["fields"][1]; ?>"
                                                        data-rules='{"required": true}'
                                                        data-messages='{"required": "Select Duration"}'>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputgymtype" class="col-sm-1 control-label">Minimum Member</label>
                                            <div class="col-sm-5">
                                                <select class="form-control"
                                                        id="<?php echo $AddOffers["fields"][2]; ?>"
                                                        name="<?php echo $AddOffers["fields"][2]; ?>"
                                                        data-rules='{"required": true}'
                                                        data-messages='{"required": "Select Value"}'>
                                                </select>
                                            </div>
                                            <label for="inputgymtype" class="col-sm-1 control-label">Facility Type</label>
                                            <div class="col-sm-5">
                                                <select class="form-control"
                                                        id="<?php echo $AddOffers["fields"][3]; ?>"
                                                        name="<?php echo $AddOffers["fields"][3]; ?>"
                                                        data-rules='{"required": true}'
                                                        data-messages='{"required": "Select Facility Name"}'>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Price / Description Of The Offer</strong></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" id="addbox">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputgymName" class="col-sm-2 control-label">Price Of The Offer</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                           class="form-control"
                                           id="<?php echo $AddOffers["fields"][4]; ?>"
                                           name="<?php echo $AddOffers["fields"][4]; ?>"
                                           data-rules='{"required": true}'
                                           data-messages='{"required": "Enter Price"}'
                                           required="required"
                                           maxlength="10"
                                           placeholder="2500">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputsertax" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control"
                                              id="<?php echo $AddOffers["fields"][5]; ?>"
                                              name="<?php echo $AddOffers["fields"][5]; ?>"
                                              data-rules='{"required": true}'
                                              data-messages='{"required": "Enter Description"}'
                                              rows="5"
                                              placeholder="Description">Steam<br />Shower<br />Change room<br />Locker<br /></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-11">
                        <button type="submit"
                                class="btn btn-primary"
                                id="<?php echo $AddOffers["fields"][6]; ?>"
                                name="<?php echo $AddOffers["fields"][6]; ?>"
                                data-rules='{}'
                                data-messages='{}'>Save Details</button>
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>
