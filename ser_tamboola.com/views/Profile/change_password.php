<?php
$Prof = isset($this->idHolders["tamboola"]["profile"]["ChangePassword"]) ? (array) $this->idHolders["tamboola"]["profile"]["ChangePassword"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#addutype" data-toggle="tab">Profile</a></li>
    </ul>
    <div class="tab-content-wrapper">
        <div class="tab-pane active" id="addutype">
            <!-- /.nav-tabs-custom -->
            <div class="box">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $Prof["form"]; ?>"
                      name="<?php echo $Prof["form"]; ?>"
                      method="post">
                    <section class="content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="oldpassword" class="col-sm-1 control-label">Old Password</label>
                                                <div class="col-sm-11">
                                                    <input type="password"
                                                           class="form-control"
                                                           id="<?php echo $Prof["fields"][0]; ?>"
                                                           name="<?php echo $Prof["fields"][0]; ?>"
                                                           data-rules='{"required": true,"minlength": "6"}'
                                                           data-messages='{"required": "Enter Old Password","minlength": "Length Should be minimum 6 Characters"}'
                                                           placeholder="Old Password" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="newpassword" class="col-sm-1 control-label">New Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password"
                                                           class="form-control"
                                                           id="<?php echo $Prof["fields"][1]; ?>"
                                                           name="<?php echo $Prof["fields"][1]; ?>"
                                                           data-rules='{"required": true,"minlength": "6"}'
                                                           data-messages='{"required": "Enter New Password","minlength": "Length Should be minimum 6 Characters"}'
                                                           placeholder="New Password" />
                                                </div>
                                                <label for="confirmpassword" class="col-sm-1 control-label">Confirm Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password"
                                                           class="form-control"
                                                           id="<?php echo $Prof["fields"][2]; ?>"
                                                           name="<?php echo $Prof["fields"][2]; ?>"
                                                           data-rules='{"required": true,"minlength": "6","equalTo": "#<?php echo $Prof["fields"][1]; ?>"}'
                                                           data-messages='{"required": "confirm password","minlength": "Length Should be minimum 6 Characters","equalTo":"Enter same password"}'
                                                           placeholder="Confirm Password" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputemail" class="col-sm-1 control-label">Email IDs</label>
                                                <div class="col-sm-5">
                                                    <input type="email"
                                                           class="form-control"
                                                           id="<?php echo $Prof["fields"][4]; ?>"
                                                           name="<?php echo $Prof["fields"][4]; ?>"
                                                           data-rules='{"required": true,"minlength": "6"}'
                                                           data-messages='{"required": "Enter Email IDs","minlength": "Length Should be 6 characters"}'
                                                           placeholder="Email ID"
                                                           maxlength="100"/>
                                                </div>
                                                <label for="inputemail" class="col-sm-1 control-label">Cell Number</label>
                                                <div class="col-sm-5">
                                                    <input type="number"
                                                           class="form-control"
                                                           id="<?php echo $Prof["fields"][5]; ?>"
                                                           name="<?php echo $Prof["fields"][5]; ?>"
                                                           data-rules='{"required": true,"minlength":"10"}'
                                                           data-messages='{"required": "Enter Cell Numbers","minlength":"Maximum 10 numbers allowed"}'
                                                           placeholder="Cell Number"
                                                           maxlength="12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-lg-12 center">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><strong>Profile Picture</strong></div>
                                                    <div class="panel-body">
                                                        <input type="file"
                                                               name="<?php echo $Prof["inView"]; ?>"
                                                               id="<?php echo $Prof["inView"]; ?>" />
                                                    </div>
                                                    <div class="panel-footer text-warning"><i class="fa fa-warning fa-2x"></i>&nbsp;We accept jpeg, png, jpg images less than 5MB</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-sm-offset-5 col-sm-10">
                                                    <button type="submit"
                                                            class="btn btn-danger"
                                                            id="<?php echo $Prof["fields"][6]; ?>"
                                                            name="<?php echo $Prof["fields"][6]; ?>"
                                                            data-rules='{}'
                                                            data-messages='{}'>Change Password</button>
                                                </div>
                                            </div>
                                        </div>
                                        </section>
                                        </form>
                                    </div>
                                    <!-- /. box -->
                                </div>
                            </div><!-- /.nav-tabs-custom -->
                        </div>