<?php 
$restaurantAdd = isset($this->idHolders["onlinefood"]["restaurant"]["AddRestaurant"]) ? (array) $this->idHolders["onlinefood"]["restaurant"]["AddRestaurant"] : false;
?>
<form class="form-horizontal"
      action=""
      id="<?php echo $restaurantAdd["form"]; ?>"
      name="<?php echo $restaurantAdd["form"]; ?>"
      novalidate="novalidate" 
      enctype="multipart/form-data"
      method="post">
    <div class="content">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Add gym</strong></h3>
                        </div>
                        <div class="box-body" id="userbox">
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputgymtype" class="col-sm-1 control-label">Restaurant Type</label>
                                        <div class="col-sm-5">
                                            <select class="form-control"
                                                    id="<?php echo $restaurantAdd["fields"][0]; ?>"
                                                    name="<?php echo $restaurantAdd["fields"][0]; ?>"
                                                    data-rules='{"required": true}'
                                                    data-messages='{"required": "Select Restaurant Type"}'>
                                                <option>main</option>
                                                <option>branch</option>
                                            </select>
                                        </div>
                                        <label for="inputgymName" class="col-sm-1 control-label">Restaurant Name</label>
                                        <div class="col-sm-5">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $restaurantAdd["fields"][1]; ?>"
                                                   name="<?php echo $restaurantAdd["fields"][1]; ?>"
                                                   data-rules='{"required": true,"minlength": "4"}'
                                                   data-messages='{"required": "Enter Restaurant Name","minlength": "Length Should be 4 characters"}'
                                                   placeholder="Restaurant Name"
                                                   maxlength="100"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputregfee" class="col-sm-1 control-label">Registration Fee </label>
                                        <div class="col-sm-5">
                                            <input type="number"
                                                   class="form-control"
                                                   id="<?php echo $restaurantAdd["fields"][2]; ?>"
                                                   name="<?php echo $restaurantAdd["fields"][2]; ?>"
                                                   data-rules='{"required": true,"minlength": "1"}'
                                                   data-messages='{"required": "Enter Registration Fee","minlength": "Length Should be 1 characters"}'
                                                   placeholder="Registration Fee " 
                                                   value="500"
                                                   maxlength="25"/>
                                        </div>
                                        <label for="inputsertax" class="col-sm-1 control-label">Service Tax</label>
                                        <div class="col-sm-5">
                                            <input type="number"
                                                   class="form-control"
                                                   id="<?php echo $restaurantAdd["fields"][3]; ?>"
                                                   name="<?php echo $restaurantAdd["fields"][3]; ?>"
                                                   data-rules='{"required": true,"minlength":"3"}'
                                                   data-messages='{"required": "Enter Service Tax","minlength": "Length Should be 3 characters"}'
                                                   placeholder="Service Tax" 
                                                   value="0.15"
                                                   maxlength="10"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputphone" class="col-sm-1 control-label">Telephone Number </label>
                                        <div class="col-sm-2">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?php echo $restaurantAdd["fields"][4]; ?>"
                                                   name="<?php echo $restaurantAdd["fields"][4]; ?>"
                                                   data-rules='{}'
                                                   data-messages='{}'
                                                   value="080"> 
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="number"
                                                   class="form-control"
                                                   id="<?php echo $restaurantAdd["fields"][5]; ?>"
                                                   name="<?php echo $restaurantAdd["fields"][5]; ?>"
                                                   data-rules='{}'
                                                   data-messages='{}'
                                                   placeholder="Telephone Number"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
            <div class="box collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Restaurant Logo, Header Logo</strong></h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div><!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-5">
                            <div class="panel panel-info">
                                <div class="panel-heading"><strong>Restaurant Logo</strong></div>
                                <div class="panel-body">
                                    <input type="file"
                                           name="<?php echo $restaurantAdd["logoImg"]; ?>"
                                           id="<?php echo $restaurantAdd["logoImg"]; ?>" />
                                </div>
                                <div class="panel-footer text-warning"><i class="fa fa-warning fa-2x"></i>&nbsp;We accept jpeg, png, jpg images less than 5MB</div>
                            </div>
                        </div>
                        <div class="col-lg-2">&nbsp;</div>
                        <div class="col-lg-5">
                            <div class="panel panel-info">
                                <div class="panel-heading"><strong>Receipt Header Logo</strong></div>
                                <div class="panel-body">
                                    <input type="file"
                                           name="<?php echo $restaurantAdd["headerImg"]; ?>"
                                           id="<?php echo $restaurantAdd["headerImg"]; ?>" />
                                </div>
                                <div class="panel-footer text-warning"><i class="fa fa-warning fa-2x"></i>&nbsp;We accept jpeg, png, jpg images less than 5MB</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Internal / External View of Restaurant</strong></h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div><!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div class="col-lg-12 center">
                        <div class="panel panel-info">
                            <div class="panel-heading"><strong>Restaurant</strong></div>
                            <div class="panel-body">
                                <input type="file"
                                       name="<?php echo $restaurantAdd["inView"]; ?>"
                                       id="<?php echo $restaurantAdd["inView"]; ?>" />
                            </div>
                            <div class="panel-footer text-warning"><i class="fa fa-warning fa-2x"></i>&nbsp;We accept jpeg, png, jpg images less than 5MB</div>
                        </div>
                    </div>
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
                        <button type="button" class="btn btn-box-tool" id="<?php echo $restaurantAdd["cloneplusbut"][0]; ?>" name="<?php echo $restaurantAdd["cloneplusbut"][0]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                    </div><!-- /.box-tools -->
                    <div class="box-tools pull-left col-sm-offset-0">
                        <button type="button" class="btn btn-box-tool" id="<?php echo $restaurantAdd["cloneminusbut"][0]; ?>" name="<?php echo $restaurantAdd["cloneminusbut"][0]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
                    <div class="col-sm-12" id="<?php echo $restaurantAdd["clone"][0]; ?>0">
                        <div class="form-group">
                            <label for="inputemail" class="col-sm-1 control-label">Email IDs</label>
                            <div class="col-sm-5">
                                <input type="email"
                                       class="form-control <?php echo $restaurantAdd["reqparam"][0]; ?>"
                                       id="<?php echo $restaurantAdd["reqparam"][0]; ?>"
                                       name="<?php echo $restaurantAdd["reqparam"][0]; ?>"
                                       data-rules='{"required": true,"minlength": "6"}'
                                       data-messages='{"required": "Enter Email IDs","minlength": "Length Should be 6 characters"}'
                                       placeholder="Email ID"
                                       maxlength="100"/>
                            </div>
                        </div>
                        <div class="divider">&nbsp;</div>
                    </div>
                    <div class="box-tools pull-left col-sm-offset-5">
                        <button type="button" class="btn btn-box-tool" id="<?php echo $restaurantAdd["cloneplusbut"][1]; ?>" name="<?php echo $restaurantAdd["cloneplusbut"][1]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                    </div><!-- /.box-tools -->
                    <div class="box-tools pull-left col-sm-offset-0">
                        <button type="button" class="btn btn-box-tool" id="<?php echo $restaurantAdd["cloneminusbut"][1]; ?>" name="<?php echo $restaurantAdd["cloneminusbut"][1]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
                    <div class="col-sm-12" id="<?php echo $restaurantAdd["clone"][1]; ?>">
                        <div class="form-group">
                            <label for="inputcellno" class="col-sm-1 control-label">Cell Numbers</label>
                            <div class="col-sm-2">
                                <input type="number"
                                       class="form-control <?php echo $restaurantAdd["resparam"][0]; ?>"
                                       id="<?php echo $restaurantAdd["resparam"][0]; ?>"
                                       name="<?php echo $restaurantAdd["resparam"][0]; ?>"
                                       data-rules='{"required": true,"maxlength":"2"}'
                                       data-messages='{"required": "Enter Cell Code","maxlength":"Maximum 2 numbers allowed"}'
                                       value="91"
                                       maxlength="2"/>
                            </div>
                            <div class="col-sm-3">
                                <input type="number"
                                       class="form-control <?php echo $restaurantAdd["resparam"][1]; ?>"
                                       id="<?php echo $restaurantAdd["resparam"][1]; ?>"
                                       name="<?php echo $restaurantAdd["resparam"][1]; ?>"
                                       data-rules='{"required": true,"minlength":"10"}'
                                       data-messages='{"required": "Enter Cell Numbers","minlength":"Maximum 10 numbers allowed"}'
                                       placeholder="Cell Number" 
                                       maxlength="12" />
                            </div>
                        </div>
                        <div class="divider">&nbsp;</div>
                    </div>
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
                                       id="<?php echo $restaurantAdd["fields"][6]; ?>"
                                       name="<?php echo $restaurantAdd["fields"][6]; ?>"
                                       data-rules='{"required": true,"minlength": "4"}'
                                       data-messages='{"required": "Enter Country","minlength": "Length Should be 4 characters"}'
                                       placeholder="Country" type="text" maxlength="100" />
                            </div>
                            <label for="inputstate" class="col-sm-1 control-label">State/<br />Province</label>
                            <div class="col-sm-5">
                                <input class="form-control"
                                       name="<?php echo $restaurantAdd["fields"][7]; ?>"
                                       id="<?php echo $restaurantAdd["fields"][7]; ?>"
                                       type="text"
                                       data-rules='{"required": true,"minlength": "4"}'
                                       data-messages='{"required": "Enter State/Province","minlength": "Length Should be 4 characters"}'
                                       placeholder="State/Province" maxlength="150" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputdistrict" class="col-sm-1 control-label">District/<br />Department</label>
                            <div class="col-sm-5">
                                <input class="form-control"
                                       placeholder="District/Department"
                                       name="<?php echo $restaurantAdd["fields"][8]; ?>"
                                       id="<?php echo $restaurantAdd["fields"][8]; ?>"
                                       data-rules='{"required": true,"minlength": "4"}'
                                       data-messages='{"required": "Enter District/Department","minlength": "Length Should be 4 characters"}'
                                       type="text" maxlength="100" />
                            </div>
                            <label for="inputcity" class="col-sm-1 control-label">City/<br />Town</label>
                            <div class="col-sm-5">
                                <input class="form-control"
                                       placeholder="City/Town"
                                       name="<?php echo $restaurantAdd["fields"][9]; ?>"
                                       id="<?php echo $restaurantAdd["fields"][9]; ?>"
                                       data-rules='{"required": true,"minlength": "4"}'
                                       data-messages='{"required": "Enter City/Town","minlength": "Length Should be 4 characters"}'
                                       type="text" maxlength="100" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputstreet" class="col-sm-1 control-label">Street/<br />Locality</label>
                            <div class="col-sm-5">
                                <input class="form-control"
                                       placeholder="Street/Locality"
                                       name="<?php echo $restaurantAdd["fields"][10]; ?>"
                                       id="<?php echo $restaurantAdd["fields"][10]; ?>"
                                       data-rules='{}'
                                       data-messages='{}'
                                       type="text" maxlength="100" />
                            </div>
                            <label for="inputAddress" class="col-sm-1 control-label">Address Line</label>
                            <div class="col-sm-5">
                                <input class="form-control"
                                       placeholder="Address Line"
                                       type="text"
                                       name="<?php echo $restaurantAdd["fields"][11]; ?>"
                                       id="<?php echo $restaurantAdd["fields"][11]; ?>"
                                       data-rules='{}'
                                       data-messages='{}' maxlength="200" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputzipcode" class="col-sm-1 control-label">Zip code</label>
                            <div class="col-sm-5">
                                <input class="form-control"
                                       placeholder="Zipcode"
                                       name="<?php echo $restaurantAdd["fields"][12]; ?>"
                                       id="<?php echo $restaurantAdd["fields"][12]; ?>"
                                       data-rules='{}'
                                       data-messages='{}'
                                       type="text" >
                            </div>
                            <label for="inputwebsite" class="col-sm-1 control-label">Website</label>
                            <div class="col-sm-5">
                                <input class="form-control"
                                       type="url"
                                       placeholder="Personal Website"
                                       name="<?php echo $restaurantAdd["fields"][13]; ?>"
                                       id="<?php echo $restaurantAdd["fields"][13]; ?>"
                                       data-rules='{}'
                                       data-messages='{}'
                                       />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputgoogle" class="col-sm-1 control-label">Google Map URL</label>
                            <div class="col-sm-11">
                                <input class="form-control"
                                       data-rules='{}'
                                       data-messages='{}'
                                       placeholder="Google Map URL"
                                       name="<?php echo $restaurantAdd["fields"][14]; ?>"
                                       id="<?php echo $restaurantAdd["fields"][14]; ?>"
                                       type="url" /> 
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div>
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-10">
                    <button type="submit"
                            class="btn btn-primary"
                            id="<?php echo $restaurantAdd["fields"][15]; ?>"
                            name="<?php echo $restaurantAdd["fields"][15]; ?>"
                            data-rules='{}'
                            data-messages='{}'>Add Restaurant</button>
                </div>
            </div>
        </section>
    </div>
</form>
